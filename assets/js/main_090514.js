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
var spiner=' <p>Ok, great in order to create content we will need some information about your project and subject matter.</p>';
	spiner+='<div class="part6_7 clearfix">';
		spiner+='<div class="link_anchor">SERP Avenger Smart Content <span class="help"><img alt="no img" src="'+path_url+'assets/images/img2.png"></span></div>';
		spiner+='<b>Help us learn more about the type of content needed for this project by answering the following: </b>';
		spiner+='<b>What are the General Topics or Categories?</b>';
		spiner+='<p>IE: Weight loss, diet, exercise, nutrition, etc.</p>';
		spiner+='<input type="text" name="" value="Enter several generic relevant topics. (Separated by commas)">';
		spiner+='<b>What specific keywords will be used as anchors?</b>';
		spiner+='<p>IE: acai berry, acai berry diet,  buy acai berries, etc.</p>';
		spiner+='<input type="text" name="" value="Enter your exact keywords or phrases. (separated by commas)">';
		spiner+='<b>List any synonyms that could be used be replaced by your keywords.</b>';
		spiner+='<p>IE: diet pills, antioxidant, purple fruit, anthocyanins, superfoods, etc.</p>';
		spiner+='<input type="text" name="" value="Enter as many synonyms that could be substituted by your keywords  (separated by commas)">';
	spiner+='</div>';
	spiner+='<div class="part5_3 clearfix">';
		spiner+='<h3>How many unique articles should we create/ post?</h3><input type="text" value="Enter Number" name="">';
		spiner+='<div class="button-holder clearfix">';
			spiner+='<input type="radio" checked="" class="regular-radio" name="radio-1-set" id="radio-1-7"><label for="radio-1-7"></label>';
			spiner+='<span>Continue until paused or stopped.</span>';
		spiner+='</div>';
	spiner+='</div>';			
    $(document).ready(function(){
		
		
		   $('#add_anchor').click(function() {
					var avaible_anchors = 3;					
					var tbody = $('.part6').prev().find('tbody')
		            var row = tbody.find('tr:last-child').clone();
					//alert(tbody.find('tr').length);
					var nums=parseInt(tbody.find('tr').length+1);
					row.find('label').text('Anchor '+nums);
					row.find('.no3').text('Link/ URL '+nums);
					
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
					//row.append('<div class="every_remove" id="every_remove'+nums+'"><a href="javascript:void(0)" onClick="remove_it('+nums+');">- Remove</a></div>');
					if( tbody.find('tr').length < avaible_anchors ) {
					tbody.append( row );
					}
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
				
				
				
				
				
    });  
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