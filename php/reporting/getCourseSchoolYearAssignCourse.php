<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<?php
/**
 * Created by PhpStorm.
 * User: Rodrigo
 * Date: 2019-02-02
 * Time: 11:44 AM
 */


include("../db/dbConn.php");

if (isset($_POST['schoolYear'])) {
	$sql = "select distinct courseoffering.courseID, course.courseName from courseoffering, course where courseoffering.schoolYear='" . mysqli_real_escape_string($database, $_POST['schoolYear']) . "' and  courseoffering.semesterNum = " . mysqli_real_escape_string($database, $_POST['semesterNum']) . " and course.subjectCode='" . mysqli_real_escape_string($database, $_POST['subjectCode']) . "' and course.courseID = courseoffering.courseID ;";
//	$sql = "select courseoffering.courseID, course.courseName from courseoffering, course where courseoffering.schoolYear='" . mysqli_real_escape_string($database, $_POST['schoolYear']).'" and  courseoffering.semesterNum = ". mysqli_real_escape_string($database, $_POST['semesterNum'])." and course.courseID = courseoffering.courseID ;";
	$res = mysqli_query($database, $sql);
	if (mysqli_num_rows($res) > 0) {
		echo "<option value=''>------- Select --------</option>";
		while ($row = mysqli_fetch_object($res)) {
			echo "<option value='" . $row->courseID . "'>" . $row->courseName."</option>";
		}
	} else {
		echo "<option value=''>No Course Available</option>";
    }
} else {
	echo "WRONG CONNECTION";
}
?>