<?php

/**
 * common.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

// This is purely for the sake of the admin panel, do not, change it, instead change the version in cahngelog.mo
define('VERSION','beta16');       // Current XNova Redesigned version
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);

//Check rootpath
if(!defined('ROOT_PATH')){ @define('ROOT_PATH',$xnova_root_path); $info = debug_backtrace(); trigger_error("Error, ROOT_PATH is not defined in ".$info[0]['file']); unset($info); }
$xnova_root_path = ROOT_PATH;

//A bit of config
@set_magic_quotes_runtime(0);
$phpEx = "php"; //This is dangerous and will be fased out asap.


$lang = array();		//We should start the language array now.
$link = false;			//Link for mysql atm nothing.
$IsUserChecked = false;	//No, we haven't checked user yet.


//Basic Game constants
require_once(ROOT_PATH . 'SETUP.PHP');

//Load the session.
if(UNITTYPE == "domain"){
	$domain = str_ireplace("www.","",$_SERVER['HTTP_HOST']);
	$domain = explode(".",$domain);
	$uni = preg_replace("/[^0-9]/", "", $domain[UNI_IN_DOMAIN]);
}elseif(UNITTYPE == "get"){
	if(!$_GET[GETVAL]){ $_GET[GETVAL] = $_POST[GETVAL]; }
	if(!$_GET[GETVAL]){ $_GET[GETVAL] = $_GET['s']; }
	if(!$_GET[GETVAL]){ $_GET[GETVAL] = $_POST['s']; }
	if(!$_GET[GETVAL]){ die("Error, unknown session, please login again"); define('UNIVERSE',''); }
	else{ define('UNIVERSE',preg_replace("/[^0-9]/", "", $_GET[GETVAL])); }
}else{
	define('UNIVERSE',UNITTYPE);
}
//echo UNIVERSE;

//And lets include the game files
require_once(ROOT_PATH . 'modules/game.php');						//Main game class
require_once(ROOT_PATH . 'modules/calculations.php');						//Some calculations

require_once(ROOT_PATH . 'includes/error_handler.php');				//Errors handling
require_once(ROOT_PATH . 'includes/constants.php');					//More Game constants
require_once(ROOT_PATH . 'includes/functions.php');					//Functions
require_once(ROOT_PATH . 'includes/display.php');					//Display functions
require_once(ROOT_PATH . 'includes/unlocalised.php');				//Language function
require_once(ROOT_PATH . 'includes/loadfunctions.php');				//All the game functions.
require_once(ROOT_PATH . 'lang/config.mo');							//Language configs.*/

//Set language
$HTTP_ACCEPT_LANGUAGE = DEFAULT_LANG;

if(!INSTALL){
	
	//Load the modules
	require_once(ROOT_PATH . 'modules/database.php');
	require_once(ROOT_PATH . 'modules/planet.php');
	require_once(ROOT_PATH . 'modules/user.php');
	
	
    require_once(ROOT_PATH . 'includes/vars.php');					//Load the variables
    require_once(ROOT_PATH . 'includes/db.php');					//Load the sql database
    require_once(ROOT_PATH . 'includes/strings.php');				//Load some strings
    
    //We need some pages to only have a small load on the server.
    $basic_pages = array('im','fleetajax');
    if(in_array($_GET['page'],$basic_pages) && strlen($_GET['page']) > 0){
    	define("SMALL_LOAD",true);
    }else{
    	define("SMALL_LOAD",false);
    }
    
	if(!$InLogin){
		$Result			= CheckTheUser ( $IsUserChecked );
		$IsUserChecked	= $Result['state'];
		$userclass		= $Result['class'];
		//This next line should be gradually faded out of use. In future use $userclass->uarray not $user.
		$user			= $userclass->uarray;
	}else{
		// Jeux en mode 'clos' ???
		if($game_config['game_disable'] > 0){
			if ($user['authlevel'] < 1) {
				message ( stripslashes ( $game_config['close_reason'] ), $game_config['game_name'] );
			}
		}
	}
 

    require_once(ROOT_PATH . 'includes/userconstants.php');				//user specific constants


	includeLang ("system");
	includeLang ('tech');
	getLang ('general');
	getLang ('names');
	getLang ('menu');

	//System user class
	$user_system = (object) array('id' => 0, 'username' => $lang['System'], 'email' => ADMINEMAIL);

	
	//What pages do we no need to be logged in for
	$login_not_required  = array('changelog','validate');
	

	if ($user['id'] > 0) {
	
		//Security
		include_once(ROOT_PATH . 'includes/UgaSecurity.php');
	
		//ajax pages want to be quick load, so not generating combat reports or anything
		if(!SMALL_LOAD){
			//Right, lets completely recode all the missions and fleet management.
			include(ROOT_PATH . 'includes/ManageFleets.php');
			ManageFleets($user['id']);
			
			//Lets get current rank
			$rank = doquery("SELECT COUNT('id') +1 AS 'rank' FROM {{table}} WHERE `total_points` > '".$user['total_points']."' ;",'users',true);
			define("USER_RANK",$rank['rank']);
		}

		//If they have no skin, give them the default
		if(!$user['skin']){ $user['skin'] = DEFAULT_SKIN; }

		//Do they have commander?
		if($user[$resource[601]."_exp"] >= time()){ define("COMMANDER",true); }
		else{ define("COMMANDER",false); }

		//Set the planet if the user has changed it.
		if($_GET['cp'] > 0 && $_GET['cp'] != $userclass->current_planet){ $userclass->set_cp($_GET['cp']); }

		//Set the language if the user has changed it.
		if(strlen($_GET['lang']) > 0 && @in_array($_GET['lang'],$basedlang)){
			$sql->doquery("UPDATE {{table}} SET `lang` = '".mysql_real_escape_string($_GET['lang'])."' WHERE `id` = '".$userclass->id."' LIMIT 1 ;",'users');
		}

		//Get planet row and galaxy row.
		if(!$planetrow){ $planetrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true); }
		$currentplanet = $userclass->get_cp();

		//Check for cheating potentially.
		CheckPlanetUsedFields($planetrow);
	}else{
		//Log them out (unless we are on the login page).
		if(!defined('LOGIN') || LOGIN != true){
			if(!in_array($_GET['page'],$login_not_required)){
				if($_GET['demo'] == 'special'){
					$user['skin'] = "http://ugamelaplay.net/skin/xr/";
				}else{
					header("Location: ".LOGINURL);
				}
			}
		}
	}
	$dpath = (strlen($userclass->skin) > 0 ? $userclass->skin : DEFAULT_SKIN); 
} else {
	$dpath = DEFAULT_SKINPATH;
}

?>
