<?php

/**
 * check.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova Redesigned
 */
 
define('INSIDE'		, true);
define('INSTALL'	, false);
define('LOGIN'		, true);
define('ROOT_PATH'	, './');

if(!$_GET['s']){
	$_GET['s'] = 1;
}

$InLogin = true;
include(ROOT_PATH . 'common.php');

$unused = false;
if($_GET['img'] == 'good'){
	$good = true;
}elseif($_GET['img'] == 'bad'){
	$good = false;
}elseif($_GET['img'] == 'no'){
	$unused = true;
}elseif($_GET['check'] == 'user'){
	$username = $_GET['username']; // get the username
	$username = trim(htmlentities($username)); // strip some crap out of it
	$ExistUser = $sql->doquery("SELECT `username` FROM {{table}} WHERE `username` = '". $sql->real_escape_string($username) ."' LIMIT 1;", 'users', true);
	if(!$_GET['username']){
		$good = false;
	}elseif($ExistUser){
		$good = false;
	}elseif (preg_match("/[^A-z0-9_\-]/", $_GET['username']) == 1) {
		$good = false;
	}else{
		$good = true;
	}
}elseif($_GET['check'] == 'pass'){
	if(strlen($_GET['password']) < 7){
		$good = false;
	}else{
		$good = true;
	}
}elseif($_GET['check'] == 'email'){
	$email = trim(htmlentities($_GET['email'])); // strip some crap out of it
	$ExistEmail = $sql->doquery("SELECT `email` FROM {{table}} WHERE `email` = '". $sql->real_escape_string($email) ."' LIMIT 1;", 'users', true);
	if(!is_email($_GET['email'])){
		$good = false;
	}elseif($ExistEmail){
		$good = false;
	}else{
		$good = true;
	}
}elseif($_GET['check'] == 'tos'){
	if($_GET['tos'] != 'true'){
		$good = false;
	}else{
		$good = true;
	}
}elseif($_GET['check'] == 'refer'){
	$username = $_GET['refer']; // get the username
	$username = trim(htmlentities($username)); // strip some crap out of it
	$ExistUser = $sql->doquery("SELECT `username` FROM {{table}} WHERE `username` = '". $sql->real_escape_string($username) ."' LIMIT 1;", 'users', true);
	if($_GET['refer'] == ''){
		$unused = true;
	}elseif($ExistUser){
		$good = true;
	}else{
		$good = false;
	}
}elseif($_GET['check'] == 'quans'){
	$string = $_GET['string']; // get the username
	if($string == ''){
		$unused = true;
	}elseif(preg_match("/[^A-z0-9 ]/",$string) == 1) {
		$good = false;
	}else{
		$good = true;
	}
}elseif($_GET['check'] == 'planet'){
	$g = $sql->idstring($_GET['g']);
	$s = $sql->idstring($_GET['s']);
	$p = $sql->idstring($_GET['p']);
	$t = $sql->idstring($_GET['t']);
	$ExistPl = doquery("SELECT `id` FROM {{table}} WHERE `galaxy` = '".$g."' AND `system` = '".$s."' AND `planet` = '".$p."' AND `planet_type` = '".$t."' LIMIT 1;", 'planets', true);
	if($ExistPl['id'] > 0){
		$good = false;
	}else{
		$good = true;
	}
}elseif($_GET['check'] == 'planetopp'){
	$g = $sql->idstring($_GET['g']);
	$s = $sql->idstring($_GET['s']);
	$p = $sql->idstring($_GET['p']);
	$t = $sql->idstring($_GET['t']);
	$ExistPl = doquery("SELECT `id` FROM {{table}} WHERE `galaxy` = '".$g."' AND `system` = '".$s."' AND `planet` = '".$p."' AND `planet_type` = '".$t."' LIMIT 1;", 'planets', true);
	if($ExistPl['id'] > 0){
		$good = true;
	}else{
		$good = false;
	}
}
if($unused){
	$image = "./check/no.gif";
}elseif ($good){
	$image = "./check/ok.gif";
}else{
	$image = "./check/err.gif";
}
//New part, echo te image
echo "<image src=\"".$image."\" width=\"16\" height=\"14\" />";
//Old part, generated the image, now we just link it.
/*
//Load the image
$img = ImageCreateFromGif($image);
//Convert to PNG and send it to browser
if($img) {
	header("Content-Type: image/gif");
	ImageGIF($img);
	//Clean-up memory
	ImageDestroy($img);
}
*/
?>
