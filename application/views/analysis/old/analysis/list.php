<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>Chart.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>jquery.sparkline.js"></script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH;?>analysis.js"></script>
<!--<section class="mainContainerSec">-->
     <div class="submitter">
            	<div class="sub_top rankings_dashboard">
                    <div class="drop1">
                        <select name="campaign_list" id="campaign_list">
                            <option>Show All Combined</option>
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
			<select name="campaign_server_engine" id="campaign_server_engine">	    
			<option value="google">Google</option>
			<option value="yahoo">Yahoo</option>
			<option value="bing">Bing</option>
			</select>
                    </div>
                  </div>
                    <div class="clear"></div>
                </div>
                <div class="analysis_toppanel clear">
                	<div class="leftbox">
                    	<div class="content_heading clearfix">
                        <h2>SERP Meter60%</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>setup2.png" alt=""></div>
                        </div>
                        
                        <div class="metter"><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img1.jpg" alt=""></div>
                        <div class="textArea">
                        <h3><span>Today:  60%</span>Yesterday:40%</h3>
                        <h3>Week:  40%Month:50%</h3>
                        </div>
                    </div>
                    
                    <div class="middlebox">
                    	<div class="content_heading clearfix">
                        <h2>SERP Rotation by Position</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>setup2.png" alt=""></div>
                        </div>
                        <?php
			if(is_array($campaign_list) && count($campaign_list) > 0){
			   if(is_array($campaign_list[0]['campaign']) && count($campaign_list[0]['campaign']) > 0){
			     $single_campaign = $campaign_list[0]['campaign'][0];	
			   }
			}
			//pr($campaign_crawl_detail, 0);
			//pr($single_campaign);
			?>
                        <!--<div class="rotation"><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img2.jpg" alt=""></div>-->
			<div class="comparisonSec">
                   <div class="comparisonSecTop clearfix">
                     <div class="compLt"><img src="<?php echo FRONT_SITE_THUMB_URL . $single_campaign['campaign_murl_thumb'];?>" alt=""/></div>
                        <div class="compRt">
                         <p><label>Keyword:</label><span><?php echo stripslashes($single_campaign['keyword']);?></span></p>
                            <p><label>Ranking:</label>7 +1Starting: 23</p>
                            <p><label>Age:</label> 1 Month 16 Days</p>
                            <p><label>Size:</label>236 Pages +23 Mo.</p>
                        </div>
                    </div>
                    <div class="comparisonSecBottm clearfix">
                     <div class="compBtmLt">
                         <div class="comparisonSecBottmIn">
                         <p><label>Page Content:</label>328 </p>
                            <p><label>Homepage:</label>No</p>
                            <p><label>HP?s in Top 10:</label>30%</p>
                            <p><label>HP?s in Top 20:</label>60%</p>
                            </div>
                        </div>
                        <div class="compBtmRt">
                         <div class="comparisonSecBottmIn">
                         <p><label>Keyword Ratio:</label> 2.8%</p>
                            <p><label>Keyword in Title:</label> Yes</p>
                            <p><label>Keyword in Desc:</label>Yes</p>
                            <p><label>Keyword in H1:</label>Yes </p>
                            </div>
                        </div>
                    </div>
                  </div>
                        
                    </div>
                    
                    <div class="rightbox">
                    	<div class="content_heading clearfix">
                        <h2>Anchor Profile of Top10</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>setup2.png" alt=""></div>
                        </div>
                        <div class="match matchExtra">
               	  <div class="matchProgress">
                    	<div class="matchProgressdiv clearfix">
                        	<div class="matchProgressLt">
                            	<span class="textMatch">Exact Match %</span>
                                <p><img src="<?php echo FRONT_IMAGE_PATH;?>match-bar1.jpg" alt="match-bar"/></p>
                            </div>
                            <div class="matchProgressRt">
                            	<div class="colorDiv">
                            		<span class="colorSpanOne"><em style="width:95%"><strong>95%</strong></em></span>
                                </div>
                                <div class="colorDiv">
                            		<span class="colorSpanTwo"><em style="width:47%"><strong>47%</strong></em></span>
                                </div>
                                <div class="colorDiv">
                            		<span class="colorSpanThree"><em style="width:100%"><strong>100%</strong></em></span>
                                </div>
                            </div>
                        </div>
                        <div class="matchProgressdiv clearfix">
                        	<div class="matchProgressLt">
                            	<span class="textMatch">Blended %</span>
                                <p><img src="<?php echo FRONT_IMAGE_PATH;?>match-bar3.jpg" alt="match-bar"/></p>
                            </div>
                            <div class="matchProgressRt">
                            	<div class="colorDiv">
                            		<span class="colorSpanOne"><em style="width:22%"><strong>22%</strong></em></span>
                                </div>
                                <div class="colorDiv">
                            		<span class="colorSpanTwo"><em style="width:58%"><strong>58%</strong></em></span>
                                </div>
                                <div class="colorDiv">
                            		<span class="colorSpanThree"><em style="width:0%"><strong>0%</strong></em></span>
                                </div>
                            </div>
                        </div>
                        <div class="matchProgressdiv clearfix">
                        	<div class="matchProgressLt">
                            	<span class="textMatch">Brand %</span>
                                <p><img src="<?php echo FRONT_IMAGE_PATH;?>match-bar3.jpg" alt="match-bar"/></p>
                            </div>
                            <div class="matchProgressRt">
                            	<div class="colorDiv">
                            		<span class="colorSpanOne"><em style="width:31%"><strong>31%</strong></em></span>
                                </div>
                                <div class="colorDiv">
                            		<span class="colorSpanTwo"><em style="width:40%"><strong>40%</strong></em></span>
                                </div>
                                <div class="colorDiv">
                            		<span class="colorSpanThree"><em style="width:96%"><strong>96%</strong></em></span>
                                </div>
                            </div>
                        </div>
                        <div class="matchProgressdiv clearfix">
                        	<div class="matchProgressLt">
                            	<span class="textMatch">Raw URL %</span>
                                <p><img src="<?php echo FRONT_IMAGE_PATH;?>match-bar4.jpg" alt="match-bar"/></p>
                            </div>
                            <div class="matchProgressRt">
                            	<div class="colorDiv">
                            		<span class="colorSpanOne"><em style="width:50%"><strong>50%</strong></em></span>
                                </div>
                                <div class="colorDiv">
                            		<span class="colorSpanTwo"><em style="width:38%"><strong>38%</strong></em></span>
                                </div>
                                <div class="colorDiv">
                            		<span class="colorSpanThree"><em style="width:8%"><strong>8%</strong></em></span>
                                </div>
                            </div>
                        </div>
                        <div class="matchOption clearfix">
                        	<ul>
                                <li><em><img src="<?php echo FRONT_IMAGE_PATH;?>match-view1.jpg" alt="match-view"/></em>Top 10</li>
                                <li><em><img src="<?php echo FRONT_IMAGE_PATH;?>match-view2.jpg" alt="match-view"/></em>Top 3</li>
                                <li><em><img src="<?php echo FRONT_IMAGE_PATH;?>match-view3.jpg" alt="match-view"/></em>Parasire/ Authority</li>
                            </ul>
                      </div>
                  </div>
                </div>
                    </div>
                     
                     <div class="clear"></div>
                </div>
                
                
              <div class="clear"></div>
                
                <div class="sub_buttom">
                	<div class="content_titel clearfix"><h2>SEO Snapshot (Top 10)</h2><span class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>img2.png" /></span></div>
                    <div class="rating_inner">
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>Site Age</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
                        <div id="contain-site-age">
						<h3 id="site-age-heading">4 Months</h3>						
						<div class="mapArea">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">
						<tr>
						  <td>New: </td>
						  <td> 30%</td>
						  <td>&nbsp;</td>
						  <td id="grpNewSiteAge">
						      <!-- <img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt="">-->
						  </td>
						</tr>
						<tr>
						  <td>Young: </td>
						  <td>50%</td>
						  <td>&nbsp;</td>
						  <td id="grpYoungSiteAge">
						       <!--<img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt="">-->
						  </td>
						</tr>
						<tr>
						  <td>Old:  </td>
						  <td>20%</td>
						  <td>&nbsp;</td>
						  <td id="grpOldSiteAge">
						       <!--<img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt="">-->
						  </td>
						</tr>
						</table>
						<div class="wave"><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img5.jpg" alt=""></div>
						</div>
			</div>
                        <div id="loader-site-age" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader.gif" alt="Loading"></div>
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>Site Size</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
			 <div id="contain-site-page-count"></div>
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>Page Content</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
			 <div id="contain-site-word-count"></div>                        
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>Keyword Ratio</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
                        <div id="contain-site-kw-ratio"></div>
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>KW Optimization</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
                        <div id="contain-site-kw-optimization"></div>
                        
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>Exact KW Anchors</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
			  
                       <div id="contain-site-exact-kw-anchor"></div>
		       <div id="loader-site-exact-kw-anchor" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader.gif" alt="Loading"></div>
                        
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>Hiding Links (301s)</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
                        <div id="contain-site-hiding-links"></div>
			<div id="loader-site-hiding-links" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader.gif" alt="Loading"></div>
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>Social Signals</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
                        <h3>4 Months</h3>
                        
                        <div class="mapArea">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">
  <tr>
    <td>New: </td>
    <td> 30%</td>
    <td>&nbsp;</td>
    <td><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt=""></td>
  </tr>
  <tr>
    <td>Young: </td>
    <td>50%</td>
    <td>&nbsp;</td>
    <td><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt=""></td>
  </tr>
  <tr>
    <td>Old:  </td>
    <td>20%</td>
    <td>&nbsp;</td>
    <td><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt=""></td>
  </tr>
