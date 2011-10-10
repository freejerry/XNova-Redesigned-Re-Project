<?php

/**
 * aks.php
 *
 * @version 1.0
 * @copyright 2008 by Anthony (MadnessRed) for Darkness of Evolution
 * 
 * Made from scratch by Anthony (MadnessRed) http://madnessred.co.cc/
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

$parse['this_page'] = '';

if($_POST['stage'] == "1"){

	//GET Search Type
	if($_POST['method'] == "name"){
		$name = "`name` = '".$_POST['planet_name']."' AND ";
	}elseif($_POST['method'] == "coord"){
		$gal  = "`galaxy` = '".$_POST['planet_gal']."' AND ";
		$sys  = "`system` = '".$_POST['planet_sys']."' AND ";
		$pla  = "`planet` = '".$_POST['planet_pla']."' AND ";
	}else{
		if(strlen($_POST['planet_name']) > 0){ $name = "`name` = '".$_POST['planet_name']."' AND "; }
		if(strlen($_POST['planet_gal']) > 0){ $gal  = "`galaxy` = '".$_POST['planet_gal']."' AND "; }
		if(strlen($_POST['planet_sys']) > 0){ $sys  = "`system` = '".$_POST['planet_sys']."' AND "; }
		if(strlen($_POST['planet_pla']) > 0){ $pla  = "`planet` = '".$_POST['planet_pla']."' AND "; }
	}
	$query_get_planets = "SELECT * FROM {{table}} WHERE ".$name.$gal.$sys.$pla."`destruyed` = '0'";
	$parse['this_page'] .= $query_get_planets;
	$get_planets = doquery($query_get_planets,'planets');
	
	$parse['this_page'] .= "<table>";
	$parse['this_page'] .= "<tr><th><font color=\"red\">Player ID</font></th><th>Planet Name</th><th>Galaxy</th><th>System</th><th>Planet</th></tr>";
	while ($p = mysql_fetch_assoc($get_planets)) {
		$parse['this_page'] .= "<tr><th>".$p['id_owner']."</th><th>".$p['name']."</th><th>".$p['galaxy']."</th><th>".$p['system']."</th><th>".$p['planet']."</th></tr>";
	}
	$parse['this_page'] .= "</table><br /><br />";
	
	$parse['this_page'] .= '<form action="" method="POST">
Insert the Player ID of the planet he owns: <input type="text" name="user_id" size="5" /><br />
Insert the Player Name: <input type="text" name="user_name" size="25" /><br />

<input type="submit" value="Restore Planets" /><input type="hidden" name="stage" value="2" /><br />';
		
		
}elseif($_POST['stage'] == "2"){


	$query_update_user = "UPDATE {{table}} SET `id`='".$_POST['user_id']."' WHERE `username`='".$_POST['user_name']."' ;";
	$parse['this_page'] .= $query_update_user;
	$update_user = doquery($query_update_user,'users');

		
		
}else{
$parse['this_page'] .= '<form action="" method="POST">
<input type="radio" name="method" value="both" checked /> Search by Planet Name and Co-Ordinates<br /><hr /><br />

<input type="radio" name="method" value="name" /> Search by Planet Name<br />
Planet Name: <input type="text" name="planet_name" size="40" /><br />

<hr /><br />

<input type="radio" name="method" value="coord" /> Search by Co-Ordinates<br />
Galaxy: <input type="text" name="planet_gal" size="5" /><br />
System: <input type="text" name="planet_sys" size="5" /><br />
Planet: <input type="text" name="planet_pla" size="5" /><br />

<hr />
<input type="submit" value="Restore Planets" /><input type="hidden" name="stage" value="1" /><br />';
}

	display(parsetemplate(gettemplate('basic_page'), $parse), $page_title, false);
	die();
?>