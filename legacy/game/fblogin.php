<?php

/**
 * login.php
 *
 * @version 1.0
 * @copyright 2008 by ?????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('LOGIN'   , true);

$InLogin = true;

$xnova_root_path = '';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

require_once '../'.$xnova_root_path.'facebook/php/facebook.php';
require_once '../'.$xnova_root_path.'facebook/functions.php';
$facebook = new Facebook($appapikey, $appsecret);
$facebook_id = $facebook->require_login();

	includeLang('login');

	if ($_GET) {
		$login = doquery("SELECT * FROM {{table}} WHERE `id` = '" . mysql_escape_string($_GET['id']) . "' LIMIT 1", "users", true);

		if ($login) {
			if ($login['facebook_id'] == $facebook_id) {
				if (isset($_POST["rememberme"])) {
					$expiretime = time() + 31536000;
					$rememberme = 1;
				} else {
					$expiretime = 0;
					$rememberme = 0;
				}

				@include('config.php');
				$cookie = $login["id"] . "/%/" . $login["username"] . "/%/" . md5($login["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme;
				setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0);

				unset($dbsettings);
				header("Location: ./?s=".UNI);
				exit;
			} else {
				message($lang['Login_FailPassword'], $lang['Login_Error']);
			}
		} else {
			message($lang['Login_FailUser'], $lang['Login_Error']);
		}
	} else {
		$parse                 = $lang;
		$Count                 = doquery('SELECT COUNT(*) as `players` FROM {{table}} WHERE 1', 'users', true);
		$LastPlayer            = doquery('SELECT `username` FROM {{table}} ORDER BY `register_time` DESC', 'users', true);
		$parse['last_user']    = $LastPlayer['username'];
		$PlayersOnline         = doquery("SELECT COUNT(DISTINCT(id)) as `onlinenow` FROM {{table}} WHERE `onlinetime` > '" . (time()-900) ."';", 'users', true);
		$parse['online_users'] = $PlayersOnline['onlinenow'];
		$parse['users_amount'] = $Count['players'];
		$parse['servername']   = $game_config['game_name'];
		$parse['forum_url']    = $game_config['forum_url'];
		$parse['PasswordLost'] = $lang['PasswordLost'];

		$page = parsetemplate(gettemplate('login_body'), $parse);

		// Test pour prendre le nombre total de joueur et le nombre de joueurs connect�s
		if ($_GET['ucount'] == 1) {
			$page = $PlayersOnline['onlinenow']."/".$Count['players'];
			die ( $page );
		} else {
			//display($page, $lang['Login']);
			header('location: ../');
		}
	}

// -----------------------------------------------------------------------------------------------------------
// History version

?>