<?php

/**
 * fleet3.php
 *
 * @version 2.0
 * @copyright 2009 by MadnessRed for XNova
 */

includeLang('fleet');
getLang('fleet');
$parse = $lang;

//Hidden data
$parse['hidden_data'] = '';

//Get target co-ords
$galaxy		= intval($_GET['galaxy']);
$system		= intval($_GET['system']);
$planet		= intval($_GET['planet']);
$planettype	= intval($_GET['planettype']);
$parse['hidden_data'] .= '<input type="hidden" name="galaxy" value="'.$galaxy.'" />'."\n";
$parse['hidden_data'] .= '<input type="hidden" name="system" value="'.$system.'" />'."\n";
$parse['hidden_data'] .= '<input type="hidden" name="planet" value="'.$planet.'" />'."\n";
$parse['hidden_data'] .= '<input type="hidden" name="planettype" value="'.$planettype.'" />'."\n";

//Get fleet
$fleetarray	= unserialize(stripslashes($_GET["fleet_array"]));
$parse['hidden_data'] .= '<input type="hidden" name="fleet_array" value=\''.stripslashes($_GET["fleet_array"]).'\' />'."\n";

//Get speed
$speed		= intval($_GET['speed']);
$parse['hidden_data'] .= '<input type="hidden" name="speed" value="'.$speed.'" />'."\n";

//Get ACS fleet group
$fleet_group_mr = intval($_GET['fleet_group']);

//See what info we have abut the current planet
$YourPlanet	= false;
$UsedPlanet	= false;
$planettype_e = $planettype;
if($planettype == 2)
	$planettype_e = 1;
$target		= doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND `planet_type` = '".$planettype_e."' LIMIT 1 ;","planets",true);
//Does the planet exist?
if($target['id'] > 0){
	//Yes
	$UsedPlanet = true;
	
	//it is the users?
	if($target['id_owner'] == $user['id']){
		//Yes
		$YourPlanet = true;
	}
}

//Parse the missions list
$parse['missions'] = AllowedMissions($UsedPlanet,$YourPlanet,$planet,$planettype,$fleetarray,$fleet_group_mr,false);

//We can trust the results from post here, if the user hacked it it will just make life complicated for himself. No point validating as it will be passed back to post in a bit anyway. Will validate at fleet4.php though.

//Where are we going?
$parse['target'] = $target['galaxy'].":".$target['system'].":".$target['planet']." ".($target['planet_type'] == 3 ? $lang['Moon'] : ($target['planet_type'] == 2 ? $lang['DF'] : $lang['Planet']));

//How long?
$parse['duration'] = $_GET['duration'] * 1;
$parse['pduration'] = pretty_time($parse['duration']);

//How much fuel?
$parse['consumption'] = pretty_number($_GET['consumption']);

//How much space?
$parse['space'] = $_GET['fleet_cargo'] - $_GET['consumption'];
$parse['bays'] = pretty_number($parse['space']);

$page = parsetemplate(gettemplate('fleet/3'), $parse);
if($_GET['axah']){
	makeAXAH($page);
}else{
	displaypage($page, $lang['fl_title']);
}

// Updated by MadnessRed. 22 Oct 2009 (Virtually scratch recoded)
// Updated by Chlorel. 16 Jan 2008 (String extraction, bug corrections, code uniformisation)
// Created by Perberos. All rights reversed (C) 2006
?>