</table>
					<div class="wave"><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img5.jpg" alt=""></div>

                        </div>
                        
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>External Links</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
                        <div id="contain-site-external-links"></div>
			<div id="loader-site-external-links" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader.gif" alt="Loading"></div>
                        
                    </div>
                    
                    <div class="snapShotbox">
                    	<div class="content_heading clearfix">
                        <h2>Freshness Score</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>help_icon.png" alt=""></div>
                        </div>
                        <h3>4 Months</h3>
                        
                        <div class="mapArea">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">
  <tr>
    <td>New: </td>
    <td> 30%</td>
    <td>&nbsp;</td>
    <td><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt=""></td>
  </tr>
  <tr>
    <td>Young: </td>
    <td>50%</td>
    <td>&nbsp;</td>
    <td><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt=""></td>
  </tr>
  <tr>
    <td>Old:  </td>
    <td>20%</td>
    <td>&nbsp;</td>
    <td><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img4.jpg" alt=""></td>
  </tr>
</table>
					<div class="wave"><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img5.jpg" alt=""></div>

                        </div>
                        
                    </div>
                    
                    </div>
                <br class="clear"/>
              </div>
                
                
                <div class="serp">
                <div class="heading">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p><span>Show Data For:&nbsp;&nbsp;Top 10</span></p></td>
    <td><p>Top 3</p></td>
    <td><p>News Sites</p></td>
    <td><p>Authority/Parasites</p></td>
    <td><p>Aged(1+Yr.)</p></td>
    <td><p>Long Term</p></td>
    <td width="20%">&nbsp;</td>
  </tr>
