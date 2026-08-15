<?php

/**
 * chat.php
 *
 * @version 1.0
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

	$page = parsetemplate($BodyTPL, $parse);
	display($page, $lang['Chat'], false);

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?>