<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 9:05 PM
 */

//Lock down page
include "../login/checkLoggedIn.php";

include("../button.class.php");
$confirm = new Button();

//Locks down page for non-admin or educational staff.
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

        $msg = "<h2>Student Record has been successfully updated.</h2><br>";


    } else {

        $msg = "<h2>Sorry, student record could not be updated to the database at this time</h2><br>";

    }

    //Close database connection
    //$database->close();

} else {

    //Get logged in user's userID
    $userID = $_SESSION['userID'];

    //query to find the courses (and semester Number)
    //If statement to detect whether the logged in user is an Administrator or an Educator type user.
    $queryCourse = "";

    //If statement structure to choose SELECT query to use based on logged in user's access level
    if ($_SESSION["accessCode"] == 2) {

        //Get logged in user's schoolID
        $querySchool = "SELECT schoolID FROM administrator WHERE userID = $userID";
        $schoolID = 0;

        $resultSchoolID = $database->query($querySchool);

        if ($resultSchoolID) {

            while ($row = $resultSchoolID->fetch_assoc()) {

                $schoolID = $row["schoolID"];

            }

        }

        $queryCourse = "SELECT DISTINCT courseoffering.classID, course.courseName, courseoffering.semesterNum
                    FROM course, educator, courseoffering, school
                    WHERE school.schoolID = $schoolID
                    AND educator.schoolID = school.schoolID
                    AND courseoffering.educatorID = educator.educatorID
                    AND course.courseID = courseoffering.courseID;";

    } else if ($_SESSION["accessCode"] == 3) {

        $queryCourse = "SELECT courseoffering.classID, course.courseName, courseoffering.semesterNum 
                    FROM course, user, educator, courseoffering 
                    WHERE educator.userID = $userID
                    AND courseoffering.educatorID = educator.educatorID 
                    AND user.userID = educator.userID 
                    AND course.courseID = courseoffering.courseID;";

    }

    //query to find the students in the selected course
    $resultCourse = $database->query($queryCourse);
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

    <!-- Instructions to replicate can be found here:  https://getbootstrap.com/docs/4.1/getting-started/introduction/ !-->
    <!-- Here is where we call bootstrap. !-->
    <title>STARS - Assign Mark</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Calendar Date Picker !-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../../js/main.js"></script>

    <link href="../../css/stars.css" rel="stylesheet">


    <!--function to go back to your incomplete album form without losing previously filled fields-->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

</head>

<body>
<div class="header">
    <img src="../../img/StarsWhiteFIN.jpg">
</div>
<div class="jumbotron-fluid">
    <div class="container-fluid">

        <!--Main container and contents-->
        <div class="container main-container" id="studentSearch">
            <form action="enterMark.php" method="post">
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
                                        value= <?php echo $row["classID"] ?> ><?php echo $row["courseName"] . " - " . $row["semesterNum"]; ?></option><?php
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
                            </select>
                        </div>
                    </div>
                    <br>
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
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="teacherNotes">Teacher´s notes</label><br/>
                            <textarea class="form-control" id="teacherNotes" name="teacherNotes"
                                      placeholder="Enter notes" cols="75"
                                      rows="4"></textarea>
                            <span class="charactersTeacherNotes">500</span> characters remaining
                        </div>
                    </div>
                    <br>
                    <!--Search button-->
                    <div class="row">
                        <div class="col-md-3">
                            <?php
                            $confirm = new Button();

                            $confirm->buttonName = "reset";
                            $confirm->buttonID = "reset";
                            $confirm->buttonValue = "Reset";
                            $confirm->buttonStyle = "font-family:sans-serif";
                            $confirm->display(); ?>

                        </div>
                        <div class="col-md-3">
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
            <?php
            if (isset($msg)) {
                echo "<div>$msg</div>";
            }

            ?>
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



