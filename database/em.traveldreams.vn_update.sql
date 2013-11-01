/*======================================= Begin 28-10-2013 =======================================*/
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

ALTER TABLE  `Sentences` ADD  `Order` INT( 2 ) NOT NULL;

INSERT INTO  `em.traveldreams.vn`.`Users` (
`UserId` , `FullName` , `Username` , `Password` , `IsActive`
)
VALUES (
NULL ,  'Van Dao',  'vandao', MD5(  'password' ) ,  '0'
);

INSERT INTO  `em.traveldreams.vn`.`Words` (
  `WordId` , `Word` , `Status` , `CreatedBy` , `CreatedDate` , `UpdatedBy` , `UpdatedDate` , `ApprovedBy` , `IsActive` , `IsToeic`
)
  VALUES (
    NULL ,  'Hello',  'NEED CONTENT',  '1',  '2013-10-28 00:00:00', NULL , NULL , NULL ,  '1',  '1'
  );

INSERT INTO  `em.traveldreams.vn`.`Sentences` (
  `SentenceId` , `ParentSentenceId` , `LanguageId` , `WordId` , `Sentence` , `CreatedBy` , `CreatedDate` , `UpdatedBy` , `UpdatedDate` , `ApprovedBy` , `IsApproved` , `IsActive` , `Order`
)
  VALUES (
    NULL , NULL ,  '1',  '1',  'Hello, How are you?',  '1',  '2013-10-28 00:00:00', NULL , NULL , NULL ,  '0',  '1',  '1'),
  (NULL ,  '1',  '2',  '1',  'Xin chào, Bạn có khoẻ không?',  '1',  '2013-10-28 00:00:00', NULL , NULL , NULL ,  '0',  '0',  '2');

INSERT INTO  `em.traveldreams.vn`.`Tags` (
  `TagId` , `TagName` , `IsActive`
)
  VALUES (
    NULL ,  'Welcome',  '1'
  );

INSERT INTO  `em.traveldreams.vn`.`WordTags` (
  `WordTagId` , `TagId` , `WordId`
)
  VALUES (
    NULL ,  '1',  '1'
  );
INSERT INTO `em.traveldreams.vn`.`Meanings` (
  `MeaningId`, `WordId`, `LanguageId`, `Meaning`, `CreatedBy`, `CreatedDate`, `UpdatedBy`, `UpdatedDate`, `ApprovedBy`, `IsApproved`
)
  VALUES (
    NULL, '1', '1', 'an expression of greeting', '1', '2013-10-28 00:00:00', NULL, NULL, NULL, '0'),
  (NULL, '1', '2', 'Xin chào!, Chào anh!, Chào chị!', '1', '2013-10-28 00:00:00', NULL, NULL, NULL, '0');

INSERT INTO `em.traveldreams.vn`.`AccentTypes` (`AccentTypeId`, `AccentName`, `IsActive`) VALUES (NULL, 'US Male', '1'), (NULL, 'VN Male', '1');
/*======================================= End 28-10-2013 =======================================*/

/*======================================= End 01-11-2013 =======================================*/
ALTER TABLE  `Files` ADD UNIQUE (
  `SHA1`
)
/*======================================= End 01-11-2013 =======================================*/
