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
    `studentID` INTEGER(10) NOT NULL AUTO_INCREMENT,
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
    `guardianID` INTEGER(10) NOT NULL AUTO_INCREMENT,
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
    `educatorID` INTEGER(10) NOT NULL AUTO_INCREMENT,
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
    `supportEducatorID` INTEGER(10) NOT NULL AUTO_INCREMENT,
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
    `adminID` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `firstName` VARCHAR(30) NOT NULL,
    `lastName` VARCHAR(60) NOT NULL,
    `position` VARCHAR(100) NOT NULL,
    `schoolID` INTEGER(10) NOT NULL,
    `userID` INTEGER(10) NOT NULL,
    PRIMARY KEY (`adminID`)
);

CREATE TABLE `IndividualEducationPlan` (
    `planID` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `reason` VARCHAR(100) NOT NULL,
    `dateIssued` CHAR(10) NOT NULL,
    `comments` VARCHAR(500) NOT NULL,
    `supportEducatorID` INTEGER(10) NOT NULL,
    `studentID` INTEGER(10) NOT NULL,
    PRIMARY KEY (`planID`)
);

CREATE TABLE `Course` (
    `courseID` INTEGER(10) NOT NULL AUTO_INCREMENT,
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
    `classID` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `courseID` INTEGER(10) NOT NULL,
    `educatorID` INTEGER(10) NOT NULL,
    `schoolYear` CHAR(9) NOT NULL,
    `semesterNum` CHAR(2) NOT NULL,
    PRIMARY KEY (`classID`)
);

