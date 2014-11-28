<?php
/**
 * @table paysystems
 * @id epoch
 * @title Epoch
 * @visible_link https://epoch.com/en/index.html
 * @recurring paysystem
 * @logo_url epoch.png
 */
class Am_Paysystem_Epoch extends Am_Paysystem_Abstract{
    const PLUGIN_STATUS = self::STATUS_BETA;
    const PLUGIN_REVISION = '4.4.2';

    protected $defaultTitle = 'Epoch';
    protected $defaultDescription = 'Pay by credit card/debit card';
    
    const URL = 'https://wnu.com/secure/fpost.cgi';
    
    const NO = 0; 
    const YES = 1; 
    
    const EPOCH_MEMBER_ID = 'epoch_member_id';
    protected $_canResendPostback = true;
   
    public function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText("co_code")->setLabel(array('Company code', 'Three (3) alphanumeric ID assigned by Epoch (Company code does not change)'));
        $form->addSelect("testing", array(), array('options' => array(
                self::NO=>'No',
                self::YES =>'Yes' 
            )))->setLabel(array('Testing', 'enable/disable payments with test credit cars ask Epoch  support for test credit card numbers'));
        
        $form->addSelect("ach_form", array(), array('options' => array(
                self::NO=>'No',
                self::YES =>'Yes' 
            )))->setLabel(array('Enable ACH Flag', 'If this field is passed in it will enable online check (ACH) processing. Online check processing is only valid for US.'));
        
    }
    
    public function init()
    {
        parent::init();
        $this->getDi()->billingPlanTable->customFields()
            ->add(new Am_CustomFieldText('epoch_product_id', "Epoch Product ID",
                    "you must create the same product<br />in Epoch and enter its number here"));
        
    }
    
    public function _process(Invoice $invoice, Am_Request $request, Am_Paysystem_Result $result)
    {
        $a = new Am_Paysystem_Action_Form(self::URL);
        $a->co_code =   $this->getConfig('co_code');
		$a->pi_code  =   $invoice->getItem(0)->getBillingPlanData('epoch_product_id');
        $a->reseller    =   'a';
        $a->zip =   $invoice->getZip();
        $a->email   =   $invoice->getEmail();
        $a->country =   $invoice->getCountry();
        $a->no_userpass =   self::YES;
        $a->name    =   $invoice->getName();
        $a->street  =   $invoice->getStreet();
        $a->phone   =   $invoice->getPhone();
        $a->city    =   $invoice->getCity();
        $a->state   =   $invoice->getState();
        $a->pi_returnurl =  $this->getPluginUrl("thanks");
        $a->response_post   =   self::YES;
        $a->x_payment_id    =   $invoice->public_id;
        if($this->getConfig('ach_form') == self::YES) $a->ach_form = self::YES;
        $result->setAction($a);
        
    }
    public function createTransaction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_Epoch_IPN($this, $request, $response, $invokeArgs);
    }
    
    public function getRecurringType()
    {
        return self::REPORTS_REBILL;
    }

    function getReadme(){
        $root_url = $this->getDi()->config->get('root_url');
        return <<<CUT

<b>Epoch payment plugin</b>
----------------------------------------------------------------------

 - Set up products with the same settings as you have defined in 
   aMember. 
   Then enter Epoch Product IDs into corresponding field in aMember 
   Product settings (aMember Cp -> Manage Products->Edit product -> Billing terms)
   
 - Set up the data postback URL to 
   {$root_url}/payment/epoch/ipn
CUT;
    }
    public function thanksAction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        $log = $this->logRequest($request);
        $transaction = new Am_Paysystem_Transaction_Epoch_Thanks($this, $request, $response, $invokeArgs);
        $transaction->setInvoiceLog($log);
        try {
            $transaction->process();
        } catch (Exception $e) {
            throw $e;
            $this->getDi()->errorLogTable->logException($e);
            throw Am_Exception_InputError(___("Error happened during transaction handling. Please contact website administrator"));
        }
        $log->setInvoice($transaction->getInvoice())->update();
        $this->invoice = $transaction->getInvoice();
        $response->setRedirect($this->getReturnUrl());
    }
    
    public function canAutoCreate()
    {
        return true;
    }
    
}

