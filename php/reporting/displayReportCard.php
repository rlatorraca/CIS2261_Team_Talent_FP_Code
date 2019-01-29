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

    //Variable to hold the student ID requested
    $studentID = 12;// should this be 12? Yes lol.
    //Make connection to the database and check to ensure that a solid connection can be made
    @ $database = new mysqli('localhost', 'root', '', 'stars');
        if (mysqli_connect_errno()) {
            echo '<h2>Error: Could not connect to database. Please try again later.</h2>';
            exit("</div></body></html>");
        }
        // you have a look and see what you can find. Check in again ina  few
        //Thanks!
        //SQL to pull overall report card details (Report card to identify a student before the extraction of enrollment data).
        //Be sure to pull the selected student from the requestReportCard.php page to extract the correct student information
        $query1 = "SELECT reportCardID, isRead, reportcard.studentID, schoolYear, semesterNum, student.firstName, student.lastName
                    FROM reportcard, student 
                    WHERE reportcard.studentID = '$studentID'
                    AND student.studentID = reportcard.studentID;";

        $result1 = $database->query($query1);

        if ($result1) {

            while ($row = $result1->fetch_assoc()){

                $reportCardNum = $row["reportCardID"];
                $isRead = $row["isRead"];
                $studID = $row["studentID"];
                $schoolYear = $row["schoolYear"];
                $semesterNum = $row["semesterNum"];
                $studentFirstName = $row["firstName"];
                $studentLastName = $row["lastName"];
            }
    ?>
    <table>
        <thead>
            <tr>
                <td>Report Card Number</td>
                <td>Is read</td>
                <td>Student ID</td>
                <td>School Year</td>
                <td>Semester</td>
                <td>Student Name</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $reportCardNum; ?></td>
                <td><?php if (!$isRead) { echo "No"; } else { echo "Yes"; } ?></td>
                <td><?php echo $studID; ?></td>
                <td><?php echo $schoolYear; ?></td>
                <td><?php echo $semesterNum; ?></td>
                <td><?php echo $studentFirstName." ".$studentLastName; ?></td>
            </tr>
        </tbody>
    </table>
    <?php
        //If there are no results, show this
        } else {
            echo "<p>No results</p>";
        }
            //SQL for individual Enrollments
        $query2 = "SELECT course.courseName, subject.subjectCode, mark, attendance,
                    notes, educator.firstName, educator.lastName
                    FROM student, enrollment, course, courseoffering, subject, semester, educator
                    WHERE enrollment.studentID = '$studentID'
                    AND student.studentID = enrollment.studentID
                    AND enrollment.schoolYear = '$schoolYear'
                    AND enrollment.semesterNum = '$semesterNum'
                    AND semester.schoolYear = enrollment.schoolYear
                    AND semester.semesterNum = enrollment.semesterNum
                    AND course.subjectCode = subject.subjectCode
                    AND courseoffering.courseID = course.courseID
                    AND enrollment.classID = courseoffering.classID
                    AND courseoffering.educatorID = educator.educatorID;";

        $result2 = $database->query($query2);

        if ($result2) {

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
            <?php

            while ($row = $result2->fetch_assoc()){
                ?>
                <tbody>
                    <tr>
                        <td> <?php echo $row["courseName"]; ?></td>
                        <td> <?php echo $row["subjectCode"]; ?></td>
                        <td> <?php if ($row["mark"] == ""){ echo "Empty"; } else { echo $row["mark"]; } ?></td>
                        <td> <?php if ($row["attendance"] == "") { echo "0 days"; } else { echo $row["attendance"]; } ?></td>
                        <td> <?php if ($row["notes"] == "") { echo "Empty"; } else { echo $row["notes"]; } ?></td>
                        <td> <?php echo $row["firstName"]." ".$row["lastName"]; ?></td>
                    </tr>
                </tbody>
                <?php } ?>
                </table>
            <?php
        } else {
            echo "<p>No results</p>";
        }


        ?>
</body>
</html>

