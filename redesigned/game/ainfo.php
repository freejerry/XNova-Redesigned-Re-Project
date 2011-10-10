<?php

/**
 * ainfo.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */




if(!is_numeric($_GET["allyid"]) || !$_GET["allyid"] ){ message("Ung&uuml;ltige Allianz-ID","Fehler");}

$allyrow = doquery("SELECT ally_name,ally_tag,ally_description,ally_web,ally_image FROM {{table}} WHERE id=".mysql_escape_string($_GET["allyid"]),"alliance",true);

if(!$allyrow){ message("Alliance non trouv&eacute;e","Erreur");}

$count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=".mysql_escape_string($_GET["allyid"]).";","users",true);
$ally_member_scount = $count[0];

$page .="<table width=519><tr><td class=c colspan=2>Informations sur l'alliance</td></tr>";

	if($allyrow["ally_image"] != ""){
		$page .= "<tr><th colspan=2><img src=\"".$allyrow["ally_image"]."\"></td></tr>";
	}

	$page .= "<tr><th>Tag</th><th>".$allyrow["ally_tag"]."</th></tr><tr><th>Nom</th><th>".$allyrow["ally_name"]."</th></tr><tr><th>Membres</th><th>$ally_member_scount</th></tr>";

	if($allyrow["ally_description"] != ""){
		$page .= "<tr><th colspan=2 height=100>".$allyrow["ally_description"]."</th></tr>";
	}


	if($allyrow["ally_web"] != ""){
		$page .="<tr>
		<th>Site internet</th>
		<th><a href=\"".$allyrow["ally_web"]."\">".$allyrow["ally_web"]."</a></th>
		</tr>";
	}
	$page .= "</table>";

	displaypage($page, 'Alliance Info');
			


// Created by Perberos. All rights reversed (C) 2006
?>