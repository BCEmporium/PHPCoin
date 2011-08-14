<?php
    defined("_V") || die("Direct access not allowed!");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Lang" content="en">
<title>PHPCoin</title>
<link rel="stylesheet" type="text/css" href="css/<?php echo $config['css_template']['value'];?>/style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/ZeroClipboard.js"></script>
<script type="text/javascript" src="js/phpcoin.js"></script>
</head>
<body>
<?php
    if(isset($error)){
?>
  <div class="error"><?php echo $error;?></div>
<?php        
    }
    if(isset($success)){
?>
  <div class="success"><?php echo $success;?></div>
<?php        
    }
?>