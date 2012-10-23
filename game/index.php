<?php
/*
 * index.php
 *
 * @version 1.4
 * @copyright 2008 by Anthony for XNova Redesigned
 *
*/

define('INSIDE'  , true);
define('INSTALL' , false);

define('ROOT_PATH' , '');
include_once(ROOT_PATH . 'common.php');

//Firstly, if not gonan be defined anywhere else
$pageid = "overview";

//Template constants.
define('GAME_SKIN',(strlen($userclass->skin) > 0 ? $userclass->skin : DEFAULT_SKIN));
define('PLANET_NAME',$planetrow['name']);
define('USER_NAME',$userclass->username);

PlanetResourceUpdate($userclass->uarray,$planetrow,time());

//Skin config?

$skin_config = file(GAME_SKIN."/config.txt");
if(substr($skin_config[0], 0, 26) == '!!--Skin Configuration--!!'){
	define('HEADER_CACHE',str_replace("{{skin}}",GAME_SKIN,$skin_config[2]));
}
else{
	define('HEADER_CACHE',GAME_SKIN.'/headerCache/'); //not working skin config -> missing file
}

if($_GET['iframe'] == '1'){
	include_once('iframe.php');
}else{

	switch ($_GET['page']) {
		case 'admin':
			// --------------------------------------------------------------------------------------------------
			$pageid = "preferences";
			include(ROOT_PATH . 'admin.php');
			break;
		case 'test':
			// --------------------------------------------------------------------------------------------------
			$start = microtime(true);
			$currentplanet->production_rates($userclass);
			$time = microtime(true)-$start;
			echo '<hr />';
			echo $time;
			break;
		case 'logout':
			// --------------------------------------------------------------------------------------------------
      setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
			ExpireCookie();
			header("Location: ". LOGINURL);
			die();
			break;
		case 'i':
			// --------------------------------------------------------------------------------------------------
			include_once('iframe.php');
			break;
		case 'battlesim':
			// --------------------------------------------------------------------------------------------------
			include_once('battlesim.php');
			break;
		case 'im':
			// --------------------------------------------------------------------------------------------------
			@include_once('im.php');
			break;
		case 'ajax':
			// --------------------------------------------------------------------------------------------------
			include_once('ajax.php');
			break;
		case 'planetlist':
			// --------------------------------------------------------------------------------------------------
			include_once('planetlist.php');
			break;
		case 'achievements':
			// --------------------------------------------------------------------------------------------------
			include_once('achievements.php');
			break;
		case 'resources':
			// --------------------------------------------------------------------------------------------------
			$cpage = "resources";
			$pageid = "resources";
			includeLang('buildings');
			getLang('resources');
			include(ROOT_PATH . 'includes/pages/BuildRessourcePage.php');
			include(ROOT_PATH . 'includes/pages/BuildingPage.php');
			if(isset($_GET['submit_resource'])&&$_GET['submit_resource']=="1"){ header("location:./?page=resources&mode=resources"); }
			if(isset($_GET['finish'])&&$_GET['finish']=="finish"){
				UpdateQueue();
				header("location:./?page=resources");
			}else{
				UpdateQueue();
			}
			$IsWorking = HandleTechnologieBuild ( $planetrow, $userclass->uarray );
			BuildingPage ();
			break;
		case 'station':
			// --------------------------------------------------------------------------------------------------
			$cpage = "station";
			$pageid = "station";
			if($planetrow['planet_type'] == 3)
				$pageid .= "-moon";
			includeLang('buildings');
			include(ROOT_PATH . 'includes/pages/BuildingPage.php');
			if(isset($_GET['finish'])&&$_GET['finish']=="finish"){
				UpdateQueue();
				header("location:./?page=station");
			}else{
				UpdateQueue();
			}
			$IsWorking = HandleTechnologieBuild ( $planetrow, $userclass->uarray );
			BuildingPage();
			break;
		case 'trader':
			// --------------------------------------------------------------------------------------------------
			$cpage = "trader";
			$pageid = "trader";
			include('trader.php');
			break;
		case 'research':
			// --------------------------------------------------------------------------------------------------
			$cpage = "research";
			$pageid = "research";
			includeLang('buildings');
			getLang('research');
			include('includes/pages/ResearchPage.php');
			UpdatePlanetBatimentQueueList ( $planetrow, $userclass->uarray );
			$IsWorking = HandleTechnologieBuild ( $planetrow, $userclass->uarray );
			ResearchPage ( $planetrow, $userclass->uarray, $IsWorking['OnWork'], $IsWorking['WorkOn'] );
			break;
		case 'shipyard':
			// --------------------------------------------------------------------------------------------------
			$cpage = "shipyard";
			$pageid = "shipyard";
			includeLang('buildings');
			include(ROOT_PATH . 'includes/pages/ShipyardPage.php');
			UpdatePlanetBatimentQueueList ( $planetrow, $userclass->uarray );
			$IsWorking = HandleTechnologieBuild ( $planetrow, $userclass->uarray );
			ShipyardPage($planetrow,$userclass->uarray,'fleet');
			break;
		case 'defense':
			// --------------------------------------------------------------------------------------------------
			$cpage = "defense";
			$pageid = "defense";
			includeLang('buildings');
			include(ROOT_PATH . 'includes/pages/ShipyardPage.php');
			UpdatePlanetBatimentQueueList ( $planetrow, $userclass->uarray );
			$IsWorking = HandleTechnologieBuild ( $planetrow, $userclass->uarray );
			ShipyardPage($planetrow,$userclass->uarray,'defense');
			break;
		case 'fleet1':
			// --------------------------------------------------------------------------------------------------
			$cpage = "fleet";
			$pageid = "fleet1";
			include('fleet1.php');
			break;
		case 'fleet2':
			// --------------------------------------------------------------------------------------------------
			$cpage = "fleet";
			$pageid = "fleet2";
			include('fleet2.php');
			break;
		case 'fleetjump':
			// --------------------------------------------------------------------------------------------------
			$cpage = "fleet";
			$pageid = "fleet2";
			include('fleetjump.php');
			break;
		case 'fleet3':
			// --------------------------------------------------------------------------------------------------
			$cpage = "fleet";
			$pageid = "fleet3";
			include('fleet3.php');
			break;
		case 'fleet4':
			// --------------------------------------------------------------------------------------------------
			$cpage = "fleet";
			include('fleet4.php');
			break;
		case 'fleetrecall':
			// --------------------------------------------------------------------------------------------------
			include('fleetrecall.php');
			break;
		case 'jumpgate':
			// --------------------------------------------------------------------------------------------------
			$cpage = "fleet";
			include('jumpgate.php');
			break;
		case 'fleetajax':
			// --------------------------------------------------------------------------------------------------
			@include('fleetajax.php');
			break;
		case 'movement':
			// --------------------------------------------------------------------------------------------------
			$cpage = "fleet";
			$pageid = "movement";
			include('fleetm.php');
			break;
		case 'galaxy':
			// --------------------------------------------------------------------------------------------------
			$cpage = "galaxy";
			$pageid = "galaxy";
			include('galaxy.php');
			break; case 'ipm': include('ipm.php');
			break;
		case 'empire':
			// --------------------------------------------------------------------------------------------------
			$cpage = "empire";
			$pageid = "empire";
			include('empire.php');
			break;
		case 'ainfo':
			// --------------------------------------------------------------------------------------------------
			$cpage = "network";
			$pageid = "network";
			include_once("alliance.php");
			break;
		case 'network':
			// --------------------------------------------------------------------------------------------------
			$cpage = "network";
			$pageid = "network";
			include_once("alliance.php");
			break;
		case 'messages':
			// --------------------------------------------------------------------------------------------------
			$cpage = "network";
			$pageid = "messages";
			include_once("messages.php");
			break; case 'showmessage': include_once("showmessage.php");
			break; case 'write': include_once("write.php");
			break;
		case 'notes':
			// --------------------------------------------------------------------------------------------------
			$cpage = "network";
			$pageid = "networkm";
			include_once("notes.php");
			break;
		case 'phalanx':
			// --------------------------------------------------------------------------------------------------
			$cpage = "phalanx";
			include_once("phalanx.php");
			break;
		case 'amici_pop_up':
			// --------------------------------------------------------------------------------------------------
			include_once("amici_pop_up.php");
			break;
		case 'cerca':
			// --------------------------------------------------------------------------------------------------
			include_once("search.php");
			break;
		case 'premium':
			// --------------------------------------------------------------------------------------------------
			$cpage = "premium";
			$pageid = "premium";
			include_once("officers.php");
			break;
		case 'ticket':
			// --------------------------------------------------------------------------------------------------
			$cpage = "ticket";
			$pageid = "ticket";
			include_once("support.php");
			break;
		case 'paypal':
			// --------------------------------------------------------------------------------------------------
			$cpage = "premium";
			include_once("paypal.php");
			break;
		case 'payment':
			// --------------------------------------------------------------------------------------------------
			include_once('includes/payapi.php');
			$PaySystem = new UgamelaplayPay( PAYSYSTEM_PUBLIC , PAYSYSTEM_PRIVATE, $user->id, 'xr');
			if($_GET['redir'] == "1"){
				$PaySystem->RedirToPaySystem();
			}
			if($_GET['code'] != ""){
				$Message = $PaySystem->Comprobate($_GET['code']);
				info($Message,"DarkMatter Buy",'./?page=premium','./?page=premium');			
			}
			$cpage = "premium";
			$pageid = "preferences";
			getLang('premium');
			$lang['cost100k'] = $darkmattercosts['100'];
			$lang['cost250k'] = $darkmattercosts['250'];
			$lang['cost1000k'] = $darkmattercosts['1000'];
			$page = parsetemplate(gettemplate('redesigned/payment'), $lang);
			//displaypage($page, $lang['Overview']);
			makeAXAH($page);
			break;
		case 'techdata':
			// --------------------------------------------------------------------------------------------------
			include('techdata.php');
			break;
		case 'changelog':
			// --------------------------------------------------------------------------------------------------
			$cpage = "changelog";
			include('changelog.php');
			break;
		case 'preferences':
			// --------------------------------------------------------------------------------------------------
			$cpage = "options";
			$pageid = "preferences";
			include('preferences.php');
			break;
		case 'statistics':
			// --------------------------------------------------------------------------------------------------
			$pageid = 'statistics';
			include_once('stats.php');
			break;
		case 'pillory':
			// --------------------------------------------------------------------------------------------------
			$pageid = "preferences";
			include_once('banned.php');
			break;
		case 'board':
			// --------------------------------------------------------------------------------------------------
			$pageid = "preferences";
			include_once('forum.php');
			break;
		case 'validate':
			// --------------------------------------------------------------------------------------------------
			$pageid = "validate";
			include_once('validate.php');
			break;
		default: //Overview.
			// --------------------------------------------------------------------------------------------------
			$cpage = "overview";
			//includeLang('overview');
			getLang('overview');
			includeLang('tech');
			include("includes/overviewfunctions.php");
			$parse = array_merge($lang, $currentplanet->parray);
			$type_array = $currentplanet->type();
			$parse['type'] = $type_array['type'];
			$parse['subtype'] = $type_array['subtype'];
			$moon = $currentplanet->get_moon();
			if($moon){
				$alt = $moon->parray;
				$alt_type_array = $moon->type();
				if($alt['planet_type'] == 1){
					$parse['moonlink'] = '
			<div id="planet_as_moon"> 
		    	<a onclick="loadpage(\'./?cp='.$alt['id'].'&re=0\',\''.$lang['Overview'].' - '.$alt['name'].'\',\'overview\'); document.getElementById(\'planet_ext\').value = \'\'; document.getElementById(\'resources_menu_link\').style.display = \'block\'; return false;" 
		        	href="./?cp='.$alt['id'].'&re=0" 
					class="tips" 
		            onmouseover="mr_tooltip(\''.$alt['name'].'\')" onmouseout="UnTip()">
		        	<img alt="" src="'.GAME_SKIN.'/img/planets/large/'.$alt_type_array['type'].'.jpg">
		        </a>
		    </div>';
		    	}else{
					$parse['moonlink'] = '
			<div id="moon"> 
				<a onclick="loadpage(\'./?cp='.$alt['id'].'&re=0\',\''.$lang['Overview'].' - '.$alt['name'].'\',\'overview\'); document.getElementById(\'planet_ext\').value = \'-moon\'; document.getElementById(\'resources_menu_link\').style.display = \'none\'; return false;" 
					href="./?cp='.$alt['id'].'&re=0"
					class="tips"
					onmouseover="mr_tooltip(\''.$alt['name'].'\')" onmouseout="UnTip()">
					<img alt="" src="'.GAME_SKIN.'/img/planets/moon/'.$alt_type_array['type'].'_'.$alt_type_array['subtype'].'_3.gif"> 
				</a>
			</div>';	    	
		    	}
			}
			if($planetrow['planet_type'] == 3){
				$parse['headerimg'] = $parse['type'].'_'.$parse['subtype'].'.jpg';
			}else{
				$parse['headerimg'] = 'header_'.$parse['type'].'.jpg';
			}
			$parse['total_points'] = pretty_number(floor($userclass->total_points/$game_config['stat_settings']));
			$parse['user_rank'] = USER_RANK;
			//print_r($StatRecord);
			$parse['players'] = $game_config['users_amount'];
			$parse['planet_id'] = $userclass->current_planet;
			$parse['qbuilding'] = $queueinfo;
			$parse['qresearch'] = $queueinforl;
			$parse['qshipyard'] = $queueinfosy;
			$parse['date_time'] = date("D M n H:i:s");
			//Show planet remove/rename
			if($_GET['mode'] == 'removepl'){ $parse['plrem_disp'] = 'display:block;'; }
			$page = parsetemplate(gettemplate('redesigned/overview'), $parse);
			if($_GET['axah']){
				makeAXAH($page);
			}else{
				displaypage($page, $lang['Overview']);
			}
			break;
	}
}

// -----------------------------------------------------------------------------------------------------------
// Changelog
// 1.0 - First version by MadnessRed
?>
