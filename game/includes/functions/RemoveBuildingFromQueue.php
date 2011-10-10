<?php

/**
 * RemoveBuildingFromQueue.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

function RemoveBuildingFromQueue ( &$CurrentPlanet, $CurrentUser, $QueueID ) {
	
	//Check its a vlid item in the queue
	if ($QueueID > 1) {
		
		//See if there actually is a queue
		if ($CurrentPlanet['b_building_id'] != 0) {
			//Explode the queue into individual items
			$QueueArray		= explode ( ";", $CurrentPlanet['b_building_id'] );
			
			//Get size of the queue
			$ActualCount	= count ( $QueueArray );
			
			//Get the element before ours
			$ListIDArray	= explode ( ",", $QueueArray[$QueueID - 2] );
			
			//Get the element we are removing
			$element		= explode ( ",", $QueueArray[$QueueID - 1] );
			$change			= ($element[4] == 'build' ? -1 : 1);
			$element		= $element[0];
			
			//See when it would finish
			$BuildEndTime	= $ListIDArray[3];
			
			//Now loop through the rest of the items
			for ($ID = $QueueID; $ID < $ActualCount; $ID++ ) {
				//Get the current element into an array
				$ListIDArray		 = explode ( ",", $QueueArray[$ID] );
				
				//Ajust the level to what it should be.
				if($ListIDArray[0] == $element){
					$destroy = ($ListIDArray[4] == 'build' ? false : true);
					//$time = GetBuildingTime ($CurrentUser,$CurrentPlanet,$element,$destroy);
					$ListIDArray[1]	+= $change;
				}
				
				//Workout a new end time
				$BuildEndTime		+= $ListIDArray[2];
				
				//Add that to this element
				$ListIDArray[3]		 = $BuildEndTime;
				
				//Comile the array again.
				$QueueArray[$ID - 1] = implode ( ",", $ListIDArray );
			}
			//Remove the element being removed.
			unset ($QueueArray[$ActualCount - 1]);
			$NewQueue     = implode ( ";", $QueueArray );
		$CurrentPlanet['b_building_id'] = $NewQueue;
		}
	}

	return $QueueID;

}

//Version 1.1, when a building is removed, the other buildings of the same type are changed. EG if a level 16 building is removed, the level 17 building after it will become level 16.

?>