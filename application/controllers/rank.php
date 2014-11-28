<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rank extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('Template');
		$this->load->library('gcharts');
		//$this->load->library('jpgraph');
		$this->load->model('model_campaign');
		$this->load->model('model_ranking');
		$this->load->model('model_seoranking');

		
		//Edited by BEAS - Check for logged in user
		
		 $this->load->model('scrapper_model');
   
         $this->load->model('userlogin_model');

		
		   if(!$this->session->userdata('user_data'))
		   {
			   
			   $this->load->library('user_agent');
				if ($this->agent->is_referral())
				{
					//echo $this->agent->referrer();
					//exit();
					redirect(Am_Lite::getInstance()->getLoginURL($this->agent->referrer())."?backurl=");
				}
				else
				 redirect(Am_Lite::getInstance()->getLoginURL($this->uri));
		   }
	
		//Edited by BEAS - Check page access
		//Edited by BEAS

	}
	
	function _remap($method)
	{
	  $param_offset = 2;
	
	  // Default to index
	  if ( ! method_exists($this, $method))
	  {
		// We need one more param
		$param_offset = 1;
		$method = 'index';
	  }
	
	  // Since all we get is $method, load up everything else in the URI
	  $params = array_slice($this->uri->rsegment_array(), $param_offset);
	
	  // Call the determined method with all params
	  call_user_func_array(array($this, $method), $params);
	} 
	
	public function index($cid=0,$sid='google',$rcsid="google"){
		
		
		
		$session = $this->session->userdata('user_data'); 
		$users_id = $session['user_id'];
		//echo $users_id;
		$this->data = '';
		$this->data['users_id'] = $users_id;
		$this->data['cid'] = $cid;
		$this->data['sid'] = $sid;
		$this->data['rcsid'] = $rcsid;
        $this->data['campaign_domain_list'] = $this->model_campaign->getAllCampaignDomains($users_id);
		$this->data['selected_campaign_keyword_list']  = $this->model_campaign->getSelectedCampaignKeywords($cid, $users_id);
		$this->data['campaign_details']  = $this->model_seoranking->getAllCampaignDetails($users_id);
		 
		 
		 
		$get_packages = $this->userlogin_model->get_packages($session['user_id']);
		$get_keyword_count = $this->model_ranking->count_keyword_by_user($session['user_id']);
			
			
			
			foreach($get_packages as $row)
			{
				if($row['ranking_permission'] == 1)
				{
					$permission = TRUE; 
					break;
				}
				else
				{
					$permission = FALSE;
				}
			}
		
		
		//Edited by BEAS
		
		
		
		//Edited by BEAS - Setting flag for page access
		
		$this->data['permission'] = $permission;
		$this->data['packages'] = $get_packages;
		
		$max_keyword_track = 0;
		foreach($get_packages as $row)
		{
			$max_keyword_track += $row['max_keyword_track'];
		}
		
		
		$this->data['get_keyword_count'] = count($get_keyword_count);
		$this->data['max_keyword_track'] = $max_keyword_track;
		//Edited by BEAS
		
		
		$this->data['count_seo_ranking_test'] = $this->model_campaign->getUsersAllSeoRankingTests($users_id);
         $this->data['campaign_list'] = $this->model_campaign->getUsersCampaigns($users_id);
		$this->data['campaign_detail'] = $this->model_campaign->getCampaignDetail($cid, $users_id);
		$this->data['campaign_record']  = $this->model_campaign->getCampaignListingByUser($users_id);
		//print_r($this->data['campaign_record']);
		$this->data['campaign_keyword_list']  = $this->model_campaign->getCampaignKeywords($cid, $users_id);
		$this->data['campaigns_selectpopup'] = $this->model_campaign->getUsersCampaignspopup($users_id);

		$this->data['campaigns_indexyahoo'] = $this->model_campaign->getUsersCampaignCrawlSerpIndexYahoo($users_id);
		$this->data['campaigns_indexgoogle'] = $this->model_campaign->getUsersCampaignCrawlSerpIndexGoogle($users_id);
		$this->data['campaigns_indexbing'] = $this->model_campaign->getUsersCampaignCrawlSerpIndexBing($users_id);

		$this->data['campaigns_keywordlist'] = $this->model_ranking->getUsersCampaignKeywordList($cid, $users_id);
		$this->data['node_listdisplay'] = $this->model_campaign->get_node_list();
		//$this->model_campaign->getCampaignKeywordsChart($cid, $users_id, $this->data['campaign_keyword_list']);
		$this->data['getcountseokeyword']=$this->model_ranking->getCountSeokeyword($users_id);
		 
		$this->data['getcountkey']=$this->model_ranking->getCountKey($users_id);

		$this->data['getCountgoogleyahoobing']=$this->model_ranking->getCountgoogleyahoobing($users_id);
		 
		$this->data['getdetailkeywordinfo']=$this->model_ranking->getDetailKeywordInfo($users_id);
		 
		
		$currDate = date("Y-m-d");
		$prevDate = date("Y-m-d", time() - 60 * 60 * 24);
		$before14Date = date("Y-m-d", time() - 60 * 60 * 24 * 14);
		$newdroprangeTop10Array = array();
		$newdroprangeTop20Array = array();
		if($sid == 'google'){
			// Google data Current date
			$google_data_top3 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 3);
			$google_data_top10 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 10);
			$google_data_top20 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 20);
			
			// Google data Previous date
			$google_data_top3_prev = $this->model_campaign->getGoogleDataForCampaign($cid, $prevDate, 3);
			$google_data_top10_prev = $this->model_campaign->getGoogleDataForCampaign($cid, $prevDate, 10);
			$google_data_top20_prev = $this->model_campaign->getGoogleDataForCampaign($cid, $prevDate, 20);
			
			$google_data_top3_range = $this->model_campaign->getGoogleDataForCampaignForRange($cid, $before14Date, $currDate, 3, $parasitelist);
			
			$google_data_top10_range = $this->model_campaign->getGoogleDataForCampaignForRange($cid, $before14Date, $currDate, 10, $parasitelist);
			$google_data_top20_range = $this->model_campaign->getGoogleDataForCampaignForRange($cid, $before14Date, $currDate, 20, $parasitelist);	
			
			
			$timestampFromDate = strtotime($before14Date);
			$timestampToDate = strtotime($currDate);
			
			for($i=$timestampFromDate; $i<=$timestampToDate; $i=$i+24*3600){
				$sameURLExistsTop10NewDrop = 0;
				$newURLExistsTop10NewDrop = 0;
				$oldSameURlExistsTop10NewDrop = 0;
				$dropURLExistsTop10NewDrop = 0;
				
				$sameURLExistsTop20NewDrop = 0;
				$newURLExistsTop20NewDrop = 0;
				$oldSameURlExistsTop20NewDrop = 0;
				$dropURLExistsTop20NewDrop = 0;
				
			        $google_data_top10_new_drop = $this->model_campaign->getGoogleDataForCampaign($cid, date("Y-m-d", $i), 10);
				$google_data_top10_prev_new_drop = $this->model_campaign->getGoogleDataForCampaign($cid, date("Y-m-d", $i- 60 * 60 * 24), 10);
				$google_data_top20_new_drop = $this->model_campaign->getGoogleDataForCampaign($cid, date("Y-m-d", $i), 20);
				$google_data_top20_prev_new_drop = $this->model_campaign->getGoogleDataForCampaign($cid, date("Y-m-d", $i- 60 * 60 * 24), 20);
				
				//Top 10
				if(is_array($google_data_top10_prev_new_drop) && count($google_data_top10_prev_new_drop) > 0){
					for($j=0; $j<count($google_data_top10_prev_new_drop); $j++){
						if($google_data_top10_new_drop[$j]['url'] == $google_data_top10_prev_new_drop[$j]['url']){
							$sameURLExistsTop10NewDrop++;
						}
					}
					$newURLExistsTop10NewDrop = count($google_data_top10_new_drop)-$sameURLExistsTop10NewDrop;
				}
				$newdroprangeTop10Array[date("Y-m-d", $i)]['new'] = $newURLExistsTop10NewDrop;
				
				if(is_array($google_data_top10_new_drop) && count($google_data_top10_new_drop) > 0){
					for($j=0; $j<count($google_data_top10_new_drop); $j++){
						if($google_data_top10_prev_new_drop[$j]['url'] == $google_data_top10_new_drop[$j]['url']){
							$oldSameURlExistsTop10NewDrop++;
						}
					}
					$dropURLExistsTop10NewDrop = count($google_data_top10_prev_new_drop)-$oldSameURlExistsTop10NewDrop;					
				}
				$newdroprangeTop10Array[date("Y-m-d", $i)]['drop'] = $dropURLExistsTop10NewDrop;
				
				
				// Top 20
				if(is_array($google_data_top20_prev_new_drop) && count($google_data_top20_prev_new_drop) > 0){
					for($j=0; $j<count($google_data_top20_prev_new_drop); $j++){
						if($google_data_top20_new_drop[$j]['url'] == $google_data_top20_prev_new_drop[$j]['url']){
							$sameURLExistsTop10NewDrop++;
						}
					}
					$newURLExistsTop20NewDrop = count($google_data_top20_new_drop)-$sameURLExistsTop20NewDrop;
				}
				$newdroprangeTop20Array[date("Y-m-d", $i)]['new'] = $newURLExistsTop20NewDrop;
				
				if(is_array($google_data_top20_new_drop) && count($google_data_top20_new_drop) > 0){
					for($j=0; $j<count($google_data_top20_new_drop); $j++){
						if($google_data_top20_prev_new_drop[$j]['url'] == $google_data_top20_new_drop[$j]['url']){
							$oldSameURlExistsTop20NewDrop++;
						}
					}
					$dropURLExistsTop20NewDrop = count($google_data_top20_prev_new_drop)-$oldSameURlExistsTop20NewDrop;					
				}
				$newdroprangeTop20Array[date("Y-m-d", $i)]['drop'] = $dropURLExistsTop20NewDrop;
				
			}
		}elseif($sid == 'yahoo'){
			// Yahoo data Current date
			$google_data_top3 = $this->model_campaign->getYahooDataForCampaign($cid, $currDate, 3);
			$google_data_top10 = $this->model_campaign->getYahooDataForCampaign($cid, $currDate, 10);
			$google_data_top20 = $this->model_campaign->getYahooDataForCampaign($cid, $currDate, 20);
			
			// Yahoo data Previous date
			$google_data_top3_prev = $this->model_campaign->getYahooDataForCampaign($cid, $prevDate, 3);
			$google_data_top10_prev = $this->model_campaign->getYahooDataForCampaign($cid, $prevDate, 10);
			$google_data_top20_prev = $this->model_campaign->getYahooDataForCampaign($cid, $prevDate, 20);
			
			$google_data_top3_range = $this->model_campaign->getYahooDataForCampaignForRange($cid, $before14Date, $currDate, 3, $parasitelist);			
			$google_data_top10_range = $this->model_campaign->getYahooDataForCampaignForRange($cid, $before14Date, $currDate, 10, $parasitelist);
			$google_data_top20_range = $this->model_campaign->getYahooDataForCampaignForRange($cid, $before14Date, $currDate, 20, $parasitelist);
			
			$timestampFromDate = strtotime($before14Date);
			$timestampToDate = strtotime($currDate);
			
			for($i=$timestampFromDate; $i<=$timestampToDate; $i=$i+24*3600){
				$sameURLExistsTop10NewDrop = 0;
				$newURLExistsTop10NewDrop = 0;
				$oldSameURlExistsTop10NewDrop = 0;
				$dropURLExistsTop10NewDrop = 0;
				
				$sameURLExistsTop20NewDrop = 0;
				$newURLExistsTop20NewDrop = 0;
				$oldSameURlExistsTop20NewDrop = 0;
				$dropURLExistsTop20NewDrop = 0;
				
			        $google_data_top10_new_drop = $this->model_campaign->getYahooDataForCampaign($cid, date("Y-m-d", $i), 10);
				$google_data_top10_prev_new_drop = $this->model_campaign->getYahooDataForCampaign($cid, date("Y-m-d", $i- 60 * 60 * 24), 10);
				$google_data_top20_new_drop = $this->model_campaign->getYahooDataForCampaign($cid, date("Y-m-d", $i), 20);
				$google_data_top20_prev_new_drop = $this->model_campaign->getYahooDataForCampaign($cid, date("Y-m-d", $i- 60 * 60 * 24), 20);
				
				//Top 10
				if(is_array($google_data_top10_prev_new_drop) && count($google_data_top10_prev_new_drop) > 0){
					for($j=0; $j<count($google_data_top10_prev_new_drop); $j++){
						if($google_data_top10_new_drop[$j]['url'] == $google_data_top10_prev_new_drop[$j]['url']){
							$sameURLExistsTop10NewDrop++;
						}
					}
					$newURLExistsTop10NewDrop = count($google_data_top10_new_drop)-$sameURLExistsTop10NewDrop;
				}
				$newdroprangeTop10Array[date("Y-m-d", $i)]['new'] = $newURLExistsTop10NewDrop;
				
				if(is_array($google_data_top10_new_drop) && count($google_data_top10_new_drop) > 0){
					for($j=0; $j<count($google_data_top10_new_drop); $j++){
						if($google_data_top10_prev_new_drop[$j]['url'] == $google_data_top10_new_drop[$j]['url']){
							$oldSameURlExistsTop10NewDrop++;
						}
					}
					$dropURLExistsTop10NewDrop = count($google_data_top10_prev_new_drop)-$oldSameURlExistsTop10NewDrop;					
				}
				$newdroprangeTop10Array[date("Y-m-d", $i)]['drop'] = $dropURLExistsTop10NewDrop;
				
				
				// Top 20
				if(is_array($google_data_top20_prev_new_drop) && count($google_data_top20_prev_new_drop) > 0){
					for($j=0; $j<count($google_data_top20_prev_new_drop); $j++){
						if($google_data_top20_new_drop[$j]['url'] == $google_data_top20_prev_new_drop[$j]['url']){
							$sameURLExistsTop10NewDrop++;
						}
					}
					$newURLExistsTop20NewDrop = count($google_data_top20_new_drop)-$sameURLExistsTop20NewDrop;
				}
				$newdroprangeTop20Array[date("Y-m-d", $i)]['new'] = $newURLExistsTop20NewDrop;
				
				if(is_array($google_data_top20_new_drop) && count($google_data_top20_new_drop) > 0){
					for($j=0; $j<count($google_data_top20_new_drop); $j++){
						if($google_data_top20_prev_new_drop[$j]['url'] == $google_data_top20_new_drop[$j]['url']){
							$oldSameURlExistsTop20NewDrop++;
						}
					}
					$dropURLExistsTop20NewDrop = count($google_data_top20_prev_new_drop)-$oldSameURlExistsTop20NewDrop;					
				}
				$newdroprangeTop20Array[date("Y-m-d", $i)]['drop'] = $dropURLExistsTop20NewDrop;
				
			}
		}elseif($sid == 'bing'){
			// Bing data Current date
			$google_data_top3 = $this->model_campaign->getBingDataForCampaign($cid, $currDate, 3);
			$google_data_top10 = $this->model_campaign->getBingDataForCampaign($cid, $currDate, 10);
			$google_data_top20 = $this->model_campaign->getBingDataForCampaign($cid, $currDate, 20);
			
			// Bing data Previous date
			$google_data_top3_prev = $this->model_campaign->getBingDataForCampaign($cid, $prevDate, 3);
			$google_data_top10_prev = $this->model_campaign->getBingDataForCampaign($cid, $prevDate, 10);
			$google_data_top20_prev = $this->model_campaign->getBingDataForCampaign($cid, $prevDate, 20);
			
			$google_data_top3_range = $this->model_campaign->getBingDataForCampaignForRange($cid, $before14Date, $currDate, 3, $parasitelist);			
			$google_data_top10_range = $this->model_campaign->getBingDataForCampaignForRange($cid, $before14Date, $currDate, 10, $parasitelist);
			$google_data_top20_range = $this->model_campaign->getBingDataForCampaignForRange($cid, $before14Date, $currDate, 20, $parasitelist);
			
			
			$timestampFromDate = strtotime($before14Date);
			$timestampToDate = strtotime($currDate);
			
			for($i=$timestampFromDate; $i<=$timestampToDate; $i=$i+24*3600){
				$sameURLExistsTop10NewDrop = 0;
				$newURLExistsTop10NewDrop = 0;
				$oldSameURlExistsTop10NewDrop = 0;
				$dropURLExistsTop10NewDrop = 0;
				
				$sameURLExistsTop20NewDrop = 0;
				$newURLExistsTop20NewDrop = 0;
				$oldSameURlExistsTop20NewDrop = 0;
				$dropURLExistsTop20NewDrop = 0;
				
			        $google_data_top10_new_drop = $this->model_campaign->getBingDataForCampaign($cid, date("Y-m-d", $i), 10);
				$google_data_top10_prev_new_drop = $this->model_campaign->getBingDataForCampaign($cid, date("Y-m-d", $i- 60 * 60 * 24), 10);
				$google_data_top20_new_drop = $this->model_campaign->getBingDataForCampaign($cid, date("Y-m-d", $i), 20);
				$google_data_top20_prev_new_drop = $this->model_campaign->getBingDataForCampaign($cid, date("Y-m-d", $i- 60 * 60 * 24), 20);
				
				//Top 10
				if(is_array($google_data_top10_prev_new_drop) && count($google_data_top10_prev_new_drop) > 0){
					for($j=0; $j<count($google_data_top10_prev_new_drop); $j++){
						if($google_data_top10_new_drop[$j]['url'] == $google_data_top10_prev_new_drop[$j]['url']){
							$sameURLExistsTop10NewDrop++;
						}
					}
					$newURLExistsTop10NewDrop = count($google_data_top10_new_drop)-$sameURLExistsTop10NewDrop;
				}
				$newdroprangeTop10Array[date("Y-m-d", $i)]['new'] = $newURLExistsTop10NewDrop;
				
				if(is_array($google_data_top10_new_drop) && count($google_data_top10_new_drop) > 0){
					for($j=0; $j<count($google_data_top10_new_drop); $j++){
						if($google_data_top10_prev_new_drop[$j]['url'] == $google_data_top10_new_drop[$j]['url']){
							$oldSameURlExistsTop10NewDrop++;
						}
					}
					$dropURLExistsTop10NewDrop = count($google_data_top10_prev_new_drop)-$oldSameURlExistsTop10NewDrop;					
				}
				$newdroprangeTop10Array[date("Y-m-d", $i)]['drop'] = $dropURLExistsTop10NewDrop;
				
				
				// Top 20
				if(is_array($google_data_top20_prev_new_drop) && count($google_data_top20_prev_new_drop) > 0){
					for($j=0; $j<count($google_data_top20_prev_new_drop); $j++){
						if($google_data_top20_new_drop[$j]['url'] == $google_data_top20_prev_new_drop[$j]['url']){
							$sameURLExistsTop10NewDrop++;
						}
					}
					$newURLExistsTop20NewDrop = count($google_data_top20_new_drop)-$sameURLExistsTop20NewDrop;
				}
				$newdroprangeTop20Array[date("Y-m-d", $i)]['new'] = $newURLExistsTop20NewDrop;
				
				if(is_array($google_data_top20_new_drop) && count($google_data_top20_new_drop) > 0){
					for($j=0; $j<count($google_data_top20_new_drop); $j++){
						if($google_data_top20_prev_new_drop[$j]['url'] == $google_data_top20_new_drop[$j]['url']){
							$oldSameURlExistsTop20NewDrop++;
						}
					}
					$dropURLExistsTop20NewDrop = count($google_data_top20_prev_new_drop)-$oldSameURlExistsTop20NewDrop;					
				}
				$newdroprangeTop20Array[date("Y-m-d", $i)]['drop'] = $dropURLExistsTop20NewDrop;
				
			}
		}
		
		
		// Top 3
		$parasiteCountTop3 = 0;
		$moneysiteCountTop3 = 0;
		$parasiteCountTop3Prev = 0;
		$moneysiteCountTop3Prev = 0;
		
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
		
		if(is_array($google_data_top3_prev) && count($google_data_top3_prev) > 0){
			for($i=0; $i<count($google_data_top3_prev); $i++){
				$url = $google_data_top3_prev[$i]['url'];
				$url = parse_url($url);				
				foreach($parasitelist AS $val){
					if(strpos($url['host'], $val) >= 0){
						$parasiteCountTop3Prev++;
						break;
					}
				}
			}
			$moneysiteCountTop3Prev = count($google_data_top3_prev)-$parasiteCountTop3Prev;
		}
		
		// Top 10
		$parasiteCountTop10 = 0;
		$moneysiteCountTop10 = 0;
		$parasiteCountTop10Prev = 0;
		$moneysiteCountTop10Prev = 0;
		$sameURLExistsTop10 = 0;
		$newURLExistsTop10 = 0;
		$oldSameURlExistsTop10 = 0;
		$dropURLExistsTop10 = 0;
		
		if(is_array($google_data_top10) && count($google_data_top10) > 0){
			for($i=0; $i<count($google_data_top10); $i++){
				$url = $google_data_top10[$i]['url'];
				$url = parse_url($url);				
				foreach($parasitelist AS $val){
					if(isset($url['host'])  && !empty($url['host'])){
					if(strpos($url['host'], $val) >= 0){
						$parasiteCountTop10++;
						break;
					}
					}
				}
				if(is_array($google_data_top10_prev) && count($google_data_top10_prev) > 0){
					for($j=0; $j<count($google_data_top10_prev); $j++){
						if($google_data_top10[$i]['url'] == $google_data_top10_prev[$j]['url']){
							$sameURLExistsTop10++;
						}
					}
				}
			}
			$moneysiteCountTop10 = count($google_data_top10)-$parasiteCountTop10;
			$newURLExistsTop10 = count($google_data_top10)-$sameURLExistsTop10;
		}
		
		
		if(is_array($google_data_top10_prev) && count($google_data_top10_prev) > 0){
			for($i=0; $i<count($google_data_top10_prev); $i++){
				$url = $google_data_top10_prev[$i]['url'];
				$url = parse_url($url);				
				foreach($parasitelist AS $val){
					if(strpos($url['host'], $val) >= 0){
						$parasiteCountTop10Prev++;
						break;
					}
				}
				if(is_array($google_data_top10) && count($google_data_top10) > 0){
					for($j=0; $j<count($google_data_top10); $j++){
						if($google_data_top10_prev[$i]['url'] == $google_data_top10[$j]['url']){
							$oldSameURlExistsTop10++;
						}
					}
				}
			}
			$moneysiteCountTop10Prev = count($google_data_top10_prev)-$parasiteCountTop10Prev;
			$dropURLExistsTop10 = count($google_data_top10_prev)-$oldSameURlExistsTop10;
		}
		
		// Top 20
		$parasiteCountTop20 = 0;
		$moneysiteCountTop20 = 0;
		$parasiteCountTop20Prev = 0;
		$moneysiteCountTop20Prev = 0;
		$sameURLExistsTop20 = 0;
		$newURLExistsTop20 = 0;
		$oldSameURlExistsTop20 = 0;
		$dropURLExistsTop20 = 0;
		
		if(is_array($google_data_top20) && count($google_data_top20) > 0){
			for($i=0; $i<count($google_data_top20); $i++){
				$url = $google_data_top20[$i]['url'];				
				$url = parse_url($url);				
				foreach($parasitelist AS $val){
					if(isset($url['host']) && !empty($url['host'])){
						if(strpos($url['host'], $val) >= 0){
							$parasiteCountTop20++;
							break;
						}
					}
				}
				if(is_array($google_data_top20_prev) && count($google_data_top20_prev) > 0){
					for($j=0; $j<count($google_data_top20_prev); $j++){
						if($google_data_top20[$i]['url'] == $google_data_top20_prev[$j]['url']){
							$sameURLExistsTop20++;
						}
					}
				}
			}
			$moneysiteCountTop20 = count($google_data_top20)-$parasiteCountTop20;
			$newURLExistsTop20 = count($google_data_top20)-$sameURLExistsTop20;
		}
		
		if(is_array($google_data_top20_prev) && count($google_data_top20_prev) > 0){
			for($i=0; $i<count($google_data_top20_prev); $i++){
				$url = $google_data_top20_prev[$i]['url'];
				$url = parse_url($url);				
				foreach($parasitelist AS $val){
					if(isset($url['host']) && !empty($url['host'])){
						if(strpos($url['host'], $val) >= 0){
							$parasiteCountTop20Prev++;
							break;
						}
					}
				}
				if(is_array($google_data_top20) && count($google_data_top20) > 0){
					for($j=0; $j<count($google_data_top20); $j++){
						if($google_data_top20_prev[$i]['url'] == $google_data_top20[$j]['url']){
							$oldSameURlExistsTop20++;
						}
					}
				}
			}
			$moneysiteCountTop20Prev = count($google_data_top20_prev)-$parasiteCountTop20Prev;
			$dropURLExistsTop20 = count($google_data_top20_prev)-$oldSameURlExistsTop20;
		}
		
		// Graph
		$this->gcharts->load('LineChart');

		$this->gcharts->DataTable('Stocks')
			      ->addColumn('number', 'Count', 'count')
			      ->addColumn('number', 'Projected', 'projected')
			      ->addColumn('number', 'Official', 'official');
	
		for($a = 1; $a < 25; $a++)
		{
		    $data = array(
			$a, //Count
			rand(800,1000), //Line 1's data
			rand(800,1000) //Line 2's data
		    );
	
		    $this->gcharts->DataTable('Stocks')->addRow($data);
		}
	
		$config = array(
		    'title' => 'Stocks'
		);
	
		$this->gcharts->LineChart('Stocks')->setConfig($config);
		//$graphStartTime = strtotime('-2  weeks');
		//for($i=$graphStartTime; $i<=time(); $i=$i+2*24*3600){
		//	$xdata[] = date("m/d/y", $i);
		//}
		//
		//$ydata = array(11,3,8,12,5);
		////$xdata = array('01/31/14', '05/02/14', '05/04/14', '05/06/14', '05/08/14');
		//$ydata2 = array(5,7,2,15,9);
		////$xdata2 = array('jan 14', 'feb 14', 'mar 14', 'apr 14', 'may 14');
		//$graph = $this->jpgraph->linechart();
		//$plot1 = $this->jpgraph->addlineplot($ydata);
		//$plot2 = $this->jpgraph->addlineplot($ydata2);
		//$graph->xaxis->SetTickLabels($xdata);
		////$graph->SetMargin(3,1,4,2);
		//$graph->Add($plot1);
		//$graph->Add($plot2);
		//$graph_temp_directory = FILE_UPLOAD_ABSOLUTE_PATH . 'graphs';  // in the webroot (add directory to .htaccess exclude)
		//$graph_file_name = 'ranking_chart_'.$users_id.'.png';    
		//
		//$graph_file_location = $graph_temp_directory . '/' . $graph_file_name;
		//
		//$graph->Stroke($graph_file_location);  // create the graph and write to file
		//
		//$this->data['graph'] = $graph_file_name;
		
		//pr($google_data_top3_range, 0);
		
		$this->data['parasite_count_top3'] = $parasiteCountTop3;
		$this->data['moneysite_count_top3'] = $moneysiteCountTop3;
		$this->data['parasite_count_top10'] = $parasiteCountTop10;
		$this->data['moneysite_count_top10'] = $moneysiteCountTop10;
		$this->data['parasite_count_top20'] = $parasiteCountTop20;
		$this->data['moneysite_count_top20'] = $moneysiteCountTop20;
		
		$this->data['parasite_count_top3_prev'] = $parasiteCountTop3Prev;
		$this->data['moneysite_count_top3_prev'] = $moneysiteCountTop3Prev;
		$this->data['parasite_count_top10_prev'] = $parasiteCountTop10Prev;
		$this->data['moneysite_count_top10_prev'] = $moneysiteCountTop10Prev;
		$this->data['parasite_count_top20_prev'] = $parasiteCountTop20Prev;
		$this->data['moneysite_count_top20_prev'] = $moneysiteCountTop20Prev;
		
		$this->data['parasite_count_top3_diff'] = $parasiteCountTop3-$parasiteCountTop3Prev;
		$this->data['moneysite_count_top3_diff'] = $moneysiteCountTop3-$moneysiteCountTop3Prev;
		$this->data['parasite_count_top10_diff'] = $parasiteCountTop10-$parasiteCountTop10Prev;
		$this->data['moneysite_count_top10_diff'] = $moneysiteCountTop10-$moneysiteCountTop10Prev;
		$this->data['parasite_count_top20_diff'] = $parasiteCountTop20-$parasiteCountTop20Prev;
		$this->data['moneysite_count_top20_diff'] = $moneysiteCountTop20-$moneysiteCountTop20Prev;
		
		$this->data['new_url_top10'] = $newURLExistsTop10;
		$this->data['drop_url_top10'] = $dropURLExistsTop10;
		$this->data['new_url_top20'] = $newURLExistsTop20;
		$this->data['drop_url_top20'] = $dropURLExistsTop20;
		
		$this->data['top10_new_drop_range'] = $newdroprangeTop10Array;
		$this->data['top20_new_drop_range'] = $newdroprangeTop20Array;
		
		$parasiteRangeTop3 = array();
		$moneysiteRangeTop3 = array();		
		if(is_array($google_data_top3_range) && count($google_data_top3_range) > 0){
			foreach($google_data_top3_range AS $k=>$v){
				if(is_array($v) && count($v) > 0){
					$parasiteRangeTop3[] = $v['parasite'];
					$moneysiteRangeTop3[] = $v['moneysite'];
				}
			}
		}
		$this->data['top3_range_para_site'] = $parasiteRangeTop3;
		$this->data['top3_range_money_site'] = $moneysiteRangeTop3;
		
		$parasiteRangeTop10 = array();
		$moneysiteRangeTop10 = array();
		//pr($google_data_top10_range, 0);
		if(is_array($google_data_top10_range) && count($google_data_top10_range) > 0){
			foreach($google_data_top10_range AS $k=>$v){
				if(is_array($v) && count($v) > 0){					
					$parasiteRangeTop10[] = $v['parasite'];
					$moneysiteRangeTop10[] = $v['moneysite'];
				}
			}
		}
		$this->data['top10_range_para_site'] = $parasiteRangeTop10;
		$this->data['top10_range_money_site'] = $moneysiteRangeTop10;
		
		$parasiteRangeTop20 = array();
		$moneysiteRangeTop20 = array();
		if(is_array($google_data_top20_range) && count($google_data_top20_range) > 0){
			foreach($google_data_top20_range AS $k=>$v){
				if(is_array($v) && count($v) > 0){
					$parasiteRangeTop20[] = $v['parasite'];
					$moneysiteRangeTop20[] = $v['moneysite'];
				}
			}
		}
		$this->data['top20_range_para_site'] = $parasiteRangeTop20;
		$this->data['top20_range_money_site'] = $moneysiteRangeTop20;
		
		$serp_meter_stat = ($newURLExistsTop10/10)*100;
		$this->data['serp_meter_stat'] = $serp_meter_stat;
		
		
		//////// PlotBand Chart Start //////
		
		//$chart_data='{"data":[{"data":';
		$chart_data='{"data":';
		$chart_data.=json_encode($this->model_seoranking->urlSeoRanking($sid,$cid,$users_id));
		$dd=$this->model_seoranking->getCampaignKW($cid);
		//$chart_data.=',"keyword":"'.$dd[0]['campaign_main_keyword'].'"';
		
		$chart_data.=',"flags":';
		$chart_data.= json_encode($this->model_seoranking->plotBandsSeoRanking($users_id,$cid));
		
		$chart_data.='}';
		//echo $ret;
		$this->data['chart_data']=$chart_data;
		/////// PlotBand Chart End //////////
		/////// Column Chart Start /////////
		
		$col_data='{"data":';
		$col_data.=json_encode($this->model_seoranking->KWRankingRange($sid,$cid,$users_id));
		$col_data.='}';
		
		$this->data['col_data']=$col_data;
		
		/////// Column Chart End ///////////
		$this->data['active_campaignList'] =  $this->model_basic->getActiveCampaignList($users_id);	
		//$this->templatelayout->get_header();
		$this->templatelayout->make_seo();
		//$this->templatelayout->get_left();
		//$this->templatelayout->get_topmenu();
		//$this->templatelayout->get_footer();
		$this->data['title']='Ranking';
		$this->template->show("rank", "rank",$this->data,true,true);
