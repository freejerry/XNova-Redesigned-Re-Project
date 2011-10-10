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
	
	function mr_report($results,$fleets,$debug) {
		global $CombatCaps;    

		$html = "";
		$bbc = "";
		
		$html .= "<table width=\"99%\">
		<tr>
		<td>
			<p>The following fleets were facing each other on ".date("d-m-Y H:i:s")." , as it came to a battle::<br />";
		
		//For-each round (Up to 6 rounds (depending on the ammount specified in the battle engine.
		$round_no = 1;
		foreach($results['rounds'] as $round => $info){
		//First Attacker info.
		$ships = $info['atts'];
			//Round number is $round + 1 as $round starts at 0, not 1.
			$att_table = array();
			$fleetcount = array();
			foreach($ships as $id => $ship){
				if($fleetcount[$ship['fleet']][$ship['type']] > 0){
					$fleetcount['amnt'][$ship['fleet']][$ship['type']]++;
				}else{
					$fleetcount['amnt'][$ship['fleet']][$ship['type']] = 1;
				}
			}
			if($debug){
				print_r ($fleetcount);
				echo "<br />";
			}
			foreach($fleetcount as $fleet => $ship){
				$att_table[$fleet] = "<table border=1>\n\n";
				$att_table_type = '<tr>';
				$att_table_count = '<tr>';
				$att_table_w = '<tr>';
				$att_table_s = '<tr>';
				$att_table_h = '<tr>';
				foreach($ship as $type => $count){
					$att_table_type	 .= "<th>{[".$type."]}</th>";
					$att_table_count .= "<th>".$count."</th>";
					$att_table_w	 .= "<th>".$CombatCaps[$type]['attack']."</th>";
					$att_table_s	 .= "<th>".$CombatCaps[$type]['shield']."</th>";
					$att_table_h	 .= "<th>".(($pricelist[$type]['metal'] + $pricelist[$type]['crystal'])  / 10)."</th>";
				}
				$att_table_type = '</tr>';
				$att_table_count = '</tr>';
				$att_table_w = '</tr>';
				$att_table_s = '</tr>';
				$att_table_h = '</tr>';
				
				$att_table[$fleet] .= $att_table_type."\n\n";
				$att_table[$fleet] .= $att_table_count."\n\n";
				$att_table[$fleet] .= $att_table_w."\n\n";
				$att_table[$fleet] .= $att_table_s."\n\n";
				$att_table[$fleet] .= $att_table_h."\n\n";
				$att_table[$fleet] .= "</table>\n\n";
				
				if($debug){
					echo "<table border=1>\n\n".$att_table_type.$att_table_count.$att_table_w.$att_table_s.$att_table_h."</table>\n\n";
					echo "<br />";
				}
			}
			
			$attackers = array();
			foreach($fleets['a'] as $id => $fl_details){
				//Start string
				$attackers[$id] = '';
				//Start by saying the atack name and origin.
				$attackers[$id] .= "Attacker ".$fl_details['owner']." (".$fl_details['origin'].")<br />";
				//First round?
				if($round <= 1){
					//If the first round also say techs.
					$attackers[$id] .= "Weapons: ".$fl_details['techs'][0]."0% Shields: ".$fl_details['techs'][1]."0% Hull Plating: ".$fl_details['techs'][2]."0%<br />";
				}
				$attackers[$id] .= $att_table[$id];
			}
			$html .= "\n\n".$attackers[$id];
		}
			

		/*
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
		*/
		return $html;
	}

?>