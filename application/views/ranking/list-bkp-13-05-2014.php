<!--<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>-->
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>Chart.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>jquery.sparkline.js"></script>
<?php require (SERVER_ABSOLUTE_PATH . 'front-app/libraries/gChart.php');;?>
<!--<section class="mainContainerSec">-->
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
					if(is_array($campaign_list[$i]['campaign']) && count($campaign_list[$i]['campaign']) > 0){
						for($j=0; $j<count($campaign_list[$i]['campaign']); $j++){
			    ?>
							<option value="<?php echo $campaign_list[$i]['campaign'][$j]['keyword_id'] . '-' . $campaign_list[$i]['campaign'][$j]['campaign_id'];?>"><?php echo '----' . stripslashes($campaign_list[$i]['campaign'][$j]['keyword']);?></option>
			    <?php
						}
					}
				}
			    }
			    ?>			    
                        </select>
                    </div>
                    <div class="google">
                    <span> <img src="<?php echo FRONT_IMAGE_PATH;?>icon-gplus.jpg"  alt=""/></span>
                    <div class="drop1 google">                    
                        <select name="search_engine_list" id="search_engine_list">
                          <option value="google" <?php if($sid == 'google'){echo 'selected';}?>>Google</option>
                          <option value="yahoo" <?php if($sid == 'yahoo'){echo 'selected';}?>>Yahoo</option>
			  <option value="bing" <?php if($sid == 'bing'){echo 'selected';}?>>Bing</option>
                        </select>
                  </div>
                  </div>
                    <div class="clear"></div>
                </div>
                <div class="sub_midpanel clear">
			<div class="rankings_part1">
				<h3 class="rankings_part">SERP Meter <?php echo $serp_meter_stat?>%</h3>
				<!--<img src="<?php echo FRONT_IMAGE_PATH;?>img28.jpg"  alt=""/>-->
				<div id="meter-completion">
				</div>
			</div>
			<div class="rankings_part2">
				<div class="r_mid2">
					<h3 class="rankings_part">SERP Rankings</h3>
					<!--<div id="semicirclecontainer1" style="min-width: 170px; height: 170px; max-width: 170px; margin: 0 auto"></div>
					<div id="semicirclecontainer2" style="min-width: 120px; height: 120px; max-width: 120px; margin: 0 auto"></div>-->
					<div class="canvasPan">
						<div class="canvasOne">
						<canvas id="canvas" height="135" width="135"></canvas>
						</div>
						<div class="canvasTwo">
						<canvas id="canvas2" height="103" width="103"></canvas>
						</div>
					</div>
					<!--<img src="<?php //echo FRONT_IMAGE_PATH;?>img29.jpg"  alt=""/>-->
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
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img1.jpg"  alt="carve-img"/><?php echo $moneysite_count_top3;?></span><span class="mapcaveSpan rightIn"><?php if($moneysite_count_top3_diff >= 0){echo '+' . $moneysite_count_top3_diff;}else{echo '-' . $moneysite_count_top3_diff;}?><?php if($moneysite_count_top3_diff >= 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>red-icon.jpg"  alt="carve-img"/><?php } ?></span></p>
                                <p><span id="top3_moneysite_trend" class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img1.jpg"  alt="carve-img"/></span></p>
                            </div>
                            <div class="mapcaveIn mapcaveInRight">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img2.jpg"  alt="carve-img"/><?php echo $parasite_count_top3?></span><span class="mapcaveSpan rightIn"><?php if($parasite_count_top3_diff >= 0){echo '+' . $parasite_count_top3_diff;}else{echo '-' . $parasite_count_top3_diff;}?><?php if($parasite_count_top3_diff >= 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>red-icon.jpg"  alt="carve-img"/><?php } ?></span></p>
                                <p><span id="top3_parasite_trend" class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img2.jpg"  alt="carve-img"/></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="mapTopDiv">
                    	<span class="topNo">Top10</span>
                        <div class="mapcave">
                        	<div class="mapcaveIn">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img3.jpg"  alt="carve-img"/><?php echo $moneysite_count_top10;?></span><span class="mapcaveSpan rightIn redcolor"><?php if($moneysite_count_top10_diff >= 0){echo '+' . $moneysite_count_top10_diff;}else{echo '-' . $moneysite_count_top10_diff;}?><?php if($moneysite_count_top10_diff >= 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>red-icon.jpg"  alt="carve-img"/><?php } ?></span></p>
                                <p><span id="top10_moneysite_trend" class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img2.jpg"  alt="carve-img"/></span></p>
                            </div>
                            <div class="mapcaveIn mapcaveInRight">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img4.jpg"  alt="carve-img"/><?php echo $parasite_count_top10;?></span><span class="mapcaveSpan rightIn"><?php if($parasite_count_top10_diff >= 0){echo '+' . $parasite_count_top10_diff;}else{echo '-' . $parasite_count_top10_diff;}?><?php if($parasite_count_top10_diff >= 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>red-icon.jpg"  alt="carve-img"/><?php } ?></span></p>
                                <p><span id="top10_parasite_trend" class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img1.jpg"  alt="carve-img"/></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="mapTopDiv">
                    	<span class="topNo">Top20</span>
                        <div class="mapcave">
                        	<div class="mapcaveIn">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img5.jpg"  alt="carve-img"/><?php echo $moneysite_count_top20;?></span><span class="mapcaveSpan rightIn"><?php if($moneysite_count_top20_diff >= 0){echo '+' . $moneysite_count_top20_diff;}else{echo '-' . $moneysite_count_top20_diff;}?><?php if($moneysite_count_top20_diff >= 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>red-icon.jpg"  alt="carve-img"/><?php } ?></span></p>
                                <p><span id="top20_moneysite_trend" class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img1.jpg"  alt="carve-img"/></span></p>
                            </div>
                            <div class="mapcaveIn mapcaveInRight">
                            	<p><span class="mapcaveSpan"><img src="<?php echo FRONT_IMAGE_PATH;?>small-img6.jpg"  alt="carve-img"/><?php echo $parasite_count_top20;?></span><span class="mapcaveSpan rightIn redcolor"><?php if($parasite_count_top20_diff >= 0){echo '+' . $parasite_count_top20_diff;}else{echo '-' . $parasite_count_top20_diff;}?><?php if($parasite_count_top20_diff >= 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>green-icon.jpg"  alt="carve-img"/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>red-icon.jpg"  alt="carve-img"/><?php } ?></span></p>
                                <p><span id="top20_parasite_trend" class="carveImg"><img src="<?php echo FRONT_IMAGE_PATH;?>carve-img2.jpg"  alt="carve-img"/></span></p>
                            </div>
                        </div>
                    </div>
                </div>
				
			</div>
			<div class="rankings_part3">
				<h3 class="rankings_part">SERP Tracking & Analysis</h3>
                <div class="rankTrack">
                	<div class="rankTrackIn">
                    	<span class="rankTop">Top 10</span>
                        <div class="rankTrackRight">
                        	<h5>New VS Dropped Sites</h5>
                        	<div id="tracking1" class="rankTrackInLt"><img src="<?php echo FRONT_IMAGE_PATH;?>trak-bar.jpg"  alt="trak-img"/></div>
                            <div class="rankTrackInRt">
                            	<p><span><img src="<?php echo FRONT_IMAGE_PATH;?>small-img1.jpg"  alt="trak-img"/>New <em><?php echo $new_url_top10;?></em></span></p>
                                <p><span><img src="<?php echo FRONT_IMAGE_PATH;?>small-img7.jpg"  alt="trak-img"/>Drop <em class="redcolor"><?php echo $drop_url_top10;?></em></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="rankTrackIn">
                    	<span class="rankTop">Top 20</span>
                        <div class="rankTrackRight">
                        	<div id="tracking2" class="rankTrackInLt"><img src="<?php echo FRONT_IMAGE_PATH;?>trak-bar.jpg"  alt="trak-img"/></div>
                            <div class="rankTrackInRt">
                            	<p><span><img src="<?php echo FRONT_IMAGE_PATH;?>small-img1.jpg"  alt="trak-img"/>New <em><?php echo $new_url_top20;?></em></span></p>
                                <p><span><img src="<?php echo FRONT_IMAGE_PATH;?>small-img7.jpg"  alt="trak-img"/>Drop <em class="redcolor"><?php echo $drop_url_top20;?></em></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rightRankSec">
			<div id="analysisContainer" class="raoundImg"></div>
			<div class="ana-pie"><a href="javascript:swapAnalysisPie('10');" class="ana-top10 active">Top 10</a> <a href="javascript:swapAnalysisPie('20');" class="ana-top20">Top 20</a></div>
		</div>
			</div>
			<div class="clear"></div>
                </div>
                
                <?php //pr($campaign_detail, 0);?>
                <div class="active_com clear">
                	<div class="active_block1">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>pic5.png"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $campaign_detail['active_campaign'];?> Active Campaigns
                            <span class="sm_text"><a href="<?php echo FRONT_URL;?>campaign/">+ Add Campaign</a></span>
                        </div>
                    	
                  </div>
                  	<div class="active_block1">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>img34.jpg"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $campaign_detail['total_kw'];?> Keywords
                            <span class="sm_text"><a href="<?php echo FRONT_URL;?>campaign/">+ Add Campaign</a></span>
                        </div>
                    	
                  </div>
                  <div class="active_block1">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>table-icon2.jpg"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $campaign_detail['total_money_sites'];?> Money/Client Sites
                            <span class="sm_text"><a href="<?php echo FRONT_URL;?>campaign/">+ Add More</a></span>
                        </div>
                    	
                  </div>
                  <div class="active_block1">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>table-icon3.jpg"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $campaign_detail['total_para_sites'];?> Parasite Pages
                            <span class="sm_text"><a href="<?php echo FRONT_URL;?>campaign/">+ Add More</a></span>
                        </div>
                    	
                  </div>
                  <div class="active_block1 active_block1_last">
                    	<span><img src="<?php echo FRONT_IMAGE_PATH;?>img35.jpg"  alt=""/></span>
                        <div class="right_text">
                        	<?php echo $count_seo_ranking_test;?> SEO / Ranking Tests
                            <span class="sm_text"><a href="<?php echo FRONT_URL;?>seoranking/">+ Add More</a></span>
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
                        <div class="carveMapSec">
				<!--<img src="<?php echo FRONT_URL;?>graphs/<?php //echo $graph;?>">-->
				<?php					
					//echo $this->gcharts->LineChart('Stocks')->outputInto('time_div');
					//echo $this->gcharts->div(800, 500);
					//   
					//if($this->gcharts->hasErrors())
					//{
					//    echo $this->gcharts->getErrors();
					//}
				?>
				<?php
				    $lineChart = new gLineChart(700,300);
				    $lineChart->addDataSet(array(112,315,66,40));
				    $lineChart->addDataSet(array(212,115,366,140));
				    $lineChart->addDataSet(array(112,95,116,140));
				    $lineChart->setLegend(array("first", "second", "third","fourth"));
				    $lineChart->setColors(array("ff3344", "11ff11", "22aacc", "3333aa"));
				    $lineChart->setVisibleAxes(array('x'));
				    $lineChart->setDataRange(30,400);
				    $lineChart->addAxisRange('jan', 'feb', 'mar', 'apr');
				    $lineChart->addAxisRange(1, 30, 400);
				    $lineChart->addBackgroundFill('bg', 'ffffff');
				    $lineChart->addBackgroundFill('c', 'ffffff');
				    ?>
				    <img src="<?php print $lineChart->getUrl();  ?>" />
			</div></div>
                    <div class=" rating_right">			
                        <div class="google">
                        <span> <img alt="" src="<?php echo FRONT_IMAGE_PATH;?>icon-gplus.jpg"></span>
                        <div class="drop1 google">
                        
                        <select name="search_engine_list2" id="search_engine_list2">
                          <option value="google" <?php if($rcsid == 'google'){echo 'selected';}?>>Google</option>
                          <option value="yahoo" <?php if($rcsid == 'yahoo'){echo 'selected';}?>>Yahoo</option>
			  <option value="bing" <?php if($rcsid == 'bing'){echo 'selected';}?>>Bing</option>
                        </select>
                        </div>
                        </div>
                        <?php			
			if(is_array($campaign_keyword_list) && count($campaign_keyword_list) > 0){
				for($i=0; $i<count($campaign_keyword_list); $i++){
					if($i%2 == 0){
						$img = FRONT_IMAGE_PATH . 'img37.jpg';
					}else{
						$img = FRONT_IMAGE_PATH . 'img38.jpg';
					}
					
					if($rcsid == 'google'){
						$currRank	= $campaign_keyword_list[$i]['google_rank'];
						$startRank	= $campaign_keyword_list[$i]['google_start_rank'];
						$bestRank	= $campaign_keyword_list[$i]['google_best_rank'];
						$statRank	= $campaign_keyword_list[$i]['google_rank_stat'];
					}elseif($rcsid == 'yahoo'){
						$currRank	= $campaign_keyword_list[$i]['yahoo_rank'];
						$startRank	= $campaign_keyword_list[$i]['yahoo_start_rank'];
						$bestRank	= $campaign_keyword_list[$i]['yahoo_best_rank'];
						$statRank	= $campaign_keyword_list[$i]['yahoo_rank_stat'];
					}elseif($rcsid == 'bing'){
						$currRank	= $campaign_keyword_list[$i]['bing_rank'];
						$startRank	= $campaign_keyword_list[$i]['bing_start_rank'];
						$bestRank	= $campaign_keyword_list[$i]['bing_best_rank'];
						$statRank	= $campaign_keyword_list[$i]['bing_rank_stat'];
					}
			?>
				<div class="rating_block01">
					<h4 class="rating_blockhe"> <img src="<?php echo $img;?>"  alt=""/><?php echo stripslashes($campaign_keyword_list[$i]['keyword']);?></h4>
					<ul class="block_r">
					    <li>
						    <strong>Ranking:</strong><span><?php echo $currRank;?>  <a class="<?php if($statRank >= 0){echo 'green';}else{echo 'red';}?>" href="#"><?php if($statRank >= 0){echo '+' . $statRank;}else{echo $statRank;}?></a></span><span class="r_arrow"><img src="<?php echo FRONT_IMAGE_PATH;?>img40.jpg"  alt=""/></span>
					    </li>
					    <li>
						    <strong class="gray_te">Best to-date:</strong><span><?php echo $bestRank;?></span>
					    </li>
					    <li>
						    <strong class="gray_te">Starting Rank :</strong><span><?php echo $startRank;?></span>
					    </li>
					</ul>
	    
				</div>
			<?php
				}
			}
			?>
                    </div>
                    
                    
                    </div>
                <br class="clear"/>
              </div>
                
                <div class="sub_buttom rankings_keyword">
                	<div class="content_titel clearfix"><h2>Rankings by Keyword</h2>
                    <div class="side_pl"> 
                    <a href="<?php echo FRONT_URL;?>campaign/" class="campaign_btm">+ Add Campaign</a> 
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
						if(is_array($campaignlist[$j]['seo_ranking'])){
							    $seoCount = count($campaignlist[$j]['seo_ranking']);
							}else{
							    $seoCount = 0;
							}
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
						<td id="trend_google_<?php echo $j;?>"></td>
						<td><?php echo $percent_google_rank;?>% <?php if($percent_google_rank > 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>red_ar.png"  alt=""/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>green_ar.png"  alt=""/><?php } ?></td>
						<td><?php echo stripslashes($campaignlist[$j]['start_google_rank']);?>(<?php echo stripslashes($campaignlist[$j]['google_rank']);?>)</td>
						<td><?php echo stripslashes($campaignlist[$j]['best_google_rank']);?>(<?php echo stripslashes($campaignlist[$j]['google_rank']);?>)</td>
						<td><?php echo stripslashes($campaignlist[$j]['bing_rank']);?>  <a href="#" class="<?php if($bing_diff_rank >= 0){echo 'green';}else{echo 'red';}?>"><?php echo ($bing_diff_rank);?></a></td>
						<td id="trend_yahoo_<?php echo $j;?>"></td>
						<td><?php echo $percent_bing_rank;?>% <?php if($percent_bing_rank > 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>red_ar.png"  alt=""/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>green_ar.png"  alt=""/><?php } ?></td>
						<td><?php echo stripslashes($campaignlist[$j]['yahoo_rank']);?> <a href="#" class="<?php if($yahoo_diff_rank >= 0){echo 'green';}else{echo 'red';}?>"><?php echo ($yahoo_diff_rank);?></a></td>
						<td id="trend_bing_<?php echo $j;?>"></td>
						<td><?php echo $percent_yahoo_rank;?>% <?php if($percent_yahoo_rank > 0){?><img src="<?php echo FRONT_IMAGE_PATH;?>red_ar.png"  alt=""/><?php }else{?><img src="<?php echo FRONT_IMAGE_PATH;?>green_ar.png"  alt=""/><?php } ?></td>
						<td> <?php echo $seoCount;?> <a href="<?php echo FRONT_URL;?>seoranking/">+new</a></td>
					</tr>
					<script>
						$("#trend_google_<?php echo $j;?>").sparkline([<?php echo implode(",", $campaignlist[$j]['google_trend']);?>], {
						type: 'line',
						width: '60',
						height: '11',
						lineColor: '#6f98ae'});
						
						$("#trend_yahoo_<?php echo $j;?>").sparkline([<?php echo implode(",", $campaignlist[$j]['yahoo_trend']);?>], {
						type: 'line',
						width: '60',
						height: '11',
						lineColor: '#6f98ae'});
						
						$("#trend_bing_<?php echo $j;?>").sparkline([<?php echo implode(",", $campaignlist[$j]['bing_trend']);?>], {
						type: 'line',
						width: '60',
						height: '11',
						lineColor: '#6f98ae'});
					</script>
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
				<li><a href="<?php echo FRONT_URL;?>analysis/">+ Ranking Analysis</a></li>
				<li><a href="<?php echo FRONT_URL;?>seoranking/">+ Start SEO Test</a></li>
				<li><a href="<?php echo FRONT_URL;?>campaign/">+ Add Campaign</a></li>
			    </ul>
			</div>
            </div>
