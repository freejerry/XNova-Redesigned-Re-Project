<?php
	function calculateAttack (&$attackers, &$defenders) {
		global $pricelist, $CombatCaps, $game_config, $resource;
		
		$totalResourcePoints = array('attacker' => 0, 'defender' => 0);
		
		$resourcePointsAttacker = array('metal' => 0, 'crystal' => 0);
		foreach ($attackers as $fleetID => $attacker) {
			foreach ($attacker['detail'] as $element => $amount) {
				$resourcePointsAttacker['metal'] += $pricelist[$element]['metal'] * $amount;
				$resourcePointsAttacker['crystal'] += $pricelist[$element]['crystal'] * $amount ;
				
				$totalResourcePoints['attacker'] += $pricelist[$element]['metal'] * $amount ;
				$totalResourcePoints['attacker'] += $pricelist[$element]['crystal'] * $amount ;
			}
		}
		
		$resourcePointsDefender = array('metal' => 0, 'crystal' => 0);
		foreach ($defenders as $fleetID => $defender) {
			foreach ($defender['def'] as $element => $amount) {								//Line20
				if ($element < 300) {
					$resourcePointsDefender['metal'] += $pricelist[$element]['metal'] * $amount ;
					$resourcePointsDefender['crystal'] += $pricelist[$element]['crystal'] * $amount ;
					
					$totalResourcePoints['defender'] += $pricelist[$element]['metal'] * $amount ;
					$totalResourcePoints['defender'] += $pricelist[$element]['crystal'] * $amount ;
				} else {
					if (!isset($originalDef[$element])) $originalDef[$element] = 0;
					$originalDef[$element] += $amount;
				}
			}
		}
		
		$max_rounds = MAX_ATTACK_ROUNDS;
		$max_rounds = 10;

		
		for ($round = 0, $rounds = array(); $round < $max_rounds; $round++) {
			$attackDamage  = array('total' => 0);
			$attackShield  = array('total' => 0);
			$attackAmount  = array('total' => 0);
			$defenseDamage = array('total' => 0);
			$defenseShield = array('total' => 0);
			$defenseAmount = array('total' => 0);
			$attArray = array();
			$defArray = array();
			
			foreach ($attackers as $fleetID => $attacker) {
				$attackDamage[$fleetID] = 0;
				$attackShield[$fleetID] = 0;
				$attackAmount[$fleetID] = 0;
				
				foreach ($attacker['detail'] as $element => $amount) {
					$defTech    = (1 + (0.1 * ($attacker['user']['defence_tech']) + (0.05 * $attacker['user']['rpg_amiral'])));
					$shieldTech = (1 + (0.1 * ($attacker['user']['shield_tech']) + (0.05 * $attacker['user']['rpg_amiral'])));
					$attTech	= (1 + (0.1 * ($attacker['user']['military_tech']) + (0.05 * $attacker['user']['rpg_amiral'])));
					
					$attackers[$fleetID]['techs'] = array($defTech, $shieldTech, $attTech);
					
					$thisDef	= $amount * ($pricelist[$element]['metal'] + $pricelist[$element]['crystal']) / 10 * $defTech * (rand(80, 120) / 100);
					$thisShield	= $amount * ($CombatCaps[$element]['shield']) * $shieldTech * (rand(80, 120) / 100);
					$thisAtt	= $amount * ($CombatCaps[$element]['attack']) * $attTech * (rand(80, 120) / 100);
					
					$attArray[$fleetID][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);
					
					$attackDamage[$fleetID] += $thisAtt;
					$attackDamage['total'] += $thisAtt;
					$attackShield[$fleetID] += $thisDef;
					$attackShield['total'] += $thisDef;
					$attackAmount[$fleetID] += $amount;
					$attackAmount['total'] += $amount;
				}
			}
			
			foreach ($defenders as $fleetID => $defender) {
				$defenseDamage[$fleetID] = 0;
				$defenseShield[$fleetID] = 0;
				$defenseAmount[$fleetID] = 0;
				
				foreach ($defender['def'] as $element => $amount) {								//Line80
					$defTech    = (1 + (0.1 * ($defender['user']['defence_tech']) + (0.05 * $defender['user']['rpg_amiral'])));
					$shieldTech = (1 + (0.1 * ($defender['user']['shield_tech']) + (0.05 * $defender['user']['rpg_amiral'])));
					$attTech	= (1 + (0.1 * ($defender['user']['military_tech']) + (0.05 * $defender['user']['rpg_amiral'])));
					
					$defenders[$fleetID]['techs'] = array($defTech, $shieldTech, $attTech);
					
					$thisDef	= $amount * ($pricelist[$element]['metal'] + $pricelist[$element]['crystal']) / 10 * $defTech;
					$thisShield	= $amount * ($CombatCaps[$element]['shield']) * $shieldTech * (rand(80, 120) / 100);
					$thisAtt	= $amount * ($CombatCaps[$element]['attack']) * $attTech * (rand(80, 120) / 100);
					
					if ($element == 407 || $element == 408) $thisAtt = 0;
					
					$defArray[$fleetID][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);
					
					$defenseDamage[$fleetID] += $thisAtt;
					$defenseDamage['total'] += $thisAtt;
					$defenseShield[$fleetID] += $thisDef;
					$defenseShield['total'] += $thisDef;
					$defenseAmount[$fleetID] += $amount;
					$defenseAmount['total'] += $amount;
				}
			}
			
			$rounds[$round] = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount, 'infoA' => $attArray, 'infoD' => $defArray);
			
			if ($defenseAmount['total'] <= 0 || $attackAmount['total'] <= 0) {
				break;
			}
			
			// Calculate hit percentages (ACS only but ok)
			$attackPct = array();
			foreach ($attackAmount as $fleetID => $amount) {
				if (!is_numeric($fleetID)) continue;
				$attackPct[$fleetID] = $amount / $attackAmount['total'];
			}
			
			$defensePct = array();
			foreach ($defenseAmount as $fleetID => $amount) {
				if (!is_numeric($fleetID)) continue;
				$defensePct[$fleetID] = $amount / $defenseAmount['total'];
			}
			
			// UGLY CODE!! WARNING
			$attacker_n = array();
			$attacker_shield = 0;
			foreach ($attackers as $fleetID => $attacker) {
				$attacker_n[$fleetID] = array();
				
				foreach($attacker['detail'] as $element => $amount) {
					$defender_moc = $amount * ($defenseDamage['total'] * $attackPct[$fleetID]) / $attackAmount[$fleetID];
					
					if ($amount > 0) {
						if ($attArray[$fleetID][$element]['shield']/$amount < $defender_moc) {
							$max_removePoints = floor($amount * $defenseAmount['total'] / $attackAmount[$fleetID] * $attackPct[$fleetID]);
							
							$defender_moc -= $attArray[$fleetID][$element]['shield'];
							$attacker_shield += $attArray[$fleetID][$element]['shield'];
							$ile_removePoints = floor($defender_moc / (($pricelist[$element]['metal'] + $pricelist[$element]['crystal'])  / 10));
							
							if ($max_removePoints < 0) $max_removePoints = 0;
							if ($ile_removePoints < 0) $ile_removePoints = 0;
							
							if ($ile_removePoints > $max_removePoints) {
								$ile_removePoints = $max_removePoints;
							}
							
							$attacker_n[$fleetID][$element] = ceil($amount - $ile_removePoints);
							if ($attacker_n[$fleetID][$element] <= 0) {
								$attacker_n[$fleetID][$element] = 0;
							}
						} else {
							$attacker_n[$fleetID][$element] = round($amount);
							$attacker_shield += $defender_moc;
						}
					} else {
						$attacker_n[$fleetID][$element] = round($amount);
						$attacker_shield += $defender_moc;
					}
				}
			}
			
			$defender_n = array();
			$defender_shield = 0;
			
			foreach ($defenders as $fleetID => $defender) {
				$defender_n[$fleetID] = array();
				
				foreach($defender['def'] as $element => $amount) {
					$attacker_moc = $amount * ($attackDamage['total'] * $defensePct[$fleetID]) / $defenseAmount[$fleetID];
					
					if ($amount > 0) {
						if ($defArray[$fleetID][$element]['shield']/$amount < $attacker_moc) {
							$max_removePoints = floor($amount * $attackAmount['total'] / $defenseAmount[$fleetID] * $defensePct[$fleetID]);
							$attacker_moc -= $defArray[$fleetID][$element]['shield'];
							$defender_shield += $defArray[$fleetID][$element]['shield'];
							$ile_removePoints = floor(($attacker_moc / ((($pricelist[$element]['metal'] + $pricelist[$element]['crystal']) / 10) )));
							
							if ($max_removePoints < 0) $max_removePoints = 0;
							if ($ile_removePoints < 0) $ile_removePoints = 0;
							
							if ($ile_removePoints > $max_removePoints) {
								$ile_removePoints = $max_removePoints;
							}
							
							$defender_n[$fleetID][$element] = ceil($amount - $ile_removePoints);
							if ($defender_n[$fleetID][$element] <= 0) {
								$defender_n[$fleetID][$element] = 0;
							}
						
						} else {
							$defender_n[$fleetID][$element] = round($amount);
							$defender_shield += $attacker_moc;
						}
					} else {
						$defender_n[$fleetID][$element] = round($amount);
						$defender_shield += $attacker_moc;
					}
				}
			}
			
			// "Rapidfire"
			/*
			foreach ($attackers as $fleetID => $attacker) {
				foreach ($defenders as $fleetID2 => $defender) {
					foreach($attacker['detail'] as $element => $amount) {
						if ($amount > 0) {
							foreach ($CombatCaps[$element]['sd'] as $c => $d) {
								if (isset($defender['def'][$c])) {
									if ($d > 0) {
										$d = $d / $defender['techs'][0] / $defender['techs'][1] * $attacker['techs'][2];
										$defender_n[$fleetID2][$c] -= floor(($amount * $d * (rand(0,100) / 100) / 2) * $defensePct[$fleetID2] * ($amount / $attackAmount[$fleetID]));
										if ($defender_n[$fleetID2][$c] <= 0) {
											$defender_n[$fleetID2][$c] = 0;
										}
									}
								}
							}
						}
					}
			
					foreach($defender['def'] as $element => $amount) {
						if ($amount > 0) {
							foreach ($CombatCaps[$element]['sd'] as $c => $d) {
								if (isset($attacker['detail'][$c])) {
									$d = $d / $defender['techs'][0] / $defender['techs'][1] * $attacker['techs'][2];
									$attacker_n[$fleetID][$c] -= floor(($amount * $d * rand(0,100) / 100 / 2) * $attackPct[$fleetID] * ($amount / $defenseAmount[$fleetID2]));
									if ($attacker_n[$fleetID][$c] <= 0) {
										$attacker_n[$fleetID][$c] = 0;
									}
								}
							}
						}
					}
				}
			}
			*/
			$rounds[$round]['attackShield'] = $attacker_shield;
			$rounds[$round]['defShield'] = $defender_shield;
			
			foreach ($attackers as $fleetID => $attacker) {
				$attackers[$fleetID]['detail'] = array_map('round', $attacker_n[$fleetID]);
			}
			
			foreach ($defenders as $fleetID => $defender) {
				$defenders[$fleetID]['def'] = array_map('round', $defender_n[$fleetID]);
			}
		}
		
		if ($attackAmount['total'] <= 0) {
			$won = 2; // defender
		
		} elseif ($defenseAmount['total'] <= 0) {
			$won = 1; // attacker
		
		} else {
			$won = 0; // draw
			$rounds[count($rounds)] = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount);
		}
		
		// Debree
		foreach ($attackers as $fleetID => $attacker) {
			foreach ($attacker['detail'] as $element => $amount) {
				$totalResourcePoints['attacker'] -= $pricelist[$element]['metal'] * $amount ;
				$totalResourcePoints['attacker'] -= $pricelist[$element]['crystal'] * $amount ;
				
				$resourcePointsAttacker['metal'] -= $pricelist[$element]['metal'] * $amount ;
				$resourcePointsAttacker['crystal'] -= $pricelist[$element]['crystal'] * $amount ;
			}
		}
		
		foreach ($defenders as $fleetID => $defender) {
			foreach ($defender['def'] as $element => $amount) {								//Line271
				if ($element < 300) {
					$resourcePointsDefender['metal'] -= $pricelist[$element]['metal'] * $amount ;
					$resourcePointsDefender['crystal'] -= $pricelist[$element]['crystal'] * $amount ;
					
					$totalResourcePoints['defender'] -= $pricelist[$element]['metal'] * $amount ;
					$totalResourcePoints['defender'] -= $pricelist[$element]['crystal'] * $amount ;
				} else {
					$lost = $originalDef[$element] - $amount;
					$giveback = $lost * (rand(70*0.8, 70*1.2) / 100);
					$defenders[$fleetID]['def'][$element] += $giveback;
				}
			}
		}
		
		$totalLost = array('att' => $totalResourcePoints['attacker'], 'def' => $totalResourcePoints['defender']);
		$debAttMet = ($resourcePointsAttacker['metal'] * 0.3);
		$debAttCry = ($resourcePointsAttacker['crystal'] * 0.3);
		$debDefMet = ($resourcePointsDefender['metal'] * 0.3);
		$debDefCry = ($resourcePointsDefender['crystal'] * 0.3);
					
		return array('won' => $won, 'debree' => array('att' => array($debAttMet, $debAttCry), 'def' => array($debDefMet, $debDefCry)), 'rw' => $rounds, 'lost' => $totalLost);
	}
?>
