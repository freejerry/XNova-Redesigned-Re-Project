<?php

/**
 * ShowGalaxySelector.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function ShowGalaxySelector ( $Galaxy, $System ) {
	global $lang;

	$Galaxy = idstring($Galaxy); $System = idstring($System);

	if ($Galaxy > MAX_GALAXY_IN_WORLD) {
		$Galaxy = MAX_GALAXY_IN_WORLD;
	}
	if ($Galaxy < 1) {
		$Galaxy = 1;
	}
	if ($System > MAX_SYSTEM_IN_GALAXY) {
		$System = MAX_SYSTEM_IN_GALAXY;
	}
	if ($System < 1) {
		$System = 1;
	}

	$parse = $lang;

	$parse['cur_gal'] = $Galaxy;
	$parse['cur_sys'] = $System;

	//Galaxy
	if($Galaxy != 1){
		$parse['agb'] = '<a href="#"
				onmouseover="image1.src=\''.GAME_SKIN.'/img/galaxy/pfeil_links-a.gif\';"
				onmouseout="image1.src=\''.GAME_SKIN.'/img/galaxy/pfeil_links.gif\';"
                onclick="loadpage(\'./?page=galaxy&mode=1&galaxy='.($Galaxy - 1).'&system='.$System.'\',document.title,\'galaxy\');">';
	}else{
		$parse['agb'] = '<a href="#"
                onmouseover="image1.src=\''.GAME_SKIN.'/img/galaxy/pfeil_links_inaktiv.gif\';"
                onmouseout="image1.src=\''.GAME_SKIN.'/img/galaxy/pfeil_links_inaktiv.gif\';">';
	}

	if($Galaxy != MAX_GALAXY_IN_WORLD){
		$parse['agn'] = '<a href="#"
				onmouseover="image2.src=\''.GAME_SKIN.'/img/galaxy/pfeil_rechts-a.gif\';"
				onmouseout="image2.src=\''.GAME_SKIN.'/img/galaxy/pfeil_rechts.gif\';"
                onclick="loadpage(\'./?page=galaxy&mode=1&galaxy='.($Galaxy + 1).'&system='.$System.'\',document.title,\'galaxy\');">';
	}else{
		$parse['agn'] = '<a href="#"
                onmouseover="image2.src=\''.GAME_SKIN.'/img/galaxy/pfeil_rechts_inaktiv.gif\';"
                onmouseout="image2.src=\''.GAME_SKIN.'/img/galaxy/pfeil_rechts_inaktiv.gif\';">';
	}

	//Now for system
	if($System != 1){
		$parse['asb'] = '<a href="#"
				onmouseover="image3.src=\''.GAME_SKIN.'/img/galaxy/pfeil_links-a.gif\';"
				onmouseout="image3.src=\''.GAME_SKIN.'/img/galaxy/pfeil_links.gif\';"
                onclick="loadpage(\'./?page=galaxy&mode=1&galaxy='.$Galaxy.'&system='.($System - 1).'\',document.title,\'galaxy\');">';
	}else{
		$parse['asb'] = '<a href="#"
                onmouseover="image3.src=\''.GAME_SKIN.'/img/galaxy/pfeil_links_inaktiv.gif\';"
                onmouseout="image3.src=\''.GAME_SKIN.'/img/galaxy/pfeil_links_inaktiv.gif\';">';
	}

	if($System != MAX_SYSTEM_IN_WORLD){
		$parse['asn'] = '<a href="#"
				onmouseover="image4.src=\''.GAME_SKIN.'/img/galaxy/pfeil_rechts-a.gif\';"
				onmouseout="image4.src=\''.GAME_SKIN.'/img/galaxy/pfeil_rechts.gif\';"
                onclick="loadpage(\'./?page=galaxy&mode=1&galaxy='.$Galaxy.'&system='.($System + 1).'\',document.title,\'galaxy\');">';
	}else{
		$parse['asn'] = '<a href="#"
                onmouseover="image4.src=\''.GAME_SKIN.'/img/galaxy/pfeil_rechts_inaktiv.gif\';"
                onmouseout="image4.src=\''.GAME_SKIN.'/img/galaxy/pfeil_rechts_inaktiv.gif\';">';
	}

	return parsetemplate(gettemplate('galaxy/galaxy_head_div'), $parse);
}

?>
