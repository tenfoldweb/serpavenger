<?php ini_set('mysql.connect_timeout', 0);
ini_set('default_socket_timeout', 0);
ini_set('MAX_EXECUTION_TIME', '-1'); //set_time_limit(0);
ini_set('memory_limit', '-1');

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scrapper extends CI_Controller {

	public function __construct(){

		parent::__construct();	

		$this->load->helper('dom');

		$this->load->model('scrapper_model');

		$this->load->model('network_model');
	}

	public function index()
	{
		if(isset($_GET['cid']) && !empty($_GET['cid'])){
			$cid	= (int)trim($_GET['cid']);
			if(strpos($cid, '-')){
				$cidArr = explode("-", $cid);
				$cid = $cidArr[1];
			}
		}else{
			$cid	= 0;
		}
		
		if(isset($_GET['sid']) && !empty($_GET['sid'])){
			$sid	= trim($_GET['sid']);	
		}else{
			$sid	= 'google';
		}
		
		if(isset($_GET['rcsid']) && !empty($_GET['rcsid'])){
			$rcsid	= trim($_GET['rcsid']);	
		}else{
			$rcsid	= 'google';
		}
		
		$data['page_title'] = 'SERP Avenger';

		$data['networks'] = $this->network_model->get_network();
        //$data['campaigns'] = $this->scrapper_model->get_campaigns(2);
		$users_id = 1;
		$data['cid'] = $cid;
		$data['sid'] = $sid;
		$data['rcsid'] = $rcsid;
		$data['campaign_list'] = $this->scrapper_model->getUsersCampaigns($users_id);
		$this->load->view('scrapper',$data);
	}

	function num_of_domains(){

	  $data['action'] = $this->input->post('action');	

	  $ids = $this->input->post('ids');

	  if($ids==''){

		echo 0; 
		
	  }else{

	     $result = $this->scrapper_model->get_domains($ids);
		 $blog_domains = $this->scrapper_model->blog_domains($ids);
		 $domainid = $domainname = array();
		 $nums=count($result);
			for($i=0;$i < $nums;$i++){			
				array_push($domainid,$result[$i]['domainid']);
				array_push($domainname,$result[$i]['domainname']);	
		 
			}
		    echo $nums."##".$blog_domains."##".implode(',', $domainid)."##".implode(',', $domainname);

	     }

	}

	function form($campaign_id = "")
	{
		$this->load->helper('form');

		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<p>', '</p>');

		//default values are empty if the customer is new

		$data['page_title']  = 'Submitter';

		$data['campaign_id']  = '';

		$data['networks']     = '';	

		$data['project_name'] = '';

		$data['campaign']     = '';

		$data['spin_type']    = '';

		$data['post_title']   = '';

		$data['post_content'] = '';

		$data['submission_num']   = '';
		
		$data['serp_format']   = '';
		
		$data['serp_comment']   = '';

		$data['submission']    = '';

		$data['favor_preference'] = '';

		$schedule = '';

		$data['comment_seeding'] = '';	

		$provalue = '';

		$data['drip_rate']    = '';	

		//Links
		$data['link_identifier']   = '';	

		$data['keyword_replace']   = '';

		$data['synonyms']	      = '';

		//$data['file_name']	   = '';

		$data['anchor_set1']	   = '';

		$data['anchor_set2']	   = '';

		$data['anchor_set3']	   = '';

		$anchor1  = '';

		$link1    = '';

		$anchor2  = '';

		$link2    = '';

		$anchor3  = '';

		$link3    = '';

		$spintype = '';

        if($this->input->post('spin_type'))
          $spintype = implode(",", $this->input->post('spin_type'));
		
		$this->form_validation->set_rules('networks', 'Select Network', 'required');
		$this->form_validation->set_rules('project_name', 'Project Name', 'trim|required');
		$this->form_validation->set_rules('submission_num', 'Submission Number', 'trim|numeric|required');
		
		if($spintype == 'manually')
		{
			$this->form_validation->set_rules('post_title', 'Post Title', 'trim|required');
			$this->form_validation->set_rules('post_content', 'Post Content', 'trim|required');
			
			$post_title = $this->scrapper_model->spin($this->input->post('post_title'));
			$post_content = $this->scrapper_model->spin($this->input->post('post_content'));
		}
		//if this is a new account require a password, or if they have entered either a password or a password confirmation	

		if ($this->form_validation->run() == FALSE)
		{
			//$data['networks'] = $this->network_model->get_network();
		    //$this->load->view('scrapper',$data);
			
			$this->session->set_flashdata('message', '<div class="notification note-error">
										<a title="Close notification" class="close" href="#">close</a>
										<p>'.validation_errors().'</p>
									</div>');
			redirect('scrapper');
		}
		else
		{
            ////////////////////* upload */////////////////////

			$all_comments=array();
			$is_comment = $this->input->post('serp_comment'); 
			if($is_comment=='on'){ 
			$unique_comments = $this->input->post('unique_comments');
				if(!empty($_FILES) && $unique_comments==''){								
				  $this->load->library('upload');
				  if($_FILES['comment_file']['error'] == 0){   
						 $config['tmp_name'] = $_FILES['comment_file']['tmp_name'];
						 $config['upload_path'] = './assets/uploads/'; /* NB! create this dir! */							
						 $config['allowed_types'] = 'text/csv|csv';						 
						 $config['max_size'] = '1500';
						 $config['overwrite'] = false;
						 $config['remove_spaces'] = true;					 
						$config['file_name'] = $_FILES['comment_file']['name'];
						$this->upload->initialize($config);
						$error=0;						

						if ($this->upload->do_upload('comment_file')){
							$error += 0;
							$data_icon= $this->upload->data();							
							$provalue= $data_icon['file_name'];
							$row = 1;
							if (($handle = fopen("./assets/uploads/".$provalue, "r")) !== FALSE) {
									while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
										$num = count($data);					
										$row++;
											for ($c = 0; $c < $num; $c++) {
												array_push($all_comments,$data[$c]);
											}
									 }
									fclose($handle);
								}
						}else{			

							 $this->session->set_flashdata('message', '<div class="notification note-error">
										<a title="Close notification" class="close" href="#">close</a>
										<p>Only CSV file accepted.'.$this->upload->display_errors().'</p>
									</div>');
								redirect('scrapper');
							 }
					   }		  		

				  } else {  //  file is empty and unique_comments blank. below else part
				      // Here will be unique part that have found from yahoo answers 
				      $keywords = $this->input->post('keywords');
				      $spintaxreturn = $this->comment_syscon($keywords);
					  $arr=array();
							 $nn=explode('# B #',$spintaxreturn);
							for($i=1;$i<count($nn);$i++){
									for($j=1;$j<=5;$j++){			
									$content=$this->scrapper_model->spin($nn[$i]);
									$content .= str_replace("|","",$content);							
									array_push($arr,$content);
									}							
							}							
							$shuffleKeys = array_keys($arr);
							shuffle($shuffleKeys);
							//$newArray = array();
							foreach($shuffleKeys as $key) {							  
							   array_push($all_comments,$arr[$key]);
					  }
				  }
				  
			}else{   // serp_comment checking off or on. below off part.
				
			}
			
			$user_id = 2;
            /*if($this->input->post('schedule')=="later"){
				$schedule = $this->input->post('start_date');
				$date = $this->input->post('start_date');
			}else if($this->input->post('schedule')=="now"){
				$schedule = $this->input->post('schedule');
				$date = date("Y-m-d H:i:s");
			}*/
			
			if($this->input->post('drip_rate')=="Custom Range"){
				$drip_rate = $this->input->post('num_post')."/".$this->input->post('postings');
				
			}else{
				$drip_rate = $this->input->post('drip_rate');
			}
			
			$networks = implode(",", $this->input->post('networks'));
			
			$favor_preference = $this->input->post('favor_preference');
			  if($favor_preference == 'Unique IP First'){
				  $orderby = 'domainip'; $order = 'DESC';
			  }else if($favor_preference == 'Highest Pagerank First'){
				  $orderby = 'pagerank'; $order = 'DESC';
			  }else if($favor_preference == 'Oldest Domains First'){
				  $orderby = 'domainid'; $order = 'ASC';
			  }else{
				  $orderby = ''; $order = '';
			  }
			  
			$submission = $this->input->post('submission');
			
			$is_format = $this->input->post('serp_format'); 
			$nums=$this->input->post('submission_num');
			$special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
			
			  if($spintype == 'smart_content')
			  {
				$searchmode = array('google', 'yahoo');
				
				$this->form_validation->set_rules('smart_content_topics', 'Enter General Topics', 'required');
		        $this->form_validation->set_rules('smart_content_keywords', 'Enter Keywords', 'required');
		        $this->form_validation->set_rules('smart_content_synonyms', 'Enter synonyms', 'required');
				
				if($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata('message', '<div class="notification note-error">
					<a title="Close notification" class="close" href="#">close</a>
					<p>For SERP Avenger Smart Content - <br><br> Please Enter General Topics <br> Provide Keywords <br> Provide Synonyms</p>
				</div> ');
				
				    redirect('scrapper');
				}
				else
				{
					$content_topics = $this->input->post('smart_content_topics');
				    $content_keywords = $this->input->post('smart_content_keywords');
				    $content_synonyms = $this->input->post('smart_content_synonyms');
					
					$savedposts = $this->scrapper_model->fetch_campaign_posts();

					$this->scrapper_model->truncate_data();
					
					while(1)
					{
						$mode = rand(0,1);
						$stat = $this->syscon($searchmode[$mode], $content_keywords, $content_synonyms, $content_topics, $user_id);
						
						if($stat)
						 break;
				    }				
					
					if($stat)
					{
					  $this->generate_subquery($searchmode[$mode], $user_id);
					  $returndata = $this->sendtoapi();
					}
					
					$numbers = array();
					 
					 if(isset($returndata['article']))
					  $numbers = $returndata['article'];

						$newtot=array();						
						$num_scrap=count($numbers);
						
						if(count($num_scrap) > 0)
						{
							$lefts = $nums;				
							if($nums > $num_scrap){
								$tot = floor($nums / $num_scrap);
								$lefts = $nums % $num_scrap;
								for($t=0;$t<$tot;$t++){
									for($nt=1;$nt<=$num_scrap;$nt++){
									  array_push($newtot, $numbers[$nt]);
									}
								}
							}
							for($nt=1;$nt<=$lefts;$nt++){
							  array_push($newtot, $numbers[$nt]);
							}
						}
						
						$this->mysql_reconnect();
				 }
			   }
   
	 $res = $this->scrapper_model->get_domains($networks, $orderby, $order);

     for($domain=0;$domain < count($res);$domain++)
	 {
		    //open for loop for every domain section
	   if($res[$domain]['type']=='Traditional Blog' || $res[$domain]['type']=='Blog+')
	   {
			if($this->input->post('schedule')=="later"){
				$schedule = $this->input->post('start_date');
				$date = $this->input->post('start_date');
			}else if($this->input->post('schedule')=="now"){
				$schedule = $this->input->post('schedule');
				$date = date("Y-m-d H:i:s");
			}	
			if($this->input->post('drip_rate')=="Custom Range"){
				
				$date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +1 ".$this->input->post('postings'));
				$date = date("Y-m-d H:i:s",$date);
			
			}else if($this->input->post('drip_rate')=="24 Hours"){
				$hours=rand(1,20);	
				$date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +".$hours." hour");
				$date = date("Y-m-d H:i:s",$date);
				
			}else if($this->input->post('drip_rate')=="Viral Linking"){
				$days=rand(1,7);	
				$date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +".$days." days");
				$date = date("Y-m-d H:i:s",$date);
				
			}else if($this->input->post('drip_rate')=="Mini Spikes"){
				$days=rand(7,10);	
				$date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +".$days." days");
				$date = date("Y-m-d H:i:s",$date);
			} 

			$save['user_id']	    = $user_id;
			$save['networks']	   = $networks;
			$save['domain_id']	  = $res[$domain]['domainid'];
			$save['project_name']   = $this->input->post('project_name');	
			$save['campaign']	   = $this->input->post('campaign');
			$save['spin_type']	  = $spintype;	
			$save['submission_num'] = $this->input->post('submission_num');
			$save['submission']     = $submission;
			$save['favor_preference']= $favor_preference;	
			$save['schedule']	   = $schedule;
			$save['comment_seeding']= $this->input->post('comment_seeding');
			$save['comment_file']   = $provalue;
			$save['drip_rate']      = $drip_rate;
			$save['create_date']	= date("Y-m-d H:i:s");
			$save['update_date']	= '';
			$save['status']	     = 0;
			
			$campaign_id = $this->scrapper_model->save($save);

			if($campaign_id != ""){
				
				if($spintype == 'smart_content')
				{
				  $this->scrapper_model->update_keywords($campaign_id, $user_id, $content_topics, $content_keywords, $content_synonyms);
				}
				
				$unique_posts=array();
				for($i=1;$i<=$nums;$i++)
				{
					if($spintype == 'smart_content')
					{
						if(isset($returndata['title']) && count($returndata['title']) > 0)
						{
							$title = "";
							$resume = false;

							while(1)
							{
								while(1)
								{
									$val = rand(1,20);
									if(isset($returndata['title'][$val.'T']))
									{
									  $title = $returndata['title'][$val.'T'];
									  
									  if(trim($title) != "")
									   break;
									}
								}
	
									$post_title = $this->scrapper_model->spin($title);
									
									$post_title = trim(preg_replace('/[^a-zA-Z\s]/', '', $post_title));
									
									if(isset($savedposts) && count($savedposts) > 0)
									{
										foreach($savedposts as $svpost)
										{
										 if(strtolower(trim($post_title)) == strtolower(trim($svpost['posttitle'])))
										 {
											 $resume = true;
											 break;
										 }
										 else
										  $resume = false;
										}
									}
									
							  if(!$resume)
							   break;
							}
						}
						
						if(isset($newtot) && count($newtot) > 0)
						{
							while(1)
							{
							     if(isset($newtot[$i]))
								 {
								   $post_content = $this->scrapper_model->spin($newtot[$i]);
								   $post_content = str_replace('|','',$post_content);
								 }
								 
								 if(trim($post_content) == "")
								 {
									 $randompost = rand(1,$nums);
									 
									 if(isset($newtot[$randompost]))
								       $newtot[$i] = $newtot[$randompost];
								 }
								 else
								   break;
							}
						}
						
					} //smart content close
					
					if($is_format=='on'){   // checking if SERP Avenger  Professional Formatting is on					
					    if(trim($post_content) != ""){
						   $post_content = $this->scrapper_model->content_formatting($post_content);
						}
					}
					
					   for($n1=0;$n1 < $this->input->post('count_r');$n1++){
						     $anc= $n1+1; 
							 $num_qty=$this->input->post('qty'.$anc);
                             $min_qty=$this->input->post('min_qty'.$anc);
		 				    //if($i<=$num_qlty)
                             if($i>=$min_qty && $i<=$num_qty){
							 $anchor1 = $this->scrapper_model->spin($this->input->post('anchor'.$anc));
							 $link1 = $this->scrapper_model->spin($this->input->post('link'.$anc));
							 $settings = $this->input->post('anchor_set'.$anc);
							 $syns=$this->input->post('synonyms');
								 if(!empty($syns)){
							 $syms_all = $syns[$n1];
							 if($anchor1!='' && $link1!='' && !empty($syms_all)){ 
						     	$post_content = $this->scrapper_model->key_replace($anchor1, $link1, $post_content, $syms_all, $settings);
							 }							 
								 }  // if condition close here	
								 if($this->input->post('link_identifier')=='on'){
									if($anchor1!='' && $link1!=''){
									$post_content = $this->scrapper_model->link_identifier($anchor1, $link1,$post_content, '%link1%');
									}
								 }
							 }
					   } //for loop close here 

					   for($n2=0;$n2 < $this->input->post('count_rr');$n2++){
						     $anc2= $n2+1; 
							 $num_qty2 = $this->input->post('qty_rr'.$anc2);
                             $min_qty2 = $this->input->post('min_qty_rr'.$anc2);
                             if($i >= $min_qty2 && $i <= $num_qty2){
							 $anchor2 = $this->scrapper_model->spin($this->input->post('anchor_rr'.$anc2));
							 $link2 = $this->scrapper_model->spin($this->input->post('link_rr'.$anc2));
							 $settings2 = $this->input->post('anchor_set_rr'.$anc2);
							 
                             $syns2=$this->input->post('synonyms_rr');
								 if(!empty($syns2)){
							 $syms_all2 = $syns2[$n2];
							 if($anchor2!='' && $link2!='' && !empty($syms_all2)){ 
						     	$post_content = $this->scrapper_model->key_replace($anchor2, $link2, $post_content, $syms_all2, $settings2);
							 }							 
								 }  // if condition close here
								 if($this->input->post('link_identifier')=='on'){
									if($anchor2!='' && $link2!=''){
										$post_content = $this->scrapper_model->link_identifier($anchor2, $link2,$post_content, '%link2%');
									}
								 }
							 }

					   } //for loop close here 

					   for($n3=0;$n3 < $this->input->post('count_rrr');$n3++){
						     $anc3= $n3+1; 
							 $num_qty3 = $this->input->post('qty_rrr'.$anc3);
                             $min_qty3 = $this->input->post('min_qty_rrr'.$anc3);

                             if($i >= $min_qty3 && $i <= $num_qty3){

							 $anchor3 = $this->scrapper_model->spin($this->input->post('anchor_rrr'.$anc3));
							 $link3 = $this->scrapper_model->spin($this->input->post('link_rrr'.$anc3));
							 $settings3 = $this->input->post('anchor_set_rrr'.$anc3);							 
							 $syns3=$this->input->post('synonyms_rrr');
								 if(!empty($syns3)){
							 $syms_all3 = $syns3[$n3];
								 if($anchor3!='' && $link3!='' && !empty($syms_all3)){ 
									$post_content = $this->scrapper_model->key_replace($anchor3, $link3, $post_content, $syms_all3, $settings3);
							 }
								 }  // if condition close here
								 if($this->input->post('link_identifier')=='on'){
									if($anchor3!='' && $link3!=''){
										$post_content = $this->scrapper_model->link_identifier($anchor3, $link3,$post_content, '%link3%');
									}
								 }	 
							 }
					   } //for loop close here 
				
					$hp_smart=$this->input->post('hp_smart');
					if($i<=$hp_smart){ $post_hp=1; }else{ $post_hp=0; }
                    if($spintype=='manually'){ $sc=1; } else{ $sc=0; } 

					$post_name = str_replace(' ', '-', str_replace($special_chars, '', strtolower($post_title)));	
					$save_post['campaign_id']	= $campaign_id;
					$save_post['domain_id']	= $res[$domain]['domainid'];
					$save_post['user_id']	    = $user_id;
					$save_post['post_title']	 = $post_title;
					$save_post['post_content']   = $post_content;
					$save_post['post_status']    = 'publish';
					$save_post['post_name']      = $post_name;
					$save_post['post_date']      = $date;
					$save_post['post_modified']  = '';
					$save_post['comment_count']  = 0;
					$save_post['anchor1']  = $anchor1;
					$save_post['link1']  = $link1;
					$save_post['anchor2']  = $anchor2;
					$save_post['link2']  = $link2;
					$save_post['anchor3']  = $anchor3;
					$save_post['link3']  = $link3;
					$save_post['hp']  = $post_hp;
					$save_post['sc']  = $sc;
					$save_post['obl']  = 0;

                   if(trim($post_content) != "")
				   {
					/******************unique domain*********************/   
					 $posted_domain = $this->scrapper_model->domainpost_is_exist($save_post);
				   
					 if($posted_domain){
						 array_push($unique_posts,$save_post);
					 }else{
						 $post_id=$this->scrapper_model->post_save($save_post);  
						  if($post_id && $is_comment=='on' &&  $res[$domain]['type']=='Blog+'){   // checking if SERP Avenger Comment Seeding is on
						 $this->scrapper_model->comment_save($post_id,$all_comments);
						  }
					 } 
					 }
					 
				   if($this->input->post('drip_rate')=="Custom Range"){
						if($i % $this->input->post('num_post')==0){
						$date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +1 ".$this->input->post('postings'));
						$date = date("Y-m-d H:i:s",$date);
						}
					}else{
						$mins=rand(1,50);	
						$date = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +".$mins." minutes");
						$date = date("Y-m-d H:i:s",$date);	
				   }
					
				} //for loop submission num close here
				
				/******************unique domain after insert*********************/
				 
				 if(!empty($unique_posts) && $submission == 'unique_domains'){
					 for($u=0;$u < count($unique_posts);$u++){
						$post_id=$this->scrapper_model->post_save($unique_posts[$u]);
						if($post_id && $is_comment=='on' &&  $res[$domain]['type']=='Blog+'){ //checking if SERP Avenger Comment Seeding is on
							$this->scrapper_model->comment_save($post_id,$all_comments);
						 }  
					 }						 
				 }
				 /*****************************************************************/ 
					 }
		       }  //close if condition.	
			}  //close for loop for every domain section

				$this->session->set_flashdata('message', '<div class="notification note-success">
					<a title="Close notification" class="close" href="#">close</a>
					<p>The Campaign has been saved!</p>
				</div> ');

			redirect('scrapper');
		}
	}

	public function getPage($proxy_login, $proxy, $url, $referer, $agent, $header, $timeout) {

		ob_start();

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_HEADER, $header);

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_PROXY, $proxy);

		curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_login);

		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		curl_setopt($ch, CURLOPT_REFERER, $referer);

		curl_setopt($ch, CURLOPT_USERAGENT, $agent);

		$result['EXE'] = curl_exec($ch);

		$result['INF'] = curl_getinfo($ch);

		$result['ERR'] = curl_error($ch);

		curl_close($ch);
		
		//ob_flush();

		return $result;

	}

	/* public function crawler_google(){

		// Fetch Proxies

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = "1"');

		// Fetch useragents

		$useragent_list	= $this->scrapper_model->getValues_conditions(TABLE_USERAGENTSTRINGS, '*', '', 'id <> ""');

		// Fetch campaign list

		$campaign_list	= $this->scrapper_model->getCampaignList('google');

		//$search_data = $this->scrapper_model->getCampaignList();

		$word_details = $this->scrapper_model->campaignKeywords($campaign_id = 1, $users_id = 1);

		$keywords_array = explode(',',$word_details->keywords);

		$synonyms_array = explode(',',$word_details->synonyms);

		$topics_array = explode(',',$word_details->topics);

		//echo '<pre>';print_r($keywords_array);die();

		$sentence['keyword']  = $this->buildSentence($keywords_array, 'Keyword');

		$sentence['synonyms']  = $this->buildSentence($synonyms_array, 'Keyword');

		$sentence['generic']  = $this->buildSentence($topics_array, 'Generic');

		//echo '<pre>';print_r($sentence);die();

		//pr($campaign_list, 0);

		$output	= array();

		//if(is_array($campaign_list) && count($campaign_list) > 0){

		foreach($sentence['keyword'] as $keyword_crawl){

			//for($i=2; $i<3; $i++){

				//$i=1;

				$campaign_id		= 2;

				$searchstring		= $keyword_crawl['sentence'];

				//$google_se_domain	= $campaign_list[$i]['google_se_domain'];

				//$campaign_main_page_url	= $campaign_list[$i]['campaign_main_page_url'];

				$searchstring 		= str_replace(" ", "+", $searchstring);

				$rand_proxy		= array_rand($proxy_list, 5);

				$rand_useragent		= array_rand($useragent_list, 5);

				$output		= array();
				
				$url = 'http://www.google.com/search?hl=en&as_q='.$searchstring.'&as_epq=&as_oq=&as_eq=&lr=&as_filetype=&ft=i&as_sitesearch=&as_qdr=all&as_rights=&as_occt=any&cr=&as_nlo=&as_nhi=&safe=images&num=100';



				for($j=0; $j<5; $j++){



					//echo 'LOOP = ' . $j . '<br>';



					$proxy			= $proxy_list[$rand_proxy[$j]]['proxy'];



					$proxyArray		= explode(":", $proxy);    



					$proxy_ip		= $proxyArray[0];



					$proxy_port		= $proxyArray[1];



					$proxy_user		= $proxyArray[2];



					$proxy_pwd		= $proxyArray[3];



					$proxy_login		= $proxy_user . ':' . $proxy_pwd;



					$proxy			= $proxy_ip . ':' . $proxy_port;					



					//$proxy			= $proxy_ip . ':' . $proxy_port;



					$useragent		= $useragent_list[$rand_useragent[$j]];					



					$result 		= $this->getPage($proxy_login, $proxy, $url, 'http://www.google.com/', trim($useragent['useragent']), '1', '0');



					pr($result, 0);



					



					if (empty($result['ERR'])) {



						//$output1 = array();



						//pr($result['EXE'], 0);



						$trackMainPageURL= false;



						$html 	= str_get_html($result['EXE']);						



						$pos	= 0;



						foreach($html->find('li.g') as $g){						



							$pos++;



							$h3 		= $g->find('h3', 0);					



							$a 		= $h3->find('a', 0);



							if($a->href == $campaign_main_page_url){



								$main_url_pos		= 'Yes';



								$trackMainPageURL	= true;



							}else{



								$main_url_pos	= 'No';



							}



							$output[] 	= array(



										'title' 	=> $a->plaintext,



										'link' 		=> $a->href,



										'rank' 		=> $pos,



										'c_id'		=> $campaign_id,



										'keyword'	=> $keyword_crawl['word'],



										'searchstring'=> $keyword_crawl['sentence'],



										'proxy'		=> $proxy



										//'main_url_pos'	=> $main_url_pos



										);



							if($pos >= 10){



								if($trackMainPageURL){



									break;	



								}



							}							



						}



						break;



						//pr($output1, 0);



					} else {



						echo 'ERROR<br>';



						pr($result['ERR'], 0);



						echo '<br>';



					}



					sleep(rand(10,20));







				}



				



			//}



			break;



			}



		//}



		pr($output, 0);



		if(is_array($output) && count($output) > 0){



			for($i=0; $i<count($output); $i++){



				$data['campaign_id']	= $output[$i]['c_id'];



				$data['proxy']		= $output[$i]['proxy'];



				$data['keyword']	= $output[$i]['keyword'];



				$data['searchstring']	= $output[$i]['searchstring'];



				$data['title']		= $output[$i]['title'];



				$data['url']		= $output[$i]['link'];



				$data['rank']		= $output[$i]['rank'];



				//$data['main_url_pos']	= $output[$i]['main_url_pos'];



				$data['date_added']	= date("Y-m-d");



				$this->scrapper_model->insertSearchCrawlData('google', $data);



			}



		}



	}*/


	public function buildSentence($word, $identifier){

	$sentence = array();



		$getTitle = $this->scrapper_model->getTitle($identifier);



		foreach($getTitle as $getTitleVal){



			foreach($word as $word_val){



				$sentence[] = array("sentence"=>str_replace("%".$identifier."%", $word_val,$getTitleVal['title']),



									"word"=> $word_val,



									"identifier"=>$identifier



									);



			}



			



		}



		return $sentence;



	}

	public function generate_subquery($action, $user_id)
	{
		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$proxy = $proxy_list[rand(1,5)]['proxy'];

		if($action == 'yahoo'){

			$reffer = "https://answers.yahoo.com"; //Reffer Yahoo Answer

			$search_crawl_data = $this->scrapper_model->get_search_crawl_data($action, $user_id);

			$counter_crawl = 1; $counter_answers = 1; $data = array();

			foreach($search_crawl_data as $search_crawl_data_val){

				$flag = true;

				$html_answer = str_get_html($this->crawl_simple($reffer, trim($search_crawl_data_val['url']), $agent, $proxy)); //Yahoo Answer

                $gettext = array();

				foreach($html_answer->find('div[class=content]') as $content){
					
					$gettext[] = $this->filter_content(trim($content->plaintext));
				}		

				    $output = array();			

					$output['serp_google_crawl_data_id'] =  $search_crawl_data_val['id'];

					$output['campaign_id'] =  $search_crawl_data_val['campaign_id'];

					$output['users_id'] =  $user_id;

					$output['crawlby'] =  $search_crawl_data_val['crawlby'];

					$output['url'] =  $search_crawl_data_val['url'];

					$output['proxy'] =  $search_crawl_data_val['proxy'];

					$output['keyword'] =  $search_crawl_data_val['keyword'];

					$output['searchstring'] =  $search_crawl_data_val['searchstring'];

					$output['title'] = "";
					$output['content_intros'] = "";
					$output['body_content'] = "";
					$output['conclusion'] = "";

					if(str_word_count($this->filter_content(trim($html_answer->find('h1[class=subject]',0)->plaintext))) >= 4)
					{
						$output['title'] = $this->filter_content(trim($html_answer->find('h1[class=subject]',0)->plaintext));
					}

					if(count($gettext) > 0)
					{
						if(str_word_count($gettext[0]) >= 30 && str_word_count($gettext[0]) <= 2000)
						 $output['content_intros'] = $gettext[0];

						$str = "";

						for($i=1;$i<count($gettext);$i++)
						{
							$body = "";
							$body = $gettext[$i];
							$str .= $body;
						}

                        if(str_word_count($str) >= 30 && str_word_count($str) <= 2000)
						 $output['body_content'] = $str;

						if(count($gettext) > 2 && isset($gettext[count($gettext)-1]))
						{
							if(str_word_count($gettext[count($gettext)-1]) >= 30 && str_word_count($gettext[count($gettext)-1]) <= 2000)
							   $output['conclusion'] = $gettext[count($gettext)-1];
						}
					}

					$output['bullet_points'] =  '';
					
					$output['campaign_main_page_url'] =  $search_crawl_data_val['main_url'];

					$output['date_entered'] =  date("Y-m-d H:i:s");

					$output['date_modified'] =  date("Y-m-d H:i:s");		

					$retarr = $this->scrapper_model->search_url($search_crawl_data_val['searchstring'], $user_id);

						if(count($retarr) > 0)
						{
							foreach($retarr as $arr){

								if(trim(strtolower($arr['url'])) == trim(strtolower($search_crawl_data_val['url'])))
								{
								  $flag = false;
								  break;
								}
							}
						}

					if($flag)
					{
			         $this->scrapper_model->insertCrawlData($output);
					}

			$counter_crawl++;
			}
			
		}elseif($action == 'google'){

			//$reffer = "http://www.rammilk.com"; //Reffer Yahoo Answer

			$reffer = "http://www.google.com";

			$search_crawl_data = $this->scrapper_model->get_search_crawl_data($action, $user_id);

			$counter_crawl = 1; $counter_answers = 1; $data = array();

			$exclusions = array('amazon.com');       //domains to exlude

			foreach($search_crawl_data as $search_crawl_data_val){

				$flag = true;

				$url = parse_url(trim($search_crawl_data_val['url']));

				$protocol = "";

				$domain = "";

				if(!empty($url['scheme']))
				$protocol = $url['scheme'];

				 if(!empty($url['host']))
				   $domain = strtolower($url['host']);
				 else
				   $domain = strtolower($url['path']);

				   //$reffer = $protocol."://".$domain;

				$html_answer = str_get_html($this->crawl_simple($reffer, trim($search_crawl_data_val['url']), $agent, $proxy)); //google

				$gettext = array();

				foreach($html_answer->find('body div p') as $content){
					
					$gettext[] = $this->filter_content(trim($content->plaintext));
				}
				
					$output = array();

					$output['serp_google_crawl_data_id'] =  $search_crawl_data_val['id'];

					$output['campaign_id'] =  $search_crawl_data_val['campaign_id'];

					$output['users_id'] =  $user_id;

					$output['crawlby'] =  $search_crawl_data_val['crawlby'];

					$output['url'] =  $search_crawl_data_val['url'];

					$output['proxy'] =  $search_crawl_data_val['proxy'];

					$output['keyword'] =  $search_crawl_data_val['keyword'];

					$output['searchstring'] =  $search_crawl_data_val['searchstring'];

                    $output['title'] = "";
					$output['content_intros'] = "";
					$output['body_content'] = "";
					$output['conclusion'] = "";
					
                    if($html_answer->find('title',0))
					{
					  if(str_word_count($this->filter_content(trim($html_answer->find('title',0)->plaintext))) >= 4)
					    $output['title'] = $this->filter_content(trim($html_answer->find('title',0)->plaintext));
					}

					if(count($gettext) > 0)
					{
						if(str_word_count($gettext[0]) >= 30 && str_word_count($gettext[0]) <= 2000)
                         $output['content_intros'] = $gettext[0];

						$str = "";

						for($i=1;$i<count($gettext);$i++)
						{
							$body = "";

							$body = $gettext[$i];

							$str .= $body;
						}

                        if(str_word_count($str) >= 30 && str_word_count($str) <= 2000)
						 $output['body_content'] = $str;

						if(count($gettext) > 2 && isset($gettext[count($gettext)-1]))
						{
							if(str_word_count($gettext[count($gettext)-1]) >= 30 && str_word_count($gettext[count($gettext)-1]) <= 2000)
						       $output['conclusion'] = $gettext[count($gettext)-1];
						}
					}	

					$output['bullet_points'] =  '';

					$output['campaign_main_page_url'] =  $search_crawl_data_val['main_url'];

					$output['date_entered'] =  date("Y-m-d H:i:s");

					$output['date_modified'] =  date("Y-m-d H:i:s");

					foreach($exclusions as $exclude){

						if($domain == $exclude)
						{
							$flag = false;
							break;
						}
					}

					if($flag){

						$retarr = $this->scrapper_model->search_url($search_crawl_data_val['searchstring'], $user_id);

						if(count($retarr) > 0){

							foreach($retarr as $arr){

								if(trim(strtolower($arr['url'])) == trim(strtolower($search_crawl_data_val['url'])))
								{
								  $flag = false;
								  break;
								}
							}
						}
					}

					if($flag)
					{
					   $this->scrapper_model->insertCrawlData($output);
					}

					$counter_answers++;	
			        $counter_crawl++;
			}
		}
	}

	public function filter_content($content)
	{
		$content = preg_replace('/\b(https?|ftp|file):\/\/|(www|WWW)[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content);

        $content = preg_replace('#([a-zA-Z0-9-+&\#\/%?=~_\*|$!:,.;]*)@([a-zA-Z0-9-+&\#\/%?=~_\*|$!:,.;]*)#', '', $content);

		$content = preg_replace('#([a-zA-Z0-9-+&\#\/%?=~_\*|$!:,.;]*).(com|net|info|org|us|biz)#', '', $content);
		
		$content = preg_replace("/&#?[a-z0-9]+;/i",'',$content);

		$content = preg_replace("#[â€™|â€|™|©|®|\#|\-|=|%|:]*#",'',$content);
		
		$content = preg_replace("#[0-9]*#",'',$content);
		
		$content = preg_replace("#\?{2,}#","?",$content);
		
		$content = preg_replace("#\.{2,}#",".",$content);

		$content = strip_tags($content);
		
		$content = preg_replace('/[^a-zA-Z.?\s]/', '', $content);
		
		$content = preg_replace('/\s+/', ' ',$content);

		return $content;
	}

	public function sendtoapi(){

        $spinnedtxt = array();

		$retarr = $this->scrapper_model->return_crawl_data();

		if(count($retarr) > 0)
		{
			$title = "{ ";

			$intro = "{ ";

			$body = "{ ";

			$conclusion = "{ ";

			$title_count=1;

			$intro_count=1;

			$body_count=1;

			$conclusion_count=1;
			
			$keywords = "";

			foreach($retarr as $arr)
			{
				if($arr['title'] != "")
				{ 
					if($title_count <= 20)
					{
						$title .= "#".$title_count."T# ".str_replace("|","",$arr['title'])." | ";
						$title_count++;
					}
				}

				if($arr['content_intros'] != "")
				{
					if($intro_count <= 10)
					{
				        $intro .= "#".$intro_count."A# ".str_replace("|","",$arr['content_intros'])." | ";
						$intro_count++;
					}
				}

				if($arr['body_content'] != "")
				{
				    if($body_count <= 30)
					{
						$body .= "#".$body_count."B# ".str_replace("|","",$arr['body_content'])." | ";
						$body_count++;
					}
			    }

				if($arr['conclusion'] != "")
				{
					 if($conclusion_count <= 10)
					{
						$conclusion .= "#".$conclusion_count."C# ".str_replace("|","",$arr['conclusion'])." | ";
						$conclusion_count++;
					}
				}
				
				$keywords .= $arr['keyword']."\n";
			}

			for($i=1;$i<$title_count;$i++)
			$keywords .= "#".$i."T#\n";

			for($i=1;$i<$intro_count;$i++)
			$keywords .= "#".$i."A#\n";
			
			for($i=1;$i<$body_count;$i++)
			$keywords .= "#".$i."B#\n";
			
			for($i=1;$i<$conclusion_count;$i++)
			$keywords .= "#".$i."C#\n";
			
			$keywords = rtrim($keywords,"\n");

			$title = rtrim($title," | ");

			$title .= " } ";

			$intro = rtrim($intro," | ");

			$intro .= " } ";

			$body = rtrim($body," | ");

			$body .= " } ";

			$conclusion = rtrim($conclusion," | ");

			$conclusion .= " }";

  $content = $title.$intro.$body.$conclusion;

  $resultarr = explode(" ", $content);

  $start = 0;
  $length = 3500;
  $response = "";
  
  //api configuration
  $exceededkey = array();
  $shufflekey = 0;
  $apikeys[0] = array('email' => 'spax@rpautah.com', 'key' => 'c8b4864#4edbc84_b8cfb04?0b6a6b5');
  $apikeys[1] = array('email' => 'spax@rpausa.com', 'key' => 'e0a9f07#5c11d3e_91f7466?cf1342c');
  
  $data = array();
  $data['action'] = "text_with_spintax";
  $data['protected_terms'] = $keywords;
  $data['auto_protected_terms'] = "false";
  $data['confidence_level'] = "medium";
  $data['auto_sentences'] = "true";
  $data['auto_paragraphs'] = "false";
  $data['auto_new_paragraphs'] = "false";
  $data['auto_sentence_trees'] = "true";
  $data['use_only_synonyms'] = "true";
  $data['nested_spintax'] = "true";
  $data['spintax_format'] = "{|}";
  
  sleep(60);

  while(1)
  {
      $text = "";

	  $paragraph = array();

	  $paragraph = array_slice($resultarr, $start, $length);

	  if(count($paragraph) > 0)
	  {
		   // $counts = array_count_values($paragraph);
			
			/*if($paragraph[0] == "|")
			 array_shift($paragraph);
			
			if($paragraph[count($paragraph)-1] == "|")
			 array_pop($paragraph);*/
			 
			/*if(isset($counts['{']))
			{
				if(!isset($counts['}']))
				{
					array_push($paragraph,"}");
				}
			}
			
			if(isset($counts['}']))
			{
				if(!isset($counts['{']))
				{
					array_unshift($paragraph, "{");
				}
			}*/

			$text = implode(" ", $paragraph);

			$text = str_replace("{", "", $text);
			$text = str_replace("}", "", $text);
	
			if(substr($text, 0, 1) != "{")
			  $text = "{ ".trim($text);
	
			if(substr($text, -1) != "}")
			  $text = trim($text)." }";
			  
			  $data['email_address'] = $apikeys[$shufflekey]['email'];
			  $data['api_key'] = $apikeys[$shufflekey]['key'];
			  
			  $data['text'] = $text;
		
			  $api_response = $this->spinrewriter_api_post($data);
		  
			  $api_response_interpreted = json_decode($api_response, true);
			  
			  if(strtolower($api_response_interpreted['status']) == "error")
			  {
				  //echo $api_response_interpreted['response'];
	
				  if(strpos($api_response_interpreted['response'], "API quota exceeded") !== false)
				  {
					  if(!in_array($shufflekey, $exceededkey)) 
						$exceededkey[] = $shufflekey;
					  
					  if(count($exceededkey) == 2)
					   break;
					  
					  $shufflekey = $this->shuffle_api_key($shufflekey);
					  continue;
				  }
				  elseif(strpos($api_response_interpreted['response'], "The {first|second} spinning syntax invalid") !== false || 
				  strpos($api_response_interpreted['response'], "API abuse warning. You can make up to 6 valid requests per minute") !== false)
				  {
					  sleep(180);
					  continue;
				  }
				  else
				  {
					  //break;
					  sleep(30);
					  continue;
				  }
			  }
	
			  $response .= $api_response_interpreted['response'];
			  $start = $start + $length;
	  }
	  else
	   break;

      $shufflekey = $this->shuffle_api_key($shufflekey);
	   
	  /* echo $response;
	   ob_flush();
	   flush();*/
	   
	sleep(30);
   }

	 if($response != "")
	 {
	   $article = array();
	   $resultarray = array();
	   $identifiers = array('T' => $title_count - 1, 'A' => $intro_count - 1, 'B' => $body_count - 1, 'C' => $conclusion_count - 1);
	   
	   foreach($identifiers as $key => $id)
	   {
		 $resultarray[$key] = $this->compile_response($response, $key, $id);
	   }

        if(count($resultarray) > 0)
		  $article = $this->create_article($resultarray);
	 }
  }
  
  $returndata['title'] = $resultarray['T'];
  $returndata['article'] = $article;
  
 /* echo "<pre>";
  print_r($spinnedtxt);*/

  //return $article;
  
  return $returndata;
 }
 
 public function shuffle_api_key($keyindex)
 {
	 if($keyindex == 0)
	     $keyindex = 1;
	   else
	     $keyindex = 0;
		 
	 return $keyindex;
 }
 
 public function spinrewriter_api_post($data){
		
		$data_raw = "";

		foreach ($data as $key => $value){
			$data_raw = $data_raw . $key . "=" . urlencode($value) . "&";
		}

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://www.spinrewriter.com/action/api");

		curl_setopt($ch, CURLOPT_POST, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_raw);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = trim(curl_exec($ch));

		curl_close($ch);

		return $response;
	}
 
 
 public function compile_response($response, $tag, $cnt){
	 
	 $resultarray = array();
	 $enloop = false;
	 
	 if($response != "")
	 {
		 for($i=1;$i<=$cnt;$i++)
		 {
			 $tmpstr = "";
			 $duplicate = false;
			 
			 if(strpos($response, "# ".$i.$tag." #") !== false)
			 {
				$st = strpos($response, "# ".$i.$tag." #");
				
				$tmpstr = substr($response, $st+7);
				 
			     if(strpos($tmpstr, "# ".$i.$tag." #") !== false)
				 {
					 $enpos = strpos($tmpstr, "# ".$i.$tag." #");
					 $duplicate = true;
				 }
					 if($i < $cnt)
					 {
						 $count = $i; 
						 while(1)
						 {
							 $count++;
							 
							 if(strpos($tmpstr, "# ".$count.$tag." #") !== false)
							 {
							   $en = strpos($tmpstr, "# ".$count.$tag." #");
							   break;
							 }
						 }
					 }
					 else
					 {
						 $j = 1;
						 
						 $nextkey = "";
						 
						 if($tag == "T")
						  $nextkey = "A";
						 
						 if($tag == "A")
						  $nextkey = "B";
						  
						 if($tag == "B")
						  $nextkey = "C";
	 
						  while(1)
						  {
							  if($tag == "C")
							  {
								 $en = strlen($tmpstr);
								 $enloop = true;
							     break;
							  }
							  else
							  {
								 if(strpos($tmpstr, "# ".$j.$nextkey." #") !== false)
								 {
								   $en = strpos($tmpstr, "# ".$j.$nextkey." #");
								   break;
								 }
							  }
							 
							 $j++;
						  }
					 }
					 
				 if($duplicate)
				 {
					 if(isset($enpos) && isset($en))
					 {
						 if($enpos < $en)
						   $en = $enpos;
					 }
				 }

				 $result = preg_split("/# [0-9A-Z]+ #/", substr($tmpstr, 0, $en));

				 $resultarray[$i.$tag] = $result[0];
			 }
			 
			  if($enloop)
			    break;
		 }
	 }
	 
	 return $resultarray;
 }
 
 public function create_article($arr)
 {
	 $article = array();
	 
	 $title = array();
	 $intro = array();
	 $body1 = array();
	 $body2 = array();
	 $body3 = array();
	 $body4 = array();
	 $conclusion = array();

	   foreach($arr as $key=>$record)
	   {
		   //title
		   if($key == "T")
		   {
			   for($ar=1;$ar<=20;$ar++)
			   {
				   while(1)
				   {
					   $val = rand(1,20);
					   if(isset($record[$val.$key]))
					   {
						 $title[$ar] = $record[$val.$key];
						 break;
					   }
				   }
			   }
		   }
		   
		   // intro 
		   if($key == "A")
		   {
			   $i=1;
			   
			   for($ar=1;$ar<=20;$ar++)
			   {
				   if($i == 11)
				    $i = 1;
				   
				   if(isset($record[$i.$key]))
					 $intro[$ar] = $record[$i.$key];
				   else
				     $intro[$ar] = $this->get_random($record,$key);
				   
				   $i++;
			   }	 
		   }
		   
		   // body 1
		   if($key == "B")
		   {
			   $i=5;
			   $reverse = false;
			   
			   for($ar=1;$ar<=20;$ar++)
			   {
				   if($i == 15)
				   {
				    $i = 14;
					$reverse = true;
				   }
				   
				   if(isset($record[$i.$key]))
					 $body1[$ar] = $record[$i.$key];
				   else
				     $body1[$ar] = $this->get_random($record,$key);
				   
				   if($reverse)
				     $i--;
				   else
				     $i++;
			   }	 
		   }

		   // body 2
		   if($key == "B")
		   {
			   $i=15;
			   
			   for($ar=1;$ar<=20;$ar++)
			   {
				   if($i == 30)
				    $i = 15;
				   
				   if(isset($record[$i.$key]))
					 $body2[$ar] = $record[$i.$key];
				   else
				     $body2[$ar] = $this->get_random($record,$key);
				   
				   $i++;
			   }	 
		   }

		   // body 3
		   if($key == "B")
		   {
			   $i=25;
			   $flag = false;
			   $count=1;
			   
			   for($ar=1;$ar<=20;$ar++)
			   {
				   if($ar == 11)
				   {
					$i = 20;
					$flag = true;
				   }
					   
				   if($ar % 2 != 0)
				   {
					   if(isset($record[$i.$key]))
						 $body3[$ar] = $record[$i.$key];
					   else
					     $body3[$ar] = $this->get_random($record,$key);

					   if($count == 5)
					   {
						   if(isset($record['30'.$key]))
						     $body3[$ar] = $record['30'.$key];
						   else
						     $body3[$ar] = $this->get_random($record,$key);
					   }
					   
					   $i++;
					   
					   if($flag)
					     $count++;
			       }
				   else
				     $body3[$ar] = "";
			   }	 
		   }

		   // body 4
		   if($key == "B")
		   {
			   for($ar=1;$ar<=20;$ar++)
			   {
				   $body4[$ar] = "";
				   
				   if($ar == 1)
				   {
					   if(isset($record['30'.$key]))
						 $body4[$ar] = $record['30'.$key];
					   else
						 $body4[$ar] = $this->get_random($record,$key);
				   }

				   if($ar == 3)
				   {
					    if(isset($record['1'.$key]))
					      $body4[$ar] = $record['1'.$key];
						else
						  $body4[$ar] = $this->get_random($record,$key);
				   }
 
				   if($ar == 4)
				   {
					    if(isset($record['2'.$key]))
					      $body4[$ar] = $record['2'.$key];
						else
						  $body4[$ar] = $this->get_random($record,$key);
				   }
	   
				   if($ar == 5)
				   {
					    if(isset($record['3'.$key]))
					      $body4[$ar] = $record['3'.$key];
						else
						  $body4[$ar] = $this->get_random($record,$key);
				   }
				   
				   if($ar == 7)
				   {
					    if(isset($record['4'.$key]))
					      $body4[$ar] = $record['4'.$key];
						else
						  $body4[$ar] = $this->get_random($record,$key);
				   }
			   }	 
		   }
		   
		   // conclusion
		   if($key == "C")
		   {
			   $i=2;
			   
			   for($ar=1;$ar<=20;$ar++)
			   {
				   if($ar <= 9)
				   {
					   if(isset($record[$i.$key]))
						 $conclusion[$ar] = $record[$i.$key];
					   else
						 $conclusion[$ar] = $this->get_random($record,$key);
					   
					   $i++;
				   }
				   
				   if($ar == 10)
				   {
					    if(isset($record['1'.$key]))
					      $conclusion[$ar] = $record['1'.$key];
						else
						  $conclusion[$ar] = $this->get_random($record,$key);
				   }
  
				  if($ar >= 11 && $ar <= 14)
				  {
					  if($ar == 11)
					   $i=7;
					   
					  if(isset($record[$i.$key]))
						$conclusion[$ar] = $record[$i.$key];
					  else
						$conclusion[$ar] = $this->get_random($record,$key);
   
					   $i++;   
				  }

				  if($ar >= 15)
				  {
					  if($ar == 15)
					   $i=1;
					   
					  if(isset($record[$i.$key]))
						$conclusion[$ar] = $record[$i.$key];
					  else
						$conclusion[$ar] = $this->get_random($record,$key);
   
					   $i++;   
				  }   
			   }	 
		   } 
	   }
	   
	   for($ar=1;$ar<=20;$ar++)
	   {
		   $article[$ar] = $title[$ar].$intro[$ar].$body1[$ar].$body2[$ar].$body3[$ar].$body4[$ar].$conclusion[$ar];
	   }
	   
	   return $article;
 }
 
 public function get_random($record, $key)
 {
	 $el = "";
	 $retval = "";
	 $st = 1;
	 $en = 10;
	 
	 if($key == "B")
	  $en = 30;
	 
	 while(1)
	 {
		 $el = rand($st, $en);
		 if(isset($record[$el.$key]))
		 {
			 $retval = $record[$el.$key];
			 break;
		 }
	 }
	 
	 return $retval;
 }

	public function google_search(){

		$this->load->view('scrapper_blog');
	}

	public function syscon($action, $keywords, $synonyms, $topics, $user_id){
		
		$campaign_id = 1;
		$status = false;

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		/*$word_details = $this->scrapper_model->campaignKeywords($campaign_id, $user_id);

		$keywords_array = explode(',',$word_details->keywords);

		$synonyms_array = explode(',',$word_details->synonyms);

		$topics_array = explode(',',$word_details->topics);*/
		
		$keywords_array = explode(',',$keywords);

		$synonyms_array = explode(',',$synonyms);

		$topics_array = explode(',',$topics);

		$sentence['keyword']  = $this->buildSentence($keywords_array, 'Keyword');

		$sentence['synonyms']  = $this->buildSentence($synonyms_array, 'Keyword');

		$sentence['generic']  = $this->buildSentence($topics_array, 'Generic');

		foreach($sentence['keyword'] as $keyword_crawl){

			$url = '';

			$output	= array();

			$searchstring		= $keyword_crawl['sentence'];

			$searchstring 		= str_replace(" ", "+", $searchstring);

			$proxy		= $proxy_list[rand(1,5)]['proxy'];

			$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

        if($action == 'gr'){

			$reffer = "http://www.google.com/search";

			$url = 'https://www.google.com/search?q='.$searchstring.'&oq=tenant+screening&ie=UTF-8&num=100'; //Rank search

		}elseif($action == 'google'){

			$reffer = "http://www.google.com/search";

			$url = 'https://www.google.com/search?q='.$searchstring.':blog&num=100';  //Blog search

		}elseif($action == 'yahoo'){

			$reffer = "https://answers.yahoo.com";//Reffer Yahoo Answer

			$url = 'https://answers.yahoo.com/search/search_result;_ylt=ApbcXMFap1JBQNJIIG0I50Lj1KIX?fr=uh3_answers_vert_gs&type=2button&p='.$searchstring;  //Yahoo Answer search
		}

		/*Do crawl*/
		if($action == 'google' || $action == 'gr'){

			$html = str_get_html($this->crawl_simple($reffer, $url, $agent, $proxy));//Google Rank and Blog

			foreach($html->find('li[class=g]') as $li){
				
				$flag = true;

				$output['campaign_id'] = $campaign_id;
				
				$output['user_id'] = $user_id;

				$output['proxy'] = $proxy;

				$output['keyword'] = $keyword_crawl['word'];

				$output['searchstring'] = $keyword_crawl['sentence'];

				$output['title'] = $li->find('a',0)->plaintext;

				$output['url'] = $li->find('cite',0)->plaintext;

				$output['query_url'] = str_replace('/url?q=','',$li->find('a',0)->href);

				$output['crawlby'] = 'google';

				$output['date_added'] = date("Y-m-d H:i:s");

                $google_crawl_data = $this->scrapper_model->get_search_crawl_data($action, $user_id);
				
				foreach($google_crawl_data as $google_crawl_data_val){

					if(trim(strtolower($google_crawl_data_val['url'])) == trim(strtolower($output['url'])))
					{
						$flag = false;
						break;
					}
				}

				if($flag)
				  $status = $this->scrapper_model->insertSearchCrawlData('google', $output);
			}
		}
		elseif($action == 'yahoo'){

			$html = str_get_html($this->crawl_simple($reffer, $url, $agent, $proxy));//Yahoo Answer

        /*Yahoo answer parsing*/
            foreach($html->find('ul[id=yan-questions]',0)->find('li') as $li){

				$flag = true;

				$output['campaign_id'] = $campaign_id;

				$output['user_id'] = $user_id;

				$output['proxy'] = $proxy;

				$output['keyword'] = $keyword_crawl['word'];

				$output['searchstring'] = $keyword_crawl['sentence'];

                $output['title'] = $li->find('h3',0)->find('a',0)->plaintext;

                $output['url'] = $reffer.$li->find('h3',0)->find('a',0)->href;

                $output['description'] = $li->find('span[class=question-description]',0)->plaintext;

                $temp = $li->find('div[class=question-meta]',0)->plaintext;

                if(strstr($temp,'Answers')){

                    $temp = explode('Answers',$temp);

                    $output['answer_no'] = trim($temp[0]);

                }elseif(strstr($temp,'Answer')){

                    $temp = explode('Answer',$temp);

                    $output['answer_no'] = trim($temp[0]);
                }

				$output['crawlby']	= 'yahoo';

				$output['date_added']	= date("Y-m-d H:i:s");

				$google_crawl_data = $this->scrapper_model->get_search_crawl_data($action, $user_id);
				
				foreach($google_crawl_data as $google_crawl_data_val){

					if(trim(strtolower($google_crawl_data_val['url'])) == trim(strtolower($output['url'])))
					{
						$flag = false;
						break;
					}
				}

				if($flag)
				  $status = $this->scrapper_model->insertSearchCrawlData('yahoo', $output);
            }
		}

		}
		
		return $status;
	}

	function crawl_simple($reffer, $url, $agent, $proxy) {

		ob_start();

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_USERAGENT, $agent);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_REFERER, $reffer);

		/*Proxy curl settings*/

		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

		curl_setopt($ch, CURLOPT_PROXY, $proxy);

		// curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'username:passord');
		
		/*SSL settings*/
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		//curl_setopt($ch, CURLOPT_HEADER, 1);

		$result = curl_exec($ch);

		curl_close($ch);

		//ob_flush();

		return $result;

	}

	public function comment_syscon($keywords){

		$action = 'yahoo';

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywords_array = explode(',',$keywords);

		//$synonyms_array = explode(',',$this->input->post('synonyms'));

		//$topics_array = explode(',',$this->input->post('topics'));

		$sentence['keyword']  = $keywords_array;
		
		//$sentence['synonyms']  = $synonyms_array;

		//$sentence['topics']  = $topics_array;

		foreach($sentence['keyword'] as $keyword_crawl){
			
			$url =  '';

			$output		= array();

			$campaign_id		= 2;

			$searchstring		= $keyword_crawl;

			$searchstring 		= str_replace(" ", "+", $searchstring);

			$proxy		= $proxy_list[rand(1,5)]['proxy'];

			$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

			if($action == 'yahoo'){

				$reffer = "https://answers.yahoo.com";//Reffer Yahoo Answer

				$url = 'https://answers.yahoo.com/search/search_result;_ylt=ApbcXMFap1JBQNJIIG0I50Lj1KIX?fr=uh3_answers_vert_gs&type=2button&p='.$searchstring;  //Yahoo Answer search

			}

		if($action == 'yahoo'){

			$html = str_get_html($this->crawl_simple($reffer, $url, $agent, $proxy));//Yahoo Answer        /*Yahoo answer parsing*/

			$urls=array();

            foreach($html->find('ul[id=yan-questions]',0)->find('li') as $li){

				$output['campaign_id'] = $campaign_id;

				$output['proxy'] = $proxy;

				$output['keyword'] = $keyword_crawl['word'];

				$output['searchstring'] = $keyword_crawl['sentence'];

                $output['title'] = $li->find('h3',0)->find('a',0)->plaintext;

                $output['url'] = $reffer.$li->find('h3',0)->find('a',0)->href;

                $output['description'] = $li->find('span[class=question-description]',0)->plaintext;

                $temp = $li->find('div[class=question-meta]',0)->plaintext;

                if(strstr($temp,'Answers')){

                    $temp = explode('Answers',$temp);

                    $output['answer_no'] = trim($temp[0]);

                }elseif(strstr($temp,'Answer')){
                    $temp = explode('Answer',$temp);
                    $output['answer_no'] = trim($temp[0]);
                }
                array_push($urls,$output);
            }
		}			//break;			
		}

       $comments = $this->find_comment($action, $urls);
	   $spintax=$this->comment_sendtoapi($comments);	   
       return $spintax;
		/*$comment_string = '';
			for($c=0;$c<count($comments);$c++){
			$comment_string .= $comments[$c].'*^&';	
			}
		echo $comment_string;*/

	}

	public function find_comment_bkp($action, $search_crawl_data){

		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$proxy = $proxy_list[rand(1,5)]['proxy'];

		if($action == 'yahoo'){
			
			$reffer = "https://answers.yahoo.com";//Reffer Yahoo Answer

			$counter_crawl = 1;

			$counter_answers = 1;

			//$data =array();

			$all_comments = array();

			if($counter_answers < 20){

              $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';

				foreach($search_crawl_data as $search_crawl_data_val){

					$html_answer = str_get_html($this->crawl_simple($reffer, trim($search_crawl_data_val['url']), $agent, $proxy)); //Yahoo Answer

					foreach($html_answer->find('div[class=content]') as $content){

								if(str_word_count($content->plaintext) > 15){

							    $html_text = preg_replace($email_pattern, " ", $content->plaintext);

								array_push($all_comments,trim($html_text));	

								}

					}

				   $counter_answers++;

				}  //end foreach

			} //counter end if

		}

		return $all_comments;

		//echo '<pre>';print_r($data);die();

	}

	public function find_comment($action, $search_crawl_data){

		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$proxy = $proxy_list[rand(1,5)]['proxy'];

		if($action == 'yahoo'){
			
			$reffer = "https://answers.yahoo.com";//Reffer Yahoo Answer
			$counter_crawl = 1;$counter_answers = 1;$data =array();
			$counter_answers = 1;
			//$data =array();
			$all_comments = array();
			
			if($counter_answers < 20){
            $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';

				foreach($search_crawl_data as $search_crawl_data_val){
					$html_answer = str_get_html($this->crawl_simple($reffer, trim($search_crawl_data_val['url']), $agent, $proxy)); //Yahoo Answer
                    $gettext = array();
					foreach($html_answer->find('div[class=content]') as $content){
								$html_text = preg_replace($email_pattern, " ", $content->plaintext);
								$gettext[] = trim($html_text);
							break;
					}					
					//echo "<pre>";print_r($gettext);die;
					
					$output = array();
					//$output['serp_google_crawl_data_id'] =  $search_crawl_data_val['id'];
					$output['campaign_id'] =  $search_crawl_data_val['campaign_id'];
					$output['users_id'] =  '1';
					//$output['crawlby'] =  $search_crawl_data_val['crawlby'];
					$output['url'] =  $search_crawl_data_val['url'];
					$output['proxy'] =  $search_crawl_data_val['proxy'];
					$output['keyword'] =  $search_crawl_data_val['keyword'];
					$output['searchstring'] =  $search_crawl_data_val['searchstring'];
					//$output['title'] = trim($html_answer->find('h1[class=subject]',0)->plaintext);
					$output['body_content'] = "";
					
					if(count($gettext) > 0){
						
						//$output['content_intros'] = $this->filter_content($gettext[0]);
						
						$str = "";
						for($i=0;$i<count($gettext);$i++){
							$body = "";
							$body = $this->filter_content($gettext[$i]);
							$str .= $body;
						}
						
						//if(str_word_count($content->plaintext) >= 5 && str_word_count($content->plaintext) <= 200)
						if(str_word_count($str) >= 15 && str_word_count($content->plaintext) <= 500)
						 $output['body_content'] = $str;
						
						/*if(count($gettext) > 2 && isset($gettext[count($gettext)-1]))
						{
							$output['conclusion'] = $this->filter_content($gettext[count($gettext)-1]);
						}
						else
						 $output['conclusion'] = "";*/
					}
					
					$output['bullet_points'] =  '';
					//$output['campaign_main_page_url'] =  $search_crawl_data_val['main_url'];
					$output['date_entered'] =  date("Y-m-d H:i:s");
					$output['date_modified'] =  date("Y-m-d H:i:s");
			      // $this->scrapper_model->insertCrawlData($output);
				   array_push($all_comments,$output);	
			       $counter_crawl++;					
				   $counter_answers++;
				}  //end foreach
			} //counter end if
		}
		return $all_comments;

		//echo '<pre>';print_r($data);die();

	 } //find_comment function close here 
	 
	 public function comment_sendtoapi($retarr=''){
       if($retarr==''){
		$retarr = $this->scrapper_model->return_crawl_data();
	   }
        $spinnedtxt = array();		

		if(count($retarr) > 0)
		{
			//$title = "{ ";

			//$intro = "{ ";

			$body = "{ ";

			//$conclusion = "{ ";

			//$title_count=1;

			//$intro_count=1;

			$body_count=1;

			//$conclusion_count=1;
			
			$keywords = "";

			foreach($retarr as $arr)
			{
				/*if($arr['title'] != "")
				{ 
					if($title_count <= 15)
					{
						$title .= "#".$title_count."T# ".str_replace("|","",$arr['title'])."|";
						$title_count++;
					}
				}

				if($arr['content_intros'] != "")
				{
					if($intro_count <= 8)
					{
				        $intro .= "#".$intro_count."A# ".str_replace("|","",$arr['content_intros'])."|";
						$intro_count++;
					}
				}*/

				if($arr['body_content'] != "")
				{
				    if($body_count <= 15)
					{
						$body .= "#B# ".str_replace("|","",$arr['body_content'])." | ";
						$body_count++;
					}
			    }

				/*if($arr['conclusion'] != "")
				{
					 if($conclusion_count <= 8)
					{
						$conclusion .= "#".$conclusion_count."C# ".str_replace("|","",$arr['conclusion'])."|";
						$conclusion_count++;
					}
				}*/
				
				$keywords .= $arr['keyword']."\n";
			}

			/*for($i=1;$i<=15;$i++)
			$keywords .= "#".$i."T#\n";

			for($i=1;$i<=8;$i++)
			$keywords .= "#".$i."A#\n";*/
			
			//for($i=1;$i<$body_count;$i++)
			$keywords .= "#B#\n";
			
			/*for($i=1;$i<=8;$i++)
			$keywords .= "#".$i."C#\n";*/
			
			$keywords = rtrim($keywords,"\n");

			/*$title = rtrim($title,"|");

			$title .= "}";

			$intro = rtrim($intro,"|");

			$intro .= "}";*/

			$body = rtrim($body," | ");

			$body .= " }";

			/*$conclusion = rtrim($conclusion,"|");

			$conclusion .= "}";*/


  $content = $body;

  $resultarr = explode(" ", $content);

  $start = 0;
  $length = 3500;
  $response = "";
  
  //api configuration
  $exceededkey = array();
  $shufflekey = 0;
  $apikeys[0] = array('email' => 'spax@rpautah.com', 'key' => 'c8b4864#4edbc84_b8cfb04?0b6a6b5');
  $apikeys[1] = array('email' => 'spax@rpausa.com', 'key' => 'e0a9f07#5c11d3e_91f7466?cf1342c');
  
  $data = array();
  $data['action'] = "text_with_spintax";
  $data['protected_terms'] = $keywords;
  $data['auto_protected_terms'] = "false";
  $data['confidence_level'] = "medium";
  $data['auto_sentences'] = "true";
  $data['auto_paragraphs'] = "false";
  $data['auto_new_paragraphs'] = "false";
  $data['auto_sentence_trees'] = "true";
  $data['use_only_synonyms'] = "true";
  $data['nested_spintax'] = "true";
  $data['spintax_format'] = "{|}";
  
  sleep(60);

  while(1)
  {
      $text = "";

	  $paragraph = array();

	  $paragraph = array_slice($resultarr, $start, $length);

	  if(count($paragraph) > 0)
	  {
		$text = implode(" ", $paragraph);

		$text = trim($text);
		$text = str_replace("{", "", $text);
		$text = str_replace("}", "", $text);
		$text = rtrim($text," |");

		if(substr($text, 0, 1) != "{")
		  $text = "{ ".$text;

		if(substr($text, -1) != "}")
		  $text = $text." }";
		  
		  $data['email_address'] = $apikeys[$shufflekey]['email'];
		  $data['api_key'] = $apikeys[$shufflekey]['key'];
		  
		  $data['text'] = $text;
	
		  $api_response = $this->spinrewriter_api_post($data);
	  
		  $api_response_interpreted = json_decode($api_response, true);
		  
		  if(strtolower($api_response_interpreted['status']) == "error")
		  {
			  echo $api_response_interpreted['response'];

			  if(strpos($api_response_interpreted['response'], "API quota exceeded") !== false)
			  {
				  if(!in_array($shufflekey, $exceededkey)) 
				    $exceededkey[] = $shufflekey;
				  
				  if(count($exceededkey) == 2)
				   break;
				  
				  $shufflekey = $this->shuffle_api_key($shufflekey);
				  continue;
			  }
			  else
			    break;
		  }
		  $response .= $api_response_interpreted['response'];
		  $start = $start + $length;
	  }
	  else
	   break;

      $shufflekey = $this->shuffle_api_key($shufflekey);
	   
	   /*echo $response;
	   ob_flush();
	   flush();*/
	   
	sleep(30);
   }
 
// echo $response;
 
	/* if($response != "")
	 {
	   $resultarray = array();
	   $identifiers = array('T' => 20, 'A' => 10, 'B' => 30, 'C' => 10);
	   
	   foreach($identifiers as $key => $id)
	   {
		 $resultarray[$key] = $this->compile_response($response, $key, $id);
	   }

        if(count($resultarray) > 0)
		  $article = $this->create_article($resultarray);
		 
		 if(isset($article) && count($article) > 0)
		 {
			 for($i=1;$i<=count($article);$i++)
			 {
				 $spinnedtxt[$i] = $this->scrapper_model->spin($article[$i]);
			 }
		 }
	 }*/
  }
  return $response;
  }
	 
	 public function comment_sendtoapi_bkp($retarr=''){
       if($retarr==''){
		$retarr = $this->scrapper_model->return_crawl_data();
	   }
		if(count($retarr) > 0)
		{
			$title = "{";
			$intro = "{";
			$body = "{";
			$conclusion = "{";
			$title_count=1;
			$intro_count=1;
			$body_count=1;
			$conclusion_count=1;			
			$keywords = "";
			foreach($retarr as $arr)
			{
				if($arr['title'] != "")
				{ 
					if($title_count <= 20)
					{
						$title .= str_replace("|","",$arr['title'])."|";
						$title_count++;
					}
				}

				if($arr['content_intros'] != "")
				{
					if($intro_count <= 10)
					{
				        $intro .= $intro_count."A".str_replace("|","",$arr['content_intros'])."|";
						$intro_count++;						
						$keywords .= $intro_count."A\n";
					}
				}

				if($arr['body_content'] != "")
				{
				    if($body_count <= 30)
					{
						$body .= $body_count."B".str_replace("|","",$arr['body_content'])."|";
						$body_count++;
						
						$keywords .= $body_count."B\n";
					}
			    }

				if($arr['conclusion'] != "")
				{
					 if($conclusion_count <= 10)
					{
						$conclusion .= $conclusion_count."C".str_replace("|","",$arr['conclusion'])."|";
						$conclusion_count++;						
						$keywords .= $conclusion_count."C\n";
					}
				}				
				$keywords .= $arr['keyword']."\n";
			}			
			$keywords = rtrim($keywords,"\n");
			$title = rtrim($title,"|");
			$title .= "}";
			$intro = rtrim($intro,"|");
			$intro .= "}";

			$body = rtrim($body,"|");

			$body .= "}";

			$conclusion = rtrim($conclusion,"|");

			$conclusion .= "}";		

  $content = $title.$intro.$body.$conclusion;
  $resultarr = explode(' ', $content);
  $start = 0;
  $end = 1000;
  $spintax='';
  while(1)
  {
      $text = "";
	  $paragraph = array();
	  $paragraph = array_splice($resultarr, $start, $end);
	  if(count($paragraph) > 0){
		$text = implode(' ', $paragraph);
		if(substr($text, 0, 1) != "{")
		  $text = "{".$text;
		if(substr($text, -1) != "}")
		  $text .= "}";
	$data = array();

	// Spin Rewriter API settings - authentication:
	$data['email_address'] = "spax@rpautah.com";

	$data['api_key'] = "c8b4864#4edbc84_b8cfb04?0b6a6b5";

	// Spin Rewriter API settings - request details:
	$data['action'] = "text_with_spintax";
	
	$data['text'] = $text;

	$data['protected_terms'] = $keywords;

	$data['auto_protected_terms'] = "false";

	$data['confidence_level'] = "medium";

	$data['auto_sentences'] = "true";

	$data['auto_paragraphs'] = "true";

	$data['auto_new_paragraphs'] = "false";

	$data['auto_sentence_trees'] = "true";

	$data['use_only_synonyms'] = "true";				

	$data['nested_spintax'] = "true";

	$data['spintax_format'] = "{|}";
	
	$api_response = $this->spinrewriter_api_post($data);

	$api_response_interpreted = json_decode($api_response, true);

	$spintax .= $api_response_interpreted['response'];
	
	 $start = $end+1;

     $end = $end+1000;
	}  // count paragraph close here
	else
	 break;
}   echo $spintax;
  }  //count array close here
 }  // function close here
 
function valid_spintax(){
$data['action'] = $this->input->post('action');
$val = $this->input->post('chk_value');
$opentag= count(explode('{', $val));
$closetag = count(explode('}', $val));
$pattern = '/{(.*?)}/'; //(?=.*[0-9]) '/^{(.*?)}/'
if(preg_match($pattern, $val, $matches, PREG_OFFSET_CAPTURE) && $opentag==$closetag){
echo 'yes';
}else{
echo 'no';
}
}

public function mysql_reconnect()
{
	$this->db->close();
    $this->db->initialize();
}

} // class close here
