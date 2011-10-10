<?php

/**
 * This file is GPL which should be included with this distrobution
 * Do not edit the comment box
 * This file was made by madnessRed(Anthony) for DarkEvo
 * This file includes the alliance relation functions
 */
 
function relations($code,$command){
	$relation[1]['type'] = "Allies";
	$relation[1]['colour'] = "#00FF00";
	
	$relation[2]['type'] = "Wing";
	$relation[2]['colour'] = "#00FF00";
	
	$relation[3]['type'] = "NAP";
	$relation[3]['colour'] = "orange";
	
	$relation[4]['type'] = "Enemy";
	$relation[4]['colour'] = "red";
	
	$relation[5]['type'] = "WAR";
	$relation[5]['colour'] = "red";
	
	return $relation[$code][$command];
}

//Version 1.0 26/10/08 MadnessRed

?>