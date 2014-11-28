<div class="seorankinglist">
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
  <table border="1">
    <tr><td colspan="6" align="right"><a class="addListBtn" href="<?php echo base_url(); ?>seoranking/add">Add</a></td></tr>
    <tr>
	<th>Sl No</th>
	<th>Title</th>
	<th>Page Type</th>
	<th>Campaign</th>
	<th>Start Date</th>
	<th>Action</th>
    </tr>   
	<?php
	if(is_array($seo_ranking_data) && count($seo_ranking_data) > 0) {
	    for($i=0;$i<count($seo_ranking_data);$i++) {
	?>
	<tr>
	    <td><?php echo ($i+1);?></td>
	    <td><?php echo stripslashes($seo_ranking_data[$i]['title']);?></td>
	    <td><?php echo stripslashes($seo_ranking_data[$i]['type_of_page']);?></td>
	    <td><?php echo stripslashes($seo_ranking_data[$i]['campaign_name'][0]['campaign_title']);?></td>
	    <td><?php echo stripslashes($seo_ranking_data[$i]['start_date']);?></td>
	    <td align="center" valign="top;"><a class="updateIcon" href="<?php echo base_url();?>seoranking/ReserverDateUpdate/<?php echo $seo_ranking_data[$i]['s_r_id'];?>">Update Reverse Date</a>&nbsp;&nbsp;<a class="deleteIcon" href="<?php echo base_url();?>seoranking/DeleteSeoRanking/<?php echo $seo_ranking_data[$i]['s_r_id'];?>">Delete</a></td>
	</tr>
	<?php 
	    }
	}
	?>
   </table>     
   </center>
</div>
