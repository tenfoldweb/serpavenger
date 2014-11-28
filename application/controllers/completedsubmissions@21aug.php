<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompletedSubmissions extends CI_Controller {

	public function __construct(){

		parent::__construct();	

		$this->load->helper('dom');

		$this->load->model('scrapper_model');
	}

	public function index()
	{
		$data['page_title'] = 'Completed Submissions';

		$data['active_posts'] = $this->scrapper_model->get_active_posts(2,'completed');

		$this->load->view('post_list',$data);
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
		$data['ids']       = $this->input->post('ids');

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
		
		redirect('completedsubmissions');
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
	
}  //class end