<?php
/**
 * Created by PhpStorm.
 * STARS Beta Version 1.0
 * Company: Team Talent 2.0
 * Members: John, Rodrigo, Sara, Steve
 * Date: 2/14/2019
 *
 * Page which confirms the database update query and handles errors for the user. Also handles refreshes and redirects.
 *
 * Required pages: stars.css, login.php, checkLoggedIn.php, autheticateAdminPages.php, searchStudent.php, editStudent.php.
 */
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Fonts !-->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Roboto" rel="stylesheet">

    <!-- JQuery Links !-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- JQuery Calendar Date Picker !-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Here is where we call bootstrap. !-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!--Link to custom style sheet-->
    <link href="../../css/stars.css" rel="stylesheet">

    <script src="../../js/main.js"></script>

    <!-- function to go back to your incomplete form without losing previously filled fields-->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <title>STARS - Confirm Edit Student</title>
</head>
<?php
/**
 * Created by PhpStorm.
 * Company: Team Talent 2.0
 * Members: John, Rodrigo, Sara, Steve
 * Date: 2/14/2019
 *
 * Page which confirms the database update query and handles errors for the user. Also handles refreshes and redirects.
 *
 * Required pages: stars.css, login.php, checkLoggedIn.php, autheticateAdminPages.php, searchStudent.php, editStudent.php.
 */


//Lock down page
include "../login/checkLoggedIn.php";

//Admin only
include "../login/authenticateAdminPages.php";

//Database connection
include "../db/dbConn.php";

//Button class
include "../button.class.php";
//Header file
include "../../header.php";


if (isset($_POST["updateStudent"])) {

	if ($_POST["firstName"] == "" || $_POST["middleName"] == "" || $_POST["lastName"] == "" ||
		$_POST["gender"] == "" || $_POST["dob"] == "" || $_POST["address"] == "" || $_POST["phoneNum"] == "" ||
		$_POST["emailAddress"] == "" || strlen($_POST["phoneNum"]) < 10 || strlen($_POST["phoneNum"]) > 10 ||
		strlen($_POST["dob"]) < 10 || strlen($_POST["dob"]) > 10) {

		$msg = "<br><div class='alert alert-danger'>Student could not be updated. Please make sure all fields are filled before updating.</div>";

	} else {

		$studentIDFromForm = $_GET["studentID"];

//Compiling and cleaning user inputs
		$firstNameFromForm = $database->real_escape_string($_POST["firstName"]);
		$middleNameFromForm = $database->real_escape_string($_POST["middleName"]);
		$lastNameFromForm = $database->real_escape_string($_POST["lastName"]);
		$genderFromForm = $database->real_escape_string($_POST["gender"]);
		$dobFromForm = $database->real_escape_string($_POST["dob"]);
		$gradeFromForm = $database->real_escape_string($_POST["grade"]);
		$addressFromForm = $database->real_escape_string($_POST["address"]);
		$phoneNumberFromForm = $database->real_escape_string($_POST["phoneNum"]);
		$emailAddressFromForm = $database->real_escape_string($_POST["emailAddress"]);
		$allergiesFromForm = $database->real_escape_string($_POST["allergies"]);
		$schoolIDFromForm = $database->real_escape_string($_POST["selectSchool"]);
		$parentGuardianIDFromForm = $database->real_escape_string($_POST["selectParentGuardian"]);

		$updateStudentQuery = "UPDATE student SET firstName = '$firstNameFromForm', middleName = '$middleNameFromForm', 
                           lastName = '$lastNameFromForm', gender = '$genderFromForm', dob = '$dobFromForm', grade = '$gradeFromForm',
                           address = '$addressFromForm', phoneNum = '$phoneNumberFromForm', emailAddress = '$emailAddressFromForm',
                           allergies = '$allergiesFromForm', schoolID = $schoolIDFromForm, guardianID = $parentGuardianIDFromForm 
                           WHERE studentID = $studentIDFromForm;";

		$resultSetFromUpdateStudent = $database->query($updateStudentQuery);

		if ($resultSetFromUpdateStudent == 1) {

			$msg = "<br><div class='alert alert-info'>$firstNameFromForm, Student ID $studentIDFromForm, has been successfully updated in STARS. 
                        You will be automatically redirected to the Search Student page momentarily.</div><br>";

			header("Refresh:5; searchStudent.php", true, 303);

		} else {

			$msg = "<br><div class='alert alert-danger'>Sorry, student $studentIDFromForm could not be updated to the database at this time</div><br>";

			header("Refresh:5; javascript:history.back(-1)", true, 303);

		}

	}
}
?>

<body>
<div class="jumbotron-fluid">
    <div class="container-fluid">
        <div class="container"><?php if (isset($msg)) {
				echo $msg;
			}
			//Back Button
			$goBack = new Button();
			$goBack->buttonName = "goBack";
			$goBack->buttonID = "goBack";
			$goBack->buttonValue = "Go Back";
			$goBack->buttonStyle = "font-family:sans-serif";
			$goBack->buttonWeb = "javascript:history.back(-1);";
			$goBack->display(); ?></div>

    </div>
</div>
<div class="bottom">
    <div id="footer">
		<?php include("../../navMenu.php"); ?>
    </div>
</div>
</body>
</html>
<?php

//Closing Database connection
$database->close();

?>

