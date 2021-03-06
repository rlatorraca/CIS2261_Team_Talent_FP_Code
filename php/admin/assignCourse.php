<?php
/**
 * Created by PhpStorm.
 * STARS Beta Version 1.0
 * Company: Team Talent 2.0
 * Members: John, Rodrigo, Sara, Steve
 * Date: 2/14/2019
 *
 * Page which allows admin staff and educators to assign students to courses (as enrollments in the database).
 * Users must select fields in the dropdowns to narrow down the desired course in the desired school year/semester.
 *
 * Required pages: stars.css, login.php, checkLoggedIn.php, dbConn.php, addUser.php, addStudent.php, confirmStudent.php, insertStudent.php.
 *
 */
?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="../reporting/ajax.js"></script>
<script type="text/javascript" language="javascript">
    function ClearForm() {
        document.reset();
    }
</script>
<?php

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
include "../db/dbConn.php";

// Button class
include("../button.class.php");

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

    <!-- JQuery Links !-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Here is where we call bootstrap. !-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <script src="../../js/main.js"></script>

    <!--Link to custom style sheet-->
    <link href="../../css/stars.css" rel="stylesheet">

    <!--   function to go back to your incomplete form without losing previously filled fields-->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <title>STARS - Assign Student to a Course/Enrollment</title>
</head>
<body>
<?php include "../../header.php"; ?>

