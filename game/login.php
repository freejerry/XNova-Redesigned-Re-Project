<?php

/**
 * login.php
 *
 * @version 1.0
 * @copyright 2008 by ?????? for XNova
 */
session_start(); 
 
if($_POST['verified'] != 1)
  header('Location: ../');
define('INSIDE'		, true);
define('INSTALL'	, false);
define('LOGIN'		, true);

$InLogin = true;


if($_POST && in_array('uni',array_keys($_POST))){ $_GET['s'] = preg_replace("/[^0-9]/", "", $_POST['uni']); }

define('ROOT_PATH' , '');
include_once(ROOT_PATH . 'common.php');

getLang('login');

//Redirect standard
$redirect = './';
if($_GET['go']){ $redirect = str_replace('--','&',$_GET['go']); }

//Unencrypted by default
$pw_encrypted = false;

//If we are using get to login, not recomended as password will show up in history
if($_GET['GET_LOGIN']){	$_POST = $_GET; $pw_encrypted = true; }

@include('config'.UNIVERSE.'.php');
if(!empty($_COOKIE[$game_config['COOKIE_NAME']]))
{
  $cookie_tmp = explode('/%/',$_COOKIE[$game_config['COOKIE_NAME']]);
  if($cookie_tmp[3]=='1')
  {
    $UserValidate = doquery("SELECT id,username,password FROM {{table}} WHERE id='$cookie_tmp[0]' and username='$cookie_tmp[1]'", 'users', true);
    if(is_resource($UserValidate))
    {
      if(sha($UserValidate['password']."--".$dbsettings['secretword'])==$cookie_tmp[2])
      {
        header("Location: ".AddUniToString($redirect));
      }  
    }
  }
}

if ($_POST) {

	$login = doquery("SELECT * FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['username']) . "' LIMIT 1", "users", true);
	if ($login) {
		if(!$pw_encrypted){ $_POST['password'] = sha($_POST['password']); }
		if ($login['password'] == $_POST['password']) {
			if (isset($_POST["rememberme"])) {
				$expiretime = time() + 31536000;
				$rememberme = 1;
			} else {
				$expiretime = 0;
				$rememberme = 0;
			}

			@include('config'.UNIVERSE.'.php');
			$cookie = $login["id"] . "/%/" . $login["username"] . "/%/" . sha($login["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme;
			setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "../", "", 0);

			unset($dbsettings);
			header("Location: ".AddUniToString($redirect));
			exit;
		} else {
			header("Location: ".AddUniToString('./login.php?bad=Password'));
		}
	} else {
		header("Location: ".AddUniToString('./login.php?bad=Username'));
	}
} elseif($old) {
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
		header('location: http://darkevo.org/');
	}
}else{
	define('GAME_SKIN',DEFAULT_SKIN);
	
	$parse = $lang;
	$parse['s'] = UNIVERSE;
	if($_GET['bad']){
		$parse['bad'] = $lang[$_GET['bad']];
	}else{
		$parse['bad'] = $lang['Something'];
	}
	
	$parse['shortname'] = $game_config['game_name'];
	echo AddUniToLinks(parsetemplate(gettemplate('login/login'), $parse));
}

// -----------------------------------------------------------------------------------------------------------
// History version

?>
