<?php

/**
 * playercard.php
 *
 * @version 1
 * @copyright 2008 By Eumele for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);
includeLang('playercard');
		$BodyTPL = gettemplate('playercard');
        $RowsTPL = gettemplate('playercard_rows');
		$parse   = $lang;
		
		$playerid  = (isset($_POST['playerid']))  ? $_POST['playerid']  : $_GET['playerid'];
	if (!isset($playerid)) {
		$playerid  = 0;
	}
		$ownid  = (isset($_POST['ownid']))  ? $_POST['ownid']  : $_GET['ownid'];
	if (!isset($ownid)) {
		$ownid  = 1;
	}

		$PlayerCard = doquery("SELECT * FROM {{table}} WHERE `id` = '". $playerid ."';", 'users');
while($daten = mysql_fetch_array($PlayerCard)){

$gesamtkaempfe = 0;
$gesamtkaempfe        		= $daten['wons'] + $daten['loos'] +  $daten['draws'];
if ($gesamtkaempfe ==0) {
$siegprozent				=0;
$loosprozent				=0;
$drawsprozent               =0;
}
else {
$siegprozent				= 100 / $gesamtkaempfe * $daten['wons'];
$loosprozent				= 100 / $gesamtkaempfe * $daten['loos'];
$drawsprozent				= 100 / $gesamtkaempfe * $daten['draws'];
}

if (!$daten['ally_id'])   $daten['ally_id'] = "- - -";
if (!$daten['ally_name']) $daten['ally_name'] = "- - -";

$Playerplanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '". $daten['galaxy'] ."' and `system` = '". $daten['system'] ."' and `planet` = '". $daten['planet'] ."';", 'planets');
while($planets = mysql_fetch_array($Playerplanet)){
$parse['userplanet']      	= $planets['name'];
													}
$Playerpoints = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $playerid ."';", 'statpoints');
while($points = mysql_fetch_array($Playerpoints)){
$parse['tech_rank']      	= pretty_number( $points['tech_rank'] );
$parse['tech_points']      	= pretty_number( $points['tech_points'] );
$parse['build_rank']      	= pretty_number( $points['build_rank'] );
$parse['build_points']     	= pretty_number( $points['build_points'] );
$parse['defs_rank']      	= pretty_number( $points['defs_rank'] );
$parse['defs_points']      	= pretty_number( $points['defs_points'] );
$parse['fleet_rank']      	= pretty_number( $points['fleet_rank'] );
$parse['fleet_points']      = pretty_number( $points['fleet_points'] );
$parse['total_rank']      	= pretty_number( $points['total_rank'] );
$parse['total_points']     	= pretty_number( $points['total_points'] );
}
													
$parse['player_buddy']      = "<a href=\"buddy.php?a=2&amp;u=" . $UsrRow['id'] . "\" title=\"Freundesanfrage stellen\">". $lang['BUDDY'] ."</a>";
$parse['player_mes']        = "<a href=\"messages.php?mode=write&id=" . $playerid . "\">". $lang['PN'] ."</a>";
$parse['username']      	= $daten['username'];
$parse['avatar'] 	        = $daten['avatar'];
$parse['galaxy']            = $daten['galaxy'];
$parse['system']            = $daten['system'];
$parse['planet']            = $daten['planet'];
$parse['register_time']     = $daten['register_time'];
$parse['ally_id']           = $daten['ally_id'];
$parse['ally_name']         = $daten['ally_name'];
$parse['wons']              = pretty_number( $daten['wons'] );
$parse['loos']              = pretty_number( $daten['loos'] );
$parse['draws']             = pretty_number( $daten['draws'] );
$parse['kbmetal']           = pretty_number( $daten['kbmetal'] );
$parse['kbcrystal']         = pretty_number( $daten['kbcrystal'] );
$parse['lostunits']         = pretty_number( $daten['lostunits'] );
$parse['desunits']          = pretty_number( $daten['desunits'] );
$parse['gesamtkaempfe']     = pretty_number( $gesamtkaempfe );
$parse['siegprozent']       = round($siegprozent, 2);
$parse['loosprozent']       = round($loosprozent, 2);
$parse['drawsprozent']      = round($drawsprozent, 2);






}
		
		display(parsetemplate(gettemplate('playercard'), $parse), $lang['playercard'], false);



?>
