<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 2019-01-27
 * Time: 9:05 PM
 */
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
        if ($_POST["subject"] == "" || $_POST["schoolYear"] == "" || $_POST["semesterNum"] == "" || $_POST["classID"] == "" || $_POST["studentID"] == "") {
            echo "<h2>Error. Form fields must not be empty before registering new student in a course.</h2><br>";
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
        $subject = $database->real_escape_string($_POST["subject"]);
        $schoolYear = $database->real_escape_string($_POST["schoolYear"]);
        $semesterNum = $database->real_escape_string($_POST["semesterNum"]);
        $classID = $database->real_escape_string($_POST["classID"]);
        $studentID = $database->real_escape_string($_POST["studentID"]);

        //Create initial SQL query to insert form data into database
        $query = "INSERT INTO enrollment(schoolYear, semesterNum, classID, studentID) 
                  VALUES ('$schoolYear', '$semesterNum', '$classID', '$studentID');";

        //Execute query and store result.
        $result = $database->query($query);

        //Check if query executed successfully and that the result contains data.
        if ($result) {

            echo "<h2>Student has been successfully register in the course.</h2><br>";
            echo "<form action='addBook.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Add Another Book</button></div></fieldset></form>";
            echo "<form action='../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";

        } else {

            echo "<h2>Sorry, student could not be registered in this course at this time.</h2><br>";
            echo "<form action='addBook.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
            echo "<form action='../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";

        }

        //Close database connection
        $database->close();

    } else {

    ?>
    <p>**Please ensure all fields are filled before registering a new Student.</p>
    <form action="assignCourse.php" method="post">
        <fieldset>
            <legend>Student Details</legend>
            <div class="col-md-12 form-inline customDiv">
                <label for="isbn" class="col-md-6">Subject</label>
                <input type="text" name="subject" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="author" class="col-md-6">School Year</label>
                <input type="text" name="schoolYear" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Semester</label>
                <input type="text" name="semesterNum" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Class ID</label>
                <input type="text" name="classID" class="col-md-6 form-control">
            </div>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Student ID</label>
                <input type="text" name="studentID" class="col-md-6 form-control">
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