class Am_Paysystem_Transaction_Epoch_IPN extends Am_Paysystem_Transaction_Incoming{
    protected $ip = array(array('208.236.105.0', '208.236.105.255'),
			    array('65.17.248.0', '65.17.248.255'));

    protected $_autoCreateMap = array(
        'email' => 'email',
        'name' => 'name',
        'country' => 'country',
        'state' => 'state',
        'zip'   =>  'zip',
        'state' => 'state',
        'user_external_id' => 'email',
        'invoice_external_id' => 'order_id',
    );
    
    
    public function getUniqId()
    {
        if($this->request->get('transaction_id'))
            return $this->request->get('transaction_id');
        else
            return $this->request->get('ets_transaction_id') . '-' .$this->invoice->getPaymentsCount();
    }
    
    function findInvoiceId()
    {
        if($this->request->get("x_payment_id"))
            return $this->request->get("x_payment_id");
        elseif($this->request->get("ets_transaction_id"))
        {
            if($invoice = $this->getPlugin()->getDi()->invoiceTable->findByReceiptIdAndPlugin($this->request->get("ets_transaction_id"), $this->getPlugin()->getId()))
                return $invoice->public_id;
            if($member_id = $this->request->get('ets_member_idx'))
            {
                if($invoice = $this->getPlugin()->getDi()->invoiceTable->findFirstByData(Am_Paysystem_Epoch::EPOCH_MEMBER_ID, $member_id))
                    return $invoice->public_id;
            }
        }
    }
    public function validateSource()
    {
        $this->_checkIp($this->ip);
        return true;
    }
    public function validateStatus()
    {
        if($this->request->get("ets_transaction_id"))
            return true;
        if(substr($this->request->get('ans'),0,1) != 'Y')
            throw new Am_Exception_Paysystem_TransactionInvalid('Transaction declined!');
        if((strstr($this->request->get('ans'), 'YGOODTEST') !== false) && ($this->getPlugin()->getConfig('testing') != Am_Paysystem_Epoch::YES))
            throw new Am_Exception_Paysystem_TransactionInvalid("Received test result but test mode is not enabled!");
        
        return true;
    }
    public function validateTerms()
    {
        return true;
    }
    
    
    function processValidated()
    {
        /*
         C = Credit to Customers Account
         D = Chargeback Transaction
         F = Initial Free Trial Transaction
         I = Standard Initial Recurring Transaction
         J = Denied Trial Conversion
         K = Cancelled Trial
         N = Non-Initial Recurring Transaction
         O = Non-Recurring Transaction
         T = Initial Paid Trial Order Transaction
         U = Initial Trial Conversion
         X = Returned Check Transaction
         */
        if($member_id = $this->request->get('member_id'))
        {
            $this->invoice->data()->set(Am_Paysystem_Epoch::EPOCH_MEMBER_ID, $member_id)->update();
        }
        if($ets_transaction_type = $this->request->get("ets_transaction_type"))
        {
            if(in_array($this->request->get("ets_transaction_type"), array('U','N')))
                $this->invoice->addPayment($this);
            if(in_array($this->request->get("ets_transaction_type"), array('K')))
                $this->invoice->setCancelled();
            if(in_array($this->request->get("ets_transaction_type"), array('D')))
                $this->invoice->addRefund ($this, $this->request->get("ets_transaction_id"), $this->request->get("ets_transaction_amount"));
        }
        else
                $this->invoice->addPayment($this);
        print "OK";
    }
    
    function getInvoice(){
        return $this->loadInvoice($this->findInvoiceId());
    }
    
    public function autoCreateGetProducts()
    {
        $Id = $this->request->getFiltered('pi_code');
        if (empty($Id)) return;
        $pl = $this->getPlugin()->getDi()->billingPlanTable->findFirstByData('epoch_product_id', $Id);
        if (!$pl) return;
        $pr = $pl->getProduct();
        if (!$pr) return;
        return array($pr);
    }
    
    
}
class Am_Paysystem_Transaction_Epoch_Thanks extends Am_Paysystem_Transaction_Epoch_IPN {
    public function validateSource(){
        return true;
    }
    
    public function processValidated(){
        return;
    }
}
    
