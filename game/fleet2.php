<?php

/**
 * fleet2.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova
 */


//Get the language
includeLang('fleet');
getLang('fleet');
$parse = $lang;


//We should they be ent to by default.	
$g = $_GET['galaxy']; if (!$g) {$g = $planetrow['galaxy'];}
$s = $_GET['system']; if (!$s) {$s = $planetrow['system'];}
$p = $_GET['planet']; if (!$p) {$p = $planetrow['planet'];}
$t = $_GET['planet_type']; if (!$t) {$t = $planetrow['planet_type'];}
$parse['PlanetName'] = $planetrow['name'];

if($t == 3){
	$parse['origin1'] = '';
	$parse['origin3'] = '_selected';
}else{
	$parse['origin1'] = '_selected';
	$parse['origin3'] = '';
}

$parse['g'] = $g; $parse['s'] = $s; $parse['p'] = $p; $parse['t'] = $t;


//Now fleet info
$fleet = array(); $speeds = array(); $capacity = 0; $fuel = 0;
foreach ($reslist['fleet'] as $id) {
	//Check we own this type of ship and that we are actually sending some
	if ($planetrow[$resource[$id]] > 0 && $_GET["ship".$id] > 0) {
		//If they have said to many set it to the max
		if($_GET["ship".$id] > $planetrow[$resource[$id]]){
			$_GET["ship".$id] = $planetrow[$resource[$id]];
		}
		//How many of this ship type?
		$fleet[$id] = $_GET["ship".$id];
		
		//What speed?
		$speeds[$id] = GetShipSpeed($id);
		
		//Cargo space
		$capacity += ($pricelist[$id]['capacity'] * $_GET["ship".$id]);
		
		//Fuel use
		if($pricelist[$id]['upgrade'] > 0 && $user[$resource[$pricelist[$id]['drive2']]] > $pricelist[$id]['upgrade']){
			$fuel += ($pricelist[$id]['consumption2'] * $_GET["ship".$id]);
		}else{
			$fuel += ($pricelist[$id]['consumption'] * $_GET["ship".$id]);
		}
		
	}
}
//Check we have a fleet
if(sizeof($speeds) == 0){
	$parse['message'] = $parse['fl_no_ships'];
	
	if($_GET['axah']){
		makeAXAH(parsetemplate(gettemplate('fleet/0'), $parse));
	}else{
		displaypage(parsetemplate(gettemplate('fleet/0'), $parse), $lang['fl_title']);
	}
}
//Carry on
$speed = min($speeds);

//Parse
$parse['maxspeed'] = $speed;
$parse['p_maxspeed'] = pretty_number($speed);


//Some info for javascript and next page
$info = '';
$info .= '<input type="hidden" id="fleet_fuel" name="fleet_fuel" value="'.$fuel.'" />'."\n";
$info .= '<input type="hidden" id="fleet_cargo" name="fleet_cargo" value="'.$capacity.'" />'."\n";
$info .= '<input type="hidden" id="fleet_speed" name="fleet_speed" value="'.$speed.'" />'."\n";
$info .= '<input type="hidden" name="fleet_array" value=\''.serialize($fleet).'\' />'."\n";

$parse['fleetinfo'] = $info;

//Generate shortcuts
foreach ( explode(";",$user['fleet_shortcut']) as $shortcut){
if(strlen($shortcut) > 0){
$shortcut = explode("-",$shortcut);
$sh .= '<option value="'.$shortcut[0].'">'.$shortcut[1].'</option>'."\n";
}}
$parse['shsh'] = $sh;

//Axah
$page = parsetemplate(gettemplate('fleet/2'), $parse);
if($_GET['axah']){
	makeAXAH($page);
}else{
	displaypage($page, $lang['fl_title']);
}


// Created by MadnessRed
?>
