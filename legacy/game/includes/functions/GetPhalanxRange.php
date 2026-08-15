<?php

/**
 * GetPhalanxRange.php
 *
 * @version 2
 * @copyright 2008 by Anthony (MadnessRed) for Darkness
 * GPL Liscence - See LICENCE.TXT
 */

function GetPhalanxRange ( $PhalanxLevel ) {
	$PhalanxRange = 0;
	if ($PhalanxLevel > 1) { $PhalanxRange = (pow($PhalanxLevel,2)) - 1; }
	return $PhalanxRange;
}
?>