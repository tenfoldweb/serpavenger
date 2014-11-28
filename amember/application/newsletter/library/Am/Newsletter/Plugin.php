<?php

abstract class Am_Newsletter_Plugin extends Am_Plugin
{
    protected $_configPrefix = 'newsletter.';
    protected $_idPrefix = 'Am_Newsletter_Plugin_';

    const UNSUBSCRIBE_AFTER_ADDED = 1;
    const UNSUBSCRIBE_AFTER_PAID = 2;
    /**
     * Method must subscribe user to $addLists and unsubscribe from $deleteLists
     */
    abstract function changeSubscription(User $user, array $addLists, array $deleteLists);
    
    /**
     * Method must change customer e-mail when user changes it in aMember UI 
     */
    function changeEmail(User $user, $oldEmail, $newEmail)
    {
    }
    
    /** @return array lists 'id' => array('title' => 'xxx', )*/
    function getLists() { }
    /** 
     *  @return true if plugin can return lists (getLists overriden)
     */
    function canGetLists()
    {
        $rm = new ReflectionMethod($this, 'getLists');
        return ($rm->getDeclaringClass()->getName() !== __CLASS__);
    }       
    
    public function deactivate()
    {
        parent::deactivate();
        foreach ($this->getDi()->newsletterListTable->findByPluginId($this->getId()) as $list)
            $list->disable();
    }
    
    public function onUserAfterUpdate(Am_Event_UserAfterUpdate $event)
    {
    }

    function _afterInitSetupForm(Am_Form_Setup $form)
    {
        $url = Am_Controller::escape(REL_ROOT_URL) . '/default/admin-content/p/newsletter/index';
        $text = ___("Once the plugin configuration is finished on this page, do not forget to add\n".
                    "a record on %saMember CP -> Protect Content -> Newsletters%s page",
            '<a href="'.$url.'" target="_blank" class="link">', '</a>');
        $form->addProlog(<<<CUT
<div class="warning_box">
    $text
</div>
CUT
        );

        if($this->canGetLists())
        {
            $lists = array();
            try{
                foreach($this->getLists() as $k => $v)
                    $lists[$k] = $v['title'];
            }
            catch(Exception $e)
            {
                //just log
                $this->getDi()->errorLogTable->logException($e);
            }
            $gr = $form->addGroup()->setLabel(___('Unsubscribe customer from selected newsletter threads'));
            $gr->addSelect('unsubscribe_after_signup')->loadOptions(array(
                '' => ___('Please Select'),
                self::UNSUBSCRIBE_AFTER_ADDED => ___('After the user has been added'),
                self::UNSUBSCRIBE_AFTER_PAID => ___('After first payment has been completed')
            ));
            $gr->addStatic()->setContent('<br><br>');
            $gr->addMagicSelect('unsubscribe_after_signup_lists')->loadOptions($lists);
        }
        parent::_afterInitSetupForm($form);
    }
    
    public function onUserAfterInsert(Am_Event_UserAfterInsert $e)
    {
        if($this->getConfig('unsubscribe_after_signup') != self::UNSUBSCRIBE_AFTER_ADDED) return;
        if(!($lists = $this->getConfig('unsubscribe_after_signup_lists'))) return;
        try{
            $this->changeSubscription($e->getUser(), array(), $lists);
        }
        catch(Exception $e)
        {
            //just log
            $this->getDi()->errorLogTable->logException($e);
        }
    }
    
    public function onPaymentAfterInsert(Am_Event_PaymentAfterInsert $e)
    {
        if($this->getConfig('unsubscribe_after_signup') != self::UNSUBSCRIBE_AFTER_PAID) return;
        $user = $e->getUser();
        if($user->data()->get('unsubscribe_after_signup')) return;
        $user->data()->set('unsubscribe_after_signup',self::UNSUBSCRIBE_AFTER_PAID)->update();
        if(!($lists = $this->getConfig('unsubscribe_after_signup_lists'))) return;
        try{
            $this->changeSubscription($e->getUser(), array(), $lists);
        }
        catch(Exception $e)
        {
            //just log
            $this->getDi()->errorLogTable->logException($e);
        }
    }
    public function getIntegrationFormElements(HTML_QuickForm2_Container $container)
    {
    }
}
