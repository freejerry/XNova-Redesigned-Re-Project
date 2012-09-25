<?php
/*
 * galaxy.php
 *
 * @version 1.3
 * @copyright 2008 by Chlorel for XNova
 *
*/

includeLang('galaxy');
getLang('galaxy');

// Get the mode
$mode = idstring($_GET['mode']);

if($mode == 1) {
	//We are browsing galaxy, so what gal / sys
	$galaxy =  idstring($_GET["galaxy"]);
	$system =  idstring($_GET["system"]);
	
} else {
	// Well we have just got to galaxy, so show the homeworld
	$galaxy        = $planetrow['galaxy'];
	$system        = $planetrow['system'];
}

$bloc['galaxy_head'] = ShowGalaxySelector($galaxy,$system);
$bloc['galaxy_rows'] = ShowGalaxyRows($galaxy,$system);

//Footer
$bloc['res209'] = $planetrow[$resource[209]];
$bloc['res210'] = $planetrow[$resource[210]];
$bloc['res503'] = $planetrow[$resource[503]];
$bloc['curfleets'] = doquery("SELECT COUNT(fleet_id) as count FROM {{table}} WHERE `owner_userid` = '". $user['id'] ."';", 'fleets',true);
$bloc['curfleets'] = $bloc['curfleets']['count'];

//Current gal/sys
$bloc['cgal'] = $galaxy;
$bloc['csys'] = $system;

$page = parsetemplate(gettemplate('galaxy/galaxy_div'), $bloc);

/*
$userally = doquery("SELECT `relations` FROM {{table}} WHERE `id` = '".$user['ally_id']."' LIMIT 1 ;",'alliance',true);
$relations = explode(";",$userally['relations']);
$replace_a = explode(",",$relations[0]);
$with_a = explode(",",$relations[1]);

foreach ($replace_a as $n => $a){
	$replace = $replace_a[$n];
	$with = "<font color=".relations($with_a[$n],'colour').">".$replace_a[$n]."</font>";
	$page = str_replace($replace, $with, $page);
}
*/

if($_GET['axah']){
	makeAXAH($page);
}else{
	displaypage ($page, $lang['Galaxy'], $onload);
}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Created by Perberos
// 1.1 - Modified by -MoF- (UGamela germany)
// 1.2 - 1er Nettoyage Chlorel ...
// 1.3 - 2eme Nettoyage Chlorel ... Mise en fonction et debuging complet
?>
