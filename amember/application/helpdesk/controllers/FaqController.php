<?php

class Helpdesk_FaqController extends Am_Controller
{

    function preDispatch()
    {
        if (!$this->getModule()->getConfig('does_not_require_login')) {
            $this->getDi()->auth->requireLogin(ROOT_URL . '/helpdesk/faq');
        }
        $this->view->headLink()->appendStylesheet($this->view->_scriptCss('helpdesk-user.css'));
        parent::preDispatch();
    }

    public function indexAction()
    {
        $this->view->categories = $this->getDi()->helpdeskFaqTable->getCategories();
        $this->view->catActive = $this->getParam('cat');
        $this->view->faq = $this->getDi()->helpdeskFaqTable->findBy(array(
                'category' => $this->getParam('cat', null)), null, null, 'sort_order');

        if ($this->getParam('cat')) {
            $this->view->getHelper('breadcrumbs')->setPath(array(REL_ROOT_URL . '/helpdesk/faq' => ___('FAQ')));
        }

        $this->view->display('helpdesk/faq.phtml');
    }

    public function itemAction()
    {
        $path = array(REL_ROOT_URL . '/helpdesk/faq' => ___('FAQ'));

        $faq = $this->getDi()->helpdeskFaqTable->findFirstByTitle($this->getParam('title'));
        if ($faq->category) {
            $path[REL_ROOT_URL . '/helpdesk/faq/c/' . urldecode($faq->category)] = $faq->category;
        }

        $this->view->getHelper('breadcrumbs')->setPath($path);
        $this->view->faq = $faq;
        $this->view->display('helpdesk/faq-item.phtml');
    }

    public function searchAction()
    {

        $result = $this->getDi()->db->selectPage($total, "SELECT * FROM ?_helpdesk_faq WHERE MATCH(`title`,`content`)
            AGAINST (? IN NATURAL LANGUAGE MODE)
            LIMIT 10", $this->getParam('q'));

        $items = array();
        foreach ($result as $row)
            $items[] = $this->getDi()->helpdeskFaqTable->createRecord($row);

        $this->view->items = $items;
        $this->view->display('helpdesk/_search-result.phtml');
    }

}