<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserPermissions extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper('dom');
   $this->load->model('userpermissions_model');
 }
	
	public function index()
	{
		$data['page_title'] = 'SERP Avenger';

		$this->load->view('userpermissions', $data);
	}
	
	public function savepackage()
	{	
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		$this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
		$this->form_validation->set_rules('monthly_fees', 'Monthly Fee', 'trim|required');
		
		$this->form_validation->set_rules('ranking_permission', 'Ranking Module Permission', 'required');
		$this->form_validation->set_rules('max_kw_track', 'Maximum no of keywords that can be tracked', 'trim|numeric|required');
		$this->form_validation->set_rules('more_kw_cost_ranking', 'Cost to add more keywords', 'trim|required');  
		$this->form_validation->set_rules('ranking_upgrade_cost', 'Cost to upgrade to allow access', 'trim|required');
		
		$this->form_validation->set_rules('analysis_permission', 'Analysis Module Permission', 'required');
		$this->form_validation->set_rules('max_kw_analyzed', 'Maximum no of keywords analyzed monthly', 'trim|numeric|required');
		$this->form_validation->set_rules('more_kw_cost_analysis', 'Cost to add more keywords', 'trim|required');
		$this->form_validation->set_rules('analysis_upgrade_cost', 'Cost to upgrade to allow access', 'trim|required');	  
		
		$this->form_validation->set_rules('networkmanager_permission', 'Networkmanager Module Permission', 'required');
		$this->form_validation->set_rules('max_domain_no', 'Maximum no of domains', 'trim|numeric|required');
		/*$this->form_validation->set_rules('max_html_no', 'Maximum no of html sites', 'trim|numeric|required');
		$this->form_validation->set_rules('max_blogplus_no', 'Maximum no of Blog + domains', 'trim|numeric|required');
		$this->form_validation->set_rules('max_blogs_no', 'Maximum no Blogs', 'trim|numeric|required');*/
		$this->form_validation->set_rules('more_domain_cost', 'Cost to add more domains ', 'trim|required');
		$this->form_validation->set_rules('networkmanager_upgrade_cost', 'Cost to upgrade to allow access', 'trim|required');

		$this->form_validation->set_rules('submitter_permission', 'Content Submitter Module Permission', 'required');
		$this->form_validation->set_rules('max_scraped_runs_no', 'Maximum no of Scraped Runs per month', 'trim|numeric|required');
		$this->form_validation->set_rules('max_article_no', 'Maximum number of articles created per month ', 'trim|numeric|required');
		$this->form_validation->set_rules('submitter_upgrade_cost', 'Cost to upgrade to allow access', 'trim|required');	
		
		$this->form_validation->set_rules('max_site_no_subscription', 'Maximum no of Sites per subscription', 'trim|numeric|required');
		//$this->form_validation->set_rules('max_parasite_no_subscription', 'Maximum no of Parasite Sites per subscription', 'trim|numeric|required');
		//$this->form_validation->set_rules('max_moneysite_no_subscription', 'Maximum no of Money Sites per subscriptions', 'trim|numeric|required');
		//$this->form_validation->set_rules('max_no_initial_setup_runs', 'Maximum no of Initial Set-up Runs per month', 'trim|numeric|required');

		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('message', '<div class="notification note-error">
										<a title="Close notification" class="close" href="#">close</a>
										<p>'.validation_errors().'</p>
									</div>');
		}
		else
		{
			$savedata = array('package_name' => $this->input->post('package_name'),
				'monthly_fees' => $this->input->post('monthly_fees'),
				'ranking_permission' => $this->input->post('ranking_permission'),
				'max_keyword_track' => $this->input->post('max_kw_track'),
				'more_keyword_adding_cost_ranking' => $this->input->post('more_kw_cost_ranking'),
				'ranking_upgrade_cost' => $this->input->post('ranking_upgrade_cost'),
				'analysis_permission' => $this->input->post('analysis_permission'),
				'max_keyword_analyzed' => $this->input->post('max_kw_analyzed'),
				'more_keyword_adding_cost_analysis' => $this->input->post('more_kw_cost_analysis'),
				'analysis_upgrade_cost' => $this->input->post('analysis_upgrade_cost'),
				'networkmanager_permission' => $this->input->post('networkmanager_permission'),
				'max_domain_no' => $this->input->post('max_domain_no'),
				/*'max_htmlsite_no' => $this->input->post('max_html_no'),
				'max_blogplus_no' => $this->input->post('max_blogplus_no'),
				'max_blogs_no' => $this->input->post('max_blogs_no'),*/
				'more_domain_adding_cost' => $this->input->post('more_domain_cost'),
				'networkmanager_upgrade_cost' => $this->input->post('networkmanager_upgrade_cost'),
				'submitter_permission' => $this->input->post('submitter_permission'),
				'max_scraped_runs_no' => $this->input->post('max_scraped_runs_no'),
				'max_article_no' => $this->input->post('max_article_no'),
				'submitter_upgrade_cost' => $this->input->post('submitter_upgrade_cost'),
				'max_sites_per_subscription' => $this->input->post('max_site_no_subscription'),
				//'max_parasite_per_subscription' => $this->input->post('max_parasite_no_subscription'),
				//'max_moneysite_per_subscription' => $this->input->post('max_moneysite_no_subscription'),
				//'max_initial_setup_runs_no' => $this->input->post('max_no_initial_setup_runs'),
				'created_date' => date('Y-m-d H:i:s'));
			
			$retarr = $this->userpermissions_model->save_package($savedata);
			
			if($retarr["status"])
			{
				$this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">
					<a title="Close notification" class="close" href="#">close</a><p>'.$retarr["msg"].'</p></div>');
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="notification note-error">
											<a title="Close notification" class="close" href="#">close</a>
											<p>'.$retarr["msg"].'</p>
										</div>');
			}
		}
			
		redirect('userpermissions');
	}	
}