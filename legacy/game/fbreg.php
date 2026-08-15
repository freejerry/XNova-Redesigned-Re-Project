<?php

/**
 * reg.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 * Extra bit by Antony for Darkness of Evolution
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('NO_MENU' , true);

$xnova_root_path = $unipath;
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);


//START
//Is this uni a side uni?
includeLang('sides');
$evouni = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$evouni = ereg_replace("[^0-9]", "", $evouni);
if (
($evouni == $lang['sideuni_1']) || 
($evouni == $lang['sideuni_2']) || 
($evouni == $lang['sideuni_3']) || 
($evouni == $lang['sideuni_4']) || 
($evouni == $lang['sideuni_5']) || 
($evouni == $lang['sideuni_6']) || 
($evouni == $lang['sideuni_7']) || 
($evouni == $lang['sideuni_8']) || 
($evouni == $lang['sideuni_9']) || 
($evouni == $lang['sideuni_10'])
)
{define('SPLIT' , true);}
//END


includeLang('reg');

function sendpassemail($emailaddress, $password, $username) {
	global $lang;

	$uni = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$uni = ereg_replace("[^0-9]", "", $uni);

	
	$parse['gameurl']  = GAMEURL;
	$parse['password'] = $password;
	$parse['username'] = $username;
	$parse['uni']	   = $uni;
	$email             = parsetemplate($lang['mail_welcome'], $parse);
	$status            = mymail($emailaddress, $lang['mail_title'], $email);
	return $status;
}

function mymail($to, $title, $body, $from = '') {
	$from = trim($from);

	if (!$from) {
		$from = ADMINEMAIL;
	}

	$rp     = ADMINEMAIL;

	$head   = '';
	$head  .= "Content-Type: text/html \r\n";
	$head  .= "Date: " . date('r') . " \r\n";
	$head  .= "Return-Path: $rp \r\n";
	$head  .= "From: $from \r\n";
	$head  .= "Sender: $from \r\n";
	$head  .= "Reply-To: $from \r\n";
	$head  .= "Organization: $org \r\n";
	$head  .= "X-Sender: $from \r\n";
	$head  .= "X-Priority: 3 \r\n";
	$body   = str_replace("\r\n", "\n", $body);
	$body   = str_replace("\n", "\r\n", $body);

	return mail($to, $title, $body, $head);
}
if ($_POST) {
	$errors    = 0;
	$errorlist = "";

	$_POST['email'] = strip_tags($_POST['email']);
	if (!is_email($_POST['email'])) {
		$errorlist .= "\"" . $_POST['email'] . "\" " . $lang['error_mail'];
		$errors++;
	}

	if (!$_POST['planet']) {
		$errorlist .= $lang['error_planet'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['hplanet']) == 1) {
		$errorlist .= $lang['error_planetnum'];
		$errors++;
	}

	if (!$_POST['character']) {
		$errorlist .= $lang['error_character'];
		$errors++;
	}

	if (strlen($_POST['passwrd']) < 4) {
		$errorlist .= $lang['error_password'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1) {
		$errorlist .= $lang['error_charalpha'];
		$errors++;
	}

	if ($_POST['rgt'] != 'on') {
		$errorlist .= $lang['error_rgt'];
		$errors++;
	}

	// Le meilleur moyen de voir si un nom d'utilisateur est pris c'est d'essayer de l'appeler !!
	$ExistUser = doquery("SELECT `username` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
	if ($ExistUser) {
		$errorlist .= $lang['error_userexist'];
		$errors++;
	}

	// Si l'on verifiait que l'adresse email n'existe pas encore ???
	$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". mysql_escape_string($_POST['email']) ."' LIMIT 1;", 'users', true);
	if ($ExistMail) {
		$errorlist .= $lang['error_emailexist'];
		$errors++;
	}

	// Si l'on verifiait que l'adresse email n'existe pas encore ???
	$ExistMail = doquery("SELECT `facebook_id` FROM {{table}} WHERE `facebook_id` = '". mysql_escape_string($_POST['facebook']) ."' LIMIT 1;", 'users', true);
	if ($ExistMail) {
		$errorlist .= $lang['error_fbexist'];
		$errors++;
	}

	if ($_POST['sex'] != 'F' &&
		$_POST['sex'] != 'M') {
		$errorlist .= $lang['error_sex'];
		$errors++;
	}
	
	if ($_POST['avatar'] == ''){
		$avatar = "../images/no_av.gif";
		$refid = $_GET['refid'];
	}else{
		$avatar = $_POST['avatar'];
		$refid = $_GET['refid'];
	}
		
	$sec_qu = $_POST['sec_qu'];
	$sec_ans = $_POST['sec_ans'];
	
	if ($_POST['side'] == 'light'){
		$ally_id = "1";
		$ally_name = "Light";
	}else{
		$ally_id = "2";
		$ally_name = "Dark";
	}

	$ally_register_time = time();
	$ally_rank_id = 1;

	if ($errors != 0) {
		message ($errorlist, $lang['Register']);
	} else {
		$newpass        = $_POST['passwrd'];
		$UserName       = CheckInputStrings ( $_POST['character'] );
		$UserEmail      = CheckInputStrings ( $_POST['email'] );
		$UserPlanet     = CheckInputStrings ( $_POST['planet'] );
			
		if ($refid != ''){
			$QryInsertUser  = "UPDATE {{table}} SET ";
			$QryInsertUser .= "`refers` = `refers` + 1 ";
			$QryInsertUser .= "WHERE `id` =".$refid." LIMIT 1 ; ";
		doquery( $QryInsertUser, 'users');		
		}
			
		elseif ($refname != ''){
			$QryInsertUser  = "UPDATE {{table}} SET ";
			$QryInsertUser .= "`refers` = `refers` + 1 ";
			$QryInsertUser .= "WHERE `username` =".$refname." LIMIT 1 ; ";
		doquery( $QryInsertUser, 'users');		
		}
		
		$md5newpass     = md5($newpass);
		// Creation de l'utilisateur
		$QryInsertUser  = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`username` = '".     mysql_escape_string(strip_tags( $UserName )) ."', ";
		$QryInsertUser .= "`facebook_id` = '".        mysql_escape_string( $_POST['facebook'] )            ."', ";
		//$QryInsertUser .= "`email` = '".        mysql_escape_string( $UserEmail )            ."', ";
		//$QryInsertUser .= "`email_2` = '".      mysql_escape_string( $UserEmail )            ."', ";
		$QryInsertUser .= "`sex` = '".          mysql_escape_string( $_POST['sex'] )         ."', ";
		$QryInsertUser .= "`lang` = '".         mysql_escape_string( $_POST['lang'] )         ."', ";
		$QryInsertUser .= "`avatar` = '".       mysql_escape_string( $avatar )         ."', ";
		//$QryInsertUser .= "`sec_qu` = '".       mysql_escape_string( $sec_qu )         ."', ";
		//$QryInsertUser .= "`sec_ans` = '".      mysql_escape_string( $sec_ans )         ."', ";
		if(defined("SPLIT")){
			$QryInsertUser .= "`ally_id` = '".      	    mysql_escape_string( $ally_id )              ."', ";
			$QryInsertUser .= "`ally_name` = '".      	    mysql_escape_string( $ally_name )            ."', ";
			$QryInsertUser .= "`ally_register_time` = '".	mysql_escape_string( $ally_register_time )   ."', ";
			$QryInsertUser .= "`ally_rank_id` = '".      	mysql_escape_string( $ally_rank_id )         ."', ";
		}
		$QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`register_time` = '". time() ."', ";
		$QryInsertUser .= "`password`='". $md5newpass ."';";
		doquery( $QryInsertUser, 'users');


		// On cherche le numero d'enregistrement de l'utilisateur fraichement créé
		$NewUser        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
		$iduser         = $NewUser['id'];

		// Recherche d'une place libre !
		$LastSettedGalaxyPos  = $game_config['LastSettedGalaxyPos'];
		$LastSettedSystemPos  = $game_config['LastSettedSystemPos'];
		$LastSettedPlanetPos  = $game_config['LastSettedPlanetPos'];
		while (!isset($newpos_checked)) {
			for ($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy++) {
				for ($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System++) {
					for ($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit++) {
						$Planet = round (rand ( 4, 12) );

						switch ($LastSettedPlanetPos) {
							case 1:
								$LastSettedPlanetPos += 1;
								break;
							case 2:
								$LastSettedPlanetPos += 1;
								break;
							case 3:
								if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
									$LastSettedGalaxyPos += 1;
									$LastSettedSystemPos  = 1;
									$LastSettedPlanetPos  = 1;
									break;
								} else {
									$LastSettedPlanetPos  = 1;
								}
								$LastSettedSystemPos += 1;
								break;
						}
						break;
					}
					break;
				}
				break;
			}

			$QrySelectGalaxy  =	"SELECT * ";
			$QrySelectGalaxy .= "FROM {{table}} ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QrySelectGalaxy .= "`system` = '". $System ."' AND ";
			$QrySelectGalaxy .= "`planet` = '". $Planet ."' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$GalaxyRow = doquery( $QrySelectGalaxy, 'galaxy', true);

			if ($GalaxyRow["id_planet"] == "0") {
				$newpos_checked = true;
			}

			if (!$GalaxyRow) {
				CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
				$newpos_checked = true;
			}
			if ($newpos_checked) {
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedGalaxyPos ."' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedSystemPos ."' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedPlanetPos ."' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
			}
		}
		// Recherche de la reference de la nouvelle planete (qui est unique normalement !
		$PlanetID = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);

		// Mise a jour de l'enregistrement utilisateur avec les infos de sa planete mere
		$QryUpdateUser  = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`id_planet` = '". $PlanetID['id'] ."', ";
		$QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."', ";
		$QryUpdateUser .= "`galaxy` = '". $Galaxy ."', ";
		$QryUpdateUser .= "`system` = '". $System ."', ";
		$QryUpdateUser .= "`planet` = '". $Planet ."' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '". $NewUser['id'] ."' ";
		$QryUpdateUser .= "LIMIT 1;";
		doquery( $QryUpdateUser, 'users');

		// Mise a jour du nombre de joueurs inscripts
		doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
		if(defined("SPLIT")){
			if ($side == "light"){
				doquery("UPDATE {{table}} SET `ally_members` = `ally_members` + '1' WHERE `id` = '1' LIMIT 1;", 'alliance');
			}else{
				doquery("UPDATE {{table}} SET `ally_members` = `ally_members` + '1' WHERE `id` = '2' LIMIT 1;", 'alliance');
			}
		}
		
		$Message = "Hi, Welcome to Darkness of Evolution. We hope you have fun playing this game. If you have any questions please check the FAQ, if you cannot find an answer there then you will find plenty of friendly people on the forum who will help you. As a general tip we would recomend you start by building up your mines. Start with metal mines and Crystal mines as well as a Solar Plant. Good Luck.";
		SendSimpleMessage ( $NewUser['id'], 1, time(), 1, "Darkness of Evolution", "Welcome", $Message);
		
		header("Location: http://apps.facebook.com/redesigned/?regsucess=1");
		
	}
} else {
	// Afficher le formulaire d'enregistrement
	$parse               = $lang;
	$parse['servername'] = $game_config['game_name'];
	if (strlen($_GET['refid']) == 0){
		$parse['refer']		 = '<tr>
									<td>Referal</td>
									<td><input name="ref_name" size="20" maxlength="20" type="text" onKeypress="
									if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
									if (event.which==60 || event.which==62) return false;"></td>
								</tr>';
	}else{
		$parse['refer']		 = '';
	}
	
	if(defined("SPLIT")){
		$parse['side']		 = '</tr>
      								<td>Side</td>
     								<td>
										<select name="side">
											<option value="light">Light Side</option>
											<option value="dark" selected>Dark Side</option>
										</select><br /><br />
									</td>
 								</tr>';
	}else{
		$parse['side']		 = '';
	}
	
	$page                = parsetemplate(gettemplate('registry_form_new'), $parse);

	display ($page, $lang['registry'], false);
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle
// 1.1 - Menage + rangement + utilisation fonction de creation planete nouvelle generation
?>