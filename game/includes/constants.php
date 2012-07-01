<?php


/**
 * constants.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------------

if ( defined('INSIDE') ) {
	//These are from common.php what are constants doing there?
	define('DEFAULT_SKIN'				, '../skins/xr/');
	//define('DEFAULT_SKIN'				, BASEURL.'skins/xr/');
	//define('DEFAULT_SKIN'				, 'http://uni42.ogame.org/game/');
	define('TEMPLATE_DIR'				, 'templates/');
	define('TEMPLATE_NAME'				, 'Redesigned');
	define('DEFAULT_LANG'				, 'en');
	
	define('XNOVAUKLINK'				, 'https://raw.github.com/freejerry/XNova-Redesigned-Re-Project/master/');



	// Definition du monde connu !
	define('MAX_GALAXY_IN_WORLD'      , 9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     , 15);
	// Nombre de colones pour les rapports d'espionnage
	define('SPY_REPORT_ROW'           , 2);
	// Cases données par niveau de Base Lunaire
	define('FIELDS_BY_MOONBASIS_LEVEL', 4);
	// Nombre maximum de colonie par joueur
	//define('MAX_PLAYER_PLANETS'       , 8);
	// Nombre maximum d'element dans la liste de construction de batiments
	define('MAX_BUILDING_QUEUE_SIZE'  , 5);
	// Nombre maximum d'element dans une ligne de liste de construction flotte et defenses
	define('MAX_FLEET_OR_DEFS_PER_ROW', 1000000);
	// Taux de depassement possible dans l'espace de stockage des hangards ...
	// 1.0 pour 100% - 1.1 pour 110% etc ...
	define('MAX_OVERFLOW'             , 1);
	// Affiche les administrateur dans la page des records ...
	// 1 -> les affiche
	// 0 -> les affiche pas
	define('SHOW_ADMIN_IN_RECORDS'    , 0);
	
	define('MAX_BATTLE_ROUNDS'			, 8);

	// Valeurs de bases pour les colonies ou planetes fraichement crées
	define('BASE_STORAGE_SIZE'			, 10000);
	define('BUILD_METAL'				, 500);
	define('BUILD_CRISTAL'				, 500);
	define('BUILD_DEUTERIUM'			, 0);

	define('DARK_MATTER_FACTOR'       , 1);
	
	define('BASE_PROD_ON_MOONS'			, true);
	
	// Moon chance data
	define('DEBRIS_PER_PERCENT'			, 100000);
	define('MAX_MOON_PERCENT'			, 20);
	define('MIN_MOON_PERCENT'			, 1);
	
	// Maximum amount which can be raided from a planet, (as a faction of the total resources)
	define('MAX_ATTACK_RAID'			, 0.5);
	
	
	//Enable ACS
	define('ENABLE_ACS'					, false);
	
	
	//Expedition Constants
	define('MAX_DARKMATTER'				, 10000);	//Maximum ammount of Dark Matter that can be got from 1 expedition. (Note it is exponential so lower ammounts are more probable)
	define('MIN_DELAY'					, 60);		//Minimum ammount a fleet will be delayed (or sped up by) from an expedition. (Seconds)
	define('MAX_DELAY'					, 36000);	//Maximum ammount a fleet will be delayed (or sped up by) from an expedition. (Seconds)
	

	//A list of chara\cters to accept in emails. note that alpa-numeric are enabled by default
	define('EMAIL_CHARS'				, '-._');
	//define('EMAIL_CHARS'				, '-_.\+');

	// Debug Level
	define('DEBUG', 1); // Debugging off
	// Mot qui sont interdit a la saisie !
	$ListCensure = array ( "<", ">", "'", "script", "doquery", "http", "javascript", "\"" );
} else {
	die("Error: Sorry you may not view this page in this way.");
}



?>
