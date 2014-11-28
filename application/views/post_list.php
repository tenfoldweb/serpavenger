<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.dataTables.css" media="screen" />
    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/responsive.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/toggles.css">
   <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){
         $("#test").click(function (){ //alert('secondlink test');
             $('#secondlink').removeClass("active");  
             $('#secondlink').addClass("activemore");   
             $('#test').addClass("active"); 
         });
         $("#secondlink").click(function (){
             $('#secondlink').removeClass("active");
           // $('#secondlink').addClass("activemore");    
             $('#test').addClass("active"); //alert('secondlink click');
         });
function show_next(val)
{
	window.location="?show=" + val;
}

    });     

    $(document).ready(function() {
//alert('hh');
    $( "#toggle_box" ).hide();

    //$( "#toggle_box" ).css(padding, 0);
    $( ".denvernew2" ).click(function() { 
        
        var title = $(this).attr('title');
       // alert(title);
        //var res = id.split("_"); 
       // if(res[0] = 'toggle')
       // {
    $( "#toggle_box_"+title ).toggle();
   // $( "#toggle_box_"+title ).remove('style:display: none;');
    // $( "#toggle_box_" ).toggle();
   // $( "#toggle_box_"+title ).removeAttr("style:display:none;");
   // alert('test');
     //$( "#toggle_box_"+title).toggle();
    //alert($(this).text());
      if ($(this).text() == "View Articles") 
      { 
         $(this).text("Hide Articles");
         $(this).addClass("bulebg"); 
         $( "#toggle_box_"+title ).removeAttr('style');
      } 
      else 
      { 
         $(this).text("View Articles");
         $(this).removeClass("bulebg");
$( "#toggle_box_"+title ).css('display','none');
      }; 
    
    
    });
   }); 
    </script>
    
    <!-- font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row" id="header">
          <div class="col-md-3">
                <div id="logo"><a href="index.html"><img src="<?php echo base_url(); ?>images/logo.png" width="214" height="84" alt=""></a></div>
          </div>
          
            <div class="col-md-9 menusec">
                <?php //print_r($session = $this->session->userdata('user_data'));
                    $this->load->view('includes/header'); ?>
                
                <nav class="mainmenu">
                    <ul id="menu">
                        <li><a href="<?php echo base_url()?>mypannel">My Panel </a></li>
                  <li><a href="<?php echo base_url()?>campaign">My Campaigns 
                  <!-- <i class="fa fa-caret-down"></i> --></a>
                            <!-- <ul>    
                                <li><a href="#">item1</a></li>
                                <li><a href="#">item2</a></li>
                                <li><a href="#">item1</a></li>
                                <li><a href="#">item2</a></li>
                            </ul> -->
                        </li>
                      <li><a href="<?php echo base_url()?>ranking">Rankings</a></li>
                      <li><a href="<?php echo base_url()?>analysis">Analysis</a></li>
                      <li><a href="<?php echo base_url()?>networkmanager">Network Manager</a></li>
                      <li><a href="<?php echo base_url()?>scrapper">Submitter</a></li>
                      <li><a href="#">Reports</a></li>
                      <li><a href="#">Video Tutorials</a></li>
                  </ul>       
                </nav>
            </div>
        </div>
        
    </div>
    <div class="container add_margin">
      <div class="row">
          <div class="col-md-3 left-col pdgL">
            <div class="sidebar-container">
              <!-- SERP Avenger Package start -->
              <div class="sidebar-box-header">
                    <h2>SERP Avenger Package (3)</h2>
                </div>
                <!-- sidebar-box-content -->
                <div class="sidebar-box-content">
                  <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Gold Avenger (2)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <a href="" class="linktext">+ Add More or upgrade</a>
                    </ul><!-- section end -->
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Platinum Avenger (1)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <a href="" class="linktext">+ Add More or upgrade</a>
                    </ul><!-- section end -->
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Silver Avenger (0) </span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <a href="" class="linktext">+ Add More or upgrade</a>
                    </ul><!-- section end -->
                    
                 </div><!-- sidebar-box-content -->
              <!-- Active Campaigns start -->
              <div class="sidebar-box-header">
                    <h2>Active Campaigns (3)</h2>
                </div>
                <!-- sidebar-box-content -->
                <div class="sidebar-box-content">
                  <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Denver Locksmith (3)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <a href="" class="linktext">+ Add More</a>
                    </ul><!-- section end -->
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Weight Loss Book (3)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    </ul><!-- section end -->
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Hair Loss Client(3)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    </ul><!-- section end -->
                    
                 </div><!-- sidebar-box-content -->
                <!-- Active Networks start -->
                <div class="sidebar-box-header">
                    <h2>Active Networks (5)</h2>
                </div>
                <!-- sidebar-box-content -->
                <div class="sidebar-box-content">
                  <!-- section start -->
                    <ul class="acc-menu single-level" id="sidebar">
                      <li><a href="javascript:;">SERP Avenger  PR-Gold</a></li>
                        <li><a href="javascript:;">GoDaddy PR Network</a></li>
                        <li><a href="javascript:;">Aged Network</a></li>
                        <li><a href="javascript:;">Indexing Network</a> <span><a href="" class="linktext">+ Add More</a></span></li>
                    </ul>
                </div>
                
                <!-- Other Categories As Needed start -->
                <div class="sidebar-box-header">
                    <h2>Other Categories As Needed</h2>
                </div>
                <!-- sidebar-box-content -->
                <div class="sidebar-box-content">
                  <!-- section start -->
                    <ul class="acc-menu single-level" id="sidebar">
                      <li><a href="javascript:;">Car Rental</a></li>
                        <li><a href="javascript:;">Leasing</a></li>
                        <li><a href="javascript:;">Car Sales</a></li>
                        <li><a href="javascript:;">Autoshops/Garages</a></li>
                        <li><a href="javascript:;">GPS Rental</a>
                    </ul>
                </div>
                 
                </div>
            </div>
       
             <!-- right panel --> 
           <div class="col-md-9 pull-right add-border">
             
             <!-- Nav tabs -->
            <ul class="nav nav-tabs mytab">
             <li>
                  <a href="<?php echo base_url()?>index.php/scrapper">
                    <span class="new_sub"></span>
                    <span class="hed_tx">New Submission</span>
                    <span class="un_li_ne">Create New</span>
                    <span class="nor_li_te">Submission</span>
                   </a>
              </li>
              
              <li <?php if($page_title == "Active Submissions")  { echo "class=active";}?> >
                  <a href="<?php echo base_url()?>index.php/activesubmissions">
                    <span class="active_sub"></span>
                    <span class="hed_tx">Active Submissions</span>
                    <span class="view_li_ne">View/</span>
                    <span class="un_li_ne">Edit</span>
                    <span class="nor_li_te">Submission</span>
                   </a>
              </li>

              <li <?php if($page_title == "Completed Submissions")  { echo "class=active";}?>>
                  <a href="<?php echo base_url()?>index.php/completedsubmissions">
                    <span class="completed_sub"></span>
                    <span class="hed_tx">Completed Submissions</span>
                    <span class="view_li_ne">View or</span>
                    <span class="un_li_ne">Edit</span>
                    <span class="nor_li_te">Submission</span>
                   </a>
              </li>

             </ul>
            
            <!-- Tab panes -->
            <?php if($this->session->flashdata('message')) { 
              echo $this->session->flashdata('message'); } ?>
              
              <div class="tab-pane tab_con " id="act_sub">
                <p style="font-size:14px; margin-left:10px">List of campaigns created till date :</p>
                <div class="panel-body-tbl-onpage">
                  <?php if($page_title == "Active Submissions") $path = "activesubmissions"; else $path = "completedsubmissions"; ?>
                  <form name="frm1" action="<?php echo base_url().$path; ?>/article_update" method="post">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered listof-comp" style="display: table;" id="myTable">
                    <tbody><tr>
                        <th>Creation Date</th>
                        <th>Type</th>
                        <th>Project Name</th>
                        <th>Campaign</th>
                        <th>Articles</th>
                        <th>Pending</th>
                        <th><?php if($page_title == "Active Submissions"){ echo "Next Submission";  } 
                         else{  echo "Completed Date"; }?></th>
                        <th></th>
                        <th><img alt="no img" src="<?php echo base_url(); ?>assets/images/img18.png"></th>
                      </tr></tbody>
                      <?php //print_r ($active_posts);
                      //echo count($active_posts);
 $range = 10;
			 $start = 1;
			 $end = $range;
			 
			 if(isset($active_posts) && count($active_posts) > 0) {
			 if(isset($_GET['show'])) {

				  if($_GET['show'] == "all")
				  {
					 $end = count($active_posts);
				  }
				  else
				  {
						$end = $_GET['show'];
						$start = $end + 1;
						$end = $end + $range;
						
					  if($start > count($active_posts))
					   redirect('activesubmissions');
				  }
			}}
                      
