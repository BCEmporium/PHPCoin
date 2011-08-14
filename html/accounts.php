<?php
    defined("_V") || die("Direct access not allowed!");
    
    include("menus/menus.php");
    
    $sql = "SELECT COUNT(*) AS myAccounts FROM accounts WHERE uid = {$_SESSION['id']}";
    $q = mysql_query($sql);
    $r = mysql_fetch_array($q);
    $nrAccounts = $r['myAccounts'];
?>
<div id="mainBodyLMenu">
<h2>Your accounts</h2>
<div class="buttonsArea">
<?php
    if($nrAccounts < $config['user_l_accounts']['value']){
?>
    <input type="button" value="Create new account" onclick="document.location.href='index.php?f=createAccount'" />
<?php
    }
?>
</div>
<table class="listingTable">
    <tr class="listingHeader">
        <td>#</td>
        <td>Account Name</td>
        <td align="center">Fwd?</td>
        <td>Forwarded to</td>
        <td>Balance</td>
        <td>Actions</td>
    </tr>
<?php
    $sql = "SELECT * FROM accounts WHERE uid = {$_SESSION['id']} ORDER BY account_id ASC";
    $q = mysql_query($sql);
    $k = 0;
    $total_accounts = 0;
    $accounts = 0;
    while($r = mysql_fetch_assoc($q)){
        $total_accounts += $r['balance'];
        $acounts++;
?>
    <tr class="listingRow<?php echo $k;?>">
        <td align="right"><?php echo $r['account_id'];?></td>
        <td><?php echo stripslashes($r['account_name']);?></td>
        <td align="center">
        <img src="icon/<?php echo $r['forward'] == 1 ? 'tick.png' : 'cross.png';?>" border="0" title="<?php echo $r['forward'] == 1 ? 'Yes' : 'No';?>" />
        </td>
        <td><?php echo $r['forward'] == 1 ? $r['forward_to'] : "<i>not forwarded</i>";?></td>
        <td align="right"><?php echo number_format($r['balance'],8,".",",");?> BTC</td>
        <td>
        <img src="icon/blue-document--pencil.png" border="0" title="Edit account" style="cursor: pointer;" onclick="document.location.href='index.php?f=editAccount&account_id=<?php echo $r['id'];?>'" />
        </td>
    </tr>
<?php        
    
        $k = 1 - $k;
    }
?>    
</table>
<h4>Total amount in accounts: <?php echo number_format($total_accounts,8,".",",");?> BTC</h4>
</div>