<?php

/**
 * jumpgate.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */

function DoFleetJump ( $CurrentUser, $CurrentPlanet ) {
	global $lang, $resource, $_GET;

	includeLang ('infos');

	if ($_GET) {
		$RestString   = GetNextJumpWaitTime ( $CurrentPlanet );
		$NextJumpTime = $RestString['value'];
		$JumpTime     = time();
		// Dit monsieur, j'ai le droit de sauter ???
		if ( $NextJumpTime == 0 ) {
			// Dit monsieur, ou je veux aller ca existe ???
			$TargetGate = doquery ( "SELECT `id`, `".$resource[43]."`, `last_jump_time` FROM {{table}} WHERE `galaxy` = '".idstring($_GET['galaxy'])."' AND `system` = '".idstring($_GET['system'])."' AND  `planet` = '".idstring($_GET['planet'])."' AND `planetype` = '3' LIMIT 1 ;", 'planets', true);
			// Dit monsieur, ou je veux aller y a une porte de saut ???
			if ($TargetGate[$resource[43]] > 0) {
				$NextDestTime = $RestString['value'];
				// Dit monsieur, chez toi aussi peut y avoir un saut ???
				if ( $NextDestTime == 0 ) {
					// Bon j'ai eu toutes les autorisations, donc je compte les radis !!!
					$fleetarray	= unserialize(stripslashes($_GET["fleet_array"]));
					$SubQueryOri = "";
					$SubQueryDes = "";
					foreach($fleetarray as $ship => $count){
						if ($count > $CurrentPlanet[$resource[$ship]]) {
							$count = $CurrentPlanet[$resource[$ship]]];
						}
						if ($count > 0 && in_array($ship,$reslist['fleet']) && $ship != 212) {
							$SubQueryOri .= "`". $resource[ $ship ] ."` = `". $resource[ $ship ] ."` - '". idstring($count) ."', ";
							$SubQueryDes .= "`". $resource[ $ship ] ."` = `". $resource[ $ship ] ."` + '". idstring($count) ."', ";
						}
					}
					// Dit monsieur, y avait quelque chose a envoyer ???
					if ($SubQueryOri != "") {
						// Soustraction de la lune de depart !
						$QryUpdateOri  = "UPDATE {{table}} SET ";
						$QryUpdateOri .= $SubQueryOri;
						$QryUpdateOri .= "`last_jump_time` = '". $JumpTime ."' ";
						$QryUpdateOri .= "WHERE ";
						$QryUpdateOri .= "`id` = '". $CurrentPlanet['id'] ."';";
						doquery ( $QryUpdateOri, 'planets');

						// Addition à la lune d'arrivée !
						$QryUpdateDes  = "UPDATE {{table}} SET ";
						$QryUpdateDes .= $SubQueryDes;
						$QryUpdateDes .= "`last_jump_time` = '". $JumpTime ."' ";
						$QryUpdateDes .= "WHERE ";
						$QryUpdateDes .= "`id` = '". $TargetGate['id'] ."';";
						doquery ( $QryUpdateDes, 'planets');

						$CurrentPlanet['last_jump_time'] = $JumpTime;
						$RetMessage = $lang['gate_jump_done'] ." - ". $RestString['string'];
					} else {
						$RetMessage = $lang['gate_wait_data'];
					}
				} else {
					$RetMessage = $lang['gate_wait_dest'] ." - ". $RestString['string'];
				}
			} else {
				$RetMessage = $lang['gate_no_dest_g'];
			}
		} else {
			$RetMessage = $lang['gate_wait_star'] ." - ". $RestString['string'];
		}
	} else {
		$RetMessage = $lang['gate_wait_data'];
	}

	return $RetMessage;
}

die(DoFleetJump($user, $planetrow));

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.1 - Updated for new redesigned jumping. A few small changed but as I don't fully understand the jump gate, if it aint broke don't fix it. (MadnessRed)
// 1.0 - Version from scrap .. y avait pas ... bin maintenant y a !!

?>
