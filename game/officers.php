<?php

/**
 * officers.php
 *
 * @version 1.2
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */


function ShowOfficierPage ( &$CurrentUser ) {
	global $lang, $resource, $reslist, $_GET;

	includeLang('officier');
	includeLang('infos');
	getLang('premium');
	
	
	//Officer costs.
	$week_cost = 10000; //Cost for one week
	$three_month_cost = 100000; //Cost for 3 months
	
	
	$factor = DARK_MATTER_FACTOR;

	//Old system, you can un-comment and use if you want
	/*
	//refers,lvl_minier,lvl_raid,off_spent
	$CurrentUser['rpg_points']  = (($CurrentUser['refers'] + $CurrentUser['lvl_minier'] + $CurrentUser['lvl_raid']) / $factor);
	doquery("UPDATE {{table}} SET `rpg_points` = '".$CurrentUser['rpg_points']."' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
	$offipts = ($CurrentUser['rpg_points'] - $CurrentUser['off_spent']) * $factor;
	$av2buy = floor($CurrentUser['rpg_points'] - $CurrentUser['off_spent']);
	*/
	
	$av2buy = $CurrentUser['matter'];
	
	// Si recrutement d'un officier
	if ($_GET['mode'] == 2) {
		if ($av2buy >= $week_cost) {
			$Selected    = idstring($_GET['offi']);
			if ( in_array($Selected, $reslist['officier']) ) {
				$Result = IsOfficierAccessible ( $CurrentUser, $Selected );
				if ( $Result == 1 ) {					
					if($_GET['time'] == "1"){
						$CurrentUser[$resource[$Selected]."_exp"] = time() + (60 * 60 * 24 * 7);
						//$CurrentUser['off_spent'] += 1;
						$CurrentUser['matter'] -= $week_cost;
					}elseif($_GET['time'] == "2" && $av2buy >= $three_month_cost){
						$CurrentUser[$resource[$Selected]."_exp"] = time() + (60 * 60 * 24 * 30 * 3);
						//$CurrentUser['off_spent'] += 10;
						$CurrentUser['matter'] -= $three_month_cost;
					}elseif($_GET['time'] == "2"){
						$stop = true;
					}

					if(!$stop){
						$QryUpdateUser  = "UPDATE {{table}} SET `matter` = '". $CurrentUser['matter'] ."', ";
						//$QryUpdateUser .= "`".$resource[$Selected]."` = '". $CurrentUser[$resource[$Selected]] ."', ";
						$QryUpdateUser .= "`".$resource[$Selected]."_exp` = '". $CurrentUser[$resource[$Selected]."_exp"] ."' ";
						$QryUpdateUser .= "WHERE `id` = '". $CurrentUser['id'] ."';";
						doquery( $QryUpdateUser, 'users' ) or die(mysql_error());
						$Message = $lang['success'];
					}else{
						$Message = $lang['NoPoints'];
					}
				} elseif ( $Result == -1 ) {					
					if($_GET['time'] == "1"){
						$CurrentUser[$resource[$Selected]."_exp"] += (60 * 60 * 24 * 7);
						//$CurrentUser['off_spent'] += 1;
						$CurrentUser['matter'] -= $week_cost;
					}elseif($_GET['time'] == "2" && $av2buy >= $three_month_cost){
						$CurrentUser[$resource[$Selected]."_exp"] += (60 * 60 * 24 * 30 * 3);
						//$CurrentUser['off_spent'] += 10;
						$CurrentUser['matter'] -= $three_month_cost;
					}elseif($_GET['time'] == "2"){
						$stop = true;
					}

					if(!$stop){
						$QryUpdateUser  = "UPDATE {{table}} SET `matter` = '". $CurrentUser['matter'] ."', ";
						//$QryUpdateUser .= "`".$resource[$Selected]."` = '". $CurrentUser[$resource[$Selected]] ."', ";
						$QryUpdateUser .= "`".$resource[$Selected]."_exp` = '". $CurrentUser[$resource[$Selected]."_exp"] ."' ";
						$QryUpdateUser .= "WHERE `id` = '". $CurrentUser['id'] ."';";
						doquery( $QryUpdateUser, 'users' ) or die(mysql_error());
						$Message = $lang['success'];
					}else{
						$Message = $lang['NoPoints'];
					}
				} elseif ( $Result == 0 ) {
					$Message = $lang['Noob'];
				}
			} else {
				$Message = $lang['NonExist']." (".$Selected.")";
			}
		} else {
			$Message = $lang['NoPoints'];
		}
		info($Message,$lang['Officier'],"./?page=premium&offi=".$Selected);
		die();
	} else {
		// Pas de recrutement d'officier
		$TPL = gettemplate('buildings/officers');
		$MatterTPL = gettemplate('buildings/off_matter');
		$InfoTPL = gettemplate('buildings/off_info');
		$IconTPL = gettemplate('buildings/off_icon');
		
		
		
		$parse = $lang;
		$parse['avl2buy']   = KMnumber($av2buy);
		
		$parse['offis'] = '';
		
		foreach($reslist['officier'] as $n => $off) {
			$row = $lang;
			
			//The item
			$row['n'] = ($n + 2);
			$row['id'] = $off;
			$row['name'] = $lang['names'][$off];
			
			//Availble?
			$Result = IsOfficierAccessible ( $CurrentUser, $off );
			if($Result == 0){ $row['class'] = 'off'; }
			else{ $row['class'] = 'on'; }
			
			//How long have we got left?
			$expires = $CurrentUser[$resource[$off]."_exp"];
			$oneday   = (60 * 60 * 24);
			$onehour  = (60 * 60);
			$timeleft = ($expires - time());
			if($timeleft > $oneday){
				$hiredfor = floor($timeleft / $oneday)." ".$lang['days'].".";
			}elseif($timeleft > $onehour){
				$hiredfor = floor($timeleft / $onehour)." ".$lang['hours'].".";
			}elseif($timeleft > 0){
				$hiredfor = floor($timeleft / 60)." ".$lang['mins'].".";					
			}else{
				$hiredfor = 'X';
			}
			$row['remaining'] = $lang['activefor']." ".$hiredfor;
			
			//$row['name'] = $
			
			//Icons
			if($timeleft > 0){ $row['gotgfx'] = 'check'; }
			else{ $row['gotgfx'] = 'none'; }
			
			$parse['offis'] .= parsetemplate( $IconTPL, $row);
			
			/*
				$bloc['off_id']       = $Officier;
				$bloc['off_tx_lvl']   = $lang['ttle'][$Officier];
				if($CurrentUser[$resource[$Officier]] > 0){
					$bloc['off_lvl']      = " : ".$lang['hireduntil']." ".$hiredfor;
				}else{
					$bloc['off_lvl']      = "";
				}
				$bloc['off_desc']     = $lang['Desc'][$Officier];
				if ($Result == 1) {
					$bloc['off_link']  = "<a href=\"officier.php?mode=2&time=1&offi=".$Officier."\"><font color=\"#00ff00\">". $lang['link'][1]."</font><br /><br />";
					$bloc['off_link'] .= "<a href=\"officier.php?mode=2&time=2&offi=".$Officier."\"><font color=\"#00ff00\">". $lang['link'][2]."</font>";
				} else {
					$bloc['off_link'] = $lang['Maxlvl'];
				}
				$parse['disp_off_tbl'] .= parsetemplate( $RowTPL, $bloc );
			*/
		}
		if(idstring($_GET['offi']) == '600'){
			$parse['remove'] = 'style="display:none;"';
			$parse['info'] = parsetemplate( $MatterTPL, $parse);
		}elseif(in_array(idstring($_GET['offi']),$reslist['officier'])){
			$info = $lang;
			
			$info['offi'] = $_GET['offi'];
			$info['id'] = 0;
			foreach($reslist['officier'] as $n => $off) { if($off == $_GET['offi']){ $info['id'] = ($n + 2); } }
			
			$info['oneweekcost'] = pretty_number($week_cost);
			$info['threemonthcost'] = pretty_number($three_month_cost);
			
			$info['name'] = $lang['info'][$_GET['offi']]['name'];
			$info['long_desc'] = $lang['info'][$_GET['offi']]['description'];
			$info['sdesc'] = $lang['res']['descriptions'][$_GET['offi']];
				
			$parse['remove'] = 'style="display:none;"';
			$parse['info'] = parsetemplate( $InfoTPL, $info);
		}else{
			$parse['info'] = '';
		}
		$page           = parsetemplate( $TPL, $parse);
	}

	return $page;
}

$page = ShowOfficierPage ( $user );
	
if($_GET['axah']){
	makeAXAH($page);
}else{
	displaypage($page, $lang['officier']);
}
	
// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle (Tom1991)
// 1.1 - Réécriture Chlorel pour integration complete dans XNova
?>