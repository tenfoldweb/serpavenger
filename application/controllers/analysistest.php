<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysistest extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_campaigntest');
		$this->load->model('model_campaigntest');
		
		
		//Edited by BEAS - Check for logged in user
		
		 $this->load->model('scrapper_model');
   
         $this->load->model('userlogin_model');

		   if(!$this->session->userdata('user_data'))
		   {
			 redirect(Am_Lite::getInstance()->getLoginURL());
		   }
		
		//Edited by BEAS
	}
	
	
	public function index(){

		//Edited by BEAS - Check page access
		
		$session = $this->session->userdata('user_data'); 
		
		$get_packages = $this->userlogin_model->get_packages($session['user_id']);

		$get_keyword_count = $this->model_campaigntest->count_keyword_by_user($session['user_id']);
		
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

		//Edited by BEAS
		//Added by BEAS - After payment has been done , upgrading the system
		if((isset($_REQUEST['tx']) && $_REQUEST['tx']!='') && (isset($_REQUEST['st']) && $_REQUEST['st']=='Completed')){
			$index = 0;
			foreach($get_packages as $row){
				
				if($_REQUEST['custom']==$row['package_id']){
					$package_index = $index; 
				}
				$index++;
			}
			$get_packages[$package_index]['analysis_permission'] = 1;
				
			// User added permission table update code
			$data = $get_packages[$package_index];
			unset($data['user_status_id']);
			unset($data['product_id']);
			unset($data['status']);
			unset($data['package_name']);
			unset($data['monthly_fees']);
			unset($data['created_date']);
			$data['created_date'] = date('Y-m-d H:i:s');  
			$data['package_id'] = $_REQUEST['custom'];
			if(isset($_REQUEST['keyword']))
			$data['max_keyword_analyzed'] = $_REQUEST['keyword'];	
			
			$insert_status = $this->scrapper_model->user_added_permission($data);		
			$this->session->set_userdata('user_data', $session);
			
			$this->session->set_flashdata('message', '<div class="notification note-success">
					<a title="Close notification" class="close" href="#">close</a>
					<p>You have successfully upgraded your membership package!</p>
				</div> ');

			redirect('analysis');
			exit();
		}
		//Added by BEAS

		
		//$this->check_login();
		//$parasitelist	= $this->parasitelist();		
		
		if(isset($_GET['cid']) && !empty($_GET['cid'])){
			$cid	= (int)trim($_GET['cid']);
		}else{
			$cid	= 0;
		}
	
		
		//Edited by BEAS - Fetching logged in user data
		
		//$users_id	= $this->session->userdata('LOGIN_USER');
		 $users_id = $session['user_id'];
		
		//Edited by BEAS
		
		
		
		$this->data = '';
		
		//Edited by BEAS - Setting flag for page access
		// $permission = False;
		$this->data['permission'] = $permission;
		$this->data['packages'] = $get_packages;
		$max_keyword_track = 0;
		foreach($get_packages as $row)
		{
			$max_keyword_track += $row['max_keyword_track'];
		}
		
		$this->data['get_keyword_count'] = count($get_keyword_count);
		$this->data['max_keyword_track'] = $max_keyword_track;
		// $this->data['get_keyword_count'] = 1013;
		// $this->data['max_keyword_track'] = $max_keyword_track;
		
		//Edited by BEAS
		
		$this->data['users_id'] = $users_id;
		//echo "<br>";echo "test".$users_id;echo "<br>";
		$this->data['cid'] = $cid;
		$this->data['campaign_list'] = $this->model_campaigntest->getUsersCampaigns($users_id);
		$this->data['campagin_keyword_list']=$this->model_campaigntest->getUsersCampaignsKeywords($users_id);
		$this->data['showresults']=$this->model_campaigntest->showresults($users_id);
		$this->data['totalcntshowresults']=$this->model_campaigntest->totalcntshowresults($users_id);
  
		//print_r($this->data['campagin_keyword_list']); die;
		$this->data['campaign_crawl_detail'] = $this->model_campaigntest->getUsersCampaignCrawlDetail($this->data['campaign_list'][0]['campaign'][0]);
		if(is_array($this->data['campaign_list']) && count($this->data['campaign_list']) > 0){
			   if(is_array($this->data['campaign_list'][0]['campaign']) && count($this->data['campaign_list'][0]['campaign']) > 0){
			     $this->data['single_campaign'] = $this->data['campaign_list'][0]['campaign'][0];			     
			     
			   }
			}

		//$campaign_id		= $this->model_campaigntest->insertUsersCampaign($users_id);

		/*$campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = "'.$campaign_id.'"');

		$campaign_main_page_url	= $campaign_detail[0]['campaign_main_page_url'];
		$campaign_main_keyword	= $campaign_detail[0]['campaign_main_keyword'];
		$parse 			= parse_url($campaign_main_page_url);


		$campaign_murl_thumb			= $this->analyze->get_Site_thumb($campaign_main_page_url);
		copy($campaign_murl_thumb, FRONT_SITE_THUMB_PATH . $data['campaign_murl_domain'] . '_' . $campaign_id . '.jpg');
		$data['campaign_murl_thumb']		= $data['campaign_murl_domain'] . '_' . $campaign_id . '.jpg';
		$www_resolved				= $this->analyze->check_site($campaign_main_page_url,true);


		$this->data['rendertoptenresults']=$this->model_campaigntest->get_rendertoptenresults();*/

		//$this->templatelayout->get_header();
		//$this->templatelayout->make_seo();
		//$this->templatelayout->get_left();
		//$this->templatelayout->get_topmenu();
		//$this->templatelayout->get_footer();
        $this->data['active_campaignList'] =  $this->model_basic->getActiveCampaignList($users_id);	
		$this->elements['middle']='analysis/list';
		$this->elements_data['middle'] = $this->data;

		$this->layout->setLayout('main_layout');
		$this->layout->multiple_view($this->elements,$this->elements_data);
	}
	//Edited by BEAS - Adding new permission in amember
  
  public function add_user_permissions()
	{
		$permission_name = $this->input->post('name');
		
		$permission_cost = $this->input->post('cost');

		$package_id = $this->scrapper_model->add_custom_permissions($permission_name, $permission_cost);
		
		echo $package_id;
	}
	
	//Edited by BEAS


	 public function showcontent()
   {
       $id=$_POST['id'];
       $rid= $_POST['rid'];
        if($id == 1 || $id == '1'){
            $this->load->model('model_campaigntest');
           
			$session = $this->session->userdata('user_data');
			$users_id = $session['user_id'];
            $showresults = $this->data['showresults']=$this->model_campaigntest->showresults($users_id);
                      echo '<div class="main_image" id="apDiv1">';
                      //echo $totalcntshowresults;
                        foreach($showresults as $shres) {
                          //echo "<pre>"; print_r($shres);                         
                          echo'<div class="desc"><div class="block" id="block">
                                    <div class="siteinfo">';
                            echo '<img src="'; 
                            echo FRONT_IMAGE_PATH; 
                         echo $shres['campaign_murl_thumb']; 
                         echo'" width="190"  alt="">
                                        <div class="infomain">
                                        <p>
                                            <label>Ranking:</label>
                                            <span><strong>1 ('; echo $shres['keyword']; echo ')</strong></span>
                                        </p>
                                        <p>
                                            <label>Page:</label>
                                            <span>';
                                            echo $shres['campaign_murl_domain']; 
                                            echo '</span>
                                        </p>
                                        <p>
                                            <label>Age:</label>
                                            <span> yr  Months</span>
                                        </p>
                                        <p>
                                            <label>Type:</label>
                                            <span>Ranked Homepage w/ ';
                                            
                                     if($shres['domain_external_links']>= 1){
                                            echo $shres['domain_external_links'];
                                           }
                                           else
                                           {
                                             echo '0';
                                           }
 
                                             
                                        echo 'External Links</span>
                                            <ul class="typrank">
                                                <li>Top 10: ';
                                                
                                            $url4 = parse_url($rec4['campaign_main_page_url']);
                                            //echo "test".strlen($url4['path']);
                                            if(strlen($url4['path'])<=1)
                                            {
                                                $home_page10++;
                                            }
                                            echo  $home_page10/10*100;
                                                echo '% are homepages</li>
                                                <li>Top 20: ';
                                            $url4 = parse_url($rec4['campaign_main_page_url']);
                                            //echo "test".strlen($url4['path']);
                                            if(strlen($url4['path'])<=1)
                                            {
                                                $home_page20++;
                                            }
                                            echo  $home_page20/20*100;
                                                echo '% are home pages</li>
                                            </ul>
                                        </p>
                                        <p>
                                            <label>Size:</label>
                                            <span> Pages</span>
                                            <span class="pull-right">Word Count:';
                                             echo $shres['domain_word_count']; 
                                             echo '</span>
                                        </p>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="bnrbtmrow">
                                        <div class="rowinfo">
                                            <span class="headlab"><strong>Keyword Score()</strong></span>
                                            <ul class="ks">
                                                <li><span class="wdt53">KW Anchors:</span>&nbsp; Links</li>
                                                <li><span>KW above fold:</span>&nbsp;';
                                                 
                                     if($shres['domain_kw_ratio']!=''){
                                            echo $shres['domain_kw_ratio']*100;
                                           }
                                            
 
                                            
                                                echo '</li>
                                                <li><span>KW Ratio:</span>&nbsp;';
                                                
                                     if($shres['domain_kw_ratio']!=''){
                                            echo $shres['domain_kw_ratio']*100;
                                           }
                                            
 
                                             echo '%</li>
                                                <li><span class="wdt53">In Title:</span>&nbsp;';
                                     if($shres['title']!=''){
                                            echo 'Yes';
                                           }
                                           else
                                           {
                                             echo 'No';
                                           }
 
                                            echo '</li>
                                                <li><span>In Description:</span>&nbsp;';
                                                
                                     if($shres['page_description']!=''){
                                            echo 'Yes';
                                           }
                                           else
                                           {
                                             echo 'No';
                                           }                                          

                                                echo '</li>
                                                <li><span>In H1:</span>&nbsp;';
                                                
                                     if($shres['keyword_in_h1']!=''){
                                            echo 'Yes';
                                           }
                                           else
                                           {
                                             echo 'No';
                                           }
 
                                             
                                                echo '</li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="rowinfo bnr-social">
                                            <span class="headlab"><strong>Social</strong></span>
                                            <img src="';
                                            echo FRONT_IMAGE_PATH; echo 'social-like-big.gif" width="366" height="20" alt="">
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="rowinfo">
                                            <span class="headlab"><strong>Link info</strong></span>
                                            <ul class="ks">
                                                <li><span>Exact Match:</span>&nbsp;';
                                                
                                                if($shres['exact_match_anchors']>= 1){
                                                echo round(($shres['domain_kw_ratio']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                echo '%</li>
                                                <li><span>Related KWs:</span>&nbsp;';
                                                if($shres['domain_kw_ratio']>= 1){
                                                echo round(($shres['domain_kw_ratio']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                } echo '%</li>
                                                <li><span>Blended:</span>&nbsp;'; 
                                                if($shres['blended_match_anchors']>= 1){
                                                echo round(($shres['blended_match_anchors']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                echo '%</li>
                                                <li><span>Brand:</span>&nbsp;'; 
                                                if($shres['brand_match_anchors']>= 1){
                                                echo round(($shres['brand_match_anchors']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                echo '%</li>
                                                <li><span>Raw URL:</span>&nbsp;';  
                                                if($shres['raw_url_match_anchors']>= 1){
                                                echo round(($shres['raw_url_match_anchors']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                } 
                                                echo '%</li>
                                                <li><span>Using  s:</span>&nbsp;Yes ()</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                             } 
                       echo '</div>';

            
}else{
  $dta=$this->model_analysistest->showcontentdata($id);

  /*foreach ($dta as $data){
    echo "<table><tr><td>".$data->campaign_id."</td><td>".$dta[0]->campaign_id."</td></tr></table>";
}*/
  //print_r($dta);
foreach($dta as $data)
{
	

	
	 echo  " <div class='main_image_show' id='apDiv1'><div class='desc'><div class='block' id='block'>
	  <div class='siteinfo'><img src='";
	  echo FRONT_IMAGE_PATH; 
	  echo "".$data['campaign_murl_thumb']."'' width='190'  alt=''><div class='infomain'>
                                        <p>
                                            <label>Ranking:</label>
                                            <span><strong>".$rid."(".$data['keyword'].")'</strong></span>
                                        </p>
                                        <p>
                                            <label>Page:</label>
                                            <span>".$data['campaign_murl_domain']."</span>
                                        </p>
                                        <p>
                                            <label>Age:</label>
                                            <span> yr  Months</span>
                                         
                                        </p>
                                         <p>
                                            <label>Type:</label>
                                            <span>Ranked Homepage w/ ";

                                             if($data['domain_external_links']>= 1){
                                            echo $data['domain_external_links'];
                                           }
                                           else
                                           {
                                             echo '0';
                                           }

                                        echo "External Links</span>
                                            <ul class='typrank'>
                                                <li>Top 10: ".$data['domain_external_links']."
                                               % are homepages</li>
                                                <li>Top 20: ".$data['domain_word_count']."
                                            % are home pages</li>
                                            </ul>
                                        </p>
                                        <p>
                                            <label>Size:</label>
                                            <span>  Pages</span>
                                            <span class='pull-right'>Word Count:
                                            ".$data['domain_word_count']."</span>
                                        </p>
                                        </div></div>
                                      <div class='clearfix'></div>
                                    <div class='bnrbtmrow'>
                                        <div class='rowinfo'>
                                            <span class='headlab'><strong>Keyword Score()</strong></span>
                                            <ul class='ks'>
                                                <li><span class='wdt53'>KW Anchors:</span>&nbsp;";
                                          if($data['exact_match_anchors']>= 1){
                                                echo $data['exact_match_anchors']*100;
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                echo "Links</li>
                                                <li><span>KW above fold:</span>&nbsp;";
                                                 if($data['domain_kw_ratio']!=''){
                                            echo $data['domain_kw_ratio']*100;
                                           }
                                                echo "</li>
                                                <li><span>KW Ratio:</span>&nbsp;";

                                           if($data['domain_kw_ratio']!=''){
                                            echo $data['domain_kw_ratio']*100;
                                           }
                                            
 
                                             echo '%</li>
                                                <li><span class="wdt53">In Title:</span>&nbsp;';
                                     if($data['title']!=''){
                                            echo 'Yes';
                                           }
                                           else
                                           {
                                             echo 'No';
                                           }

                                              
                                   echo" </li>
                                                <li><span>In Description:</span>&nbsp;";
                                                          
                                     if($data['page_description']!=''){
                                            echo 'Yes';
                                           }
                                           else
                                           {
                                             echo 'No';
                                           }        
                                     

                                                echo '</li>
                                                <li><span>In H1:</span>&nbsp;';
                                                if($data['keyword_in_h1']!=''){
                                            echo 'Yes';
                                           }
                                           else
                                           {
                                             echo 'No';
                                           }
                                              echo  "</li>
                                            </ul>
                                        </div>

                               <div class='clearfix'></div>
                                        <div class='rowinfo bnr-social'>
                                            <span class='headlab'><strong>Social</strong></span>
                                            <img src='";
                                             echo FRONT_IMAGE_PATH; echo "social-like-big.gif' width='366' height='20' alt=''>
                                        </div>
                                        <div class='clearfix'></div>
                                        <div class='rowinfo'>
                                            <span class='headlab'><strong>Link info:</strong></span>
                                            <ul class='ks'>
                                                <li><span>Exact Match:</span>&nbsp;";
                                          if($data['exact_match_anchors']>= 1){
                                                echo round(($data['domain_kw_ratio']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                echo '%</li>
                                                <li><span>Related KWs:</span>&nbsp;';
                                                if($data['domain_kw_ratio']>= 1){
                                                echo round(($data['domain_kw_ratio']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                } echo '%</li>
                                                <li><span>Blended:</span>&nbsp;'; 
                                                if($data['blended_match_anchors']>= 1){
                                                echo round(($data['blended_match_anchors']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                echo '%</li>
                                                <li><span>Brand:</span>&nbsp;'; 
                                                if($data['brand_match_anchors']>= 1){
                                                echo round(($data['brand_match_anchors']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                }
                                                echo '%</li>
                                                <li><span>Raw URL:</span>&nbsp;';  
                                                if($data['raw_url_match_anchors']>= 1){
                                                echo round(($data['raw_url_match_anchors']/$totalcntshowresults)*100);
                                                }
                                                else
                                                {
                                                    echo '0';
                                                } 
                                                echo "%</li>
                                               
                                                <li><span>Using s:</span>&nbsp;Yes ()</li>
                                            </ul>
                                        </div></div></div></div>";
                            

        }

      }
   }


}

/* End of file member.php */
/* Location: ./front-app/controllers/member.php */