<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserStatus extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper('dom');
   $this->load->model('userlogin_model');
   
   if(!$this->session->userdata('user_data'))
   {
	 redirect(Am_Lite::getInstance()->getLoginURL());
   }
 }
	
	public function index()
	{		
		$session = $this->session->userdata('user_data'); 
		
		$user_status = $this->userlogin_model->get_user_log($session['user_id']);
		
		if($user_status)
		  redirect('campaign');
		else
		  redirect('mypannel');
	}
}