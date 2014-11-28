<?php

abstract class Am_Helpdesk_Strategy_Abstract
{

    private static $cacheUsers = array();
    private static $cacheAdmins = array();
    protected $_di = null;

    abstract public function isMessageAvalable($message);

    abstract public function isMessageForReply($message);

    abstract public function fillUpMessageIdentity($message);

    abstract public function fillUpTicketIdentity($ticket, $request);

    abstract public function getAdminName($message);

    abstract public function getTemplatePath();

    abstract public function getIdentity();

    abstract public function canViewTicket($ticket);

    abstract public function canViewMessage($message);

    abstract public function canEditTicket($ticket);

    abstract public function canEditMessage($message);

    abstract public function canUseSnippets();

    abstract public function canUseFaq();

    abstract public function canEditOwner($ticket);

    abstract public function canViewOwner($ticket);

    abstract public function canEditCategory($ticket);

    abstract public function getTicketStatusAfterReply($message);

    abstract public function onAfterInsertMessage($message);

    abstract public function createForm();

    abstract public function addUpload($form);

    abstract protected function getControllerName();

    public function __construct(Am_Di $di)
    {
        $this->_di = $di;
    }

    /**
     * @return Am_Di
     */
    protected function getDi()
    {
        return $this->_di;
    }

    function onAfterInsertTicket($ticket)
    {

    }

    public function assembleUrl($params, $route = 'default')
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        return $router->assemble(array(
            'module' => 'helpdesk',
            'controller' => $this->getControllerName(),
            ) + $params, $route, true);
    }

    /**
     * @return Am_Helpdesk_Strategy_Abstract
     */
    public static function create(Am_Di $di)
    {
        return defined('AM_ADMIN') ?
            (Zend_Controller_Front::getInstance()->getRequest()->getControllerName() == 'admin-user' ?
                new Am_Helpdesk_Strategy_Admin_User($di) :
                new Am_Helpdesk_Strategy_Admin($di) ) :
            new Am_Helpdesk_Strategy_User($di);
    }

    /**
     *
     * @return Am_Form
     *
     */
    public function createNewTicketForm()
    {
        $form = $this->createForm();

        if ($options = $this->getDi()->helpdeskCategoryTable->getOptions()) {
            $form->addAdvradio('category_id')
                ->setLabel(___('Category of question'))
                ->loadOptions($options)
                ->addRule('required');
        }


        $subject = $form->addText('subject', array('class' => 'row-wide el-wide'))
                ->setLabel(___('Subject'));
        $subject->addRule('required');
        $subject->addRule('maxlength', ___('Your subject is too verbose'), 255);
        $subject->addRule('nonempty', ___('Subject can not be empty'));

        $content = $form->addTextarea('content', array('class' => 'row-wide el-wide', 'rows' => 12))
                ->setLabel(___('Message'));
        $content->addRule('required');
        $content->addRule('nonempty', ___('Message can not be empty'));

        $this->addUpload($form);

        return $form;
    }

    public function getAdminGravatar($message)
    {
        $admin = $this->getAdmin($message->admin_id);
        return $admin ?
            sprintf('<img src="%s" width="40" height="40" />',
                'http://www.gravatar.com/avatar/' . md5(strtolower(trim($admin->email))) . '?s=40&d=mm') :
            '';
    }

    public function getUserGravatar($message)
    {
        $user = $this->getUser($message->getTicket()->user_id);
        return $user ?
            sprintf('<img src="%s" width="40" height="40" />',
                'http://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?s=40&d=mm') :
            '';
    }

    public function getUserName($message)
    {
        $user = $this->getUser($message->getTicket()->user_id);
        return sprintf('%s (%s %s)',
            $user->login,
            $user->name_f,
            $user->name_l
        );
    }

    protected function getAdmin($admin_id)
    {
        if (!isset(self::$cacheAdmins[$admin_id])) {
            self::$cacheAdmins[$admin_id] = $this->getDi()->adminTable->load($admin_id, false);
        }

        return self::$cacheAdmins[$admin_id];
    }

    protected function getUser($user_id)
    {
        if (!isset(self::$cacheUsers[$user_id])) {
            self::$cacheUsers[$user_id] = $this->getDi()->userTable->load($user_id);
        }

        return self::$cacheUsers[$user_id];
    }

}

