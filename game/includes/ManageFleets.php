<?php

//New fleet management

function ManageFleets($limit = 5){
	global $lang;
	
	getLang('fleet_management');

	//Lock the tables
	$tables = array('aks','cr','errors','messages','fleets','planets','users');
	foreach($tables as $k => $v){ $tables[$k] = "``{{prefix}}".$v."`` WRITE"; }
	doquery("LOCK TABLE ".implode(", ",$tables), "");

	//Get the fleets - ordered by their returning time
	$fleets = doquery("SELECT * FROM {{table}} WHERE (`arrival` + `hold_time`) < ".time()." ORDER BY (`arrival` + `hold_time`) ASC LIMIT ".idstring($limit)." ;",'fleets');

	//If there are any fleets.
	if(mysql_num_rows($fleets) > 0){
		include_once(ROOT_PATH . 'includes/functions/MissionCaseStay.php');
		include_once(ROOT_PATH . 'includes/functions/MissionCaseStayAlly.php');
		include_once(ROOT_PATH . 'includes/functions/MissionCaseSpy.php');
		include_once(ROOT_PATH . 'includes/functions/MissionCaseRecycling.php');
		include_once(ROOT_PATH . 'includes/functions/MissionCaseDestroy.php');
		include_once(ROOT_PATH . 'includes/functions/MissionCaseExpedition.php');
		include_once(ROOT_PATH . 'includes/functions/MissionCaseColonisation.php');

		//Now loop through the fleets.
		while($row = mysql_fetch_array($fleets)){
			
			//Update the users menus if he is online:
			doquery("UPDATE {{table}} SET `menus_update` = '".time()."' WHERE `id` = '". $row['owner_userid'] ."' LIMIT 1 ;",'users',false);
			doquery("UPDATE {{table}} SET `menus_update` = '".time()."' WHERE `id` = '". $row['target_userid'] ."' LIMIT 1 ;",'users',false);

			//Now deal with the fleet
			if($row["mission"] == 0 || $row["mission"] == 4){
				//Fleet is returning home, just restore the fleet to the planet and delete it.
				DeleteFleet($row['fleet_id']);
				RestoreFleet($row);
				
				$StartPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $row['owner_id'] ."' LIMIT 1 ;",'planets',true);
				$TargetPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $row['target_id'] ."' LIMIT 1 ;",'planets',true);

				//Send the user a message
				$Message = sprintf($lang['fleet_return_m'],
									$StartPlanet['name'], "[".$StartPlanet['galaxy'].":".$StartPlanet['system'].":".$StartPlanet['planet']."]",
									pretty_number($row['metal']), $lang['Metal'],
									pretty_number($row['crystal']), $lang['Crystal'],
									pretty_number($row['deuterium']), $lang['Deuterium'] );
				PM($row['target_userid'],0,$Message,$lang['fleet_return'],$lang['fleet_control'],2);
			}else{
				switch ($row["mission"]) {
					case 1:
						if($row["fleet_mess"] == 0){
							// Attack
							doquery("UPDATE {{table}} SET `fleet_mess` = '3' WHERE `fleet_id` = '".$row["fleet_id"]."' LIMIT 1 ;",'fleets',false);
							require_once(ROOT_PATH . 'includes/battle_engines/MissionCaseAttack_'.BATTLE_ENGINE.'.php');
							include_once(ROOT_PATH . 'includes/battle_engines/ManageCR.php');
							$results = MissionCaseAttack($row);
							$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$row['target_id']."' LIMIT 1 ;",'planets',true);
							ManageCR($results,$CurrentPlanet);
						}
						break;

					case 2:
						// ACS Attack
						// Wait, this fleet will be dealt with when the attack fleet arrives.
						// Note that the return fleet won't exist until after the attack.
						break;

					case 3:
						// Transport
						DeleteFleet($row['fleet_id']);

						//Send the res
						RestoreRes($row);

						//Now send messages to the players
						$StartPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $row['owner_id'] ."' LIMIT 1 ;",'planets',true);
						$TargetPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $row['target_id'] ."' LIMIT 1 ;",'planets',true);

						$Message = sprintf($lang['fleet_3_yours'],
							$TargetPlanet['name'], "[".$TargetPlanet['galaxy'].":".$TargetPlanet['system'].":".$TargetPlanet['planet']."]",
							pretty_number($row['metal']), $lang['Metal'],
							pretty_number($row['crystal']), $lang['Crystal'],
							pretty_number($row['deuterium']), $lang['Deuterium'] );
						PM($StartPlanet['id_owner'],0,$Message,$lang['sys_mess_transport'],$lang['fleet_control'],2);
						if ($TargetPlanet['id_owner'] != $StartPlanet['id_owner']) {
							$Message = sprintf( $lang['fleet_3_allied'],
								$StartPlanet['name'], "[".$StartPlanet['galaxy'].":".$StartPlanet['system'].":".$StartPlanet['planet']."]",
								$TargetPlanet['name'], "[".$TargetPlanet['galaxy'].":".$TargetPlanet['system'].":".$TargetPlanet['planet']."]",
								pretty_number($row['metal']), $lang['Metal'],
								pretty_number($row['crystal']), $lang['Crystal'],
								pretty_number($row['deuterium']), $lang['Deuterium'] );
							PM($TargetPlanet['id_owner'],0,$Message,$lang['sys_mess_transport'],$lang['fleet_control'],2);
						}
						break;

					case 4:
						// Deploy (note that this is imposible so is really only here to avoid confusion)
						DeleteFleet($row['fleet_id']);
						break;

					case 5:
						// ACS Defend
						// Wait, this fleet will be dealt with when the attack fleet arrives.
						// Note that the return fleet won't exist until after the attack.
						//DeleteFleet($row['fleet_id']);
						break;

					case 6:
						// Espionage
						DeleteFleet($row['fleet_id']);
						MissionCaseSpy($row);
						break;

					case 7:
						// Colonise
						DeleteFleet($row['fleet_id']);
						MissionCaseColonisation($row);
						break;

					case 8:
						// Recycle
						DeleteFleet($row['fleet_id']);
						MissionCaseRecycling($row);
						break;

					case 9:
						// Moon Destroy
						$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$row['target_id']."' LIMIT 1 ;",'planets',true);
						if($row["fleet_mess"] == 0 && $CurrentPlanet['planet_type'] == 3){
							// Attack
							doquery("UPDATE {{table}} SET `fleet_mess` = '3' WHERE `fleet_id` = '".$row["fleet_id"]."' LIMIT 1 ;",'fleets',false);
							require_once(ROOT_PATH . 'includes/battle_engines/MissionCaseAttack_'.BATTLE_ENGINE.'.php');
							include_once(ROOT_PATH . 'includes/battle_engines/ManageCR.php');
							$results = MissionCaseAttack($row);
							ManageCR($results,$CurrentPlanet);
							
							//And then destroy, if the fleet survived
							if($results['won'] == 'a'){
								$nowfleet = doquery("SELECT * FROM {{table}} WHERE `partner_fleet` = '".$row['fleet_id']."' LIMIT 1 ;",'fleets',true);
								MissionCaseDestruction($nowfleet,$CurrentPlanet);
							}
						}
						DeleteFleet($row['fleet_id']);
						break;

					case 10:
						// Missiles !!
						DeleteFleet($row['fleet_id']);
						MissileAttack($row);
						break;

					case 15:
						// Expedition
						DeleteFleet($row['fleet_id']);
						MissionCaseExpedition($row);
						break;

					default: {
						DeleteFleet($row['fleet_id']);
					}
				}
			}
		}
	}
	
	//Unlock tables
	doquery("UNLOCK TABLES", "");
}

