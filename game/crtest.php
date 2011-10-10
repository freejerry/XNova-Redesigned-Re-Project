<?php

$InLogin = true;
define('INSIDE'  , true);
define('INSTALL' , false);
define('ROOT_PATH' , './');
	
if($_GET['engine'] == 'php'){
	
	include(ROOT_PATH . 'common.php');
	include(ROOT_PATH . 'includes/battle_engines/padacombat.php');
	// -----------------------------------------------
	// +++++++++++++++++++++++++++++++++++++++++++++++
	// PadaCombat v0.4 - By Pada (byhoratiss@hotmail.com)
	// Released for http://project.xnova.es/
	// Under Development on http://www.frutagame.com.ar/
	// +++++++++++++++++++++++++++++++++++++++++++++++
	// -----------------------------------------------
	
	
	//File from josue.vieyra@gmail.com
	
	header("Content-Type: text/plain"); 
	
	$attacker_fleet =
	array(
		61 =>
			array(214 => 100000,213 => 500000),
		62 =>
			array(214 => 100000)
		);
	
	$defender_fleet =
	array(
		51 =>
			array(	402 => 5000000000,
					403 => 5000000000,
					407 => 1,
					408 => 1),
		52 =>
			array(	204 => 150000000)
		);
	
	$CurrentTechno =
	array(61 =>
		array(
			'military_tech' => 10,
			'shield_tech' => 12,
			'defence_tech' => 13
			),
		62 =>
		array(
			'military_tech' => 13,
			'shield_tech' => 12,
			'defence_tech' => 11
			)
		);
	
	$TargetTechno =
	array(51 =>
		array('military_tech' => 11,
			'shield_tech' => 12,
			'defence_tech' => 13
			),
		52 =>
		array('military_tech' => 11,
			'shield_tech' => 12,
			'defence_tech' => 13
			)
		);
	
	
	$x = PadaCombat($attacker_fleet, $defender_fleet, $CurrentTechno, $TargetTechno);
	
	echo "PadaCombat(\$attacker_fleet, \$defender_fleet, \$CurrentTechno, \$TargetTechno);\n\n";
	
	ksort($x); print_r($x);

}elseif($_GET['engine'] == 'python'){
	header("Content-Type: text/plain"); 

	$attackers = array(
		'1:10,10,10:214,10;213,5',
		'2:9,10,11:202,20;203,15',
	);
	
	$defenders = array(
		'0:10,10,10:407,1;408,1',
		'3:10,10,10:202,100;402,100',
	);
	
	
	$arg = str_replace(";","\;",sizeof($attackers)." ".sizeof($defenders)." ".implode(' ',$attackers)." ".implode(' ',$defenders));
	
	echo "python ".ROOT_PATH."includes/battle_engines/mr_combat.py ".$arg."\n\n";
	
	//Start timer
	$start = microtime('true');
	
	//let python do it
	$results = unserialize(shell_exec("python ".ROOT_PATH."includes/battle_engines/mr_combat.py ".$arg));
	
	//unserialise the attack and defend fleets in each round
	foreach($results['data'] as $key => $val){
		$results['data'][$key]['attack_fleets'] = unserialize($results['data'][$key]['attack_fleets']);
		$results['data'][$key]['defend_fleets'] = unserialize($results['data'][$key]['defend_fleets']);
	}
	
	//Output the results
	ksort($results); print_r($results);
	
	//And python did it in...
	$endpy = microtime('true');
	
	
	
	echo "\n\n\n\n\n-------------------------------------\n\n\nPython took ".($endpy - $start)." seconds.<br />";
}else{
	echo "You must specify an engine to use, eg crtest.php?engine=python";
}
?>