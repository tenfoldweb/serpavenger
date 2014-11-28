<?php

/**
 * Special controller to handles API action  
 * IS NOT subclassed from Am_Controller
 */
class Am_Controller_Api extends Zend_Controller_Action
{
    /** @return Am_Di */
    function getDi()
    {
        return $this->_invokeArgs['di'];
    }    
    function getJson($vars)
    {
        return json_encode($vars);//,JSON_FORCE_OBJECT);
    }
    function ajaxResponse($vars)
    {
        $this->getResponse()->setHeader('Content-type', 'application/json; charset=UTF-8');
        if (!empty($_GET['callback']))
        {
            if (preg_match('/\W/', $_GET['callback'])) {
                // if $_GET['callback'] contains a non-word character,
                // this could be an XSS attack.
                header('HTTP/1.1 400 Bad Request');
                exit();
            }
            $this->getResponse()->setBody(sprintf('%s(%s)', $_GET['callback'], $this->getJson($vars)));
        } else
            $this->getResponse()->setBody($this->getJson($vars));
    }
}