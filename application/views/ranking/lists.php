<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <!-- Bootstrap -->
    <link href="<?php echo FRONT_CSS_PATH;?>bootstrap.min.css" rel="stylesheet">
    
    
    <!-- Main CSS SETTINGS -->
    <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>main.css" media="screen" />
    <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>responsive.css" media="screen" />
    <link rel="stylesheet" href="<?php echo FRONT_URL;?>new/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>animate.css">
    <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>style.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    
    <!-- font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	
    <!-- Datepicker -->
	<link href="<?php echo FRONT_URL;?>new/datepicker/css/datepicker.css" rel="stylesheet">
    <link href="<?php echo FRONT_IMAGE_PATH;?>prettify.css" rel="stylesheet">
 
   
   
    
    <script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>jquery.sparkline.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>Chart.js"></script>
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>pattern-fill.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>chart.js"></script>
<script type="text/javascript">
var Color={	"algo":"rgba(194, 66, 66, 0.5)",
			"off":"rgba(151, 176, 111, 0.5)",
			"offr":{
				pattern: '<?php echo FRONT_IMAGE_PATH ?>ofr.png',
				width: 6,
				height: 6
			},
			"on":"rgba(80, 157, 199, 0.5)",
			"onr":{
				pattern: '<?php echo FRONT_IMAGE_PATH ?>onr.png',
				width: 6,
				height: 6
			}
};
var dd=<?php echo  $chart_data; ?>;
var de=<?php echo  $col_data; ?>;
//console.log(dd);
$(document).ready(function() {

	$('#campaign_list').change(function(){


			var campaignValue	= $(this).val();
			var searchEngine 	= $('#search_engine_list').val();
			if(campaignValue == ''){
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?sid=' + searchEngine;
			}else{
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?cid=' + campaignValue + '&sid=' + searchEngine;
			}
		});
		$('#search_engine_list').change(function(){
			var searchEngine = $(this).val();
			var campaignValue = $('#campaign_list').val();
			if(campaignValue == ''){
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?sid=' + searchEngine;
			}else{
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?cid=' + campaignValue + '&sid=' + searchEngine;
			}
		});
		$('#search_engine_list2').change(function(){
			var searchEngine2 = $(this).val();
			var searchEngine 	= $('#search_engine_list').val();
			var campaignValue = $('#campaign_list').val();
			if(campaignValue == ''){				
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?sid=' + searchEngine + '&rcsid=' + searchEngine2;
			}else{
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?cid=' + campaignValue + '&sid=' + searchEngine + '&rcsid=' + searchEngine2;
			}
		});
	chart_val(dd);
	col_chart();
	/*$.ajax({
		url:"dataRetrieve/",
		type:"get",
		dataType:"json",
		data:{cid:<?php echo $cid; ?>,sid:"<?php echo $sid; ?>"},
		success:function(d){
			console.log(d);
		}
	});*/
    /*$.ajax({
		url:"data.json",
		dataType:"json",
		success: function(d){
			chart_val(d);
		}
	});*/
});

