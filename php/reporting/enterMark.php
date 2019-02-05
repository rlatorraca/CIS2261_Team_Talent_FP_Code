<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 9:05 PM
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Locks down page for non-admin or educational staff. Parent/Guardians, Support Educators and Students are not able to view this page.
if ($_SESSION["accessCode"] == 4 || $_SESSION["accessCode"] == 5 || $_SESSION["accessCode"] == 6) {

    //Simple but requires full CSS
    echo "<p>Can not view this page</p>";
    echo "<a href='../../index.php'>Home</a>";
    exit();

}

//Database connection
include '../db/dbConn.php';

?>
<!--Form to update a students mark.  Requires course name, student name, mark, attendance-->

<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="ajax.js"></script>

<?php
$msg = "";
if (isset($_POST['submitUpdateRecord'])) {
    $markInput = $_POST['markInput'];
    $attendence = $_POST['attendance'];
    $teacherNotes = $_POST['teacherNotes'];
    $classID = $_POST['courseSemester'];
    $studentID = $_POST['studentMark'];

    $queryCourse1 = "UPDATE enrollment SET mark= $markInput, attendance = $attendence, notes= '$teacherNotes' 
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
    $database->close();

} else {

    //Get logged in user's userID
    $educatorUserID = $_SESSION['userID'];

    //query to find the courses (and semester Number) the teacher has assigned to them
    $queryCourse = "SELECT courseoffering.classID, course.courseName, courseoffering.semesterNum 
                    FROM course, user, educator, courseoffering 
                    WHERE educator.userID = $educatorUserID
                    AND courseoffering.educatorID = educator.educatorID 
                    AND user.userID = educator.userID 
                    AND course.courseID = courseoffering.courseID;";
    //query to find the students in the selected course

    $resultCourse = $database->query($queryCourse);
}
?>
<form action="enterMark.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">
                <label for="students">Select Course - Semester</label>
                <select class="g" id="courseSemester" name="courseSemester">
                    <option value=''>------- Select --------</option>
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
        </div>
        <div class="col-3">
            <label for="studentMark">Student</label>
            <!--            $queryCourse =-->

            <select name="studentMark" id="studentMark">
                <option>------- Select --------</option>
            </select>


        </div>
        <!--        <div class="col-3">-->
        <!--            <label for="markInput">Select Mark</label>-->
        <!--            <select class="form-control" id="markInput" name="markInput">-->
        <!--                --><?php
        //                    for ($i = 0; $i <= 100; $i++) {
        //                        ?>
        <!--                        <option value="--><?php //echo $i; ?><!--">--><?php //echo $i; ?><!--</option>-->
        <!--                        --><?php
        //                    }
        //                ?>
        <!--            </select>-->
        <!--        </div>-->
        <div class="col-3">
            <label for="markInput">Mark</label>
            <input id="markInput" type="text" name="markInput" placeholder="Enter mark" size="15">

        </div>
        <div class="col-3">
            <label for="attendance">Days missed</label>
            <input id="attendance" type="text" name="attendance" placeholder="Enter days missed" size="15">

        </div>
        <div class="col-3">
            <label for="teacherNotes">Teacher´s notes</label><br/>
            <textarea id="teacherNotes" name="teacherNotes" placeholder="Enter notes" cols="75" rows="4"></textarea>

        </div>
        <div class="col-3">
            <!--            <input type="submit" id="btn" name="submitUpdateRecord" class="btn btn-info text-center" value="submitUpdateRecord">-->
            <button type="submit" id="submitUpdateRecord" name="submitUpdateRecord">Update Record</button>
        </div>
    </div>
</form>

<?php
if (isset($msg)) {
    echo "<div class='alert alert-danger'>$msg</div>";
}
?>

