<div class="container">
  <div class="row" id="header">
    <div class="col-md-3 left-col">
      <div id="logo"><a href="index.html"><img src="<?php echo base_url('images/logo.png');?>" width="214" height="84" alt=""></a></div>
    </div>
    <div class="col-md-9 menusec right-col">
      <?php $this->load->view('includes/header'); ?>
      <nav class="mainmenu">
        <ul id="menu">
          <li><a href="<?php echo base_url()?>mypannel">My Panel </a></li>
          <li><a href="<?php echo base_url()?>campaign">My Campaigns</li>
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