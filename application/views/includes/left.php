<div class="row pdglr">
            <div class="col-md-3 left-col">

            <div class="sidebar-container">
            	<!-- SERP Avenger Package start -->
            	<div class="sidebar-box-header">
                    <h2>SERP Avenger Package (3)</h2>
                </div>
                <!-- sidebar-box-content -->
                <div class="sidebar-box-content">
                	<!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Gold Avenger (2)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <a href="<?php echo base_url();?>analyzecompare/" class="linktext">+ Add More or upgrade</a>
                    </ul><!-- section end -->
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Platinum Avenger (1)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <a href="" class="linktext">+ Add More or upgrade</a>
                    </ul><!-- section end -->
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Silver Avenger (0) </span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <a href="" class="linktext">+ Add More or upgrade</a>
                    </ul><!-- section end -->
                    
                 </div><!-- sidebar-box-content -->
            	<!-- Active Campaigns start -->
            	<div class="sidebar-box-header">
                 <h2>Active Campaigns (<?php echo count($active_campaignList);?>)</h2>
                 <?php  if(isset($active_campaignList) && count($active_campaignList)>0){
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
                   
                    
                </div>
                <!-- sidebar-box-content -->
                <div class="sidebar-box-content">
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                 
                        <li><a href="javascript:;"><span><?php echo $key;?>(<?php echo $total_money_para_site;?>)</span></a>
                        <ul class="acc-menu">
                       
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site(<?php echo $moneySite;?>)</a>
                                <ul class="acc-menu">
                                 <?php
                        if(isset($cList['moneysite']) && count($cList['moneysite'])>0){
                            foreach($cList['moneysite'] as $msite)
                            {
                        ?>      
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> <?php echo $msite; echo "<br>"; ?></a></li>
                                   
                                    <?php
                            }
                        }   
                        ?>
                                </ul>
                            
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages (<?php echo $parasite;?>)</a>
                                <ul class="acc-menu">
                                <?php
                        if(isset($cList['parasite']) && count($cList['parasite'])>0){
                            foreach($cList['parasite'] as $psite)
                            {
                        ?>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i><?php echo $psite; echo "<br>"; ?></a></li>
                                      <?php
                            }
                        }   
                        ?>
                                   
                                </ul>
                              
                            </li>
                             <?php }}?>
                        </ul>
                    </li>
                    <a href="" class="linktext">+ Add More</a>
                    </ul><!-- section end -->
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Weight Loss Book (3)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    </ul><!-- section end -->
                    <!-- section start -->
                    <ul class="acc-menu" id="sidebar">
                        <li><a href="javascript:;"><span>Hair Loss Client(3)</span></a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Money/ Client Site  1</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:;"><i class="clrlightblue fa fa-square"></i>Parasite Pages 2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantverification.com</a></li>
                                    <li><a href="javascript:;"><i class="clrlightgrey fa fa-square"></i> www.tenantbackgroundsearch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    </ul><!-- section end -->
                    
                 </div><!-- sidebar-box-content -->
                <!-- Active Networks start -->
                <div class="sidebar-box-header">
                    <h2>Active Networks (5)</h2>
                </div>
                <!-- sidebar-box-content -->
                <div class="sidebar-box-content">
                	<!-- section start -->
                    <ul class="acc-menu single-level" id="sidebar">
                    	<li><a href="javascript:;">SERP Avenger  PR-Gold</a></li>
                        <li><a href="javascript:;">GoDaddy PR Network</a></li>
                        <li><a href="javascript:;">Aged Network</a></li>
                        <li><a href="javascript:;">Indexing Network</a> <span><a href="" class="linktext">+ Add More</a></span></li>
                    </ul>
                </div>
                
                <!-- Other Categories As Needed start -->
                <div class="sidebar-box-header">
                    <h2>Other Categories As Needed</h2>
                </div>
                <!-- sidebar-box-content -->
                <div class="sidebar-box-content">
                	<!-- section start -->
                    <ul class="acc-menu single-level" id="sidebar">
                    	<li><a href="javascript:;">Car Rental</a></li>
                        <li><a href="javascript:;">Leasing</a></li>
                        <li><a href="javascript:;">Car Sales</a></li>
                        <li><a href="javascript:;">Autoshops/Garages</a></li>
                        <li><a href="javascript:;">GPS Rental</a>
                    </ul>
                </div>
                 
                </div>