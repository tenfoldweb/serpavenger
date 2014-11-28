<?php

class Am_Grid_Action_RunPayout extends Am_Grid_Action_Abstract
{

    protected $type = self::NORECORD;

    function run()
    {
        $form = new Am_Form_Admin('form-grid-payout');
        $form->setAttribute('name', 'payout');

        $date = $form->addDate('payout_date')
                ->setLabel(___('Payout Date'))
                ->setValue(sqlDate($this->getDi()->dateTime));

        foreach ($this->grid->getVariablesList() as $k) {
            $form->addHidden($this->grid->getId() . '_' . $k)->setValue($this->grid->getRequest()->get($k, ""));
        }

        $form->addSaveButton(___("Run Payout"));
        $form->setDataSources(array($this->grid->getCompleteRequest()));

        if ($form->isSubmitted() && $form->validate()) {
            $values = $form->getValue();
            $this->getDi()->affCommissionTable->runPayout($values['payout_date']);
            $this->grid->redirectBack();
        } else {
            echo $this->renderTitle();
            echo $form;
        }
    }

    /**
     * @return Am_Di
     */
    protected function getDi()
    {
        return Am_Di::getInstance();
    }

}

class Am_Grid_Action_ExportPayout extends Am_Grid_Action_Abstract
{

    protected $type = self::SINGLE;

    public function __construct($id = null, $title = null)
    {
        parent::__construct('export', ___('Export'));
    }

    public function run()
    {
        $payout = $this->grid->getRecord();
        /* @var $payout AffPayout */
        if ($this->grid->getCompleteRequest()->get('run')) {
            $m = $payout->getPayoutMethod();
            if (!$m)
                throw new Am_Exception_InputError("Payout method [$payout->type] is disabled or misconfigured");
            $details = new Am_Query($this->grid->getDi()->affPayoutDetailTable);
            $details->addWhere('payout_id=?d', $payout->pk());
            $response = new Zend_Controller_Response_Http;
            $m->export($payout, $details, $response);
            $response->sendResponse();
            exit();
        } else {
            $link = $this->grid->getActionUrl('export', $payout->pk()) . '&run=1';
            printf("<a href='%s' target=_blank>%s</a>", Am_Controller::escape($link), ___('Download CSV File'));
        }
    }

}

class Am_Grid_Action_PayoutMarkPaid extends Am_Grid_Action_Group_Abstract
{

    public function doRun(array $ids)
    {
        if ($ids[0] == self::ALL) {
            $ids = Am_Di::getInstance()->db->selectCol("SELECT payout_detail_id
                FROM ?_aff_payout_detail
                WHERE payout_id = ?",
                $this->grid->getCompleteRequest()->get('payout_id'));
            Am_Di::getInstance()->db->query("UPDATE ?_aff_payout_detail SET is_paid=1 
                WHERE payout_id = ?",
                $this->grid->getCompleteRequest()->get('payout_id'));
        }
        else
            Am_Di::getInstance()->db->query("UPDATE ?_aff_payout_detail SET is_paid=1 
                WHERE payout_detail_id IN (?a)",
                $ids);
        $this->sendEmailsIfNecessary($ids, $this->grid->getCompleteRequest()->get('payout_id'));
        echo $this->renderDone();
    }

    public function handleRecord($id, $record)
    {
        //nop
    }
    /**
     * @param array $ids ids of payout details
     * @param int $payout_id
     */
    protected function sendEmailsIfNecessary($ids, $payout_id)
    {
        $di = Am_Di::getInstance();
        $payout = $di->affPayoutTable->load($payout_id);
        $options = Am_Aff_PayoutMethod::getAvailableOptions();
        $payout_method_title = isset($options[$payout->type]) ? $options[$payout->type] : $payout->type;

        if ($di->modules->get('aff')->getConfig('notify_payout_paid')) {
            foreach ($ids as $id) {
                $payout_detail = $di->affPayoutDetailTable->load($id);
                $aff = $di->userTable->load($payout_detail->aff_id);

                $et = Am_Mail_Template::load('aff.notify_payout_paid', $aff->lang);
                $et->setPayout_detail($payout_detail);
                $et->setPayout_method_title($payout_method_title);
                $et->setPayout($payout);
                $et->setAffiliate($aff);
                $et->send($aff);
            }
        }
    }

}

