<?php
class Am_Form_Brick_Newsletter extends Am_Form_Brick
{
    protected $labels = array(
        'Subscribe to Site Newsletters' => 'Subscribe to Site Newsletters',
    );
    
    protected $hideIfLoggedInPossible = self::HIDE_DESIRED;
    
    public function __construct($id = null, $config = null)
    {
        $this->name = ___('Newsletter');
        parent::__construct($id, $config);
    }
    
    public function isAcceptableForForm(Am_Form_Bricked $form) {
        return $form instanceof Am_Form_Signup;
    }
    
    public function insertBrick(HTML_QuickForm2_Container $form)
    {
        if ($this->getConfig('type') == 'checkboxes')
        {
            $options = Am_Di::getInstance()->newsletterListTable->getUserOptions();
            if ($enabled = $this->getConfig('lists'))
                $options = array_intersect_key($options, array_combine($enabled, $enabled));
            if (!$options) return; // no lists enabled
            $group = $form->addGroup('_newsletter')->setLabel($this->___('Subscribe to Site Newsletters'));
            $group->setSeparator("<br />\n");
            foreach ($options as $list_id => $title)
            {
                $c = $group->addAdvCheckbox($list_id)->setContent($title);
                if (!$this->getConfig('unchecked'))
                    $c->setAttribute('checked');
            }
        } else {
            $c = $form->addAdvCheckbox('_newsletter')->setLabel($this->___('Subscribe to Site Newsletters'));
            if (!$this->getConfig('unchecked'))
                $c->setAttribute('checked');
        }
    }
    public function initConfigForm(Am_Form $form)
    {
        $el = $form->addSelect('type', array('id'=>'newsletter-type-select'))->setLabel(___('Type'));
        $el->addOption(___('Single Checkbox'), 'checkbox');
        $el->addOption(___('Checkboxes for Selected Lists'), 'checkboxes');
        
        $lists = $form->addMagicSelect('lists', array('id'=>'newsletter-lists-select'))
            ->setLabel(array(___('Lists'), ___('All List will be displayed if none selected')));
        $lists->loadOptions(Am_Di::getInstance()->newsletterListTable->getAdminOptions());
        $form->addScript()->setScript(<<<CUT
jQuery(document).ready(function($) {
    $("#newsletter-type-select").change(function(){
        var val = $(this).val();
        $("#row-newsletter-lists-select").toggle(val == 'checkboxes');
    }).change();
});
CUT
            );
        $form->addAdvCheckbox('unchecked')
            ->setLabel(array(___('Default unchecked'), ___('Leave unchecked if you want newsletter default to be checked')));
    }
}

