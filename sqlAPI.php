<?php
  $sqlResource;

  function sqlConnect ($username, $password, $database) {
    global $sqlResource;
    $sqlResource = mysql_connect(localhost,$username,$password) or die("Unable to connect to database");
    @mysql_select_db($database) or die("Unable to select database");
    return true;
  }

  function sqlQuery($query) {
    global $sqlResource;
    global $disableSQLAdd;

    writeDebugString($query);
    $result = mysql_query($query) or die(mysql_error($sqlResource));

    return $result;
  }

  function sqlClose () {
    mysql_close();
  }
?>


