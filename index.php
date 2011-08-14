<?php
 define("_V",1);
 session_start();
 include("sys/config.php");
 include("inc/general_functions.php");
 	ini_set("display_errors",1);
 isset($_REQUEST['f']) && trim($_REQUEST['f']) ? $f = trim($_REQUEST['f']) : $f = "";
 
 if($f == "register" && $config['allow_register']['value'] == "true") include("proc/register.php");
 if($f == "login") include("proc/login.php");
 if($f == "logout"){
     session_destroy();
     header("Location: index.php");
     exit();
 }
 if(!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])){
     include("login/login.php");
     exit();
 }
 
 if($f == "switchAccount"){
     include("proc/switchAccount.php");
 }
 
 require_once("classes/jsonRPCClient.php");
 
 $b = new jsonRPCClient("http://$btc_user:$btc_pass@$btc_ip:$btc_port");
 if(!isset($_SESSION['btaccount'])) $_SESSION['btaccount'] = $config['account_prefix']['value'] ."_" . $_SESSION['id'] . "_1";
 $pg = "";
 switch($f){
     case 'updateBasicInfo': include("proc/updateBasicInfo.php"); $pg = "html/main.php"; break;
     case 'changePassword': include("proc/changePassword.php"); $pg = "html/main.php"; break;
     case 'getnewaddress': $pg = "ajax/getnewaddress.php"; break;
     case 'accounts': $pg = "html/accounts.php"; break;
     case 'send': include("proc/prepare_send.php"); break;
     case 'sendcoins': include("proc/send.php"); break;
     case 'createAccount': include("proc/createAccount.php"); break;
     case 'doCreateAccount': include("proc/doCreateAccount.php"); $pg = "html/accounts.php"; break;
     case 'editAccount': include("proc/edit_account.php"); break;
     case 'updateAccount': include("proc/updateAccount.php"); $pg = "html/accounts.php"; break;
     case 'profile': $pg = "html/profile.php"; break;
     default: $pg = "html/main.php";
 }
 
 if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1){
 	switch($f){
		case 'bitcoindStatus': $pg = "admin/bitcoind.php"; break;
 	}
 }
 
 if(!isset($_REQUEST['nh'])) include("html/head.php");
 if($pg) include($pg);
 if(!isset($_REQUEST['nh'])) include("html/footer.php");
 
 /*$a = $b->getinfo();
 print_r($a); */
?>
