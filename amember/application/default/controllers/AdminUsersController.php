<?php

class Am_Grid_Action_Group_UserAssignGroup extends Am_Grid_Action_Group_Abstract
{
    protected $needConfirmation = true;
    protected $remove = false;
    public function __construct($removeGroup = false)
    {
        $this->remove = (bool)$removeGroup;
        parent::__construct(
            !$removeGroup ? "user-assign-group" : "user-remove-group",
            !$removeGroup ? ___("Assign Group") : ___("Remove Group")
            );
    }

    public function renderConfirmationForm($btn = "Yes, assign", $page = null, $addHtml = null)
    {
        $select = sprintf('<select name="%s__group_id">
            %s
            </select><br /><br />'.PHP_EOL,
            $this->grid->getId(),
            Am_Controller::renderOptions(Am_Di::getInstance()->userGroupTable->getSelectOptions())
            );
        return parent::renderConfirmationForm($this->remove ? ___("Yes, remove group") :  ___("Yes, assign group"), null, $select);
    }

    /**
     * @param int $id
     * @param User $record
     */
    public function handleRecord($id, $record)
    {
        $group_id = $this->grid->getRequest()->getInt('_group_id');
        if (!$group_id) throw new Am_Exception_InternalError("_group_id empty");
        $groups = $record->getGroups();
        if ($this->remove)
        {
            if (!in_array($group_id, $groups)) return;
            foreach ($groups as $k => $id)
                if ($id == $group_id) unset($groups[$k]);
        } else {
            if (in_array($group_id, $groups)) return;
            $groups[] = $group_id;
        }
        $record->setGroups($groups);
    }
}

class Am_Grid_Action_Group_PasswordConfirmedDelete extends Am_Grid_Action_Group_Delete
{
    public function __construct($id = null, $title = null)
    {
        parent::__construct($id, $title);
        $this->setTarget('_top');
    }
    public function renderConfirmationForm($btn = null, $page = null, $addHtml = null)
    {
        if (!$this->getSession()->login_ok)
            $addHtml = ___('Enter admin password for confirmation') .
            ":<br /><input type='password' name='_admin_pass' size=20/><br /><br />" . $addHtml;
        else
            $addHtml = null;
        return parent::renderConfirmationForm($btn, $page, $addHtml);
    }
    public function getConfirmationText()
    {
        return parent::getConfirmationText();
    }
    public function run()
    {
        if (!$this->getSession()->login_ok)
        {
            $admin_pass = $this->grid->getCompleteRequest()->getPost('_admin_pass');
            if (!$admin_pass)
            {
                echo $this->renderConfirmation();
                return;
            } elseif (!$this->grid->getDi()->authAdmin->getUser()->checkPassword($admin_pass)) {
                echo "<div style='color: red'>".___('The password is entered incorrectly')."</div>";
                echo $this->renderConfirmation();
                return;
            }
        }
        $this->getSession()->login_ok = true;
        return parent::run();
    }
    function getSession()
    {
        static $session;
        if ($session) return $session;
        $session = new Zend_Session_Namespace('am_admin_users_delete');
        $session->setExpirationSeconds(3600);
        return $session;
    }
}



/**
 * This hook allows you to modify user form once it is created
 * you can add/remove elements as you wish
 * Please add additional fields with _ prefix so it does not interfere
 * with User table fields
 */
class Am_Form_Admin_User extends Am_Form_Admin {
    /** @var User */
    protected $record;

    function __construct($record)
    {
        $this->record = $record;
        parent::__construct('user');
    }

    function setDataSources(array $datasources)
    {
        if(!Am_Di::getInstance()->config->get('manually_approve'))
            array_unshift($datasources, new HTML_QuickForm2_DataSource_Array(array('is_approved' =>1)));

        parent::setDataSources($datasources);
    }
    function checkUniqLogin($login)
    {
        if (!preg_match(Am_Di::getInstance()->userTable->getLoginRegex(), $login))
            return ___('Username contains invalid characters - please use digits and letters');

        // We need to check login only when user is not exists, or when he change his username.

        $user_id = $this->record ? $this->record->pk() : null;

        if(!$user_id || (strcasecmp($this->record->login, $login)!==0))
            if (!$this->record->getTable()->checkUniqLogin($login, $user_id))
                return ___('Username %s is already taken. Please choose another username', Am_Controller::escape($login));
    }
    function checkUniqEmail(array $group)
    {
        $email = $group['email'];
        if (!Am_Validate::email($email))
            return ___('Please enter valid Email');

        // Do the same for email if case there are plugins that use email as username.
        // We need to check email only when user is not exists, or when he change his email.

        $user_id = $this->record ? $this->record->pk() : null;

        if(!$user_id || (strcasecmp($this->record->email, $email)!==0))
            if (!$this->record->getTable()->checkUniqEmail($email, $user_id))
                return ___('An account with the same email already exists.');
    }

