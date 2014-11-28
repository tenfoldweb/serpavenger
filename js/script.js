// JavaScript Document


$(document).ready(function(){
	$('#menu').slicknav();
	$('#logo').addClass('animated pulse');
	//rankChart-info
	$("#showchartinfo").click(function(){
		$("ul.aa").toggle();
  	});
	
	/*$("#owl-demo").owlCarousel({
       // autoPlay: 3000,
        items : 5,
		navigation : true,
        itemsDesktop : [826,3],
        itemsDesktopSmall : [826,3],
		pagination:false,
      });*/
	  
	  // Smart Tab 			
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
	//$( ".denvernew2" ).click(function() { 
	//$( "#newonetwo" ).toggle();
	//});
	

	//$('.denvernew2').click(function() 
	//{ 
	 // if ($(this).text() == "View Articles") 
	 // { 
	//	 $(this).text("Hide Articles");
	//	 $(this).addClass("bulebg"); 
	 // } 
	 // else 
	  //{ 
		// $(this).text("View Articles");
		// $(this).removeClass("bulebg");
	  //}; 
	//});
	
	$("ul.vertical-carousel-list li:eq(0)").addClass("activethumb").show();
	
	//  $('ul.vertical-carousel-list li a').parent().siblings().addClass('activethumb');
	  // $('ul.vertical-carousel-list li a').addClass('activethumb');
	$('ul.vertical-carousel-list li a').click(function() { 
     //$(this).removeClass("activethumb");alert('new1');
	 $('ul.vertical-carousel-list li.activethumb').removeClass('activethumb');
    $(this).closest('li').addClass('activethumb');
	
	
	});
	
	


	});



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

// price slider

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
          .html(data.value.toFixed(0));
    });
	
	
// Crawling Status slider

