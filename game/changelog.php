<?php

/**
 * changelog.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

getLang('changelog');

$template = gettemplate('changelog_table');
$body = '';
foreach($lang['changelog'] as $a => $b)
{

	$parse['version_number'] = $a;
	$parse['description'] = nl2br($b);

	$body .= parsetemplate($template, $parse);

}

$parse = $lang;
$parse['body'] = $body;

$page = parsetemplate(gettemplate('changelog_body'), $parse);

makeAXAH($page);

//displaypage($page,"Change Log");

// Created by Perberos. All rights reversed (C) 2006
?>
