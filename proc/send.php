<?php
    defined("_V") || die("Direct access not allowed!");
    $e = array();
    
    isset($_POST['addrto']) && trim($_POST['addrto']) ? $addrto = makeSQLSafe(trim($_POST['addrto'])) : $e[] = "Destination address missing!";
    isset($_POST['amount']) && is_numeric($_POST['amount']) ? $amount = round($_POST['amount'],8) : $e[] = "Amount missing!";
    isset($_POST['pass']) && trim($_POST['pass']) ? $pass = trim($_POST['pass']) : $e[] = "Password missing!";
    
    if(empty($e)){
       $sql = "SELECT a.pass, b.salt FROM users AS a, salt AS b WHERE a.id = {$_SESSION['id']} AND b.uid = a.id";
       $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
       $mu = mysqli_fetch_assoc($q);
       $testPass = hash("ripemd160",$pass . $mu['salt']);
       if($testPass != $mu['pass']) $e[] = "Wrong current password!";        
    }
    
    if(empty($e)){
        $isValid = $b->validateaddress($addrto);
        if($isValid['isvalid'] != 1) $e[] = "Invalid destination address!";
    }    
    
    if(empty($e)){
        $act = explode("_",$_SESSION['btaccount']);
        if(!is_array($act) || sizeof($act) != 3) $e[] = "SESSION ERROR! Please logout and login again!";        
    }
    
    if(empty($e)){
        $sql = "SELECT id,balance FROM accounts WHERE uid = {$_SESSION['id']} AND account_id = {$act[2]}";
        $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        if(!mysqli_num_rows($q)) $e[] = "Active account not found!";        
    }
    
    if(empty($e)){
        $account = mysqli_fetch_assoc($q);
        $available = $account['balance'] - 0.0005;    
        if($available <= 0) $e[] = "You've no funds to withdraw!";        
    }
    
    if(empty($e)){
        if($available < $amount) $e[] = "Requested amount exceeds available balance!";
    }
    
    if(empty($e)){
        $system_account = $b->getbalance($config['central_account']['value'],(int)$config['confirmations']['value']);
        if($system_account < $amount) $e[] = "Bitcoind has no coins enough to perform the payment! Contact the site admin!";
    }
    
    if(empty($e)){
        
        $previous_balance = 0;
        $sql = "SELECT * FROM movements WHERE account_id = {$account['id']} ORDER BY id DESC LIMIT 0,1";
        $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        if(mysqli_num_rows($q)){
            $lastmove = mysqli_fetch_assoc($q);
            $previous_balance = $lastmove['balance'];
        }
        
        if($isValid['ismine'] == 1){
              //It's forward to a local address, so we just move the balance
              $recAct = explode("_",$isValid['account']);
              
              if(!is_array($recAct) || sizeof($recAct) != 3){
                $e[] = "Invalid destination local account!";
              }else{
                $sql = "SELECT * FROM accounts WHERE uid = {$recAct[1]} AND account_id = {$recAct[2]}";
                $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                if(!mysqli_num_rows($q)){
                    $e[] = "Local destination address but the destination account wasn't found!";
                }else{
                    $receiver = mysqli_fetch_assoc($q);  
                    $new_balance = $previous_balance - $amount;    
                    //Get the current block
                    $cBlock = $b->getblockcount();
                    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO movements(`account_id`,`dtime`,`description`,`amount`,`credit`,`balance`,`txblock`) VALUES({$account['id']},'".date("Y-m-d H:i:s")."','Payment to $addrto',$amount,0,$new_balance,$cBlock)");
                    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE accounts SET balance = balance - $amount WHERE id = {$account['id']}"); 
                    //A small issue; if the destination account is forwarded, will not forward to prevent loop attacks.
                   $prevBal = 0;
                   $sql = "SELECT balance FROM movements WHERE account_id = {$receiver['id']} ORDER BY id DESC LIMIT 0,1";
                   $q = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                   if(mysqli_num_rows($q)){
                       $pbal = mysqli_fetch_assoc($q);
                       $prevBal = $pbal['balance'];
                   }
                   $newBal = $prevBal + $amount;                    
                   mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO movements(`account_id`,`dtime`,`description`,`amount`,`credit`,`balance`,`txblock`) VALUES({$receiver['id']},'".date("Y-m-d H:i:s")."','Payment from {$_SESSION['name']}',$amount,1,$newBal,$cBlock)");
                   mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE accounts SET balance = balance + $amount WHERE id = {$receiver['id']}");                    
                    
                }
              }        
        
            }else{
                //Address is not local!
                        $txid = $b->sendfrom($config['central_account']['value'],$addrto,$amount,(int)$config['confirmations']['value']);
                        $new_balance = $previous_balance - $amount;    
                        //Get the current block
                        $cBlock = $b->getblockcount();
                        mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO movements(`account_id`,`dtime`,`description`,`amount`,`credit`,`balance`,`txblock`) VALUES({$account['id']},'".date("Y-m-d H:i:s")."','Payment to $addrto',$amount,0,$new_balance,$cBlock)");
                        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE accounts SET balance = balance - $amount WHERE id = {$account['id']}");               
                        //Get the transaction info to see what went with fees
                        $txinfo = $b->gettransaction($txid);
                        $fee = 0;
                        $fee -= $txinfo['fee'];
                        $new_balance -= $fee;
                        if($fee > 0){
                            mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO movements(`account_id`,`dtime`,`description`,`amount`,`credit`,`balance`,`txblock`) VALUES({$account['id']},'".date("Y-m-d H:i:s")."','Bitcoin Network Fee',$fee,0,$new_balance,$cBlock)");
                            mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE accounts SET balance = balance - $fee WHERE id = {$account['id']}");                                           
                        }                
            }
    }
    
    if(empty($e)){
        $success = "Coins sent!";
    }else{
        $error = implode("<br/>",$e);
    }
    $pg = "html/main.php";
?>
