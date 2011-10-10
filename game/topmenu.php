<?php

/**
 * topmenu.php
 *
 * @version 1.0
 * @copyright 2008 by msmith for XNova Redesigned
 */

function GetTopLinks(){
global $game_config, $lang;

die("blah");
	getLang('menu');
	$parse				= $lang[$lang['user']];
	
	//$parse['body']	= $body;
	$parse['forum_url']	= $game_config['forum_url'];
	$parse['game_name']	= $game_config['game_name'];
	
	print_r($lang);
	$page = parsetemplate(gettemplate('topmenu'), $parse);
	return $page;
}
?>