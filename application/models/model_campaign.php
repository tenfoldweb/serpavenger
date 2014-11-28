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
				$sqlSeo = "SELECT * FROM " . serp_seo_ranking . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."'";
				$querySeo = $this->db->query($sqlSeo);
				if($querySeo->num_rows() > 0){
				    $recSeo = $querySeo->result_array();
				    $rec[$i]['campaigns'][$j]['seo_ranking'] = $recSeo;
				}else{
				    $rec[$i]['campaigns'][$j]['seo_ranking'] = '';
				}
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
				// get google trend
				for($kk=strtotime('-2 weeks'); $kk<=time(); $kk=$kk+24*3600){
				    $rec[$i]['campaigns'][$j]['google_trend'][date("Y-m-d", $kk)] = 0;
				}
				
				$sqlRankTrend	= "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added BETWEEN '".date("Y-m-d", strtotime('-2 weeks'))."' AND '".date("Y-m-d")."'";
				$queryRankTrend = $this->db->query($sqlRankTrend);
				if($queryRankTrend->num_rows() > 0){
				    $recRanktrend = $queryRankTrend->result_array();
				    if(is_array($recRanktrend) && count($recRanktrend) > 0){
					for($k=0; $k<count($recRanktrend); $k++){
					    $rec[$i]['campaigns'][$j]['trend'][$recRanktrend[$k]['date_added']] = $recRanktrend[$k]['rank'];
					}
				    }
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
				
				// get yahoo trend
				for($kk=strtotime('-2 weeks'); $kk<=time(); $kk=$kk+24*3600){
				    $rec[$i]['campaigns'][$j]['yahoo_trend'][date("Y-m-d", $kk)] = 0;
				}
				$sqlRankTrend	= "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added BETWEEN '".date("Y-m-d", strtotime('-2 weeks'))."' AND '".date("Y-m-d")."'";
				$queryRankTrend = $this->db->query($sqlRankTrend);
				if($queryRankTrend->num_rows() > 0){
				    $recRanktrend = $queryRankTrend->result_array();
				    if(is_array($recRanktrend) && count($recRanktrend) > 0){
					for($k=0; $k<count($recRanktrend); $k++){
					    $rec[$i]['campaigns'][$j]['yahoo_trend'][$recRanktrend[$k]['date_added']] = $recRanktrend[$k]['rank'];
					}
				    }
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
				
				// get bing trend
				for($kk=strtotime('-2 weeks'); $kk<=time(); $kk=$kk+24*3600){
				    $rec[$i]['campaigns'][$j]['bing_trend'][date("Y-m-d", $kk)] = 0;
				}
				$sqlRankTrend	= "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$rec2[$j]['campaign_id']."' AND url = '".$rec2[$j]['campaign_main_page_url']."' AND date_added BETWEEN '".date("Y-m-d", strtotime('-2 weeks'))."' AND '".date("Y-m-d")."'";
				$queryRankTrend = $this->db->query($sqlRankTrend);
				if($queryRankTrend->num_rows() > 0){
				    $recRanktrend = $queryRankTrend->result_array();
				    if(is_array($recRanktrend) && count($recRanktrend) > 0){
					for($k=0; $k<count($recRanktrend); $k++){
					    $rec[$i]['campaigns'][$j]['bing_trend'][$recRanktrend[$k]['date_added']] = $recRanktrend[$k]['rank'];
					}
				    }
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
    
//    public function getCampaignKeywordsChart($cid, $users_id, $keywordArray){
//	if($cid > 0){
//	    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active' AND campaign_id = '".$cid."'";
//	}else{
//	    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active' LIMIT 3";
//	}
//	
//	$query	= $this->db->query($sql);
//	if($query->num_rows() > 0){
//	    $rec	= $query->result_array();
//	    if(is_array($rec) && count($rec) > 0){
//		for($i=0; $i<count($rec); $i++){
//		    $sql	= '';
//		    $query	= '';
//		    $sql	= "SELECT CK.keyword, CK.keyword_id, CK.campaign_id, UC.campaign_main_page_url FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS CK, " . TABLE_USERS_CAMPAIGNS . " AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$rec[$i]['campaign_id']."' AND CK.keyword_type='M'";
//		    $query	= $this->db->query($sql);
//		    $result = $query->result_array();		    
//		    if(is_array($result) && count($result) > 0){
//			for($j=0; $j<count($result); $j++){
//			    $return['google'] = array('date_added' => );
//			}
//			for($j=0; $j<count($result); $j++){
//			    $sql = '';
//			    $query = '';
//			   echo $sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE url = '".$result[$j]['campaign_main_page_url']."' AND date_added BETWEEN '".date("Y-m-d", strtotime('-2  weeks'))."' AND '".date("Y-m-d")."'";
//			    $query = $this->db->query($sql);
//			    if($query->num_rows() > 0){
//				$rec2 = $query->result_array();
//				$return['gogole'] = $rec2;
//			    }
//			    
//			    $sql = '';
//			    $query = '';
//			    $sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE url = '".$result[$j]['campaign_main_page_url']."' AND date_added BETWEEN '".date("Y-m-d", strtotime('-2  weeks'))."' AND '".date("Y-m-d")."'";
//			    $query = $this->db->query($sql);
//			    if($query->num_rows() > 0){
//				$rec2 = $query->result_array();
//				$return['yahoo'] = $rec2;
//			    }
//			    
//			    $sql = '';
//			    $query = '';
//			    $sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE url = '".$result[$j]['campaign_main_page_url']."' AND date_added BETWEEN '".date("Y-m-d", strtotime('-2  weeks'))."' AND '".date("Y-m-d")."'";
//			    $query = $this->db->query($sql);
//			    if($query->num_rows() > 0){
//				$rec2 = $query->result_array();
//				$return['bing'] = $rec2;
//			    }
//			}
//		    }
//		}
//	    }
//	}
//	pr($return);
//    }
    
	public function getAllCampaignDomains($users_id){
		$result = false;
		$rec = false;
			$sql="SELECT serp_users_campaign_master.`campaign_title`, serp_users_campaign_detail.`c_id`, serp_users_campaign_detail.campaign_site_type, serp_users_campaign_detail.campaign_main_page_url, serp_users_campaign_detail.`campaign_id`
 
					
					FROM `serp_users_campaign_master` 
					
					JOIN serp_users_campaign_detail
					
					ON serp_users_campaign_detail.c_id=serp_users_campaign_master.`campaign_id`
					
					WHERE serp_users_campaign_master.`users_id`=".$users_id."
					
					ORDER BY serp_users_campaign_detail.`c_id`";
		$query	= $this->db->query($sql);
		if($query->num_rows() > 0){
			$rec = $query->result_array();                   
        }
		else $rec;
		return $rec;
	}
	
	public function getSelectedCampaignKeywords($cid, $users_id){
		$result = false;
		$rec = false;
		if($cid==0){
			$sql="SELECT serp_users_campaign_detail.campaign_id
					FROM serp_users_campaign_master
					JOIN serp_users_campaign_detail ON serp_users_campaign_master.campaign_id = serp_users_campaign_detail.c_id
					WHERE serp_users_campaign_master.users_id='".$users_id."' LIMIT 0,1";
			$query	= $this->db->query($sql);
			if($query->num_rows() > 0){
				$rec2 = $query->result_array();
				$cid = $rec2[0]['campaign_id'];
			}
		}
		if($cid > 0){
			$sql="SELECT `serp_users_campaign_detail`.`isCrawlByGoogle`,`serp_users_campaign_detail`.`isCrawlByYahoo`,`serp_users_campaign_detail`.`isCrawlByBing` , serp_users_campaign_keywords.keyword_id, serp_users_campaign_keywords.keyword, 
			serp_users_campaign_keywords.keystatus,
			serp_users_campaign_keywords.keyword_type, serp_users_campaign_keywords.`status`

					FROM `serp_users_campaign_detail` 
					
					JOIN serp_users_campaign_keywords
					
					ON serp_users_campaign_keywords.campaign_id=serp_users_campaign_detail.`campaign_id`
					
					WHERE `serp_users_campaign_detail`.`campaign_id`=".$cid." AND `serp_users_campaign_detail`.`users_id`=".$users_id."
					
					Order By serp_users_campaign_keywords.keyword_type";
			$query	= $this->db->query($sql);
			if($query->num_rows() > 0){
				$rec = $query->result_array();                   
			}
			else
				$rec=false;
		}
		else $rec=false;
		return $rec;
	}
	
    public function getCampaignKeywords($cid, $users_id){
	$result = false;
	$rec = false;
	if($cid > 0){
	    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active' AND campaign_id = '".$cid."'";
	}else{
	    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active' LIMIT 3";
	}
	
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	    if(is_array($rec) && count($rec) > 0){
		for($i=0; $i<count($rec); $i++){
		    $sql	= '';
		    $query	= '';
		    $sql	= "SELECT CK.keyword, CK.keyword_id, CK.campaign_id FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS CK, " . TABLE_USERS_CAMPAIGNS . " AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$rec[$i]['campaign_id']."' AND CK.keyword_type='M'";
		    $query	= $this->db->query($sql);
		    $result = $query->result_array();
		    if(is_array($result) && count($result) > 0){
			for($j=0; $j<count($result); $j++){
			    // Google rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' AND date_added = '".date("Y-m-d")."'";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['google_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['google_rank'] = 0;
			    }
			    // Google start rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' ORDER BY date_added ASC LIMIT 1";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['google_start_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['google_start_rank'] = 0;
			    }
			    // Google best rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' ORDER BY rank ASC LIMIT 1";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['google_best_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['google_best_rank'] = 0;
			    }
			    //Google current rank status
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_GOOGLE_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' AND date_added = '".date("Y-m-d", time() - 60 * 60 * 24)."'";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['google_prev_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['google_prev_rank'] = 0;
			    }
			    
			    $result[$j]['google_rank_stat'] = $result[$j]['google_rank']-$result[$j]['google_prev_rank'];
			    
			    // Yahoo rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' AND date_added = '".date("Y-m-d")."'";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['yahoo_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['yahoo_rank'] = 0;
			    }
			    
			    // Yahoo start rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' ORDER BY date_added ASC LIMIT 1";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['yahoo_start_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['yahoo_start_rank'] = 0;
			    }
			    // Yahoo best rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' ORDER BY rank ASC LIMIT 1";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['yahoo_best_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['yahoo_best_rank'] = 0;
			    }
			    //Yahoo current rank status
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_YAHOO_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' AND date_added = '".date("Y-m-d", time() - 60 * 60 * 24)."'";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['yahoo_prev_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['yahoo_prev_rank'] = 0;
			    }
			    $result[$j]['yahoo_rank_stat'] = $result[$j]['yahoo_rank']-$result[$j]['yahoo_prev_rank'];
			    
			    // Bing rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' AND date_added = '".date("Y-m-d")."'";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['bing_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['bing_rank'] = 0;
			    }
			    
			    // Bing start rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' ORDER BY date_added ASC LIMIT 1";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['bing_start_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['bing_start_rank'] = 0;
			    }
			    // Bing best rank
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' ORDER BY rank ASC LIMIT 1";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['bing_best_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['bing_best_rank'] = 0;
			    }
			    //Bing current rank status
			    $sql	= '';
			    $query	= '';
			    $sql	= 'SELECT * FROM ' . TABLE_BING_CRAWL_DATA . " WHERE campaign_id = '".$result[$j]['campaign_id']."' AND keyword = '".$result[$j]['keyword']."' AND date_added = '".date("Y-m-d", time() - 60 * 60 * 24)."'";
			    $query	= $this->db->query($sql);
			    if($query->num_rows() > 0){
				$rec2 = $query->row_array();
				$result[$j]['bing_prev_rank'] = $rec2['rank'];
			    }else{
				$result[$j]['bing_prev_rank'] = 0;
			    }
			    
			    $result[$j]['bing_rank_stat'] = $result[$j]['bing_rank']-$result[$j]['bing_prev_rank'];
			}
		    }
		}
	    }
	}
	return $result;
    }
    
	
	
    public function getUsersCampaigns($users_id){
	$rec	= false;
	$sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active' group by users_id";
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	    if(is_array($rec) && count($rec) > 0){
		for($i=0; $i<count($rec); $i++){
		    $sql	= '';
		    $query	= '';
		    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS CK, " . TABLE_USERS_CAMPAIGNS . " AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$rec[$i]['campaign_id']."' GROUP BY keyword";
		    $query	= $this->db->query($sql);
		    if($query->num_rows() > 0){
			$rec[$i]['campaign'] = $query->result_array();
		    }else{
			$rec[$i]['campaign'] = '';
		    }
		}
	    }
	}
	return $rec;
    }
    
    
    function getUsersCampaignsKeywords($users_id){
	$rec	= false;
	 $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	   // pr($query->result_array());
	    foreach($query->result_array() as $index=>$data){
		
		    $sql	= '';
		    $query	= '';
		    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS CK, " . TABLE_USERS_CAMPAIGNS . " AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$data['campaign_id']."'";
		    $query	= $this->db->query($sql);
		    foreach($query->result_array() as $sub_row=>$sub_data){
			  $rec[$data['campaign_title']][$sub_data['campaign_id']] = $sub_data['campaign_main_keyword']; 
		    }
		    
	    }
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
    $campaign_title				= strip_tags(addslashes(trim($this->input->get_post('campaign_title'))));	
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
	$crawl_country='';
	if($isCrawlByGoogle == ''){
	    $isCrawlByGoogle	= 'No';
	} else {
		$crawl_country=$google_se_domain;
	}
	if($isCrawlByBing == ''){
	    $isCrawlByBing	= 'No';
	} else {
		$crawl_country=$bing_se_domain;
	}
	if($isCrawlByYahoo == ''){
	    $isCrawlByYahoo	= 'No';
	} else {
		$crawl_country=$yahoo_se_domain;
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

	$sql	= "INSERT INTO `serp_tmpanalyzecomp` SET
		  users_id			= '".$users_id."',
		  c_id				= '".$c_id."', 		  
		  google_se_domain		= '".$google_se_domain."',
		  bing_se_domain		= '".$bing_se_domain."',
		  yahoo_se_domain		= '".$yahoo_se_domain."',
		  crawl_country			= '".$crawl_country."',
		  campaign_main_page_url	= '".$campaign_main_page_url."',
		  campaign_exact_url_track	= '".$campaign_exact_url_track."',
		  campaign_main_keyword		= '".$campaign_main_keyword."',
		  campaign_secondary_keyword	= '".$campaign_secondary_keyword."',
		  date_added			= NOW()";
		  
	$this->db->query($sql);

	
	  


	if(!empty($campaign_title)){	    
	    $sql= '';
	   $sql	= "INSERT INTO " . serp_users_campaign_master . " SET  users_id = '".$users_id."', campaign_title = '".$campaign_title."', campaign_status = 'Active', date_added = NOW()";
	    $this->db->query($sql);  
	}
	
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
	    if(!empty($limit)){
		$sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	    }else{
		$sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank";
	    }
	    
	}else{
	    if(!empty($limit)){
		$sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank LIMIT 0, " . $limit;
	    }else{
		 $sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank";
		
	    }
	    
	}
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec = $query->result_array();
	}
	return $rec;
    }
    
    public function getGoogleDataForCampaignForRange($cid, $fromDate, $toDate, $limit, $parasitelist){
	$rec = false;
	$return = array();
	$rankArr = array();
	$timestampFromDate = strtotime($fromDate);
	$timestampToDate = strtotime($toDate);
	for($i=$timestampFromDate; $i<=$timestampToDate; $i=$i+24*3600){
	    $return[date("Y-m-d", $i)] = array('parasite' => 0, 'moneysite' => 0, 'url' => '');
	}
	
	if($cid > 0){
	    $sql = " SELECT url, rank, date_added
	    FROM
	      (SELECT url, rank, date_added, 
			   @crank := IF(@cdate_added = date_added, @crank + 1, 1) AS crank,
			   @cdate_added := date_added 
		FROM ". TABLE_GOOGLE_CRAWL_DATA . "
		WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND rank <= ".$limit." AND campaign_id = '".$cid."'
		ORDER BY date_added, rank
	      ) ranked";
	    //$sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	}else{
	    //$sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' ORDER BY rank LIMIT 0, " . $limit;
	    $sql = " SELECT url, rank, date_added
	    FROM
	      (SELECT url, rank, date_added, 
			   @crank := IF(@cdate_added = date_added, @crank + 1, 1) AS crank,
			   @cdate_added := date_added 
		FROM ". TABLE_GOOGLE_CRAWL_DATA . "
		WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND rank <= ".$limit."
		ORDER BY date_added, rank
	      ) ranked";
	}
	
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){	    
	    foreach($query->result() AS $row){
		if(!in_array($row->rank, $rankArr)){
		    $url = $row->url;		
		    $url = parse_url($url);
		    
		    $return[$row->date_added]['url'] = $row->url;
		    
		    if(isset($url['host']) && !empty($url['host'])){
			$parasiteExists	= false;
			foreach($parasitelist AS $val){
			    if(strpos($url['host'], $val)){
				    $c = $return[$row->date_added]['parasite'];
				    $return[$row->date_added]['parasite'] = $c+1;
				    $parasiteExists	= true;			
			    }
			    break;
			}		    
		    }
		    if(!$parasiteExists){
			$c = $return[$row->date_added]['moneysite'];
			$return[$row->date_added]['moneysite'] = $c+1;
		    }
		}
	    }
	}
	
	return $return;
    }
    
    public function getGoogleDataForCampaignForRangeNewDropped($cid, $fromDate, $toDate, $limit){
	$rec = false;
	$return = array();
	$rankArr = array();
	$timestampFromDate = strtotime($fromDate);
	$timestampToDate = strtotime($toDate);
	for($i=$timestampFromDate; $i<=$timestampToDate; $i=$i+24*3600){
	    for($j=0; $j<$limit; $j++){
		$return[date("Y-m-d", $i)][$j] = array('url' => '', 'rank' => '');
	    }	    
	}
	
	if($cid > 0){
	    $sql = " SELECT url, rank, date_added
	    FROM
	      (SELECT url, rank, date_added, 
			   @crank := IF(@cdate_added = date_added, @crank + 1, 1) AS crank,
			   @cdate_added := date_added 
		FROM ". TABLE_GOOGLE_CRAWL_DATA . "
		WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND rank <= ".$limit." AND campaign_id = '".$cid."'
		ORDER BY date_added, rank
	      ) ranked";
	    //$sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	}else{
	    //$sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' ORDER BY rank LIMIT 0, " . $limit;
	    $sql = " SELECT url, rank, date_added
	    FROM
	      (SELECT url, rank, date_added, 
			   @crank := IF(@cdate_added = date_added, @crank + 1, 1) AS crank,
			   @cdate_added := date_added 
		FROM ". TABLE_GOOGLE_CRAWL_DATA . "
		WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND rank <= ".$limit."
		ORDER BY date_added, rank
	      ) ranked";
	}
	
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    //pr($query->result_array());
	    $rec =   $query->result_array();
	    for($k=0; $k<count($rec); $k++){
		$return[$rec[$k]['date_added']][] = array('rank' => $rec[$k]['rank'], 'url' => $rec[$k]['url']);
	    }
	//    foreach($query->result() AS $row){
	//	    $url = $row->url;		
	//	    $url = parse_url($url);
	//	    for($j=0; $j<$limit; $j++){
	//	    $return[$row->date_added][$j]['url'] = $row->url;
	//	    $return[$row->date_added][$j]['rank'] = $row->rank;
	//	    }
	//    }
	}
	pr($return);
	return $return;
    }
    
    public function getYahooDataForCampaignForRange($cid, $fromDate, $toDate, $limit, $parasitelist){
	$rec = false;
	$return = array();
	$timestampFromDate = strtotime($fromDate);
	$timestampToDate = strtotime($toDate);
	for($i=$timestampFromDate; $i<=$timestampToDate; $i=$i+24*3600){
	    $return[date("Y-m-d", $i)] = array('parasite' => 0, 'moneysite' => 0, 'url' => '');
	}
	
	if($cid > 0){
	    $sql = " SELECT url, rank, date_added
	    FROM
	      (SELECT url, rank, date_added, 
			   @crank := IF(@cdate_added = date_added, @crank + 1, 1) AS crank,
			   @cdate_added := date_added 
		FROM ". TABLE_YAHOO_CRAWL_DATA . "
		WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND rank <= ".$limit." AND campaign_id = '".$cid."'
		ORDER BY date_added, rank
	      ) ranked";	    
	}else{	    
	    $sql = " SELECT url, rank, date_added
	    FROM
	      (SELECT url, rank, date_added, 
			   @crank := IF(@cdate_added = date_added, @crank + 1, 1) AS crank,
			   @cdate_added := date_added 
		FROM ". TABLE_YAHOO_CRAWL_DATA . "
		WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND rank <= ".$limit."
		ORDER BY date_added, rank
	      ) ranked";
	}
	//if($cid > 0){
	//    $sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	//}else{
	//    $sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' ORDER BY rank LIMIT 0, " . $limit;
	//}
	
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    foreach($query->result() AS $row){
		$url = $row->url;		
	        $url = parse_url($url);
		$return[$row->date_added]['url'] = $row->url;
		
		if(isset($url['host']) && !empty($url['host'])){
		    $parasiteExists	= false;
		    foreach($parasitelist AS $val){
			if(strpos($url['host'], $val)){
				$c = $return[$row->date_added]['parasite'];
				$return[$row->date_added]['parasite'] = $c+1;
				$parasiteExists	= true;			
			}
			break;
		    }		    
		}
		if(!$parasiteExists){
		    $c = $return[$row->date_added]['moneysite'];
		    $return[$row->date_added]['moneysite'] = $c+1;
		}
		
	    }
	}
	
	return $return;
    }
    
    public function getBingDataForCampaignForRange($cid, $fromDate, $toDate, $limit, $parasitelist){
	$rec = false;
	$return = array();
	$timestampFromDate = strtotime($fromDate);
	$timestampToDate = strtotime($toDate);
	for($i=$timestampFromDate; $i<=$timestampToDate; $i=$i+24*3600){
	    $return[date("Y-m-d", $i)] = array('parasite' => 0, 'moneysite' => 0, 'url' => '');
	}
	
	if($cid > 0){
	    $sql = " SELECT url, rank, date_added
	    FROM
	      (SELECT url, rank, date_added, 
			   @crank := IF(@cdate_added = date_added, @crank + 1, 1) AS crank,
			   @cdate_added := date_added 
		FROM ". TABLE_BING_CRAWL_DATA . "
		WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND rank <= ".$limit." AND campaign_id = '".$cid."'
		ORDER BY date_added, rank
	      ) ranked";	    
	}else{	    
	    $sql = " SELECT url, rank, date_added
	    FROM
	      (SELECT url, rank, date_added, 
			   @crank := IF(@cdate_added = date_added, @crank + 1, 1) AS crank,
			   @cdate_added := date_added 
		FROM ". TABLE_BING_CRAWL_DATA . "
		WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND rank <= ".$limit."
		ORDER BY date_added, rank
	      ) ranked";
	}
	
	//if($cid > 0){	    
	//    $sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	//}else{
	//    $sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE date_added BETWEEN '".$fromDate."' AND '".$toDate."' ORDER BY rank LIMIT 0, " . $limit;
	//}
	
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    foreach($query->result() AS $row){
		$url = $row->url;		
	        $url = parse_url($url);
		$return[$row->date_added]['url'] = $row->url;
		
		if(isset($url['host']) && !empty($url['host'])){
		    $parasiteExists	= false;
		    foreach($parasitelist AS $val){
			if(strpos($url['host'], $val)){
				$c = $return[$row->date_added]['parasite'];
				$return[$row->date_added]['parasite'] = $c+1;
				$parasiteExists	= true;			
			}
			break;
		    }		    
		}
		if(!$parasiteExists){
		    $c = $return[$row->date_added]['moneysite'];
		    $return[$row->date_added]['moneysite'] = $c+1;
		}
		
	    }
	}
	
	return $return;
    }
    
    public function getYahooDataForCampaign($cid, $currDate, $limit){
	$rec = false;
	if($cid > 0){
	    
	    if(!empty($limit)){
		$sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	    }else{
		$sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank";
	    }
	    
	    
	}else{
	    
	    if(!empty($limit)){
		$sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank LIMIT 0, " . $limit;
	    }else{
		$sql = "SELECT * FROM " . TABLE_YAHOO_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank";
	    }
	    
	   
	    
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
	    
	    if(!empty($limit)){
		$sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank LIMIT 0, " . $limit;
	    }else{
		$sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE date_added = '".$currDate."' AND campaign_id = '".$cid."' ORDER BY rank";
	    }
	    
	  
	}else{
	    
	    if(!empty($limit)){
		$sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank LIMIT 0, " . $limit;
	    }else{
		$sql = "SELECT * FROM " . TABLE_BING_CRAWL_DATA . " WHERE date_added = '".$currDate."' ORDER BY rank";
	    }
	    
	    
	}
	$query = $this->db->query($sql);
	
	if($query->num_rows() > 0){
	    $rec = $query->result_array();
	}
	return $rec;
    }
    
    
    public function updateCroncreationDate($tablename,$id,$data){
	
	$fields	= '';
	if(is_array($data) && count($data) > 0){
	    
		foreach($data as $k=>$v){
			$fields .= $k . ' = "' . addslashes(trim($v)). '", ';
		}
		$fields	= substr($fields, 0, strlen($fields)-2);
		
		if(!empty($fields)){				
			 $sql	= "UPDATE " . $tablename . " SET " . $fields . "  WHERE id = '".$id."'";
			
			$this->db->query($sql);
			
		}
	}
	
	 //$sql = "UPDATE ".$tablename." SET creation_date = '".$creation_date."' WHERE id = '".$id."'";
	
	//$query = $this->db->query($sql);
    }
    
    public function getUsersCampaignCrawlDetail($campaign){
	$rec = false;
	$sql = "SELECT * FROM " . TABLE_GOOGLE_CRAWL_DATA . " WHERE url = '".$campaign['campaign_main_page_url']."' AND date_added = '".date("Y-m-d")."'";
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec = $query->row_array();
	}
	return $rec;
    }
    
    public function getUsersAllSeoRankingTests($users_id){
	$sql = "SELECT * FROM " . serp_seo_ranking . " WHERE user_id = '".$users_id."'";
	$query = $this->db->query($sql);
	$num = $query->num_rows();
	return $num;
    }
   	
   	public function getUsersCampaignspopup($users_id){
	$rec	= false;
	$sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";
	//echo "test1".$sql;
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	    if(is_array($rec) && count($rec) > 0){
		for($i=0; $i<count($rec); $i++){
		    $sql	= '';
		    $query	= '';
		    $sql2	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS CK, " . TABLE_USERS_CAMPAIGNS . " AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$rec[$i]['campaign_id']."' AND campaign_murl_domain <> '' GROUP BY campaign_murl_domain";
		    //echo "test2".$sql2;
		    $query2	= $this->db->query($sql2);
		    if($query2->num_rows() > 0){
			$rec[$i]['campaign'] = $query2->result_array();
		    }else{
			$rec[$i]['campaign'] = '';
		    }
		}
	    }
	}
	return $rec;
    }



    public function getUsersCampaignCrawlSerpIndexYahoo($users_id){
	$rec = false;
	$sql = "SELECT * FROM `serp_search_engines` WHERE type = 'Yahoo'";
	 
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec = $query->result_array();
	}
	return $rec;
    }

     public function getUsersCampaignCrawlSerpIndexGoogle($users_id){
	$rec = false;
	$sql = "SELECT * FROM `serp_search_engines` WHERE type = 'Google'";
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec = $query->result_array();
	}
	return $rec;
    }

     public function getUsersCampaignCrawlSerpIndexBing($users_id){
	$rec = false;
	$sql = "SELECT * FROM `serp_search_engines` WHERE type = 'Bing'";
	$query = $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec = $query->result_array();
	}
	return $rec;
    }
    
    function get_node_list() {
	  	$rec = false;
			$sql = "	SELECT * FROM (`serp_users_campaign_keywords` a) JOIN `serp_users_campaign_detail` b ON `b`.`campaign_id` = `a`.`campaign_id`
WHERE `a`.`users_id` = b.users_id";
			$query = $this->db->query($sql);
			if($query->num_rows() > 0){
			    $rec = $query->result_array();
			}
			return $rec; 
	    
    }

    public function showresults($users_id){
			       //echo "lll".$user_id		= $this->session->userdata("LOGIN_USER");
			      // exit();
					$rec			= FALSE;
					$record			= FALSE; 

					$sql	= "SELECT CG.*,TC.*
						 FROM serp_google_crawl_data AS CG, serp_users_campaign_detail AS TC
						 WHERE CG.campaign_id = TC.campaign_id
						   AND TC.users_id = '". $users_id ."'
						   AND  TC.isCrawlByGoogle = 1   ORDER BY rank LIMIT 1";
					//echo $sql;
					 
					$query = $this->db->query($sql);
					if($query->num_rows() > 0){
					    $rec = $query->result_array();
					}
					return $rec;

					 
			}

	public function totalcntshowresults($users_id){
			       //echo "sdfdf".$users_id;
					$rec			= FALSE;
					$record			= FALSE; 

					$sql	= "SELECT CG.*,TC.*
						 FROM serp_google_crawl_data AS CG, serp_users_campaign_detail AS TC
						 WHERE CG.campaign_id = TC.campaign_id
						   AND TC.users_id = '". $users_id ."'
						   AND  TC.isCrawlByGoogle = 1   ORDER BY rank";
				//	echo $sql;
					 
					 
					$rs  =  $this->db->query($sql);
					$rec =$rs->num_rows();
					 
					return $rec;

					 
			}	

			public function showcontent($id){
		    //echo "test11"; print_r ($_REQUEST);
			$session = $this->session->userdata('user_data');
 	      $users_id=$session['user_id'];
					$rec			= FALSE;
					$record			= FALSE;


					$sql	= "SELECT CG.*,TC.*
						 FROM serp_google_crawl_data AS CG, serp_users_campaign_detail AS TC
						 WHERE CG.campaign_id = TC.campaign_id
						   AND CG.id = '1'
						   AND  TC.isCrawlByGoogle ='".$users_id."'  ORDER BY rank";
					//echo "ghhfghg".$sql;
					$query = $this->db->query($sql);
					if($query->num_rows() > 0){
					    $rec = $query->result_array();
					}
					echo $rec;
					 
					/*$rs  =  $this->db->query($sql);
					$rec =$rs->num_rows();

					return $rec; */
					 
			}	

		public function mainkeywords($users_id)
		{

		 $sql="SELECT keyword_id,keyword FROM  serp_users_campaign_keywords WHERE users_id = '".$users_id."' AND keyword_type = 'M' 
          ORDER BY keyword_id DESC LIMIT 1";
          //exit();
          $query	= $this->db->query($sql);
          if($query->num_rows() > 0){
					    $rec = $query->row_array();
					}
					return $rec;
		}

	public function secondkeywordscampaign($users_id, $campaign_id)
		{

		 $sql="SELECT keyword FROM  serp_users_campaign_keywords WHERE users_id = '".$users_id."' AND keyword_type = 'S'
          and campaign_id='".$campaign_id."' ORDER BY keyword_id DESC LIMIT 1";
          $query	= $this->db->query($sql);
          if($query->num_rows() > 0){
					    $rec = $query->row_array();
					}
					return $rec['keyword'];
		}
		
	public function secondkeywords($users_id)
		{

		 $sql="SELECT keyword FROM  serp_users_campaign_keyword_cpc_informations WHERE users_id = '".$users_id."' AND keyword_type = 'S'
          ORDER BY keyword_id DESC LIMIT 1";
          $query	= $this->db->query($sql);
          if($query->num_rows() > 0){
					    $rec = $query->row_array();
					}
					return $rec['keyword'];
		}

		public function secondkeywordspopup($users_id)
		{

		  $sql="SELECT keyword_id,keyword FROM  serp_users_campaign_keywords WHERE users_id = '".$users_id."' AND keyword_type = 'S' ORDER BY keyword_id DESC LIMIT 1";
          $query	= $this->db->query($sql);
          if($query->num_rows() > 0){
					    $rec = $query->row_array();
					}
					return $rec['keyword'];
		}	


		public function secondkeywordsloop($users_id,$campaign_id)
		{
	   $sql = "SELECT keyword, keyword_cpc, keyword_est_traffic FROM  `serp_users_campaign_keyword_cpc_informations` WHERE users_id = '".$users_id."' AND keyword_type =  'S' AND campaign_id = '".$campaign_id."' ORDER BY keyword DESC";
       $query = $this->db->query($sql);
					if($query->num_rows() > 0){
					    $rec = $query->result_array();
					}
					return $rec;

		}

		
		public function mainkeywordsloop($users_id)
		{
	   $sql = "SELECT keyword, keyword_cpc, keyword_est_traffic FROM  `serp_users_campaign_keyword_cpc_informations` WHERE users_id = '".$users_id."' AND keyword_type =  'M' ORDER BY keyword DESC";
       $query = $this->db->query($sql);
					if($query->num_rows() > 0){
					    $rec = $query->result_array();
					}
					return $rec;

		}


	public function additionalkeywords($users_id)
		{

		 $sql="SELECT keyword FROM  serp_users_campaign_keywords WHERE users_id = '".$users_id."' AND keyword_type = 'A'
          ORDER BY keyword_id DESC LIMIT 1";
          $query	= $this->db->query($sql);
          if($query->num_rows() > 0){
					    $rec = $query->row_array();
					}
					return $rec['keyword'];
		}

		public function additionalkeywordsloop($users_id,$campaign_id)
		{
	   $sql = "SELECT keyword FROM  `serp_users_campaign_keywords` WHERE users_id = '".$users_id."' and campaign_id='".$campaign_id."' AND keyword_type =  'A' ORDER BY keyword DESC";
       $query = $this->db->query($sql);
					if($query->num_rows() > 0){
					    $rec = $query->result_array();
					}
					return $rec;

		}	
			/* Added by Beas - getting count of max site subscription */
			public function count_max_sites_per_subscription($users_id)
			{
				$sql = "SELECT * FROM  `serp_users_campaign_detail` WHERE users_id = '".$users_id."'";
				$query = $this->db->query($sql);
				return $query->num_rows();

			}	
			/* Added by Beas  */

			public function getexactmatchanchor($user_id,$campaign_id)
			{


				$this->db->select('*');
			 $this->db->from('serp_google_crawl_data');
			 $this->db->where('user_id', $user_id);
			 //$this->db->where('keyword_type','M');
			 $this->db->where('campaign_id', $campaign_id);
			// $this->db->orderby('DESC');
			 $query = $this->db->get();
			 $result = $query->result();
			 $row = $query->result();
			 return $row[0]; 
          }
        /*$sql = "SELECT * FROM  `serp_users_campaign_keywords` WHERE users_id = '".$user_id."' AND campaign_id =  '".$campaign_id."' ORDER BY keyword DESC";
       $query = $this->db->query($sql);
					if($query->num_rows() > 0){
					    $rec = $query->result_array();
					}
					return $rec;*/
			public function getrelatedmatchanchor($user_id,$campaign_id)
			{


				$this->db->select('*');
			 $this->db->from('serp_users_campaign_keywords');
			 $this->db->where('users_id', $user_id);
			 $this->db->where('keyword_type','S');
			 $this->db->where('campaign_id', $campaign_id);
			// $this->db->orderby('DESC');
			 $query = $this->db->get();
			 $result = $query->result();
			 $row = $query->result();
			 return $row[0]; 
          }

          public function insertformdata($users_id)
          {
         $exactkw     = $this->input->post('exactkw');
	    $exact_anchor     = $this->input->post('exact_anchor');
        $exact_url     = $this->input->post('exact_url');
	    $exact_total     = $this->input->post('exact_total');

	    $relatedkw     = $this->input->post('relatedkw');
	    $related_anchor     = $this->input->post('related_anchor');
        $related_url     = $this->input->post('related_url');
	    $related_total     = $this->input->post('related_total');

	    $selectkw     = $this->input->post('selectkw');
	    $select_anchor     = $this->input->post('select_anchor');
        $select_url     = $this->input->post('select_url');
	    $select_total     = $this->input->post('select_total');
	    $links_built     = $this->input->post('links_built');

           if($exactkw == ''){
	    $exactkw	= 'No';
	}
	if($relatedkw == ''){
	    $relatedkw	= 'No';
	}
	if($selectkw == ''){
	    $selectkw	= 'No';
	}
	
	 $sql	= "INSERT INTO " . serp_config_custom_link . " SET
		  user_id			    = '".$users_id."',
		  exactkw				= '".$exactkw."',
		  relatedkw		        = '".$relatedkw."',
		  selectkw		        = '".$selectkw."',
		  exact_anchor			= '".$exact_anchor."',
		  exact_url		        = '".$exact_url."',
		  exact_total		    = '".$exact_total."',
		  related_anchor		= '".$related_anchor."',
		  related_url		    = '".$related_url."',
		  related_total	        = '".$related_total."',
		  select_anchor	        = '".$select_anchor."',
		  select_url		    = '".$select_url."',
		  select_total	        = '".$select_total."',
		  links_built	        = '".$links_built."'";

		
		
	$this->db->query($sql);
	

          }

 

    public function setserpcrawl_conditions($user_id,$campaign_id){
		//print_r($this->input->post());
		$session = $this->session->userdata('user_data'); 
	    $users_id = $session['user_id'];
		$country     =  $this->input->post(google_se_domain);
		$site     = $this->input->post(google_se_domain);
		$userid     =  $this->input->post(google_se_domain);
		$sql	= "INSERT INTO " . serp_temp_tbl . " SET
		country			    = '".$country."',
		site 				 = '".$site."', 
		userid		        = '".$users_id."'"; 
		$this->db->query($sql);
		//exit;
		// return $rec;
    }

    public function getserpcrawl_conditions($user_id,$campaign_id){ 
    	   $session = $this->session->userdata('user_data'); 
	    $users_id = $session['user_id'];
	    
	    //print_r($session);
		$sql = "SELECT * FROM serp_tmpanalyzecomp WHERE users_id = '".$users_id."' ORDER BY id DESC LIMIT 1";
 
			$query = $this->db->query($sql);

			 $row = $query->result();
			 return $row[0]; 
    }

     public function getbacklinkcount($user_id){ 
    	   $session = $this->session->userdata('user_data'); 
	    $users_id = $session['user_id'];
			$sql = "SELECT * FROM  serp_api_href_match WHERE user_id = '".$users_id."' limit 1";
			$query = $this->db->query($sql);

			 $row = $query->result();
			 return $row[0]; 
    }


    public function launchcampaign()
    {
    	$session = $this->session->userdata('user_data'); 
	    $user_id = $session['user_id'];
     
     $link_velocity = $this->input->post('link_velocity');
      $num_links = $this->input->post('num_links');

      $sql = "UPDATE " . serp_users_campaign_master . " SET
      link_velocity       = '".$link_velocity."',
      num_links      = '".$num_links."' WHERE users_id='".$user_id."'";
        $this->db->query($sql);

    }

    public function getuserdetailcompare($users_id)
		{
	   $sql = "SELECT * FROM  `serp_tmpanalyzecomp` WHERE users_id = '".$users_id."' ORDER BY date_added DESC limit 1";
       $query = $this->db->query($sql);

			 $row = $query->result();
			 return $row[0]; 

		}

		public function seckeywords($users_id)
		{

		 $sql="SELECT keyword_id,keyword FROM  serp_users_campaign_keywords WHERE users_id = '".$users_id."' AND keyword_type = 'S' 
          ORDER BY keyword_id DESC LIMIT 1";
          //exit();
          $query	= $this->db->query($sql);
          if($query->num_rows() > 0){
					    $rec = $query->row_array();
					}
					return $rec;
		}

		public function spider($users_id) {
   		  $url = 'https://www.google.au/search?q=rickshaw&num=10'; 
   		   $html = str_get_html(crawl_simple($this->reffer_google, $url, $this->agent, $proxy));
   		   return $html;
    }

    


		
}
