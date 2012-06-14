<?PHP

/**
 * leftmenu.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

/*
define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);
*/
function ShowAdminLeftMenu ( $Level ) {
	global $lang, $dpath, $game_config;
	includeLang('leftmenu');
	
	$Template = 'admin/left_menu';
	$MenuTPL                  = gettemplate( $Template );
	$InfoTPL                  = gettemplate( 'serv_infos' );
	$SubFrame                 = parsetemplate( $InfoTPL, $parse );
	$parse['server_info']     = $SubFrame;


	$parse                 = $lang;
	$parse['mf']           = "_self";
	$parse['dpath']        = $dpath;
	$parse['XNovaRelease'] = VERSION;
	$parse['servername']   = XNova;
	$Menu                  = parsetemplate($MenuTPL,$parse);

	return $Menu;
}
	//$Menu = ShowAdminLeftMenu ( $user['authlevel'] );
	//display ( $Menu, "Menu", '', false );


?>
