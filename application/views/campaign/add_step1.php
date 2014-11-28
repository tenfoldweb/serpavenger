<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome</title>

<!-- Bootstrap -->
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">

<!-- REVOLUTION BANNER CSS SETTINGS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/responsive.css" media="screen" />
<link rel="stylesheet" href="<?php echo FRONT_FONTCSS_PATH;?>font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
<!-- Owl Carousel Assets -->
<link href="<?php echo base_url(); ?>css/owl.carousel.css" rel="stylesheet">
<link href="../owl-carousel/owl.theme.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>

<!-- font -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script>
/*$(document).ready(function (){
$("#c_id").change(function () {
var checkedValue = $(this).val();        
if (checkedValue != "") {
$('#campaign_title').attr('disabled','disabled');
} else {
$("#campaign_title").attr("disabled", false);
}
});

$('#campaign_title').keypress(function() {
var txtVal = this.value;       
if (txtVal != "") {
$("#c_id").attr('disabled','disabled');
} else {
$("#c_id").attr("disabled", false);
}         
}); */


/*$('#campaign_main_keyword').keypress(function() {
var txtVal = this.value;       
if (txtVal != "") {
$("#campaign_secondary_keyword").attr('disabled','disabled');
} else {
$("#campaign_secondary_keyword").attr("disabled", false);
}         
}); */


/*$('#campaign_secondary_keyword').keypress(function() {
var txtVal = this.value;       
if (txtVal != "") {
$("#campaign_main_keyword").attr('disabled','disabled');
} else {
$("#campaign_main_keyword").attr("disabled", false);
}         
});      
});*/

$(document).ready(function (){
  //alert('hai');
document.getElementById("frmAddCampaign").reset();
$("#c_id").removeAttr("disabled");
$("#campaign_secondary_keyword").removeAttr("disabled");
});


</script>

</head>
<body >
<?php //if(validation_errors()){echo '<div class="alert-box error">' . validation_errors('<p><span>error: </span>', '</p>') . '</div>';}?>

<div class="container">
<div class="row" id="header">
<div class="col-md-3 left-col">
<div id="logo"><a href="index.html"><img src="<?php echo base_url(); ?>images/logo.png" width="214" height="84" alt=""></a></div>
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

