<?php

/**
 * resources.php
 *
 * @version 1.0
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	$Page = BuildRessourcePage ( $user, $planetrow );
	display( $Page, $lang['Resources'] );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour utilisation XNova
?>
