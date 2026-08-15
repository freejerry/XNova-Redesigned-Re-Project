<?php
// Edited by Anthony for release - 30/06/08 (c)MadnessRed 2008
// Edits
// * Translations
// * New ranks
// * Moon destruction language implemented
// End of Edit information



$lang['user_level'] = array (
	'0' => 'Player',
	'1' => 'GameOperator',
	'2' => 'SuperGameOperator',
	'3' => 'Developer',
);

$lang['sys_first_round_crash_1'] = 'Contact with the attacking fleet has been lost.';
$lang['sys_first_round_crash_2'] = 'That means it was destroyed during the first round.';

$lang['sys_overview'] = "Overview";
$lang['mod_marchand'] = "Merchant";
$lang['sys_moon'] = "Moon";
$lang['sys_error'] = "Error";
$lang['sys_no_vars'] = "The file with variables is not present, please contact an administrato !";
$lang['sys_attacker_lostunits'] = "The attacker lost a total of %s units.";
$lang['sys_defender_lostunits'] = "The defender lost a total of %s units.";
$lang['sys_gcdrunits'] = "At these space coordinates now float %s %s and %s %s.";
$lang['sys_moonproba'] = "The chance for a moon to be created is %d%% ";
$lang['sys_moonbuilt'] = "The enormous amounts of free metal and crystal draw together and form a moon around the planet %s [%d:%d:%d]!";
$lang['sys_attack_title'] = "On %s the following fleets met in battle::";
$lang['sys_attack_attacker_pos'] = "Attacker %s ([%s])";
$lang['sys_attack_techologies'] = "Weapons: %d%% Shields: %d%% Armour: %d%% ";
$lang['sys_attack_defender_pos'] = "Defender %s ([%s])";
$lang['sys_ship_type'] = "Type";
$lang['sys_ship_count'] = "Total";
$lang['sys_ship_weapon'] = "Weapons";
$lang['sys_ship_shield'] = "Shields";
$lang['sys_ship_armour'] = "Armour";
$lang['sys_destroyed'] = "Destroyed!";
$lang['sys_attack_attack_wave'] = "The attacking fleet fires %s times with a total firepower of %s at the defender. The defending shields absorb %s damage.";
$lang['sys_attack_defend_wave'] = "The defending fleet fires %s times with a total firepower of %s at the attacker. The attackers shields absorb %s damage";
$lang['sys_attacker_won'] = "The attacker has won the battle!";
$lang['sys_defender_won'] = "The defender has won the battle!";
$lang['sys_both_won'] = "The battle ends with draw !";
$lang['sys_stealed_ressources'] = "He captured <br /> %s %s, %s %s, and %s %s <br />";
$lang['sys_rapport_build_time'] = "Report simulated in %s seconds";
$lang['sys_mess_tower'] = "Space Control";
$lang['sys_mess_attack_report'] = "Combat Report";
$lang['sys_spy_maretials'] = "Resources on";
$lang['sys_spy_fleet'] = "Fleets";
$lang['sys_spy_defenses'] = "Defense";
$lang['sys_mess_qg'] = "Fleet command";
$lang['sys_mess_spy_report'] = "Espionage Report";
$lang['sys_mess_spy_lostproba'] = "Chance of counter-espionage: %d %% ";
$lang['sys_mess_spy_control'] = "Space Control";
$lang['sys_mess_spy_activity'] = "Espionage activity";
$lang['sys_mess_spy_ennemyfleet'] = "A foreign fleet from planet";
$lang['sys_mess_spy_seen_at'] = "was sighted near your planet";
$lang['sys_mess_spy_destroyed'] = "Espionage probes destroyed !";
$lang['sys_object_arrival'] = "Arriving on a planet";
$lang['sys_stay_mess_stay'] = "Fleet Deployment";
$lang['sys_stay_mess_start'] = "Your fleet arrived on planet ";
$lang['sys_stay_mess_back'] = "Your fleet returned to planet ";
$lang['sys_stay_mess_end'] = " and delivered:";
$lang['sys_stay_mess_bend'] = " and brought back the following resources:";
$lang['sys_adress_planet'] = "[%s:%s:%s]";
$lang['sys_stay_mess_goods'] = "%s Metal, %s : Crystal, %s : Deuterium";

$lang['sys_colo_mess_from'] = "Colonisation";
$lang['sys_colo_mess_report'] = "Colonisation Report";
$lang['sys_colo_defaultname'] = "Colony";
$lang['sys_colo_arrival'] = "The fleet reached the coordinates";
$lang['sys_colo_maxcolo'] = ", you reached maximum number of your colonies. Research astrophysics technology to a higher level. ";
$lang['sys_colo_outside_range'] = ", you cannot colinize this planet slot. Research astrophysics technology to a higher level.";
$lang['sys_colo_allisok'] = ", and the settelers are devloping this new part of your empire";
$lang['sys_colo_badpos']  = ", and the settelers found the planet completely uninhabital. They returned home disgusted, many in need of serious medical treatment.";
$lang['sys_colo_notfree'] = ", and the settlers have not found a planet with those details. They are forced to turn back, completely demoralized";
$lang['sys_colo_planet']  = " planets!";
$lang['sys_colo_slots']  = "Slots ";

