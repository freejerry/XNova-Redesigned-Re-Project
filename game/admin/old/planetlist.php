<?php

/**
 * planetlist.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {

		
	$order = $_GET["sort"];		
		
	$parse = $lang;
	$query = doquery("SELECT `id`, `id_owner`, `name`,  `field_current`, `field_max`, `galaxy`, `system`, `planet` FROM {{table}} WHERE planet_type=1 ORDER BY ".$order." ASC", "planets");
	$i = 0;
	while ($u = mysql_fetch_array($query)) {
		if ($user['authlevel'] >= 2) {
			$editplanet = "<td class=b><center><b><a href='planetlist.php?action=edit&id=".$u['id'] ."&sort=id'><img src='../../skins/madnessred/pic/appwiz.gif' border='0' /></b></center></td>";
		} else {
			$editplanet = "<td class=b><center><b><img src='../../skins/madnessred/pic/abort.gif' border='0' /></b></center></td>";
		}
		$parse['planetes'] .= "<tr>"
		. "<td class=b><center><b>" . $u['id'] . "</b></center></td>"
		. "<td class=b><center><b>" . $u['id_owner'] . "</b></center></td>"
		. "<td class=b><center><b>" . $u['name'] . "</b></center></td>"
		. "<td class=b><center><b>" . $u['field_max'] . "</b></center></td>"
		. "<td class=b><center><b>" . $u['field_current'] . "</b></center></td>"
		. "<td class=b><center><b>" . $u['galaxy'] . "</b></center></td>"
		. "<td class=b><center><b>" . $u['system'] . "</b></center></td>"
		. "<td class=b><center><b>" . $u['planet'] . "</b></center></td>"
		. $editplanet
		. "</tr>";
		$i++;
	}

	if ($i == "1")
	$parse['planetes'] .= "<tr><th class=b colspan=9>There is only 1 planet</th></tr>";
	else
	$parse['planetes'] .= "<tr><th class=b colspan=9>There are {$i} planets</th></tr>";

	if(isset($_GET['action']) && isset($_GET['id'])) {
		$id = intval($_GET['id']);
		$query  = doquery("SELECT * FROM {{table}} WHERE planet_type=1 AND id='".$id."' LIMIT 1", "planets");
		$planet = mysql_fetch_array($query);
		$parse['show_edit_form'] = parsetemplate(gettemplate('admin/planet_edit_form'),$planet);
	}
	if(isset($_POST['submit'])) {

		$edit_id 	= intval($_POST['currid']);
		$planetname = mysql_real_escape_string($_POST['planetname']);
		$fields_max = intval($_POST['felder']);
		$query = doquery("UPDATE {{table}} SET
							`name` 				= '".$planetname."', 
							`field_max` 		= '".$fields_max."',
							`metal`				= '".intval($_POST['metal'])."',
							`crystal`			= '".intval($_POST['crystal'])."',
							`deuterium`			= '".intval($_POST['deuterium'])."', 
							`small_ship_cargo` 	= '".intval($_POST['small_ship_cargo'])."', 
							`big_ship_cargo` 	= '".intval($_POST['big_ship_cargo'])."', 
							`light_hunter`		= '".intval($_POST['light_hunter'])."', 
							`heavy_hunter`		= '".intval($_POST['heavy_hunter'])."', 
							`crusher`			= '".intval($_POST['crusher'])."', 
							`battle_ship`		= '".intval($_POST['battle_ship'])."', 
							`colonizer`			= '".intval($_POST['colonizer'])."', 
							`recycler`			= '".intval($_POST['recycler'])."', 
							`spy_sonde`			= '".intval($_POST['spy_sonde'])."', 
							`bomber_ship`		= '".intval($_POST['bomber_ship'])."', 
							`solar_satelit`		= '".intval($_POST['solar_satelit'])."', 
							`destructor`		= '".intval($_POST['destructor'])."', 
							`dearth_star`		= '".intval($_POST['dearth_star'])."', 
							`battleship`		= '".intval($_POST['battleship'])."',
							`chuck`				= '".intval($_POST['chuck'])."',
							`gr_troop`			= '".intval($_POST['grtroop'])."',
							`misil_launcher`	= '".intval($_POST['misil_launcher'])."',
							`small_laser`		= '".intval($_POST['small_laser'])."',
							`big_laser`			= '".intval($_POST['big_laser'])."',
							`gauss_canyon`		= '".intval($_POST['gauss_canyon'])."',
							`ionic_canyon`		= '".intval($_POST['ionic_canyon'])."',
							`buster_canyon`		= '".intval($_POST['buster_canyon'])."',
							`small_protection_shield` 	= '".intval($_POST['small_protection_shield'])."',
							`big_protection_shield` 	= '".intval($_POST['big_protection_shield'])."',
							`sm_grav_dome` 				= '".intval($_POST['sm_grav'])."',
							`sm_grav_dome` 				= '".intval($_POST['xl_grav'])."',
							`interceptor_misil` 		= '".intval($_POST['interceptor_misil'])."',
							`interplanetary_misil` 		= '".intval($_POST['interplanetary_misil'])."',
							`metal_mine`				= '".intval($_POST['metal_mine'])."',
							`crystal_mine`				= '".intval($_POST['crystal_mine'])."',
							`deuterium_sintetizer`		= '".intval($_POST['deuterium_sintetizer'])."',
							`solar_plant`				= '".intval($_POST['solar_plant'])."',
							`fusion_plant`				= '".intval($_POST['fusion_plant'])."',
							`robot_factory`				= '".intval($_POST['robot_factory'])."',
							`nano_factory`				= '".intval($_POST['nano_factory'])."',
							`hangar`					= '".intval($_POST['hangar'])."',
							`metal_store`				= '".intval($_POST['metal_store'])."',
							`crystal_store`				= '".intval($_POST['crystal_store'])."',
							`deuterium_store`			= '".intval($_POST['deuterium_store'])."',
							`laboratory`				= '".intval($_POST['laboratory'])."',
							`terraformer`				= '".intval($_POST['terraformer'])."',
							`ally_deposit`				= '".intval($_POST['ally_deposit'])."',
							`silo`						= '".intval($_POST['silo'])."'
							  WHERE `id` = '".$edit_id."' LIMIT 1",'planets');


		AdminMessage ('<meta http-equiv="refresh" content="1; url=planetlist.php?sort=id">Planet wurde erfolgreich geändert', 'Planeten anpassen');
	}
	display(parsetemplate(gettemplate('admin/planetlist_body'), $parse), 'Planetlist', false, '', true);
} else {
	message($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>