<?php

/**
 * CreateOnePlanetRecord.php
 *
 * @version 2
 * @copyright 2008 by Anthony (MadnessRed) for Darkness
 * GPL Liscence - See LICENCE.TXT
 */

function PlanetSizeRandomiser ($Position, $HomeWorld = false, $debug = false) {
	global $game_config;
	//Source of datavalues and 60% rule. lines  http://ogame.wikia.com/wiki/Colony
	$ClassicBase     	  = 163;
	if (!$HomeWorld) {
		if(chance(60)){
			//There is a 60% chance that the table to the left is applied. The other 40% is totally random. So it's possible that you get a slot 1 or 15 colony with 300 fields, but you can also get a slot 6 colony with only 40 fields. 

			$Average		  = array ( 64, 68, 73,173,167,155,144,150,159,101, 98,105,110, 84,101);
			$SixtyMin		  = array ( 39, 53, 34, 83, 84, 82,116,123,129, 62, 81, 85, 60, 42, 54);
			$SixtyMax		  = array ( 89, 83, 82,306,232,328,173,177,203,122,116,129,191,172,150);
	
			$FrmAvgMin		  = $SixtyMin[$Position - 1] - $Average[$Position - 1];
			$FrmAvgMax		  = $SixtyMax[$Position - 1] - $Average[$Position - 1];

			
			
			//$FrmAvgMin*x + $FrmAvgMin*x should average at 0
			$DifInDeveation	  = $FrmAvgMin + $FrmAvgMax;
			$BaseIncDeveatn	  = $Average[$Position - 1] - ($DifInDeveation / 2);
		
			$PlanetFieldsLow  = mt_rand($SixtyMin[$Position - 1], $BaseIncDeveatn);
			$PlanetFieldsUpp  = mt_rand($BaseIncDeveatn, $SixtyMax[$Position - 1]);
			
			$PlanetFields	  = ($PlanetFieldsLow + $PlanetFieldsUpp) / 2;
			
			if($debug){
				echo "<u>Planet in the 60% Bracket</u><br />";
				echo "60% Greater than: ".$SixtyMin[$Position - 1]."<br />";
				echo "60% Less than: ".$SixtyMax[$Position - 1]."<br />";
				echo "Average: ".$Average[$Position - 1]."<br /><br />";
				echo "Fields OGame would give: ".floor($PlanetFields)."<br /><br /><hr /><br />";
			}
		}else{
			$MinSize		  =  30;
			$MaxSize		  = 330;
			$PlanetFields	  = mt_rand($MinSize, $MaxSize);
			if($debug){
				echo "<u>Planet outside the 60% Bracket</u><br />";
				echo "Fields OGame would give: ".$PlanetFields."<br /><br /><hr /><br />";
			}
		}
	} else {
		$PlanetFields     = $ClassicBase;
	}
	$SettingSize    	  = $game_config['initial_fields'];
	$PlanetFields		  = ($PlanetFields / $ClassicBase) * $game_config['initial_fields'];
	$PlanetFields		  = floor($PlanetFields);
	
	if($debug){
		echo "OGame homeworld size: ".$ClassicBase."<br />";
		echo "DarkEvo homeworld size: ".$game_config['initial_fields']."<br /><br />";
		echo "Fields DarkEvo would give: ".$PlanetFields."<br /><br /><hr />";
	}
	
	$PlanetSize           = ($PlanetFields ^ (14 / 1.5)) * 75;

	$return['diameter']   = $PlanetSize;
	$return['field_max']  = $PlanetFields;
	return $return;
}

