<?php

$lang['fleet_commando'] = 'Flottenkommando';

$lang['missions'][1] = 'Angreifen';
$lang['missions'][2] = 'Zerst&ouml;ren';
$lang['missions'][3] = 'Transport';
$lang['missions'][4] = 'Stationierung';
$lang['missions'][5] = 'Halten';
$lang['missions'][6] = 'Spionage';
$lang['missions'][7] = 'N/A';
$lang['missions'][8] = 'Abbau';
$lang['missions'][9] = 'Kolonisierung';
$lang['missions'][10] = 'Verbandsangriff';


$lang['eventhandler_kol_ok'] = 'Eine deiner Flotten erreichen den die Position %koords, finden einen neuen Planeten vor und beginnen sofort mit der Erschliessung.';
$lang['eventhandler_kol_toobig'] = 'Eine deiner Flotten erreichen den die Position %koords, finden einen neuen Planeten vor, doch dann erreicht sie die Meldung, dass es Unruhen im Imperium gibt und kehren zur&uuml;ck.';
$lang['eventhandler_kol_belegt'] = 'Eine deiner Flotten erreichen den die Position %koords, doch hier hat sich bereits ein anderer Herrscher niedergelassen. Deprimiert kehren sie zur&uuml;ck.';
$lang['kolonie'] = "Kolonie";
$lang['mond'] = "Mond";

$lang['eventhandler_tf_subject'] = 'TF Bericht %koords';
$lang['eventhandler_tf_done_one'] = 'Dein Recycler hat eine Gesamtkapazit&auml;t von %c. Auf dem Zeil treiben %zmet Metall und %zkris. Er hat %met Metall und %kris Kristall abgebaut.';
$lang['eventhandler_tf_done_more'] = 'Deine %anzahl Recycler haben eine Gesamtkapazit&auml;t von %c. Auf dem Zeil treiben %zmet Metall und %zkris. Sie haben %met Metall und %kris Kristall abgebaut.';

$lang['eventhandler_stationieren_done'] = 'Eine deiner Flotten %liste haben den Planeten %name  %koords erreicht.';

$lang['eventhandler_trans_erreicht'] = 'Eine deiner Flotten erreichen den Planeten %name %koords, sie liefert Metall: %met Kristall: %kris Deuterium: %deut';
$lang['eventhandler_trans_erreicht_noself'] = 'Eine fremde Flotte vom Planeten %startname %startkoords von %playername erreichen deinen Planeten %name %koords, sie liefert Metall: <b>%met</b> Kristall: <b>%kris</b> Deuterium: <b>%deut</b>';
$lang['eventhandler_trans_erreicht_noself_done'] = 'Eine deiner Flotten vom Planeten %startname %startkoords erreichen den Planeten %name %koords und liefert ihre Ladung ab:<br>Metall: <b>%met</b> Kristall: <b>%kris</b> Deuterium: <b>%deut</b>';


$lang['eventhandler_fleetback']            = 'Eine deiner Flotten %fleetlist kehren von %startkoords zum Planeten %name %koords zur&uuml;ck. ';

$lang['eventhandler_fleetback_ressources'] = 'Sie liefert %met Metall, %kris Kristall und %deut Deuterium.';
$lang['eventhandler_fleetback_tritium']    = 'Sie liefert %tri Tritium.';

$lang['eventhandler_spionagebericht_part1'] = '<table width=400>	<tr>		<td class=c colspan=4>Rohstoffe auf %name %koords am %date</td>	</tr>	<tr>			<td>Metall:</td>			<td>%met</td>			<td>Kristall:</td>			<td>%kris</td>	</tr>	<tr>			<td>Deuterium:</td>			<td>%deut</td>			<td>Energie:</td>			<td>%energie</td>	</tr></table>';

$lang['eventhandler_spionagebericht_part2'] = '<table width=400>	<tr>		<td class=c colspan=4>Flotten     </td>	</tr>%flotten</table>';

$lang['eventhandler_spionagebericht_part3'] = '<table width=400>	<tr>		<td class=c colspan=4>Verteidigung     </td>	</tr>%def</table>';

$lang['eventhandler_spionagebericht_part4'] = '<table width=400>	<tr>		<td class=c colspan=4>Geb&auml;ude     </td>	</tr>%buildings</table>';

$lang['eventhandler_spionagebericht_part5'] = '<table width=400>	<tr>		<td class=c colspan=4>Forschung     </td>	</tr>%forschungen</table>';

$lang['eventhandler_spionagebereicht_abwehr'] = '<center> Chance auf Spionageabwehr: %chance%</center>';

$lang['eventhandler_spio_subject_owner'] = 'Spionagebericht';
$lang['eventhandler_spio_subject_spionierter'] = 'Spionageaktion';
$lang['eventhandler_spio_spionierter_info'] = 'Eine fremde Flotte vom Planeten %spionplanet %spionkoords wurde in der N&auml;he deines Planeten %name %koords gesichtet.<br>Chance auf Spionageabwehr: <b>%chance</b>%  %status';
$lang['eventhandler_spio_spionierter_info_status_ok'] = '<center><font color="#00FF00" face="Arial">Spionagesonden wurden nicht zerst&ouml;rt!</font></center>';
$lang['eventhandler_spio_spionierter_info_status_destruyed'] = '<center><font color="#FF0000" face="Arial">Spionagesonden wurden zerst&ouml;rt!</font></center>';

$lang['eventhandler_angriff_error_a'] = "Eine deiner Flotten erreichen die Koordinaten %koords. Leider ist die Flotte zu gross und der Server konnte den Angriff nicht durchf&uuml;hren! Die Flotte zieht sich zur&uuml;ck! SORRY!";
$lang['eventhandler_angriff_error_v'] = "Eine fremde Flotte erreichen deine Koordinaten %koords. Leider ist die Flotte zu gross und der Server konnte den Angriff nicht durchf&uuml;hren! Die Flotte zieht sich zur&uuml;ck! SORRY!";

$lang['kampfbericht'] = "Kampfbericht";
$lang['kb'] = "KB";

$lang['and'] = "und";
?>