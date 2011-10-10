<?php

	/**
	 * formatCR.php by Anthony (MadnessRed) [http://madnessred.co.cc/]
	 *
	 * Copyright (c) MadnessRed 2008.
	 *
	 * made from Scratch by MadnessRed to work with the ACS Combat engine.
	 * 
	 * The files (below line 15) is under the GPL liscence, and the file license.txt must be included with this file.
	 *
	 * You may not edit this comment block. You may not copy any part of this file into any other file with out copying this comment block with it and placing it above any code there might be.
	*/
	
	
	function formatCR (&$result_array,&$steal_array,&$moon_int,&$moon_string,&$time_float) {
		global $phpEx, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps, $game_config;    

		$html = "";
		$bbc = "";
		
		//And lets start the CR. And admin message like asking them to give the cr. Nope, well moving on give the time and date ect.
		//$html .= "<font color=\"red\">HI THIS IS AN ADMIN MESSAGE. WE WOULD BE REALLY GREATFUL FOR YOU TO POST THE REPORT ID ON THE SHOUTBOX. THANKS</font><br /><br />";
		$html .= "The following fleets where facing each other on ".date("d-m-Y H:i:s")." , as it came to a battle::<br /><br />";
		
		
		//For-each round (Up to 10 rounds (depending on the ammount specified in calcualteAttack.php
		$round_no = 1;
		foreach( $result_array['rw'] as $round => $data1){
			//Round number is $round + 1 as $round starts at 0, not 1.
	
			$html .= "Round ".$round_no.":<br /><br />";
			
			//Now whats that attackers and defenders data
			$attackers1 = $data1['attackers'];
			$attackers2 = $data1['infoA'];
			$defenders1 = $data1['defenders'];
			$defenders2 = $data1['infoD'];
			$coord4 = 0;
			$coord5 = 0;
			$coord6 = 0;
			
			foreach( $attackers1 as $fleet_id1 => $data2){ //25
				//Player Info
				$name = $data2['user']['username'];
				$coord1 = $data2['fleet']['fleet_start_galaxy'];
				$coord2 = $data2['fleet']['fleet_start_system'];
				$coord3 = $data2['fleet']['fleet_start_planet'];
				$weap = ($data2['user']['military_tech'] * 10);
				$shie = ($data2['user']['shield_tech'] * 10);
				$armr = ($data2['user']['defence_tech'] * 10);
				
				if($coord4 == 0){$coord4 += $data2['fleet']['fleet_end_galaxy'];}
				if($coord5 == 0){$coord5 += $data2['fleet']['fleet_end_system'];}
				if($coord6 == 0){$coord6 += $data2['fleet']['fleet_end_planet'];}
				
				//And html output player info
				$fl_info1  = "<table><tr><th>";
				$fl_info1 .= "Attacker ".$name." ([".$coord1.":".$coord2.":".$coord3."])<br />";
				$fl_info1 .= "Weapons: ".$weap."% Shields: ".$shie."% Armour: ".$armr."%";
				
				//Start the table (Part 1)
				$table1  = "<table border=1 align=\"center\">";
				//Start the table rows.
				$ships1  = "<tr><th>Type</th>";
				$count1  = "<tr><th>Total</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data2['detail'] as $ship_id1 => $ship_count1){
					if ($ship_count1 > 0){
						$ships1 .= "<th>[ship[".$ship_id1."]]</th>";
						$count1 .= "<th>".$ship_count1."</th>";
					}
				}
				
				//End the table Rows
				$ships1 .= "</tr>";
				$count1 .= "</tr>";
				
				//now compile what we have, ok its the first half but the rest comes later.
				$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
			}
			
			foreach( $attackers2 as $fleet_id2 => $data3){
				//Start the table rows.
				$weap1  = "<tr><th>Weapons</th>";
				$shields1  = "<tr><th>Shields</th>";
				$armour1  = "<tr><th>Armour</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data3 as $ship_id2 => $ship_points1){
					if ($ship_points1['def'] > 0){
						$weap1 .= "<th>".$ship_points1['att']."</th>";
						$shields1 .= "<th>".$ship_points1['shield']."</th>";
						$armour1 .= "<th>".$ship_points1['def']."</th>";
					}
				}
				
				//End the table Rows
				$weap1 .= "</tr>";
				$shields1 .= "</tr>";
				$armour1 .= "</tr>";
				$endtable1 .= "</table></th></tr></table>";
				
				//now compile what we have, this is the second half.
				$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;
				
				//ok, good good, now we have both parts, lets make the html bit.
				$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
				$html .= "<br /><br />";
			}	
			
			
			foreach( $defenders1 as $fleet_id1 => $data2){
				//Player Info
				$name = $data2['user']['username'];
				$weap = ($data2['user']['military_tech'] * 10);
				$shie = ($data2['user']['shield_tech'] * 10);
				$armr = ($data2['user']['defence_tech'] * 10);
				
				//And html output player info
				$fl_info1  = "<table><tr><th>";
				$fl_info1 .= "Defender ".$name." ([".$coord4.":".$coord5.":".$coord6."])<br />";
				$fl_info1 .= "Weapons: ".$weap."% Shields: ".$shie."% Armour: ".$armr."%";
				
				//Start the table (Part 1)
				$table1  = "<table border=1 align=\"center\">";
				//Start the table rows.
				$ships1  = "<tr><th>Type</th>";
				$count1  = "<tr><th>Total</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data2['def'] as $ship_id1 => $ship_count1){
					if ($ship_count1 > 0){
						$ships1 .= "<th>[ship[".$ship_id1."]]</th>";
						$count1 .= "<th>".$ship_count1."</th>";
					}
				}
				
				//End the table Rows
				$ships1 .= "</tr>";
				$count1 .= "</tr>";
				
				//now compile what we have, ok its the first half but the rest comes later.
				$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
			}
			
			foreach( $defenders2 as $fleet_id2 => $data3){
				//Start the table rows.
				$weap1  = "<tr><th>Weapons</th>";
				$shields1  = "<tr><th>Shields</th>";
				$armour1  = "<tr><th>Armour</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data3 as $ship_id2 => $ship_points1){
					if ($ship_points1['def'] > 0){
						$weap1 .= "<th>".$ship_points1['att']."</th>";
						$shields1 .= "<th>".$ship_points1['shield']."</th>";
						$armour1 .= "<th>".$ship_points1['def']."</th>";
					}
				}
				
				//End the table Rows
				$weap1 .= "</tr>";
				$shields1 .= "</tr>";
				$armour1 .= "</tr>";
				$endtable1 .= "</table></th></tr></table>";
				
				//now compile what we have, this is the second half.
				$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;
				
				//ok, good good, now we have both parts, lets make the html bit.
				$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
				$html .= "<br /><br />";
			}		

			//HTML What happens?
			$html .= "The attacking fleet fires upon the defender with a total firepower of ".$data1['attack']['total'].". The defender's shields absorb ".$data1['defShield']." damage points.<br />";
			$html .= "The defending fleet fires upon the attacker with a total firepower of ".$data1['defense']['total'].". The defender's shields absorb ".$data1['attackShield']." damage points.<br /><br />";
			$round_no++;
		}
		
		//ok, end of rounds, battle results now.
		
		//Who won?
		if ($result_array['won'] == 2){
			//Defender wins
			$result1  = "The defender has won the battle!<br />";
		}elseif ($result_array['won'] == 1){
			//Attacker wins
			$result1  = "The attacker has won the battle!<br />";
			$result1 .= "He captured ".$steal_array['metal']." Metal, ".$steal_array['crystal']." Crystal, and ".$steal_array['deuterium']." Deuterium<br />";
		}else{
			//Battle was a draw
			$result1  = "The battle ended in a draw.<br />";
		}
		

		
		$html .= "<br /><br />";
		$html .= $result1;
		$html .= "<br />";
		
		$debirs_meta = ($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
		$debirs_crys = ($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);
		$html .= "The attacker lost a total of ".$result_array['lost']['att']." units.<br />";
		$html .= "The defender lost a total of ".$result_array['lost']['def']." units.<br />";
		$html .= "At these space coordinates now float ".$debirs_meta." Metal and ".$debirs_crys." Crystal.<br /><br />";
		
		$html .= "The chance for a moon to be created is ".$moon_int."%<br />";
		$html .= $moon_string."<br /><br />";

		$html .= "Report generated in ".$time_float." seconds<br />";
		
		//return array('html' => $html, 'bbc' => $bbc, 'extra' => $extra);
		return array('html' => $html, 'bbc' => $bbc);
	}
?>