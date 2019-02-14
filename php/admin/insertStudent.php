<?php
    /**
     * Created by PhpStorm.
     * User: jgaudet109873
     * Date: 2/5/2019
     * Time: 5:02 PM
     */

    //Lock down page
    include "../login/checkLoggedIn.php";

    //Ensure only admin/system admin staff can view this page.
    include "../login/authenticateAdminPages.php";

    //Database connection
    include "../db/dbConn.php";

    //Button Class
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

        <!-- Here is where we call bootstrap. !-->
        <title>STARS - Insert Student into Database</title>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!-- Calendar Date Picker !-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="../../js/main.js"></script>

        <link href="../../css/stars.css" rel="stylesheet">
        <script src="../../js/main.js"></script>
    </head>
    <body>
        <?php
            include "../../header.php"; ?>
        <div class="jumbotron-fluid">
            <div class="container-fluid container-sizer">
                <?php
                    //$usernameFromForm = $database->real_escape_string($_SESSION["username"]);
                    $usernameFromSession = $_SESSION["username"];

                    //Query database to get the User ID based on entered username
                    $queryUsername = "SELECT userID FROM user WHERE username = '$usernameFromSession' LIMIT 1";

                    $resultUsernameFromQuery = $database->query($queryUsername);
                    $userID = "";

                    if ($resultUsernameFromQuery) {

                        while ($resultSet = $resultUsernameFromQuery->fetch_assoc()) {

                            //Get userID from result set and apply to a variable to use in the following insert query.
                            $userID = $resultSet["userID"];

                        }
                    }
                    //Get and Sanitize user inputs to prepare for database insert query.
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
                    $schoolID = $database->real_escape_string($_POST["schoolID"]);
                    $guardianID = $database->real_escape_string($_POST["guardianID"]);
                    $supportEducatorID = $database->real_escape_string($_POST["supportEducatorID"]);

                    //To trigger when user submits request to add new Student to stars database

                    //Create initial SQL query to insert form data into database
                    $query = "INSERT INTO student(firstName, middleName, lastName, gender, dob, grade, address,
                  phoneNum, emailAddress, allergies, schoolID, guardianID, userID, supportEducatorID)
                  VALUES ('$firstName', '$middleName', '$lastName', '$gender', '$dob', '$grade', '$address',
                  '$phoneNum', '$emailAddress', '$allergies', $schoolID, $guardianID, $userID, $supportEducatorID);";

                    //Execute query and store result.
                    $result = $database->query($query);

                    //Check if query executed successfully and that the result contains data.
                    if ($result) {

                        $msg = "<br><h2>Success</h2><p>User has successfully been added to the database</p><br><br>";

                    } else {

                        $msg = "<br><div class='alert alert-danger'><h4>Sorry, student could not be added to the database at this time</h4></div>";

                    }

                    //Close database connection
                    $database->close();

                    //Clear username session variable
                    $_SESSION["username"] = "";

                    if (isset($msg)) {

                        echo $msg;

                        //Add new User Button
                        $addUser = new Button();

                        $addUser->buttonName = "addUser";
                        $addUser->buttonID = "addUser";
                        $addUser->buttonValue = "Add another User";
                        $addUser->buttonStyle = "font-family:sans-serif";
                        //Back button works. Does not use the main.js file however.
                        $addUser->buttonWeb = 'location.href = "addUser.php"';
                        $addUser->display();

                    }
                ?>
            </div>
        </div>
        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
    </body>
</html>