CREATE TABLE `Enrollment` (
    `enrollmentID` INTEGER(10) NOT NULL AUTO_INCREMENT,
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
    `schoolID` INTEGER(10) NOT NULL AUTO_INCREMENT,
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
    `accessCode` INTEGER(10) NOT NULL AUTO_INCREMENT,
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
    `reportCardID` INTEGER(10) NOT NULL AUTO_INCREMENT,
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

/* STARS TEST DATA */

INSERT INTO `stars`.`AccessLevel` (`accessCode`, `level`) VALUES
(1, 'System Administrator'),
(2, 'Administrator'),
(3, 'Educator'),
(4, 'Support Educator'),
(5, 'Student'),
(6, 'Parent or Guardian');

INSERT INTO `stars`.`Semester` (`schoolYear`, `semesterNum`, `startDate`, `endDate`) VALUES
('2015/2016', '01', '2019-01-26', '2019-06-15'),
('2015/2016', '02', '2019-01-26', '2019-06-15'),
('2016/2017', '01', '2019-01-26', '2019-06-15'),
('2016/2017', '02', '2019-01-26', '2019-06-15'),
('2017/2018', '01', '2019-01-26', '2019-06-15'),
('2017/2018', '02', '2019-01-26', '2019-06-15'),
('2018/2019', '01', '2018-09-05', '2019-01-25'),
('2018/2019', '02', '2019-01-26', '2019-06-15');

INSERT INTO `stars`.`School` (`schoolID`, `name`, `district`, `address`, `city`, `province`, `postalCode`, `phoneNum`, `emailAddress`) VALUES
(1, 'Westisle Composite High School', 'Westisle', '39570 Western Rd, ', 'Elmsdale', 'PE', 'C0B1K0', '9028538626', 'westisle@edu.pe.ca'),
(2, 'Colonel Gray High School', 'Eastern School District', '175 Spring Park Rd, ', 'Charlottetown', 'PE', 'C1A3Y8', '9021112222', 'colonelgray@edu.pe.ca'),
(3, 'Souris Regional School', 'Souris', '15 Longworth St, ', 'Souris', 'PE', 'C0A2B0', '9022221111', 'sourisregional@edu.pe.ca');

INSERT INTO `stars`.`Subject` (`subjectCode`, `subjectName`) VALUES
('MATH', 'Math'),
('SCIE', 'Science'),
('HIST', 'History'),
('LANG', 'Languages'),
('ENGL', 'English'),
('PYSD', 'Physical Education'),
('ARTS', 'Arts and Culture');

INSERT INTO `stars`.`Course` (`courseID`, `courseName`, `subjectCode`) VALUES
(010, 'Academic Math 10', 'MATH'),
(011, 'General Math 10', 'MATH'),
(012, 'Academic Math 11', 'MATH'),
(013, 'General Math 11', 'MATH'),
(014, 'Academic Math 12', 'MATH'),
(015, 'General Math 12', 'MATH'),
(016, 'Physics 10', 'SCIE'),
(017, 'Physics 11', 'SCIE'),
(018, 'Physics 12', 'SCIE'),
(019, 'Biology 10', 'SCIE'),
(020, 'Biology 11', 'SCIE'),
(021, 'Chemistry 11', 'SCIE'),
(022, 'History 10', 'HIST'),
(023, 'History 11', 'HIST'),
(024, 'History 12', 'HIST'),
(025, 'French 10', 'LANG'),
(026, 'French 11', 'LANG'),
(027, 'French 12', 'LANG'),
(028, 'English 10', 'ENGL'),
(029, 'English 11', 'ENGL'),
(030, 'English 12', 'ENGL'),
(031, 'PhysEd 10', 'PYSD'),
(032, 'PhysEd 11', 'PYSD'),
(033, 'PhysEd 12', 'PYSD'),
(034, 'Photography 10', 'ARTS'),
(035, 'Graphic Design 11', 'ARTS'),
(036, 'Music 12', 'ARTS');

INSERT INTO `stars`.`User` (`userID`, `username`, `password`, `accessCode`) VALUES
(1, 'studentSara@gmail.com', '123', 5),
(2, 'studentJane@abc.com', '123', 5),
(3, 'parentMary@abc.com', '123', 6),
(4, 'parentJohn@abc.com', '123', 6);
(5, 'abminWestisle@abc.com', '123', 2),
(6, 'adminColonelGray@abc.com', '123', 2),
(7, 'adminSouris@abc.com', '123', 2),
(8, 'systemadmin@abc.com', '123', 1),
(9, 'studentJoe@abc.com', '123', 5),
(10, 'studentJohn@abc.com', '123', 5),
(11, 'studentSteve@abc.com', '123', 5),
(12, 'studentRodrigo@abc.com', '123', 5),
(13, 'educatorJoey@abc.com', '123', 3),
(14, 'educatorGerald@abc.com', '123', 3),
(15, 'educatorDon@abc.com', '123', 3),
(16, 'educatorBJ@abc.com', '123', 3),
(17, 'supportEducatorNancy@abc.com', '123', 4),
(18, 'supportEducatorJim@abc.com', '123', 4),
(19, 'supportEducatorSam@abc.com', '123', 4),
(20, 'parentJim@abc.com', '123', 6);

INSERT INTO `stars`.`ParentOrGuardian` (`guardianID`, `firstName`, `lastName`, `address`, `city`, `province`, `postalCode`,
                                `phoneNum`, `emailAddress`, `userID`) VALUES
(1, 'Mary', 'Smith', '69 Main St, ', 'Summerside', 'PE', 'C0A103', '9028881002', 'parentJason@abc.com', 3),
(2, 'John', 'Doe', '5 Water St, ', 'Summerside', 'PE', 'C0B1L0', '9028889181', 'parentJane@abc.ca', 4),
(3, 'Jim', 'Bob', '12 Parent St, ', 'Souris', 'PE', 'C0B1K0', '9028881234', 'parentJim@abc.com', 20);

INSERT INTO `stars`.`Student` (`studentID`, `firstName`, `middleName`, `lastName`, `gender`, `dob`, `grade`, `address`,
                           `phoneNum`, `emailAddress`, `allergies`, `schoolID`, `guardianID`, `userID`) VALUES
(100, 'Jane', 'Sue', 'Doe', 'Female', '2006-05-14', 10, '55 Water St, ', '9028888181', 'studentJane@abc.ca', 'Peanuts', 1, 3, 2),
(101, 'Sara', 'A', 'Courtney', 'Female', '1999-01-01', 12, '12 Learning Lane', '9028821234', 'studentSara@abc.com', 'None', 2, 4, 1),
(102, 'Joe', 'Bob', 'Jim', 'Female', '1999-01-01', 11, '12 Learning Lane', '9028821234', 'studentSara@abc.com', 'None', 2, 4, 9),
(103, 'Sara', 'A', 'Courtney', 'Female', '1999-01-01', 11, '12 Learning Lane', '9028821234', 'studentSara@abc.com', 'None', 2, 4, 1),
(104, 'Sara', 'A', 'Courtney', 'Female', '1999-01-01', 10, '12 Learning Lane', '9028821234', 'studentSara@abc.com', 'None', 2, 4, 1),
(105, 'Sara', 'A', 'Courtney', 'Female', '1999-01-01', 12, '12 Learning Lane', '9028821234', 'studentSara@abc.com', 'None', 2, 4, 1),