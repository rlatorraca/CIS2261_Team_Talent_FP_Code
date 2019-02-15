<?php
/**
 * Created by PhpStorm.
 * Company: Team Talent 2.0
 * Members: John, Rodrigo, Sara, Steve
 * Date: 2/14/2019
 *
 * Page to edit a student's details. User is directed to this page from the search results of students when they wish to edit a student.
 *
 * Required pages: stars.css, login.php, checkLoggedIn.php, dbConn.php, searchStudents.php, addUser.php, addStudent.php, confirmStudent.php, insertStudent.php
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Admin only
include "../login/authenticateAdminPages.php";

//Database connection
include "../db/dbConn.php";

//Button class
include "../button.class.php";

//Header
include "../../header.php";
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
    <title>STARS - Edit Student</title>
</head>
<?php
//Get studentID from list page of students from search page.
$studentID = $_GET["studentID"];

$queryStudent = "SELECT * FROM student WHERE studentID = $studentID;";

$resultSetFromQueryStudent = $database->query($queryStudent);

//Get query results
if ($resultSetFromQueryStudent->num_rows == 1) {

    while ($row = $resultSetFromQueryStudent->fetch_assoc()) {

        $firstName = $row["firstName"];
        $middleName = $row["middleName"];
        $lastName = $row["lastName"];
        $gender = $row["gender"];
        $dob = $row["dob"];
        $grade = $row["grade"];
        $address = $row["address"];
        $phoneNumber = $row["phoneNum"];
        $emailAddress = $row["emailAddress"];
        $allergies = $row["allergies"];
    }
}

?>
<body>
<div class="jumbotron-fluid">
    <div class="container-fluid">
        <form action="confirmEditStudent.php?studentID='<?php echo $studentID; ?>'" method="post">
            <h2>Student Details</h2>
            <p><span style="color:red">*Please ensure all fields are filled</span></p>
            <div class="row">
                <div class="col-sm-6">
                    <label for="studentID">Student ID</label>
                    <input type="text" name="studentID" class="form-control"
                           value="<?php echo $studentID; ?>" readonly>
                </div>
                <div class="col-sm-6">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstName" class="form-control"
                           value="<?php echo $firstName; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <label for="middlename">Middle Name</label>
                    <input type="text" name="middleName" class="form-control"
                           value="<?php echo $middleName; ?>">
                </div>
                <div class="col-sm-6">
                    <label for="title">Last Name</label>
                    <input type="text" name="lastName" class="form-control"
                           value="<?php echo $lastName; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <label for="title">Gender</label>
                    <input type="text" name="gender" class="form-control"
                           value="<?php echo $gender; ?>">
                </div>

                <!-- Add proper date picker to allow for a date in proper format to be selected-->
                <div class="col-sm-6">
                    <label for="title">Date of Birth</label>
                    <input type="text" id="datepicker" class="form-control" name="dob"
                           value="<?php echo $dob; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <label for="title">Grade</label>
                    <select name="grade" class="form-control">
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="title">Address</label>
                    <input type="text" name="address" class="form-control"
                           value="<?php echo $address; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <label for="title">Phone Number</label>
                    <input type="text" name="phoneNum" class="form-control"
                           value="<?php echo $phoneNumber; ?>">
                </div>
                <div class="col-sm-6">
                    <label for="title">Email Address</label>
                    <input type="text" name="emailAddress" class="form-control"
                           value="<?php echo $emailAddress; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <label for="title">Allergies</label>
                    <input type="text" name="allergies" class="form-control"
                           value="<?php echo $allergies; ?>">
                </div>
                <div class="col-sm-6">
                    <label for="selectSchool">School</label>
                    <select name="selectSchool" class="form-control">
                        <?php
                        //Needs work done
                        $querySchools = "SELECT schoolID, name FROM school";
                        $resultFromSchoolQuery = $database->query($querySchools);
                        if ($resultFromSchoolQuery->num_rows > 0) {
                            while ($schoolResults = $resultFromSchoolQuery->fetch_assoc()) {
                                ?>
                                <option
                                value="<?php echo $schoolResults["schoolID"]; ?>"><?php echo $schoolResults["name"]; ?></option><?php
                            }
                        } else {
                            echo "<option>There are no Schools registered in STARS</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <label for="selectParentGuardian">Parent/Guardian</label>
                    <select name="selectParentGuardian" class="form-control">
                        <option value=NULL>None</option>
                        <?php
                        //Currently working on this here (to also handle if the student has no parent/guardian listed).
                        //Returns current parent or guardian of the student.
                        $queryParentGuardians = "SELECT parentorguardian.guardianID, parentFName, parentLName FROM parentorguardian;";
                        $resultsFromParentGuardian = $database->query($queryParentGuardians);
                        if ($resultsFromParentGuardian->num_rows > 0) {
                            while ($parentGuardianResultSet = $resultsFromParentGuardian->fetch_assoc()) {
                                ?>
                            <option value="<?php echo $parentGuardianResultSet["guardianID"]; ?>">
                                <?php echo $parentGuardianResultSet["parentFName"] . " "
                                    . $parentGuardianResultSet["parentLName"]; ?></option><?php
                            }
                        } else {
                            echo "<option>There are no Parent/Guardians registered in STARS</option>";
                        }
                        //Get current student's parent/guardian
                        //SELECT parentorguardian.guardianID, parentFName, parentLName FROM parentorguardian, student WHERE
                        //student.studentID = $studentID AND student.guardianID = parentorguardian.guardianID;
                        ?>
                    </select>
                </div>
                <br>
                <div class="col-sm-6">
                    <?php
                    //Confirm button to send data to confirmEditStudent.php page
                    $confirm = new Button();

                    $confirm->buttonName = "updateStudent";
                    $confirm->buttonID = "updateStudent";
                    $confirm->buttonValue = "Edit Student";
                    $confirm->buttonStyle = "font-family:sans-serif";
                    $confirm->display(); ?>
                </div>
            </div>
        </form>
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

//Close db connection
$database->close();

?>

