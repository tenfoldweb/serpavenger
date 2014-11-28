<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome</title>
<!-- Bootstrap -->
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<!-- Include the jQuery library (local or CDN) -->
<!-- Include the basic styles -->
<!-- REVOLUTION BANNER CSS SETTINGS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/responsive.css" media="screen" />
<link rel="stylesheet" href="<?php echo FRONT_FONTCSS_PATH; ?>font-awesome.min.css"  media="screen" >
<link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
<!-- Owl Carousel Assets -->
<link href="<?php echo base_url(); ?>css/owl.carousel.css" rel="stylesheet">
<!--<link href="../owl-carousel/owl.theme.css" rel="stylesheet">-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- font -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
$(document).ready(function () {
    var $content = $(".contentmypannel").show();
    $(".toggle_mypannel").click(function () {
        $(this).toggleClass("expanded").text(function (_, curText) {
            return curText == 'Open' ? '' : '';

        });
        $content.slideToggle();

    });

    $("#toggleall").slideDown();
    $(".triggerall").click(function(){
        $(this).next("#toggleall").slideToggle("slow");alert('fsdg');
      }); 
      
    $(".mng-btn").click(function () {
        var divname= this.value;    
        $('#divinner'+divname).slideToggle("slow");       
    });

});
</script>
</head>
<body>
<div class="container">
<div class="row" id="header">
<div class="col-md-3 left-col">
<div id="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo.png" width="214" height="84" alt=""></a></div>
</div>

