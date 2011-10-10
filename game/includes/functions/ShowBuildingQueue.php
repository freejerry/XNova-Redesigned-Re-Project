<?php

/**
 * ShowBuildingQueue.php
 *
 * @version 1
 * @copyright 2008 by Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------
// Construit le code html pour afficher une liste de construction en cours ...
// Données en entree :
// $CurrentPlanet -> Planete sur la quelle on affiche la page de construction de batiments
// $CurrentUser   -> Joueur courrant (inutilisé pour le moment ... Mais sait on jamais)
// Données en sortie :
// $ListIDRow     -> lignes d'une table de 3 colonnes integrable au dessus (ou au dessous) de la page de
//                   construction des batiments
// Necessite :
// Attention il faut avoir integré une fois au moins le script de controle en java ...
// Donc lancer : InsertBuildListScript () avant la balise <table> de la page
//
function ShowBuildingQueue ( $CurrentPlanet, $CurrentUser, $reloadpage = false ) {
	global $lang;

	$CurrentQueue  = $CurrentPlanet['b_building_id'];
	$QueueID       = 0;
	if ($CurrentQueue != 0) {
		// Queue de fabrication documentée ... Y a au moins 1 element a construire !
		$QueueArray    = explode ( ";", $CurrentQueue );
		// Compte le nombre d'elements
		$ActualCount   = count ( $QueueArray );
	} else {
		// Queue de fabrication vide
		$QueueArray    = "0";
		$ActualCount   = 0;
	}

	$ListIDRow    = "";
	$return = ''; $n = 0;
	$parse = $lang;
	$parse['rest'] = '';
	if($ActualCount > 0){
		$PlanetID     = $CurrentPlanet['id'];
		for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++) {
			// Chaque element de la liste de fabrication est un tableau de 5 données
			// [0] -> Le batiment
			// [1] -> Le niveau du batiment
			// [2] -> La durée de construction
			// [3] -> L'heure théorique de fin de construction
			// [4] -> type d'action
			$BuildArray   = explode (",", $QueueArray[$QueueID]);
			$BuildEndTime = floor($BuildArray[3]);
			$CurrentTime  = floor(time());
			if ($BuildEndTime >= $CurrentTime) {
				
				$n++;
				
				$element = $BuildArray[0];
				$name = $lang['names'][$element];
				$level = $BuildArray[1];
				$mod = $BuildArray[4];
				
				if($reloadpage){
					$parse['remove_link'] = "loadpage('./?page=resources&mode=','".$lang['Resources']."','resources')";
				}else{
					$parse['remove_link'] = "getAXAH('./?page=resources&mode=','resources_queue_box')";
				}
				
				if($n == 1){
					$parse['countdown'] = parsecountdown($BuildEndTime);
					$parse['thislevel'] = pretty_number($level);
					$parse['thisname'] = $name;
					$parse['thisid'] = $element;
				}else{
					$parse['rest'] .= '
							<td>
								<a href="#"
									class="tips" 
									onclick="'.$parse['remove_link'].'"
									onmouseover="mrtooltip(\'Cancel expansion of '.$name.' to level '.$level.'?\');"
									onmouseout="UnTip();">
									<img class="queuePic" src="'.GAME_SKIN.'/img/tiny/tiny_'.$element.'.jpg" height="28" width="28" alt="'.$name.'">
								</a>
								<br>
								<span style="color: lime;">'.$level.'</span>
							</td>';
					
				}
			}
		}
		
		$queue = parsetemplate(gettemplate('buildings/resources_queue'), $parse);
	}

	$RetValue['lenght']    = $ActualCount;
	$RetValue['buildlist'] = $queue;

	return $RetValue;
}

?>
