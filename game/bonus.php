<?php

/**
 * bonus.php
 *
 * @version 1.0
 * @copyright 2008 by Anthony for XNova Redesigned
 */

define('INSIDE'  , true);
define('INSTALL' , false);

define('ROOT_PATH' , '');
include_once(ROOT_PATH . 'common.php');


//Firstly add moon to homeworld
$homeworld = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['id_planet']."' LIMIT 1 ;",'planets',true);
AddMoon($homeworld['galaxy'],$homeworld['system'],$homeworld['planet'],20,'Free moon',$homeworld);


//Now give commander
doquery("UPDATE {{table}} SET `off_command_exp` = '".(time() + (60 * 60 * 24 * 30 * 3))."' WHERE `id` = '".$user['id']."' ;",'users');

?>
There is now a moon in orbit around your homeworld and you have commander for free for 3 months.
