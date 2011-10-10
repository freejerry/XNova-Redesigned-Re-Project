<?php

/**
 * fleet4.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

getLang('fleet');


/*
Data

Resources (resource[1,2,3])
	Fleet
	Speed
	Mission
	Noob Protection
	Vacation Mode
	Fleet Slots
x	ACS
	Target
holding

Send fleet
*/



//<MadnessRed ACS>
//Normally... unless its acs...
$fleet_group_mr = 0;
// Forget acs
/*
//But is it acs??
//Well all acs fleets must have a fleet code.
if($_GET['fleet_group'] > 0){
	//Also it must be mission type 2
	if($_GET['mission'] == 2){
		//The co-ords must be the same as where the acs fleet is going.
		$target = "g".$_GET["galaxy"]."s".$_GET["system"]."p".$_GET["planet"]."t".$_GET["planettype"];
		if($_GET['acs_target_mr'] == $target){
			//ACS attack must exist (if acs fleet has arrived this will also return false (2 checks in 1!!!)
			$aks_count_mr = doquery("SELECT * FROM {{table}} WHERE id = '".$_GET['fleet_group']."'",'aks');
			if (mysql_num_rows($aks_count_mr) > 0) {
				$fleet_group_mr = addslashes($_GET['fleet_group']);
			}
		}
	}
}
//Check that a failed acs attack isn't being sent, if it is, make it an attack fleet.
if(($_GET['fleet_group'] == 0) && ($_GET['mission'] == 2)){
	$_GET['mission'] = 1;
}
//</MadnessRed ACS>
*/

//Basic things
$error				= 0;
$galaxy				= idstring($_GET['galaxy']);
$system				= idstring($_GET['system']);
$planet				= idstring($_GET['planet']);
$planettype			= idstring($_GET['planettype']);
$fleetmission		= idstring($_GET['mission']);
$fleetspeed			= idstring($_GET['speed']);

//Misions
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
15 => $lang['type_mission'][15],
);


//If its a df, look at the planet its orbiting.
$planettypetemp = $planettype; if($planettype == 2){ $planettypetemp = 1; }

//Get planetrow.
$select = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ".$galaxy." AND `system` = ".$system." AND `planet` = ".$planet." AND `planet_type` = ".$planettypetemp." LIMIT 1 ;", "planets");
$effectivetarget = mysql_fetch_array($select);

//Does it exist?
if(mysql_num_rows($select) > 0){ $UsedPlanet = true; }else{ $UsedPlanet = false; }

//Is it ours?
if ($effectivetarget['id_owner'] == $user['id']) { $YourPlanet = true; }else{ $YourPlanet = false; }
//Clear some memory
unset($select);


//Some SQL Info
$targetrow  = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '". $galaxy ."' AND `system` = '". $system ."' AND `planet` = '". $planet ."' AND `planet_type` = '". $planettype ."';", 'planets', true);

//Get the fleet array...
$fleetarray	= unserialize(stripslashes($_GET["fleet_array"]));

//Is there a fleet array, if not either he's wasting our time or something is wrong.
if (!is_array($fleetarray)) {
	die($lang['fl_error']."<br /> \$fleetarray is not an array.");
}

//Does mission exist?
if (empty($missiontype[$fleetmission])) {
	die($lang['fl_bad_mission']);
}

//Check if mission is legit.
$legit = AllowedMissions($UsedPlanet,$YourPlanet,$planet,$planettype,$fleetarray,$fleet_group_mr,true);
if($legit[$fleetmission] != $fleetmission){
	die($lang['fl_bad_mission']."<br >~".$legit[$fleetmission]."<br >~".$fleetmission);
}


//Is he cheating on the fleet? die if he is.
foreach ($fleetarray as $Ship => $Count) {
	if($Ship != idstring($Ship)){ unset($fleetarray[$Ship]); }
	else{
		$Count = idstring($Count);
		$fleetarray[$Ship] = $Count;
		if ($Count > $planetrow[$resource[$Ship]]) {
			die($lang['fl_fleet_err']."<br />User is trying to send more ".$Ship." than he owns.");
		}
	}
}

//Is he attacking a noob?
if($targetrow['owner_id'] > 0){
	if(ProtectNoob($target)){
		die($lang['fl_noob_mess_n']."<br />".$lang['fl_noob_title']);
	}
}

