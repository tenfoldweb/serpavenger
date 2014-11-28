 <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet">
    
    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/responsive.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    
    <!-- font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="<?php echo base_url();?>js/Chart.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.sparkline.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/analysis.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'> 
<script>
<!-- Edited by BEAS -->

function set_analysis_permission(permission_cost, permission_name, frm_id)
{
	 $.post("<?php echo base_url() ?>index.php/analysis/add_user_permissions", {name:permission_name, cost:permission_cost}, function(data){
			   
			  $('input[name=item_number]').val(data);
			   
			  $('#'+frm_id).submit();

               });
}

</script>
    <div class="container">
    	<div class="row" id="header">
        	<div class="col-md-3 left-col">
                <div id="logo"><a href="index.html"><img src="<?php echo FRONT_IMAGE_PATH;?>logo.png" width="214" height="84" alt=""></a></div>
        	</div>

            <div class="col-md-9 menusec right-col">
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
                        <li><a href="my-pannel.html">My Panel </a></li>
                        <li><a href="my-compaigns.html">My Campaigns <i class="fa fa-caret-down"></i></a>
                            <ul>
                                <li><a href="#">item1</a></li>
                                <li><a href="#">item2</a></li>
                                <li><a href="#">item1</a></li>
                                <li><a href="#">item2</a></li>
                            </ul>
                        </li>
                        <li><a href="rankings.html">Rankings</a></li>
                        <li class="current-menu-item"><a href="analysis.html">Analysis</a></li>
                        <li><a href="network-manager.html">Network Manager</a></li>
                        <li><a href="content.html">Content</a></li>
                        <li><a href="reports.html">Reports</a></li>
                        <li><a href="video-tutorials.html">Video Tutorials</a></li>
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
			<?php if($permission){ ?>
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
                <div class="row">
                	<!-- Top 10 results -->
                    <div class="top-10-results">

                             <div id="your-id-name" class="vertical-carousel">
    <h3>TOP 10  Results</h3>
    <div class="vertical-carousel-container" style="height: 249px; overflow: hidden;">
        <!--<div id="contain-site-page-count"></div>
		<div id="loader-site-page-count" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader1.gif" alt="Loading"></div> -->
        <ul class="vertical-carousel-list">

            <li>
            	<div class="arrow_box">
                <a href="#" class="" onclick="DisData('1')">
                <img src="<?php echo FRONT_IMAGE_PATH;?>slider-tab-img1.gif"  width="74" height="56" alt="">
                <span>My Site</span>
                <div class=" clearfix"></div>
                <small>http://www.locksmithden..</small>
                </a>
                </div>
            </li>
            <li>
            	<div class="arrow_box">
            	<a href="#"  class="" onclick="DisData('2')">
                <img src="<?php echo FRONT_IMAGE_PATH;?>slider-tab-img2.gif"  width="74" height="56" alt="">
                <span class="ybg">Top 1</span>
                <small>http://www.locksmithden..</small>
                </a>
                </div>
            </li>
            <li>
            	<div class="arrow_box">
                <a href="#" onclick="DisData('3')">
                <img src="<?php echo FRONT_IMAGE_PATH;?>slider-tab-img3.gif"  width="74" height="56" alt="">
                <span class="ybg">TOP 2</span>
                <small>http://www.locksmithden..</small>
                </a>
                </div>
            </li>
            <li>
            	<div class="arrow_box">
                <a href="#" onclick="DisData('4')">
                <img src="<?php echo FRONT_IMAGE_PATH;?>slider-tab-img1.gif"  width="74" height="56" alt="">
                <span class="ybg">TOP 4</span>
                <small>http://www.locksmithden..</small>
                </a>
                </div>
            </li>
            <li>
            	<div class="arrow_box">
                <a href="#" onclick="DisData('5')">
                <img src="<?php echo FRONT_IMAGE_PATH;?>slider-tab-img1.gif"  width="74" height="56" alt="">
                <span class="ybg">TOP 5</span>
                <small>http://www.locksmithden..</small>
                </a>
                </div>
            </li>
            <li>
            	<div class="arrow_box">
                <a href="#" onclick="DisData('1')">
                <img src="<?php echo FRONT_IMAGE_PATH;?>slider-tab-img1.gif"  width="74" height="56" alt="">
                <span class="ybg">TOP 6</span>
                <small>http://www.locksmithden..</small>
                </a>
                </div>
            </li>
            <li>
            	<div class="arrow_box">
                <a href="#" onclick="DisData('2')">
                <img src="<?php echo FRONT_IMAGE_PATH;?>slider-tab-img1.gif"  width="74" height="56" alt="">
                <small>http://www.locksmithden..</small>
                </a>
                </div>
            </li>
            <li>
            	<div class="arrow_box">
                <a href="#" onclick="DisData('3')">
                <img src="<?php echo FRONT_IMAGE_PATH;?>slider-tab-img1.gif"  width="74" height="56" alt="">
                <span class="ybg">TOP 7</span>
                <small>http://www.locksmithden..</small>
                </a>
                </div>
            </li>
        </ul>
    </div>
    <div class="arrow-naviga">
    	<span>
    	<a href="#" id='down1' class="scrd pull-left"><i id="down1" class="fa fa-sort-down"></i></a><a href="#" id='up1' style="display:none;" class="scru pull-left"><i class="fa fa-sort-up"></i></a>
        </span>
    </div>
</div>

                        <div class="main_image" id="apDiv1">

                            <div class="desc">
                                <div class="block" id="block">
                                    <div class="siteinfo">
                                        <img src="<?php echo FRONT_IMAGE_PATH; ?>apex-big-img.gif11" width="190"  alt="">
                                        <div class="infomain">
                                        <p>
                                            <label>Ranking11:</label>
                                            <span><strong>3 (Tenant background check)11</strong></span>
                                        </p>
                                        <p>
                                            <label>Page:</label>
                                            <span>www.locksmithdenvermetro.com</span>
                                        </p>
                                        <p>
                                            <label>Age:</label>
                                            <span>1 yr 9 Months</span>
                                        </p>
                                        <p>
                                            <label>Type:</label>
                                            <span>Ranked Homepage w/ 3 External Links</span>
                                            <ul class="typrank">
                                                <li>Top 10: 70% are homepages</li>
                                                <li>Top 20: 60% are home pages</li>
                                            </ul>
                                        </p>
                                        <p>
                                            <label>Size:</label>
                                            <span>77 Pages</span>
                                            <span class="pull-right">Word Count: 396</span>
                                        </p>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="bnrbtmrow">
                                        <div class="rowinfo">
                                            <span class="headlab"><strong>Keyword Score(67)</strong></span>
                                            <ul class="ks">
                                                <li><span class="wdt53">KW Anchors:</span>&nbsp;389 Links</li>
                                                <li><span>KW above fold:</span>&nbsp;Yes</li>
                                                <li><span>KW Ratio:</span>&nbsp;2.3%</li>
                                                <li><span class="wdt53">In Title:</span>&nbsp;Yes</li>
                                                <li><span>In Description:</span>&nbsp;Yes</li>
                                                <li><span>In H1:</span>&nbsp;Yes</li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="rowinfo bnr-social">
                                            <span class="headlab"><strong>Social</strong></span>
                                            <img src="<?php echo FRONT_IMAGE_PATH;?>social-like-big.gif" width="366" height="20" alt="">
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="rowinfo">
                                            <span class="headlab"><strong>Link info</strong></span>
                                            <ul class="ks">
                                                <li><span>Exact Match:</span>&nbsp;28%</li>
                                                <li><span>Related KWs:</span>&nbsp;42%</li>
                                                <li><span>Blended:</span>&nbsp;13%</li>
                                                <li><span>Brand:</span>&nbsp;12%</li>
                                                <li><span>Raw URL:</span>&nbsp;8%</li>
                                                <li><span>Using 301s:</span>&nbsp;Yes (23)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                  <div class="onpage">

            <div class='onpage-element-box' id="new-site-onpage-content"></div>
            <div class='onpage-element-box' id='long-tarm-onpage-content'></div>
            <div class='onpage-element-box' id='old-site-onpage-content'></div>



                </div>
				
				</div>
				
				<?php }else{ ?>
				
				You don't have access to this area . Please upgrade for access.
				<?php
$fcnt = 1;
foreach($packages as $row){
?>

<!--<form name="_xclick" id="rnk_permission<?=$fcnt; ?>"  action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">-->
<form name="_xclick" id="anls_permission<?=$fcnt; ?>" action="https://sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">

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
<input type="button" name="submit" value="Upgrade <?php echo $row['package_name']; ?> "
 onClick="set_analysis_permission('<?=$row['analysis_upgrade_cost']; ?>', '<?=$row['package_name']; ?> - Analysis Permission', 'anls_permission<?=$fcnt; ?>')">
<br>
 
<?php $fcnt++; }} ?>
				
				<div class="clearfix"></div>

                    <!--  Link Element -->

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
                
        </div>
    
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
   
   
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
	<script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
   <script src="<?php echo base_url();?>js/script.js"></script>
    <script src="<?php echo base_url();?>js/jquery.slicknav.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/application.js"></script> 
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.cookie.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<!--<script src="<?php echo FRONT_JS_PATH;?>bootstrap.min.js"></script>-->





