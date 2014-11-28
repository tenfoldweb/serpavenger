<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ranking extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_campaign');
		$this->load->model('model_ranking');
	}
	
	
	public function index(){
		$this->check_login();
		$parasitelist	= $this->parasitelist();
		//pr($_GET, 0);
		
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
		$this->data['campaign_detail'] = $this->model_campaign->getCampaignDetail($cid, $users_id);
		$this->data['campaign_record']  = $this->model_campaign->getCampaignListingByUser($users_id);
		
		$currDate = date("Y-m-d");
		// Google data
		$google_data_top3 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 3);
		$google_data_top10 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 10);
		$google_data_top20 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 20);
		
		// Yahoo data
		$yahoo_data_top3 = $this->model_campaign->getYahooDataForCampaign($cid, $currDate, 3);
		$yahoo_data_top10 = $this->model_campaign->getYahooDataForCampaign($cid, $currDate, 10);
		$yahoo_data_top20 = $this->model_campaign->getYahooDataForCampaign($cid, $currDate, 20);
		
		// Bing data
		$bing_data_top3 = $this->model_campaign->getBingDataForCampaign($cid, $currDate, 3);
		$bing_data_top10 = $this->model_campaign->getBingDataForCampaign($cid, $currDate, 10);
		$bing_data_top20 = $this->model_campaign->getBingDataForCampaign($cid, $currDate, 20);
		
		
		// Top 3
		$parasiteCountTop3 = 0;
		$moneysiteCountTop3 = 0;
		
		if(is_array($google_data_top3) && count($google_data_top3) > 0){
			for($i=0; $i<count($google_data_top3); $i++){
				$url = $google_data_top3[$i]['url'];
				$url = parse_url($url);				
				foreach($parasitelist AS $val){
					if(strpos($url['host'], $val) >= 0){
						$parasiteCountTop3++;
						break;
					}
				}
			}
			$moneysiteCountTop3 = count($google_data_top3)-$parasiteCountTop3;
		}
		
		// Top 10
		$parasiteCountTop10 = 0;
		$moneysiteCountTop10 = 0;
		
		if(is_array($google_data_top10) && count($google_data_top10) > 0){
			for($i=0; $i<count($google_data_top10); $i++){
				$url = $google_data_top10[$i]['url'];
				$url = parse_url($url);				
				foreach($parasitelist AS $val){
					if(strpos($url['host'], $val) >= 0){
						$parasiteCountTop10;
						break;
					}
				}
			}
			$moneysiteCountTop10 = count($google_data_top10)-$parasiteCountTop10;
		}
		
		// Top 20
		$parasiteCountTop20 = 0;
		$moneysiteCountTop20 = 0;
		
		if(is_array($google_data_top20) && count($google_data_top20) > 0){
			for($i=0; $i<count($google_data_top20); $i++){
				$url = $google_data_top20[$i]['url'];
				$url = parse_url($url);				
				foreach($parasitelist AS $val){
					if(strpos($url['host'], $val) >= 0){
						$parasiteCountTop20;
						break;
					}
				}
			}
			$moneysiteCountTop20 = count($google_data_top20)-$parasiteCountTop20;
		}
		
		$this->data['parasite_count_top3'] = $parasiteCountTop3;
		$this->data['monetsite_count_top3'] = $moneysiteCountTop3;
		$this->data['parasite_count_top10'] = $parasiteCountTop10;
		$this->data['monetsite_count_top10'] = $moneysiteCountTop10;
		$this->data['parasite_count_top20'] = $parasiteCountTop20;
		$this->data['monetsite_count_top20'] = $moneysiteCountTop20;
		
		
		//pr($this->data);
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_left();
		$this->templatelayout->get_topmenu();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='ranking/list';			
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	
}

/* End of file member.php */
/* Location: ./front-app/controllers/member.php */