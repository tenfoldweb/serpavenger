<?php

class Am_Helpdesk_Controller extends Am_Controller
{

    /** @var Am_Helpdesk_Strategy */
    protected $strategy;

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Bootstrap_Helpdesk::ADMIN_PERM_ID);
    }

    public function init()
    {
        $this->strategy = $this->getDi()->helpdeskStrategy;
        $type = defined('AM_ADMIN') ? 'admin' : 'user';
        $this->getView()->headLink()->appendStylesheet($this->getView()->_scriptCss('helpdesk-' . $type . '.css'));
        parent::init();
    }

    protected function isGridRequest($gridId)
    {
        foreach ($this->getRequest()->getParams() as $key => $val)
            if (substr($key, 0, strlen($gridId)) == $gridId)
                return true;

        return false;
    }

    public function fileAction()
    {
        $message = $this->getDi()->helpdeskMessageTable->load($this->getDi()->app->reveal($this->getParam('message_id')));
        if (!$this->strategy->canViewMessage($message)) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        $upload = $this->getDi()->uploadTable->load($this->getDi()->app->reveal($this->getParam('id')));

        if (!in_array($upload->pk(), $message->getAttachments())) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        if (!in_array($upload->prefix, array(
                Bootstrap_Helpdesk::ATTACHMENT_UPLOAD_PREFIX,
                Bootstrap_Helpdesk::ADMIN_ATTACHMENT_UPLOAD_PREFIX))) {

            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        $this->_helper->sendFile($upload->getFullPath(), $upload->mime, array(
            'filename' => $upload->getName()
        ));
    }

    public function surrenderAction()
    {
        $ticketIdentity = $this->getParam('ticket');
        $ticket = $this->getDi()->helpdeskTicketTable->load($ticketIdentity);

        if (!$this->strategy->canEditOwner($ticket)) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        if ($ticket->owner_id == $this->strategy->getIdentity()) {
            $ticket->owner_id = null;
            $ticket->save();
        }

        $this->redirectTicket($ticket);
    }

    public function takeAction()
    {
        $ticketIdentity = $this->getParam('ticket');
        $ticket = $this->getDi()->helpdeskTicketTable->load($ticketIdentity);

        if (!$this->strategy->canEditOwner($ticket)) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        $id = $this->getParam('id');
        $id = $id ? $this->getDi()->app->reveal($id) : $this->strategy->getIdentity();

        $ticket->owner_id = $id;
        $ticket->save();

        if (($this->strategy->getIdentity() != $id) &&
            $this->getModule()->getConfig('notify_assign')) {

            $admin = $this->getDi()->adminTable->load($id);

            $et = Am_Mail_Template::load('helpdesk.notify_assign');
            $et->setTicket($ticket);
            $et->setAdmin($admin);
            $et->setUrl(sprintf('%s/helpdesk/index/p/view/view/ticket/%s',
                        $this->getDi()->config->get('root_surl'),
                        $ticket->ticket_mask)
                );

            $et->send($admin->email);
        }

        $this->redirectTicket($ticket);
    }

    public function editcategoryAction()
    {
        $ticketIdentity = $this->getParam('ticket');
        $ticket = $this->getDi()->helpdeskTicketTable->load($ticketIdentity);

        if (!$this->strategy->canEditCategory($ticket)) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        $ticket->category_id = $this->getDi()->app->reveal($this->getParam('id'));
        $ticket->save();

        $this->redirectTicket($ticket);
    }

    public function lockAction()
    {
        if (defined('AM_ADMIN') && AM_ADMIN) {
            $ticketIdentity = $this->getParam('ticket');
            /* @var $ticket HelpdeskTicket */
            $ticket = $this->getDi()->helpdeskTicketTable->load($ticketIdentity);
            $ticket->lock($this->getDi()->authAdmin->getUser());
        }
    }

    public function viewAction()
    {
        $ticketIdentity = $this->getParam('ticket');
        $ticket = $this->getDi()->helpdeskTicketTable->load($ticketIdentity);

        if (!$this->strategy->canViewTicket($ticket)) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        $grid = new Am_Helpdesk_Grid_Admin($this->getRequest(), $this->getView());
        $grid->getDataSource()->getDataSourceQuery()->addWhere('m.user_id=?d', $ticket->user_id);
        $grid->actionsClear();
        $grid->removeField('m_login');

        $grid->addCallback(Am_Grid_ReadOnly::CB_TR_ATTRIBS, function(& $ret, $record) use ($ticket) {
            if ($record->pk() == $ticket->pk())
                $ret['class'] = isset($ret['class']) ? $ret['class'] . ' emphase' : 'emphase';
        });

        $grid->isAjax($this->isAjax() && $this->isGridRequest('_grid'));

        if ($grid->isAjax()) {
            echo $grid->run();
            return;
        }

        $category = $ticket->getCategory();

        $t = new Am_View();
        $t->assign('ticket', $ticket);
        $t->assign('category', $category);
        $t->assign('user', $ticket->getUser());
        $t->assign('strategy', $this->strategy);
        $t->assign('historyGrid', $grid->render());
        $content = $t->render($this->strategy->getTemplatePath() . '/ticket.phtml');

        if ($this->isAjax()) {
            header('Content-type: text/html; charset=UTF-8');
            echo $content;
        } else {
            $this->view->assign('content', $content);
            $this->view->display($this->strategy->getTemplatePath() . '/index.phtml');
        }
    }

    public function replyAction()
    {
        $ticket = $this->getDi()->helpdeskTicketTable->load($this->getParam('ticket'));

        if (!$this->strategy->canEditTicket($ticket)) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        $message = null;
        $type = $this->getParam('type', 'message');
        if ($message_id = $this->getDi()->app->reveal($this->getParam('message_id'))) {
            $message = $this->getDi()->helpdeskMessageTable->load($message_id);

            switch ($type) {
                case 'message' :
                    if (!$this->strategy->canViewMessage($message)) {
                        throw new Am_Exception_AccessDenied(___('Access Denied'));
                    }
                    break;
                case 'comment' :
                    if (!$this->strategy->canEditMessage($message)) {
                        throw new Am_Exception_AccessDenied(___('Access Denied'));
                    }
                    break;
                default :
                    throw new Am_Exception_InputError('Unknown message type : ' . $type);
            }
        }

        /* @var $replyForm Am_Form */
        $replyForm = $this->getReplyForm(
                $this->getParam('ticket'),
                $message,
                $type
        );

        if ($this->isPost()) {
            $replyForm->setDataSources(array($this->getRequest()));
            $values = $replyForm->getValue();
            $message_id = $this->getParam('message_id', null);
            $message_id = $message_id ? $this->getDi()->app->reveal($message_id) : $message_id;
            $this->reply($ticket, $message_id, $values);
            $this->getRequest()->set('ticket', $ticket->ticket_mask);
            return $this->redirectTicket($ticket);
        }

        $content = (string) $replyForm;

        if ($this->isAjax()) {
            header('Content-type: text/html; charset=UTF-8');
            echo $content;
        } else {
            $this->view->assign('content', $content);
            $this->view->display($this->strategy->getTemplatePath() . '/index.phtml');
        }
    }

    public function changestatusAction()
    {
        $ticketIdentity = $this->getParam('ticket');
        $ticket = $this->getDi()->helpdeskTicketTable->load($ticketIdentity);

        if (!$this->strategy->canEditTicket($ticket)) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }

        $ticket->status = $this->getParam('status');
        $ticket->save();
        return $this->redirectTicket($ticket);
    }

    public function displaysnippetsAction()
    {
        if (!$this->strategy->canUseSnippets()) {
            throw new Am_Exception_AccessDenied();
        }

        $ds = new Am_Query($this->getDi()->helpdeskSnippetTable);
        $grid = new Am_Grid_Editable('_snippet', ___('Snippets'), $ds, $this->getRequest(), $this->view, $this->getDi());
        $grid->addField('title', ___('Title'))->setRenderFunction(array($this, 'renderSnippetTitle'));
        $grid->setForm(array($this, 'createForm'));
        $grid->actionGet('insert')->setTarget(null);
        $grid->setPermissionId(Bootstrap_Helpdesk::ADMIN_PERM_ID);

        $grid->isAjax($this->isAjax() && $this->isGridRequest('_snippet'));
        echo $grid->run();
    }

    public function displayfaqAction()
    {
        if (!$this->strategy->canUseFaq()) {
            throw new Am_Exception_AccessDenied();
        }

        $ds = new Am_Query($this->getDi()->helpdeskFaqTable);
        $grid = new Am_Grid_ReadOnly('_helpdesk_faq', ___('FAQ'), $ds, $this->getRequest(), $this->view, $this->getDi());
        $grid->addField('title', ___('Title'))->setRenderFunction(array($this, 'renderFaqTitle'));
        $grid->addField('category', ___('Category'));
        $grid->setPermissionId(Bootstrap_Helpdesk::ADMIN_PERM_ID);

        $grid->isAjax($this->isAjax() && $this->isGridRequest('_helpdesk_faq'));
        echo $grid->run();
    }

    public function displayassignAction()
    {
        if (!$this->strategy->canEditOwner(null)) {
            throw new Am_Exception_AccessDenied();
        }

        $ds = new Am_Query($this->getDi()->adminTable);
        $grid = new Am_Grid_ReadOnly('_helpdesk_assign', ___('Admins'), $ds, $this->getRequest(), $this->view, $this->getDi());
        $grid->addField('login', ___('Name'))->setRenderFunction(array($this, 'renderAssignTitle'));
        $grid->setPermissionId(Bootstrap_Helpdesk::ADMIN_PERM_ID);

        $grid->isAjax($this->isAjax() && $this->isGridRequest('_helpdesk_assign'));
        echo $grid->run();
    }

    public function displayeditcategoryAction()
    {
        if (!$this->strategy->canEditCategory(null)) {
            throw new Am_Exception_AccessDenied();
        }

        $ds = new Am_Query($this->getDi()->helpdeskCategoryTable);
        $grid = new Am_Grid_ReadOnly('_helpdesk_category', ___('Categories'), $ds, $this->getRequest(), $this->view, $this->getDi());
        $grid->addField('login', ___('Title'))->setRenderFunction(array($this, 'renderEditCategoryTitle'));
        $grid->setPermissionId(Bootstrap_Helpdesk::ADMIN_PERM_ID);

        $grid->isAjax($this->isAjax() && $this->isGridRequest('_helpdesk_category'));
        echo $grid->run();
    }

    public function renderSnippetTitle($record, $fieldName, $grid)
    {
        return sprintf('<td><a href="javascript:;" class="local am-helpdesk-insert-snippet" data-snippet-content="%s">%s</a></td>',
            Am_Controller::escape($record->content),
            Am_Controller::escape($record->title));
    }

    public function renderFaqTitle($record, $fieldName, $grid)
    {
        return sprintf('<td><a href="javascript:;" class="local am-helpdesk-insert-faq" data-faq-content="%s">%s</a></td>',
            Am_Controller::escape(sprintf('%s/helpdesk/faq/i/%s', ROOT_SURL, urlencode($record->title))),
            Am_Controller::escape($record->title));
    }

    public function renderAssignTitle($record, $fieldName, $grid)
    {
        return sprintf('<td><a href="javascript:;" class="link am-helpdesk-assign" data-admin_id="%s">%s</a></td>',
            $this->getDi()->app->obfuscate($record->pk()),
            Am_Controller::escape(sprintf('%s (%s %s)', $record->login, $record->name_f, $record->name_l)));
    }

    public function renderEditCategoryTitle($record, $fieldName, $grid)
    {
        return sprintf('<td><a href="javascript:;" class="link am-helpdesk-edit-category" data-category_id="%s">%s</a></td>',
            $this->getDi()->app->obfuscate($record->pk()),
            Am_Controller::escape($record->title));
    }

    public function createForm()
    {
        $form = new Am_Form_Admin();
        $form->addText('title', array('class' => 'el-wide'))
            ->setLabel(___('Title'))
            ->addRule('required');

        $form->addTextarea('content', array('class' => 'el-wide', 'rows' => 10))
            ->setLabel(___('Content'))
            ->addRule('required');

        return $form;
    }

    protected function redirectTicket($ticket)
    {
        $url = $this->strategy->assembleUrl(array(
                'page_id' => 'view',
                'action' => 'view',
                'ticket' => $ticket->ticket_mask,
                ), 'inside-pages');
        $this->redirectLocation($url);
        exit;
    }

    private function editMessage($message_id, $value)
    {
        $message = $this->getDi()->helpdeskMessageTable->load($message_id);
        if (!$this->strategy->canEditMessage($message)) {
            throw new Am_Exception_AccessDenied(___('Access Denied'));
        }
        $message->content = $value['content'];
        $message->save();
    }

    private function addMessage($ticket, $value)
    {
        $message = $this->getDi()->helpdeskMessageRecord;
        $message->content = $value['content'];
        $message->ticket_id = $ticket->ticket_id;
        $message->type = $value['type'];
        $message->setAttachments($value['attachments']);
        $message = $this->strategy->fillUpMessageIdentity($message);
        $message->save();

        $this->strategy->onAfterInsertMessage($message);

        $ticket->status = $this->strategy->getTicketStatusAfterReply($message);
        $ticket->updated = $this->getDi()->sqlDateTime;
        $ticket->save();
    }

    private function reply($ticket, $message_id, $values)
    {
        if ($message_id) {
            $this->editMessage($message_id, $values);
        } else {
            $this->addMessage($ticket, $values);
        }
    }

    private function getReplyForm($ticket, $message = null, $type = 'message')
    {
        $content = '';
        $form = $this->strategy->createForm();

        if (!is_null($message) && $type == 'message') {
            if (!$this->getModule()->getConfig('does_not_quote_in_reply')) {
                $content = explode("\n", $message->content);
                $content = array_map(create_function('$v', 'return \'>\'.$v;'), $content);
                $content = "\n\n" . implode("\n", $content);
            }
            if (defined('AM_ADMIN') && $this->getModule()->getConfig('add_signature')) {
                $content = "\n\n" . $this->expandPlaceholders($this->getModule()->getConfig('signature')) . $content;
            }
        } elseif (!is_null($message) && $type == 'comment') {
            $content = $message->content;
            $form->addHidden('message_id')
                ->setValue($this->getDi()->app->obfuscate($message->message_id));
        }

        $form->addHidden('type')
            ->setValue($type);

        $form->addTextarea('content', array('rows' => 15, 'class' => 'no-label el-wide'))
            ->setValue($content);

        $form->setAction($this->strategy->assembleUrl(array(
                'page_id' => 'view',
                'action' => 'reply',
                'ticket' => $ticket,
                'type' => $type
                ), 'inside-pages'));

        if ($type != 'comment') {
            $this->strategy->addUpload($form);
        }

        $btns = $form->addGroup();
        $btns->setSeparator(' ');

        $btns->addSubmit('submit', array('value' => ___('Submit')));
        $btns->addInputButton('discard', array('value' => ___('Discard')));

        return $form;
    }

    protected function expandPlaceholders($text)
    {
        $admin = $this->getDi()->authAdmin->getUser();

        return str_replace(array(
            '%name_f%', '%name_l%'
            ), array(
            $admin->name_f, $admin->name_l
            ), $text);
    }

}

