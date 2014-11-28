<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_Ranking extends CI_Model{
	
    public function __construct(){        
        // Call the Model constructor
        parent::__construct();
    }
	
        
        public function CampaignListPerUser($uId) {
	
	$sql = "SELECT * FROM ".TABLE_USERS_CAMPAIGN_MASTER." WHERE  users_id = '".$uId."'";
	$rs  = $this->db->query($sql);
	if($rs->num_rows() >0)
	    {
		    $rec = $rs->result_array();
		    
		    if(is_array($rec) && count($rec) > 0){
                    for($i=0; $i<count($rec); $i++){
                       $campaign_id = $rec[$i]['campaign_id'];
		       
                        
                       $sql1 = "SELECT COUNT(*) as CNT FROM  ".TABLE_USERS_CAMPAIGNS_KEYWORD." WHERE campaign_id = '". $campaign_id."' AND users_id = '".$uId."' AND status = 'Active'";
		       $rs1 = $this->db->query($sql1);

		       $rec1 = $rs1->row();
		       $cnt = $rec1->CNT;
		       $rec[$i]['additional_keyword'] = $cnt;
                    }
                } else {
		    $rec[$i]['additional_keyword'] = '0';
		}
		    return $rec;
	    }
	    else
	    {
		    return false;
	    }
	
    }

     /*public function delete_popupdata($id)
    {
        $query = $this->db->where('ID', $id);
        $query = $this->db->limit(1,0);
        $query = $this->db->delete('campaign_posts');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }*/


    public function popup_data($id){
		$this->db->select('*');	
		//$this->db->select('date(post_date) as date1');
		//$this->db->select('time(post_date) as time1');
		$this->db->from('serp_users_campaign_keywords');
		$this->db->where('campaign_id', $id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
		echo $result;
		
	}
    
    public function editkeywords($id,$postdata)
    {
    	//print_r ($postdata);print_r ($id);
    	$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');

/*
		$text =$postdata['addKeywordstextarea'];
		$result_text = preg_replace("/\b(\w+)\s+\\1\b/i", "$1", $text);
		echo "Result Text: ".$result_text;

		$string=$postdata['addKeywordstextarea'];
		$arr = explode( " " , $string);
		echo "arr".$arr = array_unique( $arr );
		echo "string".$string = implode(" " , $arr);
		 synonyms = '".$postdata['addKeywordstextarea']."',*/
		$sqlkey	= "INSERT INTO `serp_users_campaign_keywords` SET
		  users_id			= '".$userid."',
		  campaign_id	= '".$postdata['camp_name']."',
		  keyword = '".$postdata['addKeywordstextarea']."',
		 		 
		  status ='Active',
		  date_modified =NOW(),
		  date_added			= NOW()";
		$this->db->query($sqlkey);  

		/*$sqlcamp	= "INSERT INTO `serp_users_campaign_detail` SET
		  users_id			= '".$userid."',
		  campaign_id				= '".$camp_name."',
		  c_id = '".$camp_name."',
		  isCrawlByGoogle 	= 'Yes',
		  isCrawlByBing = 'Yes',
		  isCrawlByYahoo= 'Yes',
		  google_se_domain= 'google.co.in',
		  bing_se_domain= 'www.bing.com',
		  yahoo_se_domain= 'search.yahoo.com',
		  campaign_main_page_url
		  campaign_main_keyword
		  synonyms = '".$addKeywordstextarea."',
		  keyword_type = '".$addKeywordstextarea."',
		  status ='Active',
		  date_modified =NOW(),
		  date_added			= NOW()";	  
	    $this->db->query($sqlcamp);*/
	 
     }


     public function editmanakeywords($id,$postdata)
    {
    	print_r ($postdata);print_r ($id);
    	$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');

/*
		$text =$postdata['addKeywordstextarea'];
		$result_text = preg_replace("/\b(\w+)\s+\\1\b/i", "$1", $text);
		echo "Result Text: ".$result_text;

		$string=$postdata['addKeywordstextarea'];
		$arr = explode( " " , $string);
		echo "arr".$arr = array_unique( $arr );
		echo "string".$string = implode(" " , $arr);
		 synonyms = '".$postdata['addKeywordstextarea']."',*/
		/*$sqlkey	= "INSERT INTO `serp_users_campaign_keywords` SET
		  users_id			= '".$userid."',
		  campaign_id	= '".$postdata['camp_name']."',
		  keyword = '".$postdata['addKeywordstextarea']."',
		 		 
		  status ='Active',
		  date_modified =NOW(),
		  date_added			= NOW()";
		$this->db->query($sqlkey); */  
	 
     }

    public function getUsersCampaignKeywordList($id, $postdata)
    {
    	//print_r ($postdata);print_r ($id);
    	$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');

		/*$rec = false;
		$sql = "SELECT * FROM `serp_users_campaign_keywords` WHERE type = 'Bing'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
		    $rec = $query->result_array();
		}
		return $rec;*/
	 }
    
   
}
