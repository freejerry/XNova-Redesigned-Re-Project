<?php

/**
 * CheckCookies.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */
// TheCookie[0] = `id`
// TheCookie[1] = `username`
// TheCookie[2] = Password + Hashcode
// TheCookie[3] = Remember me?


function CheckCookies($userchecked){
	global $lang, $game_config, $basic_pages, $sql, $_GET, $_SERVER;
	
	//Get required lanuage strings
	getLang('cookies');
	
	//Check the cookie exists
	if(isset($_COOKIE[$game_config['COOKIE_NAME']])){
		
		//Sepparate the cookie
		$usercookie = explode("/%/", $_COOKIE[$game_config['COOKIE_NAME']]);
		
		//Get the user id
		$userid = $sql->id_from_username($usercookie[1]);
		
		//Check it is a valid id
		if(intval($userid) == 0){
			//Now, we have a duff cookie, how about we stop getting devs to tell users to clear cookies and do it ourself
			ExpireCookie();
			
			//Could not find a user with the username specified in the cookie.
			message(sprintf($lang['cookie_nosuchuser'],cleanstring($usercookie[1])));
			
			//Just to be sure
			die();
		}
		
		//Load the user then
		$userclass = new user($userid);
		
		//Check the user id
		if($userclass->id != $usercookie[0]){
			//ID in database differs to id in cookie, Remove the bad cookie
			ExpireCookie();
			
			//Message
			message($lang['cookie_nosuchid']);
			
			//Just to be sure
			die();
		}
		
		//Check the password
		if(sha($userclass->password . "--" . $sql->dbsettings["secretword"]) !== $usercookie[2]) {
			//Password in database differs to password in cookie, Remove the bad cookie
			ExpireCookie();
			
			//Message
			message($lang['cookie_nosuchpass']);
			
			//Just to be sure
			die();
		}
		
		//Put the cookie back together again
		$newcookie = implode("/%/", $usercookie);
		
		//Expire time, (0 expires when browser closed)
		$cookietime = ($usercookie[3] == 1 ? time() + 31536000 : 0);
		
		//If user is no checked, resubmit cookie
		if(!$userchecked)
			UpdateCookie($newcookie, $cookietime);
		
		//Update the user
		if(SMALL_LOAD){
			//Just a small query
			$sql->doquery("UPDATE {{table}} SET `onlinetime` = '". time() ."' WHERE `id` = '". $sql->idstring($userclass->id) ."' LIMIT 1;", 'users');
		}else{
			//Do the full query
			$query  = "UPDATE {{table}} SET ";
			$query .= "`onlinetime` = '". time() ."', ";
			$query .= "`current_page` = '". $sql->real_escape_string($_GET['page']) ."', ";
			$query .= "`user_lastip` = '". $sql->real_escape_string($_SERVER['REMOTE_ADDR']) ."', ";
			$query .= "`user_agent` = '". $sql->real_escape_string($_SERVER['HTTP_USER_AGENT']) ."' ";
			$query .= "WHERE ";
			$query .= "`id` = '". $sql->idstring($userclass->id) ."' LIMIT 1;";
			$sql->doquery($query, 'users');
		}
		
		//User is now checked
		$userchecked = true;
	}
	
	$return['state'] = $userchecked;
	$return['class'] = $userclass;
	return $return;
}

//If we ever need to remove the cookie, log out, of if cookie is wrong.
function ExpireCookie(){
	global $game_config;
	setcookie($game_config['COOKIE_NAME'],'',time());
}

function UpdateCookie($newcookie, $cookietime){
	global $game_config;
	return @setcookie ($game_config['COOKIE_NAME'], $newcookie, $cookietime, "/", "", False, True) or setcookie ($game_config['COOKIE_NAME'], $newcookie, $cookietime, "/", "", False);
}

?>
