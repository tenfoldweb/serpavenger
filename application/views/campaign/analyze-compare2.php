
<div class="container">
<div class="row" id="header">
<div class="col-md-3 left-col">
<div id="logo"><a href="index.html"><img src="<?php echo base_url(); ?>images/logo.png" width="214" height="84" alt=""></a></div>
</div>

<div class="col-md-9 menusec right-col">
<?php $this->load->view('includes/header'); ?>

<nav class="mainmenu">
<ul id="menu">
    <li><a href="<?php echo base_url()?>mypannel">My Panel </a></li>
<li><a href="<?php echo base_url()?>campaign">My Campaigns 
<!-- <i class="fa fa-caret-down"></i> --></a>
        <!-- <ul>    
            <li><a href="#">item1</a></li>
            <li><a href="#">item2</a></li>
            <li><a href="#">item1</a></li>
            <li><a href="#">item2</a></li>
        </ul> -->
    </li>
  <li><a href="<?php echo base_url()?>ranking">Rankings</a></li>
  <li><a href="<?php echo base_url()?>analysis">Analysis</a></li>
  <li><a href="<?php echo base_url()?>networkmanager">Network Manager</a></li>
  <li><a href="<?php echo base_url()?>scrapper">Submitter</a></li>
  <li><a href="#">Reports</a></li>
  <li><a href="#">Video Tutorials</a></li>
</ul>       
</nav>
</div>
</div>




</div>
<div class="container">
<?php  $this->load->view('includes/left'); ?>
</div>
<div class="col-md-9 right-col">
<div class="row">
<!-- Progress-->
<div class="processmain-blk">
    <ol class="progtrckr" data-progtrckr-steps="3">
        <li class="progtrckr-done"><span class="firstp">Campaign Details</span></li>
        <li class="progtrckr-done"><span class="secondp">Analyze & Compare</span></li>
        <li class="progtrckr-todo"><span class="thirdp">Launch Campaign</span></li>                        </ol>
    <div class="clearfix"></div>
    
    <!-- compaigns-details-row -->
    <div class="compaigns-details-row">
        <div class="keyword-sec">
            <div class="thumb-keyword">
                <!--<img src="<?php echo base_url(); ?>images/RPA-keyword.gif" width="200" height="150" class="keyword-main-thumb" alt=""/>-->
              <?php
include("apifolder/GrabzItClient.class.php");

//print_R($userdetailcompare);
	
	$this->load->helper('common_helper');
	$is_thumb_exist =  check_thumb_image_exists($userdetailcompare->campaign_main_page_url);
	$grabzItHandlerUrl = "http://serpavenger.com/serp_avenger/handler.php";
		 
		$grabzIt = new GrabzItClient("YjMzMjFlZWY4Y2U4NDRhNWFmZWIxM2U5Nzc0YmNjNDQ=", "Zz8yPwUeP2o/Pz8/YD8/LCgoSCo/XC0/Pz8/Pw9sY2Q=");
	//process below code if thumbnail is not exist in db
	if($is_thumb_exist==''){
		
		$userdetailcompare->campaign_main_page_url;
		$grabzIt->SetImageOptions($userdetailcompare->campaign_main_page_url,null,null,null,200,150);
			   $id1 = $grabzIt->Save($grabzItHandlerUrl);
			   save_thumb_image_exists($id1,$userdetailcompare->campaign_main_page_url); 
			   $id1 = str_replace("YjMzMjFlZWY4Y2U4NDRhNWFmZWIxM2U5Nzc0YmNjNDQ=", "", $id1);
			   
	}
      // echo '<li><a href="http://'.$userdetailcompare->campaign_main_page_url.'" target="_blank" ><img src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$userdetailcompare->campaign_main_page_url.'.jpg" width="200" height="150" ></a><a href="http://'.$userdetailcompare->campaign_main_page_url.'" target="_blank" ><span>'.$userdetailcompare->campaign_main_page_url.'</span></a></li>';  
 if($id1!='')
{
  //sleep(2);
 echo '<img id="img1" src="http://serpavenger.com/serp_avenger/assets/images/waiting_thumbnail.jpg" width="200" height="150" >';
} else {
	$img_src = base_url()."images/screenshots/".str_replace("YjMzMjFlZWY4Y2U4NDRhNWFmZWIxM2U5Nzc0YmNjNDQ=", "", $is_thumb_exist).".jpg";
	echo '<img  src="'.$img_src.'" width="200"  height="150" />';
}
?>
                <span>
                    <?php
  echo '<a href="http://'.$userdetailcompare->campaign_main_page_url.'" target="_blank" >'.$userdetailcompare->campaign_main_page_url.'</a>';
   ?>
                </span>
            </div>
      </div>
      
      <div class="keyword-info2 pull-right">
            <div class="crawling-status">
                <!--<p>Serp Avenger Crawling Status: <img src="images/loading.GIF" width="128" height="16" alt=""/></p>-->
                <div class="cs-container">
                <table width="100%" border="0" cellspacing="10" cellpadding="10">
                  <tbody>

                    <tr>
                      <th width="43%"><img width="12" height="16" alt="" src="<?php echo base_url(); ?>images/pic7.png"> SERP Crawlers</th>
                      <td>
                      
                            <div class="pull-left loader-main-base">
                                 <div class="loader-cs loader-cs-serp purple" >
                                    <div class="progress-bar progress-serp"><div class="progress-stripes progress-stripes-serp" style="margin-left: -63.6px;">///////////////////////////</div><div class="percentage-cs percentage-cs-serp" ></div></div>
                                </div>
                                <div class="pull-left progress-res progress-serp-res">
                                    <div class="progress-serp-done imgdone " style="display:none;"><i class="fa fa-check"></i></div>
                                    <span class="purple">Loading</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                      <th><img width="12" height="16" alt="" src="<?php echo base_url(); ?>images/pic7.png"> Data Mining</th>
                      <td>
                        <div class="pull-left loader-main-base">
                                <div class="loader-cs purple" >
                                    <div class="progress-bar progress-mining"><div class="progress-stripes progress-stripes-mining" style="margin-left: -63.6px;">///////////////////////////</div><div class="percentage-cs percentage-cs-mining" >0%</div></div>
                                </div>
                                <div class="pull-left progress-res progress-mining-res">
                                    <div class="progress-mining-done imgdone" style="display:none;"><i class="fa fa-check"></i></div>
                                    <span class="purple">Loading</span>
                                </div>
                            </div>  
                      </td>
                    </tr>
                    <tr>
                      <th><img width="12" height="16" alt="" src="<?php echo base_url(); ?>images/pic7.png"> Backlink Scrapers <span class="bccount"><img width="26" height="23" alt="" src="<?php echo base_url(); ?>images/gry-arrow.gif"> <small>Backlink Count: 
