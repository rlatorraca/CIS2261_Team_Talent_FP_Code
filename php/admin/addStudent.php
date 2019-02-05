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

include("../button.class.php");
$confirm = new Button();
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
    <link href="css/stars.css" rel="stylesheet">

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

    <!--function to go back to your incomplete form without losing previously filled fields-->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <title>STARS - Add Student</title>
</head>
<body>
<div>
    <!--            --><?php
    //
    //                //To trigger when user submits request to add new Student to stars database
    //                if (isset($_POST["register"])) {
    //
    //                //If details are empty, display a message and give redirect links. Otherwise, proceed.
    //                if ($_POST["firstName"] == "" || $_POST["middleName"] == "" || $_POST["lastName"] == "") {
    //                    echo "<h2>Error. Form fields must not be empty before registering new student in STARS.</h2><br>";
    //                    echo "<div class='col-md-12'><button class='btn btn-primary' onclick='goBack()'>Go Back</button>";
    //                    echo "<form action='../../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
    //                    exit("</div></body</html>");
    //                }
    //
    //                //Sanitize user inputs to prepare for database insert query.
    //                $studentID = $database->real_escape_string($_POST["studentID"]);
    //                $firstName = $database->real_escape_string($_POST["firstName"]);
    //                $middleName = $database->real_escape_string($_POST["middleName"]);
    //                $lastName = $database->real_escape_string($_POST["lastName"]);
    //                $gender = $database->real_escape_string($_POST["gender"]);
    //                $dob = $database->real_escape_string($_POST["dob"]);
    //                $grade = $database->real_escape_string($_POST["grade"]);
    //                $address = $database->real_escape_string($_POST["address"]);
    //                $phoneNum = $database->real_escape_string($_POST["phoneNum"]);
    //                $emailAddress = $database->real_escape_string($_POST["emailAddress"]);
    //                $allergies = $database->real_escape_string($_POST["allergies"]);
    //                $schoolID = $database->real_escape_string($_POST["selectSchool"]);
    //                $guardianID = $database->real_escape_string($_POST["selectParentGuardian"]);
    //
    //                $usernameFromForm = $database->real_escape_string($_SESSION["username"]);
    //
    //                $supportEducatorID = $database->real_escape_string($_POST["selectSupportEducator"]);
    //
    //                //Query database to get the User ID based on entered username
    //                $queryUsername = "SELECT userID FROM user WHERE username = '$usernameFromForm' LIMIT 1";
    //
    //                $resultUsernameFromQuery = $database->query($queryUsername);
    //                $userID = "";
    //
    //                if ($resultUsernameFromQuery->num_rows > 0) {
    //
    //                    while ($resultSet = $resultUsernameFromQuery->fetch_assoc()) {
    //
    //                        //Get userID from result set and apply to a variable to use in the following insert query.
    //                        $userID = $resultSet["userID"];
    //
    //                    }
    //                }
    //
    //                //Create initial SQL query to insert form data into database
    //                $query = "INSERT INTO student(firstName, middleName, lastName, gender, dob, grade, address,
    //                  phoneNum, emailAddress, allergies, schoolID, guardianID, userID, supportEducatorID)
    //                  VALUES ('$firstName', '$middleName', '$lastName', '$gender', '$dob', '$grade', '$address',
    //                  '$phoneNum', '$emailAddress', '$allergies', $schoolID, $guardianID, $userID, $supportEducatorID);";
    //
    //                //Execute query and store result.
    //                $result = $database->query($query);
    //
    //                //Check if query executed successfully and that the result contains data.
    //                if ($result) {
    //
    //                    echo "<h2>Student has been successfully added to the database</h2><br>";
    //
    //                } else {
    //                    echo "<h2>Sorry, student could not be added to the database at this time</h2><br>";
    //                }
    //
    //                //Close database connection
    //                $database->close();
    //
    //            } else {
    //
    //                //Pull username from previous setup for add user in order to populate user ID field for student
    //                $usernameFromAddUserScreen = $_GET["username"];
    //                $_SESSION['usernameFromAddUser'] = $usernameFromAddUserScreen;
    //
    //            ?>

    <p>**Please ensure all fields are filled before registering a new Student.</p>
    <form action="confirmStudent.php" method="post">
        <fieldset>
            <legend>Student Details</legend>
            <div class="col-md-12 form-inline customDiv">
                <label for="isbn" class="col-md-6">Student ID</label>
                <input type="text" name="studentID" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="author" class="col-md-6">First Name</label>
                <input type="text" name="firstName" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Middle Name</label>
                <input type="text" name="middleName" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Last Name</label>
                <input type="text" name="lastName" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Gender</label>
                <input type="text" name="gender" class="col-md-6 form-control">
            </div>
            <!-- Add proper date picker to allow for a date in proper format to be selected-->
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Date of Birth</label>
                <input type="text" name="dob" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Grade</label>
                <select name="grade">
                    <option name="10">10</option>
                    <option name="11">11</option>
                    <option name="12">12</option>
                </select>
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Address</label>
                <input type="text" name="address" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Phone Number</label>
                <input type="text" name="phoneNum" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Email Address</label>
                <input type="text" name="emailAddress" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Allergies</label>
                <input type="text" name="allergies" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">School</label>
                <select name="selectSchool">
                    <?php
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
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Parent/Guardian</label>
                <select name="selectParentGuardian">
                    <option value=NULL>None</option>
                    <?php
                    $queryParentGuardians = "SELECT guardianID, parentFName, parentLName FROM parentorguardian";
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
                    ?>
                </select>
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Username</label>
                <input type="text" name="username" class="col-md-6 form-control value="
                       value="<?php echo $_SESSION['username'] ?>" readonly>

            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Support Educator</label>
                <select name="selectSupportEducator">
                    <option value=NULL>None</option>
                    <?php
                    $querySupportEducators = "SELECT supportEducatorID, supFName, supLName FROM supporteducator";
                    $resultsSupportEducators = $database->query($querySupportEducators);
                    if ($resultsSupportEducators->num_rows > 0) {
                        while ($supportEducatorResultSet = $resultsSupportEducators->fetch_assoc()) {
                            ?>
                        <option value="<?php echo $supportEducatorResultSet["supportEducatorID"] ?>">
                            <?php echo $supportEducatorResultSet["supFName"] . " "
                                . $supportEducatorResultSet["supLName"]; ?></option><?php
                        }
                    } else {
                        echo "<option>There are no Support Educators registered in STARS</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-12">
                <!--Register student button-->

                <div class="col-md-12">
                    <?php
                    $confirm = new Button();

                    $confirm->buttonName = "add";
                    $confirm->buttonID = "add";
                    $confirm->buttonValue = "Add";
                    $confirm->buttonStyle = "font-family:sans-serif";
                    $confirm->display(); ?>
                </div>
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>

<?php
//    }
//?>

