<?php
/**
 * Created by PhpStorm.
 * User: jgaudet109873
 * Date: 2/4/2019
 * Time: 11:21 AM
 *
 * Page to remove a student from a course.
 * To be done in case a student is added to the wrong course or the student dropped out before completing
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
include "../db/dbConn.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remove Enrollment</title>
</head>
<body>
<?php

$studentID = $_GET["studentID"];
$classID = $_GET["classID"];
$courseID = $_GET["courseID"];
$schoolYear = $_GET["schoolYear"];
$semesterNum = $_GET["semesterNum"];

$deleteStudentEnrollment = "DELETE enrollmentID, mark, attendance, notes, enrollment.classID, enrollment.schoolYear, 
                            enrollment.semesterNum, enrollment.studentID
                            FROM enrollment, student, courseoffering, course, semester 
                            WHERE student.studentID = $studentID AND enrollment.studentID = student.studentID
                            AND courseoffering.classID = $classID AND enrollment.classID = courseoffering.classID
                            AND course.courseID = $courseID AND courseoffering.courseID = course.courseID
                            AND semester.schoolYear = $schoolYear AND enrollment.schoolYear = semester.schoolYear
                            AND semester.semesterNum = $semesterNum AND enrollment.semesterNum = semester.semesterNum";

?>
</body>
</html>
