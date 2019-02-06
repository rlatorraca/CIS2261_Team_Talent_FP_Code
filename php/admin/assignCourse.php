<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="../reporting/ajax.js"></script>

<script type="text/javascript" language="javascript">
    function ClearForm() {
        document.reset();
    }
</script>
<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 2019-01-27
 * Time: 9:05 PM
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
include "../db/dbConn.php";


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assign Student to a Course/Enrollment</title>
</head>
<body>
<div>
	<?php
	//To trigger when user submits request to add new Student to stars database
	if (isset($_POST["register"])) {

		//If details are empty, display a message and give redirect links. Otherwise, proceed.
		if ($_POST["subjectsAssignCourse"] == "" || $_POST["yearAsscourseSemesterYearAssignCourseignCourse"] == "" || $_POST["semesterYearAssignCourse"] == "" || $_POST["courseSemesterYearAssignCourse"] == "" || $_POST["studentAssignCourse"] == "") {
			echo "<h2>Error. Form fields must not be empty before registering new student in a course.</h2><br>";
			echo "<form action='addStudent.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
			echo "<form action='../../Template/index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
			exit("</div></body</html>");
		}

		$queryClassID = "SELECT classID FROM courseoffering WHERE courseID=" . mysqli_real_escape_string($database, $_POST['courseSemesterYearAssignCourse']) . " and schoolYear = '" . mysqli_real_escape_string($database, $_POST['yearAsscourseSemesterYearAssignCourseignCourse']) . "' and semesterNum = " . mysqli_real_escape_string($database, $_POST['semesterYearAssignCourse']) . ";";
		var_dump($queryClassID);
		$resultClassID = $database->query($queryClassID);
		var_dump($resultClassID);

		if ($resultClassID->num_rows > 0) {
			$row = $resultClassID->fetch_assoc();
		}

		//*******will need to pull the classID and StudentID somewhere
		//Sanitize user inputs to prepare for database insert query.
		$subject = $database->real_escape_string($_POST["subjectsAssignCourse"]);
		$schoolYear = $database->real_escape_string($_POST["yearAsscourseSemesterYearAssignCourseignCourse"]);
		$semesterNum = $database->real_escape_string($_POST["semesterYearAssignCourse"]);
		$classID = $database->real_escape_string($row['classID']);
		$studentID = $database->real_escape_string($_POST["studentAssignCourse"]);

		//Create initial SQL query to insert form data into database
		$queryEnrollment = "INSERT INTO enrollment(classID,schoolYear, semesterNum, studentID) 
                  VALUES ('$classID', '$schoolYear', '$semesterNum', '$studentID');";

		//Execute query and store result.
		var_dump($queryEnrollment);
		$result = $database->query($queryEnrollment);
		var_dump($result);

		//Check if query executed successfully and that the result contains data.
		if ($result) {

			echo "<h2>Student has been successfully register in the course.</h2><br>";
			echo "<form action='assignCourse.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Assign another student</button></div></fieldset></form>";
			echo "<form action='../../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";

		} else {

			echo "<h2>Sorry, student could not be registered in this course at this time.</h2><br>";
			echo "<form action='assignCourse.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
			echo "<form action='../../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
		}

		//Close database connection
		$database->close();

	} else {

	include "../db/dbConn.php";
	$querySubject = "SELECT * FROM subject";
	$resultSubject = $database->query($querySubject);

	$queryYearSemester = "SELECT * FROM courseoffering";
	$resultYearSemester = $database->query($queryYearSemester);

	$queryStudent = "SELECT * FROM student";
	$resultStudent = $database->query($queryStudent);

	$querySemester = "SELECT * FROM semester";
	$resultSemester = $database->query($querySemester);


	//Close database connection
	$database->close();

	?>
    <p>**Please ensure all fields are filled before registering a new Student.</p>
    <form action="assignCourse.php" method="post">
        <fieldset>
            <legend>Student Details</legend>
            <div class="form-group">
                <div class="form-row">

                    <label for="subjectsAssignCourse">Subjects</label>
                    <select class="g" id="subjectsAssignCourse" name="subjectsAssignCourse">
                        <option value=''>------- Select --------</option>
                        <!-- Using SQL to populate dropdown list of students -->
						<?php if ($resultSubject->num_rows > 0) {
							while ($row = $resultSubject->fetch_assoc()) {
								?>
                                <option
                                value= <?php echo $row["subjectCode"] ?> ><?php echo $row["subjectCode"] . " - " . $row["subjectName"]; ?></option><?php
							}
						} else {
							echo "<option>No Subjects</option>";
						}
						?>
                    </select>

                    <label for="yearAsscourseSemesterYearAssignCourseignCourse">School Year</label>
                    <select class="g" id="yearAsscourseSemesterYearAssignCourseignCourse" name="yearAsscourseSemesterYearAssignCourseignCourse">
                        <option value=''>------- Select --------</option>
                        <!-- Using SQL to populate dropdown list of students -->
		                <?php if ($resultSemester->num_rows > 0) {
		                    $count = 1;
			                while ($row = $resultSemester->fetch_assoc()) {
			                    if(($count % 2 ) == 0){
				                ?>
                                <option
                                value= <?php echo $row["schoolYear"]?>><?php echo $row["schoolYear"] ?></option><?php
			                    }
			                    $count++;
			                }
		                } else {
			                echo "<option>No Subjects</option>";
		                }
		                ?>
                    </select>


<!--                    <label for="yearAsscourseSemesterYearAssignCourseignCourse">Year</label>-->
<!--                    <select class="g" id="yearAsscourseSemesterYearAssignCourseignCourse"-->
<!--                            name="yearAsscourseSemesterYearAssignCourseignCourse">-->
<!--                        <option value=''>------- Select --------</option>-->
<!--                        <option value='2015/2016'>2015/2016</option>-->
<!--                        <option value='2016/2017'>2016/2017</option>-->
<!--                        <option value='2017/2018'>2017/2018</option>-->
<!--                        <option value='2018/2019'>2018/2019</option>-->
<!--                        <option value='2019/2020'>2019/2020</option>-->
<!--                    </select>-->


                    <label for="semesterYearAssignCourse">Semester</label>
                    <select class="g" id="semesterYearAssignCourse" name="semesterYearAssignCourse">
                        <option value=0>------- Select --------</option>
                        <option value="01">1st Semester</option>
                        <option value="02">2nd Semester</option>
                    </select>

                </div>
            </div>

            <div class="form-row">
                <div class="form-row">

                    <label for="courseSemesterYearAssignCourse">Course</label> <select
                            name="courseSemesterYearAssignCourse" id="courseSemesterYearAssignCourse">
                        <option>------- Select --------</option>
                    </select>


                    <label for="studentAssignCourse">Student</label>
                    <select class="g" id="studentAssignCourse" name="studentAssignCourse">
                        <option value=''>------- Select --------</option>
                        <!-- Using SQL to populate dropdown list of students -->
						<?php if ($resultStudent->num_rows > 0) {
							while ($row = $resultStudent->fetch_assoc()) {
								?>
                                <option
                                value= <?php echo $row["studentID"] ?> ><?php echo $row["studentID"] . " - "
									. $row["firstName"] . " " . $row["lastName"]; ?></option><?php
							}
						} else {
							echo "<option>No Students</option>";
						}
						?>
                    </select>


                </div>

                <div class="col-md-12">
                    <input type="submit" name="register" value="Register Student in Course">
                </div>
        </fieldset>
    </form>
</div>
</body>
</html>
<?php
}
?>
