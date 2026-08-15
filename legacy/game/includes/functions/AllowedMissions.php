<?php
function AllowedMissions($UsedPlanet,$YourPlanet,$planet,$planettype,$fleet,$fleet_group_mr = 0,$check = false){
	global $lang;
	$missions = '';
	$goodmissions = array();
	//loop through missions
	foreach ($lang['type_mission'] as $id => $name){
		
		//Do not mention return or ipm missions
		if($id > 0 && $id != 10){
		
			//Parse array
			$miss = array();
			$miss['missid'] = $id;
			$miss['missname'] = $name;
			$miss['missdesc'] = $lang['desc_mission'][$id];		
		
			//Default settings
			$ships = array(202,203,204,205,206,207,208,209,210,211,213,214,215);	//By default, all ships
			$planets = array(1,MAX_PLANET_IN_SYSTEM);								//By default, entire system (not outer space)
			$planettypes = array(1,3);												//By default, planets and moons
			$owned = array(true,false);												//By default, both our and not our planets
			$exists = array(true);													//By default, do exist
			$fleetgroup = 0;														//By default, don't require fleet group
			$requireacs = false;													//By default, ACS does not need to be enabled
		
			//Now setings for each mission
			switch($id){
				// --- Attack --
				case 1:
					$owned = array(false);	
					break;
				
				// --- ACS Attack --
				case 2:
					$owned = array(false);
					$fleetgroup = 1;
					$requireacs = !ENABLE_ACS;
					break;
				
				// --- Transport --
				case 3:
				
					break;
				
				// --- Delpoy --
				case 4:
					$owned = array(true);
					break;
					
				// --- ACS Defend --
				case 5:
					$owned = array(false);
					$requireacs = !ENABLE_ACS;
					break;
				
				// --- Espionage --
				case 6:
					$ships = array(210);
					$owned = array(false);
					break;
				
				// --- Colinize --
				case 7:
					$ships = array(208);
					$owned = array(false);
					$exists = array(false);
					break;
				
				// --- Harvest --
				case 8:
					$ships = array(209);
					$planettypes = array(2);
				
					break;
				
				// --- Destroy --
				case 9:
					$ships = array(214);
					$planettypes = array(3);
					$owned = array(false);
				
					break;
				
				// --- Expedition --
				case 15:
					$ships = array(202,203,204,205,206,207,208,209,211,213,214,215);
					$planets = array(MAX_PLANET_IN_SYSTEM + 1,MAX_PLANET_IN_SYSTEM + 1);
					$exists = array(false);
					$planettypes = array(1,2,3);
				
					break;
			}
		
			//Work out shipscore, will return the number of the required ships, (anything over 0 is good)
			$shipscore = 0;
			foreach($ships as $sid){ $shipscore += $fleet[$sid]; }
		
			//Check the requirements
			if(
				$shipscore > 0 && 
				$planet >= $planets[0] && $planet <= $planets[1] && 
				in_array($planettype,$planettypes) && 
				in_array($YourPlanet,$owned) && 
				in_array($UsedPlanet,$exists) &&
				$fleet_group_mr >= $fleetgroup &&
				!$requireacs
			){
				//Parse template
				$missions .= parsetemplate(gettemplate('fleet/missionselecton'),$miss);
				//Add to allowed missions
				$goodmissions[$id] = $id;
			}else{
				//Parse template
				$missions .= parsetemplate(gettemplate('fleet/missionselectoff'),$miss);
				//This next biut can be used to debug if uncommented
				/*if($id == 15){
				if($shipscore <= 0){ echo "Bad shipscore<br />"; }
				if($planet < $planets[0] || $planet > $planets[1]){ echo "Planet out of range<br />"; }
				if(!in_array($planettype,$planettypes)){ echo "Bad planet type<br />"; }
				if(!in_array($YourPlanet,$owned)){ echo "Wrong planet owner<br />"; }
				if(!in_array($UsedPlanet,$exists)){ echo "Bad used state<br />"; }
				if($fleet_group_mr < $fleetgroup){ echo "Bad ACD<br />"; }
				}*/
			}
		
		}
		
	}
	//Return the result
	if($check)
		return $goodmissions;
	else
		return $missions;
}
?>