//Check for vacation mode
if($user['urlaubs_modus'] > 0){
	die($lang['fl_vacation_pla']);
}elseif($planettype != 2){ //For harvest, we can still get df is user is in vacation mode
	$target = doquery("SELECT `urlaubs_modus` FROM {{table}} WHERE `id` = '". $targetrow['id_owner'] ."' LIMIT 1 ;", 'users', true);
	if($target['urlaubs_modus'] > 0){
		die($lang['fl_vacation_pla']);
	}
}

//Fleets go to planets, df or moons, thats it.
if ($planettype < 1 || $planettype > 3) {
	die($lang['fl_fleet_err_pl']."<br />Invalid planet type.");
}

//Check we are within constraints of universe
if ($galaxy < 1 || $galaxy > MAX_GALAXY_IN_WORLD) {
	die($lang['fl_limit_galaxy']);
}
if ($system < 1 || $system > MAX_SYSTEM_IN_GALAXY) {
	die($lang['fl_limit_system']);
}
//If he is not within the contraints the allowed missions will chuck it out, if we apply the constraints here, then it blocks expeditions
//if ($planet < 1 || $planet > MAX_PLANET_IN_SYSTEM) {
//	die($lang['fl_limit_planet']);
//}

//Fleets can't go this this very planet, whats the point in that?
if ($planetrow['galaxy'] == $galaxy &&
$planetrow['system'] == $system &&
$planetrow['planet'] == $planet &&
$planetrow['planet_type'] == $planettype) {
	die($lang['fl_ownpl_err']."<br />Fleet is going to the planet it just left!! ".$planetrow['planet_type']." = ".$planettype);
}
//Check we have enough fleets.
$FlyingFleets = doquery("SELECT COUNT(fleet_id) as Number FROM {{table}} WHERE `owner_userid`='".$user['id']."' ;", 'fleets',true);
if (eval($formulas['max_fleets']) <= $FlyingFleets["Number"]) {
	die("Not enough fleet slots.");
}

//Check fleet speed.
if(!in_array($fleetspeed,array(10, 9, 8, 7, 6, 5, 4, 3, 2, 1)) || !$fleetspeed){
	die($lang['fl_cheat_speed']."<br />Invalid fleet speed.");
}else{
	//die("-".$fleetspeed."-");
}

//Get fleet info
$fleet = array(); $speeds = array(); $capacity = 0; $fuel = 0;
foreach ($reslist['fleet'] as $id) {
	//Check we own this type of ship and that we are actually sending some
	if ($planetrow[$resource[$id]] > 0 && $fleetarray[$id] > 0) {
		//If they have said to many set it to the max
		if($fleetarray[$id] > $planetrow[$resource[$id]]){
			$fleetarray[$id] = $planetrow[$resource[$id]];
		}
		//How many of this ship type?
		$fleet[$id] = $fleetarray[$id];
		
		//What speed?
		$speeds[$id] = GetShipSpeed($id);
		
		//Cargo space
		$capacity += ($pricelist[$id]['capacity'] * $fleetarray[$id]);
		
		//Fuel use
		if($pricelist[$id]['upgrade'] > 0 && $user[$resource[$pricelist[$id]['drive2']]] > $pricelist[$id]['upgrade']){
			$fuel += ($pricelist[$id]['consumption2'] * $fleetarray[$id]);
		}else{
			$fuel += ($pricelist[$id]['consumption'] * $fleetarray[$id]);
		}
		
	}
}
//Find the minimum speed.
$speed = min($speeds);


//How Far?
$distance = GetTargetDistance($planetrow['galaxy'], $galaxy, $planetrow['system'], $system, $planetrow['planet'], $planet);
$duration = GetMissionDuration(GetGameSpeedFactor(), $speed, $distance, $fleetspeed);
//$fuelused = GetFleetFuelReq($fleetarray,$speeds,$speed,$fleetspeed,$fuel,$distance);
$fuelused = GetFleetFuelReq($fleetspeed,$fuel,$distance);


