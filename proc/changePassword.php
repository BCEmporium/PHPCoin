<?php
    defined("_V") || die("Direct access not allowed!");
    $e = array();
    isset($_POST['cpass']) && trim($_POST['cpass']) ? $pass = trim($_POST['cpass']) : $e[] = "Current password missing!";    
    isset($_POST['npass']) && trim($_POST['npass']) ? $npass = trim($_POST['npass']) : $e[] = "New password missing!";    
    isset($_POST['npass2']) && trim($_POST['npass2']) ? $npass2 = trim($_POST['npass2']) : $e[] = "New password confirmation missing!";    
    
    if(strlen($npass) < 5) $e[] = "Password too short! Min. 5 chars!";
    if(empty($e) && $npass != $npass2) $e[] = "Password and confirmation doesn't match!";
   if(empty($e)){
       $sql = "SELECT a.pass, b.salt FROM users AS a, salt AS b WHERE a.id = {$_SESSION['id']} AND b.uid = a.id";
       $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       $mu = mysqli_fetch_assoc($q);
       $testPass = hash("ripemd160",$pass . $mu['salt']);
       if($testPass != $mu['pass']) $e[] = "Wrong current password!";
   }     
   
   if(empty($e)){
       $npass_salt = md5(rand() . microtime() . $_SESSION['name']);
       $npass_hash = hash("ripemd160",$npass . $npass_salt);
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE users SET pass = '$npass_hash' WHERE id = {$_SESSION['id']}");
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE salt SET salt = '$npass_salt' WHERE uid = {$_SESSION['id']}");
       
       $success = "Password updated";
   }else{
       $error = implode("<br/>",$e);
   }
?>