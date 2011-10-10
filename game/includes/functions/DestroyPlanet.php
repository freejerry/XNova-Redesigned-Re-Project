<?php

/**
 * DestroyPlanet.php
 *
 * @version 1.0
 * @copyright 2010 By MadnessRed for XNova Redesigned
 */

function DestroyPlanet($id, $CurrentUser = false, $CurrentPlanet = false, $moon_dest = false){
		//Do we have the current planet?
		if(!$CurrentPlanet){
			$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".idstring($id)."' LIMIT 1 ;","planets",true);
		}
		//Do we have the current user?
		if(!$CurrentUser){
			$CurrentUser = doquery("SELECT * FROM {{table}} WHERE `id` = '".idstring($CurrentPlanet['id_owner'])."' LIMIT 1 ;","users",true);
		}
		
		
		
		//Destroy the planet
		if($CurrentPlanet['planet_type'] == 1){
			//Destroy the planet
			$destruyed = time() + 60 * 60 * 24;
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`destruyed` = '" . $destruyed . "', ";
			$QryUpdatePlanet .= "`id_owner` = '0' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '" . $CurrentPlanet['id'] . "' AND `id_owner` = '" . $CurrentUser['id'] . "'  LIMIT 1;";
			doquery($QryUpdatePlanet , 'planets');
			
			//Delete the moon
			$QryUpdateMoon  = "SELECT `id` FROM {{table}} WHERE ";
			$QryUpdateMoon .= "`galaxy` = '".$CurrentPlanet['galaxy']."' AND ";
			$QryUpdateMoon .= "`system` = '".$CurrentPlanet['system']."' AND ";
			$QryUpdateMoon .= "`planet` = '".$CurrentPlanet['planet']."' AND ";
			$QryUpdateMoon .= "`planet_type` = '3' LIMIT 1 ;";
			$moon = doquery($QryUpdateMoon,'planets');
			if($moon['id'] > 0)
				DestroyPlanet($moon['id'],$CurrentUser);
		
		//Delete the moon
		}else{
			$QryUpdatePlanet  = "DELETE FROM {{table}} WHERE ";
			$QryUpdatePlanet .= "`id` = '" . $CurrentUser['current_planet'] . "' AND ";
			$QryUpdatePlanet .= "`id_owner` = '" . $CurrentUser['id'] . "'  LIMIT 1;";
			doquery($QryUpdatePlanet , 'planets');
			
			//If this is a destroy fleet, get the orbitted planet
			if($moon_dest){
				$QryUpdateMoon  = "SELECT `id` FROM {{table}} WHERE ";
				$QryUpdateMoon .= "`galaxy` = '".$CurrentPlanet['galaxy']."' AND ";
				$QryUpdateMoon .= "`system` = '".$CurrentPlanet['system']."' AND ";
				$QryUpdateMoon .= "`planet` = '".$CurrentPlanet['planet']."' AND ";
				$QryUpdateMoon .= "`planet_type` = '1' LIMIT 1 ;";
				$planet = doquery($QryUpdateMoon,'planets');
			}
		}
		
		//Set the user to his homeworld
		$QryUpdateUser = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`current_planet` = `id_planet`, ";
		$QryUpdateUser .= "`menus_update` = '".time()."' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '" . $CurrentUser['id'] . "' LIMIT 1";
		doquery($QryUpdateUser, "users");
		
		//Deal with any fleets
		//Recall and fleets going to this planet
		$incoming = doquery("SELECT `fleet_id` FROM {{table}} WHERE `target_id` = ".$CurrentPlanet['id']." AND `fleet_mess` = '0' ;",'fleets');
		while($row = FetchArray($incoming)){
			RecallFleet($row['fleet_id']);
		}
		
		//Get all fleets returning to this planet
		if($moon_dest){
			//Divert returning fleets to the planet
			$incoming = doquery("UPDATE {{table}} SET `target_id` = ".$planet['id']." WHERE `target_id` = ".$CurrentPlanet['id']." AND `fleet_mess` = '1' ;",'fleets');
		}else{
			//This planet was not destroyed that way, jsut remove any ships going to it.
			doquery("DELETE FROM {{table}} WHERE `target_id` = ".$CurrentPlanet['id']." AND `fleet_mess` = '1' ;",'fleets',false,true);
		}
		
}
