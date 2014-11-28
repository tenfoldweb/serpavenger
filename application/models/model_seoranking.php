<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_seoranking extends CI_Model{
	
    public function __construct(){        
        // Call the Model constructor
        parent::__construct();
    }
	
   
    
    public function insertSeoRankingData($user_id){
	
	$title 			= $this->input->get_post('title');
	$description 		= $this->input->get_post('description');
	$campaign_id 		= $this->input->get_post('campaign_id');
	$start_date 		= $this->input->get_post('start_date');
	$type_of_page 		= $this->input->get_post('type_of_page');
	$duration 		= $this->input->get_post('duration');
	$reverse_date 		= $this->input->get_post('reverse_date');
	
	  $sql	= "INSERT INTO " . TABLE_SEO_RANKING . " SET
			       title		= '".addslashes($title)."',
			       description	= '".addslashes($description)."',
			       campaign_id	= '".$campaign_id."',
			       start_date	= '".addslashes($start_date)."',
			       type_of_page	= '".addslashes($type_of_page)."',
			       duration		= '".addslashes($duration)."',
			       reverse_date	= '".$reverse_date."',
			       user_id		= '".$user_id."',
			       status		= 'Active',
			       date_added	= '".date('Y-m-d H:i:s')."'";
			     
			       
	$this->db->query($sql);
	$id = mysql_insert_id();
	return $id;
    }
    
    public  function ListSeoRanking($user_id){
	$rec = false;
	$sql = "SELECT * FROM  ".TABLE_SEO_RANKING." WHERE user_id = '".$user_id."'";
	
            $rs  = $this->db->query($sql);
            if($rs->num_rows() > 0){
                $rec = $rs->result_array();                   
                if(is_array($rec) && count($rec) > 0){
                    for($i=0; $i<count($rec); $i++){
                       $campaign_id = $rec[$i]['campaign_id'];
                        
                       $sql1 = "SELECT * FROM  ".TABLE_USERS_CAMPAIGN_MASTER." WHERE  campaign_id = '". $campaign_id."' AND campaign_status = 'Active'";
                        $rs1  = $this->db->query($sql1);
                        if($rs1->num_rows() > 0){
                            $rec[$i]['campaign_name'] = $rs1->result_array();
                        }else{
                            $rec[$i]['campaign_name'] = '';
                        }
                    }
                }
            }
	return $rec;
	
    }
    public  function plotBandsSeoRanking($user_id,$cid){
		$rec = false;
		$sql = "SELECT ".TABLE_SEO_RANKING.".title, UNIX_TIMESTAMP(".TABLE_SEO_RANKING.".start_date)*1000 AS `start_date`, ".TABLE_SEO_RANKING.".type_of_page, ".TABLE_SEO_RANKING.".duration, UNIX_TIMESTAMP(".TABLE_SEO_RANKING.".reverse_date)*1000 AS reverse_date FROM  ".TABLE_SEO_RANKING." JOIN ".TABLE_USERS_CAMPAIGN_MASTER."  WHERE ".TABLE_SEO_RANKING.".user_id = '".$user_id."' AND ".TABLE_USERS_CAMPAIGN_MASTER.".campaign_id = '". $cid."' AND ".TABLE_USERS_CAMPAIGN_MASTER.".campaign_status = 'Active'";
	
		$rs  = $this->db->query($sql);
		if($rs->num_rows() > 0){
			$rec = $rs->result_array();                   
        }
		return $rec;
	
    }
    public  function getCampaignKW($cid){
		$rec = false;
		$sql = "SELECT ".TABLE_USERS_CAMPAIGNS.".campaign_main_keyword FROM ".TABLE_USERS_CAMPAIGNS."  WHERE ".TABLE_USERS_CAMPAIGNS.".campaign_id = '".$cid."'";
	
		$rs  = $this->db->query($sql);
		if($rs->num_rows() > 0){
			$rec = $rs->result_array();                   
        }
		return $rec;
	
    }
    public  function urlSeoRanking1($sid,$cid){
		$rec = false;
		$ta='';
		switch($sid){
			case "yahoo":
				$ta=TABLE_YAHOO_CRAWL_DATA;
				break;
			case "bing":
				$ta=TABLE_BING_CRAWL_DATA;
				break;
			default:
				$ta=TABLE_GOOGLE_CRAWL_DATA;
				break;
		}
		$sql = "SELECT UNIX_TIMESTAMP(`".$ta."`.`date_added`)*1000 AS `date`,  `".$ta."`.`rank` 
				FROM  `".$ta."` 
				JOIN  `".TABLE_USERS_CAMPAIGNS."` ON ".TABLE_USERS_CAMPAIGNS.".campaign_id =  `".$ta."`.`campaign_id` 
				AND  `".$ta."`.`url` = ".TABLE_USERS_CAMPAIGNS.".campaign_main_page_url
				WHERE ".TABLE_USERS_CAMPAIGNS.".campaign_id =".$cid."
				ORDER BY  `".$ta."`.`date_added`";
	
		$rs  = $this->db->query($sql);
		if($rs->num_rows() > 0){
			$rec = $rs->result_array();                   
        }
		return $rec;
	
    }
    
    public function DeleteSeoRanking($sr_id){
	
	$sql = "DELETE FROM ".TABLE_SEO_RANKING." WHERE s_r_id = '".$sr_id."'";
	$this->db->query($sql);
	return true;
    }
    
    
    public function getSingle($id) {
	
	$sql = "SELECT * FROM ".TABLE_SEO_RANKING." WHERE s_r_id = '".$id."'";
	$rs  =  $this->db->query($sql);
	if($rs->num_rows() > 0) {
	     $rec = $rs->result_array(); 
	}
	
	return $rec;
    }
    
    public function UpdateReserveDate() {
	
	$reverse_date 		= $this->input->get_post('reverse_date');
	$s_r_id			= $this->input->get_post('s_r_id');
	
	$sql = "UPDATE ".TABLE_SEO_RANKING." SET  reverse_date 	= '".$reverse_date."' WHERE s_r_id = '".$s_r_id."'";
	
	$this->db->query($sql);
	
	if(!$this->db->affected_rows()){
	    log_message('error',"Mysql Error on ws_user insert: ".$sql);
	    return false;
	}
	return true;
    }
	
	 public  function urlSeoRanking($sid,$cid,$users_id){
		$rec = false;
		$ta='';
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
		switch($sid){
			case "yahoo":
				$ta=TABLE_YAHOO_CRAWL_DATA;
				break;
			case "bing":
				$ta=TABLE_BING_CRAWL_DATA;
				break;
			default:
				$ta=TABLE_GOOGLE_CRAWL_DATA;
				break;
		}
		$sql="SELECT UNIX_TIMESTAMP(`".$ta."`.`date_added`)*1000 AS `date`,  `".$ta."`.`rank`,serp_users_campaign_keywords.`keyword_id`,serp_users_campaign_keywords.`keyword_type`,serp_users_campaign_keywords.`keyword` 
				FROM  `".$ta."` 
				JOIN  `serp_users_campaign_detail` 
				ON serp_users_campaign_detail.campaign_id =  `".$ta."`.`campaign_id` 
				JOIN serp_users_campaign_keywords
				ON serp_users_campaign_keywords.campaign_id=serp_users_campaign_detail.campaign_id
				AND  `".$ta."`.`keyword_id` = serp_users_campaign_keywords.keyword_id
				WHERE serp_users_campaign_detail.campaign_id =".$cid."
ORDER BY serp_users_campaign_keywords.`keyword_type` ASC, `serp_users_campaign_keywords`.`keyword_id`  DESC, `".$ta."`.`date_added` ASC ";
		/*$sql = "SELECT UNIX_TIMESTAMP(`".$ta."`.`date_added`)*1000 AS `date`,  `".$ta."`.`rank` 
				FROM  `".$ta."` 
				JOIN  `".TABLE_USERS_CAMPAIGNS."` ON ".TABLE_USERS_CAMPAIGNS.".campaign_id =  `".$ta."`.`campaign_id` 
				AND  `".$ta."`.`url` = ".TABLE_USERS_CAMPAIGNS.".campaign_main_page_url
				WHERE ".TABLE_USERS_CAMPAIGNS.".campaign_id =".$cid."
				ORDER BY  `".$ta."`.`date_added`";*/
	
		$rs  = $this->db->query($sql);
		if($rs->num_rows() > 0){
			$rec = $rs->result_array();                   
        }
		return $rec;
	
    }
	
	public function KWRankingRange($sid,$cid,$users_id){
		$rec = false;
		$ta='';
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
		switch($sid){
			case "yahoo":
				$ta=TABLE_YAHOO_CRAWL_DATA;
				break;
			case "bing":
				$ta=TABLE_BING_CRAWL_DATA;
				break;
			default:
				$ta=TABLE_GOOGLE_CRAWL_DATA;
				break;
		}
		$sql="SELECT 
				'DAY' AS `type`, 
				SUM( CASE WHEN ".$ta.".`rank` <4 THEN 1 ELSE 0 END ) AS range1,
				SUM( CASE WHEN ".$ta.".`rank` >3 AND ".$ta.".`rank` <11 THEN 1 ELSE 0 END ) AS range2,
				SUM( CASE WHEN ".$ta.".`rank` >10 AND ".$ta.".`rank` <21 THEN 1 ELSE 0 END ) AS range3, 
				SUM( CASE WHEN ".$ta.".`rank` >20 AND ".$ta.".`rank` <51 THEN 1 ELSE 0 END ) AS range4,
				SUM( CASE WHEN ".$ta.".`rank` >50 THEN 1 ELSE 0 END ) AS range5,  
				'' AS `aggr`,UNIX_TIMESTAMP(".$ta.".date_added )*1000 AS `date`
			FROM `serp_users_campaign_detail`
			
			LEFT JOIN ".$ta."
			on ".$ta.".`campaign_id`=serp_users_campaign_detail.`campaign_id`
			
			WHERE serp_users_campaign_detail.`campaign_id`=".$cid."
			
			GROUP BY (".$ta.".date_added)
			
			
			UNION
			
			SELECT 
				'WEEK' AS `type`,  
				SUM( CASE WHEN ".$ta.".`rank` <4 THEN 1 ELSE 0 END ) AS range1,
				SUM( CASE WHEN ".$ta.".`rank` >3 AND ".$ta.".`rank` <11 THEN 1 ELSE 0 END ) AS range2,
				SUM( CASE WHEN ".$ta.".`rank` >10 AND ".$ta.".`rank` <21 THEN 1 ELSE 0 END ) AS range3, 
				SUM( CASE WHEN ".$ta.".`rank` >20 AND ".$ta.".`rank` <51 THEN 1 ELSE 0 END ) AS range4,
				SUM( CASE WHEN ".$ta.".`rank` >50 THEN 1 ELSE 0 END ) AS range5,  
				WEEK(".$ta.".date_added) AS `aggr`,
				UNIX_TIMESTAMP(".$ta.".date_added )*1000 AS `date`
			FROM `serp_users_campaign_detail`
			
			LEFT JOIN ".$ta."
			on ".$ta.".`campaign_id`=serp_users_campaign_detail.`campaign_id`
			WHERE serp_users_campaign_detail.campaign_id=".$cid."
			GROUP BY WEEK(".$ta.".date_added)
			
			UNION
			
			SELECT 
				'MONTH' AS `type`,  
				SUM( CASE WHEN ".$ta.".`rank` <4 THEN 1 ELSE 0 END ) AS range1,
				SUM( CASE WHEN ".$ta.".`rank` >3 AND ".$ta.".`rank` <11 THEN 1 ELSE 0 END ) AS range2,
				SUM( CASE WHEN ".$ta.".`rank` >10 AND ".$ta.".`rank` <21 THEN 1 ELSE 0 END ) AS range3, 
				SUM( CASE WHEN ".$ta.".`rank` >20 AND ".$ta.".`rank` <51 THEN 1 ELSE 0 END ) AS range4,
				SUM( CASE WHEN ".$ta.".`rank` >50 THEN 1 ELSE 0 END ) AS range5,  
				MONTH(".$ta.".date_added) AS `aggr`,
				UNIX_TIMESTAMP(".$ta.".date_added )*1000 AS `date`
				FROM `serp_users_campaign_detail`
			
			LEFT JOIN ".$ta."
			on ".$ta.".`campaign_id`=serp_users_campaign_detail.`campaign_id`
			WHERE serp_users_campaign_detail.campaign_id=".$cid."
			GROUP BY MONTH(".$ta.".date_added)";
			$rs  = $this->db->query($sql);
			if($rs->num_rows() > 0){
				$rec = $rs->result_array();                   
			}
			return $rec;
	}
	
	public function getAllCampaignDetails($users_id){
		$rec = false;
		$sql="SELECT 
				serp_users_campaign_master.`campaign_title`, 
				serp_users_campaign_detail.`c_id`, 	
				serp_users_campaign_detail.campaign_site_type, 
				`key`.key_count,
				serp_users_campaign_detail.campaign_main_page_url, 
				serp_users_campaign_detail.`campaign_id`,
				serp_users_campaign_keywords.keyword_id, 
				serp_users_campaign_keywords.keyword,
				serp_users_campaign_keywords.keystatus,
				serp_users_campaign_keywords.keyword_type, 
				serp_users_campaign_keywords.`status`,
				`Yahoo`.ytrend,`Yahoo`.yrank, `Yahoo`.ycurrent, `Yahoo`.yprev,
				`Google`.gtrend,`Google`.grank, `Google`.gcurrent, `Google`.gprev,
				`Bing`.btrend,`Bing`.brank, `Bing`.bcurrent, `Bing`.bprev
								
			FROM `serp_users_campaign_master` 
			
			JOIN serp_users_campaign_detail
			
			ON serp_users_campaign_detail.c_id=serp_users_campaign_master.`campaign_id`
			
			JOIN serp_users_campaign_keywords
								
			ON serp_users_campaign_keywords.campaign_id=serp_users_campaign_detail.`campaign_id`

			JOIN (SELECT campaign_id,COUNT(*) AS key_count FROM serp_users_campaign_keywords GROUP BY campaign_id) AS `key`
								
			ON `key`.campaign_id=serp_users_campaign_detail.`campaign_id`
			
			LEFT JOIN (SELECT GROUP_CONCAT(rank SEPARATOR ', ') AS `ytrend`,keyword_id, MAX(rank) AS `yrank`, (SELECT rank FROM serp_yahoo_crawl_data WHERE date_added=DATE(NOW()) LIMIT 0,1) AS `ycurrent`, (SELECT rank FROM serp_yahoo_crawl_data WHERE date_added=DATE(DATE_ADD(NOW(),INTERVAL -1 day)) LIMIT 0,1) AS `yprev` FROM serp_yahoo_crawl_data GROUP BY keyword_id) AS `Yahoo`
			
			ON `Yahoo`.keyword_id=serp_users_campaign_keywords.keyword_id
			
			LEFT JOIN (SELECT GROUP_CONCAT(rank SEPARATOR ', ') AS `gtrend`,keyword_id, MAX(rank) AS `grank`, (SELECT rank FROM serp_google_crawl_data WHERE date_added=DATE(NOW()) LIMIT 0,1) AS `gcurrent`, (SELECT rank FROM serp_google_crawl_data WHERE date_added=DATE(DATE_ADD(NOW(),INTERVAL -1 day)) LIMIT 0,1) AS `gprev` FROM serp_google_crawl_data GROUP BY keyword_id) AS `Google`
			
			ON `Google`.keyword_id=serp_users_campaign_keywords.keyword_id
			
			LEFT JOIN (SELECT GROUP_CONCAT(rank SEPARATOR ', ') AS `btrend`,keyword_id, MAX(rank) AS `brank`, (SELECT rank FROM serp_bing_crawl_data WHERE date_added=DATE(NOW()) LIMIT 0,1) AS `bcurrent`, (SELECT rank FROM serp_bing_crawl_data WHERE date_added=DATE(DATE_ADD(NOW(),INTERVAL -1 day)) LIMIT 0,1) AS `bprev` FROM serp_bing_crawl_data GROUP BY keyword_id) AS `Bing`
			
			ON `Bing`.keyword_id=serp_users_campaign_keywords.keyword_id
			
			WHERE serp_users_campaign_master.`users_id`=".$users_id."
			
			ORDER BY serp_users_campaign_detail.`c_id`,serp_users_campaign_detail.`campaign_id`,serp_users_campaign_keywords.keyword_type";
		$rs  = $this->db->query($sql);
		if($rs->num_rows() > 0){
			$rec = $rs->result_array();                   
		}
		return $rec;
	}
	
	
	
	
	
}


