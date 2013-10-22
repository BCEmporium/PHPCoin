<?php
    defined("_V") || die("Direct access not allowed!");
    
    $e = array();
    
    $sql = "SELECT COUNT(*) AS myAccounts FROM accounts WHERE uid = {$_SESSION['id']}";
    $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
    $r = mysqli_fetch_array($q);
    $nrAccounts = $r['myAccounts'];
    
    if($nrAccounts > $config['user_l_accounts']['value']) $e[] = "You already have the maximum allowed accounts per user in this system!";    
    
    if(empty($e)){
        isset($_POST['name']) && trim($_POST['name']) ? $name = makeSQLSafe(trim($_POST['name'])) : $e[] = "Account name missing!";
        isset($_POST['fwd']) && is_numeric($_POST['fwd']) && $_POST['fwd'] >= 0 && $_POST['fwd'] <= 1 ? $fwd = $_POST['fwd'] : $e[] = "Account forwarding not set!";
        isset($_POST['fwdto']) && trim($_POST['fwdto']) ? $fwdto = makeSQLSafe(trim($_POST['fwdto'])) : $fwdto = "";
    }
    
    if($fwd == 1 && !$fwdto) $e[] = "You must enter a bitcoin address to forward to!";
    
    if(empty($e)){
        $sql = "SELECT * FROM accounts WHERE account_name LIKE '$name' AND uid = {$_SESSION['id']}" ## AND id != $aid";
        $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        if(mysqli_num_rows($q)) $e[] = "You already have another account with that same name!";                
    }    
    
    if(empty($e) && $fwd == 1){
        $valid = $b->validateaddress($fwdto);
        if($valid['isvalid'] != 1) $e[] = "Invalid address to forward to!";
    }
    
    if(empty($e)){
        $sql = "SELECT account_id FROM accounts WHERE uid = {$_SESSION['id']} ORDER BY account_id DESC LIMIT 0,1";
        $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        $r = mysqli_fetch_assoc($q);
        $myNewId = $r['account_id'] + 1;
        $c = array(); $v = array();
        $c[] = "`uid`"; $v[] = $_SESSION['id'];
        $c[] = "`account_id`"; $v[] = $myNewId;
        $c[] = "`account_name`"; $v[] = "'$name'";
        $c[] = "`balance`"; $v[] = 0;
        $c[] = "`forward`"; $v[] = $fwd;
        $c[] = "`forward_to`"; $v[] = "'$fwdto'";
        $sql = "INSERT INTO accounts(".implode(",",$c).") VALUES(".implode(",",$v).")";
        mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        $success = "Account created!";
    }else{
        $error = implode("<br/>",$e);
    }    
?>
