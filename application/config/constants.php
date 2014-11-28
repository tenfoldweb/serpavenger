<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');
 

define('FRONT_URL', 'http://localhost/serp_avenger/');
define('SERVER_ABSOLUTE_PATH', 'c:/xampp/htdocs/serp-new/');
define('FILE_UPLOAD_ABSOLUTE_PATH', 'c:/xampp/htdocs/serp-new/');
define('FRONT_SITE_THUMB_PATH','c:/xampp/htdocs/serp-new/campaignthumbs/');
define('FILE_UPLOAD_URL', 'http://localhost/upload/');
define('FRONT_SITE_THUMB_URL','http://localhost/serp-new/campaignthumbs/');
//define('FRONT_CSS_PATH', 'http://serpavenger.com/serp-new/css/');
define('FRONT_CSS_PATH', 'http://localhost/serp_avenger/css/');
define('FRONT_JS_PATH', 'http://localhost/serp-new/js/');
//define('FRONT_IMAGE_PATH', 'http://serpavenger.com/serp-new/images/');
define('FRONT_IMAGE_PATH', 'http://localhost/serp_avenger/images/');
define('FRONT_SCREENSHOT_PATH', 'http://localhost/serp_avenger/images/screenshots/');
//define('FRONT_FONT_PATH', 'http://serpavenger.com/serp-new/font/');
define('FRONT_IMAGE_PATH', 'http://localhost/serp_avenger/font/');
define('FRONT_FONTCSS_PATH', 'http://localhost/serp_avenger/font-awesome/css/');
define('APPPATH', 'c:/xampp/htdocs/serp_avenger/');
// TABLES
define('TABLE_PREFIX', 'serp_');
define('TABLE_USERS', TABLE_PREFIX . 'users'); 
define('TABLE_USERS_CAMPAIGN_MASTER', TABLE_PREFIX . 'users_campaign_master');
define('TABLE_USERS_CAMPAIGNS', TABLE_PREFIX . 'users_campaign_detail');

define('TABLE_USERS_CAMPAIGNS_TEST', TABLE_PREFIX . 'users_campaign_detail_test');
define('TABLE_USERS_CAMPAIGN_MASTER_TEST', TABLE_PREFIX . 'users_campaign_master_test');
define('TABLE_USERS_CAMPAIGNS_KEYWORD_TEST', TABLE_PREFIX . 'users_campaign_keywords_test');
define('TABLE_GOOGLE_CRAWL_DATA_TEST', TABLE_PREFIX . 'google_crawl_data_test');
define('TABLE_YAHOO_CRAWL_DATA_TEST', TABLE_PREFIX . 'yahoo_crawl_data_test');
define('TABLE_BING_CRAWL_DATA_TEST', TABLE_PREFIX . 'bing_crawl_data_test');


define('TABLE_SEARCH_ENGINES', TABLE_PREFIX . 'search_engines');
define('TABLE_USERS_CAMPAIGNS_KEYWORD', TABLE_PREFIX . 'users_campaign_keywords');
define('TABLE_USERS_CAMPAIGNS_KEYWORD_CPC_INFORMATION', TABLE_PREFIX . 'users_campaign_keyword_cpc_informations');
define('TABLE_PROXIES', TABLE_PREFIX . 'proxies');
define('TABLE_USERAGENTSTRINGS', TABLE_PREFIX . 'useragentstrings');
define('TABLE_GOOGLE_CRAWL_DATA', TABLE_PREFIX . 'google_crawl_data');
define('TABLE_YAHOO_CRAWL_DATA', TABLE_PREFIX . 'yahoo_crawl_data');
define('TABLE_BING_CRAWL_DATA', TABLE_PREFIX . 'bing_crawl_data');
define('TABLE_SEO_RANKING', TABLE_PREFIX . 'seo_ranking');


define('DEBUG_MODE',0);

/* End of file constants.php */
/* Location: ./application/config/constants.php */