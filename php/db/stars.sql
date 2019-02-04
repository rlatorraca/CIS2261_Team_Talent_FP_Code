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
                                    `parentFName` VARCHAR(30) NOT NULL,
                                    `parentLName` VARCHAR(60) NOT NULL,
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
                            `educatorFName` VARCHAR(30) NOT NULL,
                            `educatorLName` VARCHAR(60) NOT NULL,
                            `position` VARCHAR(100) NOT NULL,
                            `phoneNumber` CHAR(10) NOT NULL,
                            `emailAddress` VARCHAR(100) NOT NULL,
                            `userID` INTEGER(10) NOT NULL,
                            `schoolID` INTEGER(10) NOT NULL,
                            PRIMARY KEY (`educatorID`)
);

CREATE TABLE `SupportEducator` (
                                   `supportEducatorID` INTEGER(10) NOT NULL AUTO_INCREMENT,
                                   `supFName` VARCHAR(30) NOT NULL,
                                   `supLName` VARCHAR(60) NOT NULL,
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
                                 `adminFName` VARCHAR(30) NOT NULL,
                                 `adminLName` VARCHAR(60) NOT NULL,
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
                        `username` VARCHAR(100) NOT NULL UNIQUE,
                        `password` VARCHAR(100) NOT NULL,
                        `accessCode` INTEGER(10) NOT NULL,
                        PRIMARY KEY (`userID`)
);

