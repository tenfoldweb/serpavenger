<?php

class Bootstrap_Helpdesk extends Am_Module
{
    const ATTACHMENT_UPLOAD_PREFIX = 'helpdesk-attachment';
    const ADMIN_ATTACHMENT_UPLOAD_PREFIX = 'helpdesk-admin-attachment';

    const EVENT_TICKET_AFTER_INSERT = 'helpdeskTicketAfterInsert';
    const EVENT_TICKET_BEFORE_INSERT = 'helpdeskTicketBeforeInsert';

    const ADMIN_PERM_ID = 'helpdesk';
    const ADMIN_PERM_FAQ = 'helpdesk_faq';
    const ADMIN_PERM_CATEGORY = 'helpdesk_category';

    function init()
    {
        $this->getDi()->uploadTable->defineUsage(self::ATTACHMENT_UPLOAD_PREFIX, 'helpdesk_message', 'attachments', UploadTable::STORE_IMPLODE, "Ticket [%ticket_id%]", '/helpdesk/admin/p/index/index');
        $this->getDi()->uploadTable->defineUsage(self::ADMIN_ATTACHMENT_UPLOAD_PREFIX, 'helpdesk_message', 'attachments', UploadTable::STORE_IMPLODE, "Ticket [%ticket_id%]", '/helpdesk/admin/p/index/index');

    }
    
    function renderNotification()
    {
        if ($user_id = $this->getDi()->auth->getUserId()) {
            $cnt = $this->getDi()->db->selectCell("SELECT COUNT(ticket_id) FROM ?_helpdesk_ticket WHERE status IN (?a) AND user_id=?",
                    array(HelpdeskTicket::STATUS_AWAITING_USER_RESPONSE), $user_id);

            if ($cnt)
                return '<div class="am-info">' . ___('You have %s%d ticket(s)%s that require your attention',
                    sprintf('<a href="%s">', REL_ROOT_URL . '/helpdesk/index/p/index/index?&_user_filter_s[]=awaiting_user_response'), $cnt, '</a>') .
                '</div>';
        }
    }

    function onSetupEmailTemplateTypes(Am_Event $event)
    {
        $ticket = array(
            'ticket.ticket_mask' => 'Ticket Mask',
            'ticket.subject' => 'Ticket Subject',
        );

        $event->addReturn(array(
            'id' => 'helpdesk.notify_new_message',
            'title' => 'Notify New Message',
            'mailPeriodic' => Am_Mail::USER_REQUESTED,
            'vars' => $ticket + array('url' => 'Url of Page with Message', 'user'),
            ), 'helpdesk.notify_new_message');
        $event->addReturn(array(
            'id' => 'helpdesk.notify_new_message',
            'title' => 'Notify New Message',
            'mailPeriodic' => Am_Mail::USER_REQUESTED,
            'vars' => $ticket + array('url' => 'Url of Page with Message', 'user'),
            ), 'helpdesk.notify_new_message_admin');
        $event->addReturn(array(
            'id' => 'helpdesk.new_ticket',
            'title' => 'Autoresponder New Ticket',
            'mailPeriodic' => Am_Mail::USER_REQUESTED,
            'vars' => $ticket + array('url' => 'Url of Page with Ticket', 'user'),
            ), 'helpdesk.new_ticket');
        $event->addReturn(array(
            'id' => 'helpdesk.notify_assign',
            'title' => 'Notify Ticket is Assigned to Admin',
            'mailPeriodic' => Am_Mail::ADMIN_REQUESTED,
            'vars' => $ticket + array('url' => 'Url of Page with Ticket', 'admin'),
            ), 'helpdesk.notify_assign');

        $event->addReturn(array(
            'id' => 'helpdesk.notify_autoclose',
            'title' => 'Notify User about Ticket Autoclose',
            'mailPeriodic' => Am_Mail::USER_REQUESTED,
            'vars' => array('user') + $ticket + array('url' => 'Url of Page with Ticket'),
            ), 'helpdesk.notify_autoclose');
    }

