  
 <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet">
    
    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/responsive.css" media="screen" />
    <link rel="stylesheet" href="<?php echo FRONT_FONTCSS_PATH;?>font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
    
    <!-- font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    
<script type="text/javascript" src="<?php echo base_url();?>js/Chart.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.sparkline.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/analysis.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'> 
<script type="text/javascript">
    
    $(document).ready(function(){

    $("#your-id-name").verticalCarousel({nSlots: 3});
	
	<?php if(!$permission) { ?>
	var overlay = $('<div id="overlay"></div>');
	overlay.show();
	overlay.appendTo(document.body);
	$('.popup').show();
	<?php } ?> 
     
});

function DisData(id,rid) {
	
  //$('#ajaxresult').hide();
                $("#flash").show();
                $("#flash").fadeIn(400).html('<img src="ajax-loader.gif" align="absmiddle"> loading.....');

var form_data = {
id : +id,
rid : +rid,
ajax : '1'
};
   $.ajax({
         type: 'POST',
        async : false,
        data: form_data,
         url: '<?php echo base_url(); ?>index.php/analysis/showcontent/', 

         /* beforesend: function(){
            $('#ajaxresult1').hide();
            $('#ajaxresult').show();
        },*/
         success: function(data) 
         { 
            
          $('#ajaxresult1').html(data);
        //  $('#ajaxresult').hide();
          $('#ajaxresult1').removeAttr("style");
          //$('#testntwk').html(selectedText);

         }
         
         });
            
}
</script>
<script>
<!-- Edited by BEAS -->

function set_analysis_permission(permission_cost, permission_name, frm_id)
{
	 $.post("<?php echo base_url() ?>index.php/analysis/add_user_permissions", {name:permission_name, cost:permission_cost}, function(data){
			   
			  $('input[name=item_number]').val(data);
			   
			  $('#'+frm_id).submit();

               });
}
function set_keyword_val(keyword_cost, package_id, permission_name, frm_id)
{
	if($('#keyword_no').val() >= 5)
		{
		   var new_keyword_no = $('#keyword_no').val();
			
		    var total_cost = new_keyword_no*keyword_cost;
		   
		   $.post("<?php echo base_url() ?>index.php/networkmanager/add_user_permissions", {name:permission_name, cost:total_cost}, function(data){
	 
						 $('input[name=item_number]').val(data);
						 
						 $('input[name=a3]').val(total_cost);
	
	                     $('input[name=return]').val("http://serpavenger.com/serp_avenger/analysis/?custom="+package_id+"&keyword="+new_keyword_no);
						 
						 $('#'+frm_id).submit();
                    });
					
		}
		else
		{
		   alert('You must purchase a minimum of 5 keywords');
		}
}
</script>
<script>
function getXMLHTTP()
{
    var xmlhttp=null;
    try {
            xmlhttp=new XMLHttpRequest();
        }
        catch(e)
        {
            try {
                    xmlhttp=new ActiveXobject("Microsoft.XMLHTTP");
                }
                catch(e)
                {
                    try {
                            xmlhttp=new ActiveXObject("msxml2.XMLHTTP");
                        }
                        catch(e1)
                        {
                            xmlhttp=false;
                        }
                }
        }
        return xmlhttp;
}

//var strurl="ajax.php?cate="+cat;
var strurl="<?php echo base_url(); ?>analysis/showcontent?id="+id;
alert(strurl);
var req=getXMLHTTP();
</script>