/* SET RANDOM LOADER COLORS FOR DEMO PURPOSES */	
	var demoColorArray = ['yellow'];
	var colorIndex = Math.floor(Math.random()*demoColorArray.length);
	setSkin(demoColorArray[colorIndex]);

	/* RANDOM LARGE IMAGES FOR DEMO PURPOSES */	
	var demoImgArray = [ 'http://www.hdwallpapers.in/walls/2013_print_tech_lamborghini_aventador-wide.jpg', 'http://www.hdwallpapers.in/walls/ama_dablam_himalaya_mountains-wide.jpg', 'http://www.hdwallpapers.in/walls/arrow_tv_series-wide.jpg', 'http://www.hdwallpapers.in/walls/anna_in_frozen-wide.jpg', 'http://www.hdwallpapers.in/walls/frozen_elsa-wide.jpg', 'http://www.hdwallpapers.in/walls/shraddha_kapoor-wide.jpg', 'http://www.hdwallpapers.in/walls/sahara_force_india_f1_team-HD.jpg', 'http://www.hdwallpapers.in/walls/lake_sunset-wide.jpg', 'http://www.hdwallpapers.in/walls/2013_movie_cloudy_with_a_chance_of_meatballs_2-wide.jpg', 'http://www.hdwallpapers.in/walls/bates_motel_2013_tv_series-wide.jpg', 'http://www.hdwallpapers.in/walls/krrish_3_movie-wide.jpg', 'http://www.hdwallpapers.in/walls/universe_door-wide.jpg', 'http://www.hdwallpapers.in/walls/night_rider-HD.jpg', 'http://www.hdwallpapers.in/walls/tide_and_waves-wide.jpg', 'http://www.hdwallpapers.in/walls/2014_lamborghini_veneno_roadster-wide.jpg', 'http://www.hdwallpapers.in/walls/peeta_katniss_the_hunger_games_catching_fire-wide.jpg', 'http://www.hdwallpapers.in/walls/captain_america_the_winter_soldier-wide.jpg', 'http://www.hdwallpapers.in/walls/puppeteer_ps3_game-wide.jpg', 'http://www.hdwallpapers.in/walls/lunar_space_galaxy-HD.jpg', 'http://www.hdwallpapers.in/walls/2014_lamborghini_veneno_roadster-wide.jpg', 'http://www.hdwallpapers.in/walls/peeta_katniss_the_hunger_games_catching_fire-wide.jpg', 'http://www.hdwallpapers.in/walls/captain_america_the_winter_soldier-wide.jpg', 'http://www.hdwallpapers.in/walls/puppeteer_ps3_game-wide.jpg', 'http://www.hdwallpapers.in/walls/lunar_space_galaxy-HD.jpg'];

	// Stripes interval
	var stripesAnim;
	var calcPercent;
	var serfprogress = 0;
	var miningprogress = 0;
	var backlinkprogress= 0;
	var avengerprogress= 0;;
	/*$progress = $('.progress-bar');
	$percent = $('.percentage-cs');
	$stripes = $('.progress-stripes'); */
	function initilizeprogressbar(progressclass, progresscsclass, progressserpclass){
		$progress = $('.'+progressclass);
		$percent = $('.'+progresscsclass);
		$stripes = $('.'+progressserpclass);
		$stripes.text('////////////////////////');
			preload(progressclass, progresscsclass,20);
		
		
	}
	
	function initilizebacklinkbar(progressclass, progresscsclass, progressserpclass){
		$progress = $('.'+progressclass);
		$percent = $('.'+progresscsclass);
		$stripes = $('.'+progressserpclass);
		$stripes.text('////////////////////////');
		backlinkprogressbar(progressclass, progresscsclass,90);
		
		
	}

	

	// Call function to load array of images
	

	// Call function to animate stripes
	//stripesAnimate(); 

	/* WHEN LOADED */
	/*$(window).load(function() {
		loaded = true;
		$progress.animate({
			width: "100%"
		}, 100, function() {
			$('.progress-res span').text('Done').addClass('loaded');
			$percent.text('100%');
      $('.imgdone').css('display','inline');
			clearInterval(calcPercent);
			clearInterval(stripesAnim);
		});
	}); */

	/*** FUNCTIONS ***/
	function backlinkprogressbar(bprogress,bpercent,binc) {
		backlinkprogress= parseInt(backlinkprogress) + parseInt(binc);
		$('.'+bprogress).animate({
					width: backlinkprogress + "%"
				}, 4000);
			calcBacklink = setInterval(function() {

			//loop through the items
			backlinktxt = $('.'+bprogress).width() / $('.'+bprogress).parent().width() * 100;
			if(Math.floor(backlinktxt)<=100){
				$('.'+bpercent).text(Math.floor(backlinktxt) + '%');
			}

		},400);
//alert(backlinkprogress);		
		if(backlinkprogress > 99){
			clearInterval(calcBacklink);
				$('.'+bprogress+'-done').css('display','inline');
				$('.'+bprogress+'-res span').text('Done').addClass('loaded');
				$('.'+bpercent).text('100%');
				/* $('.'+progress+'-done').css('display','inline');*/
				
				
				 //$stripes.stop( true, true );
				 //$stripes.finish();
			}
	}
	/* LOADING */
	function preload(progress,percent,inc) {
	
	if(progress=="progress-serp"){
	globalprogress = parseInt(serfprogress) + parseInt(inc);
	serfprogress = globalprogress;
	}
	if(progress=="progress-mining"){
	globalprogress = parseInt(miningprogress) + parseInt(inc);
	miningprogress = globalprogress;
	}
	//alert(progress);
	//alert(percent);
//alert(globalprogress);	
	
	
	var increment = inc;
		
				$('.'+progress).animate({
					width: globalprogress + "%"
				}, 600);
			calcPercent = setInterval(function() {

			//loop through the items
			f = $('.'+progress).width() / $('.'+progress).parent().width() * 100;
			
			$('.'+percent).text(Math.floor(f) + '%');

		},100);
			
		//calcPercent = setInterval(function() {
			/*if(parseInt(inc) < 10){ 
				$stripes.animate({
					marginLeft: "-=30px"
				}, 10000, "linear").append('/');
			} else { 
					$stripes.animate({
						marginLeft: "-=30px"
					}, 6500, "linear").append('/');
			}*/
			//loop through the items
			//$percent.text(Math.floor(($progress.width() / $('.loader-cs').width()) * 100) + '%');
			//alert(globalprogress);
			
			if(globalprogress > 99){
			clearInterval(calcPercent); 
				$('.'+progress+'-done').css('display','inline');
				$('.'+progress+'-res span').text('Done').addClass('loaded');
				$('.'+percent).text('100%');
				/* $('.'+progress+'-done').css('display','inline');*/
				
				
				 //$stripes.stop( true, true );
				 //$stripes.finish();
			}
		//});
	}
	
	function sleep(milliseconds) {
	  var start = new Date().getTime();
	  for (var i = 0; i < 1e7; i++) {
		if ((new Date().getTime() - start) > milliseconds){
		  break;
		}
	  }
	}

	/* STRIPES ANIMATION */
	function stripesAnimate() {
		animating();
		stripesAnim = setInterval(animating, 2500);
	}

	function animating() {
		$stripes.animate({
			marginLeft: "-=30px"
		}, 2500, "linear").append('/');
	} 

	function setSkin(skin){
		$('.loader-cs').attr('class', 'loader-cs '+skin);
		$('.progress-res span').hasClass('loaded') ? $('.progress-res span').attr('class', 'loaded '+skin) : $('.progress-res span').attr('class', skin);
	}
    //$('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'vSlide'});
    //@ sourceURL=pen.js

/*function mypannelclosed() {  
    var ele = document.getElementById("toggleText");
    alert(ele);
    var text = document.getElementById("displayText");
    alert(text);
    if(ele.style.display == "block") {
            ele.style.display = "none";
        text.innerHTML = "show";
    }
    else {
        ele.style.display = "block";
        text.innerHTML = "hide";
    }
}*/     

function numbercounter(startnum, endnum,htmlid){
	$({someValue: startnum}).animate({someValue: endnum}, {
		duration: 5000,
		easing:'swing', // can be anything
		step: function() { // called on every step
			// Update the element's text with rounded-up value:
			$('#'+htmlid).text(Math.ceil(this.someValue));
		}
	});
}