<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_campaign');
	}
	
	
	public function index(){
		$this->check_login();
		$parasitelist	= $this->parasitelist();		
		
		if(isset($_GET['cid']) && !empty($_GET['cid'])){
			$cid	= (int)trim($_GET['cid']);	
		}else{
			$cid	= 0;
		}
		
		$users_id	= $this->session->userdata('LOGIN_USER');
		$this->data = '';
		$this->data['users_id'] = $users_id;
		$this->data['cid'] = $cid;
		$this->data['campaign_list'] = $this->model_campaign->getUsersCampaigns($users_id);
		$this->data['campagin_keyword_list']=$this->model_campaign->getUsersCampaignsKeywords($users_id);
		//pr($this->data['campaign_list']);
		$this->data['campaign_crawl_detail'] = $this->model_campaign->getUsersCampaignCrawlDetail($this->data['campaign_list'][0]['campaign'][0]);
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_left();
		$this->templatelayout->get_topmenu();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='analysis/list';			
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	
}

/* End of file member.php */
/* Location: ./front-app/controllers/member.php */