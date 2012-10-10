<?php
/*
 * display.php
 *
 * @version 2
 * @copyright 2008 By MadnessRed for XNova_Redisigned
 * @copyright 2012 By Geodar for XNova-Redisigned-Re-Project
 *
*/

function parsetemplate ($template, $array) {
	$template = str_ireplace("{{skin}}",GAME_SKIN,$template);
	$template = str_ireplace("{{user}}",USER_NAME,$template);
	$template = str_ireplace("{{planet}}",PLANET_NAME,$template);
	$template = preg_replace('#title="([^"]+)"#', 'onmouseover="mrtooltip(\'\\1\');" onmouseout="UnTip();"', $template);
	return preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
}

function info($message,$title,$redirect = '',$onpage = 'X',$etype = "note"){
	if($onpage == 'X'){ $onpage = $_SERVER['HTTP_REFERER']; }
	if($onpage == '<<'){ $onpage = $redirect; }
	$onpage = AddUniToLinks($onpage);
	header("Location: ".$onpage."&message=".$message."&title=".$title."&etype=".$etype."&to=".$redirect);
	die();
}

function axahlink($page,$title,$bodyid = ''){
	return '#" onclick="loadpage(\''.$page.'\',\''.$title.'\',\''.$bodyid.'\');';
}

function AddUniToLinks($page,$uni = 'X') {
	global $_GET;

	if(UNITTYPE == "get"){
		if($uni == 'X'){ $uni = UNIVERSE; }

		$patterns = "?page=";
		$replacements = "?".GETVAL."=".$uni."&page=";
		$page = str_ireplace($patterns, $replacements, $page);
	}

	return $page;
}

function AddUniToString($string,$uni = 'X') {
	global $_GET;

	if(UNITTYPE == "get"){
		if($uni == 'X'){ $uni = UNIVERSE; }

		$count = 0;
		$patterns = "?page=";
		$replacements = "?".GETVAL."=".$uni."&page=";
		$string = str_ireplace($patterns, $replacements, $string, $count);

		if($count == 0){
			if($string == './'){
				$string = "./?".GETVAL."=".$uni;
			}else{
				$patterns = ".php?";
				$replacements = ".php?".GETVAL."=".$uni."&";
				$string = str_ireplace($patterns, $replacements, $string, $count);	
			}
			if($count == 0){
				$patterns = ".php";
				$replacements = ".php?".GETVAL."=".$uni;
				$string = str_ireplace($patterns, $replacements, $string);				
			}
		}
	}
	return $string;
}

function GeneralHead($title) {
	global $user;

	$parse				 = $user;
	$parse['title']		 = $title;
	$part                = parsetemplate(gettemplate('redesigned/general_header'),$parse);
	//echo $part;
	return $part;
}

function GeneralFoot() {
	global $user,$planetrow,$resource,$lang,$game_config;
//metal 	metal_perhour 	metal_max 	crystal 	crystal_perhour 	crystal_max 	deuterium 	deuterium_perhour 	deuterium_max 	energy_used 	energy_max

	$Caps = ProductionRates($user,$planetrow);

	$planetrow['metal_max'] = $Caps['metal_max'];
	$planetrow['crystal_max'] = $Caps['crystal_max'];
	$planetrow['deuterium_max'] = $Caps['deuterium_max'];

	$parse = array_merge($lang,$planetrow);
	$parse['metal_ps'] = ($Caps['metal_perhour'] / 3600);
	$parse['crys_ps']  = ($Caps['crystal_perhour'] / 3600);
	$parse['deut_ps']  = ($Caps['deuterium_perhour'] / 3600);

	$parse['Admin']  = ($user['authlevel'] >= 1);	
	$parse['forum_url']	= $game_config['forum_url'];

	$parse['server_offset'] = date('Z');
	$parse['ajax_time'] = time();

	$parse['matter'] = ($user['matter'] * DARK_MATTER_FACTOR);

	$part				 = parsetemplate(gettemplate('redesigned/general_foot'),$parse);
	//echo $part;
	return $part;
}

