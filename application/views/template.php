<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $html_head; ?>
    <title><?php echo $title; ?></title>
</head>
<body>
	<?php echo $menu; ?>
    <div class="container">
  		<div class="row pdglr">
			<?php if($sidemenu): ?>
            <div class="col-md-3 left-col">
            	<?php echo $sidemenu; ?>
            </div>
            <div class="col-md-9 right-col">
            <?php else: ?>
            <div class="col-md-12">
            <?php endif; ?>
	            <?php echo $content; ?>
            </div>
    	</div>
	</div>
    <div id="footer">
        <?php echo $html_footer; ?>
    </div>
</body>
</html>