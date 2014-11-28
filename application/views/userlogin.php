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
        
        <?php 
		$this->load->library('user_agent');
		if ($this->agent->is_referral())
		{
			echo $this->agent->referrer();
		}
		if($this->session->flashdata('message')) { 
		echo $this->session->flashdata('message'); } ?>

        <div class="usr_registration">
        <form id="" name="" action="<?php echo base_url()?>userlogin/authuser" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="registration">
            <thead>
              <tr class="rowhead">
                <th colspan="4">User Login</th>
              </tr>
              </thead>
              
              <tbody>
              <tr>
              <td colspan="2">Following fields are required</td>
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