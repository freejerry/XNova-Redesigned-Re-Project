<?PHP

/**
 * leftmenu.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */

/*
define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);
*/
function ShowLeftMenu ( $Level , $Template = 'redesign_menu') {
	global $lang, $dpath, $game_config;

	includeLang('leftmenu');
	includeLang('changelog');
	//includeLang('sides');

	$MenuTPL                  = gettemplate( $Template );
	$InfoTPL                  = gettemplate( 'serv_infos' );
	$parse                    = $lang;
	$use_alliances			  = 1;
	$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
	$parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;
	$SubFrame                 = parsetemplate( $InfoTPL, $parse );
	$parse['server_info']     = $SubFrame;
	$parse['XNovaRelease']    = VERSION;
	$parse['dpath']           = $dpath;
	$parse['forum_url']       = $game_config['forum_url'];
	$parse['mf']              = "_self";
	$rank['total_rank']       = 1;
	//$rank                     = doquery("SELECT `total_rank` FROM {{table}} WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $user['id'] ."';",'statpoints',true);
	$parse['user_rank']       = $rank['total_rank'];
	
	$parse['option1']  = "<tr height=\"22\">\n
\t<td colspan=\"2\" align=\"center\" style=\"border-top: 0px; color: #FFFFFF; font-size: 10px;\" background=\"../graphics/menu_optbg.png\">\n
\t\t<div>\n\t\t\t";
	$parse['option2']  = "\n\t\t</div>\n
\t</td>\n
</tr>\n\n\n\n";
	
	if ($Level > 0) {
		$parse['ADMIN_LINK']  = "<a href=\"admin/overview.php\"><font color=\"lime\">".$lang['user_level'][$Level]."</font></a>";
	} else {
		$parse['ADMIN_LINK']  = "";
	}
	//Lien suppl�mentaire d�termin� dans le panel admin
	if ($game_config['link_enable'] == 1) {
		$parse['added_link']  = "<a href=\"".$game_config['link_url']."\" target=\"_blank\">".stripslashes($game_config['link_name'])."</a></div></td>
		</tr>";
	} else {
		$parse['added_link']  = "";
	}
	
	//Maintenant on v�rifie si les annonces sont activ�es ou non
	if ($game_config['enable_marchand'] == 1) {
		$parse['marchand_link']  = "<a href=\"marchand.php\" target=\"".$parse['mf']."\">".$lang['Marchand']."</a>";
	} else {
		$parse['marchand_link']  = "";
	}
	
	//Maintenant on v�rifie si les annonces sont activ�es ou non
	if ($game_config['enable_announces'] == 1) {
		$parse['announce_link']  = "<a href=\"annonce.php\" target=\"".$parse['mf']."\">".$lang['Annonces']."</a>";
	} else {
		$parse['announce_link']  = "";
	}
	
	//Maintenant les notes
	if ($game_config['enable_notes'] == 1) {
		$parse['notes_link']  = "<a href=\"#\" onClick=\"f('notes.php', 'Notes');\" accesskey=\"n\">Notes</a>";
	} else {
		$parse['notes_link']  = "";
	}
	$parse['servername']   = $game_config['game_name'];
	$Menu                  = parsetemplate( $MenuTPL, $parse);

	return $Menu;
}
	//$Menu = ShowLeftMenu ( $user['authlevel'] );
	//display ( $Menu, "Menu", '', false );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour XNova version future
// 1.1 - Modification pour gestion Admin / Game OP / Modo
?>