<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<title>SERP Avenger</title>-->
<!--start:seo-->
<?=isset($content_for_layout_seo)?$content_for_layout_seo:'';?>
<!--end:seo-->
<link rel="stylesheet" type="text/css" href="<?php echo FRONT_CSS_PATH; ?>styles.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo FRONT_CSS_PATH; ?>reset.css" media="all" />
 
 
<!--[if lt IE 9 ]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if lte IE 9]><link rel="stylesheet" href="<?php echo FRONT_CSS_PATH; ?>ie9.css" /><![endif]-->
<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo FRONT_CSS_PATH; ?>ie8.css" /><![endif]-->
<!--[if lte IE 7]><script src="<?php echo FRONT_JS_PATH;?>lte-ie7.js"></script><![endif]-->
<!-- <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>box.css"> -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH?>canvas_utils.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH?>jquery.timers-1.2.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>MeterWidget-1.0.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>circletype.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>functions.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>jquery.accordion.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>jquery.easing.1.3.js"></script> -->

 <script type="text/javascript" src="<?php echo base_url();?>js/script.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <script type="text/javascript">
 



</script>
     
</head>
		
<body onload="DisData('1','1')">

	<section class="mainContainerSec">
        <!-- start:body -->	
        <?=isset($content_for_layout_middle)?$content_for_layout_middle:'';?>
        <!-- end:body -->
	</section>

	
        <script type="text/javascript">
	$(function() {
		$('#st-accordion').accordion({
		oneOpenedItem	: true
		});
	});
	$(document).ready(function(){
		//$(".toggle_button").click(function(){
		//$(".toggle_box1").toggle();
		//});
		$(".toggle_button1").click(function(){
		$(".toggle_box2").toggle();
		});
	});
	
	function openCampaign(no)
	{
		$(".campaign_"+no).toggle('slow');	
	}
	function openMoneysite(no)
	{
		$(".moneysite_"+no).toggle('slow');	
	}
	function openParasite(no)
	{
		$(".parasite_"+no).toggle('slow');	
	}
	
        </script>
	
	
</body>
</html>
