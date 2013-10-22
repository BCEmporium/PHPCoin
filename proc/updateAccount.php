<?php
    defined("_V") || die("Direct access not allowed!");
    
    $e = array();
    
    isset($_POST['account_id']) && is_numeric($_POST['account_id']) ? $aid = $_POST['account_id'] : $e[] = "Account ID missing!";    
    isset($_POST['fwd']) && is_numeric($_POST['fwd']) && $_POST['fwd'] >= 0 && $_POST['fwd'] <= 1 ? $fwd = $_POST['fwd'] : $e[] = "Account forwarding not set!";
    isset($_POST['fwdto']) && trim($_POST['fwdto']) ? $fwdto = makeSQLSafe(trim($_POST['fwdto'])) : $fwdto = "";
    isset($_POST['name']) && trim($_POST['name']) ? $name = makeSQLSafe(trim($_POST['name'])) : $e[] = "Account name missing!";
    isset($_POST['pass']) && trim($_POST['pass']) ? $pass = trim($_POST['pass']) : $e[] = "Password missing!";
    
    if($fwd == 1 && !$fwdto) $e[] = "You must enter a bitcoin address to forward to!";
    if(empty($e)){
       $sql = "SELECT a.pass, b.salt FROM users AS a, salt AS b WHERE a.id = {$_SESSION['id']} AND b.uid = a.id";
       $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       $mu = mysqli_fetch_assoc($q);
       $testPass = hash("ripemd160",$pass . $mu['salt']);
       if($testPass != $mu['pass']) $e[] = "Wrong current password!";        
    }
    if(empty($e)){
        $sql = "SELECT * FROM accounts WHERE id = $aid AND uid = {$_SESSION['id']}";
        $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        if(!mysqli_num_rows($q)) $e[] = "Account not found!";        
    }
    if(empty($e)){
        $sql = "SELECT * FROM accounts WHERE account_name LIKE '$name' AND uid = {$_SESSION['id']} AND id != $aid";
        $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        if(mysqli_num_rows($q)) $e[] = "You already have another account with that same name!";                
    }
    
    if(empty($e) && $fwd == 1){
        $valid = $b->validateaddress($fwdto);
        if($valid['isvalid'] != 1) $e[] = "Invalid address to forward to!";
    }
    if(empty($e)){
        $sql = "UPDATE accounts SET account_name = '$name', forward = $fwd, forward_to = '$fwdto' WHERE id = $aid";
        mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        $success = "Account updated";
    }else{
        $error = implode("<br/>",$e);
    }
    
?>