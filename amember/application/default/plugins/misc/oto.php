<?php

class Am_Plugin_Oto extends Am_Plugin
{
    const PLUGIN_STATUS = self::STATUS_PRODUCTION; //dev status
    const PLUGIN_REVISION = '4.4.2';

    const NEED_SHOW_OTO = 'need_show_oto';
    const LAST_OTO_SHOWN = 'last_oto_shown';

    const ADMIN_PERM_ID = 'oto';

    public function getTitle()
    {
        return ___('One Time Offer');
    }
    public function onAdminMenu(Am_Event $event)
    {
        $event->getMenu()->addPage(array(
            'id' => 'oto',
            'module' => 'default',
            'controller' => 'admin-one-time-offer',
            'action' => 'index',
            'label' => ___('One Time Offer'),
            'resource' => self::ADMIN_PERM_ID
        ));
    }
    public function init()
    {
        parent::init();
        try {
            $this->getDi()->db->query("ALTER TABLE ?_oto ADD is_disabled TINYINT NOT NULL");
        } catch (Am_Exception_Db $e) {}

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Am_Controller_Plugin_Oto());
    }

    public static function activate($id, $pluginType)
    {
        try {
            Am_Di::getInstance()->db->query("CREATE TABLE ?_oto (
                oto_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                comment varchar(255),
                conditions text,
                view mediumtext,
                product_id INT NOT NULL,
                coupon_id INT NULL
                ) CHARACTER SET utf8 COLLATE utf8_general_ci");
        } catch (Am_Exception_Db $e) {}

        return parent::activate($id, $pluginType);
    }

    /**
     * Special handle for offline plugin
     *
     * show oto on first login after purchase instead of
     * thank you page
     *
     * @param Am_Event $event
     */
    public function onInvoiceStarted(Am_Event $event)
    {
        /* @var $invoice Invoice */
        $invoice = $event->getInvoice();
        if ($invoice->paysys_id == 'offline') {
            $oto = $this->getDi()->otoTable->findUpsell($invoice->getProducts());
            if ($oto) {
                $user = $invoice->getUser();
                $user->data()->set(self::NEED_SHOW_OTO, $invoice->pk())->update();
            }
        }

    }

    function onThanksPage(Am_Event $event)
    {
        /* @var $invoice Invoice */
        $invoice = $event->getInvoice();
        /* @var $controller ThanksController */
        $controller = $event->getController();
        if (!$invoice || !$invoice->tm_started) return; // invoice is not yet paid

        $this->getDi()->blocks->add(new Am_Block('thanks/success', 'Parent Invoices', 'oto-parents' , $this, array($this, 'renderParentInvoices')));

        // find first matching upsell
        $oto = $this->getDi()->otoTable->findUpsell($invoice->getProducts());

        if ($controller->getRequest()->get('oto') == 'no') {
            $oto = $this->getDi()->otoTable->findDownsell($invoice->data()->get(self::LAST_OTO_SHOWN));
        }

        if (!$oto) return;

        if ($controller->getRequest()->get('oto') == 'yes')
            return $this->yesOto($controller, $invoice, $this->getDi()->otoTable->load($invoice->data()->get(self::LAST_OTO_SHOWN)));

        $invoice->data()->set(self::LAST_OTO_SHOWN, $oto->pk())->update();
        $html = $oto->render();

        $controller->getResponse()->setBody($html);

        throw new Am_Exception_Redirect;
    }

    function directAction(Am_Request $request, Zend_Controller_Response_Http $response, array $invokeArgs)
    {

        if (!$this->getDi()->auth->getUserId() ||
            !($invoice_id = $this->getDi()->auth->getUser()->data()->get(self::NEED_SHOW_OTO)))
                throw new Am_Exception_InternalError();

        $user = $this->getDi()->auth->getUser();
        $invoice = $this->getDi()->invoiceTable->load($invoice_id);

        $controller = new Am_Controller($request, $response, $invokeArgs);

        // find first matching upsell
        $oto = $this->getDi()->otoTable->findUpsell($invoice->getProducts());

        if ($controller->getRequest()->get('oto') == 'no') {
            $oto = $this->getDi()->otoTable->findDownsell($invoice->data()->get(self::LAST_OTO_SHOWN));
        }

        if (!$oto) {
            $user->data()->set(self::NEED_SHOW_OTO, null)->update();
            Am_Controller::redirectLocation(REL_ROOT_URL);
        }


        if ($controller->getRequest()->get('oto') == 'yes') {
            $user->data()->set(self::NEED_SHOW_OTO, null)->update();
            return $this->yesOto($controller, $invoice, $this->getDi()->otoTable->load($invoice->data()->get(self::LAST_OTO_SHOWN)));
        }

        $invoice->data()->set(self::LAST_OTO_SHOWN, $oto->pk())->update();
        $html = $oto->render();

        $controller->getResponse()->setBody($html);
        throw new Am_Exception_Redirect;
    }

    // called when user agreed to OTO
    function yesOto(Am_Controller $controller, Invoice $invoice, Oto $oto)
    {
        $inv = $this->getDi()->invoiceTable->createRecord();
        /* @var $inv Invoice */
        $inv->data()->set('oto_parent', $invoice->pk());

        $inv->user_id = $invoice->user_id;
        $inv->add($oto->getProduct());
        $coupon = $oto->getCoupon();
        if ($coupon)
            $inv->setCoupon($coupon);
        $inv->calculate();

        if ($inv->isZero() ) {// free invoice
            $inv->paysys_id = 'free';
        } elseif ($oto->getPaysysId()) { // configured
            $inv->paysys_id = $oto->getPaysysId();
        } elseif ($invoice->paysys_id != 'free') {// not free? take from invoice
            $inv->paysys_id = $invoice->paysys_id;
        } else { // was free, now paid, take first public
            $paysystems = Am_Di::getInstance()->paysystemList->getAllPublic();
            $inv->paysys_id = $paysystems[0]->paysys_id;
        }

        $inv->insert();

        $payProcess = new Am_Paysystem_PayProcessMediator($controller, $inv);
        $result = $payProcess->process(); // we decided to ignore failures here...
    }

    function renderParentInvoices(Am_View $view)
    {
        $invoice = $view->invoice;
        $out = null;
        while ($parent_invoice_id = $invoice->data()->get('oto_parent'))
        {
            $invoice = $this->getDi()->invoiceTable->load($parent_invoice_id);
            $v = $view->di->view;
            $v->invoice = $invoice;
            $out .= "<br /><h2>Related Order Reference: $invoice->public_id</h2>";
            $out .= $v->render('_receipt.phtml');
        }
        echo $out;
    }

    function onGetPermissionsList(Am_Event $event)
    {
        $event->addReturn(___('Can Operate with OTO'), self::ADMIN_PERM_ID);
    }
}

