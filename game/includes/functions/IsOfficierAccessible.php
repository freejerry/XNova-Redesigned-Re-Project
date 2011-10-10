<?php

/**
 * IsOfficierAccessible.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

// Verification si l'on a le droit ou non a un officier
// Retour:
//  0 => pas les Officiers necessaires
//  1 => Tout va tres bien on peut le faire celui l�
// -1 => On pouvait le faire, mais on est d�ja au level max
function IsOfficierAccessible ($CurrentUser, $Officier) {
	global $requeriments, $resource, $pricelist;

	if (isset($requeriments[$Officier])) {
		$enabled = true;
		foreach($requeriments[$Officier] as $ReqOfficier => $OfficierLevel) {
			if ($CurrentUser[$resource[$ReqOfficier]] &&
				$CurrentUser[$resource[$ReqOfficier]] >= $OfficierLevel) {
				$enabled = 1;
			} else {
				return 0;
			}
		}
	}
	if ($CurrentUser[$resource[$Officier]."_exp"] <= time()) {
		return 1;
	} else {
		return -1;
	}
}

?>