<span id="backcnt"><?php echo number_format($backlinkcount); ?></span></small></span></th>
                      <td>
                        <div class="pull-left loader-main-base">
                                <div class="loader-cs purple" >
                                    <div class="progress-bar progress-backlink"><div class="progress-stripes progress-stripes-backlink" style="margin-left: -63.6px;">///////////////////////////</div><div class="percentage-cs percentage-cs-backlink" >0%</div></div>
                                </div>
                                <div class="pull-left progress-res progress-backlink-res">
                                    <div class="progress-backlink-done imgdone" style="display:none;"><i class="fa fa-check"></i></div>
                                    <span class="purple">Loading</span>
                                </div>
                            </div>
                      </td>
                    </tr>
                    <tr>
                      <th><img width="12" height="16" alt="" src="<?php echo base_url(); ?>images/pic7.png"> Avenger Analysis:</th>
                      <td>
                        <div class="pull-left loader-main-base">
                                <div class="loader-cs purple" >
                                    <div class="progress-bar progress-avenger"><div class="progress-stripes progress-stripes-avenger" style="margin-left: -63.6px;">///////////////////////////</div><div class="percentage-cs percentage-cs-avenger" >0%</div></div>
                                </div>
                                <div class="pull-left progress-res progress-avenger-res">
                                    <div class="progress-avenger-done imgdone" style="display:none;"><i class="fa fa-check"></i></div>
                                    <span class="purple">Loading</span>
                                </div>
                            </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                </div>

        </div>
      </div>
      
      <div class="clearfix"></div>
    </div>
    <!--Suggested Keywords-->
    <div class="howtolink-bld">
    	<h3>How would you like to build links? (Number of links is based on daily analysis of top 10)</h3>
        
        <div class="link-build-way">
        	<!--  Main row link build-->
            <div class="lb-main">
                <p class="lbhead"><input type="checkbox" id="chckbox" name="build_link" value="bot"  checked class="check"> <img src="<?php echo base_url(); ?>images/thander.png" width="9" height="13" alt=""/> Bot Suggested Link Profile <span>(Auto Pilot)</span></p>
                <div class="link-build-way-row" id="lbmain">
                	<span class="lbtitle">Keyword Anchor Percentages</span>
					<div class="pull-left slidermain">
                         <span class="title">Excat Match</span>
                              <div id="suggested-excat-min" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="suggested-excat-match" readonly id="suggested-excat-match">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Related KW</span>
                              <div id="suggested-related-kw" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="suggested-related-kw-val" readonly id="suggested-related-kw-val">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Blended KW</span>
                              <div id="suggested-blended-kw" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="suggested-blended-kw-val" readonly id="suggested-blended-kw-val">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Brand KW</span>
                              <div id="suggested-brand-kw" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="suggested-brand-kw-val" readonly id="suggested-brand-kw-val">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Raw URL</span>
                              <div id="suggested-raw-url" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="suggested-raw-url-val" readonly id="suggested-raw-url-val">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Generic</span>
                              <div id="suggested-generic" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="suggested-generic-val" readonly id="suggested-generic-val">
                     </div>		 
										
                    
                </div>
            </div>
            <div class="orsapgrey">
                <span>OR</span>
            </div>
            <!--  Main row link build-->
            <div class="lb-main">
                <p class="lbhead"><input type="checkbox" id="chckboxmanual" name="build_link" value="manually" class="check"> Manually Set Link Profile </span></p>
                <div class="link-build-way-row" id="lbmainmanual" >
                	<span class="lbtitle">Keyword Anchor Percentages</span>
					
					
					<div class="pull-left slidermain">
                         <span class="title">Excat Match</span>
                              <div id="manually-excat-min" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="manually-excat-match" readonly id="manually-excat-match">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Related KW</span>
                              <div id="manually-related-kw" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="manually-related-kw-val" readonly id="manually-related-kw-val">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Blended KW</span>
                              <div id="manually-blended-kw" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="manually-blended-kw-val" readonly id="manually-blended-kw-val">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Brand KW</span>
                              <div id="manually-brand-kw" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="manually-brand-kw-val" readonly id="manually-brand-kw-val">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Raw URL</span>
                              <div id="manually-raw-url" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="manually-raw-url-val" readonly id="manually-raw-url-val">
                     </div>
					 
					 <div class="pull-left slidermain">
                         <span class="title">Generic</span>
                              <div id="manually-generic" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
                              <input type="text" value="0" name="manually-generic-val" readonly id="manually-generic-val">
                     </div>	
					
					
					
					
					
					
					
					
                     
                </div>
            </div>
           <div class="orsapgrey">
                <span>OR</span>
            </div>
            <!--  Main row link build-->
            <div class="lb-main2">
                <p class="lbhead"><input type="checkbox" id="configureman" name="build_link" value="self" class="check">  Self Configure</span></p>
                <div class="link-build-way-row text-center" id="configure" style="margin-top:50px">
                	<button data-toggle="modal" data-target="#skiptop10a"  type="button" class="btn btn-blue-disable" >Configure</button>
                    
                    <!-- skip TOp 10 analysis popup-->
                    <div class="modal fade text-left" id="skiptop10a" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header popup-header">
                            <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Self Configured Linking Plan</h4>
                          </div>
                          <form name="config" id="self_configured" method="post" action="<?php echo base_url(); ?>analyzecompare2/formdata">
                          <div class="modal-body popupbody">
                            
                            <div class="sclphead">
                                <h2>Set-up your custom linking Plan below <span>Quantity of links is based on top 10 pattern analysis.</span></h2>
                                
                            </div>
                            <div class="sclpsec">
                                <div class="sclprow">
                                <p>
                                    <span class="number-count">1</span> Provide anchors, URL and how percentages below: <i class="">(drag slider to change percentage)</i>
                                </p>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                  <tbody id="ancurl-fields-exact">
                                    <tr>
                                      <th>Keyword Type</th>
                                      <th>Anchor <span>(Spintax Accepted)</span></th>
                                      <th>URL <span>(Spintax Accepted)</span></th>
                                      <th width="227">% of Total links</th>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="dropdown">
                                            <select name="selfconfigure1" class="dropdown-select">
                                                <option value="">Select One</option>  
												<option value="exact">Exact Match</option>  
												<option value="related">Related Keyword</option>  
												<option value="blended">Blended Keyword</option>  
												<option value="brand">Brand Keyword</option>  
												<option value="raw">Raw Url</option>  
												<option value="generic">Generic</option>  
                                            </select>
                                        </div>
                                      </td>
                                      <td><input type="text" name="exact_anchor1"></td>
                                      <td><input type="text" name=" exact_url1"></td>
                                      <td><div id="configure-slider1" class="customslier ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
										<input type="text" value="0" name="configure-slider1-val" readonly id="configure-slider1-val"></td>
                                    </tr>
									<tr>
                                      <td>
                                        <div class="dropdown">
                                            <select name="selfconfigure2" class="dropdown-select">
												<option value="">Select One</option>  
                                                <option value="exact">Exact Match</option>  
												<option value="related">Related Keyword</option>  
												<option value="blended">Blended Keyword</option>  
												<option value="brand">Brand Keyword</option>  
												<option value="raw">Raw Url</option>  
												<option value="generic">Generic</option>  
                                            </select>
                                        </div>
                                      </td>
                                      <td><input type="text" name="exact_anchor2"></td>
                                      <td><input type="text" name=" exact_url2"></td>
                                      <td><div id="configure-slider2" class="customslier ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
										<input type="text" value="0" name="configure-slider2-val" readonly id="configure-slider2-val"></td>
                                    </tr>
									
									<tr>
                                      <td>
                                        <div class="dropdown">
                                            <select name="selfconfigure3" class="dropdown-select">
												<option value="">Select One</option>  
                                                <option value="exact">Exact Match</option>  
												<option value="related">Related Keyword</option>  
												<option value="blended">Blended Keyword</option>  
												<option value="brand">Brand Keyword</option>  
												<option value="raw">Raw Url</option>  
												<option value="generic">Generic</option>  
                                            </select>
                                        </div>
                                      </td>
                                      <td><input type="text" name="exact_anchor3"></td>
                                      <td><input type="text" name=" exact_url3"></td>
                                      <td><div id="configure-slider3" class="customslier ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
										<input type="text" value="0" name="configure-slider3-val" readonly id="configure-slider3-val"></td>
                                    </tr>
									
									<tr>
                                      <td>
                                        <div class="dropdown">
                                            <select name="selfconfigure4" class="dropdown-select">
												<option value="">Select One</option>  
                                                <option value="exact">Exact Match</option>  
												<option value="related">Related Keyword</option>  
												<option value="blended">Blended Keyword</option>  
												<option value="brand">Brand Keyword</option>  
												<option value="raw">Raw Url</option>  
												<option value="generic">Generic</option>  
                                            </select>
                                        </div>
                                      </td>
                                      <td><input type="text" name="exact_anchor4"></td>
                                      <td><input type="text" name=" exact_url4"></td>
                                      <td><div id="configure-slider4" class="customslier ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
										<input type="text" value="0" name="configure-slider4-val" readonly id="configure-slider4-val"></td>
                                    </tr>
									
									<tr>
                                      <td>
                                        <div class="dropdown">
                                            <select name="selfconfigure5" class="dropdown-select">
												<option value="">Select One</option>  
                                                <option value="exact">Exact Match</option>  
												<option value="related">Related Keyword</option>  
												<option value="blended">Blended Keyword</option>  
												<option value="brand">Brand Keyword</option>  
												<option value="raw">Raw Url</option>  
												<option value="generic">Generic</option>  
                                            </select>
                                        </div>
                                      </td>
                                      <td><input type="text" name="exact_anchor5"></td>
                                      <td><input type="text" name=" exact_url5"></td>
                                      <td><!--<div class="slidermain">--><div id="configure-slider5" class="customslier ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" ></div><span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 26.7525%;"></span></div>
										<input type="text" value="0" name="configure-slider5-val" readonly id="configure-slider5-val"><!--</div>-->
                                        
                                        </td>
                                    </tr>
									<input type="hidden" name="counter_val" value="5" id="counter_val">
									
                                  </tbody>
                                </table>
                                <a class="addmore-btn pull-left" style="font-size:13px; margin-left:8px">+ Add more</a>
                                <div class="clearfix"></div>
                                </div>
                                
                                <div class="keyword-meaning">
                                    <ul>
                                        <li>Exact Match = <span>keyword</span></li>
                                        <li>Related = <span>Synonym / Similar</span></li>
                                        <li>Blended = <span>Keyword in Phrase</span></li>
                                        <li>Brand = <span> Name</span></li>
                                        <li>Raw = <span>url of anchor</span> </li>
                                    </ul>
                                </div>
                                
                                <div class="sclprow">
                                <p>
                                    <span class="number-count">2</span> How fast do you want your links built? <i>(Link Velocity)</i>
                                </p>
                                <ul class="lb-fast">
                                    <li><input type="radio" name="link_velocity" value="more slowly"> <img width="12" height="16" alt="" src="images/pic7.png"> Avenger Natural Link Velocity ( more slowly)</li>
                                    <li><input type="radio" name="link_velocity" value="faster"> <img width="12" height="16" alt="" src="images/pic7.png"> Avenger Natural Link Velocity ( more aggressive)</li>
                                    <li><input type="radio" name="link_velocity" value="24hour"> <img width="12" height="16" alt="" src="images/pic7.png"> Build links immediately (usually within 24 hours)</li>
                                </ul>
                                </div>
                                
                                <div class="sclprow">
                                    <p>
                                        <span class="number-count">3</span> That's it! launch your campaign:
                                    </p>
                                    <button type="submit" class="btn btn-primary" style="margin-left:41px" data-target="#supportingkw" data-toggle="modal">Launch!</button>
                                </div>
            </div></form>
        <div class="clearfix"></div>
         </div>
                        </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div> 
        
      <div class="unchksite-sec">
        	<h2>Uncheck any sites you’d like to ignore.  <span>(Changes will show above)</span>  </h2>
          <ul id="top_ten_website">
                <?php 
				
				$campid = $userdetailcompare->id;
				
				$url = $userdetailcompare->campaign_main_page_url;
