drop database if exists stars;
create database stars;
use stars;

/*create a user in database*/
grant select, insert, update, delete, alter on stars.*
to 'cis2261_admin'@'localhost'
identified by 'stars-innovation';
flush privileges;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `Student`;
DROP TABLE IF EXISTS `ParentOrGuardian`;
DROP TABLE IF EXISTS `Educator`;
DROP TABLE IF EXISTS `SupportEducator`;
DROP TABLE IF EXISTS `Administrator`;
DROP TABLE IF EXISTS `IndividualEducationPlan`;
DROP TABLE IF EXISTS `Course`;
DROP TABLE IF EXISTS `Subject`;
DROP TABLE IF EXISTS `CourseOffering`;
DROP TABLE IF EXISTS `Enrollment`;
DROP TABLE IF EXISTS `School`;
DROP TABLE IF EXISTS `AccessLevel`;
DROP TABLE IF EXISTS `Semester`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `ReportCard`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `Student` (
    `studentID` INTEGER(10) NOT NULL,
    `firstName` VARCHAR(30) NOT NULL,
    `middleName` VARCHAR(30) NOT NULL,
    `lastName` VARCHAR(60) NOT NULL,
    `gender` VARCHAR(50) NOT NULL,
    `dob` CHAR(10) NOT NULL,
    `grade` INTEGER(10) NOT NULL,
    `address` VARCHAR(100) NOT NULL,
    `phoneNum` CHAR(10) NOT NULL,
    `emailAddress` VARCHAR(100) NOT NULL,
    `allergies` VARCHAR(500) NOT NULL,
    `schoolID` INTEGER(10) NOT NULL,
    `guardianID` INTEGER(10),
    `userID` INTEGER(10) NOT NULL,
    `supportEducatorID` INTEGER(10),
    PRIMARY KEY (`studentID`)
);

CREATE TABLE `ParentOrGuardian` (
    `guardianID` INTEGER(10) NOT NULL,
    `firstName` VARCHAR(30) NOT NULL,
    `lastName` VARCHAR(60) NOT NULL,
    `address` VARCHAR(100) NOT NULL,
    `city` VARCHAR(60) NOT NULL,
    `province` VARCHAR(30) NOT NULL,
    `postalCode` CHAR(6) NOT NULL,
    `phoneNum` CHAR(10) NOT NULL,
    `emailAddress` VARCHAR(100) NOT NULL,
    `userID` INTEGER(10) NOT NULL,
    PRIMARY KEY (`guardianID`)
);

CREATE TABLE `Educator` (
    `educatorID` INTEGER(10) NOT NULL,
    `firstName` VARCHAR(30) NOT NULL,
    `lastName` VARCHAR(60) NOT NULL,
    `position` VARCHAR(100) NOT NULL,
    `phoneNumber` CHAR(10) NOT NULL,
    `emailAddress` VARCHAR(100) NOT NULL,
    `userID` INTEGER(10) NOT NULL,
    `schoolID` INTEGER(10) NOT NULL,
    PRIMARY KEY (`educatorID`)
);

CREATE TABLE `SupportEducator` (
    `supportEducatorID` INTEGER(10) NOT NULL,
    `firstName` VARCHAR(30) NOT NULL,
    `lastName` VARCHAR(60) NOT NULL,
    `position` VARCHAR(100) NOT NULL,
    `specialty` VARCHAR(100) NOT NULL,
    `phoneNum` CHAR(10) NOT NULL,
    `emailAddress` VARCHAR(100) NOT NULL,
    `userID` INTEGER(10) NOT NULL,
    `schoolID` INTEGER(10) NOT NULL,
    PRIMARY KEY (`supportEducatorID`)
);

CREATE TABLE `Administrator` (
    `adminID` INTEGER(10) NOT NULL,
    `firstName` VARCHAR(30) NOT NULL,
    `lastName` VARCHAR(60) NOT NULL,
    `position` VARCHAR(100) NOT NULL,
    `schoolID` INTEGER(10) NOT NULL,
    `userID` INTEGER(10) NOT NULL,
    PRIMARY KEY (`adminID`)
);

CREATE TABLE `IndividualEducationPlan` (
    `planID` INTEGER(10) NOT NULL,
    `reason` VARCHAR(100) NOT NULL,
    `dateIssued` CHAR(10) NOT NULL,
    `comments` VARCHAR(500) NOT NULL,
    `supportEducatorID` INTEGER(10) NOT NULL,
    `studentID` INTEGER(10) NOT NULL,
    PRIMARY KEY (`planID`)
);

