<script>

$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			

	$(window).resize(function () {
	 
 		var box = $('#boxes .window');
 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
      
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});
	
});

</script>
<style>



#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:9000;
  background-color:#000;
  display:none;
}
  
#boxes .window {
  position:fixed;
  left:0;
  top:0;
  width:440px;
  height:200px;
  display:none;
  z-index:9999;
  padding:20px;
}

#boxes #dialog {
  width:375px; 
  height:203px;
  padding:10px;
  background-color:#ffffff;
}


</style>

<center>
    <br><br>
<table border="1">
    <tr><td colspan="15"><b>Ranking By Keywords</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#dialog" name="modal">Add Keywords</a></td></tr>
    <tr>
    <th>Campaign</th>
    <th>Keywords</th>
    <th>Main Keyword</th>
    <th>Google</th>
    <th>Trend</th>
    <th>Meter</th>
    <th>Pop</th>
    <th>Low</th>
    <th>Bing</th>
    <th>Trend</th>
    <th>Meter</th>
    <th>Yahoo</th>
    <th>Trend</th>
    <th>Meter</th>
    <th>Tests</th>
    </tr>
    <?php
    if(is_array($campaign_record) && count($campaign_record) > 0) {
        for($i=0;$i<count($campaign_record);$i++) {
            
            if($campaign_record[$i]['additional_keyword'] != '0') {
                $total_keyword = $campaign_record[$i]['additional_keyword'];
            }
            ?>
            <tr>
                <td><?php echo ucwords(stripslashes($campaign_record[$i]['campaign_title'])); ?></td>
                <td><?php echo stripslashes($total_keyword); ?></td>
                <td><?php echo ucwords(stripslashes($campaign_record[$i]['campaign_main_keyword'])); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
            
        }
    } else { ?>
    <tr><td colspan="15">No Record Found</td></tr>
   <?php     
    }
    ?>
</table>
<div id="boxes">
<!--TABLE_USER_CAMPAIGNS_KEYWORD-->
<div id="dialog" class="window">
    <div style="float: right;"><a href="#"class="close"/>Close</a></div>
    <div id="success_msg"></div>
    <br>
<form onsubmit="return false">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" id="user_id">
    Enter Keyword: <input type="text" name="keyword" value="" placeholder="Type Keyword" id="keyword" required>
        <br><br><br>
     Choose Campaign :
     <select required x-moz-errormessage="Select Campaign" name="campaign_id" id="campaign_id">
        <option value="">Choose Campaign</option>
        <?php
        if(is_array($campaign_record) && count($campaign_record) > 0) {
            for($i=0;$i<count($campaign_record);$i++) {
        ?>
        <option value="<?php echo $campaign_record[$i]['campaign_id']; ?>"><?php echo ucwords(stripslashes($campaign_record[$i]['campaign_title'])); ?></option>
        <?php 
            }
        }
        ?>
     </select>
     <br><br><br>
    <input type="submit" name="submit" value="Submit Keyword" id="save_keyword">
</form>
</div>

<!-- Mask to cover the whole screen -->
  <div id="mask"></div>
</div>
</center>