<?php

//Right in this file we need to get information about a certain building

/**

We need...

cost
	deconstructing costs the same as constructing. Eg going from 15 -> 14 costs the same as 13 -> 14
time
	depends on serval factors

**/



function BuildingCost($element,$level){
	global $pricelist,$chargeresources;
	
	//Start the cost array
	$cost = array('sum' => 0);
	
	//Loops though the resources which can be charged
	foreach ($chargeresources as $res) {
		//Work out the cost of the resource
		$cost[$res] = $pricelist[$element][$res] * pow($pricelist[$element]['factor'],($level - 1));
		$cost['sum'] += $pricelist[$element][$res] * pow($pricelist[$element]['factor'],($level - 1));
	}
	
	//Thats it, return cost
	return $cost;
}

function BuildingTime($element,$level,$CurrentPlanet,$CurrentUser = array()){
	global $game_config,$reslist,$resource;
	
	
	//note that betweem $CurrentSet and $CurrentPLanet, all thats needed is...
	/*
	buildings
		$resource[14]
		$resource[15]
	shipyard
		$resource[21]
		$resource[15]
	research
		id_owner
		current_planet
		$resource[31]
		$resource[123]
	*/
	
	//Merge the user and planet
	$CurrentSet = array();
	$need = array($resource[14],$resource[15],$resource[21],'id_owner','current_planet',$resource[31],$resource[123]);
	foreach($need as $key){
		$CurrentSet[$key] = $CurrentUser[$key] + $CurrentPlanet[$key];
	}
	
	//We need to work out multiplier
	
	//Is it a building?
	if(in_array($element, $reslist['build'])){
		// For buildings
		$multiplier = (1 / ($CurrentSet[$resource['14']] + 1)) * pow(0.5, $CurrentSet[$resource['15']]);
	
	//Else if its a ship or defense
	}elseif(in_array($element, $reslist['defense']) || in_array($element, $reslist['fleet'])) {
		// For shipyard / defense
		$multiplier = (1 / ($CurrentSet[$resource['21']] + 1)) * pow(1 / 2, $CurrentSet[$resource['15']]);
	
	//Else if its a research
	}elseif(in_array($element, $reslist['tech'])) {
		// For research		
		
		//Intergalactic Research Network
		$lablevel = $CurrentSet[$resource['31']];
		
		//If we have IRN
		if($CurrentSet[$resource[123]] > 0){
			$empire = doquery("SELECT `".$resource['31']."` FROM {{table}} WHERE `id_owner` ='". $CurrentSet['id_owner'] ."' AND `id` <>'". $CurrentSet['current_planet'] ."' ORDER BY `".$resource['31']."` DESC LIMIT 0 , ". $CurrentSet[$resource[123]] ." ;", 'planets');
			//Loop through colonies
			while ($colonie = mysql_fetch_array($empire)) {
				//Add there lab level to combined lab level
				$lablevel += $colonie[$resource['31']];
			}
		}
		//End IRN
		
		$multiplier = 1 / (($lablevel + 1) * 2);
	}else{
		//Its not one of the above
		$multiplier = 1;
	}
	
	//Now work out the cost
	$cost = BuildingCost($element,$level);
	
	//Now work out time
	$time  = (($cost['metal'] + $cost['crystal']) / $game_config['game_speed']);	//Base time in hours
	$time *= $multiplier;															//Use the multiplier
	$time  = floor($time * 3600);													//Convert to seconds
	
	//Return time
	return $time;
}


?>
