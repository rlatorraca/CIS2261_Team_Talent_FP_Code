<?php
    /**
     * Created by PhpStorm.
     * User: sahra
     * Date: 2019-01-27
     * Time: 9:00 PM
     */

    include "../db/dbConn.php";

    //Selected info from request page
    $student = $_POST["students"];
    $subject = $_POST["subjects"];
    $yearStart = $_POST["yearStart"];
    $yearEnd = $_POST["yearEnd"];

    $queryStudentHistory = "SELECT student.studentID, student.firstName, student.lastName, course.courseName, 
          subject.subjectCode, subject.subjectName, enrollment.mark, enrollment.schoolYear, enrollment.semesterNum 
          FROM student, enrollment, course, courseoffering, subject 
          WHERE student.studentID = $student 
          AND enrollment.schoolYear BETWEEN '$yearStart' AND '$yearEnd'
          AND enrollment.studentID = student.studentID 
          AND enrollment.classID = courseoffering.classID 
          AND courseoffering.courseID = course.courseID 
          AND subject.subjectCode = '$subject'
          AND course.subjectCode = subject.subjectCode";

    $resultSubHistory = $database->query($queryStudentHistory);
    $resultSubName = $database->query($queryStudentHistory);

    //Display results or message
    if ($row = $resultSubName->fetch_assoc()) {
        ?><h2><?php echo $row["firstName"] . " " . $row["lastName"] . "'s History for " . $row["subjectName"]; ?></h2>
        <?php
    } else {
        echo "<p>Empty</p>";
    }


    //$resultSubHistory>data_seek(0); // Resets the pointer back to the beginning.
    //Check/validate if there are items in the database object
    if ($resultSubHistory->num_rows > 0) {

    //Display results to a table
?>
<table class="table table-striped">
    <thead>
        <tr id="viewHeader">
            <th>Course</th>
            <th>Mark</th>
            <th>School Year</th>
            <th>Semester</th>
        </tr>
    </thead>
    <tbody>
    <?php
        while ($row = $resultSubHistory->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['courseName']; ?></td>
                <td><?php echo $row['mark']; ?></td>
                <td><?php echo $row['schoolYear']; ?></td>
                <td><?php echo $row['semesterNum']; ?></td>
            </tr>
            <?php
        }
        } else {
        ?>
        <h2><?php echo "Subject History" ?></h2><?php
        echo "<option>Sorry, there are no marks in STARS to view in the selected subject.</option>";
    }
    ?>
    </tbody>
</table>
