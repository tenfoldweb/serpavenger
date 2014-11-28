<!--<aside class="mainLeft">
        <div class="sideMenuTitle">My Panel</div>
        <div class="sideMenuList">
          <ul>
            <li><span class="listTitle">SERP Avenger Package (3)<em></em></span>
            	<ul></ul>
            </li>
            <li><span class="listTitle">Active Campaigns (3)<em></em></span></li>
            <li><span class="listTitle">Active Networks (5)<em></em></span></li>
            <li><span class="listTitle">Other Categories As Needed<em></em></span></li>
          </ul>
        </div>
      </aside>-->
      <aside class="mainLeft">
        <div class="sideMenuTitle">My Panel</div>
        <div class="sideMenuList">
          <div class="st-accordion" id="st-accordion">
                    <ul>
                        <li>
                            <a class="heading" href="#">SERP Avenger Package (3)<span class="st-arrow">Open or Close</span></a>
                            <div class="st-content">
                            	<ul>
                                	
                                    <li>
                                    	<div class="list-topics1">
                                        	<div class="image-panel">
                                            	<img src="../images/icon-th.png" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Gold Avenger (2)</h1>
                                                <a href="#">+ Add More or upgrade</a>
                                                <span class="arr"></span>
                                            </div>
                                            <div class="clear"></div>
                                        </div> 
                                    </li>
                                    <li>
                                    	<div class="list-topics1">
                                        	<div class="image-panel">
                                            	<img src="../images/icon-th.png" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Gold Avenger (2)</h1>
                                                <a href="#">+ Add More or upgrade</a>
                                                <span class="arr toggle_button1"></span>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="toggle_box2">
                                        	<div class="list-topics3">
                                            	<div class="image-panel">
                                            	<img src="../images/table-icon2.jpg" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Money/ Client Site1</h1>
                                                <span class="arr"></span>
                                            </div>
                                            <div class="clear"></div>
                                            </div>
                                            <div class="list-topics3">
                                            	<div class="image-panel">
                                            	<img src="../images/table-icon3.jpg" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Parasite Pages2</h1>
                                                <span class="arr"></span>
                                            </div>
                                            <div class="clear"></div>
                                            </div>
                                            <a href="#">+ Add More</a>
                                        </div>
                                    </li>
                                    <li>
                                    	<div class="list-topics1">
                                        	<div class="image-panel">
                                            	<img src="../images/icon-th.png" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Gold Avenger (2)</h1>
                                                <a href="#">+ Add More or upgrade</a>
                                                <span class="arr"></span>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
			
			
                        <li>
                            <a href="#"  class="heading">Active Campaigns (<?php echo count($active_campaignList);?>)<span class="st-arrow">Open or Close</span></a>
                            <div class="st-content">
                                <ul class="small1">
				<?php if(isset($active_campaignList) && count($active_campaignList)>0){
					$ccount = 0;
					foreach($active_campaignList as $key=>$cList)
					{
						$moneySite = 0;
						$parasite = 0;
						$total_money_para_site = 0;
						if(isset( $cList['moneysite']) &&  count($cList['moneysite']))
						{
							$moneySite = count($cList['moneysite']);
						}						
						if(isset( $cList['parasite']) &&  count($cList['parasite']))
						{
							$parasite = count($cList['parasite']);
						}
						
						$total_money_para_site =  $moneySite + $parasite;
						//echo $cmp_name = urldecode($key);
						$ccount++;
				?>	
                                  <li>
                                    	<div class="list-topics2">
                                        	<div class="image-panel">
                                            	<img src="../images/small-icon1.png" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1><?php echo $key;?> <em>(<?php echo $total_money_para_site;?>)</em> </h1>
                                                <span class="arr toggle_button" onclick="openCampaign('<?php echo $ccount;?>');" ></span>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="toggle_box1 campaign_<?php echo $ccount;?>">
                                        	<div class="list-topics3">
                                            	<div class="image-panel">
                                            	<img src="../images/table-icon2.jpg" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Money/ Client Site (<?php echo $moneySite;?>)</h1>
                                                <span class="arr" onclick="openMoneysite('<?php echo $ccount;?>');"></span>
						<div class="moneysite_<?php echo $ccount;?>">
						<?php
						if(isset($cList['moneysite']) && count($cList['moneysite'])>0){
							foreach($cList['moneysite'] as $msite)
							{
						?>		
							
								<?php echo $msite; echo "<br>"; ?>
								
						<?php
							}
						}	
						?>
						</div>
						
						
                                            </div>
                                            <div class="clear"></div>
                                            </div>
                                            <div class="list-topics3">
                                            	<div class="image-panel">
                                            	<img src="../images/table-icon3.jpg" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Parasite Pages (<?php echo $parasite;?>)</h1>
                                                <span class="arr" onclick="openParasite('<?php echo $ccount;?>');"></span>
						<div class="parasite_<?php echo $ccount;?>">
						<?php
						if(isset($cList['parasite']) && count($cList['parasite'])>0){
							foreach($cList['parasite'] as $psite)
							{
						?>
							
								<?php echo $psite; echo "<br>"; ?>
							
						<?php
							}
						}	
						?>
						</div>
                                            </div>
                                            <div class="clear"></div>
                                            </div>
                                            <a href="<?php echo base_url()."campaign/"?>">+ Add More</a>
                                        </div>
                                    </li>
				  
				  <?php }}?>
                                </ul>
                                
                            </div>
                        </li>
			
			
                        <li>
                            <a class="heading" href="#">Active Networks (5)<span class="st-arrow">Open or Close</span></a>
                            <div class="st-content">
                               <ul class="small1">
                               		 <li>
                                    	<div class="list-topics2">
                                        	<div class="image-panel">
                                            	<img src="../images/setup1.png" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>SERP Avenger  PR-Gold</h1>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                     <li>
                                    	<div class="list-topics2">
                                        	<div class="image-panel">
                                            	<img src="../images/img11.png" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>GoDaddy PR Network</h1>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                     <li>
                                    	<div class="list-topics2">
                                        	<div class="image-panel">
                                            	<img src="../images/img11.png" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Aged PR Network</h1>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                    <li>
                                    	<div class="list-topics2">
                                        	<div class="image-panel">
                                            	<img src="../images/img11.png" alt="" />
                                            </div>
                                            <div class="right-panel">
                                            	<h1>Indexing Network</h1>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                 </ul>
                            </div>
                        </li>
						 <li>
                            <a class="heading" href="#">Other Categories As Needed<span class="st-arrow">Open or Close</span></a>
                            <div class="st-content">
                                 <ul>
                                    <li><a href="#">Car Rental</a></li>
                                    <li><a href="#">Leasing </a></li>
                                    <li><a href="#">Car Sales</a></li>
                                    <li><a href="#">Autoshops/Garages</a></li>
                                    <li><a href="#">GPS Rental</a></li>
                                </ul>
                            </div>
                        </li>
					 </ul>
                </div>
        </div>
      </aside>
