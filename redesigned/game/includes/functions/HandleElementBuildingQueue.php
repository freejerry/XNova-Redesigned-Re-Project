<?php

/**
 * HandleElementBuildingQueue.php
 *
 * @version 2
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */

function HandleElementBuildingQueue ($CurrentUser, &$CurrentPlanet) {
	global $resource;
	
	//Right, lets make a new shipyard queue management.
	//So some stuff in shipyard?
	//echo $CurrentPlanet['b_hangar_id'];
	
	//Lets stop it complaining, we should define $cost as an array here
	$cost = array();
	
	if(strlen($CurrentPlanet['b_hangar_id']) > 0){
		//Whats be built, so far nothing,
		$built = array(); $cost = 0;
		
		//Lets explode the queue into an array
		$queue = explode(';', $CurrentPlanet['b_hangar_id']);
		
		//Son't stop yet, we haven't started
		$stop = false;
		
		//Make an array
		$built = array();
		
		//Clear the queue to add to it later.
		$CurrentPlanet['b_hangar_id'] = '';
		
		//When was hanger last updated?
		$ProductionTime = $CurrentPlanet['b_hangar_lastupdate'];
		
		//Check a time was set
		if($ProductionTime == 0){ $ProductionTime = time(); }
		
		//So how long since the update?
		$ProductionTime = time() - $ProductionTime;
		//echo "Last update: ".$CurrentPlanet['b_hangar_lastupdate']."<br />Time since then: ".$ProductionTime."<br />";
		
		//Incase any script tries to check again before we get to write to database
		$CurrentPlanet['b_hangar_lastupdate'] = time();
		
		//Add left overs from last attempt
		$ProductionTime += $CurrentPlanet['b_hangar'];
		//echo "Leftover time: ".$CurrentPlanet['b_hangar']."<br />";
		
		//now, keeping the queue in that order.
		foreach ($queue as $todo){
			//If its a blank entry, move on.
			if($todo == ''){ continue; }
			
			//Should we stop?
			if(!$stop){
				//Explodew the queue
				$q = explode(',',$todo);
				
				//Add the build time to the temp array
				$q[2] = GetBuildingTime ($CurrentUser, $CurrentPlanet, $q[0]);
				//echo "Build time: ".$q[2].'<br />Ammount: '.$q[1].'<br />Time to build in: '.$ProductionTime;
				
				//Now is there time to build all of these?
				if(($q[2] * $q[1]) <= $ProductionTime){
					$ProductionTime -= ($q[2] * $q[1]);
					$built[$q[0]] += $q[1];
					$CurrentPlanet[$resource[$q[0]]] += $q[1];
					//$ncost = GetBuildingPrice(array(),$CurrentPlanet,$q[0],false,false,true);
					$ncost = GetBuildingPrice(array(),$CurrentPlanet,$q[0],false);
					if(!is_array($ncost)){
						trigger_error("\$ncost returned from GetBuildingPrice was not the expected array. The following was returned.<br />".nl2br(print_r($ncost,true))."<br />The arguments were:<br />GetBuildingPrice(array(),".$CurrentPlanet.",".$q[0].",false,false,true);");
					}
					//foreach($ncost as $key => $val){ $cost[$key] += ($val * $q[1]); }
					foreach($ncost as $val){ $cost += ($val * $q[1]); }
				}
				//how about some of them?
				elseif(($q[2]) <= $ProductionTime){
					$canbuild = floor($ProductionTime/$q[2]);
					$ProductionTime -= ($q[2] * $canbuild);
					$built[$q[0]] += $canbuild;
					$CurrentPlanet[$resource[$q[0]]] += $canbuild;
					//$ncost = GetBuildingPrice(array(),$CurrentPlanet,$q[0],false,false,true);
					$ncost = GetBuildingPrice(array(),$CurrentPlanet,$q[0],false);
					if(!is_array($ncost)){
						trigger_error("\$ncost returned from GetBuildingPrice was not the expected array. The following was returned.<br />".nl2br(print_r($ncost,true))."<br />The arguments were:<br />GetBuildingPrice(array(),".$CurrentPlanet.",".$q[0].",false,false,true);");
					}
					//foreach($ncost as $key => $val){ $cost[$key] += ($val * $canbuild); }
					foreach($ncost as $val){ $cost += ($val * $canbuild); }
					
					//And lets upt the rest back into the queue
					$CurrentPlanet['b_hangar_id'] .= $q[0].",".($q[1]-$canbuild).";";
					
					//And stop doing stuff.
					$stop = true;
				}else{
					$CurrentPlanet['b_hangar_id'] .= $todo.";"; 
					$stop = true;
				}
			}else{
				$CurrentPlanet['b_hangar_id'] .= $todo.";";
			}
		}
		//And how much time is left over?
		$CurrentPlanet['b_hangar'] = $ProductionTime;	
		
		//Add what he build to the stats
		AddPoints($cost,false,$CurrentUser['id']);
	}else{
		$built = array(); $CurrentPlanet['b_hangar'] = 0;
	}
	
	//Update the database: if anything was built
	if(sizeof($built) > 0){
		$qry  = "UPDATE {{table}} SET ";
		foreach($built as $i => $c){
			$qry .= "`".$resource[$i]."` = '".$CurrentPlanet[$resource[$i]]."', ";
		}
		$qry .= "`b_hangar` = '".$CurrentPlanet['b_hangar']."', ";
		$qry .= "`b_hangar_id` = '".$CurrentPlanet['b_hangar_id']."', ";
		$qry .= "`b_hangar_lastupdate` = '".time()."' ";
		$qry .= "WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;";
		doquery($qry,'planets');
	}else{
		$qry  = "UPDATE {{table}} SET ";
		$qry .= "`b_hangar` = '".$CurrentPlanet['b_hangar']."', ";
		$qry .= "`b_hangar_id` = '".$CurrentPlanet['b_hangar_id']."', ";
		$qry .= "`b_hangar_lastupdate` = '".time()."' ";
		$qry .= "WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;";
		doquery($qry,'planets');
	}
	
	return $built;
}
?>
