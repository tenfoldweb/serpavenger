// JavaScript Document


$(document).ready(function(){
	
	/* *********************************************************************
 * Graphs
 * *********************************************************************/
function InitGraphs () {
	$('.visualize1').visualize({
			'type': 'bar',
			'width': '872px',
			'height': '250px'
	});

	$('.visualize2').visualize({
			'type': 'line',
			'width': '872px',
			'height': '250px'
	});

	$('.visualize3').visualize({
			'type': 'area',
			'width': '872px',
			'height': '250px'
	});
	
	$('.visualize4').visualize({
			'type': 'pie',
			'width': '872px',
			'height': '250px'
	});
	
	$('.visualize-T1').visualize({
			'type': 'bar',
			'width': '872px',
			'height': '250px'
	});
	
	$('.visualize-T2').visualize({
			'type': 'line',
			'width': '872px',
			'height': '250px'
	});
	
	$('.visualize-T3').visualize({
			'type': 'area',
			'width': '872px',
			'height': '250px'
	});
	
	$('.visualize_dashboard').visualize({
			'type': 'bar',
			'width': '240px',
			'height': '100px'
	});
}
//start//
	$('#menu').slicknav();
	$('#logo').addClass('animated pulse');
	//rankChart-info
	$("#showchartinfo").click(function(){
		$("ul.aa").toggle();
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

	$( "#toggle_box" ).hide();
	//$( "#toggle_box" ).css(padding, 0);
	$( "#toggle" ).click(function() { 
	$( "#toggle_box" ).toggle();
	});
	

	$('.denvernew2').click(function() 
	{ 
        var id = $(this).attr('id');
        var res = id.split("_"); 
        if(res[0] = 'toggle')
        {
            $( "#toggle_box" ).toggle();
        }
    
        
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
    
   
/*$('.denvernew3').click(function() 
    { 
        //var id = $(this).attr('id');
         var id=$(this).attr("id");
        
        var res = id.split("_"); 
        if(res[0] = 'toggle')
        {
            $("#toggle_box"+title1).toggle();
        }
        
    
  // alert(id+" "+title1);
    var urll ="<?php echo base_url(); ?>index.php/activesubmissions/pop_up";
    var form_data = {title : title1,ajax : '1'};
    var vid = '#popup_table_'+title1;
    alert(vid);
 $.ajax({
        type: 'POST',
       async : false,
       data: form_data,
        url: urll, 

        
        success: function(data)
        { 
           //  alert(data);
      $(vid).html(data);
       
        }
        
        });
        
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
	*/
	
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
    
    $("#canvas").verticalCarousel({nSlots: 3}); 
   
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

