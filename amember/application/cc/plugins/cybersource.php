<?php
/**
 * @table paysystems
 * @id Cybersource
 * @title Cybersource
 * @visible_link http://Cybersourcepayments.com/
 * @recurring cc
 * @logo_url Cybersource.png
 * @adult 1
 */
class Am_Paysystem_Cybersource extends Am_Paysystem_CreditCard
{
    const PLUGIN_STATUS = self::STATUS_BETA;
    const PLUGIN_DATE = '$Date$';
    const PLUGIN_REVISION = '4.4.2';

    const URL_LIVE = 'https://ics2ws.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.90.wsdl';
    const URL_TEST = "https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.90.wsdl";

    protected $defaultTitle = "CyberSource";
    protected $defaultDescription = "accepts all major credit cards";

    public function getRecurringType()
    {
        return self::REPORTS_CRONREBILL;
    }
    
    public function isConfigured()
    {
        return strlen($this->getConfig('merchant_id')) && strlen($this->getConfig('transaction_key'));
    }

    public function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText("merchant_id")->setLabel(array('CyberSource Merchant ID',
            ''))
            ->addRule('required');

        $form->addText("transaction_key", array('size' => 80))->setLabel(array('CyberSource SOAP API Security Transaction Key',
            ''))
            ->addRule('required');

        $form->addAdvCheckbox("test_mode")
            ->setLabel("Test Mode Enabled");
    }

    public function _doBill(Invoice $invoice, $doFirst, CcRecord $cc, Am_Paysystem_Result $result)
    {
        $user = $invoice->getUser();

        $soapData = new stdClass();
        $soapData->merchantID = $this->getConfig('merchant_id');
        $soapData->merchantReferenceCode = $invoice->public_id . '/' . $invoice->getLineDescription();

        $soapData->clientLibrary = 'aMember';
        $soapData->clientLibraryVersion = '4.x';
        $soapData->clientEnvironment = php_uname();

        $soapData->customerID = $user->pk();
        $soapData->customerFirstName = $user->name_f;
        $soapData->customerLastName = $user->name_l;

        $billTo = new stdClass();
        $billTo->firstName = $cc->cc_name_f ? $cc->cc_name_f : $user->name_f;
        $billTo->lastName = $cc->cc_name_l ? $cc->cc_name_l : $user->name_l;
        $billTo->street1 = $cc->cc_street ? $cc->cc_street : $user->street;
        $billTo->city = $cc->cc_city ? $cc->cc_city : $user->city;
        $billTo->state = $cc->cc_state ? $cc->cc_state : $user->state;
        $billTo->postalCode = $cc->cc_zip ? $cc->cc_zip : $user->zip;
        $billTo->country = $cc->cc_country ? $cc->cc_country : $user->country;
        $billTo->email = $user->email;
        $billTo->ipAddress = $this->getDi()->request->getClientIp();
        $soapData->billTo = $billTo;

        $card = new stdClass();
        $card->accountNumber = $cc->cc_number;
        $card->expirationMonth = substr($cc->cc_expire, 0, 2);
        $card->expirationYear = 2000 + substr($cc->cc_expire, 2, 2);
        $card->cvNumber = $cc->getCvv();
        $soapData->card = $card;

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = $invoice->currency;
        $soapData->purchaseTotals = $purchaseTotals;

        $soapData->item = array();
        $id = 0;
        foreach ($invoice->getItems() as $item)
        {
            $itm = new stdClass();
            $itm->unitPrice = $doFirst ? ( (float)$invoice->first_total ? $item->first_total : 1.00 ) : $item->second_total;
            $itm->quantity = $item->qty;
            $itm->id = $id++;

            $soapData->item[] = $itm;
        }

        if ($doFirst && !(float)$invoice->first_total) // first & free
        {
            $ccAuthService = new stdClass();
            $ccAuthService->run = "true";
            $soapData->ccAuthService = $ccAuthService;

            $trAuth = new Am_Paysystem_Transaction_CreditCard_Cybersource_Auth($this, $invoice, $doFirst, $soapData);
            $trAuth->run($result);

            $requestId = $trAuth->getRequestId();
            $requestToken = $trAuth->getToken();
            if (!$requestId || !$requestToken)
            {
                return $result->setFailed(array("CyberSource Plugin: Bad auth response."));
            }

            $soapData->ccAuthService = null;
            $ccAuthReversalService = new stdClass();
            $ccAuthReversalService->authRequestID = $requestId;
            $ccAuthReversalService->authRequestToken = $requestToken;
            $ccAuthReversalService->run = "true";
            $soapData->ccAuthReversalService = $ccAuthReversalService;

            $trVoid = new Am_Paysystem_Transaction_CreditCard_Cybersource_Auth($this, $invoice, $doFirst, $soapData);
            $trVoid->run($result);

            $trFree = new Am_Paysystem_Transaction_Free($this);
            $trFree->setInvoice($invoice);
            $trFree->process();
            $result->setSuccess($trFree);

        } else
        {
            $ccCreditService = new stdClass();
            $ccCreditService->run = "true";
            $soapData->ccCreditService = $ccCreditService;

            $tr = new Am_Paysystem_Transaction_CreditCard_Cybersource($this, $invoice, $doFirst, $soapData);
            $tr->run($result);
        }
    }

    public function getReadme()
    {
        return <<<CUT
        CyberSource payment plugin configuration

This plugin allows you to use CyberSource for payment.
To configure the plugin:

 - register for an account at <a href='http://www.cybersource.com/register'>http://www.cybersource.com/register</a>
 - generate SOAP API Security Keys by this insctruction <a href='http://www.cybersource.com/support_center/implementation/downloads/soap_api/SOAP_toolkits.pdf'>http://www.cybersource.com/support_center/implementation/downloads/soap_api/SOAP_toolkits.pdf</a>, paragraph 'Transaction Key'
 - copy all text of just created key and paste it at 'CyberSource SOAP API Security Transaction Key' plugin option (this page)
 - fill 'CyberSource Merchant ID' option (this page)
 - click "Save"

CyberSource plugin requires at least these php-extensions:SOAP, OpenSSL and libxml.
For configuring your web-server read instruction <a href='http://www.cybersource.com/support_center/implementation/downloads/soap_api/SOAP_toolkits.pdf'>http://www.cybersource.com/support_center/implementation/downloads/soap_api/SOAP_toolkits.pdf</a>, paragraph 'Preparing your PHP Installation'.

<strong>ATTENTION:</strong>
    SOAP API Security Keys for test and live account are <strong>diffrent</strong> always.

CUT;
    }
}

