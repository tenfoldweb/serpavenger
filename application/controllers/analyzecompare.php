<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnalyzeCompare extends CI_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->helper('dom');
		$this->load->library('analyze');
		$this->load->model('model_basic');
		$this->load->model('model_campaign');
		$this->load->model('model_ranking');
		$this->load->model('userlogin_model');
		 $user_data = array('user_id' => 9,
								'user_login' => 'scott_paxton',
								'user_email' => 'spax@rpautah.com',
								'user_name_f' => 'Scott',
								'user_name_l' => 'Paxton'
								);
				
		$this->session->set_userdata('user_data', $user_data);
		 if(!$this->session->userdata('user_data'))
		 {
		   redirect(Am_Lite::getInstance()->getLoginURL());
		 }
		 
		
	}

	public function index()
	{
		/*$this->check_login();
		$this->data 		= '';
		$users_id		= $this->session->userdata('LOGIN_USER');*/
	//echo "<pre>";	 //echo "test";print_r ($this->input->post($_REQUEST));
	//print_r ($this->input->get_post('action'));
 //print_r ($_REQUEST);
//alert('i am here.');
	$session = $this->session->userdata('user_data'); 
		
		$get_packages = $this->userlogin_model->get_packages($session['user_id']);

			foreach($get_packages as $row)
			{
				if($row['analysis_permission'] == 1)
				{
					$permission = TRUE; 
					break;
				}
				else
				{
					$permission = FALSE;
				}
			}
         $users_id = $session['user_id'];

     //$this->data['keyword']=$this->model_campaign->mainkeywords($users_id); 
        $this->data['keywordmain']=$this->model_campaign->mainkeywords($users_id); 
          $this->data['secondkeywordspopup']=$this->model_campaign->secondkeywordspopup($users_id); 
              //$this->data['keywordsec']=$this->model_campaign->seckeywords($users_id); 
      $this->data['userdetailcompare']=$this->model_campaign->getuserdetailcompare($users_id,$campaign_id);        
	//  print_r($this->data['userdetailcompare']);
	  $campaign_id = $this->data['userdetailcompare']->id;
      $keyword_id=($this->data['keywordmain']['keyword_id']);
      $this->data['keyword_id'] = $keyword_id;
        //echo($this->data['keyword']);
      $this->data['keywordloop']=$this->model_campaign->mainkeywordsloop($users_id);
      $this->data['secondkeyword']=$this->model_campaign->secondkeywordscampaign($users_id,$campaign_id);
	  
      
     //print_r($this->data['userdetailcompare']);
     //echo $this->data['userdetailcompare']->campaign_main_keyword;
      //$this->data['additionalkeyword']=$this->model_campaign->additionalkeywords($users_id);
      // AIRCode
      $this->data['additionalkeyword'] = "";
      // /AIRCode
      $this->data['additionalkeywordloop']=$this->model_campaign->additionalkeywordsloop($users_id);
    // print_r($this->data['secondkeywordloop']);
   //  echo $keyword;
   $campaign_id;

      $campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = "'.$campaign_id.'"');
			
        $campaign_id		= $this->uri->segment(3, 2);
        //print_r ($campaign_id);
		$campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = 1');
		$campaign_title		= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGN_MASTER, '*', '', 'campaign_id = "'.$campaign_detail[0]['c_id'].'"');
		//print_r ($campaign_title);
		$campaign_main_page_url	= $campaign_detail[0]['campaign_main_page_url'];
		//echo "campaign_main_keyword22".$campaign_main_keyword	= $campaign_detail[0]['campaign_main_keyword'];
		$campaign_main_keyword	= $this->data['userdetailcompare']->campaign_main_keyword;

			$campaign_secondary_keyword	= $this->data['userdetailcompare']->campaign_secondary_keyword;

		
		$campaign_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = '.$campaign_id);
		$campaign_main_kw_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = "'.$campaign_id.'" AND keyword_type = "M"');
				
		 $this->data['campaign_id']			= $campaign_id; //echo $campaign_id;
		$this->data['campaign_title']			= $campaign_title[0]['campaign_title'];
		$this->data['campaign_detail']			= $campaign_detail;
		$this->data['campaign_cpc_detail']		= $campaign_cpc_detail;
		$this->data['campaign_cpc_main_kw_detail']	= $campaign_main_kw_cpc_detail;
		$this->data['kw_valuation_percentage'] 		= array(32.5,17.6,11.4,8.1,6.1,4.4,3.5,3.1,2.6,2.4);	
		$this->data['active_campaignList'] =  $this->model_basic->getActiveCampaignList($users_id);	
        $this->data['secondkeywordloop']=$this->model_campaign->secondkeywordsloop($users_id,$campaign_id);


//echo "campaign_main_keyword34".$campaign_main_keyword;
 if($campaign_main_keyword!='')
{
 $this->data['kcpcData']=$this->analyze->keywordCPCData($campaign_main_keyword);
}
else
{
  $this->data['kcpcData']=$this->analyze->keywordCPCDatabydomain($campaign_secondary_keyword);
}

// AIRCode - secondary keyword must be blank, unless the user selects on from the popup window
              //$this->data['keywordsec'] = $this->data['kcpcData'][1][0];
              $this->data['keywordsec'] = "";
              // /AIRCode

//print "<pre>"; print_r($this->data['kcpcData']); print "</pre>";
 
         // print_r($campaign_cpc_detail);

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
       /*
		$campaign_id		= $this->uri->segment(3, 0);
		$campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = "'.$campaign_id.'"');
		$campaign_title		= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGN_MASTER, '*', '', 'campaign_id = "'.$campaign_detail[0]['c_id'].'"');
		$campaign_main_page_url	= $campaign_detail[0]['campaign_main_page_url'];
		$campaign_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = "'.$campaign_id.'"');
		$campaign_main_kw_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = "'.$campaign_id.'" AND keyword_type = "M"');*/
				
		/*$this->data['campaign_id']			= $campaign_id;
		$this->data['campaign_title']			= $campaign_title[0]['campaign_title'];
		$this->data['campaign_detail']			= $campaign_detail;
		$this->data['campaign_cpc_detail']		= $campaign_cpc_detail;
		$this->data['campaign_cpc_main_kw_detail']	= $campaign_main_kw_cpc_detail;
		$this->data['kw_valuation_percentage'] 		= array(32.5,17.6,11.4,8.1,6.1,4.4,3.5,3.1,2.6,2.4);*/	
		
        $this->elements['middle']='campaign/analyze-compare';			
		$this->elements_data['middle'] = $this->data;
		$this->layout->setLayout('main_layout_new');
		$this->layout->multiple_view($this->elements,$this->elements_data);
		
	}


	


	/*public function analyze(){
		$session = $this->session->userdata('user_data'); 
		
		$get_packages = $this->userlogin_model->get_packages($session['user_id']);

			foreach($get_packages as $row)
			{
				if($row['analysis_permission'] == 1)
				{
					$permission = TRUE; 
					break;
				}
				else
				{
					$permission = FALSE;
				}
			}
        echo $users_id = $session['user_id'];

		$campaign_id		= $this->uri->segment(3, 0);
		$campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = 1');
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
		
		
        $this->elements['middle']='campaign/analyze-compare';			
		$this->elements_data['middle'] = $this->data;
		//$this->layout->setLayout('main_layout_new');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
*/
}
