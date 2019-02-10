<?php
    /**
     * Created by PhpStorm.
     * User: sahra
     * Date: 2019-01-27
     * Time: 8:49 PM
     */

    //Lock down page
    include "../login/checkLoggedIn.php";

    //Database connection
    include "../db/dbConn.php";

    //Button class
    include "../button.class.php";

    if (isset($_POST["updateStudent"])) {

        $msg = "";
        $studentID = $_SESSION["studentID"];

        //Data Validation before database insertion.
        if ($_POST["firstName"] == "" || $_POST["middleName"] == "" || $_POST["lastName"] == "" ||
            $_POST["gender"] == "" || $_POST["dob"] == "" || $_POST["address"] == "" || $_POST["phoneNum"] == "" ||
            $_POST["emailAddress"] == "" || strlen($_POST["phoneNum"]) < 10 || strlen($_POST["phoneNum"]) > 10 ||
            strlen($_POST["dob"]) < 10 || strlen($_POST["dob"]) > 10) {

            $msg = "Student could not be updated. Please make sure all fields are filled before updating.";

        } else {

            $firstNameFromForm = $_POST["firstName"];
            $middleNameFromForm = $_POST["middleName"];
            $lastNameFromForm = $_POST["lastName"];
            $genderFromForm = $_POST["gender"];
            $dobFromForm = $_POST["dob"];
            $gradeFromForm = $_POST["grade"];
            $addressFromForm = $_POST["address"];
            $phoneNumberFromForm = $_POST["phoneNum"];
            $emailAddressFromForm = $_POST["emailAddress"];
            $allergiesFromForm = $_POST["allergies"];
            $schoolIDFromForm = $_POST["selectSchool"];
            $parentGuardianIDFromForm = $_POST["selectParentGuardian"];

            $updateStudentQuery = "UPDATE student SET firstName = '$firstNameFromForm', middleName = '$middleNameFromForm', 
                           lastName = '$lastNameFromForm', gender = '$genderFromForm', dob = '$dobFromForm', grade = '$gradeFromForm',
                           address = '$addressFromForm', phoneNum = '$phoneNumberFromForm', emailAddress = '$emailAddressFromForm',
                           allergies = '$allergiesFromForm', schoolID = $schoolIDFromForm, guardianID = $parentGuardianIDFromForm 
                           WHERE studentID = $studentID;";

            $resultSetFromUpdateStudent = $database->query($updateStudentQuery);

            if ($resultSetFromUpdateStudent == 1) {

                $msg = "<h2>Student $studentID has been successfully updated in STARS.</h2><br>";

            } else {

                $msg = "<h2>Sorry, student $studentID could not be updated to the database at this time</h2><br>";

            }
        }

    } else {

        //Get studentID from list page of students from search page.
        $_SESSION["studentID"] = $_GET["studentID"];
        $studentID = $_SESSION["studentID"];

        $queryStudent = "SELECT * FROM student WHERE studentID = $studentID;";

        $resultSetFromQueryStudent = $database->query($queryStudent);

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

                <!--                <!--function to go back to your incomplete form without losing previously filled fields-->
                -->
                <!--                <script>-->
                <!--                    function goBack() {-->
                <!--                        window.history.back();-->
                <!--                    }-->
                <!---->
                <!--                    // This function shows the date picker.-->
                <!--                    $(function () {-->
                <!--                        $("#datepicker").datepicker();-->
                <!--                    });-->
                <!---->
                <!--                    // This function shows the note.-->
                <!--                    // Will need to add a variable to get the notes to then call.-->
                <!--                    $(function () {-->
                <!--                        $(document).tooltip();-->
                <!--                    });-->
                <!---->
                <!--                    // This function manages the drop downs on the main menu.-->
                <!--                    $(function () {-->
                <!--                        $("#menu").menu();-->
                <!--                    });-->
                <!--                </script>-->
                <title>STARS - Edit Student</title>
            </head>
            <body>
                <?php include "../../header.php"; ?>
                <div class="jumbotron-fluid">
                    <div class="container-fluid">
                        <form action="editStudent.php" method="post">
                            <h2>Student Details</h2>
                            <p>**Please ensure all fields are filled before editing a Student's details.</p>
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="title">Gender</label>
                                    <input type="text" name="gender" class="form-control"
                                           value="<?php echo $gender; ?>">
                                </div>
                                <!-- Add proper date picker to allow for a date in proper format to be selected-->
                                <div class="col-sm-6">
                                    <label for="title">Date of Birth</label>
                                    <input type="text" name="dob" class="form-control"
                                           value="<?php echo $dob; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="title">Grade</label>
                                    <select name="grade">
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="title">Allergies</label>
                                    <input type="text" name="allergies" class="form-control"
                                           value="<?php echo $allergies; ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="selectSchool">School</label>
                                    <select name="selectSchool">
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="selectParentGuardian">Parent/Guardian</label>
                                    <select name="selectParentGuardian">
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
                            </div>
                            <div class="col-3">
                                <!-- <input type="submit" id="btn" name="submitUpdateRecord" class="btn btn-info text-center" value="submitUpdateRecord">-->
                                <button type="submit" id="updateStudent" name="updateStudent">Update Student</button>
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
    }

    if (isset($msg)) {
        echo "<div class='alert alert-danger'>$msg</div>";

        $goBack = new Button();

        $goBack->buttonName = "goBack";
        $goBack->buttonID = "goBack";
        $goBack->buttonValue = "Go Back";
        $goBack->buttonStyle = "font-family:sans-serif";
        $goBack->buttonWeb = 'goBack()';
        $goBack->display();

        //echo "<div class='col-md-12'><button class='btn btn-primary' onclick='goBack()'>Go Back</divbutton></div>";
    }

    //Close db connection
    $database->close();
?>

