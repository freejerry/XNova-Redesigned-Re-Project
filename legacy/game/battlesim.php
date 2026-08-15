<?php

header("Content-type: text/plain");

$arg = '1 1 1:1000000000,1000000000,1000000000:212,1 0:10,10,10:214,100';
$serialized = shell_exec("python ".ROOT_PATH."includes/battle_engines/mr_combat.py ".$arg);
$results = unserialize($serialized);
	
//unserialise the attack and defend fleets in each round
foreach($results['data'] as $key => $val){
	$results['data'][$key]['attack_fleets'] = unserialize($results['data'][$key]['attack_fleets']);
	$results['data'][$key]['defend_fleets'] = unserialize($results['data'][$key]['defend_fleets']);
}

print_r($results);

//$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '4' LIMIT 1 ;",'planets',true);
//makeAXAH(ManageCR($results,$CurrentPlanet));
?>
