<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $page_title;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/styles.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/reset.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/screen.css" media="all" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/toggles.css" media="all" />

<!--[if lt IE 9 ]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
<!--[if lte IE 7]><script src="js/lte-ie7.js"></script><![endif]-->
</head>
<body>
<div id="path_url" style="display:none;"><?php echo base_url()?></div>
<section class="page clearfix">
<?php $this->load->view('frontend/header');?>
<link href="<?php echo base_url()?>assets/css/table.css" media="screen" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.datatables.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.jeditable.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.blockui.js"></script>
        <script type="text/javascript">
$(document).ready(function() {
	
	$('input:checkbox').click(function(){
			var chk='';
			 $("input[type='checkbox']:checked").each(function() { 							   
				   chk ='yes'; 
			 });
			 if(chk=='yes'){
				 $('#edit').show();
			 }else{
				 $('#edit').hide();
			 }		
		});
		
		$('input:button').click(function(){
			 $('#anchor_reset').show();
			
		});
		$('.close').click(function(){
		  $('.forms_cv').hide();
		  $('input:checkbox').removeAttr( "checked" );
		  $('#edit').hide();
		});
	
	var table = $("#datatable");
	var oTable = table.dataTable({"bPaginate": true, 
	
	    "aLengthMenu": [[5, 10, 15, 25, 50, 100 , -1], [5, 10, 15, 25, 50, 100, "All"]],		
        "iDisplayLength" : 15,
	    "bFilter": true,
       // "iDisplayStart": 0,
		"bInfo": false,
		});
		
		$('#datatable_length').hide();
		
	  
});
function update_links(id, field, field_val){
	//alert('hit');
	$('#'+field+'_'+id).removeAttr('onclick');
	var txt = '<input type="text" name="'+field+'" value="'+field_val+'" onblur="save_links('+id+',\''+ field+'\',\''+ field_val+'\')">';
	$('#'+field+'_'+id).html(txt);
	$('#'+field+'_'+id).find('input').focus();
}
function save_links(id, field, field_val){
	
  	var newlink = $('#'+field+'_'+id).find('input').val();
	$('#'+field+'_'+id).html('<img src="<?php echo base_url()?>assets/images/loader.gif" border="0" />');
	$.post( "<?php echo base_url()?>activesubmissions/update_link", { id:id, field_name:field, new_value:newlink}, function(data){
		//alert(data);
		if(data > 0){
		$('#'+field+'_'+id).attr("onclick","update_links("+id+", '"+field+"', '"+newlink+"')");
		$('#'+field+'_'+id).html(newlink);
		}else{
			$('#'+field+'_'+id).attr("onclick","update_links("+id+", '"+field+"', '"+field_val+"')");
		    $('#'+field+'_'+id).html(newlink);
		}
	});
	//alert(newlink);	
}
	
</script>
<style>
	.network_buttom.box_two {
		border:0;
	}
	.network_buttom.box_two table th {
		padding:13px 0;
	}
	.dataTables_wrapper .dataTables_paginate{
		margin-top: 0px !important;
	}
	
	.dataTables_wrapper .dataTables_filter {margin: -41px 10px 10px 0px;}
	.dataTables_wrapper .dataTables_filter input { height:25px; padding: 0px 4px 0px 4px; line-height:25px;}
