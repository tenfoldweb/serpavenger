<?php

include_once(dirname(__FILE__) . '/AdminCategoryController.php');

class AdminProductCategoriesController extends AdminCategoryController
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission('grid_product');
    }

    protected function getTable()
    {
        return $this->getDi()->productCategoryTable;
    }

    protected function getNote()
    {
        return ___('aMember does not respect category hierarchy. Each category is absolutely independent. You can use hierarchy only to organize your categories.');
    }

    protected function getTitle()
    {
        return ___('Product Categories');
    }

}