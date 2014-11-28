<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome</title>
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<!-- Include the jQuery library (local or CDN) -->
<!-- Include the basic styles -->
<!-- REVOLUTION BANNER CSS SETTINGS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/responsive.css" media="screen" />
<link rel="stylesheet" href="<?php echo FRONT_FONTCSS_PATH; ?>font-awesome.min.css"  media="screen" >
<link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/magnific-popup.css">
<!-- Owl Carousel Assets -->
<link href="<?php echo base_url(); ?>css/owl.carousel.css" rel="stylesheet">
<!--<link href="../owl-carousel/owl.theme.css" rel="stylesheet">-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<!-- font -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

     <!--Crousal slider-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/sliderStyle.css" />


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


</script>
<!-- Bootstrap -->
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
 <iframe frameborder="0" scrolling="no" src="http://serpavenger.com/serp_avenger/osTicket/upload/index.php" width="1000" height="800"></iframe>
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
					// 2nd Ajax call for domain list 
					
					 $('#def').css('display','none');
					$('.sitethumb-list').html('<img id="loadingdomain" style="margin-left: auto;margin-right: auto" src="<?php echo base_url(); ?>images/ajax-loader.gif"  />');
					document.getElementById("selectblogtype1").disabled=true;
							$.ajax({
							type: 'POST',
							async : false,
							data: form_data,
							url: '<?php echo base_url(); ?>index.php/mypannel/get_network_domain_from_db/',
							success: function(data)
							{
							
							console.log(data);
									//setTimeout(function(){
										$('.sitethumb-list').html(data);
									eval("$('.image-link').magnificPopup({type:'image',image: {cursor: ''}})");
									eval("$('#pager').html(($('#pagerphp').html()))");
									
									document.getElementById("selectblogtype1").disabled=false;
									$('.lvspag-pagination').show();
								//	}, 4000);
									
							}
							});
					
				}
		});
	});
});

function NextThumb(){
alert("Manish");

}


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
//alert(row);

   
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
$('#campaignchieldthumb').html('');
$ul = $('<ul class="carousel-inner clearfix"></ul>').appendTo('#campaignchieldthumb');
for (var key in myObject) {
       if (myObject.hasOwnProperty(key)) {
           var imagethumbcamp = (myObject[key].campaign_murl_thumb!='') ? ''+myObject[key].campaign_murl_thumb+'' :'Thumbnail-Queued.jpg';
           var campaign_murl_thumb = '<?php echo base_url(); ?>images/'+imagethumbcamp;
          $ul.append('<li class="showSingle itemS" target="1"> <span class="topright-badge"><img src="<?php echo base_url(); ?>images/Parasite.gif" alt=""/></span><span class="thumb-img"><a href="'+myObject[key].campaign_main_page_url+'"><img src="'+campaign_murl_thumb+'" width="90" height="68" alt=""/></a></span><span class="thumb-right">14 KW</br><img src="<?php echo base_url(); ?>images/bing-icon.png" width="16" height="16" alt=""/></span><span class="thumblink"><a href="'+myObject[key].campaign_main_page_url+'">'+myObject[key].campaign_murl_thumb+'</a></span></li>');
       }
    }
$ul.append('<li class="addmore-btn"><a href="">+ ADD MORE</a></li>');
$('#campaignchieldthumb').prepend('<a href="#" class="carousel-left"></a> <a href="#" class="carousel-right"></a>');

}
});
});
});

var counter = 2;

function ShowDomainList(){
	var id = $("#selectblogtype1").val();
	 $('#def').css('display','none');
	$('.sitethumb-list').html('<img id="loadingdomain" style="margin-left: auto;margin-right: auto" src="<?php echo base_url(); ?>images/ajax-loader.gif"  />');
	document.getElementById("selectblogtype1").disabled=true;
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
				
				//$('#def').css('display','block');
				setTimeout(function(){
				$('.sitethumb-list').html(row);
				eval("$('.image-link').magnificPopup({type:'image',image: {cursor: ''}})");

				
				document.getElementById("selectblogtype1").disabled=false;
				}, 10000);


			}
	});

}




$(document).ready(function() {
  $('.image-link').magnificPopup({
  type:'image'
  
  });
 });
</script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->



<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>js/jquery.magnific-popup.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/owl.carousel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.verticalCarousel.min.js"></script>

 <script src="<?php echo base_url(); ?>js/script.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.slicknav.js"></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/jquery.nicescroll.min.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/application.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/jquery.cookie.js'></script>

<script type='text/javascript' src='<?php echo base_url(); ?>js/sliderStyle.js'></script> 

</body>
</html>
