<?php
    defined("_V") || die("Direct access not allowed!");
    if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1){
?>	
<div id="adminMenu">
    <ul>
        <li><a href="index.php?f=bitcoindStatus">Status</a></li>
    </ul>
</div>	
<?php	
}	
?>
