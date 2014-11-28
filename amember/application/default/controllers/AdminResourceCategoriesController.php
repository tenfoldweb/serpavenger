<?php

include_once(dirname(__FILE__) . '/AdminCategoryController.php');

class AdminResourceCategoriesController extends AdminCategoryController
{

    public function checkAdminPermissions(Admin $admin)
    {
        return 'grid_content';
    }

    protected function getTable()
    {
        return $this->getDi()->resourceCategoryTable;
    }

    protected function getTitle()
    {
        return ___('Content Categories');
    }
}