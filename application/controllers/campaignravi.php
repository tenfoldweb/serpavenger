<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaign extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('analyze');
		$this->load->helper('dom');
		$this->load->model('model_basic');
		$this->load->model('model_campaign');
		$this->load->model('model_ranking');
		/* Added by Beas -  For user login permission */

		$user_data = array('user_id' => 9,
								'user_login' => 'scott_paxton',
								'user_email' => 'spax@rpautah.com',
								'user_name_f' => 'Scott',
								'user_name_l' => 'Paxton'
								);
				
		$this->session->set_userdata('user_data', $user_data);


//$data = $this->session->userdata('user_data');

		$this->load->model('userlogin_model');

		 /*if(!$this->session->userdata('user_data'))
		 {
		   redirect(Am_Lite::getInstance()->getLoginURL());
		 }*/
		 
		
		 /* Added by Beas  */
	}
	
/*	public function check_unique_campaign_title($campaign_title){
		$users_id	= $this->session->userdata('LOGIN_USER');
		//$bool	= $this->model_campaign->checkExistsCampaignTitle($campaign_title, $users_id);
		if($bool){
			$this->form_validation->set_message('check_unique_campaign_title', 'Campaign Title %s already exists.');
			return FALSE;
		}else{
			return TRUE;
		}
	}
*/
	
	public function index(){
	/* Added by Beas -  Assigning userid */


			$session = $this->session->userdata('user_data');
			print_R($session);
			$users_id = $session['user_id'];
			$get_packages = $this->userlogin_model->get_packages($users_id);

		$max_sites_per_subscription_count = $this->model_campaign->count_max_sites_per_subscription($users_id);
		$max_sites_per_subscription = 0;
		foreach($get_packages as $row)
		{
			$max_sites_per_subscription += $row['max_sites_per_subscription'];
		}
	
		$this->data['max_sites_per_subscription_count'] = $max_sites_per_subscription_count;
		$this->data['max_sites_per_subscription_count'] = 650;
		$this->data['max_sites_per_subscription'] = $max_sites_per_subscription;
		//$this->data['getserpcrawl_conditions'] =  $this->model_campaign->getserpcrawl_conditions($users_id);	
				
	 /* Added by Beas  */
		/*$this->check_login();
		$users_id	= $this->session->userdata('LOGIN_USER');
		$this->data = '';
		*/
		if($this->input->get_post('action') == 'Process'){
			//print_r ($this->input->post());
			$skip	= $this->input->get_post('skip');
			if($this->input->post(campaign_title))
			{
			  $this->form_validation->set_rules('campaign_title', 'Create Campaign', 'required|trim');
			}
			else
			{
			  $this->form_validation->set_rules('c_id', 'Campaign Title', 'required|trim');	
			}

			$this->form_validation->set_rules('campaign_site_type', 'Type of site', 'required');
			//$required_if_google = $this->input->post('isCrawlByGoogle') ? 'required' : '' ;
			//$this->form_validation->set_rules('google_se_domain', 'Country for Google Search Engine.', $required_if_google);
			//$required_if_bing = $this->input->post('isCrawlByBing') ? 'required' : '' ;
			//$this->form_validation->set_rules('bing_se_domain', 'Country for Bing Search Engine.', $required_if_bing);
			//$required_if_yahoo = $this->input->post('isCrawlByYahoo') ? 'required' : '' ;
			//$this->form_validation->set_rules('yahoo_se_domain', 'Country for Yahoo Search Engine.', $required_if_yahoo);
			$this->form_validation->set_rules('campaign_exact_url_track', 'Track Exact URL Only', 'required');
			$this->form_validation->set_rules('campaign_main_page_url', 'URL of Main Page You Want to Rank', 'required|trim');
			
			$required_if_google = $this->input->post('isCrawlByGoogle');
			$required_if_bing = $this->input->post('isCrawlByBing');
			$required_if_yahoo = $this->input->post('isCrawlByYahoo');



if($required_if_google =='' && $required_if_bing =='' && $required_if_yahoo =='')
            {

$this->form_validation->set_rules('isCrawlByGoogle', 'What Search Engine Would You Like to Focus on?', 'required|trim');
            	
            	
            }





			 $required_google = $this->input->post('google_se_domain');
			 $required_bing = $this->input->post('bing_se_domain');
			 $required_yahoo = $this->input->post('yahoo_se_domain');
            

           
            if($required_google=='' && $required_bing=='' && $required_yahoo=='')
            {
            	//echo "test";
            	$this->form_validation->set_rules('google_se_domain', 'What Search Engine Would You Like to Focus on?', 'required|trim');
            	$this->form_validation->set_rules('bing_se_domain');
            	$this->form_validation->set_rules('yahoo_se_domain');
            	//exit();
            }
            
 
			if($this->input->post(campaign_main_keyword))
			{
			  $this->form_validation->set_rules('campaign_main_keyword', 'Main Target keyword', 'required|trim');
			}
			else
			{
			  $this->form_validation->set_rules('campaign_secondary_keyword', 'Competitor’s Keywords', 'required|trim');
			}
			
			if ($this->form_validation->run() == FALSE){
				
			}else{
				// Crawl related data for campaign
				//////////////////////////////////
				$campaign_id		= $this->model_campaign->insertUsersCampaign($users_id);
				
				$campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = "'.$campaign_id.'"');
				
				/*$campaign_main_page_url	= $campaign_detail[0]['campaign_main_page_url'];
				$campaign_main_keyword	= $campaign_detail[0]['campaign_main_keyword'];
				$parse 			= parse_url($campaign_main_page_url);
				
				$data['campaign_murl_creation_date']	= $this->analyze->getSiteAge($parse['host']);
				$data['campaign_murl_ip']		= gethostbyname($parse['host']);
				$data['campaign_murl_domain']		= str_replace("www.", "", $parse['host']);
				$data['campaign_murl_country_code']	= $this->analyze->getIPToCountry($data['campaign_murl_ip']);
				$campaign_murl_thumb			= $this->analyze->get_Site_thumb($campaign_main_page_url);
				copy($campaign_murl_thumb, FRONT_SITE_THUMB_PATH . $data['campaign_murl_domain'] . '_' . $campaign_id . '.jpg');
				$data['campaign_murl_thumb']		= $data['campaign_murl_domain'] . '_' . $campaign_id . '.jpg';
				$www_resolved				= $this->analyze->check_site($campaign_main_page_url,true);
				if($www_resolved){
					$data['campaign_murl_www_resolved']	= 'Yes';	
				}else{
					$data['campaign_murl_www_resolved']	= 'No';
				}
				
				$sitemap_xml		= $this->analyze->check_site($campaign_main_page_url."/sitemap.xml",true);
				if($sitemap_xml){
					$data['campaign_murl_sitemap']	= 'Yes';	
				}else{
					$data['campaign_murl_sitemap']	= 'No';
				}
				$robots_txt	= $this->analyze->check_site($campaign_main_page_url."/robots.txt",true);
				if($robots_txt){
					$data['campaign_murl_robots_txt']	= 'Yes';	
				}else{
					$data['campaign_murl_robots_txt']	= 'No';
				}
				$data['kcpcData']			= $this->analyze->keywordCPCData($campaign_main_keyword);
				
				// SERP Preview
				$page_description	= '';
				$html 		= file_get_html($campaign_main_page_url);
				foreach($html->find('meta[name="description"]') AS $result){
					$page_description	= $result->plaintext;
				}
				$data['page_description']	= $page_description;
				
				$page_title	= '';
				foreach($html->find('title') AS $result){
					$page_title	= $result->plaintext;			
				}
				$data['page_title']	= $page_title;
				
				$this->model_campaign->updateUsersCampaign($campaign_id, $campaign_main_keyword, $users_id, $data);
				
				if($skip == 'Yes'){
					redirect(FRONT_URL . 'campaign/publish');
					return true;
				}else{
					redirect(FRONT_URL . 'campaign/analyze/' . $campaign_id);
					return true;
				}*/
				//echo '<script type="text/javascript">';				
				//echo 'document.getElementById("frmAddCampaign").reset()';
				//echo '</script>';

				redirect('analyzecompare');
			}



		}
		$this->data['campaign_listing']	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGN_MASTER, '*', '', 'campaign_status = "Active" AND users_id = "'.$users_id.'"');
		$this->data['campaign_record']  = $this->model_campaign->getCampaignListingByUser($users_id);
		$this->data['google_country']	= $this->model_basic->getValues_conditions(TABLE_SEARCH_ENGINES, '*', '', 'type = "Google"');
		$this->data['yahoo_country']	= $this->model_basic->getValues_conditions(TABLE_SEARCH_ENGINES, '*', '', 'type = "Yahoo"');
		$this->data['bing_country']	= $this->model_basic->getValues_conditions(TABLE_SEARCH_ENGINES, '*', '', 'type = "Bing"');
		$this->data['active_campaignList'] =  $this->model_basic->getActiveCampaignList($users_id);	
		//$this->templatelayout->get_header();
		//$this->templatelayout->make_seo();
		//$this->templatelayout->get_left();
		//$this->templatelayout->get_topmenu();
		//$this->templatelayout->get_footer();
		
		$this->elements['middle']='campaign/add_step1';			
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	
	/*public function analyze(){
		$this->check_login();
		$this->data 		= '';
		
		$users_id		= $this->session->userdata('LOGIN_USER');
		$campaign_id		= $this->uri->segment(3, 0);
		$campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = "'.$campaign_id.'"');
		$campaign_title		= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGN_MASTER, '*', '', 'campaign_id = "'.$campaign_detail[0]['c_id'].'"');
		$campaign_main_page_url	= $campaign_detail[0]['campaign_main_page_url'];
		$campaign_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = "'.$campaign_id.'"');
		$campaign_main_kw_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = "'.$campaign_id.'" AND keyword_type = "M"');
				
		$this->data['campaign_id']			= $campaign_id;
		$this->data['campaign_title']			= $campaign_title[0]['campaign_title'];
		$this->data['campaign_detail']			= $campaign_detail;
		$this->data['campaign_cpc_detail']		= $campaign_cpc_detail;
		$this->data['campaign_cpc_main_kw_detail']	= $campaign_main_kw_cpc_detail;
		$this->data['kw_valuation_percentage'] 		= array(32.5,17.6,11.4,8.1,6.1,4.4,3.5,3.1,2.6,2.4);	
		
		
		
		$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		$this->templatelayout->get_left();
		$this->templatelayout->get_topmenu();
		$this->templatelayout->get_footer();
		
		$this->elements['middle']='campaign/add_step2';			
		$this->elements_data['middle'] = $this->data;
			    
		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}*/
}

/* End of file campaign.php */
/* Location: ./front-app/controllers/campaign.php */