class Am_Grid_Action_PayoutMarkNotPaid extends Am_Grid_Action_Group_Abstract
{

    public function doRun(array $ids)
    {
        if ($ids[0] == self::ALL) {
            Am_Di::getInstance()->db->query("UPDATE ?_aff_payout_detail SET is_paid=0 
                WHERE payout_id = ?",
                $this->grid->getCompleteRequest()->get('payout_id'));
        }
        else
            Am_Di::getInstance()->db->query("UPDATE ?_aff_payout_detail SET is_paid=0 
                WHERE payout_detail_id IN (?a)",
                $ids);
        echo $this->renderDone();
    }

    public function handleRecord($id, $record)
    {
        
    }

}

class Aff_AdminPayoutController extends Am_Controller_Grid
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Bootstrap_Aff::ADMIN_PERM_ID);
    }

    function createGrid()
    {
        // display payouts list date | method | total | paid |
        $ds = new Am_Query($this->getDi()->affPayoutTable);
        $ds->leftJoin('?_aff_payout_detail', 'd', 'd.payout_id=t.payout_id AND d.is_paid>0');
        $ds->addField('SUM(amount)', 'paid');
        $ds->setOrder('date', 'DESC');
        $grid = new Am_Grid_Editable('_payout', ___('Payouts'), $ds, $this->_request, $this->view);
        $grid->setPermissionId(Bootstrap_Aff::ADMIN_PERM_ID);
        $grid->actionsClear();
        $grid->addField(new Am_Grid_Field_Date('date', ___('Payout Date')))->setFormatDate();
        $grid->addField(new Am_Grid_Field_Date('thresehold_date', ___('Thresehold Date')))->setFormatDate();
        $grid->addField('type', ___('Payout Method'));
        $grid->addField('total', ___('Total to Pay'))->setGetFunction(array($this, 'getAmount'));
        $grid->addField('paid', ___('Total Paid'))->setGetFunction(array($this, 'getAmount'));
        //$grid->actionAdd(new Am_Grid_Action_Url('run', ___('Run'), '__ROOT__/aff/admin-payout/run?payout_id=__ID__'));
        $grid->actionAdd(new Am_Grid_Action_Url('view', ___('View'), '__ROOT__/aff/admin-payout/view?payout_id=__ID__'))
            ->setTarget('_top');
        $grid->actionAdd(new Am_Grid_Action_RunPayout('run_payout', ___('Generate Payout Manually')));
        $grid->actionAdd(new Am_Grid_Action_ExportPayout());
        $grid->actionAdd(new Am_Grid_Action_Delete())
            ->setIsAvailableCallback(array($this, 'isDeleteAvailable'));
        $grid->addCallback(Am_Grid_ReadOnly::CB_TR_ATTRIBS, array($this, 'cbGetTrAttribs'));
        $grid->addCallback(Am_Grid_Editable::CB_RENDER_CONTENT, array($this, 'renderContent'));

        return $grid;
    }

    public function isDeleteAvailable($record)
    {
        return (float) $record->paid == 0.0;
    }

    public function cbGetTrAttribs(& $ret, $record)
    {
        if ($record->total <= $record->paid) {
            $ret['class'] = isset($ret['class']) ? $ret['class'] . ' disabled' : 'disabled';
        }
    }

    function viewAction()
    {
        // display payouts list date | method | total | paid |
        $id = $this->getInt('payout_id');

        if (!$id)
            throw new Am_Exception_InputError("Not payout_id passed");
        $ds = new Am_Query($this->getDi()->affPayoutDetailTable);
        $ds->leftJoin('?_aff_payout', 'p', 'p.payout_id=t.payout_id');
        $ds->leftJoin('?_user', 'u', 't.aff_id=u.user_id');
        $ds->addField('u.*');
        $ds->addField('p.type', 'type');
        $ds->addWhere('t.payout_id=?d', $id);

        $grid = new Am_Grid_Editable('_d', ___("Payout %d Details", $id), $ds, $this->_request, $this->view);
        $grid->setPermissionId(Bootstrap_Aff::ADMIN_PERM_ID);
        $grid->addCallback(Am_Grid_Editable::CB_RENDER_TABLE, array($this, 'addBackLink'));

        $userUrl = new Am_View_Helper_UserUrl();
        $grid->addField('email', ___('E-Mail'))
            ->addDecorator(new Am_Grid_Field_Decorator_Link($userUrl->userUrl('{user_id}'), '_top'));
        $grid->addField('name_f', ___('First Name'));
        $grid->addField('name_l', ___('Last Name'));
        $grid->addField('type', ___('Payout Method'));
        $grid->addField('amount', ___('Amount'))->setGetFunction(array($this, 'getAmount'));
//        $grid->addField('receipt_id', ___('Receipt Id'));
        $grid->addField(new Am_Grid_Field_Enum('is_paid', ___('Is Paid?')))
            ->setTranslations(array(
                0 => ___('No'),
                1 => ___('Yes')
            ));
        $grid->addField(new Am_Grid_Field_Expandable('_details', ___('Payout Details')))
            ->setGetFunction(array($this, 'getPayoutDetails'));
        $grid->actionsClear();
        //$grid->actionAdd(new Am_Grid_Action_LiveEdit('receipt_id'));
        $grid->actionAdd(new Am_Grid_Action_PayoutMarkPaid('mark_paid', ___('Mark Paid')));
        $grid->actionAdd(new Am_Grid_Action_PayoutMarkNotPaid('mark_notpaid', ___('Mark NOT Paid')));
        $grid->addCallback(Am_Grid_ReadOnly::CB_TR_ATTRIBS, array($this, 'detailCbGetTrAttribs'));
        $grid->runWithLayout();
    }

    function detailCbGetTrAttribs(& $ret, $record)
    {
        if ($record->is_paid) {
            $ret['class'] = isset($ret['class']) ? $ret['class'] . ' disabled' : 'disabled';
        }
    }

    function getPayoutDetails($obj)
    {
        $obj = $this->getDi()->userTable->createRecord($obj->toArray());

        $type = $obj->aff_payout_type;
        $pattern = 'aff_' . $type . '_';
        $out = "";
        foreach ($obj->data()->getAll() as $k => $v) {
            if (strpos($k, $pattern) !== 0)
                continue;
            $out .= sprintf("<strong>%s</strong> : %s <br />\n",
                    Am_Controller::escape(ucfirst(substr($k, strlen($pattern)))),
                    Am_Controller::escape($v));
        }
        return $out ? $out : '-no details-';
    }

    function addBackLink(& $out, Am_Grid_ReadOnly $grid)
    {
        $out = "<a class='link' href='" . ROOT_URL . "/aff/admin-payout'>" . ___('Return to Payouts List') . "</a><br /><br />" . $out;
    }

    public function getAmount($record, $grid, $field)
    {
        return Am_Currency::render($record->{$field});
    }

    public function renderContent(& $out, Am_Grid_Editable $grid)
    {
        $out = '<div class="info">' . ___('aMember generate payout reports automatically according your settings %shere%s. ' .
            'Please note user without defined valid payout method will not be included to this payout report. They should define it first ' .
            'in his member area.',
                '<a class="link" href="' . REL_ROOT_URL . '/admin-setup/aff#payout" target="_top">', '</a>') . '</div>' . $out;
    }

}