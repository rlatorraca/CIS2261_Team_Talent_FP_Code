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

            <!--Link to custom style sheet-->
            <link href="../../css/stars.css" rel="stylesheet">

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

            <script src="../../js/main.js"></script>

            <!--            <!--function to go back to your incomplete form without losing previously filled fields-->
            -->
            <!--            <script>-->
            <!--                function goBack() {-->
            <!--                    window.history.back();-->
            <!--                }-->
            <!--            </script>-->


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
                        //$username = $database->real_escape_string($_POST["username"]);
                        $supportEducatorID = $database->real_escape_string($_POST["selectSupportEducator"]);

                        //To trigger when user submits request to add new Student to stars database
                        //if (isset($_POST["register"])) {

                        //If details are empty, display a message and give redirect links. Otherwise, proceed.
                        if ($_POST["firstName"] == "" || $_POST["middleName"] == "" || $_POST["lastName"] == "") {
                            echo "<h2>Error</h2><p> Form fields must not be empty before registering new student in STARS.</p><br>";
                            echo "<div class='col-md-12'><button class='btn btn-primary' onclick='goBack()'>Go Back</button>";
                            echo "<form action='../../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
                            exit("        </div>
    </div>
    <div class='bottom'>
        <div id='footer'>
            <?php include('navMenu.php'); ?>
        </div>
    </div>
        </body>
    </html>");
                        }

                        echo "<p>You have entered the following student details:</p><p>Name: " . $firstName . " " . $middleName . " " . $lastName
                            . "</p><p>Gender: " . $gender . "</p><p>" . "Date of Birth: " . $dob . "</p><p>" . "Address: $address" . "</p><p>" . "Phone Number: " . $phoneNum .
                            "</p><p>" . "Email: " . $emailAddress . "</p><p>" . "Grade: " . $grade . "</p>";
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

                        <input type="submit" name="register" value="Register Student">
                    </form>
                    <?php echo "<div class='col-md-12'><button class='btn btn-primary' onclick='goBack()'>Go Back</button>"; ?>
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