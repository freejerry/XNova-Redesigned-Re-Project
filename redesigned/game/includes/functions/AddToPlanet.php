<?php


//Function to add an item to a planet, remove the resources (optionally) and update points

function AddToPlanet($CurrentPlanet,$element,$mode,$charge = false){
	global $resources,$resource,$reslist;
	
	//Well, we need to work out the cost for the points and edit the planets table
	
	//Standard construction
	//Get the cost
	$cost = BuildingCost($element,$CurrentPlanet[$resource[$element]] + $mode);
	
	$chargestr = '';
	if($charge){
		//If we are changine

		foreach($resources as $res){
			//loop through resources
			
			//Now add to query
			$chargestr .= ", `".$res."` = `".$res."` - '".$cost[$res]."' ";
			
		}	
	}
	
	//And we will want a + in the query
	$p_sign = "+";
	
	//If its deconstruction though..
	if($mode < 0){
		//Deconstructon
		
		//Get the cost
		$cost = BuildingCost($element,$CurrentPlanet[$resource[$element]]);
		
		//And we will want a - in the query
		$p_sign = "-";
	}
	
	//start total cost
	$tcost = 0;
	
	//Now the resources which count towards points
	foreach($resources as $res){
		//Add them to the total
		$tcost += $cost[$res];
	}
	
	//Now update the table
	$qry = "UPDATE {{table}} SET `".$resource[$element]."` = `".$resource[$element]."` ".$p_sign." ".idstring(abs($mode))." ".$chargestr." WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;";
	$return = doquery($qry,'planets',false);
	
	//If it is less than 100, update slots used
	if($element < 100){
		doquery("UPDATE {{table}} SET `field_current` = `field_current` ".$p_sign." ".idstring(abs($mode))." WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;",'planets',false);		
	}
	
	//Now update the users stats
	//	Are we making fleet?
	$fleet_points = 0;
	if(in_array($element,$reslist['fleet'])){ $fleet_points += $mode; }
	
	//Update in database
	doquery("UPDATE {{table}} SET `total_points` = `total_points` + '".$tcost."', `fleet_points` = `fleet_points` + '".$fleet_points."' WHERE `id` = '".$CurrentPlanet['id_owner']."' LIMIT 1 ;",'users');
	
	//Return the result
	return $return;
}

?>
