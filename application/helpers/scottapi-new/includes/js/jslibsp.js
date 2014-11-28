var BASE;
BASE = 'http://serpavenger.com/scottapi/';
// BASE = 'http://localhost/scottapi/';

$(document).ready(function(){
    
    /*Google ranking spider*/
    $('#google-rank-btn').click(function(){        
        
        $('#result').html('');
        var site_url = $('#my_site_url').val();
		var bot = $("input:radio[name=isCraw]:checked").val();
        var key = $('#key').val();
        var loc = $('#'+bot+'_se_domain').val();
        var source = 'gui';
		var page=1;

        if(page < 1){
            alert('Page value is less then MIN (1).');
        }else{
            $('#ajax').show();        
            $('#result').html('Running bot please wait');
            initialize(site_url,bot,loc,key,source,page);   
        }
    });
    
    
});

/*spider call*/
function initialize(site_url,bot,location, keyword, source,page){   
//		
    $.ajax({        
            url:BASE+'service_sp.php',
            type:'POST',
            data:{'bot':bot,'key':keyword,'loc':location,'source':source,'page':page,'siteurl':site_url},
            success:function(response_data){   
				$('#result').html(response_data);
               $('#ajax').hide();
            }
        });
}