//Holding the fleet
if ($fleetmission == 15) {
	$stay = $_GET['expeditiontime'] * 3600;
} elseif ($fleetmission == 5) {
	$stay= $_GET['holdingtime'] * 3600;
} else {
	$stay= 0;
}


//Remove fuel from capacity.
$capacity -= $consumption;


//Currently need no storage... ...but add metal crystal and deut.
$StorageNeeded = 0;
if ($_GET['resource1'] <= 0) {
	$TransMetal	  = 0;
} else {
	$TransMetal	  = idstring($_GET['resource1']);
	$StorageNeeded  += $TransMetal;
}
if ($_GET['resource2'] <= 0) {
	$TransCrystal	= 0;
} else {
	$TransCrystal	= idstring($_GET['resource2']);
	$StorageNeeded  += $TransCrystal;
}
if ($_GET['resource3'] <= 0) {
	$TransDeuterium  = 0;
} else {
	$TransDeuterium  = idstring($_GET['resource3']);
	$StorageNeeded  += $TransDeuterium;
}


//How much on planet?
$StockMetal	  = $planetrow['metal'] - $TransMetal;
$StockCrystal	= $planetrow['crystal'] - $TransCrystal;
$StockDeuterium  = $planetrow['deuterium'] - $TransDeuterium;
$StockDeuterium -= $consumption;

//Is that enough?
$StockOk		 = false;
if($StockMetal >= 0 && $StockCrystal >= 0 && $StockDeuterium >= 0) {
	$StockOk = true;
}else{
	die($lang['fl_noressources'] . pretty_number($consumption));
}

//Do we have space for those resources?
if($StorageNeeded > $capacity){
	die($lang['fl_nostoragespa'] . pretty_number($StorageNeeded - $capacity));
}

//Check if we can attack an admin
if ($targetrow['id_level'] > $user['authlevel']) {
	$Allowed = true;
	switch ($_GET['mission']){
		case 1:
		case 2:
		case 6:
		case 9:
			$Allowed = false;
			break;
		case 3:
		case 4:
		case 5:
		case 7:
		case 8:
		case 15:
			break;
		default:
	}
	if ($Allowed == false) {
		die($lang['fl_adm_attak']);
	}
}

//Do we have a target id? If not we need to have gsp
if(($effectivetarget['id'] > 0)){
	$targetid = $effectivetarget['id'];
}else{
	$targetid  = LeadingZeros($galaxy,strlen(MAX_GALAXY_IN_WORLD));
	$targetid .= LeadingZeros($system,strlen(MAX_SYSTEM_IN_GALAXY));
	$targetid .= LeadingZeros($planet,strlen(MAX_PLANET_IN_SYSTEM));
}


//Make a fleet array
$flarray = array(); $remove = array(); $FleetShipCount = 0;
foreach($fleetarray as $id => $count){
	$flarray[] = $id . ',' . $count;
	$FleetShipCount += $count;
	$remove[] = " `".$resource[$id]."` = `".$resource[$id]."` - '".$count."' ";
}
$flarray = implode(";",$flarray);
$remove = implode(" , ",$remove)." , ";

//Lock the fleets table
doquery("LOCK TABLE {{table}} WRITE", 'fleets');

//Insert fleet into out new fleets table.
$time = time();
$QryInsertFleet  = "INSERT INTO {{table}} SET ";
$QryInsertFleet .= "`mission` = '".idstring($fleetmission)."', ";
$QryInsertFleet .= "`shipcount` = '".idstring($FleetShipCount)."', ";
$QryInsertFleet .= "`array` = '".mysql_real_escape_string($flarray)."', ";
$QryInsertFleet .= "`departure` = '".idstring($time)."', ";
$QryInsertFleet .= "`arrival` = '".idstring($duration + $time)."', ";
$QryInsertFleet .= "`target_userid` = '".idstring($effectivetarget['id_owner'])."', ";
$QryInsertFleet .= "`target_id` = '".idstring($targetid)."', ";
$QryInsertFleet .= "`owner_userid` = '".idstring($planetrow['id_owner'])."', ";
$QryInsertFleet .= "`owner_id` = '".idstring($planetrow['id'])."', ";
$QryInsertFleet .= "`hold_time` = '".idstring($stay)."', ";
$QryInsertFleet .= "`metal` = '".idstring($TransMetal)."', ";
$QryInsertFleet .= "`crystal` = '".idstring($TransCrystal)."', ";
$QryInsertFleet .= "`deuterium` = '".idstring($TransDeuterium)."', ";
$QryInsertFleet .= "`fleet_group` = '".idstring($fleet_group_mr)."', ";
$QryInsertFleet .= "`fleet_mess` = '0' ; ";
doquery( $QryInsertFleet, 'fleets');

