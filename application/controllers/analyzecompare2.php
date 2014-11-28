<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnalyzeCompare2 extends CI_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->helper('dom');
		$this->load->model('model_basic');
		$this->load->model('model_campaign');
		$this->load->model('userlogin_model');

		$user_data = array('user_id' => 9,
								'user_login' => 'scott_paxton',
								'user_email' => 'spax@rpautah.com',
								'user_name_f' => 'Scott',
								'user_name_l' => 'Paxton'
								);
				
		$this->session->set_userdata('user_data', $user_data);
        $this->reffer_google = "http://www.google.com/search";//
		 if(!$this->session->userdata('user_data'))
		 {
		   redirect(Am_Lite::getInstance()->getLoginURL());
		 }
		
	}

	public function index()
	{
		$session = $this->session->userdata('user_data'); 
	    $users_id = $session['user_id'];
        //$this->data['active_campaignList'] =  $this->model_basic->getActiveCampaignList($users_id);	
        //$this->data['serpcrawl_conditions'] =  $this->model_campaign->setserpcrawl_conditions($users_id);	
//$this->data['serpcrawl_conditions'] =  $this->model_campaign->getserpcrawl_conditions($users_id,$campaign_id);	
//$this->data['backlinkcount']=$this->model_campaign->getbacklinkcount($users_id);

//$this->data['init_spider']=$this->model_campaign->init_spider();  


//$this->data['backlinkcount'] = $this->checkbacklinkcounter();
//$this->data['toptensitethumnails'] = $this->toptensitethumnails();
$this->data['campaign_id']= $campaign_id;

$this->data['userdetailcompare']=$this->model_campaign->getuserdetailcompare($users_id,$campaign_id);

       $this->elements['middle']='campaign/analyze-compare2';			
		$this->elements_data['middle'] = $this->data;
		$this->layout->setLayout('main_layout_new');
		$this->layout->multiple_view($this->elements,$this->elements_data);
                //$this->get_crawl_data();
                
		
	}
	public function formdata()
	{
		$session = $this->session->userdata('user_data'); 
	    $users_id = $session['user_id'];
	    $exactkw     = $this->input->post('exactkw');
	    $exact_anchor     = $this->input->post('exact_anchor');
        $exact_url     = $this->input->post('exact_url');
	    $exact_total     = $this->input->post('exact_total');

	    $relatedkw     = $this->input->post('relatedkw');
	    $related_anchor     = $this->input->post('related_anchor');
        $related_url     = $this->input->post('related_url');
	    $related_total     = $this->input->post('related_total');

	    $selectkw     = $this->input->post('selectkw');
	    $select_anchor     = $this->input->post('select_anchor');
        $select_url     = $this->input->post('select_url');
	    $select_total     = $this->input->post('select_total');
	    $links_built     = $this->input->post('links_built');

	    $this->model_campaign->insertformdata($users_id);
	    redirect('analyzecompare2');

	}
        
        public function toptensitethumnails() {
            
        $totaladditionoftoptensite = '';
        $toptensites = array('http://www.rediff.com','http://www.wikipedia.org','https://in.yahoo.com/?p=us','http://www.amazon.com','http://www.apple.com','https://wordpress.com','http://www.adobe.com','http://www.oracle.com/index.html','http://www.ibm.com/in/en','http://www.intel.in/content/www/in/en/homepage.html');
       // $toptensites = array('http://www.rediff.com','http://www.wikipedia.org','https://in.yahoo.com/?p=us');
        return $toptensites;  
        }


        public function checkbacklinkcounter() {
          
            
           $totaladditionoftoptensite = '';
            $toptensites = array('facebook.com','wikipedia.org','yahoo.com','amazon.com','apple.com','wordpress.com','adobe.com','oracle.com','ibm.com','intel.com');
            //$chkDomain = 'facebook.com';
            foreach ($toptensites as $chkDomain) {
                
            $ahref_url2  = 'http://apiv2.ahrefs.com/?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&target='.$chkDomain.'&limit=20&from=metrics&mode=subdomains&output=json';
            $ch = curl_init($ahref_url2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            $output = curl_exec($ch);
            
            $result2 = json_decode($output);  
            $totaladditionoftoptensite += $result2->metrics->backlinks;    
           }
           //print_r($result2);
            return  $totaladditionoftoptensite; 
            
           // echo  $totaladditionoftoptensite;
            
        }

	public function get_crawl_data()
	{   
		
		/*$session = $this->session->userdata('user_data'); 
	    $users_id = $session['user_id'];
		 $exactMatchCount    = 0;

        $blendedMatchCount  = 0;

        $brandMatchCount    = 0;

        $rawUrlMatchCount   = 0;

        $backlinkscount= 0;
        $chkDomain = 'in.yahoo.com';
        $ahref_url  = 'http://apiv2.ahrefs.com?from=anchors&mode=domain&target='.$chkDomain.'&mode=exact&limit=10&output=json&token=596b1f51527a18f0ce0a1fb11d5825d4d962ec46';
        $ch = curl_init($ahref_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec($ch);

        $result = json_decode($output);
        
        $ahref_url2  = 'http://apiv2.ahrefs.com/?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&target='.$chkDomain.'&limit=20&from=metrics&mode=subdomains&output=json';
        echo $ahref_url2;
        $ch = curl_init($ahref_url2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec($ch);

        $result2 = json_decode($output);
        echo '<pre>';
        print_r($result);
        echo '-----------------------------------------------';
         print_r($result2);
        echo '</pre>';
        $ahref_backlink_url = 'http://api.ahrefs.com?target='.$chkDomain.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
*/       
// exit;
       // $toptensites = array('facebook.com ','wikipedia.org','yahoo.com','amazon.com','apple.com','wordpress.com','adobe.com','oracle.com','ibm.com','intel.com');
        //$sql = "SELECT site FROM  serp_temp_tbl WHERE userid = '".$users_id."' limit 10";
        
        //echo $sql;exit;
          //  $query = $this->db->query($sql);
           
//                    if($query->num_rows() > 0){
//                        $rec1 = $query->result_array();
//                        echo '<pre>';
//                        print_r($rec1);
//                        echo '</pre>';exit;
//          foreach($rec1 as $row)
//            {                                          
//
//        //$rand_proxy   = $proxy_list[array_rand($proxy_list)];
//$rand_proxy = array(1=>'50.31.9.103:8800',2=>'192.126.169.239:8800',3=>'50.31.9.149:8800',4=>'50.31.9.118:8800',5=>'192.126.171.71:8800',5=>'50.31.9.123:8800',6=>'192.126.171.71:8800',7=>'50.31.9.63:8800',8=>'50.31.9.147:8800',9=>'50.31.9.254:8800',10=>'192.126.169.27:8800',11=>'50.31.9.111:8800',12=>'50.31.9.131:8800',13=>'192.126.171.229:8800');
//
//
//        //$rand_useragent   = $useragent_list[array_rand($useragent_list)];
//
//        $url=$row['site'];
//        $purl = parse_url($url);
//
//        $host   = $purl['host'];
//
//        $path   = '';
//
//        $domain = parse_url($url, PHP_URL_HOST);
//
//        $domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
//
//        $domainArray    = explode('.', $domain);
//
//        $domainName = $domainArray[0];
//       
//
//
//        if(isset($purl['path'])){
//
//        $path   = $purl['path'];
//
//        }
//
//        $chkDomain  = $host . $path;
//
//        $ahref_url  = 'http://apiv2.ahrefs.com?from=anchors&mode=domain&target='.$chkDomain.'&mode=exact&limit=10&output=json&token=596b1f51527a18f0ce0a1fb11d5825d4d962ec46';
//        //echo "<br>";echo $ahref_url  = 'http://api.ahrefs.com?from=backlinks&target='.$chkDomain.'&count=10&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
//        //die();
//
//        //$content = $this->get_content($ahref_url, $rand_proxy, $rand_useragent);
//
//        $contentone    = file_get_contents($ahref_url);
//        //print_r ($content);
//        $resultone = json_decode($contentone, true);
//        echo "<pre>";
//        print_r ($resultone);
//        $resultone = $resultone['anchors'];
//        
//        //echo strtolower($keyword);
//        //echo '<pre>';print_r($result);die();
//        //$keyword ='denver locksmith';
//
//        //echo $domainName.'>>>'.$domain;die();
//
//        if(is_array($resultone) && count($resultone) > 0){
//
//        for($i=0; $i<count($resultone); $i++){
//        	//echo count($resultone);
//        // Exact match
//        //echo $resultone[$i]['anchor'];
//        if(strtolower($resultone[$i]['anchor']) == strtolower($keyword)){
//
//        $exactMatchCount = $exactMatchCount +$resultone[$i]['backlinks'];
//
//        }
//
//        // Blended match
//
//        if(strpos(strtolower($resultone[$i]['anchor']),strtolower($keyword))>-1){
//        if(strlen(strtolower($resultone[$i]['anchor']))>strlen(strtolower($keyword))){
//        $blendedMatchCount = $blendedMatchCount +$resultone[$i]['backlinks'];
//        }
//        //$blendedMatchCount++;
//        }
//
//        // Brand match
//
//        if(strpos(strtolower($resultone[$i]['anchor']),strtolower($domainName))>-1){
//
//        //$brandMatchCount++;
//        $brandMatchCount = $brandMatchCount +$resultone[$i]['backlinks'];
//
//        }
//
//        // RAW url match
//
//        if(strpos(strtolower($resultone[$i]['anchor']),strtolower($domain))>-1){
//
//        //$rawUrlMatchCount++;
//        $rawUrlMatchCount = $rawUrlMatchCount +$resultone[$i]['backlinks'];
//
//
//         
//
//        }
//
//        $backlinkscount = $backlinkscount +$resultone[$i]['backlinks'];
//        }
//
//        }   
//        
//
//         //echo "<br>";echo  $ahref_backlink_url = 'http://api.ahrefs.com?target='.$chkDomain.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';
//
//        //$content = $this->get_content($ahref_backlink_url, $rand_proxy, $rand_useragent);
//
//        $content    = file_get_contents($ahref_backlink_url);
//        //print_r ($content);
//        $result = json_decode($content, true);
//        //print_r ($result);
//        //print_r($result['anchors']);
//         $resultanc = $result['anchors'];
//        //print_r($result['backlinks']);
//        $backlinks  = $result['backlinks'];
//        
//
//        $rec['exact_match_count']   = $exactMatchCount;
//
//        $rec['blended_match_count'] = $blendedMatchCount;
//
//        $rec['brand_match_count']   = $brandMatchCount;
//
//        $rec['raw_url_match_count'] = $rawUrlMatchCount;
//
//        $rec['backlinks_count'] = $backlinkscount; 
//
//        $sql	= "INSERT INTO " . serp_api_href_match . " SET
//		  user_id			= '".$users_id."',
//		  exactMatchCount		= '".$rec['exact_match_count']."',
//		  blendedMatchCount		= '".$rec['blended_match_count']."',
//		  brandMatchCount		= '".$rec['brand_match_count']."',
//		  rawUrlMatchCount		= '".$rec['raw_url_match_count']."',
//		  backlinkscount		= '".$rec['backlinks_count'] ."',    
//		  date_added			= '".date("Y-m-d H:i:s")."'";
//		  
//		$this->db->query($sql); 
//		//return $rec
//        //echo '<pre>';print_r($rec);
//        //$this->data['userserpapihrefmatch'] =  $this->model_campaign->insertUserserpapihrefmatch($users_id);	
//        //die();
//        }
//	}
}
    
    function str_get_html($str, $lowercase=true) {
    $dom = new simple_html_dom;
    $dom->load($str, $lowercase);
    return $dom;
    }

    function crawl_simple($reffer, $url, $agent, $proxy) {
    
    /*$cookie_file_path = "cookie.txt";
    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $reffer);
    */
    /*Proxy curl settings*/
    /*curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'billing19:nCh59iAt');*/

    
   /* $temp = explode(':',$proxy);
    curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );
    curl_setopt( $ch, CURLOPT_PROXY, $temp[0] );
    curl_setopt( $ch, CURLOPT_PROXYPORT, $temp[1] );
    curl_setopt( $ch, CURLOPT_PROXYUSERPWD, 'billing19:nCh59iAt' );
    curl_setopt( $ch, CURLOPT_HTTPPROXYTUNNEL, 1 );    
    // curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );    

    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($ch, CURLOPT_COOKIE,'~ /Set-Cookie\: ');
     */

    /*SSL settings*/
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    ob_flush();
    return $result; 
     }
	 public function generate_thumb_image(){
		$mainurl = urldecode($this->input->post('url'));
		include("apifolder/GrabzItClient.class.php");
		$grabzItHandlerUrl = "http://serpavenger.com/serp_avenger/handler.php";
		 
		$grabzIt = new GrabzItClient("YjMzMjFlZWY4Y2U4NDRhNWFmZWIxM2U5Nzc0YmNjNDQ=", "Zz8yPwUeP2o/Pz8/YD8/LCgoSCo/XC0/Pz8/Pw9sY2Q=");
		$this->load->helper('common_helper');
		$is_thumb_exist =  check_thumb_image_exists($mainurl);
		if($is_thumb_exist==''){
		
		
		$grabzIt->SetImageOptions($mainurl,null,null,null,200,150);
			   $id1 = $grabzIt->Save($grabzItHandlerUrl);
			   save_thumb_image_exists($id1,$mainurl); 
			   $id1 = str_replace("YjMzMjFlZWY4Y2U4NDRhNWFmZWIxM2U5Nzc0YmNjNDQ=", "", $id1);
			   
		} else {
			$id1 = str_replace("YjMzMjFlZWY4Y2U4NDRhNWFmZWIxM2U5Nzc0YmNjNDQ=", "", $is_thumb_exist);
		}
		echo $id1;
	 }
	 public function init_spider() {
     /*$url = 'https://www.google.au/search?q=rickshaw&ie=UTF-8&num=10'; 
     $html = str_get_html(crawl_simple($this->reffer_google, $url, $this->agent, $proxy));   
*/
     }
}