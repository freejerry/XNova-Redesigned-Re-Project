<?php

//Do not this link, it is important
define(XNOVAUKLINK,"http://xnovauk.darkevo.org/");


function parsecountdown($time){
	global $lang;
	return '<span name="mrcountdown" class="'.$time.'" onmouseover="mr_tooltip(\''.$lang['fin'].' '.$lang['at'].' '.date('D M j H:i:s',$time).'\')" onmouseout="UnTip()"></span>';
}

function BrowserInfo($user_agent,$path_to_img,$echo = false){
	if (stripos($user_agent, 'Windows NT 6.0') != FALSE) {
		$OS = "Windows Vista";
		$OS_img = $path_to_img."icon_win_new.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'Windows NT 5.2') != FALSE) {
		$OS = "Windows XP";
		$OS_img = $path_to_img."icon_win_new.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'Windows NT 5.1') != FALSE) {
		$OS = "Windows XP";
		$OS_img = $path_to_img."icon_win_new.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'Windows') != FALSE) {
		$OS = "Windows";
		$OS_img = $path_to_img."icon_win_old.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'Mac OS X') != FALSE) {
		$OS = "Mac OS X";
		$OS_img = $path_to_img."icon_macos.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'Mac') != FALSE) {
		$OS = "Mac";
		$OS_img = $path_to_img."icon_macos.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'SUSE') != FALSE) {
		$OS = "OpenSUse";
		$OS_img = $path_to_img."icon_suse.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'ubuntu') != FALSE) {
		$OS = "Linux Ubuntu";
		$OS_img = $path_to_img."icon_ubuntu.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'Ubuntu') != FALSE) {
		$OS = "Linux Ubuntu";
		$OS_img = $path_to_img."icon_ubuntu.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'Linux') != FALSE) {
		$OS = "Linux";
		$OS_img = $path_to_img."icon_linux.png";
		$only1 = false;
	} elseif (stripos($user_agent, 'PlayStation Portable') != FALSE) {
		$OS = "PSP";
		$OS_img = $path_to_img."icon_playstation.png";
		$only1 = true;
	} elseif (stripos($user_agent, 'PSP') != FALSE) {
		$OS = "PSP";
		$OS_img = $path_to_img."icon_playstation.png";
		$only1 = true;
	} elseif (stripos($user_agent, 'Ericsson') != FALSE) {
		$OS = "Sony Ericsson";
		$OS_img = $path_to_img."icon_phone.png";
		$only1 = true;
	} elseif (stripos($user_agent, 'BlackBerry') != FALSE) {
		$OS = "PSP";
		$OS_img = $path_to_img."icon_phone.png";
		$only1 = true;
	} else {
		$OS = "Undetectable";
		$OS_img = $path_to_img."x.gif";
		$only1 = true;
	}

	if (stripos($user_agent, 'Flock/2') != FALSE) {
		$Browser = "Flock 2";
		$Browser_img = $path_to_img."icon_flock.png";
	} elseif (stripos($user_agent, 'Flock') != FALSE) {
		$Browser = "Flock";
		$Browser_img = $path_to_img."icon_flock.png";
	} elseif (stripos($user_agent, 'chrome') != FALSE) {
		$Browser = "Google Chrome";
		$Browser_img = $path_to_img."icon_chrome.png";
	} elseif (stripos($user_agent, 'Konqueror') != FALSE) {
		$Browser = "Konqueror";
		$Browser_img = $path_to_img."icon_konqueror.png";
	} elseif (stripos($user_agent, 'lolifox') != FALSE) {
		$Browser = "Lolifox";
		$Browser_img = $path_to_img."icon_lolifox.gif";
	} elseif (stripos($user_agent, 'Firefox/3') != FALSE) {
		$Browser = "Firefox 3";
		$Browser_img = $path_to_img."icon_firefox.png";
	} elseif (stripos($user_agent, 'Firefox/2') != FALSE) {
		$Browser = "Firefox 2";
		$Browser_img = $path_to_img."icon_firefox.png";
	} elseif (stripos($user_agent, 'Firefox') != FALSE) {
		$Browser = "Firefox";
		$Browser_img = $path_to_img."icon_firefox.png";
	} elseif (stripos($user_agent, 'pera/9') != FALSE) {
		$Browser = "Opera 9";
		$Browser_img = $path_to_img."icon_opera.png";
	} elseif (stripos($user_agent, 'pera') != FALSE) {
		$Browser = "Opera";
		$Browser_img = $path_to_img."icon_opera.png";
	} elseif (stripos($user_agent, 'Safari') != FALSE) {
		$Browser = "Safari";
		$Browser_img = $path_to_img."icon_safari.png";
	} elseif (stripos($user_agent, 'MSIE 7') != FALSE) {
		$Browser = "Internet Explorer 7";
		$Browser_img = $path_to_img."icon_ie7.png";
	} elseif (stripos($user_agent, 'MSIE 6') != FALSE) {
		$Browser = "IE6";
		$Browser_img = $path_to_img."icon_ie5.png";
	} elseif (stripos($user_agent, 'MSIE') != FALSE) {
		$Browser = "IE";
		$Browser_img = $path_to_img."icon_ie5.gif";
	} else {
		$Browser = "Undetectable";
		$Browser_img = $path_to_img."x.gif";
	}

	$output['osys']['txt'] = $OS;
	$output['osys']['img'] = $OS_img;
	$output['brws']['txt'] = $Browser;
	$output['brws']['img'] = $Browser_img;
	$output['only']['one'] = $only1;

	if($echo == true){
		//not yet programmed
	}else{
		return $output;
	}
}

?>
