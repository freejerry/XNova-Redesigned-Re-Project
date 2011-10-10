<?php
/**
 * unlocalised.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------------
//
// Routine pour la gestion de flottes a envoyer
//

// Calcul de la distance entre 2 planetes
function GetTargetDistance ($OrigGalaxy, $DestGalaxy, $OrigSystem, $DestSystem, $OrigPlanet, $DestPlanet) {
	$distance = 0;

	if (($OrigGalaxy - $DestGalaxy) != 0) {
		$distance = abs($OrigGalaxy - $DestGalaxy) * 20000;
	} elseif (($OrigSystem - $DestSystem) != 0) {
		$distance = abs($OrigSystem - $DestSystem) * 5 * 19 + 2700;
	} elseif (($OrigPlanet - $DestPlanet) != 0) {
		$distance = abs($OrigPlanet - $DestPlanet) * 5 + 1000;
	} else {
		$distance = 5;
	}

	return $distance;
}

//How long does the mission take?
function GetMissionDuration ($gamespeed, $maxspeed, $dist, $factor){
	$factor *= 10;
	if($gamespeed == 0 || $maxspeed == 0 || $factor == 0){
		ReportError("GetMissionDuration($gamespeed, $maxspeed, $dist, $factor);",'Devision by zero',1);
		$duration = 3600 * 24 * 365;
	}else{
		//duration = 10 + Math.round(((35000 / factor) / gamespeed) * Math.sqrt((dist * 1000) / maxspeed)); //Javascript function
		$duration = 10 + round(((35000 / $factor) / $gamespeed) * sqrt(($dist * 1000) / $maxspeed));
	}

	return $duration;
}

// Retourne la valeur ajustée de vitesse des flottes
function GetGameSpeedFactor () {
	global $game_config;

	return $game_config['fleet_speed'] / 2500;
}

//Get ship speed
function GetShipSpeed($id){
	global $user,$resource,$pricelist;
	
	if($pricelist[$id]['upgrade'] > 0 && $user[$resource[$pricelist[$id]['drive2']]] > $pricelist[$id]['upgrade']){
		//We are using the upgraded engine
		$basespeed = $pricelist[$id]['speed2'];
		$enginelevel = $user[$resource[$pricelist[$id]['drive2']]];
		$enginefactor = $pricelist[$pricelist[$id]['drive2']]['speedfactor'];
	}else{
		//We are using the standard engine
		$basespeed = $pricelist[$id]['speed'];
		$enginelevel = $user[$resource[$pricelist[$id]['drive1']]];
		$enginefactor = $pricelist[$pricelist[$id]['drive1']]['speedfactor'];
	}
	return $basespeed * (1 + ($enginelevel * $enginefactor));
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la vitesse de la flotte par rapport aux technos du joueur
// Avec prise en compte
function GetFleetMaxSpeed ($FleetArray, $Fleet, $Player) {
	global $reslist, $pricelist;

	if ($Fleet != 0) {
		$FleetArray[$Fleet] =  1;
	}
	if(!is_array($FleetArray)){
		ReportError("\$FleetArray is not an array, line 60, unlocalised.php",'Invalid argument supplied for foreach()',1);
	}
	foreach ($FleetArray as $Ship => $Count) {
		
		//Has the ship been upgraded?
		if($pricelist[$Ship]['upgrade'] > 0 && $Player[$resource[$pricelist[$Ship]['drive2']]] > $pricelist[$Ship]['upgrade']){
			//We are using the upgraded engine
			$speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed2'] * $Player[$resource[$pricelist[$Ship]['drive2']]]) * $pricelist[$pricelist[$Ship]['drive2']]['speedfactor']);
		}else{
			//We are using the standard engine
			$speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player[$resource[$pricelist[$Ship]['drive1']]]) * $pricelist[$pricelist[$Ship]['drive1']]['speedfactor']);
		}
		
	}
	if ($Fleet != 0) {
		$ShipSpeed = $speedalls[$Ship];
		$speedalls = $ShipSpeed;
	}

	return $speedalls;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la consommation de base d'un vaisseau au regard des technologies
function GetShipConsumption ( $Ship, $Player ) {
	global $pricelist;
	if ($Player['impulse_motor_tech'] >= 5) {
		$Consumption  = $pricelist[$Ship]['consumption2'];
	} else {
		$Consumption  = $pricelist[$Ship]['consumption'];
	}

	return $Consumption;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la consommation de la flotte pour cette mission
function GetFleetConsumption ($FleetArray, $SpeedFactor, $MissionDuration, $MissionDistance, $FleetMaxSpeed, $Player) {

	$consumption = 0;
	$basicConsumption = 0;
	if(!is_array($FleetArray)){
		ReportError("\$FleetArray is not an array, line 108, unlocalised.php",'Invalid argument supplied for foreach()',1);
	}
	foreach ($FleetArray as $Ship => $Count) {
		if ($Ship > 0) {
			$ShipSpeed         = GetFleetMaxSpeed ( "", $Ship, $Player );
			$ShipConsumption   = GetShipConsumption ( $Ship, $Player );
			$spd               = 35000 / ($MissionDuration * $SpeedFactor - 10) * sqrt( $MissionDistance * 10 / $ShipSpeed );
			$basicConsumption  = $ShipConsumption * $Count;
			$consumption      += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
		}
	}

	$consumption = round($consumption) + 1;

	return $consumption;
}

function GetFleetFuelReq ($factor,$fuel,$dist){
	$factor *= 10;
	//fuel_used = 1 + Math.round(fuel * ((dist / 1000) / 35) * (factor / 100 + 1) * (factor / 100 + 1)); //javascript function
	$consumption = 1 + round($fuel * (($dist / 1000) / 35) * ($factor / 100 + 1) * ($factor / 100 + 1));
	//Return consumption
	return $consumption;
}

// ----------------------------------------------------------------------------------------------------------------
//
// Mise en forme de chaines pour affichage
//

// Mise en forme de la durée sous forme xj xxh xxm xxs
function pretty_time ($seconds,$leadingzeros = false) {
	$z = $leadingzeros;
	$wk = floor($seconds / (24 * 3600 * 7));
	$day = floor(($seconds / (24 * 3600)) % 7);
	$hs = floor($seconds / 3600 % 24);
	$ms = floor($seconds / 60 % 60);
	$sr = floor($seconds / 1 % 60);

	if (($hs < 10) && $z) { $hh = "0" . $hs; } else { $hh = $hs; }
	if (($ms < 10) && $z) { $mm = "0" . $ms; } else { $mm = $ms; }
	if (($sr < 10) && $z) { $ss = "0" . $sr; } else { $ss = $sr; }

	$time = '';
	if ($wk != 0) { $time .= $wk . 'w '; }
	if ($day != 0) { $time .= $day . 'd '; }
	if ($hs  != 0) { $time .= $hh . 'h ';  }
	if ($ms  != 0) { $time .= $mm . 'm ';  }
	$time .= $ss . 's';

	return $time;
}

// Mise en forme de la durée sous forme xxxmin
function pretty_time_hour ($seconds) {
	$min = floor($seconds / 60 % 60);

	$time = '';
	if ($min != 0) { $time .= $min . 'min '; }

	return $time;
}

// Mise en forme du temps de construction (avec la phrase de description)
function ShowBuildTime ($time) {
	global $lang;

	return "<br>". $lang['ConstructionTime'] .": " . pretty_time($time);
}


// ----------------------------------------------------------------------------------------------------------------
//
// Fonction de lecture / ecriture / exploitation de templates
//
function ReadFromFile($filename) {
	$content = @file_get_contents ($filename);
	return $content;
}

function SaveToFile ($filename, $content) {
	$content = @file_put_contents ($filename, $content);
}

function gettemplate ($templatename) {
	global $xnova_root_path;

	$filename = $xnova_root_path . TEMPLATE_DIR . TEMPLATE_NAME . '/' . $templatename . ".tpl";

	return ReadFromFile($filename);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Gestion de la localisation des chaines
//
function includeLang ($filename, $en = 'false', $ext = '.mo') {
	global $xnova_root_path, $lang, $user;
	if($en){
		$SelLanguage = "en";
	}else{
		if ($user['lang'] != '') {
			$SelLanguage = $user['lang'];
		} else {
			$SelLanguage = DEFAULT_LANG;
		}
	}
	if($filename == 'changelog'){
		echo nl2br(print_r(debug_backtrace(),true));
	}
	@include ($xnova_root_path . "language/". $SelLanguage ."/". $filename.$ext);
}

function getLang ($filename, $uselang = 'user', $default = false, $ext = '.mo') {
	global $lang, $user, $basedlang;
	
	if($uselang != 'user'){
		$user['lang'] = cleanstring($uselang);
	}
	
	if($default){$SelLanguage = DEFAULT_LANG;}
	else{
		if ($user['lang'] != '') {$SelLanguage = $user['lang'];}
		else {$SelLanguage = DEFAULT_LANG;}
	}
	
	//Include the default language, now we at least have all the strings
	include (ROOT_PATH."lang/".DEFAULT_LANG."/".$filename.$ext);
	
	//Include the based off language, eg for lang us, we want the english files.
	if($basedlang[$SelLanguage] != DEFAULT_LANG){
		if(file_exists(ROOT_PATH."lang/".$basedlang[$SelLanguage]."/".$filename.$ext)){
			include (ROOT_PATH."lang/".$basedlang[$SelLanguage]."/".$filename.$ext);
		}
	}
	
	//Now include the main language.
	if($SelLanguage != DEFAULT_LANG){
		if(file_exists(ROOT_PATH."lang/".$SelLanguage."/".$filename.$ext)){
			include (ROOT_PATH."lang/".$SelLanguage."/".$filename.$ext);
		}
	}
	
	//Now debug
//	$lang = array();
}


// ----------------------------------------------------------------------------------------------------------------
//
// Affiche une adresse de depart sous forme de lien
function GetStartAdressLink ( $FleetRow, $FleetType ) {
	$Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$FleetRow['fleet_start_galaxy']."&system=".$FleetRow['fleet_start_system']."\" ". $FleetType ." >";
	$Link .= "[".$FleetRow['fleet_start_galaxy'].":".$FleetRow['fleet_start_system'].":".$FleetRow['fleet_start_planet']."]</a>";
	return $Link;
}

// Affiche une adresse de cible sous forme de lien
function GetTargetAdressLink ( $FleetRow, $FleetType ) {
	$Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$FleetRow['fleet_end_galaxy']."&system=".$FleetRow['fleet_end_system']."\" ". $FleetType ." >";
	$Link .= "[".$FleetRow['fleet_end_galaxy'].":".$FleetRow['fleet_end_system'].":".$FleetRow['fleet_end_planet']."]</a>";
	return $Link;
}

// Affiche une adresse de planete sous forme de lien
function BuildPlanetAdressLink ( $CurrentPlanet ) {
	$Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$CurrentPlanet['galaxy']."&system=".$CurrentPlanet['system']."\">";
	$Link .= "[".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."]</a>";
	return $Link;
}

// Création d'un lien pour le joueur hostile
function BuildHostileFleetPlayerLink ( $FleetRow ) {
	global $lang, $dpath;

	$PlayerName = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '". $FleetRow['fleet_owner']."';", 'users', true);
	$Link  = $PlayerName['username']. " ";
	$Link .= "<a href=\"messages.php?mode=write&id=".$FleetRow['fleet_owner']."\">";
	$Link .= "<img src=\"".$dpath."/img/m.gif\" alt=\"". $lang['ov_message']."\" title=\"". $lang['ov_message']."\" border=\"0\"></a>";
	return $Link;
}

function GetNextJumpWaitTime ( $CurMoon ) {
	global $resource;

	$JumpGateLevel  = $CurMoon[$resource[43]];
	$LastJumpTime   = $CurMoon['last_jump_time'];
	if ($JumpGateLevel > 0) {
		$WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
		$NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;
		if ($NextJumpTime >= time()) {
			$RestWait   = $NextJumpTime - time();
			$RestString = " ". pretty_time($RestWait);
		} else {
			$RestWait   = 0;
			$RestString = "";
		}
	} else {
		$RestWait   = 0;
		$RestString = "";
	}
	$RetValue['string'] = $RestString;
	$RetValue['value']  = $RestWait;

	return $RetValue;
}
// ----------------------------------------------------------------------------------------------------------------
//
// Céation du lien avec popup pour la flotte
function CreateFleetPopupedFleetLink ( $FleetRow, $Texte, $FleetType ) {
	global $lang;

	$FleetRec     = explode(";", $FleetRow['fleet_array']);
	$FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
	$FleetPopup  .= "<table width=200>";
	foreach($FleetRec as $Item => $Group) {
		if ($Group  != '') {
			$Ship    = explode(",", $Group);
			$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
		}
	}
	$FleetPopup  .= "</table>";
	$FleetPopup  .= "');\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">". $Texte ."</a>";

	return $FleetPopup;

}

// ----------------------------------------------------------------------------------------------------------------
//
// Céation du lien avec popup pour le type de mission avec ou non les ressources si disponibles
function CreateFleetPopupedMissionLink ( $FleetRow, $Texte, $FleetType ) {
	global $lang;

	$FleetTotalC  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
	if ($FleetTotalC <> 0) {
		$FRessource   = "<table width=200>";
		$FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Metal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_metal']) ."<font></td></tr>";
		$FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Crystal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_crystal']) ."<font></td></tr>";
		$FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Deuterium'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_deuterium']) ."<font></td></tr>";
		$FRessource  .= "</table>";
	} else {
		$FRessource   = "";
	}

	if ($FRessource <> "") {
		$MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
		$MissionPopup .= "\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">" . $Texte ."</a>";
	} else {
		$MissionPopup  = $Texte ."";
	}

	return $MissionPopup;
}

// ----------------------------------------------------------------------------------------------------------------
//
// Roman numerals in FAQ

    function romanNumber($Num) {

       $N = intval($Num);
       $Result = '';

       $Array = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
       'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
       'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

       foreach ($Array as $Roman => $Number)
       {
          $Match = intval($N / $Number);

          $Result .= str_repeat($Roman, $Match);

          $N = $N % $Number;
       }

       return $Result;

    }

// ----------------------------------------------------------------------------------------------------------------



?>
