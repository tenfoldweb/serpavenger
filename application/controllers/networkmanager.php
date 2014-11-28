<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NetworkManager extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('networkmanager_model');
   $this->load->model('scrapper_model');
   
   $this->load->model('userlogin_model');

   if(!$this->session->userdata('user_data'))
   {
	 redirect(Am_Lite::getInstance()->getLoginURL());
   }
   $this->load->library("pagination");
 }
	
	public function index()
	{
		$add_uncategorized = true;
		
		$session = $this->session->userdata('user_data');
		
		$networks = $this->networkmanager_model->fetch_networks();
		
		$data['networks'] = $networks;
		
		foreach($networks as $ntwks)
		{
			if($ntwks['networkname'] == 'Uncategorized')
			{
			 $add_uncategorized = false;
			 break;
			}
		}
		
		if($add_uncategorized)
		{
				$default_network = array('network_name' => 'Uncategorized', 'added_date' => date('Y-m-d'), 'users_id' => $session['user_id']);
				
				$this->networkmanager_model->add_new_network($default_network);
		}

		$get_packages = $this->userlogin_model->get_packages($session['user_id']);
		
		$data['packages'] = $get_packages;
		
			foreach($get_packages as $row)
			{
				if($row['networkmanager_permission'] == 1)
				{
					$permission = TRUE; 
					break;
				}
				else
				{
					$permission = FALSE;
				}
			}

			$data['adddomain'] = true;

			$domain_count = $this->networkmanager_model->count_user_domains($session['user_id']);
			$total_domains_allowed = 0;
			foreach($get_packages as $row)
			{
				$total_domains_allowed += $row['max_domain_no'];
			} 
	
			if($domain_count >= $total_domains_allowed)
			{
				$data['adddomain'] = false;
			}
			
			if((isset($_REQUEST['tx']) && $_REQUEST['tx']!='') && (isset($_REQUEST['st']) && $_REQUEST['st']=='Completed')){
				$index = 0;
			foreach($get_packages as $row){
				
				if($_REQUEST['custom']==$row['package_id']){
					$package_index = $index; 
				}
				$index++;
			}
			$get_packages[$package_index]['networkmanager_permission'] = 1;
					
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
			
			if(isset($_REQUEST['domainno']))
			$data['max_domain_no'] = $_REQUEST['domainno'];
		
			$insert_status = $this->scrapper_model->user_added_permission($data);
			
			$this->session->set_userdata('user_data', $session);
			
			$this->session->set_flashdata('message', '<div class="notification note-success">
					<a title="Close notification" class="close" href="#">close</a>
					<p>You have successfully upgraded your membership package!</p>
				</div> ');

			redirect('networkmanager');
		}
		
		$uid = $session['user_id'];
		$data['page_title'] = 'SERP Avenger';
		$data['end']='';
		$data['permission'] = $permission;
		
		if($this->session->userdata('ahref_state'))
		{
			$session_state = $this->session->userdata('ahref_state');
			
			if(isset($_GET['state']) && $_GET['state'] != "")
			{
				if($session_state == $_GET['state'])
				{
					if(isset($_GET['code']) && $_GET['code'] != "")
					{
						$ahref_code = $_GET['code'];
						
						$ahref_data = $this->networkmanager_model->fetch_access_token($ahref_code);

						if(isset($ahref_data['access_token']))
						{
							$settings['backlink_stat'] = 1;
							$settings['backlink_update'] = 1;
							$settings['access_token'] = $ahref_data['access_token'];
							$settings['expires_in'] = $ahref_data['expires_in'];
							
							$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="close" href="#">close</a><p>Ahrefs Backlink Data Activated</p></div>');
						}
						else
						  $settings['backlink_stat'] = 0;
						
						$this->networkmanager_model->update_settings($settings, $uid);
					}
				}
			}
			$this->session->unset_userdata('ahref_state');
			redirect('networkmanager');
		}
		
		$domains = $this->networkmanager_model->fetch_domains();
		
		$data['domains'] = $domains;
		
		$networksetting = $this->networkmanager_model->default_network_setting($uid);
		
		$data['networksetting'] = $networksetting;
		
		$pausereason = explode(",",$networksetting['pauseposting']);
		
		if(count($pausereason) > 0)
		{
			$pausekey = array();

				foreach($domains as $key=>$dom)
				{
					  for($i=0;$i<count($pausereason);$i++)
					  {
						  if($pausereason[$i] == "Unindexed")
						  {
							  if($dom['indexed'] == 0)
							   $pausekey[] = $key;
						  }
						  
						  if($pausereason[$i] == "Site down")
						  {
							  
						  }
						  
						  if(strpos($pausereason[$i], "Pagerank") !== false)
						  {
							  $lessrank = explode("<", $pausereason[$i]);
							  
							  if($dom['pagerank'] < $lessrank[1])
							   $pausekey[] = $key;
						  }
					}
			   }
			
			
			$this->networkmanager_model->pause_posting_now($pausekey, $session['user_id']);
		}
		
		$category = $this->networkmanager_model->fetch_category($session['user_id']);
		
		$data['category'] = $category;
		
		$posts = $this->networkmanager_model->fetch_posts($session['user_id']);
		
		$data['posts'] = $posts;
		
		$id = "";
		$search = "";
		
		if($this->input->get('search') && $this->input->get('search') != "")
		       $search = trim(strtolower($this->input->get('search')));
		
		if($this->input->get('searchanchor') && $this->input->get('searchanchor') == "anchors")
		{
			$postsearch = array();
			$linksearch = array();
			$anchorsearch = array();
			
			$linksearch = $this->searchby('link', $search);
			$anchorsearch = $this->searchby('anchor', $search);
			
			$postsearch = array_merge($linksearch, $anchorsearch);
			
			if(count($postsearch) > 0)
		      $data['postsearch'] = $postsearch;
		}
        else
		{
			$details = $this->networkmanager_model->fetch_details($id, $search);
			$data['retarr'] = $details;
		}
		
		if($this->input->get('editlink') && $this->input->get('editlink') == "1")
		{ 
		   $postresult = array();
		   
		  if($this->input->get('domain') && $this->input->get('domain') != "")
		  {
			  $domsearch = "";
		      $domsearch = trim(strtolower($this->input->get('domain')));
			  
			  $postresult = $this->searchby('link', $domsearch);
		  }
		  
		  if($this->input->get('anchor') && $this->input->get('anchor') != "")
		  {
			  $anchor = "";
		      $anchor = trim(strtolower($this->input->get('anchor')));
		  
			  $postresult = $this->searchby('anchor', $anchor);
		  }

		  if(count($postresult) > 0)
		   $data['postarr'] = $postresult;
		}

		$this->load->view('networkmanager', $data);
	}
	
	public function updatesettings()
	{
		$session = $this->session->userdata('user_data');
		$uid = $session['user_id'];
		$pauseposting = "";
		
		if($this->input->post('unindexed') != "")
		 $pauseposting .= $this->input->post('unindexed');

		if($this->input->post('sitedown') != "")
		{
			if($pauseposting != "")
			 $pauseposting .= ",";
			
           $pauseposting .= $this->input->post('sitedown');
		}
		
		/*if($this->input->post('lesspr') != "")
		{
			if($pauseposting != "")
			 $pauseposting .= ",";
			
           $pauseposting .= $this->input->post('lesspr');
		}*/

		if($this->input->post('lesspr') == "Pagerank")
		{
			if($this->input->post('pr') != "")
			{
				if($pauseposting != "")
				 $pauseposting .= ",";
				 
			   $pauseposting .= "Pagerank<".$this->input->post('pr');
			}
		}
		
		$backlinkcount = 0;
		if($this->input->post('backlinkcount'))
		 $backlinkcount = $this->input->post('backlinkcount');
		
		$domainrank = 0;
		if($this->input->post('domainrank'))
		 $domainrank = $this->input->post('domainrank');
		
		$referringdomains = 0;
		if($this->input->post('referringdomains'))
		 $referringdomains = $this->input->post('referringdomains');

		$settings=array(

			'default_blog' => $this->input->post('defaultblog'),

			'default_network' => $this->input->post('defaultnetwork'),

			'index_frequency' => $this->input->post('indexfrequency'),

			'pause_posting' => $pauseposting,
			
			'backlink_count' => $backlinkcount,
			
			'domain_rank' => $domainrank,
			
			'referring_domains' => $referringdomains,

			'ahrefs_frequency' => $this->input->post('ahrefsfrequency'),

			'page_rank' => $this->input->post('pagerank'),
			
			'index_date' => date('Y-m-d'),
			
			'ahrefs_date' => date('Y-m-d'),
			
			'pr_date' => date('Y-m-d'));
			
			$update = $this->networkmanager_model->update_settings($settings, $uid);

			$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
			<a title="Close notification" class="close" href="#">close</a><p>Network Settings Saved</p></div>');
			
			redirect('networkmanager');
	}

	public function uploadfile()
    {
		$status = "";
		$file_element_name = 'domainlist';

		if(!empty($_FILES) && $_FILES['domainlist']['error'] == 0)
		{
		  $this->load->library('upload');
					 
		  $config['tmp_name'] = $_FILES['domainlist']['tmp_name'];
		  $config['upload_path'] = './assets/uploads/';		
		  $config['allowed_types'] = 'text/csv|csv';						 
		  $config['max_size'] = '1500';
		  $config['overwrite'] = FALSE;
		  $config['remove_spaces'] = TRUE;	
		  $config['encrypt_name'] = TRUE;				 
		  $config['file_name'] = $_FILES['domainlist']['name'];
		  $this->upload->initialize($config);
		  $error = 0;
	 
			if(!$this->upload->do_upload($file_element_name))
			{
				$status = 'error';
				$error = 1;
				$msg = $this->upload->display_errors('', '');
			}
			else
			{
				$data = $this->upload->data();
				
				$file = fopen($config['upload_path']."/".$data['file_name'],"r");

				$arr = array();
				
				while(!feof($file))
				{
				  $arr[] = fgetcsv($file);
				}
				
				fclose($file);

                $this->session->set_userdata('newdomainlist',$arr);
				
				unlink($data['full_path']);
			}
		}
    }

	public function addnetwork()
	{
		$session = $this->session->userdata('user_data');
		$uid = $session['user_id'];
		$postdata = array('network_name' => $this->input->post('netwkname'),
		'added_date' => date('Y-m-d'),'users_id' => $uid);
		
		if($postdata['network_name'] != "")
		$retval = $this->networkmanager_model->add_new_network($postdata);
		$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="hide" href="#">close</a><p class="msg success">New Network(s) added successfully</p></div>');
		redirect('networkmanager');
	}

	public function adddomain()
    {	
		$session = $this->session->userdata('user_data');
		
		$get_packages = $this->userlogin_model->get_packages($session['user_id']);

        $total_domains_allowed = 0;
		
		foreach($get_packages as $row)
		{
			$total_domains_allowed += $row['max_domain_no'];
		} 
	
		$session_data = array();
		$domarr = array();
		
		$this->uploadfile();
		
		for($i=1;$i<=10;$i++)
		{
			if($this->input->post('domainname'.$i) && $this->input->post('username'.$i) && $this->input->post('password'.$i))
			  $domarr[] = array('domname' => $this->input->post('domainname'.$i), 'uname' => $this->input->post('username'.$i), 'pass' => $this->input->post('password'.$i));
		}
		
		if(!empty($domarr))
		{
			$postdata = array('network_id' => $this->input->post('selectnetwork'),
			'type' => $this->input->post('selectblogtype'),
			'domarr' => $domarr);
			
			if($this->session->userdata('newdomainlist'))
				$session_data = $this->session->userdata('newdomainlist');
			
			$retval = $this->networkmanager_model->add_new_domain($session['user_id'], $postdata, $session_data, $total_domains_allowed);
			
			if($retval['status'])
			{
			  $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
								  <a title="Close notification" class="close" href="#">close</a><p>'.$retval['domcnt'].' New Domain(s) added successfully</p></div>');
			}
			
			redirect('networkmanager');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="notification note-error" style="padding-top:7px">
								  <a title="Close notification" class="close" href="#">close</a><p>Please add some domain or upload the CSV file of domain list .</div>');
			redirect('networkmanager');
		}
	}
	
	public function deletedomain()
	{
		$session = $this->session->userdata('user_data');
		$uid = $session['user_id'];
		$domid = $this->input->post('domid');
		
		$status = $this->networkmanager_model->delete_domain($domid);
		
		if($status)
		{
			echo $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
								<a title="Close notification" class="close" href="#">close</a><p>Domain(s) deleted successfully</p></div>');
		}
	}

	public function pauseposting()
	{
		$session = $this->session->userdata('user_data');
	    $uid = $session['user_id'];
	 
		$domid = $this->input->post('domid');
		
		$stat = $this->networkmanager_model->pause_posting($domid, $uid);
		
		echo $stat['val'];
	}

	public function editnetwork()
	{
		$networkid = $this->input->post('hidnetid');
		$networkname = $this->input->post('editnetwkname');
		$networkstatus = $this->input->post('hidsnetstat');
		$domainid = $this->input->post('hiddomid');
		$domainstatus = $this->input->post('hiddomstat');
		
		if($networkstatus == 0)
		{
			$retval = $this->networkmanager_model->delete_network($networkid);
		}
		elseif($domainstatus == 0)
		{
			$retval = $this->networkmanager_model->remove_domain($domainid,$networkid);
		}
		else
		{
			if($networkname != "")
			{
			  $postdata = array('network_name' => $networkname);
			  $retval = $this->networkmanager_model->edit_network($networkid, $postdata);
			}
		}
		
		redirect('networkmanager');
	}
	
	public function assigndomains()
	{
		if($this->input->post('domain') && $this->input->post('network'))
		{
		  $domainlist = $this->input->post('domain');
		  $networkid = $this->input->post('network');
		  
		  $retval = $this->networkmanager_model->assign_domains($networkid, $domainlist);
		}
		redirect('networkmanager');
	}
	
	public function ahrefsdata()
	{
		$state = md5(uniqid(rand(), true));

		$this->session->set_userdata('ahref_state',$state);
		
		//for local testing
		/*redirect('https://ahrefs.com/oauth2/authorize.php?response_type=code&client_id=Serp+Avenger-development&scope=api&state='.$state.'&redirect_uri=http%3A%2F%2Flocalhost%2Fserp_avenger%2Fnetworkmanager');*/
		
		//for online server	
redirect('https://ahrefs.com/oauth2/authorize.php?response_type=code&client_id=Serp+Avenger-development&scope=api&state='.$state.'&redirect_uri=http%3A%2F%2Fserpavenger.com%2Fserp_avenger%2Fnetworkmanager');
	}
	
	public function article_update()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		$data['anchor1']   = $this->input->post('anchor1');
		$data['link1']     = $this->input->post('link1');
		$data['anchor2']   = $this->input->post('anchor2');
		$data['link2']     = $this->input->post('link2');
		$data['anchor3']   = $this->input->post('anchor3');
		$data['link3']     = $this->input->post('link3');
		$data['ids'] = array();
		
		$ids = $this->input->post('ids');
		
		if($ids != "")
		  $data['ids'] = explode(",",$ids);

		$status = false;
		for($i=0;$i<count($data['ids']);$i++)
		{
				$arr = $this->scrapper_model->update_article($data['ids'][$i], "get");
	
				if($arr['status'])
				{
				 for($j=1;$j<=3;$j++)
				 {
					 if(trim($arr['data']['content']) != "" && trim($arr['data']['link'.$j]) != "" && trim($arr['data']['anchor'.$j]) != "" 
					 && trim($data['link'.$j]) != "" && trim($data['anchor'.$j]) != "")
				        $this->link_replace($arr['data']['id'], $arr['data']['content'], $arr['data']['link'.$j], $arr['data']['anchor'.$j], $data['link'.$j], $data['anchor'.$j]);
				 }

				 $arr = $this->scrapper_model->update_article($arr['data']['id'], $data, "update");
				}
		}  //for loop end
		
		if(isset($arr['status']) && $arr['status'])
		$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="close" href="#">close</a><p>Links Updated</p></div>');
		
		redirect('networkmanager');
	}
	
	public function link_replace($id, $content, $oldlink, $oldanchor, $newlink, $newanchor)
	{
		$olddata = '<a href="'.$oldlink.'" title="">'.$oldanchor.'</a>';
		$newdata = '<a href="'.$newlink.'" title="">'.$newanchor.'</a>';
		
		$update_data['post_content'] = str_replace($olddata, $newdata, $content, $replaced);
		$update_data['post_modified'] = date('Y-m-d H:i:s');
		
		if($replaced == 0)
		 $update_data['post_content'] .= $newdata;
		
		$this->scrapper_model->update_content($id, $update_data);
	}
	
	public function update_anchor_link()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		$anchor = $this->input->post('anchor1');
		$link = $this->input->post('link1');		
		$field_name = $this->input->post('searchedby');
		$ids = $this->input->post('ids');
		$typesvals = $this->input->post('typesvals');
		
		if($ids != "")
		  $idsarr = explode(",",$ids);
		  
		if($typesvals != "")
          $typesarr = explode(",",$typesvals);
		  
		$res = 0;
		for($i=0;$i<count($idsarr);$i++)
		{
			$oldvals = $this->scrapper_model->find_posts($idsarr[$i]);
			$res = $this->networkmanager_model->update_anchor_links($idsarr[$i], $field_name, $typesarr[$i], $oldvals, $anchor, $link);
			$res += $res;
		}
			
		if($res > 0)
		$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="close" href="#">close</a><p> '.$res.' Links Updated</p></div>');
		
		redirect('networkmanager');
	}
	
	public function addcategory()
	{
		$session = $this->session->userdata('user_data');

		$newcategory = $this->input->post('newcategory');
		
		if(trim($newcategory) != "")
		 $this->networkmanager_model->add_custom_category($newcategory, $session['user_id']);
		
		redirect('networkmanager?add_category=yes');
	}
	
	public function updatecategory($id)
	{
		// $categoryid = str_replace("-"," ",$id);
		
		// $category = explode("_",$categoryid);
		
		// $categoryvalue = $this->input->post($id."_txt");
		
        // if(trim($categoryvalue) != "")
		  $this->networkmanager_model->update_custom_category($_POST['id'],  $_POST['cat_name'] , $_POST['new_value'] );
		
		return true;
	}

	public function searchby($type, $search)
	{
		$session = $this->session->userdata('user_data');

		$postresult = array();
		$posts = $this->networkmanager_model->fetch_posts($session['user_id']);
		
		if($type == 'link')
		{
		  foreach($posts['postarr'] as $pt)
		  { 
			  if(strpos(trim(strtolower($pt['link1'])),$search) !== false)
				  $postresult[] = array('pid' => $pt['id'], 'domainname' => $pt['domainname'], 'post' => $pt['postname'], 'postdate' => $pt['postdate'], 
				  'anchor' => $pt['anchor1'], 'link' => $pt['link1'], 'type' => '1');
			  
			  if(strpos(trim(strtolower($pt['link2'])),$search) !== false)
				  $postresult[] = array('pid' => $pt['id'], 'domainname' => $pt['domainname'], 'post' => $pt['postname'], 'postdate' => $pt['postdate'], 
				  'anchor' => $pt['anchor2'], 'link' => $pt['link2'], 'type' => '2');
			  
			  if(strpos(trim(strtolower($pt['link3'])),$search) !== false)
				  $postresult[] = array('pid' => $pt['id'], 'domainname' => $pt['domainname'], 'post' => $pt['postname'], 'postdate' => $pt['postdate'], 
				  'anchor' => $pt['anchor3'], 'link' => $pt['link3'], 'type' => '3');	  
		  }
		}

		if($type == 'anchor')
		{	
		  foreach($posts['postarr'] as $pt)
		  { 
			  if(strpos(trim(strtolower($pt['anchor1'])),$search) !== false)
				  $postresult[] = array('pid' => $pt['id'], 'domainname' => $pt['domainname'], 'post' => $pt['postname'], 'postdate' => $pt['postdate'], 
				  'anchor' => $pt['anchor1'], 'link' => $pt['link1'], 'type' => '1');
			  
			   if(strpos(trim(strtolower($pt['anchor2'])),$search) !== false)
				  $postresult[] = array('pid' => $pt['id'], 'domainname' => $pt['domainname'], 'post' => $pt['postname'], 'postdate' => $pt['postdate'], 
				  'anchor' => $pt['anchor2'], 'link' => $pt['link2'], 'type' => '2');
			  
			  if(strpos(trim(strtolower($pt['anchor3'])),$search) !== false)
				  $postresult[] = array('pid' => $pt['id'], 'domainname' => $pt['domainname'], 'post' => $pt['postname'], 'postdate' => $pt['postdate'], 
				  'anchor' => $pt['anchor3'], 'link' => $pt['link3'], 'type' => '3');
		  }
		}
		
		return $postresult;
	}
	
	public function update_login_data()
	{
	  $id = $this->input->post('id');
	  $field_name = $this->input->post('field_name');	 
	  $new_value = $this->input->post('new_value');	 
	  $result = $this->networkmanager_model->update_login_details($id, $field_name, $new_value);
	  
	  if($result > 0)
	  {
		 echo $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="close" href="#">close</a><p>Login Data Updates</p></div>');
	  }
	}
	
	public function check_index_now()
	{
		$domains = $this->networkmanager_model->fetch_domains();
		
		foreach($domains as $key=>$dom)
		{
			$indexed = false;
			$indexed = $this->networkmanager_model->check_indexing($dom['domainname']);
			
			$this->networkmanager_model->update_index($indexed, $key);
		}
	}
	
	public function check_pr_now($now=false)
	{
		$status = $this->networkmanager_model->update_pr_now($now);
		
		if($status)
	  	{
		 echo $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="close" href="#">close</a><p>Pagerank updated</p></div>');
	  	}
		
		redirect('networkmanager');
	}

	public function check_ahrefs_now($now=false)
	{
		$status = $this->networkmanager_model->update_ahrefs_now($now);
		
		if($status)
	  	{
		 echo $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
							<a title="Close notification" class="close" href="#">close</a><p>Ahrefs data updated</p></div>');
	  	}
		
		redirect('networkmanager');
	}

	public function check_obl_now()
	{
		$domains = $this->networkmanager_model->update_obl_now();

		redirect('networkmanager');
	}

	public function delete_post_now()
	{
		$status = $this->networkmanager_model->delete_posts();
	}
	
	public function add_user_permissions()
	{
		$permission_name = $this->input->post('name');
		
		$permission_cost = $this->input->post('cost');

		$package_id = $this->scrapper_model->add_custom_permissions($permission_name, $permission_cost);
		
		echo $package_id;
	}
	public function DeleteColom()
	{
			$colom_name = $_REQUEST['name'];
			$response = $this->networkmanager_model->delete_colom($colom_name);
			return true;
	}
}