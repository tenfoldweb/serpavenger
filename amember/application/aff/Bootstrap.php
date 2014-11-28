<?php

class Bootstrap_Aff extends Am_Module
{
    /**
     * Event: called after inserted commission record
     *
     * @param AffCommission commission
     * @param User user
     * @param User aff
     * @param Invoice invoice
     * @param InvoicePayment payment
     */
    const AFF_COMMISSION_AFTER_INSERT = 'affCommissionAfterInsert';
    /**
     * Event: called after payouts is calculated
     *
     * @param AffPayout[] payouts
     */
    const AFF_PAYOUT = 'affPayout';
    /**
     * Event: Find affiliate for invoice
     * use $event->getReturn() to get caculated aff_id
     * use $event->setReturn() to set aff_id
     * @param Invoice $invoice
     * @param InvoicePayment|null $payment null for free trial!
     */
    const AFF_FIND_AFFILIATE = 'affFindAffiliate';
    /**
     * Event: called to retrieve available payout methods
     *
     * @see Am_Event::addReturn()
     */
    const AFF_GET_PAYOUT_OPTIONS = 'affGetPayoutOptions';

    /** Cookie name set for user visited affiliate link */
    const COOKIE_NAME = 'amember_aff_id';

    const ADMIN_PERM_ID = 'affiliates';
    
    const AFF_CUSTOM_REDIRECT_DISABLED = 0;
    const AFF_CUSTOM_REDIRECT_ALLOW_SOME_DENY_OTHERS = 1;
    const AFF_CUSTOM_REDIRECT_DENY_SOME_ALLOW_OTHERS = 2;

    const STORE_PREFIX = 'aff_signup_state-';

    protected $last_aff_id;

    function init()
    {
        parent::init();
        $this->getDi()->userTable->customFields()->addCallback(array('Am_Aff_PayoutMethod', 'static_addFields'));

        $this->getDi()->uploadTable->defineUsage('affiliate', 'aff_banner', 'upload_id', UploadTable::STORE_FIELD, "Affiliate Marketing Material [%title%, %desc%]", '/aff/admin-banners/p/downloads/index');
        $this->getDi()->uploadTable->defineUsage('banners', 'aff_banner', 'upload_id', UploadTable::STORE_FIELD, "Affiliate Banner [%title%, %desc%]", '/aff/admin-banners/p/banners/index');
        $this->getDi()->uploadTable->defineUsage('banners', 'aff_banner', 'upload_big_id', UploadTable::STORE_FIELD, "Affiliate Banner [%title%, %desc%]", '/aff/admin-banners/p/banners/index');
    }

    function _renderInvoiceCommissions(Am_View $view)
    {
        return $this->renderInvoiceCommissions($view->invoice, $view);
    }

    function renderInvoiceCommissions(Invoice $invoice, Am_View $view)
    {
        $query = new Am_Query($this->getDi()->affCommissionTable);
        $query->leftJoin('?_invoice', 'i', 'i.invoice_id=t.invoice_id');
        $query->leftJoin('?_user', 'a', 't.aff_id=a.user_id');
        $query->leftJoin('?_product', 'p', 't.product_id=p.product_id');
        $query->addField('CONCAT(a.login, \' (\', a.name_f, \' \', a.name_l,\') [#\', a.user_id, \']\')', 'aff_name')
            ->addField('p.title', 'product_title')
            ->addField('IF(payout_detail_id IS NULL, \'no\', \'yes\')', 'is_paid');
        $query->setOrder('commission_id', 'desc');
        $query->addWhere('t.invoice_id=?', $invoice->pk());

        $items = $query->selectAllRecords();
        if (!$items) return;
        $view->comm_items = $items;
        return $view->render('blocks/admin-user-invoice-details.phtml');
    }

    function renderAlert()
    {
        if ($user_id = $this->getDi()->auth->getUserId()) {
            $user = $this->getDi()->auth->getUser();
            if ($user->is_affiliate > 0 && !in_array($user->aff_payout_type, $this->getConfig('payout_methods', array()))) {
                return '<div class="am-info">' . ___('Please %sdefine payout method%s to get commission in our affiliate program.',
                    '<a href="' . REL_ROOT_URL . '/aff/member/payout-info">', '</a>') . '</div>';
            }
        }
    }

    function onClearItems(Am_Event $event)
    {
        $event->addReturn(array(
            'method' => array($this->getDi()->affClickTable, 'clearOld'),
            'title' => 'Affiliate Clicks',
            'desc' => ''
            ), 'aff_click');
    }

    function onInvoiceAfterDelete(Am_Event $e)
    {
        $this->getDi()->affCommissionTable->deleteByInvoiceId($e->getInvoice()->pk());
    }

    function onAdminWarnings(Am_Event $event)
    {
        $cnt = $this->getConfig('payout_methods');

        if (empty($cnt))
            $event->addReturn(___('Please %senable at least one payout method%s since you use affiliate module',
                    sprintf('<a href="%s" class="link">', REL_ROOT_URL . '/admin-setup/aff'), '</a>'));
    }

