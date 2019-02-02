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

if (isset($_POST['classID'])) {
	$sql = "select student.firstName, student.lastName, student.studentID from enrollment, student, courseoffering where courseoffering.classID=" . mysqli_real_escape_string($database, $_POST['classID']) . " and enrollment.classID = courseoffering.classID and student.studentID = enrollment.studentID;";
	$res = mysqli_query($database, $sql);
	if (mysqli_num_rows($res) > 0) {
		echo "<option value=''>------- Select --------</option>";
		while ($row = mysqli_fetch_object($res)) {
			echo "<option value='" . $row->studentID . "'>" . $row->firstName . " " . $row->lastName . "</option>";
		}
	}
} else {
	echo "WRONG CONNECTION";
}
?>