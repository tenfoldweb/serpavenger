<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $page_title;?></title>

<!-- Bootstrap -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- REVOLUTION BANNER CSS SETTINGS -->
<link rel="stylesheet" href="../css/main.css" media="screen" />
<link rel="stylesheet" href="../css/responsive.css" media="screen" />
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/animate.css">
<link rel="stylesheet" href="../css/toggles.css">
<link rel="stylesheet" href="../css/form.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script type="text/javascript" src="../assets/js/tinymce/tinymce.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script type="text/javascript" src="../assets/js/main.js"></script>
<script>
var tooltipCount=1;
function sliders(id,min_val,max_val,input_id,first_value, idPrefix) {
//var first_value=0;
console.log(idPrefix === undefined);
if(idPrefix === undefined){
idPrefix=1;
}
$('#tooltip'+tooltipCount).remove();
$( "input#"+input_id ).val('');
var tooltip = $('<div id="tooltip'+idPrefix+id+'" class="tooltip">'+first_value+'</div>').css({
position: 'absolute',
top: -19,
left: -7
}).show();

//$(".rslider"+id).slider({
$("#"+idPrefix+id).slider({
animate: true,
range: "min",
value: $('input#'+input_id).val(),
min: min_val, //0
max: max_val, //68
slide: function(event, ui) {
//  updateSliderValue("rslider");

tooltip.text(ui.value);
$( "input#"+input_id ).html( ui.value );
},
change: function(event, ui) {
$('input#'+input_id).attr('value', ui.value);}
}).find(".ui-slider-handle").append(tooltip);
tooltipCount++;
}

function slidersFooter(id,min_val,max_val,input_id,first_value) {
//var first_value=0;

$('#tooltip'+id).remove();
$( "input#"+input_id ).val('');
var tooltip = $('<div id="tooltip'+id+'">'+first_value+'</div>').css({
position: 'absolute',
top: -19,
left: -7
}).show();

//$(".rslider"+id).slider({
$(".rslider"+id).slider({
animate: true,
range: "min",
value: $('input#'+input_id).val(),
min: min_val, //0
max: max_val, //68
slide: function(event, ui) {
//updateSliderValue("rslider")
tooltip.text(ui.value);
$( "input#"+input_id ).html( ui.value );
},
change: function(event, ui) {
$('input#'+input_id).attr('value', ui.value);}
}).find(".ui-slider-handle").append(tooltip);
}

function updateSliderValue(m){
var h=$('.'+m+1).text();
console.log("ccc >> "+h);
}
function slidersold(id,min_val,max_val,input_id,first_value, idPrefix) {
//var first_value=0;
console.log(idPrefix === undefined);
if(idPrefix === undefined){
idPrefix=1;
}
$('#tooltip'+tooltipCount).remove();
$( "input#"+input_id ).val('');
var tooltip = $('<div id="tooltip'+tooltipCount+'">'+first_value+'</div>').css({
position: 'absolute',
top: -19,
left: -7
}).show();


$("#"+idPrefix+id).slider({
animate: true,
range: "min",
value: $('input#'+input_id).val(),
min: min_val, //0
max: max_val, //68
slide: function(event, ui) {
//  updateSliderValue("rslider");

tooltip.text(ui.value);
$( "input#"+input_id ).html( ui.value );
},
change: function(event, ui) {
$('input#'+input_id).attr('value', ui.value);}
}).find(".ui-slider-handle").append(tooltip);
tooltipCount++;
}
</script>
<style>

#spin_area_manually span {
    color: #878787;
    float: right;
    font-size: 12px;
    font-style: italic;
    padding: 2px 0 2px 25px;
}
.usamc-blk{ width: 100%}

.usamc-blk b {
    clear: both;
    color: #5C5C5C;
    float: left;
    margin: 10px 0;
    width: 100%;
}
.usamc-blk p {
    line-height: 16px;
    margin: 0;
    padding-bottom: 20px;
}
.usamc-blk input{
    width: 100%;
}
.link_anchor {
    background: none repeat scroll 0 0 #265691;
    border-radius: 3px 3px 3px 3px;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    margin: 0 0 5px;
    padding: 10px;
}
.styled {
    clip: rect(0px, 0px, 0px, 0px) !important;
    height: 10px !important;
    margin: 7px !important;
    padding: 10px !important;
    width: 10px !important;
}

