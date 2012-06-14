<?php //$loadstart = microtime(true);

/**
 * index.php
 *
 * @version 1.4
 * @copyright 2008 by Anthony for XNova Redesigned
 */

define('INSIDE'  , true);
define('INSTALL' , false);

define('ROOT_PATH' , '');
include_once(ROOT_PATH . 'common.php');



//Template constants.
define('GAME_SKIN',(strlen($userclass->skin) > 0 ? $userclass->skin : DEFAULT_SKIN));
define('PLANET_NAME',$planetrow['name']);
define('USER_NAME',$userclass->username);

//PlanetResourceUpdate($userclass->uarray,$planetrow,time());

//Skin config?
$skin_config = file(GAME_SKIN."/config.txt");
if(substr($skin_config[0], 0, 26) == '!!--Skin Configuration--!!'){
	define('HEADER_CACHE',str_replace("{{skin}}",GAME_SKIN,$skin_config[2]));
}
else{
	define('HEADER_CACHE',GAME_SKIN.'/headerCache/');
}

if($_GET['iframe'] == '1'){
	include_once('iframe.php');
}else{

	switch ($_GET['page']) {
		

		case 'ticket':
			// --------------------------------------------------------------------------------------------------
			$cpage = "ticket";
			$pageid = "ticket";
			include_once("support.php");

			break;
	}
}

// -----------------------------------------------------------------------------------------------------------
// Changelog
// 1.0 - First version by MadnessRed
?>
