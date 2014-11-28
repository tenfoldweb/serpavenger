<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userregistration_model extends CI_Model {

 public function __construct()
 {
  parent::__construct();
  $this->load->helper('dom');
 }
 
 public function create_user($data)
 {
	 $status = false;
	 
	 $url = 'http://serpavenger.com/serp_avenger/amember/api/users';
		 
		$fields = array(
					'_key' => 'wQP5VStXryExvXH3TIRw',
					'_format' => 'json',
					'login' => $data['user_name'],
					'pass' => $data['password'],
					'email' => $data['email'],
					'name_f' => $data['first_name'],
					'name_l' => $data['last_name'],
					'added' => date('Y-m-d H:i:s'),
					'status' => 1,
					'unsubscribed' => 1,
					'is_approved' => 1,
					'lang' => 'en'
			);
		 
		$fields_string  = http_build_query($fields);
		
		ob_start();
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

		$result = curl_exec($ch);

        $result_o = json_decode($result,true);

		curl_close($ch);
	  
	  if(isset($result_o[0]['user_id']) && $result_o[0]['user_id']!='')
	  {
	      $data_p = array('pass' => md5($data['password']));

		  $this->db->where('user_id', $result_o[0]['user_id']);
		  $this->db->update('am_user', $data_p);
	
		  $status = true;
	  }
	 
	 return $status;
 }
}
?>