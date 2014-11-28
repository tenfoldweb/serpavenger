<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Launchcampaign extends CI_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->helper('dom');
		//$this->load->model('model_basic');
		$this->load->library('analyze');
		$this->load->model('model_campaign');
		$this->load->model('model_ranking');
		$this->load->model('userlogin_model');
		$this->load->model('model_basic');

		 if(!$this->session->userdata('user_data'))
		 {
		   redirect(Am_Lite::getInstance()->getLoginURL());
		 }
	}

	public function index()
	{
		$session = $this->session->userdata('user_data'); 
		
		$get_packages = $this->userlogin_model->get_packages($session['user_id']);

			foreach($get_packages as $row)
			{
				if($row['analysis_permission'] == 1)
				{
					$permission = TRUE; 
					break;
				}
				else
				{
					$permission = FALSE;
				}
			}
       $users_id = $session['user_id'];
      // $this->data['secondkeywordloop']=$this->model_campaign->secondkeywordsloop($users_id);
       $this->data['keywordmain']=$this->model_campaign->mainkeywords($users_id); 
       $keyword_id=($this->data['keywordmain']['keyword_id']);
       
      $this->data['keyword_id'] = $keyword_id;
      //print "<pre>"; print_r($this->data); print "</pre>";
	  $this->data['userdetailcompare']=$this->model_campaign->getuserdetailcompare($users_id,$campaign_id);        
	//  print_r($this->data['userdetailcompare']);
	  $campaign_id = $this->data['userdetailcompare']->id;
	  
	   $this->data['secondkeyword']=$this->model_campaign->secondkeywordscampaign($users_id,$campaign_id);
	   
	   
       //$this->data['secondkeyword']=$this->model_campaign->secondkeywords($users_id);
       $this->data['additionalkeywordloop']=$this->model_campaign->additionalkeywordsloop($users_id,$campaign_id);
	   
	   
       $campaign_id		= $this->uri->segment(3, 2);
       $campaign_cpc_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION, '*', '', 'campaign_id = '.$campaign_id);
       $campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = 1');
       $this->data['campaign_id']			= $campaign_id; 
       $this->data['campaign_detail']			= $campaign_detail;
       $this->data['campaign_cpc_detail']		= $campaign_cpc_detail;
       $this->data['active_campaignList'] =  $this->model_basic->getActiveCampaignList($users_id);	
       $row= $this->model_campaign->getexactmatchanchor($users_id,$campaign_id);
       $this->data['keyword'] = $row->keyword; 
       $this->data['url'] = $row->url;
       //$this->data['keyword_id'] = $row->id;
      // $this->data['exact_match_anchors'] = $row->exact_match_anchors; 
       $row1= $this->model_campaign->getrelatedmatchanchor($users_id,$campaign_id);
       $this->data['keywords'] = $row1->keyword; 
       $this->data['urlspecifykw'] = $row1->urlspecifykw;
        $this->data['keywords_id'] = $row1->keyword_id; 
       $this->data['secondkeywordloop']=$this->model_campaign->secondkeywordsloop($users_id,$campaign_id);
        // $this->data['userdetailcompare']=$this->model_campaign->getuserdetailcompare($users_id,$campaign_id);
        echo $keywordmain['keyword'];
        if(($this->data['keywordmain']['keyword'])!='')
{
 $this->data['kcpcData']=$this->analyze->keywordCPCData($this->data['keywordmain']['keyword']);
}
else
{
  $this->data['kcpcData']=$this->analyze->keywordCPCDatabydomain($this->data['secondkeyword']['keyword']);
}
       /*$this->data[0]['keyword'] = $keyword;print_r($keyword);
       echo($data[0]['keyword']); 
       $this->data[0]['keyword'] = $keyword; echo $keyword;*/
       //print "<pre>"; print_r($this->data); print "</pre>";
       $this->elements['middle']='campaign/launch-campaign';			
	   $this->elements_data['middle'] = $this->data;
	   $this->layout->setLayout('main_layout_new');
	   $this->layout->multiple_view($this->elements,$this->elements_data);
		
	}

	public function launch()
	{
      $link_velocity = $this->input->post('link_velocity');
      $num_links = $this->input->post('num_links');
     
      $this->model_campaign->launchcampaign();
      redirect('campaign');

	}

}