$keyword = $userdetailcompare->campaign_main_keyword;
$bot='gr';
if($userdetailcompare->google_se_domain!=''){
	$bot='gr';
} else if($userdetailcompare->yahoo_se_domain!=''){
	$bot='yahoo';
} else if($userdetailcompare->bing_se_domain!=''){
	$bot='bing';
}
$location = $userdetailcompare->crawl_country;

				/*$this->load->helper('bots_helper');
				$top_tensitethumnails = get_top_tenwebsite('gr',$keyword,'usa');
				
				
				
              $toptensiteiamgesrc = '';
              $imgindex = 0;
			  $toptensitethumnails = array();
                foreach($top_tensitethumnails as $toptenurl) {
				
				$toptensitethumnails[] = $toptenurl->url;
      /* $grabzIt->SetImageOptions($toptenurl->url,null,null,null,120,90);
       
       $imageid = $grabzIt->Save($grabzItHandlerUrl);
       $imageid = str_replace("ZGIzY2JmNDNkOWY3NGYwNWJjNjkyYTM5MzI4MmUwMTU=", "", $imageid);*/
                  //sleep(5);
                    ?>
      
 
     <?php /*$imgindex++; 
	 if($imgindex == 10){break;}
} */

?>
 
  </ul>
         
        </div>
        	
    <div class="clearfix"></div>
    </div>

     <div class="finishbtn-area">
            <button type="button" class="btn btn-primary" id="finish_campaign">Finish</button>
        </div>
    
