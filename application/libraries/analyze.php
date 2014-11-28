<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Whois Class
 *
 * @author		G l a z z
 * @date		27.12.2010 13:40 PM
 */
class Analyze {
	
    public function getSiteAge($domain){        
        include_once(SERVER_ABSOLUTE_PATH."front-app/libraries/phpwhois/whois.main.php");
        include_once(SERVER_ABSOLUTE_PATH."front-app/libraries/phpwhois/whois.utils.php");
    
        $domain = str_replace("www.", "", $domain);
        
        $dd = explode('.',$domain);
        $dc = count($dd);
        if($dc>2)
        {
            $domain = $dd[$dc-2].".".$dd[$dc-1];
        }
    
    
        $whois = new Whois();
    
        // Set to true if you want to allow proxy requests
        $allowproxy = false;
    
        // Comment the following line to disable support for non ICANN tld's
        $whois->non_icann = true;
    
        $result = $whois->Lookup($domain);
        //$resout = str_replace('{query}', $query, $resout);
        //$winfo = '';
        $r = $result['regrinfo']['domain']['created'];
        return strtotime($r);        
    }
    
    public function getIPToCountry($ip=NULL){
        include(SERVER_ABSOLUTE_PATH."front-app/libraries/geoip.inc");
        // open the geoip database
        $gi = geoip_open(SERVER_ABSOLUTE_PATH."front-app/libraries/GeoIP.dat",GEOIP_STANDARD);
        // to get the country code
        $country_code = geoip_country_code_by_addr($gi, $ip);
        // to get country name
        $country_name = geoip_country_name_by_addr($gi, $ip);
        geoip_close($gi);
        return $country_code;
    }
    
    function get_Site_thumb($url=NULL){
        $site_url = $url;
        $parse = parse_url($site_url);          
        $API_URL = "http://images.shrinktheweb.com/xino.php?stwu=c1871&stwxmax=320&stwymax=240&stwaccesskeyid=37c50d761e16b0b&stwurl=".$site_url;            
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $oDOM = new DOMDocument;
        $oDOM->loadXML($output);
        $sXML = simplexml_import_dom($oDOM);
        $sXMLLayout = 'http://www.shrinktheweb.com/doc/stwresponse.xsd';
        
        // Pull response codes from XML feed
        $aThumbnail = (array)$sXML->children($sXMLLayout)->Response->ThumbnailResult->Thumbnail;  
        
        return $aThumbnail[0];
    }
    
    function check_site($url,$wwwResolve=false){
            $urln="";
            $host = "http://";
            if($wwwResolve)
            {
                
                if(strpos($url,"www")>=0)
                {
                    $url = str_replace("www","",$url);
                }
                
                if(strpos($url,"https://")>=0)
                {
                    $url = str_replace('https://',"",$url);
                    $host = "https://";
                }
                if(strpos($url,"http://")>=0)
                {
                    $url = str_replace('http://',"",$url);
                    $host = "http://";
                }
                
            $urln = $host."www.".$url;
            }
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $urln);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_NOBODY, true);
            $header = curl_exec($curl);
            curl_close($curl);
            //var_dump($header);
            if(strpos($header,'200 OK')>0){
                return "true";
            }else{
                return "false";
            }
    }
    
    function keywordCPCData($kw=NULL){
        $encoded_kw = urlencode($kw);
        //$regexp = '/^[a-zA-Z0-9][a-zA-Z0-9\-\_]+[a-zA-Z0-9]$/';
        $filename = $encoded_kw.".csv";
        /*if (false === preg_match($regexp, $encoded_kw)) {
             echo $url ="http://api.semrush.com/?type=domain_organic&key=fa2b854a1bcc79d55ba56c6e5e2f86e6&display_filter=%2B%7CPh%7CCo%7Cseo&display_limit=10&export_columns=Ph,Po,Pp,Pd,Nq,Cp,Ur,Tr,Tc,Co,Nr,Td&domain=seobook.com&display_sort=tr_desc&database=us";


        }
        else
        {*/
             $url = "http://us.fullsearch-api.semrush.com/?action=report&type=phrase_fullsearch&phrase=".$encoded_kw."&key=fa2b854a1bcc79d55ba56c6e5e2f86e6&display_limit=11&export=api&export_columns=Ph,Nq,Cp";

        //}
        
        


        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        file_put_contents($filename,$output);
        $row = 0;
        $res = array();
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while(($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if($row>0)
                    $res[$row] = $data;
                $row++;
            }
            fclose($handle);
        }
        unlink($filename);
        return $res;
    }


    function keywordCPCDatabydomain($kw=NULL){
        $encoded_kw = urlencode($kw);         
        $filename = $encoded_kw.".csv";
        
       $url ="http://api.semrush.com/?type=domain_organic&key=fa2b854a1bcc79d55ba56c6e5e2f86e6&display_filter=%2B%7CPh%7CCo%7Cseo&display_limit=10&export_columns=Ph,Po,Pp,Pd,Nq,Cp,Ur,Tr,Tc,Co,Nr,Td&domain=".$encoded_kw."&display_sort=tr_desc&database=us"; 


        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        //print $url."<br/>";
        //print $output;
        curl_close($ch);
        file_put_contents($filename,$output);
        $row = 0;
        $res = array();
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while(($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if($row>0)
                    $res[$row] = $data;
                $row++;
            }
            fclose($handle);
        }
        unlink($filename);
        //print_r($res); die();
        return $res;
    }
}




// END Analyze class

/* End of file Domain.php */
/* Location: ./front-app/libraries/analyze.php */