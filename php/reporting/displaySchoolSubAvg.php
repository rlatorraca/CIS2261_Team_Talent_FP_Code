<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 9:00 PM
 */

include "../db/dbConn.php";

//Selected info from request page
$subject = $_POST["subjects"];
$yearStart = $_POST["yearStart"];
$yearEnd = $_POST["yearEnd"];

//Important query
$querySubjectAverage = "SELECT school.schoolID, subject.subjectCode, AVG (enrollment.mark) AS average 
						FROM school, subject, enrollment, courseoffering, course, semester 
						WHERE school.schoolID = 3
						AND subject.subjectCode = '$subject'
						AND semester.schoolYear BETWEEN '$yearStart' AND '$yearEnd'
					  	AND enrollment.schoolYear = semester.schoolYear
						AND courseoffering.schoolYear = semester.schoolYear
						AND enrollment.classID = courseoffering.classID
						AND courseoffering.courseID = course.courseID;";

$resultSet = $database->query($querySubjectAverage);

if ($resultSet == 1) {

	while ($row = $resultSet->fetch_assoc()) {

		?><p><?php echo $row["schoolID"] . ": " . $row["subjectCode"] . " = " . $row["average"]; ?></p><?php

	}

}
