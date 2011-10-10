<?php
// -----------------------------------------------
// +++++++++++++++++++++++++++++++++++++++++++++++
// PadaCombat v0.4 - By Pada (byhoratiss@hotmail.com)
// Released for http://project.xnova.es/
// Under Development on http://www.frutagame.com.ar/
// +++++++++++++++++++++++++++++++++++++++++++++++
// -----------------------------------------------


//File from josue.vieyra@gmail.com

function PadaCombat($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno) {
	global $pricelist, $CombatCaps, $game_config;
	
	$mtime = microtime();
	$mtime = explode(' ', $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime;
	
	foreach ($CurrentSet as $UID => $arrayx) {
		foreach ($arrayx as $ShipId => $quantity) {			
			$attacker_attack_power_left += $quantity * ($CombatCaps[$ShipId]['attack'] + $CombatCaps[$ShipId]['attack'] * (1 + (0.1 * $CurrentTechno[$UID]['military_tech']) + (0.05 * $CurrentTechno[$UID]['rpg_amiral'])));
			
			$attacker_structure[$UID][$ShipId] = $quantity;
			$attacker_start_debris['metal'] += $quantity * $pricelist[$ShipId]['metal'];
			$attacker_start_debris['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
		}
	}
	
	foreach ($TargetSet as $UID => $arrayx) {
		foreach ($arrayx as $ShipId => $quantity) {			
			$defender_attack_power_left += $quantity * ($CombatCaps[$ShipId]['attack'] + $CombatCaps[$ShipId]['attack'] * (1 + (0.1 * $CurrentTechno[$UID]['military_tech']) + (0.05 * $CurrentTechno[$UID]['rpg_amiral'])));
			
			$defender_structure[$UID][$ShipId] = $quantity;
			
			if($ShipId < 300) {
				$defender_start_debris['metal'] += $quantity * $pricelist[$ShipId]['metal'];
				$defender_start_debris['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
			}else{
				$defender_start_debris_defense['metal'] += $quantity * $pricelist[$ShipId]['metal'];
				$defender_start_debris_defense['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
			}
		}
	}

	for ($i = 1; $i < 8; $i++) {
		$totalrounds++;

		if(count($defender_structure) == 0){
			if(count($defender_structure) == 0 AND count($attacker_structure) == 0){
				$battle_result = 'd';
			}else{
				$battle_result = 'a';
			}
			break;
		}elseif(count($attacker_structure) == 0){
			$battle_result = 'v';
			break;
		}else if($totalrounds == 7){
			$battle_result = 'd';
			break;
		}
		
		$Simul = PadaAttack($attacker_structure, $defender_structure, $attacker_attack_power_left);
		$defender_structure = $Simul[0];
		$attacker_attack_power_left = $Simul[1];
		
		$Simul = PadaAttack($defender_structure, $attacker_structure, $defender_attack_power_left);
		$attacker_structure = $Simul[0];
		$defender_attack_power_left = $Simul[1];
		
		unset($Simul);
	}	
	
	$mtime = microtime();
	$mtime = explode(' ', $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$endtime = $mtime;
	
	$totaltime = round($endtime - $starttime, 5);
	
	$CurrentSet = $attacker_structure;
	$TargetSet = $defender_structure;
	
	if (!is_null($CurrentSet)) {
		foreach ($CurrentSet as $UID => $arrayx) {
			foreach ($arrayx as $ShipId => $quantity) {
				$attacker_end_debris['metal'] += $quantity * $pricelist[$ShipId]['metal'];
				$attacker_end_debris['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
			}
		}
	}
	
	if (!is_null($TargetSet)) {
		foreach ($TargetSet as $UID => $arrayx) {
			foreach ($arrayx as $ShipId => $quantity) {
				if ($ShipId < 300) {
					$defender_end_debris['metal'] += $quantity * $pricelist[$ShipId]['metal'];
					$defender_end_debris['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
				} else {
					$defender_end_debris_defense['metal'] += $quantity * $pricelist[$ShipId]['metal'];
					$defender_end_debris_defense['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
				}
			}
		}
	}
	
	$debris['metal'] += (($attacker_start_debris['metal'] - $attacker_end_debris['metal']) * ($game_config['Fleet_Cdr'] / 100));
	$debris['crystal'] += (($attacker_start_debris['crystal'] - $attacker_end_debris['crystal']) * ($game_config['Fleet_Cdr'] / 100));

	$debris['metal'] += (($defender_start_debris['metal'] - $defender_end_debris['metal']) * ($game_config['Fleet_Cdr'] / 100));
	$debris['crystal'] += (($defender_start_debris['crystal'] - $defender_end_debris['crystal']) * ($game_config['Fleet_Cdr'] / 100));
	
	$debris['metal'] += (($defender_start_debris_defense['metal'] - $defender_end_debris_defense['metal'])   * ($game_config['Defs_Cdr'] / 100));
	$debris['crystal'] += (($defender_start_debris_defense['crystal'] - $defender_end_debris_defense['crystal']) * ($game_config['Defs_Cdr'] / 100));
	
	$defenseMetal = ($defender_start_debris_defense['metal'] - $defender_end_debris_defense['metal']);
	$defenseCrystal = ($defender_start_debris_defense['crystal'] - $defender_end_debris_defense['crystal']);
	
	$debris['attacker'] = (($attacker_start_debris['metal'] - $attacker_end_debris['metal']) + ($attacker_start_debris['crystal'] - $attacker_end_debris['crystal']));
	$debris['defender'] = (($defender_start_debris['metal'] - $defender_end_debris['metal']) + ($defender_start_debris['crystal'] - $defender_end_debris['crystal']) + ($defenseMetal + $defenseCrystal));
	
	return array('attackers' => $CurrentSet, 'defenders' => $TargetSet, 'won' => $battle_result, 'debrmet'=> $debris['metal'], 'debrcry'=> $debris['crystal'], 'attlost'=> $debris['attacker'], 'deflost'=> $debris['defender'], 'rounds' => $totalrounds, 'time' => $totaltime);
	
}

function PadaAttack($attacker_structure, $defender_structure, $attack_power_left){
	global $CombatCaps;
	
	if($attack_power_left <= 1){
		return array($defender_structure, 0);
	}
	
	foreach ($attacker_structure as $UID => $arrayx) {
		foreach ($arrayx as $ShipId => $Quantity) {
			
			$JustShoot = 5;
			
			if($Quantity >= $JustShoot){
				$OnlyFire = round($Quantity / $JustShoot);
			}else{
				$OnlyFire = $Quantity;
			}
			// ONLY FIRE $JustShoot
			for ($j = 1; $j < $JustShoot; $j++) {
				$fire = true;
				
				// DONT CHECK RAPIDFIRE
				unset($AlreadyRF, $attack_power);
				
				while ($fire == true) {
					$fire = false;
					
					if (count($defender_structure) == 0) {
						$killed = 1;
					}
					
					if ($killed != 1) {
						srand((float) microtime() * 10000000);

						$randUser = @array_rand($defender_structure);
						$randShip = @array_rand($defender_structure[$randUser]);
						
						$selected_user = $randUser;
						$selected_shipid = $randShip;
					}
					
					// CALCULATE THE SHIP ATTACK POWER
					if(!isset($attack_power))
						$attack_power = $OnlyFire * ($CombatCaps[$ShipId]['attack'] + $CombatCaps[$ShipId]['attack'] * (1 + (0.1 * $CurrentTechno[$UID]['military_tech']) + (0.05 * $CurrentTechno[$UID]['rpg_amiral'])));
					
					if($attack_power > $attack_power_left){
						$attack_power = $attack_power_left;
					}
					
					if ($killed != 1) {
						
						$DefenderShipStats = getShipStats($selected_shipid, $TargetTechno);
						
						// SHIP SHIELD POWER
						if(!isset($shield_power_per_unit))
							$shield_power_per_unit = $DefenderShipStats['shield'];
						
						if(!isset($defense_power_per_unit))
							$defense_power_per_unit = $DefenderShipStats['defense'];
						
						
						// ATTACK POWER DOSNT DESTROY THE SHIP SHIELD
						if ($attack_power < $shield_power_per_unit) {
							
							// DECREASE SHIP SHIELD
							$shield_power_per_unit -= $attack_power;
							
							// DECREASE TOTAL POWER ATTACK
							$attack_power_left -= $attack_power;
							
							$attack_power = 0;
							
						// SHIELD MUST BE DESTROYED
						}if ($attack_power > $shield_power_per_unit) {
							
							$ShipsToDelete = round($attack_power / ($DefenderShipStats['shield'] + $DefenderShipStats['defense'] + 1));
							
							// AVAILABLE DEFENDER SHIPS
							$AvailableShips = $defender_structure[$selected_user][$selected_shipid];
							if($ShipsToDelete > $AvailableShips){
								$ShipsToDelete = $AvailableShips;
							}
							
							// DECREASE ATTACK POWER
							$attack_power -= (($DefenderShipStats['shield'] +  $DefenderShipStats['defense']) * $ShipsToDelete);
														
							// DECREASE TOTAL POWER ATTACK
							$attack_power_left -= (($DefenderShipStats['shield'] +  $DefenderShipStats['defense']) * $ShipsToDelete);
							
							// UPDATE ARRAYS
							$defender_structure = PadaDeleteShip($defender_structure, $selected_user, $selected_shipid, $ShipsToDelete);
							
							// UNSET THE ACTUAL SHIELD AND DEFENSE
							unset($shield_power_per_unit, $defense_power_per_unit);
						}
						
						
						// IF ATTACK POWER LEFT AND HASNT RAPIDFIRE YET
						if($attack_power AND !isset($AlreadyRF)){
							
							$AlreadyRF = true;
							
							$RF = $CombatCaps[$ShipId]['sd'][$selected_shipid];
							if($RF > 1){
								$RF_ = 100 * ($RF - 1) / $RF;

								$percent = mt_rand(1, 100);

								if($percent <= $RF_){
									$fire = true;
								}
							}else{
								$fire = false;
							}
						}					
					}
				}
			}
		}
	}
	
	return array($defender_structure, $attack_power_left);
	
}

function PadaDeleteShip($Arr, $UID, $ShipId, $Quantity){

	$Arr[$UID][$ShipId] -= $Quantity;
	if($Arr[$UID][$ShipId] <= 0) unset($Arr[$UID][$ShipId]);
	if(count($Arr[$UID]) <= 0) unset($Arr[$UID]);
	
	return $Arr;	
}

function getShipStats($ShipId, $TargetTechno){
	global $CombatCaps, $pricelist;
	
	$defense = ((($pricelist[$ShipId]['metal'] + $pricelist[$ShipId]['crystal']) / 10) * (1 + (0.1 * ($TargetTechno['defence_tech']) + (0.05 * $TargetTechno[$UID]['rpg_amiral']))));
	$shield = $CombatCaps[$ShipId]['shield'] * (1 + (0.1 * $TargetTechno[$UID]['shield_tech'])+ (0.05 * $TargetTechno[$UID]['rpg_amiral']));
	
	return array('defense' => $defense, 'shield' => $shield);
}

?>