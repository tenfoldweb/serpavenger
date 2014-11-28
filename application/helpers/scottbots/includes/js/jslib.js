var BASE;
BASE = 'http://serpavenger.com/scottbots/';
// BASE = 'http://localhost/scottbots/';

$(document).ready(function(){
    
    /*Google ranking spider*/
    $('#google-rank-btn').click(function(){        
        
        $('#result').html('');
        var loc = $('#location').val();
        var bot = $('#bot').val();
        var key = $('#key').val();
        var page = $('#page').val();
        var delay = 0;
        if($('#delay').is(':checked'))
            delay = 1;
        var source = 'gui';
        if(page < 1){
            alert('Page value is less then MIN (1).');
        }else{
            $('#ajax').show();        
            $('#result').html('Running bot please wait');
            initialize(bot,loc,key,source,page,delay);   
        }
    });
    
    
});

/*spider call*/
function initialize(bot , location, keyword, source, page, delay){   
    $.ajax({        
            url:BASE+'service.php',
            type:'POST',
            data:{'bot':bot,'key':keyword,'loc':location,'source':source,'page':page,'delay':delay},
            success:function(response_data){   
               $('#result').html(response_data);
               $('#ajax').hide();
            }
        });
}
