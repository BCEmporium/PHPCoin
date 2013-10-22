<?php
    defined("_V") || die("Direct access not allowed!");
    
  function isValidEmail($email){
    return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email);
  }
  
  function makeSQLSafe($str){
      if(get_magic_quotes_gpc()) $str = stripslashes($str);
      return ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $str) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
  }
    
?>
