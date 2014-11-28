<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userpermissions_model extends CI_Model {

 public function __construct()
 {
  parent::__construct();
  $this->load->helper('dom');
 }
 
 public function save_package($data)
 {
	 $retarr = array();
	 $savepackage = true;
	 $status = false;
	 $package_id = "";
	 $msg = "";
	 
	 $query = $this->db->select("*")->from("serp_membership_packages")->get();
	 
	 if($query->num_rows() > 0)
	  {
		  foreach($query->result() as $row)
		  {
			  if(trim(strtolower($row->package_name)) == trim(strtolower($data['package_name'])))
			  {
				  $savepackage = false;
				  $msg = "Package Name already exists";
				  break;
			  }
		  }
	  }
	  
	  if($savepackage)
	  {
		  $this->db->insert('serp_membership_packages',$data);
		  //$package_id = $this->db->insert_id();
		  
		  if($this->db->affected_rows() > 0)
		  {  
			  $amember_product = array();
			  $amember_product['title'] = $data['package_name'];
			  $amember_product['start_date'] = 'product,group,payment';
			  $amember_product['currency'] = 'USD';
			  $amember_product['tax_group'] = "";
			  //$amember_product['default_billing_plan_id'] = $package_id;
			  
			  $this->db->insert('am_product',$amember_product);
			  $package_id = $this->db->insert_id();
			  
			  $updateval = array();
			  $updateval['default_billing_plan_id'] = $package_id;
			  
			  $this->db->update('am_product', $updateval, array('product_id' => $package_id)); 
			  
			  
			  $amember_billing_plan = array();
			  
			  //$data['monthly_fees'] = $data['monthly_fees'] - ($data['monthly_fees'] * $data['package_upgrade_cost']) / 100;
			  
			  $amember_billing_plan['product_id'] = $package_id;
			  $amember_billing_plan['title'] = "Default Billing Plan";
			  $amember_billing_plan['first_price'] = $data['monthly_fees'];
			  $amember_billing_plan['first_period'] = '1m';
			  $amember_billing_plan['rebill_times'] = '99999';
			  $amember_billing_plan['second_price'] = $data['monthly_fees'];
			  $amember_billing_plan['second_period'] = '1m';
			  $amember_billing_plan['qty'] = 1;
			  
			  $this->db->insert('am_billing_plan',$amember_billing_plan);
			  
				
			  $amember_data = array();
			  $amember_data['table'] = 'billing_plan';
			  $amember_data['id'] = $package_id;
			  $amember_data['key'] = 'paypal_id';
			  $amember_data['value'] = $package_id;
			  
			  $this->db->insert('am_data',$amember_data);

			  $msg = "New Package Saved Successfully";
		      $status = true;
		  }
	  }
	  
	  $retarr['status'] = $status;
	  $retarr['msg'] = $msg;
	 
	 return $retarr;
 }
}
?>