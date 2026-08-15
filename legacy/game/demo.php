<?php
define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function missilerange($impulse)	{
	if ($user[$resource[117]] > 0) {
		$MissileRange = ($user[$resource[117]] * 5) - 1;
	} elseif ($user[$resource[117]] == 0) {
		$MissileRange = 0;
	}
	return $MissileRange;
}
if($_GET['type'] == "planetsize"){
	if(is_numeric($_GET['pos'])){
		$size = PlanetSizeRandomiser($_GET['pos'],false,true);
		echo "<br /><font color=red>".$size['field_max']."</font><br /><br /><br />";
		echo "<form action='' method='GET'>
		<input type='hidden' value='planetsize' name='type' />
		<input type='s' value='".UNI."' name='type' />
		Position: <input type='text' name='pos' value='".$_GET['pos']."' maxlenth='2' size='3' />
		<input type='submit' value='Go' />";
	}else{
		echo "<form action='' method='GET'>
		<input type='hidden' value='planetsize' name='type' />
		<input type='s' value='".UNI."' name='type' />
		Position: <input type='text' name='pos' maxlenth='2' size='3' />
		<input type='submit' value='Go' />";
	}
}
elseif($_GET['type'] == "missilerange"){
	if(is_numeric($_GET['impulse'])){
		$userimpulse = $user[$resource[117]];
		$user[$resource[117]] = $_GET['impulse'];
		$result =  GetMissileRange ();
		$user[$resource[117]] = $userimpulse;
		echo "<br /><font color=red>With Impulse drive level ".$_GET['impulse']." you can fire across ".$result." systems</font><br /><br /><br />";
		echo "<form action='' method='GET'>
		<input type='hidden' value='missilerange' name='type' />
		<input type='s' value='".UNI."' name='type' />
		Impulse Drive: <input type='text' name='impulse' value='".($_GET['impulse'] + 1)."' maxlenth='2' size='3' />
		<input type='submit' value='Go' />";
	}else{
		echo "<form action='' method='GET'>
		<input type='hidden' value='missilerange' name='type' />
		<input type='s' value='".UNI."' name='type' />
		Impulse Drive: <input type='text' name='impulse' maxlenth='2' size='3' />
		<input type='submit' value='Go' />";
	}
}
elseif($_GET['type'] == "phalanxrange"){
	if(is_numeric($_GET['level'])){
		$result =  GetPhalanxRange($_GET['level']);
		echo "<br /><font color=red>A Phalanx level ".$_GET['level']." has a range of ".$result." systems.</font><br /><br /><br />";
		echo "<form action='' method='GET'>
		<input type='hidden' value='phalanxrange' name='type' />
		<input type='s' value='".UNI."' name='type' />
		Sensor Phalanx Level: <input type='text' name='level' value='".($_GET['level'] + 1)."' maxlenth='2' size='3' />
		<input type='submit' value='Go' />";
	}else{
		echo "<form action='' method='GET'>
		<input type='hidden' value='phalanxrange' name='type' />
		<input type='s' value='".UNI."' name='type' />
		Sensor Phalanx Level: <input type='text' name='level' maxlenth='2' size='3' />
		<input type='submit' value='Go' />";
	}
}
?>