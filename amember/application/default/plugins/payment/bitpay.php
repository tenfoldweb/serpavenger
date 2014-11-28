<?php
/**
 * @table paysystems
 * @id bitpay
 * @title BitPay
 * @visible_link https://bitpay.com/
 * @recurring none
 * @logo_url bitpay.png
 */
class Am_Paysystem_Bitpay extends Am_Paysystem_Abstract
{

    const PLUGIN_STATUS = self::STATUS_BETA;
    const PLUGIN_REVISION = '4.4.2';

    protected $defaultTitle = 'BitPay';
    protected $defaultDescription = 'paid by bitcoins';
    
    const URL = 'https://bitpay.com/api/invoice/';
    const BITPAY_INVOICE_ID = 'bitpay-invoice-id';
    
    private $transactionSpeedOptions = array(
        1 => 'Low: 6 confirmations, 30 minutes to 1 hour or more',
        2 => 'Medium: 3 confirmations, approximately 10-30 minutes',
        3 => 'High: Instant, for low priced digital products that require no confirmation'
    );
    private $transactionSpeed = array(
        1 => 'low',
        2 => 'medium',
        3 => 'high'
    );

    public function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText('apiKey', array('size' => 40))
            ->setLabel(array('Merchant API Key', 'from bitpay merchant account -> My Account -> API Access keys'))
            ->addRule('required');
        
        $form->addSelect('bitpay_speed_risk')
            ->setLabel(array('Default Bitpay speed/risk'))
            ->loadOptions($this->transactionSpeedOptions);
        
        $form->addAdvCheckbox("use_http")
            ->setLabel(array("Use HTTP Protocol" ,
                "at return URL"));

        $form->addAdvCheckbox("debugMode")
            ->setLabel(array("Debug Mode Enabled" ,
                "write all requests/responses to log"));
    }
    
    function init()
    {
        parent::init();
        $opt = array(
            '' => 'Using plugin settings'
        );
        if ($this->isConfigured())
            Am_Di::getInstance()->productTable->customFields()->add(
                new Am_CustomFieldSelect('bitpay_speed_risk', 'Bitpay speed/risk', null, null, array('options' => $opt+$this->transactionSpeedOptions))
            );
    }
    
    public function _process(Invoice $invoice, Am_Request $request, Am_Paysystem_Result $result)
    {
        $prSpeeds = array();
        foreach ($invoice->getProducts() as $product)
            $prSpeeds[] = ($o = $product->data()->get('bitpay_speed_risk')) ? $o : $this->getConfig('bitpay_speed_risk');
  
        $user = $invoice->getUser();
        $post = array(
            'price' => $invoice->first_total,
            'currency' => $invoice->currency,
            'posData' => array(),
            'notificationURL' => $this->getPluginUrl('ipn'),
            'transactionSpeed' => $this->transactionSpeed[min($prSpeeds)],
//            'fullNotifications' => 'true', // false default
//            'notificationEmail' => $user->email, // needed it ?
            'redirectURL' => $this->getConfig('use_http', false) ? 
                str_replace('https://', 'http://', $this->getReturnUrl()) :
                $this->getReturnUrl(),
            'orderID' => $invoice->public_id,
            'itemDesc' => $invoice->getLineDescription(),
            
            'buyerName' => $user->getName(),
            'buyerAddress1' => $user->street,
            'buyerAddress2' => $user->street2,
            'buyerState' => Am_Di::getInstance()->stateTable->getTitleByCode($user->country, $user->state),
            'buyerZip' => $user->zip,
            'buyerCountry' => Am_Di::getInstance()->countryTable->getTitleByCode($user->country),
            'buyerEmail' => $user->email,
            'buyerPhone' => $user->phone,
        );
        $post = array_filter($post);
        
        $req = new Am_Request_Bitpay($this, Am_HttpRequest::METHOD_POST, json_encode($post), 'createInvoice');
        $res = $req->getResult();

        if (!isset($res['status']) || $res['status'] != 'new')
        {
            Am_Di::getInstance()->errorLogTable->log("BitPay API Error. Invoice status is not NEW: " . @$res['status'] . ".");
            throw new Am_Exception_InternalError();
        }
        
        $invoice->data()->set(self::BITPAY_INVOICE_ID, $res['id'])->update();
        
        $action = new Am_Paysystem_Action_Redirect($res['url']);
        $result->setAction($action);
    }
    
