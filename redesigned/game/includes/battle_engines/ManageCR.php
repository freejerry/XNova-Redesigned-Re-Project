<?php

/**
 * This file manages the output from the battle, it formats the cr, it makes the debris field, and then sends the fleets home.
 * Here is the expected imput
	$results = array(
		[debrcry] => num
		[debrmet] => num
		[attlost] => num
		[deflost] => num
		[won]	 => char //(d)raw, (a)ttacker ,(v)defender
		[data] => array(
			[$roundno] => array(
				[attfires] => num
				[attpower] => num
				[attblock] => num
				[deffires] => num
				[defpower] => num
				[defblock] => num
				[attack_fleets] => array(
					[$fleetid] => array(
	either:				[$shiptype] => array('count' => num)
	or:					[$shiptype] => num
					)
				)
				[defend_fleets] => array(
					[$fleetid] => array(
	either:				[$shiptype] => array('count' => num)
	or:					[$shiptype] => num
					)
				)
			)
		)
	)
 */

function ManageCR($results, $CurrentPlanet){
	global $resource,$lang,$CombatCaps,$pricelist,$reslist;
	
	//The usual...
	$parse = $lang;
	
	//This will be poulated with planet and user data later.
	$fleets = array();
	$permafleets = array();
	
	//Loop through the rounds:
	$parse['rounds'] = '';
	foreach($results['data'] as $roundno => $round){
		$rparse = array();
		
		//List attackers and defenders fleets.
		$rparse['attackers'] = '';
		foreach($round['attack_fleets'] as $id => $attacker){
			
			//Lets get some info about this guy
			if($roundno == 0){
				$fleets[$id] = array();
				$fleets[$id]['side'] = 'a';
				if($id > 0){
					$fleets[$id]['user'] = doquery("SELECT * FROM {{table}} WHERE `id` = (SELECT `owner_userid` FROM {{prefix}}fleets WHERE `fleet_id` = '".idstring($id)."') LIMIT 1 ;",'users',true);
				}else{
					$fleets[$id]['user'] = doquery("SELECT * FROM {{table}} WHERE `{{table}}`.`id` = '".idstring($CurrentPlanet['id_owner'])."' LIMIT 1 ;",'users',true);
				}
			}
			
			$aparse = $lang;
			$aparse['td_types'] = '';
			$aparse['td_count'] = '';
			$aparse['td_weapons'] = '';
			$aparse['td_shields'] = '';
			$aparse['td_armour'] = '';
			$aparse['weap_pc'] = $fleets[$id]['user'][$resource[109]] * 10;
			$aparse['shield_pc'] = $fleets[$id]['user'][$resource[111]] * 10;
			$aparse['hull_pc'] = $fleets[$id]['user'][$resource[110]] * 10;
			$aparse['mode'] = 'attacker';
			$aparse['name'] = $lang['Attacker']." ".$fleets[$id]['user']['username']." <a>[".$fleets[$id]['user']['galaxy'].":".$fleets[$id]['user']['system'].":".$fleets[$id]['user']['planet']."]</a>";
		
			foreach($attacker as $id => $count){
				if(is_array($count)){ $count = $count['count']; }
				$aparse['td_types'] .= "\t\t\t\t\t\t\t\t\t\t<th class=\"textGrow\">".$lang['cr_names'][$id]."</th>\n";
				$aparse['td_count'] .= "\t\t\t\t\t\t\t\t\t\t<td>".pretty_number($count)."</td>\n";
				$aparse['td_weapons'] .= "\t\t\t\t\t\t\t\t\t\t<td>".pretty_number($CombatCaps[$id]['attack'])."</td>\n";
				$aparse['td_shields'] .= "\t\t\t\t\t\t\t\t\t\t<td>".pretty_number($CombatCaps[$id]['shield'])."</td>\n";
				$aparse['td_armour'] .= "\t\t\t\t\t\t\t\t\t\t<td>".pretty_number($pricelist[$id]['metal'] + $pricelist[$id]['crystal'])."</td>\n";
			}
			$rparse['attackers'] .= parsetemplate(gettemplate('fleet/combatattacker'),$aparse);
		}
		
		$rparse['defenders'] = '';
		foreach($round['defend_fleets'] as $id => $defender){
			
			//Lets get some info about this guy
			if($roundno == 0){
				$fleets[$id] = array();
				$fleets[$id]['side'] = 'd';
				if($id > 0){
					$fleets[$id]['user'] = doquery("SELECT * FROM {{table}} WHERE `id` = (SELECT `owner_userid` FROM {{prefix}}fleets WHERE `fleet_id` = '".idstring($id)."') LIMIT 1 ;",'users',true);
				}else{
					$fleets[$id]['user'] = doquery("SELECT * FROM {{table}} WHERE `{{table}}`.`id` = '".idstring($CurrentPlanet['id_owner'])."' LIMIT 1 ;",'users',true);
				}
			}
			
			$aparse = $lang;
			$aparse['td_types'] = '';
			$aparse['td_count'] = '';
			$aparse['td_weapons'] = '';
			$aparse['td_shields'] = '';
			$aparse['td_armour'] = '';
			$aparse['weap_pc'] = $fleets[$id]['user'][$resource[109]] * 10;
			$aparse['shield_pc'] = $fleets[$id]['user'][$resource[111]] * 10;
			$aparse['hull_pc'] = $fleets[$id]['user'][$resource[110]] * 10;
			$aparse['mode'] = 'defender';
			$aparse['name'] = $lang['Defender']." ".$fleets[$id]['user']['username']." <a>[".$fleets[$id]['user']['galaxy'].":".$fleets[$id]['user']['system'].":".$fleets[$id]['user']['planet']."]</a>";
			
			foreach($defender as $id => $count){
				if(is_array($count)){ $count = $count['count']; }
				$aparse['td_types'] .= "\t\t\t\t\t\t\t\t\t\t<th class=\"textGrow\">".$lang['cr_names'][$id]."</th>\n";
				$aparse['td_count'] .= "\t\t\t\t\t\t\t\t\t\t<td>".pretty_number($count)."</td>\n";
				$aparse['td_weapons'] .= "\t\t\t\t\t\t\t\t\t\t<td>".pretty_number($CombatCaps[$id]['attack'])."</td>\n";
				$aparse['td_shields'] .= "\t\t\t\t\t\t\t\t\t\t<td>".pretty_number($CombatCaps[$id]['shield'])."</td>\n";
				$aparse['td_armour'] .= "\t\t\t\t\t\t\t\t\t\t<td>".pretty_number($pricelist[$id]['metal'] + $pricelist[$id]['crystal'])."</td>\n";
			}
			$rparse['defenders'] .= parsetemplate(gettemplate('fleet/combatattacker'),$aparse);
		}
		
		//We need to keep a note on who is in the battle, as well as showing any destroyed fleets.
		$peeps = array(array(),array());
		foreach($fleets as $id => $array){
			//We need a list of members for the title
			if($roundno == 0){
				if($array['side'] == 'a'){
					$peeps[0][] = $array['user']['username'];
				}else{
					$peeps[1][] = $array['user']['username'];
				}
				$permafleets = $fleets;
			}
			//Look for fleets which are no more and list them as destroyed.
			if(!(in_array($id,array_keys($round['defend_fleets'])) || in_array($id,array_keys($round['attack_fleets'])))){
				if($array['side'] == 'a'){
					$rparse['attackers'] .= '
		<td class="round_attacker textCenter"> 
			<table cellpadding="0" cellspacing="0"> 
				<tr>
					<td class="newBack"> 
						<center> 
							<span class="destroyed textBeefy">'.$lang['Attacker'].' '.$array['user']['username'].' '.$lang['destroyed'].'.</span> 
						</center> 
					</td> 
				</tr> 
			</table> 
		</td>';
				}else{
					$rparse['defenders'] .= '
		<td class="round_defender textCenter"> 
			<table cellpadding="0" cellspacing="0"> 
				<tr>
					<td class="newBack"> 
						<center> 
							<span class="destroyed textBeefy">'.$lang['Defender'].' '.$array['user']['username'].' '.$lang['destroyed'].'.</span> 
						</center> 
					</td> 
				</tr> 
			</table> 
		</td>';
				
				}
				//If its been destroyed, we only want to show the destroyed message once, so remove the destroyed fleets.
				unset($fleets[$id]);
			}
		}
		
		//The round info, if its rounf one then we introduce the battle, otherwise its shots fired.
		if($roundno == 0){
			$rparse['roundinfo'] = "\t\t<p class=\"start\">".sprintf($lang['report_start'],date("j.n.Y H:i:s"))."</p>\n\t\t<p class=\"start opponents\">".implode(', ',$peeps[0]).' '.$lang['report_vs'].' '.implode(', ',$peeps[1])."</p>\n";
		}else{
			$rparse['roundinfo'] = sprintf($lang['report_rinfo'],pretty_number($round['attfires']),pretty_number($round['attpower']),pretty_number($round['defblock']),pretty_number($round['deffires']),pretty_number($round['defpower']),pretty_number($round['attblock']));
		}
		
		
		$parse['rounds'] .= parsetemplate(gettemplate('fleet/combatround'),$rparse);
	}
	
		
	//Phew, lets deal with all the fleets:
	$end = $results['data'][sizeof($results['data'])-1];
	$owners = array();
	foreach($permafleets as $id => $array){
		if($id == 0){
			//This is the planet...			
			$set = array();
			foreach(array_merge($reslist['dbattle'],$reslist['fleet']) as $e){
				$count = $end['defend_fleets'][0][$e];
				if(is_array($count)){ $count = $count['count']; }
				if($count > 0){
					$set[] = '`'.$resource[$e].'` = \''.idstring($count).'\'';
				}else{
					$set[] = '`'.$resource[$e].'` = 0';
				}
			}
			
			doquery("UPDATE {{table}} SET ".implode(', ',$set)." WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;",'planets',true);
			
			//Note the user
			$owners[] = idstring($CurrentPlanet['id_owner']);
		}else{
			if($array['side'] == 'a'){ $mode = 'attack'; }
			else{ $mode = 'defend'; }
			$fleetarray = array();
			$fleetcount = 0;
			foreach($end[$mode.'_fleets'][$id] as $ship => $count){
				if(is_array($count)){ $count = $count['count']; }
				$fleetarray[] = idstring($ship).','.idstring($count);
				$fleetcount += idstring($count);
			}
			$fleetarray = implode(';',$fleetarray);
			$fleetrow = doquery("SELECT * FROM {{table}} WHERE `fleet_id` = '".idstring($id)."' ;",'fleets',true);
			$permafleets[$id]['row'] = $fleetrow;
			doquery("UPDATE {{table}} SET `array` = '".$fleetarray."', `shipcount` = '".$fleetcount."' WHERE `partner_fleet` = '".idstring($id)."' LIMIT 1 ;",'fleets',false);
			DeleteFleet($id);
			
			
			$owners[] = idstring($fleetrow['owner_userid']);
		}
		
	}
	
	
	//Who won?
	if($results['won'] == 'a'){
		//Need to deal with raiding.
		$stealmax = array($CurrentPlanet['metal'] * MAX_ATTACK_RAID, $CurrentPlanet['crystal'] * MAX_ATTACK_RAID, $CurrentPlanet['deuterium'] * MAX_ATTACK_RAID);
		
		//How much cargo space do we have?
		$cargo = array('total' => 0);
		foreach($end['attack_fleets'] as $id => $attacker){
			$cargo[$id] = 0;
			foreach($attacker as $ship => $count){
				if(is_array($count)){ $count = $count['count']; }
				$space = $pricelist[$ship]['capacity'] * $count;
				$space -= $permafleets[$id]['row']['metal'];
				$space -= $permafleets[$id]['row']['crystal'];
				$space -= $permafleets[$id]['row']['deuterium'];
				if($space > 0){
					$cargo[$id] += $space;
					$cargo['total'] += $pricelist[$ship]['capacity'] * $count;
				}
			}
		}
		
		//So how much can we take?
		$totaltake = $stealmax[0] + $stealmax[1] + $stealmax[2];
		
		//Is there enough res to go around?
		if($totaltake > $cargo['total']){
			//We can fill all the cargo holds in the ratios:
			$ratio_m = $stealmax[0] / $totaltake;
			$ratio_c = $stealmax[1] / $totaltake;
			$ratio_d = $stealmax[2] / $totaltake;
		}else{
			//We can take the following ratios of resources: (nb its a bit late, so I haven't worked out why the below works but basically the $totaltake cancels so I just removed it)
			$ratio_m = $stealmax[0] / $cargo;
			$ratio_c = $stealmax[1] / $cargo;
			$ratio_d = $stealmax[2] / $cargo;			
		}
		
		//Right lets start filling up the fleets:
		$stolen = array(0,0,0);
		foreach($cargo as $id => $space){
			if($id != 'total'){
				$take_m = floor($ratio_m * $space);
				$take_c = floor($ratio_c * $space);
				$take_d = floor($ratio_d * $space);
				
				$stolen[0] += $take_m;
				$stolen[1] += $take_c;
				$stolen[2] += $take_d;
				
				doquery("UPDATE {{table}} SET `metal` = `metal` + '".$take_m."', `crystal` = `crystal` + '".$take_c."', `deuterium` = `deuterium` + '".$take_d."' WHERE `partner_fleet` = '".idstring($id)."' LIMIT 1 ;",'fleets',false);
			}
		}
		
		$parse['result'] = sprintf($lang['A_won'],pretty_number($stolen[0]),$lang['Metal'],pretty_number($stolen[1]),$lang['Crystal'],pretty_number($stolen[2]),$lang['Deuterium']);
	}elseif($results['won'] == 'v'){
		$parse['result'] = $lang['D_won'];
	}else{
		$results['won'] = 'd';
		$parse['result'] = $lang['Draw'];
	}	
	
	//Results, attlost, defost debris ect.
	$parse['alost'] = sprintf($lang['AttLost'],pretty_number($results['attlost']));
	$parse['dlost'] = sprintf($lang['DefLost'],pretty_number($results['deflost']));
	$parse['debris'] = sprintf($lang['DebrisF'],pretty_number($results['debrmet']),$lang['Metal'],pretty_number($results['debrcry']),$lang['Crystal']);

	//Now the exiting bit!!! Moons stuff
	$debris_pc = floor(($results['debrmet'] + $results['debrcry']) / DEBRIS_PER_PERCENT);
	if($debris_pc > MIN_MOON_PERCENT){
		if($debris_pc > MAX_MOON_PERCENT){
			$debris_pc = MAX_MOON_PERCENT;
		}
		$parse['moon'] = sprintf($lang['MoonChance'],$debris_pc.'%');
		
		//So does he get a moon?
		$need = rand(0,100);
		if($debris_pc > $nees){
			//Got a moon
			$pl_name = $CurrentPlanet['name'] . ' [' . $CurrentPlanet['galaxy'] . ':' . $CurrentPlanet['system'] . ':' . $CurrentPlanet['planet'] . ']';
			$parse['moon_got'] = sprintf($lang['GotMoon'],$pl_name);
			AddMoon($CurrentPlanet['galaxy'],$CurrentPlanet['system'],$CurrentPlanet['planet']);
		}
	}
	
	//Now we need to generate the report:
	$report = parsetemplate(gettemplate('fleet/combatreport'),$parse);
	
	//Add the report to the database
	doquery("INSERT INTO {{table}} (`report`, `owners`, `wonby`, `damage`, `time`) VALUES ('".mysql_real_escape_string($report)."', '".implode(",",$owners)."', '".$results['won']."', '".($results['attlost'] + $results['deflost'])."', '".time()."');",'cr',false);
	
	//Now we need to message the user...
	$message   = "<a href=\"./?page=report&raport=".$rid."\" target=\"_new\"><center>";
	$message2  = "<a href=\"./?page=report&raport=".$rid."\" target=\"_new\"><center>";
	if($results['won'] == 'a'){
		$message  .= "<font color=\"green\">";
		$message2 .= "<font color=\"red\">";
	}elseif($results['won'] == 'v'){
		$message  .= "<font color=\"red\">";
		$message2 .= "<font color=\"green\">";
	}else{
		$message  .= "<font color=\"orange\">";
		$message2 .= "<font color=\"orange\">";
	}
	$message  .= $lang['fleet_1_tit']." [".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."] </font></a>";
	$message2 .= $lang['fleet_1_tit']." [".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."] </font></a>";
	
	PM($FleetRow['owner_userid'],0,$message,$lang['fleet_1_tit'],$lang['fleet_control'],2);
	PM($FleetRow['target_userid'],0,$message2,$lang['fleet_1_tit'],$lang['fleet_control'],2);
}
