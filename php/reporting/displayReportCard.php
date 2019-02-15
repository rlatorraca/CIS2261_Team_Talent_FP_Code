<?php
    /**
     * Created by PhpStorm.
     * STARS Beta Version 1.0
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This is the page used to display a requested reportcard
     *
     * This page requires: stars.css, index.php, login.php, checkLoggedIn.php, dbConn.php, requestReportCard.php
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

        <!-- Here is where we call bootstrap. !-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!--JS/JQuery links-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!--Custom CSS link-->
        <link href="../../css/stars.css" rel="stylesheet">
        <script src="../../js/main.js"></script>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <title>STARS - View Report Card</title>
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
                        exit("</body></html>");
                    }

                    if (isset($_POST['studentID'])) {
                        $studentIDFromForm = $_POST["studentID"];
                        $schoolYearFromForm = $_POST["selectYear"];
                        $semesterNumFromForm = $_POST["selectSemester"];
                    } else {
                        //Variables to hold the requested info from the prior page
                        $studentIDFromForm = $_POST["selectStudent"];
                        $schoolYearFromForm = $_POST["selectYear"];
                        $semesterNumFromForm = $_POST["selectSemester"];
                    }

                    //Initial variables to hold student report card data.
                    $studentFirstName = "";
                    $studentLastName = "";
                    $schoolYear = "";
                    $reportCardNum = 0;
                    $isRead = 0;
                    $studID = 0;
                    $semesterNum = "";
                    $iepMsg = 0;

                    //SQL to pull overall report card details (Report card to identify a student before the extraction of enrollment data).
                    //Be sure to pull the selected student from the requestReportCard.php page to extract the correct student information
                    $query1 = "SELECT reportCardID, isRead, reportcard.studentID, schoolYear, semesterNum, student.firstName, student.lastName
                    FROM reportcard, student 
                    WHERE reportcard.studentID = $studentIDFromForm
                    AND student.studentID = reportcard.studentID
                    AND reportCard.schoolYear = '$schoolYearFromForm'
                    AND reportCard.semesterNum = '$semesterNumFromForm';";

                    $querySelectIEP = "SELECT planID
                  FROM individualeducationplan, supporteducator, student 
                  WHERE individualeducationplan.studentID = $studentIDFromForm;";

                    $result1 = $database->query($query1);
                    $result2 = $database->query($querySelectIEP);

                    if ($result2->num_rows > 0) {
                        $iepMsg = 2;
                    }

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
                                    <td width="25%"></td>
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
                                    <td></td>
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

                    $result2 = $database->query($query2);

                    if ($result2->num_rows > 0) {

                ?>
                <table class="reportCardSide">
                    <thead>
                        <tr>
                            <td class="cardMenu">Course Name</td>
                            <td class="cardMenu">Mark</td>
                            <td class="cardMenu">Days Missed</td>
                            <td>Notes</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $rowCount = 0;
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
                                    }
                                        $rowCount++;
                                    ?></p></td>
                            <?php

                                if ($rowCount == 1) {
                                    echo '<td rowspan="' . $result2->num_rows . '"><div class="reportNote"><p class = "p2">Please hover over the course name to view any teacher comments. 
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.<p></div></td>';
                                }
                            ?>

                            <?php }
                            ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="reportNote">

                                <?php
                                    //Close connection
                                    $result2->free();

                                    //Close connection to database
                                    $database->close();
                                ?>
                                <form method="post" action="viewIEP.php">
                                    <input type="hidden" id="selectStudent" name="selectStudent"
                                           value="<?php echo $studentIDFromForm; ?>">
                                    <input type="hidden" id="selectYear" name="selectYear"
                                           value="<?php echo $schoolYearFromForm; ?>">
                                    <input type="hidden" id="selectSemester" name="selectSemester"
                                           value="<?php echo $semesterNumFromForm; ?>">
                                    <?php
                                        if ($iepMsg > 0) {
                                            $iep = new Button();
                                            $iep->buttonName = "iep";
                                            $iep->buttonID = "iep";
                                            $iep->buttonValue = "Individual Educational Plan";
                                            $iep->buttonStyle = "font-family:sans-serif";
                                            $iep->display();
                                        }
                                    ?>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="reportSignOff">
                                <?php
                                    //Ensure only admin, parent/guardians and the student view this message
                                    if ((!$isRead && $semesterNum >= 1) && ($_SESSION["accessCode"] == 1 || $_SESSION["accessCode"] == 2
                                            || $_SESSION["accessCode"] == 5 || $_SESSION["accessCode"] == 6)) {
                                        echo "<div class='row'>
                        <div class='col-md-7'>
                            <p>I acknowledge that I have reviewed this report card.</p>
                        </div>
                        <div class='col-md-2'>";

                                        //Ensure only admin, parent/guardians and the student can update the report card.
                                        if ($_SESSION["accessCode"] == 1 || $_SESSION["accessCode"] == 2
                                            || $_SESSION["accessCode"] == 5 || $_SESSION["accessCode"] == 6) {
                                            echo "<form action='updateReportCard.php?reportCardNum=" . $reportCardNum . "'
                              method='post'><input type='checkbox' name='signReportCard' class='form-control'></div><div class='col-md-3'>";

                                            $confirm = new Button();

                                            $confirm->buttonName = "confirm";
                                            $confirm->buttonID = "addID";
                                            $confirm->buttonValue = "Confirm";
                                            $confirm->buttonStyle = "font-family:sans-serif";
                                            $confirm->display();
                                            echo "</form></div>";
                                        }
                                        echo "</div></div>";
                                    }
                                ?>
                            </td>
                            <?php
                                } else {
                                $msg = "<h4>This student is not enrolled in any courses for this school year.</h4>";
                            }
                            ?>
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
        <!--Bottom Navbar-->
        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
    </body>
</html>