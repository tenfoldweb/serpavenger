<script>
$(document).ready(function(){
    $('#type_of_page').change(function(){        
        var type = $('#type_of_page').val();
        if (type == "Offpage") {
            //code
            $('#duration').show();
        } else{
            $('#duration').hide();
        }
     });
    })    
</script>
<?php if(validation_errors()){echo '<div class="alert-box error">' . validation_errors('<p><span>error: </span>', '</p>') . '</div>';}?>
<div class="seorankingadd">
     <div class="widget">
		<?php if(isset($succmsg) && $succmsg != ""){?>
        <div align="center">
            <div class="nNote nSuccess" style="width: 600px;">
                <p><?php echo stripslashes($succmsg);?></p>
            </div>
        </div>
        <?php } ?>
        <?php if(isset($errmsg) && $errmsg != ""){?>
        <div align="center">
            <div class="nNote nFailure" style="width: 600px;">
                <p><?php echo stripslashes($errmsg);?></p>
            </div>
        </div>
        <?php } ?>
    <center>
    <form method="post" action="<?php echo base_url();?>seoranking/add">
        <table>
    <tr>
        <td valign="top" align="left">Campaign :</td>
        <td valign="top" align="left">
            <select name="campaign_id">
                <option value="">Select Campaign</option>
                <?php
		    if(is_array($campaign_data) && count($campaign_data) > 0){
			for($i=0; $i<count($campaign_data); $i++){
		    ?>			
			<optgroup title="<?php echo stripslashes($campaign_data[$i]['campaign_title']);?>"></optgroup>
		    <?php
				if(is_array($campaign_data[$i]['campaign']) && count($campaign_data[$i]['campaign']) > 0){
					for($j=0; $j<count($campaign_data[$i]['campaign']); $j++){
		    ?>
						<option value="<?php echo $campaign_data[$i]['campaign'][$j]['campaign_id'];?>"><?php echo stripslashes($campaign_data[$i]['campaign'][$j]['keyword']);?></option>
		    <?php
					}
				}
			}
		    }
		    ?>
            </select>
        </td>
    </tr>
    <tr>
        <td valign="top" align="left">Page Type :</td>
        <td valign="top" align="left">
            <select name="type_of_page" id="type_of_page">
                <option value="">Select Page Type</option>
                <option value="Onpage" <?php if(set_value('type_of_page') == 'Onpage') { echo 'selected';}?>>Onpage</option>
                <option value="Offpage" <?php if(set_value('type_of_page') == 'Offpage') { echo 'selected';}?>>Offpage</option>
            </select>
        </td>
    </tr>
    <tr>
        <td valign="top" align="left">Title :</td>
        <td valign="top" align="left"><input type="text" name="title" value="<?php echo stripslashes(set_value('title'));?>"></td>
    </tr>
    <tr>
        <td valign="top" align="left">Description :</td>
        <td valign="top" align="left"><textarea name="description"><?php echo stripslashes(set_value('description'));?></textarea></td>
    </tr>
    <tr>
        <td valign="top" align="left">Start Date :</td>
        <td valign="top" align="left"><input name="start_date" type="text" maxlength="10"  class="datepicker startDate" value="<?php echo date("Y-m-d"); ?>" /></td>
    </tr>
    <tr id="duration" style="display:none;">
        <td valign="top" align="left">Duration :</td>
        <td valign="top" align="left">
            <input type="radio" name="duration" value="3days" <?php if(set_value('duration') == '3days') { echo 'checked';}?>>3 days &nbsp;&nbsp;
            <input type="radio" name="duration" value="1week" <?php if(set_value('duration') == '1week') { echo 'checked';}?>>1 week &nbsp;&nbsp;
            <input type="radio" name="duration" value="3week" <?php if(set_value('duration') == '3week') { echo 'checked';}?>>3 week &nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="hidden" name="action" value="Process"><input name="submit" type="submit" value="Submit" /></td>
    </tr>
   </table> 
    </form>
   </center>
</div>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(function(){
   $(".datepicker").datepicker({
       
       dateFormat:"yy-mm-dd",
   });
  
    
    
});


</script>