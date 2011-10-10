<?php

/**
 * MissionCaseColonisation.php
 *
 * @version 2
 * @copyright 2009 by MadnessRed for XNova Redesigned
 */

// ----------------------------------------------------------------------------------------------------------------
// Mission Case 9: -> Coloniser
//
function MissionCaseColonisation ( $FleetRow ) {
	global $lang, $resource, $formulas;

	//Get the current user (note it must be $currentUser for the $formulas eval'd code to work, see includes/formulas.php
	$CurrentUser = doquery("SELECT * FROM {{table}} WHERE `id` = '".idstring($FleetRow['owner_userid'])."' LIMIT 1 ;",'users',true);
	
	//How many planets do we have?
	$userplanets = mysql_num_rows(doquery ("SELECT `id` FROM {{table}} WHERE `id_owner` = '".$CurrentUser['id']."' AND `planet_type` = '1'", 'planets'));

	//How many planets are allowed?
	$maxplanets = eval($formulas['max_planets_c']);

	//If we have less than (but not equal to) the max planets count.
	if($userplanets < $maxplanets){
		//Now the slightly trickbit, as we were not messing around with gal sys and planet in the database we now had to have a numeric id for the gsp.
		$g = strlen(MAX_GALAXY_IN_WORLD);
		$s = strlen(MAX_SYSTEM_IN_GALAXY);
		$p = strlen(MAX_PLANET_IN_SYSTEM);
		$galaxy = substr($FleetRow['target_id'], 0,$g)*1;
		$system = substr($FleetRow['target_id'],$g,$s)*1;
		$planet = substr($FleetRow['target_id'],$g+$s,$p)*1;
		unset($g,$s,$p);
		
		//Check that these planets are within the allowed range
		if($CurrentUser[$resource[124]] < 4){ $minpos = 4; }
		elseif($CurrentUser[$resource[124]] < 6){ $minpos = 3; }
		elseif($CurrentUser[$resource[124]] < 8){ $minpos = 2; }
		else{ $minpos = 1; }
		$maxpos = MAX_PLANET_IN_SYSTEM + 1 - $minpos;

		if($planet >= $minpos && $planet <= $maxpos){
			//Now get the target position
			$TargetAdress = sprintf($lang['sys_adress_planet'],$galaxy,$system,$planet);

			//See if we have a planet here already?
			$cur = doquery ("SELECT `id` FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."';", 'planets',true);
			if($cur['id'] > 0){
				$message = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_notfree'];
				PM($CurrentUser['id'], 0, $message, $lang['sys_colo_mess_report'], $lang['sys_colo_mess_from'], 2);
			}else{
				//No planet lets carry on.
				if(CreateOnePlanetRecord($galaxy, $system, $planet, $CurrentUser['id'], $lang['sys_colo_defaultname'], false)){
					//Message them that the planet has been made.
					$message = $lang['sys_colo_arrival'].$TargetAdress.$lang['sys_colo_allisok'];
					PM($CurrentUser['id'], 0, $message, $lang['sys_colo_mess_report'], $lang['sys_colo_mess_from'], 2);

					//If there is more than just a colony ship then we should put that fleet on the planet.
					if($FleetRow['shipcount'] > 0){
						$fleet = explode(";", $FleetRow['array']);
						$sql = "";
						$upd = 0;
						foreach ($fleet as $info) {
							if (strlen($info) > 0) {
								$ship = explode (",", $info);
								if($ship[0] == 208){ $ship[1]--; }
								if($ship[1] > 0){
									$sql .= "`".$resource[$ship[0]]."` = '".idstring($ship[1])."' , ";
									$upd += $ship[1];
								}
							}
						}
						if($upd > 0 && strlen(substr_replace($sql,'',-2)) > 3){
							doquery("UPDATE {{table}} SET ".substr_replace($sql,'',-2)." WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' ;",'planets');
						}
					}
					//And put resources on the planet.
					doquery("UPDATE {{table}} SET `metal` = '".$FleetRow['metal']."' , `crystal` = '".$FleetRow['crystal']."' , `deuterium` = '".$FleetRow['deuterium']."'  WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' LIMIT 1 ;",'planets');
				}else{
					//We could not make the colony
					$message = $lang['sys_colo_arrival'].$TargetAdress.$lang['sys_colo_badpos'];
					PM($CurrentUser['id'], 0, $message, $lang['sys_colo_mess_report'], $lang['sys_colo_mess_from'], 2);
				}
			}
		}else{
			//We don't have astro-physics high enough
			$message = $lang['sys_colo_arrival'].$TargetAdress.$lang['sys_colo_outside_range'].$lang['sys_colo_slots']."[".$minpos."-".$maxpos."]!";
			PM($CurrentUser['id'], 0, $message, $lang['sys_colo_mess_report'], $lang['sys_colo_mess_from'], 2);
		}
	}else{
		//We don't have astro-physics high enough
		$message = $lang['sys_colo_arrival'].$TargetAdress.$lang['sys_colo_maxcolo'].$maxplanets.$lang['sys_colo_planet'];
		PM($CurrentUser['id'], 0, $message, $lang['sys_colo_mess_report'], $lang['sys_colo_mess_from'], 2);
	}

}

// Checked with Zend Analysier, 08/04/2009

?>