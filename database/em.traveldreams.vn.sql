-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2013 at 05:22 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `em.traveldreams.vn`
--

-- --------------------------------------------------------

--
-- Table structure for table `accenttypes`
--

CREATE TABLE IF NOT EXISTS `accenttypes` (
  `AccentTypeId` int(11) NOT NULL,
  `AccentName` varchar(50) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AccentTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `FileId` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Extension` varchar(5) NOT NULL,
  `MimeType` varchar(50) DEFAULT NULL,
  `SHA1` varchar(250) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`FileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `LanguageId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Code` varchar(5) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`LanguageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `meanings`
--

CREATE TABLE IF NOT EXISTS `meanings` (
  `MeaningId` int(11) NOT NULL,
  `WordId` int(11) NOT NULL,
  `LanguageId` int(11) NOT NULL,
  `Meaning` text NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `ApprovedBy` int(11) DEFAULT NULL,
  `IsApproved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MeaningId`),
  KEY `FK_Meanings_Words_WordId_idx` (`WordId`),
  KEY `FK_Meanings_Languages_LanguageId_idx` (`LanguageId`),
  KEY `FK_Meanings_Users_CreatedBy_idx` (`CreatedBy`),
  KEY `FK_Meanings_Users_UpdatedBy_idx` (`UpdatedBy`),
  KEY `FK_Meanings_Users_ApprovedBy_idx` (`ApprovedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sentences`
--

CREATE TABLE IF NOT EXISTS `sentences` (
  `SentenceId` int(11) NOT NULL,
  `ParentSentenceId` int(11) DEFAULT NULL,
  `LanguageId` int(11) NOT NULL,
  `WordId` int(11) NOT NULL,
  `Sentence` text NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `ApprovedBy` int(11) DEFAULT NULL,
  `IsApproved` tinyint(1) NOT NULL DEFAULT '0',
  `IsActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SentenceId`),
  KEY `FK_Sentences_Users_CreatedBy_idx` (`CreatedBy`),
  KEY `FK_Sentences_Users_UpdatedBy_idx` (`UpdatedBy`),
  KEY `FK_Sentences_Users_ApprovedBy_idx` (`ApprovedBy`),
  KEY `FK_Sentences_Languages_LanguageId_idx` (`LanguageId`),
  KEY `FK_Sentences_ParentSentenceId_idx` (`ParentSentenceId`),
  KEY `FK_Sentences_Words_WordId_idx` (`WordId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(11) NOT NULL,
  `FullName` varchar(250) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `voices`
--

CREATE TABLE IF NOT EXISTS `voices` (
  `VoiceId` int(11) NOT NULL,
  `AccentTypeId` int(11) NOT NULL,
  `FileId` int(11) NOT NULL,
  `LanguageId` int(11) DEFAULT NULL,
  `ObjectId` int(11) NOT NULL,
  `ObjectType` enum('WORD','SENTENCE') NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `ApprovedBy` int(11) DEFAULT NULL,
  `IsApproved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`VoiceId`),
  KEY `FK_Voices_AccentTypes_AccentTypeId_idx` (`AccentTypeId`),
  KEY `FK_Voices_Languages_LanguageId_idx` (`LanguageId`),
  KEY `FK_Voices_Files_FileId_idx` (`FileId`),
  KEY `FK_Voices_Users_CreatedBy_idx` (`CreatedBy`),
  KEY `FK_Voices_Users_UpdatedBy_idx` (`UpdatedBy`),
  KEY `FK_Voices_Users_ApprovedBy_idx` (`ApprovedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE IF NOT EXISTS `words` (
  `WordId` int(11) NOT NULL,
  `Word` varchar(50) NOT NULL,
  `Status` enum('NEED CONTENT','WAITING APPROVE CONTENT','NEED SOUND','WAITING APPROVE SOUND','COMPLETED') NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `ApprovedBy` int(11) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`WordId`),
  KEY `FK_Words_Users_ApprovedBy_idx` (`ApprovedBy`),
  KEY `FK_Words_Users_CreatedBy_idx` (`CreatedBy`),
  KEY `FK_Words_Users_UpdatedBy_idx` (`UpdatedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meanings`
--
ALTER TABLE `meanings`
  ADD CONSTRAINT `FK_Meanings_Languages_LanguageId` FOREIGN KEY (`LanguageId`) REFERENCES `languages` (`LanguageId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Meanings_Users_ApprovedBy` FOREIGN KEY (`ApprovedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Meanings_Users_CreatedBy` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Meanings_Users_UpdatedBy` FOREIGN KEY (`UpdatedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Meanings_Words_WordId` FOREIGN KEY (`WordId`) REFERENCES `words` (`WordId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sentences`
--
ALTER TABLE `sentences`
  ADD CONSTRAINT `FK_Sentences_Languages_LanguageId` FOREIGN KEY (`LanguageId`) REFERENCES `languages` (`LanguageId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sentences_ParentSentenceId` FOREIGN KEY (`ParentSentenceId`) REFERENCES `sentences` (`SentenceId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sentences_Users_ApprovedBy` FOREIGN KEY (`ApprovedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sentences_Users_CreatedBy` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sentences_Users_UpdatedBy` FOREIGN KEY (`UpdatedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sentences_Words_WordId` FOREIGN KEY (`WordId`) REFERENCES `words` (`WordId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `voices`
--
ALTER TABLE `voices`
  ADD CONSTRAINT `FK_Voices_AccentTypes_AccentTypeId` FOREIGN KEY (`AccentTypeId`) REFERENCES `accenttypes` (`AccentTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Voices_Files_FileId` FOREIGN KEY (`FileId`) REFERENCES `files` (`FileId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Voices_Languages_LanguageId` FOREIGN KEY (`LanguageId`) REFERENCES `languages` (`LanguageId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Voices_Users_ApprovedBy` FOREIGN KEY (`ApprovedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Voices_Users_CreatedBy` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Voices_Users_UpdatedBy` FOREIGN KEY (`UpdatedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `words`
--
ALTER TABLE `words`
  ADD CONSTRAINT `FK_Words_Users_ApprovedBy` FOREIGN KEY (`ApprovedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Words_Users_CreatedBy` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Words_Users_UpdatedBy` FOREIGN KEY (`UpdatedBy`) REFERENCES `users` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
