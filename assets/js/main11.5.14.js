 function networks_checkAll(form) {
				for (i = 0, n = form.elements.length; i < n; i++) {
					if(form.elements[i].type == "checkbox" && !(form.elements[i].hasAttribute('onclick'))) {
							if(form.elements[i].checked == true)
								form.elements[i].checked = false;
							else
								form.elements[i].checked = true;
					}
				}
			}
  			
var path_url=$('#path_url').text();			

var cvform='<div id="forms_login" class="forms_cv"><a class="close" style="cursor:pointer;" onclick="call();">Close</a>';
	    cvform+='<div id="error_search"></div>';
		//cvform+='<form class="cv_form" action="" method="post" onsubmit="return chlcvform()">';	
		///cvform+='<input type="hidden" name="action" value="save_cv" />';
		cvform+='<div id="search_res">';
		cvform += '   <table width="350" border="0">';
		cvform += '		  <tr style="height:10px;">';
		cvform += '			<td colspan="3"><strong>Search Comment from Yahoo answers...</strong></td>';          
		cvform += '		  </tr>';		
		cvform += '		  <tr><td width="20">&nbsp;</td></tr>';
		cvform += '		  <tr>';
		cvform += '			<td width="118" class="pad">Keywords</td>';
		cvform += '			<td width="20">:</td>';
		cvform += '			<td width="190"><input type="text" name="keywords" class="text_field2"/></td>';
		cvform += '		  </tr>';
		/*cvform += '		  <tr><td width="20">&nbsp;</td></tr>';
		cvform += '		  <tr>';
		cvform += '			<td class="pad">Synonyms</td>';
		cvform += '			<td>:</td>';
		cvform += '			<td><input type="text" name="synonyms" class="text_field2" /></td>';
		cvform += '		  </tr>';
		cvform += '		  <tr><td width="20">&nbsp;</td></tr>';
		cvform += '		  <tr>';
		cvform += '			<td class="pad">Topics</td>';
		cvform += '			<td>:</td>';
		cvform += '			<td><input type="text" name="topics" class="text_field2" /></td>';
		cvform += '		  </tr>';*/
		cvform += '		  <tr><td width="20">&nbsp;</td></tr>';		
		cvform += '		  <tr>';
		cvform += '			<td>&nbsp;</td>';
		cvform += '			<td>&nbsp;</td>';
		cvform += '			<td><input type="button" value="Search" onclick="search_yahoo(\'yahoo\',1);"></td>';
		cvform += '		  </tr>';
		
		cvform += '</table>';  
		cvform += '</div></div>';
		
					
    $(document).ready(function(){
		
		   $('input[name=submission_num]').blur(function(){
					$('.range_slider .ui-slider-range').css('width','0%');
					$('.range_slider .ui-slider-handle').css('left','0%');
					
					
					sliders(1,0,$(this).val(),'qly1',0,"r");					
					slidersFooter(20,0,$(this).val(),'hp_smart',0)
					//alert('hit');
				});
		   var arr=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];		
		   $('#add_anchor1').click(function() {
			  
					var avaible_anchors = 3;					
					var tbody = $('#table1').find('tbody')
		            var row = tbody.find('tr:last-child').clone();
					//alert(tbody.find('tr').length);
					var nums=parseInt(tbody.find('tr').length+1);
					var arr_num=tbody.find('tr').length;
										
					row.find('label').text('Anchor 1'+arr[arr_num]);
					row.find('.no3').text('Link/ URL 1'+arr[arr_num]);
					
					//row.find('.rating .range_slider div:first').removeClass('rslider'+tbody.find('tr').length);
					row.find(".range_slider input[type='hidden']").removeAttr('id');
					row.find(".range_slider a").find('div').removeAttr('id');
					row.find(".range_slider input[type='hidden']").removeAttr('name');
					
					row.find(".chkbox3 input[type='radio']").removeAttr('name');
					row.find(".help_box2 input[type='text']").val('');
					row.find(".part6_4 input[type='text']:first").removeAttr('name');
					row.find(".part6_4 input[type='text']:last").removeAttr('name');
					row.find(".chkbox3 input[type='radio']").removeAttr('checked');
					row.find(".part6_4 input[type='text']:first").val('');
					row.find(".part6_4 input[type='text']:last").val('');
					
					
					row.find(".chkbox3 input[type='radio']").attr('name','anchor_set'+nums);					
					row.find(".part6_4 input[type='text']:first").attr('name','anchor'+nums);
					row.find(".part6_4 input[type='text']:last").attr('name','link'+nums);
					
					
					//row.find('.rating .range_slider div:first').addClass('rslider'+nums);
					row.find(".range_slider input[type='hidden']").attr('name','qty'+nums);
					row.find(".range_slider input[type='hidden']").attr('id','qty'+nums);
					row.find(".range_slider a").find('div').attr('id','tooltip'+nums);
					row.find(".range_slider").find('div').attr('id','r'+nums);
					
					//row.append('<div class="every_remove" id="every_remove'+nums+'"><a href="javascript:void(0)" onClick="remove_it('+nums+');">- Remove</a></div>');
					//if( tbody.find('tr').length < avaible_anchors ) {
					/* new logic for second slider by bhaiya*/
					var old_val=0;	
					var ids=tbody.find('tr').length;
					for(var val=1;val<=ids;val++){
						//tot_val=parseInt(tot_val) + parseInt($('#qlty'+val).val());
						//alert($('#tooltip'+val).text());											
					   // old_val=parseInt(old_val)+ parseInt($('#tooltip'+val).text());
					}
										
					old_val=$('#tooltipr'+ids).text();					
					old_val=parseInt(old_val)+1;
					//var left_post=($('input[name=submission_num]').val() - tot_val);
					//alert(old_val);
					/************ end logic**************************/	
					tbody.append( row );
					$('#r'+nums+' .ui-slider-range').css('width','0%');
					$('#r'+nums+' .ui-slider-handle').css('left','0%');
					//sliders(nums,$('input[name=submission_num]').val(),'qlty'+nums); //old logic for all slider is same
					//$('#min_qty'+nums).val(old_val);
					
					$('#r').append('<input type="hidden" name="min_qty'+nums+'" value="'+old_val+'">');
					sliders(nums,old_val,$('input[name=submission_num]').val(),'qty'+nums,old_val,"r");
					//}
				});
				
		   $('#second_anchor').click(function(){
			   $('#table2').show('slow');
			   sliders(1,0,$('input[name=submission_num]').val(),'qty_rr1',0,'rr');
			   $(this).hide();
			   
		   });
				
		   $('#add_anchor2').click(function() {
			  
					var avaible_anchors = 3;					
					var tbody = $('#table2').find('tbody')
		            var row = tbody.find('tr:last-child').clone();
					//alert(tbody.find('tr').length);
					var nums=parseInt(tbody.find('tr').length+1);
					var arr_num=tbody.find('tr').length;
										
					row.find('label').text('Anchor 2'+arr[arr_num]);
					row.find('.no3').text('Link/ URL 2'+arr[arr_num]);
					
					//row.find('.rating .range_slider div:first').removeClass('rslider'+tbody.find('tr').length);
					row.find(".range_slider input[type='hidden']").removeAttr('id');
					row.find(".range_slider a").find('div').removeAttr('id');
					row.find(".range_slider input[type='hidden']").removeAttr('name');
					
					row.find(".chkbox3 input[type='radio']").removeAttr('name');
					row.find(".help_box2 input[type='text']").val('');
					row.find(".part6_4 input[type='text']:first").removeAttr('name');
					row.find(".part6_4 input[type='text']:last").removeAttr('name');
					row.find(".chkbox3 input[type='radio']").removeAttr('checked');
					row.find(".part6_4 input[type='text']:first").val('');
					row.find(".part6_4 input[type='text']:last").val('');
					
					row.find(".chkbox3 input[type='radio']").attr('name','anchor_set_rr'+nums);					
					row.find(".part6_4 input[type='text']:first").attr('name','anchor_rr'+nums);
					row.find(".part6_4 input[type='text']:last").attr('name','link_rr'+nums);
					
					//row.find('.rating .range_slider div:first').addClass('rslider'+nums);
					row.find(".range_slider input[type='hidden']").attr('name','qty_rr'+nums);
					row.find(".range_slider input[type='hidden']").attr('id','qty_rr'+nums);
					row.find(".range_slider a").find('div').attr('id','tooltip'+nums);
					row.find(".range_slider").find('div').attr('id','rr'+nums);
					
					var old_val=0;	
					var ids=tbody.find('tr').length;
									
					old_val=$('#tooltiprr'+ids).text();					
					old_val=parseInt(old_val)+1;
						
					tbody.append( row );
					$('#rr'+nums+' .ui-slider-range').css('width','0%');
					$('#rr'+nums+' .ui-slider-handle').css('left','0%');					
					
					$('#r').append('<input type="hidden" name="min_qty_rr'+nums+'" value="'+old_val+'">');
					sliders(nums,old_val,$('input[name=submission_num]').val(),'qty_rr'+nums,old_val,"rr");
					
				});
				
				
		  $('#third_anchor').click(function(){
			   $('#table3').show('slow');
			   sliders(1,0,$('input[name=submission_num]').val(),'qty_rrr1',0,'rrr');
			   $(this).hide();
			   
		   });
				
		   $('#add_anchor3').click(function() {
			  
					var avaible_anchors = 3;					
					var tbody = $('#table3').find('tbody')
		            var row = tbody.find('tr:last-child').clone();
					//alert(tbody.find('tr').length);
					var nums=parseInt(tbody.find('tr').length+1);
					var arr_num=tbody.find('tr').length;
										
					row.find('label').text('Anchor 3'+arr[arr_num]);
					row.find('.no3').text('Link/ URL 3'+arr[arr_num]);
					
					//row.find('.rating .range_slider div:first').removeClass('rslider'+tbody.find('tr').length);
					row.find(".range_slider input[type='hidden']").removeAttr('id');
					row.find(".range_slider a").find('div').removeAttr('id');
					row.find(".range_slider input[type='hidden']").removeAttr('name');
					
					row.find(".chkbox3 input[type='radio']").removeAttr('name');
					row.find(".help_box2 input[type='text']").val('');
					row.find(".part6_4 input[type='text']:first").removeAttr('name');
					row.find(".part6_4 input[type='text']:last").removeAttr('name');
					row.find(".chkbox3 input[type='radio']").removeAttr('checked');
					row.find(".part6_4 input[type='text']:first").val('');
					row.find(".part6_4 input[type='text']:last").val('');
					
					
					row.find(".chkbox3 input[type='radio']").attr('name','anchor_set_rrr'+nums);					
					row.find(".part6_4 input[type='text']:first").attr('name','anchor_rrr'+nums);
					row.find(".part6_4 input[type='text']:last").attr('name','link_rrr'+nums);
					
					
					//row.find('.rating .range_slider div:first').addClass('rslider'+nums);
					row.find(".range_slider input[type='hidden']").attr('name','qty_rrr'+nums);
					row.find(".range_slider input[type='hidden']").attr('id','qty_rrr'+nums);
					row.find(".range_slider a").find('div').attr('id','tooltip'+nums);
					row.find(".range_slider").find('div').attr('id','rrr'+nums);				
					
					/* new logic for second slider by bhaiya*/
					var old_val=0;	
					var ids=tbody.find('tr').length;
															
					old_val=$('#tooltiprrr'+ids).text();					
					old_val=parseInt(old_val)+1;
						
					tbody.append( row );
					$('#rrr'+nums+' .ui-slider-range').css('width','0%');
					$('#rrr'+nums+' .ui-slider-handle').css('left','0%');
					//sliders(nums,$('input[name=submission_num]').val(),'qlty'+nums); //old logic for all slider is same
					//$('#min_qty'+nums).val(old_val);
					
					$('#r').append('<input type="hidden" name="min_qty_rrr'+nums+'" value="'+old_val+'">');
					sliders(nums,old_val,$('input[name=submission_num]').val(),'qty_rrr'+nums,old_val,"rrr");
					
					//}
				});		
						
			/**
			 * Remove Button
			 * Removes row or clear information in row
			 **/	
			window.remove_it = function(id) {
					var row = $('#every_remove'+id).parent();
					var tbody = row.parent().parent();
					row.remove();
					tbody.find('tbody tr').each(function(i){
						if(i!=0){							
							var nums=i+1;	
								
							$(this).find(".chkbox3 input[type='radio']").removeAttr('name');
							$(this).find(".part6_4 input[type='text']:first").removeAttr('name');
							$(this).find(".part6_4 input[type='text']:last").removeAttr('name');
							$(this).find(".every_remove").remove();
							$(this).find('label').text('Anchor '+nums);
							$(this).find('.no3').text('Link/ URL '+nums);															
							$(this).find(".chkbox3 input[type='radio']").attr('name','anchor_set'+nums);					
							$(this).find(".part6_4 input[type='text']:first").attr('name','anchor'+nums);
							$(this).find(".part6_4 input[type='text']:last").attr('name','link'+nums);
							//$(this).append('<div class="every_remove" id="every_remove'+nums+'"><a href="javascript:void(0)" onClick="remove_it('+nums+');">- Remove</a></div>');
						}
					});
				}
	//$('#spin_area').html(spiner);
	       $('#chk_box1 input:checkbox').click(function(){
					var networks = [];
					$("#chk_box1 input[type='checkbox']:checked").each(function() { 
							   // Your code goes here...
							   var network_name=$(this).val();				
						       networks.push([network_name]);	
							   
							});
							
					if($('#chk_box1 input[type="checkbox"]').not(':checked')){
						  $('#select_all').removeAttr( "checked" );
						}
					
					//alert(networks.toString());
					$.post( path_url+"scrapper/num_of_domains", { ids:networks.toString(), action:'num_domains'}, function(data){
	 					 var domains_all = data+' Domains Selected';
						 $('.part1 h3:last').text(domains_all);	
					});
				});
				
	          $('#select_all').click(function () {
				var networks = [];	
				  if($(this).is(":checked")){
					$('#chk_box1 input:checkbox').prop('checked', true);
				  }else{
					$('#chk_box1 input:checkbox').prop('checked', false);
				  }
				  //$("#chk_box1 input[type='checkbox']:checked").trigger( "click" );
				  
				  $("#chk_box1 input[type='checkbox']:checked").each(function() { 							   
							   var network_name=$(this).val();				
						       networks.push([network_name]);	
							   
							});					
					
				    $.post( path_url+"scrapper/num_of_domains", { ids:networks.toString(), action:'num_domains'}, function(data){
						
						var domains_all = data+' Domains Selected';
						 $('.part1 h3:last').text(domains_all);	
					});
				});
				$('.part5_1 .right input:checkbox').click(function(){
					$('#spin_area_manually').css('display','none');
					$('#spin_area_smart').removeAttr('style');
					$('.part5_1 .left input:checkbox').prop('checked', false);
				});
				
				$('.part5_1 .left input:checkbox').click(function(){
					$('#spin_area_smart').css('display','none');
					$('#spin_area_manually').removeAttr('style');
					$('.part5_1 .right input:checkbox').prop('checked', false);
				});
			    $('input:checkbox[name=blended]').click(function(){
					if($(this).is(":checked")){
					$('input:radio[name=comment_seeding]').removeAttr('disabled');	
					}else{
					$('input:radio[name=comment_seeding]').removeAttr('checked');
					$('input:radio[name=comment_seeding]').attr('disabled', true);
					
					}
				});
				
				
				$('#checkbox-1-6').click(function(){
					if($(this).is(":checked")){
					$('#radio-1-2').removeAttr('disabled');
					
					$('#checkbox-1-1').removeAttr('checked');
					$('#radio-1-3').removeAttr('checked');
					$('#radio-1-3').attr('disabled', true);
					
					
					}else{
					$('#radio-1-2').removeAttr('checked');
					$('#radio-1-2').attr('disabled', true);					
					//alert('hit');
					}					
				});
				
				$('#checkbox-1-1').click(function(){
					if($(this).is(":checked")){
					$('#radio-1-3').removeAttr('disabled');
					
					////////////////////////////////////
					$('#checkbox-1-6').removeAttr('checked');
					$('#radio-1-2').removeAttr('checked');
					$('#radio-1-2').attr('disabled', true);
					//////////////////////////////////////////	
					}else{
					$('#radio-1-3').removeAttr('checked');
					$('#radio-1-3').attr('disabled', true);					
					//alert('hit');
					}					
				});
				
				$( "#datepicker" ).datepicker({				
					 showOn: 'button',      
					  buttonImage: path_url+'assets/images/pic22.png',
					  buttonImageOnly: true,					  
					  dateFormat: 'yy-mm-dd',
					});
				
				$('#start_timing input:checkbox:first').click(function(){					
					if($(this).is(":checked")){						
					$('#start_timing input:checkbox:last').removeAttr('checked');
					$('.cal').css('display','none');
					$('#datepicker').val('');
					}
				});
				$('#start_timing input:checkbox:last').click(function(){					
					if($(this).is(":checked")){						
					$('#start_timing input:checkbox:first').removeAttr('checked');
					$('.cal').removeAttr('style');
					}
				});
				
				/*loading time*/
				if($('#datepicker').val()==''){
				$('.cal').css('display','none');
				}
				if($('#start_timing input:checkbox:first').is(":checked")){
				$('#start_timing input:checkbox:last').removeAttr('checked');
					$('.cal').css('display','none');	
					$('#datepicker').val('');
				}
				if($('#start_timing input:checkbox:last').is(":checked")){
				    $('#start_timing input:checkbox:first').removeAttr('checked');
					$('.cal').removeAttr('style');
				}
				
				
				$('#checkbox-1-3').click(function(){
					if($(this).is(":checked")){	
					$(".help_box2").css('display','block');					
					
					}else{
						$(".help_box2").css('display','none');
						$(".help_box2 input[type='text']").val('');
					}
					
				});
					
				  $('.serp_formats .toggle-on').click(function() {	  
					  $('#serp_format').val('off');
				  });
				  
				  $('.serp_formats .toggle-off').click(function() {	  
					  $('#serp_format').val('on');
				  });				  
				 		
			   $('.serp_comments .toggle-on').click(function() {	  
					  $('#serp_comment').val('off');
				  });
				  
				  $('.serp_comments .toggle-off').click(function() {	  
					  $('#serp_comment').val('on');
				  });
				  
			  $('input:checkbox[name=unique_comments]').click(function(){
				 
				 if($(this).is(":checked")){
				   $('body').append(cvform);				  
				   $('.page').css('opacity','0.2');
				   $('.page').css('cursor','wait');
				 }else{
					
					$('.forms_cv').remove();	
					$('.page').removeAttr("style");  
				 }
			  });
			 
			 
			 
			 $('input[name=post_title]').blur(function(){				 
					 $.post( path_url+"scrapper/valid_spintax", { chk_value:$(this).val(), action:'vti'}, function(data){						
						if(data=='yes'){
						    $('#valid-title').html('<img src="'+path_url+'assets/images/pic11.png">&nbsp;&nbsp;Correct Spintax Detected');
						}else if(data=='no'){
							$('#valid-title').html('<img src="'+path_url+'assets/images/img18.png">&nbsp;&nbsp;Correct Spintax Detected');
						}
					});					
				});
			 $('textarea[name=post_content]').blur(function(){				 
					 $.post( path_url+"scrapper/valid_spintax", { chk_value:$(this).val(), action:'vti'}, function(data){						 					
						if(data=='yes'){
						    $('#valid-post').html('<img src="'+path_url+'assets/images/pic11.png">&nbsp;&nbsp;Correct Spintax Detected');
						}else if(data=='no'){
							$('#valid-post').html('<img src="'+path_url+'assets/images/img18.png">&nbsp;&nbsp;Correct Spintax Detected');
						}
					});					
				});
			 
			 
			 
				
    });  
	function call(){
	//alert('hi');
	$('.forms_cv').remove();	
	$('.page').removeAttr("style");
	
	}
	function search_yahoo(spider , key_count, total_key_count){
		
		var keywords = $('input[name=keywords]').val();
		var synonyms = $('input[name=synonyms]').val();
		var topics = $('input[name=topics]').val();
		
		if(keywords==''){
		$('#error_search').text('Keyword is empty'); 
		$('input[name=keywords]').focus();
	    return false;	
	    }else{
		$('#error_search').text('');	
		}
		
		
		
		
		$('#search_res').html('<p>Loading......</p>');
		$.ajax({        
					url:path_url+'scrapper/comment_syscon/',
					type:'POST',
					data: {act : spider,key : key_count, keywords:keywords, synonyms:synonyms, topics:topics},
					success:function(response_data){					    
						//var res = response_data.split("*^&");
					   // var num_comments = parseInt(res.length)-1;  
						$('#search_res').html('Great, You find Comments for this keyword.<br>Please go ahead');
						//$('#search_res').html(response_data);
						$('#error_search').text('');
						$('#serp_comm').val(response_data);
						/*setTimeout(function(){
								$('.forms_cv').remove();	
								$('.page').removeAttr("style"); 									
							}, 100000);	*/
						}
				});
		
	}
	
	/*tinymce.init({
    mode: "textareas",
    plugins: "table",
    content_css: "css/content.css",
    style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ],
    formats: {
        alignleft: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left'},
        aligncenter: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center'},
        alignright: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right'},
        alignfull: {selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full'},
        bold: {inline: 'span', 'classes': 'bold'},
        italic: {inline: 'span', 'classes': 'italic'},
        underline: {inline: 'span', 'classes': 'underline', exact: true},
        strikethrough: {inline: 'del'},
        customformat: {inline: 'span', styles: {color: '#00ff00', fontSize: '20px'}, attributes: {title: 'My custom format'}}
    }
});     */                    

