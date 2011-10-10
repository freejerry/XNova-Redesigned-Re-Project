<?php

/**
 * achievements.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova Redesigned
 */

getLang('fleet');
$parse = $lang;

switch($_GET['tut']){
	case "1":
		die(nl2br('
Level 1:
Born Eagle: Create the first building.
Economist: Maintain a production factor of 100% for 48 hours.
Welcomed: Join an alliance with over 10 members.
Friendship: Send a buddylist to another player.
Explore: View another solar system in galaxy mode.
		'));
		
		break;
	case "2":
		die(nl2br('
Level 2:
Levelup 1: Sucessfully complete all level 1 achievements.
First Strike: Attack another planet for the first time.
Iron Curtain: Successfully defend one of your attacked planets.
Gross Bug!: Report a confirmed bug using the ticket system.
Dark Matters: Spend Dark Matter on an officer.
An Expanding Empire: Colinize another planet.
Intellegence: Find out another players fleet with espionage probes.
		'));
		
		break;
	case "3":
		die(nl2br('
Level 3:
Levelup 2: Sucessfully complete all level 2 achievements.
Pioneer: Run 25 expeditions.
Team Player: Help sucessfully defend a friendly planet from attack.
Headmaster: Be the leader of an alliance with at least 5 other members, for over 1 week.
Attack of Minor Destruction: Send a fleet of at least 100 ships to end up destroying only 1 ship. The attack must be successful.
Family: Have at least 3 planets in the same system.
Self-sufficient: Reach level 10 in Solar Plant, Metal Mine and Crystal Mine on a colony without sending any resources to that colony.
		'));
		
		break;
	case "4":
		die(nl2br('
Level 4:
Levelup 3: Sucessfully complete all level 3 achievements.
Armada: Have at least 1000 ships at once.
Mad Scientist: Spend a total of 7 days researching.
Bombs Away: Launch 50 intergalactic missiles to another planet at once.
Fortress: Have at least 500 defense structures on one of your planets.
Go Green: Recycle at least 500k in one sweep.
Galactic Empire: Be the leader of an alliance with at least 20 members for 3 weeks.
		'));
		
		break;
	case "5":
		die(nl2br('
Level 5:
Levelup 4: Sucessfully complete all level 4 achievements.
Dark Council: Have all officers hired at the same time.
Minor: Have all mines, solar planet and deuterium synthesiser to a combined level of over 100 on a single colony.
Raider: Steal 10kk from others players.
Ninja: Arrive to defend a planet within 3 seconds of the attacking fleet.
		'));
		
		break;
	case "6":
		die(nl2br('
Level 6:
Levelup 5: Sucessfully complete all level 5 achievements.
Survivor: Win or Draw against a fleet including a Deathstar.
Lunar Landing: Create a lunar base.
Tesla\'s Dream: Reach Solar Planet level 30 on a single planet.
		'));
		
		break;
	case "7":
		die(nl2br('
Level 7:
Levelup 6: Sucessfully complete all level 6 achievements.
Tombstone: Build your first Deathstar.
Paranoid: Have 50 anti-ballistic missiles in the missile silo on a single planet.
Orbital Chaos: Have 500 solar satellites on a single planets.
Death-defier: Sucessfully destroy an attacking Deathstar.
		'));
		
		break;
	case "8":
		die(nl2br('
Level 8:
Levelup 7: Sucessfully complete all level 7 achievements.
Speed Attack: Steal over 10k of resources from a planet, just using probes.
Deathstar sacrifice: Loose a Deathstar in a battle but still win. (In an ACS attack, all ACS members will receive this).
		'));
	
		break;
	case "9":
		die(nl2br('
Level 9:
Levelup 8: Sucessfully complete all level 8 achievements.
Parallel Computing: Using research networks attain a linked lab level of over 100.
Surprise: Find a mystery ship on an expedition.
Irony: Sucessfully destroy an opponents moons, with a fleet send from one of your own moons.
Timed: Destroy an opponents moons within 60 seconds of him creating a jumpgate upon it.
Tempory Destruction: Destroy a moon but have it reform from the debris.
		'));
		
		break;
	case "10":
		die(nl2br('
Level 10:
Levelup 9: Sucessfully complete all level 9 achievements.
Own the skies: Colinize an entire solar system.
Regular: With the exception of Graviton Technology, get all researches to the same level.
Exceeds Expectations: Research Graviton Technology to level 2.
Solar Plant Graviton: Produce 300k or more energy from purely Solar Plants.
		'));
		
		break;
	default:

		$parse['done1'] = 'tutorial_done';
		$parse['done2'] = 'tut_new';
		$parse['done3'] = '';
		$parse['done4'] = '';
		$parse['done5'] = '';
		$parse['done6'] = '';
		$parse['done7'] = '';
		$parse['done8'] = '';
		$parse['done9'] = '';
		$parse['done0'] = '';

		$page = parsetemplate(gettemplate('general/achievements'), $parse);
		if($_GET['axah']){
			makeAXAH($page);
		}else{
			displaypage($page, $lang['Fleet']);
		}
		
		break;

}

// Version 1 by MadnessRed
?>
