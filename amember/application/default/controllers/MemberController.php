<?php

/*
 *   Members page. Used to renew subscription.
 *
 *
 *     Author: Alex Scott
 *      Email: alex@cgi-central.net
 *        Web: http://www.cgi-central.net
 *    Details: Member display page
 *    FileName $RCSfile$
 *    Release: 4.4.2 ($Revision$)
 *
 * Please direct bug reports,suggestions or feedback to the cgi-central forums.
 * http://www.cgi-central.net/forum/
 *
 * aMember PRO is a commercial software. Any distribution is strictly prohibited.
 *
 */

class MemberController extends Am_Controller
{
    /** @var User */
    protected $user;
    /** @var int */
    protected $user_id;

    function preDispatch()
    {
        $this->getDi()->auth->requireLogin(ROOT_URL . '/member');
        $this->user = $this->getDi()->user;
        $this->view->assign('user', $this->user);
        $this->user_id = $this->user->pk();
    }

    static function getCancelLink(Payment $payment)
    {
        $paysys = $this->getDi()->paysystemList->get($payment->paysys_id);
        if ($paysys && $paysys->isRecurring()
            && ($pay_plugin = &instantiate_plugin('payment', $v['paysys_id']))
            && method_exists($pay_plugin, 'get_cancel_link')
            && $product = $payment->getProduct(false) && $product->isRecurring())
            return $pay_plugin->get_cancel_link($v['payment_id']);
    }

    function paymentHistoryAction()
    {
        $psList = $this->getDi()->paysystemList;
        $this->view->activeInvoices = $this->getDi()->invoiceTable->selectObjects("SELECT * FROM ?_invoice i
            LEFT JOIN ?_access a ON a.invoice_id=i.invoice_id
            WHERE a.begin_date<=? AND a.expire_date>=? AND i.status IN (?a) AND i.user_id=?
            GROUP BY i.invoice_id ORDER BY tm_started DESC", 
                $this->getDi()->sqlDate, $this->getDi()->sqlDate,
                array(Invoice::RECURRING_ACTIVE, Invoice::PAID, Invoice::RECURRING_CANCELLED), $this->user_id);
        
        foreach ($this->view->activeInvoices as $invoice)
        {
            $invoice->_paysysName = $psList->getTitle($invoice->paysys_id);
            // if there is only 1 item, offer upgrade path
            $invoice->_upgrades = array();
            if (in_array($invoice->getStatus(), array(Invoice::PAID, Invoice::RECURRING_ACTIVE)))
            {
                foreach ($invoice->getItems() as $item)
                {
                    $item->_upgrades = $this->getDi()->productUpgradeTable->findUpgrades($invoice, $item);
                }
            }
            if ($invoice->getStatus() == Invoice::RECURRING_ACTIVE)
            {
                $invoice->_cancelUrl = null;
                try { 
                    $ps = $this->getDi()->plugins_payment->loadGet($invoice->paysys_id, false);
                    if ($ps)
                        $invoice->_cancelUrl = $ps->getUserCancelUrl($invoice);
                } catch (Exception $e){}
            }
        }
        
        $this->view->payments = $this->getDi()->invoicePaymentTable->findByUserId($this->user_id, null, null, 'dattm DESC');
        foreach ($this->view->payments as $payment)
        {
            $payment->_paysysName = $psList->getTitle($payment->paysys_id);
        }
        
        $this->view->display('member/payment-history.phtml');
    }

    function setError($error)
    {
        $this->view->assign('error', $error);
        return false;
    }

    function addRenewAction()
    {
        $this->_redirect('signup');
    }

