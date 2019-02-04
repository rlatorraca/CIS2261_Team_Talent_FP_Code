<?php
/**
 * Created by PhpStorm.
 * Created and edited by: Team Talent 2.0
 * Date: 2019-01-27
 * Time: 9:00 PM
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Db connection
include "../db/dbConn.php";

//Selected info from request page
$subject = $_POST["subjects"];
$yearStart = $_POST["yearStart"];
$yearEnd = $_POST["yearEnd"];

//Get distinct years from the selections
$getSchoolYearsQuery = "SELECT DISTINCT semester.schoolYear FROM semester WHERE semester.schoolYear BETWEEN '$yearStart' AND '$yearEnd'";

//Run initial query and get all school years from the database between the selected dates.
$resultSetInitialQuery = $database->query($getSchoolYearsQuery);

//Major if statement.
//Gets each year selected and runs a query to perform against the database, subbing the year chosen in to be able to return distinct averages for each school year that the user desires.
if ($resultSetInitialQuery) {

    while($years = $resultSetInitialQuery->fetch_assoc()) {

        $schoolYear = $years["schoolYear"];
        echo $schoolYear;

        $querySubjectAverage = "SELECT school.name, subject.subjectName, AVG (enrollment.mark) AS average 
						FROM school, subject, enrollment, courseoffering, course, semester, student
						WHERE school.schoolID = 1
						AND student.schoolID = school.schoolID
						AND subject.subjectCode = '$subject'
                        AND course.subjectCode = subject.subjectCode
						AND semester.schoolYear = '$schoolYear'
					  	AND enrollment.schoolYear = semester.schoolYear
						AND courseoffering.schoolYear = semester.schoolYear
						AND enrollment.classID = courseoffering.classID
						AND courseoffering.courseID = course.courseID;";

        $resultSetSubjectAverageQuery = $database->query($querySubjectAverage);

        if ($resultSetSubjectAverageQuery) {

            while ($row = $resultSetSubjectAverageQuery->fetch_assoc()) {

                //If the results of the average calculation is empty, show the provided message to the user.
                //This would happen if there is no data to pull from between the selected dates or selected subject.
                if ($row["average"] == ""){

                    //Output message. To graph, use 0.00 to indicate that no average was calculated. (Or 100.00 but I don't think so??????)
                    echo "<p>Sorry, there is no school enrollment data in STARS to calculate chosen subject's average at this time.</p>";
                    ?><p><?php echo $row["name"] . ": " . $row["subjectName"] . " = " . 0.00; ?></p><?php

                } else {

                    //Returned information to graph on the page.
                    ?><p><?php echo $row["name"] . ": " . $row["subjectName"] . " = " . $row["average"]; ?></p><?php

                }

            }

        } else {

            echo "<p>Could not display select subject average at this time.</p>";

        }

    }

}
