<?php

/**
 * chat.php
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

	includeLang('chat');
	$BodyTPL = gettemplate('chat_body');

	$nick = $user['username'];
	$parse = $lang;

	if ($_GET) {
		if($_GET["chat_type"]=="ally"){
			$parse['chat_type'] = $_GET["chat_type"];
			$parse['ally_id']   = $user['ally_id'];
		}
	}
	$page = parsetemplate($BodyTPL, $parse);
	//displaypage($page, $lang['Chat'], false);
	display($page, $lang['Chat'], false);

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?>