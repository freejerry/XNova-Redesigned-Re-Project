<?php

/**
 * GetBuildingTime
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

// Calcul du temps de construction d'un Element (Batiment / Recherche / Defense / Vaisseau )
// $user       -> Le Joueur lui meme
// $planet     -> La planete sur laquelle l'Element doit etre construit
// $Element    -> L'Element que l'on convoite
function GetBuildingTime ($user, $planet, $Element, $destroy = false) {
	global $pricelist, $resource, $reslist, $game_config;

	//Get the cost
	$cost = GetBuildingPrice ($user,$planet,$Element,true,$destroy,false);
	$cost = $cost['metal'] + $cost['crystal'];
	
	if(in_array($Element, $reslist['build'])){
		// For buildings
		$time         = ($cost / $game_config['game_speed']) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5, $planet[$resource['15']]);
		$time         = floor($time * 60 * 60);
	
	//Else if its a research
	}elseif(in_array($Element, $reslist['tech'])) {
		// For research		
		
		//Intergalactic Research Network
		$lablevel = $planet[$resource['31']];
		
		//If we have IRN
		if($user[$resource[123]] > 0){
			$empire = doquery("SELECT `".$resource['31']."` FROM {{table}} WHERE `id_owner` ='". $user['id'] ."' AND `id` <>'". $user['current_planet'] ."' ORDER BY `".$resource['31']."` DESC LIMIT 0 , ". $user[$resource[123]] ." ;", 'planets');
			//Loop through colonies
			while ($colonie = mysql_fetch_array($empire)) {
				//Add there lab level to combined lab level
				$lablevel += $colonie[$resource['31']];
			}
		}
		//IRN
		
		$time         = ($cost / $game_config['game_speed']) / (($lablevel + 1) * 2);
		$time         = floor($time * 60 * 60);
	} elseif (in_array($Element, $reslist['defense']) || in_array($Element, $reslist['fleet'])) {
		// For shipyard / defense
		$time         = ($cost / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
		$time         = floor($time * 60 * 60);
	}


	return $time;
}

?>