CREATE TABLE `ReportCard` (
                              `reportCardID` INTEGER(10) NOT NULL AUTO_INCREMENT,
                              `isRead` BIT(1) NOT NULL,
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
(10, 'Academic Math 10', 'MATH'),
(11, 'General Math 10', 'MATH'),
(12, 'Academic Math 11', 'MATH'),
(13, 'General Math 11', 'MATH'),
(14, 'Academic Math 12', 'MATH'),
(15, 'General Math 12', 'MATH'),
(16, 'Physics 10', 'SCIE'),
(17, 'Physics 11', 'SCIE'),
(18, 'Physics 12', 'SCIE'),
(19, 'Biology 10', 'SCIE'),
(20, 'Biology 11', 'SCIE'),
(21, 'Chemistry 11', 'SCIE'),
(22, 'History 10', 'HIST'),
(23, 'History 11', 'HIST'),
(24, 'History 12', 'HIST'),
(25, 'French 10', 'LANG'),
(26, 'French 11', 'LANG'),
(27, 'French 12', 'LANG'),
(28, 'English 10', 'ENGL'),
(29, 'English 11', 'ENGL'),
(30, 'English 12', 'ENGL'),
(31, 'PhysEd 10', 'PYSD'),
(32, 'PhysEd 11', 'PYSD'),
(33, 'PhysEd 12', 'PYSD'),
(34, 'Photography 10', 'ARTS'),
(35, 'Graphic Design 11', 'ARTS'),
(36, 'Music 12', 'ARTS');

INSERT INTO `stars`.`User` (`userID`, `username`, `password`, `accessCode`) VALUES
(1, 'studentSara@gmail.com', '202cb962ac59075b964b07152d234b70', 5),
(2, 'studentJane@abc.com', '202cb962ac59075b964b07152d234b70', 5),
(3, 'parentMary@abc.com', '202cb962ac59075b964b07152d234b70', 6),
(4, 'parentJohn@abc.com', '202cb962ac59075b964b07152d234b70', 6),
(5, 'abminWestisle@abc.com', '202cb962ac59075b964b07152d234b70', 2),
(6, 'adminColonelGray@abc.com', '202cb962ac59075b964b07152d234b70', 2),
(7, 'adminSouris@abc.com', '202cb962ac59075b964b07152d234b70', 2),
(8, 'systemadmin@abc.com', '202cb962ac59075b964b07152d234b70', 1),
(9, 'studentJoe@abc.com', '202cb962ac59075b964b07152d234b70', 5),
(10, 'studentJohn@abc.com', '202cb962ac59075b964b07152d234b70', 5),
(11, 'studentSteve@abc.com', '202cb962ac59075b964b07152d234b70', 5),
(12, 'studentRodrigo@abc.com', '202cb962ac59075b964b07152d234b70', 5),
(13, 'educatorJoey@abc.com', '202cb962ac59075b964b07152d234b70', 3),
(14, 'educatorGerald@abc.com', '202cb962ac59075b964b07152d234b70', 3),
(15, 'educatorDon@abc.com', '202cb962ac59075b964b07152d234b70', 3),
(16, 'educatorBJ@abc.com', '202cb962ac59075b964b07152d234b70', 3),
(17, 'supportEducatorNancy@abc.com', '202cb962ac59075b964b07152d234b70', 4),
(18, 'supportEducatorJim@abc.com', '202cb962ac59075b964b07152d234b70', 4),
(19, 'supportEducatorSam@abc.com', '202cb962ac59075b964b07152d234b70', 4),
(20, 'parentJim@abc.com', '202cb962ac59075b964b07152d234b70', 6);

INSERT INTO `stars`.`Administrator` (`adminID`, `adminFName`, `adminLName`, `position`, `schoolID`, `userID`) VALUES
(1, 'John', 'Smith', 'Office Secretary', 1, 5),
(2, 'Jane', 'Smith', 'Principal', 2, 6),
(3, 'Jim', 'Gallant', 'Office Secretary', 3, 7);

INSERT INTO `stars`.`ParentOrGuardian` (`guardianID`, `parentFName`, `parentLName`, `address`, `city`, `province`, `postalCode`,
                                        `phoneNum`, `emailAddress`, `userID`) VALUES
(1, 'Mary', 'Smith', '69 Main St, ', 'Charlottetown', 'PE', 'C0A103', '9028881002', 'parentJason@abc.com', 3),
(2, 'John', 'Doe', '5 Water St, ', 'Summerside', 'PE', 'C0B1L0', '9028889181', 'parentJane@abc.ca', 4),
(3, 'Jim', 'Bob', '12 Parent St, ', 'Souris', 'PE', 'C0B1K0', '9028881234', 'parentJim@abc.com', 20);

INSERT INTO `stars`.`supportEducator` (`supportEducatorID`, `supFName`, `supLName`, `position`, `specialty`, `phoneNum`,
                                       `emailAddress`, `userID`, `schoolID`) VALUES
(1, 'Nancy', 'Gallant', 'TA', 'ADHD', '9021248899', 'supportEducatorNancy@abc.com', 17, 1),
(2, 'Jim', 'Joseph', 'TA', 'Autism', '9028829999', 'supportEducatorJim@abc.com', 18, 2),
(3, 'Sam', 'Doucette', 'Teaching Support', 'Dyslexia', '9028823456', 'supportEducatorSam@abc.com', 19, 3);

INSERT INTO `stars`.`Student` (`studentID`, `firstName`, `middleName`, `lastName`, `gender`, `dob`, `grade`, `address`,
                               `phoneNum`, `emailAddress`, `allergies`, `schoolID`, `guardianID`, `userID`, `supportEducatorID`) VALUES
(1, 'Jane', 'Sue', 'Doe', 'Female', '2001-05-14', 10, '55 Water St', '9028888181', 'studentJane@abc.ca', 'Peanuts, dust', 1, 3, 2, NULL),
(2, 'Sara', 'A', 'Courtney', 'Female', '1999-01-01', 12, '12 Learning Lane', '9028821234', 'studentSara@abc.com', 'None', 2, 2, 1, 1),
(3, 'Joe', 'Bob', 'Jim', 'Male', '1998-05-03', 11, '13 School St', '9028829999', 'studentJoe@abc.com', 'Everything', 3, 1, 9, 2),
(4, 'John', 'Robert', 'Gaudet', 'Male', '1999-04-08', 12, '3456 Learning Lane', '9028881234', 'studentJohn@abc.com', 'None', 1, 3, 10, 3),
(5, 'Steve', 'M', 'Martin', 'Male', '1999-10-10', 12, '1234 Learning Lane', '9028824321', 'studentSteve@abc.com', 'None', 3, NULL, 11, 1),
(6, 'Rodrigo', 'A', 'Pires', 'Male', '1999-01-31', 12, '32 Learning Lane', '9022146789', 'studentRodrigo@abc.com', 'None', 2, NULL, 12, NULL);

INSERT INTO `stars`.`Educator` (`educatorID`, `educatorFName`, `educatorLName`, `position`, `phoneNumber`, `emailAddress`, `userID`, `schoolID`) VALUES
(1, 'Gerald', 'Caissy', 'Teacher', '9028534567', 'educatorGerald@abc.com', 14, 1),
(2, 'Don', 'Bowers', 'Teacher', '9028881238', 'educatorDon@abc.com', 15, 2),
(3, 'BJ', 'MacLean', 'Teacher', '9022147777', 'educatorBJ@abc.com', 16, 3);

INSERT INTO `courseoffering` (`classID`, `courseID`, `educatorID`, `schoolYear`, `semesterNum`) VALUES
(1, 10, 1, '2016/2017', '01'),
(2, 10, 1, '2016/2017', '02'),
(3, 12, 2, '2017/2018', '01'),
(4, 12, 2, '2017/2018', '02'),
(5, 14, 3, '2018/2019', '01'),
(6, 14, 3, '2018/2019', '02'),
(7, 16, 1, '2016/2017', '01'),
(8, 18, 1, '2017/2018', '01'),
(9, 18, 1, '2017/2018', '02'),
(10, 21, 1, '2018/2019', '01'),
(11, 23, 2, '2018/2019', '01'),
(12, 25, 2, '2017/2018', '02'),
(13, 29, 2, '2016/2017', '01'),
(14, 33, 3, '2018/2019', '02'),
(15, 36, 3, '2018/2019', '01');

INSERT INTO `stars`.`enrollment` (`enrollmentID`, `mark`, `attendance`, `notes`, `classID`, `schoolYear`, `semesterNum`, `studentID`) VALUES
(1, 98, 5, 'Good effort!', 1, '2016/2017', '01', 1),
(2, 99, 8, 'Great work!', 2, '2016/2017', '02', 1),
(3, 87, 9, 'Overall good student', 3, '2017/2018', '01', 1),
(4, 77, 3, 'Good effort all around!', 4, '2017/2018', '02', 1),
(5, 99, 5, 'Good work', 5, '2018/2019', '01', 1),
(6, 77, 0, 'Great job. Have a good summer!', 6, '2018/2019', '02', 1),
(7, 67, 6, 'Good effort.', 7, '2016/2017', '01', 2),
(8, 75, 2, 'Good work', 8, '2017/2018', '01', 2),
(9, 100, 0, 'Excellent', 9, '2017/2018', '02', 2),
(10, 77, 5, 'Good effort', 2, '2016/2017', '02', 2),
(11, 69, 4, 'Great effort all around', 4, '2017/2018', '02', 2),
(12, 71, 10, 'A good effort was made', 7, '2016/2017', '01', 3),
(13, 88, 7, 'Good work', 8, '2017/2018', '01', 3),
(14, 92, 5, 'Excellent', 11, '2018/2019', '01', 3),
(15, 88, 9, 'Good work', 14, '2018/2019', '02', 3),
(16, 90, 16, 'Excellent work!', 15, '2018/2019', '01', 3),
(17, 55, 17, 'Could have been more effort from you this semester', 1, '2016/2017', '01', 4),
(18, 80, 0, 'Good work!', 4, '2017/2018', '02', 4),
(19, 99, 6, 'Great work!', 9, '2017/2018', '02', 4),
(20, 96, 5, 'Great job this semester!', 11, '2018/2019', '01', 4),
(21, 93, 1, 'Excellent', 15, '2018/2019', '01', 5),
(22, 66, 0, 'Good work', 5, '2018/2019', '01', 5),
(23, 89, 4, 'Good job', 7, '2016/2017', '01', 5),
(24, 96, 6, 'Great!', 14, '2018/2019', '02', 5),
(25, 99, 5, 'Excellent!!', 1, '2016/2017', '01', 5),
(26, 73, 2, 'Good work this semester', 3, '2017/2018', '01', 5),
(27, 100, 6, 'Excellent work!!', 14, '2018/2019', '02', 6),
(28, 97, 12, 'Great work', 12, '2017/2018', '02', 6),
(29, 87, 13, 'Great job', 8, '2017/2018', '01', 6),
(30, 100, 0, 'Excellent!!!!', 10, '2018/2019', '01', 6);

INSERT INTO `IndividualEducationPlan` (`planID`, `reason`, `dateIssued`, `comments`, `supportEducatorID`, `studentID`)
VALUES (1, 'Student requires extra support in Math & Sciences to remain at grade level.', '2017-10-05', 'Student has health issues that result in many missed classes', 1, 2),
       (2, 'Student is dyslexic', '2018-06-05', 'Student requires support in literacy.  Student is permitted to take tests orally when possible and/or with extra time', 2, 3),
       (3, 'Student has Downs Syndrome.', '2019-11-01', 'Student expectations are adjusted to match ability, please see details below:', 3, 4);

INSERT INTO `stars`.`reportcard` (`reportCardID`, `isRead`, `studentID`, `schoolYear`, `semesterNum`) VALUES
(1, 0, 1, '2016/2017', '01'),
(2, 0, 1, '2016/2017', '02'),
(3, 1, 1, '2017/2018', '01'),
(4, 1, 1, '2017/2018', '02'),
(5, 0, 1, '2018/2019', '01'),
(6, 1, 1, '2018/2019', '02'),
(7, 0, 2, '2016/2017', '01'),
(8, 0, 2, '2016/2017', '02'),
(9, 1, 2, '2017/2018', '01'),
(10, 1, 2, '2017/2018', '02'),
(11, 0, 2, '2018/2019', '01'),
(12, 1, 2, '2018/2019', '02'),
(13, 0, 3, '2016/2017', '01'),
(14, 0, 3, '2016/2017', '02'),
(15, 1, 3, '2017/2018', '01'),
(16, 1, 3, '2017/2018', '02'),
(17, 0, 3, '2018/2019', '01'),
(18, 1, 3, '2018/2019', '02'),
(19, 0, 4, '2016/2017', '01'),
(20, 0, 4, '2016/2017', '02'),
(21, 1, 4, '2017/2018', '01'),
(22, 1, 4, '2017/2018', '02'),
(23, 0, 4, '2018/2019', '01'),
(24, 1, 4, '2018/2019', '02'),
(25, 0, 5, '2016/2017', '01'),
(26, 0, 5, '2016/2017', '02'),
(27, 1, 5, '2017/2018', '01'),
(28, 1, 5, '2017/2018', '02'),
(29, 0, 5, '2018/2019', '01'),
(30, 1, 5, '2018/2019', '02'),
(31, 0, 6, '2016/2017', '01'),
(32, 1, 6, '2016/2017', '02'),
(33, 1, 6, '2017/2018', '01'),
(34, 1, 6, '2017/2018', '02'),
(35, 0, 6, '2018/2019', '01'),
(36, 1, 6, '2018/2019', '02');