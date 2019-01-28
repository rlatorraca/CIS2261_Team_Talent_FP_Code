<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 1/22/2019
 * Time: 5:37 PM
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add User</title>
</head>
<body>
<div><?php
    //To trigger when user submits request to add new User
    if (isset($_GET["add"])) {

        //If details are empty, display a message and give redirect links. Otherwise, proceed.
        if ($_GET["userID"] == "" || $_GET["username"] == "" || $_GET["password"] == "" || $_GET["accessCode"] == "") {
            echo "<h2>Error. Form fields must not be empty before submitting</h2><br>";
            echo "<form action='addUser.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
            echo "<form action='../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
            exit("</div></body</html>");
        }

        //Make connection to the database and check to ensure that a solid connection can be made
        @ $database = new mysqli('localhost', 'root', '', 'stars');
        if (mysqli_connect_errno()) {
            echo '<h2>Error: Could not connect to database. Please try again later.</h2>';
            echo "<form action='addUser.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
            exit("</div></body></html>");
        }

        //Sanitize user inputs to prepare for database insert query.
        $userID = $database->real_escape_string($_GET["userID"]);
        $username = $database->real_escape_string($_GET["username"]);
        $password = $database->real_escape_string($_GET["password"]);
        $accessCode = $database->real_escape_string($_GET["accessCode"]);

        //Create initial SQL query to insert form data into database
        $query = "INSERT INTO user(userID, username, password, accessCode) VALUES ('$userID', '$username', '$password', '$accessCode');";

        //Execute query and store result.
        $result = $database->query($query);

        //Check if query executed successfully and that the result contains data.
        if ($result) {

            echo "<h2>User has successfully been added to the database</h2><br>";
            echo "<a href='addStudent.php?userID=" . $userID . "'>Register new Student</a>";
            echo "<form action='addStudent.php?userID=" . $userID . "' method='get'><fieldset><div class='col-md-12'><button>Register Student with this Information</button></div></fieldset></form>";
            echo "<form action='addUser.php' method='post'><fieldset><div class='col-md-12'>Add Another User</button></div></fieldset></form>";

        } else {

            echo "<h2>Sorry, User could not be added to the database at this time</h2><br>";
            echo "<form action='addUser.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Try Again</button></div></fieldset></form>";
            echo "<form action='../../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";

        }

        //Close database connection
        $database->close();
    } else {

    ?>
    <p>**Please ensure all fields are filled before adding a new User.</p>
    <form action="addUser.php" method="get">
        <fieldset>
            <legend>Book Details</legend>
            <div class="col-md-12 form-inline customDiv">
                <label for="isbn" class="col-md-6">User ID</label>
                <input type="text" name="userID" class="col-md-6 form-control">
            </div>
            <br>
            <br>
            <div class="col-md-12 form-inline customDiv">
                <label for="author" class="col-md-6">Username</label>
                <input type="text" name="username" class="col-md-6 form-control">
            </div>
            <br>
            <br>
            <div class="col-md-12 form-inline customDiv">
                <label for="title" class="col-md-6">Password</label>
                <input type="text" name="password" class="col-md-6 form-control">
            </div>
            <br>
            <br>
            <div class="col-md-12 form-inline customDiv">
                <label for="price" class="col-md-6">Access Code</label>
                <select name="accessCode">
                    <option name="1">1: System Administrator</option>
                    <option name="2">2: Administrator</option>
                    <option name="3">3: Educator</option>
                    <option name="4">4: Support Educator</option>
                    <option name="5">5: Student</option>
                    <option name="6">6: Parent/Guardian</option>
                </select>
            </div>
            <br>
            <br>
            <div class="col-md-12">
                <input type="submit" name="add" value="Add User">
            </div>
        </fieldset>
    </form>
    <form action="../../index.php" method="post">
        <fieldset>
            <div class="col-md-12">
                <button id="customBtn">Return Home</button>
            </div>
        </fieldset>
    </form>
</div>
</body>
</html>
<?php
}
?>
