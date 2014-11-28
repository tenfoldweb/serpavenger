<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlogin_model extends CI_Model {

 public function __construct()
 {
  parent::__construct();
  $this->load->helper('dom');
  
  require_once 'amember/library/Am/Lite.php';
  
  $login_stat = Am_Lite::getInstance()->isLoggedIn();
  
  if(!$login_stat)
  {
	  if($this->session->userdata('user_data'))
		$this->session->unset_userdata('user_data');
  }
  else
  {
	  $user_details = Am_Lite::getInstance()->getUser();
	 
		/* $this->db->select('*');
		$this->db->from('serp_added_user_permission');
		$this->db->where('user_id', $user_details['user_id']);
		$result_user_status_a = $this->db->get();
		$result_user_status_a = $result_user_status_a->result();

		//After authentication 	fetching all the data of user like package , permission
		/*$this->db->select('*');
		$this->db->from('am_user_status');
		$this->db->join('serp_membership_packages', 'serp_membership_packages.package_id = am_user_status.product_id');
		$this->db->where('user_id', $user_details['user_id']);
		$result_user_status = $this->db->get();*/
		
		/* $this->db->select('*');
		$this->db->from('am_user_status');
		$this->db->where('user_id', $user_details['user_id']);
		$this->db->join('am_product', 'am_product.product_id = am_user_status.product_id');
		$this->db->join('serp_membership_packages', 'serp_membership_packages.package_name = am_product.title');
		$result_user_status = $this->db->get();
		$result_user_status = $result_user_status->result();
			
		if(count($result_user_status_a) > 0)
		{
			foreach ($result_user_status as $row)
			{
				foreach ($result_user_status_a as $row_a)
			    {
					if($row_a->package_id == $row->product_id){
				 
						$row->submitter_permission = $row_a->submitter_permission;
						$row->ranking_permission = $row_a->ranking_permission;
						$row->analysis_permission = $row_a->analysis_permission;
						$row->networkmanager_permission = $row_a->networkmanager_permission;
					}
			    }
			}
		} 

		foreach ($result_user_status as $row)
		{
			$arr = array();
			$arr = json_decode(json_encode($row), true);
			$arr['package_id'] = $arr['product_id'];
			unset($arr['title']);
			unset($arr['description']);
			unset($arr['trial_group']);
			unset($arr['start_date']);
			unset($arr['currency']);
			unset($arr['tax_group']);
			unset($arr['sort_order']);
			unset($arr['renewal_group']);
			unset($arr['start_date_fixed']);
			unset($arr['require_other']);
			unset($arr['prevent_if_other']);
			unset($arr['paysys_id']);
			unset($arr['comment']);
			unset($arr['default_billing_plan_id']);
			unset($arr['is_tangible']);
			unset($arr['is_disabled']);
			$package[] = $arr;
		} */

			$user_data = array('user_id' => $user_details['user_id'],
								'user_login' => $user_details['login'],
								'user_email' => $user_details['email'],
								'user_name_f' => $user_details['name_f'],
								'user_name_l' => $user_details['name_l']
								);
				
				$this->session->set_userdata('user_data', $user_data);
  }
 }
 
 public function get_packages($user_id){
		$this->db->select('*');
		$this->db->from('serp_added_user_permission');
		$this->db->where('user_id', $user_id);
		$result_user_status_a = $this->db->get();
		$result_user_status_a = $result_user_status_a->result();

		//After authentication 	fetching all the data of user like package , permission
		
		/*$this->db->select('*');
		$this->db->from('am_user_status');
		$this->db->join('serp_membership_packages', 'serp_membership_packages.package_id = am_user_status.product_id');
		$this->db->where('user_id', $user_id);
		$result_user_status = $this->db->get();*/
	  
		$this->db->select('*');
		$this->db->from('am_user_status');
		$this->db->where('user_id', $user_id);
		$this->db->join('am_product', 'am_product.product_id = am_user_status.product_id');
		$this->db->join('serp_membership_packages', 'serp_membership_packages.package_name = am_product.title');
		$result_user_status = $this->db->get();
		$result_user_status = $result_user_status->result();
			
		if(count($result_user_status_a) > 0)
		{
			foreach ($result_user_status as $row)
			{
				foreach ($result_user_status_a as $row_a)
			    {
					if($row_a->package_id == $row->product_id){
						$row->submitter_permission = $row_a->submitter_permission;
						$row->ranking_permission = $row_a->ranking_permission;
						$row->analysis_permission = $row_a->analysis_permission;
						$row->networkmanager_permission = $row_a->networkmanager_permission;
						
						$row->max_keyword_track += $row_a->max_keyword_track;
						
						$row->more_keyword_adding_cost_ranking = $row_a->more_keyword_adding_cost_ranking;
						$row->ranking_upgrade_cost = $row_a->ranking_upgrade_cost;
						
						$row->max_keyword_analyzed += $row_a->max_keyword_analyzed;
						
						$row->more_keyword_adding_cost_analysis = $row_a->more_keyword_adding_cost_analysis;
						$row->analysis_upgrade_cost = $row_a->analysis_upgrade_cost;
						
						$row->max_domain_no += $row_a->max_domain_no;
						//$row->max_htmlsite_no += $row_a->max_htmlsite_no;
						//$row->max_blogplus_no += $row_a->max_blogplus_no;
						//$row->max_blogs_no += $row_a->max_blogs_no;
						
						$row->more_domain_adding_cost = $row_a->more_domain_adding_cost;
						$row->networkmanager_upgrade_cost = $row_a->networkmanager_upgrade_cost;
						$row->max_scraped_runs_no += $row_a->max_scraped_runs_no;
						$row->max_article_no += $row_a->max_article_no;
						
						$row->submitter_upgrade_cost = $row_a->submitter_upgrade_cost;
						$row->max_sites_per_subscription = $row_a->max_sites_per_subscription;
						$row->max_parasite_per_subscription = $row_a->max_parasite_per_subscription;
						$row->max_moneysite_per_subscription = $row_a->max_moneysite_per_subscription;
						$row->max_initial_setup_runs_no = $row_a->max_initial_setup_runs_no;	
					}
			    }
			}
		} 

		foreach ($result_user_status as $row)
		{
			$arr = array();
			$arr = json_decode(json_encode($row), true);
			$arr['package_id'] = $arr['product_id'];
			unset($arr['title']);
			unset($arr['description']);
			unset($arr['trial_group']);
			unset($arr['start_date']);
			unset($arr['currency']);
			unset($arr['tax_group']);
			unset($arr['sort_order']);
			unset($arr['renewal_group']);
			unset($arr['start_date_fixed']);
			unset($arr['require_other']);
			unset($arr['prevent_if_other']);
			unset($arr['paysys_id']);
			unset($arr['comment']);
			unset($arr['default_billing_plan_id']);
			unset($arr['is_tangible']);
			unset($arr['is_disabled']);
			$package[] = $arr;
		}

		if(!empty($package))
		return $package;
	}
	
	public function get_user_log($user_id)
	{
		$new_user = true;
		
		$query = $this->db->select("*")->from("am_access_log")->where('user_id',$user_id)->get();
	 
		 if($query->num_rows() > 1)
		  {
			  $new_user = false;
		  }
		  
		  return $new_user;
	}
}
?>