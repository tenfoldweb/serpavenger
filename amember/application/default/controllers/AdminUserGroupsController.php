<?php

include_once(dirname(__FILE__) . '/AdminCategoryController.php');

class AdminUserGroupsController extends AdminCategoryController
{

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission('grid_u');
    }

    protected function getTable()
    {
        return $this->getDi()->userGroupTable;
    }

    protected function getNote()
    {
        return ___('aMember does not respect group hierarchy. Each group is absolutely independent. You can use hierarchy only to organize your groups.');
    }

    protected function getTitle()
    {
        return ___('User Groups');
    }
}