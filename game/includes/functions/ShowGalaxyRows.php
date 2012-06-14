<?php

/**
 * ShowGalaxyRows.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function ShowGalaxyRows ($Galaxy, $System) {
	global $lang, $planetcount, $CurrentRC, $dpath, $user, $planetrow, $resource, $pricelist, $formulas;
	
	
	//Can we phalanx this system?
	$CanPhalanx = false;
	if(abs($planetrow['system'] - $System) <= eval($formulas['phalanx_range']) && $planetrow['galaxy'] == $Galaxy){
		$CanPhalanx = true;
	}
	
	//Loop through planets
	$Result = "";
	for ($Planet = 1; $Planet <= MAX_PLANET_IN_SYSTEM; $Planet++) {
		unset($GalaxyRowPlanet);
		unset($GalaxyRowMoon);
		unset($GalaxyRowPlayer);
		unset($GalaxyRowAlly);
		
		//MadnessRed, reset some things to false.
		$noplanet = false;
		$moon = false;
		$moondest = false;

		$GalaxyRowPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '1' LIMIT 1 ;", 'planets', true);
		
		//If there is a planet here
		if ($GalaxyRowPlanet['id'] > 0) {
			//There is a planet
			if ($GalaxyRowPlanet['destruyed'] != 0 && 
				$GalaxyRowPlanet['id_owner'] != '' && 
				$GalaxyRowPlanet['id_owner'] != 0 && 
				$GalaxyRow["id_planet"] != '') {
				CheckAbandonPlanetState ($GalaxyRowPlanet);
			} else {
				$planetcount++;
				$GalaxyRowPlayer = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRowPlanet["id_owner"] ."';", 'users', true);
			}
			
			//Is there a moon?
			$GalaxyRowMoon = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."' AND `planet_type` = '3' LIMIT 1 ;", 'planets', true);
			if ($GalaxyRowMoon["id"] > 0) {
				$moon = true;

				if ($GalaxyRowMoon["destruyed"] != 0) {
					$moondest = true;
					CheckAbandonMoonState ($GalaxyRowMoon);
				}
			}
		}else{
			$noplanet = true;
		}
		
		//Clear $parse,
		$parse = array();
		$parse = $lang;
		
		
		//Some Basics
		//Galaxy & System
		$parse['galaxy'] = $Galaxy;
		$parse['system'] = $System;
		
		//Username and ID
		$parse['player_name'] = $GalaxyRowPlayer['username'];
		if($GalaxyRowPlayer['urlaubs_modus'] == 1){
			//Utente In Vacanza
			$parse['player_name'] = "<font color=#00CCFF><strong>".$GalaxyRowPlayer['username']."&nbsp; ( V )</strong></font>";
		}
		//Controllo se � bannato
		if($GalaxyRowPlayer['banned_until'] >= time()){
			//Controllo se � stata attivata o meno la modalit� Vacanza
			if($GalaxyRowPlayer['urlaubs_modus'] == 1){	
				//Utente In Vacanza
				$parse['player_name'] = "<font color=#00CCFF><strong><s>".$GalaxyRowPlayer['username']."&nbsp; ( V B )</s></strong></font>";
			}else{
				//Utente Bannato SENZA VACANZA
				$parse['player_name'] = "<font color=#FFFFFF><strong><s>".$GalaxyRowPlayer['username']."&nbsp; ( B )</s></strong></font>";
			}
		}
		//Controllo se il giocatore � Inattivo
		if($GalaxyRowPlayer['onlinetime'] < (time() - 60 * 60 * 24 * 7)){
			//Inattivo da 7 Giorni
			$parse['player_name'] = "<font color=#999999>".$GalaxyRowPlayer['username']."&nbsp; ( i )</font>";
		}
		if($GalaxyRowPlayer['onlinetime'] < (time() - 60 * 60 * 24 * 28)){
			//Inattivo da 28 Giorni
			$parse['player_name'] = "<font color=#666666>".$GalaxyRowPlayer['username']."&nbsp; ( i I )</font>";
		}

		$parse['player_id'] = $GalaxyRowPlayer['id'];
		
		//Alliance
		$Alliance = false;
		if($GalaxyRowPlayer["ally_id"] > 0){
			$Alliance = true;
			$GalaxyRowAlly = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRowPlayer["ally_id"] ."' ;", 'alliance', true);
			$parse['ally_name'] = $GalaxyRowAlly["ally_name"];
			$parse['ally_tag'] = $GalaxyRowAlly["ally_tag"];
			$parse['ally_id'] = $GalaxyRowAlly["id"];
			$parse['aly_members'] = $GalaxyRowAlly["ally_members"];
		}
		
		
		//Planet Number and Name
		$parse['pos'] = $Planet;
		$parse['planet_name_short'] = $GalaxyRowPlanet['name'];
		$parse['planet_name'] = $GalaxyRowPlanet['name'];
		
		//Debris field.
		$parse['df_metal'] = $GalaxyRowPlanet['debris_m'];
		$parse['df_crystal'] = $GalaxyRowPlanet['debris_c'];
		$parse['df_recs'] = ceil(($parse['df_metal'] + $parse['df_crystal']) / $pricelist[209]['capacity']);
		
		//Planet Type
		$pt = PlanetType($GalaxyRowPlanet['image']);
		$parse['micro_planet_img'] = "img/planets/micro/".$pt['type']."_".$pt['subtype']."_1.gif";
		
		//Player Stuff		
		//$parse['avatar_small'] = '<img src='.GetAvatar($GalaxyRowPlayer['email'],50).' alt=Player&nbsp;avatar border=0 />';

		//Visualizzo il Rank del Player :
		$Rank = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $GalaxyRowPlayer['id'] ."';", 'statpoints');
		$parse['rank'] = $Rank['total_rank'];
		//$parse['rank'] = "PRIMOOO";
		
		//Tooltip height
		$parse['tooltip_height'] = 75 + (31 * $Planet);
		
		//PlanetIMG
		if($noplanet){
			$parse['td_microplanet'] = "";
			$parse['td_microplanet_class'] = 'microplanet1';
			$parse['td_microplanet_extra'] = '';
			$parse['td_microplanet_style'] = '';
			$parse['td_playername']  = "";
		}else{
			if($CanPhalanx && $GalaxyRowPlayer['id'] != $user['id']){
				//$parse['phalanx'] = "<li><a href=# onclick=loadpage(\'./?page=phalanx\',\'".$lang['Phalanx']."\',\'fleet1\');>".$lang['Phalanx']."</a></li>";
				$parse['phalanx'] = "<li><a href=# onclick=mrbox(\'./?page=phalanx\');>".$lang['Phalanx']."</a></li>";
				//(url,width,margintop,title,method)
			}else{
				$parse['phalanx'] = "";
			}
			$parse['td_microplanet'] = parsetemplate(gettemplate('galaxy/microplanet'), $parse);
			$parse['td_microplanet_class'] = 'TTgalaxy microplanet';
			$parse['td_microplanet_extra'] = 'rel="#planet{pos}"';
			$parse['td_microplanet_style'] = 'background:url('.GAME_SKIN.'/'.$parse['micro_planet_img'].') no-repeat top center;';
			$parse['td_playername']  = parsetemplate(gettemplate('galaxy/playername'), $parse);
		}
		
		//Alliance?
		if($Alliance){
			$parse['td_alliance'] = parsetemplate(gettemplate('galaxy/alliance'), $parse);
		}
		
		//Moon?
		if($moondest){
			$parse['td_moon'] = '<img src="img/galaxy/moon_c.gif" width="30" height="30" />';
		}elseif($moon){
			$parse['moon_name'] = $GalaxyRowMoon['name'];
			$parse['diametre'] = $GalaxyRowMoon['diameter'];
			
			$parse['td_moon'] = parsetemplate(gettemplate('galaxy/moon'), $parse);
		}
		
		//DF?
		if($parse['df_metal'] + $parse['df_crystal'] > 0){
			$parse['td_df'] = parsetemplate(gettemplate('galaxy/df'), $parse);
		}
				
		//Actions
		$mes = '<a class="tips thickbox" href="javascript:void(0)" onclick="mrbox(\'./?page=write&to={id}&iframe=1&iheight=800\',800)" style="position:relative;">
			<img src="{{skin}}/img/icons/mail.gif" width="16" height="16" title="Write Message" />
		</a>';
		
		$bud = '<a class="tips" href="./?page=networkbuddy&a=2&u={id}" style="position:relative;">
			<img src="{{skin}}/img/icons/user.gif" width="16" height="16" title="Buddy request" />
		</a>';
		
		if($user['spio_anz'] > $planetrow[$resource[210]]){ $probes = $planetrow[$resource[210]]; }else{ $probes = $user['spio_anz']; }
		$spy = '<a class="tips thickbox" href="#" onclick="mr_alert(\'<img height=16 width=16 src=\\\'../skins/xr//img/ajax-loader.gif\\\' /> {Loading}...\',\'<img src=\\\'{{skin}}/img/icons/auge.gif\\\' width=16 height=16 title=Spy />\'); getAXAH(\'./?page=fleet4&galaxy={galaxy}&system={system}&planet={pos}&planettype=1&fleet_array=a:1:{i:210;s:1:\\%22'.$probes.'\\%22;}&speed=10&mission=6&holdingtime=0&resource1=0&resource2=0&resource3=0\',\'errorBoxNotifyContent\'); return false;" style="position:relative;">
			<img src="{{skin}}/img/icons/auge.gif" width="16" height="16" title="Spy" />
		</a>';
		
		$ipm = '<a class="tips" href="#" onclick="mrbox(\'./?page=ipm&gal={galaxy}&sys={system}&pos={pos}&pt=1\',650,150);" style="position:relative;">
			<img src="{{skin}}/img/icons/rakete.gif" width="16" height="16" title="Missile Attack" />
		</a>';
		
		if(!$noplanet && ($GalaxyRowPlayer["id"] != $user["id"])){
			$parse['id'] = $GalaxyRowPlayer["id"];
			$parse['act_message'] = parsetemplate($mes, $parse);
			$parse['act_buddy'] = parsetemplate($bud, $parse);
			if($planetrow[$resource[210]] > 0 && !ProtectNoob(array($Galaxy,$System,$Planet))){
				$parse['act_spy'] = parsetemplate($spy, $parse);
			}
			if($planetrow[$resource[503]] > 0 && $planetrow['galaxy'] = $Galaxy && eval($formulas['ipm_range']) > abs($planetrow['system'] - $System) && !ProtectNoob(array($Galaxy,$System,$Planet))){
				$parse['act_nuke'] = parsetemplate($ipm, $parse);
			}
		}
		
		
		//Now make the whole row
		$Result .= parsetemplate(gettemplate('galaxy/galaxyrow_div'), $parse);
	}

	return $Result;
}

?>