</div>   


</div>
</div>
<?php 


?>


<script src="<?php echo base_url();?>js/script.js"></script>  
<script type="text/javascript">
$(document).ready(function(){

$('#finish_campaign').click(function(){
buildlink = $('input[name="build_link"]:checked').val();
exact='0';
related ='0';
blended ='0';
brand ='0';
url ='0';
generic ='0';
if(buildlink=='bot'){
	exact = $('#suggested-excat-match').val();
	related = $('#suggested-related-kw-val').val();
	blended = $('#suggested-blended-kw-val').val();
	brand = $('#suggested-brand-kw-val').val();
	url = $('#suggested-raw-url-val').val();
	generic = $('#suggested-generic-val').val();
}
if(buildlink=='manually'){
	exact = $('#manually-excat-match').val();
	related = $('#manually-related-kw-val').val();
	blended = $('#manually-blended-kw-val').val();
	brand = $('#manually-brand-kw-val').val();
	url = $('#manually-raw-url-val').val();
	generic = $('#manually-generic-val').val();
} 
$.ajax({
        type : "POST",
        url : "<?php echo base_url(); ?>analyzecompare2/update_avenger_bots/<?php echo $campid; ?>",
        data : 'buildlink='+buildlink+'&exact='+exact+'&related='+related+'&blended='+blended+'&brand='+brand+'&url='+url+'&generic='+generic,
        success: function(data){ 
			window.location.href='<?php echo base_url();?>index.php/launchcampaign/';
         }
    });
	
});

$('#self_configured').submit(function(){
frmdata = $( this ).serialize();
$.ajax({
        type : "POST",
        url : "<?php echo base_url(); ?>analyzecompare2/update_linking_plan/s/<?php echo $campid ; ?>",
        data : frmdata,
        success: function(data){ 
			alert(data);
         }
    });
return false;
});


$('.check').click(function(){
if ($(this).is(':checked') == true){
$('input:checkbox').prop('checked', false);
$(this).prop('checked', true);
}
});  

$('#chckbox').click(function(){
$('#lbmainmanual').css("visibility","hidden");
$('#lbmain').css("visibility","visible");
$('#configure').css("visibility","hidden");
//$('#lbmain .dragger :input').attr("disabled", "disabled");
});

$('#chckboxmanual').click(function(){
$('#lbmainmanual').css("visibility","visible");
$('#lbmain').css("visibility","hidden");
$('#configure').css("visibility","hidden");
//$('#lbmain .dragger :input').attr("disabled", "disabled");
});

$('#configureman').click(function(){
$('#lbmainmanual').css("visibility","hidden");
$('#lbmain').css("visibility","hidden");
$('#configure').css("visibility","visible");
//$('#lbmain .dragger :input').attr("disabled", "disabled");

});


setTimeout(function(){
    $("#img1").attr("src", "<?php echo base_url()."images/screenshots/".$id1; ?>.jpg");
}, 10000);
});

