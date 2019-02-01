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
    <title>View Report Card</title>
</head>
<body>
<?php
    include '../dbConn.php';
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
    <table>
        <thead>
        <tr>
            <td>Report Card Number</td>
            <td>Seen</td>
            <td>Student ID</td>
            <td>School Year</td>
            <td>Semester</td>
            <td>Student Name</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo $reportCardNum; ?></td>
            <td><?php if (!$isRead) {
                    echo "No";
                } else {
                    echo "Yes";
                } ?></td>
            <td><?php echo $studID; ?></td>
            <td><?php echo $schoolYear; ?></td>
            <td><?php echo $semesterNum; ?></td>
            <td><?php echo $studentFirstName . " " . $studentLastName; ?></td>
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
                    notes, educator.firstName, educator.lastName
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
    <table>
        <thead>
        <tr>
            <td>Course Name</td>
            <td>Subject</td>
            <td>Mark</td>
            <td>Days Missed</td>
            <td>Notes</td>
            <td>Teacher Name</td>
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
            $educatorFirstName = $rowEnrollment["firstName"];
            $educatorLastName = $rowEnrollment["lastName"];

            ?>
            <tr>
                <td> <?php echo $courseName; ?></td>
                <td> <?php echo $subjectCode; ?></td>
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
                <td> <?php if ($notes == "") {
                        echo "Empty";
                    } else {
                        echo $notes;
                    } ?></td>
                <td> <?php echo $educatorFirstName . " " . $educatorLastName; ?></td>
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
</body>
</html>

