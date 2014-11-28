<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">// <![CDATA[
        function preloader(){
            document.getElementById("loading").style.display = "none";
            document.getElementById("thumb-keyword").style.display = "block";
        }//preloader
        window.onload = preloader;
// ]]></script>  
<body onload="DisData('1')" >
<div class="container">
<div class="row" id="header">
<div class="col-md-3 left-col">
<div id="logo"><a href="index.html"><img src="<?php echo base_url(); ?>images/logo.png" width="214" height="84" alt=""></a></div>
</div>

<div class="col-md-9 menusec right-col">
<?php //print_r($session = $this->session->userdata('user_data'));
$this->load->view('includes/header'); ?>

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
<li class="progtrckr-todo"><span class="thirdp">Launch Campaign</span></li>
</ol>
<div class="clearfix"></div>
<?php
include("apifolder/GrabzItClient.class.php");
   
$grabzItHandlerUrl = "http://serpavenger.com/serp_avenger/handler.php";
 
$grabzIt = new GrabzItClient("ZGIzY2JmNDNkOWY3NGYwNWJjNjkyYTM5MzI4MmUwMTU=", "Pz8RP2taPyc/cipQOD8/Pz8/PxEoUz8+Pz8/P2Y/Py4=");

$grabzIt->SetImageOptions($userdetailcompare->campaign_main_page_url,null,null,null,200,150);
      $id1 = $grabzIt->Save($grabzItHandlerUrl);
      // echo '<li><a href="http://'.$userdetailcompare->campaign_main_page_url.'" target="_blank" ><img src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$userdetailcompare->campaign_main_page_url.'.jpg" width="200" height="150" ></a><a href="http://'.$userdetailcompare->campaign_main_page_url.'" target="_blank" ><span>'.$userdetailcompare->campaign_main_page_url.'</span></a></li>';  
?>

<!-- compaigns-details-row -->
<div class="compaigns-details-row">
<div class="keyword-sec">
<div id="loading"></div>
<div class="thumb-keyword" id="thumb-keyword">
<!--<img src="<?php echo base_url(); ?>images/RPA-keyword.gif" width="200" height="150" class="keyword-main-thumb" alt=""/> -->
<?php 
if($id1!='')
{
  sleep(20);
  
echo '<img id="img1" src="http://www.serpavenger.com/serp_avenger/images/screenshots/'.$id1.'.jpg" width="200"  height="150" />';

  
}

?>
<span>
<?php //print_r($userdetailcompare);?>
	<!--<a href="">Rentalprotectionagency.com</a>-->
  <?php
  echo '<a href="'.$userdetailcompare->campaign_main_page_url.'" target="_blank" >'.$userdetailcompare->campaign_main_page_url.'</a>';
   ?>
	<!--<img src="images/enter-ur-url.png" width="34" height="28" class="pull-right" alt=""/>-->
</span>
</div>
</div>

<div class="keyword-info2 pull-right">
<div class="keyword-row">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="keyword-rank">
  <tbody>
    <tr>
      <td align="right">
      	<p>Main Keyword:</p>
    	<img src="<?php echo base_url(); ?>images/gry-arrow.gif" width="26" height="23" alt=""/>
      </td>
      <td align="left">
      	<span class="blue-text"><?php print_r($keywordmain['keyword']); //stripslashes($campaign_detail[0]['campaign_main_keyword']);?></span><br>
