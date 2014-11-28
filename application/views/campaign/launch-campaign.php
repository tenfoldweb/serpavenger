<body onload="DisData('1')">
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
          <li class="progtrckr-done"><span class="thirdp">Launch Campaign</span></li>
      </ol>
      <div class="clearfix"></div>
      
      <div class="congratulations-msg">
      	Congratulations!  You’ve completed the set-up process.
          <span>Please verify the plan and make any changes below; then click on the launch button to finish.</span>
      </div>
      
      <!-- compaigns-details-row -->
      <div class="compaigns-details-row">
          <div class="keyword-sec">
          	<div class="thumb-keyword">
            <?php
			
include("apifolder/GrabzItClient.class.php");

$is_thumb_exist =  check_thumb_image_exists($userdetailcompare->campaign_main_page_url);
$img_src = base_url()."images/screenshots/".str_replace("YjMzMjFlZWY4Y2U4NDRhNWFmZWIxM2U5Nzc0YmNjNDQ=", "", $is_thumb_exist).".jpg";
	echo '<img  src="'.$img_src.'" width="200"  height="150" />';
?>
              	<!-- <img src="<?php echo base_url(); ?>images/RPA-keyword.gif" width="200" height="150" class="keyword-main-thumb" alt=""/> -->
                  <span>
                  	 <?php
