<?php

/**
 * chat_add.php
 *
 * @version 1.0
 * @version 1.2 by Ihor
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	// On récupère les informations du message et de l'envoyeur
	if (isset($_POST["msg"]) && isset($user['username'])) {
	   //if(isset($_POST['colour'])){
	      $msg  = "[c=".$_POST['colour']."]";
	      $msg .= addslashes ($_POST["msg"]);
	      $msg .= "[/c]";
	   //}else{
	   //   $msg  = addslashes ($_POST["msg"]);
	   //}
	   if($user['auth_level'] > 0){
	      $nick  = "<font color=red>";
	      $nick .= addslashes ($user['username']);
	      $nick .= "</font>";
	   }else{
	      $nick  = addslashes ($user['username']);
	   }
	   $chat_type = addslashes ($_POST["chat_type"]);
	   $ally_id = addslashes ($_POST["ally_id"]);
	   $msg = iconv('UTF-8', 'CP1251', $msg); // CHANGE IT !!!!!!!!!!!
	}
	else {
	   $msg="";
	   $nick="";
	}
	if ($msg!="" && $nick!="") {
		if($chat_type=="ally" && $ally_id!=""){
			$query = doquery("INSERT INTO {{table}}(user, ally_id,message, timestamp) VALUES ('".$nick."','".mysql_escape_string($ally_id)."','".mysql_escape_string($msg)."', '".time()."')", "chat") or die(mysql_error);
			$chat_get_inf = "?chat_type=ally";
		}else{
			$query = doquery("INSERT INTO {{table}}(user, ally_id, message, timestamp) VALUES ('".$nick."','0', '".mysql_escape_string($msg)."', '".time()."')", "chat") or die(mysql_error);
		}
	}

header('location: chat.php'.$chat_get_inf);

?>