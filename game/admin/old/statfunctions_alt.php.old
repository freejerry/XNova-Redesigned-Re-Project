<?php

/**
 * StatFunctions.php
 *
 * @version 1
 * @copyright 2008 by Chlorel for XNova
 *
 * @version 2
 * @copyright 2008 by Anthony for Darkness of Evolution and MadnessRed
 */

/*
function GetTechnoPoints ( $CurrentUser ) {
	global $resource, $pricelist, $reslist;

	$TechCounts = 0;
	$TechPoints = 0;
	foreach($reslist['tech'] as $n => $Techno){
		if ($CurrentUser[$resource[$Techno]] > 0) {
			$l1_cost = ($pricelist[$Techno]['metal'] + $pricelist[$Techno]['crystal'] + $pricelist[$Techno]['deuterium']);
			$TechPoints += ($l1_cost * 2 * pow($pricelist[$Techno]['factor'], $CurrentUser[$resource[$Techno]])) - $l1_cost;
			$TechCounts += $CurrentUser[$resource[$Techno]];
		}
	}
	$RetValue['TechCount'] = $TechCounts;
	$RetValue['TechPoint'] = $TechPoints;
	echo $TechCounts."<br />";
	echo $TechPoints."<br />";

	return $RetValue;
}
*/

function GetTechnoPoints ( $CurrentUser ) {
	global $resource, $pricelist, $reslist;

	$TechCounts = 0;
	$TechPoints = 0;
	foreach($reslist['build'] as $n => $Tech){
		if ($CurrentPlanet[$resource[$Tech]] > 0) {
			$l1_cost = ($pricelist[$Tech]['metal'] + $pricelist[$Tech]['crystal'] + $pricelist[$Tech]['deuterium']);
			$TechPoints += ($l1_cost * 2 * pow($pricelist[$Tech]['factor'], $CurrentPlanet[$resource[$Tech]])) - $l1_cost;
			$TechCounts += $CurrentUser[$resource[$Tech]];
		}
	}
	$RetValue['TechCount'] = $TechCounts;
	$RetValue['TechPoint'] = $TechPoints;

	return $RetValue;
}

function GetBuildPoints ( $CurrentPlanet ) {
	global $resource, $pricelist, $reslist;

	$BuildCounts = 0;
	$BuildPoints = 0;
	foreach($reslist['build'] as $n => $Building){
		if ($CurrentPlanet[$resource[$Building]] > 0) {
			$l1_cost = ($pricelist[$Building]['metal'] + $pricelist[$Building]['crystal'] + $pricelist[$Building]['deuterium']);
			$BuildPoints += ($l1_cost * 2 * pow($pricelist[$Building]['factor'], $CurrentPlanet[$resource[$Building]])) - $l1_cost;
			$BuildCounts += $CurrentUser[$resource[$Building]];
		}
	}
	$RetValue['BuildCount'] = $BuildCounts;
	$RetValue['BuildPoint'] = $BuildPoints;

	return $RetValue;
}

function GetDefensePoints ( $CurrentPlanet ) {
	global $resource, $pricelist, $reslist;

	$DefenseCounts = 0;
	$DefensePoints = 0;
	foreach($reslist['defense'] as $n => $Defense) {
		if ($CurrentPlanet[$resource[$Defense]] > 0) {
			$DefensePoints += (($pricelist[$Defense]['metal'] + $pricelist[$Defense]['crystal'] + $pricelist[$Defense]['deuterium']) * $CurrentPlanet[$resource[$Defense]]);
			$DefenseCounts += $CurrentPlanet[$resource[$Defense]];
		}
	}
	$RetValue['DefenseCount'] = $DefenseCounts;
	$RetValue['DefensePoint'] = $DefensePoints;

	return $RetValue;
}

function GetFleetPoints ( $CurrentPlanet ) {
	global $resource, $pricelist, $reslist;

	$FleetCounts = 0;
	$FleetPoints = 0;
	foreach($reslist['fleet'] as $n => $Fleet) {
		if ($CurrentPlanet[ $resource[ $Fleet ] ] > 0) {
			$Units          = $pricelist[ $Fleet ]['metal'] + $pricelist[ $Fleet ]['crystal'] + $pricelist[ $Fleet ]['deuterium'];
			$FleetPoints   += ($Units * $CurrentPlanet[ $resource[ $Fleet ] ]);
			$FleetCounts   += $CurrentPlanet[ $resource[ $Fleet ] ];
		}
	}
	$RetValue['FleetCount'] = $FleetCounts;
	$RetValue['FleetPoint'] = $FleetPoints;

	return $RetValue;
}
?>