class Am_Paysystem_Transaction_CreditCard_Cybersource extends Am_Paysystem_Transaction_CreditCard
{
    protected $soapData;

    function __construct(Am_Paysystem_Abstract $plugin, Invoice $invoice, $doFirst, $soapData)
    {
        $this->soapData = $soapData;
        parent::__construct($plugin, $invoice, new Am_Request(), $doFirst);
    }

    public function validate()
    {
        if ($this->vars->reasonCode != 100)
        {
            $this->result->setFailed($this->vars->reasonCode . ' - ' . $this->vars->decision);
            return;
        }
        $this->result->setSuccess();
    }

    public function parseResponse()
    {
        $this->vars = json_decode(json_encode($this->response));;
        return $this->vars;
    }

    public function getUniqId()
    {
        return $this->vars->ccCreditReply->reconciliationID;
    }

    public function getRequestId()
    {
        return $this->vars->requestID;
    }

    public function getToken()
    {
        return $this->vars->requestToken;
    }

    public function validateResponseStatus(Am_Paysystem_Result $result)
    {
        if (empty($this->response))
        {
            $result->setErrorMessages(array("Received empty response from payment server"));
            return false;
        }
        return true;
    }

    public function run(Am_Paysystem_Result $result)
    {
        $this->result = $result;
        $log = $this->getInvoiceLog();

        try {
            $soapClient = new SoapClient_Cybersource($this->getPlugin());
        } catch (Exception $ex)
        {
            throw new Am_Exception_InternalError("Cannot create soapclient object: " . $ex->getMessage());
        }
        $soapResult = $soapClient->runTransaction($this->soapData);
        $this->response = json_decode(json_encode($soapResult), true);

        $log->add($this->response);
        $this->validateResponseStatus($this->result);
        if ($this->result->isFailure())
            return;
        try {
            $this->parseResponse();
            $this->validate();
            if ($this->result->isSuccess())
                $this->processValidated();
        } catch (Exception $e) {
            if ($e instanceof PHPUnit_Framework_Error)
                throw $e;
            if ($e instanceof PHPUnit_Framework_Asser )
                throw $e;
            if (!$result->isFailure())
                $result->setFailed(___("Payment failed"));
            $log->add($e);
        }
    }
}

class Am_Paysystem_Transaction_CreditCard_Cybersource_Auth extends Am_Paysystem_Transaction_CreditCard_Cybersource
{
    public function processValidated(){} // no process payment
}

class SoapClient_Cybersource extends SoapClient
{
    protected $merchantId;
    protected $transactionKey;

    function __construct($plugin)
    {
        $this->merchantId = $plugin->getConfig('merchant_id');
        $this->transactionKey = $plugin->getConfig('transaction_key');
        parent::__construct(($plugin->getConfig('test_mode')) ? Am_Paysystem_Cybersource::URL_TEST : Am_Paysystem_Cybersource::URL_LIVE);
    }

    function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        $soapHeader = "<SOAP-ENV:Header xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\"><wsse:Security SOAP-ENV:mustUnderstand=\"1\"><wsse:UsernameToken><wsse:Username>{$this->merchantId}</wsse:Username><wsse:Password Type=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText\">{$this->transactionKey}</wsse:Password></wsse:UsernameToken></wsse:Security></SOAP-ENV:Header>";

        $requestDOM = new DOMDocument('1.0');
        $soapHeaderDOM = new DOMDocument('1.0');

        try
        {
            $requestDOM->loadXML($request);
            $soapHeaderDOM->loadXML($soapHeader);

            $node = $requestDOM->importNode($soapHeaderDOM->firstChild, true);
            $requestDOM->firstChild->insertBefore($node, $requestDOM->firstChild->firstChild);
            $request = $requestDOM->saveXML();
        } catch (DOMException $e)
        {
            throw new Am_Exception_InternalError("Error adding UsernameToken: " . $e->getMessage());
        }

        return parent::__doRequest($request, $location, $action, $version, $one_way);
    }
}
