-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Nov 2015 um 06:38
-- Server Version: 5.6.16
-- PHP-Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `mcoc`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aq`
--

CREATE TABLE IF NOT EXISTS `aq` (
  `aq_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aq_start` bigint(20) DEFAULT NULL,
  `aq_end` bigint(20) DEFAULT NULL,
  `aq_points` int(10) unsigned DEFAULT NULL,
  `aq_result` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`aq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `aq`
--

INSERT INTO `aq` (`aq_id`, `aq_start`, `aq_end`, `aq_points`, `aq_result`) VALUES
(1, 1446678000, 1447109999, 9500000, 75),
(2, 1447887600, 1448319599, NULL, NULL),
(3, 1447887600, 1448319599, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aqday`
--

CREATE TABLE IF NOT EXISTS `aqday` (
  `aqday_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aqday_aq_id` int(10) unsigned NOT NULL,
  `aqday_number` int(10) unsigned DEFAULT NULL,
  `aqday_result` int(10) unsigned DEFAULT NULL,
  `ayday_percent` int(10) unsigned DEFAULT NULL,
  `ayday_mission` varchar(100) DEFAULT NULL,
  `aqday_prestige` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`aqday_id`),
  KEY `aqday_FKIndex1` (`aqday_aq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eventmilestones`
--

CREATE TABLE IF NOT EXISTS `eventmilestones` (
  `em_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `em_event_id` int(10) unsigned NOT NULL,
  `em_desc` varchar(200) DEFAULT NULL,
  `em_points` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`em_id`),
  KEY `eventmilestones_FKIndex1` (`em_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eventpart`
--

CREATE TABLE IF NOT EXISTS `eventpart` (
  `epart_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `epart_user_id` int(10) unsigned NOT NULL,
  `epart_event_id` int(10) unsigned NOT NULL,
  `epart_points` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`epart_id`),
  KEY `eventpart_FKIndex1` (`epart_user_id`),
  KEY `eventpart_FKIndex2` (`epart_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_etype_id` int(10) unsigned NOT NULL,
  `event_name` varchar(200) DEFAULT NULL,
  `event_start` date DEFAULT NULL,
  `event_end` date DEFAULT NULL,
  `event_points` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `events_FKIndex1` (`event_etype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eventtype`
--

CREATE TABLE IF NOT EXISTS `eventtype` (
  `etype_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `etype_des` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`etype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `eventtype`
--

INSERT INTO `eventtype` (`etype_id`, `etype_des`) VALUES
(1, '1-tages Event'),
(2, '3-tages Event'),
(3, '7-tages Event');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `useraqres`
--

CREATE TABLE IF NOT EXISTS `useraqres` (
  `uaqres_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uaqres_aq_id` int(11) NOT NULL,
  `uaqres_aqday_id` int(10) unsigned NOT NULL,
  `uaqres_user_id` int(10) unsigned NOT NULL,
  `uaqres_team` int(11) NOT NULL DEFAULT '0',
  `uaqres_points` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`uaqres_aq_id`,`uaqres_aqday_id`,`uaqres_user_id`),
  KEY `useraqres_FKIndex1` (`uaqres_user_id`),
  KEY `useraqres_FKIndex2` (`uaqres_aqday_id`),
  KEY `uaqres_id` (`uaqres_id`),
  KEY `uaqres_aq_id` (`uaqres_aq_id`),
  KEY `uaqres_aqday_id` (`uaqres_aqday_id`),
  KEY `uaqres_user_id` (`uaqres_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1492 ;

--
-- Daten für Tabelle `useraqres`
--

INSERT INTO `useraqres` (`uaqres_id`, `uaqres_aq_id`, `uaqres_aqday_id`, `uaqres_user_id`, `uaqres_team`, `uaqres_points`) VALUES
(1475, 1, 1, 22, 1, 150769),
(1483, 1, 1, 23, 3, 175469),
(1488, 1, 1, 24, 3, 113934),
(1490, 1, 1, 25, 2, 142561),
(1474, 1, 1, 26, 2, 59269),
(1478, 1, 1, 27, 1, 85028),
(1467, 1, 1, 28, 1, 49820),
(1466, 1, 1, 29, 2, 107933),
(1491, 1, 1, 30, 1, 42318),
(1479, 1, 1, 31, 2, 51309),
(1481, 1, 1, 32, 3, 70752),
(1477, 1, 1, 33, 3, 75054),
(1489, 1, 1, 34, 3, 65060),
(1464, 1, 1, 35, 1, 54716),
(1487, 1, 1, 36, 2, 55743),
(1472, 1, 1, 37, 1, 63065),
(1485, 1, 1, 38, 2, 53760),
(1473, 1, 1, 39, 3, 39288),
(1482, 1, 1, 40, 3, 52989),
(1484, 1, 1, 41, 3, 43980),
(1463, 1, 1, 42, 2, 58247),
(1469, 1, 1, 43, 2, 41351),
(1465, 1, 1, 44, 2, 37823),
(1471, 1, 1, 45, 2, 68695),
(1462, 1, 1, 46, 1, 58787),
(1476, 1, 1, 47, 3, 14420),
(1468, 1, 1, 48, 3, 25745),
(1486, 1, 1, 49, 1, 22163),
(1480, 1, 1, 50, 1, 8027),
(1470, 1, 1, 51, 1, 19372);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) DEFAULT NULL,
  `user_entrydate` bigint(20) DEFAULT NULL,
  `user_leftdate` bigint(20) DEFAULT NULL,
  `user_defaultteam` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_entrydate`, `user_leftdate`, `user_defaultteam`) VALUES
(22, 'gOk', 1446332400, NULL, 1),
(23, 'multitalent74', 1446332400, NULL, 3),
(24, 'Tito_sy', 1446332400, NULL, 3),
(25, 'zappla', 1446332400, NULL, 2),
(26, 'Fox84', 1446332400, NULL, 2),
(27, 'Jule0777', 1446332400, NULL, 1),
(28, 'cOnTiNuE83', 1446332400, NULL, 1),
(29, 'Ch053n0n2', 1446332400, NULL, 2),
(30, 'Zitarus', 1446332400, NULL, 1),
(31, 'jurginho', 1446332400, NULL, 2),
(32, 'm9k', 1446332400, NULL, 3),
(33, 'Jaaaaa', 1446332400, NULL, 3),
(34, 'Udo203', 1446332400, NULL, 3),
(35, 'Bambis Mutter', 1446332400, NULL, 1),
(36, 'Tieu', 1446332400, NULL, 2),
(37, 'FdBk!', 1446332400, NULL, 1),
(38, 'Rennsemmel', 1446332400, NULL, 2),
(39, 'Flo H', 1446332400, NULL, 3),
(40, 'Malochers', 1446332400, NULL, 3),
(41, 'PI-Billy21', 1446332400, NULL, 3),
(42, 'badboydiz', 1446332400, NULL, 2),
(43, 'Don Mir', 1446332400, NULL, 2),
(44, 'Blackbird26', 1446332400, NULL, 2),
(45, 'Fandy2504', 1446332400, NULL, 2),
(46, 'Akin Dogan', 1446332400, NULL, 1),
(47, 'Groos', 1446332400, NULL, 3),
(48, 'Dfelder', 1446332400, NULL, 3),
(49, 'RoyJn', 1446332400, NULL, 1),
(50, 'Kater cameo', 1446332400, NULL, 1),
(51, 'Earth Guard', 1446332400, NULL, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
