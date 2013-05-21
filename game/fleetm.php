<?php
/*
 * fleetm.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova Redesigned
 *
*/

getLang('fleet');

$parse = $lang;

$parse['fleets'] = '';
$fleets = doquery("SELECT * FROM {{table}} WHERE ((`owner_userid` = '".$user['id']."' AND `fleet_mess` = 0) OR `target_userid` = '".$user['id']."') ORDER BY `arrival` ASC ;",'fleets',false);
while($FleetRow = mysql_fetch_array($fleets)){
	$FleetRow = array_merge($FleetRow,$lang);

	//Default image for the fleet
	$FleetRow['image'] = 'icon-fleet-movement.gif';

	//If the fleet is returning
	if($FleetRow['partner_fleet'] > 0){
		//And the outwards bound fleet hasn't arrived yet
		if(mysql_num_rows(doquery("SELECT `fleet_id` FROM {{table}} WHERE `fleet_id` = '".$FleetRow['partner_fleet']."' ;",'fleets')) > 0){
			//Skip this one
			continue;
		}
	}

	//Fleet arrival/departure times.
	$FleetRow['arrive_d'] = date($lang['daymonth'].'/Y',$FleetRow['arrival']);
	$FleetRow['depart_d'] = date($lang['daymonth'].'/Y',$FleetRow['departure']);
	$FleetRow['arrive'] = date('H:i:s',$FleetRow['arrival']);
	$FleetRow['depart'] = date('H:i:s',$FleetRow['departure']);

	//Fleet mession
	$FleetRow['mission_t'] = $lang['type_mission'][$FleetRow['mission']];

	//Details
	if($user[$resource[106]] >= 8 || $FleetRow['fleet_mess'] > 0 || $FleetRow['owner_userid'] == $user['id']){
		//Its either our fleet, or we have high enough esp to see everything.
		$FleetRow['details'] = sprintf($lang['fl_details_full'], pretty_number($FleetRow['shipcount']));
		foreach(explode(';',$FleetRow['array']) as $fl){
			$details = explode(',',$fl);
			$FleetRow['details'] .= $lang['names'][$details[0]]." (".pretty_number($details[1]).")<br />";
		}
	}elseif($user[$resource[106]] >= 4){
		$FleetRow['details'] = sprintf($lang['fl_details_4'], pretty_number($FleetRow['shipcount']));
		foreach(explode(';',$FleetRow['array']) as $fl){
			$details = explode(',',$fl);
			$FleetRow['details'] .= $lang['names'][$details[0]]."<br />";
		}
	}elseif($user[$resource[106]] >= 2){
		$FleetRow['details'] = sprintf($lang['fl_details_2'], pretty_number($FleetRow['shipcount']));
	}else{
		$FleetRow['details'] = $lang['fl_details_0'];
	}

	//Progress
	$dur = $FleetRow['arrival'] - $FleetRow['departure'] + 1;
	$pos = time() - $FleetRow['departure'];
	$FleetRow['progress'] = $pos / $dur;
	
	//For returning fleets:
	if($FleetRow['fleet_mess'] > 0){
		//Change image to a returning fleet icon
		$FleetRow['image'] = 'icon-fleet-movement-reverse.gif';

		//Progress is the other way:
		$FleetRow['progress'] = 1 - $FleetRow['progress'];
	}

	//We need to turn pos into a number of pixels.
	$FleetRow['progress'] = round($FleetRow['progress'] * 273);

  $startplanet = doquery("SELECT `name`,`galaxy`,`system`,`planet` FROM {{table}} WHERE `id` = '".$FleetRow['owner_id']."' LIMIT 1;",'planets',true);
	if(strlen($startplanet['name']) > 0){
		$FleetRow['startplanet_name']   = $startplanet['name'];
    $FleetRow['startplanet_galaxy'] = $startplanet['galaxy'];
    $FleetRow['startplanet_system'] = $startplanet['system'];
    $FleetRow['startplanet_planet'] = $startplanet['planet'];
  }

  $targetplanet = doquery("SELECT `name`,`galaxy`,`system`,`planet` FROM {{table}} WHERE `id` = '".$FleetRow['target_id']."' LIMIT 1;",'planets',true);
	if(strlen($targetplanet['name']) > 0){
		$FleetRow['targetplanet_name']   = $targetplanet['name'];
    $FleetRow['targetplanet_galaxy'] = $targetplanet['galaxy'];
    $FleetRow['targetplanet_system'] = $targetplanet['system'];
    $FleetRow['targetplanet_planet'] = $targetplanet['planet'];
  }

  $targetplayer = doquery("SELECT `username` FROM {{table}} WHERE `id` = '".$FleetRow['target']."' LIMIT 1;",'users',true);
  if(strlen($targetplayer['username']) > 0)
		$FleetRow['targetplayer_name']   = $targetplayer['username'];

	//And finally output the template
	$parse['fleets'] .= parsetemplate(gettemplate('fleet/fleet_mov'), $FleetRow);
}

$page = parsetemplate(gettemplate('fleet/movement'), $parse);
if($_GET['axah']){
	makeAXAH($page);
}else{
	displaypage($page, $lang['FleetManage']);
}

// Created by MadnessRed. All rights reversed (C) 2009
?>
