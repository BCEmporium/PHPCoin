<?php
    defined("_V") || die("Direct access not allowed!");
    
    $e = array();
    
    $sql = "SELECT COUNT(*) AS myAccounts FROM accounts WHERE uid = {$_SESSION['id']}";
    $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
    $r = mysqli_fetch_array($q);
    $nrAccounts = $r['myAccounts'];
    
    if($nrAccounts > $config['user_l_accounts']['value']) $e[] = "You already have the maximum allowed accounts per user in this system!";    
    
    if(empty($e)){
        $pg = "forms/createAccount.php";
    }else{
        $error = implode("<br/>",$e);
        $pg = "html/accounts.php";        
    }
?>