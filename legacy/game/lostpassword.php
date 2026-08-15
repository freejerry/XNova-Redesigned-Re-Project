<?php
 /**
  * Generic Page
  * This page will look up the file from the "files" folder so all universes can be the same
  */

$phpself = $_SERVER['PHP_SELF'];
$file = basename($phpself);
$path = "../base/";
$filepath = $path.$file;

include($filepath);
?>