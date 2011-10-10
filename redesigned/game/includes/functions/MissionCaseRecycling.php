<?php

/**
 * MissionCaseRecycling.php
 *
 * @version 2.0
 * @copyright 2009 by MadnessRed for XNova
 */

function MissionCaseRecycling ($FleetRow) {
	global $pricelist, $lang;

	//Firstly we need to planet info.
	$CurrentPlanet = doquery("SELECT `debris_m`,`debris_c` FROM {{table}} WHERE `id` = '".$FleetRow['target_id']."' LIMIT 1 ;",'planets',true);
	
	//If there actually is a debris field here.
	if(($CurrentPlanet['debris_m'] + $CurrentPlanet['debris_c']) > 0){
		//How much res is currently with the fleet
		$onboard = ($FleetRow["metal"] + $FleetRow["crystal"] + $FleetRow["deuterium"]);

		//What is the cargo capacity of the fleet?
		//XNova code will work fine with a small tweak
		$FleetRecord         = explode(";", $FleetRow['array']);
		$RecyclerCapacity    = 0;
		$OtherFleetCapacity  = 0;
		foreach ($FleetRecord as $Item => $Group) {
			if ($Group != '') {
				$Class        = explode (",", $Group);
				if ($Class[0] == 209) {
					$RecyclerCapacity   += $pricelist[$Class[0]]["capacity"] * $Class[1];
				} else {
					$OtherFleetCapacity += $pricelist[$Class[0]]["capacity"] * $Class[1];
				}
			}
		}
		//</XNova Code>

		//How how much space is avaialble for debris?
		$onboard -= $OtherFleetCapacity;
		if($onboard > 0){ $RecyclerCapacity -= $onboard; }
		if($RecyclerCapacity < 0){ $RecyclerCapacity = 0; }

		//So do we have enough space for it all?
		$added = array(0,0);
		if($RecyclerCapacity >= ($CurrentPlanet['debris_m'] + $CurrentPlanet['debris_c'])){
			//Add the resources to the fleetrow
			$FleetRow["metal"] += $CurrentPlanet['debris_m'];
			$added[0] = $CurrentPlanet['debris_m'];
			$FleetRow["crystal"] += $CurrentPlanet['debris_c'];
			$added[1] = $CurrentPlanet['debris_c'];
		}else{
			//How much can we take as a percent?
			$pc = ($RecyclerCapacity / ($CurrentPlanet['debris_m'] + $CurrentPlanet['debris_c']));

			//Add the resources to the fleetrow
			$FleetRow["metal"] += ($CurrentPlanet['debris_m'] * $pc);
			$added[0] = ($CurrentPlanet['debris_m'] * $pc);
			$FleetRow["crystal"] += ($CurrentPlanet['debris_c'] * $pc);
			$added[1] = ($CurrentPlanet['debris_c'] * $pc);
		}

		//Now add those resources to the return fleet.
		doquery("UPDATE {{table}} SET `metal` = '".$FleetRow["metal"]."', `crystal` = '".$FleetRow["crystal"]."' WHERE `partner_fleet` = '".$FleetRow["fleet_id"]."' LIMIT 1 ;",'fleets');
		
		//Now change the amount of debris:
		doquery("UPDATE {{table}} SET `debris_m` = `debris_m` - '".$added[0]."',`debris_c` = `debris_c` - '".$added[1]."' WHERE `id` = '".$FleetRow['target_id']."' LIMIT 1 ;",'planets');		
		
		//And message the yser
		$Message = sprintf($lang['fleet_8_mess'], pretty_number($added[0]), $lang['Metal'], pretty_number($added[1]), $lang['Crystal']);
		PM($FleetRow['owner_userid'],0,$Message,$lang['fleet_8_tit'],$lang['fleet_control'],2);
	}

}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 Mise en module initiale
// 2.0 Recoded for XNova redesigned.

?>
