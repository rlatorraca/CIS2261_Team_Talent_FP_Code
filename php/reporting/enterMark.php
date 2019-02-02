<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 9:05 PM
 */
?>
<!--Form to update a students mark.  Requires course name, student name, mark, attendance-->

<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="ajax.js"></script

    <?php
        include '../db/dbConn.php';
    //query to find the courses (and semester Number) the teacher has assigned to them
    $queryCourse = $sql = "SELECT course.courseName, courseoffering.semesterNum FROM course, user, educator, courseoffering 
                            WHERE user.userID = educator.userID 
                            AND course.courseID = courseoffering.courseID 
                            AND educator.userID = 14";
    //query to find the students in the selected course

    $resultCourse = $database->query($queryCourse);



?>
<form action="enterMark.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">
                <label for="students">Select Course - Semester</label>
                <select class="g" id="students" name="students">
                    <option value=''>------- Select --------</option>
                    <!-- Using SQL to populate dropdown list of students -->
                    <?php if ($resultCourse->num_rows > 0) {
                        while ($row = $resultCourse->fetch_assoc()) {
                            ?>
                            <option ><?php echo $row["courseName"]." - ".$row["semesterNum"]; ?></option><?php
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

           <select name="studentMark" id="studentMark"><option>------- Select --------</option></select>

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
                            <option><?php echo $row["schoolYear"]; ?></option><?php
                        }
                    } else {
                        echo "<option>Unavailable</option>";
                    }
                ?>
            </select>
        </div>
    </div>
</form>




<!-- Button elements declared here. Button includes is above with button object declared. !-->
<!--            --><?php
    //            $confirm->buttonName = "Submit";
    //            $confirm->buttonValue = "Request";
    //            $confirm->buttonStyle = "font-family:sans-serif";
    //            $confirm->display(); ?>

< <!-- Button elements declared here. Button includes is above with button object declared. !-->
<?php
    //    $confirm->buttonName = "Submit";
    //    $confirm->buttonValue = "Request";
    //    $confirm->buttonStyle = "font-family:sans-serif";
    //    $confirm->display(); ?>
