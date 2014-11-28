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
    <form method="post" action="<?php echo base_url();?>seoranking/ReserverDateUpdate">
    <table>
     <tr>
        <td valign="top" align="left">Title :</td>
        <td valign="top" align="left"><input type="text" name="title" value="<?php echo $seo_ranking_details[0]['title'];?>" readonly="readonly"></td>
    </tr>
   
    <tr>
        <td valign="top" align="left">Reserve Date :</td>
        <td valign="top" align="left"><input name="reverse_date" type="text" maxlength="10"  class="datepicker startDate" value="<?php if($seo_ranking_details[0]['reverse_date'] == '0000-00-00') {echo date("Y-m-d"); } else { echo $seo_ranking_details[0]['reverse_date']; }?>" /></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="hidden" name="s_r_id" value="<?php echo $seo_ranking_details[0]['s_r_id'];?>"><input type="hidden" name="action" value="Process"><input name="submit" type="submit" value="Submit" /></td>
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