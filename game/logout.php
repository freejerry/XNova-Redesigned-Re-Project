<?php
/*
 * logout.php
 *
 * @version 1.0
 * @copyright 2008 by ?????? for XNova
 *
*/
@include('config1.php');
$log_out_sql = new database($dbsettings);
getLang('login');
setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
info( "<blink>".$lang['see_you']."</blink>", $lang['session_closed'], LOGINURL);
session_destroy();
unset($log_out_sql);
// -----------------------------------------------------------------------------------------------------------
// History version
?>