$lang['sys_expe_report'] = "Expedition Report";
$lang['sys_recy_report'] = "Harvest Report";
$lang['sys_expe_blackholl_1'] = "The fleet has been sucked into a black hole and has been partially destroyed!";
$lang['sys_expe_blackholl_2'] = "The fleet has been sucked into a black hole and has been completely destroyed!";
$lang['sys_expe_nothing_1'] = "Your explorers flew past a Supernova but apart from some amazing photos returned with nothing.<br><img src=../images/supernova.jpg width=300>";
$lang['sys_expe_nothing_2'] = "Your explorers spend a long time in the area but found nothing.";
$lang['sys_expe_found_goods'] = "Your fleet found an uninhabited planet.<br> Thay have brought home %s de %s, %s de %s et %s de %s";
$lang['sys_expe_found_ships'] = "You fleet found an ancient shipyard. The managed to make several ships work again and bring home: ";
$lang['sys_expe_back_home'] = "Your fleet returns from expedition";
$lang['sys_mess_transport'] = "Fleet Transport";
$lang['sys_tran_mess_owner'] = "Your fleet arrived at the planet %s %s. and delivered its goods: %s  %s , %s %s , %s %s.";
$lang['sys_tran_mess_user']  = "An allied fleet from %s %s arived to %s %s and deliver %s of %s, %s of %s and %s of %s.";
$lang['sys_mess_fleetback'] = "Back fleet";
$lang['sys_tran_mess_back'] = "One of your fleets returns from %s %s.";
$lang['sys_recy_gotten'] = "Your recycler(s) collect %s %s and %s %s.";
$lang['sys_notenough_money'] = "You do not have enough resources to launch the construction of %s. You have %s of %s, %s of %s and %s of %s. The cost of the building was %s of %s, %s of %s and %s of %s.";
$lang['sys_nomore_level'] = "This building has been destroyed to level 0, you can destroy it no more.";
$lang['sys_buildlist'] = "Building Queue";
$lang['sys_buildlist_fail'] = "Construction impossible";
$lang['sys_gain'] = "Gains";
$lang['sys_perte_attaquant'] = "Attacker loss";
$lang['sys_perte_defenseur'] = "Defender Loss";
$lang['sys_debris'] = "Debris field";
$lang['sys_noaccess'] = "Access denied";
$lang['sys_noalloaw'] = "You do not have permisions to access this page";

$lang['VacationMode'] = "Your production was disabled while you are in Vacation Mode !!!";

//destruction de lune
$lang['sys_destruc_title']    = "Attempted destruction of the moon %s :";
$lang['sys_mess_destruc_report'] = "Moon destruction report.";
$lang['sys_destruc_lune'] = "The probability of the mon being destroyed is: %d %% ";
$lang['sys_destruc_rip'] = "The chance the fleet is destroyed is: %d %% ";
$lang['sys_destruc_stop'] = "The defender has saved his moon.";
$lang['sys_destruc_mess1'] = "The gravity cannons from the attacking fleet sent shockwaves through the moon, smashing it to peices.";
$lang['sys_destruc_mess'] = "A fleet from planet %s [%d:%d:%d] flew to the moon at [%d:%d:%d]";
$lang['sys_destruc_echec'] = ". The tremmors from the graviton cannons shaking the moon fail and backfire, disintergrating the fleet completely.";
$lang['sys_destruc_reussi'] = ", causing a tremor which tore up the moon. All buildings are destroyed - Mission accomplished! The moon is destroyed! The fleets return to their planets.";
$lang['sys_destruc_null'] = ", the fleet does not develop the necessary power to destroy the moon - Mission failed! The fleets returned to their planets.";


$lang['sys_moon_destruction_report'] = "Moon Destruction Report";
$lang['sys_moon_destroyed'] = "Your Deathstars and Chucks with their gravition gannons produced a massive earthqueake on the moon moon which collapsed and was destoyed";
$lang['sys_rips_destroyed'] = "Your Deathstars and Chucks with their gravition cannons produced a massive earthquake on the moon, however, that power was not enough for this size moon. The gravition wave was reflected from moons surface and destroyed your whole fleet";
$lang['sys_rips_come_back'] = "Your Deathstars and Chucks with their gravition cannons do not have enough power to inflict any damage to this moon. The Moon absorbed all gravition waves. Your fleet returns without destroying moon.";
$lang['sys_chance_moon_destroy'] = "Change of moon destruction: ";
$lang['sys_chance_rips_destroy'] = "Change of fleet destruction: ";

?>
