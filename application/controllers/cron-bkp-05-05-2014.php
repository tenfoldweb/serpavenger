<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends MY_Controller {
	
	public function __construct(){
		parent::__construct();		
		$this->load->helper('dom');
		$this->load->model('model_basic');
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
	
	public function getPage($proxy, $url, $referer, $agent, $header, $timeout) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		
		$result['EXE'] = curl_exec($ch);
		$result['INF'] = curl_getinfo($ch);
		$result['ERR'] = curl_error($ch);
		
		curl_close($ch);
		
		return $result;
	}
	
	public function getContent($proxy_list, $url, $referer, $useragent_list, $header, $timeout) {		
		//echo 'URL = ' . $url . '<br>';
		$rand_proxy		= array_rand($proxy_list);
		$proxy			= $proxy_list[$rand_proxy]['proxy'];
		
		$proxyArray		= explode(":", $proxy);    
		$proxy_ip		= $proxyArray[0];
		$proxy_port		= $proxyArray[1];
		$proxy_user		= $proxyArray[2];
		$proxy_pwd		= $proxyArray[3];
		
		$proxy_login		= $proxy_user . ':' . $proxy_pwd;
		$proxy			= $proxy_ip . ':' . $proxy_port;
		
		$rand_useragent		= array_rand($useragent_list);
		$useragent		= $useragent_list[$rand_useragent]['useragent'];
		
		ob_start();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_login);//USER:PASSWORD
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		
		$result['EXE'] = curl_exec($ch);
		$result['INF'] = curl_getinfo($ch);
		$result['ERR'] = curl_error($ch);
		
		curl_close($ch);
		ob_flush();
		
		if($result['INF']['http_code'] == 200){			
			return $result;
			sleep(rand(5, 10));
		}else{			
			$this->getContent($proxy_list, $url, $referer, $useragent_list, $header, $timeout);
			sleep(rand(5, 10));
		}
	}
	
	public function crawler_google_bkp(){
		// Fetch Proxies
		$proxy_list	= $this->model_basic->getValues_conditions(TABLE_PROXIES, '*', '', 'status = "1"');
		
		// Fetch useragents
		$useragent_list	= $this->model_basic->getValues_conditions(TABLE_USERAGENTSTRINGS, '*', '', 'id <> ""');
		
		// Fetch campaign list
		$campaign_list	= $this->model_basic->getCampaignList('google');
		
		//pr($campaign_list, 0);
		
		$output	= array();
		if(is_array($campaign_list) && count($campaign_list) > 0){
			for($i=2; $i<3; $i++){
				$campaign_id		= $campaign_list[$i]['campaign_id'];
				$keyword		= $campaign_list[$i]['keyword'];
				$google_se_domain	= $campaign_list[$i]['google_se_domain'];
				$campaign_main_page_url	= $campaign_list[$i]['campaign_main_page_url'];
				$keywstring 		= str_replace(" ", "+", $keyword);
				$rand_proxy		= array_rand($proxy_list, 5);
				$rand_useragent		= array_rand($useragent_list, 5);
				
				$output		= array();
				$url = 'http://www.google.com/search?hl=en&as_q='.$keywstring.'&as_epq=&as_oq=&as_eq=&lr=&as_filetype=&ft=i&as_sitesearch=&as_qdr=all&as_rights=&as_occt=any&cr=&as_nlo=&as_nhi=&safe=images&num=100';
				for($j=0; $j<5; $j++){
					//echo 'LOOP = ' . $j . '<br>';
					$proxy			= $proxy_list[$rand_proxy[$j]]['proxy'];
					$proxyArray		= explode(":", $proxy);    
					$proxy_ip		= $proxyArray[0];
					$proxy_port		= $proxyArray[1];
					$proxy_user		= $proxyArray[2];
					$proxy_pwd		= $proxyArray[3];
					$proxy			= $proxy_user . ':' . $proxy_pwd . '@' . $proxy_ip . ':' . $proxy_port;
					//'user:password@173.234.11.134:54253';
					$proxy			= $proxy_ip . ':' . $proxy_port;
					$useragent		= $useragent_list[$rand_useragent[$j]];					
					$result 		= $this->getPage($proxy, $url, 'http://www.google.com/', trim($useragent['useragent']), '1', '0');
					//pr($result, 0);
					
					if (empty($result['ERR'])) {
						//$output1 = array();
						//pr($result['EXE'], 0);
						$trackMainPageURL= false;
						$html 	= str_get_html($result['EXE']);						
						$pos	= 0;
						foreach($html->find('li.g') as $g){						
							$pos++;
							$h3 		= $g->find('h3', 0);					
							$a 		= $h3->find('a', 0);
							if($a->href == $campaign_main_page_url){
								$main_url_pos		= 'Yes';
								$trackMainPageURL	= true;
							}else{
								$main_url_pos	= 'No';
							}
							$output[] 	= array(
										'title' 	=> $a->plaintext,
										'link' 		=> $a->href,
										'rank' 		=> $pos,
										'c_id'		=> $campaign_id,
										'keyword'	=> $keyword,
										'proxy'		=> $proxy,
										'main_url_pos'	=> $main_url_pos);
							if($pos >= 10){
								if($trackMainPageURL){
									break;	
								}
							}							
						}
						//pr($output1, 0);
					} else {
						echo 'ERROR<br>';
						pr($result['ERR'], 0);
						echo '<br>';
					}
					sleep(5);
				}
				
			}
		}
		pr($output, 0);
		if(is_array($output) && count($output) > 0){
			for($i=0; $i<count($output); $i++){
				$data['campaign_id']	= $output[$i]['c_id'];
				$data['proxy']		= $output[$i]['proxy'];
				$data['keyword']	= $output[$i]['keyword'];
				$data['title']		= $output[$i]['title'];
				$data['url']		= $output[$i]['link'];
				$data['rank']		= $output[$i]['rank'];
				$data['main_url_pos']	= $output[$i]['main_url_pos'];
				$data['date_added']	= date("Y-m-d");
				$this->model_basic->insertCrawlData('google', $data);
			}
		}
	}
	
	// Google crawl
	public function crawler_google(){
		// Fetch Proxies
		$proxy_list	= $this->model_basic->getValues_conditions(TABLE_PROXIES, '*', '', 'status = "1"');
		
		// Fetch useragents
		$useragent_list	= $this->model_basic->getValues_conditions(TABLE_USERAGENTSTRINGS, '*', '', 'id <> ""');
		
		// Fetch campaign list
		$campaign_list	= $this->model_basic->getCampaignList('google');
		
		//pr($campaign_list, 0);
		
		$output	= array();
		if(is_array($campaign_list) && count($campaign_list) > 0){
			for($i=0; $i<count($campaign_list); $i++){
				$campaign_id		= $campaign_list[$i]['campaign_id'];
				$keyword		= $campaign_list[$i]['keyword'];
				$google_se_domain	= $campaign_list[$i]['google_se_domain'];
				$campaign_main_page_url	= $campaign_list[$i]['campaign_main_page_url'];
				
				$keywstring 		= str_replace(" ", "+", $keyword);
				$referrer		= 'http://' . $google_se_domain . '/';
				echo $url = 'http://'.$google_se_domain.'/search?hl=en&as_q='.$keywstring.'&as_epq=&as_oq=&as_eq=&lr=&as_filetype=&ft=i&as_sitesearch=&as_qdr=all&as_rights=&as_occt=any&cr=&as_nlo=&as_nhi=&safe=images&num=100';
				echo '<br>';				
				
				$result 		= $this->getContent($proxy_list, $url, $referrer, $useragent_list, '1', '0');
				pr($result, 0);
				exit;
				if (empty($result['ERR'])) {					
					$trackMainPageURL= false;
					$html 	= str_get_html($result['EXE']);						
					$pos	= 0;
					foreach($html->find('li.g') as $g){						
						$pos++;
						$h3 		= $g->find('h3', 0);					
						$a 		= $h3->find('a', 0);
						if($a->href == $campaign_main_page_url){
							$main_url_pos		= 'Yes';
							$trackMainPageURL	= true;
						}else{
							$main_url_pos	= 'No';
						}
						$output[] 	= array(
									'title' 	=> $a->plaintext,
									'link' 		=> $a->href,
									'rank' 		=> $pos,
									'c_id'		=> $campaign_id,
									'keyword'	=> $keyword,
									'main_url_pos'	=> $main_url_pos);
						if($pos >= 10){
							if($trackMainPageURL){
								break;	
							}
						}							
					}					
				} else {
					echo 'ERROR<br>';
					pr($result['ERR'], 0);
					echo '<br>';
				}
				//sleep(rand(10, 15));
			}
		}
		pr($output);
		if(is_array($output) && count($output) > 0){
			for($i=0; $i<count($output); $i++){
				$data['campaign_id']	= $output[$i]['c_id'];				
				$data['keyword']	= $output[$i]['keyword'];
				$data['title']		= $output[$i]['title'];
				$data['url']		= $output[$i]['link'];
				$data['rank']		= $output[$i]['rank'];
				$data['main_url_pos']	= $output[$i]['main_url_pos'];
				$data['date_added']	= date("Y-m-d");
				$this->model_basic->insertCrawlData('google', $data);
			}
		}
	}
	
	// yahoo crawl
	public function crawler_yahoo(){
		// Fetch Proxies
		$proxy_list	= $this->model_basic->getValues_conditions(TABLE_PROXIES, '*', '', 'status = "1"');
		
		// Fetch useragents
		$useragent_list	= $this->model_basic->getValues_conditions(TABLE_USERAGENTSTRINGS, '*', '', 'id <> ""');
		
		// Fetch campaign list
		$campaign_list	= $this->model_basic->getCampaignList('yahoo');
		
		//pr($campaign_list, 0);
		
		$output	= array();
		if(is_array($campaign_list) && count($campaign_list) > 0){
			for($i=0; $i<count($campaign_list); $i++){
				$campaign_id		= $campaign_list[$i]['campaign_id'];
				$keyword		= $campaign_list[$i]['keyword'];
				$yahoo_se_domain	= $campaign_list[$i]['yahoo_se_domain'];
				$campaign_main_page_url	= $campaign_list[$i]['campaign_main_page_url'];				
				
				$keywstring 		= str_replace(" ", "+", $keyword);				
				$referrer		= 'http://' . $yahoo_se_domain . '/';
				//$url 			= 'https://search.yahoo.com/search?p='.$keywstring.'&b=1&pstart=40';
				
				$page_num		= 10;
				$per_page		= 10;
				$pos			= 0;
				for($pg=1; $pg<=$page_num; $pg++){					
					$first	= (($pg*$per_page)-$per_page)+1;
					$url	= 'http://'.$yahoo_se_domain.'/search?p='.$keywstring.'&n='.$per_page.'&b='.$first;					
					
					$result = $this->getContent($proxy_list, $url, $referrer, $useragent_list, '1', '0');
					if (empty($result['ERR'])) {					
						$trackMainPageURL= false;
						$html 	= str_get_html($result['EXE']);					
						
						foreach($html->find('div#web h3') as $h3){
							if($pos >= 1){
								$a 		= $h3->find('a', 0);						
								$href 		= urldecode($a->href);						
								$position1	= strpos($href, 'RU=');
								$position2	= strpos($href, 'RK=');						
								$href		= substr($href, $position1+3, ($position2-$position1)-4);
								
								if($href == $campaign_main_page_url){
									$main_url_pos		= 'Yes';
									$trackMainPageURL	= true;
								}else{
									$main_url_pos	= 'No';
								}
								
								$output[] 	= array(
										'title' 	=> $a->plaintext,
										'link' 		=> $href,
										'rank' 		=> $pos,
										'c_id'		=> $campaign_id,
										'keyword'	=> $keyword,
										'main_url_pos'	=> $main_url_pos);
								
								//if($pos >= 10){
								//	if($trackMainPageURL){
								//		break;	
								//	}
								//}	
							}						
							$pos++;					
						}						
					} else {
						echo 'ERROR<br>';
						pr($result['ERR'], 0);
						echo '<br>';
					}					
					echo '<h3>URL: '.$url.'</h3><br>';
					echo '<h3>Page: '.$pg.' | Keyword: '.$keyword.'</h3><br>';
					pr($output, 0);
					//sleep(rand(10, 15));
				}
				
				//$url			= 'http://'.$yahoo_se_domain.'/search?_adv_prop=web&x=op&ei=UTF-8&prev_vm=p&va='.$keywstring.'&va_vt=any&vp=&vp_vt=any&vo=&vo_vt=any&ve=&ve_vt=any&vd=all&vst=0&vs=&vf=all&vm=p%22.%22&vc=&fl=0&n=100&b=1';
				
				//sleep(rand(10, 15));
			}
		}
		if(is_array($output) && count($output) > 0){
			for($i=0; $i<count($output); $i++){
				$data['campaign_id']	= $output[$i]['c_id'];				
				$data['keyword']	= $output[$i]['keyword'];
				$data['title']		= $output[$i]['title'];
				$data['url']		= $output[$i]['link'];
				$data['rank']		= $output[$i]['rank'];
				$data['main_url_pos']	= $output[$i]['main_url_pos'];
				$data['date_added']	= date("Y-m-d");
				$this->model_basic->insertCrawlData('yahoo', $data);
			}
		}
	}
	
	// bing crawl
	public function crawler_bing(){
		// Fetch Proxies
		$proxy_list	= $this->model_basic->getValues_conditions(TABLE_PROXIES, '*', '', 'status = "1"');
		
		// Fetch useragents
		$useragent_list	= $this->model_basic->getValues_conditions(TABLE_USERAGENTSTRINGS, '*', '', 'id <> ""');
		
		// Fetch campaign list
		$campaign_list	= $this->model_basic->getCampaignList('yahoo');
		
		//pr($campaign_list, 0);
		$output	= array();
		if(is_array($campaign_list) && count($campaign_list) > 0){
			for($i=0; $i<count($campaign_list); $i++){
				$campaign_id		= $campaign_list[$i]['campaign_id'];
				$keyword		= $campaign_list[$i]['keyword'];
				$bing_se_domain		= $campaign_list[$i]['bing_se_domain'];
				$campaign_main_page_url	= $campaign_list[$i]['campaign_main_page_url'];
				
				$keywstring 		= str_replace(" ", "+", $keyword);
				$referrer		= 'http://' . $bing_se_domain . '/';
				$page_num		= 10;
				$per_page		= 10;
				$pos			= 0;
				for($pg=1; $pg<=$page_num; $pg++){					
					$first	= (($pg*$per_page)-$per_page)+1;
					$url 	= "http://".$bing_se_domain."/search?q=" . $keywstring . "&count=".$per_page."&first=".$first."&FORM=PERE";										
					$result = $this->getContent($proxy_list, $url, $referrer, $useragent_list, '1', '0');
					//pr($result, 0);
					if (empty($result['ERR'])) {					
						$trackMainPageURL= false;
						$html 	= str_get_html($result['EXE']);
						foreach($html->find('li.b_algo h2') as $h2){
							$pos++;
							$a 		= $h2->find('a', 0);					
							$href 		= urldecode($a->href);
							
							if($href == $campaign_main_page_url){
								$main_url_pos		= 'Yes';
								$trackMainPageURL	= true;
							}else{
								$main_url_pos	= 'No';
							}
							
							$output[] 	= array(
									'title' 	=> $a->plaintext,
									'link' 		=> $href,
									'rank' 		=> $pos,
									'c_id'		=> $campaign_id,
									'keyword'	=> $keyword,
									'main_url_pos'	=> $main_url_pos);
							
							//if($pos >= 10){
							//	if($trackMainPageURL){
							//		break;	
							//	}
							//}
								
						}					
					} else {
						echo 'ERROR<br>';
						pr($result['ERR'], 0);
						echo '<br>';
					}
					//echo '<h3>URL: '.$url.'</h3><br>';
					//echo '<h3>Page: '.$pg.' | Keyword: '.$keyword.'</h3><br>';
					//pr($output, 0);				
					//sleep(rand(10, 15));
				}
			}
		}
		pr($output, 0);
		if(is_array($output) && count($output) > 0){
			for($i=0; $i<count($output); $i++){
				$data['campaign_id']	= $output[$i]['c_id'];				
				$data['keyword']	= $output[$i]['keyword'];
				$data['title']		= $output[$i]['title'];
				$data['url']		= $output[$i]['link'];
				$data['rank']		= $output[$i]['rank'];
				$data['main_url_pos']	= $output[$i]['main_url_pos'];
				$data['date_added']	= date("Y-m-d");
				pr($data, 0);
				$this->model_basic->insertCrawlData('bing', $data);
			}
		}
	}
}

/* End of file cron.php */
/* Location: ./front-app/controllers/cron.php */