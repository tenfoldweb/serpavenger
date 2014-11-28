<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
set_time_limit(0);
/** @@ Load Dependencies ## **/
require_once "Abstract.php";
require_once "parselogger.php";

class Tripadvisor extends Dom_Abstract {

    protected $baseArr = array();
    /**
     * $query= array('dbfield_name'=>query)
     */
    protected $query = array
                (
                    'image' => 'image',
                    'title'=>'title'
                );
    protected  $basetag = '//listing/event';
    protected $callexternal_func=null,$savefile=null;

    public function __construct($savefile=null)
    {
    	//$this->savefile=$savefile;
    }


    public function parse_site($data)
    {
        try {
            $method = 'GET';          
		   
		   $url =$data['url']; 
          
           $data['url'] = $url;		   
        
            $html = $this->getHtml($url);
			//echo $html;die();
            //$this->basetag = '//div[@class="listing first" or @class="listing"]';
			
			$this->basetag = '//body';
			
			//$this->basetag = '//span[@class="sprite-middot middot"]';
				//div[@class="articlehead"]/h2		
            $this->query = array("title" => 'title',"Patragraph" => '//p[string-length()>20]');
            $hotelArr = array();
            $hotelArr = $this->parse('HTML',$html);
			//die();
            $this->saveHotel($data,$hotelArr);

            unset($html); /*free memory*/
            
            return array('hotel'=>$hotelArr);
        }
        catch (Exception $e)
        {
            echo "Error".$e->getMessage();
        }

    }
    
    protected function saveHotel($data,$hotelArr)
    {
    	
		echo '<pre>';
		print_r($hotelArr); 
		echo '</pre>'; exit;
		
		/*echo '<pre>';
		print_r($data); 
		echo '</pre>'; exit;*/
		
		$i=0;
    	foreach ($hotelArr as $hotel)
    	{
    		
			$restaurant_name=$hotel['restaurant_name'];			  	
			$restaurant_url='http://www.tripadvisor.com'.$hotel['restaurant_url'];
			$str_url=explode("-",$restaurant_url);			
			$restaurant_id=$str_url[2];		
			
			$Q=mysql_query("SELECT * FROM south_america_restaurent_info WHERE restaurant_id='".$restaurant_id."'");
			
			if($N=mysql_num_rows($Q)<=0)
			{			
			$sql = "INSERT INTO south_america_restaurent_info (
    					restaurant_id,restaurant_name,restaurant_url,continent) VALUES(
    				  '".$restaurant_id."'
    				, '".mysql_real_escape_string($restaurant_name)."'
					, '".mysql_real_escape_string($restaurant_url)."'
					, '".$data['continent']."'					
    				)
    				ON DUPLICATE KEY UPDATE
					 restaurant_id= '".$restaurant_id."'
    				, restaurant_name = '".mysql_real_escape_string($restaurant_name)."'  				 
    				";
    		mysql_query($sql) or die(mysql_error());    	
				
    		$i++;
			}
    	}
    	echo PHP_EOL."<br>Total Result parsed for Hotel: $i <br>".PHP_EOL;
    	return true;
    }
   
   

    protected function preprocess($html)
    {
    	$pattern = "charset=UTF-8";
    	$html = preg_replace("/$pattern/","charset=utf-8",$html);
    	return $html;
    }

    protected function stringProcess($data,$pattern=null)
    {
    	$data = html_entity_decode($data, ENT_QUOTES, 'UTF-8');
    	$data = trim(preg_replace("/&nbsp;/"," ",$data));
    	if(isset($pattern) && count($pattern)>0)
    	{
    		foreach ($pattern as $key=>$val)
    		$data = preg_replace("$key","$val",$data);
    	}
    	return $data;
    }
}
