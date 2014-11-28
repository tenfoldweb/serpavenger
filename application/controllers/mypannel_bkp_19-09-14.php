<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mypannel extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('dom');
		$this->load->model('model_mypannel');
		 $this->load->model('userlogin_model');
		 $this->load->model('model_campaign');

		   if(!$this->session->userdata('user_data'))
		   {
			 redirect(Am_Lite::getInstance()->getLoginURL());
		   }
		   $this->load->library('analyze');
		   $this->load->library('shrinktheweb');
	}

	public function index(){
		//$this->load->library('pagination');
		$session = $this->session->userdata('user_data');

		$get_packages = $this->userlogin_model->get_packages($session['user_id']);

			foreach($get_packages as $row)
			{
				if($row['analysis_permission'] == 1)
				{
					$permission = TRUE;
					break;
				}
				else
				{
					$permission = FALSE;
				}
			}
          $users_id = $session['user_id'];
	   /*check_login();
       $users_id= $this->session->userdata('LOGIN_USER');

		//$data = '';
		$data['ahref_state'] = $users_id; */
	   //print_r($data['user_list'] = $this->model_mypannel->getUsersdetail($users_id));
	    $row= $this->model_mypannel->getUsersdetail($users_id);
	     $this->data['users_id'] = $row->users_id;
	    $this->data['users_name'] = $row->users_name;
	    $this->data['users_email'] = $row->email;
	    $this->data['users_password'] = $row->pass;
	  // $users_id= $this->session->userdata('LOGIN_USER');
	   //echo $users_id;
        $data['network_name'] = $row->network_name;
        $this->data['networkcount']= $this->model_mypannel->getnetworkcount($users_id);
        $this->data['domaincount']= $this->model_mypannel->getdomaincount($users_id);
        $this->data['postcount']= $this->model_mypannel->getpostcount($users_id);
        $this->data['linkcount']= $this->model_mypannel->getlinkcount($users_id);
        $this->data['network_name']= $this->model_mypannel->getnetworklist($users_id);
        $this->data['campaigncount']= $this->model_mypannel->getcampaignlist($users_id);
        $this->data['campaignname']= $this->model_mypannel->getcampaign_name($users_id);
        $this->data['site_count']= $this->model_mypannel->getsitecount($users_id);
        $this->data['keyword_count']= $this->model_mypannel->getkeywordcount($users_id);
       $this->data['active_campaignList'] =  $this->model_basic->getActiveCampaignList($users_id);
        $this->data['seo_count']= $this->model_mypannel->getseocount($users_id);


       $this->data['singlelist'] =  $this->model_mypannel->getsinglelist($users_id);
         $this->data['campaign_namedetail']= $this->model_mypannel->getcampaign_namedetail($users_id);
      // $this->data['slidershrinkweb'] =  $this->model_mypannel->getslidershrinkweb($users_id);
        $this->data['campaignlistuser'] =  $this->model_mypannel->getcampaignlistuser($users_id);

        $this->data['campaignlistpara']= $this->model_mypannel->getcampaignlistpara($users_id);

         $this->data['campaignlistmoney']= $this->model_mypannel->getcampaignlistmoney($users_id);
         //$this->data['campaignlistseotest']= $this->model_mypannel->getcampaignlistseotest($users_id);
 $this->data['keywordloop']=$this->model_campaign->mainkeywordsloop($users_id);

      $this->data['secondkeywordloop']=$this->model_campaign->secondkeywordsloop($users_id);

       $this->data['campaign_fullimagedet']=$this->model_mypannel->getcampaign_fullimagedet($users_id);

        $this->data['sitemainkw']=$this->model_mypannel->getsitemainkw($users_id);
         $this->data['siteseckw']=$this->model_mypannel->getsiteseckw($users_id);
         $this->data['keywordsitese']=$this->model_mypannel->getkeywordsitese($users_id); 
        $this->data['deepanlymainkw']=$this->model_mypannel->deepanlymainkw($users_id); 
        $this->data['deepanlyseckw']=$this->model_mypannel->deepanlyseckw($users_id); 
          $this->data['autolinkprofile']=$this->model_mypannel->autolinkprofile($users_id);   
        $this->data['active_campaignList'] =  $this->model_basic->getActiveCampaignList($users_id);	
    /*
      $this->data['additionalkeywordloop']=$this->model_campaign->additionalkeywordsloop($users_id);*/


      //  $this->load->view('mypannel/mypannel',$data);
		//$this->templatelayout->get_header();
		//$this->templatelayout->make_seo();
		//$this->templatelayout->get_footer();
     // $config = array();
	  //$config["base_url"] = base_url() . "mypannel/index";
	 // $config["per_page"] = 1;
	 // $config["uri_segment"] = 3;

//$config["total_rows"] = 10;
    //$config["total_rows"] = $this->model_mypannel->getToplvslisting_count($users_id);
      
	 // $this->pagination->initialize($config);
     //$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    
     $this->data['toplvslisting']=$this->model_mypannel->getToplvslisting($users_id);  
     //print_r($this->data['toplvslisting']);
     //exit();
        //$this->data["links"] = $this->pagination->create_links();
		//$this->data['current'] = ($page / $this->pagination->per_page) +1;

		//$temp_total = $this->pagination->total_rows / $this->pagination->per_page;
   // $temp_total1 = explode(".",$temp_total);
   
		//if($temp_total1[0]>'0')
		//{
		//	$this->data['total']=$temp_total1[0]+1;
		//}
		//else{
		//	$this->data['total']= $temp_total1[0];
		//}



		$this->elements['middle']='mypannel/mypannel';
		$this->elements_data['middle'] = $this->data;

		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
		//$this->load->view('mypannel/mypannel',$data);
	}
	public function getPaginationList(){
		 $id = $_POST['id'];
 $this->load->model('model_mypannel');
            // echo "kk";
 $users_id = 24;
 		$data =$this->model_mypannel->getToplvslisting($users_id,1,$id); 
 		//print_r($data);
 		//exit(); 
 		echo '<ul>';
 		foreach ($data as $key) {

 			 echo '<li><img src="http://serpavenger.com/screenshot/results/'.$key['thumbailsize1'].'.jpg" width="120" height="90" alt=""/>';
		
     
 		}
                                 
   echo '</ul>';
     
	}

   //echo $users_id;
	public function updateuser()
	{
     $users_id = $this->input->post('users_id');
     $users_email = $this->input->post('users_email');
     $users_password = $this->input->post('users_password');

    $this->model_mypannel->getUsersupdate($users_id);

    redirect('mypannel/mypannel');

	}

	function get_network($id)
	{	//echo $_POST['id'];

        $this->db->select("COUNT(*) as name");
		 $this->db->from('serp_assign_domains');
		 $this->db->where('network_id', $_POST['id']);
		 $query = $this->db->get();
		 $result = $query->result();
		 $row = $query->result();
		//print_r($row[0]->name);
		echo $row[0]->name. ' Domains';


	}


	function get_network_list()
	{	
		include("apifolder/GrabzItClient.class.php");
		//include("apifolder/config.php");
$grabzItHandlerUrl = "http://serpavenger.com/serp_avenger/handler.php";
//print_r($grabzItHandlerUrl);
//exit();
//$hand = handlerfun();

$grabzIt = new GrabzItClient("ZGIzY2JmNDNkOWY3NGYwNWJjNjkyYTM5MzI4MmUwMTU=", "Pz8RP2taPyc/cipQOD8/Pz8/PxEoUz8+Pz8/P2Y/Py4=");

 //print_r($rr);
//echo '<ul>';
//echo '<img id="bhaskar" src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$id.'.jpg" width="120" height="90" >';
//echo '</ul>';
//print_r($id);

 

//Ensure that the application has the correct rights for this directory.
 //file_put_contents("results" . DIRECTORY_SEPARATOR . $filename, $result);



		$id = $_POST['id'];
$this->load->model('model_mypannel');
            // echo "kk";
 $users_id = 24;
 		$data =$this->model_mypannel->get_network_list_data($id,17,0); 
 		$i=0;
 		echo "<ul>";
 		foreach ($data as $key) {
 			
 			if($i <=7)
 			{ 	
 				 $grabzIt->SetImageOptions($key->domainname,null,null,null,120,90);
 			 $id = $grabzIt->Save($grabzItHandlerUrl);			 
 				echo '<li><a href="http://'.$key->domainname.'" target="_blank" ><img src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$id.'.jpg" width="120" height="90" ></a><a href="http://'.$key->domainname.'" target="_blank" ><span>'.$key->domainname.'</span></a></li>';
 				//echo "<br/>"; 				
 			}
 			//echo "</ul>";
 			if($i > 7 && $i <=12)
 			{
 				$grabzIt->SetImageOptions($key->domainname,null,null,null,120,90);
 			 $id = $grabzIt->Save($grabzItHandlerUrl);			 
 				echo '<li><a href="http://'.$key->domainname.'" target="_blank" ><img src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$id.'.jpg" width="120" height="90" ></a><a href="http://'.$key->domainname.'" target="_blank" ><span>'.$key->domainname.'</span></a></li>';
 			
 			}
 			if($i > 12 && $i <=17)
 			{
 				$grabzIt->SetImageOptions($key->domainname,null,null,null,120,90);
 			 $id = $grabzIt->Save($grabzItHandlerUrl);			 
 				echo '<li><a href="http://'.$key->domainname.'" target="_blank" ><img src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$id.'.jpg" width="120" height="90" ></a><a href="http://'.$key->domainname.'" target="_blank" ><span>'.$key->domainname.'</span></a></li>';
 			
 			}
 			$i++;
 			
 		}
 		//print_r($data);
 		//exit(); 
 		// for($j=1; $j<=3; $j++){
 		// echo '<ul>';
 		// for($i=0; $i<=5; $i++) {
 		// 	 echo '<li><img src="'.$base_url.'images/Thumbnail-Queued.jpg" width="120" height="90" /><span>'.$data[$i]['domainname'].'</span></li>';
		     
 		// }

                                 
   echo '</ul>';
//}        

	}



	function get_campaign_url($id)
	{	//echo $_POST['id'];
        $this->db->select("campaign_main_page_url");
		$this->db->from('serp_users_campaign_detail');
        $this->db->where('campaign_id', $_POST['id']);
        $query = $this->db->get();
       // $result = $query->result();
        $row = $query->result();
       // print_r($row);
        foreach($row as $row1){
       echo $row1->campaign_main_page_url;
		}

	}

	/* public function get_left($selected=""){
	  $this->left = '';
	  $this->left['active_campaignList'] =  $this->obj->model_basic->getActiveCampaignList();
	  //pr($this->left['campaignList'],0);
	 $this->obj->elements['left']='includes/left';
	  $this->obj->elements_data['left'] = $this->left;
     }*/

     function shrinktheweb($size, $url){
	$access_key_id="MY KEY"; // Replace [Access_Key_Id] with your actual Access_Key_Id
	$secret_access_key="SECRETE KEY"; // Replace [Secret_Access_Key] with your actual Secret_Access_Key
	$default_image="http://www.neobus.net/images/thumbs/nothumb.jpg"; // Enter the default image you would like shown if no thumbnail
	$cache=1; // Set to 1, if you want to save thumbnails locally (config function get_html_snippet also)
	$access_key_id='c1871';
	$secret_access_key='37c50d761e16b0b';
	$url='http://serpavenger.com';
	$size='200';

	$url_enc = urlencode($url);

	$request_url =  "http://www.shrinktheweb.com/xino.php?"
					. "Service=".           "ShrinkWebUrlThumbnail"
					. "&Action=".           "Thumbnail"
					. "&STWAccessKeyId=".   $access_key_id
					. "&Size=" .            $size
					. "&u=" .				$secret_access_key
					. "&Url=" .             $url;

	$line=make_http_request($request_url);
	$num_matches = preg_match('/<[^:]*:Thumbnail\\s*(?:Exists=\"((?:true)|(?:false))\")?[^>]*>([^<]*)<\//', $line, $matches);
	if($num_matches == 1){
		$exists = $matches[1];
		$thumbnail = $matches[2];
	}else{
		$exists = NULL;
		$thumbnail = NULL;
	}

	$has_default_image = ($default_image != NULL) && (strlen($default_image) > 0);
	if ($thumbnail != NULL && ($exists || !$has_default_image)){
			return get_html_snippet($url,$thumbnail,1,$exists,$cache);
	}
	return get_html_snippet($url,$default_image,1,$exists,$cache);
}

