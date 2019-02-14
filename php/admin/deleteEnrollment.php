<?php
/**
 * Created by PhpStorm.
 * Company: Team Talent 2.0
 * Members: John, Rodrigo, Sara, Steve
 * Date: 2/14/2019
 *
 * Page to remove a student from a course. This page handles the database connection and query to delete the enrollment
 * To be done in case a student is added to the wrong course or the student dropped out before completing, or any other reason.
 *
 * Required pages: login.php, checkLoggedIn.php, autheticateAdminPages.php, dbConn.php, searchCourses.php, searchCourseResults.php
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Ensure only admin level staff can view and use this page
include "../login/authenticateAdminPages.php";

//Database connection
include "../db/dbConn.php";

//Importing button
include("../button.class.php");
$confirm = new Button();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Fonts !-->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Roboto" rel="stylesheet">

    <!--Link to custom style sheet-->
    <link href="../../css/stars.css" rel="stylesheet">

    <!-- JQuery Links !-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Here is where we call bootstrap. !-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <script src="../../js/main.js"></script>

    <!--function to go back to your incomplete form without losing previously filled fields-->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <title>STARS - Enrollment Removed</title>
</head>

<body>
<?php include "../../header.php"; ?>
<div class="jumbotron-fluid">
    <div class="container-fluid">
        <?php

        $studentID = htmlspecialchars($_GET["studentID"]);
        $classID = htmlspecialchars($_GET["classID"]);

        if ($_GET["studentID"] = "" || $_GET["classID"] == "") {
            header('Location: ../../php/admin/searchCourses.php');
        }

        $deleteStudentEnrollment = "DELETE FROM enrollment WHERE enrollment.studentID = $studentID AND enrollment.classID = $classID;";

        $deleteQueryForStudentEnrollment = $database->query($deleteStudentEnrollment);

        if ($deleteQueryForStudentEnrollment) {

            $msg = "Student enrollment record has been successfully removed from the database.";

        } else {

            $msg = "Student could not be un-enrolled from this course.";
        }

        $return = new Button();

        $return->buttonName = "return";
        $return->buttonID = "return";
        $return->buttonValue = "Return";
        $return->buttonStyle = "font-family:sans-serif";
        $return->buttonWeb = 'goBack()';
        $return->display();

        ?>
    </div>
</div>
<!--Bottom navbar-->
<div class="container">
    <div class="alert alert-danger">
        <?php if (isset($msg)) { echo $msg; } ?>
    </div>
</div>
<div class="bottom">
    <div id="footer">
        <?php include("../../navMenu.php"); ?>
    </div>
</div>
</body>
</html>
