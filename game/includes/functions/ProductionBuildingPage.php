<?php

/**
 * BatimentBuildingPage.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

function ProductionBuildingPage (&$CurrentPlanet, $CurrentUser) {
	global $lang, $resource, $reslist, $pricelist, $phpEx, $dpath, $game_config, $_GET;

	CheckPlanetUsedFields ( $CurrentPlanet );

	// Tables des batiments possibles par type de planete
	$Allowed['1'] = array(  1,  2,  3,  4, 12,212, 22, 23, 24);
	$Allowed['3'] = array(212, 22, 23, 24);

	//Right, lets see what he has an generate him an image.
	$imgnum = '';
	if($CurrentPlanet[$resource[1]] > 0){
		$imgnum .= "_1";
	}
	if($CurrentPlanet[$resource[2]] > 0){
		$imgnum .= "_2";
	}
	if($CurrentPlanet[$resource[3]] > 0){
		$imgnum .= "_3";
	}
	if($CurrentPlanet[$resource[4]] > 0){
		$imgnum .= "_4";
	}

	// Boucle d'interpretation des eventuelles commandes
	if (isset($_GET['cmd'])) {
		// On passe une commande
		$bThisIsCheated = false;
		$bDoItNow       = false;
		$TheCommand     = $_GET['cmd'];
		$Element        = $_GET['building'];
		$ListID         = $_GET['listid'];
		if       ( isset ( $Element )) {
			if ( !strchr ( $Element, " ") ) {
				if ( !strchr ( $Element, ",") ) {
					if (in_array( trim($Element), $Allowed[$CurrentPlanet['planet_type']])) {
						$bDoItNow = true;
					} else {
						//$bThisIsCheated = true;
						$bDoItNow = true;
					}
				} else {
					$bThisIsCheated = true;
				}
			} else {
				$bThisIsCheated = true;
			}
		} elseif ( isset ( $ListID )) {
			$bDoItNow = true;
		}
		if ($bDoItNow == true) {
			switch($TheCommand){
				case 'cancel':
					// Interrompre le premier batiment de la queue
					CancelBuildingFromQueue ( $CurrentPlanet, $CurrentUser );
					break;
				case 'remove':
					// Supprimer un element de la queue (mais pas le premier)
					// $RemID -> element de la liste a supprimer
					RemoveBuildingFromQueue ( $CurrentPlanet, $CurrentUser, $ListID );
					break;
				case 'insert':
					// Insere un element dans la queue
					$fields_rem = ($CurrentPlanet['field_max'] - $CurrentPlanet['field_current']) + ($CurrentPlanet[$resource[33]] * 5);
					if($fields_rem >= 0){
						AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, true );
					}else{
						echo $fields_rem." < 0";
						die("Hacking Attempt!");
					}
					break;
				case 'destroy':
					// Detruit un batiment deja construit sur la planete !
					AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, false );
					break;
				default:
					break;
			} // switch
		} elseif ($bThisIsCheated == true) {
			ResetThisFuckingCheater ( $CurrentUser['id'] );
		}
	}

	SetNextQueueElementOnTop ( $CurrentPlanet, $CurrentUser );

	$Queue = ShowBuildingQueue ( $CurrentPlanet, $CurrentUser );

	// On enregistre ce que l'on a modifi� dans planet !
	BuildingSavePlanetRecord ( $CurrentPlanet );
	// On enregistre ce que l'on a eventuellement modifi� dans users
	BuildingSaveUserRecord ( $CurrentUser );
	
	$max_qs = MAX_BUILDING_QUEUE_SIZE;
	if($max_qs > 0){
		//fine :)
	}else{
		$max_qs = 10;
	}

	if ($Queue['lenght'] < $max_qs) {
		$CanBuildElement = true;
	} else {
		$CanBuildElement = false;
	}

	$SubTemplate 		= gettemplate('buildings_res_buttonz');
	$parse 				= array();
	$infopg				= array();
	foreach($lang['tech'] as $Element => $ElementName) {
		if (in_array($Element, $Allowed[1])) {
			if (in_array($Element, $Allowed[$CurrentPlanet['planet_type']])) {
				if(!IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)){
					$parse['state_'.$Element] = "off";
					$parse['mes_'.$Element] = "Requirements are not met";
				}elseif(!IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false)){
					$parse['state_'.$Element] = "disabled";
					$parse['mes_'.$Element] = "Not enough resources!";
				}else{
					$parse['state_'.$Element] = "on";
					$parse['mes_'.$Element] = "";
				}
			}else{
				$parse['state_'.$Element] = "off";
				$parse['mes_'.$Element] = "Not availble";
			}
			$parse['name_'.$Element] = $ElementName;
			$parse['count_'.$Element] = $CurrentPlanet[$resource[$Element]];
		}
	}
	$BuildingPage = parsetemplate($SubTemplate, $parse);

	$parse                 = $lang;
	$Element			   = idstring($_GET['id']);
	$ElementName		   = $lang['tech'][$Element];

	// Faut il afficher la liste de construction ??
	if ($Queue['lenght'] > 0) {
		$parse['BuildListScript']  = '';
		//$parse['BuildListScript']  = InsertBuildListScript ( "buildings" );
		$parse['BuildList']        = $Queue['buildlist'];
	} else {
		$parse['BuildListScript']  = "";
		$parse['BuildList']        = "";
	}

	$de_planettype = PlanetType($CurrentPlanet['image']);
	$parse['type'] = $de_planettype['type'];
	$parse['bg'] = GAME_SKIN."/img/header/resources/".$parse['type'].$imgnum.".png";
	

	$parse['hideres'] = "display:none;";
	$parse['hidenorm'] = "";
	if(!$Element){
		$parse['bg'] = GAME_SKIN."/img/header/resources/".$parse['type'].$imgnum.".png";
		if($_GET['mode'] == "resources"){
			$parse['hideres'] = "";
			$parse['hidenorm'] = "display:none;";
			$parse['resources_section'] = BuildRessourcePage ($CurrentUser,$CurrentPlanet);
		}
	}else{
		if (in_array($Element, $Allowed[$CurrentPlanet['planet_type']])) {
			//Something else
			$HaveRessources        = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false);
			$parse['i']            = $Element;
			$parse['dpath']        = $dpath;
			$BuildingLevel         = $CurrentPlanet[$resource[$Element]];
			$parse['nivel']        = ($BuildingLevel == 0) ? "" : " (". $lang['level'] ." ". $BuildingLevel .")";
			$parse['n']            = $ElementName;
			$parse['descriptions'] = $lang['res']['descriptions'][$Element];
			$ElementBuildTime      = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
			$parse['time']         = ShowBuildTime($ElementBuildTime);
			$parse['price']        = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
			$parse['rest_price']   = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
			$parse['click']        = '';
			
			$CurrentMaxFields      = CalculateMaxPlanetFields($CurrentPlanet);
			if ($CurrentPlanet["field_current"] < ($CurrentMaxFields - $Queue['lenght'])) {
				$RoomIsOk = true;
			} else {
				$RoomIsOk = false;
			}
			
			if ($Element == 31) {
				// Sp�cial Laboratoire
				if ($CurrentUser["b_tech_planet"] != 0 &&     // Si pas 0 y a une recherche en cours
					$game_config['BuildLabWhileRun'] != 1) {  // Variable qui contient le parametre
					// On verifie si on a le droit d'evoluer pendant les recherches (Setting dans config)
					$parse['click'] = "<font color=#FF0000>". $lang['in_working'] ."</font>";
				}
			}
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				if       ($parse['click'] != '') {
					// Bin on ne fait rien, vu que l'on l'a deja fait au dessus !!
				} elseif ($RoomIsOk && $CanBuildElement) {
					if ($Queue['lenght'] == 0) {
						if ($NextBuildLevel == 1) {
							if ( $HaveRessources == true ) {
								$parse['click'] = "<a href=\"./?page=resources&cmd=insert&building=".$Element."&id=".$Element."\"><font color=#00FF00>". $lang['BuildFirstLevel'] ."</font></a>";
								$infopg['build_link'] = "./?page=resources&cmd=insert&building=".$Element."&id=".$Element;
								$infopg['build_text'] = $lang['BuildFirstLevel'];
							} else {
								$parse['click'] = "<font color=#FF0000>4". $lang['BuildFirstLevel'] ."</font>";
								$infopg['build_text'] = $lang['BuildFirstLevel'];
							}
						} else {
							if ( $HaveRessources == true ) {
								$parse['click'] = "<a href=\"./?page=resources&cmd=insert&building=". $Element ."&id=".$Element."\"><font color=#00FF00>". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font></a>";
								$infopg['build_link'] = "./?page=resources&cmd=insert&building=".$Element."&id=".$Element;
								$infopg['build_text'] = $lang['BuildNextLevel'] ." ". $NextBuildLevel;
							} else {
								$parse['click'] = "<font color=#FF0000>". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font>";
								$infopg['build_text'] = $lang['BuildNextLevel'] ." ". $NextBuildLevel;
							}
						}
					} else {
						$parse['click'] = "<a href=\"./?page=resources&cmd=insert&building=". $Element ."&id=".$Element."\"><font color=#00FF00>". $lang['InBuildQueue'] ."</font></a>";
						$infopg['build_link'] = "./?page=resources&cmd=insert&building=".$Element."&id=".$Element;
						$infopg['build_text'] = $lang['InBuildQueue'];
					}
				} elseif ($RoomIsOk && !$CanBuildElement) {
					if ($NextBuildLevel == 1) {
						$parse['click'] = "<font color=#FF0000>2". $lang['BuildFirstLevel'] ."</font>";
						$infopg['build_text'] = $lang['BuildFirstLevel'];
					} else {
						$parse['click'] = "<font color=#FF0000>1". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font>";
						$infopg['build_text'] = $lang['BuildNextLevel'] ." ". $NextBuildLevel;
					}
				} else {
					$parse['click'] = "<font color=#FF0000>". $lang['NoMoreSpace'] ."</font>";
					$infopg['build_text'] = $lang['NoMoreSpace'];
				}
			} else {
				$parse['click'] = "<font color=#FF0000>". $lang['NotAccessible'] ."</font>";
				$infopg['build_text'] = $lang['NotAccessible'];
			}
			
			//$parse['bg'] = GAME_SKIN."/img/header/resources/ice.png";	
			$parse['gebaeude_inf'] = "<br /><blockquote style=\"margin-left: 15px; margin-right: 15px; filter:alpha(opacity=75); -moz-opacity:.75; opacity:.75; background-color: #000000;\">
			<div style=\"margin-left: 10px; margin-right: 10px;\">
			<table width=\"100%\"><tr>
				<td width=\"130\"><img src=\"".$dpath."/gebaeude/".$parse['i'].".gif\" width=\"120\" border=\"0\" alt=\"".$parse['n']."\" /></td>
				<td style=\"margin-left: 10px;\">
				<div style=\"text-align: center;\"><!--<a href=\"infos.php?gid=".$parse['i']."\">-->".$parse['n']."<!--</a>--></div>".
				"<div style=\"text-align: left;\">".$parse['nivel']."<br />".
				$parse['descriptions']."<br /><br />".
				$parse['price'].
				$parse['time'].
				$parse['rest_price']."<br /></div>".
				"<div style=\"text-align: right;\">".$parse['click']."</div>
				</td>
			</tr></table>
			</div>
			</blockquote>";
				
			//Building Info
			if($infopg['build_link']){
				$infopg['buildit_class'] = "build-it";
				$infopg['build_text'] = "Improve";
			}else{
				$infopg['buildit_class'] = "build-it_disabled";
				$infopg['build_text'] = "In queue";
			}
			$infopg['id'] = $Element;
			$infopg['name'] = $ElementName;
			$infopg['level'] = $CurrentPlanet[$resource[$Element]];
			if($CurrentPlanet[$resource[$Element]] < 1){
				$infopg['display_destroy'] = "style=\"display:none;\"";
			}			
			$infopg['td_url'] = "./?page=".$_GET['page']."&cmd=destroy&building=".$Element;
			$infopg['title'] = "Tear down";
			
			$infopg['level1'] = $infopg['level'] + 1;
			$infopg['duration'] = pretty_time($ElementBuildTime);
			$infopg['shortdesc'] = $lang['res']['descriptions'][$Element];
			
			$infopg['skin'] = $CurrentUser['skin'];
			
			$infopg['cost_m'] = 1 * floor($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $CurrentPlanet[$resource[$Element]]));
			$infopg['cost_c'] = 1 * floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $CurrentPlanet[$resource[$Element]]));
			$infopg['cost_d'] = 1 * floor($pricelist[$Element]['deuterium'] * pow($pricelist[$Element]['factor'], $CurrentPlanet[$resource[$Element]]));
			
			if($infopg['cost_m'] > $CurrentPlanet['metal'] && $infopg['cost_m'] > 0){
				$infopg['missing_resource_m'] = "missing_resource";
			}
			if($infopg['cost_c'] > $CurrentPlanet['crystal'] && $infopg['cost_c'] > 0){
				$infopg['missing_resource_c'] = "missing_resource";
			}
			if($infopg['cost_d'] > $CurrentPlanet['deuterium'] && $infopg['cost_d'] > 0){
				$infopg['missing_resource_d'] = "missing_resource";
			}
			
			$infopg['sh_cost_m'] = KMnumber($infopg['cost_m'],0,'up');
			$infopg['sh_cost_c'] = KMnumber($infopg['cost_c'],0,'up');
			$infopg['sh_cost_d'] = KMnumber($infopg['cost_d'],0,'up');
			
			$infopg['cost_m'] = pretty_number($infopg['cost_m']);
			$infopg['cost_c'] = pretty_number($infopg['cost_c']);
			$infopg['cost_d'] = pretty_number($infopg['cost_d']);
			
			$infopg['page'] = $_GET['page'];
			$parse['info'] = parsetemplate(gettemplate('buildings/info'), $infopg);
			$parse['extra'] = "style=\"display:none\"";
			
		}
	}
	
    $parse['planet_field_current'] = $CurrentPlanet["field_current"];
    $parse['planet_field_max']     = $CurrentPlanet['field_max'] + ($CurrentPlanet[$resource[33]] * 5);
    $parse['field_libre']          = $parse['planet_field_max']  - $CurrentPlanet['field_current'];

	$parse['buttonz']        = $BuildingPage;

	$page                         .= parsetemplate(gettemplate('buildings/resources'), $parse);

	displaypage($page, $lang['Builds']);
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 Mise en module initiale (creation)
// 1.1 FIX interception cheat +1
// 1.2 FIX interception cheat destruction a -1

?>
