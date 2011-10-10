<?php
define("INSIDE",true);
require('game/config1.php');

$link = mysql_connect($dbsettings["server"], $dbsettings["user"], $dbsettings["pass"]) or die(mysql_error());
mysql_select_db($dbsettings["name"]) or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `test123` (`val` text NOT NULL)") or die(mysql_error());

mysql_query("DROP TABLE IF EXISTS `test123`") or die(mysql_error());
?>
