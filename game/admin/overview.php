<?php

/**
 * overview.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */


includeLang('admin');

if($_GET['cmd'] == 'sort'){ $TypeSort = $_GET['type']; }
else{ $TypeSort = "id"; }

$PageTPL  = gettemplate('admin/overview_body');
$RowsTPL  = gettemplate('admin/overview_rows');

$parse						= $lang;
$parse['dpath']				= $dpath;
$parse['mf']				= $mf;
$parse['adm_ov_data_yourv']	= colourRed(VERSION);
$info = @file(XNOVAUKLINK."info.php");
$parse['adm_ov_here']		= $info[0];
$parse['xnovalink']			= XNOVAUKLINK;

$LastMin = doquery("SELECT * FROM {{table}} WHERE `onlinetime` >= '". (time() - 60) ."' ORDER BY `". $TypeSort ."` ASC;", 'users');

$Count      = 0;
$Color      = "lime";
while ( $TheUser = mysql_fetch_array($LastMin) ) {
	if ($PrevIP != "") {
		if ($PrevIP == $TheUser['user_lastip']) {
			$Color = "red";
		} else {
			$Color = "lime";
		}
	}
	
	//$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $TheUser['id'] . "';", 'statpoints', true);
	$Bloc['dpath']               = $dpath;
	$Bloc['adm_ov_altpm']        = $lang['adm_ov_altpm'];
	$Bloc['adm_ov_wrtpm']        = $lang['adm_ov_wrtpm'];
	$Bloc['adm_ov_data_id']      = $TheUser['id'];
	$Bloc['adm_ov_data_name']    = $TheUser['username'];
	$Bloc['adm_ov_data_agen']    = $TheUser['user_agent'];
	$Bloc['current_page']    = $TheUser['current_page'];
	$Bloc['usr_s_id']    = $TheUser['id'];

	$Bloc['adm_ov_data_clip']    = $Color;
	$Bloc['adm_ov_data_adip']    = $TheUser['user_lastip'];
	$Bloc['adm_ov_data_ally']    = $TheUser['ally_name'];
	$Bloc['adm_ov_data_point']   = pretty_number ( $UserPoints['total_points'] );
	$Bloc['adm_ov_data_activ']   = pretty_time ( time() - $TheUser['onlinetime'] );
	$Bloc['adm_ov_data_pict']    = "m.gif";
	$PrevIP                      = $TheUser['user_lastip'];
			
	//Tweaks vue g�n�rale 
	$Bloc['usr_email']    = $TheUser['email'];
	$Bloc['usr_xp_raid']    = $TheUser['xpraid'];
	$Bloc['usr_xp_min']    = $TheUser['xpminier'];
									
	if ($TheUser['urlaubs_modus'] == 1) {
		$Bloc['state_vacancy']  = "<img src=\"".$darkevo_root_path."images/true.png\" >";
	} else {
		$Bloc['state_vacancy']  = "<img src=\"".$darkevo_root_path."images/false.png\">";
	}
				
	if ($TheUser['bana'] == 1) {
		$Bloc['is_banned']  = "<img src=\"".$darkevo_root_path."images/banned.png\" >";
	} else {
		$Bloc['is_banned']  = $lang['is_banned_lang'];
	}
	$Bloc['usr_planet_gal']    = $TheUser['galaxy'];
	$Bloc['usr_planet_sys']    = $TheUser['system'];
	$Bloc['usr_planet_pos']    = $TheUser['planet'];
	
	$parse['adm_ov_data_table'] .= parsetemplate( $RowsTPL, $Bloc );
	$Count++;
}

$parse['adm_ov_data_count']  = $Count;

$bloc['content'] = parsetemplate($PageTPL, $parse);
$bloc['title'] = $lang['sys_overview'];

?>
