<?php

/**
 * email.php
 *
 * @version 1.1
 * @copyright 2008 by MadnessRed for Darkness of Evolution.
 * function from reg.php
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('NO_MENU' , true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function sendemail($message,$address,$title) {
	global $lang;

	$uni = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$uni = ereg_replace("[^0-9]", "", $uni);

	$lang['mail_welcome']      = '<table width="100%" height="100%" bgcolor="Black" border="1">';
	$lang['mail_welcome']     .= '<tr valign="top">';
	$lang['mail_welcome']     .= '<td valign="top">';
	$lang['mail_welcome']     .= '<center>';
	$lang['mail_welcome']     .= '<img src="http://darkevo.org/images/header.jpg" alt="Censtudios Gaming Portal" /><br />';
	$lang['mail_welcome']     .= '<table width="80%" height="220"><tr><td valign="top">';
	$lang['mail_welcome']     .= '<font color="White"><br /><br />';
	$lang['mail_welcome']     .= $message;
	$lang['mail_welcome']     .= '</font>';
	$lang['mail_welcome']     .= '</td></tr></table>';
	$lang['mail_welcome']     .= '</center>';
	$lang['mail_welcome']     .= '</td>';
	$lang['mail_welcome']     .= '</tr>';
	$lang['mail_welcome']     .= '</table>';
	
	$parse['gameurl']  = GAMEURL;
	$parse['uni']	   = $uni;



	$email             = parsetemplate($lang['mail_welcome'], $parse);
	$status            = mymail($address, $title, $email);
	return $status;
}

function mymail($to, $title, $body, $from = '') {
	$from = trim($from);

	if (!$from) {
		$from = ADMINEMAIL;
	}

	$rp     = ADMINEMAIL;

	$head   = '';
	$head  .= "Content-Type: text/html \r\n";
	$head  .= "Date: " . date('r') . " \r\n";
	$head  .= "Return-Path: $rp \r\n";
	$head  .= "From: $from \r\n";
	$head  .= "Sender: $from \r\n";
	$head  .= "Reply-To: $from \r\n";
	$head  .= "Organization: $org \r\n";
	$head  .= "X-Sender: $from \r\n";
	$head  .= "X-Priority: 3 \r\n";
	$body   = str_replace("\r\n", "\n", $body);
	$body   = str_replace("\n", "\r\n", $body);

	return mail($to, $title, $body, $head);
}
$echo = "";
if ($_POST) {
	if($_POST['email'] != "#all#"){
		if (sendemail($_POST['message'],$_POST['email'],$_POST['subject'])) {
			$echo .= "Your email has been sent to ".$_POST['email'];
		} else {
			$echo .= "Your email could not be sent to ".$_POST['email'];
		}
	}else{
		$qry = doquery("SELECT `email` FROM {{table}} ;",'users') or die(mysql_error());
		echo "Dealt with query";
		while ($row = mysql_fetch_array($qry)){
			$echo .= "Your email has been sent to ".$row['email']."<br />";
			/*
			if (sendemail($_POST['message'],`evo1_users`,$_POST['subject'])) {
				$echo .= "Your email has been sent to ".$row['email']."<br />";
			} else {
				$echo .= "Your email could not be sent to ".$row['email']."<br />";
			}	
			*/		
		}
	}
} else {
	$echo .= "<form action=\"email.php\" method=\"POST\">";
	$echo .= "<table width=\"517\">";
	$echo .= "<tr>";
	$echo .= "<td colspan=\"2\" class=\"c\">Send Email</td>";
	$echo .= "</tr>";
	$echo .= "<tr>";
	$echo .= "<th>Email:</th><th width=\"400\"><input type=\"text\" name=\"email\" style=\"width:400px;\" /><br />(Enter #all# to send a mass email)</th>";
	$echo .= "</tr>";
	$echo .= "<tr>";
	$echo .= "<th>Subject:</th><th><input type=\"text\" name=\"subject\" style=\"width:400px;\" /></th>";
	$echo .= "</tr>";
	$echo .= "<tr>";
	$echo .= "<th>Message:</th><th><textarea name=\"message\" rows=\"10\" style=\"width:400px;\"></textarea></th>";
	$echo .= "</tr>";
	$echo .= "</table>";
	$echo .= "<input type=\"submit\" value=\"Send\" />";
	$echo .= "</form>";
}
$parse['this_page'] = $echo;
$page                = parsetemplate(gettemplate('basic_page'), $parse);
display ($page, "Send Email", false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - First Verion - MadnessRed
?>