<style type="text/css">
#overlay {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: #000;
filter:alpha(opacity=70);
-moz-opacity:0.7;
-khtml-opacity: 0.7;
opacity: 0.7 !important;
z-index: 100;
display: none;
}
.cnt223 a{
text-decoration: none;
}
.popup{
width: 100%;
margin: 0 auto;
display: none;
position: fixed;
z-index: 101;
}
.cnt223{
min-width: 600px;
width: 600px;
min-height: 150px;
margin: 100px auto;
background: #f3f3f3;
position: relative;
z-index: 103;
padding: 10px;
border-radius: 5px;
box-shadow: 0 2px 5px #000;
}
.cnt223 p{
clear: both;
color: #555555;
text-align: justify;
}
.cnt223 p a{
color: #d91900;
font-weight: bold;
}
.cnt223 .x{
float: right;
height: 35px;
left: 22px;
position: relative;
top: -25px;
width: 34px;
}
.cnt223 .x:hover{
cursor: pointer;
}
</style>

    <div class="container">
    	<div class="row" id="header">
        	<div class="col-md-3 left-col">
                <div id="logo"><a href="index.html"><img src="<?php echo FRONT_IMAGE_PATH;?>logo.png" width="214" height="84" alt=""></a></div>
        	</div>

            <div class="col-md-9 menusec right-col">
                <?php $this->load->view('includes/header'); ?>

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
    <div class="container">
        <div class="row pdglr">
            <div class="col-md-3 left-col">
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

        <?php if(!$permission){ ?>    
             
	 <!-- Added by beas  Making Pop up -->
	 <div class='popup'>
     <div class="modal-dialog cnt223">
      <div class="modal-content">
        <div class="modal-header popup-header">
          <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Upgrade Package</h4>
        </div>
        
          <h4>Please subscribe to get access to this section</h4>
             <table id="" width="" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive"> 
           <tr>
           <td>

<?php //$fcnt = 1;

$pckgarr = array();

foreach($packages as $row)
{
	$pckgarr[$row['analysis_upgrade_cost']] = array('package_id' => $row['package_id'], 
	'package_name' => $row['package_name'], 
	'analysis_upgrade_cost' => $row['analysis_upgrade_cost']);
}

ksort($pckgarr);

foreach($pckgarr as $row) { ?>

<!--<form name="_xclick" id="anls_permission"  action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">-->
<form name="_xclick" id="anls_permission" action="https://sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">

<!--<input type="hidden" name="cmd" value="_xclick">-->
<input type="hidden" name="cmd" value="_xclick-subscriptions">

<!--<input type="hidden" name="business" value="billing@rpautah.com">-->
<input type="hidden" name="business" value="abhrabeas@gmail.com">

<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="lc" value="US">

<!--<input type="hidden" name="no_note" value="1">-->
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="item_number">
<input type="hidden" name="item_name" value="<?=$row['package_name']; ?> - Analysis Permission">
<!--<input type="hidden" name="amount">-->
<input type="hidden" name="a3" value="<?php echo $row['analysis_upgrade_cost']; ?>">
<!--<input type="hidden" name="discount_rate">-->
<input type="hidden" name="p3" value="1">
<input type="hidden" name="t3" value="M">
<input type="hidden" name="src" value="1">
<input type="hidden" name="sra" value="1">
<input type='hidden' name='rm' value="0">
<input type="hidden" name="return" value="http://serpavenger.com/serp_avenger/analysis/?custom=<?=$row['package_id']; ?>">
<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribe_SM.gif:NonHostedGuest">
</form>

<br>
<input type="button" name="submit" value="UPGRADE NOW"
 onClick="set_analysis_permission('<?=$row['analysis_upgrade_cost']; ?>', '<?=$row['package_name']; ?> - Analysis Permission', 'anls_permission')">
<br>
 
<?php break; } ?>
            
      </td> 
      </tr>   
    </table>
      </div>
    </div>
    </div>
            
     <?php } ?>

            <div class="col-md-9 right-col">
            	<div class="row">
                	<div class="topfilterblock">
                    	<div class="topbreadcrumbarea">
                    	<ol class="breadcrumb topbreadcrumb">
                          <li><a href="#">www.locksmithdenvermetro.com</a></li>
                          <li>Denever</li>
                          <li class="active">Denever locksmith</li>
                        </ol>
                        </div>



                        	<div class="toprowfilter">
                                <div class="choose-campaign">
                                    <span>Choose campaign:</span> <div class="dropdown">
                                    <select id="campaign_list" name="campaign_list" class="dropdown-select">
                                     <?php
                if(is_array($campagin_keyword_list) && count($campagin_keyword_list) > 0){
                foreach($campagin_keyword_list as $row=>$data){
                   ?>
                   <optgroup label="<?php echo $row ?>"><?php echo $row ?></optgroup>
                 <?php  foreach($data as $index=>$sub_data){
                ?>
                <option value="<?php echo stripslashes($index);?>" <?php //if($cid == $sub_data){echo 'selected';}?>><?php echo stripslashes($sub_data);?></option>
                <?php
                   }

                }
                }
                ?>
                                    </select>
                                    </div>
                                </div>

                                <div class="filterby">
                                    <span>Filter By:</span> <div class="dropdown">
                                    <select id="campaign_server_engine" name="campaign_server_engine" class="dropdown-select">
                                    <option value="Google">Google</option>
                                    <option value="Yahoo">Yahoo</option>
                                    <option value="Bing">Bing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row" >
                	 <div class="top-10-results"> 

                     </div>   
					
                     <div class="top-10-ap">
                        <div class="inner-table anchor-profile-block">
                            <div class="panel-heading-tbl">
                                <h4>Anchor profile of Top10</h4>
                                <i class="fa fa-question query pull-right"></i>
                            </div>
                            <div class="clearfix"></div>
                            <div class="panel-body-tbl">
                            	<!--  Ap profile block start-->
                                <div class="progressdiv" id="match_keyword_box">

                                </div>
                                <!-- bottom-identification -->
                                <div class="bottom-identification">
                                	<ul>
                                    	<li><i class="blue fa fa-square"></i> Top3</li>
                                        <li><i class="grey fa fa-square"></i> Top10</li>
                                        <li><i class="lightblue fa fa-square"></i> My Site</li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                     </div>

                	<div class="clearfix"></div>
               	  <!-- SEO Snapshot -->

                	<div class="inner-table seo-snapshot">
                        <div class="panel-heading-tbl">

                            <h4>SEO Snapshot - <span>Top 10</span></h4>
                            <div class="data-filter pull-right">
                            	<span>Show Data For :</span>
                            	<ul class="pull-left">
                                	<li><a href="javascript:void()" id="top_ten_snape_shot" class="active">Top10</a></li>
                                    <li><a href="javascript:void()"  id="top_three_snape_shot">Top3</a></li>
                                    <li><a href="javascript:void()"  id="new_site_snape_shot">News Sites</a></li>
                                    <li><a href="javascript:void()"  id="recovery_snape_shot">Recovered</a></li>
                                    <li><a href="javascript:void()"  id="aged_snape_shot">Aged(1+Yr.)</a></li>
                                    <li><a href="javascript:void()"  id="long_term_snape_shot">Long Term</a></li>
                                    <li width="20%">&nbsp;<input type="hidden" value="top10" id="linkelement_search_type"></li>
                                </ul>
                                <i class="fa fa-question query"></i>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="panel-body-tbl">
                          <div class="seo-snapshot-box">
                            	<h2>Site Age <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>
                                <div id="contain-site-age">
                                <h3 id="site-age-heading">4 Months</h3>
                                <div class="mapArea">
                               <table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">
                        <tr>
                          <td>New: </td>
                          <td> 30%</td>
                          <td>&nbsp;</td>
                          <td id="grpNewSiteAge">
                              <!-- <img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt="">-->
                          </td>
                        </tr>
                        <tr>
                          <td>Young: </td>
                          <td>50%</td>
                          <td>&nbsp;</td>
                          <td id="grpYoungSiteAge">
                               <!--<img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt="">-->
                          </td>
                        </tr>
                        <tr>
                          <td>Old:  </td>
                          <td>20%</td>
                          <td>&nbsp;</td>
                          <td id="grpOldSiteAge">
                               <!--<img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt="">-->
                          </td>
                        </tr>
                        </table>
                                </div>
                            </div>
                                <div id="loader-site-age" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>

                            </div>

                            <div class="seo-snapshot-box">
                            	<h2>Site Size <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                                <div id="contain-site-page-count"></div>
                                    <div id="loader-site-page-count" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>

                            <div class="seo-snapshot-box">
                            	<h2>Page Content <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                                <div id="contain-site-word-count"></div>
                                 <div id="loader-site-word-count" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>

                                </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>


                            <div class="seo-snapshot-box">
                            	<h2>Keyword Ratio <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                                <div id="contain-site-kw-ratio"></div>
                                  <div id="loader-site-kw-ratio" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>

                            <div class="seo-snapshot-box">
                            	<h2>KW Optimization <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                                <div id="contain-site-kw-optimization"></div>
                                <div id="loader-site-kw-optimization" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>

                            <div class="seo-snapshot-box">
                            	<h2>Exact KW Anchors <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                               <div id="contain-site-exact-kw-anchor"></div>
                                 <div id="loader-site-exact-kw-anchor" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                    </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>

                            <div class="seo-snapshot-box">
                            	<h2>Hiding Links (301s) <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                                 <div id="contain-site-hiding-links"></div>
                              <div id="loader-site-hiding-links" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>

                            <div class="seo-snapshot-box">
                            	<h2>Social Signals <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                                <div id="contain-share-signal"></div>
                                  <div id="loader-share-signal" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>

                            <div class="seo-snapshot-box">
                            	<h2>External Links <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                                <div id="contain-site-external-links"></div>
                                 <div id="loader-site-external-links" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>

                            <div class="seo-snapshot-box">
                            	<h2>Freshness Score <span class="que-icon pull-right"><i class="fa fa-question query-blue"></i></span></h2>

                                <div class="table-statistics">
                                <div id="content-frace-ness"></div>
                                 <div id="loader-frace-ness" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </div>
                                <span class="avg-graph"><img src="<?php echo FRONT_IMAGE_PATH;?>graph2.gif" width="100" height="18" alt=""></span>
                            </div>

                        </div>
                    </div>

                    <!-- SERP Profile -->

                    <div class="inner-table serp-profile">
                        <div class="panel-heading-tbl">
                            <h4>SERP Profile</h4>
                            <i class="fa fa-question query pull-right"></i>
                        </div>
                        <div class="clearfix"></div>
                        <div class="panel-body-tbl">
                        	<div class="serp-profile-box">
                           	  <p>New/ Recovered Sites</p>
                            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <div id="content-new-site"></div>
                               <div id="loader-new-site" align="center" style="display: none;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </table>

                            </div>
                            <div class="serp-profile-box">
                            	<p>Authority/ Parasite</p>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <div id="content-rec-site"></div>
                                 <div id="loader-rec-site" align="center" style="display: none;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </table>
                            </div>
                            <div class="serp-profile-box">
                            	<p>Aged Sites (1 Year +)</p>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <div id="content-old-site"></div>
                               <div id="loader-old-site" align="center" style="display: none;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                            <div class="data-filter pull-left pdfTB10">
                            	<span>Show Data For :</span>
                            	<ul class="pull-left">
                                    <li><a href="#">New Sites</a></li>
                                    <li><a href="#">Authority/Parasite (2)</a></li>
                                    <li><a href="#">Aged(1+Yr.)</a></li>
                                    <li><a href="#">Long Term</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Long-Term Page one Rankings -->

                    <div class="inner-table one-page-ranking">
                        <div class="panel-heading-tbl">
                            <h4>Long-Term Page one Rankings</h4>
                            <i class="fa fa-question query pull-right"></i>
                        </div>
                        <div class="clearfix"></div>

                        <div id="content-long-term-site" class="panel-body-tbl"></div>
            <div id="loader-long-term-site" align="center" style="display: block;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>

                    </div>
               	 	</div>

                    <div class="clearfix"></div>


                    <!-- Onpage Elements -->
                    <div class="row">
                   <div class="inner-table seo-snapshot bordernull">
                        <div class="panel-heading-tbl">
                            <h4>Onpage Elements - <span>New sites</span></h4>
                            <div class="data-filter pull-right">
                                <span>Show Data For :</span>
                                <ul class="pull-left">
                                    <li id='new-site-link' class="active">News Sites</li>
                                    <li>Authority/Parasite (2)</li>
                                    <li id='aged-link'>Aged(1+Yr.)</li>
                                    <li id='long-tarm-link'>Long Term</li>
                                </ul>
                                <i class="fa fa-question query"></i>
                            </div>
                        </div>
                        </div>
                        <!-- 
                        <div class="panel-body-tbl-onpage">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered">
                              <tr>
                                <td width="25%">&nbsp;</td>
                                <td>Title  URL</td>
                                <td>Descr </td>
                                <td>H1 H2</td>
                                <td>Above Fold</td>
                                <td>Image</td>
                                <td>Words</td>
                                <td>Min/ Max KW%</td>
                                <td>Min/ MaxExt Link</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>100% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""></td>
                                <td>40% <img src="<?php echo FRONT_IMAGE_PATH;?>red-arrow.png" alt=""></td>
                                <td>80% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> 50%</td>
                                <td>10% <img src="<?php echo FRONT_IMAGE_PATH;?>red-arrow.png" alt=""> 75%</td>
                                <td>10% <img src="<?php echo FRONT_IMAGE_PATH;?>red-arrow.png" alt=""></td>
                                <td>429 <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> 52/</td>
                                <td>15282.5% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> 0%</td>
                                <td>/8%60% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> (3)</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>100% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""></td>
                                <td>40% <img src="<?php echo FRONT_IMAGE_PATH;?>red-arrow.png" alt=""></td>
                                <td>80% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> 50%</td>
                                <td>10% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> 75% <img src="<?php echo FRONT_IMAGE_PATH;?>red-arrow.png" alt=""> </td>
                                <td>10% <img src="<?php echo FRONT_IMAGE_PATH;?>red-arrow.png" alt=""></td>
                                <td>429 <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> 52/</td>
                                <td>15282.5% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> 0%</td>
                                <td>/8%60% <img src="<?php echo FRONT_IMAGE_PATH;?>green-arrow.png" alt=""> (3)</td>
                              </tr>
                            </table>
                        </div>
                    </div>-->
                  <div class="onpage nw-add-cls">

            <div class='onpage-element-box' id="new-site-onpage-content"></div>
            <div class='onpage-element-box' id='long-tarm-onpage-content'></div>
            <div class='onpage-element-box' id='old-site-onpage-content'></div>

                </div>
				
				</div>

				<div class="clearfix"></div>

                    <!--  Link Element -->
               <div class="row">
                  <div class="inner-table seo-snapshot">
                        <div class="panel-heading-tbl">
                            <h4>Link Elements - <span>New sites</span></h4>
                            <div class="data-filter pull-right">
                                <span>Show Data For :</span>
                                <ul class="pull-left">
                                    <li><a id="linkelement_newsite" href="javascript:void(0);">News Sites</a></li>
                                    <li><a href="#">Authority/Parasite (2)</a></li>
                                    <li><a id="linkelement_aged1yr" href="javascript:void(0);">Aged(1+Yr.)</a></li>
                                    <li><a id="linkelement_longterm" href="javascript:void(0);">Long Term</a></li>
                                </ul>
                                <i class="fa fa-question query"></i>
                            </div>
                        </div>
                        <div id="contain-link-element" class="element leblock">
                  <!--<img src="<?php echo FRONT_IMAGE_PATH;?>link_element.jpg" alt="">-->
          <div id="canvas301Redirect" class="carveBox"></div>
          <div id="canvasFollow" class="carveBox"></div>
          <div id="canvasSiteWide" class="carveBox"></div>
          <div id="canvasTextImage" class="carveBox"></div>
                </div><div class="clearfix"></div>
        <div id="loader-link-element" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div>
            	</div></div>
                </li>
                
        </div>
          <script type="text/javascript">
   $(document).ready(function(){
 
       $("#ajaxresult1").hide();
        $(".main_image").show();
// alert('testing');
   $("#image1").click(function(){// alert('dfgdsd');
        // $("#ajaxresult").hide();
        $(".main_image").hide();
   // $("#ajaxresult1").slideToggle();
    //return false;
    });
 
});
    </script>
    <script type="text/javascript">
     $(document).ready(function(){
        $('#btn-search').click(function(){
            var search_keyword = $('#search_keyword').val();
            var search_url = $('#search_url').val();
            var server_engine = $('#campaign_server_engine').val();
            if (search_keyword != '' && search_url != '') {
                var dataString = 'search_keyword=' + encodeURIComponent(search_keyword) + '&search_url=' + encodeURIComponent(search_url) + '&server_engine=' + encodeURIComponent(server_engine);
                alert(dataString);
                $.ajax({
                    type: 'post',
                    url: '<?php echo FRONT_URL;?>renderanalysis/secrawl',
                    data: dataString,
                    beforeSend: function(){

                    },
                    success: function(data){

                    }
                });
            }else{
                alert("Enter keyword, URl both!");
                return false;
            }
        });
    });
    </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins)
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.verticalCarousel.min.js"></script>
   
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
	<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
   
    <script src="<?php echo base_url();?>js/jquery.slicknav.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/application.js"></script> 
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.cookie.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<!--<script src="<?php echo FRONT_JS_PATH;?>bootstrap.min.js"></script>-->





