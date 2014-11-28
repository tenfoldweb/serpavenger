<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlogin_model extends CI_Model {

 public function __construct()
 {
  parent::__construct();
  $this->load->helper('dom');
 }
 
 public function auth_user($data)
 {
	$status = false;
	$password = md5($data['password']); 

	// Authentication of user login
	
	$this->db->select('*');
    $this->db->from('am_user');
	$this->db->where('login', $data['user_name']);
    $this->db->where('pass', $password); 
    $result = $this->db->get();
	$result = $result->result();		

	if($result)
	{
		// For addedd permission status
		$this->db->select('*');
		$this->db->from('serp_added_user_permission');
		$this->db->where('user_id', $result[0]->user_id);
		$result_user_status_a = $this->db->get();
		$result_user_status_a = $result_user_status_a->result();
	
		
			//After authentication 	fetching all the data of user like package , permission
			$this->db->select('*');
			$this->db->from('am_user_status');
			$this->db->join('serp_membership_packages', 'serp_membership_packages.package_id = am_user_status.product_id');
			$this->db->where('user_id', $result[0]->user_id);
			$result_user_status = $this->db->get();
			$result_user_status = $result_user_status->result();
			
		if(count($result_user_status_a) > 0)
		{
			foreach ($result_user_status as $row)
			{
				foreach ($result_user_status_a as $row_a)
			    {
					if($row_a->package_id == $row->package_id){
				 
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
			$package[] = json_decode(json_encode($row), true);
		}
			$user_data = array('user_id' => $result[0]->user_id,
								'user_login' => $result[0]->login,
								'user_email' => $result[0]->email,
								'user_name_f' => $result[0]->name_f,
								'user_name_l' => $result[0]->name_l,						
								'package' =>  $package);
			$this->session->set_userdata('user_data', $user_data);
			
			$status = true;
		
   }

   return $status;
 }
}
?>