<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Google Spider</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <!--<script language="javascript" type="text/javascript" src="includes/js/jslib.js"></script>-->
    <script>
	    var BASE;
		BASE = "<?php echo base_url()?>";
		
		$(document).ready(function(){
			
			/*Google ranking spider*/
			$('#google-rank-btn').click(function(){        
				$('#result').html('');
				$('#ajax').show();
				$('#result').html('Extracting from Google please wait');
				initialize('gr', 1, 2);   
			});
			
			/*Google blog spider*/
			$('#google-blog-btn').click(function(){
				$('#result').html('');
				$('#ajax').show();
				$('#result').html('Extracting from Google please wait');
				initialize('google',1);   
			});
			/*Yahoo spider*/
			$('#yahoo-blog-btn').click(function(){
				$('#result').html('');
				$('#ajax').show();
				$('#result').html('Extracting from Yahoo please wait');
				initialize('yahoo',1);
			});			
		});
		
		/*spider call*/
		function initialize(spider , key_count, total_key_count){   
			$.ajax({        
					url:BASE+'scrapper/syscon/'+spider,
					type:'GET',
					data: {act : spider,key : key_count},
					success:function(response_data){  
						$('#result').html(response_data);
						$('#ajax').hide();
					}
				});
		}
    </script>
    <!--<link href="includes/style/style.css"  type="text/css" rel="stylesheet" />-->
    <style>
    body{
	margin:0px;
	font-family:tahoma;
	font-size:16px;
	}
	
	#result{
	height:auto;
	overflow:auto;
	text-align:left;
	padding:10px;
	margin-top:10px;
	margin-left:10px;
	font-size:13px;
	}
    </style>
  </head>
  <body style="margin:0px; font-family:tahoma; font-size:11px">
    <div style="margin:auto; width:auto;">
      <table width="39%" border="0" cellspacing="0" cellpadding="10" align="center" style="margin-top:20px;border:1px dotted #000000;background-color:#DDDDDD">
        <tr>
          
          <td colspan="1" >
            <div align="left">
              <input id="google-rank-btn" type="button" value="Start Ranking Extraction" />
              <input id="google-blog-btn" type="button" value="Start Blog Extraction" />
              <input id="yahoo-blog-btn" type="button" value="Start Yahoo Extraction" /><br /><br /><hr />
            </div>
          </td>
        </tr>
      </table>      
    </div>
    <img src="<?php echo base_url();?>assets/images/icon_waiting.gif" id="ajax"  style="display:none;">
    <div id="result"></div>
  </body>
</html>