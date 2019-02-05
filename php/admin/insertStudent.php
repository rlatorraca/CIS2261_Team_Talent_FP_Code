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

//$usernameFromForm = $database->real_escape_string($_SESSION["username"]);
$usernameFromSession = $_SESSION["username"];

//Query database to get the User ID based on entered username
$queryUsername = "SELECT userID FROM user WHERE username = '$usernameFromSession' LIMIT 1";

$resultUsernameFromQuery = $database->query($queryUsername);
$userID = "";

if ($resultUsernameFromQuery->num_rows > 0) {

    while ($resultSet = $resultUsernameFromQuery->fetch_assoc()) {

        //Get userID from result set and apply to a variable to use in the following insert query.
        $userID = $resultSet["userID"];

    }
}

$firstName = $_POST["firstName"];
$middleName = $_POST["middleName"];
$lastName = $_POST["lastName"];
$gender = $_POST["gender"];
$dob = $_POST["dob"];
$grade = $_POST["grade"];
$address = $_POST["address"];
$phoneNum = $_POST["phoneNum"];
$emailAddress = $_POST["emailAddress"];
$allergies = $_POST["allergies"];
$schoolID = $_POST["schoolID"];
$guardianID = $_POST["guardianID"];
$supportEducatorID = $_POST["supportEducatorID"];

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

    echo "<h2>Student has been successfully added to the database</h2><br>";

} else {
    echo "<h2>Sorry, student could not be added to the database at this time</h2><br>";
}

//Clear username session variable
$_SESSION["username"] = "";

//Close database connection
$database->close();


?>