    function onSetupEmailTemplateTypes(Am_Event $event)
    {
        $event->addReturn(array(
            'id' => 'aff.mail_sale_user',
            'title' => 'Aff Mail Sale User',
            'mailPeriodic' => Am_Mail::USER_REQUESTED,
            'vars' => array(
                'user',
                'affiliate',
                'amount' => ___('Total Amount of Payment'),
                'tier' => ___('Affiliate Tier')),
            ), 'aff.mail_sale_user');
        $event->addReturn(array(
            'id' => 'aff.mail_sale_admin',
            'title' => 'Aff Mail Sale Admin',
            'mailPeriodic' => Am_Mail::USER_REQUESTED,
            'vars' => array(
                'user',
                'affiliate',
                'amount' => ___('Total Amount of Payment'),
                'tier' => ___('Affiliate Tier')),
            ), 'aff.mail_sale_admin');
        $event->addReturn(array(
            'id' => 'aff.notify_payout_empty',
            'title' => 'Empty Payout Method Notification to User',
            'mailPeriodic' => Am_Mail::USER_REQUESTED,
            'vars' => array(
                'affiliate'
            )), 'aff.notify_payout_empty');
        $event->addReturn(array(
            'id' => 'aff.notify_payout_paid',
            'title' => 'Affiliate Payout Paid Notification to User',
            'mailPeriodic' => Am_Mail::REGULAR,
            'vars' => array(
                'affiliate',
                'payout.threshold_date' => ___('Threshold Date'),
                'payout_detail.amount' => ___('Amount'),
                'payout_method_title' => ___('Payout Method Title')
            )), 'aff.notify_payout_paid');
    }

    function onUserMerge(Am_Event $event)
    {
        $target = $event->getTarget();
        $source = $event->getSource();

        $this->getDi()->db->query('UPDATE ?_aff_click SET aff_id=? WHERE aff_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_aff_commission SET aff_id=? WHERE aff_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_aff_lead SET aff_id=? WHERE aff_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_aff_payout_detail SET aff_id=? WHERE aff_id=?',
            $target->pk(), $source->pk());
        $this->getDi()->db->query('UPDATE ?_user SET aff_id=? WHERE aff_id=?',
            $target->pk(), $source->pk());
    }

    function onGetMemberLinks(Am_Event $e)
    {
        $u = $e->getUser();
        if (!$u->is_affiliate && !$this->getDi()->config->get('aff.signup_type'))
            $e->addReturn(___('Advertise our website to your friends and earn money'),
                ROOT_URL . '/aff/aff/enable-aff');
    }

    function onGetUploadPrefixList(Am_Event $event)
    {
        $event->addReturn(array(
            Am_Upload_Acl::IDENTITY_TYPE_ADMIN => array(
                self::ADMIN_PERM_ID => Am_Upload_Acl::ACCESS_ALL
            ),
            Am_Upload_Acl::IDENTITY_TYPE_USER => Am_Upload_Acl::ACCESS_READ,
            Am_Upload_Acl::IDENTITY_TYPE_ANONYMOUS => Am_Upload_Acl::ACCESS_READ
            ), "banners");

        $event->addReturn(array(
            Am_Upload_Acl::IDENTITY_TYPE_ADMIN => array(
                self::ADMIN_PERM_ID => Am_Upload_Acl::ACCESS_ALL
            ),
            Am_Upload_Acl::IDENTITY_TYPE_AFFILIATE => Am_Upload_Acl::ACCESS_READ
            ), "affiliate");
    }

    function onGetPermissionsList(Am_Event $event)
    {
        $event->addReturn("Can see affiliate info/make payouts", self::ADMIN_PERM_ID);
    }

    function onUserMenu(Am_Event $event)
    {
        if (!$event->getUser()->is_affiliate)
            return;
        $event->getMenu()->addPage(
            array(
                'id' => 'aff',
                'controller' => 'aff',
                'module' => 'aff',
                'label' => ___('Affiliate Info'),
                'order' => 300,
                'pages' => array(
                    array(
                        'id' => 'aff-links',
                        'controller' => 'aff',
                        'module' => 'aff',
                        'label' => ___('Get affiliate banners and links'),
                    ),
                    array(
                        'id' => 'aff-stats',
                        'controller' => 'member',
                        'module' => 'aff',
                        'action' => 'stats',
                        'label' => ___('Review your affiliate statistics'),
                    ),
                    array(
                        'id' => 'aff-payout-info',
                        'controller' => 'member',
                        'module' => 'aff',
                        'action' => 'payout-info',
                        'label' => ___('Update your commissions payout info'),
                    ),
                ),
            )
        );
    }

    function onAdminMenu(Am_Event $event)
    {
        $menu = $event->getMenu();
        $menu->addPage(array(
            'id' => 'affiliates',
            'uri' => 'javascript:;',
            'label' => ___('Affiliates'),
            'resource' => self::ADMIN_PERM_ID,
            'pages' => array_merge(array(
                array(
                    'id' => 'affiliates-commission-rules',
                    'controller' => 'admin-commission-rule',
                    'module' => 'aff',
                    'label' => ___('Commission Rules'),
                    'resource' => self::ADMIN_PERM_ID,
                ),
                array(
                    'id' => 'affiliates-payout',
                    'controller' => 'admin-payout',
                    'module' => 'aff',
                    'label' => ___("Review/Pay Affiliate Commission"),
                    'resource' => self::ADMIN_PERM_ID,
                ),
                array(
                    'id' => 'affiliates-commission',
                    'controller' => 'admin-commission',
                    'module' => 'aff',
                    'label' => ___('Affiliate Clicks/Sales Statistics'),
                    'resource' => self::ADMIN_PERM_ID,
                ),
                array(
                    'id' => 'affiliates-banners',
                    'controller' => 'admin-banners',
                    'module' => 'aff',
                    'label' => ___('Manage Banners and Text Links'),
                    'resource' => self::ADMIN_PERM_ID,
                )
                ),
                !Am_Di::getInstance()->config->get('manually_approve') && (Am_Di::getInstance()->config->get('aff.signup_type') != 2) ? array() : array(array(
                        'id' => 'user-not-approved',
                        'controller' => 'admin-users',
                        'action' => 'not-approved',
                        'label' => ___('Not Approved Affiliates'),
                        'resource' => 'grid_u',
                        'privilege' => 'browse',
                    ))
            )
        ));
    }

