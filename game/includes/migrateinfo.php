<?php

/**
 * migrateinfo.php
 *
 * @version 1.0
 * @copyright 2008 By e-Zobar for XNova
 */

$QryMigrate = array(
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_end_stay` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_target_owner` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_group` int (11) NOT NULL DEFAULT '0';",

"ALTER TABLE `{{prefix}}messages` MODIFY `message_from` varchar(48) character set latin1 default NULL;",
"ALTER TABLE `{{prefix}}messages` MODIFY `message_subject` varchar(48) character set latin1 default NULL;",

"ALTER TABLE `{{prefix}}users` ADD COLUMN `mnl_buildlist` INT (11) NOT NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `expedition_tech` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `mnl_expedition` INT( 11 ) NOT NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_geologue` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_amiral` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_ingenieur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_technocrate` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_espion` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_constructeur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_scientifique` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_commandant` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_stockeur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_defenseur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_destructeur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_general` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_bunker` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_raideur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_empereur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_points` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `lvl_minier` int(11) NOT NULL default '1';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `lvl_raid` int(11) NOT NULL default '1';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `xpraid` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `xpminier` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `banaday` int(11) default NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `user_agent` text character set latin1 NOT NULL;",
"ALTER TABLE `{{prefix}}users` MODIFY `lang` varchar(8) character set latin1 NOT NULL default 'fr';",

"CREATE TABLE `{{prefix}}annonce` (
`id` int(11) NOT NULL auto_increment,
`user` text collate latin1_general_ci NOT NULL,
`galaxie` int(11) NOT NULL,
`systeme` int(11) NOT NULL,
`metala` bigint(11) NOT NULL,
`cristala` bigint(11) NOT NULL,
`deuta` bigint(11) NOT NULL,
`metals` bigint(11) NOT NULL,
`cristals` bigint(11) NOT NULL,
`deuts` bigint(11) NOT NULL,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=5;",

"ALTER TABLE `{{prefix}}planets` ADD COLUMN `last_jump_time` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}planets` ADD COLUMN `id_level` int(11) default NULL;",
"ALTER TABLE `{{prefix}}planets` MODIFY `b_building_id` text character set latin1 NOT NULL;",

"CREATE TABLE `{{prefix}}statpoints` (
`id_owner` int(11) NOT NULL,
`id_ally` int(11) NOT NULL,
`stat_type` int(2) NOT NULL,
`stat_code` int(11) NOT NULL,
`tech_rank` int(11) NOT NULL,
`tech_old_rank` int(11) NOT NULL,
`tech_points` bigint(20) NOT NULL,
`tech_count` int(11) NOT NULL,
`build_rank` int(11) NOT NULL,
`build_old_rank` int(11) NOT NULL,
`build_points` bigint(20) NOT NULL,
`build_count` int(11) NOT NULL,
`defs_rank` int(11) NOT NULL,
`defs_old_rank` int(11) NOT NULL,
`defs_points` bigint(20) NOT NULL,
`defs_count` int(11) NOT NULL,
`fleet_rank` int(11) NOT NULL,
`fleet_old_rank` int(11) NOT NULL,
`fleet_points` bigint(20) NOT NULL,
`fleet_count` int(11) NOT NULL,
`total_rank` int(11) NOT NULL,
`total_old_rank` int(11) NOT NULL,
`total_points` bigint(20) NOT NULL,
`total_count` int(11) NOT NULL,
`stat_date` int(11) NOT NULL,
KEY `TECH` (`tech_points`),
KEY `BUILDS` (`build_points`),
KEY `DEFS` (`defs_points`),
KEY `FLEET` (`fleet_points`),
KEY `TOTAL` (`total_points`)
) ENGINE=MyISAM;",

"CREATE TABLE `{{prefix}}chat` (
`messageid` int(5) unsigned NOT NULL auto_increment,
`user` varchar(255) NOT NULL default '',
`message` text NOT NULL,
`timestamp` int(11) NOT NULL default '0',
PRIMARY KEY  (`messageid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"INSERT INTO `{{prefix}}config` (`config_name`, `config_value`) VALUES
('Fleet_Cdr', '30'),
('Defs_Cdr', '30'),
('game_disable', '0'),
('close_reason', ''),
('BuildLabWhileRun', '0'),
('LastSettedGalaxyPos', '1'),
('LastSettedSystemPos', '9'),
('LastSettedPlanetPos', '1'),
('urlaubs_modus_erz', '1'),
('forum_url', 'http://www.xnova.fr/forum'),
('OverviewNewsFrame', '1'),
('OverviewNewsText', 'Vous avez correctement mis votre serveur UGamela sous XNova!'),
('OverviewExternChat', '0'),
('OverviewExternChatCmd', ''),
('OverviewBanner', '0'),
('OverviewClickBanner', ''),
('ExtCopyFrame', '0'),
('ExtCopyOwner', ''),
('ExtCopyFunct', ''),
('ForumBannerFrame', '0');",
"UPDATE `{{prefix}}config` SET `config_value`='XNova' WHERE `config_name`='COOKIE_NAME';",
"UPDATE `{{prefix}}config` SET `config_value`='XNova' WHERE `config_name`='game_name';",

"CREATE TABLE `{{prefix}}multi` (
`id` int(11) NOT NULL auto_increment,
`player` bigint(11) unsigned NOT NULL default '0',
`sharer` bigint(11) unsigned NOT NULL default '0',
`reason` text character set latin1 NOT NULL,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

?>