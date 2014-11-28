<?php

/*Global settings*/
ini_set('max_execution_time', '0');
ini_set('memory_limit', '-1');
error_reporting(0);


/*include files*/
include_once('includes/functions/simple_html_dom.php');
include_once('includes/functions/config.php');
include_once('includes/spiders/crawl.php');
include_once('includes/spiders/bot.php');

$bot = isset($_REQUEST['bot']) ? $_REQUEST['bot'] : '';
$keyword = isset($_REQUEST['key']) ? str_replace(array('%20',' '),'+',$_REQUEST['key']) : '';
$location = isset($_REQUEST['loc']) ? $_REQUEST['loc'] : '';
$source = isset($_REQUEST['source']) ? $_REQUEST['source'] : 'console';
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$mainurl = $_REQUEST['siteurl'];
$delay = isset($_REQUEST['delay']) ? $_REQUEST['delay'] : 0;
$siteurl = (strncasecmp('http://', $mainurl, 7) && strncasecmp('https://', $mainurl, 8) ? 'http://' : '') . $mainurl;
$response = '';
if(empty($bot) || empty($keyword) || $page < 1)
	$response = json_encode(array('error'=>'Missing mendatory parameters (bot OR keyword) OR Page value incorrect (can not be less than 1).'));
else{
	/*Get proxy randomly*/
	$proxy = $proxy_array[rand(1,sizeof($proxy_array))];

	// Search Location
	$searchLocation = '';
	if($bot == 'gr')
		$searchLocation = $google_location_array[$location];
	elseif($bot == 'yahoo')
	    $searchLocation = $yahoo_location_array[$location];


	ob_start();

	$botObject = new bot;
	$response = $botObject->initSpider($bot,$keyword, $proxy, $searchLocation,$page, $delay);
	unset($spider_object);

	ob_flush();

}
	$responseArray = json_decode($response);

	if(sizeof($responseArray)<2){
			$proxy = $proxy_array[rand(1,sizeof($proxy_array))];
		$botObject = new bot;
		$response = $botObject->initSpider($bot,$keyword, $proxy, $searchLocation,$page, $delay);
		unset($spider_object);
	}
	//echo "<pre>";
	//print_r($responseArray);
