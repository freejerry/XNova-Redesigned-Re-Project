<?php

 /**
   * mr_attack.php
   * This file is created from scratch by MadnessRed for Darkness of Evolution.
   * The formulas from this file game from teh OGame wikia.
   * Anthony [madnessred@gmail.com] is the sole owner of this file. You may use this file but Credit for the Combat Engine, including RapidFire, ACS and Bounce Effect must be given to MadnessRed or Anthony in teh Changelog or Credit page. Where this is not possible an email should be sent to madnessred@gmail.com for more information on what to do.
   * This file is under the GPL lisence, which must be included with this file.
   * This file must not be made available on other locations without first consulting MadnessRed.
   * Do NOT edit this comment block.
   */

function chance ($percent) {  //MadnessRed function
	$chance = mt_rand(0,100);
	if($percent <= $chance){
		return true;
	}else{
		return false;		
	}
}
   
/*
get all the ships and techs.
$fleets
	[id] =>
	array(
		[id_owner]
		[leader]
		[origin]
		[side]
	}
		
$att_ships
	[id] =>
	array(
		[fleet]
		[type]
		[weaps]
		[shields]
		[hull]
	)
$def_ships
	[id] =>
	array(
		[id]
		[fleet]
		[type]
		[weaps]
		[shields]
		[hull]
	)
*/

