<?php if(validation_errors()){echo '<div class="alert-box error">' . validation_errors('<p><span>error: </span>', '</p>') . '</div>';}?>
<div class="stepNavigation clearfix">
            <ul>
              <li class="complete active"> <a href="#"><em></em> <span class="stepText">Campaign Details</span></a> </li>
              <li class="active"> <a href="#"><em></em> <span class="stepText">Analyze & Compare</span></a> </li>
              <li> <a href="#"><em></em> <span class="stepText">Launch Campaign</span></a> </li>
            </ul>
          </div>
          <section class="campaingDeatials">
            <section class="campaingDeatialsQs clearfix">
              <div class="campaingDeatialsQsLt">
                <h4 class="campaingTitle">Campaing Details</h4>
                <form name="frmAddCampaign" id="frmAddCampaign" action="" method="post">
                    <input type="hidden" name="action" value="Process">
                    <input type="hidden" name="skip" id="skip" value="No">
                <div class="campDtlsDiv">
                  <div class="inputPara inputParaEx">
                    <label>Campaing Title</label>
                    <select name="c_id" id="c_id" style="width: 200px;">
                        <option value="">Select a campaign</option>
                        <?php
                        if(is_array($campaign_listing) && count($campaign_listing) > 0){
                            for($i=0; $i<count($campaign_listing); $i++){
                        ?>
                        <option value="<?php echo $campaign_listing[$i]['campaign_id'];?>"><?php echo stripslashes($campaign_listing[$i]['campaign_title']);?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>                    
                  </div>
                  <div class="inputPara">
                    <label>Type of site</label>
                    <span class="checkbox">
                    <input type="radio" name="campaign_site_type" id="campaign_site_type1" value="1" <?php if(set_value('campaign_site_type') == '1'){echo 'CHECKED';}?> />
                    <label>Money / Client Website</label>
                    <em>I own or my client owns the site</em> </span> </div>
                  <div class="inputPara"> <span class="checkbox">
                    <input type="radio" name="campaign_site_type" id="campaign_site_type2" value="2" <?php if(set_value('campaign_site_type') == '2'){echo 'CHECKED';}?> />
                    <label>I own or my client owns the site</label>
                    <em>I have a page(s) on a authority site I don't own. <br>
                    (IE: Youtube, Amazon, PRweb, Linkedin, etc)</em> </span> </div>
                </div>
              </div>
              <div class="campaingDeatialsQsRt">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th align="left" valign="top" scope="col">Campaing</th>
                    <th align="left" valign="top" scope="col">Keywords</th>
                    <th align="left" valign="top" scope="col">Main Keyword</th>
                  </tr>
                  <?php                  
                  if(is_array($campaign_record) && count($campaign_record) > 0) {
                    for($i=0;$i<count($campaign_record);$i++) { 
                   ?>
                   <tr>
                    <td align="left" valign="top"><span class="icon1"><a href="javascript:void(0);"><?php echo stripslashes($campaign_record[$i]['campaign_title']);?>(<?php echo $campaign_record[$i]['total_campaign'];?>)</a></span></td>
                    <td align="center" valign="top"><?php echo stripslashes($campaign_record[$i]['total_kw']);?></td>
                    <td align="left" valign="top">&nbsp;</td>
                   </tr>
                   <?php
                        if(is_array($campaign_record[$i]['campaigns']) && count($campaign_record[$i]['campaigns']) > 0){
                            $campaignlist   = $campaign_record[$i]['campaigns'];
                            for($j=0; $j<count($campaignlist); $j++){
                                $parse_url  = parse_url($campaignlist[$j]['campaign_main_page_url']);
                    ?>
                                <tr>
                                    <td align="left" valign="top"><span <?php if($campaignlist[$j]['campaign_site_type'] == 1){?>class="icon2"<?php }elseif($campaignlist[$j]['campaign_site_type'] == 2){?>class="icon3"<?php } ?>><a href="#"><?php echo $parse_url['host'];?></a></span></td>
                                    <td align="center" valign="top"><?php echo stripslashes($campaignlist[$j]['total_kw']);?></td>
                                    <td align="left" valign="top"><?php echo stripslashes($campaignlist[$j]['campaign_main_keyword']);?></td>
                                </tr>
                    <?php
                            }
                        }
                    }
                  }
                  ?>                  
                </table>
              </div>
              <section class="btmFormSec">
                <div class="searchEngine clearfix">
                  <div class="inputPara clearfix">
                    <label>Wahat Search Engine Would You Like to Focus On?</label>
                    <div class="boxOne">
                      <input type="checkbox" name="isCrawlByGoogle" id="isCrawlByGoogle" value="Yes" <?php if(isset($_POST['isCrawlByGoogle']) && $_POST['isCrawlByGoogle']== 'Yes'){echo 'CHECKED';}?> />
                      <span class="iconGplus"></span>
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
                    </div>
                    <div class="boxTwo">
                      <input type="checkbox"  name="isCrawlByBing" id="isCrawlByBing" value="Yes" <?php if(isset($_POST['isCrawlByBing']) && $_POST['isCrawlByBing']== 'Yes'){echo 'CHECKED';}?> />
                      <span class="iconBlog"></span>
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
                    </div>
                    <div class="boxOne">
                      <input type="checkbox"  name="isCrawlByYahoo" id="isCrawlByYahoo" value="Yes" <?php if(isset($_POST['isCrawlByYahoo']) && $_POST['isCrawlByYahoo']== 'Yes'){echo 'CHECKED';}?>/>
                      <span class="iconYahoo"></span>
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
                    </div>
                  </div>
                </div>
                <div class="urlRanks">
                  <div class="inputPara clearfix">
                    <div class="urlRanksLt">
                      <label>URL of Main Page You Want to Rank:</label>
                      <input type="text" name="campaign_main_page_url" id="campaign_main_page_url" value="<?php echo set_value('campaign_main_page_url');?>" placeholder="Enter a name for this campaing" />
                    </div>
                    <div class="urlRanksRt">
                      <label>Track Exact URL Only?</label>
                      <span class="trackSpan">
                      <input type="radio" name="campaign_exact_url_track" id="campaign_exact_url_track1" value="Yes" />
                      <label>Yes, Please!</label>
                      <span class="noteText">
                        <input type="radio" name="campaign_exact_url_track" id="campaign_exact_url_track2" value="No">
                        No, Please look for any og my pages ranking <br>
                      (Don't use this option for parasite pages!)</span> </span> </div>
                  </div>
                </div>
                <div class="inputPara clearfix">
                	<label>Main Target Keyword:</label>
                    <input type="text" name="campaign_main_keyword" id="campaign_main_keyword" value="<?php echo set_value('campaign_main_keyword');?>" placeholder="Enter a name for this campaing" />
                </div>
                <div class="inputPara clearfix">
                	<label>Secondary Keyword:</label>
                    <input type="text" name="campaign_secondary_keyword" id="campaign_secondary_keyword" value="<?php echo set_value('campaign_secondary_keyword');?>" placeholder="If Applicatable; Enter Next Most Important KW" />
                    <span class="addiNote">Note: you can add additional keywords later.</span>
                </div>
              </section>
              <section class="pageDescription">
                <p><label>Page Size:</label> 40.3KB</p>
                <p><label>Load Time:</label> 4.1 Seconds</p>
                <p><label>Word Count:</label> 450</p>
                <p><label>Keyword %:</label> 2.5%</p>
              </section>
              <section class="pageDescription pageDescriptionRight">
              	<p><input value="Next" name="subLogin" id="subLogin" type="submit" class="yellowBtn" /></p>
              	<p class="skipText"><a href="javascript:skipStep();" >Please Skip Analyze & Compare Step</a></p>
                <p><label>Page Size:</label> 40.3KB</p>
                <p><label>Load Time:</label> 4.1 Seconds</p>
                <p><label>Word Count:</label> 450</p>
                <p><label>Keyword %:</label> 2.5%</p>
              </section>               
            </section>            
          </section>
             </form>
        </section>
<script type="text/javascript">
    function skipStep(){
        
        document.getElementById("skip").value = 'Yes';
        document.forms['frmAddCampaign'].submit();
    }
</script>