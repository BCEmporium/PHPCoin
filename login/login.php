<?php
    defined("_V") || die("Direct access not allowed!");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Lang" content="en">
<title>PHPCoin Login</title>
<link rel="stylesheet" type="text/css" href="css/<?php echo $config['css_template']['value'];?>/login.css" />
</head>
<body>
<?php
    if(isset($error) && ($error)) {
?>
  <div class="error"><?php echo $error;?></div>
<?php        
    }
?>
<script language="javascript" type="text/javascript">
<?php
    if($config['allow_register']['value'] == "true"){
?>
    function doRegister(){
        var rForm = document.getElementById('registerFormForm');
        var err = new Array;
        if(rForm.user.value == "") err.push('Username missing!');
        if(rForm.pass.value == "") err.push("Password missing!");
        if(rForm.pass.value.length < 5) err.push("Password too short! Min. 5 chars!");
        if(rForm.pass.value != rForm.pass2.value) err.push("Password and confirmation doesn't match!");
        if(rForm.name.value == "") err.push("Name missing!");
<?php
  if($config['require_email']['value'] == "true"){
?>
        if(rForm.email.value == "") err.push("Email missing!");
<?php      
  }
?>        
        if(rForm.email.value != "" && !isValidEmail(rForm.email.value)) err.push("Invalid email!");
        
        if(err.length > 0){
            alert(err.join("\r\n"));
            return false;
        }
        rForm.submit();
    }
    function isValidEmail(email){
    return (/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/).test(email);
    }  
<?php
    }
?>    
    function doLogin(){
        var lForm = document.getElementById('loginFormForm');
        var err = new Array; 
        if(lForm.user.value == "") err.push("Username missing!");       
        if(lForm.pass.value == "") err.push("Password missing!");  
        if(err.length > 0){
            alert(err.join("\r\n"));
            return false;
        }
        lForm.submit();             
    }   
</script>
<noscript>This system requires Javascript to be active!</noscript>
   <div id="loginArea">
    <div id="loginLogo"></div>
    <div id="loginForm">
    <form method="post" id="loginFormForm" action="index.php">
    <input type="hidden" name="f" value="login" />
        <div class="formLine">
            <label for="user">Username</label>
            <input type="text" name="user" id="user" class="inputText" />
        </div>
        <div class="formLine">
            <label for="pass">Password</label>
            <input type="password" name="pass" id="pass" class="inputText" />
        </div>        
        <div class="formLine">
            <label>&nbsp;</label>
            <input type="button" value="Log In" onclick="doLogin()" id="btnSubmit" class="inputButton" />
        </div>
     </form>                   
    </div>
<?php
    if($config['allow_register']['value'] == "true"){
?>
   <div id="registerForm">
    <form method="post" id="registerFormForm" action="index.php">
    <input type="hidden" name="f" value="register" />   
        <div class="formLine">
            <label for="userReg">Username</label>
            <input type="text" name="user" id="userReg" class="inputText" />
        </div>
        <div class="formLine">
            <label for="passReg">Password</label>
            <input type="password" name="pass" id="passReg" class="inputText" />
        </div>        
        <div class="formLine">
            <label for="pass2">Repeat Password</label>
            <input type="password" name="pass2" id="pass2" class="inputText" />
        </div>                
        <div class="formLine">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="inputTextLong" />
        </div>        
        <div class="formLine">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="inputText" />
        </div>                
        <div class="formLine">
            <label>&nbsp;</label>
            <input type="button" value="Register" onclick="doRegister()" id="submitReg" class="inputButton" />
        </div>
       </form>    
   </div>
<?php        
    }
?>    
   </div>
</body>
</html>
