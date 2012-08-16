<?php
// Edited by Anthony for release - 30/06/08 (c)MadnessRed 2008
// Edits
// * Translations
// * New Ships
// * New Defence
// * New techs
// End of Edit information


/*
#############################################################################
#  Filename: tech.mo
#  Create date: Friday, March 28, 2008	 19:35:54
#  Project: prethOgame
#  Description: RPG web based game
#
#  Copyright © 2008 Aleksandar Spasojevic <spalekg@gmail.com>
#  Copyright © 2005 - 2008 KGsystem
#############################################################################
*/
$lang['Tech']         = "Technologies";
$lang['Requirements'] = "Requirements";
$lang['Metal']        = "Metal";
$lang['Crystal']      = "Crystal";
$lang['Deuterium']    = "Deuterium";
$lang['Energy']       = "Energy";
$lang['Matter']       = "Xentronium";
$lang['Matter']       = "Xenothium";
$lang['Matter']       = "Dark Matter";
$lang['Message']      = "Message";
$lang['level']        = "Level";
$lang['treeinfo']     = "[i]";
$lang['comingsoon']   = "Coming Soon";
$lang['te_dt_tx_pre'] = "Prerequisite for";


// Short names for fight rapport
$lang['tech_rc'] = array (
	202 => 'S.Cargo',
	203 => 'L.Cargo',
	204 => 'L.Fighter',
	205 => 'H.Fighter',
	206 => 'Cruiser',
	207 => 'Battleship',
	208 => 'Col. Ship',
	209 => 'Recy.',
	210 => 'Esp.Probe',
	211 => 'Bomber',
	212 => 'Sol. Sat',
	213 => 'Dest.',
	214 => 'Deathstar',
	215 => 'Battlecr.',
	218 => 'Chuck',
	
	401 => 'R.Launcher',
	402 => 'L.Laser',
	403 => 'H.Laser',
	404 => 'Gauss',
	405 => 'Ion C.',
	406 => 'Plasma',
	407 => 'S.Dome',
	408 => 'L.Dome',
	409 => 'S.Grav',
	410 => 'L.Grav',
);

$lang['tech'] = array(
//Buildings
	 0 => "Buildings",
	 1 => "Metal Mine",
	 2 => "Crystal Mine",
	 3 => "Deuterium Synthesizer",
	 4 => "Solar Plant",
	12 => "Fusion Reactor",
	14 => "Robotics Factory",
	15 => "Nanite Factory",
	21 => "Shipyard",
	22 => "Metal Storage",
	23 => "Crystal Storage",
	24 => "Deuterium Tank",
	31 => "Research Lab",
	33 => "Terraformer",
	34 => "Alliance Depot",

//Lunar Buildings
	40 => 'Lunar Buildings',
	41 => 'Lunar Base',
	42 => 'Sensor Phalanx',
	43 => 'Jump Gate',

//Special Buildings
	44 => "Missile Silo",
	45 => "Resource Portal",

// Technologies
	100 => 'Research',
	106 => 'Espionage Technology',
	108 => 'Computer Technology',
	109 => 'Weapons Technology',
	110 => 'Shielding Technology',
	111 => 'Armour Technology',
	113 => 'Energy Technology',
	114 => 'Hyperspace Technology',
	115 => 'Combustion Drive',
	117 => 'Impulse Drive',
	118 => 'Hyperspace Drive',
	119 => 'Hyperspace Mapping Technology',
	120 => 'Laser Technology',
	121 => 'Ion Technology',
	122 => 'Plasma Technology',
	123 => 'Intergalactic Research Network',
	124 => 'Expedition Technology',
	125 => 'Alliance Based Research Network',
	150 => 'Colonization Technology',
	199 => 'Graviton Technology',

//Ships                 
	200 => 'Ships',         
	202 => 'Small Cargo',   
	203 => 'Large Cargo',   
	204 => 'Light Fighter', 
	205 => 'Heavy Fighter', 
	206 => 'Cruiser',       
	207 => 'Battleship',    
	208 => 'Colony Ship',   
	209 => 'Recycler',      
	210 => 'Espionage Probe',
	211 => 'Bomber',        
	212 => 'Solar Satellite',
	213 => 'Destroyer',     
	214 => 'Deathstar',     
	215 => 'Battlecruiser',     
	218 => 'Chuck', 

//Barracks                 
	300 => 'Barracks', 
	302 => 'Ground Troops', 
                        
//Defense                        
	400 => 'Defense',                
	401 => 'Rocket Launcher',        
	402 => 'Light Laser',            
	403 => 'Heavy Laser',            
	404 => 'Gauss Cannon',           
	405 => 'Ion Cannon',             
	406 => 'Plasma Turret',          
	407 => 'Small Shield Dome',      
	408 => 'Large Shield Dome',            
	409 => 'Small Gravity Dome',      
	410 => 'Large Gravity Dome',     
	502 => 'Anti-Ballistic Missiles',
	503 => 'Interplanetary Missiles',
                        
	/*
//Officers                        
	600 => 'Officers',  
	601 => "Geologist",
	602 => "Admiral",
	603 => "Engineer",
	604 => "Technocrat",
	605 => "Manufacturer",
	606 => "Scientist",
	607 => "Storekeeper",
	608 => "Defender",
	609 => "Bunker",
	610 => "Spy",
	611 => "Commander",
	612 => "Destroyer",
	613 => "General",
	614 => "Raider",
	615 => "Emperer",
	*/
                        
//Officers                        
	600 => 'Officers',  
	601 => "Commander",
	602 => "Admiral",
	603 => "Engineer",
	604 => "Geologist",
	605 => "Technocrat",

);

