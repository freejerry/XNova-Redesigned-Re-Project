<?php

/**
 * amici_pop_UP.php
 *
 * @version 1
 * @copyright 2009 by KikkU for XNova Redesigned
 */

includeLang('buddy');

$a = $_GET['a'];
$e = $_GET['e'];
$s = $_GET['s'];
$u = intval( $_GET['u'] );
$parse['titolo'] = "Pagina Per La Gestione Amici";
if ( $s == 1 && isset( $_GET['bid'] ) )
{
	// Ci hanno fatto la richiesta d'amicizia e adesso si decide se ACCETTARLA - RIFUTARLA
	$bid = addslashes(intval( $_GET['bid'] ));

	$buddy = doquery( "SELECT * FROM {{table}} WHERE `id` = '".mysql_escape_string($bid)."';", 'buddy', true );
	if ( $buddy['owner'] == $user['id'] ) {
		if ( $buddy['active'] == 0 && $a == 1 ) {
			doquery( "DELETE FROM {{table}} WHERE `id` = '".mysql_escape_string($bid)."';", 'buddy' );
		} elseif ( $buddy['active'] == 1 ) {
			doquery( "DELETE FROM {{table}} WHERE `id` = '".mysql_escape_string($bid)."';", 'buddy' );
		} elseif ( $buddy['active'] == 0 ) {
			doquery( "UPDATE {{table}} SET `active` = '1' WHERE `id` = '".mysql_escape_string($bid)."';", 'buddy' );
		}
	} elseif ( $buddy['sender'] == $user['id'] ) {
		doquery( "DELETE FROM {{table}} WHERE `id` = '".mysql_escape_string($bid)."';", 'buddy' );
	}
} elseif ( $_POST["s"] == 3 && $_POST["a"] == 1 && $_POST["e"] == 1 && isset( $_POST["u"] ) ) {
	// Traitement de l'enregistrement de la demande d'entree dans la liste d'amis
	$uid = $user["id"];
	$u = intval( $_POST["u"] );

	$buddy = doquery( "SELECT * FROM {{table}} WHERE sender={$uid} AND owner={$u} OR sender={$u} AND owner={$uid}", 'buddy', true );

	if ( !$buddy ) {
		if ( strlen( $_POST['text'] ) > 5000 ) {
			//message( "Le texte ne doit pas faire plus de 5000 caract&egrave;res !", "Erreur" );
			$parse['titolo'] = "Pagina Per La Richiesta Amici";
			$parse['body'] = "La Richiesta Amicizia Non Puo Superare i 5000 Caratteri!";
		}
		$text = mysql_escape_string( strip_tags( $_POST['text'] ) );
		doquery( "INSERT INTO {{table}} SET sender={$uid}, owner={$u}, active=0, text='{$text}'", 'buddy' );
		//message( $lang['Request_sent'], $lang['Buddy_request'], 'buddy.php' );
		//message( $lang['Request_sent'], $lang['Buddy_request'], 'href=./?page=amici_pop_up&iframe=0&iheight=800' );
		$parse['titolo'] = "Pagina Per La Richiesta Amici";
		$parse['body'] = "$lang[Request_sent], $lang[Buddy_request]";
	} else {
		//message( $lang['A_request_exists_already_for_this_user'], $lang['Buddy_request'] );
		$parse['titolo'] = "Pagina Per La Richiesta Amici";
		$parse['body'] = "$lang[A_request_exists_already_for_this_user], $lang[Buddy_request]";
	}
}

$parse['body'] .= "<br>";

