<?php

class Bootstrap_Cart extends Am_Module
{
    const UPLOAD_PREFIX = 'product-img-cart';

    function onSavedFormTypes(Am_Event $event)
    {
        $event->getTable()->addTypeDef(array(
            'type' => SavedForm::T_CART,
            'title' => ___('Shopping Cart Signup'),
            'class' => 'Am_Form_Signup_Cart',
            'defaultTitle' => 'Create Customer Profile',
            'defaultComment' => 'shopping cart signup form',
            'isSingle' => true,
            'isSignup' => true,
            'noDelete' => true,
            'urlTemplate' => 'signup/cart',
        ));
    }

    public function deactivate()
    {
        unset($this->getDi()->session->cart);
        parent::deactivate();
    }

    public function onAdminMenu(Am_Event $event)
    {
        $event->getMenu()->addPage(array(
            'id' => 'cart',
            'controller' => 'admin-shopping-cart',
            'action' => 'index',
            'module' => 'cart',
            'label' => ___('Shopping Cart'),
            'resource' => 'grid_carthtmlgenerate'
        ));
    }

    function onUserMenu(Am_Event $event)
    {
        if ($this->getDi()->config->get('cart.show_menu_cart_button')) {
            $menu = $event->getMenu();
            $menu->addPage(array(
                'id' => 'cart',
                'controller' => 'index',
                'module' => 'cart',
                'action' => 'index',
                'label' => ___($this->getDi()->config->get('cart.show_menu_cart_button_label', 'Shopping Cart')),
                'order' => 150,
            ));
            $page = $menu->findOneBy('id', 'add-renew');
            if ($page)
                $menu->removePage($page);
        }
    }

    function init()
    {
        parent::init();
        $this->getDi()->uploadTable->defineUsage(
            self::UPLOAD_PREFIX,
            'product',
            'img',
            UploadTable::STORE_FIELD,
            "Image for product: [%title%]", '/admin-products?_product_a=edit&_product_id=%product_id%'
        );
    }

    function onGridProductInitForm(Am_Event $event)
    {

        $form = $event->getGrid()->getForm();

        $fs = $form->addAdvFieldset('cart')
                ->setLabel(___('Shopping Cart'));

        $fs->addUpload('img', null, array('prefix' => self::UPLOAD_PREFIX))
            ->setLabel(___('Product Picture') . "\n" . ___('for shopping cart pages. Only jpeg, png and gif formats allowed'))
            ->setAllowedMimeTypes(array(
                'image/png', 'image/jpeg', 'image/gif',
            ));

        $fs->addText('path', array('class' => 'el-wide'))
            ->setId('product-path')
            ->setLabel(array(___('Path'), ___('will be used to construct user-friendly url, in case of you leave it empty aMember will use id of this product to do it')));

        $root_url = Am_Controller::escape(Am_Di::getInstance()->config->get('root_url'));

        $fs->addStatic()
            ->setLabel(___('Permalink'))
            ->setContent(<<<CUT
<div data-root_url="$root_url" id="product-permalink"></div>
CUT
        );

        $fs->addScript()
            ->setScript(<<<CUT
$('#product-path').bind('keyup', function(){
    $('#product-permalink').closest('.row').toggle($(this).val() != '');
    $('#product-permalink').html($('#product-permalink').data('root_url') + '/product/' + encodeURIComponent($(this).val()).replace(/%20/g, '+'))
}).trigger('keyup')
CUT
        );

        $fs->addHtmlEditor('cart_description')
            ->setLabel(___('Product Description') . "\n" . ___('displayed on the shopping cart page'));

        $fs = $form->addAdvFieldset('meta', array('id'=>'meta'))
                ->setLabel(___('Meta Data'));

        $fs->addText('meta_title', array('class' => 'el-wide'))
            ->setLabel(___('Title'));

        $fs->addText('meta_keywords', array('class' => 'el-wide'))
            ->setLabel(___('Keywords'));

        $fs->addText('meta_description', array('class' => 'el-wide'))
            ->setLabel(___('Description'));
    }

    function onGridProductValuesFromForm(Am_Event $event)
    {
        $vars = $event->getArg(0);
        if (!$vars['path'])
            $vars['path'] = null;

        $event->setArg(0, $vars);
    }

