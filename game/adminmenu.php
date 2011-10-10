<?php

/**
 * adminmenu.php
 *
 * @version 1.2
 * @copyright 2008 By Chlorel for XNova
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */

function ShowLeftMenu($cpage = 'x') {
	global $lang;

	$qry = doquery("SELECT COUNT('error_id') as `errors` FROM {{table}}",'errors',true);
	$errorscount = $qry['errors'];
	$qry = doquery("SELECT `id` FROM {{table}} WHERE `status` = 1 || `status` = 2 ;",'supp');
	$ticketcount = mysql_num_rows($qry);

	$info = @file(XNOVAUKLINK."info.php");
	if($info[0] != VERSION."\n"){ $newversion = colourRed("(*)"); }

	$adminpages = array(
	'overview' => 'Overview '.$newversion,
	'config' => 'Configuration',
	'edit' => 'Manage Users',
	'errors' => 'Errors ('.$errorscount.')',
	'supp' => 'Tickets ('.$ticketcount.')'
	);

	getLang('menu');

	$parse = $lang;
	$parse['links'] = '';
	foreach ($adminpages as $get => $title){
		$parse['links'] .= '
		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img src="'.GAME_SKIN.'/img/navigation/navi_ikon_premium_b.gif" height="29" width="38" />
		  	</span>
			<a class="menubutton" href="./?page=admin&link='.$get.'" title=\''.$title.'\' tabindex="1">
				<span class="textlabel">'.$title.'</span>
			</a>
		</li>
		';
	}


	$Menu                  = parsetemplate(gettemplate('redesigned/adminmenu'),$parse);

	return $Menu;
}
	//$Menu = ShowLeftMenu ( $user['authlevel'] );
	//display ( $Menu, "Menu", '', false );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour XNova version future
// 1.1 - Modification pour gestion Admin / Game OP / Modo
// 1.2 - Modified to support the new redesign. Now longer a standalone page.
?>