<!--</section>-->

<script type="text/javascript">
	$(document).ready(function(){
		$('#campaign_list').change(function(){
			var campaignValue	= $(this).val();
			var searchEngine 	= $('#search_engine_list').val();
			if(campaignValue == ''){
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?sid=' + searchEngine;
			}else{
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?cid=' + campaignValue + '&sid=' + searchEngine;
			}
		});
		$('#search_engine_list').change(function(){
			var searchEngine = $(this).val();
			var campaignValue = $('#campaign_list').val();
			if(campaignValue == ''){
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?sid=' + searchEngine;
			}else{
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?cid=' + campaignValue + '&sid=' + searchEngine;
			}
		});
		$('#search_engine_list2').change(function(){
			var searchEngine2 = $(this).val();
			var searchEngine 	= $('#search_engine_list').val();
			var campaignValue = $('#campaign_list').val();
			if(campaignValue == ''){				
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?sid=' + searchEngine + '&rcsid=' + searchEngine2;
			}else{
				window.location.href	= '<?php echo FRONT_URL;?>ranking/?cid=' + campaignValue + '&sid=' + searchEngine + '&rcsid=' + searchEngine2;
			}
		});
	});
</script>
<script type="text/javascript">
    function swapAnalysisPie(num){
	var base_url_suffix	= 'serp-new/';
	var base_url 		= location.protocol + '//' + location.host + '/' + base_url_suffix;	
	var campaignValue 	= $('#campaign_list').val();
	var searchEngine 	= $('#search_engine_list').val();
	var dataString 		= 'num=' + encodeURIComponent(num) + '&campaignValue=' + encodeURIComponent(campaignValue) + '&searchEngine=' + encodeURIComponent(searchEngine);
	
	$.ajax({
		type: 'post',
		url: base_url + 'ajax/rankingpieswap',
		data: dataString,
		beforeSend: function(){
			$('.ana-top10').removeClass('active');
			$('.ana-top20').removeClass('active');
		},
		success: function(data){
			if (parseInt(num) == 10) {
				    $('.ana-top10').addClass('active');
			}else if (parseInt(num) == 20) {
				    $('.ana-top20').addClass('active');
			}
			var dataArr = data.split('|');
			var newrec = dataArr[0];
			var oldrec = dataArr[1];
			$("#analysisContainer").sparkline([newrec, oldrec], {
			type: 'pie',
			width: '100',
			height: '100',
			sliceColors: ['#feb52b', '#6f98ae']});
		}
	});
    }
    $('#meter-completion').meter({
		meter: "<?php echo FRONT_IMAGE_PATH;?>meter-bg.png",
		glass: null,
		width: 148,
		height: 148,
		maxAngle: 135,
		minAngle: -135,
		needlePosition: [79,79],
		needleScale: 0.5,
		maxLevel: 100,
		needleColour: "<?php echo FRONT_IMAGE_PATH;?>meter-arrow.jpg",
		needleHighlightColour: '#fff',
		needleShadowColour: '#fff',
		shadowColour: '#fff'
		
    });
    $('#meter-completion').meter('setLevel', '<?php echo $serp_meter_stat?>' );
    //$('#meter-caption').circleType();
    $("#analysisContainer").sparkline([<?php echo $new_url_top10;?>, <?php echo $drop_url_top10;?>], {
    type: 'pie',
    width: '100',
    height: '100',
    sliceColors: ['#feb52b', '#6f98ae']});
    
    $("#top3_moneysite_trend").sparkline([<?php echo implode(',', $top3_range_money_site);?>], {
    type: 'line',
    width: '60',
    height: '11',
    lineColor: '#6f98ae'});
    $("#top3_parasite_trend").sparkline([<?php echo implode(',', $top3_range_para_site);?>], {
    type: 'line',
    width: '60',
    height: '11',
    lineColor: '#6f98ae'});
    $("#top10_moneysite_trend").sparkline([<?php echo implode(',', $top10_range_money_site);?>], {
    type: 'line',
    width: '60',
    height: '11',
    lineColor: '#6f98ae'});
    $("#top10_parasite_trend").sparkline([<?php echo implode(',', $top10_range_para_site);?>], {
    type: 'line',
    width: '60',
    height: '11',
    lineColor: '#6f98ae'});
    $("#top20_moneysite_trend").sparkline([<?php echo implode(',', $top20_range_money_site);?>], {
    type: 'line',
    width: '60',
    height: '11',
    lineColor: '#6f98ae'});
    $("#top20_parasite_trend").sparkline([<?php echo implode(',', $top20_range_para_site);?>], {
    type: 'line',
    width: '60',
    height: '11',
    lineColor: '#6f98ae'});
    $('#tracking1').sparkline([ <?php foreach($top10_new_drop_range as $k=>$v){echo '[' . $v['drop']. ',' . $v['new'] .']';}?> ], { type: 'bar' });
    $('#tracking2').sparkline([ <?php foreach($top20_new_drop_range as $k=>$v){echo '[' . $v['drop']. ',' . $v['new'] .']';}?> ], { type: 'bar' });