    function onGetUploadPrefixList(Am_Event $event)
    {
        $event->addReturn(array(
            Am_Upload_Acl::IDENTITY_TYPE_ADMIN => array(
                self::ADMIN_PERM_ID => Am_Upload_Acl::ACCESS_ALL
            )
            ), self::ADMIN_ATTACHMENT_UPLOAD_PREFIX);

        if (!$this->getConfig('does_not_allow_attachments')) {
            $event->addReturn(array(
                Am_Upload_Acl::IDENTITY_TYPE_ADMIN => array(
                    self::ADMIN_PERM_ID => Am_Upload_Acl::ACCESS_ALL
                ),
                Am_Upload_Acl::IDENTITY_TYPE_USER => Am_Upload_Acl::ACCESS_WRITE | Am_Upload_Acl::ACCESS_READ_OWN
                ), self::ATTACHMENT_UPLOAD_PREFIX);
        }
    }

    function onLoadAdminDashboardWidgets(Am_Event $event)
    {
        $event->addReturn(new Am_Widget('helpdesk-messages', ___('Last Messages in Helpdesk'), array($this, 'renderWidget'), Am_Widget::TARGET_ANY, array($this, 'createWidgetConfigForm'), self::ADMIN_PERM_ID));
    }

    function createWidgetConfigForm()
    {
        $form = new Am_Form_Admin();
        $form->addInteger('num')
            ->setLabel(___('Number of Messages to display'))
            ->setValue(5);

        return $form;
    }

    function renderWidget(Am_View $view, $config = null)
    {
        $view->num = is_null($config) ? 5 : $config['num'];
        return $view->render('admin/helpdesk/widget/messages.phtml');
    }

    function onClearItems(Am_Event $event)
    {
        $event->addReturn(array(
            'method' => array($this->getDi()->helpdeskTicketTable, 'clearOld'),
            'title' => 'Helpdesk Tickets',
            'desc' => 'records with last update date early than Date to Purge'
            ), 'helpdesk_tickets');
    }

    function onAdminWarnings(Am_Event $event)
    {
        $cnt = $this->getDi()->db->selectCell("SELECT COUNT(ticket_id) FROM ?_helpdesk_ticket WHERE status IN (?a)",
                array(HelpdeskTicket::STATUS_AWAITING_ADMIN_RESPONSE, HelpdeskTicket::STATUS_NEW));

        if ($cnt)
            $event->addReturn(___('You have %s%d ticket(s)%s that require your attention',
                    sprintf('<a class="link" href="%s">', REL_ROOT_URL . '/helpdesk/admin/?_admin_filter_s[]=new&_admin_filter_s[]=awaiting_admin_response'), $cnt, '</a>'));
    }

