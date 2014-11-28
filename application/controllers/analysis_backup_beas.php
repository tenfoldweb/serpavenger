<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_campaign');
	}
	
	
	public function index(){
		//$this->check_login();
		//$parasitelist	= $this->parasitelist();		
		
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
		if(is_array($this->data['campaign_list']) && count($this->data['campaign_list']) > 0){
			   if(is_array($this->data['campaign_list'][0]['campaign']) && count($this->data['campaign_list'][0]['campaign']) > 0){
			     $this->data['single_campaign'] = $this->data['campaign_list'][0]['campaign'][0];			     
			     
			   }
			}

		//$campaign_id		= $this->model_campaign->insertUsersCampaign($users_id);

		/*$campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = "'.$campaign_id.'"');

		$campaign_main_page_url	= $campaign_detail[0]['campaign_main_page_url'];
		$campaign_main_keyword	= $campaign_detail[0]['campaign_main_keyword'];
		$parse 			= parse_url($campaign_main_page_url);


		$campaign_murl_thumb			= $this->analyze->get_Site_thumb($campaign_main_page_url);
		copy($campaign_murl_thumb, FRONT_SITE_THUMB_PATH . $data['campaign_murl_domain'] . '_' . $campaign_id . '.jpg');
		$data['campaign_murl_thumb']		= $data['campaign_murl_domain'] . '_' . $campaign_id . '.jpg';
		$www_resolved				= $this->analyze->check_site($campaign_main_page_url,true);


		$this->data['rendertoptenresults']=$this->model_analysis->get_rendertoptenresults();*/

		//$this->templatelayout->get_header();
		//$this->templatelayout->make_seo();
		//$this->templatelayout->get_left();
		//$this->templatelayout->get_topmenu();
		//$this->templatelayout->get_footer();

		$this->elements['middle']='analysis/list';
		$this->elements_data['middle'] = $this->data;

		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}


}

/* End of file member.php */
/* Location: ./front-app/controllers/member.php */