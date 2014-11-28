<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends MY_Controller {
	
	var $campaignstable = 'serp_users_campaign_detail';
	var $useragenttable = 'serp_useragentstrings';
	var $proxiestable   = 'serp_proxies';
	
	public function __construct(){
		parent::__construct();		
		$this->load->helper('dom');
		$this->load->library('search_engine_crawler');	
		$this->load->model('model_basic');
		$this->load->model('model_campaign_cron');
	}
	
	
	function get_content($url, $proxy, $useragent){
	    $proxy		= $proxy['proxy'];
	    $proxyArray		= explode(":", $proxy);
	    
	    $proxy_ip		= $proxyArray[0];
	    $proxy_port		= $proxyArray[1];
	    $proxy_username	= $proxyArray[2];
	    $proxy_pwd		= $proxyArray[3];
	    
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);	    
	    curl_setopt($ch, CURLOPT_USERAGENT, trim($useragent['useragent']));
	    curl_setopt($ch, CURLOPT_PROXY, trim($proxy_ip) . ':' . trim($proxy_port));
	    curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
	    curl_setopt($ch, CURLOPT_PROXYUSERPWD, trim($proxy_username) . ':' . trim($proxy_pwd));
	    curl_setopt($ch, CURLOPT_TIMEOUT, 400);
	    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    $data = curl_exec($ch); 
	    curl_close ($ch);        
		  
	    return $data;    
	}
	
	public function getgooglecrawldata(){
		$limit = "LIMIT 0,10";
		$currDate = date("Y-m-d");
		$data	= $this->model_campaign_cron->getGoogleDataForCampaign(0, $currDate, $limit);
		
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
			if(!isset($parse_url['host']) && !empty($parse_url['host'])){
				$host = $parse_url['host'];
			}else{
				$host = '';
			}
			
			$path  = '';
			if(isset($parse_url['path']) && !empty($parse_url['path'])){
				$path	= $parse_url['path'];
			}
			
			//$new_url = $host.$path;
			
			if(!empty($host)){
				$replaced_domain_host	= str_replace("www.", "", $host);
				
				$rand_proxy	= $proxy_list[array_rand($proxy_list)];
				$rand_useragent	= $useragent_list[array_rand($useragent_list)];
				
				//echo $url . ' | ' . $host . '<br><br>';
				$whoisApiurl = 'http://whois.my-addr.com/api_parsed_json/2AC307DEF0FCEC41D30BF33683CD862B/' . $host;
				//$json = file_get_contents($whoisApiurl);
				$json = $this->get_content($whoisApiurl, $rand_proxy, $rand_useragent);
				$result = json_decode($json,TRUE);
				
				
				
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
				
				
				//entertaintment data //	
							
				
				 $entertaintmentJsonUrl  	=  'http://api.ahrefs.com/get_backlinks_count_ext.php?target='.$url.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
				
				$jsonvalue  			= $this->get_content($entertaintmentJsonUrl, $rand_proxy, $rand_useragent);
				$entertaintment_result 		= json_decode($jsonvalue,TRUE);
				
				//print_r($entertaintment_result);
				//echo '<br>';
				$domain_text =  $entertaintment_result['Result']['Text'];			
				$importData['domain_text'] = $domain_text;
				
				$domain_Image =  $entertaintment_result['Result']['Image'];
				$importData['domain_image'] = $domain_Image;
				
				$domain_Redirect =  $entertaintment_result['Result']['Redirect'];
				$importData['domain_redirect'] = $domain_Redirect;
				
				
				$domain_Frame =  $entertaintment_result['Result']['Frame'];
				$importData['domain_frame'] = $domain_Frame;
				
				
				$domain_Form =  $entertaintment_result['Result']['Form'];
				$importData['domain_form'] = $domain_Form;
				
				$domain_Canonical =  $entertaintment_result['Result']['Canonical'];
				$importData['domain_canonical'] = $domain_Canonical;
				
				$domain_Sitewide =  $entertaintment_result['Result']['Sitewide'];
				$importData['domain_sitewide'] = $domain_Sitewide;
				
				
				$domain_NotSitewide =  $entertaintment_result['Result']['NotSitewide'];
				$importData['domain_notsitewide'] = $domain_NotSitewide;
				
				$domain_NoFollow =  $entertaintment_result['Result']['NoFollow'];
				$importData['domain_nofollow'] = $domain_NoFollow;
				
				
				$domain_DoFollow =  $entertaintment_result['Result']['DoFollow'];
				$importData['domain_dofollow'] = $domain_DoFollow;
				//print_r($importData);
				
				
				$this->model_campaign_cron->updateCroncreationDate(TABLE_GOOGLE_CRAWL_DATA, $id, $importData );
				
				echo '<br>----------------------------------------------------------<br>';
			}
		}
	}
	
	
	public function getbingcrawldata(){
		
		$currDate = date("Y-m-d");
		
		$limit = "LIMIT 0,10";
		$data	= $this->model_campaign_cron->getBingDataForCampaign(0, $currDate, $limit);
		
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
			
			if(!isset($parse_url['host']) && !empty($parse_url['host'])){
				$host = $parse_url['host'];
			}else{
				$host = '';
			}
			
			if(!empty($host)){
				$replaced_domain_host	= str_replace("www.", "", $host);
				
				//echo $url . ' | ' . $host . '<br><br>';
				$whoisApiurl = 'http://whois.my-addr.com/api_parsed_json/2AC307DEF0FCEC41D30BF33683CD862B/' . $host;
				$json = file_get_contents($whoisApiurl);
				$result = json_decode($json,TRUE);
				//print_r($result);
				
				
				// Fetch Unique Campaign List
				$campaign_list	= $this->model_basic->getValues_conditions($this->campaignstable, '*', '', 'campaign_id = "'.$campaign_id.'"');
				$bing_domain	= $campaign_list[0]['bing_se_domain'];
				
				// B6 - creation Date[Site Age]
				$domain_creation_date =  $result['body']['domain']['created'];
				
				$importData['domain_creation_date'] = $domain_creation_date;
				
				// B7 - Site Size
				$pageCount	= $this->search_engine_crawler->get_google_site_size($bing_domain, $replaced_domain_host);
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
				
				
				
				
				//entertaintment data //	
							
				
				$entertaintmentJsonUrl  	=  'http://api.ahrefs.com/get_backlinks_count_ext.php?target='.$url.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
				
				$jsonvalue  			= $this->get_content($entertaintmentJsonUrl, $rand_proxy, $rand_useragent);
				$entertaintment_result 		= json_decode($jsonvalue,TRUE);
				
				
				$domain_text =  $entertaintment_result['Result']['Text'];			
				$importData['domain_text'] = $domain_text;
				
				$domain_Image =  $entertaintment_result['Result']['Image'];
				$importData['domain_image'] = $domain_Image;
				
				$domain_Redirect =  $entertaintment_result['Result']['Redirect'];
				$importData['domain_redirect'] = $domain_Redirect;
				
				
				$domain_Frame =  $entertaintment_result['Result']['Frame'];
				$importData['domain_frame'] = $domain_Frame;
				
				
				$domain_Form =  $entertaintment_result['Result']['Form'];
				$importData['domain_form'] = $domain_Form;
				
				$domain_Canonical =  $entertaintment_result['Result']['Canonical'];
				$importData['domain_canonical'] = $domain_Canonical;
				
				$domain_Sitewide =  $entertaintment_result['Result']['Sitewide'];
				$importData['domain_sitewide'] = $domain_Sitewide;
				
				
				$domain_NotSitewide =  $entertaintment_result['Result']['NotSitewide'];
				$importData['domain_notsitewide'] = $domain_NotSitewide;
				
				$domain_NoFollow =  $entertaintment_result['Result']['NoFollow'];
				$importData['domain_nofollow'] = $domain_NoFollow;
				
				
				$domain_DoFollow =  $entertaintment_result['Result']['DoFollow'];
				$importData['domain_dofollow'] = $domain_DoFollow;
			
				
				$this->model_campaign_cron->updateCroncreationDate(TABLE_BING_CRAWL_DATA, $id, $importData );
				
				echo '<br>----------------------------------------------------------<br>';
			}
		}
		

	}
	
	public function getYahoocrawldata(){
		
		$currDate = date("Y-m-d");
		$limit = "LIMIT 0,10";
		$data	= $this->model_campaign_cron->getYahooDataForCampaign(0, $currDate, $limit);
		
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
			
			if(!isset($parse_url['host']) && !empty($parse_url['host'])){
				$host = $parse_url['host'];
			}else{
				$host = '';
			}
			
			if(!empty($host)){
				$replaced_domain_host	= str_replace("www.", "", $host);
				
				//echo $url . ' | ' . $host . '<br><br>';
				$whoisApiurl = 'http://whois.my-addr.com/api_parsed_json/2AC307DEF0FCEC41D30BF33683CD862B/' . $host;
				$json = file_get_contents($whoisApiurl);
				$result = json_decode($json,TRUE);
				//print_r($result);
				
				
				// Fetch Unique Campaign List
				$campaign_list	= $this->model_basic->getValues_conditions($this->campaignstable, '*', '', 'campaign_id = "'.$campaign_id.'"');
				$yahoo_domain	= $campaign_list[0]['yahoo_se_domain'];
				
				// B6 - creation Date[Site Age]
				$domain_creation_date =  $result['body']['domain']['created'];
				
				$importData['domain_creation_date'] = $domain_creation_date;
				
				// B7 - Site Size
				$pageCount	= $this->search_engine_crawler->get_google_site_size($yahoo_domain, $replaced_domain_host);
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
				
				
				
				
				//entertaintment data //	
							
				
				$entertaintmentJsonUrl  	=  'http://api.ahrefs.com/get_backlinks_count_ext.php?target='.$url.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
				
				$jsonvalue  			= $this->get_content($entertaintmentJsonUrl, $rand_proxy, $rand_useragent);
				$entertaintment_result 		= json_decode($jsonvalue,TRUE);
				
				
				$domain_text =  $entertaintment_result['Result']['Text'];			
				$importData['domain_text'] = $domain_text;
				
				$domain_Image =  $entertaintment_result['Result']['Image'];
				$importData['domain_image'] = $domain_Image;
				
				
				$domain_Redirect =  $entertaintment_result['Result']['Redirect'];
				$importData['domain_redirect'] = $domain_Redirect;
				
				
				$domain_Frame =  $entertaintment_result['Result']['Frame'];
				$importData['domain_frame'] = $domain_Frame;
				
				
				$domain_Form =  $entertaintment_result['Result']['Form'];
				$importData['domain_form'] = $domain_Form;
				
				$domain_Canonical =  $entertaintment_result['Result']['Canonical'];
				$importData['domain_canonical'] = $domain_Canonical;
				
				$domain_Sitewide =  $entertaintment_result['Result']['Sitewide'];
				$importData['domain_sitewide'] = $domain_Sitewide;
				
				
				$domain_NotSitewide =  $entertaintment_result['Result']['NotSitewide'];
				$importData['domain_notsitewide'] = $domain_NotSitewide;
				
				$domain_NoFollow =  $entertaintment_result['Result']['NoFollow'];
				$importData['domain_nofollow'] = $domain_NoFollow;
				
				
				$domain_DoFollow =  $entertaintment_result['Result']['DoFollow'];
				$importData['domain_dofollow'] = $domain_DoFollow;
			
				
				$this->model_campaign_cron->updateCroncreationDate(TABLE_YAHOO_CRAWL_DATA, $id, $importData );
				
				echo '<br>----------------------------------------------------------<br>';
			}
		}
				
		
	}
	
}

/* End of file cron.php */
/* Location: ./front-app/controllers/cron.php */