$(window).load(function() {
$.noConflict();


var incid=5;

$(".addmore-btn").click(function() {
incid++;
divarr = $('<div>').attr('id', 'configure-slider' + incid).slider({range: "min",
				value: 0,
				min: 0,
				max: 100,
				animate: true,
              slide: function( event, ui ) {
				     var id = $(this).attr("id");
	
					 curval = $('#'+id+'-val').val();
					 //curval = parseFloat(curval.replace('%',''));
					 obj = $(this);
						total = 0;
						execeptcur =0;
						$('.customslier').each(function() {
						
							if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
							total = parseFloat(total) + parseFloat($(this).slider( "value" ));
							
						});
						
						if(ui.value > curval){
							if(total>99){ 
								slidval = parseFloat(100) - parseFloat(execeptcur);  
								//console.log(slidval);
								if(slidval<0){ slidval=0;}
								//obj.slider( "value",slidval +'%');
								$('#'+id+'-val').val(slidval);
								return false;
							} else {
								$('#'+id+'-val').val(ui.value);
							}
						} else {
							$('#'+id+'-val').val(ui.value);
						}
                //$('#addnew'+incid).val();
              }});
			  liid= 'new'+incid;
			  sliderinput = '<input type="text" value="0" name="configure-slider'+incid+'-val" readonly id="configure-slider'+incid+'-val">';
			  appendata = '<tr><td><div class="dropdown"><select name="selfconfigure'+incid+'" class="dropdown-select">                                                <option value="">Select One</option>  												<option value="exact">Exact Match</option>  												<option value="related">Related Keyword</option>  												<option value="blended">Blended Keyword</option>  												<option value="brand">Brand Keyword</option>  												<option value="raw">Raw Url</option>  												<option value="generic">Generic</option>                                              </select>                                        </div>                                      </td>                                      <td><input type="text" name="exact_anchor'+incid+'"></td>                                      <td><input type="text" name=" exact_url'+incid+'"></td><td id="customid'+incid+'"></td></tr>';
				$("#ancurl-fields-exact").append(appendata);
				$("#customid"+incid).append(divarr);
				$("#customid"+incid).append(sliderinput);
				//$('#currentinc').val(incid);
				$('#configure-slider' + incid).addClass('customslier');

				$('#counter_val').val(incid);
});


$( ".customslier" ).slider({
 range: "min",
 min: 0,
 max: 100,
 create: function () {
            $(this).slider( "option", "value", '0' );
        }, 
 slide: function( event, ui ) { 

	var id = $(this).attr("id");
	
	 curval = $('#'+id+'-val').val();
	 //curval = parseFloat(curval.replace('%',''));
	 obj = $(this);
		total = 0;
		execeptcur =0;
		$('.customslier').each(function() {
		
			if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
			total = parseFloat(total) + parseFloat($(this).slider( "value" ));
			
		});
		
		if(ui.value > curval){
			if(total>99){ 
				slidval = parseFloat(100) - parseFloat(execeptcur);  
				//console.log(slidval);
				if(slidval<0){ slidval=0;}
				//obj.slider( "value",slidval +'%');
				$('#'+id+'-val').val(slidval);
				return false;
			} else {
				$('#'+id+'-val').val(ui.value);
			}
		} else {
			$('#'+id+'-val').val(ui.value);
		}
		
		
     //get the id of this slider
   //  var id = $(this).attr("id");
     //select the input box that has the same id as the slider within it and set it's value to the current slider value. 
        
 }
 });
		
		$( "#manually-excat-min" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
		//return false;
			manexact = $("#manually-excat-min" ).slider( "value" );
			manrelated = $("#manually-related-kw" ).slider( "value" );
			manblended = $("#manually-blended-kw" ).slider( "value" );
			manraw = $("#manually-raw-url" ).slider( "value" );
			manbrand = $("#manually-brand-kw" ).slider( "value" );
			mangeneric = $("#manually-generic" ).slider( "value" );
			if(ui.value>manexact){
			if(parseInt(manexact)+parseInt(manrelated)+parseInt(manblended)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric)>99){
				alltot = parseInt(manrelated)+parseInt(manblended)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric);
				slidval = parseInt(100) - parseInt(alltot);  
				$( this ).slider( "value",slidval );
				$( "#manually-excat-match" ).val(slidval+'%');
				return false;
			} else { 
				$( "#manually-excat-match" ).val( ui.value +'%');
			}
			} else {
				$( "#manually-excat-match" ).val( ui.value +'%');
			}
		}
		});
		$( "#manually-excat-match" ).val( $( "#manually-excat-min" ).slider( "value" ) );
		
		
		$( "#manually-related-kw" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
			manexact = $("#manually-excat-min" ).slider( "value" );
			manrelated = $("#manually-related-kw" ).slider( "value" );
			manblended = $("#manually-blended-kw" ).slider( "value" );
			manraw = $("#manually-raw-url" ).slider( "value" );
			manbrand = $("#manually-brand-kw" ).slider( "value" );
			mangeneric = $("#manually-generic" ).slider( "value" );
			if(ui.value>manrelated){
				if(parseInt(manexact)+parseInt(manrelated)+parseInt(manblended)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric)>99){
					alltot = parseInt(manexact)+parseInt(manblended)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric);
					slidval = parseInt(100) - parseInt(alltot);  
					$( this ).slider( "value",slidval );
					$( "#manually-related-kw-val" ).val(slidval +'%');
					return false;
				} else { 
					$( "#manually-related-kw-val" ).val( ui.value +'%');
				}
			} else { 
				$( "#manually-related-kw-val" ).val( ui.value +'%');
			}
		}
		});
		$( "#manually-related-kw-val" ).val( $( "#manually-related-kw" ).slider( "value" ) );
		
		
		$( "#manually-blended-kw" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
			manexact = $("#manually-excat-min" ).slider( "value" );
			manrelated = $("#manually-related-kw" ).slider( "value" );
			manblended = $("#manually-blended-kw" ).slider( "value" );
			manraw = $("#manually-raw-url" ).slider( "value" );
			manbrand = $("#manually-brand-kw" ).slider( "value" );
			mangeneric = $("#manually-generic" ).slider( "value" );
			
			if(ui.value>manblended){
				if(parseInt(manexact)+parseInt(manrelated)+parseInt(manblended)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric)>99){
					alltot = parseInt(manexact)+parseInt(manrelated)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric);
					slidval = parseInt(100) - parseInt(alltot);  
					$( this ).slider( "value",slidval );
					$("#manually-blended-kw-val").val(slidval +'%');
					return false;
				} else { 
					$( "#manually-blended-kw-val" ).val( ui.value +'%');
				}
			} else { 
					$( "#manually-blended-kw-val" ).val( ui.value +'%');
			}
		}
		});
		$( "#manually-related-kw-val" ).val( $( "#manually-blended-kw" ).slider( "value" ) );
		
		$( "#manually-brand-kw" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
			manexact = $("#manually-excat-min" ).slider( "value" );
			manrelated = $("#manually-related-kw" ).slider( "value" );
			manblended = $("#manually-blended-kw" ).slider( "value" );
			manraw = $("#manually-raw-url" ).slider( "value" );
			manbrand = $("#manually-brand-kw" ).slider( "value" );
			mangeneric = $("#manually-generic" ).slider( "value" );
			
			if(ui.value>manbrand){
				if(parseInt(manexact)+parseInt(manrelated)+parseInt(manblended)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric)>99){
					alltot = parseInt(manexact)+parseInt(manrelated)+parseInt(manraw)+parseInt(manblended)+parseInt(mangeneric);
					slidval = parseInt(100) - parseInt(alltot);  
					$( this ).slider( "value",slidval );
					$("#manually-brand-kw-val").val(slidval +'%');
					return false;
				} else { 
					$( "#manually-brand-kw-val" ).val( ui.value +'%');
				}
			} else { 
				$( "#manually-brand-kw-val" ).val( ui.value +'%');
			}
		}
		});
		$( "#manually-brand-kw-val" ).val( $( "#manually-brand-kw" ).slider( "value" ) );
		
		$( "#manually-raw-url" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
			manexact = $("#manually-excat-min" ).slider( "value" );
			manrelated = $("#manually-related-kw" ).slider( "value" );
			manblended = $("#manually-blended-kw" ).slider( "value" );
			manraw = $("#manually-raw-url" ).slider( "value" );
			manbrand = $("#manually-brand-kw" ).slider( "value" );
			mangeneric = $("#manually-generic" ).slider( "value" );
			
			if(ui.value>manraw){
				if(parseInt(manexact)+parseInt(manrelated)+parseInt(manblended)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric)>99){
					alltot = parseInt(manexact)+parseInt(manrelated)+parseInt(manbrand)+parseInt(manblended)+parseInt(mangeneric);
					slidval = parseInt(100) - parseInt(alltot);  
					$( this ).slider( "value",slidval );
					$("#manually-raw-url-val").val(slidval +'%');
					return false;
				} else { 
					$( "#manually-raw-url-val" ).val( ui.value +'%');
				}
			} else { 
					$( "#manually-raw-url-val" ).val( ui.value +'%');
			}
		}
		});
		$( "#manually-raw-url-val" ).val( $( "#manually-raw-url" ).slider( "value" ) );
		
		$( "#manually-generic" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		change: function( event, ui ) {
			manexact = $("#manually-excat-min" ).slider( "value" );
			manrelated = $("#manually-related-kw" ).slider( "value" );
			manblended = $("#manually-blended-kw" ).slider( "value" );
			manraw = $("#manually-raw-url" ).slider( "value" );
			manbrand = $("#manually-brand-kw" ).slider( "value" );
			mangeneric = $("#manually-generic" ).slider( "value" );
			
			if(ui.value>mangeneric){
				if(parseInt(manexact)+parseInt(manrelated)+parseInt(manblended)+parseInt(manraw)+parseInt(manbrand)+parseInt(mangeneric)>99){
					alltot = parseInt(manexact)+parseInt(manrelated)+parseInt(manbrand)+parseInt(manblended)+parseInt(manraw);
					slidval = parseInt(100) - parseInt(alltot);  
					$( this ).slider( "value",slidval +'%');
					$("#manually-generic-val").val(slidval+'%');
					return false;
				} else { 
					$( "#manually-generic-val" ).val( ui.value +'%');
				}
			} else { 
					$( "#manually-generic-val" ).val( ui.value +'%');
				}
		}
		});
		$( "#manually-generic-val" ).val( $( "#manually-generic" ).slider( "value" ) );
		
		
	
		$( "#suggested-excat-min" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
		return false;
		//$( "#suggested-excat-match" ).val( ui.value );
		}
		});
		$( "#suggested-excat-match" ).val( $( "#suggested-excat-min" ).slider( "value" ) );
		
		
		$( "#suggested-related-kw" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
		return false;
		//$( "#suggested-related-kw-val" ).val( ui.value );
		}
		});
		$( "#suggested-related-kw-val" ).val( $( "#suggested-related-kw" ).slider( "value" ) );
		
		
		$( "#suggested-blended-kw" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
			return false;
		//$( "#suggested-blended-kw-val" ).val( ui.value );
		}
		});
		$( "#suggested-related-kw-val" ).val( $( "#suggested-blended-kw" ).slider( "value" ) );
		
		$( "#suggested-brand-kw" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
			return false;
			//$( "#suggested-brand-kw-val" ).val( ui.value );
		}
		});
		$( "#suggested-brand-kw-val" ).val( $( "#suggested-brand-kw" ).slider( "value" ) );
		
		$( "#suggested-raw-url" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
		return false;
		//$( "#suggested-raw-url-val" ).val( ui.value );
		}
		});
		$( "#suggested-raw-url-val" ).val( $( "#suggested-raw-url" ).slider( "value" ) );
		
		$( "#suggested-generic" ).slider({
		range: "min",
		value: 0,
		min: 0,
		max: 100,
		animate: true,
		slide: function( event, ui ) {
			return false;
		//$( "#suggested-generic-val" ).val( ui.value );
		}
		});
		$( "#suggested-generic-val" ).val( $( "#suggested-generic" ).slider( "value" ) );
		
		
		

		
		