    function onGridProductAfterSave(Am_Event $event)
    {
        $product = $event->getGrid()->getRecord();
        $vars = $event->getGrid()->getForm()->getValue();

        if (empty($vars['img'])) {
            $product->img = null;
            $product->img_path = null;
            $product->img_cart_path = null;
            $product->img_detail_path = null;
            $product->img_orig_path = null;
            $product->update();
            return;
        }

        $sizes = array(
            'img' => array(
                'w' => $this->getConfig('product_image_width', 200),
                'h' => $this->getConfig('product_image_height', 200),
                't' => Am_Image::RESIZE_CROP
            ),
            'img_cart' => array(
                'w' => $this->getConfig('img_cart_width', 50),
                'h' => $this->getConfig('img_cart_height', 50),
                't' => Am_Image::RESIZE_CROP
            ),
            'img_detail' => array(
                'w' => $this->getConfig('img_detail_width', 400),
                'h' => $this->getConfig('img_detail_height', 400),
                't' => Am_Image::RESIZE_GIZMO
            )
        );

        if ($product->img) {
            $upload = $this->getDi()->uploadTable->load($product->img);
            if ($upload->prefix != self::UPLOAD_PREFIX)
                throw new Am_Exception_InputError('Incorrect prefix requested [%s]', $upload->prefix);

            switch ($upload->getType()) {
                case 'image/gif' :
                    $ext = 'gif';
                    break;
                case 'image/png' :
                    $ext = 'png';
                    break;
                case 'image/jpeg' :
                    $ext = 'jpeg';
                    break;
                default :
                    throw new Am_Exception_InputError(sprintf('Unknown MIME type [%s]', $mime));
            }


            $name = str_replace('.' . self::UPLOAD_PREFIX . '.', '', $upload->path);
            $filename = $upload->getFullPath();

            $image = new Am_Image($upload->getFullPath(), $upload->getType());

            foreach ($sizes as $id => $size) {
                $newName = 'cart/' . $size['w'] . '_' . $size['h'] . '/' . $name . '.jpeg';
                $newFilename = ROOT_DIR . '/data/public/' . $newName;

                if (!file_exists($newFilename)) {
                    if (!is_dir(dirname($newFilename))) {
                        mkdir(dirname($newFilename), 0777, true);
                    }

                    $i = clone $image;
                    $i->resize($size['w'], $size['h'], $size['t'])->save($newFilename);
                }
                $product->{$id . '_path'} = $newName;
            }

            $newOrigName = 'cart/orig/' . $name . '.' . $ext;
            $newOrigFilename = ROOT_DIR . '/data/public/' . $newOrigName;
            if (!file_exists($newOrigFilename)) {
                if (!is_dir(dirname($newOrigFilename))) {
                    mkdir(dirname($newOrigFilename), 0777, true);
                }
                copy($filename, $newOrigFilename);
                $product->img_orig_path = $newOrigName;
            }

            $product->update();
        }
    }

    function onGetUploadPrefixList(Am_Event $event)
    {
        $event->addReturn(array(
            Am_Upload_Acl::IDENTITY_TYPE_ADMIN => Am_Upload_Acl::ACCESS_ALL,
            Am_Upload_Acl::IDENTITY_TYPE_USER => Am_Upload_Acl::ACCESS_READ,
            Am_Upload_Acl::IDENTITY_TYPE_ANONYMOUS => Am_Upload_Acl::ACCESS_READ
            ), self::UPLOAD_PREFIX);
    }

    function onDbUpgrade(Am_Event $e)
    {
        if (version_compare($e->getVersion(), '4.2.16') < 0) {
            $nDir = opendir(ROOT_DIR . '/data/');
            $baseDir = ROOT_DIR . '/data/';
            while (false !== ( $file = readdir($nDir) ))
                if (preg_match('/^.' . self::UPLOAD_PREFIX . '.*$/', $file, $matches) && !file_exists($baseDir . 'public/' . $matches[0] . ".png"))
                    if (!@copy($baseDir . $matches[0], $baseDir . 'public/' . $matches[0] . ".png"))
                        echo sprintf('<span style="color:red">Could not copy file [%s] to [%s]. Please, copy and rename manually.</span><br />',
                            $baseDir . $matches[0], $baseDir . 'public/' . $matches[0] . ".png");

            closedir($nDir);
            $this->getDi()->db->query("
                UPDATE ?_product
                SET img_path = CONCAT(img_path,'.png')
                WHERE
                    img IS NOT NULL
                    AND img_path NOT LIKE '%.png'
                    AND img_path NOT LIKE '%.jpg'
                    AND img_path NOT LIKE '%.jpeg'
                    AND img_path NOT LIKE '%.gif'
            ");
        }
    }

    public function onInitFinished()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addRoute('cart-product', new Zend_Controller_Router_Route(
                'product/:path', array(
                'module' => 'cart',
                'controller' => 'index',
                'action' => 'product'
                )
        ));
    }

}