class AdminOneTimeOfferController extends Am_Controller_Grid
{
    protected $_defaultHtml ='
        <p>This text will be displayed before the buttons. Describe
          your offer here. The following tags "yes" and "no" will be
          automatically replaced to buttons. Please do not touch or remove them.</p>

        <p>%yes% %no%</p>

        <p>This text will be displayed after "yes" and "no" buttons,
        you may remove or customize it</p>
';

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Am_Plugin_Oto::ADMIN_PERM_ID);
    }

    public function previewAction()
    {
        $id = $this->_request->getInt('id');
        if (!$id)
            throw new Am_Exception_InputError("Empty id passed");
        $oto = $this->getDi()->otoTable->load($id);
        echo $oto->render();
    }

    public function createGrid()
    {
        $ds = new Am_Query($this->getDi()->otoTable);
        $grid = new Am_Grid_Editable('_oto', ___('One Time Offer'), $ds, $this->_request, $this->view, $this->getDi());
        $grid->setPermissionId(Am_Plugin_Oto::ADMIN_PERM_ID);
        $grid->addField('comment', ___('Comment'));
        $grid->addField(new Am_Grid_Field_IsDisabled());
        $grid->setForm(array($this, 'createForm'));
        $grid->setFormValueCallback('conditions', array('RECORD', 'getConditions'), array('RECORD', 'setConditions'));
        $grid->setFormValueCallback('view', array('RECORD', 'getView'), array('RECORD', 'setView'));

        $grid->actionGet('edit')->setTarget('_top');

        $grid->addCallback(Am_Grid_Editable::CB_VALUES_TO_FORM, array($this, 'valuesToForm'));

        $grid->actionAdd(new Am_Grid_Action_Url('preview', ___('Preview'), REL_ROOT_URL . '/admin-one-time-offer/preview?id=__ID__'))->setTarget('_blank');
        $grid->actionAdd(new Am_Grid_Action_CopyOto())->setTarget('_top');
        $grid->actionAdd(new Am_Grid_Action_Group_Callback('disable', ___('Disable'), array($this, 'disableOto')));
        $grid->actionAdd(new Am_Grid_Action_Group_Callback('enable', ___('Enable'), array($this, 'enableOto')));
        $grid->actionAdd(new Am_Grid_Action_Group_Delete());
        $grid->actionAdd(new Am_Grid_Action_LiveEdit('comment'));

        $grid->setRecordTitle(___('One Time Offer'));

        return $grid;
    }

    public function disableOto($id, Oto $oto)
    {
        $oto->updateQuick('is_disabled', 1);
    }
    public function enableOto($id, Oto $oto)
    {
        $oto->updateQuick('is_disabled', 0);
    }

    public function valuesToForm(array & $values, Oto $record)
    {
        if (empty($values['view']))
        {
            $values['view'] = array(
                'title' => 'One Time Offer',
                'html' => $this->_defaultHtml,
                'yes' => array('label' => 'Yes, Add To Card'),
                'no' => array('label' => 'No, Thank You'),
                'no_layout' => 0,
            );
        }
    }

    function createForm()
    {
        $form = new Am_Form_Admin();

        $form->addText('comment', array('class' => 'el-wide'))->setLabel(array(___('Comment'), ___('for your reference')))->addRule('required');

        $sel = $form->addMagicSelect('conditions[product]')->setLabel(array(___('Conditions'),
            ___('After actual payment aMember will check user invoice and in case of it contains one of defined
                product or product from defined product category this OTO will be shown for him instead of ordinary thank you page.
                In case of you use OTO (Downsell) condition it will be matched if user click NO link in defined offer and this OTO will be shown for user')));
        $cats = $pr = $oto = array();
        foreach ($this->getDi()->productCategoryTable->getAdminSelectOptions() as $k => $v)
            $cats['category-'.$k] = ___('Category') . ':'. $v;
        foreach ($this->getDi()->productTable->getOptions() as $k => $v)
            $pr['product-'.$k] = ___('Product') . ':' . $v;
        foreach ($this->getDi()->otoTable->getOptions() as $k => $v)
            $oto['oto-'.$k] = ___('OTO') . ':' . $v;

        $options =
            array (___('Categories') => $cats)
            + ($pr ? array(___('Products') => $pr) : array())
            + ($oto ? array(___('OTO (Downsell)') => $oto) : array());

        $sel->loadOptions($options);
        $sel->addRule('required');

        $form->addSelect('product_id')->setLabel('Product to Offer')
                ->loadOptions($this->getDi()->productTable->getOptions())
                ->addRule('required');

        $coupons = array('' => '');
	    foreach ($this->getDi()->db->selectCol("
		SELECT c.coupon_id as ARRAY_KEY,
		CONCAT(c.code, ' - ' , b.comment)
		FROM ?_coupon c LEFT JOIN ?_coupon_batch b USING (batch_id)
		ORDER BY c.code
        ") as $k => $v)
			$coupons[$k] = $v;

        $form->addSelect('coupon_id')->setLabel(___('Apply Coupon (optional)'))
                ->loadOptions($coupons);


        $psList = array('' => '') + $this->getDi()->paysystemList->getOptionsPublic();
        $form->addSelect('view[paysys_id]')->setLabel(___('Paysystem (optional)'))
            ->loadOptions($psList);

        $fs = $form->addFieldSet()->setLabel(___('Offer Page Settings'));

        $fs->addText('view[title]', array('class' => 'el-wide'))->setLabel(___('Title'));

        $fs->addHtmlEditor('view[html]')->setLabel("Offer Text\nuse %yes% and %no% to insert buttons");
        $fs->addHtmlEditor('view[yes][label]')->setLabel('[Yes] button text');
        $fs->addHtmlEditor('view[no][label]')->setLabel('[No] button code');

        $fs->addAdvCheckbox('view[no_layout]')->setLabel(___("Avoid using standard layout\nyou have to design entire page in the 'Offer Text' field"));

        return $form;
    }
}

class OtoTable extends Am_Table
{
    protected $_table = '?_oto';
    protected $_recordClass = 'Oto';
    protected $_key = 'oto_id';

    /**
     *
     * @param array $products
     * @return Oto
     */
    function findUpsell(array $products)
    {
        if ($products && current($products) instanceof Product)
        {
            foreach ($products as $k => $p)
                $products[$k] = $p->product_id;
        }
        foreach ($this->findBy(array('is_disabled'=>0)) as $oto)
        {
            /* @var $oto Oto */
            if ($oto->matchProducts($products))
                return $oto;
        }
    }
    /**
     *
     * @param int $oto_id
     * @return Oto
     */
    function findDownsell($oto_id)
    {
        foreach ($this->findBy(array('is_disabled'=>0)) as $oto)
        {
            /* @var $oto Oto */
            if ($oto->matchOto($oto_id))
                return $oto;
        }
    }


    function getOptions()
    {
        return array_map(array("Am_Controller", "escape"), $this->_db->selectCol("SELECT oto_id as ARRAY_KEY, comment
            FROM ?_oto ORDER BY comment"));
    }
}

/**
 * @property int $oto_id
 * @property string $comment
 * @property string $conditions
 * @property string $view
 * @property int $product_id
 * @property int $coupon_id
 */
class Oto extends Am_Record
{
    function matchProducts(array $product_ids)
    {
        $cats = $this->getDi()->productCategoryTable->getCategoryProducts();
        // $cats set to category_id => array(product_ids)
        $cond = $this->getConditions();
        foreach ($cond['product'] as $s)
        {
            if (preg_match('/product-(\d+)/', $s, $regs))
            {
                if (in_array($regs[1], $product_ids)) return true;
            } elseif (preg_match('/category-(\d+)/', $s, $regs)) {
                if (array_intersect(@$cats[$regs[1]], $product_ids)) return true;
            }
        }
        return false;
    }
    function matchOto($oto_id)
    {
        $cond = $this->getConditions();
        foreach ($cond['product'] as $s)
        {
            if (preg_match('/oto-(\d+)/', $s, $regs) && ($regs[1]==$oto_id))
                return true;
        }
        return false;
    }

    protected function _getJson($fn)
    {
        $v = $this->get($fn);
        if (empty($v)) return array();
        return json_decode($v, true);
    }
    protected function _setJson($fn, array $v)
    {
        $this->{$fn} = json_encode($v);
        return $this->{$fn};
    }
    function getConditions()
    {
        return $this->_getJson('conditions');
    }
    function setConditions(array $conditions)
    {
        return $this->_setJson('conditions', $conditions);
    }
    function getView()
    {
        return $this->_getJson('view');
    }
    function setView(array $view)
    {
        return $this->_setJson('view', $view);
    }
    /** @return Coupon|null */
    function getCoupon()
    {
        if ($this->coupon_id)
            return $this->getDi()->couponTable->load($this->coupon_id);
    }
    /** @return Product */
    function getProduct()
    {
        return $this->getDi()->productTable->load($this->product_id);
    }
    /** @return PaysysId */
    function getPaysysId()
    {
        $viewVars = $this->getView();
        if (isset($viewVars['paysys_id']))
            return $viewVars['paysys_id'];
    }

    function render()
    {
        $view = $this->getView();
        $html = $view['html'];

        $html = str_replace('%yes%', '<button name="yes" onclick="window.location.href=window.location.href + (window.location.href.indexOf(\'?\') == -1 ? \'?\' : \'&\') + \'oto=yes\'">'.$view['yes']['label'].'</button>', $html);
        $html = str_replace('%no%', '<a href="javascript:" onclick="window.location.href=window.location.href + (window.location.href.indexOf(\'?\') == -1 ? \'?\' : \'&\') + \'oto=no\'">'.$view['no']['label'].'</a>', $html);

        if ($view['no_layout'])
        {
            $title = Am_Controller::escape($view['title']);
            $html = strpos($html, 'html') === false ?
                "<!DOCTYPE html>\n<html><head><title>$title</title></head><body>" . $html . "</body></html>" :
                $html;
        } else {
            $v = $this->getDi()->view;
            $v->title = $view['title'];
            $v->content = $html;
            $v->layoutNoMenu = $v->layoutNoLang = $v->layoutNoTitle = true;
            $html = $v->render('layout.phtml');
        }

        return $html;
    }
}

class Am_Controller_Plugin_Oto extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if (stripos($this->getRequest()->getControllerName(), 'admin') === 0)
            return; //exception for admin

        $di = Am_Di::getInstance();
        if ($di->auth->getUserId() && $di->auth->getUser()->data()->get(Am_Plugin_Oto::NEED_SHOW_OTO))
        {
            $request->setControllerName('direct')
                ->setActionName('index')
                ->setModuleName('default')
                ->setParam('type', 'misc')
                ->setParam('plugin_id', 'oto');
        }
    }
}

class Am_Grid_Action_CopyOto extends Am_Grid_Action_Abstract
{
    protected $id = 'copy';
    protected $privilege = 'insert';
    public function run()
    {
        $record = $this->grid->getRecord();

        $vars = $record->toRow();
        unset($vars['oto_id']);
        $vars['comment'] = ___('Copy of') . ' ' . $record->comment;
        $vars['view'] = json_decode($vars['view'], true);
        $vars['conditions'] = json_decode($vars['conditions'], true);

        $back = @$_SERVER['HTTP_X_REQUESTED_WITH'];
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';

        $request = new Am_Request($vars + array($this->grid->getId() . '_a' => 'insert',
            $this->grid->getId() . '_b' => $this->grid->getBackUrl()), Am_Request::METHOD_POST);

        $request->setModuleName('default')
            ->setControllerName('admin-one-time-offfer')
            ->setActionName('index')
            ->setDispatched(true);

        $controller = new AdminOneTimeOfferController_Copy($request, new Zend_Controller_Response_Http(),
            array('di' => Am_Di::getInstance()));

        $controller->dispatch('indexAction');
        $response = $controller->getResponse();
        $response->sendResponse();
        $_SERVER['HTTP_X_REQUESTED_WITH'] = $back;
    }
}

class AdminOneTimeOfferController_Copy extends AdminOneTimeOfferController {
    public function valuesToForm(array & $values, Oto $record){}
}