/*

SELECT `serp_google_crawl_data`.`date_added` AS `date`,  `serp_google_crawl_data`.`rank` 
FROM  `serp_google_crawl_data` 
JOIN  `serp_users_campaign_detail` ON serp_users_campaign_detail.campaign_id =  `serp_google_crawl_data`.`campaign_id` 
AND  `serp_google_crawl_data`.`url` = serp_users_campaign_detail.campaign_main_page_url
WHERE serp_users_campaign_detail.campaign_id =1
ORDER BY  `serp_google_crawl_data`.`date_added` */

/*

SELECT UNIX_TIMESTAMP(`serp_yahoo_crawl_data`.`date_added`)*1000 AS `date`,  `serp_yahoo_crawl_data`.`rank`,serp_users_campaign_keywords.`keyword_id`,serp_users_campaign_keywords.`keyword` 
				FROM  `serp_yahoo_crawl_data` 
				JOIN  `serp_users_campaign_detail` 
				ON serp_users_campaign_detail.campaign_id =  `serp_yahoo_crawl_data`.`campaign_id` 
				JOIN serp_users_campaign_keywords
				ON serp_users_campaign_keywords.campaign_id=serp_users_campaign_detail.campaign_id
				AND  `serp_yahoo_crawl_data`.`keyword_id` = serp_users_campaign_keywords.keyword_id
				WHERE serp_users_campaign_detail.campaign_id =1
ORDER BY `serp_users_campaign_keywords`.`keyword`  DESC

*/