if ( $a == 2 && isset( $u ) )
{
	// Form Per la richiesta Amicizia
	$u = doquery( "SELECT * FROM {{table}} WHERE id='$u'", "users", true );
	if ( isset( $u ) && $u["id"] != $user["id"] )
	{
		$parse['body'] .= "
		<script src=\"scripts/cntchar.js\" type=\"text/javascript\"></script>
		<script src=\"scripts/win.js\" type=\"text/javascript\"></script>
		<center>
			<form action=./?page=amici_pop_up method=post>
			<input type=hidden name=a value=1>
			<input type=hidden name=s value=3>
			<input type=hidden name=e value=1>
			<input type=hidden name=u value=" . $u["id"] . ">
			<table width=519>
			<tr>
				<td class=c colspan=2>{$lang['Buddy_request']}</td>
			</tr><tr>
				<th>{$lang['Player']} :</th>
				<th><center><font color=\"#33FF00\">" . $u["username"] . "</font></center></th>
			</tr><tr>
				<th>{$lang['Request_text']} (<span id=\"cntChars\">0</span> / 5000 {$lang['characters']})</th>
				<th><textarea name=text cols=60 rows=10 onKeyUp=\"javascript:cntchar(5000)\"></textarea></th>
			</tr><tr>
				<td class=c><a href=\"javascript:back();\">{$lang['Back']}</a></td>
				<td class=c><input type=submit value='{$lang['Send']}'></td>
			</tr>
		</table></form>
		</center>";

	}elseif ( $u["id"] == $user["id"] ) {
		message( $lang['You_cannot_ask_yourself_for_a_request'], $lang['Buddy_request'] );
	}
}
else
{
	// con a indicamos las solicitudes y con e las distiguimos
	if ( $a == 1 )
		$TableTitle = ( $e == 1 ) ? $lang['My_requests']:$lang['Anothers_requests'];
	else
		$TableTitle = $lang['Buddy_list'];
	
	//Originale
	//$parse['body'] .= "<table width=519><tr><td class=c colspan=6>{$TableTitle}</td></tr>";
	$parse['body'] .= "<table width=519>";
	
	if (!isset( $a))
	{
		//$page
		//print "TEST";
		$parse['body'] .= "<tr><th colspan=6><center><a href=./?page=amici_pop_up&a=1&iframe=0&iheight=800><font color=\"#CC66CC\">{$lang['Requests']}</font></a></center></th></tr><tr><th colspan=6><center><a href=./?page=amici_pop_up&a=1&e=1&iframe=0&iheight=800><font color=\"#FF6666\">{$lang['My_requests']}</font></a></center></th></tr><tr><td class=c></td><td class=c><font color=\"#33CCCC\">{$lang['Name']}</font></td><td class=c><font color=\"#33CCCC\">{$lang['Alliance']}</font></td><td class=c><font color=\"#33CCCC\">{$lang['Coordinates']}</font></td><td class=c><font color=\"#33CCCC\">{$lang['Position']}</font></td><td class=c></td></tr>";
	}
	
	if ( $a == 1 )
	{
		//Si stanno visualizzando le Proprie Richieste D'amicizia
		$query = ( $e == 1 ) ? "WHERE active=0 AND sender=" . $user["id"] : "WHERE active=0 AND owner=" . $user["id"];
	}
	else
	{
		$query = "WHERE active=1 AND sender=" . $user["id"] . " OR active=1 AND owner=" . $user["id"];
	}
	$buddyrow = doquery( "SELECT * FROM {{table}} " . $query, 'buddy' );
	
	while ( $b = mysql_fetch_array( $buddyrow ) ) {
		// para solicitudes
		if ( !isset( $i ) && isset( $a ) ) {
			$parse['body'] .= "
			<tr>
				<td class=c></td>
				<td class=c><font color=\"#33CCCC\">{$lang['User']}</font></td>
				<td class=c><font color=\"#33CCCC\">{$lang['Alliance']}</font></td>
				<td class=c><font color=\"#33CCCC\">{$lang['Coordinates']}</font></td>
				<td class=c><font color=\"#33CCCC\">{$lang['Text']}</font></td>
				<td class=c></td>
			</tr>";
		}
	
		$i++;
		$uid = ( $b["owner"] == $user["id"] ) ? $b["sender"] : $b["owner"];
		// query del user
		$u = doquery( "SELECT id,username,galaxy,system,planet,onlinetime,ally_id,ally_name FROM {{table}} WHERE id=" . $uid, "users", true );
		// $g = doquery("SELECT galaxy, system, planet FROM {{table}} WHERE id_planet=".$u["id_planet"],"galaxy",true);
		// $a = doquery("SELECT * FROM {{table}} WHERE id=".$uid,"aliance",true);
		if ( $u["ally_id"] != 0 ) { // Alianza
			// $allyrow = doquery("SELECT id,ally_tag FROM {{table}} WHERE id=".$u["ally_id"],"alliance",true);
			// if($allyrow){
			$UserAlly .= "<a href=alliance.php?mode=ainfo&a=" . $u["id"] . ">" . $u["ally_name"] . "</a>";
			// }
		}
	
		if ( isset( $a ) ) {
			$LastOnline = $b["text"];
		} else {
			$LastOnline = "<font color=";
			if ( $u["onlinetime"] + 60 * 10 >= time() ) {
				$LastOnline .= "lime>{$lang['On']}";
			} elseif ( $u["onlinetime"] + 60 * 20 >= time() ) {
				$LastOnline .= "yellow>{$lang['15_min']}";
			} else {
				$LastOnline .= "red>{$lang['Off']}";
			}
			$LastOnline .= "</font>";
		}
	
		if ( isset( $a ) && isset( $e ) ) {
			$UserCommand = "<a href=./?page=amici_pop_up&s=1&bid=" . $b["id"] . "&iframe=0&iheight=800>{$lang['Delete_request']}</a>";
		} elseif ( isset( $a ) ) {
			$UserCommand = "<a href=./?page=amici_pop_up&s=1&bid=" . $b["id"] . "&iframe=0&iheight=800><font color=\"#00FF00\">{$lang['Ok']}</font></a><br/>";
			$UserCommand .= "<a href=./?page=amici_pop_up&a=1&s=1&bid=" . $b["id"] . "&iframe=0&iheight=800><font color=\"#FF0000\">{$lang['Reject']}</font></a></a>";
		} else {
			$UserCommand = "<a href=./?page=amici_pop_up&s=1&bid=" . $b["id"] . "&iframe=0&iheight=800><font color=\"#FF0000\">{$lang['Delete']}</font>
</a>";
		}
		$parse['body'] .= "
		<tr>
			<td width=20>" . $i . "</th>		
			<td><a href=./?page=write&to=" . $u["id"] . "&iframe=0&iheight=800>" . $u["username"] . "</a></td>
			
			<td>{$UserAlly}</td>
			<td><a href=./?page=galaxy&mode=1&galaxy=" . $u["galaxy"] . "&system=" . $u["system"] . ">" . $u["galaxy"] . ":" . $u["system"] . ":" . $u["planet"] . "</a></td>
			<td>{$LastOnline}</td>
			<td>{$UserCommand}</td>
		</tr>";
	}
	
	if ( !isset( $i ) )
	{
		//Si stanno guardando SE ci sono state inviate RICHIESTE d'amicizia
		$parse['body'] .= "
		<tr>
			<th colspan=6><font color=\"#FF0000\"><center>{$lang['There_is_no_request']}</center></font></th>
		</tr>";
		//echo parsetemplate(gettemplate('network/amici_pop_up'), $parse);
	}
	
	if ( $a == 1 ) {
		$parse['body'] .= "
		<tr>
			<td colspan=6 class=c><a href=./?page=amici_pop_up>{$lang['Back']}</a></td>
		</tr>";
	}
	
	$parse['body'] .= "
		</table>
		</center>";
	$parse['titolo'] = $TableTitle;
}
echo AddUniToLinks(parsetemplate(gettemplate('network/amici_pop_up'), $parse));

?>