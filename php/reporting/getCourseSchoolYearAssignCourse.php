<?php
    /**
     * Created by PhpStorm.
     * STARS Beta Version 1.0
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * Page to get the items to populate the dropdowns for the assign course option
     *
     * This page requires: stars.css, index.php, login.php, checkLoggedIn.php, dbConn.php, assignCourse, ajax.js
     *
     */
?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<?php

include("../db/dbConn.php");

if (isset($_POST['schoolYear'])) {
	$sql = "SELECT courseoffering.courseID, course.courseName, educator.educatorFName, educator.educatorLName 
            FROM courseoffering, course, educator 
            WHERE courseoffering.schoolYear='" . mysqli_real_escape_string($database, $_POST['schoolYear']) . "' 
            AND  courseoffering.semesterNum = '" . mysqli_real_escape_string($database, $_POST['semesterNum']) . "' 
            AND course.subjectCode='" . mysqli_real_escape_string($database, $_POST['subjectCode']) . "' 
            AND course.courseID = courseoffering.courseID
            AND courseoffering.educatorID = educator.educatorID;";
//	$sql = "select courseoffering.courseID, course.courseName from courseoffering, course where courseoffering.schoolYear='" . mysqli_real_escape_string($database, $_POST['schoolYear']).'" and  courseoffering.semesterNum = ". mysqli_real_escape_string($database, $_POST['semesterNum'])." and course.courseID = courseoffering.courseID ;";
	$res = mysqli_query($database, $sql);
	if (mysqli_num_rows($res) > 0) {
		echo "<option value=''>Select </option>";
		while ($row = mysqli_fetch_object($res)) {
			echo "<option value='" . $row->courseID . "'>" . $row->courseName . " - " . $row->educatorFName . " " . $row->educatorLName . "</option>";
		}
	} else {
		echo "<option value=''>No Course Available</option>";
    }
} else {
	echo "WRONG CONNECTION";
}
?>