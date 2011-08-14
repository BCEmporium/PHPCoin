<?php
    defined("_V") || die("Direct access not allowed!");
    
  function isValidEmail($email){
    return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email);
  }
  
  function makeSQLSafe($str){
      if(get_magic_quotes_gpc()) $str = stripslashes($str);
      return mysql_real_escape_string($str);
  }
    
?>