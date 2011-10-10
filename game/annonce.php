<?php

/**
 * Editd by Anthony
 *
 * I have translated this page into English
 *
 * Copyright 2008 by MadnessRed
 */

/**
 * annonce.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

if ($game_config['enable_announces'] == 0) {
	message("Market disabled");
}

$users   = doquery("SELECT * FROM {{table}} WHERE id='".addslashes($user['id'])."';", 'users');
$planets = doquery("SELECT id, id_owner, galaxy, system, planet, metal, crystal, deuterium FROM {{table}}  WHERE id_owner='".addslashes($user['id'])."' ", "planets");
$annonce = doquery("SELECT * FROM {{table}} ", 'annonce');
$action  = addslashes($_GET['action']);

if ($action == 5) {
	$metalvendre = $_POST['metalvendre'];
	$cristalvendre = $_POST['cristalvendre'];
	$deutvendre = $_POST['deutvendre'];

	$metalsouhait = $_POST['metalsouhait'];
	$cristalsouhait = $_POST['cristalsouhait'];
	$deutsouhait = $_POST['deutsouhait'];

	$usern 		= $user['username'];
	$galaxie 	= $user['galaxy'];
	$systeme 	= $user['system'];
	$planet_id 	= $user['current_planet'];

	doquery("INSERT INTO {{table}} SET
user='{$usern}',
galaxie='{$galaxie}',
systeme='{$systeme}',
planet_id='{$planet_id}',
metala='{$metalvendre}',
crystala='{$cristalvendre}',
deuta='{$deutvendre}',
metals='{$metalsouhait}',
crystals='{$cristalsouhait}',
deuts='{$deutsouhait}'" , "annonce");

		
//	doquery ("UPDATE {{table}} SET `metal` = `metal` - '".$metalvendre."' WHERE `id` = '".$planet_id."' ;" , 'planets') or die(mysql_error);
//	doquery ("UPDATE {{table}} SET `crystal` = `crystal` - '".$cristalvendre."' WHERE `id` = '".$planet_id."' ;" , 'planets') or die(mysql_error);
//	doquery ("UPDATE {{table}} SET `deuterium` = `deuterium` - '".$deutvendre."' WHERE `id` = '".$planet_id."' ;" , 'planets') or die(mysql_error);		
	
	$page2 .= <<<HTML
<center>
<br>
<p>Your request has been added.</p>
<br><p><a href="annonce.php">Return to trades</a></p>

HTML;

	display($page2);
}

elseif ($action == 4) {

	$annonce4 = doquery ("SELECT * FROM {{table}} WHERE `id` = ".mysql_escape_string($_POST['trade'])." ;", 'annonce');
	
	while ($b = mysql_fetch_array($annonce4)) {
		
		//$b["metala"];
		//$b["crystala"];
		//$b["deuta"];
		
		//$b["metals"];
		//$b["crystals"];
		//$b["deuts"];
		
		doquery ("UPDATE `evo1_planets` SET `metal` = `metal` - '".$b["metala"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets')
			or die("UPDATE {{table}} SET `metal` = `metal` - '".$b["metala"]."' WHERE `id` = ".$_POST['seller']." ;");
		doquery ("UPDATE {{table}} SET `crystal` = `crystal` - '".$b["crystala"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets')
			or die(mysql_error);
		doquery ("UPDATE {{table}} SET `deuterium` = `deuterium` - '".$b["deuta"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets')
			or die(mysql_error);
		
		doquery ("UPDATE {{table}} SET `metal` = `metal` + '".$b["metals"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets')
			or die(mysql_error);
		doquery ("UPDATE {{table}} SET `crystal` = `crystal` + '".$b["crystals"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets')
			or die(mysql_error);
		doquery ("UPDATE {{table}} SET `deuterium` = `deuterium` + '".$b["deuts"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets')
			or die(mysql_error);
		
	//	doquery ("UPDATE {{table}} SET `metal` = `metal` + '".$b["metala"]."' WHERE `id` = ".$_POST['buyer']." ;" , 'planets')
	//		or die(mysql_error);
	//	doquery ("UPDATE {{table}} SET `crystal` = `crystal` + '".$b["crystala"]."' WHERE `id` = ".$_POST['buyer']." ;" , 'planets')
	//		or die(mysql_error);
	//	doquery ("UPDATE {{table}} SET `deuterium` = `deuterium` + '".$b["deuta"]."' WHERE `id` = ".$_POST['buyer']." ;" , 'planets')
	//		or die(mysql_error);		
		
		doquery ("UPDATE {{table}} SET `metal` = `metal` - '".$b["metals"]."' WHERE `id` = ".$_POST['buyer']." ;" , 'planets')
			or die(mysql_error);
		doquery ("UPDATE {{table}} SET `crystal` = `crystal` - '".$b["crystals"]."' WHERE `id` = ".$_POST['buyer']." ;" , 'planets')
			or die(mysql_error);
		doquery ("UPDATE {{table}} SET `deuterium` = `deuterium` - '".$b["deuts"]."' WHERE `id` = ".$_POST['buyer']." ;" , 'planets')
			or die(mysql_error);
	
	}
	
	doquery ("DELETE FROM {{table}} WHERE `id` = ".$_POST['trade']." ;", 'annonce') or die(mysql_error);

	$page2 .= <<<HTML
<center>
<br>
<p>Transaction Completed</p>
<br><p><a href="annonce.php">Return to trades</a></p>

HTML;

	display($page2);
}

elseif ($action == 3) {

	$annonce3 = doquery ("SELECT * FROM {{table}} WHERE `id` = ".$_POST['trade']." ;", 'annonce');
	
	//while ($b = mysql_fetch_array($annonce4)) {
		
	
	//	doquery ("UPDATE {{table}} SET `metal` = `metal` + '".$b["metala"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets');
	//	doquery ("UPDATE {{table}} SET `crystal` = `crystal` + '".$b["crystala"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets');
	//	doquery ("UPDATE {{table}} SET `deuterium` = `deuterium` + '".$b["deuta"]."' WHERE `id` = ".$_POST['seller']." ;" , 'planets');		
	

	//}


	doquery ("DELETE FROM {{table}} WHERE `id` = ".$_POST['trade']." ;", 'annonce');

	$page2 .= <<<HTML
<center>
<br>
<p>Your request has been deleted.</p>
<br><p><a href="annonce.php">Return to trades</a></p>

HTML;

	display($page2);
}



else

{
	$annonce = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC ", "annonce");

	$page2 = "<HTML>
<center>
<br>
<table width=\"517\">

<td class=\"c\" colspan=\"10\">
<font color=\"#FFFFFF\">In-Game Trades</font>
</td></tr>

<tr>
<th colspan=\"3\">Trader Information</th>
<th colspan=\"3\">Ressources for sale</th>
<th colspan=\"3\">Ressources wanted</th>
<th>Action</th>
</tr>

<tr>
<th>Name</th>
<th>Galaxy</th>
<th>System</th>
<th>Metal</th>
<th>Crystal</th>
<th>Deuterium</th>
<th>Metal</th>
<th>Crystal</th>
<th>Deuterium</th>
<th>-</th>
</tr>
";
	while ($c = mysql_fetch_array($planets)) {	
	while ($b = mysql_fetch_array($annonce)) {
		
		if (($b["metals"] <= $c["metal"]) && ($b["crystals"] <= $c["crystal"]) && ($b["deuts"] <= $c["deuterium"])){
			$canaccept = 1;
		}else{
			$canaccept = 0;
		}
		
		if (addslashes($b["user"]) == addslashes($user['username'])){
			$owntrade = 1;
		}else{
			$owntrade = 0;
		}
		
		
		if ($owntrade != 1){
			$opt = 'Remove';
			$act = 3;
		}elseif ($canaccept == 1){
			$opt = 'Accept';
			$act = 4;
		}elseif (($canaccept == 0) && ($owntrade == 0)){
			$opt = 'X';
		}else{
			$opt = 'Error';
		}
		
		$acc = '<form action="annonce.php?action='.$act.'" method="post">
		<input type="hidden" name="seller" value="'.$b["planet_id"].'" />
		<input type="hidden" name="buyer" value="'.$user['current_planet'].'" />
		<input type="hidden" name="trade" value="'.$b["id"].'" />
		<input type="submit" value="'.$opt.'" />		
		</form>';
		
		//Make red what he can't afford.
		if($b["metals"] > $c["metal"]){ $redm = "<font color=\"red\">"; $redem = "</font>"; }
		else{ $redm = ""; $redem = ""; } 
		if($b["crystals"] > $c["crystal"]){ $redc = "<font color=\"red\">"; $redec = "</font>"; }
		else{ $redc = ""; $redec = ""; }
		if($b["deuts"] > $c["deuterium"]){ $redd = "<font color=\"red\">"; $reded = "</font>"; }
		else{ $redd = ""; $reded = ""; }
		
		$page2 .= '<tr><th> ';
		$page2 .= $b["user"] ;
		$page2 .= '</th><th>';
		$page2 .= $b["galaxie"];
		$page2 .= '</th><th>';
		$page2 .= $b["systeme"];
		$page2 .= '</th><th>';
		$page2 .= $b["metala"];
		$page2 .= '</th><th>';
		$page2 .= $b["crystala"];
		$page2 .= '</th><th>';
		$page2 .= $b["deuta"];
		$page2 .= '</th><th>';
		$page2 .= $redm.$b["metals"].$redem;
		$page2 .= '</th><th>';
		$page2 .= $redc.$b["crystals"].$redec;
		$page2 .= '</th><th>';
		$page2 .= $redd.$b["deuts"].$reded;
		$page2 .= '</th><th>';
		$page2 .= $acc;
		$page2 .= "</th></tr>";
	}
	}

	$page2 .= "
<tr><th colspan=\"10\" align=\"center\"><a href=\"annonce2.php?action=2\">Add a trade</a></th></tr>
</td>
</table>
</HTML>";

	display($page2,"Player Trades");
}

// Add and view trades by Tom1991 Copyright 2008
// Accept and Delete trades by Anthony Copyright 2008 for Darkness of Evolution
// Transltions by Anthony Copyright 2008 for Darkness of Evolution
?>
