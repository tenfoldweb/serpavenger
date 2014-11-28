<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/** Defines the Cinema_Http_Client_Adapter_Curl class.
 *
 * @package ELMS
 * @subpackage SPIDER
 */

/** Specialized cURL adapter for ELMS.
 *
 * @package HTTP
 */
require_once dirname(__FILE__)."/../../../parselogger.php";

class Cinema_Http_Client_Adapter_Curl
{
  protected

    /** cURL handle.
     *
     * @var resource
     */
    $myHandle,

    /** Stores the requested URL.
     *
     * @var string
     */
    $myURL,

    /**
     * Store cookie file name
     * @var string
     */
    $cookiefile,

    /** Stores the response from the server.
     *
     * @var string
     */
    $myResponse;


  /** Connect to the remote server
   *
   * @param string  $host
   * @param int     $port
   * @param boolean $secure
   */
  public function connect( $host='', $port = 80, $secure = false,$headerOn=true)
  {
    $this->myHandle = curl_init();

    curl_setopt_array
    (
        $this->myHandle
      , array
        (
            CURLOPT_HTTPHEADER =>
              array
              (
                  'User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.0.1) Gecko/2008070206 Firefox/3.0.1'
                , 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
                , 'Accept-Language: en-us,en;q=0.5'
                , 'Accept-Encoding: gzip,deflate'
                , 'Accept-Charset: utf-8,iso-8859-1;q=0.7,*;q=0.7'
                , 'Keep-Alive: 300'
                , 'Connection: keep-alive'
              )
          , CURLOPT_ENCODING        => ''
          , CURLOPT_HEADER          => $headerOn
          , CURLOPT_RETURNTRANSFER  => true
         )
    );

    curl_setopt($this->myHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->myHandle, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($this->myHandle, CURLOPT_TIMEOUT, 60);
    curl_setopt($this->myHandle,CURLOPT_MAXREDIRS,5);

    $cookiefile = dirname(__FILE__).DIRECTORY_SEPARATOR."cookie";
    $this->cookiefile = tempnam($cookiefile,'curl_');

    curl_setopt($this->myHandle, CURLOPT_COOKIEFILE, $this->cookiefile);
    curl_setopt($this->myHandle, CURLOPT_COOKIEJAR, $this->cookiefile);

    /* Init $myURL so that initSession() can use it. */
    $this->myURL = $host;

  }

  /**
   * Send request to the remote server
   *
   * @param string $method
   * @param Zend_Uri_Http $url
   * @param unknown_type $data
   * @param string $http_ver
   * @param array $headers
   * @param string $body
   * @return string Request as text
   */
  public function write( $method = 'get', $url,$data=null, $http_ver = '1.1', $headers = array(), $body = '' )
  {
    $this->myURL = $url;

    if(strtolower($method)=='post')
    {
        $fields_string='';
        foreach($data as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string,'&');
        curl_setopt($this->myHandle, CURLOPT_POST, count($data));
        curl_setopt($this->myHandle, CURLOPT_POSTFIELDS, $fields_string);
    }
    curl_setopt($this->myHandle, CURLOPT_URL, $this->myURL);

    $this->myResponse = curl_exec($this->myHandle);

    /* Check for errors. */
    if( curl_errno($this->myHandle) )
    {
    	Parserlogger::logger(
      	 ' (' . curl_errno($this->myHandle) . ') '
          . curl_error($this->myHandle)
         );
    }
  }

  /** Read response from server
   *
   * @return string
   */
  public function read(  )
  {
    /* Read response from remote server and return it as a string.
     *  Remove compression headers; they confuse the framework.
     */
    $this->myResponse =
      preg_replace
      (
          array
          (
              '/transfer-encoding:\s*chunked/i'
            , '/content-encoding:\s*(?:gzip|deflate)/i'
          )
        , ''
        , $this->myResponse
      );

    return $this->myResponse;
  }

  /** Close the connection to the server
   *
   * @return void
   */
  public function close(  )
  {
    curl_close($this->myHandle);
    @unlink($this->cookiefile);
    $this->cleancookie();
  }

  public function cleancookie()
  {
  	$files = array();
	$index = array();
	try {
		$yesterday = strtotime('yesterday');
		$cookiefile = dirname(__FILE__).DIRECTORY_SEPARATOR."cookie".DIRECTORY_SEPARATOR;
		if ($handle = opendir($cookiefile)) {
			clearstatcache();
			while (false !== ($file = readdir($handle))) {
		   		if ($file != "." && $file != "..") {
		   			$files[] = $file;
					$index[] = filemtime( $cookiefile.$file );
		   		}
			}
		  	closedir($handle);
		}

		asort( $index );

		foreach($index as $i => $t) {

			if($t < $yesterday) {
				@unlink($cookiefile.$files[$i]);
			}

		}
	}
	catch (Exception $e)
	{
		Parserlogger::logger("Error in cleaning cookie.".$e->getMessage().PHP_EOL);
	}

  }

}
