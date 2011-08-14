<?php
    defined("_V") || die("Direct access not allowed!");
    include("menus/menus.php");
?>
<div id="mainBodyLMenu">
<h2>Send Coins</h2>
<script language="javascript" type="text/javascript">
    function validateWithdraw(form){
        var max = <?php echo $available;?>;
        var err = new Array;
        if(form.addrto.value == "") err.push("Destination address missing!");
        if(form.amount.value == "") err.push("Amount missing!");
        if(isNaN(form.amount.value)){
            err.push("Amount has to be numeric!");
        }else{
            if(form.amount.value > max) err.push("Selected amount exceeds your available balance!");
        }
        if(form.pass.value == "") err.push("Your password is needed to send coins!");
        
        if(err.length > 0){
            alert(err.join("\r\n"));
            return false;
        }
        return true;        
        
    }
</script>
<p>The maximum amount you can withdraw is <strong><?php echo number_format($available,8,".",",");?> BTC</strong></p>
<form method="post" action="index.php" onsubmit="return validateWithdraw(this)">
<input type="hidden" name="f" value="sendcoins" />
    <div class="formLine">
        <label>To Address</label>
        <input id="addrto" type="text" name="addrto" size="60" />
    </div>
    <div class="formLine">
        <label>Amount</label>
        <input type="text" style="text-align: right;" name="amount" size="10" /> BTC
    </div>  
        <div class="formLine">
            <label>Your Password</label>
            <input type="password" name="pass" />
        </div>        
        <div class="formLine">
            <label>&nbsp;</label>
            <input type="submit" value="Send coins" />
        </div>      
</form>
</div>