echo '<a href="http://'.$userdetailcompare->campaign_main_page_url.'" target="_blank" >'.$userdetailcompare->campaign_main_page_url.'</a>';
?>
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
                        	<span class="blue-text" id="total-first"><?php print_r($keywordmain['keyword']); //stripslashes($campaign_detail[0]['campaign_main_keyword']);?></span><br>
		<span class="smalltext">(This is my most important KW)</span> 
	</td>
                      <td align="center">
                      	<button data-toggle="modal" data-target="#editkw" class="btn btn-primary" type="button">Edit Keyword</button>
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
                                          <td><input name="" type="text" id="entrkeywrdmain" value=""></td>
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
                                          <button type="button" class="btn btn-primary pull-left" onClick="validate();return false;">Save</button><div id="mainkeyresult"></div>
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
                        	<span class="textgrey" id="total-secondary"><?php echo $secondkeyword; ?></span><br>
		<span class="smalltext">(This is my most important KW)</span> 
	</td>
                      <td align="center">
                      	<button data-toggle="modal" data-target="#secondarykw" class="btn btn-blue-disable" type="button">Set Keyword</button>
                          <!-- Secondary keyword popup-->
                              <div class="modal fade text-left" id="secondarykw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header popup-header">
                                  <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                          <td><input type="checkbox" value='<?php echo stripslashes($kcpcData[$i]['0']); ?>'  onclick="mysecondFunction(this.value);" style="width:14px"></td>
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
						<?php
						$len ='';
						 if((sizeof($additionalkeywordloop)-1) >0){ $len = sizeof($additionalkeywordloop)-1; }
						?>
                        	<span  class="textgrey" id="total-supporting"><?php echo @$additionalkeywordloop[0]['keyword']; ?> + <?php echo $len; ?> more KWs</span><br>
		<span class="smalltext">(This is my most important KW)</span> 
	</td>
                      <td align="center">
                      	<button data-toggle="modal" data-target="#supportingkw" class="btn btn-blue-disable" type="button">Set Keyword</button>
                          <!-- supporting keyword popup-->
                              <div class="modal fade text-left" id="supportingkw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header popup-header">
                                  <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4 class="modal-title" id="myModalLabel">Supporting Keyword(S)</h4>
                                </div>
                                <div class="modal-body popupbody">
                                	
                                  <div class="modal-header kwhead">
                                  	<h2>What would you like to set as your supporting keyword?</h2>
                                      
                                  </div>
                                  <div class="enter-keyword">
                                  	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                        <tr>
                                          <td width="16%" valign="middle" class="valgn-middle">Enter Keyword:</td>
                                          <td><textarea style="width:100%" id="entrkeywrdthird"></textarea> </td>
                                          <td class="valgn-middle">Enter 1 keyword per line</td>
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
                          <td><input type="checkbox" value='<?php echo stripslashes($kcpcData[$i]['0']); ?>' id="chckkeyword" style="width:14px" onclick="myFunctionThird(this.value);"/></td>
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
	   <form name="launch" method="post" action="<?php base_url();?>launch">
      <!--Suggested Keywords-->
      <div class="howtolink-bld">
      	<h3>Link plan chosen: <img src="<?php echo base_url(); ?>images/pic7.png" width="12" height="16" alt=""/> <span class="blue-text">Bot Suggested Link Profile  (Auto Pilot)</span> <a href="<?php echo base_url();?>analyzecompare2/">Change/ Edit</a>   </h3>
          
         <div class="launch-comp-row anchorurl">
         		<div class="launch-comp-hader">
              	<span>Anchor Type / %</span>
                  <span style="width:32%">Anchor</span>
                  <span  style="width:35%">URL</span>
              </div>
			  <?php 
			  $exact=$related=$blended=$brand=$raw=$generic=array();
			  
			  foreach($analysisdata as $data){
			  if($link_profiile=='') $link_profiile = $data->link_profiile;
				if($data->match_type=="exact"){
					$exact[$data->count] = array(
													'id' => $data->id,
													'anchor' => $data->anchor,
													'url' => $data->url
												);
				}
				if($data->match_type=="related"){
					$related[$data->count] = array(
													'id' => $data->id,
													'anchor' => $data->anchor,
													'url' => $data->url
												);
				}
				if($data->match_type=="blended"){
					$blended[$data->count] = array(
													'id' => $data->id,
													'anchor' => $data->anchor,
													'url' => $data->url
												);
				}
				if($data->match_type=="brand"){
					$brand[$data->count] = array(
													'id' => $data->id,
													'anchor' => $data->anchor,
													'url' => $data->url
												);
				
				}
				if($data->match_type=="raw"){
					$raw[$data->count] = array(
													'id' => $data->id,
													'anchor' => $data->anchor,
													'url' => $data->url
												);
				
				}
				if($data->match_type=="generic"){
					$generic[$data->count] = array(
													'id' => $data->id,
													'anchor' => $data->anchor,
													'url' => $data->url
												);
				
				}
			  }
			  
			  $existingid = '';

			$arr['exact'] = 'Exact Match';
			  $arr['related'] = 'Related Kw';
			  $arr['blended'] = 'Blended Kw';
			  $arr['brand'] = 'Brand Kw';
			  $arr['raw'] = 'Raw URL';
			  $arr['generic'] = 'Generic';
			  
			   if(sizeof($exact)>0){ ?>
					<div class="eachrow">
					<div class="col-rightdynamic">
					
                  	<ul class="ancurl-fields" id="ancurl-fields-exact">
                    <?php foreach($exact as $count => $data){ 
					$existingid .= $data['id'].',';
					?>
						<li id="li<?php echo $data['id']; ?>">
                        	<span class="title"><?php echo $arr['exact']; ?> </span>
                      		<span  class="anchor-slid">
								<div id="avengeranalysis<?php echo $data['id']; ?>" class="avengeranalysis"></div>
								<input type="text" value="<?php echo $count; ?>" name="avengercnt<?php echo $data['id']; ?>" readonly id="avengeranalysis<?php echo $data['id']; ?>id">
							</span>
                              <span><input type="text" placeholder="" name="avengeranchor<?php echo $data['id']; ?>" value="<?php echo $data['anchor'];  ?>"></span>
                              <span><input type="text" placeholder="" name="avengerurl<?php echo $data['id']; ?>" value="<?php echo $data['url'];  ?>"></span>
                              <span class="adddel" style="width:auto !important"><a onclick="deleterow('li<?php echo $data['id']; ?>');"> <i class="fa fa-trash-o"></a></i></span>
                          </li>
                         <?php } ?>
                      </ul>
                      <a href="javascript:void(0)" class="addmore-btn pull-right" style="padding-right:52px" id="add_more_exact">+ Add more</a>
                  </div>
              </div>
			  <?php }
			
				if(sizeof($related)>0){ ?>
					<div class="eachrow">
					<div class="col-rightdynamic">
					
                  	<ul class="ancurl-fields" id="ancurl-fields-related">
                    <?php foreach($related as $count => $data){ 
					$existingid .= $data['id'].',';
					?>
						<li id="li<?php echo $data['id']; ?>">
                        	<span class="title"><?php echo $arr['related']; ?> </span>
                      		<span  class="anchor-slid">
								<div id="avengeranalysis<?php echo $data['id']; ?>" class="avengeranalysis"></div>
								<input type="text" value="<?php echo $count; ?>" name="avengercnt<?php echo $data['id']; ?>" readonly id="avengeranalysis<?php echo $data['id']; ?>id">
							</span>
                              <span><input type="text" placeholder="" name="avengeranchor<?php echo $data['id']; ?>" value="<?php echo $data['anchor'];  ?>"></span>
                              <span><input type="text" placeholder="" name="avengerurl<?php echo $data['id']; ?>" value="<?php echo $data['url'];  ?>"></span>
							  <span class="adddel" style="width:auto !important"><a onclick="deleterow('li<?php echo $data['id']; ?>');"> <i class="fa fa-trash-o"></a></i></span>
                          </li>
                         <?php } ?>
                      </ul>
                      <a href="javascript:void(0)" class="addmore-btn pull-right" style="padding-right:52px" id="add_more_related">+ Add more</a>
                  </div>
              </div>
			  <?php }
			  
			  if(sizeof($blended)>0){ ?>
					<div class="eachrow">
					<div class="col-rightdynamic">
					
                  	<ul class="ancurl-fields" id="ancurl-fields-blended">
                    <?php foreach($blended as $count => $data){ 
					$existingid .= $data['id'].',';
					?>
						<li id="li<?php echo $data['id']; ?>">
                        	<span class="title"><?php echo $arr['blended']; ?> </span>
                      		<span  class="anchor-slid">
								<div id="avengeranalysis<?php echo $data['id']; ?>" class="avengeranalysis"></div>
								<input type="text" value="<?php echo $count; ?>" name="avengercnt<?php echo $data['id']; ?>" readonly id="avengeranalysis<?php echo $data['id']; ?>id">
							</span>
                              <span><input type="text" placeholder="" name="avengeranchor<?php echo $data['id']; ?>" value="<?php echo $data['anchor'];  ?>"></span>
                              <span><input type="text" placeholder="" name="avengerurl<?php echo $data['id']; ?>" value="<?php echo $data['url'];  ?>"></span>
							  <span class="adddel" style="width:auto !important"><a onclick="deleterow('li<?php echo $data['id']; ?>');"> <i class="fa fa-trash-o"></a></i></span>
                          </li>
                         <?php } ?>
                      </ul>
                      <a href="javascript:void(0)" class="addmore-btn pull-right" style="padding-right:52px" id="add_more_blended">+ Add more</a>
                  </div>
              </div>
			  <?php }
			  
			  if(sizeof($brand)>0){ ?>
					<div class="eachrow">
					<div class="col-rightdynamic">
					
                  	<ul class="ancurl-fields" id="ancurl-fields-brand">
                    <?php foreach($brand as $count => $data){ 
					$existingid .= $data['id'].',';
					?>
						<li id="li<?php echo $data['id']; ?>">
                        	<span class="title"><?php echo $arr['brand']; ?> </span>
                      		<span  class="anchor-slid">
								<div id="avengeranalysis<?php echo $data['id']; ?>" class="avengeranalysis"></div>
								<input type="text" value="<?php echo $count; ?>" name="avengercnt<?php echo $data['id']; ?>" readonly id="avengeranalysis<?php echo $data['id']; ?>id">
							</span>
                              <span><input type="text" placeholder="" name="avengeranchor<?php echo $data['id']; ?>" value="<?php echo $data['anchor'];  ?>"></span>
                              <span><input type="text" placeholder="" name="avengerurl<?php echo $data['id']; ?>" value="<?php echo $data['url'];  ?>"></span>
							  <span class="adddel" style="width:auto !important"><a onclick="deleterow('li<?php echo $data['id']; ?>');"> <i class="fa fa-trash-o"></a></i></span>
                          </li>
                         <?php } ?>
                      </ul>
                      <a href="javascript:void(0)" class="addmore-btn pull-right" style="padding-right:52px" id="add_more_brand">+ Add more</a>
                  </div>
              </div>
			  <?php }

			  if(sizeof($raw)>0){ ?>
					<div class="eachrow">
					<div class="col-rightdynamic">
					
                  	<ul class="ancurl-fields" id="ancurl-fields-raw">
                    <?php foreach($raw as $count => $data){ 
					$existingid .= $data['id'].',';
					?>
						<li id="li<?php echo $data['id']; ?>">
                        	<span class="title"><?php echo $arr['raw']; ?> </span>
                      		<span  class="anchor-slid">
								<div id="avengeranalysis<?php echo $data['id']; ?>" class="avengeranalysis"></div>
								<input type="text" value="<?php echo $count; ?>" name="avengercnt<?php echo $data['id']; ?>" readonly id="avengeranalysis<?php echo $data['id']; ?>id">
							</span>
                              <span><input type="text" placeholder="" name="avengeranchor<?php echo $data['id']; ?>" value="<?php echo $data['anchor'];  ?>"></span>
                              <span><input type="text" placeholder="" name="avengerurl<?php echo $data['id']; ?>" value="<?php echo $data['url'];  ?>"></span>
							  <span class="adddel" style="width:auto !important"><a onclick="deleterow('li<?php echo $data['id']; ?>');"> <i class="fa fa-trash-o"></a></i></span>
                          </li>
                         <?php } ?>
                      </ul>
                      <a href="javascript:void(0)" class="addmore-btn pull-right" style="padding-right:52px" id="add_more_raw">+ Add more</a>
                  </div>
              </div>
			  <?php }
			  
			  if(sizeof($generic)>0){ ?>
					<div class="eachrow">
					<div class="col-rightdynamic">
					
                  	<ul class="ancurl-fields" id="ancurl-fields-generic">
                    <?php foreach($generic as $count => $data){ 
					$existingid .= $data['id'].',';
					?>
						<li id="li<?php echo $data['id']; ?>">
                        	<span class="title"><?php echo $arr['generic']; ?> </span>
                      		<span  class="anchor-slid">
								<div id="avengeranalysis<?php echo $data['id']; ?>" class="avengeranalysis"></div>
								<input type="text" value="<?php echo $count; ?>" name="avengercnt<?php echo $data['id']; ?>" readonly id="avengeranalysis<?php echo $data['id']; ?>id">
							</span>
                              <span><input type="text" placeholder="" name="avengeranchor<?php echo $data['id']; ?>" value="<?php echo $data['anchor'];  ?>"></span>
                              <span><input type="text" placeholder="" name="avengerurl<?php echo $data['id']; ?>" value="<?php echo $data['url'];  ?>"></span>
							  <span class="adddel" style="width:auto !important"><a onclick="deleterow('li<?php echo $data['id']; ?>');"> <i class="fa fa-trash-o"></a></i></span>
                          </li>
                         <?php } ?>
                      </ul>
                      <a href="javascript:void(0)" class="addmore-btn pull-right" style="padding-right:52px" id="add_more_generic">+ Add more</a>
                  </div>
              </div>
			  <?php }
				
			  ?>
              <div class="launch-comp-main">
              
              </div>
              <div class="clearfix"></div>
         </div>
         
         <input type="hidden" name="existingid" value="<?php echo $existingid; ?>" />
		 <input type="hidden" name="currentinc" id="currentinc" value="0" />
		 <input type="hidden" name="linkprofile" id="linkprofile" value="<?php echo $link_profiile; ?>" />
		 <input type="hidden" name="campaignid" value="<?php echo $userdetailcompare->id; ?>" />
		 
        
         <div class="launch-comp-row lv">
         		<h2>Link Velocity </h2>
              <p><input type="radio" value="more slowly" class="check" name="link_velocity" checked="checked">&nbsp;<img src="<?php echo base_url(); ?>images/pic7.png" width="12" height="16" alt=""/> Avenger Natural Link Velocity <span>(more slowly)</span> <!--<a href="">Change/ Edit</a>--></p>
              <span class="orgreymain">OR</span><br>
              <p><input type="radio" class="check" name="link_velocity"  value="faster" >&nbsp<img src="<?php echo base_url(); ?>images/pic7.png" width="12" height="16" alt=""/> Aggressive Link Velocity <span>(faster) </span> <!--<a href="">Change/ Edit</a>--></p>
			  <span class="orgreymain">OR</span><br>
              <p><input type="radio" class="check" name="link_velocity"  value="24hour" >&nbsp<img src="<?php echo base_url(); ?>images/pic7.png" width="12" height="16" alt=""/>  Build Links Immediately <span>(usually within 24 hours) </span> <!--<a href="">Change/ Edit</a>--></p>
         </div>
         
         <div class="launch-comp-row lv">
         		<h2>Quantity of Links </h2>
              <p><img src="<?php echo base_url(); ?>images/pic7.png" width="12" height="16" alt=""/> Unlimited Links:  Continually built until I rank</p>
              <div class="lvorsec">
              	<span class="greytxt">* Quantity of links is based on analysis of top 10 results for your main keyword.</span>
                  <div class="clearfix"></div>
                  <span class="orgreymain">OR</span>
                  <p>Set Maximum Number of Links to be built: </p>
                  <span>Do not build more than <input type="text" style="width:63px" name="num_links"> links.  </span>
              </div>
         </div>
		 
		 <div class="launch-comp-row lv">
         		<h2>Select Private Blog Network(s)</h2>
              <p><input type="checkbox" value="yes" class="check" name="serp_avenger_private_network" checked="checked">&nbsp;<img src="<?php echo base_url(); ?>images/pic7.png" width="12" height="16" alt=""/> Serp Avenger Private Network</span> <!--<a href="">Change/ Edit</a>--></p>
              <span class="orgreymain">OR/And</span><br>
              <p><img src="<?php echo base_url(); ?>images/pic7.png" width="12" height="16" alt=""/> select 1 or more of your own networks <!--<a href="">Change/ Edit</a>--></p>
			  <div class="serpAPRN" id="chk_box1">
            	<ul>
			  <?php 
			  
                     

			  foreach($user_networks as $networks){
						
						echo '<li><div class="serpAPRN"><input type="checkbox" name="networks[]" value="'.$networks->id.'" class="styled"><span>'.$networks->network_name.'</span></div></li>';
					}			  
			  
			  ?>
			  </ul></div>
         </div>
         
         <div class="launch-comp-row launchbtn">
         		<button type="submit" class="btn btn-primary">Launch!</button>
         </div>
         </form>
      <div class="clearfix"></div>
      </div>
      
