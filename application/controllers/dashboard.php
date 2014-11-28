<?php


class Dashboard extends MY_Controller{
    
    public function __construct(){
		parent::__construct();
		//$this->load->library('analyze');
		$this->load->model('model_analysis');
    }
    
    
    function index(){
        $this->check_login();
        $parasitelist	= $this->parasitelist();		
        
        if(isset($_GET['cid']) && !empty($_GET['cid'])){
                $cid	= (int)trim($_GET['cid']);	
        }else{
                $cid	= 0;
        }
        
        $users_id	= $this->session->userdata('LOGIN_USER');
        $this->data = '';
        $this->templatelayout->get_header();
        $this->templatelayout->make_seo();
        $this->templatelayout->get_left();
        $this->templatelayout->get_topmenu();
        $this->templatelayout->get_footer();
        
        $this->elements['middle']='dash_board';			
        $this->elements_data['middle'] = $this->data;
                    
        $this->layout->setLayout('main_layout');
        $this->layout->multiple_view($this->elements,$this->elements_data);
        
    }
}

?>