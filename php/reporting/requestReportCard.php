<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 2019-01-29
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Make connection to the database and check to ensure that a solid connection can be made
include '../db/dbConn.php';

//Button class
include "../button.class.php";

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

    <title>STARS: Request Report Card</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Calendar Date Picker !-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <link href="../../css/stars.css" rel="stylesheet">
    <script src="../../js/main.js"></script>
    <!--        <script>-->
    <!--            // This function shows the date picker.-->
    <!--            $(function () {-->
    <!--                $("#datepicker").datepicker();-->
    <!--            });-->
    <!---->
    <!--            // This function shows the note.-->
    <!--            // Will need to add a variable to get the notes to then call.-->
    <!--            $(function () {-->
    <!--                $(document).tooltip();-->
    <!--            });-->
    <!---->
    <!--            // This function manages the drop downs on the main menu.-->
    <!--            $(function () {-->
    <!--                $("#menu").menu();-->
    <!--            });-->
    <!--        </script>-->
</head>
<body>
<?php include "../../header.php"; ?>
<div class="jumbotron-fluid">
    <div class="container-fluid login">
        <!--Form to request to view a student's report card.  Requires student name, student ID?(how to incorporate), year & semester-->
        <form action="displayReportCard.php" method="post">
            <h2>Report Cards</h2>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-3">
                        <label for="selectStudent">Select Student</label>
                        <select class="form-control" id="selectStudent" name="selectStudent">
                            <!-- Using SQL to populate dropdown list of students
                            (includes the Student's ID, first and last names) -->
                            <?php

                            $query = "";
                            $userID = $_SESSION["userID"];

                            //Switch statement to determine the student(s) to show in the search student drop down box.
                            //Important for the many user levels present in the STARS system.
                            switch ($_SESSION["accessCode"]) {

                                case 1:
                                    $query = "SELECT studentID, firstName, lastName FROM student;";
                                    break;
                                case 2:
                                    $querySchoolID = "SELECT schoolID FROM administrator WHERE userID = $userID;";

                                    $resultSchoolID = $database->query($querySchoolID);

                                    if ($resultSchoolID) {

                                        while ($row = $resultSchoolID->fetch_assoc()) {

                                            $schoolID = $row["schoolID"];

                                        }
                                    }

                                    $query = "SELECT studentID, firstName, lastName FROM student, school 
                                              WHERE school.schoolID = $schoolID AND student.schoolID = school.schoolID;";
                                    break;
                                case 3:
                                    $query = "SELECT DISTINCT student.studentID, student.firstName, student.lastName 
                                            FROM user, student, enrollment, course, courseoffering, subject, semester, educator 
                                            WHERE educator.userID = $userID
                                            AND user.userID = educator.userID 
                                            AND courseoffering.educatorID = educator.educatorID
                                            AND student.studentID = enrollment.studentID 
                                            AND course.subjectCode = subject.subjectCode AND courseoffering.courseID = course.courseID 
                                            AND enrollment.classID = courseoffering.classID;";
                                    break;
                                case 4:
                                    $querySupportEducator = "SELECT supportEducatorID FROM supporteducator, user 
                                                              WHERE supporteducator.userID = $userID;";

                                    $resultQuerySupportEducator = $database->query($querySupportEducator);

                                    if ($resultQuerySupportEducator) {

                                        while ($row = $resultQuerySupportEducator->fetch_assoc()) {

                                            $supportEducatorID = $row["supportEducatorID"];

                                        }
                                    }

                                    $query = "SELECT DISTINCT student.studentID, student.firstName, student.lastName 
                                                    FROM student, supporteducator 
                                                    WHERE supporteducator.supportEducatorID = $supportEducatorID
                                                    AND student.supportEducatorID = supporteducator.supportEducatorID;";
                                    break;
                                case 5:
                                    $query = "SELECT DISTINCT student.studentID, student.firstName, student.lastName 
                                                      FROM student WHERE student.userID = $userID;";
                                    break;
                                case 6:
                                    $queryParentGuardian = "SELECT parentorguardian.guardianID FROM parentorguardian WHERE userID = $userID;";

                                    $resultsParentGuardian = $database->query($queryParentGuardian);

                                    if ($resultsParentGuardian) {

                                        while ($row = $resultsParentGuardian->fetch_assoc()) {

                                            $guardianID = $row["guardianID"];
                                        }
                                    }

                                    $query = "SELECT DISTINCT student.studentID, student.firstName, student.lastName FROM student, parentorguardian 
                                                    WHERE parentorguardian.guardianID = $guardianID
                                                    AND student.guardianID = parentorguardian.guardianID;";
                                    break;
                                default:
                                    $query = "SELECT studentID, firstName, lastName FROM student;";
                                    break;
                            }

                            $resultStudent = $database->query($query);
                            if ($resultStudent->num_rows > 0) {
                                while ($row = $resultStudent->fetch_assoc()) {
                                    ?>
                                    <option
                                    value="<?php echo $row["studentID"]; ?>"><?php echo $row["firstName"] . " " . $row["lastName"]; ?></option><?php
                                }
                            } else {
                                echo "<option>No Students</option>";
                            }
                            ?>
                        </select><br>
                    </div>
                    <div class="col-3">
                        <label for="selectYear">Select School Year</label>
                        <select class="form-control" id="selectYear" name="selectYear">
                            <!-- Using SQL to populate dropdown list of school years recorded in database-->
                            <?php $query = "SELECT DISTINCT schoolYear FROM semester ORDER BY schoolYear DESC";
                            $resultYear = $database->query($query);
                            if ($resultYear->num_rows > 0) {
                                while ($row = $resultYear->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row["schoolYear"]; ?>"><?php echo $row["schoolYear"]; ?></option><?php
                                }
                            } else {
                                echo "<option>No School Years recorded in STARS database</option>";
                            }
                            ?>
                        </select><br>
                    </div>
                    <div class="col-3">
                        <label for="selectSemester">Select Semester</label>
                        <select class="form-control" id="selectSemester" name="selectSemester">
                            <!-- Using SQL to populate dropdown list of semesters -->
                            <?php $query = "SELECT DISTINCT semesterNum FROM semester;";
                            $resultSemester = $database->query($query);
                            if ($resultSemester->num_rows > 0) {
                                while ($row = $resultSemester->fetch_assoc()) {
                                    ?>
                                    <option
                                    value="<?php echo $row["semesterNum"]; ?>"><?php echo $row["semesterNum"]; ?></option><?php
                                }
                            } else {
                                echo "<option>No semesters have been recorded in the STARS database</option>";
                            }
                            ?>
                        </select><br>
                    </div>

                    <?php
                    $request = new Button();

                    $request->buttonName = "viewReportCard";
                    $request->buttonID = "viewReportCard";
                    $request->buttonValue = "View Report Card";
                    $request->buttonStyle = "font-family:sans-serif";
                    $request->display(); ?>
                </div>
        </form>
        <?php
        if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
    </div>
</div>
<div class="bottom">
    <div id="footer">
        <?php include("../../navMenu.php"); ?>
    </div>
</div>
</body>
</html>