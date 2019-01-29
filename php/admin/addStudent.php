<?php
/**
 * Created by PhpStorm
 * Edited by: John Gaudet
 * Date: 2019-01-27
 * Time: 8:49 PM
 *
 * 2019/01/28: Functionality mostly there. Able to pull user ID from prior screen but cannot use to insert into database.
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register New Student</title>
</head>
<body>
<div>
    <?php
    //To trigger when user submits request to add new Student to stars database
    if (isset($_POST["register"])) {

        //If details are empty, display a message and give redirect links. Otherwise, proceed.
        if ($_POST["studentID"] == "" || $_POST["firstName"] == "" || $_POST["middleName"] == "" || $_POST["lastName"] == "") {
            echo "<h2>Error. Form fields must not be empty before registering new student in STARS.</h2><br>";
            echo "<form action='addStudent.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
            echo "<form action='../../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
            exit("</div></body</html>");
        }

        //Make connection to the database and check to ensure that a solid connection can be made
        @ $database = new mysqli('localhost', 'root', '', 'stars');
        if (mysqli_connect_errno()) {
            echo '<h2>Error: Could not connect to database. Please try again later.</h2>';
            echo "<form action='addStudent.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
            exit("</div></body></html>");
        }

        //Sanitize user inputs to prepare for database insert query.
        $studentID = $database->real_escape_string($_POST["studentID"]);
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
        $userIDFromForm = $database->real_escape_string($_POST["userID"]);
        $supportEducatorID = $database->real_escape_string($_POST["supportEducatorID"]);

        //Create initial SQL query to insert form data into database
        $query = "INSERT INTO student(studentID, firstName, middleName, lastName, gender, dob, grade, address, 
                  phoneNum, emailAddress, allergies, schoolID, guardianID, userID, supportEducatorID) 
                  VALUES ('$studentID', '$firstName', '$middleName', '$lastName', '$gender', '$dob', '$grade', '$address', 
                  '$phoneNum', '$emailAddress', '$allergies', $schoolID, $guardianID, $userIDFromForm, $supportEducatorID);";

        //Execute query and store result.
        $result = $database->query($query);

        //Check if query executed successfully and that the result contains data.
        if ($result) {

            echo "<h2>Student has been successfully added to the database</h2><br>";

        } else {

            echo "<h2>Sorry, student could not be added to the database at this time</h2><br>";

        }

        //Close database connection
        $database->close();

    } else {

    //Pull userID from previous setup for add user in order to populate user ID field for student
    $userIDFromAddUserScreen = $_GET["userID"];

    ?>
    <p>**Please ensure all fields are filled before registering a new Student.</p>
    <form action="addStudent.php" method="post">
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
                <label for="title" class="col-md-6">School ID number</label>
                <input type="text" name="schoolID" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Guardian ID number</label>
                <input type="text" name="guardianID" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">User ID number</label>
                <input type="text" name="userID" class="col-md-6 form-control value="
                       value="<?php echo $userIDFromAddUserScreen ?>" disabled="disabled">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Support Educator ID number</label>
                <input type="text" name="supportEducatorID" class="col-md-6 form-control value=">
            </div>
            <div class="col-md-12">
                <input type="submit" name="register" value="Register Student">
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>
<?php
}
?>
