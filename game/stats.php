<?php

/**
 * stats.php
 *
 * @version 1.0
 * @copyright 2009 by Anthony for XNova Redesigned
 */

/* Some info on functionsuser here
mod($x) - runs the modulus |$x|
idstring($x) - returns all the numbers in a string, eg 1a2b3c.4d returns 1234 unless arg 2 is true, then 123.4
*/
getLang('stat');
$parse = $lang;
if(idstring($_GET['p']) > 0){
	$p = (idstring($_GET['p']) - 1) * 100;
}else{
	$p = floor((USER_RANK-1) / 100) * 100;
}
if($p < 0){ $p = 0; }
$parse['time_of'] = date("d M Y - H:i:s", $game_config['last_reload']);
if($_GET['sort'] == 'fleet'){
	$sort = 'fleet';
    $parse['class_4'] = 'active';
}elseif($_GET['sort'] == 'research'){
	$sort = 'research';
    $parse['class_5'] = 'active';
}else{
	$sort = 'total';
    $parse['class_3'] = 'active';
}
$parse['sort'] = $sort;
if($_GET['who'] == 'ally'){
    $parse['class_2'] = 'active';
	$stattable = doquery("
	SELECT `id`, `username`, 
	SUM(`total_points`) AS `total_points`, 
	SUM(`fleet_points`) AS `fleet_points`, 
	SUM(`research_points`) AS `research_points`, 
	`ally_id`, `ally_name` 
	FROM {{table}} WHERE `ally_id` > '0' GROUP BY `ally_id` ORDER BY `".$sort."_points` DESC LIMIT ".$p.",100;",'users',false);
	$who = 'ally';
	$disp = 'ally_';
	$parse['who'] = $who;
	$parse['type_stat'] = 'ALLIANCES';

	//$updaterank = '';
	$parse['rows'] = '';
	while($statrow = mysql_fetch_array($stattable)){
		$alianza_tag = doquery("SELECT `ally_tag`, `ally_name` FROM {{table}} WHERE `id` = '".$statrow['ally_id']."'",'alliance');
		$alianza_tag = mysql_fetch_array($alianza_tag);
		$p++;
		$change = ($statrow[$sort."_rank"] - $p);
		if($change > 0){
			$ch = 'class="undermark" title="+'.mod(floor($change)).'"';
			$plus = "+";
		}elseif($change < 0){
			$ch = 'class="overmark" title="-'.mod(floor($change)).'"';
			$plus = "-";
		}else{
			$plus = "*";
		}
		if($p % 2 == 1){ $alt = ' class="alt"'; }else{ $alt = ''; }
		//print_r($statrow);
		$parse['rows'] .= '
					<tr'.$alt.'>
						<!-- rank -->
						<td class="position">'.($p).'&nbsp;&nbsp;<span '.$ch.' style="cursor:default;">'.$plus.'</span></td>
						
						<!-- nick -->
						<td class="name">
							<a style="color:FFFFFF" href="./?page=ainfo&allyid='.$statrow["ally_id"].'" 
							target="_ally"
							title="'.$lang['goto_alliance'].'"
							>'.$alianza_tag[$disp.'name'].'</a>
						</td>
						
						<!--  message-icon -->
						<td class="sendmsg">
							<a title="'.$lang['goto_alliance'].'" class="tips thickbox" href="./?page=ainfo&allyid='.$statrow['ally_id'].'" rel="ibox&width=785&height=490">
								<img title="'.$lang['goto_alliance'].'" src="'.GAME_SKIN.'/img/icons/info.gif" />
							</a>
						</td>
						
						<!-- points -->
						<td class="score">'.pretty_number(floor($statrow[$sort."_points"]/$game_config['stat_settings'])).'</td>
					</tr>';
					unset($statrow);
		//$updaterank .= "UPDATE {{table}} SET `".$sort."_rank` = '".$p."' WHERE `username` = '".$statrow[$disp.'name']."' ;  ";
	}
	$top10 = doquery(
		"SELECT `id`, `username`, `galaxy`, `system`, `planet`, `total_rank`, `total_points`, `fleet_rank`, `fleet_points`, `research_rank`, `research_points`, `ally_id`, `ally_name` 
		FROM {{table}} ORDER BY `".$sort."_points` DESC LIMIT 10;",'users',false);
	while($statrow = mysql_fetch_array($top10)){
		$c++;
		if($c % 2 == 1){ $alt = ' alt'; }else{ $alt = ''; }
		//print_r($statrow);
		$parse['top10'] .= '	
					
					<tr>
				<td class="rankcol'.$alt.'">'.$c.'</td>

				<td class="namecol ">
					
						<span style="color:FFFFFF">
						<a href="./?page=galaxy&galaxy='.$statrow['galaxy'].'&system='.$statrow['system'].'&position='.$statrow['planet'].'" 
							target="_ally"
							class="tips"
							title="'.$lang['goto_galaxy'].'">
								'.$statrow["username"].'
						 </a>
					</span>				
					</td>
			</tr>';
			unset($statrow);
	$parse['top10_title'] = $lang['t10_players'];
	}
}else{
	$parse['top10_title'] = $lang['t10_allys'];
    $parse['class_1'] = 'active';
	$stattable = doquery(
	"SELECT `id`, `username`, `galaxy`, `system`, `planet`, `total_rank`, `total_points`, `fleet_rank`, `fleet_points`, `research_rank`, `research_points`, `ally_id`, `ally_name` 
	FROM {{table}} ORDER BY `".$sort."_points` DESC LIMIT ".$p.",100;",'users',false);
	$who = 'player';
	$disp = 'user';
	$top10 = doquery("
	SELECT `id`, `username`, 
	SUM(`total_points`) AS `total_points`, 
	SUM(`fleet_points`) AS `fleet_points`, 
	SUM(`research_points`) AS `research_points`, 
	`ally_id`, `ally_name` 
	FROM {{table}} WHERE `ally_id` > '0' GROUP BY `ally_id` ORDER BY `".$sort."_points` DESC LIMIT 10;",'users',false);
	while($statrow = mysql_fetch_array($top10)){
	$c++;
	if($c % 2 == 1){ $alt = ' alt'; }else{ $alt = ''; }
		//print_r($statrow);
		$alianza_tag = doquery("SELECT `ally_tag`, `ally_name` FROM {{table}} WHERE `id` = '".$statrow['ally_id']."'",'alliance');
		$alianza_tag = mysql_fetch_array($alianza_tag);
		$parse['top10'] .= '	
				
				<tr>
			<td class="rankcol'.$alt.'">'.$c.'</td>

			<td class="namecol ">
				
					<span class="ally-tag">
					<a href="./?page=ainfo&allyid='.$statrow["ally_id"].'" 
			   			target="_ally"
			   			class="tips"
			   			title="Go to the alliance page">
							['.$alianza_tag["ally_name"].']
					 </a>
				</span>				
				</td>
		</tr>';
		unset($statrow);
	}
	$parse['who'] = $who;
	$parse['type_stat'] = 'PLAYER';
	//$updaterank = '';
	$parse['rows'] = '';
	while($statrow = mysql_fetch_array($stattable)){
		$p++;
		$change = ($statrow[$sort."_rank"] - $p);
		if($change > 0){
			$ch = 'class="undermark" title="+'.mod(floor($change)).'"';
			$plus = "+";
		}elseif($change < 0){
			$ch = 'class="overmark" title="-'.mod(floor($change)).'"';
			$plus = "-";
		}else{
			$plus = "*";
		}
		$alianza_tag = doquery("SELECT `ally_tag`, `ally_name` FROM {{table}} WHERE `id` = '".$statrow['ally_id']."'",'alliance');
		$alianza_tag = mysql_fetch_array($alianza_tag);
		if($statrow['ally_name'] != '' and $statrow['ally_id'] != ''){
			$ally = '<span class="ally-tag"><a href="./?page=ainfo&allyid='.$statrow["ally_id"].'" title="'.$alianza_tag["ally_name"].'">['.$alianza_tag["ally_tag"].']</span>';
		}else{
			$ally = '';
		}
		if($p % 2 == 1){ $alt = ' class="alt"'; }else{ $alt = ''; }
		if($statrow['id'] == $user['id']){
			$alt = ' class="myrank"';
		}
		//print_r($statrow);
		$parse['rows'] .= '
					<tr'.$alt.'>
						<!-- rank -->
						<td class="position">'.($p).'&nbsp;&nbsp;<span '.$ch.' style="cursor:default;">'.$plus.'</span></td>
						
						<!-- nick -->
						<td class="name">
							'.$ally.' <a href="./?page=galaxy&galaxy='.$statrow['galaxy'].'&system='.$statrow['system'].'&position='.$statrow['planet'].'" style="color:FFFFFF" >'.$statrow[$disp.'name'].'</a>
						</td>
						
						<!--  message-icon -->
						<td class="sendmsg">
							<a title="'.$lang['send_message'].'" class="tips thickbox" href="./?page=write&to='.$statrow['id'].'&close=1"  onClick="window.open(this.href, this.target, \'width=770,height=475\');return false;">
								<img title="'.$lang['send_message'].'" src="'.GAME_SKIN.'/img/icons/mail.gif" />
							</a>
						</td>
						
						<!-- points -->
						<td class="score">'.pretty_number(floor($statrow[$sort."_points"]/$game_config['stat_settings'])).'</td>
					</tr>';
		//$updaterank .= "UPDATE {{table}} SET `".$sort."_rank` = '".$p."' WHERE `username` = '".$statrow[$disp.'name']."' ;  ";
		unset($statrow);
	}
	//$updaterank .= "UPDATE {{table}} SET `".$sort."_rank` = '".$p."' WHERE `username` = '".$statrow[$disp.'name']."' ;  ";
}
$parse['pages'] = '';
for ($p = 1; $p <= ceil($game_config['users_amount'] / 100); $p++){
	$st = ($p - 1) * 100;
	if($p == $_GET['p']){ $selected = "SELECTED"; }else{ $selected = ""; }
	$parse['pages'] .= "\t\t\t\t\t\t<option value=\"".$p."\" ".$selected.">".($st+1)."-".($st+100)."</option>\n";
}
//Update
//if($who == 'player'){ doquery($updaterank,'users'); }
if($_GET['axah']){
	makeAXAH(parsetemplate(gettemplate('stats'),$parse));
}else{
	displaypage(parsetemplate(gettemplate('stats'),$parse),$lang['Statistics']);
}
?>
