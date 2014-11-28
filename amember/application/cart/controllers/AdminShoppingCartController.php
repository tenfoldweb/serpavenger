<?php

class Cart_AdminShoppingCartController extends Am_Controller_Pages
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Am_Auth_Admin::PERM_SETUP);
    }

    public function initPages()
    {
        $this->addPage(array($this, 'configCartController'), 'cart', ___('Shopping Cart Settings'))
            ->addPage(array($this, 'createButtonController'), 'button', ___('Button/Link HTML Code'))
            ->addPage(array($this, 'createBasketController'), 'basket', ___('Basket HTML Code'));
    }

    public function configCartController($id, $title, Am_Controller $controller)
    {
        return new AdminShoppingCart_Settings($controller->getRequest(), $controller->getResponse(), $this->_invokeArgs);
    }

    public function createButtonController($id, $title, Am_Controller $controller)
    {
        return new AdminCartHtmlGenerateController_Button($controller->getRequest(), $controller->getResponse(), $this->_invokeArgs);
    }

    public function createBasketController($id, $title, Am_Controller $controller)
    {
        return new AdminCartHtmlGenerateController_Basket($controller->getRequest(), $controller->getResponse(), $this->_invokeArgs);
    }

}

require_once APPLICATION_PATH . '/default/controllers/AdminSetupController.php';

class AdminShoppingCart_Settings extends AdminSetupController
{

    public function indexAction()
    {
        $this->_request->setParam('page', 'cart');

        $this->p = filterId($this->_request->getParam('page'));
        $this->initSetupForms();
        $this->form = $this->getForm($this->p, false);
        $this->form->prepare();
        if ($this->form->isSubmitted()) {
            $this->form->setDataSources(array($this->_request));
            if ($this->form->validate() && $this->form->saveConfig()) {
                Am_Controller::redirectLocation($this->getUrl());
            }
        } else {
            $this->form->setDataSources(array(
                new HTML_QuickForm2_DataSource_Array($this->getConfigValues()),
                new HTML_QuickForm2_DataSource_Array($this->form->getDefaults()),
            ));
        }
        $this->view->assign('p', $this->p);
        $this->form->replaceDotInNames();

        $this->view->assign('pageObj', $this->form);
        $this->view->assign('form', $this->form);
        $this->view->display('admin/cart/config.phtml');
    }

}

class AdminCartHtmlGenerateController_Button extends Am_Controller
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Am_Auth_Admin::PERM_SETUP);
    }

    public function indexAction()
    {
        if ($this->getRequest()->getParam('title') && $this->getRequest()->getParam('actionType')) {
            $productIds = $this->getRequest()->getParam('productIds');
            $prIds = $productIds ?
                implode(',', $productIds) :
                implode(',', array_keys($this->getDi()->productTable->getOptions(true)));

            $htmlcode = '
<!-- Button/Link for aMember Shopping Cart -->
<script type="text/javascript">
if (typeof cart  == "undefined")
    document.write("<scr" + "ipt src=\'' . REL_ROOT_URL . '/application/cart/views/public/js/cart.js\'></scr" + "ipt>");
</script>
';
            if ($this->getRequest()->getParam('isLink')) {
                $htmlcode .= '<a href="#" onclick="cart.' . $this->getRequest()->getParam('actionType') . '(this,' . $prIds . '); return false;" >' . $this->getRequest()->getParam('title') . '</a>';
            } else {
                $htmlcode .= '<input type="button" onclick="cart.' . $this->getRequest()->getParam('actionType') . '(this,' . $prIds . '); return false;" value="' . $this->getRequest()->getParam('title') . '">';
            }
            $htmlcode .= '
<!-- End Button/Link for aMember Shopping Cart -->
';

            $this->view->assign('htmlcode', $htmlcode);
            $this->view->display('admin/cart/button-code.phtml');
        } else {
            $form = new Am_Form_Admin();

            $form->addMagicSelect('productIds')
                ->setLabel(___('Select Product(s)
if nothing selected - all products'))
                ->loadOptions($this->getDi()->productTable->getOptions());

            $form->addSelect('isLink')
                ->setLabel(___('Select Type of Element'))
                ->loadOptions(array(
                    0 => 'Button',
                    1 => 'Link',
                ));

            $form->addSelect('actionType')
                ->setLabel(___('Select Action of Element'))
                ->loadOptions(array(
                    'addExternal' => ___('Add to Basket only'),
                    'addBasketExternal' => ___('Add & Go to Basket'),
                    'addCheckoutExternal' => ___('Add & Checkout'),
                ));

            $form->addText('title')
                ->setLabel(___('Title of Element'))
                ->addRule('required');

            $form->addSaveButton(___('Generate'));

            $this->view->assign('form', $form);
            $this->view->display('admin/cart/button-code.phtml');
        }
    }

}

class AdminCartHtmlGenerateController_Basket extends Am_Controller
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Am_Auth_Admin::PERM_SETUP);
    }

    public function indexAction()
    {
        $htmlcode = '
<!-- Basket for aMember Shopping Cart -->
<script type="text/javascript">
if (typeof(cart) == "undefined")
    document.write("<scr" + "ipt src=\'' . REL_ROOT_URL . '/application/cart/views/public/js/cart.js\'></scr" + "ipt>");
jQuery(function(){cart.loadOnly();});
</script>
<div class="am-basket-preview"></div>
<!-- End Basket for aMember Shopping Cart -->
';
        $this->view->assign('htmlcode', $htmlcode);
        $this->view->display('admin/cart/basket-code.phtml');
    }

}

