<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');

class Model_thumbnail extends CI_Model
{
	

	public function __construct(){
		parent::__construct();
	}

	public function get_image_thumbnail($siteurl){
		$this->db->select('imagename');
		$this->db->from('serp_image_to_url');
		$this->db->where('siteurl',$siteurl);
		return $this->db->get();
	}

	public function save_image_thumbnail($data){
		$this->db->insert('serp_image_to_url',$data);
	}

}

