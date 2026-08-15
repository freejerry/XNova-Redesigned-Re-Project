<?php

/**
 * aks.php
 *
 * @version 1.0
 * @copyright 2008 by Anthony (MadnessRed) for Darkness of Evolution
 * 
 * Made from scratch by Anthony (MadnessRed) http://madnessred.co.cc/
 * This file is under the GPL license which must be included wit this file.
 *
 * You may not edit this comment block. You may not copy any part of this file into any other file with out copying this comment block with it and placing it above any code there might be.
 */
define('INSIDE'  , true);
define('NO_MENU' , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

$parse['this_page'] = "";
$n = 1;
$delete = true;

die("Script Disabled");

$qry = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC ;",'lunas') or die(mysql_error());
while($row = mysql_fetch_assoc($qry)){
	
	$qry2 = doquery("SELECT `id` FROM {{table}} WHERE `galaxy` =".$row['galaxy']." AND `system` =".$row['system']." AND `planet` =".$row['lunapos']." AND `planet_type` =3 ;",'planets') or die(mysql_error());
	$numrows = mysql_num_rows($qry2);

	if($numrows == 0){
		if($delete == true){
			doquery("DELETE FROM {{table}} WHERE `id` = ".$row['id']." LIMIT 1",'lunas');
			printf("DELETE FROM {{table}} WHERE `id` = ".$row['id']." LIMIT 1",'lunas');
			echo "<br />";
		}else{
			printf("DELETE FROM {{table}} WHERE `id` = ".$row['id']." LIMIT 1",'lunas');
			echo "<br />";
		}
	}else{
		$parse['this_page'] .= $n." - Fine<br />";
	}
	$n++;
}


$qry = doquery("SELECT `id_planet` FROM {{table}} ORDER BY `id_planet` ASC ;",'galaxy') or die(mysql_error());
while($row = mysql_fetch_assoc($qry)){
	
	$qry2 = doquery("SELECT `id` FROM {{table}} WHERE `id` =".$row['id_planet']." ;",'planets') or die(mysql_error());
	$numrows = mysql_num_rows($qry2);

	if($numrows == 0){
		if($delete == true){
			doquery("DELETE FROM {{table}} WHERE `id_planet` = '".$row['id_planet']."' LIMIT 1",'galaxy');
			printf("DELETE FROM {{table}} WHERE `id_planet` = '".$row['id_planet']."' LIMIT 1",'galaxy');
			echo "<br />";
		}else{
			printf("DELETE FROM {{table}} WHERE `id_planet` = '".$row['id_planet']."' LIMIT 1",'galaxy');
			echo "<br />";
		}
	}else{
		$parse['this_page'] .= $n." - Fine<br />";
	}
	$n++;
}


$qry = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC ;",'lunas') or die(mysql_error());
while($row = mysql_fetch_assoc($qry)){
	
	$qry2 = doquery("SELECT * FROM {{table}} WHERE `galaxy` =".$row['galaxy']." AND `system` =".$row['system']." AND `planet` =".$row['lunapos']." AND `id_luna` >0 ;",'galaxy') or die(mysql_error());
	$numrows = mysql_num_rows($qry2);

	if($numrows == 0){
		if($delete == true){
			doquery("UPDATE {{table}} SET `id_luna` =0 WHERE `galaxy` =".$row['galaxy']." AND `system` =".$row['system']." AND `planet` =".$row['lunapos']." ;",'galaxy') or die(mysql_error());
			printf("UPDATE {{table}} SET `id_luna` =0 WHERE `galaxy` =".$row['galaxy']." AND `system` =".$row['system']." AND `planet` =".$row['lunapos']." ;");
			echo "<br />";
		}else{
			printf("UPDATE {{table}} SET `id_luna` =0 WHERE `galaxy` =".$row['galaxy']." AND `system` =".$row['system']." AND `planet` =".$row['lunapos']." ;");
			echo "<br />";
		}
	}else{
		$parse['this_page'] .= $n." - Fine<br />";
	}
	$n++;
}


$qry = doquery("SELECT `id_planet` FROM {{table}} ORDER BY `id_planet` ASC ;",'galaxy') or die(mysql_error());
while($row = mysql_fetch_assoc($qry)){
	
	$qry2 = doquery("SELECT `id` FROM {{table}} WHERE `id` =".$row['id_planet']." ;",'planets') or die(mysql_error());
	$numrows = mysql_num_rows($qry2);

	if($numrows == 0){
		if($delete == true){
			doquery("DELETE FROM {{table}} WHERE `id_planet` = '".$row['id_planet']."' LIMIT 1",'galaxy');
			printf("DELETE FROM {{table}} WHERE `id_planet` = '".$row['id_planet']."' LIMIT 1",'galaxy');
		}else{
			printf("DELETE FROM {{table}} WHERE `id_planet` = '".$row['id_planet']."' LIMIT 1",'galaxy');
			echo "<br />";
		}
	}else{
		$parse['this_page'] .= $n." - Fine<br />";
	}
	$n++;
}

display(parsetemplate(gettemplate('basic_page'), $parse), "Test", false);
die();

?>