<div class="col-md-9 menusec right-col">
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
<div class="container">
<?php  $this->load->view('includes/left'); ?>
</div>
<div class="col-md-9 right-col">
<div class="row">
    <div class="mypanel-tab-content">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li><img src="<?php echo base_url(); ?>images/mypnl-tab-icon.png" class="icontop" alt=""/></li>
            <li class="active"><a href="#pannel-my-compagins" data-toggle="tab">My Campagins</a></li>
            <li><a href="#pannel-my-netwzorks" data-toggle="tab">My Networks</a></li>
            <li><a href="#pannel-account-setting" data-toggle="tab">Account settings</a></li>
        </ul>
        <div id="my-tab-content" class="tab-content mypanel-contant">
            <div class="tab-pane active" id="pannel-my-compagins">
                <div class="col-md-12 ataglance">
                    <h2>At A Glance</h2>
                    <ul>
                        <li><span><?php echo $campaigncount; ?></span> Total Campagins</li>
                        <li><span><?php echo $site_count; ?></span> Total Sites</li>
                        <li><span><?php echo $campaignlistmoney; ?></span> Money/Client</li>
                        <li><span><?php echo $campaignlistpara; ?></span> Parasites</li>
                        <li><span><?php echo $keyword_count; ?></span> Keywords</li>
                        <li><span><?php echo $seo_count; ?></span> SEO Tests</li>
                    </ul>
                </div>
               <!--  <div class="col-md-12 more-recent">
                <h2>More Recent</h2>
                  <ul class="addmoresec">
                      <li><img src="<?php echo base_url(); ?>images/recent1.jpg" width="90" height="67" alt=""/></li>
                      <li><img src="<?php echo base_url(); ?>images/recent2.jpg" width="90" height="67" alt=""/></li>
                      <li class="addmore-btn"><a href="">+ ADD MORE</a></li>
                  </ul>
                </div> -->
                <!--  filter  -->
                <div class="filterblock-mypnl">
                    <div class="topbreadcrumbarea">
                        <ol class="breadcrumb topbreadcrumb">
                            <li><span id="campaigntest"><a href="http://www.locksmithdenvermetro.com" target="_blank">www.locksmithdenvermetro.com</a></span></li>
                            <li id="campaign_secondary_keyword">Denever</li>
                            <li class="active" id="campaigntest1">Denever locksmith</li>
                        </ol>
                    </div>

                    <div class="toprowfilter choosecamp-panel" style="margin-top:3px">
                        <div class="pull-right">
                             <a class="btn btn-primary" href="<?php echo base_url()?>campaign">View campaign</a>
                        </div>
                        <div class="choose-campaign cc-mpnl">
                            <span>Choose campaign:</span> <div class="dropdown">
                            <select class="dropdown-select" name="selectblogtype" id="selectblogtype2">
                            <option value="Show all domain">Show all domain</option>
                           <?php
                             foreach($campaignname as $campaign_name){?>

                           <option value="<?php echo $campaign_name->campaign_id; ?>"><?php echo $campaign_name->campaign_main_keyword; ?></option>

                        <?php }   ?>

                            </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="clearfix"></div>
                <!---->




                <div class="denever-locksmith">
                                   <div class="dlheader">
                                       <h2><span id="campaigntest2"><a href="http://www.locksmithdenvermetro.com" target="_blank">Denver Locksmith</a></span></h2>
                       <!-- manage button -->
                        <div class="btn-group manage-drop pull-right">
                         <!--<div class="toggle_mypannel"></div>-->
                         <button data-toggle="dropdown" value="" class="btn btn-default dropdown-toggle mng-btn toggle_mypannel" type="button"></button>
                         <!-- <button type="button" class="btn btn-default dropdown-toggle mng-btn" data-toggle="dropdown">
                            <span class="caret"></span>
                          </button> -->
                          <!-- <ul class="dropdown-menu manage-drop-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                          </ul> -->
                        </div>

                      <div class="other-figure">
                            <div class="mcsites">
                                <span><img src="<?php echo base_url(); ?>images/money-icon.png" alt=""/></span>
                                <span>Money/Clients Sites</span>
                                <span class="keywrdcnt"><?php echo $campaign_namedetail[0]->campaign_site_type; ?></span>
                          </div>
                          <div class="parasites-info">
                                <span><img src="<?php echo base_url(); ?>images/Parasite.gif" /></span>
                                <span>Parasites</span>
                                <span  class="keywrdcnt"><?php echo $campaign_namedetail[0]->para; ?></span>
                          </div>
                        <div class="keyword-info">
                                <span><img src="<?php echo base_url(); ?>images/keywords-icon.png" width="17" height="16" alt=""/></span>
                                <span>Keywords</span>
                                <span class="keywrdcnt"><?php echo $campaign_namedetail[0]->keywordcnt; ?></span>
                          </div>
                      </div>
                      
                       
                        <div class="clearfix"></div>
                    </div>

                  <div class="dlbody">
                    <!--  website info-->
                     <div class="contentmypannel">
                    <div class="websiteinfo">
                        <div class="website-thumb">
                            <img id="campaign_murl_thumb" src="<?php echo base_url(); ?>images/<?php echo $campaign_namedetail[0]->campaign_murl_thumb; ?>" width="200" height="150" alt=""/>
                         </div>
                         <div class="website-thumb-info">
                            <div class="web-type">
                                <span>Type:</span> <div class="dropdown">
                                <select id="selectblogtype" name="selectblogtype" class="dropdown-select">
                                    <option id="campaign_site_type" value="Show all domain">
                <?php if($campaign_namedetail[0]->campaign_site_type='1') {  ?>
                                Money/Client
                                <?php } else {?>
                                Parasite
                                <?php } ?>
                                </option>
                                </select>
                                </div>
                            </div>
                            <div class="web-status">
                                <span>Status:</span>
                                <div class="ststus-active" id="campaign_status">
                                    <i class="fa fa-check-circle"></i>
                                     <?php echo $campaign_namedetail[0]->status; ?>
                                </div>
                                <div class="web-control">
                                    <a href="" class="pause-btn"><i class="fa fa-pause"></i></a>
                                    <a href="" class="delete-btn"><i class="fa fa-trash-o"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="web-focus">
                                <span>Focus:</span> <div class="dropdown">
                                <select id="selectblogtype" name="selectblogtype" class="dropdown-select">
                                    <option value="Show all domain" id="campaign_murl_country_code">
                    <?php echo $campaign_namedetail[0]->campaign_murl_country_code; ?></option>
                                </select>
                                </div>
                            </div>
                         </div>
                         <div class="clearfix"></div>
                         <div class="website-link">
                             <span id="campaigntest3"><a href="http://www.locksmithdenvermetro.com" target="_blank">www.locksmithdenvermetro.com</a></span>
                         </div>
                        <div class="clearfix"></div>
                    </div>
                    </div>
                    <!-- Ranking -->
                    <div class="dlblock dlranking">
                        <h2>Ranking <span>( <?php echo $keywordsitese[0]->tkw; ?> )</span></h2>
                        <div class="dlranking-body">
                            <ul>
                              <li>
                              	<label>Main Keyword:</label>
                                <span><a data-target="#editkw" data-toggle="modal">Edit</a></span>
                                <!-- Edit keyword popup-->
                                <div class="modal fade text-left" id="editkw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header popup-header">
                                    <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Main Keyword</h4>
                                  </div>
                                  <div class="modal-body popupbody">

                                    <div class="modal-header kwhead">
                                        <h2>What would you like to set as your main keyword?</h2>

                                    </div>
                                    <div class="enter-keyword">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                          <tr>
                                            <td width="16%" valign="middle" class="valgn-middle">Enter Keyword:</td>
                                            <td><input name="" type="text"></td>
                                          </tr>
                                        </table>
                                        <div class="headingor"><span class="greyorcircle">OR</span> Select a Suggested Keyword:</div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="sk-list ">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                              <th></th>
                                              <th>Similar Keyword</th>
                                              <th>Est Traffic</th>
                                              <th>CPC</th>
                                            </tr>
                                            <?php foreach($keywordloop as $keey) {?>
                                            <tr>
                                              <td><input type="checkbox"></td>
                                              <td><?php print_r($keey['keyword'])  ?></td>
                                              <td><?php print_r($keey['keyword_cpc'])  ?></td>
                                              <td><?php print_r($keey['keyword_est_traffic'])  ?></td>
                                            </tr>
                                           <?php } ?>
                                          </tbody>
                                        </table>
                                        </div>
                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-primary pull-left">Save</button>
                                          </div>
                                    <div class="clearfix"></div>
                                  </div>
                                </div>
                                </div>
                                </div>
                              </li>

                                <li><label><?php echo $sitemainkw[0]->keyword; ?>&nbsp; <span><?php echo $sitemainkw[0]->mkw; ?></span></label> <span class="badge small-badge small-badgegreen  pull-right">+1</span></li>
                              <li>
                              	<label>Secondary Keyword:</label>
                                <span><a data-target="#secondarykw" data-toggle="modal">Edit</a></span>
                                <!-- Secondary keyword popup-->
                                <div class="modal fade text-left" id="secondarykw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header popup-header">
                                    <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Secondary Keyword</h4>
                                  </div>
                                  <div class="modal-body popupbody">

                                    <div class="modal-header kwhead">
                                        <h2>What would you like to set as your Secondary keyword?</h2>

                                    </div>
                                    <div class="enter-keyword">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                          <tr>
                                            <td width="16%" valign="middle" class="valgn-middle">Enter Keyword:</td>
                                            <td><input name="" type="text"></td>
                                          </tr>
                                        </table>
                                        <div class="headingor"><span class="greyorcircle">OR</span> Select a Suggested Keyword:</div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="sk-list ">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tbody>
                                            <tr>
                                              <th></th>
                                              <th>Similar Keyword</th>
                                              <th>Est Traffic</th>
                                              <th>CPC</th>
                                            </tr>
                                             <?php foreach($secondkeywordloop as $keey) {?>
                                            <tr>
                                              <td><input type="checkbox"></td>
                                              <td><?php print_r($keey['keyword'])  ?></td>
                                              <td><?php print_r($keey['keyword_cpc'])  ?></td>
                                              <td><?php print_r($keey['keyword_est_traffic'])  ?></td>
                                            </tr>
                                            <?php } ?>
                                          </tbody>
                                        </table>
                                        </div>
                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-primary pull-left">Save</button>
                                          </div>
                                    <div class="clearfix"></div>
                                  </div>
                                </div>
                                </div>
                                </div>
                               </li>
                                <li><label><?php echo $siteseckw[0]->keyword; ?>&nbsp; Key <span><?php echo $siteseckw[0]->skw; ?></span></label> <span class="badge small-badge small-badgered pull-right">-2</span></li>
                            </ul>
                            <div class="pull-left">
                            	<a class="btn btn-primary" href="<?php echo base_url()?>ranking">View Rankings</a>
                            </div>
                        </div>
                    </div>
                    <!-- Ranking -->
                    <div class="dlblock dlranking">
                        <h2>Deep Analysis </h2>
                        <div class="dlranking-body">
                            <ul class="deepanalysis">
                                <li>
                                    <span class="ststus-active"><i class="fa fa-check-circle"></i>
                                 <?php if($deepanlymainkw[0]->analyzed='true') {  ?>
                                     Active
                                 <?php }  else {?>
                                      Inactive
                                 <?php } ?>
                                     </span>
                                </li>
                                <li>
                                    <span class="dropdown">
                                        <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                        <option value="Show all domain">Daily</option>
                                        </select>
                                    </span>
                                </li>
                                <li>
                                    <span class="ststus-activate"><i class="fa fa-check-circle"></i>
                                <?php if($deepanlyseckw[0]->analyzed='true') {  ?>
                                     Active
                                 <?php }  else {?>
                                      Inactive
                                 <?php } ?>
                                    </span>
                                </li>
                            </ul>
                            <a data-toggle="modal" data-target="#addnewkeyword" style="float: left; margin: 0 0 40px;">+ Add More</a>
                        <!-- New Network popup-->
                        <div class="modal fade" id="addnewkeyword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header popup-header">
                            <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Analyze Additional Keyword</h4>
                          </div>
                          <div class="modal-body popupbody">
                            <div class="modal-header select-key-head">
                                <h2>Select a keyword you would like to have analyzed daily:</h2>
                                <div class="keyword-compaign">
                                  <label>Campaign</label>
                                    <div class="dropdown">
                                        <select class="dropdown-select" name="selectnetwork" id="selectnetwork">
                                            <option value="1">Uncategorized</option>
                                            <option value="2">General PR Network</option>
                                            <option value="3">Local California Clients</option>
                                            <option value="4">Bing ONLY Network</option>
                                            <option value="5">Denver Lock Network</option>
                                            <option value="6">5+ High PR Network</option>
                                            <option value="7">Aged Network</option>
                                            <option value="8">Indexer Network</option>
                                            <option value="9">Radio Works Network</option>
                                            <option value="10">Test Network</option>
                                            <option value="11">Randy Jones Locker</option>
                                            <option value="12">test network</option>
                                            <option value="13">Kristin's Network</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="keyword-site">
                                  <label>Site</label>
                                    <div class="dropdown">
                                        <select class="dropdown-select" name="selectnetwork" id="selectnetwork">
                                            <option value="1">Uncategorized</option>
                                            <option value="2">General PR Network</option>
                                            <option value="3">Local California Clients</option>
                                            <option value="4">Bing ONLY Network</option>
                                            <option value="5">Denver Lock Network</option>
                                            <option value="6">5+ High PR Network</option>
                                            <option value="7">Aged Network</option>
                                            <option value="8">Indexer Network</option>
                                            <option value="9">Radio Works Network</option>
                                            <option value="10">Test Network</option>
                                            <option value="11">Randy Jones Locker</option>
                                            <option value="12">test network</option>
                                            <option value="13">Kristin's Network</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="selectkeyword-sec">
                                <ul>
                                    <li>
                                        <input type="checkbox" class="css-checkbox" id="ts" checked="checked">
                                        <label for="ts" name="checkbox1_lbl" class="label-chkbx lite-gray-check">Tenant Screening</label>
                                    </li>
                                    
                                    <li>
                                        <input type="checkbox" class="css-checkbox" id="tss" checked="checked">
                                        <label for="tss" name="checkbox1_lbl" class="label-chkbx lite-gray-check">Tenant Screening Services</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="css-checkbox" id="tsr" checked="checked">
                                        <label for="tsr" name="checkbox1_lbl" class="label-chkbx lite-gray-check">Tenant Screening report</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="css-checkbox" id="st" checked="checked">
                                        <label for="st" name="checkbox1_lbl" class="label-chkbx lite-gray-check">Screening Tenant  </label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="css-checkbox" id="tsbc" checked="checked">
                                        <label for="tsbc" name="checkbox1_lbl" class="label-chkbx lite-gray-check">Tenant Screening background check</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="css-checkbox" id="tbs" checked="checked">
                                        <label for="tbs" name="checkbox1_lbl" class="label-chkbx lite-gray-check">Tenant background Screening</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" class="css-checkbox" id="fts" checked="checked">
                                        <label for="fts" name="checkbox1_lbl" class="label-chkbx lite-gray-check">Free Tenant Screening</label>
                                    </li>
                                </ul>
                                
                                <button class="btn btn-primary" type="button">Save</button>
                                
                            </div> 
                            <div class="clearfix"></div>   
                          </div>
                        </div>
                        </div>
                        </div>
                            <div class="pull-left">
                             	<a class="btn btn-primary" href="<?php echo base_url()?>analysis">Check Analysis</a>
                            <!-- <button class="btn btn-primary" type="button"><a href="<?php echo base_url()?>analysis">Check Analysis</a></button> -->
                            </div>
                        </div>
                    </div>

                    <!-- Ranking -->
                    <div class="dlblock dlranking">
                        <h2>Automated Link Building</h2>
                        <div class="dlranking-body">
                            <div class="alb">
                                <ul>
                                    <li>
                                        <label><i class="fa fa-bolt"></i> Auto Pilot</label>
                                        <?php if($autolinkprofile[0]->profilelink=='auto') {  ?>
                                    <span class="ststus-active"><i class="fa fa-check-circle"></i>Active</span>
                                 <?php }  else {?>
                                   <span class="ststus-activate"><i class="fa fa-check-circle"></i>Inactive</span>
                                 <?php } ?>
                                    </li>
                                    <li>
                                        <label>Manually Set</label>
                                         <?php if($autolinkprofile[0]->profilelink=='manual') {  ?>
                                    <span class="ststus-active"><i class="fa fa-check-circle"></i> Active</span>
                                 <?php }  else {?>
                                       <span class="ststus-activate"><i class="fa fa-check-circle"></i> Inactive</span>
                                 <?php } ?>
                                    </li>
                                    <li>
                                        <label>Self Configured</label>
                                        <?php if($autolinkprofile[0]->profilelink=='self') {  ?>
                                     <span class="ststus-active"><i class="fa fa-check-circle"></i>Active</span>
                                 <?php }  else {?>
                                     <span class="ststus-activate"><i class="fa fa-check-circle"></i> Inactive</span>
                                 <?php } ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="pull-left">
                             <a class="btn btn-primary" href="<?php echo base_url()?>analyzecompare2">Manage Settings</a>

                           <!--  <button class="btn btn-primary" type="button">Manage Settings</button>-->
                            </div>
                        </div>
                    </div>

                    <!-- dl thumb-->
                    <div class="dlthumb">
                        <ul>
                          <?php
             foreach($campaign_fullimagedet as $campaignfullimagedet){?>
                          <li  class="showSingle" target="1">
                            <span class="topright-badge"><img src="<?php echo base_url(); ?>images/Parasite.gif" alt=""/></span>
                            <span class="thumb-img">
                                <img src="<?php echo base_url(); ?>images/dlhumb1.gif" width="90" height="68" alt=""/>
                             </span>
                             <span class="thumb-right">
                                14 KW<br>
                                <img src="<?php echo base_url(); ?>images/bing-icon.png" width="16" height="16" alt=""/>
                             </span>
                             <span class="thumblink">
                                <a href=""><?php echo $campaignfullimagedet['campaign_murl_thumb']; ?></a>
                             </span>
                           </li>
                           <?php } ?>

                          <li class="addmore-btn"><a href="">+ ADD MORE</a></li>
                      </ul>
                    </div>

                    <div class="clearfix"></div>
                  </div>
                </div>

                <!-- lead gen sites-->
                 <?php //echo $campaignname;
                 //echo "<pre>";
               //  print_r ($campaignlistuser);
                 $cnt=0;
             foreach($toplvslisting as $campaignlistusernm){  $cnt++;?>



            <div class="denever-locksmith">
                <div class="dlheader">
                    <h2><?php echo $campaignlistusernm['imagename']; ?></h2>
                    <div class="btn-group manage-drop pull-right ">
                      <button data-toggle="dropdown" value="<?=$cnt;?>" class="btn btn-default dropdown-toggle mng-btn plusminus-btn" type="button"></button>
                      <!--  <h3 class = "triggerall">Heading 1</h3>  -->
                      <!-- <ul role="menu" class="dropdown-menu manage-drop-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul> -->
                    </div>
                    <div class="other-figure">
                        <div class="mcsites">
                            <span><?php echo $campaignlistusernm['campaign_site_type']; ?></span>
                            <span><img alt="" src="<?php echo base_url(); ?>images/money-icon.png"></span>
                            <span>Money/Clients Sites</span>
                      </div>
                      <div class="parasites-info">
                            <span><?php echo $campaignlistusernm['para']; ?></span>
                            <span><img src="<?php echo base_url(); ?>images/Parasite.gif"></span>
                            <span>Parasites</span>
                      </div>
                    <div class="keyword-info">
                            <span><?php echo $campaignlistusernm['keywordcnt']; ?></span>
                            <span><img width="17" height="16" alt="" src="<?php echo base_url(); ?>images/keywords-icon.png"></span>
                            <span>Keywords</span>
                      </div>
                  </div>
                  
                    <div class="clearfix"></div>
                </div>

            <div class="dlbody more-recent pnlalltmb" id="divinner<?=$cnt;?>">
                    <ul class="addmoresec">
                          <li><img width="90" height="67" alt="" src="http://serpavenger.com/screenshot/results/<?php echo $campaignlistusernm['thumbailsize1']; ?>.jpg"></li>
                        <!--   <li><img width="90" height="67" alt="" src="<?php echo base_url(); ?>images/2.jpg"></li> -->
                          <li class="addmore-btn"><a href="">+ ADD MORE</a></li>
                      </ul>
                      <div class="clearfix"></div>
                </div>


            </div>
                 <?php }   ?>
                <a href="<?php echo base_url()?>campaign" class="newcomp">+ New Campaign</a>


                <div class="clearfix"></div>
            </div>
            <div class="tab-pane" id="pannel-my-netwzorks">
                <div class="col-md-9 ataglance mynetwork-ataglance">
                    <h2 class="pull-left">At A Glance</h2>
                    <ul>
                        <li><span> <?php echo $networkcount; ?></span> Total Networks</li>
                        <li><span><?php echo $domaincount; ?></span> Total Domains</li>
                        <li><span><?php echo $postcount; ?></span> nO. OF pOSTS</li>
                        <li><span><?php echo $linkcount; ?></span> nO. OF LINKS</li>
                    </ul>

                    <!-- Visual health check-->
                    <div class="vhcheck">
                        <span class="vckech-heading">
                            <i class="fa fa-plus-square"></i> Visual Health Check Your Network
                        </span>
                        <div class="select-network-vhcheck">
                            <div class="choose-campaign">
                                <span>Select Network:</span> <div class="dropdown">
                                <select id="selectblogtype1" name="selectblogtype" class="dropdown-select">
                                    <option value="">select network</option>
                                  <?php   foreach($network_name as $network1)
                                  {?>

                                  	<option value="<?php echo $network1->id; ?>"><?php echo $network1->network_name; ?></option>
                                <?php  } ?>



                                  ?>
                                </select>
                                </div>
                            </div>
                            <button type="button" onclick="ShowDomainList(0);" class="btn btn-primary">Run Check</button>
                        </div>
                    </div>
                    <div class="pull-right">
                    <a class="gotonm" href="<?php echo base_url()?>networkmanager">Go to Network Manager</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                 <!-- Live visual snapshot-->
                    <div class="denever-locksmith lvshead-main">
                        <div class="dlheader lvshead">
                            <ul>
                                <li><a href="#" class="active">Live Visual Snapshot</a></li>
                                <li><a href="#" id="testntwk">Network Name</a></li>
                                <li><a href="#" id="test">No. Of Domain</a></li>
                            </ul>
                        </div>

                        <!-- pagination-->
                        <div class="lvspag-sec">
                            <p>Click the URL to view site in browser. </p>
                            <div id="container"><?php
     echo @$body_content; ?></div>
                            <div class="pagination-row text-right">
                        <?php if(isset($links) && $links!='' ){  ?>
                <div class="pagination">
                    <?php // echo $links; ?> 
             <input type="hidden" id="nval" value="<?php echo $current+1; ?>">
                    <span class="previous"><i class="fa fa-caret-left"></i></span><span class="next-btn"><i id="<?php echo $current+1; ?>" class="fa fa-caret-right"></i></span>
                     Page <input name="page" id="page" type="text" value="<?php if(isset($current)) echo $current; ?>" readonly> of <?php if(isset($total)) echo $total; ?>
                </div>
                <? } ?></div>
                           <!--  <div class="lvspag-pagination">
                                <span>Page 1 of 8 </span>
                                <ul>
                                    <li><a href="#" class="active">NEXT</a></li>
                                    <li><a href="#">PREVIOUS</a></li>
                                </ul>
                            </div> -->
                            <div class="clearfix">
                            </div>
                        </div>

                        <!-- top listing-->
                        <div class="toplvs-listing">
                            <div  class="sitethumb-list" >
                           <img id="def" src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /> 
                            <!--  <ul class='bjqs' >
                             <li><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="20" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /></li>
                             <li><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /></li>
                             <li><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="100" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /><img src="<?php echo base_url(); ?>images/Thumbnail-Queued.jpg" width="120" height="90" /></li>
                            </ul>  -->
                                <!-- <ul> -->
                                <?php 
                              // print_r($toplvslisting);
                             //  foreach($toplvslisting as $img){                             
                               
                                ?>
