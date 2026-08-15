<?php

/**
 * FleetBuildingPage.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */

// Page de Construction d'Elements de Flotte
// $CurrentPlanet -> Planete sur laquelle la construction est lancée
//                   Parametre passé par adresse, cela permet de mettre les valeurs a jours
//                   dans le programme appelant
// $CurrentUser   -> Utilisateur qui a lancé la construction
//
function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $phpEx, $dpath, $_POST, $reslist, $pricelist;
 	
 	echo "["; print_r($_POST); echo "]";

	if (isset($_POST['fmenge'])) {
		// On vient de Cliquer ' Construire '
		// Et y a une liste de dol�ances
		$AddedInQueue                     = false;
		// Ici, on sait precisement ce qu'on aimerait bien construire ...
		foreach($_POST as $Element => $Count) {
			$Element = idstring($Element);
			if(in_array($Element,$reslist['fleet'])){
			
				$Element = intval($Element);
				$Count   = intval($Count);
				if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
					$Count = MAX_FLEET_OR_DEFS_PER_ROW;
				}
	
				if ($Count > 0) {
					// On verifie si on a les technologies necessaires a la construction de l'element
					if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {
						// On verifie combien on sait faire de cet element au max
						$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );
						// Si pas assez de ressources, on ajuste le nombre d'elements
						if ($Count > $MaxElements) {
							$Count = $MaxElements;
						}
						$Ressource = GetElementRessources ( $Element, $Count );
						$BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
						if ($Count >= 1) {
							$CurrentPlanet['metal']          -= $Ressource['metal'];
							$CurrentPlanet['crystal']        -= $Ressource['crystal'];
							$CurrentPlanet['deuterium']      -= $Ressource['deuterium'];
							$CurrentPlanet['b_hangar_id']    .= "". $Element .",". $Count .";";
						}
					}
				}
			}
		}
	}

	// -------------------------------------------------------------------------------------------------------
	// S'il n'y a pas de Chantier ...
	if ($CurrentPlanet[$resource[21]] == 0) {
		$shipyard = false;
	}else{
		$shipyard = true;
	}

	// -------------------------------------------------------------------------------------------------------
	// Now for the building part.
	$TabIndex = 0;

	$SubTemplate 		= gettemplate('buildings/shipyard_buttonz');
	$parse 				= array();
	$infopg				= array();
	
	foreach($lang['tech'] as $Element => $ElementName) {
		if (in_array($Element,$reslist['fleet'])) {
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
			
			$parse['name_'.$Element] = $ElementName;
			$parse['count_'.$Element] = KMnumber($CurrentPlanet[$resource[$Element]]);

		}else{
			$parse['state_'.$Element] = "off";
			$parse['mes_'.$Element] = "Not availble";
		}
	}
	
	$Buttonz = parsetemplate($SubTemplate, $parse);

	$parse                 = $lang;
	$Element			   = idstring($_GET['id']);
	$ElementName		   = $lang['tech'][$Element];
	
	if(!$Element){
		$parse['bg'] = "../img/headerCache/station/".$parse['type'].".png";
	}else{
			if(IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element) && IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false)){
				$infopg['build_link'] = '#" onclick="Javascript: document.getElementById(\'shipyard\').submit()';
			}
			die("!!!!!!!!!!!!!");
			//Building Info
			if($infopg['build_link']){
				$infopg['buildit_class'] = "build-it";
				$infopg['build_text'] = "Build";
			}else{
				$infopg['buildit_class'] = "build-it_disabled";
				$infopg['build_text'] = "Build";
			}
			$infopg['id'] = $Element;
			$infopg['name'] = $ElementName;
			$infopg['level'] = $CurrentPlanet[$resource[$Element]];
			if($CurrentPlanet[$resource[$Element]] < 1){
				$infopg['display_destroy'] = "style=\"display:none;\"";
			}
			$infopg['td_url'] = "./?page=".$_GET['page']."&cmd=destroy&id=".$Element."&building=".$Element;
			$infopg['title'] = "Tear down";
			
			$infopg['level1'] = $infopg['level'] + 1;
			$infopg['duration'] = pretty_time(GetBuildingTime($CurrentUser, $CurrentPlanet, $Element));
			$infopg['shortdesc'] = $lang['res']['descriptions'][$Element];
			
			$infopg['skin'] = $CurrentUser['skin'];
			
			$infopg['cost_m'] = $pricelist[$Element]['metal'];
			$infopg['cost_c'] = $pricelist[$Element]['crystal'];
			$infopg['cost_d'] = $pricelist[$Element]['deuterium'];
			
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
			$parse['info'] = parsetemplate(gettemplate('buildings/sy_info'), $infopg);
			$parse['extra'] = "style=\"display:none\"";
	}
	
	$parse['buttonz']        = $Buttonz;
	
	$page = parsetemplate(gettemplate('buildings/shipyard'), $parse);
	displaypage($page, $lang['Fleet']);
}
// Version History
// - 1.0 Modularisation
// - 1.1 Correction mise en place d'une limite max d'elements constructibles par ligne
//
?>