var progressvalglo = 0;
var miningvalglo =0;
initilizeprogressbar('progress-serp','percentage-cs-serp','progress-stripes-serp');
//initilizeprogressbar('progress-backlink','percentage-cs-backlink','progress-stripes-backlink');
$("#meterid > span").each(function() {
				$("#meterid > span")
					.data("origWidth", $(this).width())
					.width(0)
					.animate({
						width: $(this).data("origWidth")
					}, 1200);
			});
			
//var randNum = Math.floor(Math.random() * 3);

//switch (randNum) {
/*case 0:
repeatXI.apply(null, [percb].concat(2000,5));
break;
case 1:
repeatXI.apply(null, [percb1].concat(1500,6));
break;
default:*/
//repeatXI.apply(null, [percb2].concat(2500,6));
//}
//	repeatXI.apply(null, [cb].concat(3500,2));		

$.ajax({
     type: 'POST',
	 url: "<?php echo 'http://serpavenger.com/serpcrawl/service_sp.php?key='.$keyword.'&bot='.$bot.'&loc='.$location.'&page=1&siteurl='.$url;?>",
     data: {},
     success: function(data){
		dataarr = $.parseJSON(data);
		console.log(dataarr.backlinkdata);
		
		x=0;
		backlinkcnt=0;
		initilizebacklinkbar('progress-backlink','percentage-cs-backlink','progress-stripes-backlink');
		update_db_data('<?php echo $keyword; ?>','<?php echo $bot; ?>','<?php echo $location; ?>',<?php echo $campid; ?>, data);
		$.each(dataarr.backlinkdata, function(i,item){
		if(x==0){ 
			excatper = parseFloat(item.ExactPercent);
			relatedper = parseFloat(item.RelatedPercent);
			blendedper = parseFloat(item.BlendedPercent);
			brandper = parseFloat(item.BrandPercent);
			rawper = parseFloat(item.RawPercent);
			genericper = parseFloat(item.GenericPercent);
		}
		if(x==2){
			initilizeminingbar('progress-mining','percentage-cs-mining','progress-stripes-mining');
		}
		
		//alert(item.backlinks);
		backlinkcnt =  parseInt(backlinkcnt) + parseInt(item.backlinks);
		
			siteurl = item.url;
			siteurl = siteurl.replace("http://", '');
			siteurl = siteurl.replace("https://", '');
			siteurl = siteurl.replace("www.", '');
			
			siteurl = siteurl.substr(0, 25);
		
			if(x>0){
			$('#top_ten_website').append('<li><input checked="checked" type="checkbox"><img id="imgx_'+x+'" src="http://serpavenger.com/serp_avenger/assets/images/waiting_thumbnail.jpg" width="120" height="90" alt=""><br>'+siteurl+'</li> '); 
			thumb_image_load(item.url,x);
			} 
			if(x==10){ numbercounter('0', backlinkcnt,'backcnt'); 
			//jqueryslideranimation('suggested-excat-min',excatper,'suggested-excat-match');
			//jqueryslideranimation('suggested-related-kw',relatedper,'suggested-related-kw-val');
			//jqueryslideranimation('suggested-blended-kw',blendedper,'suggested-blended-kw-val');
			//jqueryslideranimation('suggested-brand-kw',brandper,'suggested-brand-kw-val');
			//jqueryslideranimation('suggested-raw-url',rawper,'suggested-raw-url-val');
			//jqueryslideranimation('suggested-generic',genericper,'suggested-generic-val');
			}

/*setTimeout(function() {
//preload(6 * <?php echo $im; ?>);
preload(x);
      $("#imgx_x").attr("src", "<?php echo base_url(); ?>images/screenshots/<?php echo str_replace("YjMzMjFlZWY4Y2U4NDRhNWFmZWIxM2U5Nzc0YmNjNDQ=", "", $imgid); ?>.jpg");
}, 10000);*/
x++;
			if(x==11){
			preload('progress-serp','percentage-cs-serp',100);
			 return false;
			 }
		});
    }
 });
 
 

});