CREATE TABLE `Course` (
    `courseID` INTEGER(10) NOT NULL,
    `courseName` VARCHAR(100) NOT NULL,
    `subjectCode` CHAR(4) NOT NULL,
    PRIMARY KEY (`courseID`)
);

CREATE TABLE `Subject` (
    `subjectCode` CHAR(4) NOT NULL,
    `subjectName` VARCHAR(40) NOT NULL,
    PRIMARY KEY (`subjectCode`)
);

CREATE TABLE `CourseOffering` (
    `classID` INTEGER(10) NOT NULL,
    `courseID` INTEGER(10) NOT NULL,
    `educatorID` INTEGER(10) NOT NULL,
    `schoolYear` CHAR(9) NOT NULL,
    `semesterNum` CHAR(2) NOT NULL,
    PRIMARY KEY (`classID`)
);

CREATE TABLE `Enrollment` (
    `enrollmentID` INTEGER(10) NOT NULL,
    `mark` INTEGER(5),
    `attendance` INTEGER(5),
    `notes` VARCHAR(500),
    `classID` INTEGER(10) NOT NULL,
    `schoolYear` CHAR(9) NOT NULL,
    `semesterNum` CHAR(2) NOT NULL,
    `studentID` INTEGER(10) NOT NULL,
    PRIMARY KEY (`enrollmentID`)
);

CREATE TABLE `School` (
    `schoolID` INTEGER(10) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `district` VARCHAR(30) NOT NULL,
    `address` VARCHAR(100) NOT NULL,
    `city` VARCHAR(60) NOT NULL,
    `province` VARCHAR(30) NOT NULL,
    `postalCode` CHAR(6) NOT NULL,
    `phoneNum` CHAR(10) NOT NULL,
    `emailAddress` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`schoolID`)
);

CREATE TABLE `AccessLevel` (
    `accessCode` INTEGER(10) NOT NULL,
    `level` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`accessCode`)
);

CREATE TABLE `Semester` (
    `schoolYear` CHAR(9) NOT NULL,
    `semesterNum` CHAR(2) NOT NULL,
    `startDate` CHAR(10) NOT NULL,
    `endDate` CHAR(10) NOT NULL
);

CREATE TABLE `User` (
    `userID` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `accessCode` INTEGER(10) NOT NULL,
    PRIMARY KEY (`userID`)
);

CREATE TABLE `ReportCard` (
    `reportCardID` INTEGER(10) NOT NULL,
    `isRead` BIT(5) NOT NULL,
    `studentID` INTEGER(10) NOT NULL,
    `schoolYear` CHAR(9) NOT NULL,
    `semesterNum` CHAR(2) NOT NULL,
    PRIMARY KEY (`reportCardID`)
);

ALTER TABLE `Semester` ADD CONSTRAINT PK_SEMESTER PRIMARY KEY (`schoolYear`, `semesterNum`);

ALTER TABLE `Enrollment` ADD CONSTRAINT FK_ENROLLMENT FOREIGN KEY (`schoolYear`, `semesterNum`)
REFERENCES `Semester` (`schoolYear`, `semesterNum`);

ALTER TABLE `CourseOffering` ADD CONSTRAINT FK_COURSEOFFERING FOREIGN KEY (`schoolYear`, `semesterNum`)
REFERENCES `Semester` (`schoolYear`, `semesterNum`);

ALTER TABLE `ReportCard` ADD CONSTRAINT FK_REPORTCARD FOREIGN KEY (`schoolYear`, `semesterNum`)
REFERENCES `Semester` (`schoolYear`, `semesterNum`);


