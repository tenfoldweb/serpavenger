<?php $this->load->helper('url'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $page_title; ?></title>
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!--<script src="<?php //echo base_url() ?>assets/js/ajaxfileupload.js"></script>-->
<!--<script src="<?php //echo base_url()?>assets/js/Chart.js"></script>
<script src="<?php //echo base_url()?>assets/js/jquery.sparkline.min.js"></script>-->
<script src="<?php echo base_url()?>assets/js/jquery.datatables.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.jeditable.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.blockui.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery-ui-1.10.4.js"></script>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" media="all" />

<script type="text/javascript">

$(document).ready(function(){
	
	/*$('input[name=ranking_permission]').click(function(){

		$("[id^=ranking_]").hide();
		$("div [id^=ranking_] input").val('');
		
		if($(this).val() == 1)
		 $('#ranking_panel').show();
		if($(this).val() == 0)
		 $('#ranking_upgrade').show();
	})
	
	$('input[name=analysis_permission]').click(function(){
		
		$("[id^=analysis_]").hide();
		$("div [id^=analysis_] input").val('');
		
		if($(this).val() == 1)
		 $('#analysis_panel').show();
		if($(this).val() == 0)
		 $('#analysis_upgrade').show(); 
	})

	$('input[name=networkmanager_permission]').click(function(){
		
		$("[id^=networkmanager_]").hide();
		$("div [id^=networkmanager_] input").val('');
		
		if($(this).val() == 1)
		 $('#networkmanager_panel').show();
		if($(this).val() == 0)
		 $('#networkmanager_upgrade').show();
	})

	$('input[name=submitter_permission]').click(function(){
		
		$("[id^=submitter_]").hide();
		$("div [id^=submitter_] input").val('');
		
		if($(this).val() == 1)
		 $('#submitter_panel').show();
		if($(this).val() == 0)
		 $('#submitter_upgrade').show();
	})*/
});

</script>
</head>
<body>
<!--<div id="fade" class="black_overlay"></div>-->
<section class="page clearfix">
<?php $this->load->view('frontend/header');?>
  <section class="main">
    <section class="mainContent clearfix">

		 <?php $this->load->view('frontend/main_menu');?>
        <section class="">

      <div class="permission">

      	<div class="permission_top">

        	<div class="top3"></div>

            <br class="spacer">

        </div>
        
        <?php if($this->session->flashdata('message')) { 
		echo $this->session->flashdata('message'); } ?>

        <div class="usr_permission">
        <form id="" name="" action="<?php echo base_url()?>userpermissions/savepackage" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="permission">
            <thead>
              <tr class="rowhead">
                <th colspan="4">User Permissions</th>
              </tr>
              </thead>
              
              <tbody>
              <tr>
              <td>Package Name</td>
              <td><input type="text" name="package_name" /></td>
              </tr>
              
              <tr>
              <td>Monthly Fee</td>
              <td><input type="text" name="monthly_fees" /></td>
              </tr>
              
              <tr>
              <td style="vertical-align:top;">Select Permissions</td>
              <td>
              
                  <table border="0" cellspacing="0" cellpadding="0" id="panel">
                  
                  <tr>
                  <td width="500"><b>Ranking Panel</b>  <br><br>
                  <input type="radio" name="ranking_permission" value="1" /> Allow Access&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="ranking_permission" value="0" /> Deny Access
                  <div id="ranking_panel" class="panel_options">
                  Max # of keywords that can be tracked &nbsp;&nbsp;&nbsp;<input type="text" name="max_kw_track" /> <br><br>
                  Cost to add more keywords &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="more_kw_cost_ranking" /> ( / keyword) <br><br>
                  Cost to upgrade to allow access &nbsp;&nbsp;&nbsp;<input type="text" name="ranking_upgrade_cost" />
                  </div>
                 <!-- <div id="ranking_upgrade" class="panel_options">
                  
                  </div>-->
                  </td>
                  </tr>
                  
                  <tr>
                  <td width="500"><b>Analysis Panel</b>  <br><br>
                  <input type="radio" name="analysis_permission" value="1" /> Allow Access&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="analysis_permission" value="0" /> Deny Access
                  
                  <div id="analysis_panel" class="panel_options">
                  Max # of keywords analyzed monthly &nbsp;&nbsp;&nbsp;<input type="text" name="max_kw_analyzed" /> <br><br>
                  Cost to add more keywords &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="more_kw_cost_analysis" /> ( / keyword) <br><br>
                  Cost to upgrade to allow access &nbsp;&nbsp;&nbsp;<input type="text" name="analysis_upgrade_cost" />
                  </div>
                 <!-- <div id="analysis_upgrade" class="panel_options">
                  
                  </div>-->
                  </td>
                  </tr>
                  
                  <tr>
                  <td width="500"><b>Network Manager</b>  <br><br>
                  <input type="radio" name="networkmanager_permission" value="1" /> Allow Access&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="networkmanager_permission" value="0" /> Deny Access
                  <div id="networkmanager_panel" class="panel_options">
                  Max # of domains &nbsp;&nbsp;&nbsp;<input type="text" name="max_domain_no" /> <br><br>
                 <!-- Max # of HTML sites &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="max_html_no" /> <br><br>
                  Max # of Blog + domains &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="max_blogplus_no" /> <br><br>
                  Max # of blogs &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="max_blogs_no" /> <br><br>-->
                  Cost to add more domains &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="more_domain_cost" /> ( / domain) <br><br>
                  Cost to upgrade to allow access &nbsp;&nbsp;&nbsp;<input type="text" name="networkmanager_upgrade_cost" />
                  </div>
                 <!-- <div id="networkmanager_upgrade" class="panel_options">
                  
                  </div>-->
                  </td>
                  </tr>
                  
                  <tr>
                  <td width="500"><b>Submitter</b>  <br><br>
                  <input type="radio" name="submitter_permission" value="1" /> Allow Access&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="submitter_permission" value="0" /> Deny Access
                  <div id="submitter_panel" class="panel_options">
                  Max # of Scraped Runs per month &nbsp;&nbsp;&nbsp;<input type="text" name="max_scraped_runs_no" /> <br><br>
                  Max # of articles created per month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="max_article_no" /> <br><br>
                  Cost to upgrade to allow access &nbsp;&nbsp;&nbsp;<input type="text" name="submitter_upgrade_cost" />
                  </div>
                 <!-- <div id="submitter_upgrade" class="panel_options">
                  
                  </div>-->
                  </td>
                  </tr>
                  
                  <tr>
                  <td width="500"><b>Other Permissions</b>  <br><br>
                  Max # of Sites per subscription &nbsp;&nbsp;&nbsp;<input type="text" name="max_site_no_subscription" /> <br><br>
                 <!-- Max # of Parasite Sites per subscription &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="max_parasite_no_subscription" /> <br><br>
                  Max # of Money Sites per subscriptions &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="max_moneysite_no_subscription" /> <br><br>
                  Max # of Initial Set-up Runs per month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="max_no_initial_setup_runs" />-->
                  </td>
                  </tr>
                  </table>
              </td>
              </tr>
              
              <tr>
              <td></td>
              <td><input type="submit" name="save" value="Save" /></td>
              </tr>
              
              </tbody>
            </table>	
        </form>
       </div>

      </div>
    </section>

  </section>
</section>

<?php $this->load->view('frontend/footer');?>