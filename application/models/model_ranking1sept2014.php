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
 
		$sqlkey	= "INSERT INTO `serp_users_campaign_keywords` SET
		  users_id			= '".$userid."',
		  campaign_id	= '".$postdata['camp_name']."',
		  keyword = '".$postdata['addKeywordstextarea']."',
		 		 
		  status ='Active',
		  date_modified =NOW(),
		  date_added			= NOW()";
		$this->db->query($sqlkey);  
	 
     }


     public function editmanakeywords($id,$postdata)
    {
    	//print_r ($postdata);print_r ($id);
    	$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');
		
		$data = array(
               'date_modified' => date('Y-m-d H:i:s')               
            );

		//$postdata['date_modified'] = date('Y-m-d H:i:s');
		$where = array('campaign_id ' => $postdata['camp_name']  ,'users_id ' => $userid);
		$this->db->where($where);
		$this->db->update('serp_users_campaign_detail', $data); 
		   
		return $this->db->affected_rows(); 
	 
     }


     public function editmanageseo($id,$postdata)
    {
    	//print_r ($postdata);print_r ($id);
    	$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME'); 

 		$sqlkey	= "INSERT INTO `serp_seo_ranking` SET
		  user_id			= '".$userid."',
		  campaign_id	= '".$postdata['campaignid']."',
		  title = '".$postdata['title']."',
		  description = '".$postdata['description']."',	
		  type_of_page = '".$postdata['pagetest']."',
		  duration = '".$postdata['schart']."',		 		 
		  status ='Active',
		  date_modified =NOW(),
		  date_added			= NOW()";
		  //echo $this->db->last_query(); 
		$this->db->query($sqlkey);   
	 
     }

    public function getUsersCampaignKeywordList($id, $postdata)
    {
    	//print_r ($postdata);print_r ($id);
    	$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');
 
	 }

	function keyworddelete($id)
	{	 
		//print_r ($postdata);print_r ($id);
    	$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');
		 
	
		$sql = "DELETE FROM  `serp_users_campaign_keywords`  WHERE campaign_id = '".$id."' and users_id='".$userid."'";
		$this->db->query($sql);
		return $this->db->affected_rows();
      
	 }
	 
	 
	 
	  function get_node_by_type($type) {
	  	$this->db->select('*');
			$this->db->from('serp_users_campaign_keywords a');
			$this->db->join('serp_users_campaign_detail b', 'b.campaign_id = a.campaign_id');
			$this->db->where('a.users_id = b.users_id');
			$this->db->where('type',$type,'=');
			//$this->db->order_by('a.date_added','DESC');			 
			$query = $this->db->get();
	  	//echo $this->db->last_query(); 
	    
	 
	    return $query->result();
    }

    public function getCountSeokeyword($id) {
		//print_r($_REQUEST);print_r ($id);
		$campid=@$_REQUEST['cid'];
		$arr = explode("-",$campid);
		//echo "<br>";echo $arr['0'];
	    //echo "<br>";echo $arr['1'];
		$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');
		//$sql = "SELECT count(*) FROM `serp_users_campaign_keywords` a, serp_users_campaign_keywords b where  a.campaign_id=b.campaign_id and a.users_id=b.users_id and a.users_id=1 and b.keyword='tenant screening'";
		//echo "<br>";echo "arr".$arr['1'];
		if(isset($arr['1']))
		{
			$sql="SELECT * FROM serp_users_campaign_keywords
		    where  campaign_id='".$arr['1']."' and  users_id='".$userid."' and keyword_id='".$arr['0']."'";
			
		}
		else
		{
			$sql="SELECT * FROM serp_users_campaign_keywords
		    where  users_id='".$userid."'";
		}
		//echo "<br>";echo $sql;
		$rs  =  $this->db->query($sql);
		$rec =$rs->num_rows();
		 
	    return $rec;
   
     }

     public function getCountKey($id) {
		//print_r($_REQUEST);print_r ($id);
		@$campid=$_REQUEST['cid'];
		$arr = explode("-",$campid);
		//echo "<br>";echo $arr['0'];
	    //echo "<br>";echo $arr['1'];
		$userid = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');
		//$sql = "SELECT * FROM `serp_users_campaign_keywords` a, serp_users_campaign_keywords b where  a.campaign_id=b.campaign_id and a.users_id=b.users_id and a.users_id=1 and b.keyword='tenant screening'";
		//echo "<br>";echo "arr1".$arr['1'];
		if(isset($arr['1']))
		{
			 $sql = "SELECT * FROM `serp_users_campaign_keywords` where  campaign_id='".$arr['1']."' and users_id='".$userid."'";
			
		}
		else
		{
			 $sql = "SELECT * FROM `serp_users_campaign_keywords` where users_id='".$userid."'";
		}
	    //echo "<br>";echo $sql;
		$rs  =  $this->db->query($sql);
		$rec =$rs->num_rows();
		 
		return $rec;
    }
 

     public function getCountgoogleyahoobing($id) {
     	//TABLE_USERS_CAMPAIGNS_KEYWORD-serp_users_campaign_keywords
    	//TABLE_GOOGLE_CRAWL_DATA  - serp_google_crawl_data
		//print_r($_REQUEST);print_r ($id);
		$campid=@$_REQUEST['cid'];
		$arr = explode("-",$campid);
		//echo "<br>";echo $arr['0'];
	    //echo "<br>";echo $arr['1'];
		$users_id = $this->session->userdata('LOGIN_USER');
		$usernm = $this->session->userdata('LOGIN_USER_NAME');
		
		/*$rec	= false;
	 $sql	= "SELECT * FROM serp_users_campaign_master WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	    if(is_array($rec) && count($rec) > 0){
		for($i=0; $i<count($rec); $i++){
		    $sql	= '';
		    $query	= '';
		     $sql	= "SELECT * FROM  serp_users_campaign_detail WHERE c_id = '".$rec[$i]['campaign_id']."'";
		    $query	= $this->db->query($sql);
		    if($query->num_rows() > 0){
			$rec2			= $query->result_array();
			$rec[$i]['total_campaign']	= $query->num_rows();
			$rec[$i]['campaigns']	= $rec2;
			if(is_array($rec2) && count($rec2) > 0){
			    for($j=0; $j<count($rec2); $j++){*/

	      if((isset($_REQUEST['sid'])=='') && (isset($_REQUEST['cid'])==''))
			{	 
				 $sqlRank	= "SELECT * FROM serp_google_crawl_data a, serp_users_campaign_keywords b WHERE  a.campaign_id = a.campaign_id AND a.keyword_id = b.keyword_id
					AND b.users_id ='".$users_id."' GROUP BY a.keyword ORDER BY b.keyword_id DESC	LIMIT 3";
				//echo $sqlRank;
				$queryRank	= $this->db->query($sqlRank);
				 
				if($queryRank->num_rows() > 0){
				    $rec = $queryRank->result_array();
				} 

			}
				 
			if((@$_REQUEST['sid']=='google') && (isset($_REQUEST['cid'])!=''))
			{	 //echo "<br>";echo "google".$_REQUEST['sid'];
				// get google rank
				$sqlRank	= "SELECT * FROM serp_google_crawl_data a, serp_users_campaign_keywords b WHERE a.campaign_id = a.campaign_id AND a.keyword_id = b.keyword_id
					AND b.users_id ='".$users_id."' GROUP BY a.keyword ORDER BY b.keyword_id DESC	LIMIT 3";
				//echo $sqlRank;
				$queryRank	= $this->db->query($sqlRank);
				 
				if($queryRank->num_rows() > 0){
				    $rec = $queryRank->result_array();
				}
				 		 
			} 
			
			// get yahoo rank
			if((@$_REQUEST['sid']=='yahoo') && (isset($_REQUEST['cid'])!=''))
			{	//echo "<br>"; echo "yahoo".$_REQUEST['sid'];
				$sqlRank	= "SELECT * FROM serp_yahoo_crawl_data a, serp_users_campaign_keywords b WHERE a.campaign_id = a.campaign_id AND a.keyword_id = b.keyword_id
					AND b.users_id ='".$users_id."' GROUP BY a.keyword ORDER BY b.keyword_id DESC	LIMIT 3";
				//echo $sqlRank;
				$queryRank	= $this->db->query($sqlRank);
				 
				if($queryRank->num_rows() > 0){
				    $rec = $queryRank->result_array();
				}
				 	 
			}

			// get bing rank
			if((@$_REQUEST['sid']=='bing') && (isset($_REQUEST['cid'])!=''))
			{   //echo "<br>";echo "bing".$_REQUEST['sid'];
				$sqlRank	= "SELECT * FROM serp_bing_crawl_data a, serp_users_campaign_keywords b WHERE a.campaign_id = a.campaign_id AND a.keyword_id = b.keyword_id
					AND b.users_id ='".$users_id."' GROUP BY a.keyword ORDER BY b.keyword_id DESC	LIMIT 3";
				 
				$queryRank	= $this->db->query($sqlRank);
				 
				if($queryRank->num_rows() > 0){
				    $rec = $queryRank->result_array();
				}
				
				 
			} 
				return @$rec; 
			    //}
			//}
		    //} 
		     
		//}
	    //}
	 
	    return $rec;
      }

      public function getDetailKeywordInfo($id) {
			//print_r($_REQUEST);print_r ($id);
      		$userid = $this->session->userdata('LOGIN_USER');
			$usernm = $this->session->userdata('LOGIN_USER_NAME'); 
			$campid=@$_REQUEST['cid'];
			$arr = explode("-",$campid);
			//echo "<br>";echo "arr0".$arr['0'];
		    //echo "<br>";echo "arr1".$arr['1']; 
			 
			if (isset($campid)!='' && isset($arr['0'])!='' && isset($arr['1'])=='') {
				$sql = "SELECT * FROM `serp_users_campaign_detail` where  campaign_id='".$arr['0']."' and users_id='".$userid."' GROUP BY campaign_id";	
				//echo "<br>";echo "2";
				$campid=$_REQUEST['cid'];
				$arr = explode("-",$campid);
				//echo "<br>";echo $arr['0'];
		   		//echo "<br>";echo $arr['1'];
			}
			elseif (isset($campid)=='' && isset($_REQUEST['sid'])=='') {
				  $sql = "SELECT * FROM `serp_users_campaign_detail` where  campaign_id='1' and users_id='".$userid."' GROUP BY campaign_id";	
				//echo "<br>";echo "1--shas";
				//echo "<br>";echo $campid='1';
				//$arr['1']='1';
			}
			else
			{
				$sql = "SELECT * FROM `serp_users_campaign_detail` where  campaign_id='".$arr['1']."' and users_id='".$userid."' GROUP BY campaign_id";	
				//echo "<br>";echo "222";
				$campid=$_REQUEST['cid'];
				$arr = explode("-",$campid);
				//echo "<br>";echo $arr['0'];
		   		//echo "<br>";echo $arr['1'];
			} 

			 

		   $query = $this->db->query($sql);
			if($query->num_rows() > 0){
			    $rec =$query->row(); 
			}
			return $rec;
		  }




}     
