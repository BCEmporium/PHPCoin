<?php
    defined("_V") || die("Direct access not allowed!");
    $e = array();
  $act = explode("_",$_SESSION['btaccount']);
  if(!is_array($act) || sizeof($act) != 3) $e[] = "SESSION ERROR! Please logout and login again!";
  
  if(empty($e)){
    $sql = "SELECT balance FROM accounts WHERE uid = {$_SESSION['id']} AND account_id = {$act[2]}";
    $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
    if(!mysqli_num_rows($q)) $e[] = "Active account not found!";
  }
  if(empty($e)){
    $account = mysqli_fetch_assoc($q);
    $available = $account['balance'] - 0.0005;    
    if($available <= 0) $e[] = "You've no funds to withdraw!";
  }
  if(empty($e)){
      $pg = "forms/send.php";
  }else{
      $error = implode("<br/>",$e);
      $pg = "html/main.php";
  }
?>