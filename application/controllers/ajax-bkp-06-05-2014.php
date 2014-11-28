<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MY_Controller{
	
	
	public function __construct(){
		parent::__construct();		
		$this->load->model('model_basic');
	}
	public function InsertKeyword(){
		
		$user_id     = $this->input->post('user_id');
		$keyword     = $this->input->post('keyword');
		$campaign_id = $this->input->post('campaign_id');
		
		
		$this->form_validation->set_rules('keyword', 'Keyword', 'trim|required');
		$this->form_validation->set_rules('campaign_id', 'Campaign', 'required');
		
		
		if ($this->form_validation->run() == FALSE)
		{	
		} else {
				
				$condition = "keyword = '".$keyword."' and campaign_id = '".$campaign_id."'";
				
				$value_exist   = $this->model_basic->isRecordExist(TABLE_USERS_CAMPAIGNS_KEYWORD,$condition,'','');
				
				if($value_exist != '0') {
					echo '<font color="red"><i>"'.$keyword.'"</i> Keyword Already Exist</font>';
				} else {
					$insertArr  =  array(
							'users_id'	=> $user_id,
							'keyword'	=> $keyword,
							'campaign_id'	=> $campaign_id,
							'keyword_type'	=> 'A',
							'status'     	=> 'Active',
							'date_added'	=>  date('Y-m-d H:i:s')
						);
				
					$return_val = $this->model_basic->insertIntoTable(TABLE_USERS_CAMPAIGNS_KEYWORD,$insertArr);
					
					if(strlen($return_val) > 0){
						
						echo '<font color="green">Keyword Added Successfully</font>';
						
					}
						
				}
		}
	}
	
	function kw_cpc_valuation(){
		$str	= '';
		$cid = $this->uri->segment(3,0);
		$val = $this->uri->segment(4,0);
		
		$campaign_main_kw_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = "'.$cid.'" AND keyword_type = "M"');
		
		$kw_valuation_percentage = array(32.5,17.6,11.4,8.1,6.1,4.4,3.5,3.1,2.6,2.4);
		$items = array_chunk($kw_valuation_percentage,(count($kw_valuation_percentage)/2));		
		
		$counterx = 1;
		foreach($items as $km=>$kam){
			foreach($kam as $vo){
				if(!empty($val) || $val != 0){
					$valn = ($vo/100) * $val;
				}else{
					$valn =  ($vo/100) * $campaign_main_kw_cpc_detail[0]['keyword_est_traffic'] * $campaign_main_kw_cpc_detail[0]['keyword_cpc'];
				}
				
				$str	.= '<li>'.$counterx.' $' . number_format($valn,2) . '</li>';
				$counterx++;
			}
		}
		echo $str;
		exit;
	}
}