<?php

/**
 * overviewfunctions.php
 *
 * @version 1
 * @copyright 2008 By MadnessRed for XNova_Redisigned
 */

//This file is to clear out all that complicated mess from overview.php.

//Start any alerts
$alerts = '';
//First if they delete a planet.
if (($_GET['mode'] == "delplanet") && ($_GET['planet_id'] == $user['current_planet'])) {
	//Check the pass and check they are not deleting homeworld
	if ((sha($_GET['password']) == $user['password']) && ($user['id_planet'] != $user['current_planet'])) {
		DestroyPlanet($user['current_planet'],$user,$planetrow);
		// Tout s'est bien passé ! La colo a été effacée !!
		$alerts .= "<br />".$lang['deletemessage_ok'];
	} elseif ($user['id_planet'] == $user["current_planet"]) {
		// Et puis quoi encore ??? On ne peut pas effacer la planete mere ..
		// Uniquement les colonies crées apres coup !!!
		$alerts .= "<br />".$lang['deletemessage_wrong'];
	} else {
		// Erreur de saisie du mot de passe je n'efface pas !!!
		$alerts .= "<br />".$lang['deletemessage_fail'];
	}
	die($alerts);
}

//Or if they rename a planet.
if ($_GET['mode'] == "renplanet") {
	//Filter the name
	$newname = preg_replace("/[^A-Za-z0-9 ]/","",$_GET['newPlanetName']);
	if ($newname != "") {
		//Change the name of the planet in the planetrow array
		$planetrow['name'] = $newname;
		//Update table
		doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `id` = '" . $user['current_planet'] . "' LIMIT 1;", "planets");
		doquery("UPDATE {{table}} SET `menus_update` = '".time()."' WHERE `id` = '" . $user['id'] . "' LIMIT 1;",'users');
	}
}

//Whats building?
if (strlen($planetrow['build_queue']) > 0) {
	UpdateQueue();
	if (strlen($planetrow['build_queue']) > 0) {
		
		$Queue = ShowQueue (false);
		$queueinfo  = '<div id="resources_queue_box">';
		$queueinfo .= $Queue['buildlist'];
		$queueinfo .= '</div>';
		
	} else {
		$queueinfo  = '<div id="resources_queue_box">';
		
		$queueinfo .= '<div class="content-box-s">';
		$queueinfo .= '<div class="header"><h3>Buildings</h3></div>';
		$queueinfo .= '<div class="content">';
		
		$queueinfo .= '<table cellpadding="0" cellspacing="0" class="construction">';
		$queueinfo .= '<tr>';
		$queueinfo .= '<td colspan="2" class="idle">';
		$queueinfo .= $lang['Free_bu'];
		$queueinfo .= '</td>';
		$queueinfo .= '</tr>';
		$queueinfo .= '</table>';
		
		$queueinfo .= '</div>';
		$queueinfo .= '<div class="footer"></div>';
		
		$queueinfo .= '</div>';
	}
} else {
	$queueinfo  = '<div id="resources_queue_box">';
	
	$queueinfo .= '<div class="content-box-s">';
	$queueinfo .= '<div class="header"><h3>Buildings</h3></div>';
	$queueinfo .= '<div class="content">';
		
	$queueinfo .= '<table cellpadding="0" cellspacing="0" class="construction">';
	$queueinfo .= '<tr>';
	$queueinfo .= '<td colspan="2" class="idle">';
	$queueinfo .= $lang['Free_bu'];
	$queueinfo .= '</td>';
	$queueinfo .= '</tr>';
	$queueinfo .= '</table>';
	
	$queueinfo .= '</div>';
	$queueinfo .= '<div class="footer"></div>';
	$queueinfo .= '</div>';
	
	$queueinfo .= '</div>';
}

