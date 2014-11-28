<?php
/**
 * @table paysystems
 * @id blockchain
 * @title Blockchain
 * @visible_link https://blockchain.info
 * @recurring none
 */
class Am_Paysystem_Blockchain extends Am_Paysystem_Abstract
{

    const PLUGIN_STATUS = self::STATUS_PRODUCTION;
    const PLUGIN_REVISION = '4.4.2';
    const LIVE_URL = 'https://blockchain.info/api/receive';
    const CURRENCY_URL = 'https://blockchain.info/tobtc';
    const BLOCKHAIN_AMOUNT = 'blockhain_amount';

    protected $defaultTitle = "Blockchain";
    protected $defaultDescription = "accepts bitcoins";

    public function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText('address', array('size' => 40))->setLabel('Your Receiving Bitcoin Address');
    }

    public function _process(Invoice $invoice, Am_Request $request, Am_Paysystem_Result $result)
    {
        $req = new Am_HttpRequest(self::LIVE_URL, Am_HttpRequest::METHOD_POST);
        $req->addPostParameter(array(
            'method' => 'create',
            'address' => $this->getConfig('address'),
            'callback' => $this->getPluginUrl('ipn') . "?secret=" . $invoice->getSecureId('THANKS') . '&invoice_id=' . $invoice->public_id,
        ));
        $res = $req->send();
        $arr = (array) json_decode($res->getBody(), true);
        if (empty($arr['input_address']))
        {
            throw new Am_Exception_InternalError($res->getBody());
        }
        $req = new Am_HttpRequest(self::CURRENCY_URL . "?currency={$invoice->currency}&value={$invoice->first_total}", Am_HttpRequest::METHOD_GET);
        $res = $req->send();
        $amount = $res->getBody();
        if (doubleval($amount) <= 0)
        {
            throw new Am_Exception_InternalError($amount);
        }
        $invoice->data()->set(self::BLOCKHAIN_AMOUNT, doubleval($amount))->update();

        $a = new Am_Paysystem_Action_HtmlTemplate_Blockchain($this->getDir(), 'confirm.phtml');
        $a->amount = doubleval($amount);
        $a->input_address = $arr['input_address'];
        $a->invoice = $invoice;
        $result->setAction($a);
    }
    
    public function directAction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        try{
            parent::directAction($request, $response, $invokeArgs);
        }
        catch(Exception $e)
        {
            $this->getDi()->errorLogTable->logException($e);
        }
        //in other case blockchain will send IPN's once per minute
        echo 'ok';
    }

    public function createTransaction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        return new Am_Paysystem_Blockchain_Transaction($this, $request, $response, $invokeArgs);
    }

    public function getRecurringType()
    {
        return self::REPORTS_NOT_RECURRING;
    }

    public function getSupportedCurrencies()
    {
        return array('USD', 'CNY', 'JPY', 'SGD', 'HKD', 'CAD', 'AUD', 'NZD', 'GBP', 'DKK', 'SEK', 'BRL', 'CHF', 'EUR', 'RUB', 'SLL');
    }

}

class Am_Paysystem_Blockchain_Transaction extends Am_Paysystem_Transaction_Incoming
{

    public function getUniqId()
    {
        return $this->request->getFiltered('transaction_hash');
    }

    public function validateSource()
    {
        return $this->request->getFiltered('secret') == $this->invoice->getSecureId('THANKS');
    }

    public function validateStatus()
    {
        return !$this->request->get('test');
    }

    public function validateTerms()
    {
        return doubleval($this->invoice->data()->get(Am_Paysystem_Blockchain::BLOCKHAIN_AMOUNT)) == doubleval($this->request->get('value') / 100000000);
    }

    public function findInvoiceId()
    {
        return $this->request->getFiltered('invoice_id');
    }

    public function validate()
    {
        $this->autoCreate();
        if (!$this->validateSource())
            throw new Am_Exception_Paysystem_TransactionSource("IPN seems to be received from unknown source, not from the paysystem");
        if (empty($this->invoice->_autoCreated) && !$this->validateTerms())
            throw new Am_Exception_Paysystem_TransactionInvalid("Subscriptions terms in the IPN does not match subscription terms in our Invoice");
        if (!$this->validateStatus())
            throw new Am_Exception_Paysystem_TransactionInvalid("Payment status is invalid, this IPN is not regarding a completed payment");
    }
    
}

class Am_Paysystem_Action_HtmlTemplate_Blockchain extends Am_Paysystem_Action_HtmlTemplate
{

    protected $_template;
    protected $_path;

    public function __construct($path, $template)
    {
        $this->_template = $template;
        $this->_path = $path;
    }

    public function process(Am_Controller $action = null)
    {
        $action->view->addBasePath($this->_path);

        $action->view->assign($this->getVars());
        $action->renderScript($this->_template);

        throw new Am_Exception_Redirect;
    }

}
