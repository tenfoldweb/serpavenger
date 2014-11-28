<?php

class ContentController extends Am_Controller
{
    
    /** @access private for unit testing */
    public function _setHelper($v)
    {
        $this->_helper->addHelper($v);
    }
    /**
     * Serve file download
     */
    function fAction()
    {
        $f = $this->loadWithAccessCheck($this->getDi()->fileTable, $id = $this->getInt('id'));
        // download limits works for user access only and not for guest access
        if ($this->getDi()->auth->getUserId())
        {
            if (!$this->getDi()->fileDownloadTable->checkLimits($this->getDi()->auth->getUser(), $f)) {
                throw new Am_Exception_AccessDenied(___('Download limit exceeded for this file'));
            }

            $this->getDi()->fileDownloadTable->logDownload($this->getDi()->auth->getUser(), $f, $this->getRequest()->getClientIp());
        }
        if ($path = $f->getFullPath())
        {
            @ini_set('zlib.output_compression', 'Off'); // for IE
            $this->_helper->sendFile($path, $f->getMime(), 
                array(
                    //'cache'=>array('max-age'=>3600),
                    'filename' => $f->getDisplayFilename(),
            ));
        } else
            $this->redirectLocation($f->getProtectedUrl(600));
    }
    
    /**
     * Display saved page
     */
    function pAction()
    {
        $page = ($path = $this->getParam('path')) ?
            $this->getDi()->pageTable->findFirstByPath($path):
            null;

        $p = $this->loadWithAccessCheck($this->getDi()->pageTable, $page ? $page->pk() : $this->getInt('id'));
        echo $p->render($this->view, $this->getDi()->auth->getUserId() ? $this->getDi()->auth->getUser() : null);
    }

    /**
     * Display allowed content within category
     *
     */
    function cAction()
    {
        /* @var $cat ResourceCategory */
        $cat = $this->getDi()->resourceCategoryTable->load($this->getParam('id'));
        $this->view->resources = $cat->getAllowedResources($this->getDi()->user);
        $this->view->category = $cat;
        $this->view->display('member/category.phtml');
    }

    function loadWithAccessCheck(ResourceAbstractTable $table, $id)
    {
        if ($id<=0)
            throw new Am_Exception_InputError(___('Wrong link - no id passed'));
        
        $p = $table->load($id);
        if (!$this->getDi()->auth->getUserId()) // not logged-in
        {
            if ($p->hasAccess(null)) // guest access allowed?
                return $p;           // then process
            $this->_redirect('login?amember_redirect_url=' . $this->getFullUrl());
        }
        if (!$p->hasAccess($this->getDi()->user))
        {
            if(!empty($p->no_access_url))
                $this->_redirect($p->no_access_url);
            else
                $this->_redirect('no-access/content/'.sprintf('?id=%d&type=%s', 
                    $id, $table->getName(true)));
        }
        
        return $p;
    }
}