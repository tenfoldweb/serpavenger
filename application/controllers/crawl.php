<?php

function crawl_simple($reffer, $url, $agent, $proxy,$proxyUser) {
    
    $cookie_file_path = "cookie.txt";
    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $reffer);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, true);//Keep Alive Disable-Do not pool
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);//use of a new connection instead of a cached 
    
    /*Proxy curl settings*/
        
    $temp = explode(':',$proxy);
    curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );
    curl_setopt( $ch, CURLOPT_PROXY, $temp[0] );
    curl_setopt( $ch, CURLOPT_PROXYPORT, $temp[1] );
    curl_setopt( $ch, CURLOPT_PROXYUSERPWD, $proxyUser );
    curl_setopt( $ch, CURLOPT_HTTPPROXYTUNNEL, 1 );    
    // curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );    

    /*Cookie settings*/
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($ch, CURLOPT_COOKIE,'~ /Set-Cookie\: ');


    /*SSL settings*/
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
    curl_setopt($ch, CURLOPT_HEADER, 1);
    
    $result = curl_exec($ch);
    curl_close($ch);
    ob_flush();
    return $result;
}


?>