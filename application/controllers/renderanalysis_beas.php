<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Renderanalysis_beas extends MY_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->library('analyze');
		$this->load->model('model_analysis_beas');
	}
        
	public function siteage(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis_beas->renderUsersDomainAge($campaign_list, $campaign_server_engine,$site_type);
		echo json_encode($renderList);
	}
	
	public function sitepagecount(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
	
		$renderList	= $this->model_analysis_beas->renderUsersDomainPageCount($campaign_list, $campaign_server_engine,$site_type);
		echo json_encode($renderList);
	}
	
	public function sitewordcount(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		
		$renderList	= $this->model_analysis_beas->renderUsersDomainWordCount($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function sitekwratio(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis_beas->renderUsersDomainKWRatio($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function sitekwoptimization(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis_beas->renderUsersDomainKWOptimization($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function sitehidinglinks(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis_beas->renderUsersDomainHidingLinks($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	public function socialLinks(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis_beas->renderSocialLinks($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	
	public function siteexternallinks(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis_beas->renderUsersDomainExternalLinks($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function siteexactkwanchors(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis_beas->renderUsersDomainExactKWAnchor($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function sitelongtermpageonerank(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_beas->renderUsersLongTermPageOneRank($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function siteStat(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_beas->rendersiteStat($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	function randeronpageelement(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_beas->renderonpageelement($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function sitelinkelement(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$type				= $this->input->get_post('linkelement_search_type');
		
		echo $renderList	= $this->model_analysis_beas->renderUsersLinkElement($campaign_list, $campaign_server_engine,$type);
		
		echo json_encode($renderList);
	}
	
	public function siteanalysiscomparison(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$keyword_value			= $this->input->get_post('keyword_value');
		
		$renderList	= $this->model_analysis_beas->renderanalysiscomparison($campaign_list, $campaign_server_engine,$keyword_value);
		
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
		$before7Date = date("Y-m-d", time() - 60 * 60 * 24 * 7);
		$before30Date = date("Y-m-d", time() - 60 * 60 * 24 * 30);
		/*$this->load->model('model_campaign');
		$google_data_top10 = $this->model_campaign->getGoogleDataForCampaign($cid, $currDate, 10);
		$google_data_top10_prev = $this->model_campaign->getGoogleDataForCampaign($cid, $prevDate, 10);
		$google_data_top10_prev2date = $this->model_campaign->getGoogleDataForCampaign($cid, $before2Date, 10);
		
		pr($google_data_top10_prev,0);
		pr($google_data_top10_prev2date);
		*/
		$data_top10_today = $this->model_analysis_beas->renderserpmeter($campaign_list, $campaign_server_engine, $currDate);
		$data_top10_prevDate = $this->model_analysis_beas->renderserpmeter($campaign_list, $campaign_server_engine, $prevDate);
		$data_top10_prev2date = $this->model_analysis_beas->renderserpmeter($campaign_list, $campaign_server_engine, $before2Date);
		$data_top10_prev7date = $this->model_analysis_beas->renderserpmeter($campaign_list, $campaign_server_engine, $before7Date);
		$data_top10_prev30date = $this->model_analysis_beas->renderserpmeter($campaign_list, $campaign_server_engine, $before30Date);
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
		
		$diff_week = 0;
		for($i= 0;$i<10;$i++)
		{
			if(isset($data_top10_today[$i]['url']) && isset($data_top10_prev7date[$i]['url'])){
				if($data_top10_prev7date[$i]['url'] != $data_top10_today[$i]['url'])
				{
					$diff_week++;
				}
			}
		}
		
		$diff_month = 0;
		for($i= 0;$i<10;$i++)
		{
			if(isset($data_top10_today[$i]['url']) && isset($data_top10_prev30date[$i]['url'])){
				if($data_top10_prev30date[$i]['url'] != $data_top10_today[$i]['url'])
				{
					$diff_month++;
				}
			}
		}
		
		/*echo $diff_today;
		pr($data_top10_today,0);
		pr($data_top10_prevDate);
		*/
		$result['yesterday'] = $diff_yesterday/10*100;
		$result['today'] = $diff_today/10*100;
		$result['week'] = $diff_week/10*100;
		$result['month'] = $diff_month/10*100;
		
		echo json_encode($result);
		
	}	
	function sitelongterm(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_beas->renderlongtermsite($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	
	function sitefraceness(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis_beas->rendersitefressness($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	
	function siteLinkGraph(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis_beas->renderLinkGraph($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	
	
}