    public function addPayoutInputs(HTML_QuickForm2_Container $fieldSet)
    {
        $el = $fieldSet->addSelect('aff_payout_type')
                ->setLabel(___('Affiliate Payout Type'))
                ->loadOptions(array_merge(array('' => ___('Not Selected'))));
        foreach (Am_Aff_PayoutMethod::getEnabled() as $method)
            $el->addOption($method->getTitle(), $method->getId());

        $fieldSet->addScript()->setScript('
/**** show only options for selected payout method */
$(function(){
$("#' . $el->getId() . '").change(function()
{
    var selected = $("#' . $el->getId() . '").val();
    $("option", $(this)).each(function(){
        var option = $(this).val();
        if(option == selected){
            $("input[name^=aff_"+option+"_]").closest(".row").show();
        }else{
            $("input[name^=aff_"+option+"_]").closest(".row").hide();
        }
    });
}).change();
});
/**** end of payout method options */
');

        foreach ($this->getDi()->userTable->customFields()->getAll() as $f)
            if (strpos($f->name, 'aff_') === 0)
                $f->addToQf2($fieldSet);
    }

    public function onGridCouponInitGrid(Am_Event_Grid $event)
    {
        $event->getGrid()->addField('aff_id', ___('Affiliate'))
            ->setRenderFunction(array($this, 'renderAffiliate'));
        $event->getGrid()->actionAdd(new Am_Grid_Action_LiveEdit('aff_id', ___('Click to Assign')))
            ->setInitCallback('l = function(){this.autocomplete({
    minLength: 2,
    source: window.rootUrl + "/aff/admin/autocomplete/"
});}')
            ->getDecorator()->setInputTemplate(sprintf('<input type="text" placeholder="%s" />',
                ___('Type Username or E-Mail')));
        $event->getGrid()->addCallback(Am_Grid_ReadOnly::CB_RENDER_CONTENT, array($this, 'couponRenderContent'));
    }

    public function couponRenderContent(& $out)
    {
        $out = sprintf('<div class="info">%s</div>', ___('You can assign some coupon codes to specific affiliate. This affiliate will get commission for payment
in case of coupon is used during payment. This affiliate will be assigned to user as default affiliate in case of user has not default affiliate assigned yet.')) . $out;
    }

    public function onCouponBeforeUpdate(Am_Event $event)
    {
        $coupon = $event->getCoupon();
        if (!$coupon->aff_id)
            $coupon->aff_id = null;
        if (!is_numeric($coupon->aff_id)) {
            $user = $this->getDi()->userTable->findFirstByLogin($coupon->aff_id);
            $coupon->aff_id = $user ? $user->pk() : null;
        }
    }

    public function renderAffiliate($rec)
    {
        $aff = $rec->aff_id ?
            $this->getDi()->userTable->load($rec->aff_id, false) :
            null;

        return $aff ?
            sprintf('<td>%s</td>', Am_Controller::escape($aff->login)) :
            '<td></td>';
    }

    public function onGridCouponBatchBeforeSave(Am_Event_Grid $event)
    {
        $input = $event->getGrid()->getForm()->getValue();
        if (!empty($input['_aff'])) {
            $aff = $this->getDi()->userTable->findFirstByLogin($input['_aff'], false);
            if ($aff) {
                $event->getGrid()->getRecord()->aff_id = $aff->pk();
            } else {
                throw new Am_Exception_InputError("Affiliate not found, username specified: " . Am_Controller::escape($input['_aff']));
            }
        } elseif (isset($input['_aff']) && $input['_aff'] == '') {
            //reset affiliate
            $event->getGrid()->getRecord()->aff_id = null;
        }
    }

    function onGridCouponBatchInitForm(Am_Event $event)
    {
        /* @var $form Am_Form_Admin */
        $form = $event->getGrid()->getForm();

        $fieldSet = $form->getElementById('coupon-batch');

        $batch = $event->getGrid()->getRecord();
        $affGroup = $fieldSet->addGroup()
                ->setLabel(array(___('Affiliate'),
                    ___("this affiliate will get commission for payment in case of " .
                    "coupon from this batch is used during payment. " .
                    "This affiliate will be assigned to user as default affiliate " .
                    "in case of user has not default affiliate assigned yet.")));

        $affEl = $affGroup->addText('_aff', array('placeholder' => ___('Type Username or E-Mail')))
                ->setId('aff-affiliate');
        $fieldSet->addScript()->setScript(<<<CUT
    $("input#aff-affiliate").autocomplete({
        minLength: 2,
        source: window.rootUrl + "/aff/admin/autocomplete/"
    });
CUT
        );

        if (!empty($batch->aff_id)) {
            try {
                $aff = $this->getDi()->userTable->load($batch->aff_id);
                $affEl->setValue($aff->login);
                $affEl->setAttribute('style', 'display:none');
                $url = new Am_View_Helper_UserUrl;
                $affHtml = sprintf('<div><a href="%s">%s %s (%s)</a> [<a href="javascript:;" title="%s" class="local" id="aff-unassign-affiliate">x</a>]</div>',
                        Am_Controller::escape($url->userUrl($batch->aff_id)),
                        $aff->name_f, $aff->name_l, $aff->email, ___('Unassign Affiliate')
                );
                $affGroup->addStatic()
                    ->setContent($affHtml);

                $affGroup->addScript()->setScript(<<<CUT
$('#aff-unassign-affiliate').click(function(){
    $(this).closest('div').remove();
    $('#aff-affiliate').val('');
    $('#aff-affiliate').show();
})
CUT
                );
            } catch (Am_Exception $e) {
                // ignore if affiliate was deleted
            }
        }
    }

    public function onGridUserBeforeSave(Am_Event_Grid $event)
    {
        $input = $event->getGrid()->getForm()->getValue();
        if (!empty($input['_aff'])) {
            $aff = $this->getDi()->userTable->findFirstByLogin($input['_aff'], false);
            if ($aff) {
                if ($aff->pk() == $event->getGrid()->getRecord()->pk()) {
                    throw new Am_Exception_InputError("Cannot assign affiliate to himself");
                }
                if ($event->getGrid()->getRecord()->aff_id != $aff->pk()) {
                    $event->getGrid()->getRecord()->aff_id = $aff->pk();
                    $event->getGrid()->getRecord()->aff_added = sqlTime('now');
                    $event->getGrid()->getRecord()->data()->set('aff-source', 'admin-' . $this->getDi()->authAdmin->getUserId());
                }
            } else {
                throw new Am_Exception_InputError("Affiliate not found, username specified: " . Am_Controller::escape($input['_aff']));
            }
        } elseif (isset($input['_aff']) && $input['_aff'] == '') {
            //reset affiliate
            $event->getGrid()->getRecord()->aff_id = null;
            $event->getGrid()->getRecord()->aff_added = null;
            $event->getGrid()->getRecord()->data()->set('aff-source', null);
        }
    }

    public function onGridUserInitForm(Am_Event_Grid $event)
    {
        $fieldSet = $event->getGrid()->getForm()->addAdvFieldset('affiliate')->setLabel(___('Affiliate Program'));

        $user = $event->getGrid()->getRecord();
        $user_id = $user->pk();
        $affGroup = $fieldSet->addGroup()
                ->setLabel(___('Referred Affiliate'));

        $affEl = $affGroup->addText('_aff', array('placeholder' => ___('Type Username or E-Mail')))
                ->setId('aff-refered-affiliate');
        $fieldSet->addScript()->setScript(<<<CUT
    $("input#aff-refered-affiliate").autocomplete({
        minLength: 2,
        source: window.rootUrl + "/aff/admin/autocomplete/?exclude=$user_id"
    });
CUT
        );

        if (!empty($user->aff_id)) {
            try {
                $aff = $this->getDi()->userTable->load($user->aff_id);
                $affEl->setValue($aff->login);
                $affEl->setAttribute('style', 'display:none');
                $url = new Am_View_Helper_UserUrl;

                $is_expired = false;
                if ($commissionDays = $this->getDi()->config->get('aff.commission_days')) {
                    $signupDays = $this->getDi()->time - strtotime($user->aff_added ? $user->aff_added : $user->added);
                    $signupDays = intval($signupDays / (3600*24)); // to days
                    if ($commissionDays < $signupDays)
                        $is_expired = true;
                }

                $affHtml = sprintf('<div><a class="link" href="%s">%s %s (%s)</a> [<a href="javascript:;" title="%s" class="local" id="aff-unassign-affiliate">x</a>]%s</div>',
                        Am_Controller::escape($url->userUrl($user->aff_id)),
                        $aff->name_f, $aff->name_l, $aff->email, ___('Unassign Affiliate'),
                        ($is_expired ? sprintf('<div class="red">%s</div>', ___('affiliate <-> user relation is expired (%saccording your settings%s <strong>User-Affiliate Relation Lifetime</strong> is %d day(s)), no commissions will be added for new payments',
                            '<a href="' . REL_ROOT_URL . '/admin-setup/aff">', '</a>', $commissionDays)): '')
                );
                $affGroup->addStatic()
                    ->setContent($affHtml);

                $affGroup->addScript()->setScript(<<<CUT
$('#aff-unassign-affiliate').click(function(){
    $(this).closest('div').remove();
    $('#aff-refered-affiliate').val('');
    $('#aff-refered-affiliate').show();
})
CUT
                );
            } catch (Am_Exception $e) {
                // ignore if affiliate was deleted
            }
        }

        if ($user->isLoaded() && ($source = $user->data()->get('aff-source'))) {
            preg_match('/^([a-z]*)(-(.*))?$/i', $source, $match);
            $res = '';
            switch ($match[1]) {
                case 'ip':
                    $res = ___('Assigned by IP <strong>%s</strong> at %s', $match[3], amDatetime($user->aff_added));
                    break;
                case 'cookie':
                    $res = ___('Assigned by COOKIE at %s', amDatetime($user->aff_added));
                    break;
                case 'admin':
                    $admin = $this->getDi()->adminTable->load($match[3], false);
                    $res = ___('Assigned by Administrator <strong>%s</strong> at %s', $admin ?
                        sprintf('%s (%s %s)', $admin->login, $admin->name_f, $admin->name_l) :
                        '#' . $match[3], amDatetime($user->aff_added));
                    break;
                case 'coupon':
                    $res = ___('Assigned by Coupon %s at %s',
                        '<a href="' . REL_ROOT_URL .'/admin-coupons?_coupon_filter=' . urlencode($match[3]) . '">' . $match[3] . '</a>',
                        amDatetime($user->aff_added));
                    break;
                case 'invoice':
                    $invoice = $this->getDi()->invoiceTable->load($match[3], false);
                    $res = ___('Assigned by Invoice %s at %s', $invoice ?
                            '<a href="' . REL_ROOT_URL .'/admin-user-payments/index/user_id/' . $invoice->user_id . '#invoice-' . $invoice->pk() . '">' .
                            $invoice->pk() . '/' .  $invoice->public_id  . '</a>' :
                            '<strong>#' . $match[3] . '</strong>', amDatetime($user->aff_added));
                    break;
                default;
                    $res = $source;
            }

            $fieldSet->addHtml()
                ->setLabel(___('Affiliate Source'))
                ->setHtml('<div>' . $res . '</div>');
        }

        $fieldSet->addElement('advradio', 'is_affiliate')
            ->setLabel(array(___('Is Affiliate?'), ___('customer / affiliate status')))
            ->loadOptions(array(
                '0' => ___('No'),
                '1' => ___('Both Affiliate and member'),
                '2' => ___('Only Affiliate %s(rarely used)%s', '<em>', '</em>'),
            ))->setValue($this->getConfig('signup_type') == 1 ? 1 : 0);
        if($cr = $this->getConfig('custom_redirect'))
            $fieldSet->addElement('advradio', 'aff_custom_redirect')
                ->setLabel(___('Allow Affiliate to redirect Referrers to any url'))
                ->loadOptions(array(
                    '0' => $cr == self::AFF_CUSTOM_REDIRECT_ALLOW_SOME_DENY_OTHERS ? ___('No') : ___('Yes'),
                    '1' => $cr == self::AFF_CUSTOM_REDIRECT_DENY_SOME_ALLOW_OTHERS ? ___('No') : ___('Yes')
                    ));

        $this->addPayoutInputs($fieldSet);
    }

    function onUserTabs(Am_Event_UserTabs $event)
    {
        if ($event->getUserId() > 0) {
            $user = $this->getDi()->userTable->load($event->getUserId());
            if ($user->is_affiliate > 0) {
                $event->getTabs()->addPage(array(
                    'id' => 'aff',
                    'uri' => '#',
                    'label' => ___('Affiliate Info'),
                    'order' => 1000,
                    'resource' => self::ADMIN_PERM_ID,
                    'pages' => array(
                        array(
                            'id' => 'aff-stat',
                            'module' => 'aff',
                            'controller' => 'admin',
                            'action' => 'info-tab',
                            'params' => array(
                                'user_id' => $event->getUserId(),
                            ),
                            'label' => ___('Statistics'),
                            'resource' => self::ADMIN_PERM_ID
                        ),
                        array(
                            'id' => 'aff-subaff',
                            'module' => 'aff',
                            'controller' => 'admin',
                            'action' => 'subaff-tab',
                            'params' => array(
                                'user_id' => $event->getUserId(),
                            ),
                            'label' => ___('Sub-Affiliates'),
                            'resource' => self::ADMIN_PERM_ID,
                        ),
                        array(
                            'id' => 'aff-comm',
                            'module' => 'aff',
                            'controller' => 'admin',
                            'action' => 'comm-tab',
                            'params' => array(
                                'user_id' => $event->getUserId(),
                            ),
                            'label' => ___('Commissions'),
                            'resource' => self::ADMIN_PERM_ID,
                        ),
                        array(
                            'id' => 'aff-payout',
                            'module' => 'aff',
                            'controller' => 'admin',
                            'action' => 'payout-tab',
                            'params' => array(
                                'user_id' => $event->getUserId(),
                            ),
                            'label' => ___('Payouts'),
                            'resource' => self::ADMIN_PERM_ID,
                        )
                    )
                ));
            }
        }
    }

    /**
     * if $_COOKIE is empty, find matches for user by IP address in aff_clicks table
     * @param Am_Event_UserBeforeInsert $event 
     */
    function onUserBeforeInsert(Am_Event_UserBeforeInsert $event)
    {
        // skip this code if running from aMember CP
        if (defined('AM_ADMIN') && AM_ADMIN)
            return;
        $aff_id = !empty($_COOKIE[self::COOKIE_NAME]) ? $_COOKIE[self::COOKIE_NAME] : null;
        $aff_source = null;
        //backwards compatiablity of affiliate cookies
        //first fragment of affiliate cookie can be <int> user_id
        //or base64_encoded login
        $aff_info = explode('-', $aff_id);
        if ($aff_info[0] && !is_numeric($aff_info[0])) {
            $login = base64_decode($aff_info[0]);
            if ($user = $this->getDi()->userTable->findFirstByLogin($login)) {
                $aff_id = preg_replace('/^.*?-/i', $user->pk() . '-', $aff_id);
                $aff_source = 'cookie';
            } else {
                $aff_id = null;
            }
        }
        if (empty($aff_id)) {
            $aff_id = $this->getDi()->affClickTable->findAffIdByIp($_SERVER['REMOTE_ADDR']);
            $aff_source = 'ip-' . $_SERVER['REMOTE_ADDR'];
        }
        // remember for usage in onUserAfterInsert
        $this->last_aff_id = $aff_id;
        if ($aff_id > 0) {
            $event->getUser()->aff_id = intval($aff_id);
            $event->getUser()->aff_added = sqlTime('now');
            if ($aff_source)
                $event->getUser()->data()->set('aff-source', $aff_source);
        }
        if (empty($event->getUser()->is_affiliate))
            $event->getUser()->is_affiliate = $this->getDi()->config->get('aff.signup_type') == 1 ? 1 : 0;
    }

    function onUserAfterInsert(Am_Event_UserAfterInsert $event)
    {
        // skip this code if running from aMember CP @see $this->onUserBeforeInsert()
        if (preg_match('/^(\d+)-(\d+)-(\d+)$/', $this->last_aff_id, $regs)) {
            $this->getDi()->affLeadTable->log($regs[1], $regs[2], $event->getUser()->pk(), $this->decodeClickId($regs[3]));
        }
    }

    function onUserAfterDelete(Am_Event_UserAfterDelete $event)
    {
        foreach (array('?_aff_click', '?_aff_commission', '?_aff_lead') as $table)
            $this->getDi()->db->query("DELETE FROM $table WHERE aff_id=?", $event->getUser()->user_id);
    }

    function onUserAfterUpdate(Am_Event_UserAfterUpdate $e)
    {
        if ($e->getUser()->is_approved && !$e->getOldUser()->is_approved && $e->getUser()->is_affiliate)
            $this->sendAffRegistrationEmail($e->getUser());
    }

    /**
     * Handle free signups
     */
    function onInvoiceStarted(Am_Event_InvoiceStarted $event)
    {
        $invoice = $event->getInvoice();
        $isFirst = !$this->getDi()->db->selectCell("SELECT COUNT(*)
            FROM ?_invoice
            WHERE user_id=?
            AND invoice_id<>?
            AND tm_started IS NOT NULL",
                $invoice->user_id, $invoice->pk());

        if (($invoice->first_total == 0) &&
            ($invoice->second_total == 0) &&
            $isFirst) {
            $this->getDi()->affCommissionRuleTable->processPayment($invoice);
        }
    }

    /**
     * Handle payments
     */
    function onPaymentAfterInsert(Am_Event_PaymentAfterInsert $event)
    {
        $this->getDi()->affCommissionRuleTable->processPayment($event->getInvoice(), $event->getPayment());
    }

    /**
     * Handle refunds
     */
    function onRefundAfterInsert(Am_Event $event)
    {
        $this->getDi()->affCommissionRuleTable->processRefund($event->getInvoice(), $event->getRefund());
    }

    function onAffCommissionAfterInsert(Am_Event $event)
    {
        $user = $event->getUser();
        if (!$user->aff_id) {
            $user->aff_id = $event->getAff()->pk();
            $user->aff_added = sqlTime('now');
            $user->data()->set('aff-source', 'invoice-' . $event->getInvoice()->pk());
            $user->save();
        }

        /* @var $commission AffCommission */
        $commission = $event->getCommission();
        if ($commission->record_type == AffCommission::VOID)
            return; // void

        if (empty($commission->invoice_item_id))
            return;
        /* @var $invoice_item InvoiceItem */
        $invoice_item = $this->getDi()->invoiceItemTable->load($commission->invoice_item_id);
        $amount = $commission->is_first ? $invoice_item->first_total : $invoice_item->second_total;

        if ($this->getConfig('mail_sale_admin')) {
            if ($et = Am_Mail_Template::load('aff.mail_sale_admin'))
                $et->setPayment($commission->getPayment())
                    ->setInvoice($invoice = $commission->getInvoice())
                    ->setAffiliate($commission->getAff())
                    ->setUser($invoice->getUser())
                    ->setCommission($commission->amount)
                    ->setTier($commission->tier + 1)
                    ->setProduct($this->getDi()->productTable->load($commission->product_id, false))
                    ->setInvoiceItem($invoice_item)
                    ->setAmount($amount)
                    ->sendAdmin();
        }
        if ($this->getConfig('mail_sale_user')) {
            if ($et = Am_Mail_Template::load('aff.mail_sale_user'))
                $et->setPayment($commission->getPayment())
                    ->setInvoice($invoice = $commission->getInvoice())
                    ->setAffiliate($commission->getAff())
                    ->setUser($invoice->getUser())
                    ->setCommission($commission->amount)
                    ->setTier($commission->tier + 1)
                    ->setProduct($this->getDi()->productTable->load($commission->product_id, false))
                    ->setInvoiceItem($invoice_item)
                    ->setAmount($amount)
                    ->send($commission->getAff());
        }

        if ($this->getConfig('notify_payout_empty')) {
            $aff = $event->getAff();
            if (in_array($aff->aff_payout_type, $this->getConfig('payout_methods', array())) ||
                $aff->data()->get('notify_payout_empty_sent')) {
                return;
            }

            $aff->data()->set('notify_payout_empty_sent', 1);
            $aff->save();

            $et = Am_Mail_Template::load('aff.notify_payout_empty', $aff->lang);
            $et->setAffiliate($aff)
                ->send($aff);
        }
    }

    function onSignupStateSave(Am_Event $e)
    {
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            $code = $e->getCode();
            $this->getDi()->store->set(self::STORE_PREFIX . $code, $_COOKIE[self::COOKIE_NAME], '+12 hours');
        }
    }

    function onSignupStateLoad(Am_Event $e)
    {
        $code = $e->getCode();
        if ($cookie = $this->getDi()->store->get(self::STORE_PREFIX . $code)) {
            $tm = $this->getDi()->time + $this->getDi()->config->get('aff.cookie_lifetime', 30) * 3600 * 24;
            Am_Controller::setCookie(self::COOKIE_NAME, $cookie, $tm, '/', $_SERVER['HTTP_HOST']);
            $_COOKIE[self::COOKIE_NAME] = $cookie;
        }
    }

    // utility functions
    function setCookie(User $aff, /* AffBanner */  $banner, $aff_click_id = null)
    {
        $tm = $this->getDi()->time + $this->getDi()->config->get('aff.cookie_lifetime', 30) * 3600 * 24;
        $val = base64_encode($aff->login);
        $val .= '-' . ($banner ? $banner->pk() : "0");
        if ($aff_click_id)
            $val .= '-' . $this->encodeClickId($aff_click_id);
        Am_Controller::setCookie(self::COOKIE_NAME, $val, $tm, '/', $_SERVER['HTTP_HOST']);
    }

    function encodeClickId($id)
    {
        // we use only part of key to don't give attacker enough results to guess key
        $key = crc32(substr($this->getDi()->app->getSiteKey(), 1, 9)) % 100000;
        return $id + $key;
    }

    function decodeClickId($id)
    {
        $key = crc32(substr($this->getDi()->app->getSiteKey(), 1, 9)) % 100000;
        return $id - $key;
    }

    /**
     * run payouts when scheduled
     */
    function onDaily(Am_Event $event)
    {
        $delay = $this->getConfig('payout_day');
        if (!$delay)
            return;
        list($count, $unit) = preg_split('/(\D)/', $delay, 2, PREG_SPLIT_DELIM_CAPTURE);
        switch ($unit) {
            case 'd':
                if ($count != (int) date('d', amstrtotime($event->getDatetime())))
                    return;
                break;
            case 'w':
                $w = date('w', amstrtotime($event->getDatetime()));
                if ($count != $w)
                    return;
                break;
            default :
                throw new Am_Exception_InternalError(sprintf('Unknown unit [%s] in %s::%s',
                    $unit, __CLASS__, __METHOD__));
        }
        $this->getDi()->affCommissionTable->runPayout(sqlDate($event->getDatetime()));
    }

    function onBuildDemo(Am_Event $event)
    {
        $referrers = array(
            'http://example.com/some/url.html',
            'http://example.com/some/other/url.html',
            'http://example.com/page/offer.html',
            'http://example.com/very/very/long/referrer/url.html',
            'http://example.com/referrer.html'
        );

        static $banners = null;
        if (is_null($banners)) {
            $banners = $this->getDi()->affBannerTable->findBy();
            array_push($banners, null);
        }

        $user = $event->getUser();
        $user->is_affiliate = 1;
        $user->aff_payout_type = 'check';
        if (rand(0, 10) < 4) {
            $aff_id = $this->getDi()->db->selectCell("SELECT `id`
                FROM ?_data
                WHERE `table`='user' AND `key`='demo-id' AND `value`=?
                LIMIT ?d, 1",
                    $event->getDemoId(), rand(0, $event->getUsersCreated()));
            if ($aff_id) {
                $aff = $this->getDi()->userTable->load($aff_id);
                $banner = $banners[array_rand($banners)];
                $banner_id = $banner ? $banner->pk() : null;
                $user->aff_id = $aff_id;
                $user->aff_added = $user->added;
                $user->data()->set('aff-source', 'cookie');
                $server = $_SERVER;

                $_SERVER['REMOTE_ADDR'] = $user->remote_addr;
                $_SERVER['HTTP_REFERER'] = $referrers[array_rand($referrers)];

                $this->getDi()->setService('time', amstrtotime($user->added) - rand(5*60,3600));
                $aff_click_id = $this->getDi()->affClickTable->log($aff, $banner);

                $this->getDi()->setService('time', amstrtotime($user->added));
                $this->getDi()->affLeadTable->log($aff_id, $banner_id, $user->pk(), $aff_click_id);

                $_SERVER = $server;
                $this->getDi()->setService('time', time());
            }
        }
    }

    function onSavedFormTypes(Am_Event $event)
    {
        $event->getTable()->addTypeDef(array(
            'type' => 'aff',
            'class' => 'Am_Form_Signup_Aff',
            'title' => ___('Affiliate Signup Form'),
            'defaultTitle' => ___('Affiliate Signup Form'),
            'defaultComment' => '',
            'generateCode' => false,
            'urlTemplate' => 'aff/signup',
            'isSingle' => true,
            'isSignup' => true,
            'noDelete' => true,
        ));
    }

    function onLoadReports()
    {
        include_once APPLICATION_PATH . '/aff/library/Reports.php';
    }

    function sendAffRegistrationEmail(User $user)
    {
        if ($et = Am_Mail_Template::load('aff.registration_mail', $user->lang)) {
            $et->setUser($user);
            $et->password = $user->getPlaintextPass();
            $et->send($user);
        }
    }

    function onDbUpgrade(Am_Event $e)
    {
        if (version_compare($e->getVersion(), '4.2.6') < 0) {
            echo "Convert commission rule type...";
            if (ob_get_level ())
                ob_end_flush();
            $this->getDi()->db->query("UPDATE ?_aff_commission_rule SET type=?, tier=? WHERE type=?", 'global', 0, 'global-1');
            $this->getDi()->db->query("UPDATE ?_aff_commission_rule SET type=?, tier=? WHERE type=?", 'global', 1, 'global-2');
            echo "Done<br>\n";
        }
        if (version_compare($e->getVersion(), '4.2.20') < 0) {
            echo "Normalize sort order for aff banners and links...";
            if (ob_get_level ())
                ob_end_flush();
            $this->getDi()->db->query("SET @i = 0");
            $this->getDi()->db->query("UPDATE ?_aff_banner SET sort_order=(@i:=@i+1) ORDER BY IF(sort_order = 0, ~0, sort_order)");
            echo "Done<br>\n";
        }

        if (version_compare($e->getVersion(), '4.3.6') < 0) {
            echo "Define relation between commission and void...";
            if (ob_get_level ())
                ob_end_flush();
            $rows = $this->getDi()->db->select("SELECT c.commission_id AS comm_id, v.commission_id AS void_id FROM ?_aff_commission c LEFT JOIN ?_aff_commission v ON
 v.record_type = 'void'
 AND c.invoice_id = v.invoice_id
 AND (c.invoice_payment_id = v.invoice_payment_id OR (c.invoice_payment_id IS NULL AND v.invoice_payment_id IS NULL))
 AND c.product_id = v.product_id
 AND c.tier=v.tier
 AND c.invoice_item_id = v.invoice_item_id
 WHERE
 c.record_type = 'commission'
 AND c.is_voided = 0
 AND v.commission_id IS NOT NULL");
            foreach ($rows as $row) {
                $comm_id = $row['comm_id'];
                $void_id = $row['void_id'];
                $comm = $this->getDi()->affCommissionTable->load($comm_id);
                $void = $this->getDi()->affCommissionTable->load($void_id);
                $comm->updateQuick('is_voided', 1);
                $void->updateQuick('commission_id_void', $comm->pk());
            }
            echo "Done<br>\n";
        }
    }

    public function onEmailTemplateTagSets(Am_Event $event)
    {
        $tagSets = $event->getReturn();
        $tagSets['user']['%user.aff_link%'] = ___('User Affiliate Link');
        $tagSets['affiliate'] = array(
                '%affiliate.name_f%' => 'Affiliate First Name',
                '%affiliate.name_l%' => 'Affiliate Last Name',
                '%affiliate.login%' => 'Affiliate Username',
                '%affiliate.email%' => 'Affiliate E-Mail',
                '%affiliate.user_id%' => 'Affiliate Internal ID#',
                '%affiliate.street%' => 'Affiliate Street',
                '%affiliate.street2%' => 'Affiliate Street (Second Line)',
                '%affiliate.city%' => 'Affiliate City',
                '%affiliate.state%' => 'Affiliate State',
                '%affiliate.zip%' => 'Affiliate ZIP',
                '%affiliate.country%' => 'Affiliate Country'
            );

        foreach ($this->getDi()->userTable->customFields()->getAll() as $field) {
            if (@$field->sql && @$field->from_config) {
                $tagSets['affiliate']['%affiliate.' . $field->name . '%'] = 'Affiliate ' . $field->title;
            }
        }

        $tagSets['affiliate']['%affiliate.aff_link%'] = ___('Affiliate Affiliate Link');

        $event->setReturn($tagSets);
    }

    public function onMailTemplateBeforeParse(Am_Event $event)
    {
        $template = $event->getTemplate();
        $tConfig = $template->getConfig();
        $mailBody = (!empty($tConfig['bodyText'])) ? $tConfig['bodyText'] : $tConfig['bodyHtml'];
        foreach (array('user', 'affiliate') as $prefix) {
            if (strpos($mailBody, "%$prefix.aff_link%") !== false) {
                $user = $template->$prefix;
                $user->aff_link = $this->getGeneralAffLink($user);
            }
        }
    }

    public function onMailSimpleTemplateBeforeParse(Am_Event $event)
    {
        $template = $event->getTemplate();
        $body = $event->getBody();
        $subject = $event->getSubject();
        foreach (array('user', 'affiliate') as $prefix) {
            if (strpos($body, "%$prefix.aff_link%") !== false) {
                $user = $this->getDi()->userRecord->fromRow($template->$prefix);
                $tmp = $template->$prefix;
                $tmp['aff_link'] = $this->getGeneralAffLink($user);
                $template->$prefix = $tmp;
            }
        }
    }

    public function onInitFinished()
    {
        $this->getDi()->blocks->add(new Am_Block('member/main/top', null, 'aff-member-payout-empty', null, array($this, 'renderAlert')));
        $this->getDi()->blocks->add(new Am_Block('aff/top', null, 'aff-aff-payout-empty', null, array($this, 'renderAlert')));
        $this->getDi()->blocks->add(new Am_Block('admin/user/invoice/details', null, 'aff-user-invoice-details', null, array($this, '_renderInvoiceCommissions')));
        $this->getDi()->blocks->add(new Am_Block('admin/user/invoice/top', null, 'aff-user-invoice-top', null, 'admin-void-commission.phtml'));
        
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addRoute('aff-go', new Zend_Controller_Router_Route(
                'aff/go/:r', array(
                'module' => 'aff',
                'controller' => 'go',
                'action' => 'index'
                )
        ));
    }

    protected function getGeneralAffLink(User $user)
    {
        return sprintf('%s/aff/go/%s', ROOT_URL, urlencode($user->login));
    }
    
    function getClickJs(){
         $root_url = ROOT_URL; $root_surl = ROOT_SURL;

         return <<<EOT
<script type="text/javascript" id='am-ctcs-v1'>
    (function(){
    var url=(("https:" == document.location.protocol) ?
        "{$root_surl}" : "{$root_url}");
    var d=document, s=d.createElement('script'), src=d.getElementsByTagName('script')[0];
    var w = window; var lo = w.location; var hr=lo.href; var ho=lo.host;  var se=lo.search;
    var m = RegExp('[?&]ref=([^&]*)').exec(se);
    var ref = m && decodeURIComponent(m[1].replace(/\+/g, ' '));s.type='text/javascript'; 
    s.async=true; s.src=url+'/aff/click-js/?r='+ref+'&s='+encodeURIComponent(document.referrer);
    if(ref){src.parentNode.insertBefore(s,src); var uri = hr.toString().split(ho)[1];
    w.history.replaceState('Object', 'Title', uri.replace(m[0], ""));}})();
</script>
EOT;
    }
    
    function onBeforeRender(Am_Event $e){
        $view = $e->getView();
        $tmpl = $e->getTemplateName();
        if(!defined('AM_ADMIN') && !$view->jsClickCodeAdded){
            $view->jsClickCodeAdded=true;
            $view->placeholder('body-finish')->prepend($this->getClickJs());
        }
        
    }
}