function setwidth(pwidth){
	//width = $("#meterid > span").width() / $("#meterid").width() * 100;
pwidth = parseInt(20) + parseInt(pwidth);
alert(pwidth);
				//alert(width);
				$("#meterid > span").animate({
						width: pwidth+'%'
					}, 1200);
}






function repeatXI(callback, interval, repeats, immediate) {
    var timer, trigger;
    trigger = function() {
        callback();
        --repeats || clearInterval(timer);
    };

    interval = interval <= 0 ? 1000 : interval; // default: 1000ms
    repeats = parseInt(repeats, 10) || 0; // default: repeat forever
    timer = setInterval(trigger, interval);

    if ( !! immediate) { // Coerce boolean
        trigger();
    }

    return timer;
}

function percb2(){
//preload('progress-serp','percentage-cs-serp',10);
}


    
function update_db_data(keyword,bot,location,campaignid,jsondata){
			$.ajax({
        type : "POST",
        url : "<?php echo base_url(); ?>analyzecompare2/update_crawled_data/"+keyword+"/"+bot+"/"+location+"/"+campaignid+"/",
        data : {json_datas:jsondata},
        success: function(data){ 
			//alert(data);
         }
    });

}


function thumb_image_load(urldec,indexid){

urlarr = urldec.split('&amp');
	
	$.ajax({
        type : "POST",
        url : "<?php echo base_url(); ?>analyzecompare2/generate_thumb_image",
        data : 'url='+urlarr[0],
        success: function(data){ 
			setTimeout(function() {
				if(indexid==1){ initilizeavengerbar('progress-avenger','percentage-cs-avenger','progress-stripes-avenger');}
				$("#imgx_"+indexid).attr("src", "<?php echo base_url(); ?>images/screenshots/"+data+".jpg");				
				if(indexid==10){
					
					backlinkprogressbar('progress-backlink','percentage-cs-backlink',100);
					
					jqueryslideranimation('suggested-excat-min','16.19','suggested-excat-match');
					jqueryslideranimation('suggested-related-kw','15.49','suggested-related-kw-val');
					jqueryslideranimation('suggested-blended-kw','24.64','suggested-blended-kw-val');
					jqueryslideranimation('suggested-brand-kw','8.45','suggested-brand-kw-val');
					jqueryslideranimation('suggested-raw-url','21.12','suggested-raw-url-val');
					jqueryslideranimation('suggested-generic','14.08','suggested-generic-val');
					
				}
				//
				
			}, 10000);
         }
    });
}
function jqueryslideranimation(htmlid, slidernum,inputvalueid){
	$( "#"+htmlid).slider('value',slidernum);
	$( "#"+inputvalueid).val(slidernum +'%');
	$//("#"+htmlid).slider({ disabled: true });
}
</script>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
