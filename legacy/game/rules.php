<?php
// Added by Anthony for release - 31/06/08 (c)MadnessRed 2008
// Edits
// * Added rule sin language file
// End of Edit information



/**
 * rules.php
 *
 * @Version 1.2
 * @Copyright 2008 by Rocky for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('rules');

	foreach($lang['rules'] as $title => $rule)
	{

		$n = count($rule);

		$parse['title']  = $title;
		$parse['rule']   = nl2br($rule);
		$parse['ID']    += $n;
		$parse['romID']  = romanNumber($parse['ID']);

		$template .= parsetemplate(gettemplate('rules_general'), $parse);
		$body     .= parsetemplate(gettemplate('rules_table'), $parse);

	}

	$parse                  = $lang;
	$parse['servername']    = $game_config['game_name'];
	$parse['rules_body']    = $body;
	$parse['rules_general'] = $template;

	$page .= parsetemplate(gettemplate('rules_body'), $parse);

	display($page,$lang['rules_title'], true);
	
// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - First version, based on changelog.php by Perberos (C) 2006
// 1.1 -Second version, add rules list and link to all rules
// 1.2 - Final version,  number Id converted to roman number.

?>
