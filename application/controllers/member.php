<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_basic');
		$this->load->model('model_campaign');
	}
	
	public function index(){
		$this->data = '';		
		
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='home';			
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	
	public function login(){
		$invalidLogin		= false;
		$this->data 		= '';		
		$this->data['err_msg']	= '';
		
		if($this->input->get_post('action') == 'Process'){
			$users_email		= addslashes(trim($this->input->get_post('users_email')));
			$users_password	= addslashes(trim($this->input->get_post('users_password')));
			
			$loginReturn	= $this->model_basic->getValues_conditions(TABLE_USERS, '*', '', 'users_email = "'.$users_email.'"');
			if(is_array($loginReturn) && count($loginReturn) > 0){				
				if($loginReturn[0]['users_password'] == $users_password){
					if($loginReturn[0]['users_status'] == 'Active'){
						$this->session->set_userdata('LOGIN_USER', $loginReturn[0]['users_id']);
						$this->session->set_userdata('LOGIN_USER_NAME', $loginReturn[0]['user_name']);
						
						redirect(FRONT_URL . 'dashboard');
						return true;
					}else{						
						$invalidLogin	= true;
					}
				}else{					
					$invalidLogin	= true;
				}
			}else{
				
				$invalidLogin	= true;
			}
			
			if($invalidLogin){
				$this->session->set_userdata('err_msg', 'Invalid email/password');
				redirect(FRONT_URL . 'member/login/');
				return true;
			}
		}
		
		if($this->session->userdata('err_msg') != ''){
			$this->data['err_msg']	= $this->session->userdata('err_msg');
			$this->session->set_userdata('err_msg', '');
		}
		
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='member/login';			
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	
	public function dashboard(){
		$this->check_login();	
		$this->data = '';		
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_left();
		$this->templatelayout->get_topmenu();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='member/dashboard';			
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	
	public function logout(){
		$this->session->set_userdata('LOGIN_USER', '');
		redirect('welcome');
	}
}

/* End of file member.php */
/* Location: ./front-app/controllers/member.php */