/*
$('input:checkbox[name=randomly_post]').click(function(){
					if($(this).is(":checked")){
					$('input:radio[name=randomly_refresh]').removeAttr('disabled');
					//////////////////////////////////
					$('input:checkbox[name=smart_monitoring]').removeAttr('checked');
					$('input:radio[name=smart_refresh]').removeAttr('checked');
					$('input:radio[name=smart_refresh]').attr('disabled', true);
					
					//////////////////////////////////	
					}else{
					$('input:radio[name=randomly_refresh]').removeAttr('checked');
					$('input:radio[name=randomly_refresh]').attr('disabled', true);					
					//alert('hit');
					}					
				});
				
				$('input:checkbox[name=smart_monitoring]').click(function(){
					if($(this).is(":checked")){
					$('input:radio[name=smart_refresh]').removeAttr('disabled');
					
					////////////////////////////////////
					$('input:checkbox[name=randomly_post]').removeAttr('checked');
					$('input:radio[name=randomly_refresh]').removeAttr('checked');
					$('input:radio[name=randomly_refresh]').attr('disabled', true);
					//////////////////////////////////////////	
					}else{
					$('input:radio[name=smart_refresh]').removeAttr('checked');
					$('input:radio[name=smart_refresh]').attr('disabled', true);					
					//alert('hit');
					}					
				});

*/