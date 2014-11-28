<?php

class IndexController extends Am_Controller
{
    function indexAction()
    {
        if(!$this->getDi()->auth->getUserId())
            $this->getDi()->auth->checkExternalLogin($this->getRequest());
        if($this->getDi()->auth->getUserId() && $this->getDi()->config->get('skip_index_page'))
            Am_Controller::redirectLocation($this->getUrl('member', 'index'));

        try {
            $p = $this->getDi()->pageTable->load($this->getDi()->config->get('index_page'));
            echo $p->render($this->view, $this->getDi()->auth->getUserId() ? $this->getDi()->auth->getUser() : null);
        } catch (Exception $e) {
            $this->view->display("index.phtml");
        }
    }
}
