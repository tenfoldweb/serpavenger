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

function set_subscription(pck_id, pck_name, pck_fee)
{
	$('input[name=item_number]').val(pck_id);
	$('input[name=item_name]').val(pck_name);
	$('input[name=a3]').val(pck_fee);
	
	$('#redirect_msg').show();
	$('#upgrade').submit();
}
</script>

<style>
#redirect_msg, span[id^=msg]
{
 color:#F00;
 display:none;
}
</style>

</head>
<body>
<section class="page clearfix">
<?php $this->load->view('frontend/header');?>
  <section class="main">
    <section class="mainContent clearfix">

		 <?php $this->load->view('frontend/main_menu');?>
        <section class="">

      <div class="package">

      	<div class="package_top">

        	<div class="top3"></div>

            <br class="spacer">

        </div>

        <div class="usr_permission">
       
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="permission">
            <thead>
              <tr class="rowhead">
                <th colspan="4">Buy New Package</th>
              </tr>
              </thead>
              
              <tbody>
              
              <tr>
              <td>Package Name</td>
              <td>Monthly Fee</td>
              <td></td>
              </tr>
              
              <?php if(isset($package) && count($package) > 0) {
			  foreach($package as $key=>$pckg) { ?>
              <tr>
              <td> <?=$pckg['name']; ?> </td>
              <td> $<?=$pckg['fee']; ?> (<?=$pckg['upgrade_cost']; ?>% Discount on $<?=$pckg['actual_cost']; ?>) </td>
              <td>
              <input type="button" name="submit" value="Subscribe" onClick="set_subscription(<?=$key; ?>, '<?=$pckg['name']; ?>', '<?=$pckg['fee']; ?>')">
              </td>
              </tr>
              <?php } ?>
              
              <tr>
              <td colspan="2">
               <!--<form name="_xclick" id="upgrade" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">-->
               <form name="_xclick" id="upgrade" action="https://sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <!--<input type="hidden" name="cmd" value="_xclick">-->
                <input type="hidden" name="cmd" value="_xclick-subscriptions">
                <!--<input type="hidden" name="business" value="billing@rpautah.com">-->
                <input type="hidden" name="business" value="abhrabeas@gmail.com">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="lc" value="US">
                <!--<input type="hidden" name="no_note" value="1">-->
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="item_number">
                <input type="hidden" name="item_name">
                <!--<input type="hidden" name="amount">-->
                <input type="hidden" name="a3">
                <!--<input type="hidden" name="discount_rate">-->
                <input type="hidden" name="p3" value="1">
                <input type="hidden" name="t3" value="M">
                <input type="hidden" name="src" value="1">
                <input type="hidden" name="sra" value="1">
                <input type='hidden' name='rm' value="0">
                <input type="hidden" name="return" value="http://serpavenger.com/serp_avenger/upgrade?stat=1">
				<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribe_SM.gif:NonHostedGuest">
                </form>
              </td>
              </tr>
              
              <tr>
              <td colspan="2">
              <span id="redirect_msg"> &nbsp;&nbsp;&nbsp;&nbsp; Redirecting to secure paypal page...........</span>
              </td>
              </tr>
              
              <?php } ?>
              
              </tbody>
            </table>	
       </div>
      </div>
    </section>
  </section>
</section>

<?php $this->load->view('frontend/footer');?>