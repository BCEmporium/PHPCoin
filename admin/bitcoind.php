<?php
	defined("_V") || die("Direct access not allowed!");
	if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) die("You're not admin!");
	
	include("menus/menus.php");

	$info = $b->getinfo();
	print_r($info);
	
	//This is a dirty hack, but should go ok until version 9.x
	if(strlen($info['version']) < 6){
		$version = 0;
		$sub_version = substr($info['version'],0,1);
		$build = substr($info['version'],1,2);
	}else{
		$version = substr($info['version'],0,1);
		$sub_version = substr($info['version'],1,1);
		$build = substr($info['version'],2,2);		
	}
?>
<div id="mainBodyLMenu">
	<div class="infoLine">
		<label>Version</label>
		<?php echo "$version.$sub_version.$build";?>
	</div>
	<div class="infoLine">
		<label>Balance</label>
		<?php echo number_format($info['balance'],8,".",",");?> BTC
	</div>
<?php
	$users_balance = 0;
	$sql = "SELECT `balance` FROM accounts";
	$q = mysql_query($sql);
	while($r = mysql_fetch_assoc($q)){
		$users_balance += $r['balance'];
	}
	$diff = $info['balance'] - $users_balance;
?>	
	<div class="infoLine">
		<label>Difference</label>
		<?php echo $diff;?> BTC <small>This value should always be zero if everything is ok</small>
	</div>
	<div class="infoLine">
		<label>Connections</label>
		<?php echo $info['connections'];?>
	</div>	
<?php
	if($info['proxy'] != ""){
?>
	<div class="infoLine">
		<label>Proxy</label>
		<?php echo $info['proxy'];?>
	</div>	
<?php		
	}
?>	
</div>
