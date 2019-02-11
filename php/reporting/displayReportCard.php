<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 2019-01-29
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
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

    <title>STARS: View Report Card</title>
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
    <!--    <script>function goBack() {-->
    <!--            window.history.back();-->
    <!--        }</script>-->
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
    <div class="container-fluid">
        <?php

        //In the event that a user reaches this page before requesting a student's report card from the prior page, handle this.
        if (!isset($_POST["selectStudent"])) {

            //Show message and bottom nav bar.
            $msg = "Please request a student's report card before accessing this page. 
            You can do this by selecting 'Request Report Card' from the Navigation Bar.";
            echo "<br><div class='alert alert-danger'>$msg</div>";
            echo "</div></div>";
            ?>
            <div class='bottom'>
            <div id='footer'><?php include('../../navMenu.php'); ?></div></div><?php
            exit("</body</html>");

        }

        //Variables to hold the requested info from the prior page
        $studentIDFromForm = $_GET["selectStudent"];
        $schoolYearFromForm = $_GET["selectYear"];
        $semesterNumFromForm = $_GET["selectSemester"];

        //Initial variables to hold student report card data.
        $studentFirstName = "";
        $studentLastName = "";
        $schoolYear = "";
        $reportCardNum = 0;
        $isRead = 0;
        $studID = 0;
        $semesterNum = "";

        //SQL to pull overall report card details (Report card to identify a student before the extraction of enrollment data).
        //Be sure to pull the selected student from the requestReportCard.php page to extract the correct student information
        $query1 = "SELECT reportCardID, isRead, reportcard.studentID, schoolYear, semesterNum, student.firstName, student.lastName
                    FROM reportcard, student 
                    WHERE reportcard.studentID = $studentIDFromForm
                    AND student.studentID = reportcard.studentID
                    AND reportCard.schoolYear = '$schoolYearFromForm'
                    AND reportCard.semesterNum = '$semesterNumFromForm';";

        $result1 = $database->query($query1);

        if ($result1->num_rows > 0) {

            while ($rowReportCard = $result1->fetch_assoc()) {

                $reportCardNum = $rowReportCard["reportCardID"];
                $isRead = $rowReportCard["isRead"];
                $studID = $rowReportCard["studentID"];
                $schoolYear = $rowReportCard["schoolYear"];
                $semesterNum = $rowReportCard["semesterNum"];
                $studentFirstName = $rowReportCard["firstName"];
                $studentLastName = $rowReportCard["lastName"];

            }
            ?>
            <table class="reportCardHead">
                <thead>
                <tr>
                    <td><h2><?php echo $studentFirstName . " " . $studentLastName; ?></h2></td>
                    <td width="35%"></td>
                    <td></td>
                    <td><h2><?php echo $schoolYear; ?></h2></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><p><?php if ($semesterNum > 1) {
                                echo "2nd ";
                            } else {
                                echo "1st ";
                            }; ?>Semester</p></td>
                    <td><input type="hidden" value="<?php echo $reportCardNum; ?>"></td>
                    <td><input value="<?php if (!$isRead) {
                            echo "Unread";
                        } else {
                            echo "Is Read";
                        } ?>" readonly></td>
                    <td><?php if (!$isRead) {
                            //Ensure only admin, parent/guardians and the student can update the report card.
                            if ($_SESSION["accessCode"] == 1 || $_SESSION["accessCode"] == 2
                                || $_SESSION["accessCode"] == 5 || $_SESSION["accessCode"] == 6) {
                                echo "<form action='updateReportCard.php?reportCardNum=" . $reportCardNum . "'
                              method='post'><input type='checkbox' name='signReportCard'>
                            <input type='submit' name='Submit' value='Update'></form>";
                            }
                        } ?></td>
                    <td><input type="hidden" value="<?php echo $studID; ?>"></td>
                </tr>
                </tbody>
            </table>
            <?php

            //If there are no results, set this
        } else {
            $msg = "<h4>There is no report card registered in the system for this student. </h4>";
        }

        $result1->free();

        //SQL for individual Enrollments
        $query2 = "SELECT course.courseName, subject.subjectCode, mark, attendance,
                    notes, educator.educatorFName, educator.educatorLName
                    FROM enrollment, course, courseoffering, subject, educator
                    WHERE enrollment.studentID = $studentIDFromForm
                    AND enrollment.schoolYear = '$schoolYearFromForm'
                    AND enrollment.semesterNum = '$semesterNumFromForm'
                    AND enrollment.classID = courseoffering.classID
                    AND courseoffering.courseID = course.courseID
                    AND courseoffering.educatorID = educator.educatorID
                    AND course.subjectCode = subject.subjectCode;";

        //May be needed in query
        //AND semester.schoolYear = enrollment.schoolYear
        //AND semester.semesterNum = enrollment.semesterNum
        $result2 = $database->query($query2);

        if ($result2->num_rows > 0) {

        ?>
        <div>
            <table class="reportCardSide">
                <thead>
                <tr>
                    <td>Course Name</td>
                    <!--            <td>Subject</td>-->
                    <td>Mark</td>
                    <td>Days Missed</td>
                    <!--            <td>Notes</td>-->
                    <!--            <td>Teacher Name</td>-->
                </tr>
                </thead>
                <tbody>
                <?php
                while ($rowEnrollment = $result2->fetch_assoc()) {

                    $courseName = $rowEnrollment["courseName"];
                    $subjectCode = $rowEnrollment["subjectCode"];
                    $mark = $rowEnrollment["mark"];
                    $daysMissed = $rowEnrollment["attendance"];
                    $notes = $rowEnrollment["notes"];
                    $educatorFirstName = $rowEnrollment["educatorFName"];
                    $educatorLastName = $rowEnrollment["educatorLName"];

                    ?>
                    <tr>
                        <td><label title="<?php if ($notes == "") {
                                echo "Empty";
                            } else {
                                echo $notes;
                            } ?>"><?php echo $courseName; ?></label></td>
                        <!--                <td> --><?php //echo $subjectCode; ?><!--</td>-->
                        <td><p> <?php if ($mark == "") {
                                    echo "0";
                                } else {
                                    echo $mark . "%";
                                } ?></p></td>
                        <td><p><?php if ($daysMissed == "") {
                                    echo "0 days";
                                } else {
                                    echo $daysMissed . " days";
                                } ?></p></td>
                        <!--                <td> --><?php //if ($notes == "") {
                        //                        echo "Empty";
                        //                    } else {
                        //                        echo $notes;
                        //                    } ?><!--</td>-->
                        <!--                <td> -->
                        <?php //echo $educatorFirstName . " " . $educatorLastName; ?><!--</td>-->
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> <?php
                        } else {
                            $msg .= "<h4>This student is not enrolled in any courses for this school year.</h4>";
                        }

                        //Close connection
                        $result2->free();

                        //Close connection to database
                        $database->close();

                        if (!isset($msg)) {
                            $iep = new Button();

                            $iep->buttonName = "iep";
                            $iep->buttonID = "iep";
                            $iep->buttonValue = "Individual Educational Plan";
                            $iep->buttonStyle = "font-family:sans-serif";
                            //Back button works. Does not use the main.js file however.
                            $iep->buttonWeb = 'location.href="viewIEP.php?studentID=' . $studentIDFromForm . '"';
                            $iep->display();
                        }

                        ?>
                    <td>
                </tr>
                </tbody>
            </table>
            <?php
            //If the error message is set, display it along with a back button.
            if (isset($msg)) {
                echo "<br><div class='alert alert-danger'>$msg</div>";

                //Back button
                $goBack = new Button();

                $goBack->buttonName = "goBack";
                $goBack->buttonID = "goBack";
                $goBack->buttonValue = "Go Back";
                $goBack->buttonStyle = "font-family:sans-serif";
                //Back button works. Does not use the main.js file however.
                $goBack->buttonWeb = "javascript:history.back(-1);";
                $goBack->display();
            }
            ?>
        </div>
    </div>
</div>
</form>
</div>
</div>
<div class="bottom">
    <div id="footer">
        <?php include("../../navMenu.php"); ?>
    </div>
</div>
</body>
</html>