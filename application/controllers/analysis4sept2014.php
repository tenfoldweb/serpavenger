<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analysis extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_campaign');
		
		
		
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
			$data['max_keyword_track'] = $_REQUEST['keyword'];	
			
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
		
		$this->data['permission'] = $permission;
		$this->data['packages'] = $get_packages;
		
		//Edited by BEAS
		
		$this->data['users_id'] = $users_id;
		$this->data['cid'] = $cid;
		$this->data['campaign_list'] = $this->model_campaign->getUsersCampaigns($users_id);
		$this->data['campagin_keyword_list']=$this->model_campaign->getUsersCampaignsKeywords($users_id);
		//print_r($this->data['campagin_keyword_list']); die;
		$this->data['campaign_crawl_detail'] = $this->model_campaign->getUsersCampaignCrawlDetail($this->data['campaign_list'][0]['campaign'][0]);
		if(is_array($this->data['campaign_list']) && count($this->data['campaign_list']) > 0){
			   if(is_array($this->data['campaign_list'][0]['campaign']) && count($this->data['campaign_list'][0]['campaign']) > 0){
			     $this->data['single_campaign'] = $this->data['campaign_list'][0]['campaign'][0];			     
			     
			   }
			}

		//$campaign_id		= $this->model_campaign->insertUsersCampaign($users_id);

		/*$campaign_detail	= $this->model_basic->getValues_conditions(TABLE_USERS_CAMPAIGNS, '*', '', 'campaign_id = "'.$campaign_id.'"');

		$campaign_main_page_url	= $campaign_detail[0]['campaign_main_page_url'];
		$campaign_main_keyword	= $campaign_detail[0]['campaign_main_keyword'];
		$parse 			= parse_url($campaign_main_page_url);


		$campaign_murl_thumb			= $this->analyze->get_Site_thumb($campaign_main_page_url);
		copy($campaign_murl_thumb, FRONT_SITE_THUMB_PATH . $data['campaign_murl_domain'] . '_' . $campaign_id . '.jpg');
		$data['campaign_murl_thumb']		= $data['campaign_murl_domain'] . '_' . $campaign_id . '.jpg';
		$www_resolved				= $this->analyze->check_site($campaign_main_page_url,true);


		$this->data['rendertoptenresults']=$this->model_analysis->get_rendertoptenresults();*/

		//$this->templatelayout->get_header();
		//$this->templatelayout->make_seo();
		//$this->templatelayout->get_left();
		//$this->templatelayout->get_topmenu();
		//$this->templatelayout->get_footer();

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

}

/* End of file member.php */
/* Location: ./front-app/controllers/member.php */