function NewHeader($bodyid) {
	global $planetrow,$user,$onload,$dpath,$game_config,$resource,$_GET,$lang,$cid;

	getLang('menu');

	$parse				= $lang;
	$parse['bodyid']	= $bodyid;

	//Top Menu
	$parse['forum_url']	= $game_config['forum_url'];
	$parse['game_name']	= $game_config['game_name'];

	//Basics
	$de_planettype =PlanetType($planetrow['image']);
	$parse['type'] = $de_planettype['type'];

	$parse['de_type'] = $de_planettype;
	$parse['de_string'] = $planetrow['image'];
	$parse['user_name'] = $user['username'];
	$parse['skin'] = $user['skin'];
	$parse['dpath'] = $user['dpath'];
	$parse['dpath'] = $dpath;

	//Moon extention
	if($planetrow['planet_type'] == 3)
		$parse['planet_ext'] = '-moon';
	else
		$parse['planet_ext'] = '';

	if($user['authlevel'] > 1){
		$parse['adminlink'] = '<li><a href="./?page=admin">'.$lang['Amdin'].'</a></li>';
	}

	//To get planet sub type (01 to 10) well will remove all except numbers. To remove the leading zeros, times by 1.
	$parse['subtype'] = $de_planettype['subtype'];

	//Messages
	if (strlen($user['messages']) > 0) {
		$messages = explode(",",$user['messages']);
		$mess = 0; foreach ($messages as $c){ $mess += $c; }
		if($mess > 0){
			$parse['showmail'] = 'visible';
			$parse['messages_count'] = pretty_number($mess);
		}else{
			$parse['showmail'] = 'hidden';
		}
	}else{
		$parse['showmail'] = 'hidden';
	}

	//Officers
	for($offi = 601; $offi <= 605; $offi++){
		//echo $user[$resource[$offi]]."-";
		if($user[$resource[$offi]."_exp"] < time()){
			$parse["un".$offi] = "_un";
			$parse["hire".$offi] = "Hire ".$lang['names'][$offi];
		}else{
			$parse["un".$offi] = "";
			//$parse["hire".$offi] = "Expires: ".date($lang['daymonth']."/y H:i",$user[$resource[$offi]."_exp"]);
			$remain = ($user[$resource[$offi]."_exp"] - time());
			if($remain >= 86400){
				$parse["hire".$offi] = $lang['expiresin']." ".floor($remain / 86400)." ".$lang['days'];
			}elseif($remain >= 3600){
				$parse["hire".$offi] = $lang['expiresin']." ".floor($remain / 3600)." ".$lang['hours'];
			}
		}
	}

	//M/C/D/DM
	$parse['metal'] = pretty_number($planetrow['metal'] * 1);
	$parse['crystal'] = pretty_number($planetrow['crystal'] * 1);
	$parse['deut'] = pretty_number($planetrow['deuterium'] * 1);
	$parse['kmetal'] = KMnumber($planetrow['metal'] * 1);
	$parse['kcrystal'] = KMnumber($planetrow['crystal'] * 1);
	$parse['kdeut'] = KMnumber($planetrow['deuterium'] * 1);
	$parse['metal_max'] = pretty_number($planetrow['metal_max'] * 1);
	$parse['crystal_max'] = pretty_number($planetrow['crystal_max'] * 1);
	$parse['deut_max'] = pretty_number($planetrow['deuterium_max'] * 1);

	$parse['energy'] = KMnumber($planetrow['energy_used'] + $planetrow['energy_max']);
	$parse['energy_green'] = " color=\"green\"";
	if($parse['energy'] <= 0){
		$parse['energy_red'] = " color=\"red\"";
		$parse['energy_green'] = " color=\"red\"";
	}
	$parse['energy_used'] = pretty_number(floor($planetrow['energy_used'] * -1));
	$parse['energy_max'] = pretty_number(floor($planetrow['energy_max'] * 1));
	$parse['matter'] = KMnumber(floor($user['matter']) * DARK_MATTER_FACTOR * 1);

	$parse['players'] = USER_RANK;

	$fl_tbl = GetFleetInfo($user,$planet);
	if($fl_tbl){
		$parse['fleet_table'] = $fl_tbl[0];
		$parse['eventboxdisplay'] = 'block';
	}else{
		$parse['eventboxdisplay'] = 'none';
	}
	if($fl_tbl[1] > 0){
		$parse['attack_alert'] = 'visible';
	}else{
		$parse['attack_alert'] = 'hidden';
	}

	$parse['onload'] = $onload;

	$parse['note_show'] = "none";
	$parse['desc_show'] = "none";
	if($_GET['message'] && $_GET['etype']){
		$parse['ncont'] = $_GET['message'];
		$parse['nhead'] = $_GET['title'];
		$parse[$_GET['etype'].'_show'] = "float";

		$parse['go_ok'] = $_GET['to'];
		$parse['go_yes'] = $_GET['ifyes'];
		$parse['go_no'] = $_GET['ifno'];

		//$parse['errorbox'] = parsetemplate(gettemplate('redesigned/errorbox'),$parse);
	}
	$part				 = parsetemplate(gettemplate('redesigned/header'),$parse);
	//echo $part;
	return $part;
}

function displaypage ($page, $title = '', $body = '', $scripts = '') {
	//global $link, $game_config, $debug, $user, $planetrow;	//old
	global $link, $InLogin, $game_config, $debug, $user, $planetrow, $cpage, $pageid, $loadstart;

	if($_GET['page'] != 'admin'){ include(ROOT_PATH . "menu.php"); }
	else{ include(ROOT_PATH . "adminmenu.php"); }
	include(ROOT_PATH . "planetlist.php");

	$Menu = ShowLeftMenu ($cpage);
	$Planets = ShowPlanetList();
	if(defined('IN_ADMIN')){
		$AdminPage = true;
	}
;
	if((!defined("NO_ADS")) && ($game_config['OverviewBanner'] == '1')){
		$ads = $game_config['OverviewClickBanner'];
	}else{
		$ads = '';
	}

	$DisplayPage  = GeneralHead($title);
	$DisplayPage .= NewHeader($pageid);
	$DisplayPage .= $Menu;

	$DisplayPage .= "\n<!--Start axah bit -->\n<div id=\"axah\">\n";
	$DisplayPage .= $page;
	$DisplayPage .= "\n<!--End axah bit -->\n</div>\n";

	// Debug from origional XNova
	if ($user['authlevel'] >= 1) {
		if ($game_config['debug'] == 1) $debug->echo_log();
	}

	//$DisplayPage .= RightMenu();
	$DisplayPage .= $Planets;
	$DisplayPage .= GeneralFoot();

	if (isset($link)) {
		mysql_close();
	}

	die(AddUniToLinks($DisplayPage));
}

function makeAXAH($page/*,$title*/){
	//global $pageid;
	//echo '<a onmouseover="update(\''.$title.'\',\''.$pageid.'\');" href="#">Click me to update</a>';
	die(AddUniToLinks($page));
	//echo '<script language="javascript">window.onload = update(\''.$title.'\',\''.$pageid.'\');</script>';
	//echo '<script language="javascript">update(\''.$title.'\',\''.$pageid.'\');</script>';
}

?>
