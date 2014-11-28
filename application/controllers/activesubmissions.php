<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ActiveSubmissions extends CI_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->helper('dom');
    

		$this->load->model('scrapper_model');
		
		$this->load->model('userlogin_model');


	   if(!$this->session->userdata('user_data'))
	   {
		 redirect(Am_Lite::getInstance()->getLoginURL());
	   }
	}

  function limit_words_scrapper($string, $word_limit)
  {
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
  }

	public function index()
	{
    $this->load->library('pagination');
		$data['page_title'] = 'Active Submissions';
$session = $this->session->userdata('user_data');
     $users_id = $session['user_id'];
    
		$config = array();
	  $config["base_url"] = base_url() . "index.php/activesubmissions/index";
	  $config["per_page"] = 10;
	  $config["uri_segment"] = 3;

//$config["total_rows"] = 10;
    $config["total_rows"] = $this->scrapper_model->user_count($users_id,'publish');
      
	  $this->pagination->initialize($config);
     $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    
    $data['active_posts'] = $this->scrapper_model->get_active_posts($users_id,'publish',$config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		$data['current'] = ($page / $this->pagination->per_page) +1;

		$temp_total = $this->pagination->total_rows / $this->pagination->per_page;
    $temp_total1 = explode(".",$temp_total);
   
		if($temp_total1[0]>'0')
		{
			$data['total']=$temp_total1[0]+1;
		}
		else{
			$data['total']= $temp_total1[0];
		}

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
		$data['ids'] = array();
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
		
		redirect('activesubmissions');
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
	
	public function update_link(){	
	  $id = $this->input->post('id');
	  $field_name = $this->input->post('field_name');	 
	  $new_value = $this->input->post('new_value');	 
	  echo $this->scrapper_model->update_links($id, $field_name, $new_value);
	  
	}

	public function delete($id)
   {
    $data['page_title'] = 'Active Submissions';
    $this->scrapper_model->delete_user($id);
    redirect('activesubmissions');
   }
	
  public function deletepopup($id)
   {
    $data['page_title'] = 'Active Submissions';
    $this->scrapper_model->delete_popupdata($id);
    redirect('activesubmissions');
   }
 public function tildescpopmodal_update()
  {
     
    $pid = $this->input->post('pid');  
    $ptitle = $this->input->post('ptitle');  
    $pcontent = $this->input->post('pcontent');
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p>', '</p>');
    $postdata = array('pid' => $pid,'ptitle' => $ptitle,'pcontent' => $pcontent);  
    
     $retval = $this->scrapper_model->tildescpopmodal_update($postdata);
    
   // $this->session->set_flashdata('message', '<div class="notification note-success" style="padding-top:7px">              <a title="Close notification" class="close" href="#">close</a><p>Links Updated</p></div>');
    if($retval == 1 || $retval == '1')
    $this->session->set_flashdata('message', '<div class="notification note-success">
          <a title="Close notification" class="close" href="#">close</a>
          <p>You have successfully updated your Articles!</p>
        </div> ');

    redirect('activesubmissions');
  }
  
public function pop_up()
   {
    $data['page_title'] = 'Active Submissions';
    $id=$_POST['title'];
  $dta=$this->scrapper_model->popup_data($id);
   // echo "<table><tr><td>".$dta[0]->ID."</td><td>".$dta[0]->campaign_id."</td></tr></table>";
    
   echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover">
                                  <tr>
                                    <th>Submission Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th>Comments</th>
                                    <th>Formatted</th>
                                    <th>Assigned Blog</th>
                                    <th></th>
                                    <th></th>
                                  </tr>';
                                 foreach($dta as $data){
                                 //$newstar= limit_words($data->post_content,7);
                               echo  ' <tr>
                                    <td>'.$data->date1.'</td>
                                    <td>'.$data->time1.'</td>
                                    <td>'.$data->post_status.'</td>
                                    <td>'.$data->post_title.'</td>
                                    <td>'.$data->comment_count.'</td>
                                    <td>'.$data->post_title.'</td>
                                    <td>'.$data->post_content.'</td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <a data-toggle="modal" data-target="#edit-articles_'.$data->ID.'" style="padding:0" href="activesubmissions/'.$data->ID.'">Edit Articles</a>
                                           
                                            <div class="modal fade" id="edit-articles_'.$data->ID.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header popup-header">
                                                <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Edit Articles</h4>
                                              </div>
                                              <form id="managemankey" name="managemankey" action="'.base_url().'index.php/activesubmissions/tildescpopmodal_update/" method="post">
                                              <input name="pid" type="hidden" value="'.$data->ID.'">
                                              <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="editart">
                                                      <tr>
                                                        <td width="8%">Title</td>
                                                        <td><input name="ptitle" type="text" value="'.$data->post_title.'"></td>
                                                      </tr>
                                                      <tr>
                                                        <td width="8%" valign="top">Article</td>
                                                        <td>
                                                            <div class="text-editor">
                                                                <div class="editing-tools">
                                                                    <div class="toolgroup">
                                                                        <a href=""><i class="fa fa-bold"></i></a>
                                                                        <a href=""><i class="fa fa-italic"></i></a>
                                                                        <a href=""><i class="fa fa-underline"></i></a>
                                                                        <a href=""><i class="fa fa-subscript"></i></a>
                                                                    </div>
                                                                    <div class="toolgroup">
                                                                        <a href=""><i class="fa fa-list-ol"></i></a>
                                                                        <a href=""><i class="fa fa-list-ul"></i></a>
                                                                    </div>
                                                                    
                                                                    <div class="toolgroup">
                                                                        <a href=""><i class="fa fa-align-left"></i></a>
                                                                        <a href=""><i class="fa fa-align-right"></i></a>
                                                                        <a href=""><i class="fa fa-align-justify"></i></a>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="editingcontent-area">
                                                        <textarea name="pcontent" cols="" rows="20" placeholder="Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham. ">'.$data->post_content.'</textarea>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </td>
                                                      </tr>
                                                      </table>
                                                 </div>
                                                <div class="clearfix"></div>   
                                              </div>
                                              <div class="modal-footer popupfooter">
                                                <button class="btn btn-primary" type="submit">Save</button>
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                              </div>
                                            </div>
                                            </div>
                                            </div>
                                    </td>
                                    <td><a href="activesubmissions/deletepopup/'.$data->ID.'"><i class="fa fa-trash-o"></i></a></td>
                                  </tr>';
                              }
                              echo  '</table>';



  //  echo $this->scrapper_model->popup_data($id);
    //redirect('activesubmissions');
    
   }
}  //class end