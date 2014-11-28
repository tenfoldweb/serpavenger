<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Renderanalysis extends MY_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->library('analyze');
		$this->load->model('model_analysis');
		$this->load->helper('dom');
	}
        
	public function siteage(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis->renderUsersDomainAge($campaign_list, $campaign_server_engine,$site_type);
		echo json_encode($renderList);
	}
	
	public function sitepagecount(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
	
		$renderList	= $this->model_analysis->renderUsersDomainPageCount($campaign_list, $campaign_server_engine,$site_type);
		echo json_encode($renderList);
	}
	
	public function sitewordcount(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		
		$renderList	= $this->model_analysis->renderUsersDomainWordCount($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function sitekwratio(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis->renderUsersDomainKWRatio($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function sitekwoptimization(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis->renderUsersDomainKWOptimization($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function sitehidinglinks(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis->renderUsersDomainHidingLinks($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	public function socialLinks(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis->renderSocialLinks($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	
	public function siteexternallinks(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis->renderUsersDomainExternalLinks($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function siteexactkwanchors(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis->renderUsersDomainExactKWAnchor($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	public function sitelongtermpageonerank(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis->renderUsersLongTermPageOneRank($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	public function siteStat(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis->rendersiteStat($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	function randeronpageelement(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis->renderonpageelement($campaign_list, $campaign_server_engine);
		
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
	function sitelongterm(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis->renderlongtermsite($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	
	function sitefraceness(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		$site_type			= $this->input->get_post('site_type');
		$renderList	= $this->model_analysis->rendersitefressness($campaign_list, $campaign_server_engine,$site_type);
		
		echo json_encode($renderList);
	}
	
	
	function siteLinkGraph(){
		$this->check_login();
		$campaign_list			= $this->input->get_post('campaign_list');
		$campaign_server_engine		= $this->input->get_post('campaign_server_engine');
		
		$renderList	= $this->model_analysis->renderLinkGraph($campaign_list, $campaign_server_engine);
		
		echo json_encode($renderList);
	}
	
	function crawl_simple($reffer, $url, $agent, $proxy) {
    
		ob_start();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, $reffer);
		
		/*Proxy curl settings*/
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		// curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'username:passord');
		
		/*SSL settings*/
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		ob_flush();
		return $result;
	}
	
	public function secrawl(){
		$reffer_google = "http://www.google.com/search";
		$reffer_yahoo_rank = "https://search.yahoo.com/search";
		$reffer_bing_rank = "https://www.bing.com/search";
		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//Agent
		
		$search_keyword	= $this->input->get_post('search_keyword');
		$search_url	= $this->input->get_post('search_url');
		$server_engine	= $this->input->get_post('server_engine');
		
		/*Get keyword*/
		//$rank_keyword_array = array(1=>$search_keyword);		
		
		/*Get proxy randomly*/
		$proxy_array = array(1=>'50.31.105.26:8800',2=>'50.31.9.24:8800',3=>'192.126.171.71:8800',4=>'192.126.171.229:8800');
		$proxy = $proxy_array[rand(1,4)];		
		
		switch($server_engine){
			case "google" :
				$url = 'https://www.google.com/search?q='.str_replace(' ','+',$search_keyword).'&oq=tenant+screening&ie=UTF-8&num=10';
				$html = str_get_html($this->crawl_simple($reffer_google, $url, $agent, $proxy));
				
				$counter_result = 1; 
				foreach($html->find('li[class=g]') as $li){
				    $rank = $counter_result;
				    $title = $li->find('a',0)->plaintext;
				    $url = urldecode($li->find('a',0)->href);
				    $url = str_replace('/url?q=','',$url);
			            $url =strstr($url, '&amp;',true);
				    
				    echo 'RANK = ' . $rank . ' | URL = ' . $url . '<br>';
				    $counter_result++;
				}				
				break;
			case "yahoo";
				$url = 'https://search.yahoo.com/search?p='.str_replace(' ','+',$search_keyword).'&n=10&b=1';
				$html = str_get_html($this->crawl_simple($reffer_yahoo_rank, $url, $agent, $proxy));
				
				$counter_result = 1; 
				foreach($html->find('div[class=res]') as $div){                         
				    $data = '';
				    //Check for blank data
				    if(count($div->find('span[class=url]'))>0){					
					if(count($div->find('a[id=link-'.$counter_result.']'))>0){
					    $title = $div->find('a[id=link-'.$counter_result.']', 0)->plaintext;
					}else{
					   $title = ''; 
					}
					
					$temp_url = explode('RU=',urldecode($div->find('a[id=link-'.$counter_result.']', 0)->href));
					$temp_url = explode('/RK=0', $temp_url[1]);
					$url = $temp_url[0];
					$counter_result++;
				    }				    
				}
				break;
			case "bing" :
				$url = 'https://www.bing.com/search?q='.str_replace(' ','+',$search_keyword).'&count=10&first=1&FORM=PERE';
				$html = str_get_html($this->crawl_simple($reffer_bing_rank, $url, $agent, $proxy));
				$counter_result = 1;           
				foreach($html->find('div#results',0)->find('ul',0)->find('li') as $li){
				    $data = '';
				    //Check for blank data
				    if(count($li->find('a')) > 0){
					$rank = $counter_result;
					$title = $li->find('a', 0)->plaintext;
					$url = $li->find('a', 0)->href;					
					$counter_result++;
				   }
				}
				break;
		}
		exit;
	}	
}