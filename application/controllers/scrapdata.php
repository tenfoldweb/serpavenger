<?php 
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('mysql.connect_timeout', 0);
ini_set('default_socket_timeout', 0);
ini_set('MAX_EXECUTION_TIME', '-1'); //set_time_limit(0);
ini_set('memory_limit', '-1');

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scrapdata extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('dom');
		//$this->load->helper('simple_html_dom');
		$this->load->model('model_campaign');
		$this->load->model('model_analysis');
		$this->load->model('scrapper_model');
		$this->load->model('userlogin_model');
		$this->load->model('cron_model');
		$this->agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//Agent
        $this->reffer_google = "http://www.google.com/search";//Reffer Google
        $this->reffer_yahoo = "https://answers.yahoo.com";//Reffer Yahoo Answer
        $this->reffer_yahoo_rank = "https://search.yahoo.com/search";//Reffer Yahoo search
        $this->reffer_bing_rank = "https://www.bing.com/search";//Reffer Yahoo search
		$this->load->helper('file');
	}
	
	
	
	public function index(){
		
		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_main_keyword_campaginlist('usa');
		//print_r($keywordarr);
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			//$this->cron_model->set_proxy_disable($proxy);
			//exit;
			//$proxy = '107.181.72.10:59242';
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			//print_r($getproxy_credential);
			
			
			if($keyworddata->keyword!=''){
				// $keyworddata->keyword;
				//echo "<br>";
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			////sleep( rand( 5, 10 ) );
			
		}
		echo "adsf";
		
   }
   
   
   public function googlemainkeywordca(){
		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');
		$keywordarr = $this->cron_model->google_main_keyword_campaginlist('ca');
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			////sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   public function googlemainkeyworduk(){
		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');
		$keywordarr = $this->cron_model->google_main_keyword_campaginlist('uk');
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			////sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   public function googlemainkeywordau(){
		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');
		$keywordarr = $this->cron_model->google_main_keyword_campaginlist('au');
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			////sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   
   public function googleseckeyword(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_sec_keyword_campaginlist('usa');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_campaign_crawl_data');
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   
    public function googleseckeywordca(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_sec_keyword_campaginlist('ca');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_campaign_crawl_data');
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
    public function googleseckeyworduk(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_sec_keyword_campaginlist('uk');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_campaign_crawl_data');
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   public function googleseckeywordau(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_sec_keyword_campaginlist('au');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_campaign_crawl_data');
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   
   
   public function googleaddkeyword(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_add_keyword_campaginlist('usa');
		
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			
			if($keyworddata->keyword!=''){
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
				//$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   
   public function googleaddkeywordca(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_add_keyword_campaginlist('ca');
		
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			
			if($keyworddata->keyword!=''){
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
				//$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   public function googleaddkeyworduk(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_add_keyword_campaginlist('uk');
		
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			
			if($keyworddata->keyword!=''){
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
				//$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   public function googleaddkeywordau(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->google_add_keyword_campaginlist('au');
		
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			
			if($keyworddata->keyword!=''){
				$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
				//$data = $this->initSpider('gr',$keyworddata->keyword,$proxy,$keyworddata->google_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
		
   }
   
   
   public function yahoomainkeyword(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_main_keyword_campaginlist('usa');
		
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			print_r($keyworddata);
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	
	   public function yahoomainkeywordca(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_main_keyword_campaginlist('ca');
		
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			print_r($keyworddata);
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	public function yahoomainkeywordau(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_main_keyword_campaginlist('au');
		
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			print_r($keyworddata);
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	   public function yahoomainkeyworduk(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_main_keyword_campaginlist('uk');
		
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			print_r($keyworddata);
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	public function yahooseckeyword(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_sec_keyword_campaginlist('usa');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
			
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	
	public function yahooseckeyworduk(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_sec_keyword_campaginlist('uk');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
			
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	
	public function yahooseckeywordau(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_sec_keyword_campaginlist('au');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
			
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	
	public function yahooseckeywordca(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_sec_keyword_campaginlist('ca');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
			
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	
	public function yahooaddkeyword(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_add_keyword_campaginlist('usa');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_yahoo_crawl_data');
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	public function yahooaddkeywordau(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_add_keyword_campaginlist('au');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_yahoo_crawl_data');
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	public function yahooaddkeyworduk(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_add_keyword_campaginlist('uk');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_yahoo_crawl_data');
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
	
	
	public function yahooaddkeywordca(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->yahoo_add_keyword_campaginlist('ca');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_yahoo_crawl_data');
				$data = $this->initSpider('yahoo',$keyworddata->keyword,$proxy,$keyworddata->yahoo_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
	}
   
   
   public function bingmainkeyword(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_main_keyword_campaginlist('usa');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   public function bingmainkeywordca(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_main_keyword_campaginlist('ca');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   public function bingmainkeyworduk(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_main_keyword_campaginlist('uk');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   public function bingmainkeywordau(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_main_keyword_campaginlist('au');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   
   public function bingseckeyword(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_sec_keyword_campaginlist('usa');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   
   public function bingseckeywordca(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_sec_keyword_campaginlist('ca');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   
   public function bingseckeyworduk(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_sec_keyword_campaginlist('uk');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   public function bingseckeywordau(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_sec_keyword_campaginlist('au');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   
   public function bingaddkeyword(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_add_keyword_campaginlist('usa');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   public function bingaddkeywordca(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_add_keyword_campaginlist('ca');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   public function bingaddkeywordau(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_add_keyword_campaginlist('au');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   }
   
   public function bingaddkeyworduk(){

		$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');

		$keywordarr = $this->cron_model->bing_add_keyword_campaginlist('uk');
		
		foreach($keywordarr as $keyworddata){
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			if($keyworddata->keyword!=''){
				//$this->cron_model->delete_analysis_data($keyworddata->campaign_id,$keyworddata->keyword_id,'serp_bing_crawl_data');
				$data = $this->initSpider('bing',$keyworddata->keyword,$proxy,$keyworddata->bing_se_domain,1,$getproxy_credential,$keyworddata->campaign_main_page_url,$keyworddata->keyword_id,$keyworddata->campaign_id,$keyworddata->is_exact_match,$keyworddata->crawlengine,$keyworddata->analyzed,$keyworddata->analyzed_term);
			}
			//print_r($keyworddata);
			//sleep( rand( 5, 10 ) );
			
		}
		echo "done";
   } 
   
   	private function initSpider($bot, $keyword, $proxy, $location, $page,$getproxy_credential,$mainpageurl,$keywordid,$campaignid,$isexact,$issearchengine,$analyzed,$analyzed_term) {
        $url =  $html = '';
        $json = array();
		$locat = $location;
        /*Construct URL*/
		$iscrawled='0';
		//echo "inside loop";
		$google_location_array = array('usa'=>'com','uk'=>'co.uk','au'=>'com.au','ca'=>'ca');

		$yahoo_location_array = array('usa'=>'','uk'=>'uk.','au'=>'','ca'=>'ca.');
		$pageloc = $google_location_array[$locat];
        if($bot == 'gr'){  
			$location = $google_location_array[$locat];
            if($page == 1)
                $url = 'https://www.google.'.$location.'/search?q='.str_replace(' ','+',$keyword).'&ie=UTF-8&num=100'; //Google Rank
            else
                $url = 'https://www.google.'.$location.'/search?q='.str_replace(' ','+',$keyword).'&ie=UTF-8&num=100&start='.(($page-1)*100); //Google Rank
        }elseif($bot == 'bing'){ 
            if($page == 1)         
                $url = 'http://www.bing.com/search?q='.str_replace(' ','+',$keyword).'&qs=n&form=QBLH&pq='.str_replace(' ','+',$keyword).'&sc=&sp=-1&sk=&cvid=&count=50'; //Rank search
            else
                $url = 'http://www.bing.com/search?q='.str_replace(' ','+',$keyword).'&qs=n&form=QBLH&pq='.str_replace(' ','+',$keyword).'&sc=&sp=-1&sk=&cvid=&count=50&first='.((($page-1)*50)+1); //Rank search
        }elseif($bot == 'yahoo'){
			$location = $yahoo_location_array[$locat];
            if($page == 1)
                echo $url = 'https://'.$location.'search.yahoo.com/search?p='.str_replace(' ','+',$keyword).'&n=100';
            else    
                $url = 'https://'.$location.'search.yahoo.com/search?p='.str_replace(' ','+',$keyword).'&n=100&b='.((($page-1)*100)+1);
			    
				
				echo $url1 = 'https://'.$location.'search.yahoo.com/search?p='.str_replace(' ','+',$keyword).'&pstart=2&n=100&b='.(((2-1)*100)+1);
        }elseif($bot == 'gb'){
            $url = 'https://www.google.com/search?q='.str_replace(' ','+',$keyword).':blog&num=100';  //Blog search     
        }elseif($bot == 'ya'){
            $url = 'https://answers.yahoo.com/search/search_result;_ylt=ApbcXMFap1JBQNJIIG0I50Lj1KIX?fr=uh3_answers_vert_gs&type=2button&p='.str_replace(' ','+',$keyword);  //Yahoo Answer search   
        }
	//echo "start crawler";
        /*Do crawl*/
        if($bot == 'gb' || $bot == 'gr'){
		
			$raw=$this->crawl_simple($this->reffer_google, $url, $this->agent, $proxy,$getproxy_credential);
           //Google Rank and Blog
		   //sleep(6);
		}
        elseif($bot == 'bing'){
			$raw=$this->crawl_simple($this->reffer_bing_rank, $url, $this->agent, $proxy,$getproxy_credential);
            //Bing Rank
        
		}
		elseif($bot == 'yahoo'){
		//echo $this->reffer_yahoo_rank;
			$raw=$this->crawl_simple($this->reffer_yahoo_rank, $url, $this->agent, $proxy,$getproxy_credential);
			$raw1=$this->crawl_simple($this->reffer_yahoo_rank, $url1, $this->agent, $proxy,$getproxy_credential);
            //Yahoo Rank
        }
		if($isexact =="Yes"){ $mainsiteurl = $mainpageurl; } else { $mainsiteurl = $this->get_domain($mainpageurl); }
		
		$keyword = str_replace(' ','+',$keyword);
		 $html = str_get_html($raw);
		 
        /*Do parsing*/
        /*Google Rank and Blog parsing*/
			$i=1;
			$flag=0;
        if($bot == 'gb' || $bot == 'gr'){
				echo "bot crawled successfully".'<br>';
			//var_dump($html);
			$ischeck = $this->cron_model->is_campaign_exist($campaignid,$keywordid,$bot,$locat,'serp_campaign_crawl_data');
			$existcamp = array();
			$existcamparr = array();
			$currenturl = array();
			$currenturl[] = $mainpageurl;
			if($ischeck==1){ 
				
				$campaigndataobj = $this->cron_model->get_keyword_data_by_campaign($campaignid,$keywordid,$bot,$locat,'serp_campaign_crawl_data');
					
				foreach($campaigndataobj as $camparr){
				$existcamparr[] = $camparr->url;
					$existcamp[$camparr->url]['rank']=$camparr->rank;
					$existcamp[$camparr->url]['first_found_date']=$camparr->first_found_date;
					$existcamp[$camparr->url]['first_found_ranking']=$camparr->first_found_ranking;
				}
				
			}
			
            foreach($html->find('li[class=g]') as $index => $li){ 
			$iscrawled='1';
                //Only get results with url
                $domainCheck = strtolower($li->find('cite',0)->plaintext);
                //URL will have "/"  OR domain which can be of 3 character like .com or 4 like .asia
                if(preg_match('/\/|\.[a-z]{2|3|4}/',$domainCheck)){     
    				$json[$index]['title'] = $li->find('a',0)->plaintext;
					$json[$index]['url'] = $li->find('cite',0)->plaintext;
                    $des = str_replace('/url?q=','',$li->find('a',0)->href);
					$arr = explode('&amp;sa',$des);
					$json[$index]['description'] =  urldecode($arr[0]);              
					 $linkurl =urldecode($arr[0]);
					$title = urldecode($li->find('a',0)->plaintext);
					
							if($isexact =="Yes"){
								$currentsiteurl =  $linkurl;
							} else {
								$currentsiteurl =  $this->get_domain($linkurl);
							}
							$currenturl[] = $linkurl;
							
							
							
								
								
							
							if($currentsiteurl==$mainsiteurl && $flag==0){

								$flag=1;
								/* Handle Analysis data Start Here          */
									if($analyzed=="True" && $issearchengine=="Yes"){
										$this->model_campaign->domain_creation_date($mainpageurl);  
										$this->google_site_size($mainpageurl,$pageloc);
										
										$this->get_social_data($mainpageurl,$campaignid,$keywordid,$keyword);
										$this->get_aherf_data($mainpageurl,$campaignid,$keywordid,$keyword);
										if($ischeck==0){
											$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'Yes',
												'first_found_date' => date('Y-m-d'),
												'first_found_ranking' => $i,
												'date_added'=>date('Y-m-d')
											);
											$this->cron_model->insert_analysis_data('serp_campaign_crawl_data',$campigndata);
										} else {
											if(array_key_exists($mainpageurl,$existcamp)){
												$campigndata = array(
												'rank'=> $i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->update_analysis_data('serp_campaign_crawl_data',$mainpageurl,$campigndata,$locat,$bot,$campaignid,$keywordid,'Yes');
											} else {
												$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$mainpageurl,$locat,$bot);
												if(is_array($moveddata)){
													$first_found_date = $moveddata[0]->first_found_date;
													$first_found_ranking = $moveddata[0]->first_found_ranking;
													$rec =1;
													$rec_date = date('Y-m-d');
												} else {
													$first_found_date = date('Y-m-d');
													$first_found_ranking = $i;
													$rec =0;
													$rec_date = date('Y-m-d');
												}
												$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => $first_found_date,
												'first_found_ranking' => $first_found_ranking,
												'is_recovered' => $rec,
												'recovered_date'=>$rec_date,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_crawl_data',$campigndata);
												
												
												
											}
										}
										
									}
									/* Handle Analysis data End Here          */
										
										$campignkeyrankingdata = array(
												'keyword_id'=> $keywordid,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
												
										$data = array(
											'campaign_id' =>$campaignid,
											'keyword_id'  =>$keywordid,
											'hostname'    =>$mainpageurl,
											'siterank'    =>$i,
											'date_added'  =>date('Y-m-d'),
											'search_engine'=>$bot,
											'search_location'=>$locat,
											'is_subject' =>'yes'
										);
										$this->cron_model->insert_ranking_data($data);
								
							}
							
									
									if($analyzed=="True" && $issearchengine=="Yes"){
										$this->model_campaign->domain_creation_date($linkurl);    $this->google_site_size($linkurl,$pageloc);
										if($i<=10){
										$this->get_social_data($linkurl,$campaignid,$keywordid,$keyword);
										$this->get_aherf_data($linkurl,$campaignid,$keywordid,$keyword);
										}
										if($ischeck==0){
											$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => date('Y-m-d'),
												'first_found_ranking' => $i,
												'date_added'=>date('Y-m-d')
											);
											$this->cron_model->insert_analysis_data('serp_campaign_crawl_data',$campigndata);
										} else {
											if(array_key_exists($linkurl,$existcamp)){
												$campigndata = array(
												'rank'=> $i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->update_analysis_data('serp_campaign_crawl_data',$linkurl,$campigndata,$locat,$bot,$campaignid,$keywordid,'No');
											} else {
												$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$linkurl,$locat,$bot);
												if(is_array($moveddata)){
													$first_found_date = $moveddata[0]->first_found_date;
													$first_found_ranking = $moveddata[0]->first_found_ranking;
													$rec =1;
													$rec_date = date('Y-m-d');
												} else {
													$first_found_date = date('Y-m-d');
													$first_found_ranking = $i;
													$rec =0;
													$rec_date = date('Y-m-d');
												}
												$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => $first_found_date,
												'first_found_ranking' => $first_found_ranking,
												'is_recovered' => $rec,
												'recovered_date'=>$rec_date,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_crawl_data',$campigndata);
											}
										}
										
									}
									$campignkeyrankingdata = array(
												'keyword_id'=> $keywordid,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
									
										
										
									
							
							
					$i++;
                }
            }
			if($iscrawled=='0'){ 
				
				$this->cron_model->set_proxy_disable($proxy);
				$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');
				$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
				$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
				$this->initSpider($bot, $keyword, $proxy, $location, $page,$getproxy_credential,$mainpageurl,$keywordid,$campaignid,$isexact,$issearchengine,$analyzed,$analyzed_term); 
			}
			if($flag==0){
				$campignkeyrankingdata = array(
									'keyword_id'=> $keywordid,
									'url'=>$mainpageurl,
									'host'=>$locat,
									'crawlby' =>$bot,
									'rank'=>'null',
									'date_added'=>date('Y-m-d')
									);
				$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
				
				$data = array('campaign_id' =>$campaignid,
									'keyword_id'  =>$keywordid,
									'hostname'    =>$mainpageurl,
									'siterank'    =>'null',
									'date_added'  =>date('Y-m-d'),
									'search_engine'=>$bot,
									'search_location'=>$locat,
									'is_subject' =>'yes');
								$this->cron_model->insert_ranking_data($data);
					
				if($analyzed=="True" && $ischeck==0 && $issearchengine=="Yes"){
							$this->model_campaign->domain_creation_date($mainpageurl);  
							$this->google_site_size($mainpageurl,$pageloc);
							$this->get_social_data($mainpageurl,$campaignid,$keywordid,$keyword);
							//$this->get_aherf_data($mainpageurl,$campaignid,$keywordid,$keyword);
							
									$campigndata = array(
										'campaign_id' => $campaignid,
										'keyword_id'=> $keywordid,
										'keyword' =>$keyword,
										'title'=> $title,
										'url'=>$mainpageurl,
										'host'=>$locat,
										'crawlby' =>$bot,
										'rank'=>'null',
										'is_main_url'=>'Yes',
										'date_added'=>date('Y-m-d')
									);
									$this->cron_model->insert_analysis_data('serp_campaign_crawl_data',$campigndata);
				}
			}
			
			$diff = array_diff($existcamparr,$currenturl);
			//echo "<pre>";
			//print_R($currenturl);
			//echo "</pre>";
			foreach($diff as $expiredata){
				$sitedatas = $existcamp[$expiredata];
				$moveddata = array(
										'campaign_id' => $campaignid,
										'keyword_id'=> $keywordid,
										'websiteurl'=>$expiredata,
										'search_country'=>$locat,
										'search_engine' =>$bot,
										'first_found_date' => $sitedatas['first_found_date'],
										'first_found_ranking' => $sitedatas['first_found_ranking'],
										'date_added'=>date('Y-m-d')
									);
					$this->cron_model->add_moved_site_data($moveddata);				
									
			}
			if(sizeof($currenturl)>10){
				$this->cron_model->delete_campaign_data($currenturl,$campaignid,$keywordid,$locat,$bot,'serp_campaign_crawl_data');				
			}
			
			//print_r($json);
        } elseif($bot == 'yahoo'){
		//echo $campaignid;
		//echo "<br>".$keywordid."-------<br>";
			$ischeck = $this->cron_model->is_campaign_exist($campaignid,$keywordid,$bot,$locat,'serp_yahoo_crawl_data');
			$existcamp = array();
			$existcamparr = array();
			$currenturl = array();
			$currenturl[] = $mainpageurl;
			if($ischeck==1){ 
				
				$campaigndataobj = $this->cron_model->get_keyword_data_by_campaign($campaignid,$keywordid,$bot,$locat,'serp_yahoo_crawl_data');
					
				foreach($campaigndataobj as $camparr){
				$existcamparr[] = $camparr->url;
					$existcamp[$camparr->url]['rank']=$camparr->rank;
					$existcamp[$camparr->url]['first_found_date']=$camparr->first_found_date;
					$existcamp[$camparr->url]['first_found_ranking']=$camparr->first_found_ranking;
				}
				
			}
			
            foreach($html->find('div[class=res]') as $index => $div){
				$iscrawled='1';			
                //Check for blank data
				
                if(count($div->find('h3'))>0){
                        $temp_url = explode('RU=',urldecode($div->find('h3',0)->find('a', 0)->href));
                        $temp_url = explode('/RK=0', $temp_url[1]);                                          
                        if(!empty($temp_url[0])){
                            //$json[$index]['title']  = $div->find('h3', 0)->plaintext;                        
							$desc = str_replace("#","",urldecode($temp_url[0]));
							 $desc = str_replace("!","",$desc);
							
                            //$json[$index]['description'] = $desc;
                            //$json[$index]['description'] = $div->find('div[class=abstr]',0)->plaintext; 
                             //print_r($json);
							 $linkurl =urldecode($desc);
							
							$title = urldecode($div->find('h3', 0)->plaintext);
							
							if($isexact =="Yes"){
								$currentsiteurl =  $linkurl;
							} else {
								$currentsiteurl =  $this->get_domain($linkurl);
							}
							$currenturl[] = $linkurl;
							
							
							
								
								
							
							if($currentsiteurl==$mainsiteurl && $flag==0){
								
								/* Handle Analysis data Start Here          */
									if($analyzed=="True" && $issearchengine=="Yes"){
										$this->model_campaign->domain_creation_date($mainpageurl);  $this->google_site_size($mainpageurl,$pageloc);
										$flag=1;
										$this->get_social_data($mainpageurl,$campaignid,$keywordid,$keyword);
										$this->get_aherf_data($mainpageurl,$campaignid,$keywordid,$keyword);
										if($ischeck==0){
											$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'Yes',
												'first_found_date' => date('Y-m-d'),
												'first_found_ranking' => $i,
												'date_added'=>date('Y-m-d')
											);
											$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
										} else {
											if(array_key_exists($mainpageurl,$existcamp)){
												$campigndata = array(
												'rank'=> $i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->update_analysis_data('serp_yahoo_crawl_data',$mainpageurl,$campigndata,$locat,$bot,$campaignid,$keywordid,'Yes');
											} else {
												$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$mainpageurl,$locat,$bot);
												if(is_array($moveddata)){
													$first_found_date = $moveddata[0]->first_found_date;
													$first_found_ranking = $moveddata[0]->first_found_ranking;
													$rec =1;
													$rec_date = date('Y-m-d');
												} else {
													$first_found_date = date('Y-m-d');
													$first_found_ranking = $i;
													$rec =0;
													$rec_date = date('Y-m-d');
												}
												$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => $first_found_date,
												'first_found_ranking' => $first_found_ranking,
												'is_recovered' => $rec,
												'recovered_date'=>$rec_date,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
												
												
												
											}
										}
										
									}
									/* Handle Analysis data End Here          */
										
										$campignkeyrankingdata = array(
												'keyword_id'=> $keywordid,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
												
										$data = array(
											'campaign_id' =>$campaignid,
											'keyword_id'  =>$keywordid,
											'hostname'    =>$mainpageurl,
											'siterank'    =>$i,
											'date_added'  =>date('Y-m-d'),
											'search_engine'=>$bot,
											'search_location'=>$locat,
											'is_subject' =>'yes'
										);
										$this->cron_model->insert_ranking_data($data);
								
							}
							
									
									if($analyzed=="True" && $issearchengine=="Yes"){
										$this->model_campaign->domain_creation_date($linkurl);    $this->google_site_size($linkurl,$pageloc);
										if($i<=10){
										$this->get_social_data($linkurl,$campaignid,$keywordid,$keyword);
										$this->get_aherf_data($linkurl,$campaignid,$keywordid,$keyword);
										}
										if($ischeck==0){
											$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => date('Y-m-d'),
												'first_found_ranking' => $i,
												'date_added'=>date('Y-m-d')
											);
											$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
										} else {
											if(array_key_exists($linkurl,$existcamp)){
												$campigndata = array(
												'rank'=> $i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->update_analysis_data('serp_yahoo_crawl_data',$linkurl,$campigndata,$locat,$bot,$campaignid,$keywordid,'No');
											} else {
												//$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$mainpageurl,$locat,$bot);
												$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$linkurl,$locat,$bot);
												if(is_array($moveddata)){
													$first_found_date = $moveddata[0]->first_found_date;
													$first_found_ranking = $moveddata[0]->first_found_ranking;
													$rec =1;
													$rec_date = date('Y-m-d');
												} else {
													$first_found_date = date('Y-m-d');
													$first_found_ranking = $i;
													$rec =0;
													$rec_date = date('Y-m-d');
												}
												$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => $first_found_date,
												'first_found_ranking' => $first_found_ranking,
												'is_recovered' => $rec,
												'recovered_date'=>$rec_date,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
											}
										}
										
									}
									$campignkeyrankingdata = array(
												'keyword_id'=> $keywordid,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
									
										
										
									
							
							$i++;		
                        }
                    }
            }
			
			$html = str_get_html($raw1);
			
			foreach($html->find('div[class=res]') as $index => $div){                         
                //Check for blank data
				
                if(count($div->find('h3'))>0){
                        $temp_url = explode('RU=',urldecode($div->find('h3',0)->find('a', 0)->href));
                        $temp_url = explode('/RK=0', $temp_url[1]);                                          
                        if(!empty($temp_url[0])){
                            $json[$index]['title']  = urldecode($div->find('h3', 0)->plaintext);                        
							$desc = str_replace("#","",urldecode($temp_url[0]));
							 $desc = str_replace("!","",$desc);
							
                            $json[$index]['description'] = urldecode($desc);
                            //$json[$index]['description'] = $div->find('div[class=abstr]',0)->plaintext; 
                             //print_r($json);
							echo $linkurl =urldecode($desc);
							echo "<br>";
							$title = $div->find('h3', 0)->plaintext;
							if($isexact =="Yes"){
								$currentsiteurl =  $linkurl;
							} else {
								$currentsiteurl =  $this->get_domain($linkurl);
							}
							$currenturl[] = $linkurl;
							
							
							//$currentsiteurl.'=='.$mainsiteurl;
								
								
							
							if($currentsiteurl==$mainsiteurl && $flag==0){
								
								/* Handle Analysis data Start Here          */
									if($analyzed=="True" && $issearchengine=="Yes"){
										$this->model_campaign->domain_creation_date($mainpageurl);  $this->google_site_size($mainpageurl,$pageloc);
										$flag=1;
										$this->get_social_data($mainpageurl,$campaignid,$keywordid,$keyword);
										$this->get_aherf_data($mainpageurl,$campaignid,$keywordid,$keyword);
										if($ischeck==0){
											$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'Yes',
												'first_found_date' => date('Y-m-d'),
												'first_found_ranking' => $i,
												'date_added'=>date('Y-m-d')
											);
											$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
										} else {
											if(array_key_exists($mainpageurl,$existcamp)){
												$campigndata = array(
												'rank'=> $i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->update_analysis_data('serp_yahoo_crawl_data',$mainpageurl,$campigndata,$locat,$bot,$campaignid,$keywordid,'Yes');
											} else {
												
												$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$mainpageurl,$locat,$bot);
												if(is_array($moveddata)){
													$first_found_date = $moveddata[0]->first_found_date;
													$first_found_ranking = $moveddata[0]->first_found_ranking;
													$rec =1;
													$rec_date = date('Y-m-d');
												} else {
													$first_found_date = date('Y-m-d');
													$first_found_ranking = $i;
													$rec =0;
													$rec_date = date('Y-m-d');
												}
												$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => $first_found_date,
												'first_found_ranking' => $first_found_ranking,
												'is_recovered' => $rec,
												'recovered_date'=>$rec_date,
												'date_added'=>date('Y-m-d')
												);
												
												
												
												$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
												
											}
										}
										
									}
									/* Handle Analysis data End Here          */
										
										$campignkeyrankingdata = array(
												'keyword_id'=> $keywordid,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campignkeyrankingdata);
												
										$data = array(
											'campaign_id' =>$campaignid,
											'keyword_id'  =>$keywordid,
											'hostname'    =>$mainpageurl,
											'siterank'    =>$i,
											'date_added'  =>date('Y-m-d'),
											'search_engine'=>$bot,
											'search_location'=>$locat,
											'is_subject' =>'yes'
										);
										$this->cron_model->insert_ranking_data($data);
								
							}
							
									
									if($analyzed=="True" && $issearchengine=="Yes"){
										$this->model_campaign->domain_creation_date($linkurl);    $this->google_site_size($linkurl,$pageloc);
										if($i<=10){
											$this->get_social_data($linkurl,$campaignid,$keywordid,$keyword);
											$this->get_aherf_data($linkurl,$campaignid,$keywordid,$keyword);
										}
										if($ischeck==0){
											$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => date('Y-m-d'),
												'first_found_ranking' => $i,
												'date_added'=>date('Y-m-d')
											);
											$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
										} else {
											if(array_key_exists($linkurl,$existcamp)){
												$campigndata = array(
												'rank'=> $i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->update_analysis_data('serp_yahoo_crawl_data',$linkurl,$campigndata,$locat,$bot,$campaignid,$keywordid,'No');
											} else {
												
												
												$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$linkurl,$locat,$bot);
												if(is_array($moveddata)){
													$first_found_date = $moveddata[0]->first_found_date;
													$first_found_ranking = $moveddata[0]->first_found_ranking;
													$rec =1;
													$rec_date = date('Y-m-d');
												} else {
													$first_found_date = date('Y-m-d');
													$first_found_ranking = $i;
													$rec =0;
													$rec_date = date('Y-m-d');
												}
												$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => $first_found_date,
												'first_found_ranking' => $first_found_ranking,
												'is_recovered' => $rec,
												'recovered_date'=>$rec_date,
												'date_added'=>date('Y-m-d')
												);
												
												
												
											
												$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
												
											}
										}
										
									}
									$campignkeyrankingdata = array(
												'keyword_id'=> $keywordid,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
									
										
										
									
							
							$i++;		
                        }
                    }
            }
			if($iscrawled=='0'){ 
				
				$this->cron_model->set_proxy_disable($proxy);
				$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');
				$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
				$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
				$this->initSpider($bot, $keyword, $proxy, $location, $page,$getproxy_credential,$mainpageurl,$keywordid,$campaignid,$isexact,$issearchengine,$analyzed,$analyzed_term); 
			}
				
			if($flag==0){
				$campignkeyrankingdata = array(
									'keyword_id'=> $keywordid,
									'url'=>$mainpageurl,
									'host'=>$locat,
									'crawlby' =>$bot,
									'rank'=>'null',
									'date_added'=>date('Y-m-d')
									);
				$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
				
				$data = array('campaign_id' =>$campaignid,
									'keyword_id'  =>$keywordid,
									'hostname'    =>$mainpageurl,
									'siterank'    =>'null',
									'date_added'  =>date('Y-m-d'),
									'search_engine'=>$bot,
									'search_location'=>$locat,
									'is_subject' =>'yes');
								$this->cron_model->insert_ranking_data($data);
					
				if($analyzed=="True" && $ischeck==0){
							$this->model_campaign->domain_creation_date($mainpageurl);  $this->google_site_size($mainpageurl,$pageloc);
							$this->get_social_data($mainpageurl,$campaignid,$keywordid,$keyword);
							//$this->get_aherf_data($mainpageurl,$campaignid,$keywordid,$keyword);
							
									$campigndata = array(
										'campaign_id' => $campaignid,
										'keyword_id'=> $keywordid,
										'keyword' =>$keyword,
										'title'=> $title,
										'url'=>$mainpageurl,
										'host'=>$locat,
										'crawlby' =>$bot,
										'rank'=>'null',
										'is_main_url'=>'Yes',
										'date_added'=>date('Y-m-d')
									);
									$this->cron_model->insert_analysis_data('serp_yahoo_crawl_data',$campigndata);
				}
			}
			
			$diff = array_diff($existcamparr,$currenturl);
			
			foreach($diff as $expiredata){
				$sitedatas = $existcamp[$expiredata];
				$moveddata = array(
										'campaign_id' => $campaignid,
										'keyword_id'=> $keywordid,
										'websiteurl'=>$expiredata,
										'search_country'=>$locat,
										'search_engine' =>$bot,
										'first_found_date' => $sitedatas['first_found_date'],
										'first_found_ranking' => $sitedatas['first_found_ranking'],
										'date_added'=>date('Y-m-d')
									);
					$this->cron_model->add_moved_site_data($moveddata);				
									
			}
			if(sizeof($currenturl)>10){
				$this->cron_model->delete_campaign_data($currenturl,$campaignid,$keywordid,$locat,$bot,'serp_yahoo_crawl_data');				
			}
			
        } elseif($bot == 'bing'){        
			$ischeck = $this->cron_model->is_campaign_exist($campaignid,$keywordid,$bot,$locat,'serp_bing_crawl_data');
			$existcamp = array();
			$existcamparr = array();
			$currenturl = array();
			$currenturl[] = $mainpageurl;
			if($ischeck==1){ 
				
				$campaigndataobj = $this->cron_model->get_keyword_data_by_campaign($campaignid,$keywordid,$bot,$locat,'serp_bing_crawl_data');
					
				foreach($campaigndataobj as $camparr){
				$existcamparr[] = $camparr->url;
					$existcamp[$camparr->url]['rank']=$camparr->rank;
					$existcamp[$camparr->url]['first_found_date']=$camparr->first_found_date;
					$existcamp[$camparr->url]['first_found_ranking']=$camparr->first_found_ranking;
				}
				
			}
          foreach($html->find('ol#b_results',0)->find('li[class=b_algo]') as $index => $li){
			$iscrawled='1';
                //Check for blank data
                if(count($li->find('a')) > 0){
                   // $json[$index]['title'] = $li->find('a', 0)->plaintext;
                    //$json[$index]['description']  = $li->find('a', 0)->href;
                    //$json[$index]['description'] = $li->find('p', 0)->plaintext;    
					
							$linkurl =urldecode($li->find('a', 0)->href);
							$title = urldecode($li->find('a', 0)->plaintext);
						//	$currentsiteurl =  $this->get_domain($linkurl);
							
							
							if($isexact =="Yes"){
								$currentsiteurl =  $linkurl;
							} else {
								$currentsiteurl =  $this->get_domain($linkurl);
							}
							$currenturl[] = $linkurl;
							
							
							
								
								
							
							if($currentsiteurl==$mainsiteurl && $flag==0){
								
								/* Handle Analysis data Start Here          */
									if($analyzed=="True" && $issearchengine=="Yes"){
										$this->model_campaign->domain_creation_date($mainpageurl);  $this->google_site_size($mainpageurl,$pageloc);
										
										$flag=1;
										$this->get_social_data($mainpageurl,$campaignid,$keywordid,$keyword);
										$this->get_aherf_data($mainpageurl,$campaignid,$keywordid,$keyword);
										if($ischeck==0){
											$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'Yes',
												'first_found_date' => date('Y-m-d'),
												'first_found_ranking' => $i,
												'date_added'=>date('Y-m-d')
											);
											$this->cron_model->insert_analysis_data('serp_bing_crawl_data',$campigndata);
										} else {
											if(array_key_exists($mainpageurl,$existcamp)){
												$campigndata = array(
												'rank'=> $i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->update_analysis_data('serp_bing_crawl_data',$mainpageurl,$campigndata,$locat,$bot,$campaignid,$keywordid,'Yes');
											} else {
												$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$mainpageurl,$locat,$bot);
												if(is_array($moveddata)){
													$first_found_date = $moveddata[0]->first_found_date;
													$first_found_ranking = $moveddata[0]->first_found_ranking;
													$rec =1;
													$rec_date = date('Y-m-d');
												} else {
													$first_found_date = date('Y-m-d');
													$first_found_ranking = $i;
													$rec =0;
													$rec_date = date('Y-m-d');
												}
												$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => $first_found_date,
												'first_found_ranking' => $first_found_ranking,
												'is_recovered' => $rec,
												'recovered_date'=>$rec_date,
												'date_added'=>date('Y-m-d')
												);
												
												
												$this->cron_model->insert_analysis_data('serp_bing_crawl_data',$campigndata);
												
												
												
											}
										}
										
									}
									/* Handle Analysis data End Here          */
										
										$campignkeyrankingdata = array(
												'keyword_id'=> $keywordid,
												'url'=>$mainpageurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
												
										$data = array(
											'campaign_id' =>$campaignid,
											'keyword_id'  =>$keywordid,
											'hostname'    =>$mainpageurl,
											'siterank'    =>$i,
											'date_added'  =>date('Y-m-d'),
											'search_engine'=>$bot,
											'search_location'=>$locat,
											'is_subject' =>'yes'
										);
										$this->cron_model->insert_ranking_data($data);
								
							}
							
									
									if($analyzed=="True" && $issearchengine=="Yes"){
										$this->model_campaign->domain_creation_date($linkurl);    $this->google_site_size($linkurl,$pageloc);
										if($i<=10){
										$this->get_social_data($linkurl,$campaignid,$keywordid,$keyword);
										$this->get_aherf_data($linkurl,$campaignid,$keywordid,$keyword);
										}
										if($ischeck==0){
											$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => date('Y-m-d'),
												'first_found_ranking' => $i,
												'date_added'=>date('Y-m-d')
											);
											$this->cron_model->insert_analysis_data('serp_bing_crawl_data',$campigndata);
										} else {
											if(array_key_exists($linkurl,$existcamp)){
												$campigndata = array(
												'rank'=> $i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->update_analysis_data('serp_bing_crawl_data',$linkurl,$campigndata,$locat,$bot,$campaignid,$keywordid,'No');
											} else {
												$moveddata = $this->cron_model->get_and_delete_moveddata($campaignid,$keywordid,$linkurl,$locat,$bot);
												if(is_array($moveddata)){
													$first_found_date = $moveddata[0]->first_found_date;
													$first_found_ranking = $moveddata[0]->first_found_ranking;
													$rec =1;
													$rec_date = date('Y-m-d');
												} else {
													$first_found_date = date('Y-m-d');
													$first_found_ranking = $i;
													$rec =0;
													$rec_date = date('Y-m-d');
												}
												$campigndata = array(
												'campaign_id' => $campaignid,
												'keyword_id'=> $keywordid,
												'keyword' => $keyword,
												'title'=> $title,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'is_main_url'=>'No',
												'first_found_date' => $first_found_date,
												'first_found_ranking' => $first_found_ranking,
												'is_recovered' => $rec,
												'recovered_date'=>$rec_date,
												'date_added'=>date('Y-m-d')
												);
												
												
												
												$this->cron_model->insert_analysis_data('serp_bing_crawl_data',$campigndata);
											}
										}
										
									}
									$campignkeyrankingdata = array(
												'keyword_id'=> $keywordid,
												'url'=>$linkurl,
												'host'=>$locat,
												'crawlby' =>$bot,
												'rank'=>$i,
												'date_added'=>date('Y-m-d')
												);
												$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
									
										
										
									
							
							$i++;	
							
							
							
							
							
                        }
                                
                
            }
			if($iscrawled=='0'){ 
				
				$this->cron_model->set_proxy_disable($proxy);
				$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');
				$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
				$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
				$this->initSpider($bot, $keyword, $proxy, $location, $page,$getproxy_credential,$mainpageurl,$keywordid,$campaignid,$isexact,$issearchengine,$analyzed,$analyzed_term); 
			}
			if($flag==0){
				$campignkeyrankingdata = array(
									'keyword_id'=> $keywordid,
									'url'=>$mainpageurl,
									'host'=>$locat,
									'crawlby' =>$bot,
									'rank'=>'null',
									'date_added'=>date('Y-m-d')
									);
				$this->cron_model->insert_analysis_data('serp_campaign_ranking_month',$campignkeyrankingdata);
				
				$data = array('campaign_id' =>$campaignid,
									'keyword_id'  =>$keywordid,
									'hostname'    =>$mainpageurl,
									'siterank'    =>'null',
									'date_added'  =>date('Y-m-d'),
									'search_engine'=>$bot,
									'search_location'=>$locat,
									'is_subject' =>'yes');
								$this->cron_model->insert_ranking_data($data);
					
				if($analyzed=="True" && $ischeck==0){
							$this->model_campaign->domain_creation_date($mainpageurl);  $this->google_site_size($mainpageurl,$pageloc);
							$this->get_social_data($mainpageurl,$campaignid,$keywordid,$keyword);
							//$this->get_aherf_data($mainpageurl,$campaignid,$keywordid,$keyword);
							
									$campigndata = array(
										'campaign_id' => $campaignid,
										'keyword_id'=> $keywordid,
										'keyword' =>$keyword,
										'title'=> $title,
										'url'=>$mainpageurl,
										'host'=>$locat,
										'crawlby' =>$bot,
										'rank'=>'null',
										'is_main_url'=>'Yes',
										'date_added'=>date('Y-m-d')
									);
									$this->cron_model->insert_analysis_data('serp_bing_crawl_data',$campigndata);
				}
			}
			
			$diff = array_diff($existcamparr,$currenturl);
			
			foreach($diff as $expiredata){
				$sitedatas = $existcamp[$expiredata];
				$moveddata = array(
										'campaign_id' => $campaignid,
										'keyword_id'=> $keywordid,
										'websiteurl'=>$expiredata,
										'search_country'=>$locat,
										'search_engine' =>$bot,
										'first_found_date' => $sitedatas['first_found_date'],
										'first_found_ranking' => $sitedatas['first_found_ranking'],
										'date_added'=>date('Y-m-d')
									);
					$this->cron_model->add_moved_site_data($moveddata);				
									
			}
			if(sizeof($currenturl)>10){
				$this->cron_model->delete_campaign_data($currenturl,$campaignid,$keywordid,$locat,$bot,'serp_bing_crawl_data');				
			}
			
			
        }elseif($bot == 'ya'){            
            /*Yahoo answer parsing*/
            foreach($html->find('ul[id=yan-questions]',0)->find('li') as $index => $li){
                $json[$index]['title'] = urldecode($li->find('h3',0)->find('a',0)->plaintext);
                $json[$index]['url']  = urldecode($this->reffer_yahoo.$li->find('h3',0)->find('a',0)->href);
                $json[$index]['question-description']  = urldecode($li->find('span[class=question-description]',0)->plaintext);
                $json[$index]['question-meta'] = urldecode($li->find('div[class=question-meta]',0)->plaintext);
                
                /*Get answers for each Question*/
                $html_answer = str_get_html($this->crawl_simple($this->reffer_yahoo, trim($this->reffer_yahoo.$li->find('h3',0)->find('a',0)->href), $this->agent, $proxy,$getproxy_credential));//Yahoo Answer
                foreach($html_answer->find('div[class=content]') as $answer => $content){
                    $json[$index][$answer] = urldecode($content->plaintext);
                }
                $html_answer->clear();unset($html_answer);
                /*random delay*/
                //if ( $delay == 1 ) {
                    /*random delay*/
                    //sleep( rand( 5, 10 ) );
                //}
            }
        }
        
		
        /*random delay*/
         //if ( $delay == 1 ) {
            /*random delay*/
            sleep( rand( 5, 10 ) );
        //}
        
        return json_encode($json);
    }
	
	
	function crawl_simple($reffer, $url, $agent, $proxy, $getproxy_credential) {
		
		ob_start();
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_REFERER, $reffer);
		
		curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);

		/*Proxy curl settings*/
		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
		
		$prxy = explode(':',$proxy);

		curl_setopt($ch, CURLOPT_PROXY, $prxy[0]);
		curl_setopt($ch, CURLOPT_PROXYPORT, $prxy[1]);
		
		if($getproxy_credential['user'] != "" && $getproxy_credential['pass'] != "")
		  curl_setopt($ch, CURLOPT_PROXYUSERPWD, $getproxy_credential['user'].':'.$getproxy_credential['pass']);
		
		/*SSL settings*/
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		if(curl_error($ch))
		{
		//die(curl_error($ch));
		}
		
		$result = curl_exec($ch);
		
		curl_close($ch);
		
		//ob_flush();
		return $result;
	}
	
	
	
	public function get_google_site_size($result){
		$pageCount	= 0;
		$html	= str_get_html($result);
		
		foreach($html->find('div#resultStats') AS $result){
			$pos1 = strpos($result->plaintext, 'About');
			$pos2 = strpos($result->plaintext, 'results');

			$pageCount	= str_replace(",", "", substr($result->plaintext, 6, $pos2-7));

		}
		
		return $pageCount;
	}
	
	public function get_site_word_count($url){
	
	
		$content	= '';
		$WordCount	= 0;
		$WordCountArray	= array();

		 $html 		= file_get_html($url);
		
		
		foreach($html->find('body') AS $result){
			$content	= $result->plaintext;
		}

		if(!empty($content)){
			$WordCount 	= str_word_count($content, 0);
		}		

		return $WordCount;
	}
	
	public function get_site_keyword_ratio_count($url, $keyword){
		$WordCountArray	= array();
		$keyword_ratio	= 0;

		$html 		= file_get_html($url);
		//$keyword 	= str_replace(" ", "-", strtolower($keyword));

		// Get rid of style, script etc
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
			   '@<head>.*?</head>@siU',            // Lose the head section
			   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properl
			   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
		);

		$contents = preg_replace($search, '', $html); 
		$result = array_count_values(
			str_word_count(
				strip_tags($contents), 1
			)
		);		

		$sum = 0;
		$contents = strip_tags($contents);
		$kwCount  = 0;
		$kwCount  = substr_count(strtolower($contents), strtolower($keyword));
		$sum      = str_word_count($contents);

		if($sum > 0){
			$keyword_ratio = number_format((($kwCount/$sum)*100), 2);
		}
		
		return $keyword_ratio;
	}
	
	public function get_site_keyword_optimization($url, $keyword){
	
		$keywordScore['url']		= 0;
		$keywordScore['title']		= 0;
		$keywordScore['meta_desc']	= 0;
		$keywordScore['h1']		= 0;
		$keywordScore['h2']		= 0;

		$html = file_get_html($url);
		
		// If keyword fount in url
		if(strpos($url,strtolower(urlencode($keyword)))!=''){
			$keywordScore['url'] = 1;
		}else{
			$keywordScore['url'] = 0;
		}

		// if keyword found in titl
		foreach($html->find('title') AS $result){
			$content	= $result->plaintext;
			if(strpos(strtolower($content),strtolower($keyword))>-1){
			    $keywordScore['title'] = 1;
			    break;
			}
		}
		
		// if keyword found in Meta descriptio
		foreach($html->find('mata[name="description"]') AS $result){
			$content	= $result->plaintext;
			if(strpos(strtolower($content),strtolower($keyword))>-1){
			    $keywordScore['meta_desc'] = 1;
			    break;
			}
		}

		// if keyword found in H1
		foreach($html->find('h1') AS $result){
			$content	= $result->plaintext;
			if(strpos(strtolower($content),strtolower($keyword))>-1){
			    $keywordScore['h1'] = 1;
			    break;
			}
		}

		// if keyword found in H2
		foreach($html->find('h2') AS $result){
			$content	= $result->plaintext;
			if(strpos(strtolower($content),strtolower($keyword))>-1){
			    $keywordScore['h2'] = 1;
			    break;
			}
		}

		return $keywordScore;
	}
	
	public function get_site_exact_kw_links($keyword, $url, $proxy_list, $useragent_list){
		$exactMatchCount	= 0;
		$blendedMatchCount	= 0;
		$brandMatchCount	= 0;
		$rawUrlMatchCount	= 0;
		
		$rand_proxy		= $proxy_list[array_rand($proxy_list)];
		$rand_useragent = $useragent_list[array_rand($useragent_list)];
		$purl 			= parse_url($url);
		$host			= $purl['host'];
		$path			= '';
		$domain 		= parse_url($url, PHP_URL_HOST);
		$domain 		= str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
		$domainArray	= explode('.', $domain);
		$domainName		= $domainArray[0];
		
		if(isset($purl['path'])){
			$path	= $purl['path'];
		}

		$chkDomain	= $host . $path;
		/*$ahref_url	= 'http://api.ahrefs.com/get_anchors_of_backlinks.php?target='.$chkDomain.'&count=20&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';*/
		
		$ahref_url	= 'http://apiv2.ahrefs.com?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&target='.urlencode($chkDomain).'&limit=20&from=anchors&mode=exact&output=json';
		
		//$content 	= $this->get_content($ahref_url, $rand_proxy, $rand_useragent);
		$content	= file_get_contents($ahref_url);
		$result 	= json_decode($content, true);
		$result		=  $result['anchors']; //$result['Result'];
		
		
		if(is_array($result) && count($result) > 0){
			for($i=0; $i<count($result); $i++){
				// Exact match
				if(strtolower($result[$i]['anchor']) == strtolower($keyword)){
					$exactMatchCount++;
				}
				
				// Blended match
				if(strpos(strtolower($result[$i]['anchor']),strtolower($keyword))>-1){
					$blendedMatchCount++;
				}

				// Brand match
				if(strpos(strtolower($result[$i]['anchor']),strtolower($domainName))>-1){
					$brandMatchCount++;
				}

				// RAW url match
				if(strpos(strtolower($result[$i]['anchor']),strtolower($domain))>-1){
					$rawUrlMatchCount++;
				}
			}
		}
				
		/*$ahref_backlink_url	= 'http://api.ahrefs.com/get_backlinks_count_ext.php?target='.$chkDomain.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';*/
		
		$ahref_backlink_url	= 'http://apiv2.ahrefs.com/?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&target='.urlencode($chkDomain).'limit=20&from=metrics&mode=subdomains&output=json';
		
		//$content 	= $this->get_content($ahref_backlink_url, $rand_proxy, $rand_useragent);
		$content	= file_get_contents($ahref_backlink_url);
		$result 	= json_decode($content, true);
		$result		= $result['metrics']; //$result['Result'];
		$backlinks	= $result['backlinks']; //$result['Backlinks'];
		
		$rec['exact_match_count']	= $exactMatchCount;
		$rec['blended_match_count']	= $blendedMatchCount;
		$rec['brand_match_count']	= $brandMatchCount;
		$rec['raw_url_match_count']	= $rawUrlMatchCount;
		$rec['backlinks_count']		= $backlinks;
		
		return $rec;
	}
	
	public function get_site_hiding_links($url, $proxy_list, $useragent_list){
		$rand_proxy	= $proxy_list[array_rand($proxy_list)];
		$rand_useragent	= $useragent_list[array_rand($useragent_list)];
		
		$urlArray	= parse_url($url);
		$path		= '';
		$host	= $urlArray['host'];
		
		if(isset($urlArray['path']) && !empty($urlArray['path'])){
			$path	= $urlArray['path'];
		}

		$url	= $host . $path;
		/*$url	= 'http://api.ahrefs.com/get_backlinks_count_ext.php?target='.$url.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';*/
		
		$url	= 'http://apiv2.ahrefs.com/?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&target='.urlencode($url).'limit=20&from=metrics&mode=subdomains&output=json';

		//$content = $this->get_content($url, $rand_proxy, $rand_useragent);
		$content = file_get_contents($url);
		$result = json_decode($content, true);
		$redirectCount	= $result['metrics']['redirect'];//$result['Result']['Redirect'];

		return $redirectCount;
	}
	
	public function get_site_external_links($url){
		$countExternalLinks	= 0;
		$pUrl = parse_url($url);
		$html = file_get_html($url);
		
		$socialDomains = array(
			'yahoo.com',
			'facebook.com',
			'twitter.com',
			'linkedin.com'
		);
		foreach($html->find('a') AS $result){
			$href	  = $result->href;
			$pHref    = parse_url($href);

			if(isset($pUrl['host']) && isset($pHref['host'])){
				$hostData = explode('.', $pHref['host']);
				$hostData = array_reverse($hostData);
				$host     = $hostData[1] . '.' . $hostData[0];
				
				if(strtolower($pUrl['host']) != strtolower($pHref['host']) && !in_array($host, $socialDomains)){
					$countExternalLinks++;
				}
			}
		}		

		return $countExternalLinks;
	}
	
	public function get_entertainment($url) 
	{
		$importData = array();
		
		/*$entertaintmentJsonUrl  	=  'http://api.ahrefs.com/get_backlinks_count_ext.php?target='.$url.'&mode=exact&output=json&AhrefsKey=34e3ff8e0cbf2d36cc205c37120a6107';*/
		
		$entertaintmentJsonUrl  	=  'http://apiv2.ahrefs.com/?token=f7aa792c3e6f4482249123cb7f6b184584950dd4&target='.urlencode($url).'limit=20&from=metrics&mode=subdomains&output=json';
				
		$content = file_get_contents($entertaintmentJsonUrl);
		$entertaintment_result = json_decode($content, true);					
		
		
		
		if (isset($entertaintment_result['metrics'])) {
			$importData['domain_text']  =  $entertaintment_result['metrics']['text'];		
			$importData['domain_image'] =  $entertaintment_result['metrics']['image'];		
			$importData['domain_redirect']  =  $entertaintment_result['metrics']['redirect'];		
			$importData['domain_frame'] =  0; //$entertaintment_result['metrics']['Frame'];		
			$importData['domain_form'] =  0; //$entertaintment_result['metrics']['Form'];		
			$importData['domain_canonical'] =  $entertaintment_result['metrics']['canonical'];	
			$importData['domain_sitewide'] = $entertaintment_result['metrics']['sitewide'];
			$importData['domain_notsitewide'] =  $entertaintment_result['metrics']['not_sitewide'];
			$importData['domain_nofollow'] = $entertaintment_result['metrics']['nofollow'];		
			$importData['domain_dofollow'] = $entertaintment_result['metrics']['dofollow'];
		}
		
		return $importData;
	}
	
	public function getAddresses($domain) {
	  $records = dns_get_record($domain);
	  $res = array();
	  foreach ($records as $r) {
		if ($r['host'] != $domain) continue; // glue entry
		if (!isset($r['type'])) continue; // DNSSec

		if ($r['type'] == 'A') $res[] = $r['ip'];
		if ($r['type'] == 'AAAA') $res[] = $r['ipv6'];
	  }
	  return $res;
	}

	public function getAddresses_www($domain) {
	  $res = $this->getAddresses($domain);
	  if (count($res) == 0) {
		$res = $this->getAddresses('www.' . $domain);
	  }
	  return $res;
	}
	
	public function get_soc_signal_insert_sql($url) { 
		$insertCond = '';
		$sql = "SELECT fb_like, fb_share, tweets, google_like
				FROM ".$this->db_table."
				WHERE url = '".$url."' ORDER BY id DESC LIMIT 0, 1";
				
		$result = mysql_query($sql);						
		if (mysql_num_rows($result) > 0) {		
			while($row = mysql_fetch_assoc($result)) {
				$insertCond .= ", fb_like = '".$row['fb_like']."'
								, fb_share = '".$row['fb_share']."'
								, tweets = '".$row['tweets']."'
								, google_like = '".$row['google_like']."'";				
			}		
		}
		
		return $insertCond;	
	}
	
	public function get_tweets($url) { 
		$url = rawurlencode($url);
		$json_string = $this->file_get_contents_curl('http://urls.api.twitter.com/1/urls/count.json?url=' . $url);
		$json = json_decode($json_string, true);
		return isset($json['count'])?intval($json['count']):0;
	}
	
	public function get_fb_like_count($url) {
		$url = rawurlencode($url);
		$json_string = $this->file_get_contents_curl('http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$url);
		$json = json_decode($json_string, true);
		
		$resp = array(
			'like_count' => isset($json[0]['like_count']) ? intval($json[0]['like_count']) : 0,
			'share_count' => isset($json[0]['share_count']) ? intval($json[0]['share_count']) : 0
		);
		
		return $resp;
	}
	
	public function get_fb_share_count($url) {
		$url = rawurlencode($url);
		$fb_share_link		= 'https://graph.facebook.com/' . $url;
		$fb_share_content	= json_decode(file_get_contents($fb_share_link));	
		
		if(is_object($fb_share_content) && isset($fb_share_content->shares)){
			return $fb_share_content->shares;
		} else {
			return 0;
		}
	}
	
	public function get_plusones($url)  {
		$url = rawurlencode($url);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.rawurldecode($url).'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		$curl_results = curl_exec ($curl);
		curl_close ($curl);
		$json = json_decode($curl_results, true);
		
		return isset($json[0]['result']['metadata']['globalCounts']['count'])?intval( $json[0]['result']['metadata']['globalCounts']['count'] ):0;
	}
	
	private function file_get_contents_curl($url){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		$cont = curl_exec($ch);
		if(curl_error($ch))
		{
		//die(curl_error($ch));
		}
		return $cont;
	}
	
	function get_domain($url)
	{
	  $pieces = parse_url($url);
	  $domain = isset($pieces['host']) ? $pieces['host'] : '';
	  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
		return $regs['domain'];
	  }
	  return false;
	}
	
	
	function sp_get_domain($sitename){
	
	return $sitename=preg_replace("(^http://)", "", trim($sitename) );
	
	}
	function sp_get_domain_only($sitename){
		$sitename=preg_replace("(www.)", "", $sitename );
		return $sitename=preg_replace("(^https?://)", "", $sitename );
		
	}
	function sp_is_domain($sitename){
		$sitename=preg_replace("(^ftps?://)", "", $sitename );
		$sitename=preg_replace("(^https?://)", "", $sitename );
		$sitename=preg_replace("(^www.)", "", $sitename );
		$arr = explode("/",$sitename);
		$myDomainName= $arr[0];
		$pattern="/^((?!-)[A-Za-z0-9-]{1,63}(?<!-)\\.)+[A-Za-z]{2,6}$/";
		return preg_match($pattern,$myDomainName);
	}

	function sp_is_related($string,$keywords){
		$related=explode(" ",$keywords);
		$counter=0;

		for($j=0;$j<count($related);$j++){
			if(strpos(strtolower(trim($string)),strtolower($related[$j]))> -1){
				$counter++;							
			}
		}
		
		return $counter;
	}
	
	function sp_is_brand($string,$domain){
		$sitename=preg_replace("(^ftps?://)", "", $domain );
		$sitename=preg_replace("(^https?://)", "", $sitename );
		$sitename=preg_replace("(^www.)", "", $sitename );
		$arr=explode(".",$sitename);
		$domain_name=strtolower($arr[0]);
		
		$related=explode(" ",$string);	
		$mainstr="";
		for($j=0;$j<count($related);$j++){
			$mainstr.=$related[$j];
		}
		
		
		return strpos(strtolower($mainstr),$domain_name);

	}

	/* name:- get_site_crawler_data
	   author:- Ravi Prakash(tenfoldweb)
	   desc:- This function is used to handle site page data for each website
	*/
	function get_site_crawler_data($url,$campaignid,$keywordid,$keyword){


						
						/*
							$data = array(
										
									);
										echo "<pre>";
							print_r($data);
							echo "</pre>"; */
	}
	
	/* name:- get_social_data
	   author:- Ravi Prakash(tenfoldweb)
	   desc:- This function is used to handle Social data for each website
	*/
	function get_social_data($url,$campaignid,$keywordid,$keyword){
	
		$socialdata = $this->cron_model->get_social_data_by_siteurl($url);
		$is_go=0;
		if(sizeof($socialdata)>0){
			$date1 = new DateTime(date('Y-m-d')); //Today
			$date2 = new DateTime($socialdata[0]->date_added);

			$interval = $date1->diff($date2);
			$daysDiff = $interval->days;
			
			if ($daysDiff < 30) {
				$is_go=1;
			}
			
		}
		
		//print_r($anchordata);
		if($is_go==0){
		
			$tweets	= $this->get_tweets($url);
			$fb_like_share = $this->get_fb_like_count($url);
			
			$fb_like_share['share_count'];
			$google_like	= $this->get_plusones($url);
			$data = array(
						'siteurl' => $url,
						'tweets_count' => $tweets,
						'like_count' => $fb_like_share['like_count'],
						'share_count' =>$fb_like_share['share_count'],
						'gplus_count' =>$google_like,
						'date_added' =>date('Y-m-d')
					);
					
			$this->cron_model->insert_site_social_data($data);
		}
							
	}
	
	function get_pagebot($url,$keyword){
			//$url = 'http://tutorialzine.com/2011/06/15-powerful-jquery-tips-and-tricks-for-developers/';
			//$keyword = 'jquery';
			$key = strtolower(trim(str_replace('+',' ',$keyword)));
			$proxy_list	= $this->scrapper_model->getValues_conditions(TABLE_PROXIES, '*', '', 'status = 1');
			$proxy = $proxy_list[rand(0,(count($proxy_list)-1))]['proxy'];
			$getproxy_credential = $this->scrapper_model->get_proxy_credentials($proxy);
			$raw = $this->crawl_simple('', $url, $this->agent, $proxy,$getproxy_credential);

			$html = str_get_html($raw);
			$domain = parse_url($url);
			print_r($domain);
			$domain = str_replace('www.','',strtolower(trim($domain['host'])));
			$ip = array_pop(gethostbynamel($domain));
			$text = preg_replace('/<a(.*?)\/a>/','',$html->find('body',0));
			$text = preg_replace('/\s+/',' ',$text);
			$text = preg_replace('/<script(.*?)>(.*?)\s+(.*?)<\/script>/',' ',$text);
			$text = preg_replace('/<\s*script.*?>.*?(<\s*\/script.*?>|$)/',' ',$text);
			$text = preg_replace('/<\s*style.*?>.*?(<\s*\/style.*?>|$)/',' ',$text);
			$text =  strip_tags($text);

			$pageParser['URL'] = $url;
			$pageParser['keyword'] = trim(str_replace('+',' ',$keyword));
			$pageParser['ip'] = $ip;
			$pageParser['inURL'] = (strstr(strtolower(str_replace(array('-','https','http','www.','.com'),array(' ','','','',''),preg_replace('/[^a-zA-Z\-.]/','',$url))),$key)?'YES':'No');
			$pageParser['wordCount'] = str_word_count($text);
			$pageParser['kwCount'] = substr_count(strtolower($text),' '.$key.' ');

			if(count($html->find('meta[name="Description"]')) > 0){
				$meta = $html->find('meta[name="Description"]',0)->getAttribute('content');
				if(strstr(strtolower($meta),$key))
					$pageParser['inMetaDescription'] = 'Yes';		
				else
					$pageParser['inMetaDescription'] = 'No';
			}elseif(count($html->find('meta[name="description"]')) > 0){
				$meta = $html->find('meta[name="description"]',0)->getAttribute('content');
				if(strstr(strtolower($meta),$key))
					$pageParser['inMetaDescription'] = 'Yes';
				else
					$pageParser['inMetaDescription'] = 'No';
			}

			$title =  strtolower($html->find('title',0)->plaintext);
			if(strstr($title,$key))
				$pageParser['inTitle'] = 'Yes';
			else
				$pageParser['inTitle'] = 'No';	 

			$counter = 0;
			$internalOutput = '';
			foreach($html->find('b') as $b){
				if(strstr(strtolower($b->plaintext),$key)){
					$counter++;		
				}
			}
			$pageParser['inBold'] = $counter;

			$counter = 0;
			$internalOutput = '';
			foreach($html->find('h1') as $h1){
				if(strstr(strtolower($h1->plaintext),$key)){
					$counter++;
				}
			}
			$pageParser['inH1'] = $counter;

			$counter = 0;
			$internalOutput = '';
			foreach($html->find('h2') as $h2){
				if(strstr(strtolower($h2->plaintext),$key)){
					$counter++;
				}
			}
			$pageParser['inH2'] = $counter;

			$internalOutput = '';
			$counter = 0;
			foreach($html->find('a') as $a){
				if(!isset($a->href) || empty($a->href) || preg_match('/#(.*?)/', $a->href) || empty($a->plaintext)) continue;
					$link = parse_url($a->href);
					if(isset($link['host'])){
					$link = str_replace('www.','',strtolower($link['host']));
					if(!empty($link) && !strstr($link,$domain) ){

						$ignoreDomainFlag = true;
						if(isset($ignoreDomain)){
							foreach($ignoreDomain as $ignDomain){
								if(preg_match('/(.*)'.$ignDomain.'/',$link)){
									$ignoreDomainFlag = false;
									break;
								}	
							}
						}
						if($ignoreDomainFlag){
							$counter++;
							$internalOutput[] = $a->href;
						}
					}
				}
			}	
			$pageParser['externalLinksCount'] = $counter;
			$pageParser['externalLinks'] = $internalOutput;

			$counter = 0;
			$internalOutput = '';

			foreach($html->find('img') as $img){
				$imageName = trim($img->src);
				$temp = explode('/',$imageName);
				$temp = $temp[sizeof($temp)-1];
				$temp = explode('.',$temp);
				$temp = strtolower(preg_replace('/[^a-zA-Z]/','',$temp[0]));
				if(strstr($temp,strtolower(preg_replace('/[^a-zA-Z]/','',$key)))){
					$counter++;
				}
			}
			$pageParser['InImageName'] = $counter;


			$counter = 0;
			$internalOutput = '';

			foreach($html->find('img') as $img){
				if(!isset($img->alt) || empty($img->alt)) continue;
				$alt = trim($img->alt);
				$temp = trim(strtolower($alt));

				if(strstr($temp,$key)){
					$counter++;
				}
			}
			$pageParser['inImageAlt'] = $counter;

			$counter=0;
			foreach($html->find('a') as $a){
				$anchorText = strtolower(trim($a->plaintext));
				if(strstr($anchorText,$key)){
					$counter++;
				}
			}
			$pageParser['anchors'] = count($html->find('a'));
			$pageParser['inAnchor'] = $counter;

			$demo = preg_replace('/[^a-zA-Z0-9 ]/',' ',$text);
			$demo = preg_replace('/\s+/',' ',$demo);
			$percentage = (str_word_count($demo) * 20) /100;//20% of page content
			$totwords = ceil($percentage);
			$temp = explode(' ',$demo);
			$temp = array_chunk($temp, $totwords);
			$demoText = strtolower(implode(' ',$temp[0]));


			if(strstr($demoText,$key)){
				$pageParser['aboveTheFold'] = 'Yes';
				$pageParser['aboveTheFoldCount'] = substr_count($demoText ,' '.$key.' ');
			}
			else{
				$pageParser['aboveTheFold'] = 'No';
				$pageParser['aboveTheFoldCount'] = 0;
			}

		return $pageParser;
	}
	/* name:- get_aherf_data
	   author:- Ravi Prakash(tenfoldweb)
	   desc:- This function is used to handle aherf data for each website
	*/
	function get_aherf_data($sitename,$campaignid,$keywordid,$keyword){
		$siteurl = $sitename;
		$sitename = preg_replace("(^https?://)", "", $sitename );
		$sitename = urlencode($sitename);
		$ahrefdata = $this->cron_model->get_api_response_by_siteurl($siteurl);
		$is_update=0;
		//echo "http://apiv2.ahrefs.com/?token=935d9beebf39975982f345f3bb24176a8b46320c&from=metrics&target=$sitename&mode=exact&order_by=backlinks:desc&output=json";
		if(sizeof($ahrefdata)<1){
			//echo "no exist";
			$webdata = $this->file_get_contents_curl("http://apiv2.ahrefs.com/?token=935d9beebf39975982f345f3bb24176a8b46320c&from=metrics&target=$sitename&mode=exact&order_by=backlinks:desc&output=json");
			$webdatadb= $webdata;
			$webdata = json_decode($webdata);
			$sitedata = $webdata->metrics;
			//print_r($sitedata);
			
			$webdata = $this->file_get_contents_curl("http://apiv2.ahrefs.com/?token=935d9beebf39975982f345f3bb24176a8b46320c&from=anchors&target=$sitename&mode=exact&order_by=backlinks:desc&limit=20&output=json&select=anchor,backlinks,refdomains&where=nofollow%3Dfalse");
			$anchordatadb = $webdata;
			$webdata = json_decode($webdata);
			$anchordata = $webdata->anchors;
			$data = array(
							'sitename' =>$siteurl,
							'sitedata' => addslashes($webdatadb),
							'anchordata' =>addslashes($anchordatadb),
							'date_added' => date('Y-m-d')
						);
			$this->cron_model->insert_api_response_data($data);
			$is_update=1;
		} else {
		//	echo "yes exist";
			$date1 = new DateTime(date('Y-m-d')); //Today
			$date2 = new DateTime($ahrefdata[0]->date_added);

			$interval = $date1->diff($date2);
			$daysDiff = $interval->days;
			
			if ($daysDiff < 30) {
				$webdata = stripslashes($ahrefdata[0]->sitedata);
				$webdata = json_decode($webdata);
				$sitedata = $webdata->metrics;
				$webdata = stripslashes($ahrefdata[0]->anchordata);
				$webdata = json_decode($webdata);
				$anchordata = $webdata->anchors;
			} else {
			//	echo "greate 30 days";
				$webdata = $this->file_get_contents_curl("http://apiv2.ahrefs.com/?token=935d9beebf39975982f345f3bb24176a8b46320c&from=metrics&target=$sitename&mode=exact&order_by=backlinks:desc&output=json");
				$webdatadb= $webdata;
				$webdata = json_decode($webdata);
				$sitedata = $webdata->metrics;
				//print_r($sitedata);
				
				$webdata = $this->file_get_contents_curl("http://apiv2.ahrefs.com/?token=935d9beebf39975982f345f3bb24176a8b46320c&from=anchors&target=$sitename&mode=exact&order_by=backlinks:desc&limit=20&output=json&select=anchor,backlinks,refdomains&where=nofollow%3Dfalse");
				$anchordatadb = $webdata;
				$webdata = json_decode($webdata);
				$anchordata = $webdata->anchors;
				$is_update=1;
				$data = array(
								'sitedata' => addslashes($webdatadb),
								'anchordata' =>addslashes($anchordatadb),
								'date_added' => date('Y-m-d')
							);
				$this->cron_model->update_api_response_data($data,$siteurl);
			}
								
								
			
		}
		
		$siterankingdata = $this->cron_model->get_site_ranking_by_keyword_data($siteurl,$keyword);
		
		$is_go=0;
		if(sizeof($siterankingdata)>0){
			$date1 = new DateTime(date('Y-m-d')); //Today
			$date2 = new DateTime($siterankingdata[0]->date_added);

			$interval = $date1->diff($date2);
			$daysDiff = $interval->days;
			
			if ($daysDiff < 30) {
				$is_go=1;
			}
			if($is_update==1){
				$is_go=0;
			}
			
		}
		//if($is_go==0){
		if($is_go!=0){
			$combineMatchCount=$exactMatchCount=$blendedMatchCount =$relatedKeywordsCount=$rawUrlMatchCount=$brandMatchCount =$GenericMatchCount ="0";
			$totalbacklinkperurl="0";
			
			
			foreach($anchordata as $anchor){
				if($anchor->anchor!=''){
					$combine_Match_Count=$exact_Match_Count=$blended_Match_Count =$related_Keywords_Count=$raw_Url_Match_Count=$brand_Match_Count="";
			
					$domain=$domainName=$this->get_domain($siteurl);
					
					$per = ($anchor->backlinks/$sitedata->backlinks);
					$per = round($per*100);
					$totalbacklinkperurl+=$anchor->backlinks;
					//$per_anchor=round(($anchor->backlinks/$totalbacklinkperurl)*100);
					
					//echo "adsfasd111f";
									
						// Exact match
						
					if(strtolower(trim($anchor->anchor)) == strtolower(trim($keyword))){
						//$exactMatchCount++;
						$exactMatchCount = $exactMatchCount +$anchor->backlinks; 
						$exact_Match_Count=$anchor->backlinks;
						
					}
					// Blended match 
					else if(strpos(strtolower(trim($anchor->anchor)),strtolower($keyword))>-1){
						//$blendedMatchCount++;
						$blendedMatchCount = $blendedMatchCount +$anchor->backlinks;
						$blended_Match_Count = $anchor->backlinks; 	
						
					}
					// Related Keywords
					else if($this->sp_is_related(strtolower(trim($anchor->anchor)),strtolower($keyword))>0 && $this->sp_is_domain(trim($anchor->anchor))==false){ 
					
						$relatedKeywordsCount = $relatedKeywordsCount + $anchor->backlinks; 
						$related_Keywords_Count = $anchor->backlinks; 
						//$anc_are_str1_inner[$siteurl]['related_Keywords_Count'][]=array($anchor->anchor,$anchor->backlinks);	
						//$popular_anchors_by_backlink[$siteurl]['anchor'][$i]['type'] ="related";					

					}
				   else if($this->sp_is_domain(strtolower(trim($anchor->anchor)))>0){ 
						
						$rawUrlMatchCount = $rawUrlMatchCount +$anchor->backlinks;
						$raw_Url_Match_Count = $anchor->backlinks;
						//$anc_are_str1_inner[$siteurl]['raw_Url_Match_Count'][]=array($anchor->anchor,$anchor->backlinks);	
						//$popular_anchors_by_backlink[$siteurl]['anchor'][$i]['type'] ="raw";					

					}

					// Brand match
					else if($this->sp_is_brand(trim($anchor->anchor),$domain)>-1 ){ //&& sp_is_domain(trim($anchor->anchor))==false
						//$brandMatchCount++;
						$brandMatchCount = $brandMatchCount +$anchor->backlinks;
						$brand_Match_Count = $anchor->backlinks;
					}
					else{ //generic
						//$popular_anchors_by_backlink[$siteurl]['anchor'][$i]['type'] ="generic";	
					}		
					
					//$i++;
				}
			}
			$combineCount=($exactMatchCount+$relatedKeywordsCount+$blendedMatchCount+$brandMatchCount+$rawUrlMatchCount);
			$genericCount = round($totalbacklinkperurl-$combineCount);
			
			
			$pagedata = $this->get_pagebot($siteurl,$keyword);
			
			$keywordRatio = $this->get_site_keyword_ratio_count($siteurl, $keyword);
							$keywordRatio = trim($keywordRatio);	
							
			$data = array(
						'site_url' =>$siteurl,
						'keyword' =>$keyword,
						'backlink_count' =>$sitedata->backlinks,
						'referring_count' =>$sitedata->refpages,
						'sitewide_count' =>$sitedata->sitewide,
						'do_follow_count' =>$sitedata->dofollow,
						'no_follow_count' =>$sitedata->nofollow,
						'redirect_count' =>$sitedata->redirect,
						'image_count' =>$sitedata->image,
						'text_count' =>$sitedata->text,
						'exact_match' =>$exactMatchCount,
						'related_kw' =>$relatedKeywordsCount,
						'blended_kw' =>$blendedMatchCount,
						'brand_kw' =>$brandMatchCount,
						'raw_url' =>$rawUrlMatchCount,
						'other_kw' =>$genericCount,
						'exact_match_percent' =>number_format(($exactMatchCount*100)/$totalbacklinkperurl,2),
						'related_kw_percent' =>number_format(($relatedKeywordsCount*100)/$totalbacklinkperurl,2),
						'blended_kw_percent' =>number_format(($blendedMatchCount*100)/$totalbacklinkperurl,2),
						'brand_kw_percent' =>number_format(($brandMatchCount*100)/$totalbacklinkperurl,2),
						'raw_url_percent' =>number_format(($rawUrlMatchCount*100)/$totalbacklinkperurl,2),
						'other_kw_percent' =>number_format(($genericCount*100)/$totalbacklinkperurl,2),
						'ip' =>$pagedata['ip'],
						'wordcount' =>$pagedata['wordCount'],
						'kwcount' =>$pagedata['kwCount'],
						'keywordratio' => $keywordRatio,
						'keyword_in_url'=>$pagedata['inURL'],
						'keyword_in_title'=>$pagedata['inTitle'],
						'keyword_in_meta_desc'=>$pagedata['inMetaDescription'],
						'keyword_in_bold'=>$pagedata['inBold'],
						'keyword_in_h1'=>$pagedata['inH1'],
						'keyword_in_h2'=>$pagedata['inH2'],
						'external_links' =>$pagedata['externalLinksCount'],
						'in_image_name'=>$pagedata['InImageName'],
						'in_image_alt'=>$pagedata['inImageAlt'],
						'anchors'=>$pagedata['anchors'],
						'in_anchor'=>$pagedata['inAnchor'],
						'is_above_fold'=>$pagedata['aboveTheFold'],
						'above_fold'=>$pagedata['aboveTheFoldCount'],						
						'date_added' =>date('Y-m-d')
					);
			
			
			$this->cron_model->insert_site_ranking_by_keyword_data($data);
		}
	}
	
	
	public function google_site_size($siteurl,$domainext){
	
	return '';
							$host = str_replace("www.", "", $siteurl);
						
				
						/* Site Size */
						$keyword['google_se_domain'] = (isset($keyword['google_se_domain'])) ? $keyword['google_se_domain'] : 'google.com';
						$pageCountURL = 'http://www.google.' . $domainext . '/search?q=site:'.$host;						
						
						$result       = file_get_contents_curl($pageCountURL);						
						$pageCount	  = $this->get_google_site_size($result);
						$data = array(
									'siteurl' =>$siteurl,
									'search_engine' =>$domainext,
									'pagesize' => $pageCount,
									'date_added' =>date('Y-m-d')
									);
						
						$this->cron_model->insertsitedata('serp_google_site_size',$data); 
	}

	
	public function google_domain_age(){
	
		$sitedata = $this->cron_model->get_all_sites();
		foreach($sitedata as $sites){
			$this->model_campaign->domain_creation_date($sites->hostname);
			//sleep(30);
		}
		
		
	}
	
	public function get_domain_page_count(){	
		$pagesitedata = $this->cron_model->get_data_for_page_count();
		/*echo "<pre>";
		print_r($pagesitedata);
		exit;*/
		
		foreach($pagesitedata as $sitedata){
			 echo $mainurl = $this->get_domain($sitedata->url);
			 
			$indexdata = file_get_contents_curl('http://serpavenger.com/indexchecker/resultcount.php?domain='.$mainurl);
			
			if($indexdata!=''){
				$dataarr = json_decode($indexdata);
				$tot = $dataarr->totalResultsWeekly;
				$totall = $dataarr->totalResultsAllTime;
					if(is_numeric($tot)){
					$data = array(
									'siteurl' =>$sitedata->url,
									'search_engine' =>'gr',
									'pagesize' => $tot,
									'totpagesize' => $totall,
									'date_added' =>date('Y-m-d')
									);
						//print_r($data);
						$this->cron_model->insertsitedata('serp_google_site_size',$data); 
					}
						sleep(15);
			}
		}
		echo "done";
	
		
		
	}
	
	public function enable_proxy(){
		$this->cron_model->set_proxy_enable();
		echo "done";
	}
	
		
	
	
}



/* End of file member.php */
/* Location: ./front-app/controllers/member.php */