//
if($siteurl!='' && $response!=''){
	$flag=0;
	$mainsiteurl =  get_domain($siteurl);
	$ave_top3=array('ranking'=>2,'backlinks'=>0,'refering'=>0,'sitewide'=>0,'do_fellow'=>0,'redirect'=>0,'image'=>0);
	$mean_top3=array('ranking'=>3,'backlinks'=>0,'refering'=>0,'sitewide'=>0,'do_fellow'=>0,'redirect'=>0,'image'=>0);
	$ave_top10=array('ranking'=>6,'backlinks'=>0,'refering'=>0,'sitewide'=>0,'do_fellow'=>0,'redirect'=>0,'image'=>0);
	$mean_top10=array('ranking'=>6,'backlinks'=>0,'refering'=>0,'sitewide'=>0,'do_fellow'=>0,'redirect'=>0,'image'=>0);
		$ancdata = array();
		$webdata=array();
		$sitedata = get_site_data($siteurl);
		$anchordata = get_anchor_data($siteurl);
		$ancdata[$siteurl]['url']=$siteurl;
		$ancdata[$siteurl]['subject']='YES';
		$ancdata[$siteurl]['mainback']=$sitedata->backlinks;
		$i=0;
		foreach($anchordata as $anchor){
			if($anchor->anchor!=''){
			//	echo $anchor->anchor .'<br>';
				$ancdata[$siteurl]['anchor'][$i]['text'] = $anchor->anchor;
				$ancdata[$siteurl]['anchor'][$i]['backlink'] = $anchor->backlinks;
				$ancdata[$siteurl]['anchor'][$i]['refpages'] = $anchor->refpages;
				$ancdata[$siteurl]['anchor'][$i]['refdomains'] = $anchor->refdomains;


				$i++;
			}
		}
		
		//$ancdata[$siteurl]['count'] = 

		$webdata[$siteurl]['url']=$mainurl;
		$webdata[$siteurl]['subject']='YES';
		$webdata[$siteurl]['ranking']='';
		$webdata[$siteurl]['backlinks']=$sitedata->backlinks;
		$webdata[$siteurl]['refering']=$sitedata->refpages;
		$webdata[$siteurl]['sitewide']=$sitedata->sitewide;
		$webdata[$siteurl]['do_follow']=$sitedata->dofollow;
		$webdata[$siteurl]['redirect']=$sitedata->redirect;
		$webdata[$siteurl]['image']=$sitedata->image;
		$responseArray = json_decode($response);
		

		$x=1;
		foreach($responseArray as $index => $res){

			
			
			$site_url = $res->description;
			$currentsiteurl =  get_domain($site_url);
			//echo $currentsiteurl.'--'.$mainsiteurl;
			if($currentsiteurl==$mainsiteurl && $webdata[$siteurl]['ranking']==''){
				$webdata[$siteurl]['ranking']=$x;
				$ancdata[$siteurl]['ranking']=$x;
				$flag=1;
			}
			if($site_url!=false && !in_array($site_url,$webdata) && $x<=11){
			
			
			$sitedata = get_site_data($site_url);
			$anchordata = get_anchor_data($site_url);
			if($x<11){
				$webstr .= "<tr><td>".$site_url."</td><td>no</td><td>$x</td><td>".$sitedata->backlinks."</td><td>".$sitedata->refpages."</td><td>".$sitedata->sitewide."</td><td>".$sitedata->dofollow."</td><td>".$sitedata->redirect."</td><td>".$sitedata->image."</td></tr>";
			}
		
			$webdata[$site_url]['url']=$site_url;
			$webdata[$site_url]['subject']='no';
			$webdata[$site_url]['ranking']=$x;
			$webdata[$site_url]['backlinks']=$sitedata->backlinks;
			$webdata[$site_url]['refering']=$sitedata->refpages;
			$webdata[$site_url]['sitewide']=$sitedata->sitewide;
			$webdata[$site_url]['do_follow']=$sitedata->dofollow;
			$webdata[$site_url]['redirect']=$sitedata->redirect;
			$webdata[$site_url]['image']=$sitedata->image;


			if($x<4){
			$ave_top3['backlinks']=$ave_top3['backlinks']+$sitedata->backlinks;
			$ave_top3['refering']=$ave_top3['refering']+$sitedata->refpages;
			$ave_top3['sitewide']=$ave_top3['sitewide']+$sitedata->sitewide;
			$ave_top3['do_follow']=$ave_top3['do_follow']+$sitedata->dofollow;
			$ave_top3['redirect']=$ave_top3['redirect'] +$sitedata->redirect;
			$ave_top3['image']=$ave_top3['image']+$sitedata->image;
			}
			if($x>1 && $x<5){
			$mean_top3['backlinks']=$mean_top3['backlinks']+$sitedata->backlinks;
			$mean_top3['refering']=$mean_top3['refering']+$sitedata->refpages;
			$mean_top3['sitewide']=$mean_top3['sitewide']+$sitedata->sitewide;
			$mean_top3['do_follow']=$mean_top3['do_follow']+$sitedata->dofollow;
			$mean_top3['redirect']=$mean_top3['redirect'] +$sitedata->redirect;
			$mean_top3['image']=$mean_top3['image']+$sitedata->image;
			}
			if($x>1 && $x<10){
			$mean_top10['backlinks']=$mean_top10['backlinks']+$sitedata->backlinks;
			$mean_top10['refering']=$mean_top10['refering']+$sitedata->refpages;
			$mean_top10['sitewide']=$mean_top10['sitewide']+$sitedata->sitewide;
			$mean_top10['do_follow']=$mean_top10['do_follow']+$sitedata->dofollow;
			$mean_top10['redirect']=$mean_top10['redirect'] +$sitedata->redirect;
			$mean_top10['image']=$mean_top10['image']+$sitedata->image;
			}

			if($x<11){
			$ave_top10['backlinks']=$ave_top10['backlinks']+$sitedata->backlinks;
			$ave_top10['refering']=$ave_top10['refering']+$sitedata->refpages;
			$ave_top10['sitewide']=$ave_top10['sitewide']+$sitedata->sitewide;
			$ave_top10['do_follow']=$ave_top10['do_follow']+$sitedata->dofollow;
			$ave_top10['redirect']=$ave_top10['redirect'] +$sitedata->redirect;
			$ave_top10['image']=$ave_top3['image']+$sitedata->image;
			}
				$i=0;
				$ancdata[$site_url]['url']=$site_url;
				$ancdata[$site_url]['ranking']=$x;
				$ancdata[$site_url]['subject']='no';
				$ancdata[$site_url]['mainback']=$sitedata->backlinks;
				foreach($anchordata as $anchor){

					if($anchor->anchor!=''){
						
					$per = ($anchor->backlinks/$sitedata->backlinks);
					$per = number_format($per*100,2);
					if($i==0){
						$ancstr .= "<tr><td>".$site_url."</td><td>no</td><td>$x</td><td>".$anchor->anchor."</td><td>".$anchor->backlink."</td><td>".$anchor->refpages."</td><td>".$anchor->refdomains."</td><td>".$per."</td></tr>";
					} else {
						$ancstr.="<tr><td></td><td></td><td></td><td>".$anchor->anchor."</td><td>".$anchor->backlink."</td><td>".$anchor->refpages."</td><td>".$anchor->refdomains."</td><td>".$per."</td></tr>";
					}
			
		
						//echo $anchor->anchor .'<br>';
						$ancdata[$site_url]['anchor'][$i]['text'] = $anchor->anchor;
						$ancdata[$site_url]['anchor'][$i]['backlink'] = $anchor->backlinks;
						$ancdata[$site_url]['anchor'][$i]['refpages'] = $anchor->refpages;
						$ancdata[$site_url]['anchor'][$i]['refdomains'] = $anchor->refdomains;
						$i++;
					}
				}
			
			
			}
			$x++;
		}
		if($flag==0){
			/*Get proxy randomly*/
			$proxy = $proxy_array[rand(1,sizeof($proxy_array))];

			// Search Location
			$searchLocation = '';
			if($bot == 'gr')
				$searchLocation = $google_location_array[$location];
			elseif($bot == 'yahoo')
				$searchLocation = $yahoo_location_array[$location];
			else
				$searchLocation ='';

			if($searchLocation!=''){
				ob_start();

				$botObject = new bot;
				$response = $botObject->initSpider($bot,$keyword, $proxy, $searchLocation,2, $delay);
				unset($spider_object);
		
				ob_flush();
				$responseArray = json_decode($response);
				foreach($responseArray as $index => $res){

				
				
					$site_url = $res->description;
					$currentsiteurl =  get_domain($site_url);
					if($currentsiteurl==$mainsiteurl && $webdata[$siteurl]['ranking']==''){
						$webdata[$siteurl]['ranking']=$x;
						$ancdata[$siteurl]['ranking']=$x;
						$flag=1;
						break;
					}
					$x++;
				}
			}
		}
		if($flag==0){
			$webdata[$siteurl]['ranking']='NA';
			$ancdata[$siteurl]['ranking']='NA';
		}

}

