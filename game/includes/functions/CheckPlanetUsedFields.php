<?php

/**
 *
 * CheckPlanetUsedFields.php
 *
 * @version 2
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */

// Check if the fields used count is right.
function CheckPlanetUsedFields ( &$CurrentPlanet ) {
	global $resource,$reslist,$user;

	// Every building...
	$slots = 0;foreach ($reslist['build'] as $id){	$slots += $CurrentPlanet[$resource[$id]]; }

	// So if the slots wrong in the database?
	if ($CurrentPlanet['field_current'] != $slots) {
		$message = $user['username']." (".$user['id'].") has ".$slots." used slots bu tthe database says he only has ".$CurrentPlanet['field_current'];
		$CurrentPlanet['field_current'] = $slots;
		doquery("UPDATE {{table}} SET `field_current` = '".$slots."' WHERE id='".$CurrentPlanet['id']."' LIMIT 1;", 'planets',false);
		trigger_error($message."^|^ANTI-CHEAT^|^Fields Checker^|^".__LINE__);
	}
}

?>