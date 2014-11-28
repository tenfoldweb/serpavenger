<?php if(validation_errors()){echo '<div class="alert-box error">' . validation_errors('<p><span>error: </span>', '</p>') . '</div>';}?>
<form name="frmAddCampaign" id="frmAddCampaign" action="" method="post">
    <input type="hidden" name="action" value="Process">
    <input type="hidden" name="skip" id="skip" value="No">
    <p>
        <label>Campaign Title:</label><br class="spacer" />
        <input type="text" name="campaign_title" id="campaign_title" value="<?php echo set_value('campaign_title');?>" placeholder="Enter a name for this campaign">
    </p>
    <p>
        <label>Type of Site:</label><br class="spacer" />
        <input type="radio" name="campaign_site_type" id="campaign_site_type1" value="1" <?php if(set_value('campaign_site_type') == '1'){echo 'CHECKED';}?>> Money/Client Website<br class="spacer" />
        <input type="radio" name="campaign_site_type" id="campaign_site_type2" value="2" <?php if(set_value('campaign_site_type') == '2'){echo 'CHECKED';}?>> Leech/Parasite Page<br class="spacer" />
    </p>
    <p>
        <label>What search engine would you like to focus on?</label><br class="spacer" />
        <!-- Google -->
        <input type="checkbox" name="isCrawlByGoogle" id="isCrawlByGoogle" value="Yes" <?php if(isset($_POST['isCrawlByGoogle']) && $_POST['isCrawlByGoogle']== 'Yes'){echo 'CHECKED';}?> />
        <img src="<?php echo FRONT_IMAGE_PATH;?>google_icon-small.png" alt="">
        <select name="google_se_domain" id="google_se_domain">
            <option value="">Select Country</option>
            <?php
            if(is_array($google_country) && count($google_country) > 0){
                for($i=0; $i<count($google_country); $i++){
            ?>
                <option value="<?php echo $google_country[$i]['url'];?>"><?php echo stripslashes($google_country[$i]['country']);?></option>
            <?php
                }
            }
            ?>
        </select>
        <!-- Bing -->
        <input type="checkbox" name="isCrawlByBing" id="isCrawlByBing" value="Yes" <?php if(isset($_POST['isCrawlByBing']) && $_POST['isCrawlByBing']== 'Yes'){echo 'CHECKED';}?> />
        <img src="<?php echo FRONT_IMAGE_PATH;?>bing_icon-small.png" alt="">
        <select name="bing_se_domain" id="bing_se_domain">
            <option value="">Select Country</option>
            <?php
            if(is_array($bing_country) && count($bing_country) > 0){
                for($i=0; $i<count($bing_country); $i++){
            ?>
                <option value="<?php echo $bing_country[$i]['url'];?>"><?php echo stripslashes($bing_country[$i]['country']);?></option>
            <?php
                }
            }
            ?>
        </select>
        <!-- Yahoo -->
        <input type="checkbox" name="isCrawlByYahoo" id="isCrawlByYahoo" value="Yes" <?php if(isset($_POST['isCrawlByYahoo']) && $_POST['isCrawlByYahoo']== 'Yes'){echo 'CHECKED';}?> />
        <img src="<?php echo FRONT_IMAGE_PATH;?>yahoo_icon-small.png" alt="">
        <select name="yahoo_se_domain" id="yahoo_se_domain">
            <option value="">Select Country</option>
            <?php
            if(is_array($yahoo_country) && count($yahoo_country) > 0){
                for($i=0; $i<count($yahoo_country); $i++){
            ?>
                <option value="<?php echo $yahoo_country[$i]['url'];?>"><?php echo stripslashes($yahoo_country[$i]['country']);?></option>
            <?php
                }
            }
            ?>
        </select>
    </p>
    <p>
        <label>URL of Main Page You Want to Rank:</label><br class="spacer" />
        <input type="text" name="campaign_main_page_url" id="campaign_main_page_url" value="<?php echo set_value('campaign_main_page_url');?>" placeholder="Enter your main page URL">
               
    </p>
    <p>
        <label>Track Exact URL Only?</label><br class="spacer" />
        <input type="radio" name="campaign_exact_url_track" id="campaign_exact_url_track1" value="Yes"> Yes, Please!
        <input type="radio" name="campaign_exact_url_track" id="campaign_exact_url_track2" value="No"> No, Please look for nay of the pages ranking(Don't use this option for parasite pages)!
    </p>
    <p>
        <label>Main Target keyword:</label><br class="spacer" />
        <input type="text" name="campaign_main_keyword" id="campaign_main_keyword" value="<?php echo set_value('campaign_main_keyword');?>" placeholder="Enter your main target keyword">
    </p>
    <p>
        <label>Secondary keyword:</label><br class="spacer" />
        <input type="text" name="campaign_secondary_keyword" id="campaign_secondary_keyword" value="<?php echo set_value('campaign_secondary_keyword');?>" placeholder="If Applicable, Enter Nect Most Important KW"><br class="spacer"><i>Note: You can add additional keywords later</i>
    </p>
    <p>
        <input type="submit" name="subLogin" id="subLogin" value="Next"><br class="spacer"><a href="javascript:void(0);" onclick=javascript:skipStep();">Please Skip Analyze & Compare Step</a>
    </p>
</form>
<script type="text/javascript">
    function skipStep(){
        document.getElementById("skip").value('Yes');
        document.forms['frmAddCampaign'].submit();
    }
</script>