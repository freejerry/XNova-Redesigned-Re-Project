<?php

function battle_log($stringData){
	$myFile = "battle_log.txt";
	$fh = fopen($myFile, 'a') or die("can't open file");
	fwrite($fh, $stringData."\n");
	fclose($fh);
}

function MissionCaseAttack($fleetrow){
	global $resource,$reslist;
	
	battle_log("Battle on ".date("jS F Y \a\t H:i:s:"));
	
	//Get the attackers / defenders arrays
	$attackers = array();
	$defenders = array();
	
	//This fleet
	$techs = doquery("SELECT `".$resource[109]."`,`".$resource[110]."`,`".$resource[111]."` FROM {{table}} WHERE `id` = ".$fleetrow['owner_userid'],'users',true);
	$attackers[] = $fleetrow['fleet_id'].':'.$techs[$resource[109]].','.$techs[$resource[110]].','.$techs[$resource[111]].':'.$fleetrow['array'];

	//ACS?
	if($fleetrow['fleet_group'] > 0){
		//We have some acs fleets, maybe
		$acs = doquery("SELECT * FROM {{table}} WHERE `fleet_group` = '".$fleetrow['fleet_group']."' AND `mission` = 2 AND `fleet_mess` = 0",'fleets');
		while($acsrow = FetchArray($acs)){
			$techs = doquery("SELECT `".$resource[109]."`,`".$resource[110]."`,`".$resource[111]."` FROM {{table}} WHERE `id` = ".$acsrow['owner_userid'],'users',true);
			$attackers[] = $acsrow['fleet_id'].':'.$techs[$resource[109]].','.$techs[$resource[110]].','.$techs[$resource[111]].':'.$acsrow['array'];	
		}
	}
	
	
	//Defender
	$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$fleetrow['target_id']."' LIMIT 1 ;",'planets',true);
	$techs = doquery("SELECT `".$resource[109]."`,`".$resource[110]."`,`".$resource[111]."` FROM {{table}} WHERE `id` = '".$fleetrow['target_userid']."' LIMIT 1 ;",'users',true);
	$str = '0:'.$techs[$resource[109]].','.$techs[$resource[110]].','.$techs[$resource[111]].':';
	foreach($reslist['dbattle'] as $e){ if($CurrentPlanet[$resource[$e]] > 0){ $str .= $e.','.$CurrentPlanet[$resource[$e]].';'; } }
	foreach($reslist['fleet']   as $e){ if($CurrentPlanet[$resource[$e]] > 0){ $str .= $e.','.$CurrentPlanet[$resource[$e]].';'; } }
	$defenders[] = $str;

	//ACS?
		//We have some acs fleets, maybe
		$acs = doquery("SELECT * FROM {{table}} WHERE `target_id` = '".$fleetrow['target_id']."' AND `mission` = 5 AND `fleet_mess` = 0 AND `arrival` < '".$fleetrow['arrival']."' AND `arrival`+`hold_time` > '".$fleetrow['arrival']."'",'fleets');
		while($acsrow = FetchArray($acs)){
			$techs = doquery("SELECT `".$resource[109]."`,`".$resource[110]."`,`".$resource[111]."` FROM {{table}} WHERE `id` = ".$acsrow['owner_userid'],'users',true);
			$defenders[] = $acsrow['id'].':'.$techs[$resource[109]].','.$techs[$resource[110]].','.$techs[$resource[111]].':'.$acsrow['array'];	
		}
	
	//Generate the python arguments
	$arg = str_replace(";","\;",sizeof($attackers)." ".sizeof($defenders)." ".implode(' ',$attackers)." ".implode(' ',$defenders));

	//Start timer
	$start = microtime('true');
	
	//Log the commands
	battle_log("Battle command: "."python ".ROOT_PATH."includes/battle_engines/mr_combat.py ".$arg);
	
	//let python do it
	$serialized = shell_exec("python ".ROOT_PATH."includes/battle_engines/mr_combat.py ".$arg);
	$results = unserialize($serialized);
	
	//unserialise the attack and defend fleets in each round
	foreach($results['data'] as $key => $val){
		$results['data'][$key]['attack_fleets'] = unserialize($results['data'][$key]['attack_fleets']);
		$results['data'][$key]['defend_fleets'] = unserialize($results['data'][$key]['defend_fleets']);
	}
	
	//Log the results
	battle_log("Serialized Results:\n".$serialized);
	battle_log("Results:\n".print_r($results,true)."\n\n");
	
	//And python did it in...
	$results['time'] = microtime('true') - $start;
	
	//Return the raw results, another function can take it from here
	return $results;
}


?>
