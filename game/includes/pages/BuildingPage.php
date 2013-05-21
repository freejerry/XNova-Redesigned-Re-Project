<?php
/*
 * BuildingPage.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova Redesigned
 *
*/

function BuildingPage($a=0,$b=0){
	global $lang, $resource, $reslist, $pricelist, $dpath, $game_config, $_GET, $user, $planetrow;

	CheckPlanetUsedFields ( $planetrow );

	if(!$_GET['page']){ return false; die(); }

	// Tables des batiments possibles par type de planete
	if($_GET['page'] == 'station'){
		$Allowed[1] = array( 14, 15, 21, 31, 33, 34, 44);
		$Allowed[3] = array( 14, 21, 34, 41, 42, 43);
	}elseif($_GET['page'] == 'resources'){
		$Allowed[1] = array(1, 2, 3, 4, 12, 212, 22, 23, 24);
		$Allowed[3] = array(212, 22, 23, 24);
	}else{
		die("Hacking attempt");
	}

	//Right, lets see what he has an generate him an image.
	//resource
	$imgnum = '';
	if($planetrow[$resource[1]] > 0){
		$imgnum .= "_1";
	}
	if($planetrow[$resource[2]] > 0){
		$imgnum .= "_2";
	}
	if($planetrow[$resource[3]] > 0){
		$imgnum .= "_3";
	}
	if($planetrow[$resource[4]] > 0){
		$imgnum .= "_4";
	}
	if($planetrow[$resource[12]] > 0){
		$imgnum .= "_12";
		if($planetrow[$resource[212]] > 0){
			$imgnum .= "_212";
		}
	}
	//buildings
  if($planetrow['planet_type'] == 3){	//if the plane is a moon
    $imgnum1 = '';
    if($planetrow[$resource[41]] > 0){
      $imgnum1 .= "_41";
    }
    if($planetrow[$resource[42]] > 0){
      $imgnum1 .= "_42";
    }
    if($planetrow[$resource[43]] > 0){
      $imgnum1 .= "_43";
    }
	}else{	//the planet is't a moon
    $imgnum1 = '';
    if($planetrow[$resource[14]] > 0){
      $imgnum1 .= "_14";
    }
    if($planetrow[$resource[21]] > 0){
      $imgnum1 .= "_21";
    }
    if($planetrow[$resource[31]] > 0){
      $imgnum1 .= "_31";
    }
    if($planetrow[$resource[34]] > 0){
      $imgnum1 .= "_34";
    }
  }

	// Boucle d'interpretation des eventuelles commandes
	if (isset($_GET['cmd'])) {
		// On passe une commande
		$bThisIsCheated = false;
		$bDoItNow			 = false;
		$TheCommand		 = $_GET['cmd'];
		$Element				= $_GET['building'];
		$ListID				 = $_GET['listid'];
		if ( isset ( $Element )) {
			if ( !strchr ( $Element, " ") ) {
				if ( !strchr ( $Element, ",") ) {
					if (in_array( trim($Element), $Allowed[$planetrow['planet_type']])) {
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
					//Remove last queue item
					RemoveFromQueue();
					break;
				case 'remove':
					//Remove a specific queue item
					RemoveFromQueue($ListID);
					break;
				case 'insert':
					//Insert into the queue a build
					$fields_rem = ($planetrow['field_max'] - $planetrow['field_current']) + ($planetrow[$resource[33]] * 5);
					if($fields_rem >= 0){
						AddToQueue($Element,1);
					}else{
						echo $fields_rem." < 0";
						die("Hacking Attempt!");
					}
					break;
				case 'destroy':
					//Add a deconstrction to the queue
					AddToQueue($Element,-1);
					break;
			} // switch
		} elseif ($bThisIsCheated == true) {
			//ResetThisFuckingCheater ( $user['id'] );
		}

		//If they want axah_section
		if($_GET['axah_box']){
			$q = ShowQueue(false);
			makeAXAH($q['buildlist']);
			die();
		}
	}

	$Queue = ShowQueue(true);

	// On enregistre ce que l'on a modifi� dans planet !
	BuildingSavePlanetRecord ( $planetrow );
	// On enregistre ce que l'on a eventuellement modifi� dans users
	BuildingSaveUserRecord ( $user );

	$max_qs = $formulas['max_building_queue_size'];
	if($max_qs > 0){
		//fine :)
	}else{
		$max_qs = 10;
	}

	if ($Queue['length'] < $max_qs) {
		$CanBuildElement = true;
	} else {
		$CanBuildElement = false;
	}

	if($_GET['page'] == 'station'){
		if($planetrow['planet_type'] == 3)
			$SubTemplate		= gettemplate('buildings/station-moon_buttonz');
		else
			$SubTemplate		= gettemplate('buildings/station_buttonz');
	}elseif($_GET['page'] == 'resources'){
		$SubTemplate		= gettemplate('buildings/resources_buttonz');
	}else{
		die("Hacking attempt");
	}

	$parse				= array();
	$infopg			 = array();
	foreach($lang['names'] as $Element => $ElementName) {
		if (!$planetrow['planet_type']){
			die("no planet type");
		}
		if (in_array($Element, $Allowed[$planetrow['planet_type']]) || ($_GET['page'] == 'station')) {
			if (@in_array($Element, $Allowed[$planetrow['planet_type']])) {
				if(!IsTechnologieAccessible($user, $planetrow, $Element)){
					$parse['state_'.$Element] = "off";
					$parse['mes_'.$Element] = "Requirements are not met";
					$parse['canbuild_'.$Element] = "";
				}elseif(!IsElementBuyable ($user, $planetrow, $Element, true, false) && $Queue['length'] == 0){
					$parse['state_'.$Element] = "disabled";
					$parse['mes_'.$Element] = "Not enough resources!";
					$parse['canbuild_'.$Element] = "";
				}elseif(!$CanBuildElement){
					$parse['state_'.$Element] = "disabled";
					$parse['mes_'.$Element] = "Queue is full!";
					$parse['canbuild_'.$Element] = "";
				}else{
					$parse['state_'.$Element] = "on";
					$parse['mes_'.$Element] = "";
					$parse['canbuild_'.$Element] = "
						<a class=\"fastBuild tips\" href=\"#\" onclick=\"loadpage('./?page=".$_GET['page']."&cmd=insert&building=$Element&id=$Element',document.title,document.body.id);\">
							<img src=\"".GAME_SKIN."/img/layout/sofort_bauen.gif\" height=\"14\" width=\"22\">
						</a>";
				}
			}else{
				$parse['state_'.$Element] = "off";
				$parse['mes_'.$Element] = "Not availble";
				$parse['canbuild_'.$Element] = "";
			}
			$parse['name_'.$Element] = $ElementName;
			$parse['count_'.$Element] = $planetrow[$resource[$Element]];
		}
	}

	//Countdowns
	if ($planetrow['b_building'] > 0) {
		$BuildQueue = explode (";", $planetrow['b_building_id']);
		$CurrBuild = explode (",", $BuildQueue[0]);

		$parse['countdown_'.$CurrBuild[0]] = "
			\t\t\t\t\t\t<div class=\"construction\">\n
			\t\t\t\t\t\t\t<div class=\"pusher\" style=\"height: 80px; margin-bottom: -80px;\">\n
			\t\t\t\t\t\t\t\t<span class=\"time\" id=\"resource\">".parsecountdown($planetrow['b_building'])."</span>\n
			\t\t\t\t\t\t\t</div>\n
			\t\t\t\t\t\t</div>\n";
	}

	$BuildingPage = parsetemplate($SubTemplate, $parse);

	$parse					 = $lang;
	$Element				 = idstring($_GET['id']);
	$ElementName			 = $lang['names'][$Element];

	// Faut il afficher la liste de construction ??
	if ($Queue['length'] > 0) {
		$parse['BuildList']				= $Queue['buildlist'];
	} else {
		$parse['BuildList']				= "";
	}

	$type_array = PlanetType($planetrow['image']);
	$de_planettype = $planetrow['image'];
	$parse['type'] = @$de_planettype['type'];
	if($_GET['page'] == 'station'){
		if($planetrow['planet_type'] == 3)
			if(file_exists(HEADER_CACHE."station/".$parse['type'].'_'.$type_array['subtype'].$imgnum1.".png"))
			$parse['bg'] = HEADER_CACHE."station/".$parse['type'].'_'.$type_array['subtype'].$imgnum1.".png";
			else $parse['bg'] = HEADER_CACHE."station/".$parse['type'].".png";
		else
			if(file_exists(HEADER_CACHE."station/".$parse['type'].$imgnum1.".png"))
			$parse['bg'] = HEADER_CACHE."station/".$parse['type'].$imgnum1.".png";
			else $parse['bg'] = HEADER_CACHE."station/".$parse['type'].".png";
	}elseif($_GET['page'] == 'resources'){
			if(file_exists(HEADER_CACHE."resources/".$parse['type'].$imgnum.".png"))
			$parse['bg'] = HEADER_CACHE."resources/".$parse['type'].$imgnum.".png";
			else $parse['bg'] = HEADER_CACHE."resources/default.png";
	}else{
		die("Hacking attempt");
	}

	$parse['hideres'] = "display:none;";
	$parse['hidenorm'] = "";
	$parse['planetname'] = $planetrow['name'];
	if(!$Element){
		if($_GET['mode'] == "resources"){
			$parse['hideres'] = "";
			$parse['hidenorm'] = "display:none;";
		}
	}else{
		if(!is_array($Allowed[$planetrow['planet_type']])){
			$message = $user['username']." (".intval($user['id']).") does not have a propper planet_type, so \$Allowed[\$planetrow['planet_type']] was not an array, causing the error which is most likely directly below this.";
			trigger_error($message,E_USER_NOTICE);
		}
		if(in_array($Element, $Allowed[$planetrow['planet_type']])) {
			//Something else
			$HaveRessources				= IsElementBuyable ($user, $planetrow, $Element, true, false);
			$HaveRessourcesForDestroy	= IsElementBuyable ($user, $planetrow, $Element, true, true);
			$parse['i']						= $Element;
			$parse['dpath']				= $dpath;
			$BuildingLevel				 = $planetrow[$resource[$Element]];
			$parse['nivel']				= ($BuildingLevel == 0) ? "" : " (". $lang['level'] ." ". $BuildingLevel .")";
			$parse['n']						= $ElementName;
			$parse['descriptions'] = $lang['res']['descriptions'][$Element];
			$ElementBuildTime			= BuildingTime($Element,$BuildingLevel+1,$planetrow);			
			$parse['time']				 = ShowBuildTime($ElementBuildTime);
			$parse['price']				= GetElementPrice($user, $planetrow, $Element);
			$parse['rest_price']	 = GetRestPrice($user, $planetrow, $Element);
			$parse['click']				= '';
			$NextBuildLevel				= $planetrow[$resource[$Element]] + 1;

			$CurrentMaxFields			= CalculateMaxPlanetFields($planetrow);
			if ($planetrow["field_current"] < ($CurrentMaxFields - $Queue['lenght'])) {
				$RoomIsOk = true;
			} else {
				$RoomIsOk = false;
			}

			if ($Element == 31) {
				// Sp�cial Laboratoire
				if ($user["b_tech_planet"] != 0 &&		 // Si pas 0 y a une recherche en cours
					$game_config['BuildLabWhileRun'] != 1) {	// Variable qui contient le parametre
					// On verifie si on a le droit d'evoluer pendant les recherches (Setting dans config)
					$parse['click'] = "<font color=#FF0000>". $lang['in_working'] ."</font>";
				}
			}
			if (IsTechnologieAccessible($user, $planetrow, $Element)) {
				if       ($parse['click'] != '') {
					$infopg['build_link'] = "return false;";
					// Bin on ne fait rien, vu que l'on l'a deja fait au dessus !!
				} elseif ($RoomIsOk && $CanBuildElement) {
					if ($Queue['lenght'] == 0) {
						if ($NextBuildLevel == 1) {
							if ( $HaveRessources == true ) {
								$parse['click'] = "<a href=\"./?page=".$_GET['page']."&cmd=insert&building=".$Element."&id=".$Element."\"><font color=#00FF00>". $lang['BuildFirstLevel'] ."</font></a>";
								$infopg['build_link'] = "loadpage('./?page=".$_GET['page']."&cmd=insert&building=".$Element."&id=".$Element."',document.title,document.body.id);";
								$infopg['build_text'] = $lang['BuildFirstLevel'];
							} else {
								$parse['click'] = "<font color=#FF0000>4". $lang['BuildFirstLevel'] ."</font>";
								$infopg['build_text'] = $lang['BuildFirstLevel'];
								$infopg['build_link'] = "return false;";
							}
						} else {
							if ( $HaveRessources == true ) {
								$parse['click'] = "<a href=\"./?page=".$_GET['page']."&cmd=insert&building=". $Element ."&id=".$Element."\"><font color=#00FF00>". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font></a>";
								$infopg['build_link'] = "loadpage('./?page=".$_GET['page']."&cmd=insert&building=".$Element."&id=".$Element."',document.title,document.body.id);";
								$infopg['build_text'] = $lang['BuildNextLevel'] ." ". $NextBuildLevel;
							} else {
								$parse['click'] = "<font color=#FF0000>". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font>";
								$infopg['build_text'] = $lang['BuildNextLevel'] ." ". $NextBuildLevel;
								$infopg['build_link'] = "return false;";
							}
						}
					} else {
						$parse['click'] = "<a href=\"./?page=".$_GET['page']."&cmd=insert&building=". $Element ."&id=".$Element."\"><font color=#00FF00>". $lang['InBuildQueue'] ."</font></a>";
						$infopg['build_link'] = "loadpage('./?page=".$_GET['page']."&cmd=insert&building=".$Element."&id=".$Element."',document.title,document.body.id);";
						$infopg['build_text'] = $lang['InBuildQueue'];
					}
				} elseif ($RoomIsOk && !$CanBuildElement) {
					if ($NextBuildLevel == 1) {
						$parse['click'] = "<font color=#FF0000>2". $lang['BuildFirstLevel'] ."</font>";
						$infopg['build_text'] = $lang['BuildFirstLevel'];
						$infopg['build_link'] = "return false;";
					} else {
						$parse['click'] = "<font color=#FF0000>1". $lang['BuildNextLevel'] ." ". $NextBuildLevel ."</font>";
						$infopg['build_text'] = $lang['BuildNextLevel'] ." ". $NextBuildLevel;
						$infopg['build_link'] = "return false;";
					}
				} else {
					$parse['click'] = "<font color=#FF0000>". $lang['NoMoreSpace'] ."</font>";
					$infopg['build_text'] = $lang['NoMoreSpace'];
					$infopg['build_link'] = "return false;";
				}
			} else {
				$parse['click'] = "<font color=#FF0000>". $lang['NotAccessible'] ."</font>";
				$infopg['build_text'] = $lang['NotAccessible'];
				$infopg['build_link'] = "return false;";
			}

			//Building Info
			if($infopg['build_link'] != "return false;"){
				$infopg['buildit_class'] = "build-it";
				$infopg['build_text'] = "Improve";
			}else{
				$infopg['buildit_class'] = "build-it_disabled";
				$infopg['build_text'] = "In queue";
			}
			$infopg['id'] = $Element;
			$infopg['name'] = $ElementName;
			$infopg['level'] = $planetrow[$resource[$Element]];
			if($planetrow[$resource[$Element]] < 1){
				$infopg['display_destroy'] = "style=\"display:none;\"";
			}
			if($HaveRessourcesForDestroy == true){
				$infopg['demolish'] = "pic";
				$infopg['title_msg'] = "Tear down";
			}else{
				$infopg['demolish'] = "disabled";
				$infopg['title_msg'] = "Not enough resource!";
			}
			$infopg['td_url'] = "loadpage('./?page=".$_GET['page']."&cmd=destroy&id=".$Element."&building=".$Element."',document.title,document.body.id);";
			$infopg['title'] = "Tear down";

			$infopg['level1'] = $infopg['level'] + 1;
			$infopg['duration'] = pretty_time($ElementBuildTime);
			$infopg['shortdesc'] = $lang['sdesc'][$Element];

			$infopg['skin'] = $user['skin'];

			$infopg['cost_m'] = 1 * floor($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $planetrow[$resource[$Element]]));
			$infopg['cost_c'] = 1 * floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $planetrow[$resource[$Element]]));
			$infopg['cost_d'] = 1 * floor($pricelist[$Element]['deuterium'] * pow($pricelist[$Element]['factor'], $planetrow[$resource[$Element]]));

			if($infopg['cost_m'] > $planetrow['metal'] && $infopg['cost_m'] > 0){
				$infopg['missing_resource_m'] = "missing_resource";
			}
			if($infopg['cost_c'] > $planetrow['crystal'] && $infopg['cost_c'] > 0){
				$infopg['missing_resource_c'] = "missing_resource";
			}
			if($infopg['cost_d'] > $planetrow['deuterium'] && $infopg['cost_d'] > 0){
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

			if($_GET['axah_section'] == '1'){
				makeAXAH($parse['info']);
				die();
			}
		}
	}

	$parse['planet_field_current']	= $planetrow["field_current"];
	$parse['planet_field_max']		= $planetrow['field_max'] + ($planetrow[$resource[33]] * 5);
	$parse['field_libre']			= $parse['planet_field_max'] - $planetrow['field_current'];
	if($_GET['mode'] != 'resources'){
		$parse['buttonz']				= $BuildingPage;
		$parse['BuildingsList']			= $BuildingPage;
	}

	if($_GET['page'] == 'station'){
		$page = parsetemplate(gettemplate('buildings/station'), $parse);
		$title = $lang['Facilities'];
	}elseif($_GET['page'] == 'resources'){
		//Resources screen
		$parse['resources_section'] = BuildRessourcePage ($user,$planetrow,$parse['hideres']);

		$page = parsetemplate(gettemplate('buildings/resources'), $parse);
		$title = $lang['Resources'];
	}else{
		die("Hacking attempt");
	}

	if($_GET['axah']){
		makeAXAH($page);
	}else{
		displaypage($page, $title);
	}
}
// -----------------------------------------------------------------------------------------------------------
// Changelog
// 1.0 File was created to merge Station and Facilities Page.
?>
