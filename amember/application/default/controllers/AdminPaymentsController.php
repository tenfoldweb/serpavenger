<?php 
/*
*
*
*     Author: Alex Scott
*      Email: alex@cgi-central.net
*        Web: http://www.cgi-central.net
*    Details: Admin Payments
*    FileName $RCSfile$
*    Release: 4.4.2 ($Revision$)
*
* Please direct bug reports,suggestions or feedback to the cgi-central forums.
* http://www.cgi-central.net/forum/
*                                                                          
* aMember PRO is a commercial software. Any distribution is strictly prohibited.
*
*/

abstract class Am_Grid_Filter_Payments_Abstract extends Am_Grid_Filter_Abstract
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
                    if ($q->getTableName() == '?_invoice') {
                        $q->addWhere('(t.invoice_id=? OR t.public_id=?)', $filter['text'], $filter['text']);
                    } else {
                        $q->addWhere('(t.invoice_id=? OR t.invoice_public_id=?)', $filter['text'], $filter['text']);
                    }
                    break;
                case 'login':
                    $q->addWhere('login=?', $filter['text']);
                    break;
                case 'receipt':
                    if ($q->getTableName() == '?_invoice') {
                        $q->leftJoin('?_invoice_payment', 'p');
                    }
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
                ->addWhere('ii.item_id in (?a)', $filter['product_id']);
        }
        if(@$filter['paysys_id'])
            $q->addWhere('paysys_id in (?a)', $filter['paysys_id']);
        
    }
    public function renderInputs()
    {
        $prefix = $this->grid->getId();

        $filter = (array)$this->vars['filter'];
        $filter['datf'] = Am_Controller::escape(@$filter['datf']);
        $filter['dat1'] = Am_Controller::escape(@$filter['dat1']);
        $filter['dat2'] = Am_Controller::escape(@$filter['dat2']);
        $filter['text'] = Am_Controller::escape(@$filter['text']);

        $pOptions = array();
        $pOptions = $pOptions +
            Am_Di::getInstance()->productTable->getOptions();
        $pOptions = Am_Controller::renderOptions(
            $pOptions,
            @$filter['product_id']
        );
        
        $paysysOptions = array();
        $paysysOptions = $paysysOptions +
            Am_Di::getInstance()->paysystemList->getOptions();
        $paysysOptions = Am_Controller::renderOptions(
            $paysysOptions,
            @$filter['paysys_id']
        );

        
        $options = Am_Controller::renderOptions(array(
            'invoice' => ___('Invoice Number'),
            'receipt' => ___('Payment Receipt'),
            'login' => ___('Username'),
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
        $offer_product = '-' . ___('Filter by Product') . '-';
        $offer_paysys = '-' . ___('Filter by Paysystem') . '-';
        return <<<CUT
<div style='display:table-cell; padding-right:0.4em; padding-bottom:0.4em; width:160px; box-sizing:border-box;'>
<select name="{$prefix}_filter[product_id][]" style="width:160px" class="magicselect" multiple="multiple" data-offer='$offer_product'>
$pOptions
</select>
</div>
<div style='display:table-cell; padding-right:0.4em; padding-bottom:0.4em; width:160px; box-sizing:border-box;'>
<select name="{$prefix}_filter[paysys_id][]" style="width:160px" class="magicselect" multiple="multiple" data-offer='$offer_paysys'>
$paysysOptions
</select>
   </div>    
<div style='display:table-cell; padding-bottom:0.4em;'>

$dSelect
<input type="text" placeholder="$start" name="{$prefix}_filter[dat1]" class='datepicker' style="width:80px" value="{$filter['dat1']}" />
<input type="text" placeholder="$end" name="{$prefix}_filter[dat2]" class='datepicker' style="width:80px" value="{$filter['dat2']}" />
</div>
<input type="text" name="{$prefix}_filter[text]" value="{$filter['text']}" style="width:380px" />
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

class Am_Grid_Filter_Payments extends Am_Grid_Filter_Payments_Abstract {
    public function renderInputs()
    {
        return parent::renderInputs() . '<br />' . $this->renderDontShowRefunded();
    }

    public function renderDontShowRefunded()
    {
        $filter = (array)$this->vars['filter'];
        return sprintf('<label>
                <input type="hidden" name="%s_filter[dont_show_refunded]" value="0" />
                <input type="checkbox" name="%s_filter[dont_show_refunded]" value="1" %s /> %s</label>',
                $this->grid->getId(), $this->grid->getId(),
                (@$this->vars['filter']['dont_show_refunded'] == 1 ? 'checked' : ''),
                Am_Controller::escape(___('do not show refunded payments'))
            );
    }

    protected function applyFilter()
    {
        parent::applyFilter();
        $filter = (array)$this->vars['filter'];
        $q = $this->grid->getDataSource();
        if (@$filter['dont_show_refunded'])
           $q->addWhere('t.refund_dattm IS NULL');
    }
}

class Am_Grid_Filter_Invoices extends Am_Grid_Filter_Payments_Abstract {

    public function renderInputs()
    {
        return parent::renderInputs() . '<br />' . $this->renderDontShowPending();
    }

    public function renderDontShowPending()
    {
        $filter = (array)$this->vars['filter'];
        return sprintf('<label>
                <input type="hidden" name="%s_filter[dont_show_pending]" value="0" />
                <input type="checkbox" name="%s_filter[dont_show_pending]" value="1" %s /> %s</label>',
                $this->grid->getId(), $this->grid->getId(),
                (@$this->vars['filter']['dont_show_pending'] == 1 ? 'checked' : ''),
                Am_Controller::escape(___('do not show pending invoices'))
            );
    }

    protected function applyFilter()
    {
        parent::applyFilter();
        $filter = (array)$this->vars['filter'];
        $q = $this->grid->getDataSource();
        if (@$filter['dont_show_pending'])
           $q->addWhere('t.status<>?', Invoice::PENDING);
    }

    public function getDateFieldOptions()
    {
        return array(
            'tm_added' => ___('Added'),
            'tm_started' => ___('Started'),
            'tm_cancelled' => ___('Cancelled'),
            'rebill_date' => ___('Rebill Date')
        );
    }
}

class Am_Grid_Filter_Refunds extends Am_Grid_Filter_Payments_Abstract {
    public function getDateFieldOptions()
    {
        return array('dattm' => ___('Refund Date'));
    }
}

class AdminPaymentsController extends Am_Controller_Pages
{
    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission('grid_payment') || $admin->hasPermission('grid_invoice');
    }
    public function initPages()
    {
        $admin = $this->getDi()->authAdmin->getUser();

        if ($admin->hasPermission('grid_payment'))
            $this->addPage(array($this, 'createPaymentsPage'), 'index', ___('Payment'));

        if ($admin->hasPermission('grid_payment'))
            $this->addPage(array($this, 'createRefundsPage'), 'refunds', ___('Refund'));

        if ($admin->hasPermission('grid_invoice')) {
            $this->addPage(array($this, 'createInvoicesPage'), 'invoices', ___('Invoice'));
            if($this->getDi()->config->get('manually_approve_invoice'))
                $this->addPage(array($this, 'createInvoicesPage'), 'not-approved', ___('Not Approved'));
        }
    }
    function createPaymentsPage()
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
            ->addField("CONCAT(m.name_f,' ',m.name_l)", 'name')
            ->addField('m.name_f')
            ->addField('m.name_l')
            ->addField('DATE(dattm)', 'date')
            ->addField('t.invoice_public_id', 'public_id');
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
        array_push($totalFields, $grid->addField('amount', ___('Amount'))->setGetFunction(array($this, 'getAmount')));

        if ($this->getDi()->plugins_tax->getEnabled()) {
            array_push($totalFields, $grid->addField('tax', ___('Tax'))->setGetFunction(array($this, 'getTax')));
        }
        $grid->addField(new Am_Grid_Field_Date('refund_dattm', ___('Refunded')))->setFormatDatetime();
        $grid->addField('items', ___('Items'));
        $grid->addField('login', ___('Username'))->addDecorator(
            new Am_Grid_Field_Decorator_Link(
                'admin-users?_u_a=edit&_u_b={THIS_URL}&_u_id={user_id}', '_top')
        );
        $grid->addField('name', ___('Name'));
        $grid->setFilter(new Am_Grid_Filter_Payments);

        $action = new Am_Grid_Action_Export();
        $action->addField(new Am_Grid_Field('dattm', ___('Date/Time')))
                ->addField(new Am_Grid_Field('date', ___('Date')))
                ->addField(new Am_Grid_Field('receipt_id', ___('Receipt')))
                ->addField(new Am_Grid_Field('paysys_id', ___('Payment System'))) 
                ->addField(new Am_Grid_Field('amount', ___('Amount')))
                ->addField(new Am_Grid_Field('tax', ___('Tax')))
                ->addField(new Am_Grid_Field('refund_dattm', ___('Refunded')))
                ->addField(new Am_Grid_Field('login', ___('Username')))
                ->addField(new Am_Grid_Field('name', ___('Name')))
                ->addField(new Am_Grid_Field('name_f', ___('First Name')))
                ->addField(new Am_Grid_Field('name_l', ___('Last Name')))
                ->addField(new Am_Grid_Field('email', ___('Email')))
                ->addField(new Am_Grid_Field('street', ___('Street')))
                ->addField(new Am_Grid_Field('city', ___('City')))
                ->addField(new Am_Grid_Field('state', ___('State')))
                ->addField(new Am_Grid_Field('country', ___('Country')))
                ->addField(new Am_Grid_Field('phone', ___('Phone')))
                ->addField(new Am_Grid_Field('zip', ___('Zip Code')))
                ->addField(new Am_Grid_Field('items', ___('Items')))
                ->addField(new Am_Grid_Field('invoice_id', ___('Invoice (Internal Id)')))
                ->addField(new Am_Grid_Field('public_id', ___('Invoice (Public Id)')))
            ;
        $grid->actionAdd($action);
        $action = $grid->actionAdd(new Am_Grid_Action_Total());
        foreach ($totalFields as $f)
            $action->addField($f, 'ROUND(%s / base_currency_multi, 2)');
        
        return $grid;
    }

    function createRefundsPage()
    {
        $query = new Am_Query($this->getDi()->invoiceRefundTable);
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
            ->addField('m.name_f')
            ->addField('m.name_l')
            ->addField('DATE(dattm)', 'date')
            ->addField('t.invoice_public_id', 'public_id');
        $query->setOrder("invoice_payment_id", "desc");

        $grid = new Am_Grid_Editable('_refund', ___('Refunds'), $query, $this->_request, $this->view);
        $grid->setPermissionId('grid_payment');
        $grid->actionsClear();
        $grid->addField(new Am_Grid_Field_Date('dattm', ___('Date/Time')));

        $grid->addField('invoice_id', ___('Invoice'))
            ->setGetFunction(array($this, '_getInvoiceNum'))
            ->addDecorator(
                new Am_Grid_Field_Decorator_Link(
                    'admin-user-payments/index/user_id/{user_id}#invoice-{invoice_id}', '_top'));
        $grid->addField('receipt_id', ___('Receipt'));
        $grid->addField('paysys_id', ___('Payment System'));
        $fieldAmount = $grid->addField('amount', ___('Amount'))->setGetFunction(array($this, 'getAmount'));
        $grid->addField('items', ___('Items'));
        $grid->addField('login', ___('Username'))->addDecorator(
            new Am_Grid_Field_Decorator_Link(
                'admin-users?_u_a=edit&_u_b={THIS_URL}&_u_id={user_id}', '_top')
        );
        $grid->addField('name', ___('Name'));
        $grid->setFilter(new Am_Grid_Filter_Refunds);

        $action = new Am_Grid_Action_Export();
        $action->addField(new Am_Grid_Field('dattm', ___('Date/Time')))
                ->addField(new Am_Grid_Field('date', ___('Date')))
                ->addField(new Am_Grid_Field('receipt_id', ___('Receipt')))
                ->addField(new Am_Grid_Field('paysys_id', ___('Payment System')))
                ->addField(new Am_Grid_Field('amount', ___('Amount')))
                ->addField(new Am_Grid_Field('login', ___('Username')))
                ->addField(new Am_Grid_Field('name', ___('Name')))
                ->addField(new Am_Grid_Field('name_f', ___('First Name')))
                ->addField(new Am_Grid_Field('name_l', ___('Last Name')))
                ->addField(new Am_Grid_Field('email', ___('Email')))
                ->addField(new Am_Grid_Field('street', ___('Street')))
                ->addField(new Am_Grid_Field('city', ___('City')))
                ->addField(new Am_Grid_Field('state', ___('State')))
                ->addField(new Am_Grid_Field('country', ___('Country')))
                ->addField(new Am_Grid_Field('phone', ___('Phone')))
                ->addField(new Am_Grid_Field('zip', ___('Zip Code')))
                ->addField(new Am_Grid_Field('items', ___('Items')))
                ->addField(new Am_Grid_Field('invoice_id', ___('Invoice (Internal Id)')))
                ->addField(new Am_Grid_Field('public_id', ___('Invoice (Public Id)')))
            ;
        $grid->actionAdd($action);

        $action = $grid->actionAdd(new Am_Grid_Action_Total());
            $action->addField($fieldAmount, 'ROUND(%s / base_currency_multi, 2)');

        return $grid;
    }
    
    function getAmount(Am_Record $p)
    {
        return Am_Currency::render($p->amount, $p->currency);
    }
    
    function getTax(InvoicePayment $p)
    {
        return Am_Currency::render($p->tax, $p->currency);
    }
    
    function _getInvoiceNum(Am_Record $invoice)
    {
        return $invoice->invoice_id . '/' . $invoice->public_id;
    }
    
    function createInvoicesPage($page)
    {
        $query = new Am_Query($this->getDi()->invoiceTable);
        if($page =='not-approved') $query->addWhere('is_confirmed<1');
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
            ->addField('m.name_f')
            ->addField('m.name_l')
            ->addField('DATE(tm_started)', 'date');
        $query->setOrder("invoice_id", "desc");
        
        $grid = new Am_Grid_Editable('_invoice', ___('Invoices'), $query, $this->_request, $this->view);
        $grid->setRecordTitle(array($this, 'getInvoiceRecordTitle'));
        $grid->actionsClear();
        $grid->actionAdd(new Am_Grid_Action_Delete())->setTarget('_top');
        $grid->addField(new Am_Grid_Field_Date('tm_added', ___('Added')));
        
        $grid->addField('invoice_id', ___('Invoice'))->setGetFunction(array($this, '_getInvoiceNum'))->addDecorator(
            new Am_Grid_Field_Decorator_Link(
                'admin-user-payments/index/user_id/{user_id}#invoice-{invoice_id}', '_top')
        );
        $grid->addField('status', ___('Status'))->setRenderFunction(array($this, 'renderInvoiceStatus'));
        $grid->addField('paysys_id', ___('Payment System'));
        $grid->addField('_total', ___('Billing Terms'), false)->setGetFunction(array($this, 'getInvoiceTotal'));
        $grid->addField(new Am_Grid_Field_Date('rebill_date', ___('Rebill Date')))->setFormatDate();
        $grid->addField('items', ___('Items'));
        $grid->addField('login', ___('Username'))->addDecorator(
            new Am_Grid_Field_Decorator_Link(
                'admin-users?_u_a=edit&_u_b={THIS_URL}&_u_id={user_id}', '_top')
        );
        $grid->addField('name', ___('Name'));
        $filter = new Am_Grid_Filter_Invoices();
        $grid->setFilter($filter);
        
        $action = new Am_Grid_Action_Export();
        $action->addField(new Am_Grid_Field('tm_started', ___('Date/Time')))
                ->addField(new Am_Grid_Field('date', ___('Date')))
                ->addField(new Am_Grid_Field('rebill_date', ___('Rebill Date')))
                ->addField(new Am_Grid_Field('invoice_id', ___('Invoice (Internal Id)')))
                ->addField(new Am_Grid_Field('public_id', ___('Invoice (Public Id)')))
                ->addField(new Am_Grid_Field('paysys_id', ___('Payment System'))) 
                ->addField(new Am_Grid_Field('first_total', ___('First Total')))
                ->addField(new Am_Grid_Field('first_tax', ___('First Tax')))
                ->addField(new Am_Grid_Field('email', ___('Email')))
                ->addField(new Am_Grid_Field('login', ___('Username')))
                ->addField(new Am_Grid_Field('name', ___('Name')))
                ->addField(new Am_Grid_Field('name_f', ___('First Name')))
                ->addField(new Am_Grid_Field('name_l', ___('Last Name')))
                ->addField(new Am_Grid_Field('street', ___('Street')))
                ->addField(new Am_Grid_Field('city', ___('City')))
                ->addField(new Am_Grid_Field('state', ___('State')))
                ->addField(new Am_Grid_Field('country', ___('Country')))
                ->addField(new Am_Grid_Field('phone', ___('Phone')))
                ->addField(new Am_Grid_Field('zip', ___('Zip Code')))
                ->addField(new Am_Grid_Field('item_title', ___('Product Title')));
        $action->setGetDataSourceFunc(array($this, 'getExportDs'));
        $grid->actionAdd($action);
        if($this->getDi()->config->get('manually_approve_invoice'))
            $grid->actionAdd(new Am_Grid_Action_Group_Callback('approve', ___("Approve"), array($this, 'approveInvoice')));
        
        
        return $grid;
    }

    public function getInvoiceRecordTitle(Invoice $invoice = null)
    {
        return $invoice ? sprintf('%s (%s/%s, %s: %s)',
            ___('Invoice'), $invoice->pk(), $invoice->public_id,
            ___('Billing Terms'), new Am_TermsText($invoice)) :
            ___('Invoice');
    }

    public function getExportDs(Am_Query $ds)
    {
        return $ds->leftJoin('?_invoice_item', 'ii', 'ii.invoice_id=t.invoice_id')
                    ->addField('ii.item_title', 'item_title');
    }
    
    public function getInvoiceTotal(Invoice $invoice)
    {
        return $invoice->getTerms();
    } 
    
    public function renderInvoiceStatus(Invoice $invoice)
    {
        return '<td>'.$invoice->getStatusTextColor().'</td>';
    }
    
    public function approveInvoice($id, Invoice $invoice){
        $invoice->approve();
    }
}