</script>
<?php
$moneysite_count_top3_do = ($moneysite_count_top3/180)*100;
$moneysite_count_top10_do = ($moneysite_count_top10/180)*100;
$moneysite_count_top20_do = ($moneysite_count_top20/180)*100;

$parasite_count_top3_do = ($parasite_count_top3/180)*100;
$parasite_count_top10_do = ($parasite_count_top10/180)*100;
$parasite_count_top20_do = ($parasite_count_top20/180)*100;
?>
<script>

		var doughnutData = [
				{
					value : <?php echo $moneysite_count_top3;?>,
					color : "#264061"
				},
				{
					value : <?php echo $moneysite_count_top10;?>,
					color : "#366092"
				},
				{
					value : <?php echo $moneysite_count_top20;?>,
					color : "#95b3d7"
				}
			
			];

	var myDoughnut = new Chart(document.getElementById("canvas").getContext("2d")).Doughnut(doughnutData);
	
	var doughnutData2 = [
				{
					value : <?php echo $parasite_count_top3;?>,
					color : "#fadaa1"
				},
				{
					value : <?php echo $parasite_count_top10;?>,
					color : "#fabf1b"
				},
				{
					value : <?php echo $parasite_count_top20;?>,
					color : "#d69b27"
				}
			
			];

	var myDoughnut2 = new Chart(document.getElementById("canvas2").getContext("2d")).Doughnut(doughnutData2);
	
	</script>