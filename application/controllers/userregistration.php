<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserRegistration extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper('dom');
   $this->load->model('userregistration_model');
 }
	
	public function index()
	{
		$data['page_title'] = 'SERP Avenger';
		$this->load->view('userregistration', $data);
	}
	
	public function saveuser()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_fees', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|is_unique[am_user.login]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[am_user.email]');

		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('message', '<div class="notification note-error">
										<a title="Close notification" class="close" href="#">close</a>
										<p>'.validation_errors().'</p>
									</div>');
		}
		else
		{
			$userdata = array('first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_fees'),
				'user_name' => $this->input->post('user_name'),
				'password' => $this->input->post('password'),
				'email' => $this->input->post('email'));
			
			$stat = $this->userregistration_model->create_user($userdata);
			
			if($stat)
		     redirect('userlogin?stat=1');
		}

		 redirect('userregistration');
	}	
}