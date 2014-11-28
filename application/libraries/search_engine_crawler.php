<?php

class Search_engine_crawler {	
	
	private $CI;
	var $ahref_url	= 'http://api.ahrefs.com/get_backlinks_count_ext.php?target=';
	
	function __construct(){
		$CI =& get_instance();
		$CI->load->helper('dom');
	}
	
	function fetchSiteSize($url, $proxy, $useragent){		
		$proxyArray	= explode(":", $proxy);
		$proxy_ip	= $proxyArray[0];
		$proxy_port	= $proxyArray[1];
		$proxy_user	= $proxyArray[2];
		$proxy_pwd	= $proxyArray[3];		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_PROXY, $proxy_ip . ":" . $proxy_port);
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user . ":" . $proxy_pwd);
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
	
	function GoogleBackLinks($domain, $proxy, $useragent){		
		$proxyArray	= explode(":", $proxy);
		$proxy_ip	= $proxyArray[0];
		$proxy_port	= $proxyArray[1];
		$proxy_user	= $proxyArray[2];
		$proxy_pwd	= $proxyArray[3];
		
		$url="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=link:".$domain."&filter=0";
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT,$useragent);
		curl_setopt($ch, CURLOPT_PROXY, $proxy_ip . ":" . $proxy_port);
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user . ":" . $proxy_pwd);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$json = curl_exec($ch);
		curl_close($ch);
		$data=json_decode($json,true);
		echo '------------ Google Back Links ------------------<br>';
		pr($data, 0);
		echo '<br>';
		//if($data['responseStatus']==200)
		//return $data['responseData']['cursor']['resultCount'];
		//else
		//return false;
	}
	
	function GoogleIndexedPageCount($domain, $proxy, $useragent){
		$proxyArray	= explode(":", $proxy);
		$proxy_ip	= $proxyArray[0];
		$proxy_port	= $proxyArray[1];
		$proxy_user	= $proxyArray[2];
		$proxy_pwd	= $proxyArray[3];
		
		$url="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=site:".$domain."&filter=0";
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT,$useragent);
		curl_setopt($ch, CURLOPT_PROXY, $proxy_ip . ":" . $proxy_port);
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user . ":" . $proxy_pwd);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$json = curl_exec($ch);
		curl_close($ch);
		
		$data=json_decode($json,true);
		
		echo '------------ Google Indexed page Count ------------------<br>';
		pr($data, 0);
		echo '<br>';
		//if($data['responseStatus']==200)
		//return $data['responseData']['cursor']['resultCount'];
		//else
		//return false;
	}
	
	
	function getBetween($s,$s1,$s2=false,$offset=0){        
	    if( $s2 === false ) { $s2 = $s1; }
	    $result = array();
	    $L1 = strlen($s1);        
	    $L2 = strlen($s2);
	    
	
	    if( $L1==0 || $L2==0 ) { return false; }
		
	    do {
		$pos1 = strpos($s,$s1,$offset);
		
		if( $pos1 !== false ) 
		{
		    $pos1 += $L1;
	
		    $pos2 = strpos($s,$s2,$pos1);
	
		    if( $pos2 !== false ) 
		    {
			$key_len = $pos2 - $pos1;
			$this_key = substr($s,$pos1,$key_len); //trim this_key
						
						  preg_match_all("/<a[^>]+href\s*=\s*(\"|')?([^\"'\s>]+)/i", $this_key, $links);
									 
						  if (($links[2][0]!="") and !(stristr($links[2][0],"google"))) $result[] = $links[2][0]; //= link address 			  
						   
			 $offset = $pos2 + $L2;
		    } else 
		    {
			$pos1 = false;
		    }
		}
	    } while($pos1 !== false );
	
	    return $result;
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
	
	function get_google_crawler($keywordArray, $main_url, $cmp_id, $proxy_list, $useragent_list, $limit = 10){
		$returnArray	= array();
		if(is_array($keywordArray) && count($keywordArray) > 0){
			foreach($keywordArray AS $keyword){
				$rand_proxy	= $proxy_list[array_rand($proxy_list)];
				$rand_useragent	= $useragent_list[array_rand($useragent_list)];
				//pr($rand_proxy);
				
				$keywstring = str_replace(" ", "+", $keyword);           
				$pages=ceil($limit/100);
				
				$content="";
	    
				for($n=1;$n<=$pages;$n++){	
					if($n) $start=$n*100-100;
					$bypassCaptchaRequired	= false;
					$url="http://www.google.com/search?as_q=$keywstring&hl=en&client=firefox-a&channel=s&rls=org.mozilla%3Aen-US%3Aofficial&num=20&start=$start&btnG=Google+Search&as_epq=&as_oq=&as_eq=&lr=&as_ft=i&as_filetype=&as_qdr=all&as_occt=any&as_dt=i&as_sitesearch=&as_rights=&safe=images";
					
					$content = $this->get_content($url, $rand_proxy, $rand_useragent);
					//$html 		= str_get_html($content);
					//
					//foreach($html->find('input[name=id]') AS $node){
					//	$nodeValue		= $captcha_value_pair = $node->value;
					//	$nodeName		= $captcha_name_pair = $node->name;
					//	if($nodeName == 'id'){
					//		$bypassCaptchaRequired	= true;
					//	}
					//	$catptchaURL		= 'http://google.com/sorry/image?id='.$nodeValue.'&hl=en';
					//	echo 'CODE = ' . $CaptchaCode = breakcaptcha($catptchaURL);
					//	$url="http://www.google.com/search?as_q=$keywstring&hl=en&client=firefox-a&channel=s&rls=org.mozilla%3Aen-US%3Aofficial&num=20&start=$start&btnG=Google+Search&as_epq=&as_oq=&as_eq=&lr=&as_ft=i&as_filetype=&as_qdr=all&as_occt=any&as_dt=i&as_sitesearch=&as_rights=&safe=images&id=".$nodeValue."&captcha=" . $CaptchaCode;
					//	$content = $this->get_content($url, $rand_proxy, $rand_useragent); 
					//}
					
					
					if(!$bypassCaptchaRequired){						
						$res 	= $this->getBetween($content,"<h3","</h3>");
						
						$pos	= 0;
						while (list($key, $value) = each($res)){
							if(substr($value,0,4) == "http"){						 
								$pos++;						
								$returnArray[$keyword][$pos-1]['rank']	= $pos;
								$returnArray[$keyword][$pos-1]['url']	= $value;
								$returnArray[$keyword][$pos-1]['cmp_id']= $cmp_id;
								if($value == $main_url){
									$returnArray[$keyword][$pos-1]['main_url_pos']	= 'Yes';
								}else{
									$returnArray[$keyword][$pos-1]['main_url_pos']	= 'No';
								}
							}
							
						}
					}
					
				}            
				//sleep(10);
			}
		}
		return $returnArray;
	}
	
	function get_web_page( $url ){
	    $options = array(
		CURLOPT_RETURNTRANSFER => true,     // return web page
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle all encodings
		CURLOPT_USERAGENT      => "spider", // who am i
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		CURLOPT_TIMEOUT        => 120,      // timeout on response
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	    );
	
	    $ch      = curl_init( $url );
	    curl_setopt_array( $ch, $options );
	    $content = curl_exec( $ch );
	    $err     = curl_errno( $ch );
	    $errmsg  = curl_error( $ch );
	    $header  = curl_getinfo( $ch );
	    curl_close( $ch );
	
	    //$header['errno']   = $err;
	    //$header['errmsg']  = $errmsg;
	    //$header['content'] = $content;
	    return $content;
	}
	
	function fetchSiteCreationdate($r){
		$creation_date	= 0;
		$data = explode("<br />",nl2br($r));
		$data = array_unique($data);
		$new_data = array();
		//pr($data);
		foreach($data as $d){
		    $p = strpos($d,":");
		    if( $p > 0 ){
			$dp = explode(":",$d);
			if(trim($dp[0]) == 'Creation Date'){
				$creation_date	= strtotime(trim($dp[1]));
			}
		    }
		}
		return $creation_date;
	}
	
	function get_google_site_size($result){		
		$pageCount	= 0;
		$html	= str_get_html($result);
		
		// get the result content		
		//$html 	= file_get_html('http://www.' . $search_engine . '/search?q=site:'.$domain);
		
		foreach($html->find('div#resultStats') AS $result){
			$pos1 = strpos($result->plaintext, 'About');
			$pos2 = strpos($result->plaintext, 'results');			
			$pageCount	= str_replace(",", "", substr($result->plaintext, 6, $pos2-7));
		}
		return $pageCount;
	}
	
	function get_site_word_count($url){
		$content	= '';
		$WordCount	= 0;
		$WordCountArray	= array();
		$html 		= file_get_html($url);		
		foreach($html->find('body') AS $result){
			$content	= $result->plaintext;
		}
		if(!empty($content)){
			$WordCount 	= str_word_count($content, 0);			
		}		
		return $WordCount;
	}
	
	function get_site_keyword_ratio_count($url, $keyword){
		$WordCountArray	= array();
		$keyword_ratio	= 0;
		$html 		= file_get_html($url);
		//$keyword 	= str_replace(" ", "-", strtolower($keyword));
		// Get rid of style, script etc
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
			   '@<head>.*?</head>@siU',            // Lose the head section
			   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
		);
		
		$contents = preg_replace($search, '', $html); 
		
		$result = array_count_values(
			      str_word_count(
				  strip_tags($contents), 1
				  )
			      );		
		
		$sum = 0;
		
		$contents = strip_tags($contents);
		
		$kwCount = 0;
		$kwCount = substr_count(strtolower($contents), strtolower($keyword));
		
		$sum = str_word_count($contents);
		if($sum > 0){
		$keyword_ratio		= number_format((($kwCount/$sum)*100), 2);
		}
		

		/*if(is_array($result) && count($result) > 0){
			foreach($result AS $k=>$v){
				$sum = $sum+$v;
			}
			$kwCount = 0;
			if(isset($result[$keyword])){
				$kwCount = $result[$keyword];
			}
			
			$keyword_ratio		= number_format((($kwCount/$sum)*100), 2);
		}*/
		
		//foreach($html->find('body') AS $result){
		//	$content	= $result->plaintext;
		//}
		//
		//if(!empty($content)){
		//	$WordCount 		= str_word_count($content, 0);
		//	$keywordcount		= substr_count($content, $keyword);			
		//	$keyword_ratio		= round(($keywordcount/$WordCount)*100);
		//}
		return $keyword_ratio;
	}
	
	function get_site_keyword_optimization($url, $keyword){
		$keywordScore['url']		= 0;
		$keywordScore['title']		= 0;
		$keywordScore['meta_desc']	= 0;
		$keywordScore['h1']		= 0;
		$keywordScore['h2']		= 0;
		
		$html 		= file_get_html($url);
		
		// If keyword fount in url
		if(strpos($url,strtolower(urlencode($keyword)))!=''){
			$keywordScore['url'] = 1;
		}else{
			$keywordScore['url'] = 0;
		}
		
		// if keyword found in title
		foreach($html->find('title') AS $result){
			$content	= $result->plaintext;
			if(strpos(strtolower($content),strtolower($keyword))>-1){
			    $keywordScore['title'] = 1;
			    break;
			}
		}
		
		// if keyword found in Meta description
		foreach($html->find('mata[name="description"]') AS $result){
			$content	= $result->plaintext;
			if(strpos(strtolower($content),strtolower($keyword))>-1){
			    $keywordScore['meta_desc'] = 1;
			    break;
			}
		}
		
		// if keyword found in H1
		foreach($html->find('h1') AS $result){
			$content	= $result->plaintext;
			if(strpos(strtolower($content),strtolower($keyword))>-1){
			    $keywordScore['h1'] = 1;
			    break;
			}
		}
		
		// if keyword found in H2
		foreach($html->find('h2') AS $result){
			$content	= $result->plaintext;
			if(strpos(strtolower($content),strtolower($keyword))>-1){
			    $keywordScore['h2'] = 1;
			    break;
			}
		}
		return $keywordScore;
	}
	
	public function get_site_hiding_links($url, $proxy_list, $useragent_list){
		$rand_proxy	= $proxy_list[array_rand($proxy_list)];
		$rand_useragent	= $useragent_list[array_rand($useragent_list)];
		
		$urlArray	= parse_url($url);		
		$path		= '';
		$host	= $urlArray['host'];
		
		if(isset($urlArray['path']) && !empty($urlArray['path'])){
			$path	= $urlArray['path'];
		}
		$url	= $host . $path;
		$url	= 'http://api.ahrefs.com/get_backlinks_count_ext.php?target='.$url.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
		
		
		//$content = $this->get_content($url, $rand_proxy, $rand_useragent);
		$content = file_get_contents($url);
		$result = json_decode($content, true);
		$redirectCount	= $result['Result']['Redirect'];
		return $redirectCount;
	}
	
	public function get_site_external_links($url){		
		$countExternalLinks	= 0;
		$pUrl 		= parse_url($url);
		$html 		= file_get_html($url);
		
		foreach($html->find('a') AS $result){
			$href	= $result->href;			
			$pHref = parse_url($href);
			if(isset($pUrl['host']) && isset($pHref['host'])){
				if(strtolower($pUrl['host']) != strtolower($pHref['host'])){					
					$countExternalLinks++;
				}
			}
		}		
		return $countExternalLinks;
	}
	
	public function get_site_exact_kw_links($keyword, $url, $proxy_list, $useragent_list){		
		$exactMatchCount	= 0;
		$blendedMatchCount	= 0;
		$brandMatchCount	= 0;
		$rawUrlMatchCount	= 0;
		
		$rand_proxy		= $proxy_list[array_rand($proxy_list)];
		$rand_useragent		= $useragent_list[array_rand($useragent_list)];
		
		$purl 			= parse_url($url);
		$host			= $purl['host'];
		$path			= '';
		$domain 		= parse_url($url, PHP_URL_HOST);
		$domain 		= str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
		$domainArray		= explode('.', $domain);
		$domainName		= $domainArray[0];
		
		
		if(isset($purl['path'])){
			$path	= $purl['path'];
		}
		
		$chkDomain	= $host . $path;
		
		$ahref_url	= 'http://api.ahrefs.com/get_anchors_of_backlinks.php?target='.$chkDomain.'&count=20&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
		
		//$content 	= $this->get_content($ahref_url, $rand_proxy, $rand_useragent);
		$content	= file_get_contents($ahref_url);
		$result 	= json_decode($content, true);
		$result		= $result['Result'];		
		
		
		if(is_array($result) && count($result) > 0){
			for($i=0; $i<count($result); $i++){
				// Exact match
				if(strtolower($result[$i]['Text']) == strtolower($keyword)){
					$exactMatchCount++;
				}
				// Blended match
				if(strpos(strtolower($result[$i]['Text']),strtolower($keyword))>-1){
					$blendedMatchCount++;
				}
				// Brand match
				if(strpos(strtolower($result[$i]['Text']),strtolower($domainName))>-1){
					$brandMatchCount++;
				}
				// RAW url match
				if(strpos(strtolower($result[$i]['Text']),strtolower($domain))>-1){
					$rawUrlMatchCount++;
				}
			}
		}		
		
		$ahref_backlink_url	= 'http://api.ahrefs.com/get_backlinks_count_ext.php?target='.$chkDomain.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
		
		//$content 	= $this->get_content($ahref_backlink_url, $rand_proxy, $rand_useragent);
		$content	= file_get_contents($ahref_backlink_url);
		$result 	= json_decode($content, true);
		$result		= $result['Result'];
		$backlinks	= $result['Backlinks'];
		
		$rec['exact_match_count']	= $exactMatchCount;
		$rec['blended_match_count']	= $blendedMatchCount;
		$rec['brand_match_count']	= $brandMatchCount;
		$rec['raw_url_match_count']	= $rawUrlMatchCount;
		$rec['backlinks_count']		= $backlinks;
		
		return $rec;
	}
	
	function get_google_crawler_5proxy($keywordArray, $main_url, $cmp_id, $proxy_list, $useragent_list, $limit = 10){
		$returnArray	= array();
		$rand_proxy	= $proxy_list[array_rand($proxy_list)];
		$rand_useragent	= $useragent_list[array_rand($useragent_list)];
		if(is_array($keywordArray) && count($keywordArray) > 0){
			foreach($keywordArray AS $keyword){				
				
				$keywstring = str_replace(" ", "+", $keyword);           
				$pages=ceil($limit/100);
				
				$content="";
				for($i=0; $i<1; $i++){
					for($n=1;$n<=$pages;$n++){	
						if($n) $start=$n*100-100;
						$bypassCaptchaRequired	= false;
						$url="http://www.google.com/search?as_q=$keywstring&hl=en&client=firefox-a&channel=s&rls=org.mozilla%3Aen-US%3Aofficial&num=20&start=$start&btnG=Google+Search&as_epq=&as_oq=&as_eq=&lr=&as_ft=i&as_filetype=&as_qdr=all&as_occt=any&as_dt=i&as_sitesearch=&as_rights=&safe=images";
						
						echo $content = $this->get_content($url, $rand_proxy, $rand_useragent);
						
						if(!$bypassCaptchaRequired){						
							$res 	= $this->getBetween($content,"<h3","</h3>");
							
							$pos	= 0;
							while (list($key, $value) = each($res)){
								if(substr($value,0,4) == "http"){						 
									$pos++;						
									$returnArray[$keyword][$pos-1]['rank']	= $pos;
									$returnArray[$keyword][$pos-1]['url']	= $value;
									$returnArray[$keyword][$pos-1]['cmp_id']= $cmp_id;
									$returnArray[$keyword][$pos-1]['proxy']= $proxy_list[$i]['proxy'];
									if($value == $main_url){
										$returnArray[$keyword][$pos-1]['main_url_pos']	= 'Yes';
									}else{
										$returnArray[$keyword][$pos-1]['main_url_pos']	= 'No';
									}
								}
								
							}
						}
						
					}
				}
				//sleep(10);
			}
		}
		return $returnArray;
	}
}