//Whats happening in shipyard?
if ($planetrow['b_hangar_id'] != '') {

	// Array del b_hangar_id
	$ElementQueue = explode(';', $planetrow['b_hangar_id']);

	$cont = true; $q = array();
	foreach($ElementQueue as $ElementLine => $Element) {
		if ($Element != '') {
			if($cont){
				$Element = explode(',', $Element);
				$NamePerType = $lang['tech'][$Element[0]];
				$NbrePerType = $Element[1];
				$Typecode = $Element[0];
				$ProductionTime = time() - $planetrow['b_hangar_lastupdate'] + $planetrow['b_hangar'];
				$Time = (GetBuildingTime($user,$planetrow,$Typecode) * $NbrePerType) - $ProductionTime;
				//echo GetBuildingTime($user,$planetrow,$Typecode)."*".$NbrePerType." - ".$ProductionTime." = ".$Time;
				$cont = false;
			}else{
				$Element = explode(',', $Element);
				$q[] = array('id' => $Element[0],'count' => $Element[1]);				
			}
		}
	}
	
	$queueinfosy  = '
		<table cellpadding="0" cellspacing="0" class="construction" width="100%">
			<tr>
				<th colspan="2">'.$NamePerType.'</th>
			</tr>
			<tr class="data">
				<td class="building" rowspan="2">
					<img src="'.GAME_SKIN.'/img/small/small_'.$Typecode.'.jpg" alt="'.$NamePerType.'">
				</td>
				<td class="desc">Number: 
					<span class="level">'.$NbrePerType.'</span>
				</td>
			</tr>
			<tr>
				<td class="desc">'.parsecountdown(time() + $Time,true).'</td>
			</tr>
			<tr class="queue">
			<tr class="queue">
				<td colspan="2">
					<table>
						<tr>';
	$no = 0;
	foreach ($q as $arr){
		$no++;
		$queueinfosy  .= '
							<td class="tips" titl="|2 Colony Ship Build">
								<a href="#">
									<img src="'.GAME_SKIN.'/img/tiny/tiny_'.$arr['id'].'.jpg" height="28" width="28" alt="'.$lang['names'][$arr['id']].'">
								</a><br />
								'.$arr['count'].'
							</td>';
		if($no == 4){
			$queueinfosy  .= '</tr><tr>';
			$no = 0;
		}
	}
	$queueinfosy .= '
						</tr>
					</table>
				</td>
			</tr>
		</table>';
} else {
	$queueinfosy  = '<table cellpadding="0" cellspacing="0" class="construction">';
	$queueinfosy .= '<tr>';
	$queueinfosy .= '<td colspan="2" class="idle">';
	$queueinfosy .= $lang['Free_sy'];
	$queueinfosy .= '</td>';
	$queueinfosy .= '</tr>';
	$queueinfosy .= '</table>';
}

//Whats happening in the research lab?
if($user['b_tech_planet'] > 0){
	$WorkingPlanet = doquery("SELECT `b_tech_id`,`b_tech` FROM {{table}} WHERE `id` = '". $user['b_tech_planet'] ."';", 'planets', true);
	$queueinforl  = '
		<table cellpadding="0" cellspacing="0" class="construction">
			<tr>
				<th colspan="2">'.$lang['tech'][$WorkingPlanet['b_tech_id']].'</th>
			</tr>
			<tr class="data">
				<td class="building" rowspan="2">
					<img src="'.GAME_SKIN.'/img/small/small_'.$WorkingPlanet['b_tech_id'].'.jpg" alt="'.$lang['names'][$WorkingPlanet['b_tech_id']].'">
				</td>
				<td class="desc">Improve to 
					<span class="level">Level '.($user[$resource[$WorkingPlanet['b_tech_id']]] + 1).'</span>
				</td>
			</tr>
			<tr>
				<td class="desc">'.parsecountdown($WorkingPlanet['b_tech'],true).'</td>
			</tr>
		</table>';
} else {
	$queueinforl  = '<table cellpadding="0" cellspacing="0" class="construction">';
	$queueinforl .= '<tr>';
	$queueinforl .= '<td colspan="2" class="idle">';
	$queueinforl .= $lang['Free_rl'];
	$queueinforl .= '</td>';
	$queueinforl .= '</tr>';
	$queueinforl .= '</table>';
}

?>
