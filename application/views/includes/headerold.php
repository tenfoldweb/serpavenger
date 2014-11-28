 <header class="header">
    <section class="headerTop clearfix">
      <h1 class="logo"><a href="#"><img src="<?php echo FRONT_IMAGE_PATH; ?>logo.png" alt="logo"/></a></h1>
      <?php if($this->session->userdata('LOGIN_USER')>0){?>
      <figure class="loginSec"> <span class="loginText"><a href="#">Welcome, <?php echo stripslashes($this->session->userdata('LOGIN_USER_NAME'));?></a></span>
        <div class="loginDrop">
          <ul>
            <li><a href="#">My Profile</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="<?php echo FRONT_URL;?>member/logout/">Logout</a></li>
          </ul>
        </div>
      </figure>
      <?php } else { ?>
      <figure class="loginSec"> <span class="loginText"><a href="<?php echo FRONT_URL;?>member/login/">Login</a></span></figure>
      <?php } ?>
    </section>
  </header>
  
        