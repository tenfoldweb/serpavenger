
$(function() {	

	//var base_url = document.domain;
	var base_url_suffix	= 'serp-new/';
	var base_url = location.protocol + '//' + location.host + '/' + base_url_suffix;
	
	$("#save_keyword").click(function(){
		
		
		var user_id 	= $("#user_id").val();
		var keyword 	= $("#keyword").val();
		var campaign_id = $("#campaign_id").val();
		var dataString  = 'user_id=' + encodeURIComponent(user_id)+'&keyword='+encodeURIComponent(keyword)+'&campaign_id='+encodeURIComponent(campaign_id);
		
		$.ajax({
				type: 'POST',
				url: base_url + 'ajax/InsertKeyword',
				data: dataString,
				beforeSend: function(){
				},
				success: function(data){
					$("#success_msg").html(data);
					$('#keyword').val('');
					$('#campaign_id').val('');
					
				}	
		  });
	});
	
	
	
	
	
});