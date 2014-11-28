// JavaScript Document


$(document).ready(function(){
	$('#menu').slicknav();
	$('#logo').addClass('animated pulse');
	//rankChart-info
	$("#showchartinfo").click(function(){
		$("ul.aa").toggle();
  	});
	
	$("#owl-demo").owlCarousel({
       // autoPlay: 3000,
        items : 5,
		navigation : true,
        itemsDesktop : [826,3],
        itemsDesktopSmall : [826,3],
		pagination:false,
      });
	
});


function show()
    	{
            if($('#show').is(":hidden")){
                $("#show_td").css("background-color", "#e6f5f5");
                $("#show_content").text("Hide");
            }
            else 
            {
                $("#show_td").css("background-color", "#fff");
                $("#show_content").text("Show");
            }
            
    		$("#show").toggle();
    		$("#show1").toggle();
    		$("#show2").toggle();
			
			$("#show3").toggle();
			$("#show4").toggle();
			$("#show5").toggle();
			$("#show6").toggle();
			$("#show7").toggle();
			
			
    		$("#show").css("background-color", "#e6f5f5");
    		$("#show1").css("background-color", "#e6f5f5");
    		$("#show2").css("background-color", "#e6f5f5");
			
			$("#show3").css("background-color", "#e6f5f5");
			$("#show4").css("background-color", "#e6f5f5");
			$("#show5").css("background-color", "#e6f5f5");
			$("#show6").css("background-color", "#e6f5f5");
			$("#show7").css("background-color", "#e6f5f5");
    	}


$(document).ready(function() {
	$( "#newonetwo" ).hide();
	//$( "#newonetwo" ).css(padding, 0);
	$( ".denvernew2" ).click(function() { 
	$( "#newonetwo" ).toggle();
	});
	

	$('.denvernew2').click(function() 
	{ 
	  if ($(this).text() == "View Articles") 
	  { 
		 $(this).text("Hide Articles");
		 $(this).addClass("bulebg"); 
	  } 
	  else 
	  { 
		 $(this).text("View Articles");
		 $(this).removeClass("bulebg");
	  }; 
	});
	
	$("ul.vertical-carousel-list li:eq(0)").addClass("activethumb").show();
	
	//  $('ul.vertical-carousel-list li a').parent().siblings().addClass('activethumb');
	  // $('ul.vertical-carousel-list li a').addClass('activethumb');
	$('ul.vertical-carousel-list li a').click(function() { 
     //$(this).removeClass("activethumb");alert('new1');
	 $('ul.vertical-carousel-list li.activethumb').removeClass('activethumb');
    $(this).closest('li').addClass('activethumb');
	
	
	});
	
	


	});
//jQuery(function() {
		//jQuery("#acdnmenu").accordionMenu();
	//});
	
	
// tab slider

$(document).ready(function(){ 
    
    $("#your-id-name").verticalCarousel({nSlots: 3}); 
   
});  