<!-- <li><a href="http://<?php echo $img['imagename']; ?>" target="_blank" ><img src="http://serpavenger.com/screenshot/results/<?php echo $img['thumbailsize1']; ?>.jpg" width="120" height="90" alt=""/></a> <span><a href="http://<?php echo $img['imagename']; ?>" target="_blank" ><?php echo $img['imagename']; ?></a></span></li>
                                  
    -->                            <?php //} ?>
                                 <!--    <li><img src="<?php echo base_url(); ?>images/10.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/11.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/12.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/13.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/14.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/15.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                         -->        
                        <!--  </ul> -->
                            </div>
                        </div>
                        <div class="urllisting-corsoul">
                            <div id="owl-demo" class="owl-carousel">
                                <div class="item">
                        <?php  //print_r($slidershrinkweb);
foreach($slidershrinkweb as $recn) {
$config = array(
'access_key'    => 'XXXXXXXXXXXXXXXX',
'secret_key'    => 'XXXXX'
);

# load library with access_key & secret_key (supplied from ShrinkTheWeb with a valid account)
$this->load->library('shrinktheweb', $config);

$url = 'bbc.co.uk';

# display the image to the browser
echo $this->shrinktheweb->getThumbnailHTML($url);
          //echo "<pre>";// print_r($recn);
          //echo $recn['campaign_murl_thumb'];
          //echo $recn['campaign_main_page_url'];
          //echo $recn['campaign_murl_domain'];
//<img src=’http://www.shrinktheweb.com/xino.php?embed=1&STWAccessKeyId=<your access key>&stwsize=<thumbnail size>&stwUrl=<url>’>
// echo '<img src="http://images.shrinktheweb.com/xino.php?stwu=c1871&stwxmax=120&stwymax=90&stwaccesskeyid=37c50d761e16b0b&stwurl='.$recn['campaign_main_page_url'].'">';
//echo '<img src="http://images.shrinktheweb.com/xino.php?stwu=c1871&stwsize=sm&stwaccesskeyid=37c50d761e16b0b&stwurl='.$recn['campaign_main_page_url'].'"><span>"'.$recn['campaign_murl_domain'].'"</span> ?>
<img src="<?php echo base_url(); ?>images/<?php echo $recn['campaign_main_page_url'];?>"> <span><?php echo $recn['campaign_murl_domain']; ?></span>
<?php   }

