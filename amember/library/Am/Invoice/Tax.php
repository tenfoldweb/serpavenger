<?php

/**
 * Tax plugins storage
 * @package Am_Invoice 
 */
class Am_Plugins_Tax extends Am_Plugins
{
    // calculate tax
    /** @return array of calculators */
    function match(Invoice $invoice)
    {
        $di = $invoice->getDi();
        $ret = array();
        foreach ($this->getEnabled() as $id)
        {
            $obj = $this->get($id);
            $calcs = $obj->getCalculators($invoice);
            if ($calcs && !is_array($calcs)) 
                $calcs = array($calcs);
            if ($calcs)
                $ret = array_merge($ret, $calcs);
        }
        return $ret;
    }
}

/**
 * Abstract tax plugin
 * @package Am_Invoice 
 */
abstract class Am_Invoice_Tax extends Am_Pluggable_Base
{
    protected $_idPrefix = 'Am_Invoice_Tax_';
    protected $_configPrefix = 'tax.';
    
    function initForm(HTML_QuickForm2_Container $form) {}
    
    /**
     * @param Invoice $invoice 
     * @return double
     */
    function getRate(Invoice $invoice) {} 
    
    // get calculators
    function getCalculators(Invoice $invoice) 
    {
        $rate = $this->getRate($invoice);
        if ($rate > 0.0)
            return new Am_Invoice_Calc_Tax($this->getId(), $this->getConfig('title', $this->getTitle()), $rate);
    }
    protected function _beforeInitSetupForm()
    {
        $form = parent::_beforeInitSetupForm();
        $form->addText('title', array('class' => 'el-wide'))->setLabel(___('Tax Title'))->addRule('required');
        return $form;
    }
}

class Am_Invoice_Tax_GlobalTax extends Am_Invoice_Tax
{
    public function getTitle() { return ___("Global Tax"); }
    public function getRate(Invoice $invoice)
    {
        return $this->getConfig('rate');
    }
    protected function _initSetupForm(Am_Form_Setup $form)
    {
        $gr = $form->addGroup()->setLabel(___("Tax Rate\nfor example 18.5 (no percent sign)"));
        $gr->addText('rate', array('size'=>5));
        $gr->addStatic()->setContent(' %');
    }
}

class Am_Invoice_Tax_Regional extends Am_Invoice_Tax
{
    public function getTitle()
    {
        return ___("Regional Tax");
    }
    public function getCalculators(Invoice $invoice)
    {
        $user = $invoice->getUser();
        if (!$user) return;
        $rate = null;
        foreach ((array)$this->getConfig('rate') as $t){
            if (!empty($t['zip']))
                if (!$this->compareZip($t['zip'], $user->get('zip'))) 
                    continue; // no match
            if (!empty($t['state']) && ($t['state'] == $user->get('state')) && ($t['country'] == $user->get('country')))
            {
                $rate = $t['tax_value'];
                break;
            }
            if (!$t['state'] && !empty($t['country']) && ($t['country'] == $user->get('country')))
            {
                $rate = $t['tax_value'];
                break;
            }
        }
        if ($rate > 0)
            return new Am_Invoice_Calc_Tax($this->getId(), $this->getTitle(), $rate);
    }
    protected function compareZip($zipString, $zip)
    {
        $zip = trim($zip);
        foreach (preg_split('/[,;\s]+/', $zipString) as $s)
        {
            $s = trim($s);
            if (!strlen($s)) continue;
            if (strpos($s, '-'))
                list($range1, $range2) = explode('-', $s);
            else
                $range1 = $range2 = $s;
            if (($range1 <= $zip) && ($zip <= $range2))
            {
                return true;
            }
        }
        return false;
    }
    protected function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addElement(new Am_Form_Element_RegionalTaxes('rate'));
    }
}

