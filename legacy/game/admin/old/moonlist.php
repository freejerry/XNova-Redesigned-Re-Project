<?php


/**
 * moonlist.php
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
	includeLang('overview');

	$order = $_GET["sort"];	
	
	$parse = $lang;
	$query = doquery("SELECT * FROM {{table}} WHERE planet_type='3' ORDER BY ".$order." ASC", "planets");
	$i = 0;
	while ($u = mysql_fetch_array($query)) {
		if ($user['authlevel'] >= 2) {
			$editmoon = "<td class=b><center><b><a href='moonlist.php?action=edit&id=".$u['id'] ."&sort=id'><img src='../../skins/madnessred/pic/appwiz.gif' border='0' /></b></center></td>";
		} else {
			$editmoon = "<td class=b><center><b><img src='../../skins/madnessred/pic/abort.gif' border='0' /></b></center></td>";
		}
		$parse['moon'] .= "<tr>"
		. "<td class=b><center><b>" . $u[0] . "</center></b></td>"
		. "<td class=b><center><b>" . $u[1] . "</center></b></td>"
		. "<td class=b><center><b>" . $u[2] . "</center></b></td>"
		. "<td class=b><center><b>" . $u[18] . "</center></b></td>"
		. "<td class=b><center><b>" . $u[4] . "</center></b></td>"
		. "<td class=b><center><b>" . $u[5] . "</center></b></td>"
		. "<td class=b><center><b>" . $u[6] . "</center></b></td>"
		. $editmoon
		. "</tr>";
		$i++;
	}

	if ($i == 1) {
		$parse['moon'] .= "<tr><th class=b colspan=8>There is only 1 moon</th></tr>";
	}else{
		$parse['moon'] .= "<tr><th class=b colspan=8>There are {$i} moons</th></tr>";
	}

	if(isset($_GET['action']) && isset($_GET['id'])) {
		$id = intval($_GET['id']);
		$query  = doquery("SELECT * FROM {{table}} WHERE planet_type=3 AND id='".$id."' LIMIT 1", "planets");
		$planet = mysql_fetch_array($query);
		$parse['show_edit_form'] = parsetemplate(gettemplate('admin/moon_edit_form'),$planet);
	}
	if(isset($_POST['submit'])) {

		$edit_id 	= intval($_POST['currid']);
		$planetname = mysql_real_escape_string($_POST['mondname']);
		$fields_max = intval($_POST['felder']);
		$query = doquery("UPDATE {{table}} SET
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
							`robot_factory`				= '".intval($_POST['robot_factory'])."',
							`hangar`					= '".intval($_POST['hangar'])."',
							`metal_store`				= '".intval($_POST['metal_store'])."',
							`crystal_store`				= '".intval($_POST['crystal_store'])."',
							`deuterium_store`			= '".intval($_POST['deuterium_store'])."',
							`ally_deposit`				= '".intval($_POST['ally_deposit'])."',
							`phalanx`					= '".intval($_POST['phalanx'])."',
							`mondbasis`					= '".intval($_POST['mondbasis'])."',
							`sprungtor`					= '".intval($_POST['sprungtor'])."'
							 WHERE `id` = '".$edit_id."' LIMIT 1",'planets');

		
		AdminMessage ('<meta http-equiv="refresh" content="1; url=moonlist.php?sort=id">Mond wurde erfolgreich geändert', 'Mond anpassen');
	}

	display(parsetemplate(gettemplate('admin/moonlist_body'), $parse), 'Lunalist' , false, '', true);

} else {
	message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>