?></div>
                              </div>
                        </div>
                        <!-- <div class="urllisting-corsoul">
                            <div id="owl-demo" class="owl-carousel">
                                <div class="item"><img src="<?php echo base_url(); ?>images/16.gif" alt=""/> <span>tenantverific...in.com</span></div>
                                <div class="item"><img src="<?php echo base_url(); ?>images/17.gif" alt=""/> <span>checkintocash.com/</span></div>
                                <div class="item"><img src="<?php echo base_url(); ?>images/18.gif" alt=""/> <span>wikihow.com</span></div>
                                <div class="item"><img src="<?php echo base_url(); ?>images/19.gif" alt=""/> <span>yahoo.com</span></div>
                                <div class="item"><img src="<?php echo base_url(); ?>images/20.gif" alt=""/> <span>acecashexpress.com</span></div>
                                <div class="item"><img src="<?php echo base_url(); ?>images/18.gif" alt=""/> <span>yahoo.com</span></div>
                                <div class="item"><img src="<?php echo base_url(); ?>images/19.gif" alt=""/> <span>wikihow.com</span></div>
                                <div class="item"><img src="<?php echo base_url(); ?>images/20.gif" alt=""/> <span>checkintocash.com/</span></div>
                              </div>
                        </div> -->
                        <!-- top listing-->
                       <!--  <div class="toplvs-listing">
                            <div class="sitethumb-list">
                                <ul>
                                    <li><img src="<?php echo base_url(); ?>images/10.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/11.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/12.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/13.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/14.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                    <li><img src="<?php echo base_url(); ?>images/15.gif" width="120" height="90" alt=""/> <span><a href="#">boertjelaw.com</a></span></li>
                                </ul>
                            </div>
                        </div> -->

                        <div class="pagination-row text-right">
                        <?php if(isset($links) && $links!='' ){ echo "gg"; ?>
                <div class="pagination">
                    <?php echo $links; ?> Page <input name="page" type="text" value="<?php if(isset($current)) echo $current; ?>" readonly> of <?php if(isset($total)) echo $total; ?>
                </div>
                <? } ?>
                        <!-- <div class="pagination">
                            <span class="previous"><i class="fa fa-caret-left"></i></span><span class="next-btn"><i class="fa fa-caret-right"></i></span>
                            <span>Page <input type="text" name=""> of 8</span>
                        </div> -->
                    </div>


                    </div>

                <div class="clearfix"></div>
            </div>


            <div class="tab-pane" id="pannel-account-setting">
            <form action="<?php echo base_url();?>index.php/mypannel/updateuser" method="POST">
                <div class="acc-setting-block">
                    <h3>Update Account Information</h3>
                    <ul>
                        <li>
                            <label>Email Address</label>
                            <input type="text" name="users_email" value="">
                            <span><a href="#">Change</a></span>
                        </li>
                        <li>
                            <label>Current Email Address</label>
                            <input type="text" value="<?=$users_email;?>">
                        </li>
                        <li>
                            <label>Password</label>
                            <input type="password" name="users_password">
                        </li>
                        <li>
                            <label>Re enter Password</label>
                            <input type="password" name="users_password">
                            <input type="hidden" value="<?=$users_id;?>" name="users_id">
                        </li>
                        <li>
                            <label>&nbsp;</label>
                            <button class="btn btn-primary" type="submit" style="margin-right:10px">Save</button> <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        </li>
                    </ul>
                </div>
            </div></form>
        </div>

    </div>
