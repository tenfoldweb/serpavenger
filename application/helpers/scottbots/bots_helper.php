<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Global settings*/
ini_set('max_execution_time', '0');
ini_set('memory_limit', '-1');
error_reporting(0);

/*include files*/
require_once('includes/functions/simple_html_dom.php');
echo "asdf";
exit;
require_once('./serp_avenger/helpers/includes/functions/config.php');
require_once('./serp_avenger/helpers/includes/spiders/crawl.php');
require_once('./serp_avenger/helpers/includes/spiders/bot.php');

function get_top_tenwebsite($bot, $keyword, $location){
$keyword = str_replace(array('%20',' '),'+',$keyword);
$source = 'console';
$page = 1;
$delay = 0;

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
	echo "Bot-".$bot;
	echo "<br>";
	echo "keyword:-".$keyword;
	echo "<br>";	
	echo "Proxy :- ".$proxy;
	echo "<br>";
	echo "searchlocation-".	 $searchLocation;
		echo "<br>";
	echo "page-".$page;
exit;
	$botObject = new bot;
	$response = $botObject->initSpider($bot,$keyword, $proxy, $searchLocation,$page, $delay);
	echo "adsfsdf";
exit;
	unset($spider_object);

	ob_flush();
	echo $response;
}

}