function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9.\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}


function get_site_data($sitename){
	$sitename = preg_replace("(^https?://)", "", $sitename );

	$webdata = file_get_contents("http://apiv2.ahrefs.com/?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&from=metrics&target=$sitename&mode=exact&output=json");
	$webdata = json_decode($webdata);
	return $webdata->metrics;
	
}


function get_anchor_data($sitename){
	$sitename = preg_replace("(^https?://)", "", $sitename );
	//echo $sitename;

//echo "http://apiv2.ahrefs.com/?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&from=anchors&target=$sitename&mode=exact&limit=20&output=json";
//echo "<br>";

	$webdata = file_get_contents("http://apiv2.ahrefs.com/?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&from=anchors&target=$sitename&mode=exact&limit=20&output=json");
	$webdata = json_decode($webdata);
	return $webdata->anchors;
	
}


if($source == 'gui'){
$sitewebstr =
"<tr><td>".$siteurl."</td><td>".$webdata[$siteurl]['subject']."</td><td>".$webdata[$siteurl]['ranking']."</td><td>".$webdata[$siteurl]['backlinks']."</td><td>".$webdata[$siteurl]['refering']."</td><td>".$webdata[$siteurl]['sitewide']."</td><td>".$webdata[$siteurl]['do_follow']."</td><td>".$webdata[$siteurl]['redirect']."</td><td>".$webdata[$siteurl]['image']."</td></tr>";


	echo '<table><tr><td>URL</td><td>Subject</td><td>Ranking</td><td>Backlinks</td><td>Refering</td><td>Sitewide</td><td>Do Follow</td><td>Redirect</td><td>Image</td></tr>'.$sitewebstr.$webstr;

	/*$len=0;
	foreach($webdata as $index => $res){
		
		echo "<tr><td>".$res['url']."</td><td>".$res['subject']."</td><td>".$res['ranking']."</td><td>".$res['backlinks']."</td><td>".$res['refering']."</td><td>".$res['sitewide']."</td><td>".$res['do_follow']."</td><td>".$res['redirect']."</td><td>".$res['image']."</td></tr>";
		$len++;
		if($len==11){break;}
		
	}*/
	
	echo "<tr><td>Average Top 3</td><td></td><td>".$ave_top3['ranking']."</td><td>".ceil($ave_top3['backlinks']/3)."</td><td>".ceil($ave_top3['refering']/3)."</td><td>".ceil($ave_top3['sitewide']/3)."</td><td>".ceil($ave_top3['do_follow']/3)."</td><td>".ceil($ave_top3['redirect']/3)."</td><td>".ceil($ave_top3['image']/3)."</td></tr>";

	echo "<tr><td>Mean Top 3</td><td></td><td>".$mean_top3['ranking']."</td><td>".ceil($mean_top3['backlinks']/3)."</td><td>".ceil($mean_top3['refering']/3)."</td><td>".ceil($mean_top3['sitewide']/3)."</td><td>".ceil($mean_top3['do_follow']/3)."</td><td>".ceil($mean_top3['redirect']/3)."</td><td>".ceil($mean_top3['image']/3)."</td></tr>";


	echo "<tr><td>Average Top 10</td><td></td><td>".$ave_top10['ranking']."</td><td>".ceil($ave_top10['backlinks']/3)."</td><td>".ceil($ave_top10['refering']/3)."</td><td>".ceil($ave_top10['sitewide']/3)."</td><td>".ceil($ave_top10['do_follow']/3)."</td><td>".ceil($ave_top10['redirect']/3)."</td><td>".ceil($ave_top10['image']/3)."</td></tr>";

	echo "<tr><td>Mean Top 3</td><td></td><td>".$mean_top10['ranking']."</td><td>".ceil($mean_top10['backlinks']/3)."</td><td>".ceil($mean_top10['refering']/3)."</td><td>".ceil($mean_top10['sitewide']/3)."</td><td>".ceil($mean_top10['do_follow']/3)."</td><td>".ceil($mean_top10['redirect']/3)."</td><td>".ceil($mean_top10['image']/3)."</td></tr>";


echo "</table><br>";
	echo '<table><tr><td>Anchor CHECK (top 20) 
</td><td>Subject</td><td>Ranking</td><td>Anchor</td><td>Count</td><td>Ref pages</td><td> Ref Domain</td><td>Percentage</td></tr>';

	
		
		$i=0;
		
		foreach($ancdata[$siteurl]['anchor'] as $anchor){
			$per = ($anchor['backlink']/$ancdata[$siteurl]['mainback']);
			$per = number_format($per*100,2);
			if($i==0){
				echo "<tr><td>".$siteurl."</td><td>".$ancdata[$siteurl]['subject']."</td><td>".$ancdata[$siteurl]['ranking']."</td><td>".$anchor['text']."</td><td>".$anchor['backlink']."</td><td>".$anchor['refpages']."</td><td>".$anchor['refdomains']."</td><td>".$per."</td></tr>";
			} else {
				echo "<tr><td></td><td></td><td></td><td>".$anchor['text']."</td><td>".$anchor['backlink']."</td><td>".$anchor['refpages']."</td><td>".$anchor['refdomains']."</td><td>".$per."</td></tr>";
			}
			$i++;
		}
		
	echo $ancstr."</table>";
	exit;
}else{
	$apiarr = array('backlinkdata'=>$webdata, 'anchordata'=>$ancdata);
	 echo json_encode($apiarr);
}
?>