</div>
</div>
</div>



<script type="text/javascript">
/*jQuery(document).ready(function($) {
    $('#my-slideshow').bjqs({
        'height' : 700,
        'width' : 850,
        'responsive' : true
    });
});
*/


// <![CDATA[
$(document).ready(function(){
$('#selectblogtype1').change(function(){
var id = $('#selectblogtype1').val();
var selects = document.getElementById("selectblogtype1");
var selectedText = selects.options[selects.selectedIndex].text;// give

var form_data = {
id : $('#selectblogtype1').val(),
ajax : '1'
};
$.ajax({
type: 'POST',
async : false,
data: form_data,
url: '<?php echo base_url(); ?>index.php/mypannel/get_network/',


success: function(name)
{

$('#test').html(name);
$('#testntwk').html(selectedText);

}

});

});
});
</script>
<script type="text/javascript">

$(document).ready(function(){
$('#selectblogtype2').change(function(){
var id = $('#selectblogtype2').val();
var selects = document.getElementById("selectblogtype2");
var selectedText = selects.options[selects.selectedIndex].text;// giv
var form_data = {
id : $('#selectblogtype2').val(),
ajax : '1'
};
$.ajax({
type: 'POST',
async : false,
data: form_data,
url: '<?php echo base_url(); ?>index.php/mypannel/get_campaign_url/',
success: function(row)
{
    var myObject = JSON.parse(row);
  alert(row);
   
$('#campaigntest').html('<a href="'+myObject[0].campaign_main_page_url+'">'+myObject[0].campaign_main_page_url+'</a>');
$('#campaigntest2').html('<a href="'+myObject[0].campaign_main_page_url+'">'+selectedText+'</a>');
$('#campaigntest3').html('<a href="'+myObject[0].campaign_main_page_url+'">'+myObject[0].campaign_main_page_url+'</a>');
$('#campaign_secondary_keyword').html(myObject[0].campaign_secondary_keyword);
$('#campaign_murl_country_code').html(myObject[0].campaign_murl_country_code);
$('#campaign_status').html('<i class="fa fa-check-circle"></i> '+myObject[0].campaign_status);
var campaign_type  = (myObject[0].campaign_site_type == 1) ? 'Money/Client' : 'Parasite';
$('#campaign_site_type').html(campaign_type);
campaign_murl_thumbsrc = '<?php echo base_url(); ?>images/'+myObject[0].campaign_murl_thumb;
$('#campaign_murl_thumb').attr("src", campaign_murl_thumbsrc);
$('#campaigntest1').html(selectedText);
}
});
});
});

var counter = 2;

function ShowDomainList(){
var id = $("#selectblogtype1").val();
var form_data = {
id : id,
ajax : '1'
};
$.ajax({
type: 'POST',
async : false,
data: form_data,
url: '<?php echo base_url(); ?>mypannel/get_network_list/',
success: function(row)
{

$('#def').css('display','block');
setTimeout(function(){
$('.sitethumb-list').html(row);
$('#def').css('display','none');
}, 5000);


}
});

}
</script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->



<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/owl.carousel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.verticalCarousel.min.js"></script>

 <script src="<?php echo base_url(); ?>js/script.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.slicknav.js"></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/jquery.nicescroll.min.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/application.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/jquery.cookie.js'></script>

</body>
</html>