</table>

                </div>
                <div class="serpProfile">
                    	<div class="content_heading clearfix">
                        <h2>SERP Profile</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>setup2.png" alt=""></div>
                        </div>
                        
                        <div class="leftPanel">
                        <!--<h2>New/ Recovered Sites</h2>-->
			<h2>New</h2>
                        	<!--<div class="mainImage">
				   <img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img6.jpg" alt="">
				</div>-->
				<div id="content-new-site"></div>
				<div id="loader-new-site" align="center" style="display: none;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader.gif" alt="Loading"></div>
                        </div>
                
                        <div class="middlePanel">
                        <h2>Authority/ Parasite </h2>
                        	<div class="mainImage"><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img7.jpg" alt=""></div>
                        </div>
                
                        <div class="rightPanel">
                        <h2>Aged Sites (1 Year +)</h2>
                        	<!--<div class="mainImage"><img src="<?php echo FRONT_IMAGE_PATH;?>analysis_img8.jpg" alt=""></div>-->
				<div id="content-old-site"></div>
				<div id="loader-old-site" align="center" style="display: none;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader.gif" alt="Loading"></div>
                        </div>
                
                </div>
                
                <div class="serpProfile_right">
                    	<div class="content_heading clearfix">
                        <h2>Long-Term Page One Rankings</h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>setup2.png" alt=""></div>
                        </div>
			<div id="content-long-term-site"></div>
			<div id="loader-long-term-site" align="center" style="display: block;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader.gif" alt="Loading"></div>
                        
			
                </div>
                
               </div> 
                
                
                <div class="onpage">
                    	<div class="content_heading clearfix">
                        <h2>Onpage Elements <span>(Exact Keyword Optimized)</span></h2>
                        <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>setup2.png" alt=""></div>
                        </div>
                        
			<div class='onpage-element-box' id="new-site-onpage-content"></div>
			<div class='onpage-element-box' id='long-tarm-onpage-content'></div>
			<div class='onpage-element-box' id='old-site-onpage-content'></div>
                        
                     
                        
                </div>
                
                <div class="element">
                <div class="heading">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--<td><p><span>Show Data For:&nbsp;&nbsp;Top 10</span></p></td>
    <td><p>Top 3</p></td>-->
    <td><p><span>Show Data For:&nbsp;&nbsp;</span><label id='new-site-link' class='sub-link-lable'>News Sites</label></p></td>
    <!--<td><p>Authority/Parasites</p></td>-->
    <td><p><label id='aged-link' class='sub-link-lable'>Aged(1+Yr.)</label></p></td>
    <td><p><label id='long-tarm-link' class='sub-link-lable'>Long Term</label></p></td>
    <td width="20%">&nbsp;</td>
  </tr>
