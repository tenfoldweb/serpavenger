<?php 

class Aff_GoController extends Am_Controller
{
    /** @var User */
    protected $aff;
    /** @var Banner */
    protected $banner;
    
    /** @return User|null */
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
    function findAm3Aff()
    {
        $id = $this->getFiltered('r');
        if ($id > 0)
        {
            $newid = $this->getDi()->getDbService()->selectCell("SELECT id from ?_data 
                where `key`='am3:id' AND `table`='user' and value=?",$id);
            if ($newid > 0)
            {
                $aff = $this->getDi()->userTable->load($newid, false);
                if ($aff) return $aff;
            }
        }
        return null;
    }
    function findUrl()
    {
        $link = $this->getInt('i');
        if ($link > 0 )
        {
            $this->banner = $this->getDi()->affBannerTable->load($link, false);
            return $this->banner->url;
        } else {
            //try to find custom redirect url
            if($this->aff)
            {
                if($custom_url = $this->getParam('cr'))
                {
                    $cr = Am_Di::getInstance()->config->get('aff.custom_redirect');
                    if(($cr == Bootstrap_Aff::AFF_CUSTOM_REDIRECT_ALLOW_SOME_DENY_OTHERS && $this->aff->aff_custom_redirect) || 
                        ($cr == Bootstrap_Aff::AFF_CUSTOM_REDIRECT_DENY_SOME_ALLOW_OTHERS && !$this->aff->aff_custom_redirect))
                    {
                        if($url = base64_decode($custom_url))
                        {
                            if (preg_match('!^https?://!i', $url))
                                return $url;
                        }
                    }
                }
            }
            return $this->getDi()->config->get('aff.general_link_url', null);
        }
    }
    function indexAction()
    {
        $this->aff = $this->findAff();
        $event = new Am_Event(Am_Event::GET_AFF_REDIRECT_LINK, array('aff' => $this->aff));
        $event->setReturn($this->findUrl());
        $this->getDi()->hook->call($event);
        $this->link = $event->getReturn();
        /// log click
        if ($this->aff)
        {
            $aff_click_id = $this->getDi()->affClickTable->log($this->aff, $this->banner);
            $this->getModule()->setCookie($this->aff, $this->banner ? $this->banner : null, $aff_click_id);
        }
        $this->_redirect($this->link ? $this->link : '/', array('prependBase'=>false));
    }
    function findAm3Url()
    {
        $r = $this->getFiltered('i');
        $r_id = substr($r,1);
        $r_type = substr($r,0,1);
        if ($r_id > 0 && $r_type)
        {
            $url = $this->getDi()->db->selectCell("SELECT url from ?_aff3_banner where banner_link_id=? and type=?",$r_id,$r_type);
            return ($url) ? $url : $this->getDi()->config->get('aff.general_link_url', null);
        } else {
            return $this->getDi()->config->get('aff.general_link_url', null);
        }
    }
    function am3goAction()
    {
        $this->aff = $this->findAm3Aff();
        $event = new Am_Event(Am_Event::GET_AFF_REDIRECT_LINK, array('aff' => $this->aff));
        $event->setReturn($this->findAm3Url());
        $this->getDi()->hook->call($event);
        $this->link = $event->getReturn();
        /// log click
        if ($this->aff)
        {
            $aff_click_id = $this->getDi()->affClickTable->log($this->aff, $this->banner);
            $this->getModule()->setCookie($this->aff, $this->banner ? $this->banner : null, $aff_click_id);
        }
        $this->_redirect($this->link ? $this->link : '/', array('prependBase'=>false));
    }
}