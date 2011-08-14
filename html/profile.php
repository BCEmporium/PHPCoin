<?php
    defined("_V") || die("Direct access not allowed!");
    
    include("menus/menus.php");
    
?>
<script language="javascript" type="text/javascript">
    function checkBasicInfo(form){
        var err = new Array;
        if(form.user.value == "") err.push("Username missing!");
        if(form.name.value == "") err.push("Name missing!");
<?php
  if($config['require_email']['value'] == "true"){
?>        
        if(form.email.value == "") err.push("Email missing!");
<?php
  }
 ?>    
        if(form.email.value != "" && !isValidEmail(form.email.value)) err.push("Invalid email!");
        
        if(err.length > 0){
            alert(err.join("\r\n"));
            return false;
        }    
        return true;
    }
    function isValidEmail(email){
    return (/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/).test(email);
    }  
    function verifyPassChange(form){
        var err = new Array;
        if(form.cpass.value == "") err.push("Current password missing!");
        if(form.npass.value == "") err.push("New password missing!");
        if(form.npass2.value != form.npass.value) err.push("New password and confirmation doesn't match!");
        if(form.npass.value.length < 5) err.pusg("New password too short! Min 5 chars!");
        if(err.length > 0){
            alert(err.join("\r\n"));
            return false;
        }    
        return true;        
    }    
</script>
<div id="mainBodyLMenu">
    <form method="post" action="index.php" onsubmit="return checkBasicInfo(this)">
    <input type="hidden" name="f" value="updateBasicInfo" />
        <div class="formLine">
            <label>Username</label>
            <input type="text" name="user" value="<?php echo $_SESSION['user'];?>" />
        </div>
        <div class="formLine">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $_SESSION['name'];?>" />
        </div>        
        <div class="formLine">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo $_SESSION['email'];?>" />
        </div>
        <div class="formLine">
            <label>&nbsp;</label>
            <input type="submit" value="Update basic info" />
        </div>        
    </form>
    <form method="post" action="index.php" onsubmit="verifyPassChange(this)">
    <input type="hidden" name="f" value="changePassword" />
        <div class="formLine">
            <label>Current Password</label>
            <input type="password" name="cpass" />
        </div>
        <div class="formLine">
            <label>New Password</label>
            <input type="password" name="npass" />
        </div>        
        <div class="formLine">
            <label>Confirm Password</label>
            <input type="password" name="npass2" />
        </div>
        <div class="formLine">
            <label>&nbsp;</label>
            <input type="submit" value="Change password" />
        </div>        
    </form>    
</div>