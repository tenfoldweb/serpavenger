<?php

class Am_Helpdesk_Strategy_User extends Am_Helpdesk_Strategy_Abstract
{

    protected $_identity = null;

    public function __construct(Am_Di $di, $user_id = null)
    {
        parent::__construct($di);
        $this->_identity = $user_id ? $user_id : $this->getDi()->auth->getUserId();
    }

    public function isMessageAvalable($message)
    {
        return!($message->type == 'comment' && $message->admin_id);
    }

    public function isMessageForReply($message)
    {
        if ($message->type == 'comment') {
            return false;
        } else {
            return (boolean) $message->admin_id;
        }
    }

    public function fillUpMessageIdentity($message)
    {
        return $message;
    }

    public function fillUpTicketIdentity($ticket, $request)
    {
        $ticket->user_id = $this->getIdentity();
        return $ticket;
    }

    public function getTicketStatusAfterReply($message)
    {
        if ($message->type == 'comment') {
            return $message->getTicket()->status;
        } else {
            return 'awaiting_admin_response';
        }
    }

    public function onAfterInsertMessage($message)
    {
        if ($this->getDi()->config->get('helpdesk.notify_new_message_admin', 1)) {

            $user = $this->getUser($message->getTicket()->user_id);

            $recepients[] = Am_Mail_Template::TO_ADMIN;
            if ($owner = $message->getTicket()->getOwner()) {
                $recepients[] = $owner;
            }

            foreach ($recepients as $recepient) {
                if ($et = Am_Mail_Template::load('helpdesk.notify_new_message_admin')) {
                    $et->setTicket($message->getTicket());
                    $et->setUser($user);
                    $et->setMessage($message);
                    $et->setUrl(sprintf('%s/helpdesk/admin/p/view/view/ticket/%s',
                            $this->getDi()->config->get('root_surl'),
                            $message->getTicket()->ticket_mask)
                    );
                    $et->send($recepient);
                }
            }
        }
    }

    public function onAfterInsertTicket($ticket)
    {
        if ($this->getDi()->config->get('helpdesk.new_ticket')) {

            $user = $this->getUser($ticket->user_id);
            if ($user->unsubscribed)
                return;

            $et = Am_Mail_Template::load('helpdesk.new_ticket', $user->lang);
            if ($et) {
                $et->setTicket($ticket);
                $et->setUser($user);
                $et->setUrl(sprintf('%s/helpdesk/index/p/view/view/ticket/%s',
                        $this->getDi()->config->get('root_surl'),
                        $ticket->ticket_mask)
                );
                $et->send($user);
            }
        }
    }

    public function getAdminName($message)
    {
        return ___('Administrator');
    }

    public function getTemplatePath()
    {
        return 'helpdesk';
    }

    public function getIdentity()
    {
        return $this->_identity;
    }

    public function canViewTicket($ticket)
    {
        return $ticket->user_id == $this->getIdentity();
    }

    public function canViewMessage($message)
    {
        return $message->getTicket()->user_id == $this->getIdentity();
    }

    public function canEditTicket($ticket)
    {
        return $ticket->user_id == $this->getIdentity() &&
        $ticket->status != HelpdeskTicket::STATUS_CLOSED;
    }

    public function canEditMessage($message)
    {
        return $message->type == 'comment' &&
        ($message->getTicket()->user_id == $this->getIdentity());
    }

    public function canUseSnippets()
    {
        return false;
    }

    public function canUseFaq()
    {
        return false;
    }

    public function canEditOwner($ticket)
    {
        return false;
    }

    public function canViewOwner($ticket)
    {
        return false;
    }

    public function canEditCategory($ticket)
    {
        return false;
    }

    public function createForm()
    {
        $form = new Am_Form();
        $form->setAttribute('class', 'am-helpdesk-form');

        return $form;
    }

    public function addUpload($form)
    {
        if (!$this->getDi()->modules->get('helpdesk')->getConfig('does_not_allow_attachments')) {
            $form->addUpload('attachments', array('multiple' => 1), array('prefix' => Bootstrap_Helpdesk::ATTACHMENT_UPLOAD_PREFIX, 'secure' => true))
                ->setLabel(___('Attachments'))
                ->setJsOptions(<<<CUT
{
   fileBrowser:false,
   urlUpload : '/upload/upload',
   urlGet : '/upload/get'
}
CUT
            );
        }
    }

    protected function getControllerName()
    {
        return 'index';
    }

}

