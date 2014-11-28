<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $page_title;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/styles.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/reset.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/screen.css" media="all" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/toggles.css" media="all" />

<!--[if lt IE 9 ]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
<!--[if lte IE 7]><script src="js/lte-ie7.js"></script><![endif]-->
</head>
<body>
<div id="path_url" style="display:none;"><?php echo base_url()?></div>
<section class="page clearfix">
<?php $this->load->view('frontend/header');?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/tinymce/tinymce.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/main.js"></script>



<!--<script type="text/javascript" src="<?php //echo base_url();?>assets/js/script.js"></script>-->
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />-->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

  <script>
  var tooltipCount=1;
 function sliders(id,min_val,max_val,input_id,first_value, idPrefix) {  
	//var first_value=0;
	  	console.log(idPrefix === undefined);
		if(idPrefix === undefined){
			idPrefix=1;
		}
	    $('#tooltip'+tooltipCount).remove();
		$( "input#"+input_id ).val(''); 
	var tooltip = $('<div id="tooltip'+idPrefix+id+'" class="tooltip">'+first_value+'</div>').css({
		position: 'absolute',
		top: -19,
		left: -7
		}).show();
		
		//$(".rslider"+id).slider({
		$("#"+idPrefix+id).slider({
		animate: true,
		range: "min",
		value: $('input#'+input_id).val(),
		min: min_val, //0
		max: max_val, //68
		slide: function(event, ui) {
		//	updateSliderValue("rslider");
			
		tooltip.text(ui.value);
		$( "input#"+input_id ).html( ui.value );
		},
		change: function(event, ui) {
		$('input#'+input_id).attr('value', ui.value);}
		}).find(".ui-slider-handle").append(tooltip);
		tooltipCount++;
  }
  
   function slidersFooter(id,min_val,max_val,input_id,first_value) {  
	//var first_value=0;
	  
	    $('#tooltip'+id).remove();
		$( "input#"+input_id ).val(''); 
	var tooltip = $('<div id="tooltip'+id+'">'+first_value+'</div>').css({
		position: 'absolute',
		top: -19,
		left: -7
		}).show();
		
		//$(".rslider"+id).slider({
		$(".rslider"+id).slider({
		animate: true,
		range: "min",
		value: $('input#'+input_id).val(),
		min: min_val, //0
		max: max_val, //68
		slide: function(event, ui) {
			//updateSliderValue("rslider")
		tooltip.text(ui.value);
		$( "input#"+input_id ).html( ui.value );
		},
		change: function(event, ui) {
		$('input#'+input_id).attr('value', ui.value);}
		}).find(".ui-slider-handle").append(tooltip);
  }
  
  function updateSliderValue(m){
  	var h=$('.'+m+1).text();
	console.log("ccc >> "+h);
  }
  function slidersold(id,min_val,max_val,input_id,first_value, idPrefix) {  
	//var first_value=0;
	  	console.log(idPrefix === undefined);
		if(idPrefix === undefined){
			idPrefix=1;
		}
	    $('#tooltip'+tooltipCount).remove();
		$( "input#"+input_id ).val(''); 
	var tooltip = $('<div id="tooltip'+tooltipCount+'">'+first_value+'</div>').css({
		position: 'absolute',
		top: -19,
		left: -7
		}).show();
		
		
		$("#"+idPrefix+id).slider({
		animate: true,
		range: "min",
		value: $('input#'+input_id).val(),
		min: min_val, //0
		max: max_val, //68
		slide: function(event, ui) {
		//	updateSliderValue("rslider");
			
		tooltip.text(ui.value);
		$( "input#"+input_id ).html( ui.value );
		},
		change: function(event, ui) {
		$('input#'+input_id).attr('value', ui.value);}
		}).find(".ui-slider-handle").append(tooltip);
		tooltipCount++;
  }
  </script>
  <style type="text/css">
.file-upload {
position: relative;
overflow: hidden;
margin: 10px;
}

