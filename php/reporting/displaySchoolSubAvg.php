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

$querySubjectAverage = "";

//Check if the user selected the same year range.
if ($yearStart == $yearEnd){

    $querySubjectAverage = "SELECT school.name, subject.subjectName, AVG (enrollment.mark) AS average 
						FROM school, subject, enrollment, courseoffering, course, semester, student
						WHERE school.schoolID = 1
						AND student.schoolID = school.schoolID
						AND subject.subjectCode = '$subject'
                        AND course.subjectCode = subject.subjectCode
						AND semester.schoolYear = '$yearStart'
					  	AND enrollment.schoolYear = semester.schoolYear
						AND courseoffering.schoolYear = semester.schoolYear
						AND enrollment.classID = courseoffering.classID
						AND courseoffering.courseID = course.courseID;";

} else {

    $querySubjectAverage = "SELECT school.name, subject.subjectName, AVG (enrollment.mark) AS average 
						FROM school, subject, enrollment, courseoffering, course, semester, student
						WHERE school.schoolID = 1
						AND student.schoolID = school.schoolID
						AND subject.subjectCode = '$subject'
                        AND course.subjectCode = subject.subjectCode
						AND semester.schoolYear BETWEEN '$yearStart' AND '$yearEnd'
					  	AND enrollment.schoolYear = semester.schoolYear
						AND courseoffering.schoolYear = semester.schoolYear
						AND enrollment.classID = courseoffering.classID
						AND courseoffering.courseID = course.courseID;";

}

$resultSet = $database->query($querySubjectAverage);

if ($resultSet) {

	while ($row = $resultSet->fetch_assoc()) {

	    //If the results of the average calculation is empty, show the provided message to the user.
        //This would happen if there is no data to pull from between the selected dates or selected subject.
	    if ($row["average"] == ""){

	        echo "<p>Sorry, there is no school enrollment data in STARS to calculate chosen subject's average at this time.</p>";

        } else {

            ?><p><?php echo $row["name"] . ": " . $row["subjectName"] . " = " . $row["average"]; ?></p><?php

        }
	}

} else {

    echo "<p>Could not display select subject average at this time.</p>";

}
