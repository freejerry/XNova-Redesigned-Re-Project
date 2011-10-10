<?php

/**
 * MissionCaseTransport.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

function MissionCaseTransport ( $FleetRow ) {
	global $lang;

	$from = doquery("SELECT * FROM {{table}} WHERE `id` = '". $FleetRow['owner_userid'] ."' LIMIT 1 ;",'planets',true);
	$to = doquery("SELECT * FROM {{table}} WHERE `id` = '". $FleetRow['target_userid'] ."' LIMIT 1 ;",'planets',true);
	RestoreRes ($FleetRow, false);
	$Message = sprintf( $lang['sys_tran_mess_owner'],
						$TargetPlanet['name'], "[".$TargetPlanet['galaxy'].":".$TargetPlanet['system'].":".$TargetPlanet['planet']."]",
						$FleetRow['metal'], $lang['Metal'],
						$FleetRow['crystal'], $lang['Crystal'],
						$FleetRow['deuterium'], $lang['Deuterium'] );
	SendSimpleMessage ($StartPlanet['id_owner'], '', $FleetRow['arrival'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
	if ($TargetPlanet['id_owner'] != $StartPlanet['id_owner']) {
		$Message = sprintf( $lang['sys_tran_mess_user'],
							$StartPlanet['name'], "[".$StartPlanet['galaxy'].":".$StartPlanet['system'].":".$StartPlanet['planet']."]",
							$TargetPlanet['name'], "[".$TargetPlanet['galaxy'].":".$TargetPlanet['system'].":".$TargetPlanet['planet']."]",
							$FleetRow['metal'], $lang['Metal'],
							$FleetRow['crystal'], $lang['Crystal'],
							$FleetRow['deuterium'], $lang['Deuterium'] );
		SendSimpleMessage ( $TargetPlanet['id_owner'], '', $FleetRow['arrival'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
	}	
}

// -----------------------------------------------------------------------------------------------------------
// History version

?>