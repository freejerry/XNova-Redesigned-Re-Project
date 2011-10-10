<?php

/**
 * fleetjump.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova
 */

//Get the language
includeLang('fleet');
getLang('fleet');
$parse = $lang;


function BuildJumpableMoonCombo () {
	global $resource, $user, $planetrow;
	$MoonList        = doquery ("SELECT `galaxy`,`system`,`planet`,`name` FROM {{table}} WHERE `planet_type` = '3' AND `id_owner` = '". $user['id'] ."' AND `id` <> '". $planetrow['id'] ."' AND `". $resource[43] ."` > 0 ;", 'planets',false);
	$Combo           = "";
	while($CurMoon = mysql_fetch_assoc($MoonList)){
		$RestString = GetNextJumpWaitTime ($CurMoon);
		$Combo .= "\t\t\t\t\t\t\t<option value=\"". $CurMoon['galaxy'] .":". $CurMoon['system'] .":". $CurMoon['planet'] ."\">[". $CurMoon['galaxy'] .":". $CurMoon['system'] .":". $CurMoon['planet'] ."] ". $CurMoon['name'] . $RestString['string'] ."</option>\n";
	}
	return $Combo;
}


//Where should they be sent to by default.	
$g = $_GET['galaxy']; if (!$g) {$g = $planetrow['galaxy'];}
$s = $_GET['system']; if (!$s) {$s = $planetrow['system'];}
$p = $_GET['planet']; if (!$p) {$p = $planetrow['planet'];}
$t = $_GET['planet_type']; if (!$t) {$t = $planetrow['planet_type'];}

$parse['g'] = $g; $parse['s'] = $s; $parse['p'] = $p; $parse['t'] = $t;


//Now fleet info
$fleet = array();
foreach ($reslist['fleet'] as $id) {
	//Check we own this type of ship and that we are actually sending some
	if ($planetrow[$resource[$id]] > 0 && $_GET["ship".$id] > 0) {
		//If they have said to many set it to the max
		if($_GET["ship".$id] > $planetrow[$resource[$id]]){
			$_GET["ship".$id] = $planetrow[$resource[$id]];
		}
		//How many of this ship type?
		$fleet[$id] = $_GET["ship".$id];
		
	}
}
//Check we have a fleet
if(sizeof($fleet) == 0){
	$parse['message'] = $parse['fl_no_ships'];
	
	if($_GET['axah']){
		makeAXAH(parsetemplate(gettemplate('fleet/0'), $parse));
	}else{
		displaypage(parsetemplate(gettemplate('fleet/0'), $parse), $lang['fl_title']);
	}
}

//Parse, fleet and targets
$parse['fleetinfo'] = '<input type="hidden" name="fleet_array" value=\''.serialize($fleet).'\' />'."\n";
$parse['jumptos'] = BuildJumpableMoonCombo ();


//Make page
$page = parsetemplate(gettemplate('fleet/jump'), $parse);
if($_GET['axah']){
	makeAXAH($page);
}else{
	displaypage($page, $lang['fl_title']);
}


// Created by MadnessRed
?>
