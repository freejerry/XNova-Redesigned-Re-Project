<?php

//Edited by Anthony (MadnessRed) Small changes for compatability with new Combar report generation.

/**
 * rw.php
 *
 * @version 1.0
 * @copyright 2008 by ????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

define('ROOT_PATH' , '');
include(ROOT_PATH . 'common.php');

	includeLang('tech');

	$open = true;
	$reportid = $_GET["raport"];
	$raportrow = doquery("SELECT * FROM {{table}} WHERE `rid` = '".(mysql_escape_string($_GET["raport"]))."';", 'rw', true);

	if ($allow == 1 || $open) {
		$Page  = "<html>";
		$Page .= "<head>";
		$Page .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$dpath."/formate.css\">";
		$Page .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-2\" />";
		$Page .= "</head>";
		$Page .= "<body>";
		$Page .= "<center>";

		if (($raportrow["owners"] == $user["id"]) and
			($raportrow["a_zestrzelona"] == 1)) {
			$Page .= "<td>Contact with the attacking fleet has been lost.<br>";
			$Page .= "(This means that is was destroyed in the first round.)</td>";
		} else {
			$report = stripslashes($raportrow["raport"]);
			foreach ($lang['tech_rc'] as $id => $s_name) {
				$str_replace1  = array("[ship[".$id."]]");
				$str_replace2  = array($s_name);
				$report = str_replace($str_replace1, $str_replace2, $report);
			}
			$no_fleet = "<table border=1 align=\"center\"><tr><th>Type</th></tr><tr><th>Total</th></tr><tr><th>Weapons</th></tr><tr><th>Shields</th></tr><tr><th>Armour</th></tr></table>";
			$destroyed = "<table border=1 align=\"center\"><tr><th><font color=\"red\"><strong>Destroyed!</strong></font></th></tr></table>";
			$str_replace1  = array($no_fleet);
			$str_replace2  = array($destroyed);
			$report = str_replace($str_replace1, $str_replace2, $report);
			$Page .= $report;
		}
		$Page .= "<br /><br />";
		$Page .= "Share this report - ";
		$Page .= $reportid;
		$Page .= "<br /><br />";
		$Page .= "</center>";
		$Page .= "</body>";
		$Page .= "</html>";

		echo $Page;
	}

// -----------------------------------------------------------------------------------------------------------
// History version

?>
