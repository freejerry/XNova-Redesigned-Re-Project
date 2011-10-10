<?php

/**
 * PlanetResourceUpdate.php
 *
 * @version 2.0
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */


function PlanetResourceUpdate($CurrentUser, &$CurrentPlanet){
	global $resources;
	
	//We need to know the production rates
	$Caps = ProductionRates ($CurrentUser,$CurrentPlanet);
	
	//How long since last update?
	$time = time();
	$production = $time - $CurrentPlanet['last_update'];
	
	//Some how many resources where mined in that time?
	foreach($resources as $res){
		//How much should we expect to produce?
		$produce = ($Caps[$res.'_perhour'] / 3600) * $production;
		
		//Do we go over limit?
		if($CurrentPlanet[$res] > $Caps[$res.'_max']){
			//We started over the limit - so base production only
			$CurrentPlanet[$res] += ($game_config[$res.'_basic_income'] * $production);
		}elseif($CurrentPlanet[$res] + $produce > $Caps[$res.'_max']){
			//We have exceded storage limit - resources were produced up to that limit normall, then base production only
			$space = $Caps[$res.'_max'] - $CurrentPlanet[$res];
			
			//What percentage of that time was at base income?
			$pc_base = 1 - ($space / $produce);
			
			//So we got to full...
			$CurrentPlanet[$res] = $Caps[$res.'_max'];
			
			//Then carried on at base comsumption for $pc_base% of the time
			$CurrentPlanet[$res] += ($game_config[$res.'_basic_income'] * $production * $pc_base);			
		}else{
			//We have not exceded storage limit - add the total produce
			$CurrentPlanet[$res] += $produce;
		}
	}
	
	//See what was built
	$built = HandleElementBuildingQueue($CurrentUser,$CurrentPlanet,$production);
	
	//Now update the planet
	$qry  = "UPDATE {{table}} SET";
	foreach($resources as $res){
		$qry .= "`".$res."` = '".$CurrentPlanet[$res]."', ";
		$qry .= "`".$res."_perhour` = '".$Caps[$res.'_perhour']."', "; $CurrentPlanet[$res.'_perhour'] = $Caps[$res.'_perhour'];
		$qry .= "`".$res."_max` = '".$Caps[$res.'_max']."', "; $CurrentPlanet[$res.'_max'] = $Caps[$res.'_max'];
	}
	$qry .= "`energy_used` = '".$Caps['energy_used']."', "; $CurrentPlanet['energy_used'] = $Caps['energy_used'];
	$qry .= "`energy_max` = '".$Caps['energy_max']."', "; $CurrentPlanet['energy_max'] = $Caps['energy_max'];
	$qry .= "`last_update` = '".$time."', ";
	foreach($built as $element => $count){
		if ($Element > 0) {
			$qry .= "`".$resource[$element]."` = `".$resource[$element]."` + '".$count."', ";
		}
	}
	$qry .= "`b_hangar` = '".$CurrentPlanet['b_hangar']."', ";
	$qry .= "`b_hangar_id` = '".$CurrentPlanet['b_hangar_id']."' ";
	$qry .= "WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;";

	doquery("LOCK TABLE {{table}} WRITE", 'planets');
	doquery($qry, 'planets');
	doquery("UNLOCK TABLES", '');
	
}

// Revision History
// - 1.0 Mise en module initiale
// - 1.1 Mise a jour automatique mines / silos / energie ...
// - 2.0 Upaated for new ProductionRates file, better management of starage, 1 function to mange production, not 3 or 4 which are different.
?>