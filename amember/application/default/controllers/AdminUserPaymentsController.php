<?php

class Am_Grid_Filter_Payments extends Am_Grid_Filter_Abstract
{
    public function isFiltered()
    {
        foreach ((array)$this->vars['filter'] as $v)
            if ($v) return true;
    }

    public function setDateField($dateField)
    {
        $this->dateField = $dateField;
    }

    protected function applyFilter()
    {
        class_exists('Am_Form', true);
        $filter = (array)$this->vars['filter'];
        $q = $this->grid->getDataSource();

        $dateField = $this->vars['filter']['datf'];
        if (!array_key_exists($dateField, $this->getDateFieldOptions()))
            throw new Am_Exception_InternalError (sprintf('Unknown date field [%s] submitted in %s::%s',
                $dateField, __CLASS__, __METHOD__));
        /* @var $q Am_Query */
        if ($filter['dat1'])
            $q->addWhere("t.$dateField >= ?", Am_Form_Element_Date::createFromFormat(null, $filter['dat1'])->format('Y-m-d 00:00:00'));
        if ($filter['dat2'])
            $q->addWhere("t.$dateField <= ?", Am_Form_Element_Date::createFromFormat(null, $filter['dat2'])->format('Y-m-d 23:59:59'));
        if (@$filter['text']) {
            switch (@$filter['type'])
            {
                case 'invoice':
                    $q->addWhere('(t.invoice_id=? OR t.invoice_public_id=?)', $filter['text'], $filter['text']);
                    break;
                case 'receipt':
                    $q->addWhere('receipt_id LIKE ?', '%'.$filter['text'].'%');
                    break;
                case 'coupon':
                    $q->leftJoin('?_invoice', 'i', 't.invoice_id=i.invoice_id');
                    $q->addWhere('i.coupon_code=?', $filter['text']);
                    break;
            }
        }
        if (@$filter['product_id']){
            $q->leftJoin('?_invoice_item', 'ii', 't.invoice_id=ii.invoice_id')
                ->addWhere('ii.item_type=?', 'product')
                ->addWhere('ii.item_id=?', $filter['product_id']);
        }
    }

    public function renderInputs()
    {
        $prefix = $this->grid->getId();

        $filter = (array)$this->vars['filter'];
        $filter['datf'] = Am_Controller::escape(@$filter['datf']);
        $filter['dat1'] = Am_Controller::escape(@$filter['dat1']);
        $filter['dat2'] = Am_Controller::escape(@$filter['dat2']);
        $filter['text'] = Am_Controller::escape(@$filter['text']);

        $pOptions = array('' => '-' . ___('Filter by Product') . '-');
        $pOptions = $pOptions +
            Am_Di::getInstance()->productTable->getOptions();
        $pOptions = Am_Controller::renderOptions(
            $pOptions,
            @$filter['product_id']
        );

        $options = Am_Controller::renderOptions(array(
            '' => '***',
            'invoice' => ___('Invoice'),
            'receipt' => ___('Payment Receipt'),
            'coupon' => ___('Coupon Code')
            ), @$filter['type']);

        $dOptions = $this->getDateFieldOptions();
        if (count($dOptions) === 1) {
            $dSelect = sprintf('%s: <input type="hidden" name="%s_filter[datf]" value="%s" />',
                current($dOptions), $prefix, key($dOptions));
        } else {
            $dSelect = sprintf('<select name="%s_filter[datf]">%s</select>', $prefix,
                Am_Controller::renderOptions($dOptions, @$filter['datf']));
        }

        $start = ___('Start Date');
        $end   = ___('End Date');

        return <<<CUT
<select name="{$prefix}_filter[product_id]" style="width:150px">
$pOptions
</select>
$dSelect
<input type="text" placeholder="$start" name="{$prefix}_filter[dat1]" class='datepicker' style="width:80px" value="{$filter['dat1']}" />
<input type="text" placeholder="$end" name="{$prefix}_filter[dat2]" class='datepicker' style="width:80px" value="{$filter['dat2']}" />
<br />
<input type="text" name="{$prefix}_filter[text]" value="{$filter['text']}" style="width:300px" />
<select name="{$prefix}_filter[type]">
$options
</select>
CUT;
    }

    public function getDateFieldOptions()
    {
        return array('dattm' => ___('Payment Date'));
    }

    public function renderStatic()
    {
        return <<<CUT
<script type="text/javascript">
$(function(){
    $(document).ajaxComplete(function(){
        $('input.datepicker').datepicker({
                defaultDate: window.uiDefaultDate,
                dateFormat:window.uiDateFormat,
                changeMonth: true,
                changeYear: true
        }).datepicker("refresh");
    });
});
</script>
CUT;
    }
}

