-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 21. Aug 2013 um 21:59
-- Server Version: 5.6.13-log
-- PHP-Version: 5.5.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `legasthenie_projekt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(130) NOT NULL,
  `FirstName` varchar(60) NOT NULL,
  `eMail` varchar(160) NOT NULL,
  `Password_Salt` varchar(255) NOT NULL,
  `Password_Hash` char(64) NOT NULL,
  `Permissions` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `accounts`
--

INSERT INTO `accounts` (`ID`, `Name`, `FirstName`, `eMail`, `Password_Salt`, `Password_Hash`, `Permissions`) VALUES
(1, 'Admin', 'Admin', 'admin@legasthenie-projekt.dev', '$2a$13$LEu1kDNTAETVFqpFhjmIne', '$2a$13$LEu1kDNTAETVFqpFhjmIneyTR9xIKkmPGOqlV3DAfb3foWeXkaguq', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `account_rights_adjust`
--

CREATE TABLE IF NOT EXISTS `account_rights_adjust` (
  `accountID` int(11) NOT NULL,
  `rightID` int(11) NOT NULL,
  `adjustment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `rightID` int(11) NOT NULL AUTO_INCREMENT,
  `rightName` varchar(100) NOT NULL,
  PRIMARY KEY (`rightID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Daten für Tabelle `rights`
--

INSERT INTO `rights` (`rightID`, `rightName`) VALUES
(1, 'Benutzer anlegen'),
(2, 'Benutzer bearbeiten'),
(3, 'Benutzer l&ouml;schen'),
(4, 'Benutzer sperren'),
(5, 'Benutzer entsperren'),
(6, 'Passwort zur&uuml;cksetzen'),
(7, 'Test anlegen'),
(8, 'Test bearbeiten'),
(9, 'Test l&ouml;schen'),
(10, 'Test deaktivieren'),
(11, 'Test aktivieren'),
(12, 'Bild hochladen'),
(13, 'Bild l&ouml;schen'),
(14, 'Rechte bearbeiten'),
(15, 'Administrator sperren'),
(16, 'Administrator entsperren'),
(17, 'Administratorrechte entziehen'),
(18, 'Administratorrechte vergeben'),
(19, 'Benutzer auflisten');

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
(1, 19);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
