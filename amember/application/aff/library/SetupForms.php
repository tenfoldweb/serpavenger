<?php

class Am_Form_Setup_Aff extends Am_Form_Setup
{
    function __construct()
    {
        parent::__construct('aff');
        $this->setTitle(___('Affiliates'));
        $this->data['help-id'] = 'Setup/Affiliates';
    }
    function initElements()
    {
         $this->addSelect('aff.signup_type', null, array('help-id' => '#Affiliate_Options'))
             ->setLabel(___("Affiliates Signup Type"))
             ->loadOptions(
                 array (
                   '' => ___('Default - user clicks a link to become affiliate'),
                   1 => ___('All new users automatically become affiliates'),
                   2 => ___('Only admin can enable user as an affiliate'),
                 )
         );

         $this->addElement('email_checkbox', 'aff.registration_mail')
             ->setLabel(___("Affiliate Registration E-Mail"));

         $this->setDefault('aff.cookie_lifetime', 365);
         $this->addInteger('aff.cookie_lifetime', null, array('help-id' => '#Affiliate_Options'))
             ->setLabel(___("Affiliate Cookie Lifetime\n" .
                 "days to store cookies about referred affiliate"));

         $this->addInteger('aff.commission_days')
             ->setLabel(___("User-Affiliate Relation Lifetime\n".
                 "how long (in days) calculate commission for referred affiliate (default: 0 - forever)"));

         $this->setDefault('aff.commission_days', 0);

         $fs = $this->addFieldset()
             ->setLabel(___('Payout'))
             ->setId('payout');

         $fs->addHtml(null, array('class'=>'no-label'))
             ->setHtml(___('aMember generate payout reports automatically according your settings below. ' .
                 'Then you can use these reports to make real payout. You can find list of payout reports %shere%s. ' .
                 'User without defined valid payout method will not be included to payout report until he fill payout ' .
                 'method in member area.',
                 '<a class="link" href="' . REL_ROOT_URL . '/aff/admin-payout">', '</a>'));

         $el = $fs->addMagicSelect('aff.payout_methods', array (
           'multiple' => 'multiple'), array('help-id' => '#Accepted_Payout_methods'))
                ->setLabel(___('Accepted Payout Methods'))
                ->loadOptions(Am_Aff_PayoutMethod::getAvailableOptions());

         $el = $fs->addSelect('aff.payout_day', null, array('help-id' => '#Affiliate_Payout_Options'))
            ->setLabel(___("Affiliates Payout Day\n".
                "choose a day of month when payout is generated"));
             for ($i=1;$i<=28;$i++)
                $el->addOption(___("%d-th day", $i), $i . 'd');
             $wd = Zend_Registry::get('Am_Locale')->getWeekdayNames();
             for ($i=0;$i<7;$i++) {
                $el->addOption(___('Every %s', $wd[$i]), $i.'w');
             }

         $fs->addElement('email_link', 'aff.new_payouts')
             ->setLabel(___('New Affiliate Payout to Admin'));

         $fs->addInteger('aff.payout_min', array('placeholder'=>___('Unlimited')), array('help-id' => '#Affiliate_Payout_Options'))
            ->setLabel(array(___('Minimum Payout'),
                ___('minimal commission amount earned by affiliate to include it to payout report')));

//         $el = $this->addElement('select', 'aff.payout_delay')
//            ->setLabel(___('Delay Payout'));
//         $el->addOption('Display commissions to affilate immediately, but delay actual payout (default)', 0);
//         //$el->addOption('Delay payouts, and hide commissions from affiliates until it becomes payable', 1);
//         $el->addOption('Do not delay payouts (not recommended, high risk of fraud)', 2);

         $fs->addInteger('aff.payout_delay_days', null, array('help-id' => '#Affiliate_Payout_Options'))
            ->setLabel(array(___('Delay Payout (days)'),
                ___('number of days that should go through before commision is included to payout report')));

         $this->setDefault('aff.payout_delay_days', 30);

         $fs->addElement('email_checkbox', 'aff.notify_payout_empty')
            ->setLabel(array(___('Empty Payout Method Notification to User'),
                 ___("send email to user in case he has commission but did not define payout method yet.\n" .
                     'This email will be sent only once.')));

         $fs->addElement('email_checkbox', 'aff.notify_payout_paid')
             ->setLabel(___("Affiliate Payout Paid Notification to User\n" .
                 "send email to user when his payout is marked as paid"));

         $fs = $this->addFieldset()
             ->setLabel(___('Commission'));

         $gr = $fs->addGroup('', array('id' => 'commission'), array('help-id' => '#Affiliate_Payout_Options'))->setLabel(___('Default Commission'));
         $gr->addStatic()->setContent('<div>');
         if (Am_Di::getInstance()->affCommissionRuleTable->hasCustomRules())
         {
             $gr->addStatic()->setContent(
                 ___('Custom Commission Rules added') . ' ');
         } else {
             $rule = Am_Di::getInstance()->affCommissionRuleTable->findFirstBy(array(
                 'type' => AffCommissionRule::TYPE_GLOBAL,
                 'tier' =>0));
             $gr->addStatic()->setContent(___('First Payment (calculated for first payment in each invoice)') . ' ');
             $first = $gr->addElement(new Am_Form_Element_AffCommissionSize('aff_comm[first]', null, 'first_payment'));
             $gr->addStatic()->setContent(' ' . ___('Rebill') . ' ');
             $second = $gr->addElement(new Am_Form_Element_AffCommissionSize('aff_comm[recurring]', null, 'recurring'));
             $gr->addStatic()->setContent(
                 ' ' . ___('or') . ' ');
             if ($rule && !$this->isSubmitted())
             {
                 $first->getElementById('first_payment_c-0')->setValue($rule->first_payment_c);
                 $first->getElementById('first_payment_t-0')->setValue($rule->first_payment_t);
                 $second->getElementById('recurring_c-0')->setValue($rule->recurring_c);
                 $second->getElementById('recurring_t-0')->setValue($rule->recurring_t);
             }
         }
         $gr->addStatic()->setContent(
             '<a class="link" href="'.REL_ROOT_URL.'/aff/admin-commission-rule">'
             . ___('Edit Custom Commission Rules')
             . '</a>'
         );
         $gr->addStatic()->setContent('</div>');

         $fs->addAdvCheckbox('aff.commission_include_tax')
            ->setLabel(___("Calculate Affiliate Commissions from Totals Including Tax\n".
                "by default commission calculated from amounts before tax"));

         $fs->addElement('email_checkbox', 'aff.mail_sale_admin', null, array('help-id' => '#Setting_Up_Commission_Notification_Emails'))
             ->setLabel(___("E-Mail Commission to Admin"));

         $fs->addElement('email_checkbox', 'aff.mail_sale_user', null, array('help-id' => '#Setting_Up_Commission_Notification_Emails'))
             ->setLabel(___('E-Mail Commission to Affiliate'));

         $fs = $this->addFieldset()
             ->setLabel(___('Miscellaneous'));

         $this->addAdvCheckbox('aff.affiliate_can_view_details', null, array('help-id' => '#Affiliate_Payout_Options'))
            ->setLabel(array(___('Affiliate Can View Sales Details'),
                ___('Leave this checkbox unselected to restrict affiliates from seeing their sales details')));
         
         $this->addSelect('aff.custom_redirect')
            ->setLabel(___("Allow Affiliates to redirect Referrers to any url"))
            ->loadOptions(
                array(
                    Bootstrap_Aff::AFF_CUSTOM_REDIRECT_DISABLED => ___('Disabled'),
                    Bootstrap_Aff::AFF_CUSTOM_REDIRECT_ALLOW_SOME_DENY_OTHERS => ___('Allow for some affiliates, disallow for others'),
                    Bootstrap_Aff::AFF_CUSTOM_REDIRECT_DENY_SOME_ALLOW_OTHERS => ___('Disallow for some affiliates, allow for others'),
                ));
         $this->addHtmlEditor('aff.intro')
                 ->setLabel(___("Intro Text on Affiliate Info Page"));
         
         $this->addAdvCheckbox('aff.tracking_code')->setLabel(array(___('Enable Click Tracking Code'), ___('Enable ability to track affiliate clicks on any page on your site')));

         $code = htmlentities(Am_Di::getInstance()->modules->loadGet('aff')->getClickJs());
         $this->addHTML('tracking_code')->setHTML(<<<EOT
To track affiliate referrals on any page of your site your site pages have to contain click tracking code. Insert this JS code to the footer on every  site's page  just before &lt;/body&gt; tag: 
<div class='info'><pre>{$code}</pre></div>
    
             
EOT
         )->setLabel(___('Click Tracking Code'));
        $this->addScript()->setScript(<<<CUT
$(function(){
    $('input[type=checkbox][name=aff___tracking_code]').change(function(){
        $('#row-tracking_code-0, #row-unsubscribe_txt-0').toggle(this.checked)
    }).change();
})
CUT
);

         
    }
    public function beforeSaveConfig(Am_Config $before, Am_Config $after)
    {
        $arr = $after->getArray();

        if (empty($arr['aff_comm']))
            return;

        $this->rule = Am_Di::getInstance()->affCommissionRuleTable->findFirstBy(array(
            'type' => AffCommissionRule::TYPE_GLOBAL,
            'tier' => 0));
        if (empty($this->rule))
        {
            $this->rule = Am_Di::getInstance()->affCommissionRuleTable->createRecord();
            $this->rule->type = AffCommissionRule::TYPE_GLOBAL;
            $this->rule->tier = 0;
            $this->rule->comment = "Default Commmission";
        }
        foreach ($arr['aff_comm'] as $aa)
            foreach ($aa as $k => $v)
                $this->rule->set($k, $v);
        unset($arr['aff_comm']);

        $after->setArray($arr);
    }
    public function afterSaveConfig(Am_Config $before, Am_Config $after)
    {
        if (!empty($this->rule))
            $this->rule->save();
    }
}
