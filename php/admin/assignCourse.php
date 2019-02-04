<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 2019-01-27
 * Time: 9:05 PM
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
    <title>Assign Student to a Course/Enrollment</title>
</head>
<body>
<div>
    <?php
    //To trigger when user submits request to add new Student to stars database
    if (isset($_POST["register"])) {

        //If details are empty, display a message and give redirect links. Otherwise, proceed.
        if ($_POST["subject"] == "" || $_POST["schoolYear"] == "" || $_POST["semesterNum"] == "" || $_POST["course"] == "" || $_POST["student"] == "") {
            echo "<h2>Error. Form fields must not be empty before registering new student in a course.</h2><br>";
            echo "<form action='addStudent.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
            echo "<form action='../../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
            exit("</div></body</html>");
        }

        //*******will need to pull the classID and StudentID somewhere
        //Sanitize user inputs to prepare for database insert query.
        $subject = $database->real_escape_string($_POST["subject"]);
        $schoolYear = $database->real_escape_string($_POST["schoolYear"]);
        $semesterNum = $database->real_escape_string($_POST["semesterNum"]);
        $classID = $database->real_escape_string($_POST["classID"]);
        $studentID = $database->real_escape_string($_POST["studentID"]);

        //Create initial SQL query to insert form data into database
        $query = "INSERT INTO enrollment(schoolYear, semesterNum, classID, studentID) 
                  VALUES ('$schoolYear', '$semesterNum', '$classID', '$studentID');";

        //Execute query and store result.
        $result = $database->query($query);

        //Check if query executed successfully and that the result contains data.
        if ($result) {

            echo "<h2>Student has been successfully register in the course.</h2><br>";
            echo "<form action='assignCourse.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Assign another student</button></div></fieldset></form>";
            echo "<form action='../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";

        } else {

            echo "<h2>Sorry, student could not be registered in this course at this time.</h2><br>";
            echo "<form action='assignCourse.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
            echo "<form action='../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
        }

        //Close database connection
        $database->close();

    } else {
    //********************this section needs to be drop downs
    ?>
    <p>**Please ensure all fields are filled before registering a new Student.</p>
    <form action="assignCourse.php" method="post">
        <fieldset>
            <legend>Student Details</legend>
            <div class="col-md-12 form-inline customDiv">
                <label for="subject" class="col-md-6">Subject</label>
                <select name="subject">
                    <?php

                    ?>
                    <option></option>
                </select>
                <input type="text" name="subject" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="schoolYear" class="col-md-6">School Year</label>
                <input type="text" name="schoolYear" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="semesterNum" class="col-md-6">Semester</label>
                <input type="text" name="semesterNum" class="col-md-6 form-control">
            </div>
            <!--********************this section needs to use classID as hidden feild?-->
            <div class="col-md-12 form-inline customDiv">
                <label for="course" class="col-md-6">Course</label>
                <input type="text" name="course" class="col-md-6 form-control">
            </div>
            <!--********************this section needs to display first & last name but student ID needed for SQL update?-->
            <div class="col-md-12 form-inline customDiv">
                <label for="student" class="col-md-6">Student</label>
                <input type="text" name="student" class="col-md-6 form-control">
            </div>
            <div class="col-md-12">
                <input type="submit" name="register" value="Register Student in Course">
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>
<?php
}
?>
