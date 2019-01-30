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
    exit("</div></body></html>");
}
?>

<!--Form to request to view a student's report card.  Requires student name, student ID?(how to incorporate), year & semester-->
<form action="displayReportCard.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">
                <label for="selectStudent">Select Student</label>
                <select class="g" id="selectStudent" name="selectStudent">
                    <!-- Using SQL to populate dropdown list of students (includes the Student's ID, first and last names) -->
                    <?php $query = "SELECT studentID, firstName, lastName FROM student;";
                    $resultStudent = $database->query($query);
                    if ($resultStudent->num_rows > 0) {
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
            <div class="col-3">
                <label for="selectYear">Select School Year</label>
                <select class="g" id="selectYear" name="selectYear">
                    <!-- Using SQL to populate dropdown list of school years recorded in database-->
                    <?php $query = "SELECT DISTINCT schoolYear FROM semester;";
                    $resultYear = $database->query($query);
                    if ($resultYear->num_rows > 0) {
                        while ($row = $resultYear->fetch_assoc()) {
                            ?>
                            <option
                            value="<?php echo $row["schoolYear"]; ?>"><?php echo $row["schoolYear"]; ?></option><?php
                        }
                    } else {
                        echo "<option>No School Years recorded in STARS database</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label for="selectSemester">Select Semester</label>
                <select class="g" id="selectSemester" name="selectSemester">
                    <!-- the name attribute has hold selectSem... WHen this gets passed in post, the value of the selected option below will be passed. YOu have all of your name attributes incorrect.
                    So instead of how I tried to jump in php and use the $selectSemester, it should really just be name="selectSemester"? For name yes. Then the dropdown values would be chosen by the user. WHen you click
                    submit, the chosen value (from the chosen option) gets passed and you do $userCHoiceSelectSem = $_POST['selectSem']; // this would tell you which they picked
                    So that would appear on this page? /// oh yes. This is the form page. YOu are just setting up the form for the user with some options. THey make
                    their choices inthe form, then you pass the data to the display page, get their choices form the form and use that data in your next query (to
                    display the report card). Ok, I think I'm following. I need to have a button for the user to click when they're finished with their options,
                    and then in the form, have the action set to post to the next page. On the display page, use the $_POST[] to access their choices?? Yes. Ok,
                    that seems more simple. Not sure why I over complicated it, as per usual. Thank you. No problem!
                    <!-- Using SQL to populate dropdown list of semesters -->
                    <?php $query = "SELECT DISTINCT semesterNum FROM semester;";
                    $resultSemester = $database->query($query);
                    if ($resultSemester->num_rows > 0) {
                        while ($row = $resultSemester->fetch_assoc()) {
                            ?>
                            <option
                            value="<?php echo $row["semesterNum"]; ?>"><?php echo $row["semesterNum"]; ?></option><?php
                        }
                    } else {
                        echo "<option>No semesters have been recorded in the STARS database</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- These vars? WHere do they come from? They aren't populating. The idea was that when the option boxes are selected, then the select value takes on the option selected and then that is what is passed as the student ID for example.
            OOOOH. Gotcha. This is beyond PHP's ability. You will need Javascript for this. OR after you make a selection in the dropdown
            you will need to find some javascript that would reload the page, but not just hte url of the page, but with the query string below appended.
            Then you would use $_GET['selectedStudent'] from the url to access those vars. As far as time frame, not sure that is possible. Many instead of two pages, condense it down to a one page action?
            How many students would be in that dropdown? Right now there is 6 in the whole database, so when new student's are added and this page reloads, those option boxes would reflect that.
            Instead of a link and using GET, why don't you just make a button and use POST, pass this data to the next page that way?
            But that is what I was trying to do with the button earlier and then now the link, is javascript still required for that? No... Just php.
            Is it fairly different from what I have going on right here?-->
            <!--<a href='displayReportCard.php?studentID=<?php echo $selectStudent ?>&schoolYear=<?php echo $selectYear ?>&semesterNum=<?php echo $selectSemester ?>"'>View Report Card</a>-->

            <button>View Report Card</button>
</form>