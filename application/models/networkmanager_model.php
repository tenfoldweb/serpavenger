<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Networkmanager_model extends CI_Model {

 public function __construct()
 {
  parent::__construct();
  $this->load->helper('dom');
 }
 
 public function fetch_networks()
 {
 	 $session = $this->session->userdata('user_data');
 	 $uid=$session['user_id'];
 	 
	 $retarr = array();
	 
	 $query = $this->db->select("*")->from("networks")->where('users_id',$uid)->get();
	 
	 if($query->num_rows() > 0)
			{
    			foreach($query->result() as $row)
				{
					$count = $this->db->select('*')->from('serp_assign_domains')->where('network_id',$row->id)->where('users_id',$uid)->get();
		            $num_rows = $count->num_rows();	
					
					$retarr[$row->id] = array('networkname' => $row->network_name, 'domcount' => $num_rows);
				}
			}
	 
	 return $retarr;
 }
 
 public function count_user_domains($uid)
 {
	 $count = $this->db->select("*")->from("domains")->where('users_id',$uid)->get();
	 $domain_count = $count->num_rows();

	 return $domain_count;	  
 }

 public function fetch_domains()
 {
	 $session = $this->session->userdata('user_data');
	 $retarr = array();
	 
	 $query = $this->db->select("*")->from("domains")->where('users_id',$session['user_id'])->get();
	 
	 if($query->num_rows() > 0)
			{
    			foreach($query->result() as $row)
				{
					$netid = "";
					$networks = $this->db->select('network_id')->from("serp_assign_domains")->where('domain_id',$row->domainid)->where('users_id',$session['user_id'])->get();
					
					foreach($networks->result() as $net)
					{
						$netid .= "nid".$net->network_id."_";
					}
					
					$retarr[$row->domainid] = array('domainname' => $row->domainname, 'networkid' => $netid, 'domainexpiry' => $row->domainexpiry, 
					'blogtype' => $row->cmstype, 'indexed' => $row->indexed, 'nowindex' => $row->nowindex, 'pagerank' => $row->pagerank, 'pageranknow' => $row->pageranknow,
					 'ahrefstat' => $row->ahrefstat);
				}
			}
	 
	 return $retarr;
 }

 public function default_network_setting($uid)
 {
	 $retarr = array();
	 $domains = array();
	 $domains = $this->fetch_domains();

	$res = $this->db->select("*")->from("network_settings")->where("uid",$uid)->get();
	
	$count_res = $res->num_rows();
	 
	 if(!($count_res > 0))
	 { 
		$default_settings = array('uid' => $uid,
		'default_blog' => 'Traditional Blog',
		'default_network' => 1,
		'index_frequency' => 'Monthly',
		'backlink_stat' => 0,
		'backlink_update' => 0,
		'backlink_count' => 0,
		'domain_rank' => 0,
		'referring_domains' => 0,
		'ahrefs_frequency' => 'Weekly',
		'page_rank' => 'Weekly',
		'index_date' => NULL,
		'ahrefs_date' => NULL,
		'pr_date' => NULL);
		
		$this->db->insert('network_settings',$default_settings);
     }

	 $query = $this->db->select("*")->from("network_settings")->where("uid",$uid)->join('networks', 'networks.id = network_settings.default_network')->get();
	 
	 if($query->num_rows() > 0)
			{
    			foreach($query->result() as $row)
				{
					$retarr = array('defaultblog' => $row->default_blog,
					'defaultnetwork' => $row->id,
					'indexfrequency' => $row->index_frequency,
					'pauseposting' => $row->pause_posting,
					'backlinkstat' => $row->backlink_stat,
					'backlinkupdate' => $row->backlink_update,
					'accesstoken' => $row->access_token,
					'expiresin' => $row->expires_in,
					'backlinkcount' => $row->backlink_count,
					'domainrank' => $row->domain_rank,
					'referringdomains' => $row->referring_domains,
					'ahrefsfrequency' => $row->ahrefs_frequency,
					'pagerank' => $row->page_rank,
					'indexdate' => $row->index_date,
					'ahrefsdate' => $row->ahrefs_date,
					'prdate' => $row->pr_date);
				}
			}
			
					if($retarr['backlinkstat'] == 1 && $retarr['backlinkupdate'] == 1)
					{
						if(count($domains) > 0)
						{
							foreach($domains as $key=>$doms)
							{
								if($doms['ahrefstat'] == 0)
								{
								  $data = array();
								  
								  $data['ahrefstat'] = 1;
								  $data['backlinks'] = $this->fetch_backlinks($retarr['accesstoken'], $doms['domainname']);
								  $data['domainrank'] = $this->fetch_domain_rank($retarr['accesstoken'], $doms['domainname']);
								  $data['referringdomains'] = $this->fetch_referring_domains($retarr['accesstoken'], $doms['domainname']);
								 
		
								 /* on error -                  HTTP code = 401
																error = invalid_token
																error_description = The access token provided has expired
								 
									 $settings['backlink_stat'] = 0;
									 $settings['backlink_update'] = 0;
									 $this->update_settings($settings, $uid);
									 redirect('networkmanager/ahrefsdata');
									 break;
								  */
								  
								  $this->db->update("domains", $data, array('domainid' => $key)); 
								}
							}
						}
						
						$updateval = array();
						$updateval['backlink_update'] = 0;
						
						$this->db->update("network_settings", $updateval, array('uid' => $uid));
					}
					
					
					//schedule job settings for networkmanager

					$updateindex = false;
					$updateahrefs = false;
					$updatepr = false;
					$indexdt = explode(" ", $retarr['indexdate']);
					$ahrefsdt = explode(" ", $retarr['ahrefsdate']);
					$prdt = explode(" ", $retarr['prdate']);
					$datetime1 = new DateTime(date('Y-m-d'));
					
					//indexing
					if($retarr['indexfrequency'] == "Weekly")
					{
						$nextweek = date('Y-m-d', strtotime("+1 week", strtotime($indexdt[0])));

						$datetime2 = new DateTime($nextweek);
						$interval = $datetime1->diff($datetime2);
						
						if($interval->days == 0)
						 $updateindex = true;
					}
					
					if($retarr['indexfrequency'] == "Monthly")
					{
						$nextmonth = date('Y-m-d', strtotime("+1 month", strtotime($indexdt[0])));

						$datetime2 = new DateTime($nextmonth);
						$interval = $datetime1->diff($datetime2);
						
						if($interval->days == 0)
						 $updateindex = true;
					}
					
					if($retarr['indexfrequency'] == "Never")
					  $updateindex = false;
					
					if($updateindex)
					{
						foreach($domains as $key=>$doms)
						{
							$save = array();
							$save['indexed'] = $doms['nowindex'];
							$this->db->update("domains", $save, array('domainid' => $key)); 
						}
						
						$updateval = array();
						$updateval['index_date'] = date('Y-m-d');
						
						$this->db->update("network_settings", $updateval, array('uid' => $uid));
					}

					//ahrefs frequency
					if($retarr['ahrefsfrequency'] == "Once")
					{
						$nextday = date('Y-m-d', strtotime("+1 day", strtotime($ahrefsdt[0])));

						$datetime2 = new DateTime($nextday);
						$interval = $datetime1->diff($datetime2);
						
						if($interval->days == 0)
						 $updateahrefs = true;
					}
					
					if($retarr['ahrefsfrequency'] == "Weekly")
					{
						$nextweek = date('Y-m-d', strtotime("+1 week", strtotime($ahrefsdt[0])));

						$datetime2 = new DateTime($nextweek);
						$interval = $datetime1->diff($datetime2);
						
						if($interval->days == 0)
						 $updateahrefs = true;
					}
					
					if($retarr['ahrefsfrequency'] == "Monthly")
					{
						$nextmonth = date('Y-m-d', strtotime("+1 month", strtotime($ahrefsdt[0])));

						$datetime2 = new DateTime($nextmonth);
						$interval = $datetime1->diff($datetime2);
						
						if($interval->days == 0)
						 $updateahrefs = true;
					}
					
					if($retarr['ahrefsfrequency'] == "Never")
					  $updateahrefs = false;
					
					if($updateahrefs)
					{
						foreach($domains as $key=>$doms)
						{
							$save = array();

							$save['backlinks'] = $doms['backlinksnow'];
			                $save['domainrank'] = $doms['domainranknow'];
			                $save['referringdomains'] = $doms['referringdomainsnow'];
							
							$this->db->update("domains", $save, array('domainid' => $key)); 
						}
						
						$updateval = array();
						$updateval['ahrefs_date'] = date('Y-m-d');
						
						$this->db->update("network_settings", $updateval, array('uid' => $uid));
					}

					//pagerank
					if($retarr['pagerank'] == "Once")
					{
						$nextday = date('Y-m-d', strtotime("+1 day", strtotime($prdt[0])));

						$datetime2 = new DateTime($nextday);
						$interval = $datetime1->diff($datetime2);
						
						if($interval->days == 0)
						 $updatepr = true;
					}
					
					if($retarr['pagerank'] == "Monthly")
					{
						$nextmonth = date('Y-m-d', strtotime("+1 month", strtotime($prdt[0])));

						$datetime2 = new DateTime($nextmonth);
						$interval = $datetime1->diff($datetime2);
						
						if($interval->days == 0)
						 $updatepr = true;
					}
					
					if($retarr['pagerank'] == "Never")
					  $updatepr = false;
					  
					if($updatepr)
					{
						foreach($domains as $key=>$doms)
						{
							$save = array();
							$save['pagerank'] = $doms['pageranknow'];
							$this->db->update("domains", $save, array('domainid' => $key)); 
						}
						
						$updateval = array();
						$updateval['pr_date'] = date('Y-m-d');
						
						$this->db->update("network_settings", $updateval, array('uid' => $uid));
					}
			
			return $retarr;
 }
 
 public function fetch_details($id="",$val="")
 {
	 $session = $this->session->userdata('user_data');
     $uid = $session['user_id'];
	 
	 $retarr = array();

		if($id == "" && $val == "")
		{
			 $query = $this->db->select("*")->from("domains")->where('domains.users_id',$uid)
			 ->join('serp_assign_domains', 'serp_assign_domains.domain_id = domains.domainid')->where('serp_assign_domains.users_id',$uid)
			 ->join('networks', 'networks.id = serp_assign_domains.network_id')->where('networks.users_id',$uid)->get();
		}
		elseif($id != "")
		{
			$query = $this->db->select("*")->from("domains")->where('domains.users_id',$uid)->where('domains.domainid',$id)
			 ->join('serp_assign_domains', 'serp_assign_domains.domain_id = domains.domainid')->where('serp_assign_domains.users_id',$uid)
			 ->join('networks', 'networks.id = serp_assign_domains.network_id')->where('networks.users_id',$uid)->get();
		}
		else
		{
			$query = $this->db->select("*")->from("domains")->where('domains.users_id',$uid)->where('domains.domainname',$val)
			 ->join('serp_assign_domains', 'serp_assign_domains.domain_id = domains.domainid')->where('serp_assign_domains.users_id',$uid)
			 ->join('networks', 'networks.id = serp_assign_domains.network_id')->where('networks.users_id',$uid)->get();
		}

    		if($query->num_rows() > 0)
			{
    			foreach($query->result() as $row)
				{
					$retarr[$row->domainid] = array('networkid' => $row->id,
					'networkname' => $row->network_name,
					'type' => $row->type,
					'cms' => $row->cmstype,
					'domain' => $row->domainname,
					'pagerank' => $row->pagerank,
					'age' => $row->age,
					'domainip' => $row->domainip,
					'dns' => $row->dns,
					'domainregistrar' => $row->domainregistrar,
					'domainexpiry' => $row->domainexpiry,
					'obl' => $row->obl,
					'username' => $row->username,
					'password' => $row->password,
					'status' => $row->status,
					'indexed' => $row->indexed,
					'ahrefstat' => $row->ahrefstat,
					'backlinks' => $row->backlinks,
					'domainrank' => $row->domainrank,
					'referringdomains' => $row->referringdomains,
					'valid_credentials' => $row->valid_credentials);
						
					
					 $getposts = $this->db->select("*")->from("campaign_posts")->where('domain_id', $row->domainid)->get();
					 
					 if($getposts->num_rows() > 0)
			         {
						 $postarr = array();
						 
						foreach($getposts->result() as $rowresult)
						{
							$setpostdt = array();
							$setmodifieddt = array();
							
							if($rowresult->post_date != "")
							{
							$postdate = explode(" ",$rowresult->post_date);
							$setpostdt = explode("-",$postdate[0]);
							}
							
							if($rowresult->post_modified != "")
							{
							$modifieddate = explode(" ",$rowresult->post_modified);
							$setmodifieddt = explode("-",$modifieddate[0]);
							}

							$postarr[$rowresult->ID] = array('postid' => $rowresult->ID,
							'posturl' => $rowresult->post_name,
							'postcreated' => $setpostdt[1]."/".$setpostdt[2]."/".$setpostdt[0],
							'postupdated' => $setmodifieddt[1]."/".$setmodifieddt[2]."/".$setmodifieddt[0],
							'postmodified' => $rowresult->post_modified,
							'hp' => $rowresult->hp,
							'sc' => $rowresult->sc,
							'comments' => $rowresult->comment_count,
							'obl' => $rowresult->obl,
							'anchor1' => $rowresult->anchor1,
							'link1' => $rowresult->link1,
							'anchor2' => $rowresult->anchor2,
							'link2' => $rowresult->link2,
							'anchor3' => $rowresult->anchor3,
							'link3' => $rowresult->link3);
						}
						
						$retarr[$row->domainid]['postdetail'] = $postarr;
			         }
				}
			}
			
			return $retarr;
 }
 
 public function fetch_posts($uid, $id='', $stat='')
 {
	 $post['count'] = 0;
	 $post['countlink'] = 0;
	 
	 $domarr = $this->fetch_domains();
	 
	 if($stat == '')
	  $query = $this->db->select("*")->from("campaign_posts")->where('user_id',$uid)->get();
	 if($stat == 'link')
	  $query = $this->db->select("*")->from("campaign_posts")->where('user_id',$uid)->where('ID',$id)->get();  
	 
	 if($query->num_rows() > 0)
	 {
		$countlink = 0;
		$postarr = array();
		$linksearch = array();
    	$post['count'] = $query->num_rows();
		
		foreach($query->result() as $row)
		{
			$postdate = explode(" ",$row->post_date);
			$setpostdt = explode("-",$postdate[0]);
			
			$domainname = "";
			if(isset($domarr[$row->domain_id]['domainname']))
			  $domainname = $domarr[$row->domain_id]['domainname'];

			$postarr[] = array('id' => $row->ID, 'domainid' => $row->domain_id, 'domainname' => $domainname, 'postname' => $row->post_name, 
			'postdate' => $setpostdt[1]."/".$setpostdt[2]."/".$setpostdt[0], 'link1' => $row->link1, 'link2' => $row->link2, 'link3' => $row->link3, 
			'anchor1' => $row->anchor1, 'anchor2' => $row->anchor2, 'anchor3' => $row->anchor3);
			
			if(trim($row->link1) != "")
			{
				$linksearch[] = $row->link1;
			    $countlink++;
			}
			 
			if(trim($row->link2) != "")
			{
				$linksearch[] = $row->link2;
			    $countlink++;
			}
			 
			if(trim($row->link3) != "")
			{
				$linksearch[] = $row->link3;
			    $countlink++;
		    }
		
			if(trim($row->anchor1) != "")
			{
				$linksearch[] = $row->anchor1;
			}
			 
			if(trim($row->anchor2) != "")
			{
				$linksearch[] = $row->anchor2;
			}
			 
			if(trim($row->anchor3) != "")
			{
				$linksearch[] = $row->anchor3;
			}
		}
		
		$linksearch = array_unique($linksearch);
		
		$post['postarr'] = $postarr;
		$post['linksearch'] = $linksearch;
		$post['countlink'] = $countlink;
	 }
	 
	 return $post;
 }
 
 public function update_settings($settings, $uid)
 {
	$this->db->update("network_settings", $settings, array('uid' => $uid));
 }
 
 public function add_new_network($postdata)
 {
	 $this->db->insert('networks',$postdata);
 }
 
 public function get_allowed_domains($uid)
 {
	 $retarr = array();
	 $query = $this->db->select("*")->from("serp_added_user_permission")->where('user_id',$uid)->get();
	 
	 if($query->num_rows() > 0)
	  {
		  foreach($query->result() as $row)
		  {
			  $retarr[] = array('package_id' => $row->package_id, 'max_domain' => $row->max_domain_no, 'max_htmlsite' => $row->max_htmlsite_no, 
			  'max_blogplus' => $row->max_blogplus_no, 'max_blogs' => $row->max_blogs_no);	
		  }
	  }
	  
	  return $retarr;
 }
 
 public function get_default_membership_permissions($uid)
 {
	  $this->db->select('*');
	  $this->db->from('am_user_status');
	  $this->db->join('serp_membership_packages', 'serp_membership_packages.package_id = am_user_status.product_id');
	  $this->db->where('user_id', $uid);
	  $result_user_status = $this->db->get();
	  $result_user_status = $result_user_status->result();
	  
	  return $result_user_status;
 }

 public function add_new_domain($uid, $post_data, $domain_list, $total_domains_allowed)
 {
	 $details = $this->fetch_details();
     $category = $this->fetch_category($uid);

     $status = false;
	 $statarr = array();
	 $save_data = array();
	 $domainsadded = 0;
	 
	 $save_data['cmstype'] = $post_data['type'];
	 $save_data['status'] = 1;
	 $save_data['network_id'] = $post_data['network_id'];
	 $save_data['users_id'] = $uid;

	 foreach($post_data['domarr'] as $domarr)
	 {
	     $num_rows = $this->count_user_domains($uid);

		 if($num_rows < $total_domains_allowed)
		 {
		 $flag = true;
		 if($domarr['domname'] != "" && $domarr['uname'] != "" && $domarr['pass'] != "")
		 {
			 $domarr['domname'] = preg_replace('/\b(https?|ftp|file):\/\/|(www|WWW)./i', '', $domarr['domname']);
			 $domarr['domname'] = str_replace('/', '', $domarr['domname']);
			 
		   if(checkdnsrr($domarr['domname'],'ANY'))
	       {
			   $retarr = $this->set_new_domain($domarr['domname']);
			   
			   $save_data['domainip'] = $retarr['domainip'];
			   $save_data['pagerank'] = $retarr['pagerank'];
			   $save_data['dns'] = $retarr['dns'];
			   $save_data['domainregistrar'] = $retarr['domainregistrar'];
			   $save_data['domainexpiry'] = $retarr['domainexpiry'];
			   $save_data['age'] = $retarr['age'];
			   $save_data['domainname'] = $retarr['domname'];
			   $save_data['obl'] = $this->get_obl($retarr['domname']);
			   $save_data['username'] = $domarr['uname'];
			   $save_data['password'] = $domarr['pass'];
			   $save_data['indexed'] = $this->check_indexing($retarr['domname']);
			   
			   foreach($details as $detail)
			   {
				   if(strtolower(trim($detail['domain'])) == strtolower(trim($save_data['domainname'])))
				   {
					   $flag = false;
					   break;
				   }
			   }
		   
			   if($flag)
			   {
				   $this->db->insert('domains',$save_data);
		
				   $save_assigned = array();
				   $save_assigned['network_id'] = $save_data['network_id'];
				   $save_assigned['users_id'] = $uid;
				   
				   $domaindetails = $this->db->select("domainid")->from("domains")->order_by("domainid", "desc")->limit(1)->get();
				   
				   if($domaindetails->num_rows() > 0)
					{
						foreach($domaindetails->result() as $details)
						{
							$save_assigned['domain_id'] = $details->domainid;
						}
					}
				   $this->db->insert('serp_assign_domains',$save_assigned);
				   
				   exec("bash /home/serpaven/wpposter/run.sh domains ".$save_assigned['domain_id']);

					 if(isset($category['catname']))
					 {
						foreach($category['catname'] as $catg)
						{ 
						  $save['domainid'] = $save_assigned['domain_id'];
						  $save['userid'] = $uid;
						  $save['categoryname'] = $catg['categoryname'];
				
						  $this->db->insert('serp_custom_category',$save);
						}
					 }
					 
					 $domainsadded++;
			   }
		 }
	   }
	  }
	  else
	  {
		  $this->session->set_flashdata('message', '<div class="notification note-error" style="padding-top:7px">
							<a title="Close notification" class="close" href="#">close</a><p>You have reached the maximum limit of adding new domains.</p></div>');

		  redirect('networkmanager');
	  }
	 }
	 
	 if(count($domain_list) > 0)
	 {
		 foreach($domain_list as $list)
		 {
			 $count = $this->db->select("*")->from("domains")->where('users_id',$uid)->get();
	         
			 $num_rows = $count->num_rows();
	 			
			 if($num_rows < $total_domains_allowed)
			 {
		      $flag = true;
			 if($list[0] != "" && $list[1] != "" && $list[2] != "")
			 {
				 $list[0] = preg_replace('/\b(https?|ftp|file):\/\/|(www|WWW)./i', '', $list[0]);
			     $list[0] = str_replace('/', '', $list[0]);
			 
			   if(checkdnsrr($list[0],'ANY'))
	           {
				 $retarr = $this->set_new_domain($list[0]);
				 
				 $save_data['domainip'] = $retarr['domainip'];
				 $save_data['pagerank'] = $retarr['pagerank'];
				 $save_data['dns'] = $retarr['dns'];
				 $save_data['domainregistrar'] = $retarr['domainregistrar'];
				 $save_data['domainexpiry'] = $retarr['domainexpiry'];
				 $save_data['age'] = $retarr['age'];
				 $save_data['domainname'] = $retarr['domname'];
				 $save_data['obl'] = $this->get_obl($retarr['domname']);
				 $save_data['username'] = $list[1];
				 $save_data['password'] = $list[2];
				 $save_data['indexed'] = $this->check_indexing($retarr['domname']);
				 
				 foreach($details as $detail)
				 {
					 if(strtolower(trim($detail['domain'])) == strtolower(trim($save_data['domainname'])))
					 {
						 $flag = false;
						 break;
					 }
				 }
		
				 if($flag)
				 {
				   $this->db->insert('domains',$save_data);
  
					$save_assigned = array();
					$save_assigned['network_id'] = $save_data['network_id'];
					$save_assigned['users_id'] = $uid;
				 
					 $domaindetails = $this->db->select("domainid")->from("domains")->order_by("domainid", "desc")->limit(1)->get();
					 
					 if($domaindetails->num_rows() > 0)
					  {
						  foreach($domaindetails->result() as $details)
						  {
							  $save_assigned['domain_id'] = $details->domainid;
						  }
					  }
					 $this->db->insert('serp_assign_domains',$save_assigned);
					 
					 exec("bash /home/serpaven/wpposter/run.sh domains ".$save_assigned['domain_id']);
  
				   if(isset($category['catname']))
				   { 
					  foreach($category['catname'] as $catg)
					  { 
						$save['domainid'] = $save_assigned['domain_id'];
						$save['userid'] = $uid;
						$save['categoryname'] = $catg['categoryname'];
			  
						$this->db->insert('serp_custom_category',$save);
					  }
				   }
				   
				   $domainsadded++;
				 }
			  }
			 }
		 }
		 else
         {
		  $this->session->set_flashdata('message', '<div class="notification note-error" style="padding-top:7px">
							<a title="Close notification" class="close" href="#">close</a><p>You have reached the maximum limit of adding new domains.</p></div>');
		
		  redirect('networkmanager');
	      }
		 }
	 }
	 
	 if($this->session->userdata('newdomainlist'))
		  $this->session->unset_userdata('newdomainlist');
		  	  
	//$cnt = $this->db->affected_rows();
	 
	 if($domainsadded > 0)
	  $status = true;
	 
	 $statarr['status'] = $status;
	 $statarr['domcnt'] = $domainsadded;
	  
	 return $statarr;
 }
 
 public function set_new_domain($domainname)
 {
	 $arr = array();
	 
	 $url = parse_url($domainname);
	
	 if(!empty($url["host"]))
	   $domain = strtolower($url["host"]);
	 else
	   $domain = strtolower($url["path"]);

	 $domain = str_replace("www.","",$domain);
	 
	 $arr['domname'] = $domain;
	
	 $arr['domainip'] = gethostbyname($domain);
	 
	 $arr['pagerank'] = $this->get_pr($domainname);
	 
	 $whois = $this->get_whois($domainname);
	 
	 $arr['dns'] = strtolower($whois['nameserver']);
	 
	 $arr['domainregistrar'] = $whois['registrar'];
	 
	 $arr['domainexpiry'] = $whois['expirydate'];
	 
	 $domaincreated = $whois['createddate'];

	if($domaincreated != "")
	{
		 $date = new DateTime($domaincreated);
		 $now = new DateTime();
		 $interval = $now->diff($date);
		 $arr['age'] = $interval->y;
	}
	else
	  $arr['age'] = 0;
	 
	 return $arr;
 }
 
 public function pause_posting($domainid, $uid)
 {	
	 $status = false;

	 $query = $this->db->select("status")->from("domains")->where('domainid', $domainid)->where('users_id', $uid)->get();
	 	
	  foreach($query->result() as $row)
	  {
		  if($row->status)
			$val = false;
		  else
			$val = true;
	  }
	 
	 $data = array('status' => $val);
	 
	 if($this->db->update("domains", $data, array('domainid' => $domainid, 'users_id' => $uid)))
	   $status = true;

	 return array('stat' => $status, 'val' => $val);
 }
 
 public function edit_network($id,$postdata)
 {
	 $flag = true;
	 $result = $this->fetch_networks();
	 
	 foreach($result as $res)
	 {
		 if(trim(strtolower($res['networkname'])) == trim(strtolower($postdata['network_name'])))
		 {
			 $flag = false;
			 break;
		 }
	 }
	 
	 if($flag)
	 $this->db->update("networks", $postdata, array('id' => $id));
 }
 
 public function delete_network($id)
 {
	$session = $this->session->userdata('user_data');
	
	$query = $this->db->select("*")->from("networks")->where('network_name','Uncategorized')->where('users_id',$session['user_id'])->get();  

	foreach($query->result() as $row)
	{
		$network_id = $row->id;
	}
 
	  $this->db->delete("networks", array('id' => $id));

	  $res = $this->db->select("*")->from("serp_assign_domains")->where('network_id',$id)->where('users_id',$session['user_id'])->get();
				   
				   if($res->num_rows() > 0)
					{
						foreach($res->result() as $result)
						{
							$doms = $this->db->select("*")->from("serp_assign_domains")->where('domain_id',$result->domain_id)
							->where('users_id',$session['user_id'])->get();
							
							if($doms->num_rows() == 1)
							{
							   $postdata = array('network_id' => $network_id);
	                           $this->db->update("serp_assign_domains", $postdata, array('domain_id' => $result->domain_id, 'users_id' => $session['user_id']));
							}
							else
							   $this->db->delete("serp_assign_domains", array('network_id' => $id, 'domain_id' => $result->domain_id, 'users_id' => $session['user_id']));
						}
					}
 }
 
 public function delete_domain($ids)
 {
	 $session = $this->session->userdata('user_data');
	 
	 $status = false;
	 $domid = explode(",",$ids);
     
	 if(count($domid) > 0)
     {
		 for($i=0;$i<count($domid);$i++)
		 {
		  $savedata['post_status'] = "trash";
		  
		  $this->db->update("campaign_posts", $savedata, array('domain_id' => $domid[$i]));
		  
		  $this->db->delete("serp_assign_domains", array('domain_id' => $domid[$i], 'users_id' => $session['user_id']));
		  $this->db->delete("domains", array('domainid' => $domid[$i]));
		 }
     }
	 
	 $cnt = $this->db->affected_rows();
	 
	 if($cnt > 0)
	  $status = true;
	  
	 return $status;
 }
 
 public function delete_posts()
 {
	 $this->db->delete("campaign_posts", array('post_status' => "trash"));
 }
 
 public function remove_domain($domainid,$networkid)
 {
	$session = $this->session->userdata('user_data');
	
	$query = $this->db->select("*")->from("networks")->where('network_name','Uncategorized')->where('users_id',$session['user_id'])->get();  

	foreach($query->result() as $row)
	{
		$network_id = $row->id;
	}

	  $doms = $this->db->select("*")->from("serp_assign_domains")->where('domain_id',$domainid)->where('users_id',$session['user_id'])->get();
							
	  if($doms->num_rows() == 1)
	  {
		 $postdata = array('network_id' => $network_id);
		 $this->db->update("serp_assign_domains", $postdata, array('domain_id' => $domainid, 'users_id' => $session['user_id']));
	  }
      else
	     $this->db->delete("serp_assign_domains", array('network_id' => $networkid, 'domain_id' => $domainid, 'users_id' => $session['user_id']));
 }
 
 public function assign_domains($networkid, $domainlist)
 {
	 $session = $this->session->userdata('user_data');
	 
	 $res = $this->db->select("domain_id")->from("serp_assign_domains")->where('network_id',$networkid)->where('users_id',$session['user_id'])->get();

						foreach($domainlist as $list)
							{
								$save_data = array();
								$flag = true;
								$save_data['network_id'] = $networkid;
								$save_data['domain_id'] = $list;
								$save_data['users_id'] = $session['user_id'];
								
								foreach($res->result() as $result)
								{
									if($list == $result->domain_id)
									{
										$flag = false;
								        break;
									}
								}
								
								if($flag)
								{
								    $this->db->insert('serp_assign_domains',$save_data);
								
									$ret = $this->db->select("*")->from("serp_assign_domains")->where('domain_id',$list)->where('serp_assign_domains.users_id',$session['user_id'])
									->join('networks', 'networks.id = serp_assign_domains.network_id')->where('networks.users_id',$session['user_id'])->get();
									
									if($ret->num_rows() > 1)
					                {
										foreach($ret->result() as $val)
										{
											if($val->network_name == 'Uncategorized')
											{
											   $this->db->delete("serp_assign_domains", array('network_id' => $val->network_id, 
											   'domain_id' => $list, 'users_id' => $session['user_id']));
											   break;
											}
										}
					                }
								}
							}
 }
 
 public function add_custom_category($category, $uid)
 {
	 $postdata['categoryname'] = $category;
	 $postdata['userid'] = $uid;
	 $flag = true;
	 
	 $retarr = $this->fetch_category($uid);
	 
	 if(isset($retarr['catname']) && count($retarr['catname']) > 0)
	 { 
		foreach($retarr['catname'] as $catg)
		{ 
		  if(strtolower(trim($catg['categoryname'])) == strtolower(trim($category)))
		  {
		   $flag = false;
		   break;
		  }
		}
     }
	 
	 if($flag)
	 {
	   $domains = $this->fetch_domains();
	   
	   if(count($domains) > 0)
	   { 
		foreach($domains as $key=>$doms)
		{
			$postdata['domainid'] = $key;
			$this->db->insert('serp_custom_category',$postdata);
		}
	   }
	 }
 }
 
 public function update_custom_category($domainid, $categoryname, $categoryvalue)
 {
	 $savedata['categoryvalue'] = $categoryvalue;
	 $this->db->update("serp_custom_category", $savedata, array('domainid' => $domainid, 'categoryname' => $categoryname));
 }
 
 public function fetch_category($uid)
 {
	 $retarr = array();
	 $catname = array();
	 $catvalue = array();
	 
	 $query = $this->db->select("*")->from("serp_custom_category")->where('userid',$uid)->group_by('categoryname')->get();
	 
	 if($query->num_rows() > 0)
	  {
		  foreach($query->result() as $row)
		  {
			  $catname[] = array('categoryname' => $row->categoryname);
		  }
	  }
	  
	 $query2 = $this->db->select("*")->from("serp_custom_category")->where('userid',$uid)->get();
	 
	 if($query2->num_rows() > 0)
	  {
		  foreach($query2->result() as $row2)
		  {
			  $catvalue[] = array('domainid' => $row2->domainid, 'categoryname' => $row2->categoryname, 'categoryvalue' => $row2->categoryvalue);
		  }
	  }
	  
	  $retarr['catname'] = $catname;
	  $retarr['catvalue'] = $catvalue;

	 return $retarr;
 }
 
 public function get_pr($domain)
 {
	$access_token = '251EB044F5F371C7B995EDA191743BEA';
	$url = 'http://pagerank.my-addr.com/external_api/';
	
	$request_url = $url.$access_token."/".$domain;
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $request_url);
	
	$pagerank = curl_exec($ch);
	
	curl_close($ch);
	
	return $pagerank;
}

public function get_whois($domain)
 {
	$access_token = '2AC307DEF0FCEC41D30BF33683CD862B';
	$url = 'http://whois.my-addr.com/api_parsed_json/';
	
	$request_url = $url.$access_token."/".$domain;
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $request_url);
	
	$whoisinfo = curl_exec($ch);
	
	curl_close($ch);
	
	$whois = array();
	
	$decoded = json_decode($whoisinfo);
	
	foreach($decoded as $val)
	{
		$result = $val->whois_record;
		
		$whois['registrar'] = $val->domain->sponsor;
		
		if($whois['registrar'] == "")
		{
			$info = explode("Registrar:",$result);
			
				if(isset($info[1]) && strpos($info[1],"Whois Server"))
				{
					$whois['registrar'] = substr($info[1], 0, strpos($info[1],"Whois Server"));
				}
		}
		
		$whois['nameserver'] = $val->domain->nserver[0];

		$whois['createddate'] = $val->domain->created;
		if($whois['createddate'] == "")
			{
				$st = strpos($result,"Creation Date");
				$tmp = substr($result,$st);
				$whois['createddate'] = substr($tmp,15,10);
			}
		
		$expirydate = $val->domain->expires;

		if($expirydate == "")
	    {
			$st = strpos($result,"Registry Expiry Date");
			$tmp = substr($result,$st);
			$expirydate = substr($tmp,22,10);
	    }
		
		if($expirydate != "")
		{
			$dt = explode("-",$expirydate);
			$whois['expirydate'] = $dt[1]."/".$dt[2]."/".$dt[0];
		}
		else
		    $whois['expirydate'] = "";
	}
	
	return $whois;
}

	 public function check_indexing($domain)
	{
	$reffer = "https://www.google.com/search";
    $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
	
		$query = $this->db->select('proxy')->from('serp_proxies')->where('status', 1)->get();

    		if($query->num_rows() > 0)
			{
    			foreach($query->result() as $row)
				{
					$proxy_list[] = $row->proxy;
				}
			}
			
			$proxy = $proxy_list[rand(0,count($proxy_list)-1)];

		$url = 'https://www.google.com/search?q='.$domain;
		
		$indexed = false;

		$crawlsite = str_get_html($this->crawl_list($reffer, $url, $agent, $proxy));

		foreach($crawlsite->find('li[class=g]') as $li)
		{
			$cite = $li->find('cite',0)->plaintext;

				if(strpos($cite,$domain) !== false)
				{
					$indexed = true;
					break;
				}
		}
		
		return $indexed;
	}

	public function get_obl($domain)
	{
		$reffer = "http://www.google.com";

		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
	
		$query = $this->db->select('proxy')->from('serp_proxies')->where('status', 1)->get();

    		if($query->num_rows() > 0)
			{
    			foreach($query->result() as $row)
				{
					$proxy_list[] = $row->proxy;
				}
			}
			
		$proxy = $proxy_list[rand(0,count($proxy_list)-1)];
		
        $html_answer = str_get_html($this->crawl_list($reffer, $domain, $agent, $proxy));
		
		$counter = 0;

        foreach($html_answer->find('body a') as $content)
		{
			$flag = true;
			
			if(trim($content->href) == "")
			  $flag = false;
			else
			{
				if(substr($content->href,0,1) == "/" || substr($content->href,0,1) == "#")
				{
					$flag = false;
				}
				else
				{
					$link = "";
					$url = parse_url($content->href);
	
					if(!empty($url["host"]))
					   $link = strtolower($url["host"]);
					else
					{
						if(!empty($url["path"]))
					     $link = strtolower($url["path"]);
					}
				
					$link = str_replace("www.","",$link);
					
					if($link == "" || $link == $domain)
					 $flag = false;
					 
					if(empty($url["scheme"]))
					 $flag = false;
				}
			}

			if($flag)
			$counter++;
		}

		return $counter;
	}
	
	/*public function check_indexing($domain)
	{
		$url = base_url()."index_checker.php";

		$arr = array('domain' => $domain);

        ob_start();
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
		
		$json = curl_exec($ch);
		
		curl_close($ch);
		
		$indexed = json_decode($json,true);
		
		return $indexed;
	}*/
	
	/*public function get_obl($domain)
	{	
		$url = base_url()."obl_link_counter.php";

		$arr = array('domain' => $domain);

        ob_start();
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
		
		$json = curl_exec($ch);
		
		curl_close($ch);
		
		$obl = json_decode($json,true);
	
		return $obl;
	}*/

	public function crawl_list($reffer, $url, $agent, $proxy)
	{
			ob_start();
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_REFERER, $reffer);
			
			curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
			
			/*Proxy curl settings*/
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
			
			$prxy = explode(':',$proxy);
			
			curl_setopt($ch, CURLOPT_PROXY, $prxy[0]);
			curl_setopt($ch, CURLOPT_PROXYPORT, $prxy[1]);
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'billing19:nCh59iAt');

			/*SSL settings*/
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			
			curl_setopt($ch, CURLOPT_HEADER, FALSE);

			$result = curl_exec($ch);
			curl_close($ch);
			//ob_flush();
			return $result;
	}
	
	
	public function fetch_access_token($code)
	{
		$data = array();
		
		$url = "https://ahrefs.com/oauth2/token.php";

		$arr = array('grant_type' => 'authorization_code',
			'code' => $code,
			'client_id' => 'Serp Avenger-development',
			'client_secret' => 'b5AyDsSqz',
			//'redirect_uri' => 'http://localhost/serp_avenger/networkmanager'
			'redirect_uri' => 'http://serpavenger.com/serp_avenger/networkmanager');

		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
		
		$json = curl_exec($ch);
		
		curl_close($ch);
		
		$data = json_decode($json,true);
	
		return $data;
	}
	
	
	public function fetch_backlinks($token, $domain)
	{
		$data = array();
		$val = 0;
		
		$url = "http://apiv2.ahrefs.com?token=".$token."&target=".$domain."&from=metrics_extended&mode=subdomains&output=json";
		
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
		$json = curl_exec($ch);
		
		curl_close($ch);
		
		$data = json_decode($json,true);
		
		if(isset($data['metrics']['backlinks']))
		  $val = $data['metrics']['backlinks'];
	
		return $val;
	}
	
	public function fetch_domain_rank($token, $domain)
	{
		$data = array();
		$val = 0;

		$url = "http://apiv2.ahrefs.com?token=".$token."&target=".$domain."&from=domain_rating&mode=subdomains&output=json";
		
		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
		$json = curl_exec($ch);
		
		curl_close($ch);
		
		$data = json_decode($json,true);
		
		if(isset($data['domain']['domain_rating']))
	     $val = $data['domain']['domain_rating'];
		 
		return $val;	
	}
	
	public function fetch_referring_domains($token, $domain)
	{
		$data = array();
		$val = 0;

		$url = "http://apiv2.ahrefs.com?token=".$token."&target=".$domain."&from=refdomains&mode=subdomains&output=json";

		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
		$json = curl_exec($ch);
		
		curl_close($ch);
		
		$data = json_decode($json,true);
		
		if(isset($data['stats']['refdomains']))
		  $val = $data['stats']['refdomains'];
	
		return $val;	
	}
	
	public function update_anchor_links($id, $fieldname, $position, $oldvals, $anchor='', $link='')
	{
		$field_name = $fieldname.$position;
		
		$anchorss = 'anchor'.$position;
		$linkss = 'link'.$position;
		
		$old_anchor = $oldvals[0]->$anchorss;
	    $old_link = $oldvals[0]->$linkss;
	
        $content = $oldvals[0]->post_content;
		
		if($anchor == '')
		  $anchor = $old_anchor;
		  
		if($link == '')
		  $link = $old_link;
		  
		$find_words = '<a href="'.$old_link.'" title="">'.$old_anchor.'</a>';
		$content_new = '<a href="'.$link.'" title="">'.$anchor.'</a>';
		
		$new_article = str_replace($find_words,$content_new,$content);

		$post[$anchorss] = $anchor;
		$post[$linkss] = $link;
		$post['post_content'] = $new_article;
		$post['post_modified'] = date('Y-m-d H:i:s');
		
		$this->db->where('id', $id);
		$this->db->update('campaign_posts', $post);
		return $this->db->affected_rows();
	}
	
	public function update_login_details($id, $field_name, $new_value)
	{
		exec("bash /home/serpaven/wpposter/run.sh domains ".$id);
		
		$save_data[$field_name] = $new_value;
		$this->db->update("domains", $save_data, array('domainid' => $id));
		return $this->db->affected_rows();
	}
	
	public function update_index($indexed, $id)
    {
		$update_data['nowindex'] = $indexed;
		$this->db->update("domains", $update_data, array('domainid' => $id));
    }
	
	public function pause_posting_now($pausekey, $uid)
	{
		if(count($pausekey) > 0)
		{
			for($i=0;$i<count($pausekey);$i++)
			{
				$update_data['status'] = false;
			    $this->db->update("domains", $update_data, array('domainid' => $pausekey[$i], 'users_id' => $uid));
			}
		}
	}
	
	public function update_pr_now($now)
	{
		$status = false;
		$domains = $this->fetch_domains();
		
		foreach($domains as $key=>$dom)
		{
			$update_data['pageranknow'] = "";
			
			$pagerank = $this->get_pr($dom['domainname']);

			$update_data['pageranknow'] = $pagerank;
			
			if($now)
			 $update_data['pagerank'] = $pagerank;
			
			$this->db->update("domains", $update_data, array('domainid' => $key));
		}
		
		$result = $this->db->affected_rows();
		
		if($result > 0)
		 $status = true;
		
		return $status;
	}
	
	public function update_ahrefs_now($now)
	{
		$session = $this->session->userdata('user_data');
		$uid = $session['user_id'];
		
		$accesstoken = "";
		$status = false;
		$domains = $this->fetch_domains();
		
		$network_setting = $this->default_network_setting($uid);
		
		foreach($network_setting as $setting)
		{
			$accesstoken = $setting['accesstoken'];
		}
		
		foreach($domains as $key=>$doms)
		{
			$update_data = array();

			$update_data['backlinksnow'] = $this->fetch_backlinks($accesstoken, $doms['domainname']);
			$update_data['domainranknow'] = $this->fetch_domain_rank($accesstoken, $doms['domainname']);
			$update_data['referringdomainsnow'] = $this->fetch_referring_domains($accesstoken, $doms['domainname']);

			if($now)
			{
				$update_data['backlinks'] = $update_data['backlinksnow'];
				$update_data['domainrank'] = $update_data['domainranknow'];
				$update_data['referringdomains'] = $update_data['referringdomainsnow'];
			}
			
			$this->db->update("domains", $update_data, array('domainid' => $key));
		}
		
		$result = $this->db->affected_rows();
		
		if($result > 0)
		 $status = true;
		
		return $status;
	}
	
	public function update_obl_now()
	{
		$domains = $this->fetch_domains();
		
		foreach($domains as $key=>$doms)
		{
			$save = array();
			$save['obl'] = $this->get_obl($doms['domainname']);
			$this->db->update("domains", $save, array('domainid' => $key)); 
		}
	}
	public function delete_colom($colom_name)
	{
		$this->db->delete('serp_custom_category', array('categoryname' => $colom_name)); 
		return true;
	}
}
?>