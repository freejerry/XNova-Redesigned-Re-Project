<?php

/**
 * fleet_management.mo
 * Created by MadnessRed, for XNova Redesigned
 * 23/12/2009
 */

//<Gerneral>
$lang['fleet_control']	= 'Fleet Control';
//</General>

//<Return>
$lang['fleet_recall']	= 'Fleet Recalled';
$lang['fleet_not_fnd']	= 'Fleet not found';
$lang['fleet_return']	= 'Return of Fleet';
$lang['fleet_return_m']	= 'Your fleet is returning from %s %s to your planet.<br /><br />The fleet is delivering %s %s, %s %s and %s %s.';
//</Return>

//<Attack>
$lang['report_start']	= 'On %s the following fleets met in battle:';
$lang['report_vs']		= 'vs.';
$lang['report_rinfo']	= "
\t\t<div class=\"battle\">\n
\t\t\t<p class=\"action\">The attacking fleet fires %s times at the defender, with a total firepower of %s. The defender&#x27;s shields absorb %s damage points.</p>\n
\t\t\t<p class=\"action\">The defending fleet fires %s times at the attacker, with a total firepower of %s. The attacker&#x27;s shields absorb %s damage points.</p>\n
\t\t</div>\n
";
$lang['Weapons']		= 'Weapons';
$lang['Shields']		= 'Shields';
$lang['Armour']			= 'Armour';
$lang['Attacker']		= 'Attacker';
$lang['Defender']		= 'Defender';
$lang['A_won']			= 'The attacker has won the battle!	He captured %s %s, %s %s and %s %s.';
$lang['D_won']			= 'The defender has won the battle!';
$lang['Draw']			= 'The battle ended in a draw!';
$lang['AttLost']		= 'The attacker lost a total of %s units.';
$lang['DefLost']		= 'The defender lost a total of %s units.';
$lang['DebrisF']		= 'At these space coordinates now float %s %s and %s %s.';
$lang['destroyed']		= 'destroyed';
$lang['MoonChance']		= 'The chance for a moon to be created is %s<br />';
$lang['GotMoon']		= 'The enormous amounts of free metal and crystal draw together and form a moon around the planet %s!<br />';

$lang['fleet_1_tit']	= 'Combat Report';
//</Attack>

//<Transport>
$lang['fleet_3_yours']	= 'Your fleet arrived at the planet %s %s and delivered its goods: %s %s, %s %s and %s %s.';
$lang['fleet_3_allied']	= 'An allied fleet from %s %s arived at %s %s and delivered its goods: %s %s, %s %s and %s %s.';
//</Transport>

//<Spy>
$lang['fleet_6_res']	= 'Resources';
$lang['fleet_6_tit']	= 'Espionage Report';
//</Spy>

//<Harvest>
$lang['fleet_8_tit']	= "Harvest Report";
$lang['fleet_8_mess']	= "Your recyclers arrived at the debris field and collected %s %s and %s %s.";
//</Harvest>

//<Expedition>
$lang['fleet_15_tit']	= "Expedition Report";
$lang['fleet_15_lost'] = array(
						"Whilst navigating uncharted space, the fleet became completely lost, and was unable to find its way back.",
						"Whilst navigating uncharted space, the fleet was sucked into a blackhole and destroyed."
);
$lang['fleet_15_dark'] = array(
						"Your explorers came across a very rare substance known as %s, although a large supply was found, only a small ammount could be harvested. You now have an additional %s units of %s.",
						"Your explorers have discovered the ruins of an acient civilization, although there were no signs of life, the explorers did find a storage facilirt for %s. You now have an additional %s units of %s."
);
$lang['fleet_15_nothing'] = array(
						'Your explorers flew past a Supernova but apart from some amazing photos returned with nothing.',
						'Your explorers spend a long time searching, however, were unable to find anything.',
						'A malfunction on one of the ships, meant that your explorers had to concentrate on fixing that, rather than exploring, as a result they found nothing.'
);
$lang['fleet_15_problems'] = array(
						'Whilst exploring outer space your fleet became hopelessly lost, however, on spotting a foreight fleet, the captain decided to follow and found himself back in known space, all-be-it very delayed.',
						'A malfunction onboard forced your fleet to halt, luckily the fault was repairable and the fleet could return, however, a considerable ammount of time was lost during the repair, meaning that the fleet will arrive back on your planet later than expected.',
);
$lang['fleet_15_wormhole'] = array(
						'Whilst exploring space your fleet was sucked into a wormhole, which miraculously did not damage the fleet and send it close to your planet, as a result the fleet will arrive earlier than expected.',
						'A malfunction in one of the ships forces the fleet to return home before the expedition could be completed. As a result nothing could be found, however, your fleet will return earlier than expected.'
);
//</Expedition>

//<Destroy>
$lang['fleet_9_tit']	= "Attempted destruction of the moon %s.";

$lang['fleet_9_mess1']	= "A fleet from planet %s attempted to destroy the moon orbiting at %s.";

$lang['fleet_9_moon']	= "The probability of the moon being destroyed is %s.";
$lang['fleet_9_rips']	= "The chance the fleet is destroyed is %s.";

$lang['fleet_9_mess2']	= "The gravity cannons from the attacking fleet sent shockwaves through the moon";

$lang['fleet_9_messD'] = ", causing a tremor which tore up the moon. All buildings are destroyed";
$lang['fleet_9_messK'] = ". The tremmors from the graviton cannons shaking the moon fail and backfire, disintergrating the fleet completely";
$lang['fleet_9_messN'] = ", however, the fleet does not develop the necessary power to destroy the moon. The fleets returned to their planets";
//</Destroy>

?>
