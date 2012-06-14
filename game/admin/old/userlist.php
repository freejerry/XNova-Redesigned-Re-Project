<?php

/**
 * userlist.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
include($xnova_root_path . '/includes/madnessred.php');

	//if (($user['authlevel'] >= 2) && ($context['user']['is_admin'])) {
	if ($user['authlevel'] >= 1) {
		
	includeLang('admin');
	if ($_GET['cmd'] == 'dele') {
		if ($user['authlevel'] >= 3) {
			DeleteSelectedUser ( intval($_GET['user']) );
		}else{
			message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
		}
	}
	if ($_GET['cmd'] == 'sort') {
		$TypeSort = mysql_real_escape_string($_GET['type']);
	} else {
		$TypeSort = "id";
	}

	$PageTPL = gettemplate('admin/userlist_body');
	$RowsTPL = gettemplate('admin/userlist_rows');

	$query   = doquery("SELECT * FROM {{table}} ORDER BY `". $TypeSort ."` ASC", 'users');

	$parse                 = $lang;
	$parse['adm_ul_table'] = "";
	$i                     = 0;
	$Color                 = "lime";
	while ($u = mysql_fetch_assoc ($query) ) {
		if ($PrevIP != "") {
			if ($PrevIP == $u['user_lastip']) {
				$Color = "red";
			} else {
				$Color = "lime";
			}
		}
		if ($user['authlevel'] >= 2) {
			$Bloc['adm_ul_data_edit'] = "<th><center><b><a href='?action=edit&id=".$u['id'] ."&sort=id'><img src='http://darkevo.org/skins/madnessred/pic/appwiz.gif' border='0' /></b></center></th>";
		} else {
			$Bloc['adm_ul_data_edit'] = "<th><center><b><img src='http://darkevo.org/skins/madnessred/pic/abort.gif' border='0' /></b></center></th>";
		}
		
		$path_to_img = "http://madnessred.co.cc/img/agent/";
		$browser = BrowserInfo($u['user_agent'],$path_to_img);
		$Browser_img = $browser['brws']['img'];
		$OS_img = $browser['osys']['img'];
		
		$monde = doquery("SELECT id FROM {{table}} WHERE id_owner= '".$u['id']."'",'lunas');
		$Bloc['adm_ul_data_id']     = $u['id'];
		$Bloc['adm_ul_data_name']   = $u['username'];
		$Bloc['adm_ul_data_agent']  = "<img src=\"".$Browser_img."\" border=\"0\" width=\"18\" alt=\"".$u['user_agent']."\" />";
		$Bloc['adm_ul_data_agent']  .= "<img src=\"".$OS_img."\" border=\"0\" width=\"18\" alt=\"".$u['user_agent']."\" />";
		$Bloc['adm_ul_data_hp']		= $u['galaxy'].':'.$u['system'].':'.$u['planet'];
		$Bloc['adm_ul_data_moons']	= mysql_num_rows($monde);
		$Bloc['adm_ul_data_mail']   = $u['email'];
		$Bloc['adm_ul_data_adip']   = "<font color=\"".$Color."\">". $u['user_lastip'] ."</font>";
		$Bloc['adm_ul_data_regd']   = gmdate ( "d/m/Y G:i:s", $u['register_time'] );
		$Bloc['adm_ul_data_lconn']  = gmdate ( "d/m/Y G:i:s", $u['onlinetime'] );
		$Bloc['adm_ul_data_banna']  = ( $u['bana'] == 1 ) ? "<a href # title=\"". gmdate ( "d/m/Y G:i:s", $u['banaday']) ."\">". $lang['adm_ul_yes'] ."</a>" : $lang['adm_ul_no'];
		$Bloc['adm_ul_data_umod']  	= $u['urlaubs_modus'] ? 'Ja' : 'Nein';
		//$Bloc['adm_ul_data_actio']  = "<a href=\"userlist.php?cmd=dele&user=".$u['id']."\"><img src=\"../images/r1.png\"></a>"; // Lien vers actions 'effacer'
		$PrevIP                     = $u['user_lastip'];
		$parse['adm_ul_table']     .= parsetemplate( $RowsTPL, $Bloc );
		$i++;
	}
	$parse['adm_ul_count'] = $i;

	if(isset($_GET['action']) && isset($_GET['id'])) {
		$id = intval($_GET['id']);
		$query  				= doquery("SELECT * FROM {{table}} WHERE id='".$id."' LIMIT 1", "users");
		$users 					= mysql_fetch_array($query);
		$users['umodchecked'] 	= $users['urlaubs_modus'] ? 'checked=checked' : '';
		$users['banchecked']		= ( $users['bana'] == 1 ) ? 'checked=checked' : '';
		$parse['show_edit_form'] = parsetemplate(gettemplate('admin/user_edit_form'),$users);
	}
	if(isset($_POST['submit'])) {

		$edit_id 	= intval($_POST['currid']);
		$username 	= mysql_real_escape_string($_POST['username']);
		$email 		= mysql_real_escape_string($_POST['email']);
		$bantime    =  intval($_POST['ban_days'] * 86400);
		$bantime    += intval($_POST['ban_hours'] * 3600);
		$bantime    += intval($_POST['ban_mins'] * 60);
		$bantime    += intval($_POST['ban_secs']);
		$bantime    = time() + $bantime;

		if($_POST['gesperrt'] == 1) {
			$bana = '`bana` = 1,`urlaubs_modus` = 1,`banaday` = '. $bantime;

			$bann = doquery("INSERT INTO {{table}} SET
								`who` 		= '".$username."',
								`theme`		= '".mysql_real_escape_string($_POST['reason'])."',
								`who2`		= '".$username."',
								`time`		= '".time()."',
								`longer`	= '".$bantime."',
								`author`	= '".$user['username']."',
								`email`		= '".$user['email']."'",'banned');
		}else{
			$bana = '`bana` = NULL,`banaday` = NULL';
		}
		if($_POST['umod'] == 1) {
			$umod = '`urlaubs_modus` = 1,`urlaubs_until` = '.time();
		}else{
			$umod = '`urlaubs_modus` = 0,`urlaubs_until` = 0';
		}

		$query = doquery("UPDATE {{table}} SET
							`username`		= '".$username."',
							`email`			= '".$email."',
							`adminNotes` 			= '".$_POST['adminNotes']."',
							`researchers` 			= '".intval($_POST['researchers'])."',
							`spy_tech` 				= '".intval($_POST['spy_tech'])."',
							`computer_tech` 		= '".intval($_POST['computer_tech'])."',
							`military_tech` 		= '".intval($_POST['military_tech'])."',
							`defence_tech` 			= '".intval($_POST['defence_tech'])."',
							`shield_tech` 			= '".intval($_POST['shield_tech'])."',
							`energy_tech` 			= '".intval($_POST['energy_tech'])."',
							`hyperspace_tech` 		= '".intval($_POST['hyperspace_tech'])."',
							`combustion_tech` 		= '".intval($_POST['combustion_tech'])."',
							`impulse_motor_tech` 	= '".intval($_POST['impulse_motor_tech'])."',
							`hyperspace_motor_tech` = '".intval($_POST['hyperspace_motor_tech'])."',
							`laser_tech` 			= '".intval($_POST['laser_tech'])."',
							`ionic_tech` 			= '".intval($_POST['ionic_tech'])."',
							`buster_tech` 			= '".intval($_POST['buster_tech'])."',
							`intergalactic_tech` 	= '".intval($_POST['intergalactic_tech'])."',
							`interalliance_tech` 	= '".intval($_POST['interalliance_tech'])."',
							`expedition_tech` 		= '".intval($_POST['expedition_tech'])."',
							`colonisation_tech` 	= '".intval($_POST['colonisation_tech'])."',
							`graviton_tech` 		= '".intval($_POST['graviton_tech'])."',
							 ".$bana.",
							 ".$umod."  
							 WHERE `id` = '".$edit_id."' LIMIT 1",'users');


		AdminMessage ('<meta http-equiv="refresh" content="1; url=userlist.php?sort=id">Player edited', 'Sucess');
	}

	$page = parsetemplate( $PageTPL, $parse );
	display( $page, $lang['adm_ul_title'], false, '', true);
} else {
	message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>