<span class="smalltext">(This is my most important KW)</span> 
</td>
    <td>
    	<button data-toggle="modal" data-target="#editkw" class="btn btn-primary" type="button" >Edit Keyword</button>
        <!-- Edit keyword popup-->
            <div class="modal fade text-left" id="editkw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header popup-header">
                <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Main Keyword</h4>
              </div>
              <div class="modal-body popupbody">
              	
                <div class="modal-header kwhead">
                	<h2>What would you like to set as your main keyword?</h2>
                    
                </div>
                <div class="enter-keyword">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                      <tr>
                        <td width="16%" valign="middle" class="valgn-middle">Enter Keyword:</td>
                        <td><input name="keywordname" type="text" id="entrkeywrdmain" value=""></td>
                      </tr>
                    </table>
                    <div class="headingor"><span class="greyorcircle">OR</span> Select a Suggested Keyword:</div>
                </div> 
                <div class="clearfix"></div>
                <div class="sk-list ">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                          <th></th>
                          <th>Similar Keyword</th>
                          <th>Est Traffic</th>
                          <th>CPC</th>
                        </tr>
                        <?php  if(is_array($campaign_cpc_detail) && count($campaign_cpc_detail) > 0){
                            //for($i=0; $i<count($campaign_cpc_detail); $i++){
                          for($i=1; $i<count($kcpcData); 
                          $i++){
                             ?>
                        <tr>
                          <td><input type="checkbox" value='<?php echo stripslashes($kcpcData[$i]['0']); ?>' id="chckkeyword" style="width:14px" onclick="myFunction(this.value);"></td>
                          <td> 
        <?php echo stripslashes($kcpcData[$i]['0']); ?></td>
                          <td><?php echo stripslashes($kcpcData[$i]['1']);?></td>
                          <td><?php echo stripslashes($kcpcData[$i]['2']); ?></td>
                        </tr>
                       <?php } }?>
                      </tbody>
                    </table>
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" class="btn btn-primary pull-left" id="editsave"  onClick="validate();return false;">Save</button><div id="mainkeyresult"></div>
                      </div>
                <div class="clearfix"></div>   
              </div>
            </div>
            </div>
            </div>
    </td>
    </tr>
    <tr>
      <td align="right">
      	<p>Secondary Keyword:</p>
    	<img src="<?php echo base_url(); ?>images/gry-arrow.gif" width="26" height="23" alt=""/>
      </td>
      <td align="left">
      	<span class="textgrey">
        <?php //print_r($keywordsec['keyword']); 
          echo $keywordmain['keyword']; ?></span><br>
<span class="smalltext">(Next most important KW)</span> 
</td>
    <td>
    	<button data-toggle="modal" data-target="#secondarykw" class="btn btn-primary" type="button">Set Keyword</button>
        <!-- Secondary keyword popup-->
            <div class="modal fade text-left" id="secondarykw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header popup-header">
                <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true" id="secclkboot">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Secondary Keyword</h4>
              </div>
              <div class="modal-body popupbody">
              	
                <div class="modal-header kwhead">
                	<h2>What would you like to set as your Secondary keyword?</h2>
                    
                </div>
                <div class="enter-keyword">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                      <tr>
                        <td width="16%" valign="middle" class="valgn-middle">Enter Keyword:</td>
                        <td><input name="" type="text" id="entrkeywrdsecond"></td>
                      </tr>
                    </table>
                    <div class="headingor"><span class="greyorcircle">OR</span> Select a Suggested Keyword:</div>
                </div> 
                <div class="clearfix"></div>
                <div class="sk-list ">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <th></th>
                          <th>Similar Keyword</th>
                          <th>Est Traffic</th>
                          <th>CPC</th>
                        </tr>
                         <?php  if(is_array($campaign_cpc_detail) && count($campaign_cpc_detail) > 0){
                            //for($i=0; $i<count($campaign_cpc_detail); $i++){
                          for($i=1; $i<count($kcpcData); 
                          $i++){
                             ?>
                        <tr>
                          <td><input type="checkbox" value='<?php echo stripslashes($kcpcData[$i]['0']); ?>' id="chckkeyword" style="width:14px" onclick="myFunction(this.value);"></td>
                          <td> 
        <?php echo stripslashes($kcpcData[$i]['0']); ?></td>
                          <td><?php echo stripslashes($kcpcData[$i]['1']);?></td>
                          <td><?php echo stripslashes($kcpcData[$i]['2']); ?></td>
                        </tr>
                       <?php } }?>
                      </tbody>
                    </table>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary pull-left" onClick="validatesecond();return false;">Save</button><div id="secondkeyresult"></div>
                      </div>
                <div class="clearfix"></div>   
              </div>
            </div>
            </div>
            </div>
    </td>
    </tr>
    <tr>
      <td align="right">
      	<p>Supporting Keyword(s): </p>
    	<img src="<?php echo base_url(); ?>images/gry-arrow.gif" width="26" height="23" alt=""/>
      </td>
      <td align="left">
      	<span  class="textgrey"><?php echo($additionalkeyword); ?></span><br>
