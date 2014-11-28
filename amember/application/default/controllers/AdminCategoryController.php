<?php

abstract class AdminCategoryController extends Am_Controller
{

    abstract protected function getTable();
    abstract protected function getTitle();

    function indexAction()
    {
        $this->view->isAjax = $this->isAjax();
        if (!$this->isAjax()) {
            $this->view->title = $this->getTitle();
        }
        $this->view->note = $this->getNote();
        $this->view->nodes = $this->getTable()->getTree();
        $this->view->tmpl = $this->getTable()->createRecord();
        $this->view->display('admin/category.phtml');
    }

    function saveAction()
    {
        $id = $this->getInt('id');
        if ($id) {
            $c = $this->getTable()->load($id);
        } else {
            $c = $this->getTable()->createRecord();
        }
        $c->title = $this->getParam('title');
        $c->description = $this->getParam('description');
        if (!is_null($code = $this->getParam('code')))
            $c->code = $code;
        $c->parent_id = $this->getInt('parent_id');
        $c->sort_order = $this->getInt('sort_order');
        $c->save();
        return $this->ajaxResponse($c->toArray() + array('id' => $c->pk()));
    }

    function delAction()
    {
        $id = $this->getInt('id');
        if (!$id)
            throw new Am_Exception_InputError(___('Wrong id'));
        $c = $this->getTable()->load($id);
        $this->getTable()->moveNodes($c->pk(), $c->parent_id);
        $c->delete();
        echo 'OK';
    }

    function optionsAction()
    {
        return Am_Controller::ajaxResponse($this->getTable()->getOptions());
    }

    protected function getNote()
    {
        return '';
    }

}