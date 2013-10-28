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

ALTER TABLE  `Words` ADD  `IsToeic` BOOLEAN NOT NULL DEFAULT FALSE;

CREATE TABLE IF NOT EXISTS `WordTags` (
  `WordTagId` int(11) NOT NULL AUTO_INCREMENT,
  `TagId` int(11) NOT NULL,
  `WordId` int(11) NOT NULL,
  PRIMARY KEY (`WordTagId`),
  KEY `FK_WordTags_Tags_TagId_idx` (`TagId`),
  KEY `FK_WordTags_Words_WordId_idx` (`WordId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `WordTags`
ADD CONSTRAINT `FK_WordTags_Words_WordId_idx` FOREIGN KEY (`WordId`) REFERENCES `Words` (`WordId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_WordTags_Tags_TagId_idx` FOREIGN KEY (`TagId`) REFERENCES `Tags` (`TagId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

INSERT INTO  `em.traveldreams.vn`.`Languages` (
  `LanguageId` , `Name` , `Code` , `IsActive`
)
VALUES (NULL ,  'English',  'en',  '1'),
       (NULL ,  'Vietnamese',  'vi',  '1');

ALTER TABLE  `Sentences` ADD  `Order` INT( 2 ) NOT NULL
/*======================================= End 28-10-2013 =======================================*/
