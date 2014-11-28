<?php
/**
 * Logs affiliate click and sets affiliate cookies;
 */

class Aff_ClickJsController extends Am_Controller
{
    
    function findAff()
    {
        $id = preg_replace('/[^ a-zA-Z0-9_-]/', '', $this->getParam('r'));
        
        if (is_numeric($id)) {
            $aff = $this->getDi()->userTable->load($id, false);
            if ($aff) return $aff;
        }
        
        if (strlen($id)) {
            $aff = $this->getDi()->userTable->findFirstByLogin($id);
            if ($aff) return $aff;
        }
        return null;
    }
    
    function indexAction(){
        if(!Am_Di::getInstance()->config->get('aff.tracking_code'))
        {
            $this->log('Click logging disabled in config');
        }
        elseif ($this->aff = $this->findAff())
        {
          $aff_click_id = $this->getDi()->affClickTable->log($this->aff, null, $this->getParam('s'));
          $this->getModule()->setCookie($this->aff, null, $aff_click_id);
          $this->log('Click Logged');
        }
    }
    
    function log($text){
        echo 'console.log("'.$text.'")';
    }
    
}
