<?php

/**
 * RecallFleet.php
 *
 * @version 1.0
 * @copyright 2010 By MadnessRed for XNova Redesigned
 */

function RecallFleet($id, $key = 'x', $user = 'x'){
	global $lang;
	
	//Get the lang strings
	getLang('fleet_management');
	
	//See what validation is needed
	$and = '';
	if($key != 'x')
		$and .= " AND `passkey` = '".idstring($key)."'";
	if($user != 'x')
		$and .= " AND `owner_userid` = '".idstring($user)."'";
	
	//First get said fleet:
	$fleetrow = doquery("SELECT *, COUNT('fleet_id') AS `count` FROM {{table}} WHERE `fleet_id` = '".idstring($id)."'".$and." AND `fleet_mess` = '0' AND `mission` <> '0' GROUP BY 'fleet_id';",'fleets',true);

	//Check we found the fleet:
	if($fleetrow['count'] == 1){
		//Incase script takes over a second, lets keep now constant.
		$now = time();
	
		//Duration in flight
		$duration = $now - $fleetrow['departure'];
	
		//ok, lets update the fleet
		doquery("UPDATE {{table}} SET `departure` = '".$now."', `arrival` = '".($now + $duration)."', `target_id` = '".$fleetrow['owner_id']."', `target_userid` = '".$fleetrow['owner_userid']."', `owner_id` = '".$fleetrow['target_id']."', `owner_userid` = '".$fleetrow['target_userid']."', `fleet_mess` = '1', `mission` = '0' WHERE `fleet_id` = '".$fleetrow['fleet_id']."' ;",'fleets',false);
		//Remove any partner fleets
		doquery("DELETE FROM {{table}} WHERE `partner_fleet` = '".$fleetrow['fleet_id']."' ;",'fleets',false);
	
		//Update menus
		doquery("UPDATE {{table}} SET `menus_update` = '".time()."' WHERE `id` = '". $fleetrow['owner_userid'] ."' LIMIT 1 ;",'users',false);
		doquery("UPDATE {{table}} SET `menus_update` = '".time()."' WHERE `id` = '". $fleetrow['target_userid'] ."' LIMIT 1 ;",'users',false);
	
		//Thats it
		return $lang['fleet_recall'];
	}else{
		return $lang['fleet_not_fnd'];
	}
}
