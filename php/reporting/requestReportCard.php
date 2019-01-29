<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 2019-01-29
 */
//Make connection to the database and check to ensure that a solid connection can be made
@ $database = new mysqli('localhost', 'root', '', 'stars');
if (mysqli_connect_errno()) {
    echo '<h2>Error: Could not connect to database. Please try again later.</h2>';
    echo "<form action='addStudent.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
    exit("</div></body></html>");
}
?>

<!--Form to request to view a student's report card.  Requires student name, student ID?(how to incorporate), year & semester-->
<form action="displayReportCard.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">
                <label for="student">Select Student</label>
                <select class="g" id="selectStud" name="selectStud">
                    <!-- Using SQL to populate dropdown list of students (includes the Student's ID, first and last names) -->
                    <?php $query = "SELECT studentID, firstName, lastName FROM student;";
                    $result = $database->query($query);
                    if ($result){
                        while ($row = $result->fetch_assoc()){
                            ?><option><?php echo $row["studentID"].": ".$row["firstName"]." ".$row["lastName"]; ?></option><?php
                        }
                    } else {
                        echo "<option>No Students</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label for="year">Select School Year</label>
                <select class="g" id="selectYear" name="selectYear">
                    <!-- Using SQL to populate dropdown list of school years recorded in database-->
                    <?php $query = "SELECT schoolYear FROM semester;";
                    $result = $database->query($query);
                    if ($result){
                        while ($row = $result->fetch_assoc()){
                            ?><option><?php echo $row["schoolYear"]; ?></option><?php
                        }
                    } else {
                        echo "<option>No School Years recorded in STARS database</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label for="semester">Select Semester</label>
                <select class="g" id="selectSem" name="selectSem">
                    <!-- Using SQL to populate dropdown list of semesters -->
                    <?php $query = "SELECT semesterNum FROM semester;";
                    $result = $database->query($query);
                    if ($result){
                        while ($row = $result->fetch_assoc()){
                            ?><option><?php echo $row["semesterNum"]; ?></option><?php
                        }
                    } else {
                        echo "<option>No semesters have been recorded in the STARS database</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Button elements declared here. Button includes is above with button object declared. !-->
<!--            --><?php
//            $confirm->buttonName = "Submit";
//            $confirm->buttonValue = "Request";
//            $confirm->buttonStyle = "font-family:sans-serif";
//            $confirm->display(); ?>
</form>