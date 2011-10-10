<?php


/**
 * constants.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------------

if ( defined('INSIDE') ) {
   //There are constant to the user, but not constant to the game, eg a users max planets is constant to that user, at least its constand for then 0.01 seconds in which the pageis generated
   define('MAX_PLAYER_PLANETS',ceil($user[$resource[124]]/2)+1);
}


?>
