<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*include files*/

function get_top_tenwebsite($bot, $keyword, $location='usa'){
$keyword = str_replace(array('%20',' '),'+',$keyword);
$source = 'console';
$page = 1;
$delay = 0;
$data = json_decode(file_get_contents('http://www.serpavenger.com/scottbots/service.php?key='.$keyword.'&bot='.$bot.'&loc='.$location.'&page=1'));
return $data;
}