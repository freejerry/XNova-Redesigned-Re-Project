<?php

/**
 * FAQ.php
 *
 * @Version 1.2
 * @Copyright 2008 by Rocky for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('FAQ');

	foreach($lang['FAQ'] as $question => $answer)
	{

		$n = count($question);

		$parse['question'] = $question;
		$parse['answer']   = nl2br($answer);
		$parse['ID']      += $n;
		$parse['romID']    = romanNumber($parse['ID']);

		$template .= parsetemplate(gettemplate('FAQ_general'), $parse);
		$body     .= parsetemplate(gettemplate('FAQ_table'), $parse);

	}

	$parse                = $lang;
	$parse['FAQ_body']    = $body;
	$parse['FAQ_general'] = $template;

	$page .= parsetemplate(gettemplate('FAQ_body'), $parse);

	display($page,$lang['FAQ_title'], true);
	
// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - First version, based on changelog.php by Perberos (C) 2006
// 1.1 -Second version, add FAQ list and link to all FAQs
// 1.2 - Final version,  number Id converted to roman number.

?>