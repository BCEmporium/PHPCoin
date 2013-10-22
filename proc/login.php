<?php
    defined("_V") || die("Direct access not allowed!");
    
    $e = array();
   isset($_POST['user']) && trim($_POST['user']) ? $user = makeSQLSafe(trim($_POST['user'])) : $e[] = "Username missing!";
   isset($_POST['pass']) && trim($_POST['pass']) ? $pass = trim($_POST['pass']) : $e[] = "Password missing!";    
    
   if(empty($e)){
       $sql = "SELECT a.*, b.salt FROM users AS a, salt AS b WHERE a.user LIKE '$user' AND b.uid = a.id";
       $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       if(!mysqli_num_rows($q)) $e[] = "Username not found or wrong password!";
   } 
   if(empty($e)){
       $u = mysqli_fetch_assoc($q);
       $tpass = hash("ripemd160",$pass.$u['salt']);
       if($tpass != $u['pass']) $e[] = "Username not found or wrong password!";
   } 
   if(empty($e)){
       $_SESSION['id'] = $u['id'];
       $_SESSION['user'] = $u['user'];
       $_SESSION['name'] = $u['name'];
       $_SESSION['email'] = $u['email'];
	   $_SESSION['is_admin'] = $u['is_admin'];       
   }else{
       $error = implode("<br/>",$e);
   }
?>