</table>
                </div>
                
                <div class="elementProfile">
                <div class="content_heading clearfix">
                <h2>Link Elements</h2>
                <div class="help"><img src="<?php echo FRONT_IMAGE_PATH;?>setup2.png" alt=""></div>
                </div>
                <div id="contain-link-element" class="element">
                  <!--<img src="<?php echo FRONT_IMAGE_PATH;?>link_element.jpg" alt="">-->
		  <canvas id="canvas301Redirect" height="135" width="135"></canvas>
		  <canvas id="canvasFollow" height="135" width="135"></canvas>
		  <canvas id="canvasSiteWide" height="135" width="135"></canvas>
		  <canvas id="canvasTextImage" height="135" width="135"></canvas>
                </div>
		<div id="loader-link-element" align="center" style="display: none; min-height: 50px; margin-top:10px;"><img src="<?php echo FRONT_IMAGE_PATH;?>loader.gif" alt="Loading"></div>
                
                <div class="showData">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p><span>Show Data For:&nbsp;&nbsp;Top 10</span></p></td>
    <td><p><a id="linkelement_top3" href="javascript:void(0);">Top 3</a></p></td>
    <td><p><a id="linkelement_newsite" href="javascript:void(0);">News Sites</a></p></td>
    <td><p><a id="linkelement_parasite" href="javascript:void(0);">Authority/Parasites</a></p></td>
    <td><p><a id="linkelement_aged1yr" href="javascript:void(0);">Aged(1+Yr.)</a></p></td>
    <td><p><a id="linkelement_longterm" href="javascript:void(0);">Long Term</a></p></td>
    <td width="20%">&nbsp;</td>
  </tr>
</table>
                </div>
                </div>
                
                </div>
                
            </div>
<!--        </section>-->
<script type="text/javascript">
	/*$(document).ready(function(){
		$('#campaign_list').change(function(){
			var campaignValue	= $(this).val();
			if(campaignValue == ''){
				window.location.href	= '<?php echo FRONT_URL;?>analysis/';
			}else{
				window.location.href	= '<?php echo FRONT_URL;?>analysis/?cid=' + campaignValue;
			}
		});
	});*/
</script>
