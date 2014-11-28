<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends MY_Controller {
	
	var $campaignstable = 'serp_users_campaign_detail';
	var $useragenttable = 'serp_useragentstrings';
	var $proxiestable   = 'serp_proxies';
	
	public function __construct(){
		parent::__construct();		
		//$this->load->helper('dom');
		$this->load->library('search_engine_crawler');	
		$this->load->model('model_basic');
		$this->load->model('model_campaign');
	}
	
	public function getgooglecrawldata(){
		$currDate = date("Y-m-d");
		$data	= $this->model_campaign->getGoogleDataForCampaign(0, $currDate, 10);
		
		// Fetch Proxies
		$proxy_list	= $this->model_basic->getValues_conditions($this->proxiestable, '*', '', 'status = "1"');
		
		// Fetch useragents
		$useragent_list	= $this->model_basic->getValues_conditions($this->useragenttable, '*', '', 'id <> ""');
		
		$importData	= array();
		//pr($data);
		for($i=0; $i<count($data); $i++){
			$id = $data[$i]['id'];
			$campaign_id = $data[$i]['campaign_id'];
			$url = $data[$i]['url'];
			$keyword = $data[$i]['keyword'];
			$parse_url = parse_url($url);
			$host = $parse_url['host'];
			$replaced_domain_host	= str_replace("www.", "", $host);
			
			//echo $url . ' | ' . $host . '<br><br>';
			$whoisApiurl = 'http://whois.my-addr.com/api_parsed_json/2AC307DEF0FCEC41D30BF33683CD862B/' . $host;
			$json = file_get_contents($whoisApiurl);
			$result = json_decode($json,TRUE);
			//print_r($result);
			
			
			// Fetch Unique Campaign List
			$campaign_list	= $this->model_basic->getValues_conditions($this->campaignstable, '*', '', 'campaign_id = "'.$campaign_id.'"');
			$google_domain	= $campaign_list[0]['google_se_domain'];
			
			// B6 - creation Date[Site Age]
			$domain_creation_date =  $result['body']['domain']['created'];
			
			$importData['domain_creation_date'] = $domain_creation_date;
			
			// B7 - Site Size
			$pageCount	= $this->search_engine_crawler->get_google_site_size($google_domain, $replaced_domain_host);
			$importData['domain_page_count']	= $pageCount;
			
			// B8 - Site word count
			$wordCount	= $this->search_engine_crawler->get_site_word_count($url);
			$importData['domain_word_count']	= $wordCount;
			
			// B9 - Keyword ratio					
			$keywordRatio	= $this->search_engine_crawler->get_site_keyword_ratio_count($url, $keyword);
			$importData['domain_kw_ratio']	= $keywordRatio;
			
			
			// B10 - Keyword Optimization
			$keywordOptimization	= $this->search_engine_crawler->get_site_keyword_optimization($url, $keyword);
			$importData['keyword_in_url']		= $keywordOptimization['url'];
			$importData['keyword_in_title']		= $keywordOptimization['title'];
			$importData['keyword_in_meta_desc']	= $keywordOptimization['meta_desc'];
			$importData['keyword_in_h1']		= $keywordOptimization['h1'];
			$importData['keyword_in_h2']		= $keywordOptimization['h2'];
			
			
			// B11 - Exact KW Links
			$exact_match_anchor	= $this->search_engine_crawler->get_site_exact_kw_links($keyword, $url, $proxy_list, $useragent_list);
			$importData['exact_match_anchors']	= $exact_match_anchor['exact_match_count'];
			$importData['blended_match_anchors']	= $exact_match_anchor['blended_match_count'];
			$importData['brand_match_anchors']	= $exact_match_anchor['brand_match_count'];
			$importData['raw_url_match_anchors']	= $exact_match_anchor['raw_url_match_count'];
			$importData['domain_backlinks']		= $exact_match_anchor['backlinks_count'];
			
			// B12 - Hiding Links
			$hiding_link_count	= $this->search_engine_crawler->get_site_hiding_links($url, $proxy_list, $useragent_list);
			$importData['domain_hiding_links']	= $hiding_link_count;
			
			// B14 - external Links
			$external_links		= $this->search_engine_crawler->get_site_external_links($url);
			$importData['domain_external_links']	= $external_links;
		
			
			$this->model_campaign->updateCroncreationDate(TABLE_GOOGLE_CRAWL_DATA, $id, $importData );
			
			echo '<br>----------------------------------------------------------<br>';
		}
	}
	
	
	public function getbingcrawldata(){
		
		$currDate = date("Y-m-d");
		$data	= $this->model_campaign->getBingDataForCampaign(0, $currDate, 10);
		
		// Fetch Proxies
		$proxy_list	= $this->model_basic->getValues_conditions($this->proxiestable, '*', '', 'status = "1"');
		
		// Fetch useragents
		$useragent_list	= $this->model_basic->getValues_conditions($this->useragenttable, '*', '', 'id <> ""');
		
		$importData	= array();
		//pr($data);
		for($i=0; $i<count($data); $i++){
			$id = $data[$i]['id'];
			$campaign_id = $data[$i]['campaign_id'];
			$url = $data[$i]['url'];
			$keyword = $data[$i]['keyword'];
			$parse_url = parse_url($url);
			$host = $parse_url['host'];
			$replaced_domain_host	= str_replace("www.", "", $host);
			
			//echo $url . ' | ' . $host . '<br><br>';
			$whoisApiurl = 'http://whois.my-addr.com/api_parsed_json/2AC307DEF0FCEC41D30BF33683CD862B/' . $host;
			$json = file_get_contents($whoisApiurl);
			$result = json_decode($json,TRUE);
			//print_r($result);
			
			
			// Fetch Unique Campaign List
			$campaign_list	= $this->model_basic->getValues_conditions($this->campaignstable, '*', '', 'campaign_id = "'.$campaign_id.'"');
			$google_domain	= $campaign_list[0]['google_se_domain'];
			
			// B6 - creation Date[Site Age]
			$domain_creation_date =  $result['body']['domain']['created'];
			
			$importData['domain_creation_date'] = $domain_creation_date;
			
			// B7 - Site Size
			$pageCount	= $this->search_engine_crawler->get_google_site_size($google_domain, $replaced_domain_host);
			$importData['domain_page_count']	= $pageCount;
			
			// B8 - Site word count
			$wordCount	= $this->search_engine_crawler->get_site_word_count($url);
			$importData['domain_word_count']	= $wordCount;
			
			// B9 - Keyword ratio					
			$keywordRatio	= $this->search_engine_crawler->get_site_keyword_ratio_count($url, $keyword);
			$importData['domain_kw_ratio']	= $keywordRatio;
			
			
			// B10 - Keyword Optimization
			$keywordOptimization	= $this->search_engine_crawler->get_site_keyword_optimization($url, $keyword);
			$importData['keyword_in_url']		= $keywordOptimization['url'];
			$importData['keyword_in_title']		= $keywordOptimization['title'];
			$importData['keyword_in_meta_desc']	= $keywordOptimization['meta_desc'];
			$importData['keyword_in_h1']		= $keywordOptimization['h1'];
			$importData['keyword_in_h2']		= $keywordOptimization['h2'];
			
			
			// B11 - Exact KW Links
			$exact_match_anchor	= $this->search_engine_crawler->get_site_exact_kw_links($keyword, $url, $proxy_list, $useragent_list);
			$importData['exact_match_anchors']	= $exact_match_anchor['exact_match_count'];
			$importData['blended_match_anchors']	= $exact_match_anchor['blended_match_count'];
			$importData['brand_match_anchors']	= $exact_match_anchor['brand_match_count'];
			$importData['raw_url_match_anchors']	= $exact_match_anchor['raw_url_match_count'];
			$importData['domain_backlinks']		= $exact_match_anchor['backlinks_count'];
			
			// B12 - Hiding Links
			$hiding_link_count	= $this->search_engine_crawler->get_site_hiding_links($url, $proxy_list, $useragent_list);
			$importData['domain_hiding_links']	= $hiding_link_count;
			
			// B14 - external Links
			$external_links		= $this->search_engine_crawler->get_site_external_links($url);
			$importData['domain_external_links']	= $external_links;
		
			
			$this->model_campaign->updateCroncreationDate(TABLE_BING_CRAWL_DATA, $id, $importData );
			
			echo '<br>----------------------------------------------------------<br>';
		}
		

	}
	
	public function getYahoocrawldata(){
		
		$currDate = date("Y-m-d");
		$data	= $this->model_campaign->getYahooDataForCampaign(0, $currDate, 10);
		
		// Fetch Proxies
		$proxy_list	= $this->model_basic->getValues_conditions($this->proxiestable, '*', '', 'status = "1"');
		
		// Fetch useragents
		$useragent_list	= $this->model_basic->getValues_conditions($this->useragenttable, '*', '', 'id <> ""');
		
		$importData	= array();
		//pr($data);
		for($i=0; $i<count($data); $i++){
			$id = $data[$i]['id'];
			$campaign_id = $data[$i]['campaign_id'];
			$url = $data[$i]['url'];
			$keyword = $data[$i]['keyword'];
			$parse_url = parse_url($url);
			$host = $parse_url['host'];
			$replaced_domain_host	= str_replace("www.", "", $host);
			
			//echo $url . ' | ' . $host . '<br><br>';
			$whoisApiurl = 'http://whois.my-addr.com/api_parsed_json/2AC307DEF0FCEC41D30BF33683CD862B/' . $host;
			$json = file_get_contents($whoisApiurl);
			$result = json_decode($json,TRUE);
			//print_r($result);
			
			
			// Fetch Unique Campaign List
			$campaign_list	= $this->model_basic->getValues_conditions($this->campaignstable, '*', '', 'campaign_id = "'.$campaign_id.'"');
			$google_domain	= $campaign_list[0]['google_se_domain'];
			
			// B6 - creation Date[Site Age]
			$domain_creation_date =  $result['body']['domain']['created'];
			
			$importData['domain_creation_date'] = $domain_creation_date;
			
			// B7 - Site Size
			$pageCount	= $this->search_engine_crawler->get_google_site_size($google_domain, $replaced_domain_host);
			$importData['domain_page_count']	= $pageCount;
			
			// B8 - Site word count
			$wordCount	= $this->search_engine_crawler->get_site_word_count($url);
			$importData['domain_word_count']	= $wordCount;
			
			// B9 - Keyword ratio					
			$keywordRatio	= $this->search_engine_crawler->get_site_keyword_ratio_count($url, $keyword);
			$importData['domain_kw_ratio']	= $keywordRatio;
			
			
			// B10 - Keyword Optimization
			$keywordOptimization	= $this->search_engine_crawler->get_site_keyword_optimization($url, $keyword);
			$importData['keyword_in_url']		= $keywordOptimization['url'];
			$importData['keyword_in_title']		= $keywordOptimization['title'];
			$importData['keyword_in_meta_desc']	= $keywordOptimization['meta_desc'];
			$importData['keyword_in_h1']		= $keywordOptimization['h1'];
			$importData['keyword_in_h2']		= $keywordOptimization['h2'];
			
			
			// B11 - Exact KW Links
			$exact_match_anchor	= $this->search_engine_crawler->get_site_exact_kw_links($keyword, $url, $proxy_list, $useragent_list);
			$importData['exact_match_anchors']	= $exact_match_anchor['exact_match_count'];
			$importData['blended_match_anchors']	= $exact_match_anchor['blended_match_count'];
			$importData['brand_match_anchors']	= $exact_match_anchor['brand_match_count'];
			$importData['raw_url_match_anchors']	= $exact_match_anchor['raw_url_match_count'];
			$importData['domain_backlinks']		= $exact_match_anchor['backlinks_count'];
			
			// B12 - Hiding Links
			$hiding_link_count	= $this->search_engine_crawler->get_site_hiding_links($url, $proxy_list, $useragent_list);
			$importData['domain_hiding_links']	= $hiding_link_count;
			
			// B14 - external Links
			$external_links		= $this->search_engine_crawler->get_site_external_links($url);
			$importData['domain_external_links']	= $external_links;
		
			
			$this->model_campaign->updateCroncreationDate(TABLE_YAHOO_CRAWL_DATA, $id, $importData );
			
			echo '<br>----------------------------------------------------------<br>';
		}
				
		
	}
	
}

/* End of file cron.php */
/* Location: ./front-app/controllers/cron.php */