<span class="smalltext">(Next most important KW's)</span> 
</td>
    <td>
    	<button data-toggle="modal" data-target="#supportingkw" class="btn btn-primary" type="button">Set Keyword</button>
        <!-- supporting keyword popup-->
            <div class="modal fade text-left" id="supportingkw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header popup-header">
                <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true" id="thirdclkboot">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Supporting Keyword(s)</h4>
              </div>
              <div class="modal-body popupbody">
              	
                <div class="modal-header kwhead">
                	<h2>What would you like to set as your supporting keyword(s)?</h2>
                    
                </div>
                <div class="enter-keyword">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                      <tr>
                        <td width="16%" valign="middle" class="valgn-middle">Enter Keyword:</td>
                        <td><textarea style="width:100%" id="entrkeywrdthird"></textarea> </td>
                        <td class="valgn-middle">Enter 1 keyword per line</td>
                      </tr>
                    </table>
                    <div class="headingor"><span class="greyorcircle">OR</span> Select a Suggested Keyword(s):</div>
                </div> 
                <div class="clearfix"></div>
                <div class="sk-list ">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <th></th>
                          <th>Similar Keyword</th>
                          <th>Est Traffic</th>
                          <th>CPC</th>
                        </tr>
                        <?php  if(is_array($campaign_cpc_detail) && count($campaign_cpc_detail) > 0){
                            //for($i=0; $i<count($campaign_cpc_detail); $i++){
                          for($i=1; $i<count($kcpcData); 
                          $i++){
                             ?>
                        <tr>
                          <td><input type="checkbox" value='<?php echo stripslashes($kcpcData[$i]['0']); ?>' id="chckkeyword" style="width:14px" onclick="myFunction(this.value);"></td>
                          <td> 
        <?php echo stripslashes($kcpcData[$i]['0']); ?></td>
                          <td><?php echo stripslashes($kcpcData[$i]['1']);?></td>
                          <td><?php echo stripslashes($kcpcData[$i]['2']); ?></td>
                        </tr>
                       <?php } }?>
                      </tbody>
                    </table>
                    </div>
                    <div class="modal-footer ">
                         <button type="button" class="btn btn-primary pull-left" onClick="validatethird();return false;">Save</button><div id="thirdkeyresult"></div>
                      </div>
                <div class="clearfix"></div>   
              </div>
            </div>
            </div>
            </div>
    </td>
    </tr>
  </tbody>
</table>


</div>
</div>

<div class="clearfix"></div>
</div>
<!--Suggested Keywords-->
<div class="suggested-keyword">
<h3>Suggested Keywords:   (click on a keyword below to see how valuable its ranking is by position)</h3>
<div class="skmain">
<div class="skhead">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
  <tbody>
    <tr>
      <td width="24%">Similar Keyword</td>
      <td width="12%">Est Traffic</td>
      <td>CPC </td>
      <td align="center">How valuable is this keyword based on its ranking</td>
    </tr>
  </tbody>
</table>

</div>
<!-- Tabs -->
<div id="tabs">
<ul>
<?php 
//echo "bcos";echo "<br>";
//echo "<pre>";
//print_r($kcpcData);
if(is_array($campaign_cpc_detail) && count($campaign_cpc_detail) > 0){
//for($i=0; $i<count($campaign_cpc_detail); $i++){                                   
for($i=1; $i<count($kcpcData); 
$i++){
   ?>
<li>
<a href="#tabs-1">
  <span class="smlrkeywrd" data-val="<?php echo $kcpcData[$i]['1']*$kcpcData[$i]['2'];?>"><?php echo stripslashes($kcpcData[$i]['0']);?></span>
        <span class="esttrfic"><?php echo stripslashes($kcpcData[$i]['1']);?></span>
        <span class="cpc"><?php echo stripslashes($kcpcData[$i]['2']);?></span>
</a>
	<!-- <a href="#tabs-1">
    	<span class="smlrkeywrd" data-val="<?php //echo $campaign_cpc_detail[$i]['keyword_est_traffic']*$campaign_cpc_detail[$i]['keyword_cpc'];?>"><?php //echo stripslashes($campaign_cpc_detail[$i]['keyword']);?></span>
        <span class="esttrfic"><?php //echo stripslashes($campaign_cpc_detail[$i]['keyword_est_traffic']);?></span>
        <span class="cpc"><?php //echo stripslashes($campaign_cpc_detail[$i]['keyword_cpc']);?></span>
    </a> -->
</li>
<?php } }?>
<?php 
//echo "bcos";echo "<br>";
//echo "<pre>";
//print_r($kcpcDatasec);
if(is_array($campaign_cpc_detail) && count($campaign_cpc_detail) > 0){
//for($i=0; $i<count($campaign_cpc_detail); $i++){                                   
for($i2=1; $i2<count($kcpcDatasec); $i2++){
   ?>
<li>
<a href="#tabs-1">
  <span class="smlrkeywrd" data-val="<?php echo $kcpcDatasec[$i2]['1']*$kcpcDatasec[$i2]['2'];?>"><?php echo stripslashes($kcpcDatasec[$i2]['0']);?></span>
  <span class="esttrfic"><?php echo stripslashes($kcpcDatasec[$i2]['1']);?></span>
    <span class="cpc"><?php echo stripslashes($kcpcDatasec[$i2]['2']);?></span>
</a>
   
</li>
<?php } }?>
</ul>

<div id="tabs-1" class="valuable-rank"> 
<ul>
<?php
//echo "sdfgg";echo "<br>";
$valuation_percentage = rearrange_array($campaign_cpc_detail);
$counterx = 1;
$count_kw_valuation_percentage = count($kw_valuation_percentage);
$kvp = array_chunk($kw_valuation_percentage,($count_kw_valuation_percentage/2));    
foreach($kvp as $km=>$kam){
foreach($kam as $vo){
for($i=1; $i<count($kcpcData); $i++){
?>

<li><?php echo $counterx;?>  <span> $<?php $valn =  ($vo/100) * $kcpcData[0]['1'] * $kcpcData[0]['2']; echo number_format($valn,2);?></span></li>


<?php
$counterx++; }}} ?>
</ul>  
</div> 
</div> 

<div class="clearfix"></div>
</div>
<div class="compaign-button-area">
<span><img src="<?php echo base_url(); ?>images/loader.gif" width="71" height="14" alt=""  style="display:none" class="mgrbtm"></span>
<span><a data-toggle="modal" data-target="#skiptop10a" href="#">Skip Top 10 Analysis</a></span>

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
                      <th>% of Total links</th>
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
                
                
            </div><form>
            <div class="clearfix"></div>   
          </div>
        </div>
        </div>
        </div>
<div class="clearfix"></div>  
<button class="btn btn-primary"  name="subLogin" id="subLogin" type="button" onclick="parent.location='<?php echo base_url();?>analyzecompare2/';ShowcronList(<?php $session = $this->session->userdata('user_data'); 
      echo $users_id = $session['user_id']; ?>);">Next</button>
