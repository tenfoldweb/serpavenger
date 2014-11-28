<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Define Parser logger
 * 
 * @author Suvendu Patra <bcons4u@gmail.com>
 * @since July 10,2011
 * 
 * @copyright To suvendu patra
 */

class Parserlogger{
	public static function logger($log=null)
	{
		$file = "parser_log.log";
  		if(defined('LOG'))
  		{
  			$file = LOG;
  		}
  		$fp = fopen($file,'a+');
  		fwrite($fp,"[".date('Y-m-d H:i:s')."] : ".$log);
  		fclose($fp);
  	}
}