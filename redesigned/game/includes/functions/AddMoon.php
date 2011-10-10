<?php

/**
 * AddMoon.php
 *
 * @version 1.0
 * @copyright 2009 By MadnessRed for XNova Redisigned
 * GPL Liscence - See LICENCE.TXT
 */

function write_to_temp($string){
	global $temp;
	$temp = $string;
} 

//Add mon to database
function AddMoon($galaxy,$system,$planet,$chance = 20,$name = '_DEFAULT_',$CurrentPlanet=false,$num=0){
	global $lang;
	
	if($name == '_DEFAULT_'){ $name = $lang['sys_moon']; }
	if(idstring($num) < 1 || idstring($num) < 5){ $num = mt_rand(1,5); }
	$num = '0'.idstring($num);
	
	//Firsly is there already a moon here?
	$moons = mysql_num_rows(doquery("SELECT `id` FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND `planet_type` = '3' LIMIT 1 ;",'planets',false));
	
	if($moons > 0){
		return "There is already a moon in orbit here.";
	}else{
		
		//First get the homeplanet
		if(!is_array($CurrentPlanet)){
			$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND `planet_type` = '1' LIMIT 1 ;",'planets',true);
		}
		
		//Get min and max temps
		$tempmin = $CurrentPlanet['temp_min'] - rand(10, 45);
		$tempmax = $CurrentPlanet['temp_max'] - rand(10, 45);
		
		//It is possible that min temp becomes greater than max temp, if so just flip them
		if($tempmin > $tempmax){
			$temp = $tempmin;
			$tempmin = $tempmax;
			$tempmax = $temp;
		}
		
		//Now the long query...
		$qry = "INSERT INTO {{table}} SET ";
		$qry .= "`name` = '".mysql_real_escape_string($name)."', ";
		$qry .= "`id_owner` = '".idstring($CurrentPlanet['id_owner'])."', ";
		$qry .= "`galaxy` = '".idstring($galaxy)."', ";
		$qry .= "`system` = '".idstring($system)."', ";
		$qry .= "`planet` = '".idstring($planet)."', ";
		$qry .= "`planet_type` = '3', ";
		$qry .= "`last_update` = '".time()."', ";
		$qry .= "`image` = 'mond".$num."', ";
		$qry .= "`diameter` = '".idstring(rand(2000+($chance*100),6000+($chance*200)))."', ";
		$qry .= "`field_max` = '1', ";
		$qry .= "`temp_min` = '".idstring($tempmin)."', ";
		$qry .= "`temp_max` = '".idstring($tempmax)."', ";
		$qry .= "`metal` = '0', ";
		$qry .= "`metal_perhour` = '0', ";
		$qry .= "`metal_max` = '".BASE_STORAGE_SIZE."', ";
		$qry .= "`crystal` = '0', ";
		$qry .= "`crystal_perhour` = '0', ";
		$qry .= "`crystal_max` = '".BASE_STORAGE_SIZE."', ";
		$qry .= "`deuterium` = '0', ";
		$qry .= "`deuterium_perhour` = '0', ";
		$qry .= "`deuterium_max` = '".BASE_STORAGE_SIZE."' ;";
		
		//Do the query and return the result.
		$temp = true;
		doquery($qry,'planets') or write_to_temp(mysql_error());
		
		//Tell the user to update his planetlist
		doquery("UPDATE {{table}} SET `menus_update` = '".time()."' WHERE `id` = '".idstring($CurrentPlanet['id_owner'])."' LIMIT 1;",'users');
		
		return $temp;
	}
}

?>