if(count($active_posts)>0)
                      {  
                       foreach($active_posts as $active_post){
 if(count($active_posts) >= $start && count($active_posts) <= $end) { ?>


                      <tr>
                        <td><?php echo $active_post->post_date;?></td>
                        <td><?php echo $active_post->schedule;?></td>
                        <td><?php echo $active_post->project_name;?></td>
                        <td><?php echo $active_post->campaign;?></td>
                        <td><?php echo $active_post->count ;?></td>
                        <td><?php echo $active_post->campaign;?></td>
                        <td><?php echo $active_post->post_modified;?></td>
                        
                      <td class="varticle-btn">
                        
                            <a href="#" class="denvernew2" id="toggle_<?php echo $active_post->campaign_id;?>" title="<?php echo $active_post->campaign_id;?>">View Articles</a>

                            
                             <div class="table-responsive toggle_box arrowpopup arrowdata zindexauto" id="toggle_box_<?php echo $active_post->campaign_id;?>" style="display:none;">

                       
                            
                         
                            
                                <!-- <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover">
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
                                  </tr>
                                  <tr>
                                    <td><?php $dta[0]->ID ?></td>
                                    <td>7:13PM</td>
                                    <td>Pending</td>
                                    <td>How to hire a locksmith</td>
                                    <td>No</td>
                                    <td>Yes</td>
                                    <td>redbarrow.com</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#edit-articles" style="padding:0">Edit Articles</a>
                                            Edit network popup
                                            <div class="modal fade" id="edit-articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header popup-header">
                                                <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Edit Articles</h4>
                                              </div>
                                              <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="editart">
                                                      <tr>
                                                        <td width="8%">Title</td>
                                                        <td><input name="" type="text"></td>
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
                                                                    <textarea name="" cols="" rows="20" placeholder="Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham. "></textarea>
                                                                </div>
                                                            </div>
                                                        </td>
                                                      </tr>
                                                      </table>
                                                 </div>
                                                <div class="clearfix"></div>   
                                              </div>
                                              <div class="modal-footer popupfooter">
                                                <button class="btn btn-primary" type="button">Save</button>
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                              </div>
                                            </div>
                                            </div>
                                            </div>
                                    </td>
                                    <td><i class="fa fa-trash-o"></i></td>
                                  </tr>
                                  <tr>
                                    <td>May 15, 2014</td>
                                    <td>8:10AM</td>
                                    <td>Pending</td>
                                    <td>Where to Hire Locksmith</td>
                                    <td>Yes  15</td>
                                    <td>Yes</td>
                                    <td>conference209…</td>
                                    <td><a style="padding:0" href="#">Edit Articles</a></td>
                                    <td><i class="fa fa-trash-o"></i></td>
                                  </tr>
                                </table> -->
                                
                           </div></td>
                       
                       
                      
                        <td align="center"><a  onclick="return confirm('Are You sure?')" href="<?php echo base_url();?>index.php/activesubmissions/delete/<?php echo $active_post->campaign_id;?>"><i class="fa fa-trash-o"></i></a></td>
                      </tr> 
                      <?php } }}
                      else {
            echo  "<tr><td>";echo "<b>No data available in table</b>";echo "</td></tr>";
                        } ?>
                   <!--  <tr> 
                      <th>Creation Date</th>    
                       <th>Type</th>
                        <th>Project</th>
                        <th>Campaign</th>
                        <th>Articles</th>
                        <th>Pending</th>
                        <th>Next Submission</th>
                        <th></th>
                        <th></th></tr>
                        <tr>
                        <td>May 15, 2014 </td>
                        <td>New</td>
                        <td>Denever locksmith</td>
                        <td>Denverlock LLC</td>
                        <td>15</td>
                        <td>7</td>
                        <td>1 HR 32 Min 27 Seconds</td>
                        <td class="varticle-btn">
                          <a href="#" class="denvernew2">View Articles</a>
                            <div class="table-responsive arrowpopup zindexauto" id="newonetwo" style="position:absolute">
                            </tr>-->    
                   </table></form></div>
                              
                     
                <div class="pagination-row text-right">
              <div class="result-per-page">
                    <span>Results Per Page:</span>
                    <ul> 
                      <li><a href="javascript:void(0)" onClick="show_next(<?=$end; ?>)">10</a></li>  
                        <li><a href="#">100</a></li>  
                        <li><a href="javascript:void(0)" onClick="show_next('all')">All</a></li>
                    </ul>
                </div>
                <?php if(isset($links) && $links!='' ){ ?>
                <div class="pagination">
                    <?php echo $links; ?> Page <input name="page" type="text" value="<?php if(isset($current)) echo $current; ?>" readonly> of <?php if(isset($total)) echo $total; ?>
                </div>
                <? } ?>
            </div>
              </div>
                          </div>

             
             </div>   
          </div>
        </div>
        <script type="text/javascript">
       



       $(".denvernew2").click(function (){
    var id=$(this).attr("id");

   var title1=$(this).attr("title");
  // alert(id+" "+title1);
    var urll ="<?php echo base_url(); ?>index.php/activesubmissions/pop_up";
    var form_data = {title : title1,ajax : '1'};

 $.ajax({
        type: 'POST',
       async : false,
       data: form_data,
        url: urll, 

        
        success: function(data)
        { 
            // alert(data);
      $('#toggle_box_'+title1).html(data);
      // $( "#toggle_box_"+title1 ).removeAttr('style');
       
        }
        
        });
});
        </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
   
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/toggles-min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/toggles.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.verticalCarousel.min.js"></script>
    
    <script src="<?php echo base_url(); ?>js/jquery.slicknav.js"></script>
    
    <script type='text/javascript' src='<?php echo base_url(); ?>js/jquery.nicescroll.min.js'></script>
    <script type='text/javascript' src='<?php echo base_url(); ?>js/application.js'></script> 
    <script type='text/javascript' src='<?php echo base_url(); ?>js/jquery.cookie.js'></script> 
    
  <script type="text/javascript">
$(document).ready(function(){

    $('#myTable').dataTable();
});
    

  </script>
  </body>
</html>
