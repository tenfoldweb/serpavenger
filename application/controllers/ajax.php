<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller{
	
	
	public function __construct(){
		parent::__construct();		
		$this->load->model('model_basic');
		$this->load->model('model_campaign');
		$this->load->model('userlogin_model');

		 if(!$this->session->userdata('user_data'))
		 {
		   redirect(Am_Lite::getInstance()->getLoginURL());
		 }
		 
	}
	public function InsertKeyword(){
		//echo $campaign_id= $_POST['campaign_id'];
		//echo $user_id     = $this->input->post('user_id');
		$session = $this->session->userdata('user_data');
		 $user_id = $session['user_id'];
		//echo $user_id     = $this->input->post('user_id');
		 $keyword     = $this->input->post('keyword');
		 $campaign_id = $this->input->post('campaign_id');
		 $keyword_id = $this->input->post('keyword_id');
		
		
		$this->form_validation->set_rules('keyword', 'Keyword', 'trim');
		$this->form_validation->set_rules('campaign_id', 'Campaign', 'required');
		
		
		if ($this->form_validation->run() == FALSE)
		{	
		} else {
				
				$condition = "keyword = '".$keyword."' and users_id = '".$user_id."'";
				
				
				$value_exist   = $this->model_basic->isRecordExist(TABLE_USERS_CAMPAIGNS_KEYWORD,$condition,'','');
				
				/*if($value_exist != '0') {
					echo '<font color="red"><i>"'.$keyword.'"</i> Keyword Already Exist</font>';
				} else {*/
					$insertArr  = $keyword;  /*array(
							'users_id'	=> $user_id,
							'keyword'	=> $keyword,
							'campaign_id'	=> $campaign_id,
							'keyword_type'	=> 'M',
							'status'     	=> 'Active',
							'date_added'	=>  date('Y-m-d H:i:s')
						);*/
				$condition1= "users_id = '".$user_id."' and keyword_id = '".$keyword_id."'";
					$return_val = $this->model_basic->insertIntoTable(TABLE_USERS_CAMPAIGNS_KEYWORD,$insertArr,$condition1);
					
					if(strlen($return_val) > 0){
						
						echo '<font color="green">Keyword Updated Successfully</font>';
						
					}
						
				//}
		}
	}


	public function InsertsecondaryKeyword(){
		//echo $campaign_id= $_POST['campaign_id'];
		//echo $user_id     = $this->input->post('user_id');
		$session = $this->session->userdata('user_data');
		 $user_id = $session['user_id'];
		//echo $user_id     = $this->input->post('user_id');
		 $keyword     = $this->input->post('keyword');
		 $campaign_id = $this->input->post('campaign_id');
		
		
		$this->form_validation->set_rules('keyword', 'Keyword', 'trim');
		$this->form_validation->set_rules('campaign_id', 'Campaign', 'required');
		
		
		if ($this->form_validation->run() == FALSE)
		{	
		} else {
				
	//			$condition = "keyword = '".$keyword."' and campaign_id = '".$campaign_id."' and users_id = '". $user_id ."'";
				
//$value_exist   = $this->model_basic->isRecordExist(TABLE_USERS_CAMPAIGNS_KEYWORD,$condition,'','');
		$conditions = array('campaign_id'=>$campaign_id,'users_id'=>$user_id,'keyword_type'=>'S');
					$this->model_basic->deleteRecords(TABLE_USERS_CAMPAIGNS_KEYWORD,$conditions);
					
				//if($value_exist != '0') {
					//echo '<font color="red"><i>"'.$keyword.'"</i> Keyword Already Exist</font>';
				//} else {
					$insertArr  =  array(
							'users_id'	=> $user_id,
							'keyword'	=> $keyword,
							'campaign_id'	=> $campaign_id,
							'keyword_type'	=> 'S',
							'status'     	=> 'Active',
							'date_added'	=>  date('Y-m-d H:i:s')
						);
				
					$return_val = $this->model_basic->insertIntoTable1(TABLE_USERS_CAMPAIGNS_KEYWORD,$insertArr);
					
					if(strlen($return_val) > 0){
						
						echo '<font color="green">Keyword Added Successfully</font>';
						
					}
						
//				}
		}
	}
	
  public function InsertthirdKeyword(){
//print_R($_POST);
  	$session = $this->session->userdata('user_data');
		 $user_id = $session['user_id'];
		//echo $user_id     = $this->input->post('user_id');
		 $keyword     = $this->input->post('keyword');
		 $campaign_id = $this->input->post('campaign_id');
		
		
		$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required');
		$this->form_validation->set_rules('campaign_id', 'Campaign', 'required');
		
		
		if ($this->form_validation->run() == FALSE)
		{	
		} else {
				
				$keywords  = explode("\n", $keyword);
					$conditions = array('campaign_id'=>$campaign_id,'users_id'=>$user_id,'keyword_type'=>'A');
					$this->model_basic->deleteRecords(TABLE_USERS_CAMPAIGNS_KEYWORD,$conditions);
                foreach($keywords as $k)
                {
                    //echo $k."</br>";
					if($k==''){continue;}
                    $condition = "keyword = '".$k."' and campaign_id = '".$campaign_id."'";
				
    				$value_exist   = $this->model_basic->isRecordExist(TABLE_USERS_CAMPAIGNS_KEYWORD,$condition,'','');
    				
    				if($value_exist != '0') {
    					echo '<font color="red"><i>"'.$k.'"</i> Keyword Already Exist</font>';
    				} else {
    					$insertArr  =  array(
    							'users_id'	=> $user_id,
    							'keyword'	=> $k,
    							'campaign_id'	=> $campaign_id,
    							'keyword_type'	=> 'A',
    							'status'     	=> 'Active',
    							'date_added'	=>  date('Y-m-d H:i:s')
    						);
    				
    					$return_val = $this->model_basic->insertIntoTable1(TABLE_USERS_CAMPAIGNS_KEYWORD,$insertArr);
    					
    					if(strlen($return_val) > 0){
    						
    						echo '<font color="green">Keyword Added Successfully</font><br/>';
    						
    					}
    						
    				}
                }
		}
	}
  



	function kw_cpc_valuation(){
		//$str	= '';
		//$cid = $this->uri->segment(3,2);
		//echo "val".$val = $this->uri->segment(4,0); 
                $keywordval = $_POST['keywordval'];
                //echo $keywordval;
                //exit;
		//echo   $url = "http://us.fullsearch-api.semrush.com/?action=report&type=phrase_fullsearch&phrase=".$val."&key=fa2b854a1bcc79d55ba56c6e5e2f86e6&display_limit=11&export=api&export_columns=Ph,Nq,Cp";
		
		//$campaign_main_kw_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = "'.$cid.'" AND keyword_type = "M"');
		if($keywordval !='') {
		$kw_valuation_percentage = array(32.5,17.6,11.4,8.1,6.1,4.4,3.5,3.1,2.6,2.4);
                $keywordnewvalue = '';
                $count = 0;
                $str	.= '<ul>';
                foreach ($kw_valuation_percentage as $value) {
                    $count++;
                    $keynum = $keywordval*$value/100;
                  $str	.= '<li>'.$count.') <span>$' . number_format( $keynum,2) . '</span></li>';
                    
                }
                $str	.= '</ul>';
                echo $str;
                exit;
                } 
//		$items = array_chunk($kw_valuation_percentage,(count($kw_valuation_percentage)/2));		
//		print_r ($items);
//		$counterx = 1;
//		foreach($items as $km=>$kam){
//			foreach($kam as $vo){
//				if(!empty($val) || $val != 0){
//					$valn = ($vo/100) * $val;
//				}else{
//					$valn =  ($vo/100) * $campaign_main_kw_cpc_detail[0]['keyword_est_traffic'] * $campaign_main_kw_cpc_detail[0]['keyword_cpc'];
//				}
//				
//				$str	.= '<li>'.$counterx.' <span>$' . number_format($valn,2) . '</span></li>';
//				$counterx++;
//			}
//		}
//		echo $str;
//		exit;
	}
	
	public function rankingpieswap(){
		$num		= $this->input->get_post('num');
		$cid		= $this->input->get_post('campaignValue');
		$searchEngine	= $this->input->get_post('searchEngine');
		
		$currDate = date("Y-m-d");
		$prevDate = date("Y-m-d", time() - 60 * 60 * 24);
		$before30Date = date("Y-m-d", time() - 60 * 60 * 24 * 7);
		
		if($searchEngine == 'google'){
			// Google data Current date			
			$google_data_top10 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 10);
			$google_data_top20 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 20);
			
			// Google data Previous date			
			$google_data_top10_prev = $this->model_campaign->getGoogleDataForCampaign($cid, $prevDate, 10);
			$google_data_top20_prev = $this->model_campaign->getGoogleDataForCampaign($cid, $prevDate, 20);
			
			//$google_data_top3_range = $this->model_campaign->getGoogleDataForCampaignForRange($cid, $before30Date, $currDate, 3, $parasitelist);
		}elseif($searchEngine == 'yahoo'){
			// Yahoo data Current date			
			$google_data_top10 = $this->model_campaign->getYahooDataForCampaign($cid, $currDate, 10);
			$google_data_top20 = $this->model_campaign->getYahooDataForCampaign($cid, $currDate, 20);
			
			// Yahoo data Previous date			
			$google_data_top10_prev = $this->model_campaign->getYahooDataForCampaign($cid, $prevDate, 10);
			$google_data_top20_prev = $this->model_campaign->getYahooDataForCampaign($cid, $prevDate, 20);
		}elseif($searchEngine == 'bing'){
			// Bing data Current date			
			$google_data_top10 = $this->model_campaign->getBingDataForCampaign($cid, $currDate, 10);
			$google_data_top20 = $this->model_campaign->getBingDataForCampaign($cid, $currDate, 20);
			
			// Bing data Previous date			
			$google_data_top10_prev = $this->model_campaign->getBingDataForCampaign($cid, $prevDate, 10);
			$google_data_top20_prev = $this->model_campaign->getBingDataForCampaign($cid, $prevDate, 20);
		}
		
		if($num == 10){
			$sameURLExistsTop10 = 0;
			$newURLExistsTop10 = 0;
			$oldSameURlExistsTop10 = 0;
			$dropURLExistsTop10 = 0;
			
			if(is_array($google_data_top10) && count($google_data_top10) > 0){
				for($i=0; $i<count($google_data_top10); $i++){					
					if(is_array($google_data_top10_prev) && count($google_data_top10_prev) > 0){
						for($j=0; $j<count($google_data_top10_prev); $j++){
							if($google_data_top10[$i]['url'] == $google_data_top10_prev[$j]['url']){
								$sameURLExistsTop10++;
							}
						}
					}
				}				
				$newURLExistsTop10 = count($google_data_top10)-$sameURLExistsTop10;
			}
			
			
			if(is_array($google_data_top10_prev) && count($google_data_top10_prev) > 0){
				for($i=0; $i<count($google_data_top10_prev); $i++){					
					if(is_array($google_data_top10) && count($google_data_top10) > 0){
						for($j=0; $j<count($google_data_top10); $j++){
							if($google_data_top10_prev[$i]['url'] == $google_data_top10[$j]['url']){
								$oldSameURlExistsTop10++;
							}
						}
					}
				}				
				$dropURLExistsTop10 = count($google_data_top10_prev)-$oldSameURlExistsTop10;
			}
			echo $newURLExistsTop10 . '|' . $dropURLExistsTop10;
		}elseif($num == 20){
			$sameURLExistsTop20 = 0;
			$newURLExistsTop20 = 0;
			$oldSameURlExistsTop20 = 0;
			$dropURLExistsTop20 = 0;
			
			if(is_array($google_data_top20) && count($google_data_top20) > 0){
				for($i=0; $i<count($google_data_top20); $i++){					
					if(is_array($google_data_top20_prev) && count($google_data_top20_prev) > 0){
						for($j=0; $j<count($google_data_top20_prev); $j++){
							if($google_data_top20[$i]['url'] == $google_data_top20_prev[$j]['url']){
								$sameURLExistsTop20++;
							}
						}
					}
				}				
				$newURLExistsTop20 = count($google_data_top20)-$sameURLExistsTop20;
			}
			
			if(is_array($google_data_top20_prev) && count($google_data_top20_prev) > 0){
				for($i=0; $i<count($google_data_top20_prev); $i++){					
					if(is_array($google_data_top20) && count($google_data_top20) > 0){
						for($j=0; $j<count($google_data_top20); $j++){
							if($google_data_top20_prev[$i]['url'] == $google_data_top20[$j]['url']){
								$oldSameURlExistsTop20++;
							}
						}
					}
				}				
				$dropURLExistsTop20 = count($google_data_top20_prev)-$oldSameURlExistsTop20;
			}
			echo $newURLExistsTop20 . '|' . $dropURLExistsTop20;
		}
		exit;
	}
}