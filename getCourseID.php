<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<?php
/**
 * Created by PhpStorm.
 * Company: Team Talent 2.0
 * Members: John, Rodrigo, Sara, Steve
 * Date: 2/14/2019
 *
 * Page which handles updating the list of courses on the
 *
 * COME BACK to this
 *
 */

include("../db/dbConn.php");

if (isset($_POST['schoolYear'])) {
	$sql = "SELECT courseoffering.courseID, course.courseName 
            FROM courseoffering, course WHERE courseoffering.schoolYear='" . mysqli_real_escape_string($database, $_POST['schoolYear']) . "' 
            AND  courseoffering.semesterNum = '" . mysqli_real_escape_string($database, $_POST['semesterNum']) . "' 
            AND course.subjectCode='" . mysqli_real_escape_string($database, $_POST['subjectCode']) . "' 
            AND course.courseID = courseoffering.courseID;";
	$res = mysqli_query($database, $sql);
	if (mysqli_num_rows($res) > 0) {
		echo "<option value=''>Select</option>";
		while ($row = mysqli_fetch_object($res)) {
			echo "<option value='" . $row->courseID . "'>" . $row->courseName . "</option>";
		}
	} else {
		echo "<option value=''>No Courses Available</option>";
    }
} else {
	echo "WRONG CONNECTION";
}
?>