function DisData(id){
    var id ;
    if(id == 1){
   document.getElementById('apDiv1').innerHTML = '<div class="block" >'+
                                     '<div class="siteinfo">'+
                                        '<img src="images/apex-big-img.gif" width="190"  alt="">'+
                                        '<div class="infomain">'+
                                        '<p><label>Ranking:</label>'+
                                            '<span><strong>3 (Tenant background check)</strong></span>'+
                                        '</p><p><label>Page:</label>'+
                                            '<span>www.locksmithdenvermetro.com</span>'+
                                        '</p><p><label>Age:</label>'+
                                            '<span>1 yr 9 Months</span>'+
                                        '</p><p>'+
                                            '<label>Type:</label>'+
                                            '<span>Ranked Homepage w/ 3 External Links</span>'+
                                            '<ul class="typrank">'+
                                                '<li>Top 10: 70% are homepages</li>'+
                                                '<li>Top 20: 60% are home pages</li>'+
                                            '</ul></p><p>'+
                                            '<label>Size:</label>'+
                                            '<span>77 Pages</span>'+
                                            '<span class="pull-right">Word Count: 396</span>'+
                                       ' </p>'+
                                        '</div> </div>'+
                                                                     
                                    '<div class="clearfix"></div>'+
                                   ' <div class="bnrbtmrow">'+
                                        '<div class="rowinfo">'+
                                            '<span class="headlab"><strong>Keyword Score(67)</strong></span>'+
                                            '<ul class="ks">'+
                                              '  <li><span class="wdt53">KW Anchors:</span>&nbsp;389 Links</li>'+
                                                '<li><span class="wdt63">KW above fold:</span>&nbsp;Yes</li>'+
                                                '<li><span class="wdt53">KW Ratio:</span>&nbsp;2.3%</li>'+
                                                '<li><span class="wdt53">In Title:</span>&nbsp;Yes</li>'+
                                                '<li><span class="wdt63">In Description:</span>&nbsp;Yes</li>'+
                                                '<li><span class="wdt53">In H1:</span>&nbsp;Yes</li>'+
                                            '</ul>'+
                                        '</div>'+
                                        '<div class="clearfix"></div>'+
                                        '<div class="rowinfo bnr-social">'+
                                            '<span class="headlab"><strong>Social</strong></span>'+
                                            '<ul class="banner-social">'+
												'<li><i class="fa fa-facebook fb"></i> 32 likes</li>'+
												'<li><i class="fa fa-facebook fb"></i> 12 Shares</li>'+
												'<li><i class="fa fa-twitter twitter"></i> 58 Tweets</li>'+
												'<li><i class="fa fa-google-plus gplus"></i> 39 G</li>'+
											'</ul>'+
                                        '</div>'+
                                        '<div class="clearfix"></div>'+
                                        '<div class="rowinfo">'+
                                            '<span class="headlab"><strong>Link info</strong></span>'+
                                            '<ul class="ks">'+
                                                '<li><span class="wdt53">Exact Match:</span>&nbsp;28%</li>'+
                                                '<li><span class="wdt63">Related KWs:</span>&nbsp;42%</li>'+
                                                '<li><span class="wdt53">Blended:</span>&nbsp;13%</li>'+
                                                '<li><span class="wdt53">Brand:</span>&nbsp;12%</li>'+
                                                '<li><span class="wdt63">Raw URL:</span>&nbsp;8%</li>'+
                                                '<li><span class="wdt53">Using 301s:</span>&nbsp;Yes (23)</li>'+
                                            '</ul>'+
                                        '</div></div></div></div>';
                                    }
                                    if(id == 2){

                                        document.getElementById('apDiv1').innerHTML = '<div class="block" >'+
                                     '<div class="siteinfo">'+
                                        '<img src="images/RPA-big-img.gif" width="190"  alt="">'+
                                        '<div class="infomain">'+
                                        '<p><label>Ranking:</label>'+
                                            '<span><strong>3 (Tenant background check)</strong></span>'+
                                        '</p><p><label>Page:</label>'+
                                            '<span>www.locksmithdenvermetro.com</span>'+
                                        '</p><p><label>Age:</label>'+
                                            '<span>1 yr 9 Months</span>'+
                                        '</p><p>'+
                                            '<label>Type:</label>'+
                                            '<span>Ranked Homepage w/ 3 External Links</span>'+
                                            '<ul class="typrank">'+
                                                '<li>Top 10: 70% are homepages</li>'+
                                                '<li>Top 20: 60% are home pages</li>'+
                                            '</ul></p><p>'+
                                            '<label>Size:</label>'+
                                            '<span>77 Pages</span>'+
                                            '<span class="pull-right">Word Count: 396</span>'+
                                       ' </p>'+
                                        '</div> </div>'+
                                                                     
                                    '<div class="clearfix"></div>'+
                                   ' <div class="bnrbtmrow">'+
                                        '<div class="rowinfo">'+
                                            '<span class="headlab"><strong>Keyword Score(67)</strong></span>'+
                                            '<ul class="ks">'+
                                              '  <li><span class="wdt53">KW Anchors:</span>&nbsp;389 Links</li>'+
                                                '<li><span class="wdt63">KW above fold:</span>&nbsp;Yes</li>'+
                                                '<li><span class="wdt53">KW Ratio:</span>&nbsp;2.3%</li>'+
                                                '<li><span class="wdt53">In Title:</span>&nbsp;Yes</li>'+
                                                '<li><span class="wdt63">In Description:</span>&nbsp;Yes</li>'+
                                                '<li><span class="wdt53">In H1:</span>&nbsp;Yes</li>'+
                                            '</ul>'+
                                        '</div>'+
                                        '<div class="clearfix"></div>'+
                                        '<div class="rowinfo bnr-social">'+
                                            '<span class="headlab"><strong>Social</strong></span>'+
                                            '<ul class="banner-social">'+
												'<li><i class="fa fa-facebook"></i> 32 likes</li>'+
												'<li><i class="fa fa-facebook"></i> 12 Shares</li>'+
												'<li><i class="fa fa-twitter"></i> 58 Tweets</li>'+
												'<li><i class="fa fa-google-plus"></i> 39 G</li>'+
											'</ul>'+
                                        '</div>'+
                                        '<div class="clearfix"></div>'+
                                        '<div class="rowinfo">'+
                                            '<span class="headlab"><strong>Link info</strong></span>'+
                                            '<ul class="ks">'+
                                                '<li><span class="wdt53">Exact Match:</span>&nbsp;28%</li>'+
                                                '<li><span class="wdt63">Related KWs:</span>&nbsp;42%</li>'+
                                                '<li><span class="wdt53">Blended:</span>&nbsp;13%</li>'+
                                                '<li><span class="wdt53">Brand:</span>&nbsp;12%</li>'+
                                                '<li><span class="wdt63">Raw URL:</span>&nbsp;8%</li>'+
                                                '<li><span class="wdt53">Using 301s:</span>&nbsp;Yes (23)</li>'+
                                            '</ul>'+
                                        '</div></div></div></div>';
                                    }
                                    if(id == 3){

                                        document.getElementById('apDiv1').innerHTML = '<div class="block" > Content 3'+
                                     '</div>';
                                    }
                                    if(id == 4){

                                        document.getElementById('apDiv1').innerHTML = '<div class="block" > Content 4'+
                                     '</div>';
                                    }
                                    if(id == 5){

                                        document.getElementById('apDiv1').innerHTML = '<div class="block" > Content 5'+
                                     '</div>';
                                    }
}


// compaign progress
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($(".stepsdiv").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($(".stepsdiv").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
})

$("[data-slider]")
    .each(function () {
      var input = $(this);
      $("<span>")
        .addClass("outputbl")
        .insertAfter($(this));
    })
    .bind("slider:ready slider:changed", function (event, data) {
      $(this)
        .nextAll(".outputbl:first")
          .html(data.value.toFixed(3));
    });
