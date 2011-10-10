<?php

/**
 * ProductionRates.php
 *
 * @version 1.1
 * @copyright 2008 By MadnessRed for XNova Redesigned
 */

function ProductionRates ($CurrentUser,$CurrentPlanet,$basic=false) {
	global $ProdGrid, $resource, $resources, $reslist, $game_config;

	$Caps = array();
	
	foreach($reslist['prod'] as $ProdID){
		$BuildTemp = $CurrentPlanet['temp_max'];
		$BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
		$BuildLevel	   = $CurrentPlanet[ $resource[$ProdID] ];
		
		$Caps['metal_perhour']				 +=  floor(eval($ProdGrid[$ProdID]['formule']['metal']	) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[604]]  * 0.1)));
		$Caps['crystal_perhour']			 +=  floor(eval($ProdGrid[$ProdID]['formule']['crystal']  ) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[604]]  * 0.1)));
		$Caps['deuterium_perhour']			 +=  floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[604]]  * 0.1)));
		
		$Caps[$ProdID]['metal_perhour']		  =  floor(eval($ProdGrid[$ProdID]['formule']['metal']	) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[604]]  * 0.1)));
		$Caps[$ProdID]['crystal_perhour']	  =  floor(eval($ProdGrid[$ProdID]['formule']['crystal']  ) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[604]]  * 0.1)));
		$Caps[$ProdID]['deuterium_perhour']	  =  floor(eval($ProdGrid[$ProdID]['formule']['deuterium']) * ($game_config['resource_multiplier']) * (1 + ( $CurrentUser[$resource[604]]  * 0.1)));
		
		$Energy								  =  floor(eval($ProdGrid[$ProdID]['formule']['energy']   ) * ($game_config['resource_multiplier']));
		
		if($Energy < 0){
			$Caps['energy_used']			 += $Energy;
			$Caps[$ProdID]['energy_used']	  = $Energy;
		}elseif($Energy > 0){
			$Caps['energy_max']				 +=  floor($Energy * (1 + ($CurrentUser[$resource[603]] * 0.1)));
			$Caps[$ProdID]['energy_max']	  =  floor($Energy * (1 + ($CurrentUser[$resource[603]] * 0.1)));
		}
	}	
	
	/*
	echo "<pre>";
	print_r($Caps);
	echo "</pre>";
	*/
	
	if($basic){
		return $Caps;
	}else{
	
		//What effects resource production?
		//1 - Planet - No income on moons.
		//2 - Storage full - Mines shut down - Still base income though???
		//3 - Production factor - Production is at porduction factor % - Basine income unefected.
		//4 - Vacation mode - Base income only
		
		// 1 - There is no production on the moon
		if($CurrentPlanet['planet_type'] == 3){
			$game_config['metal_basic_income']		 = 0;
			$game_config['crystal_basic_income']	 = 0;
			$game_config['deuterium_basic_income']	 = 0;
			
			$Caps['metal_perhour']		 = 0;
			$Caps['crystal_perhour']	 = 0;
			$Caps['deuterium_perhour']	 = 0;
			$Caps['energy_used']		 = 0;
			$Caps['energy_max']			 = 0;
		}
		
		//2 Check storage
		$Caps['metal_max']	 = BASE_STORAGE_SIZE + ((BASE_STORAGE_SIZE / 2) * floor(pow(1.6,$CurrentPlanet[$resource[22]])));
		$Caps['crystal_max']   = BASE_STORAGE_SIZE + ((BASE_STORAGE_SIZE / 2) * floor(pow(1.6,$CurrentPlanet[$resource[23]])));
		$Caps['deuterium_max'] = BASE_STORAGE_SIZE + ((BASE_STORAGE_SIZE / 2) * floor(pow(1.6,$CurrentPlanet[$resource[24]])));
		foreach ($resources as $res){
			if($CurrentPlanet[$res] >= ($Caps[$res.'_max'] * MAX_OVERFLOW)){
				//$Caps[$res.'_perhour'] = 0;
				//$game_config[$res.'_basic_income'] = 0;
				$Caps[$res.'_perhour'] = $game_config[$res.'_basic_income'];
				foreach($reslist['prod'] as $ProdID){
					if($Caps[$ProdID][$res.'_perhour'] > 0){
						$Caps[$ProdID][$res.'_perhour'] = 0;
						$Caps['energy_used'] -= $Caps[$ProdID]['energy_used'];
						$Caps[$ProdID]['energy_used'] = 0;
					}
				}
			}
		}
		
		//3 - Production Factor.
		if((0-$Caps['energy_used']) > 0){
			$production_level = ($Caps['energy_max'] / (0-$Caps['energy_used']));
		}else{
			$production_level = 1;
		}
		if($production_level > 1){ $production_level = 1; }
		$Caps['production_factor'] = floor($production_level * 100);
		foreach ($resources as $res){
			$Caps[$res.'_perhour']		 = $Caps[$res.'_perhour'] * $production_level;
			foreach($reslist['prod'] as $ProdID){
				//echo $ProdID." = ".$Caps[$ProdID][$res.'_perhour']." * ".$production_level."<br />";
				$Caps[$ProdID][$res.'_perhour'] = $Caps[$ProdID][$res.'_perhour'] * $production_level;
			}
		}
		
		
		//4 - Vacation Mode - Base income only
		if($CurrentUser['urlaubs_modus'] == 1){
			foreach ($resources as $res){
				$Caps[$res.'_perhour'] = 0;
				foreach($reslist['prod'] as $ProdID){
					$Caps[$ProdID][$res.'_perhour'] = $Caps[$ProdID][$res.'_perhour'] * $production_level;
				}
			}
			$Caps['energy_used']		 = 0;
			$Caps['energy_max']			 = 0;
		}	
		
		
		//Now add base production
		$Caps['metal_perhour']		 += $game_config['metal_basic_income'];
		$Caps['crystal_perhour']	 += $game_config['crystal_basic_income'];
		$Caps['deuterium_perhour']	 += $game_config['deuterium_basic_income'];	
		$Caps['base'] = Array(
			'metal_perhour' => $game_config['metal_basic_income'],
			'crystal_perhour' => $game_config['crystal_basic_income'],
			'deuterium_perhour' => $game_config['deuterium_basic_income']
		);
		
		/*
		echo "<pre>";
		print_r($Caps);
		echo "</pre>";
		*/
		
		return $Caps;
		
		
	}
}

// Revision History
// - 1.0 First made to get the prouctin of resources in 1 place. (MadnessRed)
?>