class Am_Invoice_Tax_Vat extends Am_Invoice_Tax
{
    public function getTitle() { return ___("VAT"); }
    // will be transformed to code => title in constructor
    protected $countries = array(
        'AT', 'BE', 'BG', 'CY', 'HR', 'CZ', 'DE',
        'DK', 'EE', 'GR', 'ES', 'FI', 'FR',  // GR is known as EL for tax 
        'GB', 'HU', 'IE', 'IT', 'LT', 'LU', 
        'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 
        'SE', 'SK', 'SI'
    );
    protected $euCountries = array();
    public function __construct(Am_Di $di, array $config)
    {
        parent::__construct($di, $config);
        $countryList = $di->countryTable->getOptions();
        foreach ($this->countries as $k => $c)
        {
            unset($this->countries[$k]);
            $this->countries[$c] = $countryList[$c];
        }
    }
    public function getRate(Invoice $invoice)
    {
        $u = $invoice->getUser();
        $id = is_null($u) ? false : $u->get('tax_id');
        if ($id && $this->getConfig('extempt_if_vat_number'))
        {
            // if that is a foreign customer
            if (strtoupper(substr($this->getConfig('my_id'), 0, 2)) != strtoupper(substr($id, 0, 2)))
                return null;
        }
        $country = $id ? substr($id, 0, 2) : ( is_null($u) ? false : $u->get('country'));
        if (!$country) $country = $this->getConfig('my_country');
        if ($country == $this->getConfig('my_country'))
            return $this->getConfig('local_rate');
        if(!$this->getConfig('add_vat_outside_eu') && !array_key_exists(strtoupper($country), $this->countries))
            return null;
        return $this->getConfig('rate.'.strtoupper($country), $this->getConfig('local_rate'));
    }
    protected function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addSelect('my_country')
            ->setLabel(___('My Country'))
            ->loadOptions($this->countries)
            ->addRule('required');
        
        $form->addText('my_id')
            ->setLabel(___('VAT Id'))
            ->addRule('required');

        $gr = $form->addGroup()
            ->setLabel(___("Local VAT Rate\n" .
                "for example 18.5 (no percent sign)"));
        $gr->addText('local_rate', array('size' => 5, 'maxlength' => 5));
        $gr->addStatic()->setContent(' %');
        
        $form->addAdvCheckbox('extempt_if_vat_number')
            ->setLabel(___('Do not add VAT if a valid EU VAT Id entered by foreign customer'));

        $form->addAdvCheckbox('add_vat_outside_eu')
            ->setLabel(array(___('Add VAT even if customer is outside of EU'), ___('Locat VAT Rate will be used in order to calculate VAT')));
        
        $fs = $form->addGroup()->setLabel(array(___('Tax Rates for Other Countries'), ___('in case of it is different with Local VAT Rate')));

        foreach ($this->countries as $k => $v) {
            $fs->addText('rate.' . $k, array('class'=>'vat-rate'));
        }

        $rate = $fs->addElement(new Am_Form_Element_VatRate('rate'));
        foreach ($this->countries as $k => $v) {
            $val = $this->getConfig('rate.' . $k, $this->getConfig('local_rate', ''));
            $attr = array(
                'data-label'=> $v . sprintf(' <input style="padding:0" type="text" onChange = "$(this).closest(\'div\').find(\'input[type=hidden]\').val($(this).val())"  name="" size="4" value="%s" /> %%', $val),
                'data-value' => $val
            );
            $rate->addOption($v, $k, $attr);
        }

        $rate->setJsOptions('{
            getOptionName : function (name, option) {
                return name.replace(/\[\]$/, "") + "___" + option.value;
            },
            getOptionValue : function (option) {
                return $(option).data("value");
            }
        }');
        $rate->setValue(array_keys(array_filter($this->getConfig('rate', array()))));

        $form->addScript()
            ->setScript(<<<CUT
$('.vat-rate').hide();
$('.vat-rate').val('');
CUT
            );
    }
}

class Am_Form_Brick_VatId extends Am_Form_Brick
{
    protected $labels = array(
        'VAT Settings are incorrect - no Vat Id configured',
        'Invalid VAT Id, please try again',
        'Cannot validate VAT Id, please try again',
        'Invalid EU VAT Id format',
        'EU VAT Id (optional)',
        'Please enter EU VAT Id'
    );

