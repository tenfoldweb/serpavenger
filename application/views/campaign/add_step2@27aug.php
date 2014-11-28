<!--<section class="mainContainerSec">-->
  <div class="stepNavigation clearfix">
    <ul>
      <li class="complete active"> <a href="#"><em></em> <span class="stepText">Campaign Details</span></a> </li>
      <li class="active"> <a href="#"><em></em> <span class="stepText">Analyze & Compare</span></a> </li>
      <li> <a href="#"><em></em> <span class="stepText">Launch Campaign</span></a> </li>
    </ul>
  </div>
  <section class="campaingDeatials">
    <section class="campaingDeatialsQs clearfix">    
            <div class="setup">
            <h4><span class="img_left"></span><span><?php echo stripslashes($campaign_title);?></span><span class="img_right"></span></h4>
                <div class="setup_inner clearfix">
                <div class="setup_inner_left">
                    <div class="align_left"><img src="<?php echo FRONT_SITE_THUMB_URL . $campaign_detail[0]['campaign_murl_thumb'];?>" alt="<?php echo stripslashes($campaign_title);?>" width="156" height="105"/></div>
                    <div class="align_left content_left">
                        <p><?php echo stripslashes($campaign_detail[0]['campaign_murl_domain']);?></p>
                        <p>Server IP: <span><?php echo stripslashes($campaign_detail[0]['campaign_murl_ip']);?></span></p>
                        <p>Location: <span class="flag"><img src="<?php echo FRONT_IMAGE_PATH."flag_16/".strtolower($campaign_detail[0]['campaign_murl_country_code'])."_16.png";?>" alt="flag" /> <?php echo $campaign_detail[0]['campaign_murl_country_code'];?></span></p>
                        <p>Age: <span><?php echo timeDifference(date("Y-m-d", $campaign_detail[0]['campaign_murl_creation_date']));?></span></p>
                    </div>
                </div>
                <div class="setup_inner_right">
                    <!--<ul class="resolve">
                        <li>www Resolve</li>
                        <li>Yes Index</li>
                        <li>XML Sitemap <a href="#">www.ytproz.com/sitemap.xml</a></li>
                        <li>Robots TXT File <a href="#">www.ytproz.com/robots.txt</a></li>
                    </ul>-->
                    <p>Main Keyword: <?php echo stripslashes($campaign_detail[0]['campaign_main_keyword']);?> <br> Estimated Search Volume: <?php echo stripslashes($campaign_cpc_main_kw_detail[0]['keyword_est_traffic']);?> <br> Paid Cost Per Click: <?php echo '$' . stripslashes($campaign_cpc_main_kw_detail[0]['keyword_cpc']);?></p>
                </div>
            </div>
                <div class="setup_inner clearfix">
                <div class="setup_inner_left">
                        <table class="table1 howval_cont" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <th>Similar Keyword</th>
                              <th>Est Traffic</th>
                              <th>cpc</th>
                            </tr>
                            <?php
                            if(is_array($campaign_cpc_detail) && count($campaign_cpc_detail) > 0){
                                for($i=0; $i<count($campaign_cpc_detail); $i++){                                    
                            ?>
                            <tr>
                                <td><input type="checkbox" name="chk" class="chk" data-val="<?php echo $campaign_cpc_detail[$i]['keyword_est_traffic']*$campaign_cpc_detail[$i]['keyword_cpc'];?>"> <?php echo stripslashes($campaign_cpc_detail[$i]['keyword']);?></td>
                                <td><?php echo stripslashes($campaign_cpc_detail[$i]['keyword_est_traffic']);?></td>
                                <td>$<?php echo stripslashes($campaign_cpc_detail[$i]['keyword_cpc']);?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                </div>
                <div class="setup_inner_right">
                        <p>How valuable is this keyword based on its ranking:</p>
                        <ul id="contain-ranking" class="ranking">
                            <?php
                            $valuation_percentage = rearrange_array($campaign_cpc_detail);
                            $counterx = 1;
                            $count_kw_valuation_percentage = count($kw_valuation_percentage);
                            $kvp = array_chunk($kw_valuation_percentage,($count_kw_valuation_percentage/2));    
                            foreach($kvp as $km=>$kam){
                                foreach($kam as $vo){
                            ?>
                            <li><?php echo $counterx;?> $<?php $valn =  ($vo/100) * $campaign_cpc_main_kw_detail[0]['keyword_est_traffic'] * $campaign_cpc_main_kw_detail[0]['keyword_cpc']; echo number_format($valn,2);?></li>
                            <?php
                                $counterx++;
                                }
                            }    
                            ?>                            
                        </ul>
                </div>
            </div>
            <h4>SERP Preview:</h4>
            <div class="views">
                <a href="<?php echo stripslashes($campaign_detail[0]['campaign_main_page_url']);?>" target="_blank"><?php echo stripslashes($campaign_detail[0]['page_title']);?></a>
                <a href="<?php echo stripslashes($campaign_detail[0]['campaign_main_page_url']);?>" target="_blank" class="link"><?php echo stripslashes($campaign_detail[0]['campaign_murl_domain']);?></a>
                <p><?php echo stripslashes($campaign_detail[0]['page_description']);?></p>
            </div>
            <h4>What would you prefer?</h4>
            <div class="button1 clearfix">
                <button class="align_left">Audit & Compare My Site </button>
                <button class="align_right">Skip Audit</button>
            </div>
            <span class="compare">Compare My Site VS Top 10 Now</span>
        </div>
      
    </section>
  </section>
<!--</section>-->

<script>
    $(document).ready(function(){
        $("input:checkbox[name=chk]").change(function() {
            var val = $(this).attr('data-val');
            if ($(this).is(':checked') == true){
                var ajaxURL = '<?php echo FRONT_URL;?>ajax/kw_cpc_valuation/<?php echo $campaign_id;?>/'+val;
            }else{
                var ajaxURL = '<?php echo FRONT_URL;?>ajax/kw_cpc_valuation/<?php echo $campaign_id;?>/0';
            }
            alert(ajaxURL);
            $.ajax({
                url:ajaxURL,
                context: document.body,
                success:function(text){
                    jQuery('#contain-ranking').html(text);
                }
            })        
        });
    
        
        $(".chk").click(function(){
            if ($(this).is(':checked') == true){
                $('.chk').prop('checked', false);
                $(this).prop('checked', true);
            }
        });
        
    })
</script>