    function init()
    {
        /* General Settings */
        $fieldSet = $this->addElement('fieldset', 'general', array('id'=>'general', 'label' => ___('General')));

        $login = $fieldSet->addText('login', array('class' => 'el-wide'))
            ->setLabel(___('Username'))
            ->setId('login');
        $login->addRule('required');
        $login->addRule('callback2', '-error-', array($this, 'checkUniqLogin'));

        if ($this->record->isLoaded()) {
            $countSameIp = Am_Di::getInstance()->userTable->countBy(array(
                'remote_addr' => $this->record->remote_addr,
                'user_id' => '<>'.$this->record->pk()));

            $ban = Am_Di::getInstance()->banTable->findBan(array(
                'ip' => $this->record->remote_addr
            ));
            $banInfoHtml = $ban ?
                sprintf('<strong>%s</strong>', Am_Controller::escape(___('This IP is Banned'))) :
                (Am_Di::getInstance()->authAdmin->getUser()->hasPermission(Am_Auth_Admin::PERM_BAN) ?
                    sprintf('<a class="link" href="%s">%s</a>',
                        REL_ROOT_URL . '/admin-ban?' . http_build_query(array(
                            '_ip_a' => 'insert',
                            '_ip_b' => Am_Di::getInstance()->view->userUrl($this->record->pk()),
                            'value' => $this->record->remote_addr,
                            'comment' => sprintf('%s (%s %s)', $this->record->login,
                                $this->record->name_f,
                                $this->record->name_l))),
                        Am_Controller::escape(___('Block This IP Address'))) :
                    '');

            $fieldSet->addStatic('_signup_info', null, array('label' => ___('Signup Info')))->setContent(
                sprintf('<div>%s%s<time title="%s" datetime="%s">%s</time> %s</div>%s',
                        $this->record->remote_addr,
                        ___(' at '),
                        Am_Di::getInstance()->view->getElapsedTime($this->record->added),
                        date('c', amstrtotime($this->record->added)),
                        amDatetime($this->record->added),
                        $banInfoHtml,
                    $countSameIp ? '<div>' . ___('There is %s users with same registration IP Address',
                        '<a class="link" href="' . REL_ROOT_URL . '/admin-users?_u_filter=' . $this->record->remote_addr . '">' . $countSameIp . '</a>') . '</div>' : '')
            );

            $ban = Am_Di::getInstance()->banTable->findBan(array(
                'ip' => $this->record->remote_addr
            ));

            $ban = Am_Di::getInstance()->banTable->findBan(array(
                'ip' => $this->record->last_ip
            ));
            $banInfoHtml = $ban ?
                sprintf(' <strong>%s</strong>', Am_Controller::escape(___('This IP is Banned'))) :
                (Am_Di::getInstance()->authAdmin->getUser()->hasPermission(Am_Auth_Admin::PERM_BAN) ?
                    sprintf(' <a class="link" href="%s">%s</a>',
                        REL_ROOT_URL . '/admin-ban?' . http_build_query(array(
                            '_ip_a' => 'insert',
                            '_ip_b' => Am_Di::getInstance()->view->userUrl($this->record->pk()),
                            'value' => $this->record->remote_addr,
                            'comment' => sprintf('%s (%s %s)', $this->record->login,
                                $this->record->name_f,
                                $this->record->name_l))),
                        Am_Controller::escape(___('Block This IP Address'))) :
                    '');

            $fieldSet->addStatic('_signin_info', null, array('label' => ___('Last Signin Info')))->setContent(
                sprintf("<div>%s</div>", $this->record->last_login ?
                    sprintf('%s%s<time title="%s" datetime="%s">%s</time> %s',
                        $this->record->last_ip,
                        ___(' at '),
                        Am_Di::getInstance()->view->getElapsedTime($this->record->last_login),
                        date('c', amstrtotime($this->record->last_login)),
                        amDatetime($this->record->last_login),
                        $banInfoHtml) : ___('Never'))
            );
        }


        $comment = $fieldSet->addTextarea('comment', array('class' => 'el-wide', 'id' => 'comment'), array('label' => ___('Comment')));

        $pass = $fieldSet->addElement('password', '_pass', array('size' => 20, 'autocomplete'=>'off'))->setLabel(___('New Password'));
        //$pass0 = $gr->addElement('password', '_pass0', array('size' => 20));
        //$pass0->addRule('eq', 'Password confirmation must be equal to Password', $pass);
        if (!$this->record->isLoaded())
            $pass->addRule('required');

        $nameField = $fieldSet->addGroup('', array('id' => 'name'), array('label' => ___('Name')));
        $nameField->setSeparator(' ');
        $nameField->addElement('text', 'name_f', array('size'=>20));
        $nameField->addElement('text', 'name_l', array('size'=>20));

        $gr = $fieldSet->addGroup()->setLabel(___('E-Mail Address'));
        $gr->setSeparator(' ');
        $gr->addElement('text', 'email', array('size' => 40))->addRule('required');
        $gr->addRule('callback2', '-error-', array($this, 'checkUniqEmail'));

        if ($this->record && $this->record->isLoaded())
        {
            $resendText = Am_Controller::escape(___('Resend Signup E-Mail'));
            $sending = Am_Controller::escape(___('sending'));
            $sent = Am_Controller::escape(___('sent successfully'));
            $id = $this->record->pk();
            $gr->addElement('static')->setContent(<<<CUT
<input type='button' value='$resendText' id='resend-signup-email' />
<script type='text/javascript'>
$(function(){
$("#resend-signup-email").click(function(){
    var btn = this;
    var txt = btn.value;
    btn.value += '...($sending)...';
    $.post(window.rootUrl + '/admin-users/resend-signup-email', {id: $id}, function(){
        btn.value = txt + '...($sent)';
        setTimeout(function(){ btn.value = txt; }, 600);
    });
});
});
</script>
CUT
            );
        }
        $isLocked = $fieldSet->addElement('advradio', 'is_locked', array('id' => 'is_locked', ))
            ->loadOptions(array(
                ''   => 'No',
                '1'  => '<span class="red">'.___('Yes, locked').'</span>',
                '-1' => '<em>'.___('Disable auto-locking for this customer').'</em>',
            ))->setLabel(___('Is Locked'));

        $fieldSet->addElement('advcheckbox', 'is_approved', array('id' => 'is_approved'))
                 ->setLabel(___('Is Approved'));

        $fieldSet->addElement('advradio', 'unsubscribed', array('id' => 'unsubscribed'))
            ->setLabel(___("Is Unsubscribed?
if enabled, this will
unsubscribe the customer from:
* messages that you send from aMember Cp,
* autoresponder messages,
* subscription expiration notices"))
            ->loadOptions(array(
                ''   => ___('No'),
                '1'  => ___('Yes, do not e-mail this customer for any reasons'),
            ));

        $fieldSet->addCategory('_groups', null, array(
                'base_url' => 'admin-user-groups',
                'link_title' => ___('Edit Groups'),
                'title' => ___('User Groups'),
                'options' => Am_Di::getInstance()->userGroupTable->getOptions()))
            ->setLabel(___('User Groups'));

        if (in_array('vat', (array)Am_Di::getInstance()->config->get('plugins.tax')))
            $this->addText('tax_id')->setLabel(___('Tax Id'));

        $this->addElement('text', 'phone', array('size' => 20))->setLabel(___('Phone Number'));
        /* Address Info */
        $this->insertAddressFields();
        $this->insertAdditionalFields();
    }

    function addSaveButton($title = null)
    {
        if (!$this->record->isLoaded())
        {
            $group = $this->addGroup();
            $group->addAdvCheckbox('_registration_mail');
            $group->addStatic()->setContent(sprintf(' <strong>%s</strong>',
                Am_Controller::escape(___('Send Registration E-Mail to this user'))
                ));
            $group->addStatic()->setContent('<br /><br />');
            $group->addElement(parent::addSaveButton($title));

        } else {
            parent::addSaveButton($title);
        }
    }


    function insertAddressFields()
    {
        $fieldSet = $this->addElement('advfieldset', 'address', array('id' => 'address_info'))
            ->setLabel(___('Address Info'));
        $fieldSet->addText('street', array('class' => 'el-wide'))->setLabel(___('Street Address'));
        $fieldSet->addText('street2', array('class' => 'el-wide'))->setLabel(___('Street Address (Second Line)'));
        $fieldSet->addText('city', array('class' => 'el-wide'))->setLabel(___('City'));
        $fieldSet->addText('zip')->setLabel(___('ZIP Code'));

        $fieldSet->addSelect('country')->setLabel(___('Country'))
            ->setId('f_country')
            ->loadOptions(Am_Di::getInstance()->countryTable->getOptions(true));

        $group = $fieldSet->addGroup()->setLabel(___('State'));
        $state =$group->addSelect('state', '', array('intrinsic_validation'=>false))
            ->setId('f_state');
        /* @var $state HTML_QuickForm2_Select */
        $state->addFilter(array($this, '_filterState'));
        if (!empty($this->record->country))
            $state->loadOptions(Am_Di::getInstance()->stateTable->getOptions($this->record->country, true));
        $group->addText('state')->setId('t_state')->setAttribute('disabled', 'disabled');
    }
    public function _filterState($state)
    {
        return preg_replace('#[^A-Za-z0-9-]#', '', $state);
    }

    function insertAdditionalFields() {
        $fieldSet = $this->getElementById('general');
        $fields = Am_Di::getInstance()->userTable->customFields()->getAll();
        uksort($fields, array(Am_Di::getInstance()->userTable, 'sortCustomFields'));
        $exclude = array(
        );
        foreach ($fields as $k => $f)
            if (!in_array($f->name, $exclude) && strpos($f->name, 'aff_')!==0)
                $el = $f->addToQf2($fieldSet);
    }
    protected function renderClientRules(HTML_QuickForm2_JavascriptBuilder $builder)
    {
        $generate = ___("generate");
        $builder->addElementJavascript(<<<CUT
$(document).ready(function(){
    var pass0 = $("input#_pass-0").after(" <a href='javascript:;' class='local' id='generate-pass'>$generate</a>");
    $("a#generate-pass").click(function(){
        if (pass0.attr("type")!="text")
        {
            pass0.replaceWith("<input type='text' name='"+pass0.attr("name")
                    +"' id='"+pass0.attr("id")
                    +"' size='"+pass0.attr("size")
                    +"' />");
            pass0 = $("input#_pass-0");
        }
        var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
        var pass = "";
        var len = 9;
        for(i=0;i<len;i++)
        {
            x = Math.floor(Math.random() * 62);
            pass += chars.charAt(x);
        }
        pass0.val(pass);
    });
});
CUT
        );
    }
}

class Am_Grid_Action_Group_EmailUsers extends Am_Grid_Action_Group_Abstract {
    protected $needConfirmation = false;

    public function __construct()
    {
        parent::__construct('email-users', ___('E-Mail Users'));
        $this->setTarget('_top');
    }
    public function handleRecord($id, $record)
    {
        ;
    }
    public function doRun(array $ids)
    {
        if ($ids[0] == self::ALL)
        {
            $search = urlencode($this->grid->getDataSource()->serialize());
        } else {
            $q = new Am_Query_User;
            $q->setPrefix('search');
            $vars['search']['member_id_filter']['val'] = join(',',$ids);
            $q->setFromRequest($vars);
            $search = urlencode($q->serialize());
        }
        $this->grid->redirect(REL_ROOT_URL . '/admin-email?search-type=advanced&search='.$search);
    }
}

class Am_Grid_Action_Group_MassSubscribe extends Am_Grid_Action_Group_Abstract
{
    protected $needConfirmation = true;
    protected $form;
    protected $_vars, $_products;
    public function __construct()
    {
        parent::__construct('mass_subscribe', ___('Mass Subscribe'));
        $this->setTarget('_top');
    }
    public function _getProduct($id)
    {
        if (!$this->_products[$id])
        {
            $this->_products[$id] = Am_Di::getInstance()->productTable->load($id);
        }
        return $this->_products[$id];
    }
    public function handleRecord($id, $record)
    {
        if (!$this->_vars['add_payment'])
        {
            $a = $this->grid->getDi()->accessRecord;
            $a->begin_date = $this->_vars['start_date'];
            $a->expire_date = $this->_vars['expire_date'];
            $a->product_id = $this->_vars['product_id'];
            $a->user_id = $id;
            $a->insert();
        } else {
            $invoice = $this->grid->getDi()->invoiceRecord;
            $invoice->user_id = $id;
            $invoice->add($this->_getProduct($this->_vars['product_id']));

            // Set item first_total for correct reporting.

            $items = $invoice->getItems();
            $item = $items[0];
            $item->first_price = $item->first_total = $this->_vars['amount'];

            $invoice->paysys_id = 'free';
            $invoice->comment = 'mass-subscribe';
            $invoice->calculate();
            $invoice->save();

            $tr = new Am_Paysystem_Transaction_Manual($this->grid->getDi()->plugins_payment->loadGet('free'));
            $tr->setAmount($this->_vars['amount']);
            $tr->setTime(new DateTime($this->_vars['start_date']));
            $tr->setReceiptId('mass-subscribe-'. uniqid() . '-' . $invoice->pk());
            $invoice->addPayment($tr);
        }
    }

    public function getForm()
    {
        if (!$this->form)
        {
            $id = $this->grid->getId();
            $this->form = new Am_Form_Admin;
            $sel = $this->form->addSelect($id . '_product_id')->setLabel(___('Product'));
            $sel->loadOptions(Am_Di::getInstance()->productTable->getOptions(false));
            $sel->addRule('required');
            $dates = $this->form->addGroup()->setLabel(___('Start and Expiration Dates'));
            $dates->setSeparator(' ');
            $dates->addRule('required');
            $dates->addDate($id.'_start_date')->addRule('required');
            $dates->addDate($id.'_expire_date')->addRule('required');
            $pg = $this->form->addCheckboxedGroup($id.'_add_payment')->setLabel(___('Additionally to "Access", add "Invoice" and "Payment" record with given %s amount, like they have really made a payment', Am_Currency::getDefault()));
            $pg->addStatic()->setContent('Payment Record amount, eg.: 19.99' . ' ');
            $pg->addText($id.'_amount', array('size'=>8))->addRule('regex', 'must be a number', '/^(\d+)(\.\d+)?$/');
            $this->form->addSaveButton(___('Mass Subscribe'));
        }
        return $this->form;
    }

    public function renderConfirmationForm($btn = null, $page = null, $addHtml = null)
    {
        if ($page) {
            return parent::renderConfirmationForm($btn, $page, $addHtml);
        } else {
            $this->getForm();
            $vars = $this->grid->getCompleteRequest()->toArray();
            $vars[$this->grid->getId() . '_confirm'] = 'yes';
            if ($page !== null)
            {
                $vars[$this->grid->getId() . '_group_page'] = (int)$page;
            }
            foreach ($vars as $k => $v)
                if ($this->form->getElementsByName($k))
                    unset($vars[$k]);
            $hiddens = Am_Controller::renderArrayAsInputHiddens($vars);
            $this->form->addStatic()->setContent($hiddens);

            $url_yes = $this->grid->makeUrl(null);
            $this->form->setAction($url_yes);
            echo $this->renderTitle();
            echo (string)$this->form;
        }
    }
    public function run()
    {
        if (!$this->getForm()->validate())
        {
            echo $this->renderConfirmationForm();
        } else {
            $prefix = $this->grid->getId().'_';
            foreach ($this->getForm()->getValue() as $k => $v)
            {
                if (strpos($k, $prefix)===0)
                    $this->_vars[substr($k, strlen($prefix))] = $v;
            }
            // disable emailing
            Am_Mail::setDefaultTransport(new Am_Mail_Transport_Null);
            return parent::run();
        }
    }
}

class Am_Grid_Action_Merge extends Am_Grid_Action_Abstract {

    protected $title = "Merge %s";
    protected $privilege = 'merge';

    function run()
    {
        $form = new Am_Form_Admin('form-grid-merge');
        $form->setAttribute('name', 'merge');

        $user = $this->grid->getRecord();

        $login = $form->addText('login');
        $login->setId('login')
            ->setLabel(___("Username of Source User\nmove information from"));
        $login->addRule('callback', ___('Can not find user with such username'), array($this, 'checkUser'));
        $login->addRule('callback', ___('You can not merge user with itself'), array($this, 'checkIdenticalUser'));

        $target = $form->addStatic()
            ->setContent(sprintf('<div>%s</div>', Am_Controller::escape($user->login)));
        $target->setLabel(___("Target User\nmove information to"));


        $script = <<<CUT
        $("input#login").autocomplete({
                minLength: 2,
                source: window.rootUrl + "/admin-users/autocomplete"
        });
CUT;

        $form->addStatic('', array('class' => 'no-label'))->setContent(
            '<div class="info"><strong>' . ___("WARNING! Once [Merge] button clicked, all invoices, payments, logs\n".
                "and other information regarding 'Source User' will be moved\n".
                "to the 'Target User' account. 'Source User' account will be deleted.\n".
                "There is no way to undo this operation!") . '</strong></div>'
        );


        $form->addScript('script')->setScript($script);


        foreach ($this->grid->getVariablesList() as $k)
        {
            $form->addHidden($this->grid->getId() . '_' . $k)->setValue($this->grid->getRequest()->get($k, ""));
        }

        $form->addSaveButton(___("Merge"));
        $form->setDataSources(array($this->grid->getCompleteRequest()));

        if ($form->isSubmitted() && $form->validate())
        {
            $values = $form->getValue();
            $this->merge($this->grid->getRecord(), Am_Di::getInstance()->userTable->findFirstByLogin($values['login']));
            $this->grid->redirectBack();
        }
        else
        {
            echo $this->renderTitle();
            echo $form;
        }
    }

    public function checkUser($login)
    {
        $user = Am_Di::getInstance()->userTable->findFirstByLogin($login);
        return (boolean)$user;
    }

    public function checkIdenticalUser($login)
    {
        $user = Am_Di::getInstance()->userTable->findFirstByLogin($login);
        return $user->pk() != $this->grid->getRecord()->pk();
    }

    protected function merge(User $target, User $source)
    {
        //module should throw Exception in case of merge is not possible
        $event = new Am_Event(Am_Event::USER_BEFORE_MERGE, array(
            'target' => $target,
            'source' => $source
        ));
        $this->getDi()->hook->call(Am_Event::USER_BEFORE_MERGE, $event);

        $this->getDi()->db->query('UPDATE ?_access SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_access_log SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_invoice SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_invoice_log SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_invoice_payment SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_invoice_refund SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
//        $this->getDi()->db->query('UPDATE ?_admin_log SET record_id=? WHERE record_id=?
//            AND tablename=?',
//            $target->pk(), $source->pk(), 'user');
        $this->getDi()->db->query('UPDATE ?_coupon_batch SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_file_download SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_upload SET user_id=? WHERE user_id=?',
            $target->pk(), $source->pk());

        $event = new Am_Event(Am_Event::USER_MERGE, array(
            'target' => $target,
            'source' => $source
        ));
        $this->getDi()->hook->call(Am_Event::USER_MERGE, $event);

        $source->delete();
        $target->save();
        $target->checkSubscriptions(true);
    }

    /**
     * @return Am_Di
     */
    protected function getDi()
    {
        return Am_Di::getInstance();
    }
}

class Am_Grid_Action_LoginAs extends Am_Grid_Action_Url {
    protected $privilege = 'login-as';
}

class Am_Grid_Filter_User extends Am_Grid_Filter_Abstract
{
    protected $title;
    public function __construct()
    {
        $this->title = ___("Filter By Username/Name/E-Mail/Invoice#/Receipt#/Remote Addr");
        parent::__construct();
    }
    public function getVariablesList()
    {
        $ret = parent::getVariablesList();
        $ret[] = 'search';
        $ret[] = 'search_load';
        return $ret;
    }
    protected function applyFilter()
    {
        // done in initFilter
    }
    protected function renderButton()
    {
        $title = Am_Controller::escape(___('Advanced Search'));
        return parent::renderButton().
          "<span style='margin-left: 1em;'></span>" .
          "<input type='button' value='$title' onclick='toggleAdvancedSearch(this)'>";
    }

    public function  renderFilter()
    {
        $query = $this->grid->getDataSource();
        $conditions = $query->getConditions();
        $title = "";
        if (count($conditions)>1 || (count($conditions)==1 && !$conditions[0] instanceof Am_Query_User_Condition_Filter))
        {
            $selfUrl = $this->grid->escape($this->grid->makeUrl(null));
            if ($name = Am_Controller::escape($query->getName())) {
                $deleteConfirm = json_encode(___("Delete Saved Search?"));
                $desc = ___("Saved Search") . ": <b>$name</b>";
                $root = Am_Controller::escape(REL_ROOT_URL);
                $id = $this->grid->getRequest()->getInt('search_load');
                $desc .= "&nbsp;<a href='$root/admin-users?_search_del=$id' class='link'
                    onclick='return confirm($deleteConfirm)' target=\"_top\">".___("Delete")."</a>";
            } else {
                $desc  = "<a href='{$selfUrl}' class='red'><b>".___("Filtered").":</b></a>&nbsp;";
                $desc .= $query->getDescription();
                $desc .= "&nbsp;<a href='javascript:;' class='link' onclick='saveAdvancedSearch(this)'>".___("Save This Search")."</a>";
            }
            $title = "<div style='text-align:left;float:left;'>&nbsp;"
                .$desc
                .'</div>' . PHP_EOL;
        }

        $filter = parent::renderFilter();
        $filter = preg_match('#^(<div class="filter-wrap">)(.*)$#is', $filter, $matches);
        return $matches[1] . $title . $matches[2];
    }

    public function renderInputs()
    {
        return $this->renderInputText('filter');
    }
    public function initFilter(Am_Grid_ReadOnly $grid)
    {
        parent::initFilter($grid);
        $query = $grid->getDataSource();
        $query->setPrefix('_u_search');
        /* @var $query Am_Query_User */
        if ($id = $grid->getCompleteRequest()->getInt('_search_del')){
            $query->deleteSaved($id);
            Am_Controller::redirectLocation(REL_ROOT_URL . '/admin-users');
            exit();
        } elseif ($id = $grid->getRequest()->getInt('search_load')){
            $query->load($id);
        } elseif (is_string($this->vars['filter']) && $this->vars['filter']){
            $cond = new Am_Query_User_Condition_Filter();
            $cond->setFromRequest(array('filter' => array('val' => $this->vars['filter'])));
            $query->add($cond);
        } else {
            $query->setFromRequest($grid->getCompleteRequest());
        }
    }
    public function isFiltered()
    {
        return (bool)$this->grid->getDataSource()->getConditions();
    }
}

class Am_Grid_Field_Decorator_Additional extends Am_Grid_Field_Decorator_Abstract
{
    /** @var Am_CustomField */
    protected $f;
    function __construct(Am_CustomField $f) {
        $this->f = $f;
    }
    function render(& $out, $obj, $controller) {
        $field = $this->f;
        $val = $field->valueFromTable($out);
        switch($field->getType()) {
            case 'date':
                $res = amDate($val);
                break;
            case 'select':
            case 'radio':
            case 'checkbox':
            case 'multi_select':
                $val = (array)$val;
                foreach ($val as $k=>$v)
                    $val[$k] = @$field->options[$v];
                $res = implode(", ", $val);
                break;
            default:
                $res = $val;
        }
        $out = $controller->renderTd($res);
    }
}

class AdminUsersController extends Am_Controller_Grid
{
    public function preDispatch()
    {
        parent::preDispatch();
        $this->setActiveMenu($this->getParam('_u_a')=='insert' ? 'users-insert' : 'users-browse');
    }

    public function getNotConfirmedCount()
    {
        return $this->getDi()->db->selectCell("SELECT COUNT(*) FROM ?_store
            WHERE name LIKE 'signup_record-%' AND CHAR_LENGTH(blob_value)>10");
    }

    public function notConfirmedAction()
    {
        $arr = array();
        foreach ($this->getDi()->db->select("SELECT `blob_value`, expires FROM ?_store
            WHERE name LIKE 'signup_record-%' AND CHAR_LENGTH(blob_value)>10") as $row)
        {
            $v = unserialize($row['blob_value']);
            $rec = array();
            foreach ($v['values'] as $page)
            {
                $rec = array_merge($rec, $page);
            }
            $rec['expires'] = $row['expires'];
            $link = Am_Controller::escape($v['opaque']['ConfirmUrl']);
            $rec['link'] = 'Give this link to customer if e-mail confirmation has not been received:'.
                '<br /><br /><pre>' . $link . '</pre><br />';
            if (empty($rec['login'])) $rec['login'] = null;
            if (empty($rec['name_f'])) $rec['name_f'] = null;
            if (empty($rec['name_l'])) $rec['name_l'] = null;
            $arr[] = (object)$rec;
        }

        $ds = new Am_Grid_DataSource_Array($arr);
        $grid = new Am_Grid_Editable('_usernc', ___("Not Confirmed Users"),
            $ds, $this->_request, $this->view, $this->getDi());
        $grid->setPermissionId('grid_u');
        $grid->addField('login', ___('Username'));
        $grid->addField('email', ___('E-Mail'));
        $grid->addField('name_f', ___('First Name'));
        $grid->addField('name_l', ___('Last Name'));
        $grid->addField(new Am_Grid_Field_Date('expires', ___('Expires')))->setFormatDate();
        $grid->addField(new Am_Grid_Field_Expandable('link', ___('Link')))->setEscape(false);
        $grid->actionsClear();

        $this->view->content = $grid->runWithLayout('admin/layout.phtml');
    }

    public function autocompleteAction()
    {
        $term = '%' . $this->getParam('term') . '%';
        if (!$term) return null;
        $q = new Am_Query($this->getDi()->userTable);
        $q->addWhere('(t.login LIKE ?) OR (t.email LIKE ?) OR (t.name_f LIKE ?) OR (t.name_l LIKE ?)',
            $term, $term, $term, $term);
        $qq = $q->query(0, 10);
        $ret = array();
        while ($r = $this->getDi()->db->fetchRow($qq))
        {
            $ret[] = array
            (
                'label' => sprintf('%s / "%s" <%s>', $r['login'], $r['name_f'] . ' ' . $r['name_l'], $r['email']),
                'value' => $r['login']
            );
        }
        if ($q->getFoundRows() > 10)
            $ret[] = array(
                'label' => sprintf("... %d more rows found ...", $q->getFoundRows() - 10),
                'value' => null,
            );
        $this->ajaxResponse($ret);
    }

    public function indexAction()
    {
        if (in_array($this->grid->getCurrentAction(), array('edit','insert')))
            $this->layout = 'admin/user-layout.phtml';
        parent::indexAction();
    }

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission('grid_u');
    }

    public function createGrid()
    {
        $ds = new Am_Query_User;
        $datetime = $this->getDi()->sqlDateTime;
        $ds->addField("concat(name_f, ' ', name_l)", 'name')
          ->addField('(SELECT COUNT(p.invoice_payment_id) FROM ?_invoice_payment p WHERE p.user_id = u.user_id)',  'payments_count')
          ->addField('ROUND(IFNULL((SELECT SUM(p.amount/p.base_currency_multi) FROM ?_invoice_payment p WHERE p.user_id = u.user_id),0)-' .
                     'IFNULL((SELECT SUM(r.amount/r.base_currency_multi) FROM ?_invoice_refund r WHERE u.user_id=r.user_id),0), 2)',
              'payments_sum')
          ->addField("(SELECT MAX(expire_date) FROM ?_access ac WHERE ac.user_id = u.user_id)", 'expire')
          ->addField("(SELECT GROUP_CONCAT(title SEPARATOR ', ') FROM ?_access ac
              LEFT JOIN ?_product p USING (product_id)
              WHERE ac.user_id = u.user_id AND ac.begin_date<='$datetime' AND ac.expire_date>='$datetime')", 'products');
        $ds->setOrder("login");
        $grid = new Am_Grid_Editable('_u', ___("Browse Users"), $ds, $this->_request, $this->view);
        $grid->setRecordTitle(array($this, 'getRecordTitle'));
        $grid->addField(new Am_Grid_Field('login', ___('Username'), true))->setRenderFunction(array($this, 'renderLogin'));
        $grid->addField(new Am_Grid_Field('name', ___('Name'), true));
        $grid->addField(new Am_Grid_Field('email', ___('E-Mail Address'), true))
            ->setRenderFunction(array($this, 'renderEmail'));
        $grid->addField(new Am_Grid_Field('payments_sum', ___('Payments'), true, null, array($this, 'renderPayments')));
        $grid->addField('status', ___('Status'), true)->setRenderFunction(array($this, 'renderStatus'));
        $grid->actionAdd($this->createActionExport());
        $grid->actionGet('edit')->setTarget('_top')->showFormAfterSave(true);
        $grid->actionGet('insert')->setTarget('_top')->showFormAfterSave(true);
        $grid->setForm(array($this, 'createForm'));
        $grid->addCallback(Am_Grid_Editable::CB_BEFORE_SAVE, array($this, 'beforeSave'));
        $grid->addCallback(Am_Grid_Editable::CB_AFTER_SAVE, array($this, 'afterSave'));
        $grid->addCallback(Am_Grid_Editable::CB_VALUES_TO_FORM, array($this, 'valuesToForm'));
        $grid->addCallback(Am_Grid_Editable::CB_RENDER_STATIC, array($this, 'renderStatic'));
        $grid->addCallback(Am_Grid_ReadOnly::CB_TR_ATTRIBS, array($this, 'getTrAttribs'));

        $grid->actionAdd($this->createActionCustomize());
        $grid->actionAdd(new Am_Grid_Action_Group_Callback('lock', ___("Lock"), array($this, 'lockUser')));
        $grid->actionAdd(new Am_Grid_Action_Group_Callback('unlock', ___("Unlock"), array($this, 'unlockUser')));
        $grid->actionAdd(new Am_Grid_Action_Group_Callback('approve', ___("Approve"), array($this, 'approveUser')));
        $grid->actionAdd(new Am_Grid_Action_Group_EmailUsers());
        $grid->actionAdd(new Am_Grid_Action_Group_MassSubscribe());
        $grid->actionAdd(new Am_Grid_Action_Group_PasswordConfirmedDelete());
        $grid->actionDelete('delete');
        $grid->actionAdd(new Am_Grid_Action_LoginAs('login', ___('Login as User'), '__ROOT__/admin-users/login-as?id=__ID__'))->setTarget('_blank');
        $grid->actionAdd(new Am_Grid_Action_Delete());
        $grid->actionAdd(new Am_Grid_Action_Merge());
        $grid->actionAdd(new Am_Grid_Action_Group_UserAssignGroup(false));
        $grid->actionAdd(new Am_Grid_Action_Group_UserAssignGroup(true));

        $nc_count = $this->getDi()->cacheFunction->call(array($this, 'getNotConfirmedCount'),
            array(), array(), 60);
        if ($nc_count)
        {
            $grid->actionAdd(new Am_Grid_Action_Url('not-confirmed',
                    ___("Not Confirmed Users") . "($nc_count)",
                    REL_ROOT_URL . '/admin-users/not-confirmed'))
                ->setType(Am_Grid_Action_Abstract::NORECORD)
                ->setTarget('_top');
        }
        $grid->setFilter(new Am_Grid_Filter_User());
//        $grid->addAction(new Am_Grid_Action_Group_Callback('email', ___("E-Mail"), array($this, 'email')));
        $grid->setEventId('gridUser');
        return $grid;
    }

    public function getRecordTitle(User $user = null)
    {
        return $user ? sprintf('%s (%s)', ___('User'), $user->login) : ___('User');
    }

    public function getTrAttribs(& $ret, $record)
    {
        if ($record->isLocked()
            || (!$record->isApproved()))
        {
            $ret['class'] = isset($ret['class']) ? $ret['class'] . ' disabled' : 'disabled';
        }
    }

    protected function createActionCustomize() {
        $stateTitleField = new Am_Grid_Field('state_title', ___('State Title'), false);
        $stateTitleField->setGetFunction(array($this, 'getStateTitle'));

        $countryTitleField = new Am_Grid_Field('country_title', ___('Country Title'), false);
        $countryTitleField->setGetFunction(array($this, 'getCountryTitle'));

        $lastSigninInfoField = new Am_Grid_Field('last_signin', ___('Last Signin Info'), false);
        $lastSigninInfoField->setGetFunction(array($this, 'getLastSigninInfo'));

        $gravatarField = new Am_Grid_Field('gravatar', ___('Gravatar'), false, null, array($this, 'renderGravatar'), '1%');

        $expireField = new Am_Grid_Field_Date('expire', ___('Expire'), false);
        $expireField->setFormatDate();

        $productsField = new Am_Grid_Field_Expandable('products', ___('Active Subscriptions'));
        $productsField->setPlaceholder(Am_Grid_Field_Expandable::PLACEHOLDER_SELF_TRUNCATE_END)
            ->setMaxLength(50);

        $userGroupField = new Am_Grid_Field('ugroup', ___('User Groups'), false);
        $userGroupField->setRenderFunction(array($this, 'renderUGroup'));

        $action = new Am_Grid_Action_Customize();
        $action->addField(new Am_Grid_Field('user_id', ___('#'), true, '', null, '1%'))
            ->addField(new Am_Grid_Field('name_f', ___('First Name')))
            ->addField(new Am_Grid_Field('name_l', ___('Last Name')))
            ->addField(new Am_Grid_Field('street', ___('Street')))
            ->addField(new Am_Grid_Field('city', ___('City')))
            ->addField(new Am_Grid_Field('state', ___('State')))
            ->addField($stateTitleField)
            ->addField(new Am_Grid_Field('zip', ___('ZIP Code')))
            ->addField(new Am_Grid_Field('country', ___('Country')))
            ->addField($countryTitleField)
            ->addField(new Am_Grid_Field('phone', ___('Phone')))
            ->addField(new Am_Grid_Field_Date('added', ___('Added')))
            ->addField($productsField)
            ->addField($userGroupField)
            ->addField(new Am_Grid_Field('status', ___('Status')))
            ->addField(new Am_Grid_Field('unsubscribed', ___('Unsubscribed')))
            ->addField(new Am_Grid_Field('lang', ___('Language')))
            ->addField(new Am_Grid_Field('is_locked', ___('Is Locked')))
            ->addField(new Am_Grid_Field('comment', ___('Comment')))
            ->addField(new Am_Grid_Field('aff_id', ___('Affiliate Id#')))
            ->addField($expireField)
            ->addField($lastSigninInfoField)
            ->addField($gravatarField);
            //Additional Fields
        foreach ($this->getDi()->userTable->customFields()->getAll() as $field) {
            if (isset($field->from_config) && $field->from_config) {
                $f = $field->sql ?
                    new Am_Grid_Field($field->name, $field->title) :
                    new Am_Grid_Field_Data($field->name, $field->title, false);
                $f->addDecorator(new Am_Grid_Field_Decorator_Additional($field));
                $f->setRenderFunction(array($this, 'renderAdditional'));
                $action->addField($f);
            }
        }

        return $action;
    }

    function renderUGroup(User $u)
    {
        $res = array();
        $options = $this->getDi()->userGroupTable->getOptions();
        foreach ($u->getGroups() as $id) {
            $res[] = $options[$id];
        }
        return $this->renderTd(implode(", ", $res));
    }

    function renderAdditional($record, $fieldName, $controller, $field)
    {
        //@see Am_Grid_Field_Decorator_Additional
        return $field->get($record, $controller, $fieldName);
    }

    function renderGravatar($record, $fieldName, $controller, $field)
    {
        return sprintf('<td><img src="%s" width="40" height="40" /></td>',
            'http://www.gravatar.com/avatar/' . md5(strtolower(trim($record->email))) . '?s=40&d=mm');
    }

    function renderEmail($record, $fieldName, $controller, $field)
    {
        return $controller->renderTd(sprintf('<a class="link" target="_top" href="mailto:%1$s">%1$s</a>',
            $this->escape($record->email)), false);
    }

    protected function createActionExport() {
        $stateTitleField = new Am_Grid_Field('state_title', ___('State Title'));
        $stateTitleField->setGetFunction(array($this, 'getStateTitle'));

        $countryTitleField = new Am_Grid_Field('country_title', ___('Country Title'));
        $countryTitleField->setGetFunction(array($this, 'getCountryTitle'));

        $lastSigninInfoField = new Am_Grid_Field('last_signin', ___('Last Signin Info'));
        $lastSigninInfoField->setGetFunction(array($this, 'getLastSigninInfo'));

        $action = new Am_Grid_Action_Export();
        $action->addField(new Am_Grid_Field('user_id', ___('User Id')))
                ->addField(new Am_Grid_Field('login', ___('Username')))
                ->addField(new Am_Grid_Field('email', ___('Email')))
                ->addField(new Am_Grid_Field('name_f', ___('First Name')))
                ->addField(new Am_Grid_Field('name_l', ___('Last Name')))
                ->addField(new Am_Grid_Field('street', ___('Street')))
                ->addField(new Am_Grid_Field('street2', ___('Street (Second Line)')))
                ->addField(new Am_Grid_Field('city', ___('City')))
                ->addField(new Am_Grid_Field('state', ___('State')))
                ->addField($stateTitleField)
                ->addField(new Am_Grid_Field('zip', ___('ZIP Code')))
                ->addField(new Am_Grid_Field('country', ___('Country')))
                ->addField($countryTitleField)
                ->addField(new Am_Grid_Field('phone', ___('Phone')))
                ->addField(new Am_Grid_Field('added', ___('Added')))
                ->addField(new Am_Grid_Field('status', ___('Status')))
                ->addField(new Am_Grid_Field('products', ___('Active Subscriptions')))
                ->addField(new Am_Grid_Field('unsubscribed', ___('Unsubscribed')))
                ->addField(new Am_Grid_Field('lang', ___('Language')))
                ->addField(new Am_Grid_Field('is_locked', ___('Is Locked')))
                ->addField(new Am_Grid_Field('comment', ___('Comment')))
                ->addField(new Am_Grid_Field('aff_id', ___('Affiliate Id#')))
                ->addField(new Am_Grid_Field('payments_sum', ___('Payments (amount of all payments made by user minus refunds)')))
                ->addField(new Am_Grid_Field('expire', ___('Expire (maximum expiration date)')))
                ->addField($lastSigninInfoField);

        //Additional Fields
        foreach ($this->getDi()->userTable->customFields()->getAll() as $field) {
            if (isset($field->from_config) && $field->from_config) {
                if ($field->sql) {
                    $action->addField(new Am_Grid_Field($field->name, $field->title));
                } else {
                    if(in_array($field->type, array('multi_select','checkbox'))){
                        //we use trailing __blob to distinguish multi select fields from data table
                        $mfield = new Am_Grid_Field($field->name . '__blob', $field->title);
                        $mfield->setGetFunction(array($this,'getMultiSelect'));
                        $action->addField($mfield);
                    }
                    else
                        //we use trailing __ to distinguish fields from data table
                        $action->addField(new Am_Grid_Field($field->name . '__', $field->title));
                }
            }
        }

        $action->setGetDataSourceFunc(array($this, 'getDS'));
        return $action;
    }

    function getStateTitle($obj, $controller, $field=null)
    {
        return $this->getDi()->stateTable->getTitleByCode($obj->country, $obj->state);
    }

    function getCountryTitle($obj, $controller, $field=null)
    {
        return $this->getDi()->countryTable->getTitleByCode($obj->country);
    }

    function getLastSigninInfo($obj, $controller, $field=null)
    {
        return $obj->last_login ? $obj->last_ip . ___(' at ') . amDatetime($obj->last_login) : ___('Never');
    }

    function getMultiSelect($obj, $controller, $field=null)
    {
        return implode(':',unserialize($obj->{$field}));
    }

    public function getDS(Am_Query $ds, $fields) {
        $i = 0;
        //join only selected fields
        foreach ($fields as $field) {
            $fn = $field->getFieldName();
            if (substr($fn, -6) == '__blob') { //multi select field from data table
                $i++;
                $field_name = substr($fn, 0, strlen($fn)-6);
                $ds = $ds->leftJoin("?_data", "d$i", "u.user_id = d$i.id AND d$i.table='user' AND d$i.key='$field_name'")
            ->addField("d$i.blob", $fn);
            }
            if (substr($fn, -2) == '__') { //field from data table
                $i++;
                $field_name = substr($fn, 0, strlen($fn)-2);
                $ds = $ds->leftJoin("?_data", "d$i", "u.user_id = d$i.id AND d$i.table='user' AND d$i.key='$field_name'")
                    ->addField("d$i.value", $fn);
            }
        }
        return $ds;
    }

    public function renderStatic(& $out, Am_Grid_Editable $grid)
    {
        $hidden = Am_Controller::renderArrayAsInputHiddens($grid->getFilter()->getAllButFilterVars());
        $out .=
            "<!-- start of advanced search box -->\n" .
            $grid->getDataSource()->renderForm($hidden) . "\n";
            "<!-- end of advanced search box -->\n";
    }
    public function lockUser($id, User $user)
    {
        $user->lock(true);
    }
    public function unlockUser($id, User $user)
    {
        $user->lock(false);
    }

    public function approveUser($id, User $user)
    {
        $user->approve();
    }
    function renderLogin($record)
    {

        $icons = "";
        if ($record->isLocked())
            $icons .= $this->view->icon('user-locked', ___('User is locked'));
        if (!$record->isApproved())
            $icons .= $this->view->icon('user-not-approved', ___('User is not approved'));
        if ($icons) $icons = '<div style="float: right;">' . $icons . '</div>';

        return $this->renderTd(sprintf('%s<a class="link" target="_top" href="%s">%s</a>',
                $icons,
                $this->escape($this->grid->getActionUrl('edit', $record->user_id)),
                $this->escape($record->login)), false);
    }

    function renderStatus(User $record)
    {
        $text = "";
        switch ($record->status)
        {
            case User::STATUS_PENDING:
                if ($record->payments_count)
                    $text = '<span class="user-status-future">' . ___('Future') . '</span>';
                else
                    $text = '<span class="user-status-pending">' . ___('Pending') . '</span>';
                break;
            case User::STATUS_ACTIVE:
                $text = '<span class="user-status-active">' . ___('Active') . '</span>';
                break;
            case User::STATUS_EXPIRED:
                $text = '<span class="user-status-expired">' . ___('Expired') . '</span>';
                break;
        }
       return $this->renderTd($text, false);
    }
    function renderPayments(User $record)
    {
        if ($record->payments_count)
        {
            $curr = new Am_Currency();
            $curr->setValue($record->payments_sum);
            $text = $record->payments_count . ' - ' . $curr->toString();
            $link = REL_ROOT_URL . "/admin-user-payments/index/user_id/{$record->user_id}";
            $text = sprintf('<a class="link" target="_top" href="%s#payments">%s</a>', $link, $text);
        } else
            $text = ___('Never');

        return sprintf('<td>%s</td>', $text);
    }
    function createForm()
    {
        return new Am_Form_Admin_User($this->grid->getRecord());
    }

/*

    public function createRecord()
    {
        $record = parent::createRecord();
        $record->added = sqlTime('now');
        $record->remote_addr = $this->_request->getClientIp();
        $record->country = null;
        return $record;
    }

    function preDispatch()
    {
        if ($this->getParam('c')) {
            $pages = $this->getPages();
            $class = $pages[$this->_request->c];
            if ($class)
                $p = new $class($this->_request, $this->_response, $this->_invokeArgs);
            else
                throw new Am_Exception_InputError("[c] parameter is wrong - could not be handled");
            $p->dispatch($this->_request->getActionName() . 'Action');
            $this->setProcessed();
            return;
        }
        if ($id = $this->getParam('loadSearch')){
            $query = $this->getAdapter()->getQuery();
            $query->load($id);
        }
        parent::preDispatch();
        $amActiveMenuID = $this->getRequest()->getActionName() == 'insert' ? 'users-insert' : 'users-browse';
        $this->setActiveMenu($amActiveMenuID);
    }
    public function renderGrid($withWrap) {
        $ret = parent::renderGrid($withWrap);
        if ($withWrap) {
            $ret .= $this->getAdapter()->getQuery()->renderForm("");
        }
        return $ret;
    }
 *
 */
    function saveSearchAction(){
        $q = new Am_Query_User();
        $search = $this->_request->get('search');
        $q->unserialize($search['serialized']);
        if (!$q->getConditions())
            throw new Am_Exception_InputError("Wrong parameters passed: no conditions : " . htmlentities($this->_request->search['serialized']));
        if (!strlen($this->getParam('name')))
            throw new Am_Exception_InputError(___("No search name passed"));
        $name = $this->getParam('name');
        $id = $q->setName($name)->save();
        $this->redirectLocation(REL_ROOT_URL . '/admin-users?_u_search_load=' . $id);
    }
    function valuesToForm(& $values, User $record)
    {
        $values['_groups'] = $record->getGroups();
    }
    function beforeSave(array &$values, User $record)
    {
        if (!empty($values['_pass']))
            $record->setPass($values['_pass']);

        if (!$record->isLoaded()) $record->is_approved = 1;
    }
    function afterSave(array &$values, User $record)
    {

        if(($this->grid->getCurrentAction() == 'insert') && @$values['_registration_mail'])
            $record->sendRegistrationEmail();

        $record->setGroups(array_filter((array)@$values['_groups']));
//        if ($this->grid->hasPermission(null, 'edit'))
//        {
//            $this->redirectLocation($this->getView()->userUrl($record->pk()));
//            exit();
//        }
    }
    function loginAsAction()
    {
        if (!$this->getDi()->authAdmin->getUser()->hasPermission('grid_u', 'login-as'))
            throw new Am_Exception_AccessDenied();

        $id = $this->getInt('id');
        if (!$id) throw new Am_Exception_InputError("Empty or no id passed");

        $user = $this->getDi()->userTable->load($id);
        $this->getDi()->auth->setUser($user, $this->getRequest()->getClientIp())->onSuccess();
        $this->redirectLocation($this->getUrl('member', "index", null));
    }
    function accessLogAction()
    {
        require_once dirname(__FILE__) . '/AdminLogsController.php';
        $c = new AdminLogsController($this->getRequest(), $this->getResponse(), $this->getInvokeArgs());
        $grid = $c->createAccess();
        $grid->removeField('member_login');
        $grid->getDataSource()->addWhere('t.user_id=?d', (int)$this->getParam('user_id'));
        $grid->runWithLayout('admin/user-layout.phtml');
    }
    function mailQueueAction()
    {
        require_once dirname(__FILE__) . '/AdminLogsController.php';
        $c = new AdminLogsController($this->getRequest(), $this->getResponse(), $this->getInvokeArgs());
        $grid = $c->createMailQueue();
        $user = $this->getDi()->userTable->load($this->getParam('user_id'));
        $grid->getDataSource()->addWhere('t.recipients LIKE ?', $user->email);
        $grid->runWithLayout('admin/user-layout.phtml');
    }
    function notApprovedAction()
    {
        $this->_redirect('admin-users?_u_search[field-is_approved][val]=0');
    }
    function resendSignupEmailAction()
    {
        $id = $this->_request->getInt('id');
        if (!$id) throw new Am_Exception_InputError("Empty id");
        $user = $this->getDi()->userTable->load($id);
        $user->sendSignupEmail();
        $this->ajaxResponse(array('success' => true));
    }
}