</div>   


</div>
</div>
<?php $campaign_id = $userdetailcompare->id; ?>
<script src="<?php echo base_url();?>js/script.js"></script>  
<script type="text/javascript">
function myFunction(a) {
document.getElementById("entrkeywrdmain").value = a;
$("total-first").html(a);
//alert('I am here.');
}
function myFunctionThird(a)
{
    var p = $("#entrkeywrdthird").val();

    $("#entrkeywrdthird").val(p + "\n" + a);
    
    var xx = $("#entrkeywrdthird").val();
    
    //alert(xx);
    
    var selected = [];
    $('#supportingkw input:checked').each(function() {
        selected.push($(this).attr('name'));
    });
    
    var total_third = selected.length - 1;
    
    $("#total-supporting").html(selected[0] + " + " + total_third + " more KWs");
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
// $('#campaigntest1').html(selectedText);

}

});


}
</script>

<script type="text/javascript">
function mysecondFunction(a) {
document.getElementById("entrkeywrdsecond").value = a;
$("#total-secondary").html(a);
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
// $('#campaigntest1').html(selectedText);

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
selarr = selects.split('\n');
len = parseInt(selarr.length) -parseInt(2);

$("#total-supporting").html(selarr[1] + " + " + len + " more KWs");


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
//alert(row);
$('#thirdkeyresult').html(row);
$("#thirdclkboot" ).trigger("click");
// $('#campaigntest1').html(selectedText);

}

});


}
</script>
<script type="text/javascript">



