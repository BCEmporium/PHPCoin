<?php
    defined("_V") || die("Direct access not allowed!");
    include("menus/menus.php");
?>
<script language="javascript">
    function updateSettings(form){
        var err = new Array;
        if(form.name.value == "") err.push("Account name can't be blank!");
        if(form.pass.value == "") err.push("You must input your password to update an account info!");
        if(form.fwd.options[form.fwd.options.selectedIndex].value == 1 && form.fwdto.value == "") err.push("You need to set an address to forward to!");
        
        if(err.length > 0){
            alert(err.join("\r\n"));
            return false;
        }
        return true;
    }
</script>
<div id="mainBodyLMenu">
    <h2>Editing Account</h2>
      <p>NOTE:<br/>
      if you activate funds forwarding to an address outside this server, upon forwarding a bitcoin network fee of 0.0005 BTC will be held.<br/>
      If the transfer didn't pay fee, the held funds will remain in your account.<br/>
      Transfers bellow 0.0005 BTC will not be forwarded!</p>
    <form action="index.php" method="post" onsubmit="return updateSettings(this)">
    <input type="hidden" name="f" value="updateAccount" />
    <input type="hidden" name="account_id" value="<?php echo $aid;?>" />
        <div class="formLine">
            <label>Account Name</label>
            <input type="text" name="name" size="40" value="<?php echo stripslashes($account_to_edit['account_name']);?>" />
        </div>
        <div class="formLine">
            <label>Forward?</label>
            <select name="fwd">
                <option value="0"<?php if($account_to_edit['forward'] == 0) echo " selected";?>>No</option>
                <option value="1"<?php if($account_to_edit['forward'] == 1) echo " selected";?>>Yes</option>
            </select>
        </div>
        <div class="formLine">
            <label>Forward to Address</label>
            <input type="text" name="fwdto" size="60" value="<?php echo $account_to_edit['forward_to'];?>" />
        </div>
        <div class="formLine">
            <label>Your Password</label>
            <input type="password" name="pass" />
        </div>        
        <div class="formLine">
            <label>&nbsp;</label>
            <input type="submit" value="Update account" />
        </div>
    </form>
</div>
