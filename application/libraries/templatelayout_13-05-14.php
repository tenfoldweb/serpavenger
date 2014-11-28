<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of templatelayout
 */
class templatelayout {
     
     var $obj;
     var $tblCategories = 'smr_categories';
    
     public function __construct()
     {
        $this->obj =& get_instance();
	$this->obj->load->model('model_basic');
     }

     public function get_header($selected=""){
	  $this->header = '';
	  $this->obj->elements['header']='includes/header';
	  $this->obj->elements_data['header'] = $this->header;
     }
     
     public function get_left($selected=""){
	  $this->left = '';
	  $this->obj->elements['left']='includes/left';
	  $this->obj->elements_data['left'] = $this->left;
     }
     
     public function get_topmenu($selected=""){
	  $this->topmenu = '';
	  $this->obj->elements['topmenu']='includes/top_menu';
	  $this->obj->elements_data['topmenu'] = $this->topmenu;
     }
     
//     public function get_headerinner($selected=""){
//	  $this->header = '';
//	  $this->header['tabSelected'] = $selected;
//	  $this->obj->elements['header']='includes/headerinner';
//	  $this->obj->elements_data['header'] = $this->header;
//     }
     
     public function make_seo($title='',$key='',$desc=''){
	  $this->dataSeo['page_title'] = "Welcome To SERP Avenger";
	  $this->dataSeo['meta_desc'] = "Welcome To SERP Avenger";
	  $this->dataSeo['meta_keyword'] = "Welcome To SERP Avenger";
	  if($title){
	       $this->dataSeo['page_title'] .= ' | '.$title;
	  }
	  
	  if($key){
	       $this->dataSeo['meta_desc'] = $key;
	  }
	  
	  if($desc){
	       $this->dataSeo['meta_keyword'] = $desc;
	  }
	  
	  $this->obj->elements['seo']='includes/seo';
	  $this->obj->elements_data['seo'] = $this->dataSeo;
     }     
     
         
     public function get_footer()
     {
	  $this->footer = '';	  
	  $this->obj->elements['footer']='includes/footer';
	  $this->obj->elements_data['footer'] = $this->footer;
     }	
}
?>