</script>
<style type="text/css">
.thetooltip {
	border: 1px solid #2f7ed8;
	background-color: #fff;
	opacity: 0.8500000000000001;
	padding: 4px 12px;
	border-radius: 3px;
	position: absolute;
	top: 10px;
	box-shadow: 1px 1px 3px #666;
	font-size: 12px;
	color: #333333
}
svg>text[text-anchor="end"]:last-child {
	display: none
}
</style>
<?php require ('front-app/libraries/gChart.php');;?>
    

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
                        <li class="current-menu-item"><a href="<?php echo FRONT_URL;?>ranking">Rankings</a></li>
                        <li><a href="<?php echo FRONT_URL;?>analysis">Analysis</a></li>
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
                    <a href="<?php echo FRONT_URL;?>campaign" class="linktext">+ Add More</a>
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
                                    <select id="campaign_list" name="selectblogtype" class="dropdown-select">
                                    <?php
			    if(is_array($campaign_list) && count($campaign_list) > 0){
					for($i=0; $i<count($campaign_list); $i++){
			    ?>
        <option value="<?php echo stripslashes($campaign_list[$i]['campaign_id']);?>" <?php if($cid == $campaign_list[$i]['campaign_id']){echo 'selected';}?>><?php echo stripslashes($campaign_list[$i]['campaign_title']);?></option>
        <?php
						if(is_array($campaign_list[$i]['campaign']) && count($campaign_list[$i]['campaign']) > 0){
							for($j=0; $j<count($campaign_list[$i]['campaign']); $j++){
			    ?>
        <option value="<?php echo $campaign_list[$i]['campaign'][$j]['keyword_id'] . '-' . $campaign_list[$i]['campaign'][$j]['campaign_id'];?>"><?php echo '----' . stripslashes($campaign_list[$i]['campaign'][$j]['keyword']);?></option>
        <?php
						}
					}
				}
			    }
			    ?>  
                                    <option value="Traditional Blog">Traditional Blog</option>
                                    <option value="HPBL">HPBL</option>
                                    <option value="Mini Money">Mini Money</option>
                                    </select>
                                    </div>
                                </div>
                                
                                <!--<div class="filterby">
                                    <span>Filter By:</span> 
                                    <div class="dropdown">
                                        <select id="selectblogtype" name="selectblogtype" class="dropdown-select">
                                        <option value="Google">Google</option>  
                                        <option value="Yahoo">Yahoo</option>
                                        <option value="Bing">Bing</option>
                                        </select>
                               		 </div>
                                </div>-->
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                	
                    <!-- Top row Start -->
                    <div class="mtrranking-row">
                    	<div class="row">
                            <div class="col-md-5 col-md-5-1">
                                 <!-- serprank Start -->
                                <div class="serprank">
                                    <!-- image placeholder Start -->
                                    <div class="imgholder">
                                        <img src="<?php echo FRONT_IMAGE_PATH;?>apex-big-img.gif" alt="">
                                    </div>
                                    <!-- SERP Ranking chart Start -->
                                </div>
                                
                                <div class="viewkeyword">
                                <div class="metersecheader ">SERP Ranking</div>
                                <div class="fropfilter">
                                <div class="dropdown">
                                    <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                        <option value="Google">View Keywords</option>  
                                        <option value="Yahoo">Yahoo</option>
                                        <option value="Bing">Google</option>
                                    </select>
                                </div>
                                 <div class="dropdown pull-right">
                                    <select class="dropdown-select" name="selectblogtype" id="search_engine_list">
                                        
          <option value="yahoo" <?php if($sid == 'yahoo'){echo 'selected';}?>>Yahoo</option>
          <option value="bing" <?php if($sid == 'bing'){echo 'selected';}?>>Bing</option>
          <option value="google" <?php if($sid == 'google'){echo 'selected';}?>>Google</option>
                                    </select>
                                </div>
                                </div>
                                
                                <!-- rating-block Start -->
                                <div class="rating-block">
                                <ul>
                                    <li>
                                        <p>
                                            <span class="lightblue"></span>Colorado Locksmith 
                                            <span class="levelno">7</span> 
                                            <span class="badge small-badge small-badgegreen  pull-right">+1</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <span class="darkblue"></span>Aurora Lock and Key 
                                            <span class="levelno">9</span> 
                                            <span class="badge small-badge small-badgered pull-right">-2</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <span class="pgreen"></span>Cheap Locksmith CO  
                                            <span class="levelno">3</span> 
                                            <span class="badge small-badge small-badgegreen  pull-right">+1</span>
                                        </p>
                                    </li>
                                </ul>
                                </div>
                                
                                </div>
                                
                            </div>
                        
                            <div class="col-md-5 col-md-5-2 bdrRL">
                                <div class="serp-ta mtrranking-row-block">
                                    <div class="sta pull-left">
                                    <div class="metersecheader ">SERP Tracking & Analysis</div>
                                    <p class="headgrey">New VS Dropped Sites:</p>
                                    <!-- topno-row -->
                                    <div class="topno-row">
                                    <!--<span class="rank-count">Top 3</span>-->
                                    <span><img src="<?php echo FRONT_IMAGE_PATH;?>top10.png" alt="" class="pull-left"></span>
                                    <div class="stablock mgrR">
                                         <ul>
                                            <li class="pull-left"><img src="<?php echo FRONT_IMAGE_PATH;?>sta-img.png" width="80" height="16" alt=""></li>
                                            <li class="pull-right">
                                                <p>
                                                    <span class="sta-blue"></span> New <small class="green"><?php echo $new_url_top10;?></small>
                                                </p>
                                                <p>
                                                    <span class="sta-blue"></span> Drop <small class="red"><?php echo $drop_url_top10;?></small>
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <!-- topno-row -->
                                    <div class="topno-row">
                                    <!--<span class="rank-count">Top 3</span>-->
                                    <span><img src="<?php echo FRONT_IMAGE_PATH;?>top20.png" alt="" class="pull-left"></span>
                                    <div class="stablock bdrbtm">
                                         <ul>
                                            <li class="pull-left"><img src="<?php echo FRONT_IMAGE_PATH;?>sta-img.png" width="80" height="16" alt=""></li>
                                            <li class="pull-right">
                                                <p>
                                                    <span class="sta-blue"></span> New <small class="green"><?php echo $new_url_top20;?></small>
                                                </p>
                                                <p>
                                                    <span class="sta-blue"></span> Drop <small class="red"><?php echo $drop_url_top20;?></small>
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    </div>
                                    </div>
                                    
                                    </div>
                                <div class="sta-graph pull-right">
                                <div class="serp-meter mtrranking-row-block">
                                    <div class="metersecheader ">SERP Meter <?php echo $serp_meter_stat?>%</div>
                                    <!--img width="176" alt="" src="<?php echo FRONT_IMAGE_PATH;?>meter-0.gif"-->
                                    <?php
					 if($serp_meter_stat <= 0){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="0%">';
					}elseif($serp_meter_stat > 0 && $serp_meter_stat <= 10){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="10%">';
					}elseif($serp_meter_stat > 10 && $serp_meter_stat <= 20){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="20%">';
					}elseif($serp_meter_stat > 20 && $serp_meter_stat <= 30){
						echo '<img width="176" alt=""src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="30%">';
					}elseif($serp_meter_stat > 30 && $serp_meter_stat <= 40){
						echo '<img width="176" alt=""  src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="40%">';
					}elseif($serp_meter_stat > 40 && $serp_meter_stat <= 50){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="50%">';
					}elseif($serp_meter_stat > 50 && $serp_meter_stat <= 60){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="60%">';
					}elseif($serp_meter_stat > 60 && $serp_meter_stat <= 70){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="70%">';
					}elseif($serp_meter_stat > 70 && $serp_meter_stat <= 80){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="80%">';
					}elseif($serp_meter_stat > 80 && $serp_meter_stat <= 90){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="90%">';
					}elseif($serp_meter_stat > 90 && $serp_meter_stat <= 100){
						echo '<img width="176" alt="" src="'.FRONT_IMAGE_PATH.'meter-0.gif" alt="100%">';
					}
					?>
                                    <span class="serpmeter-canvas"><img src="<?php echo FRONT_IMAGE_PATH;?>serp-meter-graph.gif" class="img-responsive" align="center"  alt=""></span>
                                </div>
                                
                                 
                               
                                </div>
                                </div>
                            </div>
                          <div class="col-md-2">
                            <div class="metersecheader ">Tools</div>
                              <ul class="tools">
                               	  <li><img src="<?php echo FRONT_IMAGE_PATH;?>KeywordsIcon.gif" width="16" height="16" alt=""> <span>15 Keyword <a data-toggle="modal" data-target="#addKeywords">+ Add Keywords</a> <a data-toggle="modal" data-target="#ManageKeywords">+ Manage Keywords</a></span>
                                  </li>
                                   <!-- More domains popup -->
                                    <div class="modal fade new5popup" id="addKeywords" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header popup-header">
                                        <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Add Keywords</h4>
                                      </div>
                                      <div class="modal-body popupbody">
                                        <h2>What Keyword(s) would you like to add to this campaign?</h2>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                            <tr>
                                             <td>
                                             <ul>
                                             <li>	
                                                <span class="add_text">Campaign</span>
                                                <div class="dropdown drop_right">
                                                <select class="dropdown-select" name="selectnetwork" id="selectnetwork">
                                                <option value="1">Denver Locksmith</option>
                                                </select>
                                                </div>
											</li>
                                            <li>
                                                <span class="add_text">Site</span>
                                                <div class="dropdown drop_right drpdrp">
                                                <img alt="" src="<?php echo FRONT_IMAGE_PATH;?>Parasite.gif">
                                                <select class="dropdown-select" name="selectnetwork" id="selectnetwork">
                                                <option value="1">www.tenantverfication.com</option>
                                                </select>
                                                </div>
                                            </li>
                                            </ul>
                                            </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td>
                                                <ul>
                                                <li>
                                                    <span class="add_text">Serp Index</span>
                                                    <div class="drpright">
                                                    <div class="droptextd">
                                                     <div class="checkbox12">
                                                           <input id="select_coun1" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="select_coun1" name="checkbox1_lbl"></label>
                                                          </div>
                                                            <img src="<?php echo FRONT_IMAGE_PATH;?>add_key_1.jpg">
                                                            <div class="dropdown">
                                                                <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                                                    <option value="Blog+">United States</option>  
                                                                </select>
                                                            </div>
															<div class="clearfix"></div>
                                                         </div> 
                                                         
                                                         <div class="droptextd">
                                                     		<div class="checkbox12">
                                                           <input id="select_coun2" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="select_coun2" name="checkbox1_lbl"></label>
                                                          </div>
                                                            <img src="<?php echo FRONT_IMAGE_PATH;?>add_key_2.jpg">
                                                            <div class="dropdown">
                                                                <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                                                    <option value="Blog+">Select Country</option>  
                                                                </select>
                                                            </div>
 															<div class="clearfix"></div>
                                                         </div>
                                                        
                                                         <div class="droptextd">
                                                     		<div class="checkbox12">
                                                           <input id="select_coun3" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="select_coun3" name="checkbox1_lbl"></label>
                                                          </div>
                                                            <img src="<?php echo FRONT_IMAGE_PATH;?>add_key_3.jpg">
                                                            <div class="dropdown">
                                                                <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                                                    <option value="Blog+">Select Country</option>  
                                                                </select>
                                                            </div>
   															<div class="clearfix"></div>
                                                         </div>
                                                         
														<div class="clearfix"></div>
                                                         
                                                        </div> 
                                                </li>
                                                <li>
                                                	<div class="exact_url">
                                                        <h4>Do you need to track an exact URL ?</h4>
                                                        <div class="radio_bnt_tt">
                                                            <input id="yes_please" class="css-checkbox" type="radio" checked="checked" name="default-network">
                                                            <label class="css-label radGroup1" for="yes_please"> Yes, Please!</label>
                                                        </div>
                                                        <input type="text" name="" class="url_text" value="" placeholder="(enter exact URL address here)">

                                                        <div class="radio_bnt_tt">
                                                            <input id="no_please" class="css-checkbox" type="radio" name="default-network">
                                                            <label class="css-label radGroup1" for="no_please" style="font-weight:600; font-size:12px;">No, Please lookfor any of my pages ranking<br><i>(Don't use this optionfor parasite pages!)</i></label>
                                                        </div>

                                                     </div>   
                                            </li>
                                            </ul>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td>
                                                	<ul>
                                                    	<li>
                                                        
                                                        	<span class="add_text">+ Keywords</span>
                                                           <div class="drpright textarea_size">
                                                           		<textarea rows="5" cols="" name=""></textarea>
                                                               <button class="btn btn-primary" type="button">Add Keywords  </button>                                                            </div>

                                                        </li>
                                                    	<li>
                                                       	<div class="exact_url">
                                                        	<p><i class="fa fa-angle-double-right"></i> Add one kewword per line.<span>(type in keyword, then hit enter.)</span></p>
                                                            
                                                            <p><i class="fa fa-angle-double-right"></i> Duplicates are automatically removed.</p>
                                                            
                                                            <p><i class="fa fa-angle-double-right"></i> Please don't comma separate words.</p>
                                                           <div class="orandbnt"> 
                                                            <span class="or">OR</span>
                                                            <button class="btn btn-default" type="button" data-dismiss="modal">Manage Keywords</button>
                                                            </div>
                                                           </div>
                                                            
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            
                                        </table>                                            
                                            
                                      </div>
                                    </div>
                                    </div>
                                    </div>
                                    
                                    <div class="modal fade" id="ManageKeywords" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog new5popup">
                                    <div class="modal-content">
                                      <div class="modal-header popup-header">
                                        <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Manage Keywords</h4>
                                      </div>
                                      <div class="modal-body popupbody">
                                        <h2>Manage your keywords by campaign</h2>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                            <tr>
                                             <td>
                                             <ul>
                                             <li>	
                                                <span class="add_text">Campaign</span>
                                                <div class="dropdown drop_right">
                                                <select class="dropdown-select" name="selectnetwork" id="selectnetwork">
                                                <option value="1">Denver Locksmith</option>
                                                </select>
                                                </div>
											</li>
                                            <li>
                                                <span class="add_text">Site</span>
                                                <div class="dropdown drop_right drpdrp">
                                                <img alt="" src="<?php echo FRONT_IMAGE_PATH;?>Parasite.gif">
                                                <select class="dropdown-select" name="selectnetwork" id="selectnetwork">
                                                <option value="1">www.tenantverfication.com</option>
                                                </select>
                                                </div>
                                            </li>
                                            </ul>
                                            </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td>
                                                    <span class="add_text">Serp Index</span>
                                                    <div class="drpright">
                                                    <div class="droptextd left3text">
                                                     <div class="checkbox12">
                                                           <input id="select_coun4" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="select_coun4" name="checkbox1_lbl"></label>
                                                          </div>
                                                            <img src="<?php echo FRONT_IMAGE_PATH;?>add_key_1.jpg">
                                                            <div class="dropdown">
                                                                <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                                                    <option value="Blog+">United States</option>  
                                                                </select>
                                                            </div>
															<div class="clearfix"></div>
                                                         </div> 
                                                         
                                                         <div class="droptextd left3text">
                                                     		<div class="checkbox12">
                                                           <input id="select_coun5" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="select_coun5" name="checkbox1_lbl"></label>
                                                          </div>
                                                            <img src="<?php echo FRONT_IMAGE_PATH;?>add_key_2.jpg">
                                                            <div class="dropdown">
                                                                <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                                                    <option value="Blog+">Select Country</option>  
                                                                </select>
                                                            </div>
 															<div class="clearfix"></div>
                                                         </div>
                                                        
                                                         <div class="droptextd left3text">
                                                     	<div class="checkbox12">
                                                           <input id="select_coun6" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="select_coun6" name="checkbox1_lbl"></label>
                                                          </div>
                                                            <img src="<?php echo FRONT_IMAGE_PATH;?>add_key_3.jpg">
                                                            <div class="dropdown">
                                                                <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                                                    <option value="Blog+">Select Country</option>  
                                                                </select>
                                                            </div>
   															<div class="clearfix"></div>
                                                         </div>
                                                         
														<div class="clearfix"></div>
                                                         
                                                        </div> 
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td>
                                                    <table class="table keytable">
                                                      <thead>
                                                        <tr>
                                                          <th>Keyword</th>
                                                          <th>Type</th>
                                                          <th>Url</th>
                                                          <th>Exact</th>
                                                          <th><img src="<?php echo FRONT_IMAGE_PATH;?>delete_ico.png"></th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                        <tr>
                                                          <td>Denver Locksmith</td>
                                                          <td><strong>Main</strong><img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>www.locksmithdenermetro.com/lock-out...</td>
                                                          <td>Yes<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>
                                                         <div class="checkbox12">
                                                           <input id="delete1" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="delete1" name="checkbox1_lbl"></label>
                                                          </div>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                          <td>Denver Lock</td>
                                                          <td>Secondary<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>www.locksmithdenermetro.com/lock-out...</td>
                                                          <td>Yes<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>
                                                        <div class="checkbox12">
                                                           <input id="delete2" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="delete2" name="checkbox1_lbl"></label>
                                                          </div>

                                                          </td>
                                                        </tr>
                                                        <tr>
                                                          <td>Aurora Locksmith</td>
                                                          <td>Supporting<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>www.locksmithdenermetro.com/</td>
                                                          <td>No<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>
                                                        <div class="checkbox12">
                                                           <input id="delete3" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="delete3" name="checkbox1_lbl"></label>
                                                          </div>

                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <td>Locksmith </td>
                                                          <td>Supporting<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>www.locksmithdenermetro.com/</td>
                                                          <td>No<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>
                                                        <div class="checkbox12">
                                                           <input id="delete4" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="delete4" name="checkbox1_lbl"></label>
                                                          </div>
                                                          	
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <td>Locked out</td>
                                                          <td>Supporting<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>www.locksmithdenermetro.com/</td>
                                                          <td>No<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>
                                                        <div class="checkbox12">
                                                           <input id="delete5" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="delete5" name="checkbox1_lbl"></label>
                                                          </div>
                                                          
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <td>Denver Area Lock</td>
                                                          <td>Supporting<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>www.locksmithdenermetro.com/denver-lo...</td>
                                                          <td>Yes<img src="<?php echo FRONT_IMAGE_PATH;?>gray-arrow.png"></td>
                                                          <td>
                                                        <div class="checkbox12">
                                                           <input id="delete6" class="css-checkbox" type="checkbox" checked="checked">
                                                           <label class="label-chkbx lite-gray-check" for="delete6" name="checkbox1_lbl"></label>
                                                          </div>
                                                          </td>
                                                        </tr>

                                                        
                                                      </tbody>
                                                    </table>
                                                    
                                                    <button class="btn btn-primary" type="button">Save Changes</button>                                                           
                                                    <div class="orandbnt orbntSave"> 
                                                    <span class="or">OR</span>
                                                    <button class="btn btn-default" type="button" data-dismiss="modal">Add Keywords</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>                                            
                                            
                                      </div>
                                    </div>
                                    </div>
                                    </div>
                                  
                                  <li><img src="<?php echo FRONT_IMAGE_PATH;?>SEOTestIcon.gif" width="16" height="14" alt=""> <span>15 Keyword <a data-toggle="modal" data-target="##">+ Manage Tests</a></span></li>
                                   <!-- More domains popup -->
                                    
                              </ul>
                            </div>
                        </div>
                        
                        
                    </div>
                    <!-- Top row End -->
                
                    <!--<div class="active-com">
                    	<ul>
                        	<li>
                            	<p>Active Campaigns <a href="">+ Add Campaign</a></p>
                                <span>5</span>
                            </li>
                            <li>
                            	<p>Keywords <a href="">+ Add Keyword</a></p>
                                <span>135</span>
                            </li>
                            <li>
                            	<p>Money/Client Sites <a href="">+ Add More</a></p>
                                <span>4</span>
                            </li>
                            <li>
                            	<p>Parasite Pages <a href="">+ Add More</a></p>
                                <span>0</span>
                            </li>
                            <li>
                            	<p>Ranking Tests (SEO) <a href="">+ Create New Test</a></p>
                                <span>14</span>
                            </li>
                        </ul>
                    </div>-->
                    
                    <div class="clearfix"></div>
               	  <!-- Ranking Chart -->
                    
                	<div class="inner-table rankingchart">
                        <div class="panel-heading-tbl">
                            <h4>Ranking Chart</h4>
                            <i class="fa fa-question query pull-right"></i>
                            
                        </div>
                        <div class="clearfix"></div>
                        <div class="panel-body-tbl">
                        	<div class="pull-left" style="width:100%">
                        	<div class="rankChart-info">
                            	<label><a href="javascript:;" id="showchartinfo">Show <i class="fa fa-caret-down"></i></a></label>
                                <ul class="aa">
                                	<li><span class="cf-lightred"></span> Algo update</li>
                                    <li><span class="cf-lightgreen"></span> Offpage test</li>
                                    <li><span><img src="<?php echo FRONT_IMAGE_PATH;?>dotdot1.gif" alt=""></span> Reversed offpage</li>
                                    <li><span class="cf-lightblue"></span> Onpage test</li>
                                    <li><span><img src="<?php echo FRONT_IMAGE_PATH;?>dotdot1.gif" alt=""></span> Reversed onpage</li>
                               </ul>
                              
                             </div>
                            </div>
							<div class="carveMapSec">
                            	<img src="<?php echo FRONT_IMAGE_PATH;?>ranking-chart-img.gif" class="img-responsive" style="width:100%; height:220px" alt="">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    
                    <!--  Ranking by ketword-->
                    
                    <div class="inner-table rankingchart">
                        <div class="panel-heading-tbl">
                            <h4>Ranking Chart</h4>
                            <i class="fa fa-question query pull-right"></i>
                            
                        </div>
                        <div class="clearfix"></div>
                        <div class="panel-body-tbl-onpage">
                        <div class="rbktoprow">
                            <div class="pull-left srb">
                                <span>First choose a Campaign:</span> 
                                <div class="dropdown">
                                <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                <option value="Google">Choose a Campaign</option>  
                                <option value="Yahoo">Yahoo</option>
                                <option value="Bing">Bing</option>
                                </select>
                                </select>
                                </div>
                            </div>
                            <ul class="pull-right btns-group">
                                <li><button data-dismiss="modal" class="btn btn-default" onClick="window.location.href='<?php echo FRONT_URL;?>analysis'" type="button">Add Ranking Analysis</button></li>
                                <li><button data-toggle="modal" class="btn btn-default" type="button" data-target="#startaseotest">Start a SEO Test</button></li>
                                <li><button class="btn btn-primary" onClick="window.location.href='<?php echo FRONT_URL;?>campaign'" type="button">Add Campaign</button></li>
                                <li><button class="btn btn-primary" type="button">Add Keyword</button></li>
                            </ul>
                            
                          

                            
                        </div>
                        <div class="clearfix"></div>
                          <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-bordered ranking-tbl">
                              
                              <tr>
                                <th>Site</th>
                                <th>Keywords</th>
                                <th>Keyword</th>
                                <th>Google</th>
                                <th>Trend</th>
                                <th>Bing</th>
                                <th>Trend</th>
                                <th>Yahoo</th>
                                <th>Trend</th>
                                <th>Tests</th>
                              </tr>
                               <?php
				//pr($campaign_record, 0);
				if(is_array($campaign_record) && count($campaign_record) > 0) {
				  for($i=0;$i<count($campaign_record);$i++) {
				?>
        <tr>
          <td><img src="<?php echo FRONT_IMAGE_PATH;?>table-icon1.jpg"  alt=""/><?php echo stripslashes($campaign_record[$i]['campaign_title']);?>(<?php echo $campaign_record[$i]['total_campaign'];?>)</td>
          <td><?php echo stripslashes($campaign_record[$i]['total_kw']);?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <?php
					if(is_array($campaign_record[$i]['campaigns']) && count($campaign_record[$i]['campaigns']) > 0){
					    $campaignlist   = $campaign_record[$i]['campaigns'];
					    for($j=0; $j<count($campaignlist); $j++){
						if(is_array($campaignlist[$j]['seo_ranking'])){
							    $seoCount = count($campaignlist[$j]['seo_ranking']);
							}else{
							    $seoCount = 0;
							}
						$parse_url  = parse_url($campaignlist[$j]['campaign_main_page_url']);
						
						$curr_google_rank = $campaignlist[$j]['google_rank'];
						$prev_gogole_rank = $campaignlist[$j]['prev_google_rank'];
						$google_diff_rank = $curr_google_rank-$prev_gogole_rank;
						if($curr_google_rank > 0){
							$percent_google_rank = ($google_diff_rank/$curr_google_rank)*100;
						}else{
							$percent_google_rank = 0;
						}
						
						$curr_yahoo_rank = $campaignlist[$j]['yahoo_rank'];
						$prev_yahoo_rank = $campaignlist[$j]['prev_yahoo_rank'];
						$yahoo_diff_rank = $curr_yahoo_rank-$prev_yahoo_rank;
						if($curr_yahoo_rank > 0){
							$percent_yahoo_rank = ($yahoo_diff_rank/$curr_yahoo_rank)*100;
						}else{
							$percent_yahoo_rank = 0;
						}
						
						$curr_bing_rank = $campaignlist[$j]['bing_rank'];
						$prev_bing_rank = $campaignlist[$j]['prev_bing_rank'];
						$bing_diff_rank = $curr_bing_rank-$prev_bing_rank;
						if($curr_bing_rank > 0){
							$percent_bing_rank = ($bing_diff_rank/$curr_bing_rank)*100;
						}else{
							$percent_bing_rank = 0;
						}
					?>
				
                              <tr>
                               <td><?php if($campaignlist[$j]['campaign_site_type'] == 1){?>
            <img src="<?php echo FRONT_IMAGE_PATH;?>table-icon2.jpg"  alt=""/>
            <?php }elseif($campaignlist[$j]['campaign_site_type'] == 2){?>
            <img src="<?php echo FRONT_IMAGE_PATH;?>table-icon3.jpg"  alt=""/>
            <?php } ?>
            <?php echo $parse_url['host'];?></td>
                               <td><?php echo stripslashes($campaignlist[$j]['total_kw']);?> <ul class="pull-right">
                                    	<li><a href="" class="yellowlink">+Add</a></li>
                                        <li><a class="bluelink" onclick="show()" id ="show_content">Show</a></li>
                                    </ul></td>
                                <td><?php echo stripslashes($campaignlist[$j]['campaign_main_keyword']);?></td>
                                <td><?php echo stripslashes($campaignlist[$j]['google_rank']);?>
                                <a href="#" class="<?php if($google_diff_rank >= 0){echo 'green';}else{echo 'red';}?>"><?php echo ($google_diff_rank);?></a>
                              </td>
                                <td id="trend_google_<?php echo $j;?>"></td>
                                <td><?php echo stripslashes($campaignlist[$j]['bing_rank']);?> <a href="#" class="<?php if($bing_diff_rank >= 0){echo 'green';}else{echo 'red';}?>"><?php echo ($bing_diff_rank);?></a></td>
                                <td id="trend_bing_<?php echo $j;?>"></td>
                                <td><?php echo stripslashes($campaignlist[$j]['yahoo_rank']);?> <a href="#" class="<?php if($yahoo_diff_rank >= 0){echo 'green';}else{echo 'red';}?>"><?php echo ($yahoo_diff_rank);?></a></td>
                                 <td id="trend_yahoo_<?php echo $j;?>"></td>
                                <td><?php echo $seoCount;?> <a href="<?php echo FRONT_URL;?>seoranking/">+add</a></td>
                              </tr>
                          <script>
						$("#trend_google_<?php echo $j;?>").sparkline([<?php echo implode(",", $campaignlist[$j]['google_trend']);?>], {
						type: 'line',
						width: '60',
						height: '11',
						lineColor: '#6f98ae'});
						
						$("#trend_yahoo_<?php echo $j;?>").sparkline([<?php echo implode(",", $campaignlist[$j]['yahoo_trend']);?>], {
						type: 'line',
						width: '60',
						height: '11',
						lineColor: '#6f98ae'});
						
						$("#trend_bing_<?php echo $j;?>").sparkline([<?php echo implode(",", $campaignlist[$j]['bing_trend']);?>], {
						type: 'line',
						width: '60',
						height: '11',
						lineColor: '#6f98ae'});
					</script>
        <?php
							}
						    }
						}
					      }
					?>
                           </table>
                </div>
                    </div>
                    
            	</div>
            
        </div>
    </div>
    
    
  <!-- More Start a SEO Test popup -->
 <div class="modal fade new5popup" id="startaseotest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header popup-header">
                                        <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Create New SEO Test</h4>
                                      </div>
                                      <div class="modal-body popupbody">
                                        <h2>Find out what’s working and what’s failing by graphing the results.</h2>
                                <form method="post" action="">
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                            <tr>
                                             <td>
                                             <ul>
                                             <li>	
                                                <span class="add_text">Campaign</span>
                                                <div class="dropdown drop_right">
                                                <select class="dropdown-select" name="campaign_id" id="selectnetwork">
                                                <?php
		    if(is_array($campaign_data) && count($campaign_data) > 0){
			for($i=0; $i<count($campaign_data); $i++){
		    ?>			
			<optgroup title="<?php echo stripslashes($campaign_data[$i]['campaign_title']);?>"></optgroup>
		    <?php
				if(is_array($campaign_data[$i]['campaign']) && count($campaign_data[$i]['campaign']) > 0){
					for($j=0; $j<count($campaign_data[$i]['campaign']); $j++){
		    ?>
						<option value="<?php echo $campaign_data[$i]['campaign'][$j]['campaign_id'];?>"><?php echo stripslashes($campaign_data[$i]['campaign'][$j]['keyword']);?></option>
		    <?php
					}
				}
			}
		    }
		    ?>
                                                </select>
                                                </div>
											</li>
                                            <li>
                                                <span class="add_text">Site</span>
                                                <div class="dropdown drop_right drpdrp">
                                                <img alt="" src="<?php echo FRONT_IMAGE_PATH;?>Parasite.gif">
                                                <select class="dropdown-select" name="selectnetwork" id="selectnetwork">
                                                <option value="1">www.tenantverfication.com</option>
                                                </select>
                                                </div>
                                            </li>
                                            </ul>
                                            </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td class="page_tst">
                                                   	<h2><span>1</span> What type of SEO test would you like to create?</h2>
                                                	<ul>
                                                    	<li>
                                                  <input id="offpage_test" class="css-checkbox" type="checkbox" checked="checked">
                                     <label class="label-chkbx lite-gray-check" for="offpage_test" name="checkbox1_lbl">Offpage Test<br>
                                                         <span>Link building, or off site factors.    </span></label>      
                                                        </li>
                                                        
                                                    	<li>
                                                        <input id="onpage_test" class="css-checkbox" type="checkbox" checked="checked">
                                                        <label class="label-chkbx lite-gray-check" for="onpage_test" name="checkbox1_lbl"><span class="onpgts">Onpage Test</span><br>
                                                         <span>Site optimization, or on site factors.</span></label>      
                                                        </li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                    <div class="TitleofTest">
                                                    <p>
                                                    	<span class="add_text">Title of Test</span>
                                                        <input type="text" name="" value="<?php echo stripslashes(set_value('title'));?>" placeholder="Enter Brief Description.  (This will appear on the chart)"/>
                                                     </p>
                                                     <p>
                                                    	<span class="add_text">My Notes</span>
                                                        <textarea name="" rows="5"><?php echo stripslashes(set_value('description'));?></textarea>
                                                     </p>
                                                     <div class="clearfix"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td class="date_pickr">
                                                	<h2><span>2</span>Select a Start Date:</h2>
                                                    
                                                    <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                        <input class="span2" size="16" type="text" value="12-02-2012" readonly>
                                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    
                                                    <div class="add_color_shading">
                                                        <ul>
                                                        	<li>
                                                            	<span class="add_text">Shading to chart:</span>
                                                            </li>
                                                        	<li>
                                                                <div class="radio_bnt_tt">
                                                                    <input type="radio" name="default-network" class="css-checkbox" id="3days">
                                                                    <label for="3days" class="css-label radGroup1">3 days</label>
                                                                </div>
                                                             </li>
                                                             
                                                        	<li>
                                                                <div class="radio_bnt_tt">
                                                                    <input type="radio" name="default-network" class="css-checkbox" id="1week">
                                                                    <label for="1week" class="css-label radGroup1"> 1 week</label>
                                                                </div>
                                                             </li>
                                                             
                                                        	<li>
                                                                <div class="radio_bnt_tt">
                                                                    <input type="radio" name="default-network" class="css-checkbox" id="3week">
                                                                    <label for="3week" class="css-label radGroup1"> 3 week</label>
                                                                </div>
                                                             </li>   
   
   
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td class="keywordimp">
                                                	<h2><span>3</span>Specify which keywords/pages are impacted:</h2>
                                                    <ul>
                                                    	<li>
                                                        <input id="selectal" class="css-checkbox" type="checkbox" checked="checked">
                                                        <label class="label-chkbx lite-gray-check" for="selectal" name="checkbox1_lbl"><span class="swkpr">Select All (applies to all keywords and pages within campaign)</span></label>      							
                                                        </li>
                                                        <li><span class="or">OR</span></li>
                                                        <li>
                                                        <input id="selectkey" class="css-checkbox" type="checkbox" checked="checked">
                                                        <label class="label-chkbx lite-gray-check" for="selectkey" name="checkbox1_lbl"><span class="swkpr">Select Keywords that are impacted. </span></label>                                                        </li>
                                                        <li>
                                                        <input id="selectpeg" class="css-checkbox" type="checkbox" checked="checked">
                                                        <label class="label-chkbx lite-gray-check" for="selectpeg" name="checkbox1_lbl"><span class="swkpr">Select Pages that are impacted.</span></label>                                                        </li>
                                                      </ul>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td class="bnt_p_de">
          <!--button class="btn btn-primary" type="button">Create SEOTest<button-->                                                           <input type="hidden" name="action" value="Process"><input name="submit" type="submit" value="Create SEO Test" class="btn btn-primary" style="width:124px;"/>                                        
                                                    <button class="btn btn-default" type="button" data-dismiss="modal">Manage Tests</button>
                                                </td>
                                            </tr>
                                            
                                        </table>                                            
                                         </form>   
                                      </div>
                                    </div>
                                    </div>
                                    </div>    
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo FRONT_JS_PATH;?>bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>jquery.verticalCarousel.min.js"></script>
    <script src="<?php echo FRONT_JS_PATH;?>script.js"></script>
    <script src="<?php echo FRONT_JS_PATH;?>jquery.slicknav.js"></script>
    <script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>application.js"></script> 
    <script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>jquery.cookie.js"></script>
    <!--    click radio button show hide textbox   -->
    
    <script>
    $(document).ready(function (){
			$("#yes_please").click( function(){
			$(".url_text").show(100);
			});
			$("#no_please").click(function(){
			$(".url_text").css("display","none");
			});
		});

	 $(document).ready(function () 
	 { alert("Hello World"); }); 
	 

    
    
    <script src="http://axattechnologies.in/demo/serp-new/datepicker/js/prettify.js"></script>
    <script src="http://axattechnologies.in/demo/serp-new/datepicker/js/bootstrap-datepicker.js"></script>
	<script>
	if (top.location != location) {
    top.location.href = document.location.href ;
  }
		$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'mm-dd-yyyy'
			});
			$('#dp2').datepicker();
			$('#dp3').datepicker();
			$('#dp3').datepicker();
			$('#dpYears').datepicker();
			$('#dpMonths').datepicker();
			
			
			var startDate = new Date(2012,1,20);
			var endDate = new Date(2012,1,25);
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('The end date can not be less then the start date');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
		});
	</script>

    
    
    
  </body>
</html>
