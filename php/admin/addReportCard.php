<?php
/**
 * Created by PhpStorm.
 * User: jgaudet109873
 * Date: 2/6/2019
 * Time: 4:11 PM
 */

//Lock down page
include "../login/authenticateAdminPages.php";

//Database connection
include "../db/dbConn.php";

//Take details used in assign student to a course to generate/search for report cards
$studentIDFromAssignToCourse = $_POST["studentID"];
$schoolYearFromAssignToCourse = $_POST["schoolYear"];
$semesterNumFromAssignToCourse = $_POST["semesterNum"];

$queryReportCard = "SELECT * FROM reportcard WHERE studentID = $schoolYearFromAssignToCourse 
                    AND schoolYear = '$schoolYearFromAssignToCourse' AND semesterNum = '$semesterNumFromAssignToCourse';";

$resultReportCard = $database->query($queryReportCard);

//If no report card is returned from the query, add one using the information.
//Otherwise, proceed is normally and bypass the insert query.
if ($resultReportCard->num_rows == 0) {

    $queryAddReportCard = "INSERT INTO reportcard (isRead, studentID, schoolYear, semesterNum) 
                            VALUES (0, $studentIDFromAssignToCourse, '$schoolYearFromAssignToCourse', '$semesterNumFromAssignToCourse')";

    $resultAddReportCard = $database->query($queryAddReportCard);

    if ($resultAddReportCard){

        header("Location: ../../index.php");

    } else {

        echo "<p>Issue adding a report card to STARS for Student $studentIDFromAssignToCourse</p>";

    }

}

//Close connection
$database->close();