<?php
    defined("_V") || die("Direct access not allowed!");
    
    $e = array();
    
    isset($_POST['user']) && trim($_POST['user']) ? $user = makeSQLSafe(trim($_POST['user'])) : $e[] = "Username missing!";
    isset($_POST['name']) && trim($_POST['name']) ? $name = makeSQLSafe(trim($_POST['name'])) : $e[] = "Name missing!";
    isset($_POST['email']) && trim($_POST['email']) ? $email = makeSQLSafe(trim($_POST['email'])) : $email = "";
    
    if(!$email && $config['require_email']['value'] == "true") $e[] = "Email missing!";
   
    if(strlen($user) > 32) $e[] = "Username too long. Max. 32 chars!";    
    if(empty($e) && $email && !isValidEmail($email)) $e[] = "Invalid email!";
    
   if(empty($e)){
       $sql = "SELECT * FROM users WHERE user LIKE '$user' AND id != {$_SESSION['id']}";
       $q = mysql_query($sql);
       if(mysql_num_rows($q)) $e[] = "Username in use!";
   }
   if(empty($e) && $email){
       $sql = "SELECT * FROM users WHERE email LIKE '$email' AND id != {$_SESSION['id']}";
       $q = mysql_query($sql);
       if(mysql_num_rows($q)) $e[] = "Email already registered!";
   }       
   
   if(empty($e)){
        mysql_query("UPDATE users SET user = '$user', name = '$name', email = '$email' WHERE id = {$_SESSION['id']}");
        $_SESSION['name'] = $name;
        $_SESSION['user'] = $user;
        $_SESSION['email'] = $email;
        $success = "Details updated";   
   }else{
       $error = implode("<br/>",$e);
   }
?>