ALTER TABLE `Student` ADD FOREIGN KEY (`userID`) REFERENCES `User`(`userID`);
ALTER TABLE `Student` ADD FOREIGN KEY (`guardianID`) REFERENCES `ParentOrGuardian`(`guardianID`);
ALTER TABLE `Student` ADD FOREIGN KEY (`schoolID`) REFERENCES `School`(`schoolID`);
ALTER TABLE `Student` ADD FOREIGN KEY (`supportEducatorID`) REFERENCES `SupportEducator`(`supportEducatorID`);
ALTER TABLE `ParentOrGuardian` ADD FOREIGN KEY (`userID`) REFERENCES `User`(`userID`);
ALTER TABLE `Educator` ADD FOREIGN KEY (`schoolID`) REFERENCES `School`(`schoolID`);
ALTER TABLE `Educator` ADD FOREIGN KEY (`userID`) REFERENCES `User`(`userID`);
ALTER TABLE `SupportEducator` ADD FOREIGN KEY (`schoolID`) REFERENCES `School`(`schoolID`);
ALTER TABLE `SupportEducator` ADD FOREIGN KEY (`userID`) REFERENCES `User`(`userID`);
ALTER TABLE `Administrator` ADD FOREIGN KEY (`schoolID`) REFERENCES `School`(`schoolID`);
ALTER TABLE `Administrator` ADD FOREIGN KEY (`userID`) REFERENCES `User`(`userID`);
ALTER TABLE `IndividualEducationPlan` ADD FOREIGN KEY (`supportEducatorID`) REFERENCES `SupportEducator`(`supportEducatorID`);
ALTER TABLE `IndividualEducationPlan` ADD FOREIGN KEY (`studentID`) REFERENCES `Student`(`studentID`);
ALTER TABLE `Course` ADD FOREIGN KEY (`subjectCode`) REFERENCES `Subject`(`subjectCode`);
ALTER TABLE `CourseOffering` ADD FOREIGN KEY (`educatorID`) REFERENCES `Educator`(`educatorID`);
ALTER TABLE `CourseOffering` ADD FOREIGN KEY (`courseID`) REFERENCES `Course`(`courseID`);
ALTER TABLE `Enrollment` ADD FOREIGN KEY (`studentID`) REFERENCES `Student`(`studentID`);
ALTER TABLE `Enrollment` ADD FOREIGN KEY (`classID`) REFERENCES `CourseOffering`(`classID`);
ALTER TABLE `User` ADD FOREIGN KEY (`accessCode`) REFERENCES `AccessLevel`(`accessCode`);
ALTER TABLE `ReportCard` ADD FOREIGN KEY (`studentID`) REFERENCES `Student`(`studentID`);

INSERT INTO `stars`.`AccessLevel` (`accessCode`, `level`) VALUES
(1, 'System Administrator'),
(2, 'Administrator'),
(3, 'Educator'),
(4, 'Support Educator'),
(5, 'Student'),
(6, 'Parent or Guardian');


INSERT INTO `stars`.`Semester` (`schoolYear`, `semesterNum`, `startDate`, `endDate`) VALUES
('2018/2019', '-1', '2018-09-05', '2019-01-25'),
('2018/2019', '-2', '2019-01-26', '2019-06-15');


INSERT INTO `stars`.`Subject` (`subjectCode`, `subjectName`) VALUES
('MATH', 'Math'),
('ARTS', 'Arts and Culture');


INSERT INTO `stars`.`Course` (`courseID`, `courseName`, `subjectCode`) VALUES
(010, 'Grade 10 Academic Math', 'MATH'),
(011, 'Grade 11 General Math', 'MATH'),
(012, 'Grade 12 Music', 'ARTS');

# UserID???
INSERT INTO `user` (`userID`, `username`, `password`, `accessCode`) VALUES ('0', 'sahracourtney@gmail.com', '123', '5'),
                                                                           ('0', 'parentJane@abc.com', '123', '6'),
                                                                           ('0', 'parentJane@abc.com', '123', '6'),
                                                                           ('0', 'parentJason@abc.com', '123', '6');

INSERT INTO `parentorguardian` (`guardianID`, `firstName`, `lastName`, `address`, `city`, `province`, `postalCode`,
                                `phoneNum`, `emailAddress`, `userID`)
                                VALUES ('1002', 'mary', 'Smith', '69 Main St', 'Summerside', 'PE', 'c0b1m0',
                                        '9028881002', 'parentJason@abc.com', '6972'),
                                ('1001', 'John', 'Doe', '5 Water St ', 'Summerside', 'PE', 'C0B1L0',
                                        '9028888181', 'parentJane@abc.ca', '6970');
insert into `stars`.`Student` (`studentID`, `firstName`, `middleName`, `lastName`, `gender`, `dob`, `grade`, `address`,
                           `phoneNum`, `emailAddress`, `allergies`, `schoolID`, `guardianID`, `userID`)
                            VALUES ( 100, 'Jane', 'Sue', 'Doe', 'Female', '2006-05-14', '9', '55 Water St, Summerside, PE, C0B1L0',
                                    '9028888181', 'parentJane@abc.ca', 'None', '69', '1001', '6970');