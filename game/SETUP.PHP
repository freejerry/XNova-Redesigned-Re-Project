<?php

/**
 * SETUP.PHP
 *
 * @version 1
 * @copyright 2008 By MadnessRed for XNova Redesigned
 */

//Here you should set up the core features of the game.

if(!defined('INSIDE')){ die(); } //Please ignore this, it is just a security measure.

//Admin email - this will be given as the contact email.
define('ADMINEMAIL'			, "madnessred@xnovauk.com");

//Admin name - this will be how game emails are signed.
define('ADMIN_NAME'			, "XNova Redesigned Team");

//How do we get to the files from the domain, eg if your game was at "www.examlpe.com/xnova/" you would simply enter "xnova/" here.
//(note for the install script to work, this next line MUST BE 22)
define('PATH_TO_FILES'		, "redesigned/");

//GameURL, the url of the game. Probably best to leave this.
define('BASEURL'			, "http://".$_SERVER['HTTP_HOST']."/".PATH_TO_FILES);

//GameURL, the url of the game. Probably best to leave this.
define('GAMEURL'			, BASEURL."game/");

//LoginURL, where do you want users to go when they are logged out.
define('LOGINURL'			, "../");

//Payment setup
//This is where we setup the payment process.
//(note for the install script to work, these next line MUST BE 36 and 37)
define('PAYSYSTEM_PUBLIC'	, '');
define('PAYSYSTEM_PRIVATE'	, '');


//Battle engine - which battle engine should we use
//padacombat - php battleengine
define('BATTLE_ENGINE'		, 'python');

//Multi-universe type. Here you must choose what multi-universe upport you want.
// "domain" - Use this when you wil have several sub-domains or domains pointing to these files. eg uni1.game.org, uni2.game.org, the game van get teh universe from the domain.
// "get" - Use this when you have one set of files with 1 domain, here the game will get the domain from a get url, eg inex.php?s=1, this will be done automatically by the game
// [number] - if this set of files will be used by just one universe, then simply enter the universe number here. eg 1 if this was uni1, or 2 if this was uni2
define('UNITTYPE'			, 1);

//Some basic multi uni support
if(UNITTYPE == "domain"){
	//What part of the domain do you want to use? (www will be ignored)
	//eg
	//http://subdomain.domain.tld/
	//           0        1    2
	//eg2
	//http://domain.tld/
	//          0    1
	//eg3
	//http://subdomain.subdomain.domain.tld/
	//           0         1        2    3
	define('UNI_IN_DOMAIN'	, 0);
}elseif(UNITTYPE == "get"){
	//All urls in the game will look similar to the following: http://domain.com/game/?getval=1&page=overivew
	//What would you like to use instead of "getval"
	define('GETVAL'			, 's');
}
