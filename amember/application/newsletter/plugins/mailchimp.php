<?php

class Am_Newsletter_Plugin_Mailchimp extends Am_Newsletter_Plugin
{
    function _initSetupForm(Am_Form_Setup $form)
    {
        $el = $form->addPassword('api_key', array('size' => 40))->setLabel('MailChimp API Key'.
            "\n<a target='_blank' href=''></a>");
        $el->addRule('required');
        $el->addRule('regex', 'API Key must be in form xxxxxxxxxxxx-xxx', '/^[a-zA-Z0-9]+-[a-zA-Z0-9]{2,4}$/');
        
        $form->addAdvCheckbox('disable_double_optin')->setLabel(
            array(
                'Disable Double Opt-in', 
                '<a href="http://kb.mailchimp.com/article/how-does-confirmed-optin-or-double-optin-work">http://kb.mailchimp.com/article/how-does-confirmed-optin-or-double-optin-work</a>'
                ));
        $form->addAdvCheckbox('send_welcome')->setLabel(
            array(
                'Send Welcome Message', 
                'Should Mailchimp send Welcome Email after opt-in'
                ));
        $form->addAdvCheckbox('send_goodbye')->setLabel(
            array(
                'Send Goodbye Message', 
                ''
                ));
        $form->addAdvCheckbox('ecommerce_tracking')->setLabel(
            array(
                'Enable Ecommerce360 tracking', 
                'Read more: <a href="http://kb.mailchimp.com/article/what-is-ecommerce360-and-how-does-it-work-with-mailchimp/">on mailchimp site</a>'
                )
            );
        
    }
    /** @return Am_Plugin_Mailchimp */
    function getApi()
    {
        return new Am_Mailchimp_Api($this);
    }

    public function changeEmail(User $user, $oldEmail, $newEmail)
    {
        $ef = 'email';
        $list_ids = $this->getDi()->newsletterUserSubscriptionTable->getSubscribedIds($user->pk());
        $lists = array();
        foreach ($this->getDi()->newsletterListTable->loadIds($list_ids) as $list)
        {
            if ($list->plugin_id != $this->getId()) continue;
            $lists[] = $list->plugin_list_id;
        }
        $user->set($ef, $oldEmail)->toggleFrozen(true);
        $this->changeSubscription($user, array(), $lists); 
        // subscribe again
        $user->set($ef, $newEmail)->toggleFrozen(false);
        $this->changeSubscription($user, $lists, array()); 
    }
    
    public function changeSubscription(User $user, array $addLists, array $deleteLists)
    {
        $api = $this->getApi();
        foreach ($addLists as $list_id)
        {
            $ret = $api->sendRequest('listSubscribe', array(
                'id' => $list_id,
                'email_address' => $user->email,
                'double_optin' => $this->getConfig('disable_double_optin') ? false : true,
                'update_existing' => true,
                //'replace_interests' => '', 
                'send_welcome' => ($this->getConfig('send_welcome')? 1 : 0),
                'merge_vars' => array(
                    'FNAME' => $user->name_f,
                    'LNAME' => $user->name_l,
                    'LOGIN' => $user->login,
                ),
            ));
            if (!$ret) return false;
        }
        foreach ($deleteLists as $list_id)
        {
            $ret = $api->sendRequest('listUnsubscribe', array(
                'id' => $list_id,
                'email_address' => $user->email,
                'delete_member' => 0,
                'send_goodbye' => ($this->getConfig('send_goodbye')? 1 : 0),
                'send_notify'   => 0,
            ));
            if (!$ret) return false;
        }
        return true;
    }

    public function getLists()
    {
        $api = $this->getApi();
        $ret = array();
        $start = 0;
        do
        {
            $lists = $api->sendRequest('lists', array('start'=>$start++));
            foreach ($lists['data'] as $l)
                $ret[$l['id']] = array(
                    'title' => $l['name'],
                );
        } while(@count($lists['data'])>0);
        return $ret;
    }
    
    public function getReadme()
    {
        return <<<CUT
   MailChimp plugin readme
       
This module allows aMember Pro users to subscribe/unsubscribe from e-mail lists
created in MailChimp. To configure the module:

 - go to <a target='_blank' href='https://us4.admin.mailchimp.com/account/api/'>www.mailchimp.com -> Account -> API Keys and Authorized Apps</a>
 - if no "API Keys" exists, click "Add A Key" button
 - copy "API Key" value and insert it into aMember MailChimp plugin settings (this page) and click "Save"
 - go to aMember CP -> Protect Content -> Newsletters, you will be able to define who and how can 
   subscribe to your MailChimp lists. You can create lists in <a href='http://www.mailchimp.com/' target='_blank'>MailChimp Website</a>
   
   

CUT;
    }
    
