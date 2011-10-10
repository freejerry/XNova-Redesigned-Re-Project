<?php

/**
 * reg.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 * Extra bit by Antony for Darkness of Evolution
 */

define('INSIDE'		, true);
define('INSTALL'	, false);
define('NO_MENU'	, true);
define('LOGIN'		, true);

if(!$_GET['s']){ $_GET['s'] = $_POST['s']; }

define('ROOT_PATH' , '');
include_once(ROOT_PATH . 'common.php');

getLang('reg',cleanstring($_POST['lang']));

function sendpassemail($emailaddress, $password, $username, $code) {
	global $lang,$game_config;

	$parse = $lang;
	$parse['password']	= $password;
	$parse['username']	= $username;
	$parse['uni']		= UNIVERSE;
	$parse['game']		= $game_config['game_name'];
	$parse['GAMEURL']	= GAMEURL;
	$parse['ADMIN_NAME']= ADMIN_NAME;
	
	$parse['validate_url'] = GAMEURL.'/login.php?GET_LOGIN=1&username='.$username.'&password='.sha($password).'&UNI='.UNIVERSE.'&go=./?page=validate--code='.$code;
	
	$status				= mymail($emailaddress, $lang['mail_title'].$parse['game'], parsetemplate(gettemplate('emails/reg'), $parse));
	return $status;
}

function mymail($to, $title, $body, $from = false) {
	global $game_config;

	if (!$from) { $from = ADMINEMAIL; }

	$head   = '';
	$head  .= "Content-Type: text/html \n";
	$head  .= "Date: " . date('r') . " \n";
	$head  .= "Return-Path: ".ADMINEMAIL." \n";
	$head  .= "From: $from \n";
	$head  .= "Sender: $from \n";
	$head  .= "Reply-To: $from \n";
	$head  .= "Organization: ".$game_config['game_name']." \n";
	$head  .= "X-Sender: $from \n";
	$head  .= "X-Priority: 3 \n";

	return mail($to, $title, $body, $head);
}

if ($_POST) {

	//if(idstring($_POST['sec_ans']) != '1992'){
	//	message("Sorry, this game is still under developement, please check back later.<br /><small>(reg.php - line 86-88)</small>","Registration Closed");
	//	die();
	//}

	$errors    = 0;
	$errorlist = "";
	if(!$_POST['planet']){ $_POST['planet'] = 'Homeworld'; }
	if(!$_POST['lang']){ $_POST['lang'] = 'en'; }

	$_POST['email'] = strip_tags($_POST['email']);
	if (!is_email($_POST['email'])) {
		$errorlist .= "\"" . $_POST['email'] . "\" " . $lang['error_mail'];
		$errors++;
	}

	if (!$_POST['planet']) {
		$errorlist .= $lang['error_planet'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9]/", $_POST['hplanet']) == 1) {
		$errorlist .= $lang['error_planetnum'];
		$errors++;
	}

	if (!$_POST['character']) {
		$errorlist .= $lang['error_character'];
		$errors++;
	}

	if (strlen($_POST['passwrd']) < 7) {
		$errorlist .= $lang['error_password'];
		$errors++;
	}

	if (preg_match("/[^A-z0-9]/", $_POST['character']) == 1) {
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

	if ($_POST['avatar'] == ''){
		$avatar = "[X]";
	}else{
		$avatar = $_POST['avatar'];
	}

	if (preg_match("/[^A-z0-9]/",$_POST['ref_name']) == 1) {
		$errorlist .= $lang['bad_referal'];
	}

	$refid = idstring($_GET['refid']);

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
		$RefeName		= CheckInputStrings ( $_POST['ref_name'] );
		$UserEmail      = CheckInputStrings ( $_POST['email'] );
		$UserPlanet     = CheckInputStrings ( $_POST['planet'] );

		if ($refid != ''){
			$QryInsertUser  = "UPDATE {{table}} SET ";
			$QryInsertUser .= "`refers` = `refers` + 1 ";
			$QryInsertUser .= "WHERE `id` =".mysql_real_escape_string($refid)." LIMIT 1 ; ";
			doquery( $QryInsertUser, 'users');
		}

		elseif ($refname != ''){
			$QryInsertUser  = "UPDATE {{table}} SET ";
			$QryInsertUser .= "`refers` = `refers` + 1 ";
			$QryInsertUser .= "WHERE `username` =".mysql_real_escape_string($refname)." LIMIT 1 ; ";
			doquery( $QryInsertUser, 'users');
		}

		$md5newpass     = md5($newpass);
		$shanewpass     = sha($newpass);
		$validation_code = mt_rand(10000000,99999999);
		// Creation de l'utilisateur
		$QryInsertUser  = "INSERT INTO {{table}} SET ";
		$QryInsertUser .= "`username` = '".		mysql_escape_string(strip_tags( $UserName ))	."', ";
		
		//Is he going to be the admin?
		if(mysql_num_rows(doquery("SELECT `id` FROM {{table}} LIMIT 1 ;",'users')) == 0){
			//Fist user, make admin
			$QryInsertUser .= "`authlevel` = '3', ";
		}
		$QryInsertUser .= "`referal` = '".		mysql_escape_string(strip_tags( $RefeName ))	."', ";
		$QryInsertUser .= "`validate` = '".		$validation_code								."', ";
		$QryInsertUser .= "`email` = '".		mysql_escape_string( $UserEmail )				."', ";
		$QryInsertUser .= "`email_2` = '".		mysql_escape_string( $UserEmail )				."', ";
		$QryInsertUser .= "`sex` = '".			mysql_escape_string( $_POST['sex'] )			."', ";
		$QryInsertUser .= "`lang` = '".			mysql_escape_string( $_POST['lang'] )			."', ";
		$QryInsertUser .= "`avatar` = '".		mysql_escape_string( $avatar )					."', ";
		$QryInsertUser .= "`sec_qu` = '".		mysql_escape_string( $sec_qu )					."', ";
		$QryInsertUser .= "`sec_ans` = '".		mysql_escape_string( $sec_ans )					."', ";
		$QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`register_time` = '". time() ."', ";
		$QryInsertUser .= "`password`='". $shanewpass ."';";
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

			$QrySelectGalaxy  =	"SELECT `id` ";
			$QrySelectGalaxy .= "FROM {{table}} ";
			$QrySelectGalaxy .= "WHERE ";
			$QrySelectGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
			$QrySelectGalaxy .= "`system` = '". $System ."' AND ";
			$QrySelectGalaxy .= "`planet` = '". $Planet ."' ";
			$QrySelectGalaxy .= "LIMIT 1;";
			$GalaxyRow = doquery( $QrySelectGalaxy, 'planets', true);

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
		
		//PM users
		$Message  = $lang['thanksforregistry'];
		if (sendpassemail($_POST['email'], $newpass, $UserName, $validation_code)) {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
		} else {
			$Message .= " (" . htmlentities($_POST["email"]) . ")";
			$Message .= "<br><br>". $lang['error_mailsend'] ." <b>" . $newpass . "</b>";
		}

		$Message = str_replace("{game}",$game_config['game_name'],$lang['WelcomePM']);
		PM ( $NewUser['id'], 0, $Message, $lang['Welcome'], $game_config['game_name'], 0);

		//message( $Message, $lang['reg_welldone']);

		echo "<center><font color=\"white\">";
		echo "<u>".$lang['reg_welldone']."</u><br /><br />";
		echo $Message."</font></center>";
		die();

	}
} else {
	// Afficher le formulaire d'enregistrement
	header("Location: ../");
	die();
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle
// 1.1 - Menage + rangement + utilisation fonction de creation planete nouvelle generation
?>
