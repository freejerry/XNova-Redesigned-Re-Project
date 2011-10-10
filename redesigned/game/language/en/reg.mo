<?php
// Edited by Anthony for release - 30/06/08 (c)MadnessRed 2008
// Edits
// * Translations
// End of Edit information


/*
#############################################################################
#  Filename: reg.mo
#  Create date: Wednesday, April 02, 2008	 15:13:08
#  Project: prethOgame
#  Description: RPG web based game
#
#  Copyright © 2008 Aleksandar Spasojevic <spalekg@gmail.com>
#  Copyright © 2005 - 2008 KGsystem
#############################################################################
*/

if (!defined('INSIDE')) {
	die("attemp hacking");
}

// Registration form
$lang['registry']          = 'Registration';
$lang['form']              = 'Form';
$lang['Register']          = 'Registration';
$lang['Undefined']         = '- please select -';
$lang['Male']              = 'Male';
$lang['Female']            = 'Female';
$lang['Multiverse']        = 'SuperNova';
$lang['E-Mail']            = 'E-mail address';
$lang['MainPlanet']        = 'Homeworld (name)';
$lang['GameName']          = 'Username (NO SPACES!)';
$lang['Sex']               = 'Gender';
$lang['accept']            = 'I accept license agreement';
$lang['signup']            = ' Register ';
$lang['neededpass']        = 'Password';

// Send
$lang['mail_welcome']      = '<table width="100%" height="100%" bgcolor="Black" border="1">';
$lang['mail_welcome']     .= '<tr valign="top">';
$lang['mail_welcome']     .= '<td valign="top">';
$lang['mail_welcome']     .= '<center>';
$lang['mail_welcome']     .= '<img src="http://darkevo.org/images/header.jpg" alt="Censtudios Gaming Portal" /><br />';
$lang['mail_welcome']     .= '<table width="532" height="220"><tr><td background="http://darkevo.org/images/box.jpg" align="center" valign="top">';
$lang['mail_welcome']     .= '<font color="White"><br /><br /><br />';
$lang['mail_welcome']     .= 'Thank you for signing up for Darkness of Evolution,<br />Universe {uni}.<br /><br />';
$lang['mail_welcome']     .= 'Your username is: {username}<br />';
$lang['mail_welcome']     .= 'Your password is: {password}<br /><br />';
$lang['mail_welcome']     .= 'Good luck!<br /><a href="http://darkevo.org/" target="_new"><font color="White">Login</font></a>';
$lang['mail_welcome']     .= '</font>';
$lang['mail_welcome']     .= '</td></tr></table>';
$lang['mail_welcome']     .= '</center>';
$lang['mail_welcome']     .= '</td>';
$lang['mail_welcome']     .= '</tr>';
$lang['mail_welcome']     .= '</table>';



// Send
//$lang['mail_welcome']      = 'Thank you for signing up for our game {gameurl}\nYour password is: {password}\n\nGood luck!\n{gameurl}';
$lang['mail_title']        = 'Your Registration on Darkness of Evolution';
$lang['thanksforregistry'] = 'Thank you for signing up! You will soon receive an email with your username and password.';
$lang['welcome_to_universe'] = 'Welcome to the universe !!';
$lang['your_password'] = 'Your password is';
$lang['please_click_url'] = 'To be able to use your account, you must activate it by clicking on this link';
$lang['regards'] = "Best regards, DoE Team";

// Errors
$lang['error_mail']        = 'Invalid e-mail!<br />';
$lang['error_planet']      = 'Error in the name of your planet!.<br />';
$lang['error_hplanetnum']  = 'You must use alphanumeric characters for your planet name!<br />';
$lang['error_character']   = 'Error in the name of the player!<br />';
$lang['error_charalpha']   = 'Username must have alphanumeric characters (spaces not allowed)!<br />';
$lang['error_password']    = 'The password should be at least 4 characters!<br />';
$lang['error_rgt']         = 'You must accept the conditions of use.<br />';
$lang['error_userexist']   = 'Username already exist!<br />';
$lang['error_emailexist']  = 'That e-mail was already registred in our system !<br />';
$lang['error_sex']         = 'You must chose a gender!<br />';
$lang['error_mailsend']    = 'Thankyou for registering. Your password is: ';
$lang['reg_welldone']      = 'Registration complete!';
?>