//  for test only
/*
    public function directAction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        if ($request->getActionName() == 'test')
        {
//            $req = new Am_Request_Bitpay($this, Am_HttpRequest::METHOD_GET, 'WjjP3w3jWw1WZ-Vzxm8fQjnCoawUi-63xU83237gw4s=', 'checkInvoice');
//            print_rre($req->getResult());

            $post = array(
                'id' => 'WjjP3w3jWw1WZ-Vzxm8fQjnCoawUi-63xU83237gw4s=',
                'status' => 'paid',
                'price' => '13',
            );

            $r  = new Am_HttpRequest($this->getPluginUrl('ipn'));
            $r->setMethod(Am_HttpRequest::METHOD_POST);
            $r->setHeader('content-type', 'application/json');
            $r->setBody(json_encode($post));
            
            return;
        }
        parent::directAction($request, $response, $invokeArgs);
    }
*/
    public function getRecurringType()
    {
        return self::REPORTS_NOT_RECURRING;
    }

    public function getReadme()
    {
        return <<<CUT
            BitPay payment plugin configuration

This plugin allows to customers paid for products by bitcoins.

<b>NOTE:</b> This plugin is not support recurring payments.

For using this plugin:
    - you must obtain an API key from the bitpay website and paste it at 'Merchant API Key' option
        (find your API Key by logging into your merchant account and clicking on My Account, API Access keys)
    - your server must use HTTPS protocol
    
Go to 'aMember CP -> Products -> Manage Products' and edit 'Bitpay speed/risk' options for needed products.

It is recommended to enable Debug Mode for the first time.

CUT;
    }

    public function createTransaction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_Bitpay($this, $request, $response, $invokeArgs);
    }

    public function createThanksTransaction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_Bitpay($this, $request, $response, $invokeArgs);
    }
}

class Am_Paysystem_Transaction_Bitpay extends Am_Paysystem_Transaction_Incoming
{
    private $res;
    
    public function process()
    {
        $rawBody = $this->request->getRawBody();
        if($this->plugin->getConfig('debugMode'))
            Am_Di::getInstance()->errorLogTable->log("BitPay-debug [incoming]. REQUEST: $rawBody.");
        
        $vars = json_decode($rawBody, true);
        
        if (!isset($vars['id']))
            throw new Am_Exception_InternalError("BitPay API Error. Request[incoming] has no [id].");
        
        $req = new Am_Request_Bitpay($this->plugin, Am_HttpRequest::METHOD_GET, $vars['id'], 'checkInvoice');
        $this->res = $req->getResult();
        
        parent::process();
    }

    public function validateSource()
    {
        return true;
    }

    public function findInvoiceId()
    {
        $id = Am_Di::getInstance()->db->selectCell("
            SELECT id
            FROM ?_data
            WHERE
                `table` = 'invoice'
                AND `key` = ?
                AND `value` = ?
        ", Am_Paysystem_Bitpay::BITPAY_INVOICE_ID, $this->res['id']);
        if (!$id)
            throw new Am_Exception_InternalError("BitPay Error. Not found invoice by bitpayInvoiceId #[{$this->res['id']}].");
        
        return Am_Di::getInstance()->invoiceTable->load($id)->public_id;
    }

    public function validateStatus()
    {
        switch ($this->res['status'])
        {
            case 'paid':
            case 'confirmed':
            case 'complete':
                return true;
        }
    }

    public function getUniqId()
    {
        return (string) $this->res['id'];
    }

    public function validateTerms()
    {
        $this->assertAmount($this->invoice->first_total, (string)$this->res['price']);
        return true;
    }

}

class Am_Request_Bitpay
{
    private $plugin;
    private $method;
    private $param;
    private $mess;
    
    private $request;
    private $response;

    function __construct($plugin, $method, $param, $mess)
    {
        $this->plugin = $plugin;
        $this->method = $method;
        $this->param = $param;
        $this->mess = $mess;
        
        $this->_createRequest();
    }
    
    private function _createRequest()
    {
        $this->request  = new Am_HttpRequest();
        $this->request->setMethod($this->method);
        $this->request->setAuth($this->plugin->getConfig('apiKey'));
        if ($this->method == Am_HttpRequest::METHOD_POST)
        {
            $this->request->setUrl(Am_Paysystem_Bitpay::URL);
            $this->request->setHeader('content-type', 'application/json');
            $this->request->setBody($this->param);
        } else
        {
            $this->request->setUrl(Am_Paysystem_Bitpay::URL . $this->param);
        }
    }


    private function _sendRequest()
    {
        $response = $this->request->send();
        if ($response->getStatus() != '200')
        {
            Am_Di::getInstance()->errorLogTable->log("BitPay API Error. Request[{$this->mess}]. Status is not OK: {$response->getStatus()}. Params [{$this->param}]");
            throw new Am_Exception_InternalError();
        }
        $this->response = $response->getBody();
        if (!$this->response)
        {
            Am_Di::getInstance()->errorLogTable->log("BitPay API Error. Response[{$this->mess}] is NULL. Params [{$this->param}]");
            throw new Am_Exception_InternalError();
        }
        if ($this->plugin->getConfig('debugMode'))
            Am_Di::getInstance()->errorLogTable->log("BitPay-debug [{$this->mess}]. REQUEST: {$this->param}. RESPONSE: {$this->response}.");
    }
    
    function getResult()
    {
        $this->_sendRequest();
        return json_decode($this->response, true);
    }
}

