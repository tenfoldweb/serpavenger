// JavaScript Document

$(document).ready(function(){
    
	$('#menu').slicknav();
	$('#logo').addClass('animated pulse');
});

$(document).ready(function() {
		$( "#newonetwo" ).hide();
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
   // alert("sdfasdfds");
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
                                              '  <li><span>KW Anchors:</span>&nbsp;389 Links</li>'+
                                                '<li><span>KW above fold:</span>&nbsp;Yes</li>'+
                                                '<li><span>KW Ratio:</span>&nbsp;2.3%</li>'+
                                                '<li><span>In Title:</span>&nbsp;Yes</li>'+
                                                '<li><span>In Description:</span>&nbsp;Yes</li>'+
                                                '<li><span>In H1:</span>&nbsp;Yes</li>'+
                                            '</ul>'+
                                        '</div>'+
                                        '<div class="clearfix"></div>'+
                                        '<div class="rowinfo bnr-social">'+
                                            '<span class="headlab"><strong>Social</strong></span>'+
                                            '<img src="images/social-like-big.gif" width="366" height="20" alt="">'+
                                        '</div>'+
                                        '<div class="clearfix"></div>'+
                                        '<div class="rowinfo">'+
                                            '<span class="headlab"><strong>Link info</strong></span>'+
                                            '<ul class="ks">'+
                                                '<li><span>Exact Match:</span>&nbsp;28%</li>'+
                                                '<li><span>Related KWs:</span>&nbsp;42%</li>'+
                                                '<li><span>Blended:</span>&nbsp;13%</li>'+
                                                '<li><span>Brand:</span>&nbsp;12%</li>'+
                                                '<li><span>Raw URL:</span>&nbsp;8%</li>'+
                                                '<li><span>Using 301s:</span>&nbsp;Yes (23)</li>'+
                                            '</ul>'+
                                        '</div></div></div></div>';
                                    }
                                    if(id == 2){

                                        document.getElementById('apDiv1').innerHTML = '<div class="block" > Content 2'+
                                     '</div>';
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
	
