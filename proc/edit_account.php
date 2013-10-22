<?php
    defined("_V") || die("Direct access not allowed!");
    
    $e = array();
    
    isset($_REQUEST['account_id']) && is_numeric($_REQUEST['account_id']) ? $aid = $_REQUEST['account_id'] : $e[] = "Account ID missing!";
    
    if(empty($e)){
        $sql = "SELECT * FROM accounts WHERE id = $aid AND uid = {$_SESSION['id']}";
        $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        if(!mysqli_num_rows($q)) $e[] = "Account not found!";
    }
    if(empty($e)){
        $account_to_edit = mysqli_fetch_assoc($q);
        $pg = "forms/edit_account.php";
    }else{
        $error = implode("<br/>",$e);
        $pg = "html/main.php";
    }
?>