//		$this->elements['middle']='ranking/list';			
	//	$this->elements_data['middle'] = $this->data;
			    
		//$this->layout->setLayout('main_layoutnew');
		//$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	public function dataRetrieve(){
		///Acetrik Start
		$cid=1;
		$sid="google";
		if(isset($_GET['cid']) && !empty($_GET['cid']))
			$cid=$_GET['cid'];
		if(isset($_GET['sid']) && !empty($_GET['sid']))
			$sid=$_GET['sid'];
			
		
		//Edited by BEAS - Fetching logged in user data
		
		//$users_id	= $this->session->userdata('LOGIN_USER');
		$session = $this->session->userdata('user_data');
		$users_id = $session['user_id'];
		
		//Edited by BEAS
		
		
		
		/*$this->data['SEORank'][]=array("data"=>$this->model_seoranking->urlSeoRanking($sid,$cid));
		$dd=$this->model_seoranking->getCampaignKW($cid);
		$this->data['SEORank'][]=array("keyword"=>$dd[0]['campaign_main_keyword']);*/
		$ret='{"data":[';
		$ret.=json_encode(array("data"=>$this->model_seoranking->urlSeoRanking($sid,$cid)));
		$dd=$this->model_seoranking->getCampaignKW($cid);
		$ret.=',"keyword":"'.$dd[0]['campaign_main_keyword'].'"';
		$ret.=']}';
		return $ret;
		///Acetrik End
		
	}

	/*public function delete($id)
   {
    $data['page_title'] = 'Active Submissions';
    $this->scrapper_model->delete_user($id);
    redirect('activesubmissions');
   }
	
  public function deletepopup($id)
   {
    $data['page_title'] = 'Active Submissions';
    $this->scrapper_model->delete_popupdata($id);
    redirect('activesubmissions');
   }*/

   public function keyworddelete(){
		//print_r($_REQUEST);//print_r($this->session->all_userdata());
		$data = false;
		$id  = $this->uri->segment(3,0);
		
		$data = $this->model_ranking->keyworddelete($id);
		
		if($data == true) {
			$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px"><a title="Close notification" class="hide" href="#">close</a><p class="msg success">Record Deleted successfully.</p></div>');
			 
			redirect(FRONT_URL . 'ranking');
		} else {
			$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px"><a title="Close notification" class="hide" href="#">close</a><p class="msg success">Record is not Deleted.</p></div>');
			 
			redirect(FRONT_URL . 'ranking');
		}
		
		 
	 }
  