<div class="jumbotron-fluid">
    <div class="container-fluid container-sizer">
        <?php
        $msg = "";
        //To trigger when user submits request to add new Student to stars database
        if (isset($_POST["register"])) {

            //If details are empty, display a message and give redirect links. Otherwise, proceed.
            if ($_POST["subjectsAssignCourse"] == "" || $_POST["yearAsscourseSemesterYearAssignCourseignCourse"] == "" || $_POST["semesterYearAssignCourse"] == "" || $_POST["courseSemesterYearAssignCourse"] == "" || $_POST["studentAssignCourse"] == "") {
                echo "<h2>Error</h2>
                                <p>Form fields must not be empty before registering new student in a course.</p>
                                <br>
                                <form action='assignCourse.php' method='post'>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <button class='button button2'>Try Again</button>
                                    </div>
                                </form>
                                <form action='../../index.php' method='post'>
                                    <div class='col-md-6'>
                                        <button class='button button2'>Return Home</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class='bottom'>
                            <div id='footer'>";
                include('../../navMenu.php');
                exit("</div>
                            </div>
                        </body>
                    </html>");
            }

            $queryClassID = "SELECT classID FROM courseoffering WHERE courseID=" . mysqli_real_escape_string($database, $_POST['courseSemesterYearAssignCourse']) . " and schoolYear = '" . mysqli_real_escape_string($database, $_POST['yearAsscourseSemesterYearAssignCourseignCourse']) . "' and semesterNum = " . mysqli_real_escape_string($database, $_POST['semesterYearAssignCourse']) . ";";

            $resultClassID = $database->query($queryClassID);

            if ($resultClassID->num_rows > 0) {
                $row = $resultClassID->fetch_assoc();
            }

            //Sanitize user inputs to prepare for database insert query.
            $subject = $database->real_escape_string($_POST["subjectsAssignCourse"]);
            $schoolYear = $database->real_escape_string($_POST["yearAsscourseSemesterYearAssignCourseignCourse"]);
            $semesterNum = $database->real_escape_string($_POST["semesterYearAssignCourse"]);
            $classID = $database->real_escape_string($row['classID']);
            $studentID = $database->real_escape_string($_POST["studentAssignCourse"]);

            //Create initial SQL query to insert form data into database
            $queryEnrollment = "INSERT INTO enrollment(classID, schoolYear, semesterNum, studentID) 
                                        VALUES ('$classID', '$schoolYear', '$semesterNum', '$studentID');";

            //Execute query and store result.
            $result = $database->query($queryEnrollment);

            //Check if query executed successfully and that the result contains data.
            if (!$result) {
                echo "<h2>Error</h2>
                                <p>Sorry, student could not be registered in this course at this time.</p><br>
                                <form action='assignCourse.php' method='post'>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <button class='button button2'>Try Again</button>
                                    </div>
                                </form>
                                <form action='../../index.php' method='post'>
                                    <div class='col-md-6'>
                                        <button class='button button2'>Return Home</button>
                                    </div>
                                </div>
                            </form>";
            } else {

                echo "<h2>Student Assigned</h2>
                                <p>Student with an ID of " . $studentID . " " . " has been assigned to " . $subject . " course (year: " . $schoolYear . ", semester: " . $semesterNum . ")</p>
                                <br>
                                <form action='assignCourse.php' method='post'>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <button class='button button2'>Assign New</button>
                                    </div>
                                </form>
                                <form action='../../index.php' method='post'>
                                    <div class='col-md-6'>
                                        <button class='button button2'>Return Home</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <div class='bottom'>
            <div id='footer'>";
                include('../../navMenu.php');
                exit("</div>
                            </div>
                        </body>
                    </html>");

            }

            //Take details used in assign student to a course to generate/search for report cards
            //Report card query
            $queryReportCard = "SELECT * FROM reportcard WHERE studentID = $studentID 
                    AND schoolYear = '$schoolYear' AND semesterNum = '$semesterNum';";

            $resultReportCard = $database->query($queryReportCard);

            //If no report card is returned from the query, add one using the information.
            //Otherwise, proceed is normally and bypass the insert query.
            if ($resultReportCard->num_rows == 0) {

                $queryAddReportCard = "INSERT INTO reportcard (isRead, studentID, schoolYear, semesterNum) 
                            VALUES (0, $studentID, '$schoolYear', '$semesterNum')";

                $resultAddReportCard = $database->query($queryAddReportCard);

                if ($resultAddReportCard) {

                    //If successful, reload page
                    header("Location: assignCourse.php");

                } else {

                    echo "<p>Issue adding a report card to STARS for Student $studentID</p>";

                }

            } else {

                //If no report card is generated, refresh the page.
                header("Location: assignCourse.php");

            }

        } else {

        $querySubject = "SELECT * FROM subject;";
        $resultSubject = $database->query($querySubject);

        $queryYearSemester = "SELECT * FROM courseoffering;";
        $resultYearSemester = $database->query($queryYearSemester);

        //Initialize variables to hold the queries and results for students.
        $queryStudent = "";
        $resultStudent = "";

        //Get school ID to populate student's dropdown
        if ($_SESSION["accessCode"] == 1) {

            $queryStudent = "SELECT studentID, firstName, lastName FROM student;";
            $resultStudent = $database->query($queryStudent);

        } else if ($_SESSION["accessCode"] == 2) {

            $userID = $_SESSION["userID"];
            $schoolID = 0;
            $querySchoolID = "SELECT schoolID FROM administrator WHERE userID = $userID;";

            $resultSchoolID = $database->query($querySchoolID);

            if ($resultSchoolID) {

                while ($row = $resultSchoolID->fetch_assoc()) {

                    $schoolID = $row["schoolID"];

                }

            }

            $queryStudent = "SELECT studentID, firstName, lastName FROM student WHERE schoolID = $schoolID;";
            $resultStudent = $database->query($queryStudent);

        }

        $querySemester = "SELECT * FROM semester;";
        $resultSemester = $database->query($querySemester);

        ?>
        <form action="assignCourse.php" method="post">
            <h2>Student Details</h2>
            <p>
                <span style="color: red">*Please ensure all fields are filled before registering a new Student.</span>
            </p>
            <div class="row">
                <div class="col-md-12">
                    <label for="subjectsAssignCourse">Subjects</label>
                    <select class="form-control" id="subjectsAssignCourse" name="subjectsAssignCourse">
                        <option value=''> Select</option>
                        <!-- Using SQL to populate dropdown list of students -->
                        <?php if ($resultSubject->num_rows > 0) {
                            while ($row = $resultSubject->fetch_assoc()) {
                                ?>
                                <option
                                value= <?php echo $row["subjectCode"] ?> ><?php echo $row["subjectCode"] . " - " . $row["subjectName"]; ?></option><?php
                            }
                        } else {
                            echo "<option>No Subjects</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="yearAsscourseSemesterYearAssignCourseignCourse">School Year</label>
                        <select class="form-control" id="yearAsscourseSemesterYearAssignCourseignCourse"
                                name="yearAsscourseSemesterYearAssignCourseignCourse">
                            <option value=''> Select</option>
                            <!-- Using SQL to populate dropdown list of students -->
                            <?php if ($resultSemester->num_rows > 0) {
                                $count = 1;
                                while ($row = $resultSemester->fetch_assoc()) {
                                    if (($count % 2) == 0) {
                                        ?>
                                        <option
                                        value= <?php echo $row["schoolYear"] ?><?php if ($row["schoolYear"] == '2018/2019') {
                                            echo " selected";
                                        } ?>><?php echo $row["schoolYear"] ?></option><?php
                                    }
                                    $count++;
                                }
                            } else {
                                echo "<option>No Subjects</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="semesterYearAssignCourse">Semester</label>
                    <select class="form-control" id="semesterYearAssignCourse"
                            name="semesterYearAssignCourse">
                        <option value=0> Select</option>
                        <option value="01">1st Semester</option>
                        <option value="02">2nd Semester</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="courseSemesterYearAssignCourse">Course</label> <select class="form-control"
                                                                                       name="courseSemesterYearAssignCourse"
                                                                                       id="courseSemesterYearAssignCourse">
                        <option>Select</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="studentAssignCourse">Student</label>
                    <select class="form-control" id="studentAssignCourse" name="studentAssignCourse">
                        <option value=''> Select</option>
                        <!-- Using SQL to populate dropdown list of students -->
                        <?php if ($resultStudent->num_rows > 0) {
                            while ($row = $resultStudent->fetch_assoc()) {
                                ?>
                                <option
                                value= <?php echo $row["studentID"] ?> ><?php echo $row["studentID"] . " - "
                                    . $row["firstName"] . " " . $row["lastName"]; ?></option><?php
                            }
                        } else {
                            echo "<option>No Students</option>";
                        }
                        ?>
                    </select><br>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <?php
                        //Reset button
                        $reset = new Button();

                        $reset->buttonName = "reset";
                        $reset->buttonID = "reset";
                        $reset->buttonValue = "Reset";
                        $reset->buttonStyle = "font-family:sans-serif";
                        $reset->display(); ?>
                    </div>
                    <div class="col-md-8">
                        <!--<input type="submit" name="register" value="Register Student in Course">-->
                        <?php
                        //Register student in course button
                        $assignCourse = new Button();

                        $assignCourse->buttonName = "register";
                        $assignCourse->buttonID = "register";
                        $assignCourse->buttonValue = "Register Student in Course";
                        $assignCourse->buttonStyle = "font-family:sans-serif";
                        $assignCourse->display();
                        ?>
                    </div>
                </div>
        </form>
        <div><?php echo $msg ?></div>
    </div>
</div>
<div class="bottom">
    <div id="footer">
        <?php include("../../navMenu.php"); ?>
    </div>
</div>
</body>
</html>
<?php
}

//Close database connection
$database->close();
?>
