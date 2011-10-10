<?php

header("Content-Type: text/plain"); 

define('INSIDE'  , true);
define('ROOT_PATH'  , '../');
include(ROOT_PATH.'includes/vars.php');

//Start the file
$file = '';

//Top comments
$file .= "#Python version of vars.php, be careful when editing as python is very particular about tabs and line breaks.\n";
$file .= "#To update this file simple go tothe admin center and go the the vars.py generation page.\n";

//Now start he pricelist
$file .= "pricelist = {\n";

//Foreach ship
foreach($reslist['fleet'] as $id){
	$file .= "\t".$id." : { 'metal' : ".$pricelist[$id]['metal'].", 'crystal' : ".$pricelist[$id]['crystal'].", 'deuterium' : ".$pricelist[$id]['deuterium']." },\n";
}
$file .= "\n";

//Foreach defence
$last = sizeof($reslist['dbattle']); $n = 1; $comma = ',';
foreach($reslist['dbattle'] as $id){
	if($n == $last){ $comma = ''; }
	$file .= "\t".$id." : { 'metal' : ".$pricelist[$id]['metal'].", 'crystal' : ".$pricelist[$id]['crystal'].", 'deuterium' : ".$pricelist[$id]['deuterium']." }".$comma."\n";
	$n++;
}
$file .= "}\n\n";


//Now combat caps
$file .= "CombatCaps = {";

//Foreach ship
foreach($reslist['fleet'] as $id){
	$sd = array();
	foreach($CombatCaps[$id]['sd'] as $t => $v){ $sd[] = "$t : $v"; }
	$sd = implode(", ",$sd);
	$file .= "
	".$id." : {
		'shield' : ".$CombatCaps[$id]['shield'].",
		'attack' : ".$CombatCaps[$id]['attack'].",
		'sd' : {
			".$sd."
		}
	},";
}
$file .= "\n";

//Foreach defence
$n = 1; $comma = ',';
foreach($reslist['dbattle'] as $id){
	if($n == $last){ $comma = ''; }
	$sd = array();
	foreach($CombatCaps[$id]['sd'] as $t => $v){ $sd[] = "$t : $v"; }
	$sd = implode(", ",$sd);
	$file .= "
	".$id." : {
		'shield' : ".$CombatCaps[$id]['shield'].",
		'attack' : ".$CombatCaps[$id]['attack'].",
		'sd' : {
			".$sd."
		}
	}".$comma;
	$n++;
}
$file .= "\n}\n";

//Try to write the file
$myFile = ROOT_PATH."includes/battle_engines/vars.py";
//Open file. If that can't be done output the file.
$fh = @fopen($myFile, 'w') or die($file);
//Write to the file
fwrite($fh, $file);
//Close the file.
fclose($fh);
	
echo "The file vars.py has been written autmatically. You do not need to do any more.";