$(window).load(function() {
$.noConflict();

$( ".avengeranalysis" ).slider({
 range: "min",
 min: 0,
 max: 100,
 create: function () {
	var id = $(this).attr("id");
	sliderval = $('#'+id+'id').val();
	$(this).slider( "option", "value", sliderval );
        }, 
 slide: function( event, ui ) {                 
     var id = $(this).attr("id");
	 curval = $('#'+id+'id').val();
	 //curval = parseFloat(curval.replace('%',''));
	 obj = $(this);
		total = 0;
		execeptcur =0;
		$('.ui-slider').each(function() {
		
			if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
			total = parseFloat(total) + parseFloat($(this).slider( "value" ));
			
		});
		
		if(ui.value > curval){
			if(total>99){ 
				slidval = parseFloat(100) - parseFloat(execeptcur);  
				console.log(slidval);
				if(slidval<0){ slidval=0;}
				//obj.slider( "value",slidval +'%');
				$('#'+id+'id').val(slidval);
				return false;
			} else {
				$('#'+id+'id').val(ui.value);
			}
		} else {
			$('#'+id+'id').val(ui.value);
		}
		
	 
        
 }
 });
 
var incid=0;

$("#add_more_exact").click(function() {
incid++;
divarr = $('<div>').attr('id', 'addnew_' + incid).slider({range: "min",
				value: 0,
				min: 0,
				max: 100,
				animate: true,
              slide: function( event, ui ) {
				     var id = $(this).attr("id");
					 curval = $('#'+id+'id').val();
					 //curval = parseFloat(curval.replace('%',''));
					 obj = $(this);
						total = 0;
						execeptcur =0;
						$('.ui-slider').each(function() {
						
							if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
							total = parseFloat(total) + parseFloat($(this).slider( "value" ));
							
						});
						
						if(ui.value > curval){
							if(total>99){ 
								slidval = parseFloat(100) - parseFloat(execeptcur);  
								console.log(slidval);
								if(slidval<0){ slidval=0;}
								//obj.slider( "value",slidval +'%');
								$('#'+id+'id').val(slidval);
								return false;
							} else {
								$('#'+id+'id').val(ui.value);
							}
						} else {
							$('#'+id+'id').val(ui.value);
						}
                //$('#addnew'+incid).val();
              }});
			  liid= 'new'+incid;
			  sliderinput = '<input type="text" id="addnew_'+incid+'id" readonly="" name="addnew_'+incid+'id" value="0"><input type="hidden" name="addtype'+incid+'" value="exact">';
appendata = "<li id='"+liid+"'><span class=\"title\">Exact Match</span>"+"<span  class=\"anchor-slid\" id='customid"+incid+"'></span>"+"<span><input name=\"anchornew"+incid+"\" type=\"text\" placeholder=\"\"></span>"+"<span><input type=\"text\" name=\"urlnew"+incid+"\" placeholder=\"\"></span>"+"<span class=\"adddel\">  <a onclick=\"deleterow('"+liid+"')\"><i class=\"fa fa-trash-o\"></a></i></span></li>"			  
$("#ancurl-fields-exact").append(appendata);
$("#customid"+incid).append(divarr);
$("#customid"+incid).append(sliderinput);
$('#currentinc').val(incid);
});

$("#add_more_related").click(function() {
incid++;
divarr = $('<div>').attr('id', 'addnew_' + incid).slider({range: "min",
				value: 0,
				min: 0,
				max: 100,
				animate: true,
              slide: function( event, ui ) {
                     var id = $(this).attr("id");
					 curval = $('#'+id+'id').val();
					 //curval = parseFloat(curval.replace('%',''));
					 obj = $(this);
						total = 0;
						execeptcur =0;
						$('.ui-slider').each(function() {
						
							if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
							total = parseFloat(total) + parseFloat($(this).slider( "value" ));
							
						});
						
						if(ui.value > curval){
							if(total>99){ 
								slidval = parseFloat(100) - parseFloat(execeptcur);  
								console.log(slidval);
								if(slidval<0){ slidval=0;}
								//obj.slider( "value",slidval +'%');
								$('#'+id+'id').val(slidval);
								return false;
							} else {
								$('#'+id+'id').val(ui.value);
							}
						} else {
							$('#'+id+'id').val(ui.value);
						}
              }});
			  liid= 'new'+incid;
			  sliderinput = '<input type="text" id="addnew_'+incid+'id" readonly="" name="addnew_'+incid+'id" value="0"><input type="hidden" name="addtype'+incid+'" value="related">';
appendata = "<li id='"+liid+"'><span class=\"title\">Related Kw</span>"+"<span  class=\"anchor-slid\" id='customid"+incid+"'></span>"+"<span><input name=\"anchornew"+incid+"\" type=\"text\" placeholder=\"\"></span>"+"<span><input type=\"text\" name=\"urlnew"+incid+"\" placeholder=\"\"></span>"+"<span class=\"adddel\"><a onclick=\"deleterow('"+liid+"')\"><i class=\"fa fa-trash-o\"></a></i></span></li>"			  
$("#ancurl-fields-related").append(appendata);
$("#customid"+incid).append(divarr);
$("#customid"+incid).append(sliderinput);
$('#currentinc').val(incid);
});


$("#add_more_blended").click(function() {
incid++;
divarr = $('<div>').attr('id', 'addnew_' + incid).slider({range: "min",
				value: 0,
				min: 0,
				max: 100,
				animate: true,
              slide: function( event, ui ) {
                     var id = $(this).attr("id");
					 curval = $('#'+id+'id').val();
					 //curval = parseFloat(curval.replace('%',''));
					 obj = $(this);
						total = 0;
						execeptcur =0;
						$('.ui-slider').each(function() {
						
							if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
							total = parseFloat(total) + parseFloat($(this).slider( "value" ));
							
						});
						
						if(ui.value > curval){
							if(total>99){ 
								slidval = parseFloat(100) - parseFloat(execeptcur);  
								console.log(slidval);
								if(slidval<0){ slidval=0;}
								//obj.slider( "value",slidval +'%');
								$('#'+id+'id').val(slidval);
								return false;
							} else {
								$('#'+id+'id').val(ui.value);
							}
						} else {
							$('#'+id+'id').val(ui.value);
						}
              }});
			  liid= 'new'+incid;
			  sliderinput = '<input type="text" id="addnew_'+incid+'id" readonly="" name="addnew_'+incid+'id" value="0"><input type="hidden" name="addtype'+incid+'" value="blended">';
appendata = "<li id='"+liid+"'><span class=\"title\">Blended Kw</span>"+"<span  class=\"anchor-slid\" id='customid"+incid+"'></span>"+"<span><input name=\"anchornew"+incid+"\" type=\"text\" placeholder=\"\"></span>"+"<span><input type=\"text\" name=\"urlnew"+incid+"\" placeholder=\"\"></span>"+"<span class=\"adddel\">  <a onclick=\"deleterow('"+liid+"')\"><i class=\"fa fa-trash-o\"></a></i></span></li>"			  
$("#ancurl-fields-blended").append(appendata);
$("#customid"+incid).append(divarr);
$("#customid"+incid).append(sliderinput);
$('#currentinc').val(incid);
});

$("#add_more_brand").click(function() {
incid++;
divarr = $('<div>').attr('id', 'addnew_' + incid).slider({range: "min",
				value: 0,
				min: 0,
				max: 100,
				animate: true,
              slide: function( event, ui ) {
                     var id = $(this).attr("id");
					 curval = $('#'+id+'id').val();
					 //curval = parseFloat(curval.replace('%',''));
					 obj = $(this);
						total = 0;
						execeptcur =0;
						$('.ui-slider').each(function() {
						
							if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
							total = parseFloat(total) + parseFloat($(this).slider( "value" ));
							
						});
						
						if(ui.value > curval){
							if(total>99){ 
								slidval = parseFloat(100) - parseFloat(execeptcur);  
								console.log(slidval);
								if(slidval<0){ slidval=0;}
								//obj.slider( "value",slidval +'%');
								$('#'+id+'id').val(slidval);
								return false;
							} else {
								$('#'+id+'id').val(ui.value);
							}
						} else {
							$('#'+id+'id').val(ui.value);
						}
              }});
			  liid= 'new'+incid;
			  sliderinput = '<input type="text" id="addnew_'+incid+'id" readonly="" name="addnew_'+incid+'id" value="0"><input type="hidden" name="addtype'+incid+'" value="brand">';
appendata = "<li id='"+liid+"'><span class=\"title\">Brand Kw</span>"+"<span  class=\"anchor-slid\" id='customid"+incid+"'></span>"+"<span><input name=\"anchornew"+incid+"\" type=\"text\" placeholder=\"\"></span>"+"<span><input type=\"text\" name=\"urlnew"+incid+"\" placeholder=\"\"></span>"+"<span class=\"adddel\">  <a onclick=\"deleterow('"+liid+"')\"><i class=\"fa fa-trash-o\"></a></i></span></li>"			  
$("#ancurl-fields-brand").append(appendata);
$("#customid"+incid).append(divarr);
$("#customid"+incid).append(sliderinput);
$('#currentinc').val(incid);
});

$("#add_more_raw").click(function() {
incid++;
divarr = $('<div>').attr('id', 'addnew_' + incid).slider({range: "min",
				value: 0,
				min: 0,
				max: 100,
				animate: true,
              slide: function( event, ui ) {
                     var id = $(this).attr("id");
					 curval = $('#'+id+'id').val();
					 //curval = parseFloat(curval.replace('%',''));
					 obj = $(this);
						total = 0;
						execeptcur =0;
						$('.ui-slider').each(function() {
						
							if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
							total = parseFloat(total) + parseFloat($(this).slider( "value" ));
							
						});
						
						if(ui.value > curval){
							if(total>99){ 
								slidval = parseFloat(100) - parseFloat(execeptcur);  
								console.log(slidval);
								if(slidval<0){ slidval=0;}
								//obj.slider( "value",slidval +'%');
								$('#'+id+'id').val(slidval);
								return false;
							} else {
								$('#'+id+'id').val(ui.value);
							}
						} else {
							$('#'+id+'id').val(ui.value);
						}
              }});
			  liid= 'new'+incid;
			  sliderinput = '<input type="text" id="addnew_'+incid+'id" readonly="" name="addnew_'+incid+'id" value="0"><input type="hidden" name="addtype'+incid+'" value="raw">';
appendata = "<li id='"+liid+"'><span class=\"title\">Raw URL</span>"+"<span  class=\"anchor-slid\" id='customid"+incid+"'></span>"+"<span><input name=\"anchornew"+incid+"\" type=\"text\" placeholder=\"\"></span>"+"<span><input type=\"text\" name=\"urlnew"+incid+"\" placeholder=\"\"></span>"+"<span class=\"adddel\">  <a onclick=\"deleterow('"+liid+"')\"><i class=\"fa fa-trash-o\"></a></i></span></li>"			  
$("#ancurl-fields-raw").append(appendata);
$("#customid"+incid).append(divarr);
$("#customid"+incid).append(sliderinput);
$('#currentinc').val(incid);
});

$("#add_more_generic").click(function() {
incid++;
divarr = $('<div>').attr('id', 'addnew_' + incid).slider({range: "min",
				value: 0,
				min: 0,
				max: 100,
				animate: true,
              slide: function( event, ui ) {
                     var id = $(this).attr("id");
					 curval = $('#'+id+'id').val();
					 //curval = parseFloat(curval.replace('%',''));
					 obj = $(this);
						total = 0;
						execeptcur =0;
						$('.ui-slider').each(function() {
						
							if(id!=$(this).attr("id")){ execeptcur = parseFloat(execeptcur) + parseFloat($(this).slider( "value" )); }
							total = parseFloat(total) + parseFloat($(this).slider( "value" ));
							
						});
						
						if(ui.value > curval){
							if(total>99){ 
								slidval = parseFloat(100) - parseFloat(execeptcur);  
								console.log(slidval);
								if(slidval<0){ slidval=0;}
								//obj.slider( "value",slidval +'%');
								$('#'+id+'id').val(slidval);
								return false;
							} else {
								$('#'+id+'id').val(ui.value);
							}
						} else {
							$('#'+id+'id').val(ui.value);
						}
              }});
			  liid= 'new'+incid;
			  sliderinput = '<input type="text" id="addnew_'+incid+'id" readonly="" name="addnew_'+incid+'id" value="0"><input type="hidden" name="addtype'+incid+'" value="generic">';
appendata = "<li id='"+liid+"'><span class=\"title\">Generic</span>"+"<span  class=\"anchor-slid\" id='customid"+incid+"'></span>"+"<span><input name=\"anchornew"+incid+"\" type=\"text\" placeholder=\"\"></span>"+"<span><input type=\"text\" name=\"urlnew"+incid+"\" placeholder=\"\"></span>"+"<span class=\"adddel\">  <a onclick=\"deleterow('"+liid+"')\"><i class=\"fa fa-trash-o\"></a></i></span></li>"			  
$("#ancurl-fields-generic").append(appendata);
$("#customid"+incid).append(divarr);
$("#customid"+incid).append(sliderinput);
$('#currentinc').val(incid);
});

});