function RestoreFleet($FleetRow){
	global $resource;

	//Start the query
	$qry = "UPDATE {{table}} SET ";

	//Add ships
	foreach(explode(";",$FleetRow['array']) as $array){
		$fleet = explode(",",$array);
		if($fleet[0] > 200 && $fleet[0] < 400 && $fleet[1] > 0){
			$qry .= "`".$resource[$fleet[0]]."` = `".$resource[$fleet[0]]."` + '".$fleet[1]."' , ";
		}
	}

	//Add resources
	$qry .= "`metal` = `metal` + '".$fleet['metal']."' , ";
	$qry .= "`crystal` = `crystal` + '".$fleet['crystal']."' , ";
	$qry .= "`deuterium` = `deuterium` + '".$fleet['deuterium']."' ";

	//Where
	$qry .= "WHERE `id` = '".$FleetRow['target_id']."' LIMIT 1 ;";

	//Now do the query
	doquery($qry,'planets');
}
function RestoreRes($FleetRow){
	global $resource;

	//Start the query
	$qry = "UPDATE {{table}} SET ";

	//Add resources
	$qry .= "`metal` = `metal` + '".idstring($FleetRow['metal'])."' , ";
	$qry .= "`crystal` = `crystal` + '".idstring($FleetRow['crystal'])."' , ";
	$qry .= "`deuterium` = `deuterium` + '".idstring($FleetRow['deuterium'])."' ";

	//Where
	$qry .= "WHERE `id` = '".$FleetRow['target_id']."' LIMIT 1 ;";

	//Now do the query
	doquery($qry,'planets');
	
	//now remove res from the fleet
	doquery("UPDATE {{table}} SET `metal` = '0', `crystal` = '0', `deuterium` = '0' WHERE `fleet_id` = '".$FleetRow['fleet_id']."' OR `partner_fleet` = '".$FleetRow['fleet_id']."' LIMIT 2 ;",'fleets');
}

function DeleteFleet($id){
	doquery("DELETE FROM {{table}} WHERE `fleet_id` = '".idstring($id)."' LIMIT 1 ;",'fleets',false,true);
}

function DeletePartnerFleet($id){
	if($id > 0){
		doquery("DELETE FROM {{table}} WHERE `partner_fleet` = '".idstring($id)."' LIMIT 1 ;",'fleets',false,true);
	}
}

?>
