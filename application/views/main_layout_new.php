<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <!-- Bootstrap -->
    <link href="<?php echo FRONT_CSS_PATH;?>bootstrap.min.css" rel="stylesheet">
    
    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>main.css" media="screen" />
    <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>responsive.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>font-awesome/css/font-awesome.min.css">
	 <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>animate.css">
    <link rel="stylesheet" href="<?php echo FRONT_CSS_PATH;?>style.css">
    <link href="<?php echo FRONT_CSS_PATH;?>simple-slider.css" rel="stylesheet"/>
    <link href="<?php echo FRONT_CSS_PATH;?>owl.carousel.css" rel="stylesheet"/>
    
     <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>  
    <!-- font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type='text/javascript' src="<?php echo base_url();?>js/jquery-ui.js"></script>  
    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    
  </head>

<body onload="DisData('1')" >

	<section>
        <!--start:header-->
        <?=isset($content_for_layout_header)?$content_for_layout_header:'';?>
        <!--end:header-->
	<section>
	   <section>
	<!--start left-->
	 <?=isset($content_for_layout_left)?$content_for_layout_left:'';?>
	<!--end left-->
	<article>
	<!--start top_menu-->
	<?=isset($content_for_layout_topmenu)?$content_for_layout_topmenu:'';?>
	<!--end top menu-->
	<section>
        <!-- start:body -->	
        <?=isset($content_for_layout_middle)?$content_for_layout_middle:'';?>
        <!-- end:body -->
	</section>
	     </article>
	   </section>
	</section>
        <!-- start:footer -->
        <?=isset($content_for_layout_footer)?$content_for_layout_footer:'';?>
        <!-- end:footer -->  
    

</section>


    
    <script type='text/javascript' src='<?php echo base_url();?>js/jquery-crawlin-status.js'></script>
    <script src="<?php echo base_url();?>js/simple-slider.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.smartTab.js"></script>
    <script src="<?php echo base_url();?>js/owl.carousel.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.verticalCarousel.min.js"></script>
    <!-- jQuery easing plugin -->
    
    <script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/script.js"></script>     
     <script src="<?php echo base_url();?>js/jquery.slicknav.js"></script> 
    <script type='text/javascript' src='<?php echo base_url();?>js/jquery.nicescroll.min.js'></script>
    <script type='text/javascript' src='<?php echo base_url();?>js/application.js'></script> 
    <script type='text/javascript' src='<?php echo base_url();?>js/jquery.cookie.js'></script>



	</body>
       </html>
	

