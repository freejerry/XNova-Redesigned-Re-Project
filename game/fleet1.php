<?php

/**
 * fleet1.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

getLang('fleet');
$parse = $lang;

//Get max fleets origional XN0va code
$MaxFlyingFleets = doquery("SELECT COUNT(owner_userid) AS `actcnt` FROM {{table}} WHERE `owner_userid` = '".$user['id']."' AND `fleet_mess` = '0' ;", 'fleets', true); $MaxFlyingFleets = $MaxFlyingFleets['actcnt'];
$MaxExpedition		= $user[$resource[124]];
$ExpeditionEnCours	= 0;
if ($MaxExpedition >= 1) {
	$maxexpde  = doquery("SELECT COUNT(owner_userid) AS `expedi` FROM {{table}} WHERE `owner_userid` = '".$user['id']."' AND `mission` = '15' AND `fleet_mess` = '0' ;", 'fleets', true);
	$ExpeditionEnCours  = $maxexpde['expedi'];
	$EnvoiMaxExpedition = 1 + floor( $MaxExpedition / 3 );
}
$MaxFlottes = eval($formulas['max_fleets']);
//max fleets got :)

//Any reason why not fleet? ATM no.
$nofleet = false;
//If he has no ships.
$ships = 0; for($n=200;$n<300;$n++){$ships += $planetrow[$resource[$n]];}
if($ships == 0){
	$nofleet = true;
	$nofleetreason = "There are no ships on this planet.";
}
//Block users on vacation mode
elseif ($user['urlaubs_modus']==1){
	$nofleet = true;
	$nofleetreason = "You may not build things on vacation mode. Please de-active it if you have returned.";
}elseif ($MaxFlottes == $MaxFlyingFleets) {
	//$nofleet = true;
	$$nofleetreason = $lang['fl_noslotfree'];
}else{
	//$nofleet = true;
	$nofleetreason = "Fleets are not programmed yet.";
}

$parse['avl_fleets'] = $MaxFlyingFleets."/".$MaxFlottes;
$parse['avl_exp'] = $ExpeditionEnCours."/".$MaxExpedition;

if($nofleet){
	$parse['message'] = $nofleetreason;
	
	if($_GET['axah']){
		makeAXAH(parsetemplate(gettemplate('fleet/0'), $parse));
	}else{
		displaypage(parsetemplate(gettemplate('fleet/0'), $parse), $lang['fl_title']);
	}
}

if($planetrow[$resource[43]] > 0){
	$parse['show_jg'] = '';
}else{
	$parse['show_jg'] = 'display:none;';
}

$missiontype = array(
1 => $lang['type_mission'][1],
2 => $lang['type_mission'][2],
3 => $lang['type_mission'][3],
4 => $lang['type_mission'][4],
5 => $lang['type_mission'][5],
6 => $lang['type_mission'][6],
7 => $lang['type_mission'][7],
8 => $lang['type_mission'][8],
9 => $lang['type_mission'][9],
15 => $lang['type_mission'][15]
);

// Histoire de recuperer les infos passées par galaxy
$galaxy         = idstring($_GET['galaxy']);
$system         = idstring($_GET['system']);
$planet         = idstring($_GET['planet']);
$planettype     = idstring($_GET['planettype']);
$target_mission = idstring($_GET['target_mission']);

if (!$galaxy) {	$galaxy = $planetrow['galaxy']; }
if (!$system) {	$system = $planetrow['system']; }
if (!$planet) {	$planet = $planetrow['planet']; }
if (!$planettype) {	$planettype = $planetrow['planet_type']; }

if (!$planetrow) {
	info($lang['fl_noplanetrow'], $lang['fl_error'],"./?page=overview","./?page=overview");
}

// Prise des coordonnées sur la ligne de commande
$galaxy         = intval($_GET['galaxy']);
$system         = intval($_GET['system']);
$planet         = intval($_GET['planet']);
$planettype     = intval($_GET['planettype']);
$target_mission = intval($_GET['target_mission']);
$ShipData       = "";
$parse['military_ships'] = ""; $parse['civil_ships'] = "";

$stationaly_ships = array(212);
foreach ($reslist['fleet'] as $n => $i) {
	if(!in_array($i,$stationaly_ships)){
		//Now load the new template...
		if($planetrow[$resource[$i]] <= 0){ $shinfo['class'] = 'off'; $shinfo['readonly'] = 'readonly="readonly"'; }
		else{ $shinfo['class'] = 'on'; $shinfo['readonly'] = ''; }
		$shinfo['id'] = $i;
		$shinfo['name'] = $lang['names'][$i];
		$shinfo['avl_ships'] = $planetrow[$resource[$i]];

		if(in_array($i,$reslist['foffense'])){
			$parse['military_ships'] .= parsetemplate(gettemplate('fleet/ship'), $shinfo);
		}elseif(in_array($i,$reslist['fpassive'])){
			$parse['civil_ships'] .= parsetemplate(gettemplate('fleet/ship'), $shinfo);
		}
	}
}

$page = parsetemplate(gettemplate('fleet/1'), $parse);
if($_GET['axah']){
	makeAXAH($page);
}else{
	displaypage($page, $lang['Fleet']);
}

// Updated by Chlorel. 16 Jan 2008 (String extraction, bug corrections, code uniformisation
// Created by Perberos. All rights reversed (C) 2006
?>
