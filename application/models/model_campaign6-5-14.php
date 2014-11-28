<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_campaign extends CI_Model{
	
    public function __construct(){        
        // Call the Model constructor
        parent::__construct();
    }
	
    public function checkExistsCampaignTitle($campaign_title, $users_id){
	$sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS . " WHERE campaign_title = '".$campaign_title."' AND users_id = '".$users_id."'";
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    return TRUE;
	}else{
	    return FALSE;
	}
    }
    
    public function getCampaignListingByUser($users_id){
	$rec	= false;
	$sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	    if(is_array($rec) && count($rec) > 0){
		for($i=0; $i<count($rec); $i++){
		    $sql	= '';
		    $query	= '';
		    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS . " WHERE c_id = '".$rec[$i]['campaign_id']."'";
		    $query	= $this->db->query($sql);
		    if($query->num_rows() > 0){
			$rec2			= $query->result_array();
			$rec[$i]['total_campaign']	= $query->num_rows();
			$rec[$i]['campaigns']	= $rec2;
			if(is_array($rec2) && count($rec2) > 0){
			    for($j=0; $j<count($rec2); $j++){
				$sql3 = "SELECT * FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."'";
				$query3	= $this->db->query($sql3);
				$rec[$i]['campaigns'][$j]['total_kw']	= $query3->num_rows();
				
				// get google rank
				$sqlRank	= "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added = '".date("Y-m-d")."'";
				$queryRank	= $this->db->query($sqlRank);
				if($queryRank->num_rows() > 0){
				    $recRank	= $queryRank->row_array();
				    $rec[$i]['campaigns'][$j]['google_rank']	= $recRank['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['google_rank']	= 0;
				}
				// get google previous day rank
				$sqlRank2	= "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added = '".date("Y-m-d", time() - 60 * 60 * 24)."'";
				$queryRank2	= $this->db->query($sqlRank2);
				if($queryRank2->num_rows() > 0){
				    $recRank2	= $queryRank2->row_array();
				    $rec[$i]['campaigns'][$j]['prev_google_rank']	= $recRank2['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['prev_google_rank']	= 0;
				}
				// get google start rank
				$sqlRank3	= "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' ORDER BY date_added LIMIT 1";
				$queryRank3	= $this->db->query($sqlRank3);
				if($queryRank3->num_rows() > 0){
				    $recRank3	= $queryRank3->row_array();
				    $rec[$i]['campaigns'][$j]['start_google_rank']	= $recRank3['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['start_google_rank']	= 0;
				}
				
				// get google best rank
				$sqlRank4	= "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' ORDER BY rank DESC LIMIT 1";
				$queryRank4	= $this->db->query($sqlRank3);
				if($queryRank4->num_rows() > 0){
				    $recRank4	= $queryRank4->row_array();
				    $rec[$i]['campaigns'][$j]['best_google_rank']	= $recRank4['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['best_google_rank']	= 0;
				}
				
				// get yahoo rank
				$sqlRank	= "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added = '".date("Y-m-d")."'";
				$queryRank	= $this->db->query($sqlRank);
				if($queryRank->num_rows() > 0){
				    $recRank	= $queryRank->row_array();
				    $rec[$i]['campaigns'][$j]['yahoo_rank']	= $recRank['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['yahoo_rank']	= 0;
				}
				// get yahoo previous day rank
				$sqlRank2	= "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added = '".date("Y-m-d", time() - 60 * 60 * 24)."'";
				$queryRank2	= $this->db->query($sqlRank);
				if($queryRank2->num_rows() > 0){
				    $recRank2	= $queryRank2->row_array();
				    $rec[$i]['campaigns'][$j]['prev_yahoo_rank']	= $recRank2['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['prev_yahoo_rank']	= 0;
				}
				// get yahoo start rank
				$sqlRank3	= "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' ORDER BY date_added LIMIT 1";
				$queryRank3	= $this->db->query($sqlRank3);
				if($queryRank3->num_rows() > 0){
				    $recRank3	= $queryRank3->row_array();
				    $rec[$i]['campaigns'][$j]['start_yahoo_rank']	= $recRank3['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['start_yahoo_rank']	= 0;
				}
				// get yahoo best rank
				$sqlRank4	= "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' ORDER BY rank DESC LIMIT 1";
				$queryRank4	= $this->db->query($sqlRank3);
				if($queryRank4->num_rows() > 0){
				    $recRank4	= $queryRank4->row_array();
				    $rec[$i]['campaigns'][$j]['best_yahoo_rank']	= $recRank4['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['best_yahoo_rank']	= 0;
				}
				
				// get bing rank
				$sqlRank	= "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added = '".date("Y-m-d")."'";
				$queryRank	= $this->db->query($sqlRank);
				if($queryRank->num_rows() > 0){
				    $recRank	= $queryRank->row_array();
				    $rec[$i]['campaigns'][$j]['bing_rank']	= $recRank['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['bing_rank']	= 0;
				}
				// get bing previous day rank
				$sqlRank2	= "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added = '".date("Y-m-d", time() - 60 * 60 * 24)."'";
				$queryRank2	= $this->db->query($sqlRank2);
				if($queryRank2->num_rows() > 0){
				    $recRank2	= $queryRank2->row_array();
				    $rec[$i]['campaigns'][$j]['prev_bing_rank']	= $recRank2['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['prev_bing_rank']	= 0;
				}
				// get bing start rank
				$sqlRank3	= "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' ORDER BY date_added LIMIT 1";
				$queryRank3	= $this->db->query($sqlRank3);
				if($queryRank3->num_rows() > 0){
				    $recRank3	= $queryRank3->row_array();
				    $rec[$i]['campaigns'][$j]['start_bing_rank']	= $recRank3['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['start_bing_rank']	= 0;
				}
				
				// get bing best rank
				$sqlRank4	= "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' ORDER BY rank DESC LIMIT 1";
				$queryRank4	= $this->db->query($sqlRank3);
				if($queryRank4->num_rows() > 0){
				    $recRank4	= $queryRank4->row_array();
				    $rec[$i]['campaigns'][$j]['best_bing_rank']	= $recRank4['rank'];
				}else{
				    $rec[$i]['campaigns'][$j]['best_bing_rank']	= 0;
				}
			    }
			}
		    }else{
			$rec[$i]['campaigns']	= '';
		    }
		    // Total KW
		    $sql	= '';
		    $query	= '';
		    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS CK, " . TABLE_USERS_CAMPAIGNS . " AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$rec[$i]['campaign_id']."'";
		    $query	= $this->db->query($sql);
		    $rec[$i]['total_kw']	= $query->num_rows();
		}
	    }
	}
	return $rec;
    }
    
    public function getUsersCampaigns($users_id){
	$rec	= false;
	$sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	}
	return $rec;
    }
    
    public function getCampaignDetail($cid, $users_id){
	$rec			= array();
	$total_keywords		= 0;
	$total_money_sites	= 0;
	$total_para_sites	= 0;
	
	if($cid > 0){
	    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active' AND campaign_id = '".$cid."'";
	}else{
	    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";
	}	
	
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	    if(is_array($rec) && count($rec) > 0){
		for($i=0; $i<count($rec); $i++){
		    $sql	= '';
		    $query	= '';
		    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS CK, " . TABLE_USERS_CAMPAIGNS . " AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$rec[$i]['campaign_id']."'";
		    $query	= $this->db->query($sql);
		    $total_keywords		= $total_keywords+$query->num_rows();
		    
		    $sql	= '';
		    $query	= '';
		    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS . " WHERE c_id = '".$rec[$i]['campaign_id']."' AND campaign_site_type = 1";
		    $query	= $this->db->query($sql);
		    $total_money_sites	= $total_money_sites+$query->num_rows();
		    
		    $sql	= '';
		    $query	= '';
		    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS . " WHERE c_id = '".$rec[$i]['campaign_id']."' AND campaign_site_type = 2";
		    $query	= $this->db->query($sql);
		    $total_para_sites	= $total_para_sites+$query->num_rows();
		}
	    }
	}
	$rec['active_campaign']		= count($rec);
	$rec['total_kw']		= $total_keywords;
	$rec['total_money_sites']	= $total_money_sites;
	$rec['total_para_sites']	= $total_para_sites;
	
	return $rec;
    }
    
    public function insertUsersCampaign($users_id){
	$c_id				= strip_tags(addslashes(trim($this->input->get_post('c_id'))));
	$campaign_site_type		= strip_tags(addslashes(trim($this->input->get_post('campaign_site_type'))));
	$isCrawlByGoogle		= strip_tags(addslashes(trim($this->input->get_post('isCrawlByGoogle'))));
	$isCrawlByBing			= strip_tags(addslashes(trim($this->input->get_post('isCrawlByBing'))));
	$isCrawlByYahoo			= strip_tags(addslashes(trim($this->input->get_post('isCrawlByYahoo'))));
	$google_se_domain		= strip_tags(addslashes(trim($this->input->get_post('google_se_domain'))));
	$bing_se_domain			= strip_tags(addslashes(trim($this->input->get_post('bing_se_domain'))));
	$yahoo_se_domain		= strip_tags(addslashes(trim($this->input->get_post('yahoo_se_domain'))));
	$campaign_main_page_url		= strip_tags(addslashes(trim($this->input->get_post('campaign_main_page_url'))));
	$campaign_exact_url_track	= strip_tags(addslashes(trim($this->input->get_post('campaign_exact_url_track'))));
	$campaign_main_keyword		= strip_tags(addslashes(trim($this->input->get_post('campaign_main_keyword'))));
	$campaign_secondary_keyword	= strip_tags(addslashes(trim($this->input->get_post('campaign_secondary_keyword'))));
	
	if($isCrawlByGoogle == ''){
	    $isCrawlByGoogle	= 'No';
	}
	if($isCrawlByBing == ''){
	    $isCrawlByBing	= 'No';
	}
	if($isCrawlByYahoo == ''){
	    $isCrawlByYahoo	= 'No';
	}
	
	$sql	= "INSERT INTO " . TABLE_USERS_CAMPAIGNS . " SET
		  users_id			= '".$users_id."',
		  c_id				= '".$c_id."',
		  campaign_site_type		= '".$campaign_site_type."',
		  isCrawlByGoogle		= '".$isCrawlByGoogle."',
		  isCrawlByBing			= '".$isCrawlByBing."',
		  isCrawlByYahoo		= '".$isCrawlByYahoo."',
		  google_se_domain		= '".$google_se_domain."',
		  bing_se_domain		= '".$bing_se_domain."',
		  yahoo_se_domain		= '".$yahoo_se_domain."',
		  campaign_main_page_url	= '".$campaign_main_page_url."',
		  campaign_exact_url_track	= '".$campaign_exact_url_track."',
		  campaign_main_keyword		= '".$campaign_main_keyword."',
		  campaign_secondary_keyword	= '".$campaign_secondary_keyword."',
		  date_added			= NOW()";
		  
	$this->db->query($sql);
	
	$capmaign_id	= $this->db->insert_id();
	
	$sql= '';
	$sql	= "INSERT INTO " . TABLE_USERS_CAMPAIGNS_KEYWORD . " SET campaign_id = '".$capmaign_id."', users_id = '".$users_id."', keyword = '".$campaign_main_keyword."', keyword_type = 'M', status = 'Active', date_added = NOW()";
	$this->db->query($sql);
	
	if(!empty($campaign_secondary_keyword)){	    
	    $sql= '';
	    $sql	= "INSERT INTO " . TABLE_USERS_CAMPAIGNS_KEYWORD . " SET campaign_id = '".$capmaign_id."', users_id = '".$users_id."', keyword = '".$campaign_secondary_keyword."', keyword_type = 'S', status = 'Active', date_added = NOW()";
	    $this->db->query($sql);  
	}
	
	return $capmaign_id;
    }
    
    public function updateUsersCampaign($campaign_id, $campaign_main_keyword = '', $users_id, $data){
	$updateStr	= '';
	
	if(is_array($data) && count($data) > 0){
	    foreach($data AS $key=>$value){
		if($key != 'kcpcData'){
		    $updateStr	.= $key . ' = "' . addslashes(trim($value)) . '", ';
		}
	    }
	    
	    if(!empty($updateStr)){
		$sql	= "UPDATE " . TABLE_USERS_CAMPAIGNS . " SET " . $updateStr . " date_modified = NOW() WHERE campaign_id = '".$campaign_id."'";
		$this->db->query($sql);
	    }
	    
	    if(isset($data['kcpcData'])){
		if(is_array($data['kcpcData']) && count($data['kcpcData']) > 0){
		    $i	= 1;
		    foreach($data['kcpcData'] AS $key=>$value){
			$keyword	= $value[0];
			$est_traffic	= $value[1];
			$cpc		= $value[2];
			if(strtolower($keyword) == strtolower($campaign_main_keyword)){
			    $kw_type	= 'M';
			}else{
			    $kw_type	= 'S';
			}
			
			$sql= "INSERT INTO " . TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION . " SET campaign_id = '".$campaign_id."', users_id = '".$users_id."', keyword = '".addslashes(trim($keyword))."', keyword_est_traffic = '".addslashes(trim($est_traffic))."', keyword_cpc = '".addslashes(trim($cpc))."', keyword_type = '".$kw_type."', date_added = NOW()";
			$this->db->query($sql);
			$i++;
		    }
		}
	    }
	}
    }
    
    public function getGoogleDataForCampaign($cid, $currDate, $limit){
	$rec = false;	
	if($cid > 0){
	    $sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	}else{
	    $sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank LIMIT 0, " . $limit;
	}
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec = $query->result_array();
	}
	return $rec;
    }
    
    public function getYahooDataForCampaign($cid, $currDate, $limit){
	$rec = false;
	if($cid > 0){
	    $sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	}else{
	    $sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank LIMIT 0, " . $limit;
	}
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec = $query->result_array();
	}
	return $rec;
    }
    
    public function getBingDataForCampaign($cid, $currDate, $limit){
	$rec = false;
	if($cid > 0){
	    $sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	}else{
	    $sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank LIMIT 0, " . $limit;
	}
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec = $query->result_array();
	}
	return $rec;
    }
}