function mr_attack($att_ships,$def_ships,$debug){
	global $CombatCaps, $pricelist;
	//list any new fucntions used here for furture use.
	// chance() 			functions.php

	//Lets set set stuff straight here.
	//There are 6 rounds.
	$maxrounds = 6;
	$debris_pc = 0.3; //30%
	$shipsend = 299; //ships are less than
	$def2deb = false; //Defence counts toward debrisfield.

	//Start the running totals.
	$attlost = 0;
	$deflost = 0;
	$debrmet = 0;
	$debrcry = 0;
	
	//Start the results array
	$results = array();

	//Start the rounds
	$rounddata = array();
	
	//Whilst neither side has won it is still a draw.
	$results['won'] = 'd';
	
	//For each round...
	for($round = 1; $round <= $maxrounds; $round++){
		//Start round info.
		$roundinfo = array();
		
		//Check that one side hasn't won yet.
		if (count($def_ships) == 0){
			$results['won'] = 'a';
			$round = ($maxrounds +1);
		}elseif (count($att_ships) == 0){
			$results['won'] = 'v';
			$round = ($maxrounds +1);
		}else{
			//First attacker fires, so, for each attacker.
			foreach($att_ships as $id => $info){
				if($debug){
					echo "Ship: ".$id.".";
					echo "<br />";
				}
				//Don't stop firing yet, haven't even done one shot.
				$stopfiring = false;
				while($stopfiring == false){
					$target = array_rand($def_ships);
					//$target = $target['id'];
					if($debug){
						echo "Target: ".$target.".";
						echo "<br />";
					}
					if(strlen($target) > 0){
						//our target is $def_ships[$target].
						//our target is not destroyed and has shields
						$destroyed = false; $noshields = false;
						//Our target is ship type.
						$element = $def_ships[$target]['type'];
						if($debug){
							echo "Target type: ".$element.".";
							echo "<br />";
						}
						//Are his shields still intact?
						if($def_ships[$target]['shields'] > 0){
							//Does boucing effect apply. (http://ogame.wikia.com/wiki/Bouncing_Effect)
							if($def_ships[$target]['shields'] <= ($info['weaps'] * 100)){
								//Did we destroy the shields?
								if($def_ships[$target]['shields'] <= $info['weaps']){
									$curattack = $info['weaps'];
									$curattack -= $def_ships[$target]['shields'];
									$def_ships[$target]['shields'] -= $def_ships[$target]['shields'];
									$def_ships[$target]['hull'] -= $curattack;
									$noshields = true;
									$roundinfo['attblock'] += $def_ships[$target]['shields'];
								}else{
									$def_ships[$target]['shields'] -= $info['weaps'];
									$roundinfo['attblock'] += $info['weaps'];
								}
							}else{
								$roundinfo['attblock'] += $info['weaps'];
							}
						}else{
							$noshields = true;
						}
						//OK, we have fired, now stop firing and log it as a fire.
						$stopfiring = true;
						$roundinfo['attfires']++;
						$roundinfo['attpower'] += $info['weaps'];
						//Have we destroyed his shields?
						if($noshields){
							$orighull = (($pricelist[$element]['metal'] + $pricelist[$element]['crystal'])  / 10);
							$nowhull = $def_ships[$target]['hull'];
							//Is the ship already destroyed.
							if($nowhull <= 0){ $destroyed = true; }
							//The chance that the ship is destroyed is the percentage remaining of the hull.
							$chance = ($nowhull / $orighull);
							//So there is a $chance chance if it beign destroyed, so run chance function. (or it may already be dead)
							if((chance($chance)) || $destroyed){
								//Ship destroyed. Lets inspect the costs.
								$element = $def_ships[$target]['type'];
								$deflost += ($pricelist[$element]['metal'] + $pricelist[$element]['crystal'] + $pricelist[$element]['deuterium']);
								if(($element <= $shipsend) || $def2deb){
									//it counts toward debris field.
									$debrmet += ($pricelist[$element]['metal'] * $debris_pc);
									$debrcry += ($pricelist[$element]['crystal'] * $debris_pc);
								}
								//Uh oh, ship destroyed, remove it from the array.
								unset($def_ships[$target]);
								//now for rapidfire.
								$rapidfire = $CombatCaps[$info['type']]['sd'][$element];
								$fireagain = ((1 - (1 / $rapidfire)) * 100);
								//So does he fire again?
								if(chance($fireagain)){
									if($debug){
										echo "Rapid Fire: Go.";
										echo "<br />";
									}
									//yes he, does, cancel that stop firing command.
									$stopfiring = false;
								}
							}
						}
					}else{
						$stopfiring = true;
					}
				}
			}
				
			//Payback time
			foreach($def_ships as $id => $info){
				//Don't stop firing yet, haven't even done one shot.
				$stopfiring = false;
				while($stopfiring == false){
					$targt = array_rand($att_ships);
					$target = $targt['id'];
					//our target is $att_ships[$target].
					//our target is not destroyed and has shields
					$destroyed = false; $noshields = false;
					//Our target is ship type.
					$element = $att_ships[$target]['type'];
					//Do is his shield intact?
					if($att_ships[$target]['shields'] > 0){
						//Does boucing effect apply. (http://ogame.wikia.com/wiki/Bouncing_Effect)
						if($att_ships[$target]['shields'] <= ($info['weaps'] * 100)){
							//Did we destroy the shields?
							if($att_ships[$target]['shields'] <= $info['weaps']){
								$curattack = $info['weaps'];
								$curattack -= $att_ships[$target]['shields'];
								$att_ships[$target]['shields'] -= $att_ships[$target]['shields'];
								$att_ships[$target]['hull'] -= $curattack;
								$noshields = true;
								$roundinfo['defblock'] += $def_ships[$target]['shields'];
							}else{
								$att_ships[$target]['shields'] -= $info['weaps'];
								$roundinfo['defblock'] += $info['weaps'];
							}
						}else{
							$roundinfo['defblock'] += $info['weaps'];
						}
					}else{
						$noshields = true;
					}
					//OK, we have fired, now stop firing.
					$stopfiring = true;
					$roundinfo['deffires']++;
					$roundinfo['defpower'] += $info['weaps'];
					//Have we destroyed his shields?
					if($noshields){
						$orighull = (($pricelist[$element]['metal'] + $pricelist[$element]['crystal'])  / 10);
						$nowhull = $att_ships[$target]['hull'];
						//Is the ship already destroyed.
						if($nowhull <= 0){ $destroyed = true; }
						//The chance that the ship is destroyed is the percentage remaining of the hull.
						$chance = ($nowhull / $orighull);
						//So there is a $chance chance if it beign destroyed, so run chance function. (or it may already be dead)
						if((chance($chance)) || $destroyed){
							//Ship destroyed. Lets inspect the costs.
							$element = $att_ships[$target]['type'];
							$attlost += ($pricelist[$element]['metal'] + $pricelist[$element]['crystal'] + $pricelist[$element]['deuterium']);
							if(($element <= $shipsend) || $def2deb){
								//it counts toward debris field.
								$debrmet += ($pricelist[$element]['metal'] * $debris_pc);
								$debrcry += ($pricelist[$element]['crystal'] * $debris_pc);
							}
							//Uh oh, ship destroyed, remove it from the array.
							unset($att_ships[$target]);
							//now for rapidfire.
							$rapidfire = $CombatCaps[$info['type']]['sd'][$att_ships[$target]['type']];
							$fireagain = ((1 - (1 / $rapidfire)) * 100);
							//So does he fire again?
							if(chance($fireagain)){
								//yes he, does, cancel that stop firing command.
								$stopfiring = false;
							}
						}
					}
				}
			}
		}
		
		//Now return the round info.
		$rounddata[$round]['atts'] = $att_ships;
		$rounddata[$round]['defs'] = $def_ships;
		$rounddata[$round]['info'] = $roundinfo;
	}
	
	//Make array from the the running totals.
	$losses['att'] = $attlost;
	$losses['def'] = $deflost;
	$losses['debm'] = $debrmet;
	$losses['debc'] = $debrcry;
	
	//Add losses to results.
	$results['losses'] = $losses;

	//Add round data to the results.
	$results['rounds'] = $rounddata;

	//Return the end result.
	return $results;
}
?>