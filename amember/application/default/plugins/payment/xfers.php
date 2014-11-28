<?php
/**
 * @table paysystems
 * @id xfers
 * @title Xfers
 * @visible_link https://www.xfers.io/
 * @recurring none
 * @country SG
 */
class Am_Paysystem_Xfers extends Am_Paysystem_Abstract
{
    const PLUGIN_STATUS = self::STATUS_BETA;
    const PLUGIN_REVISION = '4.4.2';

    protected $defaultTitle = 'Xfers';
    protected $defaultDescription = 'Pay by credit card card';

    const LIVE_DOMAIN = 'www.xfers.io';
    const SANDBOX_DOMAIN = 'sandbox.xfers.io';

    public function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText("api_key", array('class' => 'el-wide'))
            ->setLabel('Merchant API Key');
        $form->addPassword("api_secret", array('class' => 'el-wide'))
            ->setLabel('Merchant API Secret');
        $form->addAdvCheckbox("testing")
            ->setLabel("Is it a Sandbox (Testing) Account?");
        $form->addAdvCheckbox("dont_verify")
            ->setLabel(
                "Disable IPN verification\n" .
                "<b>Usually you DO NOT NEED to enable this option.</b>
            However, on some webhostings PHP scripts are not allowed to contact external
            web sites. It breaks functionality of the Xrefs payment integration plugin,
            and aMember Pro then is unable to contact Xrefs to verify that incoming
            IPN post is genuine. In this case, AS TEMPORARY SOLUTION, you can enable
            this option to don't contact Xrefs server for verification. However,
            in this case \"hackers\" can signup on your site without actual payment.
            So if you have enabled this option, contact your webhost and ask them to
            open outgoing connections to www.xfers.io port 80 ASAP, then disable
            this option to make your site secure again.");
    }

    public function _process(Invoice $invoice, Am_Request $request, Am_Paysystem_Result $result)
    {
        $u = $invoice->getUser();
        $domain = $this->getConfig('testing') ? Am_Paysystem_Xfers::SANDBOX_DOMAIN : Am_Paysystem_Xfers::LIVE_DOMAIN;
        $a = new Am_Paysystem_Action_Form('https://' . $domain . '/api/v2/payments');
        $a->api_key = $this->getConfig('api_key');
        $a->order_id = $invoice->public_id;
        $a->cancel_url = $this->getCancelUrl();
        $a->return_url = $this->getReturnUrl();
        $a->notify_url = $this->getPluginUrl('ipn');
        if ($invoice->first_tax) {
            $a->tax = $invoice->first_tax;
        }
        /* @var $item InvoiceItem */
        $i = 1;
        foreach ($invoice->getItems() as $item) {
            $a->{'item_name_' . $i} = $item->item_title;
            $a->{'item_description_' . $i} = $item->item_description;
            $a->{'item_quantity_' . $i} = $item->qty;
            $a->{'item_price_' . $i} = $item->first_price;
            $i++;
        }
        $a->total_amount = $invoice->first_total;
        $a->currency = $invoice->currency;
        $a->user_email = $invoice->getUser()->email;
        $a->signature = sha1($a->api_key . $this->getConfig('api_secret') . $a->order_id . $a->total_amount . $a->currency);
        $result->setAction($a);
    }

    public function createTransaction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_Xfers($this, $request, $response, $invokeArgs);
    }

    public function getRecurringType()
    {
        return self::REPORTS_NOT_RECURRING;
    }

    public function getSupportedCurrencies()
    {
        return array('SGD');
    }

}

class Am_Paysystem_Transaction_Xfers extends Am_Paysystem_Transaction_Incoming
{
    const STATUS_CANCELED = 'cancelled';
    const STATUS_PAID = 'paid';
    const STATUS_EXPIRED = 'expired';

    public function findInvoiceId()
    {
        return $this->request->getFiltered('order_id');
    }

    public function getUniqId()
    {
        return $this->request->getFiltered('txn_id');
    }

    public function validateSource()
    {
        // validate if that is genuine POST coming from Xfers
        if (!$this->plugin->getConfig('dont_verify')) {
            $req = $this->plugin->createHttpRequest();

            $domain = $this->plugin->getConfig('testing') ? Am_Paysystem_Xfers::SANDBOX_DOMAIN : Am_Paysystem_Xfers::LIVE_DOMAIN;
            $req->setConfig('ssl_verify_peer', false);
            $req->setConfig('ssl_verify_host', false);
            $req->setUrl('https://' . $domain . '/api/v2/payments/validate');
            foreach ($this->request->getRequestOnlyParams() as $key => $value)
                $req->addPostParameter($key, $value);
            $req->setMethod(Am_HttpRequest::METHOD_POST);
            $resp = $req->send();
            if ($resp->getStatus() != 200 || $resp->getBody() !== "VERIFIED")
                throw new Am_Exception_Paysystem("Wrong IPN received, Xrefs answers: " . $resp->getBody() . '=' . $resp->getStatus());
        }
        return $this->request->getFiltered('api_key') == $this->getPlugin()->getConfig('api_key');
    }

    public function validateStatus()
    {
        return $this->request->getFiltered('status') == self::STATUS_PAID;
    }

    public function validateTerms()
    {
        return $this->request->get('total_amount') == $this->invoice->first_total &&
        $this->request->get('currency') == $this->invoice->currency;
    }

}