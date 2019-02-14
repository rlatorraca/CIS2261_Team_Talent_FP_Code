<?php
/**
 * Created by PhpStorm
 * Edited by: John Gaudet
 * Date: 2019-01-27
 * Time: 8:49 PM
 *
 * 2019/01/28: Functionality mostly there. Able to pull user ID from prior screen but cannot use to insert into database.
 *
 * Changed functionality approach to use username instead of userID
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Ensure only admin/system admin staff can view this page.
include "../login/authenticateAdminPages.php";

//Database connection
include "../db/dbConn.php";

//Button class
include "../button.class.php";
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
            <link rel="stylesheet" href="/resources/demos/style.css">
            <!-- JQuery Calendar Date Picker !-->
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            <!-- Here is where we call bootstrap. !-->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                    crossorigin="anonymous"></script>

            <!--Link to custom style sheet-->
            <link href="../../css/stars.css" rel="stylesheet">

            <script src="../../js/main.js"></script>

            <!--           function to go back to your incomplete form without losing previously filled fields-->

            <script>
                function goBack() {
                    window.history.back();
                }
            </script>

            <title>STARS - Confirm Student</title>
        </head>
        <body>
            <?php include "../../header.php"; ?>
            <div class="jumbotron-fluid">
                <div class="container-fluid">
                    <?php

                    //Get and Sanitize user inputs to prepare for database insert query.
                    //$studentID = $database->real_escape_string($_POST["studentID"]);
                    $firstName = $database->real_escape_string($_POST["firstName"]);
                    $middleName = $database->real_escape_string($_POST["middleName"]);
                    $lastName = $database->real_escape_string($_POST["lastName"]);
                    $gender = $database->real_escape_string($_POST["gender"]);
                    $dob = $database->real_escape_string($_POST["dob"]);
                    $grade = $database->real_escape_string($_POST["grade"]);
                    $address = $database->real_escape_string($_POST["address"]);
                    $phoneNum = $database->real_escape_string($_POST["phoneNum"]);
                    $emailAddress = $database->real_escape_string($_POST["emailAddress"]);
                    $allergies = $database->real_escape_string($_POST["allergies"]);
                    $schoolID = $database->real_escape_string($_POST["selectSchool"]);
                    $guardianID = $database->real_escape_string($_POST["selectParentGuardian"]);
                    $supportEducatorID = $database->real_escape_string($_POST["selectSupportEducator"]);

                    //To trigger when user submits request to add new Student to stars database
                    //if (isset($_POST["register"])) {

                    //If details are empty, display a message and show redirect buttons. Otherwise, proceed.
                    if (($firstName == "") || ($middleName == "") || ($lastName == "") || ($dob == "") || ($address == "") || ($phoneNum == "") || ($emailAddress == "")) {
                        echo "<br><div class='alert-danger'>";
                        echo "<br><h4>Sorry, looks like you missed a required field.  Try again.</h4><br><br></div><br>";

//                        $msg = "Form fields must not be empty before registering new student in STARS.";
//                        echo "<br><div class='alert alert-danger' style='color: red'><h4>$msg</h4></div><br><br>";

                        //Back Button
                        $goBack = new Button();
                        $goBack->buttonName = "goBack";
                        $goBack->buttonID = "goBack";
                        $goBack->buttonValue = "Go Back";
                        $goBack->buttonStyle = "font-family:sans-serif";
                        $goBack->buttonWeb = "javascript:history.back(-1);";
                        $goBack->display();

                        //Home Button
                        $homeBtn = new Button();
                        $homeBtn->buttonName = "returnHome";
                        $homeBtn->buttonID = "returnHome";
                        $homeBtn->buttonValue = "Return Home";
                        $homeBtn->buttonStyle = "font-family:sans-serif";
                        $homeBtn->buttonWeb = 'location.href = "../../index.php"';
                        $homeBtn->display();
                      echo "</div></div>
    <div class='bottom'>
        <div id='footer'>";
              include '../../navMenu.php'; ?>
<?php exit("
        </div>
    </div>

        </body>
    </html>");
                         }

                    echo "<div class='alert alert-info'>
                    <h2>You have entered the following student details:</h2>
                    <h4>Name:</h4><p style='display: inline'> " . $firstName . " " . $middleName . " " . $lastName . "</p><br>
                    <h4>Gender: </h4><p style='display: inline'>" . $gender . "</p><br>
                    <h4>" . "Date of Birth: </h4><p style='display: inline'>" . $dob . "</p><br>
                    <h4>" . "Grade: </h4><p style='display: inline'>" . $grade . "</p><br>
                    <h4>" . "Address: </h4><p style='display: inline'>" . $address . "</p><br>
                    <h4>" . "Phone Number: </h4><p style='display: inline'>" . $phoneNum . "</p><br>
                    <h4>" . "Email: </h4><p style='display: inline'>" . $emailAddress . "</p><br>
                    <h4>" . "Username: </h4><p style='display: inline'>" . $_SESSION['username'] . "</p></div>";
                    ?>

                    <form action="insertStudent.php" method="post">
                        <input name="firstName" hidden value="<?php echo $firstName; ?>">
                        <input name="middleName" hidden value="<?php echo $middleName; ?>">
                        <input name="lastName" hidden value="<?php echo $lastName; ?>">
                        <input name="gender" hidden value="<?php echo $gender; ?>">
                        <input name="dob" hidden value="<?php echo $dob; ?>">
                        <input name="grade" hidden value="<?php echo $grade; ?>">
                        <input name="address" hidden value="<?php echo $address; ?>">
                        <input name="phoneNum" hidden value="<?php echo $phoneNum; ?>">
                        <input name="emailAddress" hidden value="<?php echo $emailAddress; ?>">
                        <input name="allergies" hidden value="<?php echo $allergies; ?>">
                        <input name="schoolID" hidden value="<?php echo $schoolID; ?>">
                        <input name="guardianID" hidden value="<?php echo $guardianID; ?>">
                        <input name="username" hidden value="<?php echo $_SESSION["username"]; ?>">
                        <input name="supportEducatorID" hidden value="<?php echo $supportEducatorID; ?>">
                        <?php
                        //Confirm Button
                        $confirm = new Button();

                        $confirm->buttonName = "register";
                        $confirm->buttonID = "register";
                        $confirm->buttonValue = "Register Student";
                        $confirm->buttonStyle = "font-family:sans-serif";
                        $confirm->display(); ?>
                    </form>
                    <?php
                    //Back Button
                    $goBack = new Button();

                    $goBack->buttonName = "goBack";
                    $goBack->buttonID = "goBack";
                    $goBack->buttonValue = "Go Back";
                    $goBack->buttonStyle = "font-family:sans-serif";
                    //Back button works. Does not use the main.js file however.
                    $goBack->buttonWeb = "javascript:history.back(-1);";
                    $goBack->display(); ?>
                </div>
            </div>
            <div class='bottom'>
                <div id='footer'>
                    <?php include('../../navMenu.php'); ?>
                </div>
            </div>
        </body>
    </html>
<?php

//$usernameFromForm = $database->real_escape_string($_SESSION["username"]);
//
//$supportEducatorID = $database->real_escape_string($_POST["selectSupportEducator"]);
//
////Query database to get the User ID based on entered username
//$queryUsername = "SELECT userID FROM user WHERE username = '$usernameFromForm' LIMIT 1";
//
//$resultUsernameFromQuery = $database->query($queryUsername);
//$userID = "";
//
//if ($resultUsernameFromQuery->num_rows > 0) {
//
//    while ($resultSet = $resultUsernameFromQuery->fetch_assoc()) {
//
//        //Get userID from result set and apply to a variable to use in the following insert query.
//        $userID = $resultSet["userID"];
//
//    }
//}
//
////To trigger when user submits request to add new Student to stars databas
//if (isset($_POST["register"])) {
//    //Create initial SQL query to insert form data into database
//    $query = "INSERT INTO student(firstName, middleName, lastName, gender, dob, grade, address,
//                  phoneNum, emailAddress, allergies, schoolID, guardianID, userID, supportEducatorID)
//                  VALUES ('$firstName', '$middleName', '$lastName', '$gender', '$dob', '$grade', '$address',
//                  '$phoneNum', '$emailAddress', '$allergies', $schoolID, $guardianID, $userID, $supportEducatorID);";
//
//    //Execute query and store result.
//    $result = $database->query($query);
//
//    //Check if query executed successfully and that the result contains data.
//    if ($result) {
//
//        echo "<h2>Student has been successfully added to the database</h2><br>";
//
//    } else {
//        echo "<h2>Sorry, student could not be added to the database at this time</h2><br>";
//    }
//}
////Close database connection
//$database->close();


//    else {
//
//    //Pull username from previous setup for add user in order to populate user ID field for student
//    $usernameFromAddUserScreen = $_GET["username"];
//    $_SESSION['usernameFromAddUser'] = $usernameFromAddUserScreen;
//
//}