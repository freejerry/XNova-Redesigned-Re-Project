-- phpMyAdmin SQL Dump
-- version 3.2.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 30, 2010 at 11:57 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4
--
-- XNovaRedesigned Version: beta14

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `xnova`
--

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}aks`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}aks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `teilnehmer` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `flotten` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `ankunft` int(32) DEFAULT NULL,
  `galaxy` int(2) DEFAULT NULL,
  `system` int(4) DEFAULT NULL,
  `planet` int(2) DEFAULT NULL,
  `planet_type` int(1) NOT NULL DEFAULT '1',
  `eingeladen` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}alliance`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}alliance` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `ally_name` varchar(32) DEFAULT '',
  `ally_tag` varchar(8) DEFAULT '',
  `ally_owner` int(11) NOT NULL DEFAULT '0',
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_description` text,
  `ally_web` varchar(255) DEFAULT '',
  `ally_text` text,
  `ally_image` varchar(255) DEFAULT '',
  `ally_request` text,
  `ally_request_waiting` text,
  `ally_request_notallow` tinyint(4) NOT NULL DEFAULT '0',
  `ally_owner_range` varchar(32) DEFAULT 'Leader',
  `ally_ranks` text,
  `ally_members` int(11) NOT NULL DEFAULT '1',
  `irc_chan` varchar(15) NOT NULL,
  `relations` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ally_name` (`ally_name`),
  UNIQUE KEY `ally_tag` (`ally_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}annonce`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}annonce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `galaxie` int(11) NOT NULL,
  `systeme` int(11) NOT NULL,
  `planet_id` bigint(11) NOT NULL,
  `metala` bigint(11) NOT NULL,
  `crystala` bigint(11) NOT NULL,
  `deuta` bigint(11) NOT NULL,
  `metals` bigint(11) NOT NULL,
  `crystals` bigint(11) NOT NULL,
  `deuts` bigint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}banned`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}banned` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `who` varchar(30) NOT NULL,
  `theme` text NOT NULL,
  `who2` varchar(30) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `longer` int(11) NOT NULL DEFAULT '0',
  `author` varchar(30) NOT NULL,
  `email` varchar(155) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `who` (`who`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}buddy`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}buddy` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL DEFAULT '0',
  `owner` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(3) NOT NULL DEFAULT '0',
  `text` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sender` (`sender`,`owner`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}chat`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}chat` (
  `messageid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `ally_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`messageid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}config`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}config` (
  `config_name` varchar(64) NOT NULL DEFAULT '',
  `config_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `{{prefix}}config`
--

INSERT INTO `{{prefix}}config` (`config_name`, `config_value`) VALUES
('users_amount', '0'),
('game_speed', '2500'),
('fleet_speed', '2500'),
('resource_multiplier', '1'),
('Fleet_Cdr', '30'),
('Defs_Cdr', '30'),
('initial_fields', '163'),
('COOKIE_NAME', '{{cookies}}'),
('game_name', 'XNova Redesigned'),
('game_disable', '0'),
('close_reason', ''),
('metal_basic_income', '40'),
('crystal_basic_income', '20'),
('deuterium_basic_income', '0'),
('energy_basic_income', '0'),
('BuildLabWhileRun', '0'),
('LastSettedGalaxyPos', '1'),
('LastSettedSystemPos', '1'),
('LastSettedPlanetPos', '1'),
('urlaubs_modus_erz', '1'),
('noobprotection', '0'),
('noobprotectiontime', '20000'),
('noobprotectionmulti', '5'),
('forum_url', 'http://www.xnovauk.com/forum.php'),
('OverviewNewsFrame', '0'),
('OverviewNewsText', ''),
('OverviewExternChat', '0'),
('OverviewExternChatCmd', ''),
('OverviewBanner', '0'),
('OverviewClickBanner', ''),
('ExtCopyFrame', '0'),
('ExtCopyOwner', ''),
('ExtCopyFunct', ''),
('ForumBannerFrame', '0'),
('stat_settings', '1000'),
('link_enable', '0'),
('link_name', 'Board (beta)'),
('link_url', 'board.php'),
('enable_announces', '1'),
('enable_marchand', '1'),
('enable_notes', '1'),
('bot_name', 'Game Bot'),
('bot_adress', 'xnova@gmail.com'),
('banner_source_post', ''),
('ban_duration', '30'),
('enable_bot', '0'),
('enable_bbcode', '1'),
('debug', '0'),
('copyright', '&copy; MadnessRed 2008');


