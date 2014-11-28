<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buypackage_model extends CI_Model {

 public function __construct()
 {
  parent::__construct();
  $this->load->helper('dom');
 }
 
 public function get_packages($user_id, $limit="")
 {
	 $retarr = array();
	 $loginstat = false;
	 $proids = "";
	 
	 if(isset($user_id) && $user_id != "")
	  $loginstat = true;
	
	$this->db->select("*")->from("serp_membership_packages");
	 
	$this->db->join('am_product', 'am_product.title = serp_membership_packages.package_name');
	
	if($limit != "")
	{
	  $this->db->order_by("product_id", "desc");
	  $this->db->limit(3);
	}
	 
	$query = $this->db->get();
	
	
	 
	 if($query->num_rows() > 0)
	  {
		  foreach($query->result() as $row)
		  {
			  $upgrade_cost = 0;
			  $fee = $row->monthly_fees;
			  
			  if($loginstat)
			  {
				  $count = $this->db->select("*")->from("am_user_status")
				  
				  ->where('user_id',$user_id)
				  
				  ->join('am_product', 'am_product.product_id = am_user_status.product_id')
				  
				  ->join('serp_membership_packages', 'serp_membership_packages.package_name = am_product.title')->get();			  
				  
				  $num_rows = $count->num_rows();
				  
				  if($num_rows > 0)
				  { 
					  foreach($count->result() as $ct)
					  {
						  $proids .= $ct->product_id.",";
					  }
					  
					  $proids = rtrim($proids, ",");
  
					  $query = $this->db->select("*")->from("serp_discount_rate")->get();
					  
					  if($query->num_rows() > 0)
					  {
						foreach($query->result() as $rec)
						{
							if($num_rows >= $rec->min_package_no && $num_rows <= $rec->max_package_no)
							{
								$fee = $row->monthly_fees - ($row->monthly_fees * $rec->discount) / 100;
								$upgrade_cost = $rec->discount;
								break;
							}
						}
					  }
				  } 
			  }
			  
			  $retarr[$row->product_id] = array('name' => $row->package_name, 'fee' => $fee, 
			  'actual_cost' => $row->monthly_fees, 'upgrade_cost' => $upgrade_cost, 'proids' => $proids);
		  }
	  }

	 return $retarr;
 }



	/*public function add_amember_invoice($uid)
	{
	  $url = 'http://serpavenger.com/serp_avenger/amember/api/invoices';
	  
	  if($this->session->userdata('tranx_details'))
	  {
       $tranx_data = $this->session->userdata('tranx_details');
			
	  $vars = array(
		'_key'      =>  'wQP5VStXryExvXH3TIRw',
		'_format' => 'json',
		'user_id'   => $uid,
		'paysys_id' => 'paypal',
		'currency'  =>  'USD',
		'first_subtotal' => '95.00',
		'first_discount'    =>  '0.00',
		'first_tax'     =>  '0.00',
		'first_shipping'    =>  '0.00',
		'first_total'       =>  '95.00',
		'first_period'      =>  '1m',
		'rebill_times'      =>  99999,
		'second_subtotal' => '95.00',
		'second_discount'    =>  '0.00',
		'second_tax'     =>  '0.00',
		'second_shipping'    =>  '0.00',
		'second_total'       =>  '95.00',
		'second_period'      =>  '1m',
		'is_confirmed'      =>  1,
		'status'            => 1,
	 
	//// InvoiceItem record
	 
		'nested[invoice-items][0][item_id]' => 1, //  - product_id here;
		'nested[invoice-items][0][item_type]' => '',
		'nested[invoice-items][0][item_title]' => 'Diamond Package',
		'nested[invoice-items][0][item_description]' => '' ,
		'nested[invoice-items][0][qty]' => 1,
		'nested[invoice-items][0][first_discount]'    =>  '0.00',
		'nested[invoice-items][0][first_price]'    =>  '95.00',
		'nested[invoice-items][0][first_tax]'     =>  '0.00',
		'nested[invoice-items][0][first_shipping]'    =>  '0.00',
		'nested[invoice-items][0][first_total]'       =>  '95.00',
		'nested[invoice-items][0][first_period]'      =>  '1m',
		'nested[invoice-items][0][rebill_times]'      =>  99999,
		'nested[invoice-items][0][second_discount]'    =>  '0.00',
		'nested[invoice-items][0][second_tax]'     =>  '0.00',
		'nested[invoice-items][0][second_shipping]'    =>  '0.00',
		'nested[invoice-items][0][second_total]'       =>  '95.00',
		'nested[invoice-items][0][second_price]'       =>  '95.00',
		'nested[invoice-items][0][second_period]'      =>  '1m',
		'nested[invoice-items][0][currency]' => 'USD',
		'nested[invoice-items][0][billing_plan_id]' => 1, // Billing plan within  product, check am_billing_plan table.
	 
		 // InvoicePayment record
	 
		'nested[invoice-payments][0][user_id]' => $uid,
		'nested[invoice-payments][0][paysys_id]' => 'paypal',
		'nested[invoice-payments][0][receipt_id]' => $tranx_data['tranx_id'],
		'nested[invoice-payments][0][transaction_id]' => $tranx_data['tranx_id'],
		'nested[invoice-payments][0][currency]' => 'USD',
		'nested[invoice-payments][0][amount]' => '95.00',
	 
		// Access record
		'nested[access][0][user_id]' => $uid,
		'nested[access][0][product_id]' => 1,
		'nested[access][0][transaction_id]' => $tranx_data['tranx_id'],
		'nested[access][0][begin_date]' => date('Y-m-d H:i:s'),
		'nested[access][0][expire_date]' => date('Y-m-d H:i:s')
	);
 
 
		$fields_string = http_build_query($vars);
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($vars));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

		$result = curl_exec($ch);

		curl_close($ch);
		
		$this->session->unset_userdata('tranx_details');		
	  }
	}*/
}
?>