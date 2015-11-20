-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Nov 2015 um 11:07
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `aq`
--

INSERT INTO `aq` (`aq_id`, `aq_start`, `aq_end`, `aq_points`, `aq_result`) VALUES
(1, 1446678000, 1447109999, 9500000, 75),
(2, 1447887600, 1448319599, NULL, NULL);

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
  `uaqres_points` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`uaqres_aq_id`,`uaqres_aqday_id`,`uaqres_user_id`),
  KEY `useraqres_FKIndex1` (`uaqres_user_id`),
  KEY `useraqres_FKIndex2` (`uaqres_aqday_id`),
  KEY `uaqres_id` (`uaqres_id`),
  KEY `uaqres_aq_id` (`uaqres_aq_id`),
  KEY `uaqres_aqday_id` (`uaqres_aqday_id`),
  KEY `uaqres_user_id` (`uaqres_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=356 ;

--
-- Daten für Tabelle `useraqres`
--

INSERT INTO `useraqres` (`uaqres_id`, `uaqres_aq_id`, `uaqres_aqday_id`, `uaqres_user_id`, `uaqres_points`) VALUES
(110, 1, 0, 1, 2),
(112, 1, 0, 2, 5),
(111, 1, 0, 4, 3543),
(109, 1, 0, 5, 35453),
(106, 1, 0, 8, 1),
(352, 1, 1, 1, 59269),
(355, 1, 1, 2, 5),
(354, 1, 1, 3, 500),
(353, 1, 1, 4, 3543),
(351, 1, 1, 5, 35453),
(331, 1, 2, 1, 55859),
(334, 1, 2, 2, 5),
(333, 1, 2, 3, 423423),
(332, 1, 2, 4, 4324),
(330, 1, 2, 5, 5),
(329, 1, 2, 8, 32434),
(337, 1, 3, 1, 124015),
(339, 1, 3, 2, 5),
(338, 1, 3, 4, 123),
(336, 1, 3, 5, 35453),
(335, 1, 3, 8, 423),
(342, 1, 4, 1, 123669),
(345, 1, 4, 2, 5),
(344, 1, 4, 3, 442342),
(343, 1, 4, 4, 434534),
(341, 1, 4, 5, 543),
(340, 1, 4, 8, 23423),
(347, 1, 5, 1, 272859),
(350, 1, 5, 2, 5),
(349, 1, 5, 3, 789456),
(348, 1, 5, 4, 423423),
(346, 1, 5, 8, 124342),
(196, 2, 1, 5, 111),
(195, 2, 1, 8, 555),
(197, 2, 2, 8, 555),
(198, 2, 3, 8, 555),
(199, 2, 4, 8, 55);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) DEFAULT NULL,
  `user_entrydate` bigint(20) DEFAULT NULL,
  `user_leftdate` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_entrydate`, `user_leftdate`) VALUES
(1, 'Fox', 1445330202, NULL),
(2, 'Multitalent', 1445330202, NULL),
(3, 'Jule', 1445330202, NULL),
(4, 'g0k', 1445330202, NULL),
(5, 'Flo', 1445330202, NULL),
(6, 'heinreich', 1447923323, NULL),
(7, 'lenzer', 1447723348, 1447923348),
(8, 'blubber', 1446764400, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userteam`
--

CREATE TABLE IF NOT EXISTS `userteam` (
  `userteam_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userteam_user_id` int(10) unsigned NOT NULL,
  `userteam_team` int(10) unsigned DEFAULT NULL,
  `userteam_from` bigint(20) DEFAULT NULL,
  `userteam_to` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`userteam_id`),
  KEY `userteam_FKIndex1` (`userteam_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `userteam`
--

INSERT INTO `userteam` (`userteam_id`, `userteam_user_id`, `userteam_team`, `userteam_from`, `userteam_to`) VALUES
(1, 1, 2, 1446591600, 1446937200),
(2, 2, 3, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 3, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
