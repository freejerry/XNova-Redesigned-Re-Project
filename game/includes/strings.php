<?php

/**
 * strings.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

function colourNumber($n, $s = '') {
	if ($n > 0) {
		if($s != ''){ $s = colourGreen($s); }
		else{ $s = colourGreen($n); }
	} elseif ($n <= 0){
		if($s != ''){ $s = colourRed($s); }
		else{ $s = colourRed($n); }
	} else {
		if($s != ''){ $s = $s; }
		else{ $s = $n; }
	}
	return $s;
}

function colourRed($n) {
	return '<font color="#ff0000">' . $n . '</font>';
}

function colourGreen($n) {
	return '<font color="#00ff00">' . $n . '</font>';
}

//Keep the Americans happy
function colorRed($n){ return colourRed($n); }
function colorGreen($n){ return colourGreen($n); }
function colorNumber($n){ return colourNumber($n); }

function pretty_number($n, $floor = true) {
	if ($floor) { $n = floor($n); }
	return number_format($n, 0, ".", ",");
}

function PlanetArray($id,$g=0,$s=0,$p=0){ //MadnessRed function
	return doquery("SELECT * FROM {{table}} WHERE `id` = '".$id."' OR (`galaxy` = '".$g."' AND `system` = '".$s."' AND `planet` = '".$p."') LIMIT 1;",'planets',true);
}
function PlayerArray($id){ //MadnessRed function
	return doquery("SELECT * FROM {{table}} WHERE `id` = '".$id."' LIMIT 1;",'users',true);
}

function mod($n){//Madness Red function (will return |$n|
	if($n < 0){ $n = (0-$n); }
	return $n;
}
// Created by Perberos. All rights reversed (C) 2006
?>