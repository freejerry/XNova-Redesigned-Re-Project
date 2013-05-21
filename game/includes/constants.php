<?php
/**
 * constants.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 *
*/

// ----------------------------------------------------------------------------------------------------------------

if ( defined('INSIDE') ) {
	define('DEFAULT_SKIN'       , '../skins/xr/');
	define('TEMPLATE_DIR'       , 'templates/');
	define('TEMPLATE_NAME'      , 'Redesigned');
	define('DEFAULT_LANG'       , 'en');

  //Just in case...
  define('BATTLE_ENGINE'      , 'php');

	define('XNOVAUKLINK'				, 'https://raw.github.com/freejerry/XNova-Redesigned-Re-Project/stable/');

	define('MAX_GALAXY_IN_WORLD'      , 9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     , 15);

	define('SPY_REPORT_ROW'           , 2);

	define('FIELDS_BY_MOONBASIS_LEVEL', 4);

	define('MAX_FLEET_OR_DEFS_PER_ROW', 1000000);

	define('MAX_OVERFLOW'             , 1);

	define('SHOW_ADMIN_IN_RECORDS'    , 0);

	define('MAX_BATTLE_ROUNDS'			  , 8);

	define('BASE_STORAGE_SIZE'    , 10000);
	define('BUILD_METAL'          , 500);
	define('BUILD_CRISTAL'        , 500);
	define('BUILD_DEUTERIUM'      , 0);

	define('DARK_MATTER_FACTOR'   , 1);

	define('BASE_PROD_ON_MOONS'   , true);

	define('DEBRIS_PER_PERCENT'   , 100000);
	define('MAX_MOON_PERCENT'     , 20);
	define('MIN_MOON_PERCENT'     , 1);

	define('MAX_ATTACK_RAID'      , 0.5);

	define('ENABLE_ACS'           , false);

	define('MAX_DARKMATTER'       , 10000);  //Maximum ammount of Dark Matter that can be got from 1 expedition. (Note it is exponential so lower ammounts are more probable)
	define('MIN_DELAY'            , 60);     //Minimum ammount a fleet will be delayed (or sped up by) from an expedition. (Seconds)
	define('MAX_DELAY'            , 36000);  //Maximum ammount a fleet will be delayed (or sped up by) from an expedition. (Seconds)

	//A list of chara\cters to accept in emails. note that alpa-numeric are enabled by default
	define('EMAIL_CHARS'          , '-._');
	//define('EMAIL_CHARS'				, '-_.\+');

	// Debug Level
	define('DEBUG', 1); // Debugging off

	$ListCensure = array ( "<", ">", "'", "script", "doquery", "http", "javascript", "\"" );
} else {
	die("Error: Sorry you may not view this page in this way.");
}
?>
