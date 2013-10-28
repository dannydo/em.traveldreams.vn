/*======================================= Begin 28-10-2013 =======================================*/

/**
* it was running
 */

ALTER TABLE  `AccentTypes` CHANGE  `AccentTypeId`  `AccentTypeId` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `Files` CHANGE  `FileId`  `FileId` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `Languages` CHANGE  `LanguageId`  `LanguageId` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `Meanings` CHANGE  `MeaningId`  `MeaningId` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `Sentences` CHANGE  `SentenceId`  `SentenceId` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `Users` CHANGE  `UserId`  `UserId` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `Voices` CHANGE  `VoiceId`  `VoiceId` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `Words` CHANGE  `WordId`  `WordId` INT( 11 ) NOT NULL AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `Tags` (
  `TagId` int(11) NOT NULL AUTO_INCREMENT,
  `TagName` varchar(50) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TagId`),
  UNIQUE KEY `TagName` (`TagName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*======================================= End 28-10-2013 =======================================*/
