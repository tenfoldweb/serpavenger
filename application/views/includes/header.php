<div class="btn-group pull-right user-title">
  <?php
$session = $this->session->userdata('user_data');
$usernm=   $session['user_login'];

$userid= $session['user_id'];
 if($userid>0 && $userid!=''){?>
  <button type="button" class="btn btn-default dropdown-toggle user-btn" data-toggle="dropdown"> Welcome, <span><?php echo $usernm;  ?></span> <span class="caret"></span> </button>
  <ul class="dropdown-menu">
    <li><a href="<?php echo base_url()?>mypannel"><i class="fa fa-user"></i> My Profile</a></li>
    <li><a href="<?php echo base_url()?>mypannel"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="divider"></li>
    <li><a href="<?php echo Am_Lite::getInstance()->getLogoutURL(); ?>">Logout</a></li>
  </ul>
  <?php } else { ?>
  <figure class="loginSec"> <span class="loginText"><a href="<?php echo base_url();?>amemeber/index/login">Login</a></span></figure>
  <?php } ?>
</div>
