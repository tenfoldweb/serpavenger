<?php

class Am_Grid_Editable_Newsletter extends Am_Grid_Editable_Content
{
    public function __construct(Am_Request $request, Am_View $view)
    {
        parent::__construct($request, $view);
        $a = new Am_Grid_Action_Callback('_refresh', ___('Refresh 3-rd party lists'), array($this, 'doRefreshLists'), Am_Grid_Action_Abstract::NORECORD);
        $this->actionAdd($a);
        $this->actionAdd(new Am_Grid_Action_NewsletterSubscribeAll());
        $this->refreshLists(false); // refresh if expired
        foreach ($this->getActions() as $action) {
            $action->setTarget('_top');
        }
        $this->setFilter(new Am_Grid_Filter_Text(___('Filter by Title'), array('title'=>'LIKE')));
    }
    
    public function init()
    {
        parent::init();
        $this->addCallback(self::CB_VALUES_FROM_FORM, array($this, '_valuesFromForm'));
    }

    public function _valuesFromForm(array & $vars)
    {
        if (!empty($vars['_vars'][$vars['plugin_id']]))
            $this->getRecord()->setVars($vars['_vars'][$vars['plugin_id']]);
        else
            $this->getRecord()->setVars(array_shift(array_values($vars['_vars'])));
    }
    public function valuesToForm()
    {
        $ret = parent::valuesToForm();
        if (!empty($ret['plugin_id']))
            $ret['_vars'][$ret['plugin_id']] = $this->getRecord()->getVars();
        return $ret;
    }
    
    public function doRefreshLists(Am_Grid_Action_Callback $action)
    {
        $this->refreshLists(true);
        echo ___('Done');
        echo "<br /><br />";
        echo $action->renderBackButton(___('Continue'));
    }
    
    public function refreshLists($force=true)
    {
        $this->getDi()->newsletterListTable->disableDisabledPlugins(
            $this->getDi()->plugins_newsletter->getEnabled());
        foreach ($this->getDi()->plugins_newsletter->loadEnabled()->getAllEnabled() as $pl)
        {
            if (!$pl->canGetLists()) continue;
            $k = 'newsletter_plugins_' . $pl->getId() . '_lists';
            if (!$force && $this->getDi()->store->get($k))
                continue; // it is stored
            $lists = $pl->getLists();
            $this->getDi()->newsletterListTable->syncLists($pl, $lists);
            $this->getDi()->store->set($k, serialize($lists), '+1 hour');
        }
    }
    
    public function getLists()
    {
        $ret = array();
        foreach ($this->getDi()->plugins_newsletter->loadEnabled()->getAllEnabled() as $pl)
        {
            if (!$pl->canGetLists()) continue;
            $k = 'newsletter_plugins_' . $pl->getId() . '_lists';
            $s = $this->getDi()->store->get($k);
            if ($s) 
                $ret[$pl->getId()] = (array)unserialize($s);
        }
        return $ret;
    }
    
    protected function initGridFields()
    {
        $this->addField('title', ___('Title'))->setRenderFunction(array($this, 'renderAccessTitle'));
        if (count($this->getDi()->plugins_newsletter->getEnabled()) > 1)
        {
            $this->addField('plugin_id', ___('Plugin'));
            $this->addField('plugin_list_id', ___('Plugin List Id'));
        }
        $this->addField('subscribed_users', ___('Subscribers'))
            ->addDecorator(new Am_Grid_Field_Decorator_Link('admin-users/index?_u_search[-newsletters][val][]={list_id}'));
        parent::initGridFields();
    }

    protected function createAdapter()
    {
        $q = new Am_Query(Am_Di::getInstance()->newsletterListTable);
        $q->addWhere('IFNULL(disabled,0)=0');
        $q->leftJoin('?_newsletter_user_subscription', 's', 's.list_id = t.list_id AND s.is_active > 0');
        $q->addField('COUNT(s.list_id)', 'subscribed_users');
        return $q;
    }
    
    function createForm()
    {
        $form = new Am_Form_Admin;
        $record = $this->getRecord();
        $plugins = $this->getDi()->plugins_newsletter->loadEnabled()->getAllEnabled();
        if ($record->isLoaded())
        {
            if ($record->plugin_id)
            {
                $group = $form->addFieldset();
                $group->setLabel(ucfirst($record->plugin_id));
                $form->addStatic()->setLabel(___('Plugin List Id'))->setContent(Am_Controller::escape($record->plugin_list_id));
            }
        } else {
            if (count($plugins)>1)
            {
                $sel = $form->addSelect('plugin_id')->setLabel(___('Plugin'));
                $sel->addOption(___('Standard'),'');
                foreach ($plugins as $pl)
                {
                    if (!$pl->canGetLists() && $pl->getId() != 'standard')
                        $sel->addOption($pl->getTitle(), $pl->getId());
                }
            }            
            foreach ($plugins as $pl)
            {
                $group = $form->addFieldset($pl->getId())->setId('headrow-' . $pl->getId());
                $group->setLabel($pl->getTitle());
            }
            $form->addText('plugin_list_id')->setLabel(___('Plugin List Id')."\n".___('value required'));
            
            $form->addScript()->setScript(<<<END
$(function(){
    function showHidePlugins(el, skip)
    {
        var txt = $("input[name='plugin_list_id']");
        var enabled = el.val() != '';
        txt.closest(".row").toggle(enabled);
        if (enabled)
            txt.rules("add", { required : true});
        else if(skip)
            txt.rules("remove", "required");
        var selected = el.val() ? el.val() : 'standard';
        $("[id^='headrow-']").hide();
        $("[id=headrow-"+selected+"-legend]").show();
        $("[id=headrow-"+selected+"-pluginoptions]").show();
        $("[id=headrow-"+selected+"]").show();
    }
    $("select[name='plugin_id']").change(function(){
        showHidePlugins($(this), true);
    });
    showHidePlugins($("select[name='plugin_id']"), false);
});
END
);
        }
        
        
        $form->addText('title', array('class' => 'el-wide'))->setLabel(___('Title'))->addRule('required');
        $form->addText('desc', array('class' => 'el-wide'))->setLabel(___('Description'));
        $form->addAdvCheckbox('hide')->setLabel(___("Hide\n" . "do not display this item in members area"));
        
        $form->addAdvCheckbox('auto_subscribe')->setLabel(___("Auto-Subscribe users to list\n".
            "once it becomes accessible for them"));
        foreach ($plugins as $pl)
        {
            $group = $form->addElement(new Am_Form_Container_PrefixFieldset('_vars'))->setId('headrow-' . $pl->getId() .'-pluginoptions');
            $gr = $group->addElement(new Am_Form_Container_PrefixFieldset($pl->getId()));
            $pl->getIntegrationFormElements($gr);
        }
        
        
        $group = $form->addFieldset('access')->setLabel(___('Access'));
        $group->addElement(new Am_Form_Element_ResourceAccess)->setName('_access')
            ->setLabel(___('Access Permissions'))
            ->setAttribute('without_free_without_login', 'true')
            ->setAttribute('without_period', 'true');
            
        return $form;
    }
    
}