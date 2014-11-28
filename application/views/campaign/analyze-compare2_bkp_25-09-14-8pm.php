
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
   
$grabzItHandlerUrl = "http://serpavenger.com/serp_avenger/handler.php";
 
$grabzIt = new GrabzItClient("ZGIzY2JmNDNkOWY3NGYwNWJjNjkyYTM5MzI4MmUwMTU=", "Pz8RP2taPyc/cipQOD8/Pz8/PxEoUz8+Pz8/P2Y/Py4=");
$userdetailcompare->campaign_main_page_url;
$grabzIt->SetImageOptions($userdetailcompare->campaign_main_page_url,null,null,null,200,150);
       $id1 = $grabzIt->Save($grabzItHandlerUrl);
      // echo '<li><a href="http://'.$userdetailcompare->campaign_main_page_url.'" target="_blank" ><img src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$userdetailcompare->campaign_main_page_url.'.jpg" width="200" height="150" ></a><a href="http://'.$userdetailcompare->campaign_main_page_url.'" target="_blank" ><span>'.$userdetailcompare->campaign_main_page_url.'</span></a></li>';  
 if($id1!='')
{
  sleep(20);
 echo '<img src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$id1.'.jpg" width="200" height="150" >';
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
                      <th width="35%"><img width="12" height="16" alt="" src="<?php echo base_url(); ?>images/pic7.png"> SERP Crawlers</th>
                      <td>
                      
                            <div class="pull-left loader-main-base">
                                <div class="loader-cs purple" >
                                    <div class="progress-bar"><div class="progress-stripesserpcrw" style="margin-left: -63.6px;">///////////////////////////</div><div class="percentage-cs" >0%</div></div>
                                </div>
                                <div class="pull-left progress-res">
                                    <div class="imgdone" style="display:none;"><i class="fa fa-check"></i></div>
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
                                    <div class="progress-bar"><div class="progress-stripes" style="margin-left: -63.6px;">///////////////////////////</div><div class="percentage-cs" >0%</div></div>
                                </div>
                                <div class="pull-left progress-res">
                                    <div class="imgdone" style="display:none;"><i class="fa fa-check"></i></div>
                                    <span class="purple">Loading</span>
                                </div>
                            </div>  
                      </td>
                    </tr>
                    <tr>
                      <th><img width="12" height="16" alt="" src="<?php echo base_url(); ?>images/pic7.png"> Backlink Scrapers <span class="bccount"><img width="26" height="23" alt="" src="<?php echo base_url(); ?>images/gry-arrow.gif"> <small>Backlink Count: 
<?php echo $backlinkcount->backlinkscount; ?></small></span></th>
                      <td>
                        <div class="pull-left loader-main-base">
                                <div class="loader-cs purple" >
                                    <div class="progress-bar"><div class="progress-stripes" style="margin-left: -63.6px;">///////////////////////////</div><div class="percentage-cs" >0%</div></div>
                                </div>
                                <div class="pull-left progress-res">
                                    <div class="imgdone" style="display:none;"><i class="fa fa-check"></i></div>
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
                                    <div class="progress-bar"><div class="progress-stripes" style="margin-left: -63.6px;">///////////////////////////</div><div class="percentage-cs" >0%</div></div>
                                </div>
                                <div class="pull-left progress-res">
                                    <div class="imgdone" style="display:none;"><i class="fa fa-check"></i></div>
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
                <p class="lbhead"><input type="checkbox" id="chckbox"  checked class="check"> <img src="<?php echo base_url(); ?>images/thander.png" width="9" height="13" alt=""/> Bot Suggested Link Profile <span>(Auto Pilot)</span></p>
                <div class="link-build-way-row" id="lbmain">
                	<span class="lbtitle">Keyword Anchor Percentages</span>
                    <div class="pull-left slidermain">
                        <span class="title">Exact Match</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Related KW</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Blended KW</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Brand KW</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Raw URL</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Generic</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                </div>
            </div>
            <div class="orsapgrey">
                <span>OR</span>
            </div>
            <!--  Main row link build-->
            <div class="lb-main">
                <p class="lbhead"><input type="checkbox" id="chckboxmanual" class="check"> Manually Set Link Profile </span></p>
                <div class="link-build-way-row" id="lbmainmanual" >
                	<span class="lbtitle">Keyword Anchor Percentages</span>
                    <div class="pull-left slidermain">
                        <span class="title">Exact Match</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Related KW</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Blended KW</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Brand KW</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Raw URL</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                    <div class="pull-left slidermain">
                        <span class="title">Generic</span>
                        <input type="text" data-slider="true" value="" data-slider-highlight="true">
                    </div>
                </div>
            </div>
           <div class="orsapgrey">
                <span>OR</span>
            </div>
            <!--  Main row link build-->
            <div class="lb-main2">
                <p class="lbhead"><input type="checkbox" id="configureman" class="check">  Self Configure</span></p>
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
                          <form name="config" method="post" action="<?php echo base_url(); ?>analyzecompare2/formdata">
                          <div class="modal-body popupbody">
                            
                            <div class="sclphead">
                                <h2>Set-up your custom linking Plan below <span>Quantity of links is based on top 10 pattern analysis.</span></h2>
                                
                            </div>
                            <div class="sclpsec">
                                <div class="sclprow">
                                <p>
                                    <span class="number-count">1</span> Provide anchors, URL and how percentages below: <i class="">(drag slider to change percentage)</i>
                                </p>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <th>Keyword Type</th>
                                      <th>Anchor <span>(Spintax Accepted)</span></th>
                                      <th>URL <span>(Spintax Accepted)</span></th>
                                      <th width="227">% of Total links</th>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="dropdown">
                                            <select id="selectblogtype" name="exactkw" class="dropdown-select">
                                                <option value="yes">Exact Match</option>  
                                            </select>
                                        </div>
                                      </td>
                                      <td><input type="text" name="exact_anchor"></td>
                                      <td><input type="text" name=" exact_url"></td>
                                      <td><input type="text" name=" exact_total" data-slider="true" value="" data-slider-highlight="true"></td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="dropdown">
                                            <select id="selectblogtype" name="relatedkw" class="dropdown-select">
                                                <option value="yes">Related Keyword</option>  
                                            </select>
                                        </div>
                                      </td>
                                      <td><input type="text" name="related_anchor"></td>
                                      <td><input type="text" name="related_url"></td>
                                      <td><input type="text" name="related_total" data-slider="true" value="" data-slider-highlight="true"></td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <div class="dropdown">
                                            <select id="selectblogtype" name="selectkw" class="dropdown-select">
                                                <option value="yes">Select KW Type</option>  
                                            </select>
                                        </div>
                                      </td>
                                      <td><input type="text" name="select_anchor"></td>
                                      <td><input type="text" name="select_url"></td>
                                      <td><input type="text" name="select_total" data-slider="true" value="" data-slider-highlight="true"></td>
                                    </tr>
                                  </tbody>
                                </table>
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
                                    <li><input type="checkbox" name="links_built" value="more slowly"> <img width="12" height="16" alt="" src="images/pic7.png"> Avenger Natural Link Velocity ( more slowly)</li>
                                    <li><input type="checkbox" name="links_built" value="more aggressive"> <img width="12" height="16" alt="" src="images/pic7.png"> Avenger Natural Link Velocity ( more aggressive)</li>
                                    <li><input type="checkbox" name="links_built" value="usually within 24 hours"> <img width="12" height="16" alt="" src="images/pic7.png"> Build links immediately (usually within 24 hours)</li>
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
            <ul>
             <?php //print_r ($hrefupdate); ?> 
            
                  
              
             </ul> 
          <!--<ul>
           	  <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img5.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
              <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img6.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
              <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img7.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
              <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img8.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
              <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img9.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
              <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img10.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
              
              
              
              
              
               <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img11.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
               <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img12.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
               <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img13.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
               <li>
               	  <input type="checkbox"> 
                  <img src="<?php echo base_url(); ?>images/img14.gif" width="120" height="90" alt=""/> 
                  <span>boertjelaw.com</span>
              </li>
               
          </ul> -->
        </div>
        	
    <div class="clearfix"></div>
    </div>

     <div class="finishbtn-area">
            <button type="button" class="btn btn-primary" onclick="parent.location='<?php echo base_url();?>index.php/launchcampaign/'">Finish</button>
        </div>
    
</div>   


</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  
<script type="text/javascript">
$(document).ready(function(){

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


});
</script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
