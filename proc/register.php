<?php
    defined("_V") || die("Direct access not allowed!");
    
   $e = array();
   
   isset($_POST['user']) && trim($_POST['user']) ? $user = makeSQLSafe(trim($_POST['user'])) : $e[] = "Username missing!";
   isset($_POST['pass']) && trim($_POST['pass']) ? $pass = trim($_POST['pass']) : $e[] = "Password missing!";
   isset($_POST['pass2']) && trim($_POST['pass2']) ? $pass2 = trim($_POST['pass2']) : $e[] = "Password confirmation missing!";
   isset($_POST['name']) && trim($_POST['name']) ? $name = makeSQLSafe(trim($_POST['name'])) : $e[] = "Name missing!";
   isset($_POST['email']) && trim($_POST['email']) ? $email = makeSQLSafe(trim($_POST['email'])) : $email = "";
   
   if(!$email && $config['require_email']['value'] == "true") $e[] = "Email missing!";
   
   if(strlen($user) > 32) $e[] = "Username too long. Max. 32 chars!";
   if(strlen($pass) < 5) $e[] = "Password too short! Min. 5 chars!";
   if(empty($e) && $email && !isValidEmail($email)) $e[] = "Invalid email!";
   
   if(empty($e) && $pass != $pass2) $e[] = "Password and confirmation doesn't match!";
   
   if(empty($e)){
       $sql = "SELECT * FROM users WHERE user LIKE '$user'";
       $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       if(mysqli_num_rows($q)) $e[] = "Username in use!";
   }
   
   if(empty($e) && $email){
       $sql = "SELECT * FROM users WHERE email LIKE '$email'";
       $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       if(mysqli_num_rows($q)) $e[] = "Email already registered!";
   }   
   
   if(empty($e)){
       $salt = md5(rand().$name.microtime());
       $passh = hash("ripemd160",$pass.$salt);
       mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO users(user,pass,name,email) VALUES('$user','$passh','$name','$email')");
       $myuid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
       mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO salt(uid,salt) VALUES($myuid,'$salt')");
       mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO accounts(uid,account_id,account_name) VALUES($myuid,1,'Default')");
       $success = "You're now registered to this system";
       $_SESSION['id'] = $myuid;
       $_SESSION['user'] = $user;
       $_SESSION['name'] = $name;
       $_SESSION['email'] = $email;
   }else{
       $error = implode("<br/>",$e);
   }  
?>