$lang['descriptions'] = array(
	1 => "Used in the extraction of metal ore, metal mines are of primary importance to all emerging and established empires.",
	2 => "Crystals are the main resource used to build electronic circuits and form certain alloy compounds.",
	3 => "Deuterium is used as fuel for spaceships and is harvested in the deep sea. Deuterium is a rare substance and is thus relatively expensive.",
	4 => "Solar power plants absorb energy from solar radiation. All mines need energy to operate.",
	12 => "The fusion reactor uses deuterium to produce energy.",
	14 => "Robotic factories provide construction robots to aid in the construction of buildings. Each level increases the speed of the upgrade of buildings.",
	15 => "This is the ultimate in robotics technology. Each level cuts the construction time for buildings, ships, and defenses.",
	21 => "All types of ships and defensive facilities are built in the planetary shipyard.",
	22 => "Provides storage for excess metal.",
	23 => "Provides storage for excess crystal.",
	24 => "Giant tanks for storing newly-extracted deuterium.",
	31 => "A research lab is required in order to conduct research into new technologies.",
	33 => "The terraformer increases the usable surface of planets.",
	34 => "The alliance depot supplies fuel to friendly fleets in orbit helping with defense.",
	41 => "Since the moon has no atmosphere, a lunar base is required to generate habitable space.",
	42 => "Using the sensor phalanx, fleets of other empires can be discovered and observed. The bigger the sensor phalanx array, the larger the range it can scan.",
	43 => "Jump gates are huge transceivers capable of sending even the biggest fleet in no time to a distant jump gate.",
	44 => "Missile silos are used to store missiles.",

	106 => "Information about other planets and moons can be gained using this technology.",
	108 => "More fleets can be commanded by increasing computer capacities. Each level of computer technology increases the maximum number of fleets by one.",
	109 => "Weapons technology makes weapons systems more efficient. Each level of weapons technology increases the weapon strength of units by 10 % of the base value.",
	110 => "Shielding technology makes the shields on ships and defensive facilities more efficient. Each level of shield technology increases the strength of the shields by 10 % of the base value.",
	111 => "Special alloys improve the armour on ships and defensive structures. The effectiveness of the armour can be increased by 10 % per level.",
	113 => "The command of different types of energy is necessary for many new technologies.",
	114 => "By integrating the 4th and 5th dimensions it is now possible to research a new kind of drive that is more economical and efficient.",
	115 => "The development of this drive makes some ships faster, although Each level only increases speed by 10 % of the base value.",
	117 => "The impulse drive is based on the reaction principle. Further development of this drive makes some ships faster, although each level only increases speed by 20 % of the base value.",
	118 => "Hyperspace drive warps space around a ship. The development of this drive makes some ships faster, although each level only increases speed by 30 % of the base value.",
	119 => "Hyperspace mapping technology enables complex routes to be plotted through the 4th and 5th dimentions.",
	120 => "Focusing light produces a beam that causes damage when it strikes an object.Focusing light produces a beam that causes damage when it strikes an object.",
	121 => "A deadly beam of accelerated ions. This causes enormous damage when striking an object.",
	122 => "A further development of ion technology which accelerates high-energy Plasma, a result of super-heating Ions. This has a devastating effect when striking an object.",
	123 => "Researchers on different planets communicate via this network.",
	124 => "With a astrophysics research module, ships can undertake long expeditions. Two levels of this technology allow for the colonization of an additional planet.",
	199 => "Firing a concentrated charge of graviton particles can create an artificial gravity field, which can destroy ships or even moons.",
	
	202 => "The small cargo is an agile ship which can quickly transport resources to other planets.",
	203 => "This cargo ship has a much larger cargo capacity than the small cargo, and is generally faster thanks to an improved drive.",
	204 => "This is the first fighting ship all emperors will build. The light fighter is an agile ship, but vulnerable by themselves. In mass numbers, they can become a great threat to any empire. They are the first to accompany small and large cargo to hostile planets with minor defenses.",
	205 => "This fighter is better armoured and has a higher attack strength than the light fighter.",
	206 => "Cruisers are armoured almost three times as heavily as heavy fighters and have more than twice the firepower. In addition, they are very fast.",
	207 => "Battleships form the backbone of a fleet. Their heavy cannons, high speed, and large cargo holds make them opponents to be taken seriously.",
	208 => "Vacant planets can be colonized with this ship.",
	209 => "Recyclers are the only ships able to harvest debris fields floating in a planets orbit after combat.",
	210 => "Espionage probes are small, agile drones that provide data on fleets and planets over great distances.",
	211 => "The bomber was developed especially to destroy the planetary defenses of a world.",
	212 => "Solar satellites are simple platforms of solar cells, located in a high, stationary orbit. They gather sunlight and transmit it to the ground station via laser.",
	213 => "The destroyer is the king of the warships.",
	214 => "The destructive power of the deathstar is unsurpassed.",
	215 => "The Battlecruiser is highly specialized in the interception of hostile fleets.",
	
	401 => "The rocket launcher is a simple, cost-effective defensive option.",
	402 => "Concentrated firing at a target with photons can produce significantly greater damage than standard ballistic weapons.",
	403 => "The heavy laser is the logical development of the light laser.",
	404 => "The Gauss Cannon fires projectiles weighing tons at high speeds.",
	405 => "The Ion Cannon fires a continuous beam of accelerating ions, causing considerable damage to objects it strikes.",
	406 => "Plasma Turrets release the energy of a solar flare and surpass even the destroyer in destructive effect.",
	407 => "The small shield dome covers an entire planet with a field which can absorb a tremendous amount of energy.",
	408 => "The development of the small shield dome can employ significantly more energy to withstand attacks.",

	502 => "Anti-Ballistic Missiles destroy attacking interplanetary missiles",
	503 => "Interplanetary Missiles destroy enemy defenses.",
	
	601 => "Building queue, empire view, improved galaxy view, message filter, shortcuts, advertisement free",
	602 => "max. fleet slots +2",
	603 => "Halves losses to defenses, +10% energy production",
	604 => "+10% mine production",
	605 => "+2 espionage level for probes, 25% less research time",
);
?>
