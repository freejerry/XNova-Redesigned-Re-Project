<?php

/**
 * ShipyardBuildingPage.php
 *
 * @version 1.0
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */

function ShipyardPage ( &$CurrentPlanet, $CurrentUser, $area ) {
	global $lang, $resource, $phpEx, $dpath, $_GET, $reslist, $pricelist;

	if ($_GET['fmenge'] > 0) {
		// On vient de Cliquer ' Construire '
		// Et y a une liste de dol�ances
		$AddedInQueue                     = false;
		// What an how much are they making?
		$Element = intval(idstring($_GET['fmenge']));
		$Count = intval(idstring($_GET[$Element]));
		if(in_array($Element,$reslist[$area])){
			
			//Check if it exaceeds the max amount we allow them to build in one go (XNova code)
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}

			$InQueue = 0;
			$QueueSize = 0;
			foreach(explode(";",$CurrentPlanet['b_hangar_id']) as $temp){
				if(strlen($temp) > 0){
					$q = explode(",",$temp);
					$QueueSize += $q[1];
					if($q[0] = $Element){
						$InQueue += $q[1];
					}
				}
			}
			
			//If there is a maximum allowed
			if($pricelist[$Element]['max'] > 0){
				if(($Count + $InQueue + $CurrentPlanet[$resource[$Element]]) > $pricelist[$Element]['max']){
					$Count = $pricelist[$Element]['max'] - $CurrentPlanet[$resource[$Element]] - $InQueue;
				}
			}
			
			//And missiles...
			if($Element == 502 || $Element == 503){
				
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
						//echo "". $Element .",". $Count .";";
						$CurrentPlanet['metal']          -= $Ressource['metal'];
						$CurrentPlanet['crystal']        -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']      -= $Ressource['deuterium'];
						$CurrentPlanet['b_hangar_id']    .= "". $Element .",". $Count .";";
					}
				}
			}
		}
		if($QueueSize == 0){
			$CurrentPlanet['b_hangar_lastupdate'] = time();
			$CurrentPlanet['b_hangar'] = 0;
		}
		//now do those changes...
		doquery("UPDATE {{table}} SET `metal` = '".$CurrentPlanet['metal']."', `crystal` = '".$CurrentPlanet['crystal']."', `deuterium` = '".$CurrentPlanet['deuterium']."', `b_hangar_id` = '".$CurrentPlanet['b_hangar_id']."', `b_hangar` = '".$CurrentPlanet['b_hangar']."', `b_hangar_lastupdate` = '".$CurrentPlanet['b_hangar_lastupdate']."' WHERE `id` = '".$CurrentPlanet['id']."' ;",'planets');
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

	if($area == 'fleet'){
		$SubTemplate = gettemplate('buildings/shipyard_buttonz');
		$Template	 = gettemplate('buildings/shipyard');
		$Title		 = $lang['Shipyard'];
	}elseif($area == 'defense'){
		$SubTemplate = gettemplate('buildings/defense_buttonz');
		$Template	 = gettemplate('buildings/defense');
		$Title		 = $lang['Defense'];
	}
	$parse	 = array();
	$infopg	 = array();

	if(!in_array($Element,$reslist[$area]) || $_GET['axah_section'] != '1'){
		foreach($lang['tech'] as $Element => $ElementName) {
			if (in_array($Element,$reslist[$area])) {
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
				$parse['count_'.$Element] = $CurrentPlanet[$resource[$Element]];
	
			}else{
				$parse['state_'.$Element] = "off";
				$parse['mes_'.$Element] = "Not availble";
			}
		}
		
		$Buttonz = parsetemplate($SubTemplate, $parse);
	}

	$parse                 = $lang;
	$Element			   = idstring($_GET['id']);
	$ElementName		   = $lang['tech'][$Element];

	if(in_array($Element,$reslist[$area])){
		if(IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element) && IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false)){
			$infopg['build_link'] = './?page='.$_GET['page'].'&id='.$Element.'&fmenge='.$Element.'&'.$Element.'=';
			//$infopg['build_link'] = '#" onclick="document.forms.shipyard.submit()';
		}

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
		
		if($_GET['axah_section'] == '1'){
			makeAXAH($parse['info']);
			die();
		}
	}

	$parse['buttonz'] = $Buttonz;
	$parse['planetname'] = $CurrentPlanet['name'];

	$page = parsetemplate($Template, $parse);
	
	if($_GET['axah']){
		makeAXAH($page);
	}else{
		displaypage($page, $Title);
	}
}
// Version History
// - 1.0 Created by MadnessRed
?>
