<?php

/**
 * CheckUser.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function CheckTheUser ( $IsUserChecked ) {
	global $user;
	includeLang('admin');
	$Result        = CheckCookies( $IsUserChecked );
	$IsUserChecked = $Result['state'];


	if ($Result['class'] != false) {
		$user = $Result['class'];
		if ($user->banned_until > time()) {
			if(!defined('VIEW_BANNED')){
				getLang('ban');
				info($lang['Your_Nanned'],$lang['Banned'],"./?page=pillory","./?page=pillory");
			}
		}
		$RetValue['class'] = $user;
		$RetValue['state']  = $IsUserChecked;
	} else {
		$RetValue['class'] = array();
		$RetValue['state']  = false;
	}

	return $RetValue;
}


?>
