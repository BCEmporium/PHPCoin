<?php
    defined("_V") || die("Direct access not allowed!");
    
    $new = $b->getnewaddress($_SESSION['btaccount']);
    echo $new;
?>