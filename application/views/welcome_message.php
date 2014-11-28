<!doctype html>

<html>

<head>

<meta charset="utf-8">

<title>SERP Avenger</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/styles.css" media="all" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/reset.css" media="all" />



<!--[if lt IE 9 ]>

<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

<![endif]-->



<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->

<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->

<!--[if lte IE 7]><script src="js/lte-ie7.js"></script><![endif]-->

</head>



<body>

<section class="page clearfix">
<?php $this->load->view('frontend/header');?>
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
                	<button class="one two">
                    	<p>Active Submissions</p>
                        <span>View/ Edit Submissions</span>
                    </button>
                	<button class="one three">
                    	<p>Completed Submissions</p>
                        <span>View or Edit Submissions</span>
                    </button>
                </div>
                <div class="sub_buttom">
                	<div class="content_titel clearfix"><h2>Content Wizard / Submission</h2><span class="help"><img alt="no img" src="<?php echo base_url()?>assets/images/img2.png"></span></div>
                    <div class="submitter_inner">
                    	<div class="part1 clearfix">
                        	<h3>Select Network(s) to Post to:</h3>
                            <h3>125 Domains Selected</h3>
                            <div class="toggle_arrow"></div>
                        </div>
                    	<div class="part2 clearfix">
                        	<div class="clearfix"><input type="checkbox" name="" value=""><h3>SERP Avenger <span>PR Network</span></h3></div>

                            <div class="chbox"><input type="checkbox" name="" value=""><label>General PR Network</label></div>

                            <div class="chbox"><input type="checkbox" name="" value=""><label>Local California Clients</label></div>

                            <div class="chbox"><input type="checkbox" name="" value=""><label>Bing ONLY Network</label></div>

                            <div class="chbox"><input type="checkbox" name="" value=""><label>Denver Lock Network</label></div>

                            <div class="chbox"><input type="checkbox" name="" value=""><label>5+ High PR Network</label></div>

                            <div class="chbox"><input type="checkbox" name="" value=""><label>Aged Network</label></div>

                            <div class="chbox"><input type="checkbox" name="" value=""><label>Indexer Network</label></div>

                            <div class="chbox"><input type="checkbox" name="" value=""><label>Radio Works Network</label></div>
                        </div>
                        <div class="part3 clearfix">
                        	<h3>Save Project As:</h3>
                            <input type="text" name="" value="Save As (Name this project)">
                            <div class="drop1">
                                <select>
                                    <option>Attach to Campaign (optional)</option>
                                    <option></option>
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
                                	<input type="checkbox" value="" name=""><h3>Manually Add Content Below  <span>(Spintax accepted)</span></h3>
                                    <p>Accepted Spintax format: {Spintax|Spin|Spinning}</p>
                                </div>
                                <div class="right clearfix">
                                	<input type="checkbox" value="" name=""><h3>Use SERP Avenger Smart Content!<br> <span>(Unique & Relevant)</span></h3>
                                    <p>Take a break; we’ll create the content for you.</p>

                                </div>

                            </div>

                            <p>Ok, great in order to create content we will need some information about your project and subject matter.</p>

                            <div class="part6_7 clearfix">

                            	<div class="link_anchor">SERP Avenger Smart Content <span class="help"><img alt="no img" src="<?php echo base_url()?>assets/images/img2.png"></span></div>

                                <b>Help us learn more about the type of content needed for this project by answering the following: </b>

                                <b>What are the General Topics or Categories?</b>

                                <p>IE: Weight loss, diet, exercise, nutrition, etc.</p>

                                <input type="text" name="" value="Enter several generic relevant topics. (Separated by commas)">

                                <b>What specific keywords will be used as anchors?</b>

                                <p>IE: acai berry, acai berry diet,  buy acai berries, etc.</p>

                                <input type="text" name="" value="Enter your exact keywords or phrases. (separated by commas)">

                                <b>List any synonyms that could be used be replaced by your keywords.</b>

                                <p>IE: diet pills, antioxidant, purple fruit, anthocyanins, superfoods, etc.</p>

                                <input type="text" name="" value="Enter as many synonyms that could be substituted by your keywords  (separated by commas)">

                            </div>

                            <div class="part5_3 clearfix">

                            	<h3>How many unique articles should we create/ post?</h3><input type="text" value="Enter Number" name="">

                                <div class="button-holder clearfix">

                                    <input type="radio" checked="" class="regular-radio" name="radio-1-set" id="radio-1-7"><label for="radio-1-7"></label>

                                    <span>Continue until paused or stopped.</span>

                                </div>

                            </div>

                            <div class="part6">

                            	<div class="part6_1 clearfix">

                                	<div class="on_off"><img src="<?php echo base_url()?>assets/images/pic13.png" alt="no img"/></div>

                                	<h3>SERP Avenger Professional Formatting</h3>

                                    <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"/></span>

                                </div>

                                <p>Formats post to use: sub-headlines, bullet points, bold, italics, etc.</p>

                                <h3>Blog+ Options:<span>72 Blog+ Domains Available for this submission</span></h3>

                            	<div class="part6_1 clearfix">

                                	<div class="on_off"><img src="<?php echo base_url()?>assets/images/pic13.png" alt="no img"/></div>

                                	<h3>SERP Avenger Professional Formatting</h3>

                                    <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"/></span>

                                </div>

                                <div class="radio1">

                                	<div class="button-holder clearfix">

                                    	<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-1"></label>

                                        <span>Randomly promote posts back to homepage based on Blog+ settings.</span>

                                    </div>

                                	<div class="button-holder clearfix two_radio">

                                    	<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-2"></label>

                                        <span>Randomly promote posts back to homepage based on Blog+ settings.</span>

                                    </div>

                                </div>

                            </div>

                            <div class="part6">

                            	<div class="chkbox1 clearfix">

                                    <input type="checkbox" id="checkbox-1-1" class="regular-checkbox" /><label for="checkbox-1-1"></label>

                                    <span>Smart Homepage Monitoring / Promotion.  How Many HPBL to Maintain?:</span>

                                </div>

                            	<div class="two_radio">

                                	<div class="rating"><img src="<?php echo base_url()?>assets/images/pic14.png" alt="no img"/></div>

                                	<div class="button-holder clearfix">

                                    	<input type="radio" id="radio-1-3" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-3"></label>

                                        <span>Randomly promote posts back to homepage based on Blog+ settings.</span>

                                    </div>                                	

                                </div>

                            	<div class="part6_1 clearfix">

                                	<div class="on_off"><img src="<?php echo base_url()?>assets/images/pic15.png" alt="no img"/></div>

                                	<h3>SERP Avenger Professional Formatting</h3>

                                    <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"/></span>

                                </div>

                                <p>Adds relatedLSI  comments to posts to boost crawl rates.</p>

                            	<div class="chkbox1 clearfix">

                                    <input type="checkbox" id="checkbox-1-2" class="regular-checkbox" /><label for="checkbox-1-2"></label>

                                    <span><b>Blended:</b> Used both types of comment seeding.</span>

                                </div>

                                <div class="button-holder clearfix">

                                    <input type="radio" id="radio-1-4" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-4"></label>

                                    <span><b>Viral Post:</b> Most comments added while on homepage.</span>

                                </div>

                                <div class="button-holder clearfix">

                                    <input type="radio" id="radio-1-5" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-5"></label>

                                    <span><b>Natural Post:</b> Comments spaced out over time.</span>

                                </div>

                                <div class="file clearfix">

                                	<button class="input_file">Upload Comment File</button>

                                    <div class="clearfix"><input type="checkbox" value="" name=""><h3>Have SERP Avenger create unique comments for me.</h3></div>

                                </div>

                                <a href="#" class="see">See Requirements</a>

                            </div>

                            <div class="part6">

                            	<div class="link_anchor">Links & Anchors</div>

                                <h4 class="no1">How Should Links be Added to Your Posts?</h4>

                                <div class="part6_2">

                                    <div class="button-holder clearfix">

                                        <input type="radio" id="radio-1-6" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-6"></label>

                                        <span><b>Link Identifiers:</b> I have link identifiers in my content.  (Up to 3 per post:  %link1%   %link2%  %link3%) </span>

                                    </div>

                                	<div class="chkbox1 clearfix">

                                     	<input type="checkbox" id="checkbox-1-3" class="regular-checkbox" /><label for="checkbox-1-3"></label>

                                        <span><b>Keyword Replace:</b> Find and replacekeywords or synonyms</span>

                                    </div>

                                    <div class="help_box2 clearfix">

                                    	<input type="text" name="" value="Enter synonyms or words that could be replaced by your keyword anchors. (I.E. hair loss, rogain, baldness)">

                                        <span class="help"><img alt="no img" src="<?php echo base_url()?>assets/images/img2.png"></span>

                                    </div>

                                    <div class="file clearfix">

                                        <button class="input_file">Upload Synonyms File</button>

                                    </div>

                                    <a href="#" class="see">See Requirements</a>

                                </div>

                                <h4 class="no2">What Anchors Should Be Used?</h4>

                                <div class="part6_3 clearfix">

                                	<div class="anchor"><img src="<?php echo base_url()?>assets/images/pic24.png" alt="no img"/></div>

                                    <label>Anchor 1:</label>

                                	<div class="part6_5 clearfix">

                                        <div class="chkbox3 clearfix">

                                            <input type="checkbox" name="" value=""><span>Keyword</span>

                                            <input type="checkbox" name="" value=""><span>Brand</span>

                                            <input type="checkbox" name="" value=""><span>Raw URL</span>

                                            <input type="checkbox" name="" value=""><span>Generic</span>

                                        </div>

                                     </div>

                                     <span class="help"><img src="<?php echo base_url()?>assets/images/img2.png" alt="no img"></span>

                                     <span class="qty">Quantity</span>

                                     <div class="rating"><img alt="no img" src="<?php echo base_url()?>assets/images/pic25.png"></div>

                                </div>

                                <div class="part6_4">

	                                <input type="text" name="" value="Enter Anchor (Spintax Accepted)">

                                    <h4 class="no3">Link/ URL 1:</h4>

	                                <input type="text" name="" value="Enter URL including http://">

                                    <div class="part5_2 clearfix">

                                        <a href="#">+ New Anchor/ Link</a><a href="#">+ Second Anchor/ Link to Same Post</a>

                                        <span>Correct Spintax Detected</span>

                                    </div>

                                 </div>

                            </div>

                            <div class="part6">

                            	<div class="link_anchor">Schedule and Settings</div>

                                <h4 class="no4">Select or Change Any Submission Settings:</h4>

                                <div class="part6_5 clearfix">

                                	<div class="chkbox3 clearfix"><input type="checkbox" name="" value=""><span>Unique Domains:  First, skip domains previously posted to.</span><br> </div>

                                	<div class="chkbox3 clearfix"><input type="checkbox" name="" value=""><span>Never Repeated: Never post to a domain that has been previously posted to.</span></div>

                                    <b>Favor Preference:</b>

                                    <div class="chkbox3 clearfix">

                                    	<input type="checkbox" name="" value=""><span>Random Mix</span>

                                    	<input type="checkbox" name="" value=""><span>Highest Pagerank First</span>

                                    	<input type="checkbox" name="" value=""><span>Unique IP First</span>

                                    	<input type="checkbox" name="" value=""><span>Oldest Domains First</span>

                                    </div>

                                </div>

                                <h4 class="no5">Schedule & Drip Rate</h4>

                            	<div class="part6_5 clearfix">

                                    <div class="chkbox3 clearfix">

                                    	<input type="checkbox" name="" value=""><span>Start Now</span>

                                    	<input type="checkbox" name="" value=""><span>Select Start Date</span>

                                        <div class="cal"><img src="<?php echo base_url()?>assets/images/pic22.png" alt="no img"/></div>

                                    </div>

                                    <b>Drip Rate:</b>

                                    <div class="chkbox3 clearfix">

                                    	<input type="checkbox" name="" value=""><span>Custom Range: </span>

                                        <input type="text" name="" value="# of Posts"/><span>Per </span>

                                        <select>

                                        	<option># of Posts</option>

                                        	<option># of Posts</option>

                                        	<option># of Posts</option>

                                        </select>

                                    </div>

                                    <div class="chkbox3 clearfix">

                                    	<div class="chkbox3 clearfix"><input type="checkbox" name="" value=""><span>Viral Linking:  <em>Spike in week 1, then trickle.</em></span></div>

                                    	<div class="chkbox3 clearfix"><input type="checkbox" name="" value=""><span>Mini Spikes:  <em>Mini spike in links every 7 to 10 days.</em> </span></div>

                                    	<div class="chkbox3 clearfix"><input type="checkbox" name="" value=""><span>Post All Within 24 Hours</span></div>

                                    </div>

                                    <div class="part6_6 clearfix">

                                    	<div class="chkbox1 clearfix">

                                            <input type="checkbox" class="regular-checkbox" id="checkbox-1-4"><label for="checkbox-1-4"></label>

                                            <span>Smart Homepage Monitoring / Promotion.   How Many HPBL to Maintain?:</span>

                                        </div>
                                    	<div class="rating"><img alt="no img" src="<?php echo base_url()?>assets/images/pic14.png"></div>
                                    	<b>SERP Avenger will wait for older post to roll off homepage before new posts are submitted.</b>
                                        <input type="submit" name="submit" value="submit">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section>

      </article>

    </section>

  </section>

  <footer class="footer"></footer>
</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.accordion.js"></script>

		<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.easing.1.3.js"></script>

        <script type="text/javascript">

            $(function() {
				$('#st-accordion').accordion({
				oneOpenedItem	: true
				});
				});
				$(document).ready(function(){

				$(".toggle_button").click(function(){

				$(".toggle_box1").toggle();

				});
				$(".toggle_button1").click(function(){

				$(".toggle_box2").toggle();

				});
			});
        </script>
</body>
</html>