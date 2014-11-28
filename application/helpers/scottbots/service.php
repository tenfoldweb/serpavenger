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
$delay = isset($_REQUEST['delay']) ? $_REQUEST['delay'] : 0;

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
if($source == 'gui'){
	$responseArray = json_decode($response);
	foreach($responseArray as $index => $res){
		echo ($index+1).'.'.$res->title.'<br />'.$res->url.'<br />'.$res->description.'<hr />';
	}
}else
	echo $response;

?>
