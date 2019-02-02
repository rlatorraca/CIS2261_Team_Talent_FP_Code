<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 2019-01-29
 */
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
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link rel="stylesheet" href="/resources/demos/style.css">

            <!-- Calendar Date Picker !-->
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


            <link href="../../css/stars.css" rel="stylesheet">
            <script>
                // This function shows the date picker.
                $( function() {
                    $( "#datepicker" ).datepicker();
                } );

                // This function shows the note.
                // Will need to add a variable to get the notes to then call.
                $( function() {
                    $( document ).tooltip();
                } );

                // This function manages the drop downs on the main menu.
                $( function() {
                    $( "#menu" ).menu();
                } );
            </script>
        </head>
        <body>
            <div class="header">
                <img src="../../img/StarsWhiteFIN.jpg">
            </div>
            <div class="jumbotron-fluid">
                <div class="container-fluid">
<?php
    include '../db/dbConn.php';
//Variable to hold the requested info from the prior page
$studentIDFromForm = $_POST["selectStudent"];
$schoolYearFromForm = $_POST["selectYear"];
$semesterNumFromForm = $_POST["selectSemester"];



//SQL to pull overall report card details (Report card to identify a student before the extraction of enrollment data).
//Be sure to pull the selected student from the requestReportCard.php page to extract the correct student information
$query1 = "SELECT reportCardID, isRead, reportcard.studentID, schoolYear, semesterNum, student.firstName, student.lastName
                    FROM reportcard, student 
                    WHERE reportcard.studentID = $studentIDFromForm
                    AND student.studentID = reportcard.studentID
                    AND reportCard.schoolYear = '$schoolYearFromForm'
                    AND reportCard.semesterNum = '$semesterNumFromForm';"; // is this it? No, this one works fine. Below

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
    <table class = "reportCardHead">
        <thead>
        <tr>
            <td><h2><?php echo $studentFirstName . " " . $studentLastName; ?></h2></td>
            <td width="50%"></td>
            <td><h2><?php echo $schoolYear; ?></h2></td>


        </tr>
        </thead>
        <tbody>
        <tr>
            <td><p><?php if ($semesterNum > 1) {
                echo "2nd ";
                } else {
                echo "1st ";
                    } ; ?>Semester</p></td>
            <td><input type="hidden" value="<?php echo $reportCardNum; ?>">
                <input type="hidden" value="<?php if (!$isRead) {
                    echo "No";
                } else {
                    echo "Yes";
                } ?>"></td>
            <td><input type="hidden" value="<?php echo $studID; ?>"></td>


        </tr>
        </tbody>
    </table>
    <?php

    //If there are no results, show this
} else {
    echo "<p>No results</p>";
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
                <td><p title="<?php if ($notes == "") {
                        echo "Empty";
                    } else {
                        echo $notes;
                    } ?>"><?php echo $courseName; ?></p></td>
<!--                <td> --><?php //echo $subjectCode; ?><!--</td>-->
                <td> <?php if ($mark == "") {
                        echo "0";
                    } else {
                        echo $mark . "%";
                    } ?></td>
                <td> <?php if ($daysMissed == "") {
                        echo "0 days";
                    } else {
                        echo $daysMissed . " days";
                    } ?></td>
<!--                <td> --><?php //if ($notes == "") {
//                        echo "Empty";
//                    } else {
//                        echo $notes;
//                    } ?><!--</td>-->
<!--                <td> --><?php //echo $educatorFirstName . " " . $educatorLastName; ?><!--</td>-->
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
} else {
    echo "<p>No results</p>";
}

//Close connection
$result2->free();

//Close connection to database
$database->close();

echo "<a href='viewIEP.php?studentID=" . $studentIDFromForm . "'>View IEP</a>";

?>
                </div>
                </form>
                <?php
                if (isset($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }


                ?>
            </div>
            </div>
            <div class = "bottom">
                <div id="footer">
                    <ul id="footerMenu">
                        <?php
                        echo '<a href="#"><li class = "titleNav">Home</li></a>';

                        ?>
                    </ul>
                </div>
            </div>

        </body>
</html>

