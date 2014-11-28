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

      <div class="registration">

      	<div class="registration_top">

        	<div class="top3"></div>

            <br class="spacer">

        </div>
        
        <?php if($this->session->flashdata('message')) { 
		echo $this->session->flashdata('message'); } ?>

        <div class="usr_registration">
        <form id="" name="" action="<?php echo base_url()?>userregistration/saveuser" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="registration">
            <thead>
              <tr class="rowhead">
                <th colspan="4">User Registration</th>
              </tr>
              </thead>
              
              <tbody>
              <tr>
              <td colspan="2">Following fields are required</td>
              </tr>
              
              <tr>
              <td>First Name <span class="required">*</span></td>
              <td><input type="text" name="first_name" /></td>
              </tr>
              
              <tr>
              <td>Last Name <span class="required">*</span></td>
              <td><input type="text" name="last_fees" /></td>
              </tr>
              
              <tr>
              <td>Username <span class="required">*</span></td>
              <td><input type="text" name="user_name" /></td>
              </tr>
              
              <tr>
              <td>Password <span class="required">*</span></td>
              <td><input type="password" name="password" /></td>
              </tr>
              
              <tr>
              <td>Email (Paypal Account) <span class="required">*</span></td>
              <td><input type="text" name="email" /></td>
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