    public function initConfigForm(Am_Form $form)
    {
        $form->addAdvCheckbox('dont_validate')->setLabel(___('Disable online VAT Id Validation'));
        $form->addAdvCheckbox('required')->setLabel(___('Required'));
    }
    public function insertBrick(HTML_QuickForm2_Container $form)
    {
        $el = $form->addText('tax_id')->setLabel($this->___("EU VAT Id (optional)"))
            ->addRule('regex', $this->___('Invalid EU VAT Id format'), '/^[A-Za-z]{2}[a-zA-Z0-9\s]+$/');
        if (!$this->getConfig('dont_validate'))
            $el->addRule('callback2', '-error-', array($this, 'validate'));
        if ($this->getConfig('required'))
            $el->addRule('required', $this->___("Please enter EU VAT Id"));
        
    }
    public function validate($id)
    {
        
        if (!$id) return; //skip validation in case of VAT was not supplied

        $me = Am_Di::getInstance()->config->get('tax.vat.my_id');
        if (!$me) return $this->___('VAT Settings are incorrect - no Vat Id configured');
        
        // check if response is cached
        $cacheKey = 'vat_check_' 
            . preg_replace('/[^A-Z0-9a-z_]/', '_', $me) 
            . '_' . preg_replace('/[^A-Z0-9a-z_]/', '_', $id);
        if (($ret = Am_Di::getInstance()->cache->load($cacheKey)) !== false)
            return $ret === 1 ? null : $this->___('Invalid VAT Id, please try again');
        
        if (!strlen($id)) 
                return $this->___('Invalid VAT Id, please try again');
        $req = new Am_HttpRequest('http://ec.europa.eu/taxation_customs/vies/vatResponse.html', Am_HttpRequest::METHOD_POST);
        $req->addPostParameter('action', 'check')
            ->addPostParameter('check', 'Verify')
            ->addPostParameter('memberStateCode', strtoupper(substr($id, 0, 2)))
            ->addPostParameter('number', substr($id, 2));
        try {
            $resp = $req->send();
            $ok = preg_match('/Yes[,\s]+valid\s+VAT\s+number/i', $resp->getBody());
            Am_Di::getInstance()->cache->save($ok ? 1 : 0, $cacheKey);
            if (!$ok)
                return $this->___('Invalid VAT Id, please try again');
        } catch (Exception $e) {
            Am_Di::getInstance()->errorLogTable->log($e);
            return $this->___("Cannot validate VAT Id, please try again");
        }
        
    }
    public function isAcceptableForForm(Am_Form_Bricked $form)
    {
        return $form instanceof Am_Form_Signup || $form instanceof Am_Form_Profile;
    }
}

class Am_Invoice_Tax_Gst extends Am_Invoice_Tax
{
    public function getTitle()
    {
        return ___("GST (Inclusive Tax)");
    }
    public function getCalculators(Invoice $invoice)
    {
        $user = $invoice->getUser();
        if (!$user) return;
        $rate = null;
        foreach ((array)$this->getConfig('rate') as $t){
            if (!empty($t['zip']))
                if (!$this->compareZip($t['zip'], $user->get('zip'))) 
                    continue; // no match
            if (!empty($t['state']) && ($t['state'] == $user->get('state')) && ($t['country'] == $user->get('country')))
            {
                $rate = $t['tax_value'];
                break;
            }
            if (!$t['state'] && !empty($t['country']) && ($t['country'] == $user->get('country')))
            {
                $rate = $t['tax_value'];
                break;
            }
        }
        if ($rate > 0)
        {
            $id = $this->getId();
            $title = $this->getTitle();
            $this->getDi()->hook->add(Am_Event::INVOICE_GET_CALCULATORS, 
                create_function('$event', "\$event->insertAfter(new Am_Invoice_Calc_Tax_Gst('$id', '$title', $rate),\$event->findByClassName('Am_Invoice_Calc_Total'));"));
        }
    }
    protected function compareZip($zipString, $zip)
    {
        $zip = trim($zip);
        foreach (preg_split('/[,;\s]+/', $zipString) as $s)
        {
            $s = trim($s);
            if (!strlen($s)) continue;
            if (strpos($s, '-'))
                list($range1, $range2) = explode('-', $s);
            else
                $range1 = $range2 = $s;
            if (($range1 <= $zip) && ($zip <= $range2))
            {
                return true;
            }
        }
        return false;
    }
    protected function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addElement(new Am_Form_Element_RegionalTaxes('rate'));
    }
}
