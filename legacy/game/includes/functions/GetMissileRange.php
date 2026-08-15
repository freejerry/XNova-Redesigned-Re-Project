<?php

/**
 * GetMissileRange.php
 *
 * @version 2
 * @copyright 2008 by Anthony (MadnessRed) for Darkness
 * GPL Liscence - See LICENCE.TXT
 */

function GetMissileRange () {
	global $user, $resource;
	$range = 0;
	if ($user[$resource[117]] > 0) {
		$range += ($user[$resource[117]] * 5) - 1;
	}
	return $range;
}

?>