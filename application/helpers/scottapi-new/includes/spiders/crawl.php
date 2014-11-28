<?php

function crawl_simple($reffer, $url, $agent, $proxy) {
    
    $cookie_file_path = "cookie.txt";
    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $reffer);
    
    /*Proxy curl settings*/
        
    $temp = explode(':',$proxy);
    curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );
    curl_setopt( $ch, CURLOPT_PROXY, $temp[0] );
    curl_setopt( $ch, CURLOPT_PROXYPORT, $temp[1] );
    curl_setopt( $ch, CURLOPT_PROXYUSERPWD, 'billing19:nCh59iAt' );
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