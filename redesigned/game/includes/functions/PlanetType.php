<?php

/**
 * PlanetType.php
 *
 * @version 1.0
 * @copyright 2008 By MadnessRed for XNova Redesigned
 */

function PlanetType($string){

	$de_planettype = preg_replace("/[^a-z]/", "", $string);
	if($de_planettype == "mond"){
		$parse['type'] = "moon";
	}elseif($de_planettype == "dschjungelplanet"){
		$parse['type'] = "jungle";
	}elseif($de_planettype == "eisplanet"){
		$parse['type'] = "ice";
	}elseif($de_planettype == "gasplanet"){
		$parse['type'] = "gas";
	}elseif($de_planettype == "trockenplanet"){
		$parse['type'] = "dry";
	}elseif($de_planettype == "wasserplanet"){
		$parse['type'] = "water";
	}elseif($de_planettype == "wuestenplanet"){
		$parse['type'] = "desert";
	}else{
		$parse['type'] = "normal";
	}
	//To get planet sub type (01 to 10) well will remove all except numbers. To remove the leading zeros, times by 1.
	$parse['subtype'] = (preg_replace("/[^0-9]/", "", $string)) * 1;

	return $parse;
}
?>
