<?php

/**
 * GetFleetInfo.php
 *
 * @version 2.0
 * @copyright 2008 By MadnessRed for XNova Redesigned
 */

//Fleets
/*
$lang['type_mission'][1]  = "Attack";
$lang['type_mission'][2]  = "ACS Attack";
$lang['type_mission'][3]  = "Transport";
$lang['type_mission'][4]  = "Deploy";
$lang['type_mission'][5]  = "ACS Defend";
$lang['type_mission'][6]  = "Espionage";
$lang['type_mission'][7]  = "Colonize";
$lang['type_mission'][8]  = "Harvest";
$lang['type_mission'][9]  = "Destroy";
$lang['type_mission'][10] = "Missile Attack";
$lang['type_mission'][15] = "Expedition";
*/

function GetFleetInfo($CurrentUser,$CurrentPlanet){
	global $lang,$cid;

	includeLang('tech');
	getLang('fleet');
	$parse = $lang;

	$template = '
			<table id="eventtype" style="border-collapse: collapse;" border="0" width="100%">
				<tbody>
					<tr>
						<td class="friendly col1" width="152">Own Missions: <span id="eventFriendly">{miss_own}</span></td>
						<td class="neutral col2" width="156">Friendly missions: <span id="eventNeutral">{miss_neu}</span></td>
						<td class="hostile col3" width="152">Hostile missions: <span id="eventHostile">{miss_att}</span></td>
					</tr>
				</tbody>
			</table>
			<table id="eventdetails" style="border-collapse: collapse;" border="0" width="100%">
				<tbody>
					<tr id="eventClass" class="{miss_class}">
						<td class="col1" width="152"><div class="countdown" id="countdown_start-2789-0" name="countdown">{remaining}</div></td>
						<td class="col2" width="208"><div class="text" id="eventContent"> Mission: {mission}</div></td>
						<td class="col3" width="100">
							<a class="tips thickbox" href="./?page=movement" onclick="loadpage(this.href,\'{FleetManage}\',\'movement\',\'UpdateFleetMInfo()\'); return false;">
								<span class="mrtooltip" style="width:638px;top:18px;left:-71px;border:0px;background-color:#262727;">
									{miss_all}
								</span>
							</a>
						</td>
					</tr>
				</tbody>
			</table>';

	$mhostile = array(1,2,6,9); //10? Missile attack
	$mneutral = array(3,5);

	$arriving_fleet = doquery("SELECT * FROM {{table}} WHERE ((`owner_userid` = '".$CurrentUser['id']."' AND `fleet_mess` = 0) OR `target_userid` = '".$CurrentUser['id']."') ORDER BY `arrival` ASC LIMIT 1 ;",'fleets',true);


	if($arriving_fleet['arrival'] > 0){
		$parse['mission'] = $lang['type_mission'][$arriving_fleet['mission']];
		if($arriving_fleet['owner_userid'] == $CurrentUser['id']){
			$parse['miss_class'] = 'friendly';
		}elseif(in_array($arriving_fleet['mission'],$mhostile)){
			$parse['miss_class'] = 'hostile';
		}elseif(in_array($arriving_fleet['mission'],$mneutral)){
			$parse['miss_class'] = 'neutral';
		}else{
			$parse['miss_class'] = 'none';
		}
		$parse['remaining'] = parsecountdown($arriving_fleet['arrival'],true);
	}

	//All fleets now,
	$all_fleet = doquery("SELECT * FROM {{table}} WHERE ((`owner_userid` = '".$CurrentUser['id']."' AND `fleet_mess` = 0) OR `target_userid` = '".$CurrentUser['id']."') ORDER BY `arrival` ASC ;",'fleets');

	$array_all = array();
	while($row = mysql_fetch_array($all_fleet)){
		$temp_array = array();
		//$temp_array['timea'] = parsecountdown(($row['fleet_start_time'] - time()),'!');
		//$temp_array['timee'] = parsecountdown(($row['fleet_end_time'] - time()),'!');
		$temp_array['mission'] = $lang['type_mission'][$row['mission']];

		if($row['owner_userid'] == $CurrentUser['id'] || $row['mission'] == 0){
			$temp_array['class'] = 'friendly';
		}elseif(in_array($row['mission'],$mhostile)){
			$temp_array['class'] = 'hostile';
		}elseif(in_array($row['mission'],$mneutral)){
			$temp_array['class'] = 'neutral';
		}else{
			$temp_array['class'] = 'none';
		}

		$targetplanet = doquery("SELECT `name`,`galaxy`,`system`,`planet` FROM {{table}} WHERE `id` = '".$row['target_id']."' LIMIT 1;",'planets',true);
		if(strlen($targetplanet['name']) > 0){
			$temp_array['to'] = $targetplanet['name']." (".$targetplanet['galaxy'].":".$targetplanet['system'].":".$targetplanet['planet'].")";
		}else{
			$g = strlen(MAX_GALAXY_IN_WORLD);
			$s = strlen(MAX_SYSTEM_IN_GALAXY);
			$p = strlen(MAX_PLANET_IN_SYSTEM);
			$galaxy = substr($row['target_id'], 0,$g)*1;
			$system = substr($row['target_id'],$g,$s)*1;
			$planet = substr($row['target_id'],$g+$s,$p)*1;
			if($planet == MAX_PLANET_IN_SYSTEM + 1){
				$temp_array['to'] = $lang['OuterSpace'];
			}else{
				$temp_array['to'] = "(".$galaxy.":".$system.":".$planet.")";
			}
			unset($g,$s,$p,$galaxy,$system,$planet);
		}
		
		$startplanet = doquery("SELECT `name`,`galaxy`,`system`,`planet` FROM {{table}} WHERE `id` = '".$row['owner_id']."' LIMIT 1;",'planets',true);
		if(strlen($startplanet['name']) > 0){
			$temp_array['from'] = $startplanet['name']." (".$startplanet['galaxy'].":".$startplanet['system'].":".$startplanet['planet'].")";
		}else{
			$g = strlen(MAX_GALAXY_IN_WORLD);
			$s = strlen(MAX_SYSTEM_IN_GALAXY);
			$p = strlen(MAX_PLANET_IN_SYSTEM);
			$galaxy = substr($row['owner_id'], 0,$g)*1;
			$system = substr($row['owner_id'],$g,$s)*1;
			$planet = substr($row['owner_id'],$g+$s,$p)*1;
			if($planet == MAX_PLANET_IN_SYSTEM + 1){
				$temp_array['from'] = $lang['OuterSpace'];
			}else{
				$temp_array['from'] = "(".$galaxy.":".$system.":".$planet.")";
			}
			unset($g,$s,$p,$galaxy,$system,$planet);			
		}

		$array_all[] = array(
			'to' => $temp_array['from'],
			'from' => $temp_array['to'],
			'in' => parsecountdown($row['arrival']),
			'mission' => $temp_array['mission'],
			'time' => $row['arrival'],
			'class' => $temp_array['class']);
	}
	$parse['miss_all'] = '<table width="100%" id="eventdetails" style="width:95%">';
	$parse['miss_all'] .= "<tr onmouseover=\"mrtooltip('
	');\"
	 onmouseour=\"UnTip();\">";
	$parse['miss_all'] .= '<td>'.$parse['fl_time'].'</td><td>'.$parse['fl_from'].'</td><td>'.$parse['fl_dest'].'</td><td>'.$parse['fl_mission'].'</td></tr>';

	foreach($array_all as $id => $fl){
		$parse['miss_all'] .= "<tr id=\"eventClass\" class=\"".$fl['class']."\"><td>".$fl['in']."</td><td>".$fl['to']."</td><td>".$fl['from']."</td><td>".$fl['mission']."</td></tr>";
	}
	$parse['miss_all'] .= "</table>";


	$allow = ''; foreach($mhostile as $id){ $allow .= "`mission` = '".$id."' OR "; } $allow = substr_replace($allow, '', -4);
	$att_fleets = doquery("SELECT * FROM {{table}} WHERE `target_userid` = '".$CurrentUser['id']."' AND `arrival` > '".time()."' AND (".$allow.");",'fleets');

	$allow = ''; foreach($mneutral as $id){ $allow .= "`mission` = '".$id."' OR "; } $allow = substr_replace($allow, '', -4);
	$neu_fleets = doquery("SELECT * FROM {{table}} WHERE `target_userid` = '".$CurrentUser['id']."' AND `arrival` > '".time()."' AND (".$allow.");",'fleets');

	$own_fleets = doquery("SELECT * FROM {{table}} WHERE ((`owner_userid` = '".$CurrentUser['id']."' AND `fleet_mess` = 0) OR `target_userid` = '".$CurrentUser['id']."') AND `partner_fleet` NOT IN (SELECT `fleet_id` FROM {{table}}) ;",'fleets'); //<-- wow that actually works!!
	// ^ select the rows in the table, were ((its leaving your planet to go to another and not returning, (basically it on the way there)) or (its going to your planet from somewhere)) and (it doesn't have a partner fleet (this means that if for example there is a transport fleet, both the outward bound and return fleet are counted as just one))

	$parse['miss_own'] = mysql_num_rows($own_fleets);
	$parse['miss_neu'] = mysql_num_rows($neu_fleets);
	$parse['miss_att'] = mysql_num_rows($att_fleets);

	if($arriving_fleet){
		return array(parsetemplate($template,$parse),$parse['miss_att']);
	}else{
		return false;
	}

}

?>