</style>
  <section class="main">
    <section class="mainContent clearfix">
      <aside class="mainLeft">
        <div class="sideMenuTitle">My Panel</div>
        <?php $this->load->view('frontend/left_menu');?>
      </aside>
      <article class="mainRight">
		 <?php $this->load->view('frontend/main_menu');?>
        <section class="mainContainerSec">
			<div class="submitter">
            	<div class="sub_top">
                	<a href="<?php echo base_url()?>scrapper"><button class="one">
                    	<p>New Submission</p>
                        <span>Create New Submission</span>
                    </button></a>
                	<a href="<?php echo base_url()?>activesubmissions"><button class="one two">
                    	<p>Active Submissions</p>
                        <span>View/ Edit Submissions</span>
                    </button></a>
                    <a href="<?php echo base_url()?>completedsubmissions">
                	<button class="one three">
                    	<p>Completed Submissions</p>
                        <span>View or Edit Submissions</span>
                    </button></a>
                </div>
                
                 <?php if($this->session->flashdata('message')) { 
		          echo $this->session->flashdata('message'); } ?>
                
                <div class="sub_buttom">
                	<div class="content_titel clearfix"><h2><?=$page_title; ?></h2></div>

                  
                   <div class="network_buttom box_two">
                    <!--form was here--> 
                    
                    <?php if($page_title == "Active Submissions") $path = "activesubmissions"; else $path = "completedsubmissions"; ?>
                    
                    <form name="frm1" action="<?php echo base_url().$path; ?>/article_update" method="post">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="toggle_box toggle_box1" style="display: table;" id="datatable">
                      <thead>
                      <tr>
                        <th>Post URL</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Hp</th>
                        <th>Sc</th>
                        <th>Comments</th>
                        <!--<th>OBL</th>-->
                        <th>Anchor 1</th>
                        <th>Link 1</th>
                        <th>Anchor 2</th>
                        <th>Link 2</th>
                        <th>Anchor 3</th>
                        <th>Link 3</th>
                        <!--<th>Save</th>
                        <th>Promote</th>-->
                        <th><img alt="no img" src="<?php echo base_url()?>assets/images/img18.png"></th>
                      </tr>
                      </thead>
                      <tbody>
                     
                      <?php //echo '<pre>';print_r($active_posts);die;?>
                      <?php foreach($active_posts as $active_post){?>
                      <tr>
                        <td><?php echo $active_post->post_name;?></td>
                        <td><?php echo $active_post->post_date;?></td>
                        <td><?php echo $active_post->post_modified;?></td>
                        <td><?php if($active_post->hp==1){
							echo 'Yes';
							}else{ echo 'No'; }?></td>
                        <td><?php if($active_post->sc==1){ // Not Manually
							echo 'No';
							}else{ echo 'Yes'; }?></td>
                        <td><?php echo $active_post->comment_count;?></td>
                        <!--<td>...</td>-->
                        <td><div id="anchor1_<?php echo $active_post->ID;?>" onClick="update_links(<?php echo $active_post->ID;?>,'anchor1','<?php echo $active_post->anchor1;?>');"><?php echo $active_post->anchor1;?></div></td>
                        <td><div id="link1_<?php echo $active_post->ID;?>" onClick="update_links(<?php echo $active_post->ID;?>,'link1','<?php echo $active_post->link1;?>');"><?php echo $active_post->link1;?></div></td>
                        <td><div id="anchor2_<?php echo $active_post->ID;?>" onClick="update_links(<?php echo $active_post->ID;?>,'anchor2','<?php echo $active_post->anchor2;?>');"><?php echo $active_post->anchor2;?></div></td>
                        <td><div id="link2_<?php echo $active_post->ID;?>" onClick="update_links(<?php echo $active_post->ID;?>,'link2','<?php echo $active_post->link2;?>');"><?php echo $active_post->link2;?></div></td>
                        <td><div id="anchor3_<?php echo $active_post->ID;?>" onClick="update_links(<?php echo $active_post->ID;?>,'anchor3','<?php echo $active_post->anchor3;?>');"><?php echo $active_post->anchor3;?></div></td>
                        <td><div id="link3_<?php echo $active_post->ID;?>" onClick="update_links(<?php echo $active_post->ID;?>,'link3','<?php echo $active_post->link3;?>');"><?php echo $active_post->link3;?></div></td>
                       <!-- <td><button class="save">Save</button></td>
                        <td>Select Date</td>-->
                        <td><input type="checkbox" value="<?php echo $active_post->ID;?>" name="ids[]"></td>
                      </tr>
                      <?php } ?>
                      
                     
                    </tbody>
                    </table>
                    <div id="anchor_reset" class="forms_cv" style="display:none; top:388px; z-index:100;">
                        <a class="close" style="cursor:pointer;">Close</a>
                        <div id="result"></div>
                        
                         <table width="322" border="0">
                             <tr style="height:10px;">
                              <td><strong>Update Links & Anchors...</strong></td>            
                             </tr>             
                             <tr>
                              <td>Anchor 1:</td><td><input type="text" name="anchor1" value=""></td>
                              <td>Link 1:</td><td><input type="text" name="link1" value=""></td>
                             </tr>
                             <tr>
                              <td>Anchor 2:</td><td><input type="text" name="anchor2" value=""></td>
                              <td>Link 2:</td><td><input type="text" name="link2" value=""></td>
                             </tr>
                             <tr>
                              <td>Anchor 3:</td><td> <input type="text" name="anchor3" value=""></td>
                              <td>Link 3:</td><td> <input type="text" name="link3" value=""></td>
                             </tr>
                             <tr><td colspan="4" align="center"> <input type="submit"  name="submit" value="Update" /></td></tr>							  
                        </table></div>
                    </form>
                    </div>

                </div>
               

            </div>
        <div align="center" id="edit" style="display:none;"><input type="button" value="&nbsp;Edit&nbsp;"></div>
        </section>

      </article>

    </section>

  </section>
<?php $this->load->view('frontend/footer');?>