.file-upload input.upload {
    cursor: pointer;
    font-size: 20px;
    margin: 0;
    opacity: 0;
    padding: 0;
    position: absolute;
    right: 0;
    top: 0;
} 
.btn-default {
    background: linear-gradient(to bottom, #FEFEFE 5%, #DCDCDC 100%) repeat scroll 0 0 #FEFEFE;
    border: 1px solid #C7C7C7;
    border-radius: 6px 6px 6px 6px;
    font-size: 14px;
    padding: 5px 10px;
}
.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open .dropdown-toggle.btn-default {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0)!important;
} 
 
/*.btn {
     
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857;
    padding: 6px 12px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}*/
.file-upload {
    
    overflow: hidden;
    position: relative;
}
.tooltip:after, .tooltip:before {
    border: medium solid rgba(0, 0, 0, 0);
    bottom: 100%;
    content: " ";
    height: 0;
    pointer-events: none;
    position: absolute;
    width: 0;
}
.tooltip:after, .tooltip:before {
    border: medium solid rgba(0, 0, 0, 0);
    bottom: 100%;
    content: " ";
    height: 0;
    pointer-events: none;
    position: absolute;
    width: 0;
}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('.sp-btns').hide();
        $('.comment-seeding-options').hide();
        $('#collapseinOne').show();
        $('#collapseinTwo').show();
        $('#serpcommone .toggle-on').click(function(){
                //alert('off');
                $(".sp-btns").hide();
                $('.comment-seeding-options').hide();
        });
        $('#serpcomm .toggle-off').click(function(){

                $(".sp-btns").show();
                $('.comment-seeding-options').show();
        });
        $('#serpcomm .toggle-on').click(function(){

                $(".sp-btns").hide();
                $('.comment-seeding-options').hide();
        });

        $('#lonkanc').click(function(){    //alert('sdggsg1');
                  $('#collapseinOne').toggle();
        });
        $('#scheset').click(function(){      // alert('sdggsg2');
               $('#collapseinTwo').toggle();
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
<div id="path_url" style="display:none;"><?php echo base_url().'index.php' ?></div>
<div class="container">
<div class="row" id="header">
<div class="col-md-3">
<div id="logo"><a href="index.html"><img src="../images/logo.png" width="214" height="84" alt=""></a></div>
</div>

<div class="col-md-9 menusec">
<div class="btn-group pull-right user-title">

 <button type="button" class="btn btn-default dropdown-toggle user-btn" data-toggle="dropdown">
    Welcome, <span>Bryan</span>
    <span class="caret"></span>
</button>
<ul class="dropdown-menu">
    <li><a href="#"><i class="fa fa-user"></i> My Profile</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="divider"></li>
    <li><a href="#"><i class="fa fa-sign-out"></i> Logout</a></li>
</ul>
</div>

<nav class="mainmenu">
<ul id="menu">
    <li><a href="#">My Panel </a></li>
<li><a href="#">My Campaigns <i class="fa fa-caret-down"></i></a>
        <ul>
            <li><a href="#">item1</a></li>
            <li><a href="#">item2</a></li>
            <li><a href="#">item1</a></li>
            <li><a href="#">item2</a></li>
        </ul>
    </li>
  <li><a href="#">Rankings</a></li>
  <li><a href="#">Analysis</a></li>
  <li><a href="#">Network Manager</a></li>
  <li><a href="#">Content</a></li>
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
<li class="active">
<a href="#new_sub" data-toggle="tab">
<span class="new_sub"></span>
<span class="hed_tx">New Submission</span>
<span class="un_li_ne">Create New</span>
<span class="nor_li_te">Submission</span>
</a>
</li>

<li>
<a href="<?php echo base_url()?>index.php/activesubmissions">
<span class="active_sub"></span>
<span class="hed_tx">Active Submissions</span>
<span class="view_li_ne">View/</span>
<span class="un_li_ne">Edit</span>
<span class="nor_li_te">Submission</span>
</a>
</li>

<li>
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
<?php

//lets have the flashdata overright "$message" if it exists
if($this->session->flashdata('message'))
{
$message    = $this->session->flashdata('message');
}

if($this->session->flashdata('error'))
{
$error  = $this->session->flashdata('error');
}

if(function_exists('validation_errors') && validation_errors() != '')
{
$error  = validation_errors();
}
?>
<?php if (!empty($message)): ?>

<?php //echo $message; ?>

<?php endif; ?>

<?php if (!empty($error)): ?>

<div class="notification note-error">
<a title="Close notification" class="close" href="#">close</a>
<?php echo $error; ?>
</div>

<?php endif; ?>

<?php if ($this->session->flashdata('message')):?>
<?php echo $this->session->flashdata('message');?>
<?php endif;?>
<form name="" method="post" action="<?php echo base_url()?>index.php/scrapper/form" enctype="multipart/form-data">
<input type="hidden" name="min_qty1" id="min_qty1" value="1">
<input type="hidden" name="min_qty_rr1" id="min_qty_rr1" value="1">
<input type="hidden" name="min_qty_rrr1" id="min_qty_rrr1" value="1">
<input type="hidden" name="serp_comm" id="serp_comm" value="">
<div class="submitter_inner">
<div class="tab-content">

<div class="tab-pane active tab_con" id="new_sub">
	<div class="table-responsive">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table tblheadlft">
      <tr>
        <th width="25%"><img src="../images/networks.png" width="20" height="20" alt=""> <strong>Select Network(s) to Post to:</strong></th>
        <td>
        	<div class="dropdown">
                <div class="part1 clearfix">
        <p></p>
        <p style="width: 152px; height: 11px;">0 Domains Selected</p>
        <div class="toggle_arrow"></div>
    </div>

            </div>
            <div class="greybg">
            	<input type="checkbox" id="select_all" name="selectAll" value="" class="styled"/><img src="../images/pic7.png" width="12" height="16" alt=""><span>SERP Avenger PR Network</span>
            </div>
            <div class="serpAPRN" id="chk_box1">
            	<ul>
                     <?php foreach($networks as $network){?>
                    <li>

            <div class="serpAPRN"><input type="checkbox" name="networks[]" value="<?php echo $network->id;?>" class="styled"/><span><?php echo $network->network_name;?></span></div>

                     </li>
                      <?php } ?>

                	<!--<li>
                    	<input type="checkbox" checked="checked" id="gprn" class="css-checkbox">
                		<label class="label-chkbx lite-gray-check" name="checkbox1_lbl" for="gprn">General PR Network</label>
                    </li>
                    <li>
                    	<input type="checkbox" checked="checked" id="lcc" class="css-checkbox">
                		<label class="label-chkbx lite-gray-check" name="checkbox1_lbl" for="lcc">Local California Clients </label>
                    </li>
                    <li>
                    	<input type="checkbox" checked="checked" id="bing-ONLY-network" class="css-checkbox">
                		<label class="label-chkbx lite-gray-check" name="checkbox1_lbl" for="bing-ONLY-network">Bing ONLY Network</label>
                    </li>
                    <li>
                    	<input type="checkbox" checked="checked" id="denver-lock-network" class="css-checkbox">
                		<label class="label-chkbx lite-gray-check" name="checkbox1_lbl" for="denver-lock-network">Denver Lock Network</label>
                    </li>
                    <li>
                    	<input type="checkbox" checked="checked" id="high-PR-etwork" class="css-checkbox">
                		<label class="label-chkbx lite-gray-check" name="checkbox1_lbl" for="high-PR-etwork">5+ High PR Network</label>
                    </li>
                    <li>
                    	<input type="checkbox" checked="checked" id="aged-network" class="css-checkbox">
                		<label class="label-chkbx lite-gray-check" name="checkbox1_lbl" for="aged-network">Aged Network</label>
                    </li>
                    <li>
                    	<input type="checkbox" checked="checked" id="indexer-network" class="css-checkbox">
                		<label class="label-chkbx lite-gray-check" name="checkbox1_lbl" for="indexer-network">Indexer Network</label>
                    </li>
                    <li>
                    	<input type="checkbox" checked="checked" id="radio-works-network" class="css-checkbox">
                		<label class="label-chkbx lite-gray-check" name="checkbox1_lbl" for="radio-works-network">Radio Works Network</label>
                    </li>-->
                </ul>
            </div>
         </td>
      </tr>
      <tr>
        <th><img src="../images/pic8.png" width="14" height="14" alt=""> <strong>Save Project as:</strong></th>
        <td>
        	<div class="pull-left"><input name="project_name" type="text" placeholder="Save As (Name this project)"></div>
            <div class="dropdown mgr-left">
                <select id="selectnetwork" name="selectnetwork" class="dropdown-select">
                    <option value="1">Attach to the campaign</option>
                    <?php
                    if(is_array($campaign_list) && count($campaign_list) > 0){
                        for($i=0; $i<count($campaign_list); $i++){
                    ?>
                            <option value="<?php echo stripslashes($campaign_list[$i]['campaign_id']);?>" <?php if($cid == $campaign_list[$i]['campaign_id']){echo 'selected';}?>><?php echo stripslashes($campaign_list[$i]['campaign_title']);?></option>
                    <?php
                            if(is_array($campaign_list[$i]['campaign']) && count($campaign_list[$i]['campaign']) > 0){
                                for($j=0; $j<count($campaign_list[$i]['campaign']); $j++){

                                if(isset($campaign_list[$i]['campaign'][$j]['keyword'])) { ?>
                                    <option value="<?php echo $campaign_list[$i]['campaign'][$j]['keyword_id'] . '-' . $campaign_list[$i]['campaign'][$j]['campaign_id'];?>"><?php echo '----' . stripslashes($campaign_list[$i]['campaign'][$j]['keyword']); ?></option>
                    <?php }}}}} ?>
                </select>
            </div>
            <span class="tagopt">(Optional)</span>
        </td>
      </tr>
      <tr>
        <th><img src="../images/pic9.png" alt=""> <strong>Post / Article Submission:</strong></th>
        <td>
        	<div class="articlecub">
            	<div class="col-md-6">
                	<div class="row" id="right">
                    	<input type="checkbox" name="spin_type[]" checked="checked" value="manually"><span>Manually Add Content Below</span><span class="textigrey">  (Spintax accepted)</span><br/>
                <span class="textigrey">Accepted Spintax format: {Spintax|Spin|Spinning}</span>
                    </div>
                </div>
                <div class="col-md-6" >
                	<div class="row" id="left">
                        <input type="checkbox" name="spin_type[]" value="smart_content"><img src="../images/pic7.png" width="12" height="16" alt=""><span>Use SERP Avenger Smart Content!</span><span class="textigrey">(Unique & Relevant)</span></br>
                <span class="textigrey">Take a break; we’ll create the content for you.</span>

                    </div>
                </div>
            </div>

            <div class="form_area" id="spin_area_manually">
            	<p>
                    <label>Title:</label><span id="valid-title">Correct Spintax Detected</span>
                    <input type="text" name="post_title" id="valid-title">

                </p>

            	<p>
                    <label>Post:</label><span id="valid-post">Correct Spintax Detected</span>
                    <textarea name="post_content" cols="" rows="10" id="valid-post"></textarea>

                </p>

                 <p>
                    <label># of submissions:</label>
                    <input class="small" type="text" name="submission_num">
                </p>


            </div>


             <div id="spin_area_smart" class="usamc-blk" style="display:none;">
        <p>Ok, great in order to create content we will need some information about your project and subject matter.</p>
        <div class="form_area">
            <div class="link_anchor">SERP Avenger Smart Content <i class="fa fa-question query pull-right"></i><span class="help"><img  src="<?php echo base_url()?>assets/images/img2.png"></span></div>
            <b>Help us learn more about the type of content needed for this project by answering the following: </b>
            <b>What are the General Topics or Categories?</b>
            <p>IE: Weight loss, diet, exercise, nutrition, etc.</p>
            <input type="text" name="smart_content_topics" value="" placeholder="Enter several generic relevant topics. (Separated by commas)">
            <b>What specific keywords will be used as anchors?</b>
            <p>IE: acai berry, acai berry diet,  buy acai berries, etc.</p>
            <input type="text" name="smart_content_keywords" value="" placeholder="Enter your exact keywords or phrases. (separated by commas)">
            <b>List any synonyms that could be used be replaced by your keywords.</b>
            <p>IE: diet pills, antioxidant, purple fruit, anthocyanins, superfoods, etc.</p>
            <input type="text" name="smart_content_synonyms" value="" placeholder="Enter as many synonyms that could be substituted by your keywords  (separated by commas)">



        </div>
        </div>

        </td>

        </div>
      <tr class="SERP-avenger">
        <th></th>
        <td>
        	<div class="articlecub">
            	<div class="col-md-6"  id="serpcommone" style="width:44%">
                    <div class="on_off">
                        <div class="toggle-light examples serp_formats">
                            <div class="toggle on">
                                <div class="toggle-slide">
                                    <div class="toggle-inner">
                                        <div id="test1" class="toggle-on active">ON</div>
                                        <div  class="toggle-blob"></div>
                                        <div id="test2" class="toggle-off">OFF</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img src="../images/pic7.png" width="12" height="16" alt="">
                        <label>SERP Avenger Professional Formatting</label> <span class="textigrey" style="display:block"><i style="color:#777777;">Formats post to use: sub-headlines, bullet points, bold, italics, etc. <i class="fa fa-question query"></i></i></span>
                        <!--<a href="" class="seereq">See Requirements</a>-->
                    </div>
                </div>
                <div class="col-md-6" id="serpcomm" style="width:56%">
                    <div class="on_off">
                    <div class="toggle-light examples serp_formats">
                        <div class="toggle">
                            <div class="toggle-slide">
                                <div class="toggle-inner">
                                    <div class="toggle-on active">ON</div>
                                    <div  class="toggle-blob"></div>
                                    <div class="toggle-off">OFF</div>
                                </div>
                            </div>
                        </div><input type="hidden" name="serp_comment" id="serp_comment" value="off">
                    </div>
                    <img src="../images/pic7.png" width="12" height="16" alt="">
                    <label>SERP Avenger Comment Seeding</label> </i><br><span class="textigrey"><i style="color:#777777;">Blog+ Options ie72 Avenger Blogs Available for this submission <i class="fa fa-question query"></i></i></span>
                    <div class="clearfix"></div>

                    <div  class="comment-seeding-options">
                        <ul>
                        <li>
                            <input type="radio" name="comment_seeding" id="radio-1-2" value="Blended" class="css-checkbox">
                            <label for="radio-1-2" class="css-label radGroup1"> Blended: Used both types of comment seeding.</label>
                        </li>
                        <li>
                            <input type="radio" name="comment_seeding" id="radio-1-4" value="Viral" class="css-checkbox">
                            <label for="radio-1-4" class="css-label radGroup1">Viral Post: Most comments added while on homepage.</label>
                        </li>
                        <li>
                            <input type="radio" name="comment_seeding" id="radio-1-5" value="Natural" class="css-checkbox">
                            <label for="radio-1-5" class="css-label radGroup1">Natural Post: Comments spaced out over time.</label>
                        </li>
                  </ul>
                  </div>
                  <!-- <div class="sp-btns">
                  	<button data-dismiss="modal" id="uploadBtn" name="comment_file" type="file">Upload comment file</button>
                    <span class="or">OR</span>
                    <button class="btn btn-primary" type="button">Create Unique Comments for me</button>
        			<a href="" class="seereq">See Requirements</a>
                  </div>
                   -->
                   <div class="sp-btns">
                    <!-- <button data-dismiss="modal" class="btn btn-default" type="button">Upload comment file</button>
                    <span class="or">OR</span> -->
                    <div class="input_file file-upload btn btn-default"><span>Upload Comment File</span><br> <input class="upload" id="uploadBtn" name="comment_file" type="file">
                    </div>
                    <span class="or">OR</span>
                    <input type="checkbox" value="yes" name="unique_comments"><button class="btn btn-primary" type="button">Create Unique Comments for me</button><div id="unique_key"></div>
                    <a href="" class="seereq">See Requirements</a>
                  </div>
                </div>
            </div>
        </td>
      </tr>
    </table>

    <div class="panel-body">
		<div id="accordioninpanel" class="accordion-group">
			<div class="accordion-item">
				<a class="accordion-title" data-toggle="collapse" data-parent="#accordioninpanel" href="#collapseinOne"><span id="lonkanc"><h4>Links & Anchors</h4></span></a>
				<div id="collapseinOne" class="collapse">
					<div class="accordion-body">
                    	<div class="table-responsive">
                         <div class="part6 second-anchor"> 
                                <h4 class="no1">How Should Links be Added to Your Posts?</h4>

                                <div class="part6_2">

                                    <div class="button-holder clearfix">

                                       <!-- <input type="radio" id="radio-1-6" name="link_identifier" class="regular-radio" checked /><label for="radio-1-6"></label>-->
                                        <input type="checkbox" checked="" class="regular-checkbox" name="link_identifier" id="checkbox-1-6"><label for="checkbox-1-6"></label>

                                        <span><b>Link Identifiers:</b> I have link identifiers in my content.  (Up to 3 per post:  %link1%   %link2%  %link3%) </span>

                                    </div>

                                    <div class="chkbox1 clearfix">

                                        <input type="checkbox" name="keyword_replace" class="regular-checkbox" id="checkbox-1-3"><label for="checkbox-1-3"></label>

                                        <span><b>Keyword Replace:</b> Find and replacekeywords or synonyms</span>

                                    </div>
                                    <a class="see" href="#">See Requirements</a>
                                </div>
                                <h4 class="no2">What Anchors Should Be Used?</h4>
                                <div id="table1">
                                <table id="r">
                                <tbody>
                                  <tr><td>
                                        <div class="part6_3 clearfix">
                                            <div class="anchor"><img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/pic24.png"></div>
                                            <label>Anchor 1a:</label>
                                            <div class="part6_5 clearfix">
                                                <div class="chkbox3 clearfix">
                                                    <input type="radio" value="Keyword" name="anchor_set1"><span>Keyword</span>
                                                    <input type="radio" value="Brand" name="anchor_set1"><span>Brand</span>
                                                    <input type="radio" value="Raw URL" name="anchor_set1"><span>Raw URL</span>
                                                    <input type="radio" value="Generic" name="anchor_set1"><span>Generic</span>
                                                </div>
                                             </div>
                                             <span class="help"><img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/img2.png"></span>
                                             <span class="qty">Quantity</span>
                                             <div class="rating"><!--<img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/pic25.png">-->
                                             <div class="change_color">
                                                  <div style="padding:13px 0 0 0;" class="range_slider">
                                                   <div id="r1" style="width:100px; margin:2px 0 0 0;" class="rslider1"></div>
                                                       <input type="hidden" name="qty1" value="0" id="qty1">
                                                   </div> 
                                                  </div>
                                             </div>
                                            
                                             
                                             </div>
                                        
                                            
                                        <div class="part6_4">
                                            <input type="text" placeholder="Enter Anchor (Spintax Accepted)" value="" name="anchor1">
                                            
                                            <div style="display:none;" class="help_box2 clearfix">
                                            <h4 class="no2">Please provied All synonyms That Could be replaced by your keyword.(Optional):</h4>
                                            <input type="text" placeholder="Enter synonyms or words that could be replaced by your keyword anchors. (I.E. hair loss, rogain, baldness)" value="" name="synonyms[]">
                                            </div>
                                            
                                            
                                            <h4 class="no3">Link/ URL 1a:</h4>
                                            <input type="text" placeholder="Enter URL including http://" value="" name="link1">                                   
                                         </div>
                                         <!--<div class="every_remove"><a href="javascript:void(0)">- Remove</a></div>-->
                                   </td></tr>
                                   </tbody>
                                   </table>
                                   
                                <div class="part5_2 clearfix">
                                    <a id="add_anchor1" href="javascript:void(0)">+ New Anchor/ Link</a><a id="second_anchor" href="javascript:void(0)">+ Second Anchor/ Link to Same Post</a>
                                    <span>Correct Spintax Detected</span>
                                </div>
                                </div>

                                <div style="display:none;" id="table2">
                                <table id="rr">
                                <tbody>
                                  <tr><td>
                                        <div class="part6_3 clearfix">
                                            <div class="anchor"><img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/pic24.png"></div>
                                            <label>Anchor 2a:</label>
                                            <div class="part6_5 clearfix">
                                                <div class="chkbox3 clearfix">
                                                    <input type="radio" value="Keyword" name="anchor_set_rr1"><span>Keyword</span>
                                                    <input type="radio" value="Brand" name="anchor_set_rr1"><span>Brand</span>
                                                    <input type="radio" value="Raw URL" name="anchor_set_rr1"><span>Raw URL</span>
                                                    <input type="radio" value="Generic" name="anchor_set_rr1"><span>Generic</span>
                                                </div>
                                             </div>
                                             <span class="help"><img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/img2.png"></span>
                                             <span class="qty">Quantity</span>
                                             <div class="rating"><!--<img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/pic25.png">-->
                                             <div class="change_color">
                                                  <div style="padding:13px 0 0 0;" class="range_slider">
                                                   <div id="rr1" style="width:100px; margin:2px 0 0 0;" class="rslider1"></div>
                                                       <input type="hidden" name="qty_rr1" value="0" id="qty_rr1">
                                                   </div> 
                                                  </div>
                                             </div>
                                             </div>
                                        
                                            
                                        <div class="part6_4">
                                            <input type="text" placeholder="Enter Anchor (Spintax Accepted)" value="" name="anchor_rr1">
                                            
                                            <div style="display:none;" class="help_box2 clearfix">
                                            <h4 class="no2">Please provied All synonyms That Could be replaced by your keyword.(Optional):</h4>
                                            <input type="text" placeholder="Enter synonyms or words that could be replaced by your keyword anchors. (I.E. hair loss, rogain, baldness)" value="" name="synonyms_rr[]">
                                            </div>
                                            
                                            
                                            <h4 class="no3">Link/ URL 2a:</h4>
                                            <input type="text" placeholder="Enter URL including http://" value="" name="link_rr1">                                   
                                         </div>
                                         <!--<div class="every_remove"><a href="javascript:void(0)">- Remove</a></div>-->
                                   </td></tr>
                                   </tbody>
                                   </table>
                                   <div class="part5_2 clearfix">
                                    <a id="add_anchor2" href="javascript:void(0)">+ New Anchor/ Link</a><a id="third_anchor" href="javascript:void(0)">+ Third Anchor/ Link to Same Post</a>
                                    <span>Correct Spintax Detected</span>
                                </div>
                               </div>

                                <div style="display:none;" id="table3">
                                <table id="rrr">
                                <tbody>
                                  <tr><td>
                                        <div class="part6_3 clearfix">
                                            <div class="anchor"><img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/pic24.png"></div>
                                            <label>Anchor 3a:</label>
                                            <div class="part6_5 clearfix">
                                                <div class="chkbox3 clearfix">
                                                    <input type="radio" value="Keyword" name="anchor_set_rrr1"><span>Keyword</span>
                                                    <input type="radio" value="Brand" name="anchor_set_rrr1"><span>Brand</span>
                                                    <input type="radio" value="Raw URL" name="anchor_set_rrr1"><span>Raw URL</span>
                                                    <input type="radio" value="Generic" name="anchor_set_rrr1"><span>Generic</span>
                                                </div>
                                             </div>
                                             <span class="help"><img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/img2.png"></span>
                                             <span class="qty">Quantity</span>
                                             <div class="rating"><!--<img alt="no img" src="http://serpavenger.com/serp_avenger/assets/images/pic25.png">-->
                                             <div class="change_color">
                                                  <div style="padding:13px 0 0 0;" class="range_slider">
                                                   <div id="rrr1" style="width:100px; margin:2px 0 0 0;" class="rslider1"></div>
                                                       <input type="hidden" name="qty_rrr1" value="0" id="qty_rrr1">
                                                   </div> 
                                                  </div>
                                             </div>
                                             </div>
                                        <div class="part6_4">
                                            <input type="text" placeholder="Enter Anchor (Spintax Accepted)" value="" name="anchor_rrr1">
                                            <div style="display:none;" class="help_box2 clearfix">
                                            <h4 class="no2">Please provied All synonyms That Could be replaced by your keyword.(Optional):</h4>
                                            <input type="text" placeholder="Enter synonyms or words that could be replaced by your keyword anchors. (I.E. hair loss, rogain, baldness)" value="" name="synonyms_rrr[]">
                                            </div>
                                            
                                            
                                            <h4 class="no3">Link/ URL 3a:</h4>
                                            <input type="text" placeholder="Enter URL including http://" value="" name="link_rrr1">                                   
                                         </div>
                                         <!--<div class="every_remove"><a href="javascript:void(0)">- Remove</a></div>-->
                                   </td></tr>
                                   </tbody>
                                   </table>
                                   <div class="part5_2 clearfix">
                                    <a id="add_anchor3" href="javascript:void(0)">+ New Anchor/ Link</a>
                                    <span>Correct Spintax Detected</span>
                                </div>
                               </div>
                            </div>

                        </div>

                        </div>

                    </div>
			</div>

			<div class="accordion-item">
				<a class="accordion-title" data-toggle="collapse" data-parent="#accordioninpanel" href="#collapseinTwo"><span id="scheset"><h4>Schedule and Settings</h4></span></a>
				<div id="collapseinTwo" class="collapse">
					<div class="accordion-body ">
                    	<div class="table-responsive">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table tblheadlft bordernone">
                              <tr>
                                <th width="23%">Select or Change any Submission Settings:</th>
                                <td>
                                    <div class="col-md-6">
                                    	<div class="row">
                                                 <input type="radio" name="submission" value="unique_domains" checked><span>Unique Domains:  First, skip domains previously posted to.</span>
                                    </div>
                                    </div>
                                     <div class="col-md-6">
                                     	<div class="row">
                                                  <input type="radio" name="submission" value="never_repeated"><span>Never Repeated: Never post to a domain that has been previously posted to.</span>
                                    </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="greybg pull-left" style="margin-top:20px; width:100%">Favor Preference</div>
                                    <div class="serpAPRN favor-preference">
                                        <ul>
                                            <li>
                                                <input type="radio" name="favor_preference" value="Random Mix" checked><span>Random Mix</span>
                                            </li>
                                            <li>
                                               <input type="radio" name="favor_preference" value="Highest Pagerank First"><span>Highest Pagerank First</span>
                                            </li>
                                            <li>
                                                <input type="radio" name="favor_preference" value="Unique IP First"><span>Unique IP First</span>
                                            </li>
                                            <li>
                                               <input type="radio" name="favor_preference" value="Oldest Domains First"><span>Oldest Domains First</span>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <th>Schedule & Drip Rate:</th>
                                <td>
                                    <div class="serpAPRN sdr" id="start_timing">
                                        <ul class="pull-left">
                                            <li>
                                                <input type="radio" name="schedule" value="now" checked><span>Start Now</span>
                                            </li>
                                            <li>
                                                <input type="radio" name="schedule" value="later"><span>Select Start Date</span>
                                            </li>
                                            <li>
                                                 <div class="cal"><input type="text" name="start_date" id="datepicker" value="" readonly /></div>
                                            </li>
                                        </ul>

                                    </div>
                                    
                                   <div class="greybg pull-left" style="margin-top:20px; width:100%">Drip Rate</div>
                                   <ul class="driprate-info">
                                   		<li>
                                            <input type="checkbox" name="drip_rate" value="Custom Range"><span>Custom Range: </span>
                                            <input type="text" name="num_post" value="" placeholder="# of Posts"/><span>Per </span>
                                            <div class="dropdown mgr-left">
                                                <select name="postings" class="dropdown-select">
                                                      <option value="day">Day</option>
                                                        <option value="weeks">weeks</option>
                                                         <option value="months">months</option>
                                                  </select>
                                            </div>
                                        </li>
                                        <li>
                                        	<input type="checkbox" name="drip_rate" value="Viral Linking"><span>Viral Linking:  <em>Spike in week 1, then trickle.</em></span>
                                        </li>
                                        <li>
                                        	<input type="checkbox" name="drip_rate" value="Mini Spikes"><span>Mini Spikes:  <em>Mini spike in links every 7 to 10 days.</em> </span>
                                        </li>
                                   </ul>
                                   <div class="greybg pull-left" style="margin-top:20px; width:100%">24 Hour Update</div>
                                   <div class="clearfix"></div>
                                   <ul class="hour-update">
                                   		<li>
                                        	<input type="checkbox" name="drip_rate" value="24 Hours" checked><span>Post All Within 24 Hours</span>

                                            <!--<span><input type="radio" name="keyword" id="shm" class="css-checkbox">
                                            <label for="shm" class="css-label radGroup1">Smart Homepage Monitoring / Promotion. How Many HPBL to Maintain?</label>
                                            </span>-->
                                        </li>
                                   </ul>
                                </td>
                              </tr>
                            </table>
                        </div>

                    </div>
				</div>
			</div>

		</div>
  </div>


  <div class="modal-footer tablefooter">
  	<button class="btn btn-primary" type="submit" name="submit">Save</button>
    <!-- <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button> -->
  </DIV>

</div>
</div>
</form>

</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!--<script src="../js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="../js/toggles-min.js"></script>
<script type="text/javascript" src="../js/toggles.js"></script>
<!-- <script type="text/javascript" src="../js/jquery.accordion.js"></script> -->

<!--<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript">
$(function() {
$('#st-accordion').accordion({
oneOpenedItem   : true
});
});
$(document).ready(function(){

$(".toggle_button").click(function(){

$(".toggle_box1").toggle();

});
$(".toggle_button1").click(function(){

$(".toggle_box2").toggle();

});

});
</script>-->


</body>
</html>
