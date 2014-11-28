<?php

/**
 * @table paysystems
 * @id ccavenue
 * @title ccavenue
 * @visible_link http://www.ccavenue.com/
 * @recurring none
 */
class Am_Paysystem_Ccavenue extends Am_Paysystem_Abstract
{

    const PLUGIN_STATUS = self::STATUS_BETA;
    const PLUGIN_REVISION = '4.4.2';
    const LIVE_URL = 'https://www.ccavenue.com/shopzone/cc_details.jsp';

    protected $defaultTitle = 'CCAvenue';
    protected $defaultDescription = 'Pay by credit card / Debit Card / Net Banking';

    public function getSupportedCurrencies()
    {
        return array('INR');
    }

    function adler32($adler, $str)
    {
        $BASE = 65521;

        $s1 = $adler & 0xffff;
        $s2 = ($adler >> 16) & 0xffff;
        for ($i = 0; $i < strlen($str); $i++)
        {
            $s1 = ($s1 + Ord($str[$i])) % $BASE;
            $s2 = ($s2 + $s1) % $BASE;
        }
        return $this->leftshift($s2, 16) + $s1;
    }

	function getChecksum($MerchantId, $OrderId, $Amount, $redirectUrl, $WorkingKey)  {
		$str = "$MerchantId|$OrderId|$Amount|$redirectUrl|$WorkingKey";
		$adler = 1;
		$adler = $this->adler32($adler,$str);
		return $adler;
	}

    function leftshift($str, $num)
    {

        $str = DecBin($str);

        for ($i = 0; $i < (64 - strlen($str)); $i++)
            $str = "0" . $str;

        for ($i = 0; $i < $num; $i++)
        {
            $str = $str . "0";
            $str = substr($str, 1);
        }
        return $this->cdec($str);
    }

    function cdec($num)
    {
        $dec = 0;
        for ($n = 0; $n < strlen($num); $n++)
        {
            $temp = $num[$n];
            $dec = $dec + $temp * pow(2, strlen($num) - $n - 1);
        }

        return $dec;
    }

    public function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText('account_id')->setLabel(array('Merchant Account Id'));
        $form->addText('secret')->setLabel(array('Merchant Secret Key'));
        $form->addText('java_path')->setLabel(array('Unix path to java binary', 'for ex. java or /usr/bin/java'));
        $form->setDefault('java_path', 'java');
    }

    public function _process(Invoice $invoice, Am_Request $request, Am_Paysystem_Result $result)
    {
        $u = $invoice->getUser();
        $a = new Am_Paysystem_Action_Form(self::LIVE_URL);
        $vars = array(
            'Merchant_Id' => $this->getConfig('account_id'),
            'Order_Id' => $invoice->public_id,
            'Amount' => $invoice->first_total,
            'Redirect_Url' => $this->getPluginUrl('thanks'),
            'billing_cust_name' => $u->name_f . ' ' . $u->name_l,
            'billing_cust_address' => $u->street,
            'billing_cust_city' => $u->city,
            'billing_cust_state' => substr($u->state, -2),
            'billing_zip_code' => $u->zip,
            'billing_cust_country' => $u->country,
            'billing_cust_tel' => $u->phone,
            'billing_cust_email' => $u->email,
            'Currency' => $invoice->currency,
            'TxnType' => 'A',
            'actionID' => 'TXN',
            'billing_cust_notes' => $invoice->getLineDescription(),
        );
        $query = '';
        foreach($vars as $k => $v)
            $query.="$k=$v&";
        $query.='Checksum='.$this->getChecksum($this->getConfig('account_id'), $invoice->public_id, $invoice->first_total, $this->getPluginUrl('thanks'), $this->getConfig('secret'));
        exec($ex = $this->getConfig('java_path', 'java') . ' -jar ' . dirname(__FILE__) . '/ccavutil.jar ' . $this->getConfig('secret') . ' "' . $query . '" enc', $output);
        $a->encRequest = $output[0];
        $a->Merchant_Id = $this->getConfig('account_id');
        $result->setAction($a);
    }

    public function createTransaction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        
    }

    public function createThanksTransaction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_Ccavenue($this, $request, $response, $invokeArgs);
    }

    public function getRecurringType()
    {
        return self::REPORTS_NOT_RECURRING;
    }

}

class Am_Paysystem_Transaction_Ccavenue extends Am_Paysystem_Transaction_Incoming
{

    public function validateSource()
    {
        //cid and encResponse
        exec($ex = $this->plugin->getConfig('java_path', 'java').' -jar '.dirname(__FILE__).'/ccavutil.jar '.$this->plugin->getConfig('secret').' "'.$this->request->get('encResponse').'" dec', $ccaResponse);
        parse_str($ccaResponse[0], $vars);
        $this->vars = $vars;
        $Checksum = $this->plugin->getChecksum($this->plugin->getConfig('account_id'), $vars['Order_Id'], $vars['Amount'], $vars['AuthDesc'], $this->plugin->getConfig('secret'), $vars['Checksum']);
        return $Checksum == $vars['Checksum'];
    }

    function findInvoiceId()
    {
        return $this->vars["Order_Id"];
    }

    public function getUniqId()
    {
        return $this->vars["nb_order_no"];
    }

    public function validateStatus()
    {
        return $this->vars["AuthDesc"] === "Y";
    }

    public function validateTerms()
    {
        return doubleval($this->vars["Amount"]) == $this->invoice->first_total;
    }

}