<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Renderanalysis_demo extends MY_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->library('analyze');
		
		$this->load->model('model_analysis_demo');
		
	}
       
	public function siteage(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersDomainAge($campaign_list, $campaign_server_engine);
		echo json_encode($renderList);
	}
	
	public function sitepagecount(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersDomainPageCount($campaign_list, $campaign_server_engine);
		echo json_encode($renderList);
	}
	
	public function sitewordcount(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersDomainWordCount($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function sitekwratio(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersDomainKWRatio($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function sitekwoptimization(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersDomainKWOptimization($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function sitehidinglinks(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersDomainHidingLinks($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function siteexternallinks(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersDomainExternalLinks($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function siteexactkwanchors(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersDomainExactKWAnchor($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function sitelongtermpageonerank(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderUsersLongTermPageOneRank($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function siteStat(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->rendersiteStat($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	function randeronpageelement(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_demo->renderonpageelement($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function sitelinkelement(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$type				= $this->input->get_post('linkelement_search_type');
		
		$renderList	= $this->model_analysis_demo->renderUsersLinkElement($campaign_list, $campaign_server_engine,$type);
		
		echo json_encode($renderList);
	}
	
	public function siteanalysiscomparison(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$keyword_value			= $this->input->get_post('keyword_value');
		
		$renderList	= $this->model_analysis_demo->renderanalysiscomparison($campaign_list, $campaign_server_engine,$keyword_value);
		
		echo json_encode($renderList);
	}
	
	public function renderserpmeter()
	{
		
		$this->check_login();
		
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$cid = 0;
		$currDate = date("Y-m-d");
		$prevDate = date("Y-m-d", time() - 60 * 60 * 24);
		$before2Date = date("Y-m-d", time() - 60 * 60 * 24 * 2);
		/*$this->load->model('model_campaign');
		$google_data_top10 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 10);
		$google_data_top10_prev = $this->model_campaign->getGoogleDataForCampaign($cid, $prevDate, 10);
		$google_data_top10_prev2date = $this->model_campaign->getGoogleDataForCampaign($cid, $before2Date, 10);
		
		pr($google_data_top10_prev,0);
		pr($google_data_top10_prev2date);
		*/
		$data_top10_today = $this->model_analysis_demo->renderserpmeter($campaign_list, $campaign_server_engine, $currDate);
		$data_top10_prevDate = $this->model_analysis_demo->renderserpmeter($campaign_list, $campaign_server_engine, $prevDate);
		$data_top10_prev2date = $this->model_analysis_demo->renderserpmeter($campaign_list, $campaign_server_engine, $before2Date);
		$diff_yesterday = 0;
		for($i= 0;$i<10;$i++)
		{
			if(isset($data_top10_today[$i]['url']) && isset($data_top10_prevDate[$i]['url'])){
				if($data_top10_prevDate[$i]['url'] != $data_top10_prev2date[$i]['url'])
				{
					$diff_yesterday++;
				}
			}
		}
		
		$diff_today = 0;
		for($i= 0;$i<10;$i++)
		{
			if(isset($data_top10_today[$i]['url']) && isset($data_top10_prevDate[$i]['url'])){
				if($data_top10_prevDate[$i]['url'] != $data_top10_today[$i]['url'])
				{
					$diff_today++;
				}
			}
		}
		
		/*echo $diff_today;
		pr($data_top10_today,0);
		pr($data_top10_prevDate);
		*/
		$result['yesterday'] = $diff_yesterday/10*100;
		$result['today'] = $diff_today/10*100;
		
		echo json_encode($result);
		
	}
}