.btn {
color: #666666 !important;
display: inline-block;
font-weight: normal;
text-align: center;
vertical-align: middle;
cursor: pointer;
background-image: none;
border: 1px solid transparent;
white-space: nowrap;
padding: 6px 12px;
font-size: 14px;
line-height: 1.42857143;
border-radius: 4px;
}

.btn-primary {
color: #fff;
background: #eeeeee; /* Old browsers */
/* IE9 SVG, needs conditional override of 'filter' to 'none' */
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2VlZWVlZSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNjY2NjY2MiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  #eeeeee 0%, #cccccc 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#eeeeee), color-stop(100%,#cccccc)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* IE10+ */
background: linear-gradient(to bottom,  #eeeeee 0%,#cccccc 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=0 ); /* IE6-8 */

border-color: #999;
}

.file-upload input.upload {
position: absolute;
top: 0;
right: 0;
margin: 0;
padding: 0;
font-size: 20px;
cursor: pointer;
opacity: 0;
filter: alpha(opacity=0);
}

</style>


  <section class="main">
    <section class="mainContent clearfix">
      <aside class="mainLeft">
        <div class="sideMenuTitle">My Panel</div>
        <?php $this->load->view('frontend/left_menu');?>
      </aside>
      <article class="mainRight">
		 <?php $this->load->view('frontend/main_menu');?>
        <section class="mainContainerSec">
			<div class="submitter">
            	<div class="sub_top">
                	<button class="one">
                    	<p>New Submission</p>
                        <span>Create New Submission</span>
                    </button>
                	<a href="<?php echo base_url()?>activesubmissions"><button class="one two">
                    	<p>Active Submissions</p>
                        <span>View/ Edit Submissions</span>
                    </button></a>
                    <a href="<?php echo base_url()?>completedsubmissions">
                	<button class="one three">
                    	<p>Completed Submissions</p>
                        <span>View or Edit Submissions</span>
                    </button></a>
                </div>
                
                <div class="sub_buttom">
                	<div class="content_titel clearfix"><h2>Content Wizard / Submission</h2><span class="help"><img alt="no img" src="<?php echo base_url()?>assets/images/img2.png"></span></div>
                    <?php

	//lets have the flashdata overright "$message" if it exists
	if($this->session->flashdata('message'))
		{
			$message	= $this->session->flashdata('message');
		}
	
	if($this->session->flashdata('error'))
		{
			$error	= $this->session->flashdata('error');
		}
	
	if(function_exists('validation_errors') && validation_errors() != '')
		{
			$error	= validation_errors();
		}
	?>
    	<?php if (!empty($message)): ?>
		
			<?php //echo $message; ?>
	
	<?php endif; ?>

	<?php if (!empty($error)): ?>
		
			<div class="notification note-error">
				<a title="Close notification" class="close" href="#">close</a>
				<?php echo $error; ?>
			</div>
	
	<?php endif; ?>

                    <?php if ($this->session->flashdata('message')):?>
				<?php echo $this->session->flashdata('message');?>
			     <?php endif;?>
                    <form name="" method="post" action="<?php echo base_url()?>scrapper/form" enctype="multipart/form-data">
                    <input type="hidden" name="min_qty1" id="min_qty1" value="1">
                    <input type="hidden" name="min_qty_rr1" id="min_qty_rr1" value="1">
                    <input type="hidden" name="min_qty_rrr1" id="min_qty_rrr1" value="1">
                    <input type="hidden" name="serp_comm" id="serp_comm" value="">
                    <div class="submitter_inner">
                    	<div class="part1 clearfix">
                        	<h3>Select Network(s) to Post to:</h3>
                            <h3>0 Domains Selected</h3>
                            <div class="toggle_arrow"></div>
                        </div>
                       
                    	<div class="part2 clearfix">
                        	<div class="clearfix"><input type="checkbox" id="select_all" name="selectAll" value=""/><h3>SERP Avenger <span>PR Network</span></h3></div>
                            <div id="chk_box1">
                            <?php //echo '<pre>'; print_r($networks); die;?>
                            <?php foreach($networks as $network){?>
                                <div class="chbox"><input type="checkbox" name="networks[]" value="<?php echo $network->id;?>"><label><?php echo $network->network_name;?></label></div>
                                <?php } ?>                                
                             </div>
                        </div>
                         <?php //echo '<pre>'; print_r($campaign_list); die;?>
                        <div class="part3 clearfix">
                        	<h3>Save Project As:</h3>
                            <input type="text" name="project_name" value="" placeholder="Save As (Name this project)" class="required">
                            <div class="drop1">
                            
                                <select name="campaign">
                                    <option value="">Attach to Campaign (optional)</option>
                                    <?php //foreach($campaigns as $campaign){?>
                                   <!-- <option value="<?php echo $campaign->campaign_id;?>"><?php echo $campaign->project_name;?></option>-->
                                    <?php //} ?>
                                    <?php
										if(is_array($campaign_list) && count($campaign_list) > 0){
											for($i=0; $i<count($campaign_list); $i++){
										?>
												<option value="<?php echo stripslashes($campaign_list[$i]['campaign_id']);?>" <?php if($cid == $campaign_list[$i]['campaign_id']){echo 'selected';}?>><?php echo stripslashes($campaign_list[$i]['campaign_title']);?></option>
										<?php
												if(is_array($campaign_list[$i]['campaign']) && count($campaign_list[$i]['campaign']) > 0){
													for($j=0; $j<count($campaign_list[$i]['campaign']); $j++){
														
													if(isset($campaign_list[$i]['campaign'][$j]['keyword'])) { ?>
														<option value="<?php echo $campaign_list[$i]['campaign'][$j]['keyword_id'] . '-' . $campaign_list[$i]['campaign'][$j]['campaign_id'];?>"><?php echo '----' . stripslashes($campaign_list[$i]['campaign'][$j]['keyword']); ?></option>
										<?php }}}}} ?>
                                </select>
                            </div>
                        </div>
                        <div class="part4 clearfix">
                        	<h3>Post / Article Submission</h3>
                        </div>
                        <div class="part5 clearfix">
                            <p>Would you like to add your own content or have SERP Avenger create unique content for you?</p>
                            <div class="part5_1 clearfix">
                            	<div class="left clearfix">
                                	<input type="checkbox" name="spin_type[]" checked="checked" value="manually"><h3>Manually Add Content Below  <span>(Spintax accepted)</span></h3>
                                    <p>Accepted Spintax format: {Spintax|Spin|Spinning}</p>
                                </div>
                                <div class="right clearfix">
                                	<input type="checkbox" name="spin_type[]" value="smart_content"><h3>Use SERP Avenger Smart Content!<br> <span>(Unique & Relevant)</span></h3>
                                    <p>Take a break; we’ll create the content for you.</p>
                                </div>
                            </div>
                            <div id="spin_area_manually">
                            <div class="part5_1 clearfix">
                            	<div class="part5_2 clearfix">
                                	<label>Title:</label>
                                    <span id="valid-title">Correct Spintax Detected</span>
                                </div>
                                <input type="text" name="post_title" value="">
                            	<div class="part5_2 clearfix" >
                                	<label>Post:</label>
                                    <span id="valid-post">Correct Spintax Detected</span>
                                </div>
                            </div>
                            <textarea name="post_content" style="width:100%; height:300px;"></textarea>
                            <!--<img src="<?php echo base_url()?>assets/images/pic10.png" alt="no img"/>-->
                            
                            </div>
                            <div id="spin_area_smart" style="display:none;">
                            <p>Ok, great in order to create content we will need some information about your project and subject matter.</p>
                            <div class="part6_7 clearfix">
                            	<div class="link_anchor">SERP Avenger Smart Content <span class="help"><img alt="no img" src="<?php echo base_url()?>assets/images/img2.png"></span></div>
                                <b>Help us learn more about the type of content needed for this project by answering the following: </b>
                                <b>What are the General Topics or Categories?</b>
                                <p>IE: Weight loss, diet, exercise, nutrition, etc.</p>
                                <input type="text" name="smart_content_topics" value="" placeholder="Enter several generic relevant topics. (Separated by commas)">
                                <b>What specific keywords will be used as anchors?</b>
                                <p>IE: acai berry, acai berry diet,  buy acai berries, etc.</p>
                                <input type="text" name="smart_content_keywords" value="" placeholder="Enter your exact keywords or phrases. (separated by commas)">
                                <b>List any synonyms that could be used be replaced by your keywords.</b>
                                <p>IE: diet pills, antioxidant, purple fruit, anthocyanins, superfoods, etc.</p>
                                <input type="text" name="smart_content_synonyms" value="" placeholder="Enter as many synonyms that could be substituted by your keywords  (separated by commas)">
                            </div>

                            </div>
                            <div class="part5_3 clearfix">
                            	<h3># ofSubmissions:</h3><input type="text" value="" name="submission_num" placeholder="Enter Number">
                            </div>
                            <div class="part6">

                            	<div class="part6_1 clearfix">

                                	<div class="on_off"><!--<img src="<?php echo base_url()?>assets/images/pic13.png" alt="no img"/>-->
                                    
                                    <div class="toggle-light examples serp_formats">
<div class="toggle on"><div class="toggle-slide"><div style="width: 118px; margin-left: 0px;" class="toggle-inner"><div style="height: 22px; width: 59px; text-indent: -11px; line-height: 22px;" class="toggle-on active">ON</div><div style="height: 22px; width: 22px; margin-left: -11px;" class="toggle-blob"></div><div style="height: 22px; width: 59px; margin-left: -11px; text-indent: 11px; line-height: 22px;" class="toggle-off">OFF</div></div></div>
</div><input type="hidden" name="serp_format" id="serp_format" value="on">
                                    
                                    </div>

                                	<h3>SERP Avenger Professional Formatting</h3>

                                    <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"/></span>

                                </div>

                            </div>
								<p>Formats post to use: sub-headlines, bullet points, bold, italics, etc.</p>
                                  <h3>Blog+ Options:<span><span id="num_blog">72</span> Blog+ Domains Available for this submission</span></h3>
                            <div class="part6">

                            	
                            	<div class="part6_1 clearfix">

                                	<div class="on_off"><!--<img src="<?php echo base_url()?>assets/images/pic15.png" alt="no img"/>-->
                                    
                                    
                                    <div class="toggle-light examples serp_comments">
<div class="toggle"><div class="toggle-slide"><div style="width: 118px; margin-left: 0px;" class="toggle-inner"><div style="height: 22px; width: 59px; text-indent: -11px; line-height: 22px;" class="toggle-on active">ON</div><div style="height: 22px; width: 22px; margin-left: -11px;" class="toggle-blob"></div><div style="height: 22px; width: 59px; margin-left: -11px; text-indent: 11px; line-height: 22px;" class="toggle-off">OFF</div></div></div>
</div><input type="hidden" name="serp_comment" id="serp_comment" value="off">
                                    
                                    </div>

                                	<h3>SERP Avenger Comment Seeding</h3>

                                    <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"/></span>

                                </div>

                            	
                            </div>
   								<p>Adds relatedLSI  comments to posts to boost crawl rates.</p>
                                <div class="chkbox1 clearfix">

                                <input type="radio" id="radio-1-2" name="comment_seeding" class="regular-checkbox" value="Blended" /><label for="radio-1-2"></label>

                                    <span><b>Blended:</b> Used both types of comment seeding.</span>

                                </div>

                                <div class="button-holder clearfix">
                                <input type="radio" id="radio-1-4" name="comment_seeding" class="regular-checkbox" value="Viral" /><label for="radio-1-4"></label>

                                    <span><b>Viral Post:</b> Most comments added while on homepage.</span>

                                </div>

                                <div class="button-holder clearfix">
								<input type="radio" id="radio-1-5" name="comment_seeding" class="regular-checkbox" value="Natural" /><label for="radio-1-5"></label>

                                    <span><b>Natural Post:</b> Comments spaced out over time.</span>

                                </div>

                                <div class="file clearfix">
                                <div class="input_file file-upload btn btn-primary"><span>Upload Comment File</span><br> <input class="upload" id="uploadBtn" name="comment_file" type="file"></div>
                               
                                	<!--<button class="input_file" name="comment_file">Upload Comment File</button>-->

                                    <div class="clearfix"><input type="checkbox" value="yes" name="unique_comments"><h3>Have SERP Avenger create unique comments for me.</h3><div id="unique_key"></div></div>

                                </div>

                                <a href="#" class="see">See Requirements</a>

                            <div class="part6 second-anchor">

                            	<div class="link_anchor">Links & Anchors</div>

                                <h4 class="no1">How Should Links be Added to Your Posts?</h4>

                                <div class="part6_2">

                                    <div class="button-holder clearfix">

                                       <!-- <input type="radio" id="radio-1-6" name="link_identifier" class="regular-radio" checked /><label for="radio-1-6"></label>-->
                                        <input type="checkbox" id="checkbox-1-6" name="link_identifier" class="regular-checkbox" checked /><label for="checkbox-1-6"></label>

                                        <span><b>Link Identifiers:</b> I have link identifiers in my content.  (Up to 3 per post:  %link1%   %link2%  %link3%) </span>

                                    </div>

                                	<div class="chkbox1 clearfix">

                                     	<input type="checkbox" id="checkbox-1-3" class="regular-checkbox" name="keyword_replace" /><label for="checkbox-1-3"></label>

                                        <span><b>Keyword Replace:</b> Find and replacekeywords or synonyms</span>

                                    </div>
                                    <a href="#" class="see">See Requirements</a>
                                </div>
                                <h4 class="no2">What Anchors Should Be Used?</h4>
                                <div id="table1">
								<table id="r">
                                <tbody>
                                  <tr><td>
                                        <div class="part6_3 clearfix">
                                            <div class="anchor"><img src="<?php echo base_url()?>assets/images/pic24.png" alt="no img"/></div>
                                            <label>Anchor 1a:</label>
                                            <div class="part6_5 clearfix">
                                                <div class="chkbox3 clearfix">
                                                    <input type="radio" name="anchor_set1" value="Keyword"><span>Keyword</span>
                                                    <input type="radio" name="anchor_set1" value="Brand"><span>Brand</span>
                                                    <input type="radio" name="anchor_set1" value="Raw URL"><span>Raw URL</span>
                                                    <input type="radio" name="anchor_set1" value="Generic"><span>Generic</span>
                                                </div>
                                             </div>
                                             <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"></span>
                                             <span class="qty">Quantity</span>
                                             <div class="rating"><!--<img alt="no img" src="<?php echo base_url()?>assets/images/pic25.png">-->
                                             <div class="change_color">
                                                  <div class="range_slider" style="padding:13px 0 0 0;">
                                                   <div class="rslider1" style="width:100px; margin:2px 0 0 0;" id="r1"></div>
                                                       <input type="hidden" id="qty1" value="0" name="qty1"/>
                                                   </div> 
                                                  </div>
                                             </div>
                                            
                                             
                                             </div>
                                        
                                            
                                        <div class="part6_4">
                                            <input type="text" name="anchor1" value="" placeholder="Enter Anchor (Spintax Accepted)">
                                            
                                            <div class="help_box2 clearfix" style="display:none;">
                                            <h4 class="no2">Please provied All synonyms That Could be replaced by your keyword.(Optional):</h4>
                                    	    <input type="text" name="synonyms[]" value="" placeholder="Enter synonyms or words that could be replaced by your keyword anchors. (I.E. hair loss, rogain, baldness)">
                                            </div>
                                            
                                            
                                            <h4 class="no3">Link/ URL 1a:</h4>
                                            <input type="text" name="link1" value="" placeholder="Enter URL including http://">                                   
                                         </div>
                                         <!--<div class="every_remove"><a href="javascript:void(0)">- Remove</a></div>-->
                                   </td></tr>
                                   </tbody>
                                   </table>
                                   
                                <div class="part5_2 clearfix">
                                    <a href="javascript:void(0)" id="add_anchor1">+ New Anchor/ Link</a><a href="javascript:void(0)" id="second_anchor">+ Second Anchor/ Link to Same Post</a>
                                    <span>Correct Spintax Detected</span>
                                </div>
                                </div>

                                <div id="table2" style="display:none;">
								<table id="rr">
                                <tbody>
                                  <tr><td>
                                        <div class="part6_3 clearfix">
                                            <div class="anchor"><img src="<?php echo base_url()?>assets/images/pic24.png" alt="no img"/></div>
                                            <label>Anchor 2a:</label>
                                            <div class="part6_5 clearfix">
                                                <div class="chkbox3 clearfix">
                                                    <input type="radio" name="anchor_set_rr1" value="Keyword"><span>Keyword</span>
                                                    <input type="radio" name="anchor_set_rr1" value="Brand"><span>Brand</span>
                                                    <input type="radio" name="anchor_set_rr1" value="Raw URL"><span>Raw URL</span>
                                                    <input type="radio" name="anchor_set_rr1" value="Generic"><span>Generic</span>
                                                </div>
                                             </div>
                                             <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"></span>
                                             <span class="qty">Quantity</span>
                                             <div class="rating"><!--<img alt="no img" src="<?php echo base_url()?>assets/images/pic25.png">-->
                                             <div class="change_color">
                                                  <div class="range_slider" style="padding:13px 0 0 0;">
                                                   <div class="rslider1" style="width:100px; margin:2px 0 0 0;" id="rr1"></div>
                                                       <input type="hidden" id="qty_rr1" value="0" name="qty_rr1"/>
                                                   </div> 
                                                  </div>
                                             </div>
                                             </div>
                                        
                                            
                                        <div class="part6_4">
                                            <input type="text" name="anchor_rr1" value="" placeholder="Enter Anchor (Spintax Accepted)">
                                            
                                            <div class="help_box2 clearfix" style="display:none;">
                                            <h4 class="no2">Please provied All synonyms That Could be replaced by your keyword.(Optional):</h4>
                                    	    <input type="text" name="synonyms_rr[]" value="" placeholder="Enter synonyms or words that could be replaced by your keyword anchors. (I.E. hair loss, rogain, baldness)">
                                            </div>
                                            
                                            
                                            <h4 class="no3">Link/ URL 2a:</h4>
                                            <input type="text" name="link_rr1" value="" placeholder="Enter URL including http://">                                   
                                         </div>
                                         <!--<div class="every_remove"><a href="javascript:void(0)">- Remove</a></div>-->
                                   </td></tr>
                                   </tbody>
                                   </table>
                                   <div class="part5_2 clearfix">
                                    <a href="javascript:void(0)" id="add_anchor2">+ New Anchor/ Link</a><a href="javascript:void(0)" id="third_anchor">+ Third Anchor/ Link to Same Post</a>
                                    <span>Correct Spintax Detected</span>
                                </div>
                               </div>

                                <div id="table3" style="display:none;">
								<table id="rrr">
                                <tbody>
                                  <tr><td>
                                        <div class="part6_3 clearfix">
                                            <div class="anchor"><img src="<?php echo base_url()?>assets/images/pic24.png" alt="no img"/></div>
                                            <label>Anchor 3a:</label>
                                            <div class="part6_5 clearfix">
                                                <div class="chkbox3 clearfix">
                                                    <input type="radio" name="anchor_set_rrr1" value="Keyword"><span>Keyword</span>
                                                    <input type="radio" name="anchor_set_rrr1" value="Brand"><span>Brand</span>
                                                    <input type="radio" name="anchor_set_rrr1" value="Raw URL"><span>Raw URL</span>
                                                    <input type="radio" name="anchor_set_rrr1" value="Generic"><span>Generic</span>
                                                </div>
                                             </div>
                                             <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"></span>
                                             <span class="qty">Quantity</span>
                                             <div class="rating"><!--<img alt="no img" src="<?php echo base_url()?>assets/images/pic25.png">-->
                                             <div class="change_color">
                                                  <div class="range_slider" style="padding:13px 0 0 0;">
                                                   <div class="rslider1" style="width:100px; margin:2px 0 0 0;" id="rrr1"></div>
                                                       <input type="hidden" id="qty_rrr1" value="0" name="qty_rrr1"/>
                                                   </div> 
                                                  </div>
                                             </div>
                                             </div>
                                        <div class="part6_4">
                                            <input type="text" name="anchor_rrr1" value="" placeholder="Enter Anchor (Spintax Accepted)">
                                            <div class="help_box2 clearfix" style="display:none;">
                                            <h4 class="no2">Please provied All synonyms That Could be replaced by your keyword.(Optional):</h4>
                                    	    <input type="text" name="synonyms_rrr[]" value="" placeholder="Enter synonyms or words that could be replaced by your keyword anchors. (I.E. hair loss, rogain, baldness)">
                                            </div>
                                            
                                            
                                            <h4 class="no3">Link/ URL 3a:</h4>
                                            <input type="text" name="link_rrr1" value="" placeholder="Enter URL including http://">                                   
                                         </div>
                                         <!--<div class="every_remove"><a href="javascript:void(0)">- Remove</a></div>-->
                                   </td></tr>
                                   </tbody>
                                   </table>
                                   <div class="part5_2 clearfix">
                                    <a href="javascript:void(0)" id="add_anchor3">+ New Anchor/ Link</a>
                                    <span>Correct Spintax Detected</span>
                                </div>
                               </div>
                            </div>
                            <div class="part6">
                            	<div class="link_anchor">Schedule and Settings</div>
                                <h4 class="no4">Select or Change Any Submission Settings:</h4>
                                <div class="part6_5 clearfix">
                                	<div class="chkbox3 clearfix"><input type="radio" name="submission" value="unique_domains" checked><span>Unique Domains:  First, skip domains previously posted to.</span><br> </div>
                                	<div class="chkbox3 clearfix"><input type="radio" name="submission" value="never_repeated"><span>Never Repeated: Never post to a domain that has been previously posted to.</span></div>
                                    <b>Favor Preference:</b>
                                    <div class="chkbox3 clearfix">
                                    	<input type="radio" name="favor_preference" value="Random Mix" checked><span>Random Mix</span>
                                    	<input type="radio" name="favor_preference" value="Highest Pagerank First"><span>Highest Pagerank First</span>
                                    	<input type="radio" name="favor_preference" value="Unique IP First"><span>Unique IP First</span>
                                    	<input type="radio" name="favor_preference" value="Oldest Domains First"><span>Oldest Domains First</span>
                                    </div>
                                </div>
                                <h4 class="no5">Schedule & Drip Rate</h4>
                            	<div class="part6_5 clearfix">
                                    <div class="chkbox3 clearfix" id="start_timing">
                                    	<input type="radio" name="schedule" value="now" checked><span>Start Now</span>
                                    	<input type="radio" name="schedule" value="later"><span>Select Start Date</span>
                                        <div class="cal"><input type="text" name="start_date" id="datepicker" value="" readonly /></div>                                    </div>
                                    <b>Drip Rate:</b>
                                    <div class="chkbox3 clearfix">
                                    	<input type="radio" name="drip_rate" value="Custom Range"><span>Custom Range: </span>
                                        <input type="text" name="num_post" value="" placeholder="# of Posts"/><span>Per </span>
                                        <select name="postings">
                                        	<option value="day">Day</option>
                                        	<option value="weeks">weeks</option>
                                        	<option value="months">months</option>
                                        </select>
                                    </div>
                                    <div class="chkbox3 clearfix">
                                    	<div class="chkbox3 clearfix"><input type="radio" name="drip_rate" value="Viral Linking"><span>Viral Linking:  <em>Spike in week 1, then trickle.</em></span></div>
                                    	<div class="chkbox3 clearfix"><input type="radio" name="drip_rate" value="Mini Spikes"><span>Mini Spikes:  <em>Mini spike in links every 7 to 10 days.</em> </span></div>
                                    	<div class="chkbox3 clearfix"><input type="radio" name="drip_rate" value="24 Hours" checked><span>Post All Within 24 Hours</span></div>
                                    </div>
                                    <div class="part6_6 clearfix">
                                        <input type="submit" name="submit" value="submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </section>
      </article>
    </section>
  </section>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/toggles-min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/toggles.js"></script>
<?php $this->load->view('frontend/footer');?>