class Am_Form_Setup_Cart extends Am_Form_Setup
{

    public function __construct()
    {
        parent::__construct('cart');
        $this->setTitle(___('Shopping Cart'));
    }

    public function initElements()
    {
        $options = Am_Di::getInstance()->paysystemList->getOptions();
        unset($options['free']);
        $this->addSortableMagicSelect('cart.paysystems')->setLabel(array(___('Payment Options'),
                    ___('if none selected, all enabled will be displayed')))
                ->loadOptions($options);

        $this->addSelect('cart.category_id')->setLabel(___("Category\n" .
                    "root category of hierarchy which included to shopping cart\n" .
                    "all categories is included by default"))
                ->loadOptions(array('' => '-- ' . ___('Root') . ' --') + Am_Di::getInstance()->productCategoryTable->getAdminSelectOptions());
        
        $this->addAdvCheckbox('cart.redirect_to_cart')
            ->setLabel(___('Redirect to Signup Cart Page by Default'));

        $gr = $this->addGroup()
                ->setLabel(___("Hide 'Add/Renew Subscription' tab (User Menu)\n" .
                        "and show 'Shopping Cart' tab instead"));

        $gr->addAdvCheckbox('cart.show_menu_cart_button')
            ->setId('show_menu_cart_button');

        $gr->addText('cart.show_menu_cart_button_label')
            ->setId('show_menu_cart_button_label');
        $this->setDefault('cart.show_menu_cart_button_label', 'Shopping Cart');

        $this->addScript()
            ->setScript(<<<CUT

$('#show_menu_cart_button').change(function(){
    $('#show_menu_cart_button_label').toggle(this.checked);
}).change();
CUT
        );

        $fs = $this->addAdvFieldset('img')
            ->setLabel(___('Product Image'));

        $imgSize = $fs->addGroup()
                ->setLabel(array(___('List View (Width x Height)'), ___('Empty - 200x200 px')));

        $imgSize->addText('cart.product_image_width', array('size' => 3))
            ->addRule('regex', ___('Image width must be number greater than 0.'), '/^$|^[1-9](\d+)?$/');
        $imgSize->addHtml()
            ->setHtml(' &times; ');
        $imgSize->addText('cart.product_image_height', array('size' => 3))
            ->addRule('regex', ___('Image height must be number greater than 0.'), '/^$|^[1-9](\d+)?$/');

        $imgSize = $fs->addGroup()
                ->setLabel(array(___('Detail View (Width x Height)'), ___('Empty - 400x400 px')));

        $imgSize->addText('cart.img_detail_width', array('size' => 3))
            ->addRule('regex', ___('Image width must be number greater than 0.'), '/^$|^[1-9](\d+)?$/');
        $imgSize->addHtml()
            ->setHtml(' &times; ');
        $imgSize->addText('cart.img_detail_height', array('size' => 3))
            ->addRule('regex', ___('Image height must be number greater than 0.'), '/^$|^[1-9](\d+)?$/');

        $imgSize = $fs->addGroup()
                ->setLabel(array(___('Cart View (Width x Height)'), ___('Empty - 50x50 px')));

        $imgSize->addText('cart.img_cart_width', array('size' => 3))
            ->addRule('regex', ___('Image width must be number greater than 0.'), '/^$|^[1-9](\d+)?$/');
        $imgSize->addHtml()
            ->setHtml(' &times; ');
        $imgSize->addText('cart.img_cart_height', array('size' => 3))
            ->addRule('regex', ___('Image height must be number greater than 0.'), '/^$|^[1-9](\d+)?$/');


        $fs = $this->addAdvFieldset('layout')
                ->setLabel(___('Layout'));

        $this->setDefault('cart.layout', 0);

        $fs->addAdvRadio('cart.layout')
            ->setLabel(___('Layout'))
            ->loadOptions(array(
                0 => ___('One Column'),
                1 => ___('Two Columns')
            ));

        $fs->addAdvCheckbox('cart.layout_no_category')
            ->setLabel(___('Hide Choose Category Widget'));

        $fs->addAdvCheckbox('cart.layout_no_search')
            ->setLabel(___('Hide Product Search Widget'));

        $fs->addAdvCheckbox('cart.layout_no_auth')
            ->setLabel(___('Hide Authentication Widget'));

        $fs->addAdvCheckbox('cart.layout_no_basket')
            ->setLabel(___('Hide Your Basket Widget'));

        $fs->addText('cart.records_per_page', array('size' => 3))
            ->setLabel(___('Products per Page'));

        $this->setDefault('cart.records_per_page', Am_Di::getInstance()->config->get('admin.records-on-page', 10));
    }

}