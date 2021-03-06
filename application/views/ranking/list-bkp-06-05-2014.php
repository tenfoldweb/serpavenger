<section class="mainContainerSec">
	    <div class="submitter">
            	<div class="sub_top rankings_dashboard">
                    <div class="drop1">			
                        <select name="campaign_list" id="campaign_list">
                            <option value="">Show All Combined</option>
			    <?php
			    if(is_array($campaign_list) && count($campaign_list) > 0){
				for($i=0; $i<count($campaign_list); $i++){
			    ?>
				<option value="<?php echo stripslashes($campaign_list[$i]['campaign_id']);?>" <?php if($cid == $campaign_list[$i]['campaign_id']){echo 'selected';}?>><?php echo stripslashes($campaign_list[$i]['campaign_title']);?></option>
			    <?php
				}
			    }
			    ?>                            
                        </select>
                    </div>
                    <div class="google">
                    <span> <img src="<?php echo FRONT_IMAGE_PATH;?>icon-gplus.jpg"  alt=""/></span>
                    <div class="drop1 google">
                    
                        <select>
                          <option value="google">Google</option>
                          <option value="yahoo">Yahoo</option>
			  <option value="bing">Bing</option>
                      </select>
                  </div>
                  </div>
                    <div class="clear"></div>
                </div>
                <div class="sub_midpanel clear">
			<div class="rankings_part1">
				<h3 class="rankings_part">SERP Meter 60%</h3>
				<!--<img src="<?php echo FRONT_IMAGE_PATH;?>img28.jpg"  alt=""/>-->
				<div id="meter-completion">
				</div>
			</div>
			<div class="rankings_part2">
				<div class="r_mid2">
					<h3 class="rankings_part">SERP Rankings</h3>
					<img src="<?php echo FRONT_IMAGE_PATH;?>img29.jpg"  alt=""/>
					<ul>
						<li><strong><img src="<?php echo FRONT_IMAGE_PATH;?>img30.jpg"  alt=""/></strong> <span> Money/ Client</span></li>
						<li><strong><img src="<?php echo FRONT_IMAGE_PATH;?>img31.jpg"  alt=""/></strong> <span> Parasite</span></li>
					</ul>
				</div>
                <div class="mapTopNo">
                	<div class="mapTopDiv">
                    	<span class="topNo">Top3</span>
                        <div class="mapcave">
                        	<div class="mapcaveIn">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img1.jpg"  alt="carve-img"/>7</span><span class="mapcaveSpan rightIn"><img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/>+1</span></p>
                                <p><span class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img1.jpg"  alt="carve-img"/></span></p>
                            </div>
                            <div class="mapcaveIn mapcaveInRight">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img2.jpg"  alt="carve-img"/>28</span><span class="mapcaveSpan rightIn">+12<img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/></span></p>
                                <p><span class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img2.jpg"  alt="carve-img"/></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="mapTopDiv">
                    	<span class="topNo">Top10</span>
                        <div class="mapcave">
                        	<div class="mapcaveIn">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img3.jpg"  alt="carve-img"/>15</span><span class="mapcaveSpan rightIn redcolor">+6<img src="<?php echo FRONT_IMAGE_PATH;?>red-icon.jpg"  alt="carve-img"/</span></p>
                                <p><span class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img2.jpg"  alt="carve-img"/></span></p>
                            </div>
                            <div class="mapcaveIn mapcaveInRight">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img4.jpg"  alt="carve-img"/>34</span><span class="mapcaveSpan rightIn">+8<img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/</span></p>
                                <p><span class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img1.jpg"  alt="carve-img"/></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="mapTopDiv">
                    	<span class="topNo">Top20</span>
                        <div class="mapcave">
                        	<div class="mapcaveIn">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img5.jpg"  alt="carve-img"/>78</span><span class="mapcaveSpan rightIn">+6<img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/</span></p>
                                <p><span class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img1.jpg"  alt="carve-img"/></span></p>
                            </div>
                            <div class="mapcaveIn mapcaveInRight">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img6.jpg"  alt="carve-img"/>89</span><span class="mapcaveSpan rightIn redcolor">+7<img src="<?php echo FRONT_IMAGE_PATH;?>red-icon.jpg"  alt="carve-img"/</span></p>
                                <p><span class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img2.jpg"  alt="carve-img"/></span></p>
                            </div>
                        </div>
                    </div>
                </div>
				<!--<div>Top 3 <?php echo $monetsite_count_top3;?> <?php echo $parasite_count_top3;?></div>
				<br>
				<div>Top 10 <?php echo $monetsite_count_top10;?> <?php echo $parasite_count_top10;?></div>
				<br>
				<div>Top 20 <?php echo $monetsite_count_top20;?> <?php echo $parasite_count_top20;?></div>-->
			</div>
			<div class="rankings_part3">
				<h3 class="rankings_part">SERP Tracking & Analysis</h3>
                <div class="rankTrack">
                	<div class="rankTrackIn">
                    	<span class="rankTop">Top 10</span>
                        <div class="rankTrackRight">
                        	<h5>New VS Dropped Sites</h5>
                        	<div class="rankTrackInLt"><img src="<?php echo FRONT_IMAGE_PATH;?>trak-bar.jpg"  alt="trak-img"/></div>
                            <div class="rankTrackInRt">
                            	<p><span><img src="<?php echo FRONT_IMAGE_PATH;?>small-img1.jpg"  alt="trak-img"/>New <em>+5</em></span></p>
                                <p><span><img src="<?php echo FRONT_IMAGE_PATH;?>small-img7.jpg"  alt="trak-img"/>Drop <em class="redcolor">-2</em></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="rankTrackIn">
                    	<span class="rankTop">Top 10</span>
                        <div class="rankTrackRight">
                        	<div class="rankTrackInLt"><img src="<?php echo FRONT_IMAGE_PATH;?>trak-bar.jpg"  alt="trak-img"/></div>
                            <div class="rankTrackInRt">
                            	<p><span><img src="<?php echo FRONT_IMAGE_PATH;?>small-img1.jpg"  alt="trak-img"/>New <em>+5</em></span></p>
                                <p><span><img src="<?php echo FRONT_IMAGE_PATH;?>small-img7.jpg"  alt="trak-img"/>Drop <em class="redcolor">-2</em></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rightRankSec"><img src="<?php echo FRONT_IMAGE_PATH;?>top-ten-circel.jpg"  alt=""/></div>
			</div>
			<div class="clear"></div>
                </div>
                
                <?php //pr($campaign_detail, 0);?>
                <div class="active_com clear">
                	<div class="active_block1">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>pic5.png"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $campaign_detail['active_campaign'];?> Active Campaigns
                            <span class="sm_text">+ Add Campaign</span>
                        </div>
                    	
                  </div>
                  	<div class="active_block1">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>img34.jpg"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $campaign_detail['total_kw'];?> Keywords
                            <span class="sm_text">+ Add Campaign</span>
                        </div>
                    	
                  </div>
                  <div class="active_block1">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>table-icon2.jpg"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $campaign_detail['total_money_sites'];?> Money/Client Sites
                            <span class="sm_text">+ Add More</span>
                        </div>
                    	
                  </div>
                  <div class="active_block1">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>table-icon3.jpg"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $campaign_detail['total_para_sites'];?> Parasite Pages
                            <span class="sm_text">+ Add More</span>
                        </div>
                    	
                  </div>
                  <div class="active_block1 active_block1_last">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>img35.jpg"  alt=""/></span>
                        <div class="right_text">
                        	14 SEO / Ranking Tests
                            <span class="sm_text">+ Add More</span>
                        </div>
               	  <img src="<?php echo FRONT_IMAGE_PATH;?>img2.png"  alt=""/>
                   </div>
                
                <div class="clear"></div>
              </div>
                
                <div class="sub_buttom">
                	<div class="content_titel clearfix"><h2>Ranking Chart</h2><span class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>img2.png" /></span></div>
                    <div class="rating_inner clearfix">
                	<div class="rating_left rating_left_rank">
                    	<div class="rankChartView clearfix">
                        	<label>Show/Hide</label>
                            <ul>
                            	<li><a href="#"><em class="iconView"><img src="<?php echo FRONT_IMAGE_PATH;?>view-icon1.jpg" alt="view-icon" /></em>Algo update</a></li>
                                <li><a href="#"><em class="iconView"><img src="<?php echo FRONT_IMAGE_PATH;?>view-icon2.jpg" alt="view-icon" /></em>Offpage Test</a></li>
                                <li><a href="#"><em class="iconView"><img src="<?php echo FRONT_IMAGE_PATH;?>view-icon3.jpg" alt="view-icon" /></em>Reversed Offpage Test</a></li>
                                <li><a href="#"><em class="iconView"><img src="<?php echo FRONT_IMAGE_PATH;?>view-icon4.jpg" alt="view-icon" /></em>Onpage Test</a></li>
                                <li><a href="#"><em class="iconView"><img src="<?php echo FRONT_IMAGE_PATH;?>view-icon5.jpg" alt="view-icon" /></em>Reversed Onpage</a></li>
                            </ul>
                        </div>
                        <div class="carveMapSec"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-map.jpg"  alt=""/> </div></div>
                    <div class=" rating_right">
                        <div class="google">
                        <span> <img alt="" src="<?php echo FRONT_IMAGE_PATH;?>icon-gplus.jpg"></span>
                        <div class="drop1 google">
                        
                        <select>
                        <option>Google USA</option>
                        <option></option>
                        </select>
                        </div>
                        </div>
                        
                        <div class="rating_block01">
                        	<h4 class="rating_blockhe"> <img src="<?php echo FRONT_IMAGE_PATH;?>img37.jpg"  alt=""/>Colorado Locksmith</h4>
                            <ul class="block_r">
                            	<li>
                                	<strong>Ranking:</strong><span>7  <a class="green" href="#">+1</a></span><span class="r_arrow"><img src="<?php echo FRONT_IMAGE_PATH;?>img40.jpg"  alt=""/></span>
                                </li>
                                <li>
                                	<strong class="gray_te">Best to-date:</strong><span>7</span>
                                </li>
                                <li>
                                	<strong class="gray_te">Starting Rank :</strong><span>15</span>
                                </li>
                            </ul>

                        </div>
                        
                        <div class="rating_block01">
                        	<h4 class="rating_blockhe"> <img src="<?php echo FRONT_IMAGE_PATH;?>img38.jpg"  alt=""/>Denever Locksmith</h4>
                            <ul class="block_r">
                            	<li>
                                	<strong>Ranking:</strong><span>7  <a class="green" href="#">+1</a></span><span class="r_arrow"><img src="<?php echo FRONT_IMAGE_PATH;?>img40.jpg"  alt=""/></span>
                                </li>
                                <li>
                                	<strong class="gray_te">Best to-date:</strong><span></span>
                                </li>
                                <li>
                                	<strong class="gray_te">Starting Rank:</strong><span>15</span>
                                </li>
                            </ul>

                        </div>
                        
                        <div class="rating_block01">
                        	<h4 class="rating_blockhe"> <img src="<?php echo FRONT_IMAGE_PATH;?>img39.jpg"  alt=""/>Denever Locksmith</h4>
                            <ul class="block_r">
                            	<li>
                                	<strong>Ranking:</strong><span>7  <a class="green" href="#">+1</a></span><span class="r_arrow"><img src="<?php echo FRONT_IMAGE_PATH;?>img42.jpg"  alt=""/></span>
                                </li>
                                <li>
                                	<strong class="gray_te">Best to-date:</strong><span>7</span>
                                </li>
                                <li>
                                	<strong class="gray_te">Starting Rank:</strong><span>15</span>
                                </li>
                            </ul>

                        </div>
                    </div>
                    
                    
                    </div>
                <br class="clear"/>
              </div>
                
                <div class="sub_buttom rankings_keyword">
                	<div class="content_titel clearfix"><h2>Rankings by Keyword</h2>
                    <div class="side_pl"> 
                    <a href="#" class="campaign_btm">+ Add Campaign</a> 
                    <span class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>img2.png" /></span>
                    </div>
                    </div>
                    <div class="rating_inner">
                 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><strong>Campaign </strong></td>
					<td> <strong>Keywords </strong></td>
					<td><strong>Main Keyword </strong></td>
					<td> <img src="<?php echo FRONT_IMAGE_PATH;?>googlei.jpg"  alt=""/></td>
					<td><strong>Trend </strong></td>
					<td><strong>Meter </strong></td>
					<td><strong>Start </strong></td>
					<td><strong>Best </strong></td>
					<td> <img src="<?php echo FRONT_IMAGE_PATH;?>img43.jpg"  alt=""/></td>
					<td><strong>Trend </strong></td>
					<td><strong>Meter </strong></td>
					<td> <img src="<?php echo FRONT_IMAGE_PATH;?>img44.jpg"  alt=""/></td>
					<td><strong>Trend </strong></td>
					<td><strong>Meter </strong></td>
					<td><strong>Tests </strong></td>
				</tr>
				<?php
				//pr($campaign_record, 0);
				if(is_array($campaign_record) && count($campaign_record) > 0) {
				  for($i=0;$i<count($campaign_record);$i++) {
				?>
					<tr>
						<td> <img src="<?php echo FRONT_IMAGE_PATH;?>table-icon1.jpg"  alt=""/><?php echo stripslashes($campaign_record[$i]['campaign_title']);?>(<?php echo $campaign_record[$i]['total_campaign'];?>)</td>
						<td><?php echo stripslashes($campaign_record[$i]['total_kw']);?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<?php
					if(is_array($campaign_record[$i]['campaigns']) && count($campaign_record[$i]['campaigns']) > 0){
					    $campaignlist   = $campaign_record[$i]['campaigns'];
					    for($j=0; $j<count($campaignlist); $j++){
						$parse_url  = parse_url($campaignlist[$j]['campaign_main_page_url']);
						
						$curr_google_rank = $campaignlist[$j]['google_rank'];
						$prev_gogole_rank = $campaignlist[$j]['prev_google_rank'];
						$google_diff_rank = $curr_google_rank-$prev_gogole_rank;
						if($curr_google_rank > 0){
							$percent_google_rank = ($google_diff_rank/$curr_google_rank)*100;
						}else{
							$percent_google_rank = 0;
						}
						
						$curr_yahoo_rank = $campaignlist[$j]['yahoo_rank'];
						$prev_yahoo_rank = $campaignlist[$j]['prev_yahoo_rank'];
						$yahoo_diff_rank = $curr_yahoo_rank-$prev_yahoo_rank;
						if($curr_yahoo_rank > 0){
							$percent_yahoo_rank = ($yahoo_diff_rank/$curr_yahoo_rank)*100;
						}else{
							$percent_yahoo_rank = 0;
						}
						
						$curr_bing_rank = $campaignlist[$j]['bing_rank'];
						$prev_bing_rank = $campaignlist[$j]['prev_bing_rank'];
						$bing_diff_rank = $curr_bing_rank-$prev_bing_rank;
						if($curr_bing_rank > 0){
							$percent_bing_rank = ($bing_diff_rank/$curr_bing_rank)*100;
						}else{
							$percent_bing_rank = 0;
						}
					?>
					<tr>
						<td> <?php if($campaignlist[$j]['campaign_site_type'] == 1){?><img src="<?php echo FRONT_IMAGE_PATH;?>table-icon2.jpg"  alt=""/><?php }elseif($campaignlist[$j]['campaign_site_type'] == 2){?><img src="<?php echo FRONT_IMAGE_PATH;?>table-icon3.jpg"  alt=""/><?php } ?><?php echo $parse_url['host'];?></td>
						<td><?php echo stripslashes($campaignlist[$j]['total_kw']);?> <em>+new</em></td>
						<td><?php echo stripslashes($campaignlist[$j]['campaign_main_keyword']);?></td>
						<td><?php echo stripslashes($campaignlist[$j]['google_rank']);?>  <a href="#" class="<?php if($google_diff_rank >= 0){echo 'green';}else{echo 'red';}?>"><?php echo ($google_diff_rank);?></a></td>
						<td> <img src="<?php echo FRONT_IMAGE_PATH;?>img45.jpg"  alt=""/></td>
						<td><?php echo $percent_google_rank;?>% <?php if($percent_google_rank > 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>red_ar.png"  alt=""/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>green_ar.png"  alt=""/><?php } ?></td>
						<td><?php echo stripslashes($campaignlist[$j]['start_google_rank']);?>(<?php echo stripslashes($campaignlist[$j]['google_rank']);?>)</td>
						<td><?php echo stripslashes($campaignlist[$j]['best_google_rank']);?>(<?php echo stripslashes($campaignlist[$j]['google_rank']);?>)</td>
						<td><?php echo stripslashes($campaignlist[$j]['bing_rank']);?>  <a href="#" class="<?php if($bing_diff_rank >= 0){echo 'green';}else{echo 'red';}?>"><?php echo ($bing_diff_rank);?></a></td>
						<td><img src="<?php echo FRONT_IMAGE_PATH;?>img45.jpg"  alt=""/></td>
						<td><?php echo $percent_bing_rank;?>% <?php if($percent_bing_rank > 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>red_ar.png"  alt=""/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>green_ar.png"  alt=""/><?php } ?></td>
						<td><?php echo stripslashes($campaignlist[$j]['yahoo_rank']);?> <a href="#" class="<?php if($yahoo_diff_rank >= 0){echo 'green';}else{echo 'red';}?>"><?php echo ($yahoo_diff_rank);?></a></td>
						<td><img src="<?php echo FRONT_IMAGE_PATH;?>img45.jpg"  alt=""/></td>
						<td><?php echo $percent_yahoo_rank;?>% <?php if($percent_yahoo_rank > 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>red_ar.png"  alt=""/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>green_ar.png"  alt=""/><?php } ?></td>
						<td> 3 +new</td>
					</tr>
					<?php
							}
						    }
						}
					      }
					?>					
				</table>
                    </div>                    
                    </div>
                
			<div class=" footer_link">
				<ul>
				<li><a href="#">+ Ranking Analysis</a></li>
				<li><a href="#">+ Start SEO Test</a></li>
				<li><a href="#">+ Add Campaign</a></li>
			    </ul>
			</div>
            </div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$('#campaign_list').change(function(){
			var campaignValue	= $(this).val();
			if(campaignValue == ''){
				window.location.href	= '<?php echo FRONT_URL;?>ranking/';
			}else{
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?cid=' + campaignValue;
			}
		});
	});
</script>
<script type="text/javascript">
    $('#meter-completion').meter({
		meter: "<?php echo FRONT_IMAGE_PATH;?>meter-img.jpg",
		glass: null,
		width: 158,
		height: 89,
		maxAngle: 135.5,
		minAngle: -135.5,
		needlePosition: [79,79],
		needleScale: 0.5,
		maxLevel: 100,
		needleColour: "<?php echo FRONT_IMAGE_PATH;?>meter-arrow.jpg",
		needleHighlightColour: '#fff',
		needleShadowColour: '#fff',
		shadowColour: '#fff'
		
    });
    $('#meter-completion').meter('setLevel', '60' );
    //$('#meter-caption').circleType();
</script>