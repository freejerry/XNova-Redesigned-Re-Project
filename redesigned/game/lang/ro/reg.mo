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
#  Copyright � 2008 Aleksandar Spasojevic <spalekg@gmail.com>
#  Copyright � 2005 - 2008 KGsystem
#############################################################################
*/

if (!defined('INSIDE')) {
	die("attemp hacking");
}

// Registration form
$lang['registry']			= 'Inregistreaza-te';
$lang['form']		    		= 'Formular';
$lang['Register']			= 'Inregistrare';
$lang['Undefined']			= '- te rugam selecteaza -';
$lang['Male']		    		= 'Barbat';
$lang['Female']		    		= 'Femeie';
$lang['Multiverse']			= 'SuperNova';
$lang['E-Mail']		    		= 'Adresa E-mail';
$lang['MainPlanet']			= 'Planeta de baza (nume)';
$lang['GameName']			= 'Utilizator (FARA SPATII!)';
$lang['Sex']				= 'Gen';
$lang['accept']				= 'Accept termenii de utilizare';
$lang['signup']				= ' Inregistrare ';
$lang['neededpass']			= 'Parola';

// Send
$lang['mail_title']			= 'Inregistrarea ta la ';

$lang['mail_welcome']			= '<table width="100%" height="100%" bgcolor="Black" border="1">';
$lang['mail_welcome']			.= '<tr valign="top">';
$lang['mail_welcome']			.= '<td valign="top">';
$lang['mail_welcome']			.= '<center>';
$lang['mail_welcome']			.= '<img src="'.GAMEURL.'img/email/header.jpg" alt="Email" /><br />';
$lang['mail_welcome']			.= '<table width="532" height="220"><tr><td background="'.GAMEURL.'img/email/box.jpg" align="center" valign="top">';
$lang['mail_welcome']			.= '<font color="White"><br /><br /><br />';
$lang['mail_welcome']			.= 'Multumim ca te-ai inregistrat la {game},<br />Universul {uni}.<br /><br />';
$lang['mail_welcome']			.= 'Nmele de utilizator este: {username}<br />';
$lang['mail_welcome']			.= 'Parola ta este: {password}<br /><br />';
$lang['mail_welcome']			.= 'Succes!<br /><a href="'.LOGINURL.'" target="_new"><font color="White">Autentificare</font></a>';
$lang['mail_welcome']			.= '</font>';
$lang['mail_welcome']			.= '</td></tr></table>';
$lang['mail_welcome']			.= '</center>';
$lang['mail_welcome']			.= '</td>';
$lang['mail_welcome']			.= '</tr>';
$lang['mail_welcome']			.= '</table>';

// Welcome PM
$lang['WelcomePM']			 = "Salut, Bine ai venit la {game}. Iti dorim distractie placuta jucand acest joc. Daca ai intrebari te rigam viziteaza sectiunea FAQ; daca nu gasesti raspunsul acolo atunci vei gasi cu siguranta multi membrii doritori sa ajute, pe forum. Ca un sfat gerenar, poti incepe prin a-ti construi Minele. Incepe cu Minele de Metal apoi cele de Cristal si de asemenea o Uzina Solara. Succes.";
$lang['Welcome']			 = "Bine ai venit";



// Send
//$lang['mail_welcome']			= 'Multumim ca te-ai inregistrat in jocul nostru {gameurl}\nParola ta este: {password}\n\nSucces!\n{gameurl}';

$lang['thanksforregistry']		= 'Multumim ca te-ai inregistrat! Vei primi in curand un e-mail continand Numele de Utilizator ales precum si Parola ta.';
$lang['welcome_to_universe']		= 'Bine ai venit in Universul nostru !!';
$lang['your_password']			= 'Parola ta este';
$lang['please_click_url']		= 'Pentru a putea sa folosesti noul cont abia creat va trebui sa-l activezi facand click pe aceasta legatura';
$lang['regards'] 			= "Cu respect";

// Errors
$lang['error_mail']			= 'Adresa e-mail incorecta!<br />';
$lang['error_planet']			= 'Eroare in numele planetei tale!.<br />';
$lang['error_hplanetnum']		= 'Trebuie sa folosesti caractere alfanumerice pentru numele planetei!<br />';
$lang['error_character']		= 'Eroare in numele de utilizator!<br />';
$lang['error_charalpha']		= 'Numele de utilizator trebuie sa contina doar caractere alfanumerice (spatiile nu sunt permise)!<br />';
$lang['error_password']			= 'Parola trebuie sa fie de minim 4 caractere!<br />';
$lang['error_rgt']			= 'Trebuie sa accepti Termenii de Utilizare.<br />';
$lang['error_userexist']		= 'Numele de utilizator exista deja!<br />';
$lang['error_emailexist']		= 'Acesta adresa de e-mail este deja existenta in sistem !<br />';
$lang['error_sex']			= 'Trebuie sa alegi un Gen!<br />';
$lang['error_mailsend']			= 'Multumim pentru inregistrare. Parola ta este: ';
$lang['reg_welldone']			= 'Inregistrare finalizata!';
?>