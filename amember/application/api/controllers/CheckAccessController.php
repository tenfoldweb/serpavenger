<?php

class Api_CheckAccessController extends Am_Controller_Api
{
    protected function checkUser(User $user = null, $errCode = null, $errMsg = null, $ip = null)
    {
        if ($user)
        {
            if($ip)
            {
                $auth = new Am_Auth_User(null, $this->getDi());
                if($res = $auth->checkUser($user, $this->_getParam('ip')))
                {
                    $ret = array(
                        'ok' => false,
                        'code' => $res->getCode(),
                        'msg'  => $res->getMessage(),
                    );
                    $this->ajaxResponse($ret);
                    return;
                }
            }
            $accessRecords = $user->getActiveProductsExpiration();
            $ret = array(
                'ok' => true,
                'user_id' => $user->pk(),
                'name' => $user->getName(),
                'name_f' => $user->name_f,
                'name_l' => $user->name_l,
                'email' => $user->email,
                'login' => $user->login
            );
            foreach ($accessRecords as $pid => $expires)
            {
                $ret['subscriptions'][$pid] = $expires;
            }
        } else {
            if (empty($errCode)) $errCode = -1;
            if (empty($errMsg)) $errMsg = "Failure";
            $ret = array(
                'ok' => false,
                'code' => $errCode,
                'msg'  => $errMsg,
            );
        }
        $this->ajaxResponse($ret);
    }
    
    /**
     * Check access by username/password
     */
    function byLoginPassAction()
    {
        $code = null;
        $user = $this->getDi()->userTable->getAuthenticatedRow($this->_getParam('login'), $this->_getParam('pass'), $code);
        $res = new Am_Auth_Result($code);
        $this->checkUser($user, $res->getCode(), $res->getMessage());
    }
    /**
     * Check access by username
     */
    function byLoginAction()
    {
        $user = $this->getDi()->userTable->findFirstByLogin($this->_getParam('login'));
        $this->checkUser($user);
    }
    /**
     * Check access by email address
     */
    function byEmailAction()
    {
        $user = $this->getDi()->userTable->findFirstByEmail($this->_getParam('email'));
        $this->checkUser($user);
    }
    /**
     * Check access by username/password/ip
     */
    function byLoginPassIpAction()
    {
        $code = null;
        $user = $this->getDi()->userTable->getAuthenticatedRow($this->_getParam('login'), $this->_getParam('pass'), $code);
        $res = new Am_Auth_Result($code);
        $this->checkUser($user, $res->getCode(), $res->getMessage(),$this->_getParam('ip'));
    }
}