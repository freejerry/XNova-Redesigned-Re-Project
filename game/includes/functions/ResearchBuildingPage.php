<?php

/**
 * ResearchBuildingPage.php
 *
 * @version 1.2
 * @copyright 2008 by Chlorel for XNova
 */

// Page de Construction de niveau de Recherche
// $CurrentPlanet -> Planete sur laquelle la construction est lancée
//                   Parametre passé par adresse, cela permet de mettre les valeurs a jours
//                   dans le programme appelant
// $CurrentUser   -> Utilisateur qui a lancé la construction
// $InResearch    -> Indicateur qu'il y a une Recherche en cours
// $ThePlanet     -> Planete sur laquelle se realise la technologie eventuellement
function ResearchBuildingPage (&$CurrentPlanet, $CurrentUser, $InResearch, $ThePlanet) {
	global $lang, $resource, $reslist, $pricelist, $phpEx, $dpath, $game_config, $_GET;

	CheckPlanetUsedFields ( $CurrentPlanet );

	// Boucle d'interpretation des eventuelles commandes
	if (isset($_GET['cmd'])) {
		$TheCommand = $_GET['cmd'];
		$Techno     = idstring($_GET['tech']);
		if ( is_numeric($Techno) ) {
			if ( in_array($Techno, $reslist['tech']) ) {
				// Bon quand on arrive ici ... On sait deja qu'on a une technologie valide
				if ( is_array ($ThePlanet) ) {
					$WorkingPlanet = $ThePlanet;
				} else {
					$WorkingPlanet = $CurrentPlanet;
				}
				switch($TheCommand){
					case 'cancel':
						if ($ThePlanet['b_tech_id'] == $Techno) {
							$costs                        = GetBuildingPrice($CurrentUser, $WorkingPlanet, $Techno);
							$WorkingPlanet['metal']      += $costs['metal'];
							$WorkingPlanet['crystal']    += $costs['crystal'];
							$WorkingPlanet['deuterium']  += $costs['deuterium'];
							$WorkingPlanet['b_tech_id']   = 0;
							$WorkingPlanet["b_tech"]      = 0;
							$CurrentUser['b_tech_planet'] = 0;
							$UpdateData                   = true;
							$InResearch                   = false;
						}
						break;
					case 'search':
						if ( IsTechnologieAccessible($CurrentUser, $WorkingPlanet, $Techno) &&
							 IsElementBuyable($CurrentUser, $WorkingPlanet, $Techno) ) {
							$costs                        = GetBuildingPrice($CurrentUser, $WorkingPlanet, $Techno);
							$WorkingPlanet['metal']      -= $costs['metal'];
							$WorkingPlanet['crystal']    -= $costs['crystal'];
							$WorkingPlanet['deuterium']  -= $costs['deuterium'];
							$WorkingPlanet["b_tech_id"]   = $Techno;
							$WorkingPlanet["b_tech"]      = time() + GetBuildingTime($CurrentUser, $WorkingPlanet, $Techno);
							$CurrentUser["b_tech_planet"] = $WorkingPlanet["id"];
							$UpdateData                   = true;
							$InResearch                   = true;
						}
						break;
				}
				if ($UpdateData == true) {
					$QryUpdatePlanet  = "UPDATE {{table}} SET ";
					$QryUpdatePlanet .= "`b_tech_id` = '".   $WorkingPlanet['b_tech_id']   ."', ";
					$QryUpdatePlanet .= "`b_tech` = '".      $WorkingPlanet['b_tech']      ."', ";
					$QryUpdatePlanet .= "`metal` = '".       $WorkingPlanet['metal']       ."', ";
					$QryUpdatePlanet .= "`crystal` = '".     $WorkingPlanet['crystal']     ."', ";
					$QryUpdatePlanet .= "`deuterium` = '".   $WorkingPlanet['deuterium']   ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '".          $WorkingPlanet['id']          ."';";
					doquery( $QryUpdatePlanet, 'planets');

					$QryUpdateUser  = "UPDATE {{table}} SET ";
					$QryUpdateUser .= "`b_tech_planet` = '". $CurrentUser['b_tech_planet'] ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '".            $CurrentUser['id']            ."';";
					doquery( $QryUpdateUser, 'users');
				}
				if ( is_array ($ThePlanet) ) {
					$ThePlanet     = $WorkingPlanet;
				} else {
					$CurrentPlanet = $WorkingPlanet;
					if ($TheCommand == 'search') {
						$ThePlanet = $CurrentPlanet;
					}
				}
			}
		} else {
			$bContinue = false;
		}
	}
	
	$TechScrTPL = gettemplate('buildings_research_script');
	
	$SubTemplate 		= gettemplate('buildings/research_buttonz');
	$parse 				= array();
	$infopg				= array();

	foreach($lang['tech'] as $Tech => $TechName) {
		if ($Tech > 105 && $Tech <= 199) {
			if(!IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Tech)) {
				$parse['state_'.$Tech] = "off";
				$parse['mes_'.$Tech] = "Requirements are not met";
			}elseif(!IsElementBuyable ($CurrentUser, $CurrentPlanet, $Tech)){
				$parse['state_'.$Tech] = "disabled";
				$parse['mes_'.$Tech] = "Not enough resources!";
			}else{
				$parse['state_'.$Tech] = "on";
				$parse['mes_'.$Tech] = "";
			}
		}else{
			$parse['state_'.$Tech] = "off";
			$parse['mes_'.$Tech] = "Not availble";
		}
		$parse['name_'.$Tech] = $TechName;
		$parse['count_'.$Tech] = $CurrentUser[$resource[$Tech]];
	}
	
	$Buttonz = parsetemplate($SubTemplate, $parse);

	$parse                 = $lang;
	$Element			   = idstring($_GET['id']);
	$ElementName		   = $lang['tech'][$Element];

	
	$de_planettype = PlanetType($CurrentPlanet['image']);
	$parse['type'] = $de_planettype['type'];
	
	if($Element){
		if (in_array($Element, $reslist['tech']) ) {
			/*
			$RowParse['dpath']       = $dpath;
			$RowParse['tech_id']     = $Tech;
			$building_level          = $CurrentUser[$resource[$Tech]];
			$RowParse['tech_level']  = ($building_level == 0) ? "" : "( ". $lang['level']. " ".$building_level." )";
			$RowParse['tech_name']   = $TechName;
			$RowParse['tech_descr']  = $lang['res']['descriptions'][$Tech];
			$RowParse['tech_price']  = GetElementPrice($CurrentUser, $CurrentPlanet, $Tech);
			$SearchTime              = GetBuildingTime($CurrentUser, $CurrentPlanet, $Tech);
			$RowParse['search_time'] = ShowBuildTime($SearchTime);
			$RowParse['tech_restp']  = $lang['Rest_ress'] ." ". GetRestPrice ($CurrentUser, $CurrentPlanet, $Tech, true);
			$CanBeDone               = IsElementBuyable($CurrentUser, $CurrentPlanet, $Tech);
			*/
			
			
			$HaveRessources        = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element);
			$parse['i']            = $Element;
			$BuildingLevel         = $CurrentPlanet[$resource[$Element]];
			$parse['nivel']        = ($BuildingLevel == 0) ? "" : " (". $lang['level'] ." ". $BuildingLevel .")";
			$parse['n']            = $ElementName;
			$parse['descriptions'] = $lang['res']['descriptions'][$Element];
			$ElementBuildTime      = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
			$parse['time']         = ShowBuildTime($ElementBuildTime);
			$parse['price']        = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
			$parse['rest_price']   = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
			$parse['click']        = '';
			

			$buildlink = "./?page=research&cmd=search&id=".$Element."&tech=".$Element;
			
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				if ($NextBuildLevel == 1) {
					if ( $HaveRessources == true ) {
						$infopg['build_link'] = $buildlink;
						$infopg['build_text'] = $lang['BuildFirstLevel'];
					} else {
						$infopg['build_text'] = $lang['BuildFirstLevel'];
					}
				} else {
					if ( $HaveRessources == true ) {
						$infopg['build_link'] = $buildlink;
						$infopg['build_text'] = $lang['BuildNextLevel'] ." ". $NextBuildLevel;
					} else {
						$infopg['build_text'] = $lang['BuildNextLevel'] ." ". $NextBuildLevel;
					}
				}
			} else {
				$parse['click'] = "<font color=#FF0000>". $lang['NotAccessible'] ."</font>";
				$infopg['build_text'] = $lang['NotAccessible'];
			}
			

				
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
			$infopg['level'] = $CurrentUser[$resource[$Element]];
			
			if($CurrentUser['b_tech_planet']){
				$WorkingPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $CurrentUser['b_tech_planet'] ."';", 'planets', true);
				if($WorkingPlanet['b_tech_id'] = $Element){
					$infopg['td_url'] = "./?page=".$_GET['page']."&cmd=cancel&id=".$Element."&tech=".$Element;
					if($WorkingPlanet == $CurrentPlanet){
						$infopg['title'] = "Cancel";
					}else{
						$infopg['title'] = "Cancel on ".$WorkingPlanet['name'];
						$infopg['title'] = "Cancel";
					}
				}else{
					$infopg['display_destroy'] = "style=\"display:none;\"";
				}
			}else{
				$infopg['display_destroy'] = "style=\"display:none;\"";
			}
			$infopg['level1'] = $infopg['level'] + 1;
			$infopg['duration'] = pretty_time($ElementBuildTime);
			$infopg['shortdesc'] = $lang['res']['descriptions'][$Element];
			
			$infopg['skin'] = $CurrentUser['skin'];
			
			$infopg['cost_m'] = 1 * floor($pricelist[$Element]['metal'] * pow($pricelist[$Element]['factor'], $CurrentUser[$resource[$Element]]));
			$infopg['cost_c'] = 1 * floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $CurrentUser[$resource[$Element]]));
			$infopg['cost_d'] = 1 * floor($pricelist[$Element]['deuterium'] * pow($pricelist[$Element]['factor'], $CurrentUser[$resource[$Element]]));
			
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
	
	$parse['buttonz']        = $Buttonz;
	
	$page                         .= parsetemplate(gettemplate('buildings/research'), $parse);

	displaypage($page, $lang['Builds']);
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 Mise en module initiale (creation)
// 1.1 FIX interception cheat +1
// 1.2 FIX interception cheat destruction a -1

?>