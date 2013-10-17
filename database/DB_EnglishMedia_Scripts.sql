SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `EnglishMedias` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `EnglishMedias` ;

-- -----------------------------------------------------
-- Table `EnglishMedias`.`Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EnglishMedias`.`Users` (
  `UserId` INT NOT NULL,
  `FullName` VARCHAR(250) NOT NULL,
  `Username` VARCHAR(50) NOT NULL,
  `Password` VARCHAR(50) NOT NULL,
  `IsActive` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`UserId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EnglishMedias`.`Words`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EnglishMedias`.`Words` (
  `WordId` INT NOT NULL,
  `Word` VARCHAR(50) NOT NULL,
  `Status` ENUM('NEED CONTENT', 'WAITING APPROVE CONTENT', 'NEED SOUND', 'WAITING APPROVE SOUND', 'COMPLETED') NOT NULL,
  `CreatedBy` INT NOT NULL,
  `CreatedDate` DATETIME NOT NULL,
  `UpdatedBy` INT NULL,
  `UpdatedDate` DATETIME NULL,
  `ApprovedBy` INT NULL,
  `IsActive` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`WordId`),
  INDEX `FK_Words_Users_ApprovedBy_idx` (`ApprovedBy` ASC),
  INDEX `FK_Words_Users_CreatedBy_idx` (`CreatedBy` ASC),
  INDEX `FK_Words_Users_UpdatedBy_idx` (`UpdatedBy` ASC),
  CONSTRAINT `FK_Words_Users_ApprovedBy`
    FOREIGN KEY (`ApprovedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Words_Users_CreatedBy`
    FOREIGN KEY (`CreatedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Words_Users_UpdatedBy`
    FOREIGN KEY (`UpdatedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EnglishMedias`.`Languages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EnglishMedias`.`Languages` (
  `LanguageId` INT NOT NULL,
  `Name` VARCHAR(50) NOT NULL,
  `Code` VARCHAR(5) NOT NULL,
  `IsActive` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`LanguageId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EnglishMedias`.`Meanings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EnglishMedias`.`Meanings` (
  `MeaningId` INT NOT NULL,
  `WordId` INT NOT NULL,
  `LanguageId` INT NOT NULL,
  `Meaning` TEXT NOT NULL,
  `CreatedBy` INT NOT NULL,
  `CreatedDate` DATETIME NOT NULL,
  `UpdatedBy` INT NULL,
  `UpdatedDate` DATETIME NULL,
  `ApprovedBy` INT NULL,
  `IsApproved` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`MeaningId`),
  INDEX `FK_Meanings_Words_WordId_idx` (`WordId` ASC),
  INDEX `FK_Meanings_Languages_LanguageId_idx` (`LanguageId` ASC),
  INDEX `FK_Meanings_Users_CreatedBy_idx` (`CreatedBy` ASC),
  INDEX `FK_Meanings_Users_UpdatedBy_idx` (`UpdatedBy` ASC),
  INDEX `FK_Meanings_Users_ApprovedBy_idx` (`ApprovedBy` ASC),
  CONSTRAINT `FK_Meanings_Words_WordId`
    FOREIGN KEY (`WordId`)
    REFERENCES `EnglishMedias`.`Words` (`WordId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Meanings_Languages_LanguageId`
    FOREIGN KEY (`LanguageId`)
    REFERENCES `EnglishMedias`.`Languages` (`LanguageId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Meanings_Users_CreatedBy`
    FOREIGN KEY (`CreatedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Meanings_Users_UpdatedBy`
    FOREIGN KEY (`UpdatedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Meanings_Users_ApprovedBy`
    FOREIGN KEY (`ApprovedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EnglishMedias`.`AccentTypes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EnglishMedias`.`AccentTypes` (
  `AccentTypeId` INT NOT NULL,
  `AccentName` VARCHAR(50) NOT NULL,
  `IsActive` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`AccentTypeId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EnglishMedias`.`Files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EnglishMedias`.`Files` (
  `FileId` INT NOT NULL,
  `Name` VARCHAR(250) NOT NULL,
  `Extension` VARCHAR(5) NOT NULL,
  `MimeType` VARCHAR(50) NULL,
  `SHA1` VARCHAR(250) NOT NULL,
  `IsActive` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`FileId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EnglishMedias`.`Voices`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EnglishMedias`.`Voices` (
  `VoiceId` INT NOT NULL,
  `AccentTypeId` INT NOT NULL,
  `FileId` INT NOT NULL,
  `LanguageId` INT NULL,
  `ObjectId` INT NOT NULL,
  `ObjectType` ENUM('WORD', 'SENTENCE') NOT NULL,
  `CreatedBy` INT NOT NULL,
  `CreatedDate` DATETIME NOT NULL,
  `UpdatedBy` INT NULL,
  `UpdatedDate` DATETIME NULL,
  `ApprovedBy` INT NULL,
  `IsApproved` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`VoiceId`),
  INDEX `FK_Voices_AccentTypes_AccentTypeId_idx` (`AccentTypeId` ASC),
  INDEX `FK_Voices_Languages_LanguageId_idx` (`LanguageId` ASC),
  INDEX `FK_Voices_Files_FileId_idx` (`FileId` ASC),
  INDEX `FK_Voices_Users_CreatedBy_idx` (`CreatedBy` ASC),
  INDEX `FK_Voices_Users_UpdatedBy_idx` (`UpdatedBy` ASC),
  INDEX `FK_Voices_Users_ApprovedBy_idx` (`ApprovedBy` ASC),
  CONSTRAINT `FK_Voices_AccentTypes_AccentTypeId`
    FOREIGN KEY (`AccentTypeId`)
    REFERENCES `EnglishMedias`.`AccentTypes` (`AccentTypeId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Voices_Languages_LanguageId`
    FOREIGN KEY (`LanguageId`)
    REFERENCES `EnglishMedias`.`Languages` (`LanguageId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Voices_Files_FileId`
    FOREIGN KEY (`FileId`)
    REFERENCES `EnglishMedias`.`Files` (`FileId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Voices_Users_CreatedBy`
    FOREIGN KEY (`CreatedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Voices_Users_UpdatedBy`
    FOREIGN KEY (`UpdatedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Voices_Users_ApprovedBy`
    FOREIGN KEY (`ApprovedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `EnglishMedias`.`Sentences`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EnglishMedias`.`Sentences` (
  `SentenceId` INT NOT NULL,
  `ParentSentenceId` INT NULL,
  `LanguageId` INT NOT NULL,
  `WordId` INT NOT NULL,
  `Sentence` TEXT NOT NULL,
  `CreatedBy` INT NOT NULL,
  `CreatedDate` DATETIME NOT NULL,
  `UpdatedBy` INT NULL,
  `UpdatedDate` DATETIME NULL,
  `ApprovedBy` INT NULL,
  `IsApproved` TINYINT(1) NOT NULL DEFAULT 0,
  `IsActive` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`SentenceId`),
  INDEX `FK_Sentences_Users_CreatedBy_idx` (`CreatedBy` ASC),
  INDEX `FK_Sentences_Users_UpdatedBy_idx` (`UpdatedBy` ASC),
  INDEX `FK_Sentences_Users_ApprovedBy_idx` (`ApprovedBy` ASC),
  INDEX `FK_Sentences_Languages_LanguageId_idx` (`LanguageId` ASC),
  INDEX `FK_Sentences_ParentSentenceId_idx` (`ParentSentenceId` ASC),
  INDEX `FK_Sentences_Words_WordId_idx` (`WordId` ASC),
  CONSTRAINT `FK_Sentences_Users_CreatedBy`
    FOREIGN KEY (`CreatedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Sentences_Users_UpdatedBy`
    FOREIGN KEY (`UpdatedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Sentences_Users_ApprovedBy`
    FOREIGN KEY (`ApprovedBy`)
    REFERENCES `EnglishMedias`.`Users` (`UserId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Sentences_Languages_LanguageId`
    FOREIGN KEY (`LanguageId`)
    REFERENCES `EnglishMedias`.`Languages` (`LanguageId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Sentences_ParentSentenceId`
    FOREIGN KEY (`ParentSentenceId`)
    REFERENCES `EnglishMedias`.`Sentences` (`SentenceId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_Sentences_Words_WordId`
    FOREIGN KEY (`WordId`)
    REFERENCES `EnglishMedias`.`Words` (`WordId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