</script>
<script type="text/javascript">
$(document).ready(function(){
$("#add_more2").click(function() {
$("#ancurl-fields2").append("<li><span><input type=\"text\" placeholder=\"Arora Locksmith\"></span>"+"<span><input type=\"text\" placeholder=\"http://denverlocksmith.com\"></span>"+
"<span class=\"adddel\">  <i class=\"fa fa-trash-o\"></i></span></li>");

});
});
function deleterow(id){
	$('#'+id).remove();
}
</script>

<script type="text/javascript">
$(document).ready(function(){
$("#add_more3").click(function() {
$("#ancurl-fields3").append("<li><span><input type=\"text\" placeholder=\"Arora Locksmith\"></span>"+"<span><input type=\"text\" placeholder=\"http://denverlocksmith.com\"></span>"+
"<span class=\"adddel\">  <i class=\"fa fa-trash-o\"></i></span></li>");

});
});

</script>
<script type="text/javascript">
$(document).ready(function(){
    
$(document).ready(function(){
$('#editkw input:checkbox').click(function(){
if ($(this).is(':checked') == true){
$('#editkw input:checkbox').prop('checked', false);
$(this).prop('checked', true);
}
});  

$('#secondarykw input:checkbox').click(function(){
if ($(this).is(':checked') == true){
$('#secondarykw input:checkbox').prop('checked', false);
$(this).prop('checked', true);
}
}); 
});

setTimeout(function(){
    $("#img1").attr("src", "<?php echo base_url()."images/screenshots/".$id1; ?>.jpg");
}, 10000);
  
});
</script>