<?php if($max_sites_per_subscription >= $max_sites_per_subscription_count){ ?>



<div class="col-md-9 right-col">
<div class="row">


<?php if(validation_errors()){echo '' . validation_errors('<p class="msg error"><a href="#" class="hide">hide this</a><span> </span>', '</p>') . '';}?>                
	<!-- Progress-->
    <div class="processmain-blk">
        <ol class="progtrckr" data-progtrckr-steps="3">
            <li class="progtrckr-done"><span class="firstp">Campaign Details</span></li>
            <li class="progtrckr-todo"><span class="secondp">Analyze & Compare</span></li>
            <li class="progtrckr-todo"><span class="thirdp">Launch Campaign</span></li>
        </ol>
        <div class="clearfix"></div>
        <div class="compaigns-details-row">
            <div class="lgsstart">
                <h3>Let's get started!</h3>
                 <form name="frmAddCampaign" id="frmAddCampaign" action="" method="post" OnSubmit="setTimeout('clear_form()', 200); return true">
                 <input type="hidden" name="action" value="Process">
                  <input type="hidden" name="skip" id="skip" value="No">
                <!--  Block start-->
                <div class="rowcmp cdblue">
                    <div class="creat-new-compaign">
                        <h2>Create New Campaign:</h2>
                        <input type="text" id="campaign_title" placeholder="Enter title for this campaign" name="campaign_title">
                    </div>
                    <div class="orsap">
                    	<span>OR</span>
                    </div>
                    <div class="creat-new-compaign">
                        <h2>Attach to Campaign:</h2>
                        <div class="dropdown">
                            <select name="c_id" id="c_id" class="dropdown-select">
                                <option value="">Select a campaign</option>  
                                <?php
        if(is_array($campaign_listing) && count($campaign_listing) > 0){
            for($i=0; $i<count($campaign_listing); $i++){
        ?>
        <option value="<?php echo $campaign_listing[$i]['campaign_id'];?>"><?php echo stripslashes($campaign_listing[$i]['campaign_title']);?></option>
        <?php
            }
        }?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <!--  Block start-->
                <div class="rowcmp allroecomp">
                    <h2>Type of Site?</h2>
                    <div class="col-md-6">
                    	<div class="pull-left mar-top">
                        	<div class="type-lbl-chk">
                                <input type="checkbox" name="campaign_site_type" class="checkboxselect" value="1" <?php if(set_value('campaign_site_type') == '1'){echo 'CHECKED';}?>>
                                <img alt="" src="<?php echo base_url(); ?>images/money-icon.png">
                             </div>
                                <label class="type-of-size">Money / Client Website <br><span>I own, or my client owns the site.</span></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                    	<div class="pull-left mar-top">
                        	<div class="type-lbl-chk">
                                <input type="checkbox" name="campaign_site_type" class="checkboxselect" value="2" <?php if(set_value('campaign_site_type') == '2'){echo 'CHECKED';}?>>
                                <img alt="" src="<?php echo base_url(); ?>images/Parasite.gif">
                             </div>
                                <label class="type-of-size">Leech/ Parasite Page<br><span>I have page(s) on a site that I don’t own <br>ie. Youtube, Amazon, Facebook etc.</span></label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="rowcmp allroecomp border-add">
                 <h2>What Search Engine Would You Like to Focus on?</h2>
                    <div class="drpright  wht-ser-eng">
                   
                                        <div class="droptextd left3text">
                                         <div class="checkbox12">
                                               <input id="isCrawlByGoogle" name="isCrawlByGoogle" class="css-checkbox" type="checkbox"  value="Yes" <?php if(isset($_POST['isCrawlByGoogle']) && $_POST['isCrawlByGoogle']== 'Yes'){echo 'CHECKED';}?>>
                                               <label class="label-chkbx lite-gray-check" for="isCrawlByGoogle" name="checkbox1_lbl"></label>
                                              </div>
                                                <img src="<?php echo base_url(); ?>images/add_key_1.jpg">
                                                <div class="dropdown">
                                                  <select id="google_se_domain" name="google_se_domain" class="dropdown-select">
                          <option value="">Select Country</option>  
                          <option value="usa" selected="">United States</option>
   <option value="uk">United Kingdom</option> 
   <option value="au">Australia</option>
    <option value="ca">Canada</option> 
                        </select>   
                                                </div>
                                                <div class="clearfix"></div>
                                             </div> 
                                             
                                             <div class="droptextd left3text">
                                                <div class="checkbox12">
                                               <input id="isCrawlByBing" name="isCrawlByBing" class="css-checkbox" type="checkbox"  value="Yes" <?php if(isset($_POST['isCrawlByBing']) && $_POST['isCrawlByBing']== 'Yes'){echo 'CHECKED';}?>>
                                               <label class="label-chkbx lite-gray-check" for="isCrawlByBing" name="checkbox1_lbl"></label>
                                              </div>
                                                <img src="<?php echo base_url(); ?>images/add_key_2.jpg">
                                                <div class="dropdown">
                                                     <select id="bing_se_domain" name="bing_se_domain" class="dropdown-select">
  <option value="">Select Country</option>   
  <option value="usa" selected="">United States</option>
   <option value="uk">United Kingdom</option> 
   <option value="au">Australia</option>
    <option value="ca">Canada</option>
</select>
                                                </div>
                                                <div class="clearfix"></div>
                                             </div>
                                            
                                             <div class="droptextd left3text">
                                            <div class="checkbox12">
                                               <input id="isCrawlByYahoo" name="isCrawlByYahoo" class="css-checkbox" type="checkbox"  value="Yes" <?php if(isset($_POST['isCrawlByYahoo']) && $_POST['isCrawlByYahoo']== 'Yes'){echo 'CHECKED';}?>>
                                               <label class="label-chkbx lite-gray-check" for="isCrawlByYahoo" name="checkbox1_lbl"></label>
                                              </div>
                                                <img src="<?php echo base_url(); ?>images/add_key_3.jpg">
                                                <div class="dropdown">
                                                     <select id="yahoo_se_domain" name="yahoo_se_domain" class="dropdown-select">
  <option value="">Select Country</option>  
 
 <option value="usa" selected="">United States</option>
   <option value="uk">United Kingdom</option> 
   <option value="au">Australia</option>
    <option value="ca">Canada</option>
</select>
                                                </div>
                                                <div class="clearfix"></div>
                                             </div>
                                             
                                            <div class="clearfix"></div>
                                             
                                            </div>
                  </div>  
                  
                 <div class="rowrnk-url allroecomp">
                    <div class="col-md-6 entur">
                    <h2>URL of Main Page You Want to Rank:</h2>
                    <img src="<?php echo base_url(); ?>images/enter-ur-url.png"><input type="text" name="campaign_main_page_url" id="campaign_main_page_url" value="<?php echo set_value('campaign_main_page_url');?>" placeholder="Enter your URL here (include http://)">			
                        
                    </div>
                    <div class="col-md-6">
                     <h2>Track Exact URL only?</h2>
                    	<div class="pull-left mar-top" class="urlclss">
                                <label class="type-of-size"><input type="checkbox" name="campaign_exact_url_track" id="campaign_exact_url_track1" class="boxselect" value="Yes">Yes Please ! <span>(Always use for parasite pages)</span></label>
                                <label class="type-of-size"><input type="checkbox" name="campaign_exact_url_track" id="campaign_exact_url_track2" class="boxselect" value="No" checked="checked">No show all of my pages ranking.</label>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>                      
                
                
                <div class="rowcmp cdgray txt-gray">
                    <div class="creat-new-compaign">
                        <h2>Main Target Keyword:</h2>
                        <input type="text" id="campaign_main_keyword" name="campaign_main_keyword" value="<?php echo set_value('campaign_main_keyword');?>" placeholder="Enter your most important keyword">
                    </div>
                    <div class="orsap orgray">
                    	<span>OR</span>
                    </div>
                    <div class="creat-new-compaign">
                        <h2>Find Competitor’s Keywords:</h2>
                        <input type="text" id="campaign_secondary_keyword" name="campaign_secondary_keyword" value="<?php echo set_value('campaign_secondary_keyword');?>" placeholder="Enter domain of competitor">
                    </div>
                    <div class="clearfix"></div>
                </div>
                  
<div class="clearfix"></div>
               <div class="compaign-button-area">
                 <span><img src="<?php echo base_url(); ?>images/loader.gif" class="mgrbtm" width="71" height="14" alt="" style="display:none"/></span>
               	 <button class="btn btn-primary" name="submit" id="subLogin" type="submit">Next</button>
               </div> 
            </div>
        </div>
        
        
        
  </div></form>
     
     <!--<div id="compaign-progress-bllock">
        <ul id="progressbar">
            <li class="active firstcol">Account Setup</li>
            <li class="secondcol">Social Profiles</li>
            <li class="thirdcol">Personal Details</li>
        </ul>
        <div class="pull-left" style="position:relative; width:100%">
        <div class="stepsdiv">
            <div class="compaigns-details-row cdblue">
            	zxZ
            </div>
            <input type="button" name="next" class="next action-button" value="Next" />
        </div>
        <div class="stepsdiv">
            xczxc
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </div>
        <div class="stepsdiv">
            zxczx
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="submit" name="submit" class="submit action-button" value="Submit" />
        </div>
        </div>
        <div class="clearfix"></div>
    </div>-->

     
     
    

</div>
</div>
<?php }else{ ?>
You have reached the maximum number sites per subscription. Click here to purchase a new package. <a href="<?php echo base_url()?>upgrade">BUY</a></li>

<?php } ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('.checkboxselect').click(function(){
if ($(this).is(':checked') == true){
$('.checkboxselect').prop('checked', false);
$(this).prop('checked', true);
}
});
});
</script>
<script type="text/javascript">
var checked = false;
$(document).ready(function(){
$('.css-checkbox').click(function(){
	
    if(checked)
    {
      $('.css-checkbox').each(function(){
           $(this).prop('disabled', false);
      });
      checked = false;
      return;
    }
    $('.css-checkbox').each(function(){
        if(!$(this).is(':checked')){
           $(this).prop('disabled', true);
        }
        else
            checked = true;
    });
});

});
$(document).ready(function(){
$('.boxselect').click(function(){
if ($(this).is(':checked') == true){
$('.boxselect').prop('checked', false);
$(this).prop('checked', true);
}
});
});
</script>

<script type="text/javascript">
$(function () {
    $("#isCrawlByGoogle").click(function(){
    $("#google_se_domain").prop('disabled', false);
    $("#bing_se_domain").prop('disabled', true);
    $("#yahoo_se_domain").prop('disabled', true);
     
});
  });
</script>
<script type="text/javascript">
$(function () {
    $("#isCrawlByBing").click(function(){
    $("#bing_se_domain").prop('disabled', false);
    $("#google_se_domain").prop('disabled', true);
    $("#yahoo_se_domain").prop('disabled', true);
});
  });
</script>
<script type="text/javascript">
$(function () {
    $("#isCrawlByYahoo").click(function(){
    $("#yahoo_se_domain").prop('disabled', false);
    $("#google_se_domain").prop('disabled', true);
    $("#bing_se_domain").prop('disabled', true);
   

});
  });
</script>
<script type="text/javascript">
$(function () {
    $("#subLogin").click(function(){
    $('.mgrbtm').removeAttr( 'style' );
    });
  });
</script>


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
