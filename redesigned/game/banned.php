<?php

/**
 * banned.php
 *
 * @version 1.1
 * @copyright 2009 by MadnessRed for XNova Redesigned
 */

define('VIEW_BANNED' , true);

getLang('ban');

$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;

$query = $dql->doquery("SELECT `banned_by`,`banned_until`,`banned_reason`,`username` FROM {{table}} WHERE `banned_until` < '".time()."' ORDER BY `banned_until` ;",'users');

$i=0;
while($u = $query->fetch_assoc()){

	$raw_tr = ($u['banned_until'] - time());
	$days_tr = ceil($raw_tr / 3600 / 24);

	$Days = "Day";
	if ($days_tr != 1){ $Days .= "s"; }

	$ban_remaining = $days_tr." ".$Days;

	$parse['banned'] .=
    "\t\t\t\t\t\t\t<tr style=\"color:#FF0000;\">\n".
    "\t\t\t\t\t\t\t\t<td>".$u['username']."</td>\n".
	"\t\t\t\t\t\t\t\t<td>".$lang['BanReasons'][$u['banned_reason']]."</td>\n".
	"\t\t\t\t\t\t\t\t<td>".date("d/m/Y G:i:s",$u['banned_until'])."</td>\n".
	"\t\t\t\t\t\t\t\t<td>".$u['banned_by']."</td>\n".
	"\t\t\t\t\t\t\t\t<td>".$ban_remaining."</td>\n".
	"\t\t\t\t\t\t\t</tr>\n\n";
	$i++;
}

if ($i=="0")
 $parse['banned'] .= "\t\t\t\t\t\t\t<tr><th colspan=6>There are no banned players</th></tr>\n";
else
  $parse['banned'] .= "\t\t\t\t\t\t\t<tr><th colspan=6>{$i} players have been banned</th></tr>\n";

displaypage(parsetemplate(gettemplate('banned'),$parse),$lang['Title']);


// Created by e-Zobar (XNova Team). All rights reversed (C) 2008
// Updated by MadnessRed (XNovaUK Team). All rights reversed (C) 2009
?>
