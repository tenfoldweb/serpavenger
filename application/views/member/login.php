<?php if($err_msg != ''){?>
<div class="alert-box error"><span>error: </span><?php echo stripslashes($err_msg);?></div>
<?php } ?>
<form name="frmLogin" id="frmLogin" action="" method="post">
    <input type="hidden" name="action" value="Process">
    <p>
        <label>Email Address:</label>
        <input type="text" name="users_email" id="users_email" value="">
    </p>
    <p>
        <label>Password:</label>
        <input type="password" name="users_password" id="users_password" value="">
    </p>
    <p>
        <input type="submit" name="subLogin" id="subLogin" value="Signin">
    </p>
</form>