</div>
<div class="clearfix"></div>
</div>

</div>   


</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script type="text/javascript">
function myFunction(a) {
document.getElementById("entrkeywrdmain").value = a;
}
</script>

<script type="text/javascript">
function validate() {
var selects = document.getElementById("entrkeywrdmain").value;
//alert(selects);
var form_data = {
keyword : selects,
campaign_id : <?php echo $campaign_id;?>,
keyword_id : <?php echo $keyword_id;?>
};
$.ajax({
type: 'POST',
async : false,
data: form_data,
url: '<?php echo FRONT_URL;?>ajax/InsertKeyword/', 


success: function(row) 
{ 

$('#mainkeyresult').html(row);
window.location.replace('<?php echo base_url();?>analyzecompare');
// $('#campaigntest1').html(selectedText);

}

});


}
</script>

<script type="text/javascript">
function mysecondFunction(a) {
document.getElementById("entrkeywrdsecond").value = a;
}
</script>
<script type="text/javascript">
function validatesecond() {
var selects = document.getElementById("entrkeywrdsecond").value;
//alert(selects);
var form_data = {
keyword : selects,
campaign_id : <?php echo $campaign_id;?>
};
$.ajax({
type: 'POST',
async : false,
data: form_data,
url: '<?php echo FRONT_URL;?>ajax/InsertsecondaryKeyword/', 


success: function(row) 

{ 
//alert(row);
$('#secondkeyresult').html(row);
$("#secclkboot" ).trigger("click");
}

});


}
</script>
<script type="text/javascript">
function mythirdFunction(a) {
document.getElementById("entrkeywrdthird").value = a;
}
</script>

