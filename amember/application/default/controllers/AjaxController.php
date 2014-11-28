<?php


class AjaxController extends Am_Controller
{
    function ajaxError($msg){
        $this->ajaxResponse(array('msg' => $msg));
    }

    function ajaxGetStates($vars){
        return $this->ajaxResponse($this->getDi()->stateTable->getOptions($vars['country']));
    }

    function ajaxCheckUniqLogin($vars){
        $user_id = $this->getDi()->auth->getUserId();
        if (!$user_id)
            $user_id = $this->getDi()->session->signup_member_id;

        $login = $vars['login'];
        $msg = null;
        if (!$this->getDi()->userTable->checkUniqLogin($login, $user_id))
            $msg = ___('Username %s is already taken. Please choose another username', Am_Controller::escape($login));

        if (!$msg)
            $msg = $this->getDi()->banTable->checkBan(array('login'=>$login));

        return $this->ajaxResponse($msg ? $msg : true);
    }

    function ajaxCheckUniqEmail($vars){
        $user_id = $this->getDi()->auth->getUserId();
        if (!$user_id)
            $user_id = $this->getDi()->session->signup_member_id;

        $email = $vars['email'];
        $msg = null;

        if (!$this->getDi()->userTable->checkUniqEmail($email, $user_id))
            $msg = ___('An account with the same email already exists.').'<br />'.
                    ___('Please %slogin%s to your existing account.%sIf you have not completed payment, you will be able to complete it after login','<a href="'.Am_Controller::escape(REL_ROOT_URL . '/member').'" class="ajax-link">','</a>','<br />');

        if (!$msg)
            $msg = Am_Di::getInstance()->banTable->checkBan(array('email'=>$email));

        if (!$msg && !Am_Validate::email($email))
            $msg = ___('Please enter valid Email');

        return $this->ajaxResponse($msg ? $msg : true);
    }

    function ajaxCheckCoupon($vars){
        if (!$vars['coupon']) return $this->ajaxResponse(true);
        $user_id = $this->getDi()->auth->getUserId();
        if (!$user_id)
            $user_id = $this->getDi()->session->signup_member_id;

        $coupon = $this->getDi()->couponTable->findFirstByCode($vars['coupon']);
        $msg = $coupon ? $coupon->validate($user_id) : ___('No coupons found with such coupon code');
        return $this->ajaxResponse(is_null($msg) ? true : $msg);
    }

    function indexAction()
    {
        $vars = $this->_request->toArray();
        switch ($this->_request->getFiltered('do')){
            case 'get_states':
                $this->ajaxGetStates($vars);
                break;
            case 'check_uniq_login':
                $this->ajaxCheckUniqLogin($vars);
                break;
            case 'check_uniq_email':
                $this->ajaxCheckUniqEmail($vars);
                break;
            case 'check_coupon':
                $this->ajaxCheckCoupon($vars);
                break;
            default:
                $this->ajaxError('Unknown Request: ' . $vars['do']);
        }
    }

    function unsubscribedAction()
    {
        $v = $this->_request->getPost('unsubscribed');
        if (strlen($v) != 1) 
            throw new Am_Exception_InputError("Wrong input");
        $v = ($v > 0) ? 1 : 0;
        if (($s = $this->getFiltered('s')) && ($e = $this->getParam('e')) &&
            Am_Mail::validateUnsubscribeLink($e, $s))
        {
            $user = $this->getDi()->userTable->findFirstByEmail($e);
        } else {
            $user = $this->getDi()->user;
        }
        if (!$user) 
            return $this->ajaxError(___('You must be logged-in to run this action'));
        if ($user->unsubscribed != $v)
        {
            $user->set('unsubscribed', $v)->update();            
            $this->getDi()->hook->call(Am_Event::USER_UNSUBSCRIBED_CHANGED, 
                array('user'=>$user, 'unsubscribed' => $v));
        }
        $this->ajaxResponse(array('status' => 'OK', 'value' => $v));
    }
}