    function indexAction()
    {

        $this->view->assign('member_products', $this->getDi()->user->getActiveProducts());
        $this->view->assign('member_future_products', $this->getDi()->user->getFutureProducts());

        $member_links = array (
            ROOT_URL . '/logout' => ___('Logout'),
            ROOT_URL . '/profile' => ___('Change Password/Edit Profile')
        );
        $event = new Am_Event(Am_Event::GET_MEMBER_LINKS, array('user' => $this->user));
        $event->setReturn($member_links);
        $this->view->assign('member_links', 
            $this->getDi()->hook->call($event)
                ->getReturn());

        $left_member_links = $this->getDi()->hook
                ->call(Am_Event::GET_LEFT_MEMBER_LINKS, array('user' => $this->user))
                ->getReturn();
        $this->view->assign('left_member_links', $left_member_links);

        $resources = $this->getDi()->resourceAccessTable
            ->getAllowedResources($this->getDi()->user, ResourceAccess::USER_VISIBLE_TYPES);
        $this->view->assign('resources', $resources);

        foreach ($resources as $k => $r) {
            if (!$r->renderLink()) unset($resources[$k]);
        }

        if (!$resources && !$left_member_links)
            $this->getDi()->blocks->remove('member-main-resources');

        $this->view->assign('products_expire', $this->getDi()->user->getActiveProductsExpiration());
        $this->view->assign('products_begin', $this->getDi()->user->getFutureProductsBeginning());
        
        $this->view->display('member/main.phtml');
    }

    function getInvoiceAction()
    {
        $id = $this->getDi()->app->reveal($this->getParam('id'));
        if (!$id)
            throw new Am_Exception_InputError("Wrong invoice# passed");
        $payment = $this->getDi()->invoicePaymentTable->load($id);
        if (!$payment)
            throw new Am_Exception(___("Invoice not found"));
        if ($payment->user_id != $this->user->user_id)
            throw new Am_Exception_Security("Foreign invoice requested : [$id] for {$this->user->user_id}");

        $pdfInvoice = new Am_Pdf_Invoice($payment);
        $pdfInvoice->setDi($this->getDi());

        $this->_helper->sendFile->sendData($pdfInvoice->render(), 'application/pdf', $pdfInvoice->getFileName());
    }
    
    function upgradeAction()
    {
        // load invoice to work with
        $id = $this->getFiltered('invoice_id');
        if (!$id)
            throw new Am_Exception_InputError("Wrong invoice# passed");
        $invoice = $this->getDi()->invoiceTable->findFirstByPublicId($id);
        /* @var $invoice Invoice */
        if (!$invoice)
            throw new Am_Exception_InputError(___("Invoice not found"));
        if ($invoice->user_id != $this->user->user_id)
            throw new Am_Exception_Security("Foreign invoice requested : [$id] for {$this->user->user_id}");
        // right now we only can handle first item
        $item = null;
        foreach ($invoice->getItems() as $it)
            if ($it->pk() == $this->getDi()->app->reveal($this->getParam ('invoice_item_id')))
                $item = $it;
        //
        $upgrade = $this->getDi()->productUpgradeTable->load($this->_request->getInt('upgrade'));
        if (!$invoice->canUpgrade($item, $upgrade))
            throw new Am_Exception_Security("Cannot process upgrade");
        // 
        $newInvoice = $invoice->doUpgrade($item, $upgrade);
        if (($newInvoice->getStatus() == Invoice::PENDING) && !$newInvoice->data()->get('upgrade-pending'))
        {
            if ($err = $newInvoice->validate())
                throw new Am_Exception_InputError($err[0]);
            $newInvoice->save();
            $payProcess = new Am_Paysystem_PayProcessMediator($this, $newInvoice);
            try {
                $result = $payProcess->process();
            } catch (Am_Exception_Redirect $e) {
                throw $e;
            }
            if ($result->isFailure())
                throw new Am_Exception_InputError(current($result->getErrorMessages()));
        }
        if ($newInvoice->isCompleted())
        {
            $this->_redirect('member/payment-history?_msg=' . ___('Product upgrade finished succesfully') . '.');
        } else {
            $this->_redirect('member/payment-history?_msg=' . ___('Processing your product upgrade') . '...');
        }
    }
}