    public function onInitFinished()
    {
        // Do not track anything for admin pages or if tracking is disabled.
        if(defined('AM_ADMIN') || !$this->getConfig('ecommerce_tracking'))
            return; 

        // mailchimp send two variables via get: mc_cid, and mc_eid both should be set in cookies. 
        if($mc_cid =$this->getDi()->request->getFiltered('mc_cid'))
            Am_Controller::setCookie ('mc_cid', $mc_cid, time()+3600*24*30);

        if($mc_eid =$this->getDi()->request->getFiltered('mc_eid'))
            Am_Controller::setCookie ('mc_eid', $mc_eid, time()+3600*24*30);
        
    }
    
    
    public function onUserAfterInsert(Am_Event_UserAfterInsert $e)
    {
        parent::onUserAfterInsert($e);
        
        if($this->getConfig('ecommerce_tracking') && $this->getDi()->request->getCookie('mc_cid') && $this->getDi()->request->getCookie('mc_eid'))
        {
            $user = $e->getUser();
            $user->data()
                ->set('mc_cid', $this->getDi()->request->getCookie('mc_cid'))
                ->set('mc_eid', $this->getDi()->request->getCookie('mc_eid'))
                ->update();
        }
        
    }
    
    
    public function getVar(User $user, $name){
        return ($var = $user->data()->get($name)) ? $var : $this->getDi()->request->getCookie($name);
    }
    public function onPaymentAfterInsert(Am_Event_PaymentAfterInsert $event)
    {
        $user = $event->getUser();
        
        if($this->getConfig('ecommerce_tracking') 
            && ($mc_cid = $this->getVar($user, 'mc_cid')) 
            && ($mc_eid = $this->getVar($user, 'mc_eid')))
        {
            
            $payment = $event->getPayment();
            $invoice = $event->getInvoice();
            $api = $this->getApi();
            $items = array();
            
            foreach($invoice->getItems() as $item){
                $single_item = array(
                    'product_id' => $item->item_id,
                    'product_name'  => $item->item_title,
                    'qty'   =>  $item->qty,
                    'cost'  => $payment->isFirst() ? $item->first_price : $item->second_price
                );
                $product = $this->getDi()->productTable->load($item->item_id);
                $categories = $product->getCategories();
                if(!empty($categories))
                {
                    $category_id = array_pop($categories);
                    $category = $this->getDi()->productCategoryTable->load($category_id);
                    $single_item['category_id'] = $category->pk();
                    $single_item['category_name'] = $category->title;
                }else{
                    $single_item['category_id'] = 0;
                    $single_item['category_name'] = "No Category";
                    
                }
                $items[] = $single_item;
                
            }
            $api->sendRequest('campaignEcommOrderAdd', array(
                'order' => array(
                    'id'            =>  $payment->transaction_id,
                    'campaign_id'   =>  $mc_cid,
                    'email_id'      =>  $mc_eid,
                    'total'         =>  $payment->amount,
                    'store_id'      =>  $this->getDi()->config->get('site_title'),
                    'items' => $items
                )
            ));
        }
        
    }
}

class Am_Mailchimp_Api extends Am_HttpRequest
{
    /** @var Am_Plugin_Mailchimp */
    protected $plugin;
    protected $vars = array(); // url params
    protected $params = array(); // request params
    
    public function __construct(Am_Newsletter_Plugin_Mailchimp $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct();
        $this->setMethod(self::METHOD_POST);
    }
    public function sendRequest($method, $params)
    {
        $this->vars = $params;
        $this->vars['apikey'] = $this->plugin->getConfig('api_key');
        $this->vars['method'] = $method;

        
        list($_, $server) = explode('-', $this->plugin->getConfig('api_key'), 2);
        $server = filterId($server);
        if (empty($server))
            throw new Am_Exception_Configuration("Wrong API Key set for MailChimp");
        $url = sprintf('http://%s.api.mailchimp.com/1.3/', $server);
        $url .= '?' . http_build_query($this->vars, '', '&');
        $this->setUrl($url);
        $ret = parent::send();
        if ($ret->getStatus() != '200')
        {
            throw new Am_Exception_InternalError("MailChimp API Error, is configured API Key is wrong");
        }
        $arr = json_decode($ret->getBody(), true);
        if (!$arr)
            throw new Am_Exception_InternalError("MailChimp API Error - unknown response [" . $ret->getBody() . "]");
        if(isset($arr['error']))
        {
            Am_Di::getInstance()->errorLogTable->log("MailChimp API Error - [" . $arr['error'] ."]");
            return false;
        }
        return $arr;
    }
}