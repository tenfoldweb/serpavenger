<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seoranking extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_seoranking');
		$this->load->model('model_basic');
		$this->load->model('model_campaign');
	}
	
	public function index() {
		$user_id = $this->session->userdata('LOGIN_USER');
		$condition = "user_id = '".$user_id."' and status = 'Active'";
		$this->data = '';		
		
		$this->data['seo_ranking_data'] =  $this->model_seoranking->ListSeoRanking($user_id);
		//pr($this->data);
		$this->data['succmsg'] = $this->session->userdata('succmsg');
		$this->session->unset_userdata('succmsg', "");
		$this->data['errmsg'] = $this->session->userdata('errmsg');
		$this->session->unset_userdata('errmsg', "");
		
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_left();
		$this->templatelayout->get_topmenu();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='ranking/seoranking_list';
		
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
		
	}
	
	public function add(){
		
		$user_id = $this->session->userdata('LOGIN_USER');
		if($this->input->get_post('action') == 'Process'){
			

			$this->form_validation->set_rules('campaign_id', 'Type of Campaign ', 'required|trim');
			$this->form_validation->set_rules('type_of_page', 'Type of Page', 'required');
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');
			if($this->input->get_post('type_of_page') == 'Offpage') {
				$this->form_validation->set_rules('duration', 'Duration', 'required|trim');
			}
			
			
			if ($this->form_validation->run() == FALSE){
				
			}else{
				
				//////////////////////////////////
				$seo_ranking		= $this->model_seoranking->insertSeoRankingData($user_id);
				
				
				
				
				if($seo_ranking != ''){
					$this->session->set_userdata('succmsg', "Record added successfully.");
					redirect(FRONT_URL . 'seoranking');
					return true;
				}else{
					$this->session->set_userdata('errmsg', "Record is not added successfully.");
					redirect(FRONT_URL . 'seoranking/add');
					return true;
				}
			}		    
		}
		
		$condition = "users_id = '".$user_id."' and campaign_status = 'Active'";
		$this->data = '';		
		
		//$this->data['campaign_data'] =  $this->model_basic->getValue_condition(TABLE_USERS_CAMPAIGN_MASTER,'*','',$condition);
		$this->data['campaign_data'] = $this->model_campaign->getUsersCampaigns($user_id);		
		
		$this->data['succmsg'] = $this->session->userdata('succmsg');
		$this->session->unset_userdata('succmsg', "");
		$this->data['errmsg'] = $this->session->userdata('errmsg');
		$this->session->unset_userdata('errmsg', "");
		
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_left();
		$this->templatelayout->get_topmenu();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='ranking/seo_ranking';
		
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	
	 public function DeleteSeoRanking(){
		
		$data = false;
		$sr_id  = $this->uri->segment(3,0);
		
		$data = $this->model_seoranking->DeleteSeoRanking($sr_id);
		
		if($data == true) {
			$this->session->set_userdata('succmsg', "Record Deleted successfully.");
			redirect(FRONT_URL . 'seoranking');
		} else {
			
			$this->session->set_userdata('errmsg', "Record is not Deleted.");
			redirect(FRONT_URL . 'seoranking');
		}
		
		
	 }
	 
	 
	 public function  ReserverDateUpdate(){
		
		$sr_id  = $this->uri->segment(3,0);
		if($this->input->get_post('action') == 'Process'){
			$this->form_validation->set_rules('reverse_date', 'Reserve Date', 'required|trim');
			
			if ($this->form_validation->run() == FALSE){
				
			} else {
				
			 $data = $this->model_seoranking->UpdateReserveDate();
			 
			if($data == true) {
				$this->session->set_userdata('succmsg', "Reseve Date Update successfully.");
				redirect(FRONT_URL . 'seoranking');
			} else {
				
				$this->session->set_userdata('errmsg', "Reseve Date is not Update.");
				redirect(FRONT_URL . 'seoranking');
			}
			 
				
			}
		}
		$this->data['seo_ranking_details'] = $this->model_seoranking->getSingle($sr_id);
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_left();
		$this->templatelayout->get_topmenu();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='ranking/reserve_date_update';
		
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
		
		
	 }

}

/* End of file testranking.php */
/* Location: ./front-app/controllers/testranking.php */