public function pop_up()
   {
   
    $data['page_title'] = 'Ranking';
    $id=$_POST['title'];
  $dta=$this->model_ranking->popup_data($id);
   // echo "<table><tr><td>".$dta[0]->ID."</td><td>".$dta[0]->campaign_id."</td></tr></table>";
    
   echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover">
                                  ';
                                 foreach($dta as $data){
                                 //$newstar= limit_words($data->post_content,7);
                               echo  ' <tr>
                                    <td></td>
                                    <td> </td>
                                    <td>'.$data->keyword.'</td> 
                                    <td> </td> 
                                    <td id=" "></td> 
                                   <td> </td> 
                                      <td id=" "></td> 
                                     <td> </td> 
                                      <td id=" "></td> 
                                    <td>'.$data->keyword.'</td> 

                                  </tr>';
                              }
                              echo  '</table>';



  //  echo $this->scrapper_model->popup_data($id);
    //redirect('activesubmissions');
    
   }

   public function editkeyword()
	{	//print_r($_POST);print_r($this->session->all_userdata());
	

 
		$selectcamp = $this->input->post('selectcamp');
		$selectsite = $this->input->post('selectsite');
		$selectblogtypeyahoo = $this->input->post('selectblogtypeyahoo');
		$selectblogtypegoogle = $this->input->post('selectblogtypegoogle');
		$selectblogtypebing = $this->input->post('selectblogtypebing');
		$defaultnetwork = $this->input->post('default-network');
		$addKeywordstextarea = $this->input->post('addKeywordstextarea');
		 
		/*if($networkstatus == 0)
		{
			$retval = $this->model_ranking->delete_network($networkid);
			 $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="hide" href="#">close</a><p class="msg success">Network Deleted Successfully</p></div>');
		}
		elseif($domainstatus == 0)
		{
			$retval = $this->model_ranking->remove_domain($domainid,$networkid);
			$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="hide" href="#">close</a><p class="msg success">Domain Removed Successfully</p></div>');
		}
		else
		{ */
		//if($networkname != "")
		//{
		  $postdata = array('camp_name' => $selectcamp,'site_name' => $selectsite,'yahoodrop' => $selectblogtypeyahoo,'googledrop' => $selectblogtypegoogle,'bingdrop' => $selectblogtypebing,'defaultnetwork' => $defaultnetwork,'addKeywordstextarea' => $addKeywordstextarea);
		  $retval = $this->model_ranking->editkeywords($selectcamp, $postdata);
		  $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px"><a title="Close notification" class="hide" href="#">close</a><p class="msg success">Congrats! You have successfully added Keywords</p></div>');
		//	}
		//}
		
		redirect('ranking');
	}


	 public function editmankeyword()
	{	//print_r($_POST);print_r($this->session->all_userdata()); 
		$selectmanakeywords = $this->input->post('selectmanakeywords');
		$selectmanagekeysite = $this->input->post('selectmanagekeysite');
		$selectgoogle = $this->input->post('selectgoogle');
		$bingselect = $this->input->post('bingselect');
		$yahooselect = $this->input->post('yahooselect');
		//$keywordtype = $this->input->post('keywordtype');
		//$keywordtypeinfo = $this->input->post('keywordtypeinfo'); 
		 
		  $postdata = array('camp_name' => $selectmanakeywords,'site_name' => $selectmanagekeysite,'googlekeydrop' => $selectgoogle,'bingkeydrop' => $bingselect,'yahookeydrop' => $yahooselect);
		  $retval = $this->model_ranking->editmanakeywords($selectmanakeywords, $postdata);
		  $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px"><a title="Close notification" class="hide" href="#">close</a><p class="msg success">Congrats! You have successfully added to Database</p></div>');
		 
		
		redirect('ranking');
	}

	 public function manageseo()
	{	//print_r($_POST);print_r($this->session->all_userdata()); 
		$campaignid = $this->input->post('selectseocamp');
		$siteid = $this->input->post('selectseosite');
		$pagetest = $this->input->post('pagetest');
		$schart = $this->input->post('schart'); 
		$selectal = $this->input->post('selectal');		
		$selectkeyne = $this->input->post('selectkeyne');
		$title = $this->input->post('title');		
		$description = $this->input->post('description'); 
		 
		  $postdata = array('campaignid' => $campaignid,'siteid' => $siteid,'pagetest' => $pagetest,'schart' => $schart,'selectal' => $selectal,'selectkeyne' => $selectkeyne,'title' => $title,'description' => $description);
		  $retval = $this->model_ranking->editmanageseo($campaignid, $postdata);
		  $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px"><a title="Close notification" class="hide" href="#">close</a><p class="msg success">Congrats! You have successfully added to SEO details to Database</p></div>');
		 		
		 redirect('ranking');
	}

	public function countkey()
	{	//print_r($_POST);print_r($this->session->all_userdata()); 
		$campaignid = $this->input->post('selectseocamp');
		$siteid = $this->input->post('selectseosite');
		$pagetest = $this->input->post('pagetest');
		$schart = $this->input->post('schart'); 
		$selectal = $this->input->post('selectal');		
		$selectkeyne = $this->input->post('selectkeyne');
		$title = $this->input->post('title');		
		$description = $this->input->post('description'); 
		 
		  $postdata = array('campaignid' => $campaignid,'siteid' => $siteid,'pagetest' => $pagetest,'schart' => $schart,'selectal' => $selectal,'selectkeyne' => $selectkeyne,'title' => $title,'description' => $description);
		  $retval = $this->model_ranking->editmanageseo($campaignid, $postdata);
		  $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px"><a title="Close notification" class="hide" href="#">close</a><p class="msg success">Congrats! You have successfully added to SEO details to Database</p></div>');
		 		
		 redirect('ranking');
	}

	public function countseokeyword()
	{	//print_r($_POST);print_r($this->session->all_userdata()); 
		$campaignid = $this->input->post('selectseocamp');
		$siteid = $this->input->post('selectseosite');
		$pagetest = $this->input->post('pagetest');
		$schart = $this->input->post('schart'); 
		$selectal = $this->input->post('selectal');		
		$selectkeyne = $this->input->post('selectkeyne');
		$title = $this->input->post('title');		
		$description = $this->input->post('description'); 
		 
		  $postdata = array('campaignid' => $campaignid,'siteid' => $siteid,'pagetest' => $pagetest,'schart' => $schart,'selectal' => $selectal,'selectkeyne' => $selectkeyne,'title' => $title,'description' => $description);
		  $retval = $this->model_ranking->editmanageseo($campaignid, $postdata);
		  $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px"><a title="Close notification" class="hide" href="#">close</a><p class="msg success">Congrats! You have successfully added to SEO details to Database</p></div>');
		 		
		 redirect('ranking');
	}
	
	function give_more_data() {
    if (isset($_POST['type'])) {
      $this->load->model('model_ranking');
      //$data['ajax_req'] = TRUE;
      $data['node_list'] = $this->model_ranking->get_node_by_type($_POST['type']);
      $this->load->view('list',$data);
    }
  }
  
  
 public function getCDetailsKeywords($id){
 	 $id = $_POST['id'];

 	$data1 = $this->model_ranking->getDetailsKeywords($id);
      //$this->load->view('list',$data);

 	foreach($data1 as $data){
    $curr_google_rank1 = $data['campaigns']['google_rank'];;
 $prev_gogole_rank1 = $data['campaigns']['prev_google_rank'];
 $google_diff_rank1 = $curr_google_rank1-$prev_gogole_rank1;
 $curr_bing_rank1 = $data['campaigns']['bing_rank'];
 $prev_bing_rank1 = $data['campaigns']['prev_bing_rank'];
 $bing_diff_rank1 = $curr_bing_rank1-$prev_bing_rank1;
 $curr_yahoo_rank1 = $data['campaigns']['yahoo_rank'];
 $prev_yahoo_rank1 = $data['campaigns']['prev_yahoo_rank'];
 $yahoo_diff_rank1 = $curr_yahoo_rank1-$prev_yahoo_rank1;
 if(is_array($data['campaigns']['seo_ranking'])){
         $seoCount1 = count($data['campaigns']['seo_ranking']);
     }else{
         $seoCount1 = 0;
     }
  echo '<tr class="togg'.$id.'" id="toggle'.$id.'" style=" background-color: rgb(230, 245, 245);">';
       echo ' <td>'; 
       if($data['campaign_site_type'] == 1){ 
	echo '<img src="echo FRONT_IMAGE_PATH;?>table-icon2.jpg"  alt=""/>';
			 } elseif($data['campaign_site_type'] == 2){
		echo '<img src=" echo FRONT_IMAGE_PATH; table-icon3.jpg"  alt=""/>';
			} 
 
 if(!empty($data['campaign_murl_domain'])){
 echo "www".$data['campaign_murl_domain'] ;
 }
 echo '</td>';
 echo '<td>'.$data['campaigns']['total_kw'].'</td>';
 echo '<td> '.$data['keyword'].'</td>';
 echo '<td>'.$data['campaigns']['google_rank'] ;
  echo ' <a href="#" class="';
  if($google_diff_rank1 >= 0){
  	echo 'green';
  }else{
  	echo 'red';} 

  echo '">'.$google_diff_rank1.'</a> </td>';
         echo ' <td id="trend_google_'.$i.'"></td>';
         echo '<td>'.$data['campaigns']['bing_rank'].'<a href="#" class="';
 if($bing_diff_rank1 >= 0){
 	 echo 'green';
 	}else{
 		echo 'red';
 	}
 	echo '">('.$bing_diff_rank1.')</a></td>';
 echo '<td id="trend_bing_'.$i.'"></td>';
 echo '<td>'.$data['campaigns']['yahoo_rank'].'<a href="#" class="';
 if($yahoo_diff_rank1 >= 0){
 	 echo 'green';
 	}else{
 		 echo 'red';
 	}

 		echo '">'.$yahoo_diff_rank1.'</a></td>';
          echo '<td id="trend_yahoo_'.$i.'"></td>';
 echo '<td>'.$seoCount1.'<a data-toggle="modal" data-target="#startaseotest">+add</a></td>';
echo ' </tr> ';
  $i++;
   } 

   
 }
  //Edited by BEAS - Adding new permission in amember
  
  public function add_user_permissions()
	{
		$permission_name = $this->input->post('name');
		
		$permission_cost = $this->input->post('cost');

		$package_id = $this->scrapper_model->add_custom_permissions($permission_name, $permission_cost);
		
		echo $package_id;
	}
	
	//Edited by BEAS

	
}
/* End of file member.php */
/* Location: ./front-app/controllers/member.php */