    function onUserMerge(Am_Event $event)
    {
        $target = $event->getTarget();
        $source = $event->getSource();

        $this->getDi()->db->query('UPDATE ?_helpdesk_ticket SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
    }

    function onAdminMenu(Am_Event $event)
    {
        $event->getMenu()->addPage(array(
            'label' => ___('Helpdesk'),
            'uri' => '#',
            'id' => 'helpdesk',
            'resource' => self::ADMIN_PERM_ID,
            'pages' => array(
                array(
                    'label' => ___('All Tickets'),
                    'controller' => 'admin',
                    'action' => 'index',
                    'module' => 'helpdesk',
                    'id' => 'helpdesk-ticket',
                    'resource' => self::ADMIN_PERM_ID,
                    'params' => array(
                        'page_id' => 'index'
                    ),
                    'route' => 'inside-pages'
                ),
                array(
                    'label' => ___('My Tickets'),
                    'controller' => 'admin-my',
                    'action' => 'index',
                    'module' => 'helpdesk',
                    'id' => 'helpdesk-ticket-my',
                    'resource' => self::ADMIN_PERM_ID,
                    'params' => array(
                        'page_id' => 'index'
                    ),
                    'route' => 'inside-pages'
                ),
                array(
                    'label' => ___('Categories'),
                    'controller' => 'admin-category',
                    'action' => 'index',
                    'module' => 'helpdesk',
                    'id' => 'helpdesk-category',
                    'resource' => self::ADMIN_PERM_CATEGORY
                ),
                array(
                    'label' => ___('FAQ'),
                    'controller' => 'admin-faq',
                    'action' => 'index',
                    'module' => 'helpdesk',
                    'id' => 'helpdesk-faq',
                    'resource' => self::ADMIN_PERM_FAQ
            ))
        ));
    }

    function onUserMenu(Am_Event $event)
    {
        $page = $helpdeskPage = array(
            'id' => 'helpdesk',
            'label' => ___('Helpdesk'),
            'controller' => 'index',
            'action' => 'index',
            'params' => array('page_id' => 'index'),
            'module' => 'helpdesk',
            'order' => 600,
            'route' => 'inside-pages',
        );

        if (!$this->getConfig('does_not_show_faq_tab') && $this->getDi()->helpdeskFaqTable->countBy()) {
            $page = array(
                'id' => 'helpdesk-root',
                'label' => ___('Support'),
                'uri' => 'javascript:;',
                'order' => 600,
                'pages' => array(
                    $helpdeskPage,
                    array(
                        'id' => 'helpdesk-faq',
                        'label' => ___('FAQ'),
                        'controller' => 'faq',
                        'action' => 'index',
                        'module' => 'helpdesk',
                        'order' => 601,
                    )
                )
            );
        }

        $event->getMenu()->addPage($page);
    }

    function onUserTabs(Am_Event_UserTabs $event)
    {
        extract($this->getDi()->db->selectRow("SELECT COUNT(*) AS cnt_all,
            COUNT(IF(status IN ('new', 'awaiting_admin_response'), ticket_id, NULL)) AS cnt_open
            FROM ?_helpdesk_ticket WHERE user_id=?", $event->getUserId()));

        $event->getTabs()->addPage(array(
            'id' => 'helpdesk',
            'module' => 'helpdesk',
            'controller' => 'admin-user',
            'action' => 'index',
            'params' => array(
                'user_id' => $event->getUserId()
            ),
            'label' => ___('Tickets') . sprintf(' (%s)', $cnt_all ? $cnt_open . '/' . $cnt_all: 0),
            'order' => 1000,
            'resource' => self::ADMIN_PERM_ID,
        ));
    }

    function onGetPermissionsList(Am_Event $event)
    {
        $event->addReturn(___('Helpdesk: Can operate with helpdesk tickets'), self::ADMIN_PERM_ID);
        $event->addReturn(___('Helpdesk: FAQ'), self::ADMIN_PERM_FAQ);
        $event->addReturn(___('Helpdesk: Categories'), self::ADMIN_PERM_CATEGORY);
    }

    function onUserAfterDelete(Am_Event_UserAfterDelete $event)
    {
        $this->getDi()->db->query("DELETE FROM ?_helpdesk_message WHERE 
            ticket_id IN (SELECT ticket_id FROM ?_helpdesk_ticket
            WHERE user_id=?)", $event->getUser()->user_id);
        $this->getDi()->db->query("DELETE FROM ?_helpdesk_ticket
            WHERE user_id=?", $event->getUser()->user_id);
    }

    function onHourly()
    {
        if ($this->getConfig('autoclose')) {
            $period = $this->getConfig('autoclose_period', 72);
            $thresholdDate = sqlTime("-$period hours");

            foreach($this->getDi()->db->selectPage($total, "
                SELECT *
                FROM ?_helpdesk_ticket
                WHERE status=? AND updated < ?
                ", HelpdeskTicket::STATUS_AWAITING_USER_RESPONSE, $thresholdDate) as $row) {

                $ticket = $this->getDi()->helpdeskTicketRecord->fromRow($row);

                $ticket->status = HelpdeskTicket::STATUS_CLOSED;
                $ticket->updated = $this->getDi()->sqlDateTime;
                $ticket->save();

                $user = $ticket->getUser();

                if($this->getConfig('notify_autoclose')) {
                    $et = Am_Mail_Template::load('helpdesk.notify_autoclose', $user->lang);
                    $et->setUser($user);
                    $et->setTicket($ticket);
                    $et->setUrl(sprintf('%s/helpdesk/index/p/view/view/ticket/%s',
                                    $this->getDi()->config->get('root_surl'),
                                    $ticket->ticket_mask));
                    $et->send($user);
                }
            }
        }
    }

    function onInitFinished()
    {
        $this->getDi()->blocks->add(new Am_Block('member/main/top', null, 'helpdesk-notification', null, array($this, 'renderNotification')));
        
        $this->getDi()->register('helpdeskStrategy', 'Am_Helpdesk_Strategy_Abstract')
            ->setConstructor('create')
            ->setArguments(array($this->getDi()));


        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addRoute('helpdesk-item', new Zend_Controller_Router_Route(
                'helpdesk/faq/i/:title', array(
                'module' => 'helpdesk',
                'controller' => 'faq',
                'action' => 'item'
                )
        ));
        $router->addRoute('helpdesk-category', new Zend_Controller_Router_Route(
                'helpdesk/faq/c/:cat', array(
                'module' => 'helpdesk',
                'controller' => 'faq',
                'action' => 'index'
                )
        ));
    }

    function onBuildDemo(Am_Event $event)
    {
        $subjects = array(
            'Please help',
            'Urgent question',
            'I have a problem',
            'Important question',
            'Pre-sale inquiry',
        );
        $questions = array(
            "My website is now working. Can you help?",
            "I have a problem with website script.\nWhere can I find documentation?",
            "I am unable to place an order, my credit card is not accepted.",
        );
        $answers = array(
            "Please call us to phone# 1-800-222-3334",
            "We are looking to your problem, and it will be resolved within 4 hours",
        );
        $user = $event->getUser();
        $now = $this->getDi()->time;
        $added = amstrtotime($user->added);
        /* @var $user User */
        while (rand(0, 10) < 4) {

            $created = min($now, $added + rand(60, $now - $added));

            $ticket = $this->getDi()->helpdeskTicketRecord;
            $ticket->status = HelpdeskTicket::STATUS_AWAITING_ADMIN_RESPONSE;
            $ticket->subject = $subjects[rand(0, count($subjects) - 1)];
            $ticket->user_id = $user->pk();
            $ticket->created = sqlTime($created);
            $ticket->updated = sqlTime($created);
            $ticket->insert();
            //
            $msg = $this->getDi()->helpdeskMessageRecord;
            $msg->content = $questions[rand(0, count($questions) - 1)];
            $msg->type = 'message';
            $msg->ticket_id = $ticket->pk();
            $msg->dattm = sqlTime($created);
            $msg->insert();
            //
            if (rand(0, 10) < 6) {
                $msg = $this->getDi()->helpdeskMessageRecord;
                $msg->content = $answers[rand(0, count($answers) - 1)];
                $msg->type = 'message';
                $msg->ticket_id = $ticket->pk();
                $msg->dattm = sqlTime(min($created + rand(60, 3600 * 24), $now));
                $msg->admin_id = $this->getDi()->adminTable->findFirstBy()->pk();
                $msg->insert();
                if (rand(0, 10) < 6)
                    $ticket->status = HelpdeskTicket::STATUS_AWAITING_USER_RESPONSE;
                else
                    $ticket->status = HelpdeskTicket::STATUS_CLOSED;
                $ticket->updated = $msg->dattm;
                $ticket->update();
            }
        }
    }

    function onLoadReports()
    {
        require_once 'Am/Report/Helpdesk.php';
    }

    function onDbUpgrade(Am_Event $e)
    {
        if (version_compare($e->getVersion(), '4.2.20') < 0) {
            echo "Fix FAQ categories...";
            if (ob_get_level ())
                ob_end_flush();
            $this->getDi()->db->query("UPDATE ?_helpdesk_faq SET category=? WHERE category=?", null, '');
            echo "Done<br>\n";
            echo "Add default Order to Helpdesk FAQ...";
            $this->getDi()->db->query("SET @i = 0");
            $this->getDi()->db->query("UPDATE ?_helpdesk_faq SET sort_order=(@i:=@i+1)");
            echo "Done<br>\n";
            echo "Add default Order to Helpdesk Categories...";
            $this->getDi()->db->query("SET @i = 0");
            $this->getDi()->db->query("UPDATE ?_helpdesk_category SET sort_order=(@i:=@i+1)");
            echo "Done<br>\n";
        }
    }

}