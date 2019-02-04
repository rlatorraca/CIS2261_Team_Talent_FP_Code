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
    <!-- Fonts !-->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Roboto" rel="stylesheet">

    <!-- Instructions to replicate can be found here:  https://getbootstrap.com/docs/4.1/getting-started/introduction/ !-->
    <!-- Here is where we call bootstrap. !-->
    <title>STARS - Add User</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Calendar Date Picker !-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="../../css/stars.css" rel="stylesheet">

    <!--function to go back to your incomplete album form without losing previously filled fields-->
    <script>
        function goBack() {
            window.history.back();
        }
        // This function shows the date picker.
        $( function() {
            $( "#datepicker" ).datepicker();
        } );

        // This function shows the note.
        // Will need to add a variable to get the notes to then call.
        $( function() {
            $( document ).tooltip();
        } );

        // This function manages the drop downs on the main menu.
        $( function() {
            $( "#menu" ).menu();
        } );
    </script>
</head>
<body>
<div><?php
session_start();

        include "../db/dbConn.php";

    //To trigger when user submits request to add new User
    if (isset($_POST["add"])) {

        //If details are empty, display a message and give redirect links. Otherwise, proceed.
        if ($_POST["username"] == "" || $_POST["password"] == "" || $_POST["accessCode"] == "") {
            echo "<h2>Error. Form fields must not be empty before submitting</h2><br>";
            echo "<form action='addUser.php' method='post'><fieldset><div class='col-md-12'><button class='btn btn-primary' onclick='goBack()'>Go Back</button></div></div></fieldset></form>";
            echo "<form action='../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";
            exit("</div></body</html>");
        }

        //Sanitize user inputs to prepare for database insert query.
        $userID = $database->real_escape_string($_POST["userID"]);
        $username = $database->real_escape_string($_POST["username"]);
		$password = (md5($database->real_escape_string($_POST["password"])));
        $accessCode = $database->real_escape_string($_POST["accessCode"]);

        $_SESSION['username'] = $username;

		//Create initial SQL query to insert form data into database
        $query = "INSERT INTO user(userID, username, password, accessCode) VALUES ('$userID', '$username', '$password', '$accessCode');";

        //Execute query and store result.
        $result = $database->query($query);

        //Check if query executed successfully and that the result contains data.
        if ($result) {

            echo "<h2>User has successfully been added to the database</h2><br>";
            echo "<a href='addStudent.php?username=" . $username . "'>Register new Student</a>";
            //echo "<form action='addStudent.php?userID=" . $userID . "' method='get'><fieldset><div class='col-md-12'><button>Register Student with this Information</button></div></fieldset></form>";
            //echo "<form action='addUser.php' method='post'><fieldset><div class='col-md-12'>Add Another User</button></div></fieldset></form>";

        } else {

            echo "<h2>Sorry, User could not be added to the database at this time</h2><br>";
            echo "<form action='addUser.php' method='post'><fieldset><div class='col-md-12'><button class='btn btn-primary' onclick='goBack()'>Go Back</button></div></fieldset></form>";
            echo "<form action='../../index.php' method='post'><fieldset><div class='col-md-12'><button id='customBtn'>Return Home</button></div></fieldset></form>";

        }

        //Close database connection
        $database->close();
    } else {

    ?>
    <div class="header">
        <img src="../../img/StarsWhiteFIN.jpg">
    </div>
    <div class="jumbotron-fluid">
        <div class="container-fluid">

    <p>*Please ensure all fields are completed before adding a new User.</p>
    <form action="addUser.php" method="POST">
        <fieldset>
            <h2>User Details</h2>
<!--            <div class="col-md-12 form-inline customDiv">-->
<!--                <label for="isbn" class="col-md-6">User ID</label>-->
<!--                <input type="text" name="userID" class="col-md-6 form-control">-->
<!--            </div>-->
<!--            <br>-->
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
                <select name="accessCode" class="form-control">
                    <option value="1">1: System Administrator</option>
                    <option value="2">2: Administrator</option>
                    <option value="3">3: Educator</option>
                    <option value="4">4: Support Educator</option>
                    <option value="5">5: Student</option>
                    <option value="6">6: Parent/Guardian</option>
                </select>
            </div>
            <br>
            <br>
            <div class="col-md-12">
                <?php

                include("../button.class.php");
                $confirm = new Button();

                $confirm->buttonName = "add";
                $confirm->buttonID = "addID";
                $confirm->buttonValue = "Add User";
                $confirm->buttonStyle = "font-family:sans-serif";
                $confirm->display(); ?>
            </div>
        </fieldset>
    </form>
    <form action="../../index.php" method="post">
        <fieldset>
            <div class="col-md-12">
                <?php
                    $return = new Button();

                $return->buttonName = "customBtn";
                $return->buttonName = "custom";
                $return->buttonValue = "Return Home";
                $return->buttonStyle = "font-family:sans-serif";
                $return->display();
                ?>
<!--                <button id="customBtn">Return Home</button>-->
            </div>
        </fieldset>
    </form>
</div>
    </div>
</div>

<div class = "bottom">
    <div id="footer">
        <ul id="footerMenu">
            <?php
            echo '<a href="#"><li class = "titleNav">Home</li></a>';

            echo '<li class = "titleNav">Add User
                        <ul class = "dropupMenu">
                            <a><li>Student</li></a>
                            <a><li>Educator</li></a>
                            <a><li>Support Educator</li></a>
                        </ul>
                    </li>';

            echo '<a href="#"><li class = "titleNav">Edit User</li></a>';

            echo '<a href="#"><li class = "titleNav">Search Students</li></a>';
            ?>
        </ul>
    </div>
</div>
</body>
</html>
<?php
}
?>


