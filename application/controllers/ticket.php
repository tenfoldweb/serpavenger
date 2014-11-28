<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('userlogin_model');
		$this->load->library('analyze');
		$this->load->helper('dom');
		$this->load->model('model_basic');
		$this->load->model('model_campaign');
		$this->load->model('model_ranking');
		
		if(!$this->session->userdata('user_data'))
		 {
		   redirect(Am_Lite::getInstance()->getLoginURL());
		 }
		
		//Edited by BEAS
	}
	public function index(){
		//echo "hi";
		$session = $this->session->userdata('user_data');
			$users_id = $session['user_id'];
			$get_packages = $this->userlogin_model->get_packages($users_id);

		$max_sites_per_subscription_count = $this->model_campaign->count_max_sites_per_subscription($users_id);
		$max_sites_per_subscription = 0;
		foreach($get_packages as $row)
		{
			$max_sites_per_subscription += $row['max_sites_per_subscription'];
		}
		$this->load->view('ticket/ticket');
		//echo "hello";
		//echo 

	}
	
	
	
}
/* End of file member.php */
/* Location: ./front-app/controllers/member.php */