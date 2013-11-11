-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Nov 2013 um 18:45
-- Server Version: 5.6.11
-- PHP-Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `legasthenie_projekt`
--
CREATE DATABASE IF NOT EXISTS `legasthenie_projekt` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `legasthenie_projekt`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(130) NOT NULL,
  `FirstName` varchar(60) NOT NULL,
  `username` varchar(160) NOT NULL,
  `Password_Salt` varchar(255) NOT NULL,
  `Password_Hash` char(64) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `accounts`
--

INSERT INTO `accounts` (`ID`, `Name`, `FirstName`, `username`, `Password_Salt`, `Password_Hash`, `active`) VALUES
(1, 'Admin', 'Admin', 'admin', '$2a$13$LEu1kDNTAETVFqpFhjmIne', '$2a$13$LEu1kDNTAETVFqpFhjmIneyTR9xIKkmPGOqlV3DAfb3foWeXkaguq', 1),
(2, 'sadfsd', 'adminsdfsdf', 'sdfsd@web.de', '$2a$13$JDbYytihCSJjues0K/ts69', '$2a$13$JDbYytihCSJjues0K/ts6uE2LosZQJXKdq9xwlbXlA.zuHUwds4X.', 1),
(3, 'edgar', 'edgar', 'edgar@web.de', '$2a$13$EnNy5S4CjWDbd2XLUyHOdp', '$2a$13$EnNy5S4CjWDbd2XLUyHOdeKFd.PxAjSmb03BH0nidh1aEovLrsBq6', 1),
(4, 'dsfsdf', 'admin', '', '$2a$13$.pUfeV22MiIMSH1N6MPfK1', '$2a$13$.pUfeV22MiIMSH1N6MPfKusTGO8lE9eDRQdDL9op/Uhc9b8WxwUOS', 1),
(5, 'wesdf', 'admin', 'sdfsdffd', '$2a$13$y4wgjvjlEy3g9SVZ.Mioqx', '$2a$13$y4wgjvjlEy3g9SVZ.MioquZsWE56Nn1Dm3BsiDIOKjyNg/BIvO28y', 1),
(6, 'sdfsdfdsf', 'admin', 'sdf', '$2a$13$efYYBMLItyiKIo232xyXnm', '$2a$13$efYYBMLItyiKIo232xyXnePGhF6zTl56x21CMnB9A4a1I7s2twyaS', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `account_rights_adjust`
--

CREATE TABLE IF NOT EXISTS `account_rights_adjust` (
  `accountID` int(11) NOT NULL,
  `rightID` int(11) NOT NULL,
  `adjustment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `account_rights_adjust`
--

INSERT INTO `account_rights_adjust` (`accountID`, `rightID`, `adjustment`) VALUES
(6, 1, -1),
(6, 22, -1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `account_roles`
--

CREATE TABLE IF NOT EXISTS `account_roles` (
  `accountID` int(11) NOT NULL,
  `roleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `account_roles`
--

INSERT INTO `account_roles` (`accountID`, `roleID`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `rightID` int(11) NOT NULL AUTO_INCREMENT,
  `rightName` varchar(100) NOT NULL,
  PRIMARY KEY (`rightID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Daten für Tabelle `rights`
--

INSERT INTO `rights` (`rightID`, `rightName`) VALUES
(1, 'Benutzer anlegen'),
(2, 'Benutzer bearbeiten'),
(3, 'Benutzer löschen'),
(4, 'Benutzer sperren'),
(5, 'Benutzer entsperren'),
(6, 'Passwort zurücksetzen'),
(7, 'Test anlegen'),
(8, 'Test bearbeiten'),
(9, 'Test löschen'),
(10, 'Test deaktivieren'),
(11, 'Test aktivieren'),
(12, 'Bild hochladen'),
(13, 'Bild löschen'),
(14, 'Rechte bearbeiten'),
(15, 'Administrator sperren'),
(16, 'Administrator entsperren'),
(17, 'Administratorrechte entziehen'),
(18, 'Administratorrechte vergeben'),
(19, 'Benutzer auflisten'),
(20, 'Schüler anlegen'),
(21, 'Lehrer anlegen'),
(22, 'Administrator anlegen'),
(23, 'Schüler auflisten');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `roleID` int(11) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(100) NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`roleID`, `roleName`) VALUES
(1, 'Administrator'),
(2, 'Lehrer');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role_rights`
--

CREATE TABLE IF NOT EXISTS `role_rights` (
  `roleID` int(11) NOT NULL,
  `rightID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `role_rights`
--

INSERT INTO `role_rights` (`roleID`, `rightID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schueler`
--

CREATE TABLE IF NOT EXISTS `schueler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `vorname` varchar(150) NOT NULL,
  `geburtsdatum` varchar(150) NOT NULL,
  `geschlecht` varchar(50) NOT NULL,
  `schule` varchar(200) NOT NULL,
  `klasse` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `schueler`
--

INSERT INTO `schueler` (`id`, `name`, `vorname`, `geburtsdatum`, `geschlecht`, `schule`, `klasse`) VALUES
(1, 'max', 'musterman', '01.01.2012', 'M', 'Grundschule Marinenkäfer blablabla', '2a');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
