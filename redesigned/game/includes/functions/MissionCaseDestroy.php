<?php
/**
 * MissionCaseDestroy.php
 *
 * @version 1.0
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */

function MissionCaseDestroy($FleetRow,$CurrentPlanet) {
	global $resource,$lang,$CombatCaps,$pricelist;
	
	//Get the fleet
	$fleet = array();
	foreach(explode(';',$FleetRow['array']) as $r){
		$r = explode(',',$r);
		$fleet[$r[0]] = $r[1];
	}
	
	//Check we still have Deathstarts
	if($fleet[214] > 0){
		
		$destroyed = array(false,false);
		
		//Firstly is the moon destroyed:
		$chance_m = (100 - pow($moonsize,0.5)) * pow($fleet[214],0.5);
		if($chance_m > mt_rand(0,100)){
			//Any fleet going to the moon should be recalled
			$tomoon = doquery("SELECT `fleet_id` FROM {{table}} WHERE `target_id` = '".$CurrentPlanet['id']."' AND `fleet_mess` = '0' ;",'fleets',false);
			while($row = FetchArray($tomoon)){
				$fleetrow = doquery("SELECT *, COUNT('fleet_id') AS `count` FROM {{table}} WHERE `fleet_id` = '".idstring($row['fleet_id'])."' AND `fleet_mess` = '0' AND `mission` <> '0' ;",'fleets',true);

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
				}
			}
			
			//And fleets returning to the moon should go the planet
			$planet = doquery("SELECT `id` FROM {{table}} WHERE `galaxy` = '".$CurrentPlanet['galaxy']."' AND `system` = '".$CurrentPlanet['system']."' AND `planet` = '".$CurrentPlanet['planet']."' AND `planet_type` = '1' LIMIT 1 ;",'planets',true);
			doquery("UPDATE {{table}} SET `target_id` = '".$planet['id']."' WHERE `target_id` = '".$CurrentPlanet['id']."' ;",'fleets',false);
			doquery("UPDATE {{table}} SET `owner_id` = '".$planet['id']."' WHERE `owner_id` = '".$CurrentPlanet['id']."' ;",'fleets',false);
			
			//Delete the moon
			doquery("DELETE FROM {{table}} WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;",'planets',false);
			
			//Mark it as destroyed for the message
			$destroyed[0] = true;
		}
		//Secondly are the Deathstars destroyed.
		$chance_k = 0.5 * pow($moonsize,0.5);
		if($chance_k > mt_rand(0,100)){
			//Are there any other ships in the fleet?
			if(array_sum($fleet) > $fleet[214]){				
				//Remove rips from the fleet
				unset($fleet[214]);
				
				//Compile fleet array
				$array = array(); foreach($fleet as $id => $c){ $array[] = $id.",".$c; } $array = implode(";",$array);
				
				//Update row
				doquery("UPDATE {{table}} SET `array` = '".$array."', `count` = `count` - '".array_sum($fleet)."' WHERE `fleet_id` = '".$FleetRow['fleet_id']."' LIMIT 1 ;",'fleets',false);
			}else{
				//Just remove the fleet
				DeleteFleet($FleetRow['fleet_id']);
			}
			
			//Mark it as destroyed for the message
			$destroyed[1] = true;
		}
		
		
		//Start the message
		$HomePlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$row['target_id']."' LIMIT 1 ;",'planets',true);
		$message  = '';
		$message .= sprintf($lang['fleet_9_mess1'],$HomePlanet['name']." [".$HomePlanet['galaxy'].":".$HomePlanet['system'].":".$HomePlanet['planet']."]","[".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."]");
		$message .= sprintf($lang['fleet_9_moon'],$chance_m.'%')."<br />";
		$message .= sprintf($lang['fleet_9_rips'],$chance_k.'%')."<br />";
		$message .= $lang['fleet_9_mess2'];
		
		//So what happen (for the message?)
		if($destroyed[0] && $destroyed[1]){
			//Both moon and RIPs destroyed
			$message .= $lang['fleet_9_messD'];
			$message .= $lang['fleet_9_messK'];
		}elseif($destroyed[0]){
			//Moon Destroyed
			$message .= $lang['fleet_9_messD'];
		}elseif($destroyed[1]){
			//RIPs destroyed
			$message .= $lang['fleet_9_messK'];
		}else{
			//Nothing destroyed
			$message .= $lang['fleet_9_messN'];
		}
		
		
		PM($FleetRow['owner_userid'],0,$message,sprintf($lang['fleet_9_tit'],$CurrentPlanet['name']),$lang['fleet_control'],2);
		PM($FleetRow['target_userid'],0,$message,sprintf($lang['fleet_9_tit'],$CurrentPlanet['name']),$lang['fleet_control'],2);
	}
}

?>
