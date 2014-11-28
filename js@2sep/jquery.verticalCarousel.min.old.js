(function($) {  
	$.fn.verticalCarousel = function(options) {  
  
		var defaults = { nSlots: 2, speed: 300 };  
		var options = $.extend(defaults, options); 
		var wSlotsht;
		var wSlotsht_scr;
		var nofs;
		var curfs = 1;
		var scrollDirection;
		var selector;
		var nof;
		return this.each(function() {  
			selector = this.id;
			$("#" + selector + " div.vertical-carousel-container").height(($("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list li").outerHeight(false) * options.nSlots)).css('overflow','hidden');
			$("#" + selector + " a.scru").click(function() {scrollDirection="up";calcspots();});
			$("#" + selector + " a.scrd").click(function() {scrollDirection = "down";calcspots();});
		});
		
		function calcspots()
		{
			if ($("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").is(":animated")) {return;}
			wSlotsht = $("#" + selector + " div.vertical-carousel-container").height() + 10;
			wSlotsht_scr = $("#" + selector + " div.vertical-carousel-container").height();
			nofs = Math.ceil($("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").height() / wSlotsht_scr);
			
			curtop = parseInt($("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").css('top'));
			curfs = $("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").height() - Math.abs(curtop);
			curfs = Math.ceil(curfs / (wSlotsht_scr+5)); 
			curfs = nofs - curfs + 1;
			//alert(nofs);
			nos = nofs - 1;
			//alert(curfs);
			//alert(nos);
			//alert(scrollDirection);
			if( curfs <= 2 && scrollDirection == "up") 
			{
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '+=' + wSlotsht}, options.speed, function() {});
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '-=10'}, options.speed + 100, function() {});
			  $('#down1').show();
			  $('#up1').hide();
			}
			else if(curfs > 1 && scrollDirection == "up")
			{
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '+=' + wSlotsht}, options.speed, function() {});
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '-=10'}, options.speed + 100, function() {});
			$('#down1').show();
          $('#up1').show();
			}			
			else if(curfs <= 1 && scrollDirection == "up")
			{
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '+=10'}, 100, function() {});
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '-=10'}, 200, function() {});
			  $('#down1').show();
			  $('#up1').hide();
			}else if( curfs == nos && scrollDirection == "down")
			{
				//alert('kk');
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '-=' + wSlotsht}, options.speed, function() {});
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '+=10'}, options.speed + 100, function() {});
				 $('#down1').hide();
			  $('#up1').show();
			}
			else if(curfs < nofs && scrollDirection == "down")
			{
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '-=' + wSlotsht}, options.speed, function() {});
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '+=10'}, options.speed + 100, function() {});
			 $('#down1').show();
			 $('#up1').show();

			}
			

			else if(scrollDirection == "down")
			{
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '-=10'}, 100, function() {});
				$("#" + selector + " div.vertical-carousel-container ul.vertical-carousel-list").animate({top: '+=10'}, 200, function() {});
			 $('#down1').hide();
			  $('#up1').show();
			}
		}
		  
	};  
})(jQuery);