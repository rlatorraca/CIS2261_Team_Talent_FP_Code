<?php
/**
 * Created by PhpStorm.
 * STARS Beta Version 1.0
 * Company: Team Talent 2.0
 * Authors: John, Rodrigo, Sara, Steve
 * Date: 2/14/2019
 *
 * Page to allow Educators and Administrators to update student grades,
 * attendance and add any relevant notes to give feedback on the students performance.
 *
 * Page is locked down for only Admin and Educator level users to access and make changes against the database.
 * Administrators are able to see a list of courses with the assigned educator's name showing up alongside,
 * where educators only may see the courses they teach
 *
 * Required pages: login.php, checkLoggedIn.php, assignCourse.php, addUser.php, addStudent.php, confirmStudent.php, insertStudent.php, dbConn.php
 *
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Button class includes
include("../button.class.php");
$confirm = new Button();

//Locks down page for non-admin or main educational staff.
//Parent/Guardians, Support Educators and Students are not able to view this page.
if ($_SESSION["accessCode"] == 4 || $_SESSION["accessCode"] == 5 || $_SESSION["accessCode"] == 6) {

    //Redirect unauthorized user back to Home page
    header("Location: ../../index.php");

}

//Database connection
include '../db/dbConn.php';
?>
    <!--Form to update a students mark-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="ajax.js"></script>
<?php

//Message declaration
$msg = "";

if (isset($_POST['enter'])) {
    $markInput = $_POST['markInput'];
    $attendance = $_POST['attendance'];
    $teacherNotes = $_POST['teacherNotes'];
    $classID = $_POST['courseSemester'];
    $studentID = $_POST['studentMark'];

    $queryCourse1 = "UPDATE enrollment SET mark= $markInput, attendance = $attendance, notes= '$teacherNotes' 
                     WHERE enrollment.studentID = $studentID AND enrollment.classID = $classID;";

    //Execute query and store result.
    $result = $database->query($queryCourse1);

    //Check if query executed successfully and that the result contains data.
    if ($result == 1) {

        $msg = "<br><div class='alert alert-info'>Student Record has been successfully updated. Page will refresh automatically for you.</div>";

        //Refresh page automatically (5 seconds).
        header("Refresh:5");

    } else {

        $msg = "<br><div class='alert alert-danger'>Sorry, student record could not be updated to the database at this time. Page will refresh automatically for you.</div>";

        //Refresh page automatically (5 seconds).
        header("Refresh:5");

    }

} else {

    //Get logged in user's userID
    $userID = $_SESSION['userID'];

    //query to find the courses (and semester number)
    $queryCourse = "";

    //If statement structure to choose SELECT query to use based on logged in user's access level
    if ($_SESSION["accessCode"] == 1) {

        $queryCourse = "SELECT DISTINCT courseoffering.classID, course.courseName, courseoffering.schoolYear,
                    courseoffering.semesterNum, educator.educatorFName, educator.educatorLName
                    FROM course, educator, courseoffering, school
                    WHERE courseoffering.educatorID = educator.educatorID
                    AND course.courseID = courseoffering.courseID
                    ORDER BY courseoffering.schoolYear DESC;";

        //query to find the students in the selected course
        $resultCourse = $database->query($queryCourse);

    } else if ($_SESSION["accessCode"] == 2) {

        //Get logged in user's schoolID
        $querySchool = "SELECT schoolID FROM administrator WHERE userID = $userID";
        $schoolID = 0;

        $resultSchoolID = $database->query($querySchool);

        if ($resultSchoolID) {

            while ($row = $resultSchoolID->fetch_assoc()) {

                $schoolID = $row["schoolID"];
            }
        }

        $queryCourse = "SELECT DISTINCT courseoffering.classID, course.courseName, courseoffering.schoolYear,
                    courseoffering.semesterNum, educator.educatorFName, educator.educatorLName
                    FROM course, educator, courseoffering, school
                    WHERE school.schoolID = $schoolID
                    AND educator.schoolID = school.schoolID
                    AND courseoffering.educatorID = educator.educatorID
                    AND course.courseID = courseoffering.courseID
                    ORDER BY courseoffering.schoolYear DESC;";

        //query to find the students in the selected course
        $resultCourse = $database->query($queryCourse);

    } else if ($_SESSION["accessCode"] == 3) {

        $queryCourse = "SELECT courseoffering.classID, course.courseName, courseoffering.schoolYear,
                    courseoffering.semesterNum, educator.educatorFName, educator.educatorLName
                    FROM course, user, educator, courseoffering 
                    WHERE educator.userID = $userID
                    AND courseoffering.educatorID = educator.educatorID 
                    AND user.userID = educator.userID 
                    AND course.courseID = courseoffering.courseID
                    ORDER BY courseoffering.schoolYear DESC;";

        //query to find the students in the selected course
        $resultCourse = $database->query($queryCourse);
    }
}
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Fonts !-->
        <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Roboto" rel="stylesheet">

        <!-- Here is where we call bootstrap. !-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <!-- JS/JQuery links-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="../../js/main.js"></script>
        <!--Custom CSS link-->
        <link href="../../css/stars.css" rel="stylesheet">
        <script src="../../js/main.js"></script>
        <!--function to go back to your incomplete album form without losing previously filled fields-->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <title>STARS - Assign Mark</title>
    </head>

    <body>
    <?php include "../../header.php"; ?>
    <div class="jumbotron-fluid">
        <div class="container-fluid">
            <!--Main container and contents-->
            <div class="container main-container" id="studentSearch">
                <form action="enterMark.php" method="post">
                    <div><?php if (isset($msg)) {
                            echo $msg;
                        } ?></div>
                    <h2>Assign Mark</h2>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="students">Select Course - Semester</label>
                                <select class="form-control" id="courseSemester" name="courseSemester">
                                    <option value=''>Select</option>
                                    <!-- Using SQL to populate dropdown list of students -->
                                    <?php if ($resultCourse->num_rows > 0) {
                                        while ($row = $resultCourse->fetch_assoc()) {
                                            ?>
                                            <option
                                            value= <?php echo $row["classID"]; ?> ><?php echo $row["courseName"] . ": " . $row["schoolYear"] . " - "
                                                . $row["semesterNum"] . ": " . $row["educatorFName"] . " " . $row["educatorLName"]; ?></option><?php
                                        }
                                    } else {
                                        echo "<option>No Students</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="studentMark">Student</label>
                                <!--            $queryCourse =-->

                                <select name="studentMark" id="studentMark" class="form-control">
                                    <option>Select</option>
                                </select><br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="markInput">Mark</label>
                                <select class="form-control" id="markInput" name="markInput">
                                    <?php
                                    for ($i = 0; $i <= 100; $i++) {
                                        ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="attendance">Days missed</label>
                                <select class="form-control" id="attendance" name="attendance">
                                    <?php
                                    for ($i = 0; $i <= 60; $i++) {
                                        ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select><br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <label for="teacherNotes">Teacher´s notes</label><br/>
                                <textarea class="form-control" id="teacherNotes" name="teacherNotes"
                                          placeholder="Enter notes" cols="75"
                                          rows="3"></textarea>
                                <span class="charactersTeacherNotes">500</span> characters remaining
                            </div>
                        </div>
                        <br>
                        <!--Search button-->
                        <div class="row">
                            <div class="col-md-10">
                                <?php
                                $confirm = new Button();

                                $confirm->buttonName = "reset";
                                $confirm->buttonID = "reset";
                                $confirm->buttonValue = "Reset";
                                $confirm->buttonStyle = "font-family:sans-serif";
                                $confirm->display(); ?>
                            </div>
                            <div class="col-md-2">
                                <?php
                                $confirm = new Button();

                                $confirm->buttonName = "enter";
                                $confirm->buttonID = "enter";
                                $confirm->buttonValue = "Enter";
                                $confirm->buttonStyle = "font-family:sans-serif";
                                $confirm->display(); ?>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!--The bottom navbar/footer section-->
    <div class="bottom">
        <div id="footer">
            <?php include("../../navMenu.php"); ?>
        </div>
    </div>
    </body>
    </html>
<?php

//Close database connection
$database->close();
?>