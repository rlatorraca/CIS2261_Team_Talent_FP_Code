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

//Ensure only admin level staff can view and use this page
include "../login/authenticateAdminPages.php";

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
if ($_GET["studentID"] = "" || $_GET["classID"] == ""){
    header('Location: ../../php/admin/searchCourses.php');
}
$studentID = $_GET["studentID"];
$classID = $_GET["classID"];

$deleteStudentEnrollment = "DELETE FROM enrollment 
                            WHERE enrollment.studentID = $studentID 
                            AND enrollment.classID = $classID;";

$deleteQueryForStudentEnrollment = $database->query($deleteStudentEnrollment);

if ($deleteQueryForStudentEnrollment == 1) {

    echo "Student enrollment record has been successfully removed from the database.";

}

?>
</body>
</html>
