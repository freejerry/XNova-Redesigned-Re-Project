<?php

/**
 * formulas.php
 *
 * @version 1.0
 * @copyright 2009 by Anthony for XNova Redesigned
 */

$formulas = array(
	//Missiles
	'ipm_range'		=> 'return ($user[$resource[117]] * 5) - 1;',
	'ipm_speed'		=> 'return (($systems * 2) + 1) * 75000 / $game_config["fleet_speed"];',
	
	//Phalanx
	'phalanx_range'	=> 'return ($planetrow[$resource[42]] * $planetrow[$resource[42]]) - 1;',
	
	
	//Astrophysics
	'max_planets_c'	=> 'return ceil($CurrentUser[$resource[124]] / 2) + 1;',
	'max_planets'	=> 'return ceil($user[$resource[124]] / 2) + 1;',
	'min_pos_c'		=> 'return 5 - floor($CurrentUser[$resource[124]] / 2);',
	'max_pos_c'		=> 'return MAX_PLANET_IN_SYSTEM - 5 + floor($CurrentUser[$resource[124]] / 2);',

	//Fleets
	'max_fleets'	=> 'return $user[$resource[108]] + 1;',
);

?>