// Make an http request to the specified URL and return the result
function make_http_request($url){
	$lines = file($url);
	return implode("", $lines);
}

// Returns an HTML snippet which will display the thumbnail image url and link to the website.
// Returns an error code via XML and display error image or queue image upon failure
function get_html_snippet($url, $image, $stw, $exists, $cache) {
	$homedir="keep/"; // Replace [homedir] with the path to store thumbnails (i.e. /home/username/public_html/cached/images/)
	$link = "";
	$navigable_url = (stristr($url,"http://") == $url ) ? $url : "http://".$url;
	if ($image) {
		if($stw==1) {$link = "<img border='0' src='$image' alt='$url'/>";}
		else {$link = "<a href='$navigable_url'><img border='0' src='$image' alt='$url'/></a>";}
		$nothumb=substr_count(strtolower($image),"nothumb");
		if($exists=="true" && $cache==1) {
			// Cache the thumbnail
			if(substr(strtolower($url),0,7)=="http://") $url = substr($url,7); # remove http://
			$subdom="$homedir".substr($url,4).".jpg";
			if(substr(strtolower($url),0,4)=="www.") {$dom=$subdom;}
			else {$dom = "$homedir".$url.".jpg";}
			if((!file_exists($dom) || !file_exists($subdom)) && $stw==1 && $nothumb==0)
			{
				// Store ShrinkTheWeb Thumbnails
				$imagedata = @imagecreatefromjpeg($image); if($imagedata!='') {imagejpeg($imagedata,$dom,100);}
			}
		}
	}
	return $link;
}

   public function logout(){

            $this->session->unset_userdata('user_data');
			 
			$this->session->sess_destroy(); 
            redirect('amember/login/index');
    }


}