function CreateOnePlanetRecord($gal, $System, $pos, $id_owner, $planet_name = '', $homeplanet = false) {

	global $lang;

	// We must check if planet exists.
	$PlanetExist = mysql_fetch_array(doquery("SELECT	`id` FROM {{table}} WHERE `galaxy` = '". $gal ."' AND `system` = '". $System ."' AND `planet` = '". $pos ."';",'planets'));

	// Well, does planet exist.
	if (!$PlanetExist) {
		$planet						 = PlanetSizeRandomiser ($pos, $homeplanet);
		$planet['metal']			 = BUILD_METAL;
		$planet['crystal']			 = BUILD_CRISTAL;
		$planet['deuterium']		 = BUILD_DEUTERIUM;
		$planet['metal_perhour']	 = $game_config['metal_basic_income'];
		$planet['crystal_perhour']	 = $game_config['crystal_basic_income'];
		$planet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
		$planet['metal_max']		 = BASE_STORAGE_SIZE;
		$planet['crystal_max']		 = BASE_STORAGE_SIZE;
		$planet['deuterium_max']	 = BASE_STORAGE_SIZE;

		$planet['galaxy']			 = $gal;
		$planet['system']			 = $System;
		$planet['planet']			 = $pos;
		
		$planet['id_owner']			 = $id_owner;

		if ($pos == 1 || $pos == 2 || $pos == 3) {
			$planet['img']			 = 'trocken';
			$planet['no.']			 = rand_in_array(array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10'));
			$planet['temp_min']		 = mt_rand(0, 100);
			$planet['temp_max']		 = $planet['temp_min'] + 40;
		} elseif ($pos == 4 || $pos == 5 || $pos == 6) {
			$planet['img']			 = 'dschjungel';
			$planet['no.']			 = rand_in_array(array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10'));
			$planet['temp_min']		 = mt_rand(-25, 75);
			$planet['temp_max']		 = $planet['temp_min'] + 40;
		} elseif ($pos == 7 || $pos == 8 || $pos == 9) {
			$planet['img']			 = 'normaltemp';
			$planet['no.']			 = rand_in_array(array('01', '02', '03', '04', '05', '06', '07'));
			$planet['temp_min']		 = mt_rand(-50, 50);
			$planet['temp_max']		 = $planet['temp_min'] + 40;
		} elseif ($pos == 10 || $pos == 11 || $pos == 12) {
			$planet['img']			 = 'wasser';
			$planet['no.']			 = rand_in_array(array('01', '02', '03', '04', '05', '06', '07', '08', '09'));
			$planet['temp_min']		 = mt_rand(-75, 25);
			$planet['temp_max']		 = $planet['temp_min'] + 40;
		} elseif ($pos == 13 || $pos == 14 || $pos == 15) {
			$planet['img']			 = 'eis';
			$planet['no.']			 = rand_in_array(array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10'));
			$planet['temp_min']		 = mt_rand(-100, 10);
			$planet['temp_max']		 = $planet['temp_min'] + 40;
		} else {
			$planet['img']			 = rand_in_array(array('dschjungel', 'gas', 'normaltemp', 'trocken', 'wasser', 'wuesten', 'eis'));
			$planet['no.']			 = rand_in_array(array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '00',));
			$planet['temp_min']		 = mt_rand(-120, 10);
			$planet['temp_max']		 = $planet['temp_min'] + 40;
		}
		$planet['image']		 = $planet['img']."planet".$planet['no.'];
		
		if(strlen($planet_name) > 0){ $planet['name'] = $planet_name; }
		else{ $planet['name'] = $lang['sys_colo_defaultname']; }

		doquery("INSERT INTO {{table}} (`name`,`id_owner`,`galaxy`,`system`,`planet`,`last_update`,`planet_type`,`image`,`diameter`,`field_max`,`temp_min`,`temp_max`,`metal`,`metal_perhour`,`metal_max`,`crystal`,`crystal_perhour`,`crystal_max`,`deuterium`,`deuterium_perhour`,`deuterium_max`)
		VALUES ('".$planet['name']."','".$planet['id_owner']."','".$planet['galaxy']."','".$planet['system']."','".$planet['planet']."','". time() ."','1','". $planet['image'] ."','".$planet['diameter']."','". $planet['field_max'] ."','".$planet['temp_min']."','".$planet['temp_max']."','". $planet['metal'] ."','". $planet['metal_perhour'] ."','". $planet['metal_max'] ."','". $planet['crystal'] ."','". $planet['crystal_perhour'] ."','". $planet['crystal_max'] ."','". $planet['deuterium'] ."','". $planet['deuterium_perhour'] ."','". $planet['deuterium_max'] ."') ;",'planets');
		
		return true;
	} else {
		return false;
	}
}
?>
