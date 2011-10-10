<?php

/**
 * MissileAttack.php
 *
 * @version 1
 * @copyright 2008 By MadnessRed for XNova Redesigned
 */

//ALTER TABLE `game_fleets` ADD `target` INT( 3 ) NOT NULL DEFAULT '0' AFTER `fleet_group` ;
function shuffle_array($array){
	$arraykeys=array_keys($array);
	$size=sizeof($array);

	$return=array();

	while($size > 0) {
		$element=array_rand($arraykeys);
		$return[$arraykeys[$element]] = $array[$arraykeys[$element]];
		unset($arraykeys[$element]);
		$size--;
	}
	return $return;
}

function MissileAttack($FleetRow,$CurrentPlanet = false,$db = true){
	global $resource, $reslist, $pricelist, $CombatCaps, $lang;
	
	getLang('galaxy');
	
	//Star with a blank array
	$return = array();

	//Get the missiles, as there is on 1 type of ship...
	$missiles = explode(",",$FleetRow['fleet_array']);
	$missile_count = idstring($missiles[1]);
	
	//Get the planet
	if(!$CurrentPlanet){
		$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$FleetRow['target_id']."' LIMIT 1 ;",'planets',true); 
	}
	
	//Backup current planet, it will be needed
	$OriginalCurrentPlanet = $CurrentPlanet;
	
	//Get the armour
	foreach($reslist['defense'] as $element){ $hull[$element] = (($pricelist[$element]['metal'] + $pricelist[$element]['crystal']) / 10); }

	//Now ipms will destroy some of the missiles
	//First get the defending power.
	if($db){
		$weapons = doquery("SELECT `username`,`".$resource[109]."` FROM {{table}} WHERE `id` = '".$FleetRow['owner_userid']."' LIMIT 1 ;",'users',true); $attackername = $weapons['username']; $weapons = ($weapons[$resource[109]] / 10);
		$armour = doquery("SELECT `username`,`".$resource[110]."` FROM {{table}} WHERE `id` = '".$FleetRow['target_userid']."' LIMIT 1 ;",'users',true); $defendername = $armour['username']; $armour = ($armour[0] / 10);
	}else{
		$weapons = $FleetRow['weap']; $armour = $FleetRow['arm'];
	}
	
	//Are the IPMs completely destroyed byt the ABMs?
	if($missile_count >= $CurrentPlanet[$resource[502]]){
		$missile_count -= $CurrentPlanet[$resource[502]];
		$return['abm_cost'] = $CurrentPlanet[$resource[502]];
	}else{
		$return['abm_cost'] = $missile_count;
		$missile_count = 0;
	}
	$CurrentPlanet[$resource[502]] -= $return['abm_cost'];

	//If there are no missiles left, battle over, lets go home
	if($missile_count <= 0){
		//there was no battle
		$return['battle'] = 'X';
	}else{
		//Get Attack strength
		$attack = ($missile_count * $weapons * $CombatCaps[idstring($missiles[0])]['attack']);
		
		//Do we have a target
		if(idstring($FleetRow['target']) < 500 && in_array($FleetRow['target'],$reslist['defense'])){
			//Get target
			$target = idstring($FleetRow['target']);
			$return['battle'][1]['target'] = $target;
			$return['battle'][1]['target_count'] = $CurrentPlanet[$resource[$target]];
			
			//Get defense from target
			$curdefense = $CurrentPlanet[$resource[$target]] * $armour * $hull[$target];
			$return['battle'][1]['target_defense'] = $curdefense;
			$return['battle'][1]['current_ipm_strength'] = $CombatCaps[idstring($missiles[0])]['attack'];
			$return['battle'][1]['current_attack'] = $attack;
			
			//Do we destroy is and take damage, or is it only partially destroyed?
			if($attack >= $curdefense){
				$attack -= $curdefense;
				$CurrentPlanet[$resource[$target]] = 0;
				$curdefense = 0;
			}else{
				$CurrentPlanet[$resource[$target]] = ceil(($curdefense - $attack) / $armour);
				$attack = 0;
			}
			
			//Return the results for this part.
			$return['battle'][1]['target_new_count'] = $CurrentPlanet[$resource[$target]];
		}
		
		//Do we still have missiles?
		if($attack > 0){
			//Attack left
			$return['battle'][2]['remaining_attack'] = $attack;
			
			//Get total defense
			$defence = array();
			foreach($reslist['defense'] as $item){
				if($item < 500 && $CurrentPlanet[$resource[$item]]){
					$defence[$item] = $CurrentPlanet[$resource[$item]] * $armour * $hull[$item];
				}
			}
			//Work out current defense
			$curdefense = array_sum($defence);
			
			//Some return values
			$return['battle'][2]['defense'] = $defence;
			$return['battle'][2]['defense_total'] = $curdefense;
		      
			//Are defences totall destroyed?
			if($curdefense <= $attack){
				//yes, lets just kill everything
				foreach(array_keys($defence) as $element){
					$CurrentPlanet[$resource[$element]] = 0;
					$defence[$element] = 0;
				}
				//Now remove $element from memory
				unset($element);

				//Some info for the return
				$return['battle'][2]['short'] = true;
				$return['battle'][2]['final_defense'] = $defence;
			}else{
				//now we need to work out how much is destroyed.
				$percent = ($attack / $curdefense);
				$return['battle'][2]['damage'] = round($percent * 100,2)."%";
				$percent = (1 - $percent);

				//Pick random defenses (or shuffle the array)
				$defence = shuffle_array($defence); $spare = 0;
				
				//Get all the defence elements
				foreach(array_keys($defence) as $element){
					// Do the damage
					$defence[$element] *= $percent;

					//And also any fire power left from the last target.
					if($defence[$element] <= $spare){
						$spare -= $defence[$element];
						$defence[$element] = 0;
					}else{
						$defence[$element] -= $spare;
						$spare = 0;
					}

					// Work out the spare after all the whole destroyed ones are removes
					$spare += $defence[$element] % ($armour * $hull[$element]);

					//Now put back the rest... not finished
					$CurrentPlanet[$resource[$element]] = ceil($defence[$element] / ($armour * $hull[$element]));
				}
				//Now remove $element from memory
				unset($element);

				//Some info for the return
				$return['battle'][2]['short'] = false;
				$return['battle'][2]['new_defense'] = $defence;
				$return['battle'][2]['remaining'] = $spare;

				//Great now we have fired in a random order but we may still have a small bit of firepower left which can be used.
				//We should sort the defense by armour, with the highest elvel first,t hat way all the remaining firepower will be used.
				arsort($hull);
				foreach($hull as $id => $val){
					$remain = ($defence[$id] % $val);
					if($remain < $spare){
						$spare -= $remain;
						$defence[$id] -= $remain;
						$CurrentPlanet[$resource[$id]]--;
					}
				}
				//Now remove $id and $val from memory
				unset($id,$val);

				//Some info for the return
				$return['battle'][2]['cleaned_defense'] = $defence;
				$return['battle'][2]['still_remaining'] = $spare;

				//Loop through ships and get the hull VALue for each ID
				foreach($hull as $id => $val){
					$candestroy = floor($spare / ($armour * $val));
					if($CurrentPlanet[$resource[$id]] < $candestroy){
						$candestroy = $CurrentPlanet[$resource[$id]];
					}
					$CurrentPlanet[$resource[$id]] -= $candestroy;
					$spare -= ($armour * $val * $candestroy);
					//now set $defence to the remaining defenses
					if($CurrentPlanet[$resource[$id]]){ $defence[$id] = $CurrentPlanet[$resource[$id]]; }else{ unset($defence[$id]); }
				}
				//Now remove $id and $val from memory
				unset($id,$val);

				//Some info for the return
				$return['battle'][2]['final_defense'] = $defence;
				$return['battle'][2]['wasted_power'] = $spare;
			}
		}
	}

	//If we are doing this for real, effecting the database, not just doing a sim.
	if($db){
		//Add all the remaining defences into a query to update the planet.
		$qry = "UPDATE {{table}} SET ";
		foreach($reslist['defense'] as $element){
			if($resource[$element]){
				$qry .= "`".$resource[$element]."` = '".$CurrentPlanet[$resource[$element]]."', ";
			}
		}
		$qry = substr_replace($qry,'',-2,-1)."WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;";
		
		//Update the planet
		doquery($qry,'planets');
		
		//Write the combat report
		//Template
		$lost = array();
		$report  = '';
		$report .= $lang['ipm_header'];
		$report .= '<br /><br />';
		
		$report .= $lang['ipm_attacker'];
		$report .= '<br />';
		$report .= $lang['names'][503].' {ipms}';
		$report .= '<br /><br />';
		
		$report .= $lang['ipm_defender'];
		$report .= '<br />';
		foreach($reslist['defense'] as $element){
			$report .= $lang['names'][$element].' '.pretty_number($OriginalCurrentPlanet[$resource[$element]]).' => '.pretty_number($CurrentPlanet[$resource[$element]]).'('.$lang['ipm_lost'].' '.pretty_number($OriginalCurrentPlanet[$resource[$element]] - $CurrentPlanet[$resource[$element]]).' '.$lang['ipm_units'].')';
			$lost[$element] = $OriginalCurrentPlanet[$resource[$element]] - $CurrentPlanet[$resource[$element]];
			$report .= '<br />';
		}
		$report .= '<br />';
		
		$report .= $lang['ipm_result_a'];
		$report .= '<br />';
		$report .= $lang['ipm_result_d'];
		$report .= '<br />';
		
		//How many missiles were there?
		$missiles = explode(",",$FleetRow['fleet_array']);
		$missiles_count = idstring($missiles[1]);
		
		//Get details
		$parse = array(
			'date' => date('jS F Y H:i'),
			'attacker' => $attackername,
			'defender' => $defendername,
			'meta' => pretty_number($pricelist[503]['metal'] * $missiles_count),
			'crysa' => pretty_number($pricelist[503]['crystal'] * $missiles_count),
			'deuta' => pretty_number($pricelist[503]['deuterium'] * $missiles_count),
			'metd' => 0,
			'crysd' => 0,
			'deutd' => 0,
			'ipms' => pretty_number($missiles_count)
		);
		
		//Now how much did the defender loose?
		foreach($lost as $element => $count){
			$parse['metd'] += $pricelist[$element]['metal'] * $count;
			$parse['crysd'] += $pricelist[$element]['crystal'] * $count;
			$parse['deutd'] += $pricelist[$element]['deuterium'] * $count;
		}
		
		//Pretty up those numbers
		$parse['metd'] = pretty_number($parse['metd']);
		$parse['crysd'] = pretty_number($parse['crysd']);
		$parse['deutd'] = pretty_number($parse['deutd']);
		
		//Now parse the report
		$report = parsetemplate($report,$parse);
		
		//Now send out the report
		PM($FleetRow['owner_userid'],0,$report,$lang['ipm_pm_subject'],$lang['sys_mess_tower'],3);
		PM($FleetRow['target_userid'],0,$report,$lang['ipm_pm_subject'],$lang['sys_mess_tower'],3);
		//PM(send to user id,comes from user id, message, title, name of sender, message type);
		
		return $return;
	}else{
		//Return planet state for the sim.
		return $CurrentPlanet;
	}
}
/*
if($_GET['ipms'] > 0 && $_GET['ipm_demo']){
	function idstring($n){
		return intval($n);
	}
	define("INSIDE",true);
	require("../vars.php");
	$FleetRow = array(
		'fleet_array' => '503,'.idstring($_GET['ipms']),
		'fleet_targetdef' => 402,
		'weap' => 10,
		'arm' => 10,
	);
	$CurrentPlanet = array(
		$resource[401] => 50,
		$resource[402] => 50,
		$resource[403] => 50,
		$resource[404] => 50,
		$resource[405] => 50,
		$resource[406] => 50,
		$resource[407] => 1,
		$resource[408] => 1,
		$resource[502] => 5,
	);

	$NewPlanet = MissileAttack($FleetRow,$CurrentPlanet,false);

	echo "<pre>";
	print_r($CurrentPlanet);
	echo "\n";
	print_r($NewPlanet);
	echo "</pre>";
}
*/
?>
