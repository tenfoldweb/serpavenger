<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BuyPackage extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper('dom');
   $this->load->model('buypackage_model');
   $this->load->model('userlogin_model');
 }
	
	public function index()
	{
			$data['page_title'] = 'SERP Avenger';
			
			$uid = "";
	
			if($this->session->userdata('user_data'))
			 {
				$user_data = $this->session->userdata('user_data');
				
				$uid = $user_data['user_id'];
			 }
			 
			 $package = $this->buypackage_model->get_packages($uid);
				
			 $data['package'] = $package;
	
			if($this->input->get('stat') && $this->input->get('stat') == 1)
			{
                                sleep(60);	
				redirect(Am_Lite::getInstance()->getLoginURL()."?stat=1");
			}
	
			$this->load->view('buypackage', $data);
	}
}