class AdminUserPaymentsController extends Am_Controller
{
    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission('grid_invoice', 'browse');
    }

    function preDispatch()
    {
        $this->user_id = intval($this->_request->user_id);
        if (!in_array($this->_request->getActionName(), array('log', 'invoice')))
        {
            if ($this->user_id <= 0)
                throw new Am_Exception_InputError("user_id is empty in " . get_class($this));
        }
        $this->setActiveMenu('users-browse');
        return parent::preDispatch();
    }

    public function createAdapter() {
        $adapter =  $this->_createAdapter();

        $query = $adapter->getQuery();
        $query->addWhere('t.user_id=?d', $this->user_id);

        return $adapter;
    }

    public function invoiceDetailsAction()
    {
        $this->getDi()->plugins_payment->loadEnabled();
        $this->view->invoice = $this->getDi()->invoiceTable->load($this->getInt('id'));
        $this->view->display('admin/_user_invoices-details.phtml');
    }

    public function paymentAction()
    {

        $totalFields = array();

        $query = new Am_Query($this->getDi()->invoicePaymentTable);
        $query->leftJoin('?_user', 'm', 'm.user_id=t.user_id')
            ->addField("(SELECT GROUP_CONCAT(item_title SEPARATOR ', ') FROM ?_invoice_item WHERE invoice_id=t.invoice_id)", 'items')
            ->addField('m.login', 'login')
            ->addField('m.email', 'email')
            ->addField('m.street', 'street')
            ->addField('m.city', 'city')
            ->addField('m.state', 'state')
            ->addField('m.country', 'country')
            ->addField('m.phone', 'phone')
            ->addField('m.zip', 'zip')
            ->addField("concat(m.name_f,' ',m.name_l)", 'name')
            ->addField('t.invoice_public_id', 'public_id')
            ->addWhere('t.user_id=?', $this->user_id);
        $query->setOrder("invoice_payment_id", "desc");

        $grid = new Am_Grid_Editable('_payment', ___('Payments'), $query, $this->_request, $this->view);
        $grid->actionsClear();
        $grid->addField(new Am_Grid_Field_Date('dattm', ___('Date/Time')));

        $grid->addField('invoice_id', ___('Invoice'))
            ->setGetFunction(array($this, '_getInvoiceNum'))
            ->addDecorator(
                new Am_Grid_Field_Decorator_Link(
                    'admin-user-payments/index/user_id/{user_id}#invoice-{invoice_id}', '_top'));
        $grid->addField('receipt_id', ___('Receipt'));
        $grid->addField('paysys_id', ___('Payment System'));
        array_push($totalFields, $grid->addField('amount', ___('Amount'))->setGetFunction(array($this, '_getAmount')));
        if ($this->getDi()->plugins_tax->getEnabled()) {
            array_push($totalFields, $grid->addField('tax', ___('Tax'))->setGetFunction(array($this, '_getTax')));
        }
        $grid->addField(new Am_Grid_Field_Date('refund_dattm', ___('Refunded')))->setFormatDatetime();
        $grid->addField('items', ___('Items'));
        $grid->setFilter(new Am_Grid_Filter_Payments);

        $action = new Am_Grid_Action_Export();
        $action->addField(new Am_Grid_Field('dattm', ___('Date Time')))
                ->addField(new Am_Grid_Field('receipt_id', ___('Receipt')))
                ->addField(new Am_Grid_Field('paysys_id', ___('Payment System')))
                ->addField(new Am_Grid_Field('amount', ___('Amount')))
                ->addField(new Am_Grid_Field('tax', ___('Tax')))
                ->addField(new Am_Grid_Field_Date('refund_dattm', ___('Refunded')))
                ->addField(new Am_Grid_Field('login', ___('Username')))
                ->addField(new Am_Grid_Field('name', ___('Name')))
                ->addField(new Am_Grid_Field('email', ___('Email')))
                ->addField(new Am_Grid_Field('street', ___('Street')))
                ->addField(new Am_Grid_Field('city', ___('City')))
                ->addField(new Am_Grid_Field('state', ___('State')))
                ->addField(new Am_Grid_Field('country', ___('Country')))
                ->addField(new Am_Grid_Field('phone', ___('Phone')))
                ->addField(new Am_Grid_Field('zip', ___('Zip Code')))
                ->addField(new Am_Grid_Field('items', ___('Items')))
                ->addField(new Am_Grid_Field('invoice_id', ___('Invoice')))
                ->addField(new Am_Grid_Field('public_id', ___('Invoice (Public Id)')))
            ;
        $grid->actionAdd($action);
        $action = $grid->actionAdd(new Am_Grid_Action_Total());
        foreach ($totalFields as $f)
            $action->addField($f, 'ROUND(%s / base_currency_multi, 2)');
        $grid->runWithLayout('admin/user-layout.phtml');
    }

    function _getInvoiceNum(Am_Record $invoice)
    {
        return $invoice->invoice_id . '/' . $invoice->public_id;
    }

    function _getAmount(Am_Record $p)
    {
        return Am_Currency::render($p->amount, $p->currency);
    }

    function _getTax(InvoicePayment $p)
    {
        return Am_Currency::render($p->tax, $p->currency);
    }

    public function resendPaymentLinkAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_invoice', 'edit');

        $invoice = $this->getDi()->invoiceTable->load($this->getParam('invoice_id'));

        $form = new Am_Form_Admin('add-invoice');

        $tm_due = $form->addDate('tm_due')->setLabel(___('Due Date'));
        $tm_due->setValue($invoice->due_date < sqlDate('now') ? sqlDate('+7 days') : $invoice->due_date);

        $message = $form->addTextarea('message', array('class' => 'el-wide'))->setLabel(array(___('Message'), ___('will be included to email to user')));

        $form->addElement('email_link', 'invoice_pay_link')
            ->setLabel(___('Email Template with Payment Link'));

        $form->setDataSources(array($this->getRequest()));

        if ($form->isSubmitted() && $form->validate()) {
            $vars = $form->getValue();

            $invoice->due_date = $vars['tm_due'];
            $invoice->save();

            $et = Am_Mail_Template::load('invoice_pay_link', $invoice->getUser()->lang ? $invoice->getUser()->lang : null);
            $et->setUser($invoice->getUser());
            $et->setUrl(ROOT_SURL . sprintf('/pay/%s', $invoice->getSecureId('payment-link')));
            $et->setMessage($vars['message']);
            $et->setInvoice($invoice);
            $et->setInvoice_text($invoice->render());
            $et->send($invoice->getUser());
            Am_Controller::ajaxResponse(array(
                'ok'=>true,
                'msg'=>___('Invoice link has been sent to user again'),
                'invoice_id' => $invoice->pk(),
                'due_date_html' => amDate($invoice->due_date)));
        } else {
            echo $form;
        }
    }

    public function addInvoiceAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_invoice', 'insert');

        $form = new Am_Form_Admin('add-invoice');

        $tm_added = $form->addDate('tm_added')->setLabel(___('Date'));
        $tm_added->setValue($this->getDi()->sqlDate);
        $tm_added->addRule('required');

        $comment = $form->addText('comment', array('class' => 'el-wide'))->setLabel(___("Comment\nfor your reference"));

        $form->addElement(new Am_Form_Element_ProductsWithQty('product_id'))->setLabel(___('Products'))
            ->loadOptions($this->getDi()->billingPlanTable->selectAllSorted())
            ->addRule('required');
        $form->addSelect('paysys_id')->setLabel(___('Payment System'))
            ->setId('add-invoice-paysys_id')
            ->loadOptions(array(''=>'') + $this->getDi()->paysystemList->getOptions());

        $couponEdit = $form->addText('coupon')->setLabel(___('Coupon'));

        $action = $form->addAdvRadio('_action')
            ->setLabel(___('Action'))
            ->setId('add-invoice-action')
            ->loadOptions(array(
                'pending' => ___('Just Add Pending Invoice'),
                'pending-payment' => ___('Add Invoice and Payment/Access Manually'),
                'pending-send' => ___('Add Pending Invoice and Send Link to Pay It to Customer')
            ))->setValue('pending');

        $receipt = $form->addText('receipt')->setLabel(___('Receipt#'))
                ->setId('add-invoice-receipt');

        $tm_due = $form->addDate('tm_due')->setLabel(___('Due Date'));
        $tm_due->setValue(sqlDate('+7 days'));
        $tm_due->setId('add-invoice-due');

        $message = $form->addTextarea('message', array('class' => 'el-wide'))->setLabel(___("Message\nwill be included to email to user"));
        $message->setId('add-invoice-message');

        $form->addElement('email_link', 'invoice_pay_link')
            ->setLabel(___('Email Template with Payment Link'));

        $form->addScript()->setScript('
            $("[name=_action]").change(function(){
                var val = $("[name=_action]:checked").val();
                $("#add-invoice-receipt").closest("div.row").toggle(val == "pending-payment")
                $("#add-invoice-due").closest("div.row").toggle(val == "pending-send")
                $("#add-invoice-message").closest("div.row").toggle(val == "pending-send")
                $("[name=invoice_pay_link]").closest("div.row").toggle(val == "pending-send")
            }).change();

        ');
        $form->addSaveButton();
        $form->setDataSources(array($this->getRequest()));

        do {
            if ($form->isSubmitted() && $form->validate()) {
                $vars = $form->getValue();
                $invoice = $this->getDi()->invoiceRecord;
                $invoice->setUser($this->getDi()->userTable->load($this->user_id));
                $invoice->tm_added = sqlTime($vars['tm_added']);
                if ($vars['coupon']) {
                    $invoice->setCouponCode($vars['coupon']);
                    $error = $invoice->validateCoupon();
                    if ($error)
                    {
                        $couponEdit->setError($error);
                        break;
                    }
                }
                foreach ($vars['product_id'] as $plan_id => $qty) {
                    $p = $this->getDi()->billingPlanTable->load($plan_id);
                    $pr = $p->getProduct();
                    try {
                        $invoice->add($pr, $qty);
                    } catch (Am_Exception_InputError $e) {
                        $form->setError($e->getMessage());
                        break 2;
                    }
                }

                $invoice->comment = $vars['comment'];
                $invoice->calculate();

                switch ($vars['_action']) {
                    case 'pending' :
                        if (!$this->_addPendingInvoice($invoice, $form, $vars)) break 2;
                        break;
                    case 'pending-payment' :
                        if (!$this->_addPendingInvoiceAndPayment($invoice, $form, $vars)) break 2;
                        break;
                    case 'pending-send' :
                        if (!$this->_addPendingInvoiceAndSend($invoice, $form, $vars)) break 2;
                        break;
                    default:
                        throw new Am_Exception_InternalError(sprintf('Unknown action [%s] as %s::%s',
                            $vars['_action'], __CLASS__, __METHOD__));
                }
                $this->getDi()->adminLogTable->log("Add Invoice (#{$invoice->invoice_id}/{$invoice->public_id}, Billing Terms: " . new Am_TermsText($invoice) . ")", 'invoice', $invoice->invoice_id);

                if ($vars['is_add_payment']) {
                    if($invoice->first_total<=0){
                        $invoice->addAccessPeriod(new Am_Paysystem_Transaction_Free($this->getDi()->plugins_payment->get($vars['paysys_id'])));
                    }else{
                        $transaction = new Am_Paysystem_Transaction_Manual($this->getDi()->plugins_payment->get($vars['paysys_id']));
                        $transaction->setAmount($invoice->first_total)
                            ->setReceiptId($vars['receipt'])
                            ->setTime(new DateTime($vars['tm_added']));
                        $invoice->addPayment($transaction);
                    }
                }
                return $this->redirectLocation(REL_ROOT_URL . '/admin-user-payments/index/user_id/' . $this->user_id);
            } // if
        } while (false);

        $this->view->content = '<h1>' . ___('Add Invoice') . ' (<a href="' . REL_ROOT_URL . '/admin-user-payments/index/user_id/' . $this->user_id . '">' . ___('return') . '</a>)</h1>' . (string)$form;
        $this->view->display('admin/user-layout.phtml');

    }

    protected function _addPendingInvoice(Invoice $invoice, Am_Form $form, $vars)
    {
        if (!$vars['paysys_id']) {
            $form->getElementById('add-invoice-paysys_id')->setError(___('This field is required for choosen action'));
            return false;
        }

        try {
            $invoice->setPaysystem($vars['paysys_id']);
        } catch (Am_Exception_InputError $e) {
            $form->setError($e->getMessage());
            return false;
        }
        $errors = $invoice->validate();
        if ($errors) {
            $form->setError(current($errors));
            return false;
        }
        $invoice->data()->set('added-by-admin', $this->getDi()->authAdmin->getUserId());
        $invoice->save();
        return true;
    }

    protected function _addPendingInvoiceAndPayment(Invoice $invoice, Am_Form $form, $vars)
    {
        if (!$vars['paysys_id'])
            $form->getElementById('add-invoice-paysys_id')->setError(___('This field is required for choosen action'));
        if (!$vars['receipt'])
            $form->getElementById('add-invoice-receipt')->setError(___('This field is required for choosen action'));
        if (!$vars['paysys_id'] || !$vars['receipt'])
            return false;

        try {
            $invoice->setPaysystem($vars['paysys_id']);
        } catch (Am_Exception_InputError $e) {
            $form->setError($e->getMessage());
            return false;
        }
        $errors = $invoice->validate();
        if ($errors) {
            $form->setError(current($errors));
            return false;
        }
        $invoice->data()->set('added-by-admin', $this->getDi()->authAdmin->getUserId());
        $invoice->save();

        if($invoice->first_total<=0){
            $invoice->addAccessPeriod(new Am_Paysystem_Transaction_Free($this->getDi()->plugins_payment->get($vars['paysys_id'])));
        } else {
            $transaction = new Am_Paysystem_Transaction_Manual($this->getDi()->plugins_payment->get($vars['paysys_id']));
            $transaction->setAmount($invoice->first_total)
                ->setReceiptId($vars['receipt'])
                ->setTime(new DateTime($vars['tm_added']));
            $invoice->addPayment($transaction);
        }
        return true;
    }

    protected function _addPendingInvoiceAndSend(Invoice $invoice, Am_Form $form, $vars)
    {
        if ($vars['paysys_id']) {
            try {
                $invoice->setPaysystem($vars['paysys_id']);
            } catch (Am_Exception_InputError $e) {
                $form->setError($e->getMessage());
                return false;
            }
        }
        $errors = $invoice->validate();
        if ($errors) {
            $form->setError(current($errors));
            return false;
        }
        $invoice->data()->set('added-by-admin', $this->getDi()->authAdmin->getUserId());
        $invoice->due_date = $vars['tm_due'];
        $invoice->save();

        $et = Am_Mail_Template::load('invoice_pay_link', $invoice->getUser()->lang ? $invoice->getUser()->lang : null);
        $et->setUser($invoice->getUser());
        $et->setUrl(ROOT_SURL . sprintf('/pay/%s', $invoice->getSecureId('payment-link')));
        $et->setMessage($vars['message']);
        $et->setInvoice($invoice);
        $et->setInvoice_text($invoice->render());
        $et->send($invoice->getUser());

        return true;
    }

    public function calculateAccessDatesAction()
    {
        $invoice = $this->getDi()->invoiceRecord;
        $invoice->setUser($this->getDi()->userTable->load($this->user_id));

        $product = $this->getDi()->productTable->load($this->getRequest()->getParam('product_id'));
        $invoice->add($product);

        $begin_date = $product->calculateStartDate($this->getDi()->sqlDate, $invoice);

        $p = new Am_Period($product->getBillingPlan()->first_period);
        $expire_date = $p->addTo($begin_date);

        $this->ajaxResponse(array(
            'begin_date' => $begin_date,
            'expire_date' => $expire_date
        ));

    }

    public function getAddForm($set_date = true)
    {
        $form = new Am_Form_Admin;
        $form->setAction($url = $this->getUrl(null, 'addpayment', null, 'user_id',$this->user_id));
        $form->addText("receipt_id", array('tabindex' => 2))
             ->setLabel(___("Receipt#"))
             ->addRule('required');
        $amt = $form->addSelect("amount", array('tabindex' => 3), array('intrinsic_validation' => false))
             ->setLabel(___("Amount"));
        $amt->addRule('required', ___('This field is required'));
        if ($this->_request->getInt('invoice_id'))
        {
            $invoice = $this->getDi()->invoiceTable->load($this->_request->getInt('invoice_id'));
            if ((doubleval($invoice->first_total) === 0.0) || $invoice->getPaymentsCount())
                $amt->addOption($invoice->second_total, $invoice->second_total);
            else
                $amt->addOption($invoice->first_total, $invoice->first_total);
        }
        $form->addSelect("paysys_id", array('tabindex' => 1))
             ->setLabel(___("Payment System"))
             ->loadOptions($this->getDi()->paysystemList->getOptions());
        $date = $form->addDate("dattm", array('tabindex' => 4))
             ->setLabel(___("Date Of Transaction"));
        $date->addRule('required', ___('This field is required'));
        if($set_date) $date->setValue(sqlDate('now'));

        $form->addHidden("invoice_id");
        $form->addSaveButton();
        return $form;
    }

    function getAccessRecords()
    {
        return $this->getDi()->accessTable->selectObjects("SELECT a.*, p.title as product_title
            FROM ?_access a LEFT JOIN ?_product p USING (product_id)
            WHERE a.user_id = ?d
            ORDER BY begin_date, expire_date, product_title
            ", $this->user_id);
    }

    public function createAccessForm()
    {
        static $form;
        if (!$form)
        {
            $form = new Am_Form_Admin;
            $form->setAction($url = $this->getUrl(null, 'addaccess', null, 'user_id', $this->user_id));
            $sel = $form->addSelect('product_id', array('class' => 'el-wide am-combobox'));
            $options = $this->getDi()->productTable->getOptions();
            $sel->addOption(___('Please select an item...'), '');
            foreach ($options as $k => $v)
                $sel->addOption($v, $k);
            $sel->addRule('required', ___('This field is required'));
            $form->addText('comment', array('class' => 'el-wide', 'placeholder' => ___('Comment for Your Reference')));
            $form->addDate('begin_date')->addRule('required', ___('This field is required'));
            $form->addDate('expire_date')->addRule('required', ___('This field is required'));
            $form->addAdvCheckbox('does_not_send_autoresponder');
            $form->addSaveButton(___('Add Access Manually'));
        }
        return $form;
    }

    public function indexAction()
    {
        $this->getDi()->plugins_payment->loadEnabled();
        $this->view->invoices = $this->getDi()->invoiceTable->findByUserId($this->user_id, null, null, 'tm_added DESC');

        foreach ($this->view->invoices as $invoice)
        {
            $invoice->_cancelUrl = null;
            if ($invoice->getStatus() == Invoice::RECURRING_ACTIVE && $this->getDi()->plugins_payment->isEnabled($invoice->paysys_id)) {
                $plugin = $this->getDi()->plugins_payment->get($invoice->paysys_id);
                if ($url = $plugin->getAdminCancelUrl($invoice)) {
                    $invoice->_cancelUrl = $url;
                }
            }

        }

        $this->view->user_id = $this->user_id;
        $this->view->addForm = $this->getAddForm();
        $this->view->accessRecords = $this->getAccessRecords();
        $this->view->accessForm = $this->createAccessForm()->toObject();
        $this->view->display('admin/user-invoices.phtml');
    }

    public function changeAccessDateAction(){
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_payment', 'edit');

        $this->_response->setHeader("Content-Type", "application/json", true);

        try
        {
            if(!($access_id = $this->_request->getInt('access_id')))
                throw new Am_Exception_InputError('No access_id submitted');


            switch($this->_request->getFiltered('field')){
                case 'begin_date' :
                    $field = 'begin_date';
                    break;
                case 'expire_date' :
                    $field = 'expire_date';
                    break;
                default:
                    throw new Am_Exception_InputError('Invalid field type. You can change begin or expire date fields only');
            }

            if(!($value = $this->_request->get('access_date')))
                throw new Am_Exception_InputError('No new value submitted');

            $value = new DateTime($value);
            $access = $this->getDi()->accessTable->load($access_id);

            $old_value = $access->get($field);
            if($old_value != $value)
            {
                $access->updateQuick($field, $value->format('Y-m-d'));

                if(!$access->data()->get('ORIGINAL_'.strtoupper($field)))
                    $access->data()->set('ORIGINAL_'.strtoupper($field), $old_value)->update();
                // Update cache and execute hooks
                $access->getUser()->checkSubscriptions(true);
                $this->getDi()->adminLogTable->log(
                    'Access date changed ('.$field.') old value='.$old_value.' new_value='.$access->get($field).' user_id='.$access->user_id,
                    'access',
                    $access->access_id
                    );
            }
            echo $this->getJson(array('success'=>true, 'reload'=>true));
        }catch(Exception $e){
            echo $this->getJson(array('success'=>false, 'error'=>$e->getMessage()));
        }

    }

    public function refundAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_payment', 'edit');

        $this->invoice_payment_id = $this->getInt('invoice_payment_id');
        if (!$this->invoice_payment_id)
            throw new Am_Exception_InputError("Not payment# submitted");
        $p = $this->getDi()->invoicePaymentTable->load($this->invoice_payment_id);
        /* @var $p InvoicePayment */
        if (!$p)
            throw new Am_Exception_InputError("No payment found");
        if ($this->user_id != $p->user_id)
            throw new Am_Exception_InputError("Payment belongs to another customer");
        if ($p->isRefunded())
            throw new Am_Exception_InputError("Payment is already refunded");
        $amount = sprintf('%.2f', $this->_request->get('amount'));
        if ($p->amount < $amount)
            throw new Am_Exception_InputError("Refund amount cannot exceed payment amount");
        if ($this->_request->getInt('manual'))
        {
            switch ($type = $this->_request->getFiltered('type'))
            {
                case 'refund':
                case 'chargeback':
                    $pl = $this->getDi()->plugins_payment->loadEnabled()->get($p->paysys_id);
                    if (!$pl)
                        throw new Am_Exception_InputError("Could not load payment plugin [$pl]");
                    $invoice = $p->getInvoice();
                    $transaction = new Am_Paysystem_Transaction_Manual($pl);
                    $transaction->setAmount($amount);
                    $transaction->setReceiptId($p->receipt_id . '-manual-'.$type);
                    $transaction->setTime($this->getDi()->dateTime);
                    if ($type == 'refund')
                        $invoice->addRefund($transaction, $p->receipt_id);
                    else
                        $invoice->addChargeback($transaction, $p->receipt_id);
                    break;
                case 'correction':
                    $this->getDi()->accessTable->deleteBy(array('invoice_payment_id' => $this->invoice_payment_id));
                    $invoice = $p->getInvoice();
                    $p->delete();
                    $invoice->updateStatus();
                    break;
                default:
                    throw new Am_Exception_InputError("Incorrect refund [type] passed:" . $type );
            }
            $res = array(
                'success' => true,
                'text'    => ___("Payment has been successfully refunded"),
            );
        } else { // automatic
            /// ok, now we have validated $p here
            $pl = $this->getDi()->plugins_payment->loadEnabled()->get($p->paysys_id);
            if (!$pl)
                throw new Am_Exception_InputError("Could not load payment plugin [$pl]");
            /* @var $pl Am_Paysystem_Abstract */
            $result = new Am_Paysystem_Result;
            $pl->processRefund($p, $result, $amount);

            if ($result->isSuccess())
            {
                $p->getInvoice()->addRefund($result->getTransaction(), $p->receipt_id, $amount);

                $res = array(
                    'success' => true,
                    'text'    => ___("Payment has been successfully refunded"),
                );
            } elseif ($result->isAction()) {
                $action = $result->getAction();
                if ($action instanceof Am_Paysystem_Action_Redirect)
                {
                    $res = array(
                        'success' => 'redirect',
                        'url'     => $result->getUrl(),
                    );
                } else {// todo handle other actions if necessary
                    throw new Am_Exception_NotImplemented("Could not handle refund action " . get_class($action));
                }
            } elseif ($result->isFailure()) {
                $res = array(
                    'success' => false,
                    'text' => join(";", $result->getErrorMessages()),
                );
            }
        }
        $this->_response->setHeader("Content-Type", "application/json", true);
        echo $this->getJson($res);
    }

    function addaccessAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_payment', 'insert');

        $form = $this->createAccessForm();
        if ($form->validate())
        {
            $access = $this->getDi()->accessRecord;
            $val = $form->getValue();
            $access->setForInsert($val);
            unset($access->save);
            $access->user_id = $this->user_id;
            $access->insert();
            $this->getDi()->adminLogTable->log("Add Access (user #{$access->user_id}, product #{$access->product_id}, {$access->begin_date} - {$access->expire_date})", 'access', $access->access_id);
            if (!$val['does_not_send_autoresponder']) {
                $user = $this->getDi()->userTable->load($this->user_id);
                $this->getDi()->emailTemplateTable->sendZeroAutoresponders($user, $access);
            }
            $form->setDataSources(array(new Am_Request(array())));
            $form->getElementById('begin_date-0')->setValue('');
            $form->getElementById('expire_date-0')->setValue('');
        } else {

        }
        return $this->indexAction();
    }

    function delaccessAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_payment', 'delete');

        $access = $this->getDi()->accessTable->load($this->getInt('id'));
        if ($access->user_id != $this->user_id)
            throw new Am_Exception_InternalError("Wrong access record to delete - member# does not match");
        $logaccess = $access;
        $access->delete();
        $this->getDi()->adminLogTable->log("Delete Access (user #{$logaccess->user_id}, product #{$logaccess->product_id}, {$logaccess->begin_date} - {$logaccess->expire_date})", 'access', $logaccess->access_id);
        return $this->indexAction();
    }

    function addpaymentAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_payment', 'insert');

        $invoice = $this->getDi()->invoiceTable->load($this->_request->getInt('invoice_id'));
        if (!$invoice || $invoice->user_id != $this->user_id)
            throw new Am_Exception_InputError('Invoice not found');

        $form = $this->getAddForm(false);
        if (!$form->validate())
        {
            echo $form;
            return;
        }

        $vars = $form->getValue();
        $transaction = new Am_Paysystem_Transaction_Manual($this->getDi()->plugins_payment->get($vars['paysys_id']));
        $transaction->setAmount($vars['amount'])->setReceiptId($vars['receipt_id'])->setTime(new DateTime($vars['dattm']));
        if(floatval($vars['amount']) == 0)
            $invoice->addAccessPeriod($transaction);
        else
            $invoice->addPayment($transaction);


        $form->setDataSources(array(new Am_Request(array())));
        $form->addHidden('saved-ok');
        echo $form;
    }

    function stopRecurringAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_invoice', 'edit');
        // todo: rewrote stopRecurring
        $invoiceId = $this->_request->getInt('invoice_id');
        if (!$invoiceId)
            throw new Am_Exception_InputError('No invoice# provided');

        $invoice = $this->getDi()->invoiceTable->load($invoiceId);
        $plugin = $this->getDi()->plugins_payment->loadGet($invoice->paysys_id, true);

        $result = new Am_Paysystem_Result();
        $result->setSuccess();
        try {
            $plugin->cancelAction($invoice, 'cancel-admin', $result);
        } catch (Exception $e) {
            Am_Controller::ajaxResponse(array('ok' => false, 'msg' => $e->getMessage()));
            return;
        }

        if ($result->isSuccess())
        {
            $invoice->setCancelled(true);
            $this->getDi()->adminLogTable->log("Invoice Cancelled", 'invoice', $invoice->pk());
            Am_Controller::ajaxResponse(array('ok' => true));
        } elseif ($result->isAction()) {
            $action = $result->getAction();
            if ($action instanceof Am_Paysystem_Action_Redirect)
                Am_Controller::ajaxResponse(array('ok'=> false, 'redirect' => $action->getUrl()));
            else
                $action->process(); // this .. simply will not work hopefully we never get to this point
        } else {
            Am_Controller::ajaxResponse(array('ok' => false, 'msg' => $result->getLastError()));
        }
    }

    function startRecurringAction()
    {
        if(!defined('AM_ALLOW_RESTART_CANCELLED'))
        {
            Am_Controller::ajaxResponse(array('ok' => false, 'msg' => ___('Restart is not allowed')));
            return;
        }
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_invoice', 'edit');
        $invoiceId = $this->_request->getInt('invoice_id');
        if (!$invoiceId)
            throw new Am_Exception_InputError('No invoice# provided');
        $invoice = $this->getDi()->invoiceTable->load($invoiceId);
        $invoice->setCancelled(false);
        $this->getDi()->adminLogTable->log('Invoice Restarted', 'invoice', $invoice->pk());
        Am_Controller::ajaxResponse(array('ok' => true));
    }

    function changeRebillDateAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_invoice', 'edit');
        $invoice_id = $this->_request->getInt('invoice_id');
        $form = new Am_Form_Admin;
        $form->addDate('rebill_date');
        $vals = $form->getValue();
        $rebill_date  = $vals['rebill_date'];
        try{
            if(!$invoice_id) throw new Am_Exception_InputError('No invoice provided');
            $invoice = $this->getDi()->invoiceTable->load($invoice_id);

            // Invoice must be recurring active and rebills should be controlled by paylsystem,
            // otherwise this doesn't make any sence

            if(($invoice->status != Invoice::RECURRING_ACTIVE) ||
                ($invoice->getPaysystem()->getRecurringType() != Am_Paysystem_Abstract::REPORTS_CRONREBILL)
                ) throw new Am_Exception_InputError('Unable to change rebill_date for this invoice!');

            $rebill_date = new DateTime($rebill_date);
            $old_rebill_date = $invoice->rebill_date;

            $invoice->updateQuick('rebill_date',  $rebill_date->format('Y-m-d'));
            $invoice->data()->set('first_rebill_failure', null)->update();

            $this->getDi()->invoiceLogTable->log($invoice_id, null,
               ___('Rebill Date changed from %s to %s', $old_rebill_date, $invoice->rebill_date));

            Am_Controller::ajaxResponse(array('ok'=>true, 'msg'=>___('Rebill date has been changed!')));

        }catch(Exception $e){
            Am_Controller::ajaxResponse(array('ok'=>false, 'msg'=>$e->getMessage()));

        }
    }

    function logAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission(Am_Auth_Admin::PERM_LOGS);
        $invoice = $this->getDi()->invoiceTable->load($this->_request->getInt('invoice_id'));
        $this->getResponse()->setHeader('Content-type', 'text/xml');
        echo $invoice->exportXmlLog();
    }

    function approveAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_invoice', 'edit');
        $invoiceId = $this->_request->getInt('invoice_id');
        if (!$invoiceId)
            throw new Am_Exception_InputError('No invoice# provided');
        $invoice = $this->getDi()->invoiceTable->load($invoiceId);
        if (!$invoice)
            throw new Am_Exception_InputError("No invoice found [$invoiceId]");
        $invoice->approve();
        $this->_redirect('admin-user-payments/index/user_id/'.$invoice->user_id.'#invoice-'.$invoiceId);
    }

    function invoiceAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_invoice', 'browse');
        $payment = $this->getDi()->invoicePaymentTable->load($this->_request->getInt('payment_id'));

        $pdfInvoice = new Am_Pdf_Invoice($payment);
        $pdfInvoice->setDi($this->getDi());

        $this->_helper->sendFile->sendData($pdfInvoice->render(), 'application/pdf', $pdfInvoice->getFileName());
    }

    function replaceProductAction()
    {
        $this->getDi()->authAdmin->getUser()->checkPermission('grid_payment',  'edit');

        $item = $this->getDi()->invoiceItemTable->load($this->_request->getInt('id'));
        $pr = $this->getDi()->productTable->load($item->item_id);

        $form = new Am_Form_Admin('replace-product-form');
        $form->setDataSources(array($this->_request));
        $form->method = 'post';
        $form->addHidden('id');
        $form->addHidden('user_id');
        $form->addStatic()
            ->setLabel(___('Replace Product'))
            ->setContent("#{$pr->product_id} [$pr->title]");
        $sel = $form->addSelect('product_id')->setLabel(___('To Product'));
        $options = array('' => '-- ' . ___('Please select') . ' --');
        foreach ($this->getDi()->billingPlanTable->getProductPlanOptions() as $k => $v)
            if (strpos($k, $pr->pk().'-')!==0)
                $options[$k] = $v;
        $sel->loadOptions($options);
        $sel->addRule('required');
        $form->addSubmit('_save', array('value' => ___('Save')));
        if ($form->isSubmitted() && $form->validate())
        {
            try {
                list($p,$b) = explode("-", $sel->getValue(), 2);
                $item->replaceProduct(intval($p), intval($b));
                $this->getDi()->adminLogTable->log("Inside invoice: product #{$item->item_id} replaced to product #$p (plan #$b)", 'invoice', $item->invoice_id);
                return $this->ajaxResponse(array('ok'=>true));
            } catch (Am_Exception $e) {
                $sel->setError($e->getMessage());
            }
        }
        echo $form;
    }
}