<script type="text/javascript">
function validatethird() {
var selects = document.getElementById("entrkeywrdthird").value;
//alert(selects);
var form_data = {
keyword : selects,
campaign_id : <?php echo $campaign_id;?>
};
$.ajax({
type: 'POST',
async : false,
data: form_data,
url: '<?php echo FRONT_URL;?>ajax/InsertthirdKeyword/', 


success: function(row) 

{ 

$('#thirdkeyresult').html(row);
$("#thirdclkboot" ).trigger("click");

}

});


}
</script>
<script type="text/javascript">
/*$(function () {
    $("#subLogin").click(function(){
    $('.mgrbtm').removeAttr( 'style' );
    });
  });*/
</script>
<script type="text/javascript">

$(document).ready(function(){
$(".smlrkeywrd").click(function() {
var val = $(this).attr('data-val');
var form_data = {
keywordval : val,
ajax : '1'
};
//alert(val);
/* if ($(this).is(':click') == true){
var ajaxURL = '<?php echo FRONT_URL;?>ajax/kw_cpc_valuation/<?php echo $campaign_id;?>/'+val;
}else{
var ajaxURL = '<?php echo FRONT_URL;?>ajax/kw_cpc_valuation/<?php echo $campaign_id;?>/0';
}*/
var ajaxURL = '<?php echo FRONT_URL;?>ajax/kw_cpc_valuation/'+val;
//alert(ajaxURL);
$.ajax({
type: 'POST',
async : false,
data: form_data,
url:ajaxURL,
context: document.body,
success:function(text){
jQuery('#tabs-1').html(text);
} 
});      
});
});
</script>   

<script type="text/javascript">
$(document).ready(function(){
$('input:checkbox').click(function(){
if ($(this).is(':checked') == true){
$('input:checkbox').prop('checked', false);
$(this).prop('checked', true);
}
});  
});

function ShowcronList(id){

 $('.mgrbtm').removeAttr( 'style' );
// alert(id);
 //var id = $("#selectblogtype1").val();
var form_data = { 
id : id,
ajax : '1'
};
$.ajax({
type: 'POST',
async : false,
data: form_data,
url: '<?php echo base_url(); ?>analyzecompare2/get_crawl_data/',
success: function(row)
{
//alert(row);
}
});

}
</script>


<!-- Include all compiled plugins (below), or include individual files as needed -->


