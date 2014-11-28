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
		
		
		   $('#next_anchor').click(function(){
			var max_time=3;  
			 $('#add_anchor').hide();
			 // var neaa = $('table tbody tr').html();
			  var table = $('#alltables').find('table:last');
			  var preId=table.attr("id");
		      var newtable = table.clone();
			  //var arr2=['2a','2b','2c','2d'];
			  var array=['a','b','c','d'];
			  var new_synms = $('#alltables').find('table').length;
			  newtable.attr("id","r"+preId);
			  newtable.find('tbody tr').each(function(i) {
				var new_num=parseInt(i)+1;
				$(this).find('label').text('Anchor '+(preId.length+1)+array[i]);
				//$(this).find('label').attr('name', $(this).attr('name') + i); 

				$(this).find('.no3').text('Link/ URL '+(preId.length+1)+array[i]);
					
					//$(this).find('.rating .range_slider div:first').removeClass('rslider'+tbody.find('tr').length);
					
					//alert($(this).find(".part6_4 input[type='text']:last").attr('name'));
					$(this).find(".chkbox3 input[type='radio']").attr('name',$(this).find("input[type='radio']").attr('name') + new_num);					
					$(this).find(".part6_4 input[type='text']:first").attr('name',$(this).find(".part6_4 input[type='text']:first").attr('name') + new_num);
					$(this).find(".part6_4 input[type='text']:last").attr('name',$(this).find(".part6_4 input[type='text']:last").attr('name') + new_num);
					$(this).find(".part6_4 input[name^='synonyms']").attr('name','synonyms'+new_synms+'[]');
					
					
					//$(this).find('.rating .range_slider div:first').addClass('rslider'+nums);
					$(this).find(".range_slider input[type='hidden']").attr('name',$(this).find(".range_slider input[type='hidden']").attr('name') + new_num);
					$(this).find(".range_slider input[type='hidden']").attr('id',$(this).find(".range_slider input[type='hidden']").attr('id') + new_num);
					$(this).find(".range_slider a").find('div').attr('id',$(this).find(".range_slider a").find('div').attr('id') + i); 
					$(this).find(".range_slider").find('div').attr('id', "r"+preId+ new_num);
			  
              });
			  //newtable.find('')
			  //console.log("tt >> "+newtable.html());
			  if( $('#alltables').find('table').length < max_time ) {
			  $('#alltables').append( newtable );
			  
             // sliders(1,5,10,'qlty'+1,0,"r"+preId);
			 // sliders(2,5,10,'qlty'+1,0,"r"+preId);
			 // sliders(3,5,10,'qlty'+1,0,"r"+preId);
			  newtable.find('tbody tr').each(function(i) {				  
				 var new_num=parseInt(i)+1;  
				
			   
			  sliders(new_num,0,$('input[name=submission_num]').val(),$(this).find(".range_slider input[type='hidden']").attr('id'),0,"r"+preId); 	  
				 
			  $("#r"+preId+ new_num).find("#r"+preId+ new_num).remove();
			  $("#r"+preId+ new_num).append('<div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: '+0+'%;"></div>');
			 
			  
			  });
			  }
			 // alert(neaa);
			 //$('.second-anchor .part5_2').remove();
			// $('.second-anchor').append('<div class="part5_2 clearfix"><a href="javascript:void(0)" id="third_anchor">+ Third Anchor/ Link to Same Post</a></div>');
			//arr2=['3a','3b','3c','3d'];
		  });
		  
		 /* $(this).find("input[type='text']").each(function(index) {
                        //var new_index=index+1
						var res = (this.name).replace(/[]/g, ''); 
						this.name = this.name+new_num;
						alert(res);
                    });*/
		  
		  
		  
		
		   $('input[name=submission_num]').blur(function(){
					$('.range_slider .ui-slider-range').css('width','0%');
					$('.range_slider .ui-slider-handle').css('left','0%');
					
					
					sliders(1,0,$(this).val(),'qlty1',0,"r")
					//sliders(2,$(this).val(),'qlty2')
					//sliders(3,$(this).val(),'qlty3')
					
					//sliders(4,$(this).val(),'hp_mon')
					slidersFooter(20,0,$(this).val(),'hp_smart',0)
					//alert('hit');
				});
		   var arr=['1a','1b','1c','1d'];		
		   $('#add_anchor').click(function() {
					var avaible_anchors = 3;					
					var tbody = $('.part6').prev().find('tbody')
		            var row = tbody.find('tr:last-child').clone();
					//alert(tbody.find('tr').length);
					var nums=parseInt(tbody.find('tr').length+1);
					var arr_num=tbody.find('tr').length;
					row.find('label').text('Anchor '+arr[arr_num]);
					row.find('.no3').text('Link/ URL '+arr[arr_num]);
					
					row.find('.rating .range_slider div:first').removeClass('rslider'+tbody.find('tr').length);
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
					//row.find(".every_remove").remove();
					
					row.find(".chkbox3 input[type='radio']").attr('name','anchor_set'+nums);					
					row.find(".part6_4 input[type='text']:first").attr('name','anchor'+nums);
					row.find(".part6_4 input[type='text']:last").attr('name','link'+nums);
					
					
					row.find('.rating .range_slider div:first').addClass('rslider'+nums);
					row.find(".range_slider input[type='hidden']").attr('name','qlty'+nums);
					row.find(".range_slider input[type='hidden']").attr('id','qlty'+nums);
					row.find(".range_slider a").find('div').attr('id','tooltip'+nums);
					row.find(".range_slider").find('div').attr('id','r'+nums);
					//alert(nums+'*******'+$('input[name=submission_num]').val()+'######'+'qlty'+nums);
					//$('input[name=submission_num]').trigger( "blur" );
					//sliders(nums,$('input[name=submission_num]').val(),'qlty'+nums);
					//row.append('<div class="every_remove" id="every_remove'+nums+'"><a href="javascript:void(0)" onClick="remove_it('+nums+');">- Remove</a></div>');
					if( tbody.find('tr').length < avaible_anchors ) {
					/* new logic for second slider by bhaiya*/
					//var tot_val=0;
					var old_val=0;	
					var ids=tbody.find('tr').length;
					for(var val=1;val<=ids;val++){
						//tot_val=parseInt(tot_val) + parseInt($('#qlty'+val).val());
						//alert($('#tooltip'+val).text());											
					   // old_val=parseInt(old_val)+ parseInt($('#tooltip'+val).text());
					}
										
					old_val=$('#tooltip'+ids).text();					
					old_val=parseInt(old_val)+1;
					//var left_post=($('input[name=submission_num]').val() - tot_val);
					//alert(old_val);
					/************ end logic**************************/	
					tbody.append( row );
					$('.rslider'+nums+' .ui-slider-range').css('width','0%');
					$('.rslider'+nums+' .ui-slider-handle').css('left','0%');
					//sliders(nums,$('input[name=submission_num]').val(),'qlty'+nums); //old logic for all slider is same
					$('#min_qty'+nums).val(old_val);
					sliders(nums,old_val,$('input[name=submission_num]').val(),'qlty'+nums,old_val,"r");
					}
				});
				
				/*$('.rslider1').click(function() {
					alert(hit1);
				});
				$('.rslider2').click(function() {
					alert(hit2);
				});
				$('.rslider3').click(function() {
					alert(hit3);
				});*/
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
						//$('#search_res').html('Grest, You find '+num_comments+' Comments for this keyword');
						$('#search_res').html(response_data);
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