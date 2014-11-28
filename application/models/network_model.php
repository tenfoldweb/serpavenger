<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Network_model extends CI_Model {
 public function __construct()
 {
  parent::__construct();
 }
 
 	/*
	This function gets a complete list of all sub building
	*/
 	function get_network($id = false,$users_id = false)
	{
		$this->db->select('*');
		$this->db->from('networks');				
		$this->db->order_by('id', 'ASC');
		$this->db->order_by('network_name', 'ASC');
		if($id){
		  $this->db->where('id', $id);	
		}if($users_id){
		  $this->db->where('users_id', $users_id);	
		}
		$result = $this->db->get();
				
		$result = $result->result();		
		return $result;
	}
  
	}	
 
?>