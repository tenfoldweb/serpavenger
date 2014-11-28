<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_mypannel extends CI_Model{

public function __construct(){        
        // Call the Model constructor
        parent::__construct();
    }

//function to fetch all students record
function getUsersdetail($users_id){
 $this->db->select('*');
 $this->db->from('am_user');
 $this->db->where('user_id', $users_id);
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row[0];  
 }

function getUsersupdate($users_id)
{
	$data=array(
            'email'=>$this->input->post('users_email'),
            'pass'=>$this->input->post('users_password'),
           
            );
        $this->db->where('user_id', $users_id);
        $this->db->update('am_user', $data);
}

function getnetworkcount($users_id)
{
 $this->db->select("COUNT(network_name) as networkcount");
 $this->db->from('networks');
 $this->db->where('users_id', $users_id);
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row[0]->networkcount;  
}

function getdomaincount($users_id)
{
 $this->db->select("COUNT(domainname) as domaincount");
 $this->db->from('domains');
 $this->db->where('users_id', $users_id);
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row[0]->domaincount;  
}

function getpostcount($users_id)
{
 $this->db->select("COUNT(post_name) as postcount");
 $this->db->from('campaign_posts');
 $this->db->where('user_id', $users_id);
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row[0]->postcount;  
}

function getlinkcount($users_id)
{
 $this->db->select("COUNT(link1) as linkcount");
 $this->db->from('campaign_posts');
 $this->db->where('user_id', $users_id);
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row[0]->linkcount;  
}

function getseocount($users_id)
{
 $this->db->select("COUNT(campaign_id) as getseocount");
 $this->db->from('serp_seo_ranking');
 $this->db->where('user_id', $users_id);
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row[0]->getseocount;  
}

function getnetworklist($users_id)
{
 $this->db->select("id,network_name");
 $this->db->from('networks');
 $this->db->where('users_id', $users_id);
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row; 
}
function getcampaignlist($users_id,$campaign_status='')
{
 $this->db->select("COUNT(campaign_title) as campaigncount");
 $this->db->from('serp_users_campaign_master');
 $this->db->where('users_id', $users_id);
 $this->db->where('campaign_status','active');
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row[0]->campaigncount;
}

function getcampaignlistmoney($users_id,$campaign_status='')
{
 $this->db->select("COUNT(campaign_site_type) as campaigncountmoney");
      $this->db->from('serp_users_campaign_detail');
     
      $this->db->where('serp_users_campaign_detail.campaign_site_type',1);
      $this->db->where('serp_users_campaign_detail.users_id',$users_id);
      //$this->db->get('', $this->limit, $this->offset);
      $query = $this->db->get();
      $result = $query->result();
      $row = $query->result();
      return $row[0]->campaigncountmoney;
 
}

function getcampaignlistpara($users_id,$campaign_status='')
{
 $this->db->select("COUNT(campaign_site_type) as campaigncountpara");
      $this->db->from('serp_users_campaign_detail');
     
      $this->db->where('serp_users_campaign_detail.campaign_site_type',2);
      $this->db->where('serp_users_campaign_detail.users_id',$users_id);
      //$this->db->get('', $this->limit, $this->offset);
      $query = $this->db->get();
      $result = $query->result();
      $row = $query->result();
      return $row[0]->campaigncountpara;
 
  
}

/*function getcampaignlistseotest($users_id,$campaign_status='')
{
 $this->db->select("COUNT(campaign_site_type) as campaigncountmoney");
      $this->db->from('serp_users_campaign_detail');
      $this->db->where('serp_users_campaign_detail.users_id',$users_id);
      //$this->db->get('', $this->limit, $this->offset);
      $query = $this->db->get();
      $result = $query->result();
      $row = $query->result();
      return $row[0]->campaigncountmoney;
 
}*/

function getcampaign_name($users_id,$campaign_status='')
{
 $this->db->select("campaign_id,campaign_main_keyword");
 $this->db->from('serp_users_campaign_detail');
 $this->db->where('users_id', $users_id);
 echo $getcampaign_name;
 $query = $this->db->get();
 $result = $query->result();
 $row = $query->result();
 return $row; 
}


function getsitecount($users_id,$campaign_status='')
{
	  $this->db->select("COUNT(campaign_main_page_url) as site_count");
      $this->db->from('serp_users_campaign_detail');
      $this->db->join('serp_users_campaign_master','serp_users_campaign_detail.c_id=serp_users_campaign_master.campaign_id');
      $this->db->where('serp_users_campaign_master.campaign_status',active);
      $this->db->where('serp_users_campaign_detail.users_id',$users_id);
      //$this->db->get('', $this->limit, $this->offset);
      $query = $this->db->get();
      $result = $query->result();
      $row = $query->result();
      return $row[0]->site_count;
}

function getkeywordcount($users_id,$campaign_status='')
{
	  $this->db->select("COUNT(campaign_main_keyword) as keyword_count");
      $this->db->from('serp_users_campaign_detail');
      $this->db->join('serp_users_campaign_master','serp_users_campaign_detail.c_id=serp_users_campaign_master.campaign_id');
      $this->db->where('serp_users_campaign_master.campaign_status',active);
      $this->db->where('serp_users_campaign_detail.users_id',$users_id);
      //$this->db->get('', $this->limit, $this->offset);
      $query = $this->db->get();
      $result = $query->result();
      $row = $query->result();
      return $row[0]->keyword_count;
}

public function getActiveCampaignList()
    {
      $result_array = array();

      $user_id=$this->session->userdata("LOGIN_USER");
      $sql = "SELECT campaign_id,campaign_title FROM serp_users_campaign_master WHERE users_id = '".$user_id."' AND campaign_status = 'Active'";
      $qry = $this->db->query($sql);
      if($qry->num_rows()>0)
      {
          $rs = $qry->result_array();         
          foreach($rs as $res){
            
            $c_id = $res['campaign_id'];
            $sl = "SELECT campaign_site_type,campaign_main_page_url FROM serp_users_campaign_detail WHERE c_id = '".$c_id."'";
            $qr = $this->db->query($sl);
            if($qr->num_rows()>0){
                $row = $qr->result_array();
                foreach( $row as $r=>$data){
//                    echo $data['campaign_main_page_url'];
                      $main_page = parse_url($data['campaign_main_page_url']); 
                      if($data['campaign_site_type'] == 1)
                      {
                                                
                        $result_array[$res['campaign_title']]['moneysite'][] = $main_page['host'];
                      }
                      else
                      {
                        $result_array[$res['campaign_title']]['parasite'][] = $main_page['host'];
                        
                      }
                  }
            }
            
          }
      }
      
      return $result_array;
    }

    public function getslidershrinkweb($users_id)
    {
       
      //Edited by BEAS - Fetching logged in user id
    
    //$user_id=$this->session->userdata("LOGIN_USER");
    
    $session = $this->session->userdata('user_data');
    $user_id = $session['user_id'];
    
    //Edited by BEAS

    
    
    $rec      = FALSE;
    $record     = FALSE;
   /* if(!empty($campaign_list) && $campaign_list != 'Show All Combined'){
      $sql = "SELECT * FROM `serp_users_campaign_detail` WHERE campaign_main_keyword = '".$campaign_list."' AND users_id = '".$user_id."'";
    }else{
      $sql = "SELECT * FROM `serp_users_campaign_detail` WHERE users_id = '".$user_id."' limit 1";
    }*/
      $sql = "SELECT users_id,campaign_murl_thumb,campaign_main_page_url,campaign_murl_domain 
       FROM `serp_users_campaign_detail` WHERE users_id = '".$user_id."'";
    //echo $sql;
    //die();
     $query = $this->db->query($sql);
      if($query->num_rows() > 0){
         $rec = $query->result_array();   
         // echo "<pre>";print_r ($rec);
           /*$campaign_murl_thumb = $rec['campaign_murl_thumb']; 
     $murl =$rec['campaign_murl_domain'];
    //print_r($murl);
     $API_URL = "http://images.shrinktheweb.com/xino.php?stwu=c1871&stwxmax=320&stwymax=240&stwaccesskeyid=37c50d761e16b0b&stwurl=".$murl;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $oDOM = new DOMDocument;
    $oDOM->loadXML($output);
    $sXML = simplexml_import_dom($oDOM);
    $sXMLLayout = 'http://www.shrinktheweb.com/doc/stwresponse.xsd';

    // Pull response codes from XML feed
    $aThumbnail = (array)$sXML->children($sXMLLayout)->Response->ThumbnailResult->Thumbnail;
    $rec = $aThumbnail;*/ 
      }
      return $rec;
     
    }
  function get_network_list_data($id,$limit, $start)
  { 
		$session = $this->session->userdata('user_data');
		$this->db->limit($limit, $start);
		$this->db->select("*");
		$this->db->from('domains');
		$this->db->join('serp_assign_domains', 'serp_assign_domains.domain_id = domains.domainid', 'left');
		$this->db->where('serp_assign_domains.network_id', $id);
		$this->db->where('serp_assign_domains.users_id', $session['user_id']);
		$query = $this->db->get();
		
		$result = $query->result();

		return $result;

  }
  function get_network_list_data_all($id,$limit, $start)
  { 
		$session = $this->session->userdata('user_data');
		$this->db->select("*");
		$this->db->from('domains');
		$this->db->join('serp_assign_domains', 'serp_assign_domains.domain_id = domains.domainid', 'left');
		$this->db->where('serp_assign_domains.network_id', $id);
		$this->db->where('serp_assign_domains.users_id', $session['user_id']);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
	  
	    //echo $this->db->last_query(); die;
       $result = $query->result();
     //print_r($result); die;
      return $result;

  }
  function get_network_list_data_count($id)
  { 
		$session = $this->session->userdata('user_data');
		$this->db->select("domainname");
		$this->db->from('domains');
		$this->db->join('serp_assign_domains', 'serp_assign_domains.domain_id = domains.domainid', 'left');
		$this->db->where('serp_assign_domains.network_id', $id);
		$this->db->where('serp_assign_domains.users_id', $session['user_id']);
		$query = $this->db->get();
		//  echo $this->db->last_query(); die;
		$result = $query->result();
		$num = count($result);
      
	  return $num;

  }

    public function getcampaignlistuser($users_id)
    {       
      //Edited by BEAS - Fetching logged in user id
      //$user_id=$this->session->userdata("LOGIN_USER");
    
      $session = $this->session->userdata('user_data');
      $user_id = $session['user_id'];
       
      //Edited by BEAS 
      
      $rec      = FALSE;
      $record     = FALSE;
     
      $sql = "SELECT  campaign_title,keyword,keyword_type,campaign_main_page_url,campaign_main_keyword,campaign_murl_domain,campaign_murl_thumb,campaign_site_type, COUNT( * ) as para, COUNT( keyword ) AS 
keywordcnt  FROM serp_users_campaign_keywords a, serp_users_campaign_detail b, 
serp_users_campaign_master c WHERE a.campaign_id = b.campaign_id AND a.
campaign_id = c.campaign_id AND c.campaign_id = b.campaign_id AND campaign_site_type IN ('1', '2') AND a.users_id = b.users_id AND a.users_id = c.users_id AND c.users_id = b.users_id AND b.users_id ='".$user_id."'
  GROUP BY a.campaign_id";
    //echo $sql;
    //die();
     $query = $this->db->query($sql);
      if($query->num_rows() > 0){
         $rec = $query->result_array();   
          
      }
      return $rec;
     
    }

    function getsinglelist($users_id,$campaign_status='')
    {

      $session = $this->session->userdata('user_data');
      $user_id = $session['user_id'];
       
      //Edited by BEAS 
      
      $rec      = FALSE;
      $record     = FALSE;
      $sql = "SELECT  campaign_title,keyword,keyword_type,campaign_main_page_url,campaign_main_keyword,campaign_murl_domain,campaign_murl_thumb,campaign_site_type, COUNT( * ) as para, COUNT( keyword ) AS 
keywordcnt  FROM serp_users_campaign_keywords a, serp_users_campaign_detail b, 
serp_users_campaign_master c WHERE a.campaign_id = b.campaign_id AND a.
campaign_id = c.campaign_id AND c.campaign_id = b.campaign_id AND campaign_site_type IN ('1', '2') AND a.users_id = b.users_id AND a.users_id = c.users_id AND c.users_id = b.users_id AND b.users_id ='".$user_id."'";
    //echo $sql;
    //die();
     $query = $this->db->query($sql);
      if($query->num_rows() > 0){
         $rec = $query->result_array();   
          
      }
      return $rec;
      }

function getToplvslisting_count($userid){

  $top_array = array();
  $sql = "SELECT campaign_id,campaign_title FROM serp_users_campaign_master WHERE users_id = '".$userid."' AND campaign_status = 'Active'  ";
      $qry = $this->db->query($sql);
     // echo($qry->num_rows);
      if($qry->num_rows()>0)
      {
          $rs = $qry->result_array();         
          foreach($rs as $res){
$c_id = $res['campaign_id'];
 $sql = "SELECT  *  FROM serp_screenshot_thumbs WHERE user_id = '".$userid."' and campaign_id = '".$c_id."'  ";
          //echo $sql;
         // exit();
          
$qr = $this->db->query($sql);
            if($qr->num_rows()>0){
                $row = $qr->result_array();
                foreach( $row as $rows){                                          
                        $top_array[] = $rows;                     
                  }
            }
        }
      }
      return count($top_array); 
}
function getToplvslisting($userid){
 $top_array = array();
  //$sql = "SELECT campaign_id,campaign_title FROM serp_users_campaign_master WHERE users_id = '".$userid."' AND campaign_status = 'Active'  ";
     // $qry = $this->db->query($sql);
     // echo($qry->num_rows);
      //if($qry->num_rows()>0)
      //{
         // $rs = $qry->result_array();         
         // foreach($rs as $res){
$c_id = $res['campaign_id'];
 $sql = "SELECT  *  FROM serp_screenshot_thumbs WHERE user_id = '".$userid."'  ";
         // echo $sql;
          //exit();
          
$qr = $this->db->query($sql);
            if($qr->num_rows()>0){
                $row = $qr->result_array();
                foreach( $row as $rows){                                          
                        $top_array[] = $rows;                     
                  }
            }
        //}
     // }
     // print_r($top_array);
      //exit();
          return $top_array; 




}


      function getcampaign_namedetail($users_id,$campaign_status='')
      {
          $session = $this->session->userdata('user_data');
          $user_id = $session['user_id'];
          //Edited by BEAS 
          $rec      = FALSE;
          $sql = "SELECT  *, COUNT( * ) as para, COUNT( keyword ) AS 
keywordcnt  FROM serp_users_campaign_keywords a, serp_users_campaign_detail b, 
serp_users_campaign_master c WHERE a.campaign_id = b.campaign_id AND a.
campaign_id = c.campaign_id AND c.campaign_id = b.campaign_id AND campaign_site_type IN ('1', '2') AND a.users_id = b.users_id AND a.users_id = c.users_id AND c.users_id = b.users_id AND b.users_id ='".$user_id."'  limit 1 ";
          //echo $sql;
          //die();
          $query = $this->db->query($sql);
          $result = $query->result();
          $row = $query->result();
          return $row; 
          }

      function getcampaign_fullimagedet($users_id)
      {
            $session = $this->session->userdata('user_data');
            $user_id = $session['user_id'];
            //Edited by BEAS 
            $rec      = FALSE;
            $sql = "SELECT  *   FROM serp_users_campaign_keywords a, serp_users_campaign_detail b  WHERE a.campaign_id = b.campaign_id  AND a.users_id = b.users_id  AND b.users_id ='".$user_id."' and campaign_site_type IN ('1', '2') limit 3";
            //echo $sql;
            //die();
            $query = $this->db->query($sql);
            if($query->num_rows() > 0){
            $rec = $query->result_array();   

            }
          return $rec; 
      }  


       function getsitemainkw($users_id)
      {
            $session = $this->session->userdata('user_data');
            $user_id = $session['user_id'];
            //Edited by BEAS 
            $rec      = FALSE;
            $sql = "SELECT  count(keyword_type) as mkw,keyword   FROM serp_users_campaign_keywords  a, serp_users_campaign_detail b  WHERE a.campaign_id = b.campaign_id  AND a.users_id = b.users_id  AND b.users_id ='".$user_id."' and keyword_type='S' group by keyword limit 1";
            //echo $sql;
            //die();
            $query = $this->db->query($sql);
           $result = $query->result();
            $row = $query->result();
           return $row; 
      } 

      function getsiteseckw($users_id)
      {
            $session = $this->session->userdata('user_data');
            $user_id = $session['user_id'];
            //Edited by BEAS 
            $rec      = FALSE;
            $sql = "SELECT  count(keyword_type) as skw,keyword   FROM serp_users_campaign_keywords a, serp_users_campaign_detail b  WHERE a.campaign_id = b.campaign_id  AND a.users_id = b.users_id  AND b.users_id ='".$user_id."' and keyword_type='M' group by keyword limit 1";
           // echo $sql;
            //die();
           $query = $this->db->query($sql);
            $result = $query->result();
            $row = $query->result();
            return $row; 
      } 

      function getkeywordsitese($users_id)
      {
            $session = $this->session->userdata('user_data');
            $user_id = $session['user_id'];
            //Edited by BEAS 
            $rec      = FALSE;
            $sql = "SELECT  count(keyword_type) as tkw,keyword   FROM serp_users_campaign_keywords a, serp_users_campaign_detail b  WHERE a.campaign_id = b.campaign_id  AND a.users_id = b.users_id  AND b.users_id ='".$user_id."'  group by keyword limit 1";
           // echo $sql;
            //die();
           $query = $this->db->query($sql);
            $result = $query->result();
            $row = $query->result();
            return $row; 
      }

      function deepanlymainkw($users_id)
      {
            $session = $this->session->userdata('user_data');
            $user_id = $session['user_id'];
            //Edited by BEAS 
            $rec      = FALSE;
            $sql = "SELECT  a.analyzed  as analyzed  FROM serp_users_campaign_keywords a, serp_users_campaign_detail b  WHERE a.campaign_id = b.campaign_id  AND a.users_id = b.users_id  AND b.users_id ='".$user_id."' and keyword_type='M' group by keyword limit 1 ";
           //echo $sql;
            //die();
           $query = $this->db->query($sql);
            $result = $query->result();
            $row = $query->result();
            return $row; 
      }  
  
      function deepanlyseckw($users_id)
      {
            $session = $this->session->userdata('user_data');
            $user_id = $session['user_id'];
            //Edited by BEAS 
            $rec      = FALSE;
            $sql = "SELECT  a.analyzed  as analyzed   FROM serp_users_campaign_keywords a, serp_users_campaign_detail b  WHERE a.campaign_id = b.campaign_id  AND a.users_id = b.users_id  AND b.users_id ='".$user_id."' and keyword_type='S' group by keyword limit 1 ";
            //echo $sql;
            //die();
           $query = $this->db->query($sql);
            $result = $query->result();
            $row = $query->result();
            return $row; 
      } 

       function autolinkprofile($users_id)
      {
            $session = $this->session->userdata('user_data');
            $user_id = $session['user_id'];
            //Edited by BEAS 
            $rec      = FALSE;
            $sql = "SELECT DISTINCT (profilelink) FROM serp_users_campaign_detail WHERE users_id ='".$user_id."'
GROUP BY campaign_murl_domain";
            //echo $sql;
            //die();
           $query = $this->db->query($sql);
            $result = $query->result();
            $row = $query->result();
            return $row; 
      }        
		function Update_domain_thumb($thumb=null,$domain_id=null){
		
		
		 $sql = "UPDATE `domains` SET `thumb` = '".$thumb."' WHERE `domainid` = '".$domain_id."'";
            
           $query = $this->db->query($sql);
			
		}


}