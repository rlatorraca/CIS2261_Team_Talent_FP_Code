<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 8:58 PM
 */
?>
<!--Form to request to view a students subject history, (request from a teacher)return in graph-->
<!--//*****************creating dropdown of school subjects**********************************************************-->
<!--    //Get educatorID of user-->
<!--    //$educatorID = ($_GET['educatorID']);-->
<!---->
<!--    //Deter SQL injection-->
<!--    //$cleaneducatorID = $db->real_escape_string($educatorID);-->
<!--    //echo "got here1";-->
<!---->
<!--  Create a new connection object using mysqli-->
<?php

//Lock down page
include "../login/checkLoggedIn.php";

//Locks down page for non-admin or non-educational staff. Parent/Guardians and Students are not able to view this page.
if ($_SESSION["accessCode"] != 1 && $_SESSION["accessCode"] != 2 && $_SESSION["accessCode"] != 3) {

    //Simple but requires full CSS
    echo "<p>Can not view this page</p>";
    echo "<a href='../../index.php'>Home</a>";
    exit();

}

//Necessary Db connection
include "../db/dbConn.php";

//query to find the courses the teacher has assigned to them and pull all the students.
$userID = $_SESSION["userID"];

$queryStudent = "";
$schoolID = 0;

if ($_SESSION["accessCode"] == 3) {

    $queryStudent = "SELECT DISTINCT student.studentID, student.firstName, student.lastName FROM user, student, enrollment, 
                    course, courseoffering, subject, semester, educator 
                    WHERE educator.userID = $userID
                    AND user.userID = educator.userID 
                    AND courseoffering.educatorID = educator.educatorID
                    AND student.studentID = enrollment.studentID 
                    AND course.subjectCode = subject.subjectCode AND courseoffering.courseID = course.courseID 
                    AND enrollment.classID = courseoffering.classID;";

} else if ($_SESSION["accessCode"] == 2) {

    $querySchool = "SELECT schoolID FROM administrator WHERE userID = $userID;";

    $resultSchoolID = $database->query($querySchool);

    if ($resultSchoolID) {

        while ($row = $resultSchoolID->fetch_assoc()) {

            $schoolID = $row["schoolID"];

        }

    }

    $queryStudent = "SELECT DISTINCT student.studentID, student.firstName, student.lastName FROM user, student, enrollment, 
                    course, courseoffering, subject, semester, educator, school 
                    WHERE school.schoolID = $schoolID
                    AND student.schoolID = school.schoolID
                    AND courseoffering.educatorID = educator.educatorID
                    AND student.studentID = enrollment.studentID 
                    AND course.subjectCode = subject.subjectCode AND courseoffering.courseID = course.courseID 
                    AND enrollment.classID = courseoffering.classID;";

} else if ($_SESSION["accessCode"] == 4) {



}

//create the query to get subjects
$querySubject = "SELECT subject.subjectCode, subject.subjectName FROM subject, school WHERE school.schoolID = 1";
//query to pull all available school years
$queryYear = "SELECT DISTINCT schoolYear FROM `semester`";

//Execute queries and store results.
$resultStudent = $database->query($queryStudent);
$resultSubject = $database->query($querySubject);
$resultYear = $database->query($queryYear);

?>
<form action="displayStudentSubHistory.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">
                <label for="students">Select Student</label>
                <select class="g" id="students" name="students">
                    <!-- Using SQL to populate dropdown list of students -->
                    <?php if ($resultStudent->num_rows > 0) {
                        while ($row = $resultStudent->fetch_assoc()) {
                            ?>
                            <option
                            value="<?php echo $row["studentID"]; ?>"><?php echo $row["firstName"] . " " . $row["lastName"]; ?></option><?php
                        }
                    } else {
                        echo "<option>No Students</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-3">
            <label for="subjects">Select Subject</label>
            <select class="g" id="subjects" name="subjects">
                <!-- Using SQL to populate dropdown list of subjects -->
                <?php if ($resultSubject->num_rows > 0) {
                    while ($row = $resultSubject->fetch_assoc()) {
                        ?>
                        <option
                        value="<?php echo $row["subjectCode"]; ?>"><?php echo $row["subjectName"]; ?></option><?php
                    }
                } else {
                    echo "<option>No Subjects</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-3">
            <label for="yearStart">Start Date</label>
            <select class="g" id="yearStart" name="yearStart">
                <!-- Using SQL to populate dropdown ldate range begin -->
                <?php if ($resultYear->num_rows > 0) {
                    while ($row = $resultYear->fetch_assoc()) {
                        ?>
                        <option
                        value="<?php echo $row["schoolYear"]; ?>"><?php echo $row["schoolYear"]; ?></option><?php
                    }
                } else {
                    echo "<option>Unavailable</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-3">
            <label for="yearEnd">End Date</label>
            <select class="g" id="yearEnd" name="yearEnd">
                <!-- Using SQL to populate dropdown date range end -->
                <?php
                $resultYear->data_seek(0); // Resets the pointer back to the beginning.
                if ($resultYear->num_rows > 0) {
                    while ($row = $resultYear->fetch_assoc()) {
                        ?>
                        <option
                        value="<?php echo $row["schoolYear"]; ?>"><?php echo $row["schoolYear"]; ?></option><?php
                    }
                } else {
                    echo "<option>Unavailable</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-12">
            <?php

            include("../button.class.php");
            $confirm = new Button();

            $confirm->buttonName = "viewHistory";
            $confirm->buttonID = "viewHistory";
            $confirm->buttonValue = "View";
            $confirm->buttonStyle = "font-family:sans-serif";
            $confirm->display(); ?>
        </div>
    </div>
</form>