//Get the fleet id
$fleetid = mysql_insert_id();
//An array of fleets that don't return
$noreturn = array(4,7);
if(!in_array(idstring($_GET['mission']),$noreturn)){
	//We should add a return fleet
	$QryInsertFleet  = "INSERT INTO {{table}} SET ";
	$QryInsertFleet .= "`partner_fleet` = '".idstring($fleetid)."', ";
	$QryInsertFleet .= "`mission` = '0', ";
	$QryInsertFleet .= "`shipcount` = '".idstring($FleetShipCount)."', ";
	$QryInsertFleet .= "`array` = '".mysql_real_escape_string($flarray)."', ";
	$QryInsertFleet .= "`departure` = '".idstring($duration + $time + $stay)."', ";
	$QryInsertFleet .= "`arrival` = '".idstring(($duration * 2) + $time + $stay)."', ";
	$QryInsertFleet .= "`target_userid` = '".idstring($planetrow['id_owner'])."', ";
	$QryInsertFleet .= "`target_id` = '".idstring($planetrow['id'])."', ";
	$QryInsertFleet .= "`owner_userid` = '".idstring($targetrow['id_owner'])."', ";
	$QryInsertFleet .= "`owner_id` = '".idstring($targetid)."', ";
	$QryInsertFleet .= "`hold_time` = '0', ";
	$QryInsertFleet .= "`metal` = '".idstring($TransMetal)."', ";
	$QryInsertFleet .= "`crystal` = '".idstring($TransCrystal)."', ";
	$QryInsertFleet .= "`deuterium` = '".idstring($TransDeuterium)."', ";
	$QryInsertFleet .= "`fleet_group` = '".idstring($fleet_group_mr)."', ";
	$QryInsertFleet .= "`fleet_mess` = '1' ; ";
	doquery( $QryInsertFleet, 'fleets');
}

//Unock the tables
doquery("UNLOCK TABLES", 'fleets');

//Update the users menus if he is online:
doquery("UPDATE {{table}} SET `menus_update` = '".time()."' WHERE `id` = '". idstring($planetrow['id_owner']) ."' LIMIT 1 ;",'users',false);
doquery("UPDATE {{table}} SET `menus_update` = '".time()."' WHERE `id` = '". idstring($effectivetarget['id_owner']) ."' LIMIT 1 ;",'users',false);

//Update planet
$QryUpdatePlanet  = "UPDATE {{table}} SET ";
$QryUpdatePlanet .= $remove;
$QryUpdatePlanet .= "`metal` = '". $StockMetal ."', ";
$QryUpdatePlanet .= "`crystal` = '". $StockCrystal ."', ";
$QryUpdatePlanet .= "`deuterium` = '". $StockDeuterium ."' ";
$QryUpdatePlanet .= "WHERE ";
$QryUpdatePlanet .= "`id` = '". $planetrow['id'] ."'";

// Mise a jours de l'enregistrement de la planete de depart (a partir de là, y a quelque chose qui vole et ce n'est plus sur la planete de depart)
doquery("LOCK TABLE {{table}} WRITE", 'planets');
doquery ($QryUpdatePlanet, "planets");
doquery("UNLOCK TABLES", '');
//	doquery("FLUSH TABLES", '');

// Provisoire
sleep (1);

$message = "Your ".$missiontype[$fleetmission]." fleet has be sent to ".$galaxy.":".$system.":".$planet;
die($lang['fl_fleet_send']."<br />".$message);

// Updated by MadnessRed. 24 Oct 2009 (Major changes to fleet disptach and management)
// Updated by Chlorel. 16 Jan 2008 (String extraction, bug corrections, code uniformisation
// Updated by -= MoF =- for Deutsches Ugamela Forum
// 06.12.2007 - 08:39
// Open Source
// (c) by MoF

?>