-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}cr`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}cr` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `report` text NOT NULL,
  `owners` text NOT NULL,
  `wonby` char(1) NOT NULL,
  `damage` bigint(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}errors`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}errors` (
  `error_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `error_sender` varchar(32) NOT NULL DEFAULT '0',
  `error_time` int(11) NOT NULL DEFAULT '0',
  `error_type` varchar(32) NOT NULL DEFAULT 'unknown',
  `error_text` text,
  `error_page` text,
  PRIMARY KEY (`error_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}fleets`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}fleets` (
  `fleet_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `partner_fleet` bigint(11) NOT NULL,
  `mission` int(11) NOT NULL DEFAULT '0',
  `shipcount` bigint(11) NOT NULL DEFAULT '0',
  `array` text,
  `departure` int(11) NOT NULL,
  `arrival` int(11) NOT NULL,
  `target_userid` bigint(5) NOT NULL,
  `target_id` bigint(11) NOT NULL,
  `owner_userid` bigint(5) NOT NULL,
  `owner_id` bigint(11) NOT NULL,
  `hold_time` int(6) NOT NULL DEFAULT '0',
  `metal` bigint(11) NOT NULL DEFAULT '0',
  `crystal` bigint(11) NOT NULL DEFAULT '0',
  `deuterium` bigint(11) NOT NULL DEFAULT '0',
  `fleet_group` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `target` int(3) NOT NULL DEFAULT '0',
  `fleet_mess` int(11) NOT NULL DEFAULT '0',
  `passkey` int(7) NOT NULL,
  PRIMARY KEY (`fleet_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}im`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}im` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `to` bigint(5) NOT NULL,
  `from` bigint(5) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `expires` int(11) NOT NULL DEFAULT '0',
  `message` text CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}messages`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}messages` (
  `message_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `message_owner` int(11) NOT NULL DEFAULT '0',
  `message_sender` int(11) NOT NULL DEFAULT '0',
  `message_time` int(11) NOT NULL DEFAULT '0',
  `message_type` int(1) NOT NULL DEFAULT '0',
  `message_from` varchar(48) DEFAULT NULL,
  `message_subject` varchar(48) DEFAULT NULL,
  `message_text` text,
  `message_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}notes`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}notes` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `priority` tinyint(1) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}planets`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}planets` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `id_owner` int(11) DEFAULT NULL,
  `id_level` varchar(11) DEFAULT NULL,
  `galaxy` int(11) NOT NULL DEFAULT '0',
  `system` int(11) NOT NULL DEFAULT '0',
  `planet` int(11) NOT NULL DEFAULT '0',
  `last_update` int(11) DEFAULT NULL,
  `planet_type` int(11) NOT NULL DEFAULT '1',
  `destruyed` int(11) NOT NULL DEFAULT '0',
  `build_queue` varchar(20) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `build_queue_start` int(11) NOT NULL,
  `b_building` int(11) NOT NULL DEFAULT '0',
  `b_building_id` text NOT NULL,
  `b_tech` int(11) NOT NULL DEFAULT '0',
  `b_tech_id` int(11) NOT NULL DEFAULT '0',
  `b_hangar_lastupdate` int(11) NOT NULL DEFAULT '0',
  `b_hangar` int(11) NOT NULL DEFAULT '0',
  `b_hangar_id` text NOT NULL,
  `b_hangar_plus` int(11) NOT NULL DEFAULT '0',
  `image` varchar(32) NOT NULL DEFAULT 'normaltempplanet01',
  `diameter` int(11) NOT NULL DEFAULT '12800',
  `points` bigint(20) DEFAULT '0',
  `ranks` bigint(20) DEFAULT '0',
  `field_current` int(11) NOT NULL DEFAULT '0',
  `field_max` int(11) NOT NULL DEFAULT '163',
  `temp_min` int(3) NOT NULL DEFAULT '-17',
  `temp_max` int(3) NOT NULL DEFAULT '23',
  `metal` double(132,8) unsigned NOT NULL DEFAULT '0.00000000',
  `metal_perhour` bigint(20) unsigned NOT NULL DEFAULT '0',
  `metal_max` bigint(20) unsigned DEFAULT '100000',
  `crystal` double(132,8) unsigned NOT NULL DEFAULT '0.00000000',
  `crystal_perhour` bigint(20) unsigned NOT NULL DEFAULT '0',
  `crystal_max` bigint(20) unsigned DEFAULT '100000',
  `deuterium` double(132,8) unsigned NOT NULL DEFAULT '0.00000000',
  `deuterium_perhour` bigint(20) unsigned NOT NULL DEFAULT '0',
  `deuterium_max` bigint(20) unsigned DEFAULT '100000',
  `energy_used` varchar(21) NOT NULL DEFAULT '0',
  `energy_max` bigint(20) unsigned NOT NULL DEFAULT '0',
  `debris_m` decimal(30,8) NOT NULL DEFAULT '0.00000000',
  `debris_c` decimal(30,8) NOT NULL DEFAULT '0.00000000',
  `metal_mine` int(11) NOT NULL DEFAULT '0',
  `crystal_mine` int(11) NOT NULL DEFAULT '0',
  `deuterium_sintetizer` int(11) NOT NULL DEFAULT '0',
  `solar_plant` int(11) NOT NULL DEFAULT '0',
  `fusion_plant` int(11) NOT NULL DEFAULT '0',
  `robot_factory` int(11) NOT NULL DEFAULT '0',
  `nano_factory` int(11) NOT NULL DEFAULT '0',
  `hangar` int(11) NOT NULL DEFAULT '0',
  `metal_store` int(11) NOT NULL DEFAULT '0',
  `crystal_store` int(11) NOT NULL DEFAULT '0',
  `deuterium_store` int(11) NOT NULL DEFAULT '0',
  `laboratory` int(11) NOT NULL DEFAULT '0',
  `terraformer` int(11) NOT NULL DEFAULT '0',
  `ally_deposit` int(11) NOT NULL DEFAULT '0',
  `silo` int(11) NOT NULL DEFAULT '0',
  `res_portal` int(11) NOT NULL DEFAULT '0',
  `small_ship_cargo` bigint(11) NOT NULL DEFAULT '0',
  `big_ship_cargo` bigint(11) NOT NULL DEFAULT '0',
  `light_hunter` bigint(11) NOT NULL DEFAULT '0',
  `heavy_hunter` bigint(11) NOT NULL DEFAULT '0',
  `crusher` bigint(11) NOT NULL DEFAULT '0',
  `battle_ship` bigint(11) NOT NULL DEFAULT '0',
  `colonizer` bigint(11) NOT NULL DEFAULT '0',
  `recycler` bigint(11) NOT NULL DEFAULT '0',
  `spy_sonde` bigint(11) NOT NULL DEFAULT '0',
  `bomber_ship` bigint(11) NOT NULL DEFAULT '0',
  `solar_satelit` bigint(11) NOT NULL DEFAULT '0',
  `destructor` bigint(11) NOT NULL DEFAULT '0',
  `dearth_star` bigint(11) NOT NULL DEFAULT '0',
  `battleship` bigint(11) NOT NULL DEFAULT '0',
  `chuck` bigint(11) NOT NULL DEFAULT '0',
  `gr_troop` bigint(11) NOT NULL DEFAULT '0',
  `misil_launcher` bigint(11) NOT NULL DEFAULT '0',
  `small_laser` bigint(11) NOT NULL DEFAULT '0',
  `big_laser` bigint(11) NOT NULL DEFAULT '0',
  `gauss_canyon` bigint(11) NOT NULL DEFAULT '0',
  `ionic_canyon` bigint(11) NOT NULL DEFAULT '0',
  `buster_canyon` bigint(11) NOT NULL DEFAULT '0',
  `small_protection_shield` int(11) NOT NULL DEFAULT '0',
  `big_protection_shield` int(11) NOT NULL DEFAULT '0',
  `sm_grav_dome` bigint(11) NOT NULL DEFAULT '0',
  `xl_grav_dome` bigint(11) NOT NULL DEFAULT '0',
  `interceptor_misil` int(11) NOT NULL DEFAULT '0',
  `interplanetary_misil` int(11) NOT NULL DEFAULT '0',
  `supernova` bigint(20) NOT NULL DEFAULT '0',
  `metal_mine_porcent` int(11) NOT NULL DEFAULT '10',
  `crystal_mine_porcent` int(11) NOT NULL DEFAULT '10',
  `deuterium_sintetizer_porcent` int(11) NOT NULL DEFAULT '10',
  `solar_plant_porcent` int(11) NOT NULL DEFAULT '10',
  `fusion_plant_porcent` int(11) NOT NULL DEFAULT '10',
  `solar_satelit_porcent` int(11) NOT NULL DEFAULT '10',
  `mondbasis` bigint(11) NOT NULL DEFAULT '0',
  `phalanx` bigint(11) NOT NULL DEFAULT '0',
  `sprungtor` bigint(11) NOT NULL DEFAULT '0',
  `last_jump_time` int(11) NOT NULL DEFAULT '0',
  `jumpgateTimer` int(11) NOT NULL,
  `b_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `indentity` (`galaxy`,`system`,`planet`,`planet_type`),
  KEY `galaxy_system_planet` (`galaxy`,`system`,`planet`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}rw`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}rw` (
  `rid` varchar(72) NOT NULL,
  `raport` text NOT NULL,
  `bbcode` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `aks_info` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `a_zestrzelona` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `owners` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  UNIQUE KEY `rid` (`rid`),
  KEY `id_owner1` (`rid`),
  KEY `id_owner2` (`rid`),
  KEY `time` (`time`),
  FULLTEXT KEY `raport` (`raport`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}statpoints`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}statpoints` (
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
  `total_archive` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  KEY `TECH` (`tech_points`),
  KEY `BUILDS` (`build_points`),
  KEY `DEFS` (`defs_points`),
  KEY `FLEET` (`fleet_points`),
  KEY `TOTAL` (`total_points`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}supp`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}supp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}topkb`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}topkb` (
  `time` bigint(50) NOT NULL DEFAULT '0',
  `rid` varchar(32) NOT NULL,
  `attacker` varchar(255) NOT NULL,
  `defender` varchar(255) NOT NULL,
  `fleet_result` int(1) NOT NULL DEFAULT '0',
  `lost` bigint(100) NOT NULL DEFAULT '0',
  UNIQUE KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{{prefix}}users`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}users` (
  `id` bigint(5) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` int(6) NOT NULL,
  `username` varchar(101) NOT NULL,
  `password` varchar(64) NOT NULL DEFAULT '',
  `sec_qu` text NOT NULL,
  `sec_ans` text NOT NULL,
  `validate` int(8) NOT NULL DEFAULT '0',
  `adminNotes` text NOT NULL,
  `email` varchar(101) NOT NULL,
  `email_2` varchar(101) NOT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'en',
  `authlevel` tinyint(1) NOT NULL DEFAULT '0',
  `sex` char(1) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `banner_source_post` varchar(1000) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '../images/bann.png',
  `referal` varchar(15) NOT NULL DEFAULT '0',
  `sign` text,
  `id_planet` int(7) NOT NULL DEFAULT '0',
  `galaxy` int(3) NOT NULL DEFAULT '0',
  `system` int(3) NOT NULL DEFAULT '0',
  `planet` int(3) NOT NULL DEFAULT '0',
  `current_planet` int(7) NOT NULL DEFAULT '0',
  `user_lastip` varchar(16) NOT NULL DEFAULT '',
  `user_agent` text NOT NULL,
  `ip_at_reg` varchar(16) NOT NULL,
  `menus_update` int(11) NOT NULL DEFAULT '0',
  `current_page` text NOT NULL,
  `register_time` int(11) NOT NULL DEFAULT '0',
  `onlinetime` int(11) NOT NULL DEFAULT '0',
  `forum_online` varchar(10) NOT NULL DEFAULT 'offline',
  `skin` varchar(255) DEFAULT NULL,
  `dpath` varchar(255) NOT NULL DEFAULT '',
  `design` tinyint(1) NOT NULL DEFAULT '1',
  `menutype` varchar(20) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT 'scroll',
  `noipcheck` tinyint(4) NOT NULL DEFAULT '1',
  `planet_sort` tinyint(1) NOT NULL DEFAULT '0',
  `planet_sort_order` tinyint(1) NOT NULL DEFAULT '0',
  `spio_anz` tinyint(4) NOT NULL DEFAULT '1',
  `settings_tooltiptime` tinyint(4) NOT NULL DEFAULT '5',
  `settings_fleetactions` tinyint(4) NOT NULL DEFAULT '0',
  `settings_allylogo` tinyint(4) NOT NULL DEFAULT '0',
  `settings_esp` tinyint(4) NOT NULL DEFAULT '1',
  `settings_wri` tinyint(4) NOT NULL DEFAULT '1',
  `settings_bud` tinyint(4) NOT NULL DEFAULT '1',
  `settings_mis` tinyint(4) NOT NULL DEFAULT '1',
  `settings_rep` tinyint(4) NOT NULL DEFAULT '0',
  `urlaubs_modus` int(11) NOT NULL DEFAULT '0',
  `urlaubs_until` int(11) NOT NULL DEFAULT '0',
  `db_deaktjava` tinyint(4) NOT NULL DEFAULT '0',
  `new_message` int(11) NOT NULL DEFAULT '0',
  `messages` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `battles` varchar(30) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT '0,0,0',
  `fleet_shortcut` text,
  `b_tech_planet` int(11) NOT NULL DEFAULT '0',
  `researchers` int(11) NOT NULL DEFAULT '3',
  `matter` bigint(132) NOT NULL DEFAULT '0',
  `spy_tech` int(11) NOT NULL DEFAULT '0',
  `computer_tech` int(11) NOT NULL DEFAULT '0',
  `military_tech` int(11) NOT NULL DEFAULT '0',
  `defence_tech` int(11) NOT NULL DEFAULT '0',
  `shield_tech` int(11) NOT NULL DEFAULT '0',
  `energy_tech` int(11) NOT NULL DEFAULT '0',
  `hyperspace_tech` int(11) NOT NULL DEFAULT '0',
  `combustion_tech` int(11) NOT NULL DEFAULT '0',
  `impulse_motor_tech` int(11) NOT NULL DEFAULT '0',
  `hyperspace_motor_tech` int(11) NOT NULL DEFAULT '0',
  `hyperspace_mapping_tech` int(11) NOT NULL DEFAULT '0',
  `laser_tech` int(11) NOT NULL DEFAULT '0',
  `ionic_tech` int(11) NOT NULL DEFAULT '0',
  `buster_tech` int(11) NOT NULL DEFAULT '0',
  `intergalactic_tech` int(11) NOT NULL DEFAULT '0',
  `interalliance_tech` int(11) NOT NULL DEFAULT '0',
  `astrophysics` int(11) NOT NULL DEFAULT '0',
  `colonisation_tech` int(11) NOT NULL DEFAULT '0',
  `graviton_tech` int(11) NOT NULL DEFAULT '0',
  `total_rank` int(6) NOT NULL DEFAULT '0',
  `total_points` int(20) NOT NULL DEFAULT '0',
  `perma_points` int(25) NOT NULL DEFAULT '0',
  `fleet_rank` int(6) NOT NULL DEFAULT '0',
  `fleet_points` int(20) NOT NULL DEFAULT '0',
  `research_rank` int(6) NOT NULL DEFAULT '0',
  `research_points` int(20) NOT NULL DEFAULT '0',
  `ally_id` int(11) NOT NULL DEFAULT '0',
  `ally_name` varchar(32) DEFAULT '',
  `ally_request` int(11) NOT NULL DEFAULT '0',
  `ally_request_text` text,
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_rank` int(3) NOT NULL DEFAULT '0',
  `ally_rank_name` varchar(64) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT 'Newbie',
  `current_luna` int(11) NOT NULL DEFAULT '0',
  `kolorminus` varchar(11) NOT NULL DEFAULT 'red',
  `kolorplus` varchar(11) NOT NULL DEFAULT '#00FF00',
  `kolorpoziom` varchar(11) NOT NULL DEFAULT 'yellow',
  `off_command` int(11) NOT NULL DEFAULT '0',
  `off_admiral` int(11) NOT NULL DEFAULT '0',
  `off_engineer` int(11) NOT NULL DEFAULT '0',
  `off_geologist` int(11) NOT NULL DEFAULT '0',
  `off_technocrat` int(11) NOT NULL DEFAULT '0',
  `off_command_exp` int(11) NOT NULL DEFAULT '0',
  `off_admiral_exp` int(11) NOT NULL DEFAULT '0',
  `off_engineer_exp` int(11) NOT NULL DEFAULT '0',
  `off_geologist_exp` int(11) NOT NULL DEFAULT '0',
  `off_technocrat_exp` int(11) NOT NULL DEFAULT '0',
  `off_spent` int(11) NOT NULL DEFAULT '0',
  `rpg_geologue` int(11) NOT NULL DEFAULT '0',
  `rpg_amiral` int(11) NOT NULL DEFAULT '0',
  `rpg_ingenieur` int(11) NOT NULL DEFAULT '0',
  `rpg_technocrate` int(11) NOT NULL DEFAULT '0',
  `rpg_constructeur` int(11) NOT NULL DEFAULT '0',
  `rpg_scientifique` int(11) NOT NULL DEFAULT '0',
  `rpg_stockeur` int(11) NOT NULL DEFAULT '0',
  `rpg_defenseur` int(11) NOT NULL DEFAULT '0',
  `rpg_bunker` int(11) NOT NULL DEFAULT '0',
  `rpg_espion` int(11) NOT NULL DEFAULT '0',
  `rpg_commandant` int(11) NOT NULL DEFAULT '0',
  `rpg_destructeur` int(11) NOT NULL DEFAULT '0',
  `rpg_general` int(11) NOT NULL DEFAULT '0',
  `rpg_raideur` int(11) NOT NULL DEFAULT '0',
  `rpg_empereur` int(11) NOT NULL DEFAULT '0',
  `rpg_points` int(11) NOT NULL DEFAULT '0',
  `lvl_minier` int(11) NOT NULL DEFAULT '1',
  `lvl_raid` int(11) NOT NULL DEFAULT '1',
  `xpraid` int(11) NOT NULL DEFAULT '0',
  `xpminier` int(11) NOT NULL DEFAULT '0',
  `raids` bigint(20) NOT NULL DEFAULT '0',
  `p_infligees` bigint(20) NOT NULL DEFAULT '0',
  `mnl_alliance` int(11) NOT NULL,
  `mnl_joueur` int(11) NOT NULL,
  `mnl_attaque` int(11) NOT NULL,
  `mnl_spy` int(11) NOT NULL,
  `mnl_exploit` int(11) NOT NULL,
  `mnl_transport` int(11) NOT NULL,
  `mnl_expedition` int(11) NOT NULL,
  `mnl_buildlist` int(11) NOT NULL,
  `messageliste` int(11) NOT NULL,
  `banned_by` varchar(15) NOT NULL DEFAULT '0',
  `banned_until` int(11) NOT NULL DEFAULT '0',
  `banned_reason` int(2) NOT NULL,
  `multi_validated` int(11) DEFAULT NULL,
  `raids1` int(11) DEFAULT NULL,
  `raidswin` int(11) DEFAULT NULL,
  `raidsloose` int(11) DEFAULT NULL,
  `last_researcher_search` int(11) NOT NULL DEFAULT '0' COMMENT 'When was the last search for researchers',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
