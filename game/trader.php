<?php

/**
 * marchand.php
 *
 * @version 1.2
 * @copyright 2008 by Chlorel for XNova
 */

if ($game_config['enable_marchand'] == 0) {
	info($lang['market_disabled'],$lang['no_market']);
}

getLang('trader');

function ModuleMarchand ( $CurrentUser, &$CurrentPlanet ) {
	global $lang, $_GET;

	$trade = array('m' => 4,'c' => 2,'d' => 1);
	
	$parse = $lang;

	if ($_GET['ress']) {
		$PageTPL   = gettemplate('trader/main');
		$Error     = false;
		
		$Metal     = idstring($_GET['metal']);
		$Crystal   = idstring($_GET['crystal']);
		$Deuterium = idstring($_GET['deuterium']);
		if ($Metal < 0) { $Metal = 0; }
		if ($Crystal < 0) { $Crystal   = 0; }
		if ($Deuterium < 0) { $Deuterium = 0; }
		
		$maxm = floor($CurrentPlanet['crystal_max'] - $CurrentPlanet['crystal']);
		$maxc = floor($CurrentPlanet['metal_max'] - $CurrentPlanet['metal']);
		$maxd = floor($CurrentPlanet['deuterium_max'] - $CurrentPlanet['deuterium']);
		if ($Metal > $maxm) { $Metal = $maxm; }
		if ($Crystal > $maxc) { $Crystal = $maxc; }
		if ($Deuterium > $maxd) { $Deuterium = $maxd; }
		
		switch ($_GET['ress']) {
			case 'metal':
				$need = (( $Crystal / $trade['c'] * $trade['m']) + ( $Deuterium / $trade['d'] * $trade['m']));
				if ($CurrentPlanet['metal'] > $need) {
					$CurrentPlanet['metal'] -= $need;
				} else {
					$Message = $lang['mod_ma_noten'] ." ". $lang['Metal'] ."! ";
					$Error   = true;
				}
				break;
				
			case 'crystal':
				$need   = (( $Metal / $trade['m'] * $trade['c']) + ( $Deuterium / $trade['d'] * $trade['c']));
				
				if ($CurrentPlanet['crystal'] > $need) {
					$CurrentPlanet['crystal'] -= $need;
				} else {
					$Message = $lang['mod_ma_noten'] ." ". $lang['Crystal'] ."! ";
					$Error   = true;
				}
				break;
			
			case 'deuterium':
				$need   = (( $Metal / $trade['m'] * $trade['d']) + ( $Crystal / $trade['c'] * $trade['d']));
				if ($CurrentPlanet['deuterium'] > $need) {
					$CurrentPlanet['deuterium'] -= $need;
				} else {
					$Message = $lang['mod_ma_noten'] ." ". $lang['Deuterium'] ."! ";
					$Error   = true;
				}
				break;
		}
		
		if ($Error == false) {
			$CurrentPlanet['metal']     += $Metal;
			$CurrentPlanet['crystal']   += $Crystal;
			$CurrentPlanet['deuterium'] += $Deuterium;

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = '".     $CurrentPlanet['metal']     ."', ";
			$QryUpdatePlanet .= "`crystal` = '".   $CurrentPlanet['crystal']   ."', ";
			$QryUpdatePlanet .= "`deuterium` = '". $CurrentPlanet['deuterium'] ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '".        $CurrentPlanet['id']        ."';";
			doquery ( $QryUpdatePlanet , 'planets');
			$Message = $lang['mod_ma_done'];
			
			$parse['title'] = $lang['mod_ma_donet'];
		} else {
			$parse['title'] = $lang['mod_ma_error'];
		}
		$parse['mod_ma_rates']   = $Message;
	} else {
		if ($_GET['action'] != 2) {
			$PageTPL = gettemplate('trader/main');
		} else {
			$PageTPL = gettemplate('trader/trade');
			
			switch ($_GET['resource']) {
				case 'metal':
					
					$parse['storage_a'] = floor($CurrentPlanet['metal_max'] - $CurrentPlanet['metal']);
					$parse['storage_b'] = floor($CurrentPlanet['crystal_max'] - $CurrentPlanet['crystal']);
					$parse['storage_c'] = floor($CurrentPlanet['deuterium_max'] - $CurrentPlanet['deuterium']);
					if($parse['storage_a'] < 0){ $parse['storage_a'] = 0; }
					if($parse['storage_b'] < 0){ $parse['storage_b'] = 0; }
					if($parse['storage_c'] < 0){ $parse['storage_c'] = 0; }
					$parse['storage_ap'] = pretty_number($parse['storage_a']);
					$parse['storage_bp'] = pretty_number($parse['storage_b']);
					$parse['storage_cp'] = pretty_number($parse['storage_c']);
					
					$parse['ResourceA'] = $lang['Metal'];
					$parse['ResourceB'] = $lang['Crystal'];
					$parse['ResourceC'] = $lang['Deuterium'];
					
					$parse['resa'] = 'metal';
					$parse['resb'] = 'crystal';
					$parse['resc'] = 'deuterium';
	
					$parse['tradea'] = $trade['m'];
					$parse['tradeb'] = $trade['c'];
					$parse['tradec'] = $trade['d'];
					
					break;
				case 'crystal':
					
					$parse['storage_a'] = floor($CurrentPlanet['crystal_max'] - $CurrentPlanet['crystal']);
					$parse['storage_b'] = floor($CurrentPlanet['metal_max'] - $CurrentPlanet['metal']);
					$parse['storage_c'] = floor($CurrentPlanet['deuterium_max'] - $CurrentPlanet['deuterium']);
					if($parse['storage_a'] < 0){ $parse['storage_a'] = 0; }
					if($parse['storage_b'] < 0){ $parse['storage_b'] = 0; }
					if($parse['storage_c'] < 0){ $parse['storage_c'] = 0; }
					$parse['storage_ap'] = pretty_number($parse['storage_a']);
					$parse['storage_bp'] = pretty_number($parse['storage_b']);
					$parse['storage_cp'] = pretty_number($parse['storage_c']);
					
					$parse['ResourceA'] = $lang['Crystal'];
					$parse['ResourceB'] = $lang['Metal'];
					$parse['ResourceC'] = $lang['Deuterium'];
					
					$parse['resa'] = 'crystal';
					$parse['resb'] = 'metal';
					$parse['resc'] = 'deuterium';
	
					$parse['tradea'] = $trade['c'];
					$parse['tradeb'] = $trade['m'];
					$parse['tradec'] = $trade['d'];
					
					break;
				case 'deuterium':
					
					$parse['storage_a'] = floor($CurrentPlanet['deuterium_max'] - $CurrentPlanet['deuterium']);
					$parse['storage_b'] = floor($CurrentPlanet['metal_max'] - $CurrentPlanet['metal']);
					$parse['storage_c'] = floor($CurrentPlanet['crystal_max'] - $CurrentPlanet['crystal']);
					if($parse['storage_a'] < 0){ $parse['storage_a'] = 0; }
					if($parse['storage_b'] < 0){ $parse['storage_b'] = 0; }
					if($parse['storage_c'] < 0){ $parse['storage_c'] = 0; }
					$parse['storage_ap'] = pretty_number($parse['storage_a']);
					$parse['storage_bp'] = pretty_number($parse['storage_b']);
					$parse['storage_cp'] = pretty_number($parse['storage_c']);
					
					$parse['ResourceA'] = $lang['Deuterium'];
					$parse['ResourceB'] = $lang['Metal'];
					$parse['ResourceC'] = $lang['Crystal'];
					
					$parse['resa'] = 'deuterium';
					$parse['resb'] = 'metal';
					$parse['resc'] = 'crystal';
	
					$parse['tradec'] = $trade['d'];
					$parse['tradeb'] = $trade['m'];
					$parse['tradea'] = $trade['c'];
					
					break;
			}
		}
	}

	$parse['planet'] = $CurrentPlanet['name'];
	$Page    = parsetemplate ( $PageTPL, $parse );
	return  $Page;
}

$Page = ModuleMarchand ( $user, $planetrow );
if($_GET['axah']){
	makeAXAH($Page,$lang['Marchand']);
}else{
	displaypage( $Page, $lang['Marchand'], true, '', false );
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle (Tom1991)
// 1.1 - Version 2.0 de Tom1991 ajout java
// 1.2 - R��criture Chlorel passage aux template, optimisation des appels et des requetes SQL
?>
