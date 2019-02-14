<?php
/**
 * Created by PhpStorm.
 * Company: Team Talent 2.0
 * Members: John, Rodrigo, Sara, Steve
 * Date: 2/14/2019
 *
 * Page which allows admin users in STARS the ability to add new users to the STARS system.
 * As of version 1.0, admin staff may add users of all types but can only add students based on the student access code of '5'.
 * Admin users can not add details of other types of users at this time (Educators, parent/guardians, etc.).
 *
 * Required Pages: login.php, checkLogin.php, authenticateAdminPages.php, dbConn.php, index.php, stars.css.
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Ensure only admin/system admin staff can view this page.
include "../login/authenticateAdminPages.php";

//Database connection
include "../db/dbConn.php";

//Include button class
include("../button.class.php");

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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!-- Required JS and JQuery links-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link href="../../css/stars.css" rel="stylesheet">
        <script src="../../js/main.js"></script>
        <title>STARS - Add User</title>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </head>
<body>
<div>
<?php
include "../../header.php";

//To trigger when user submits request to add new User
if (isset($_POST["add"])) {

    //If details are empty and/or passwords do not match, display a message and give redirect links. Otherwise, proceed.
    if ($_POST["username"] == "" || $_POST["password"] == "" || $_POST["password2"] == "" || $_POST["accessCode"] == "" || ($_POST["password"] != $_POST["password2"])) {
        ?>
        </div>
        <div>
            <?php include "../../header.php"; ?>
        </div>
        <!--Main container-->
        <div class="jumbotron-fluid">
            <div class="container-fluid">
                <?php
                echo "<br><div class='container'><div class=\"alert alert-danger\"><br><h4>Error. Form fields must be correct.</h4><br><br></div></div><br>";
                echo "<form action='addUser.php' method='post'><fieldset><div class='col-md-12'><button class='btn button button2' onclick='goBack()'>Go Back</button></div></fieldset></form>";
                ?>
            </div>
        </div>
        </div>
        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
        <?php

        exit("</div></body</html>");
    }

    //Sanitize user inputs to prepare for database insert query. Also hash password for database insertion.
    $username = $database->real_escape_string($_POST["username"]);
    $password = (md5($database->real_escape_string($_POST["password"])));
    $accessCode = $database->real_escape_string($_POST["accessCode"]);

    //Adds username to the session to allow for adding students after this initial step.
    $_SESSION['username'] = $username;

    //Create initial SQL query to insert form data into database
    $query = "INSERT INTO user(username, password, accessCode) VALUES ('$username', '$password', '$accessCode');";

    //Execute query and store result.
    $result = $database->query($query);

    //Check if query executed successfully and that the result contains data.
    if ($result) {
        ?>
        </div>
        <div>
            <?php include "../../header.php"; ?>
        </div>
        <div class="jumbotron-fluid">
            <div class="container-fluid container-sizer">
                <?php echo "<br><div class='container'><div class='alert alert-info'>Success. User has successfully been added to the database</div></div><br>";
                //Check that the user type chosen is for type Student.
                if ($accessCode == 5) {

                    //Register button to allow for adding new students
                    $register = new Button();

                    $register->buttonName = "add";
                    $register->buttonID = "addID";
                    $register->buttonValue = "Add Student";
                    $register->buttonStyle = "font-family:sans-serif";
                    $register->buttonWeb = 'location.href="addStudent.php?username=' . $username . '"';
                    $register->display();
                }
                ?>
            </div>
        </div>
        </div>
        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
        <?php
    } else {

        ?>
        </div>
        <div class="jumbotron-fluid">
            <div class="container-fluid chart-sizer">
                <div class="container "><br>
                    <div class='alert alert-danger'>Sorry, User could not be added to the database at this time</div>
                    <form action='addUser.php' method='post'>
                        <fieldset>
                            <div class='col-md-12'>
                                <button class='btn button button2' onclick='goBack()'>Go Back</button>
                            </div>
                        </fieldset>
                    </form>
                    <br>
                </div>
            </div>
        </div>

        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
        <?php
    }

} else {
    ?>
    </div>
    <div class="jumbotron-fluid">
        <div class="container-fluid login">
            <!--User details form-->
            <form action="addUser.php" method="POST">
                <div class="form-group">
                    <h2>User Details</h2>
                    <p><span style="color:red">*Username must be unique & passwords must match.</span></p>
                    <br>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 form-inline">
                                <label for="username" class="col-md-6">Username</label>
                                <input type="text" name="username" class="col-md-6 form-control">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12 form-inline">
                                <label for="password" class="col-md-6">Password</label>
                                <input type="password" name="password" class="col-md-6 form-control">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12 form-inline">
                                <label for="password2" class="col-md-6">Password</label>
                                <input type="password" name="password2" class="col-md-6 form-control">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12 form-inline">
                                <label for="price" class="col-md-6">Access Code</label>
                                <select name="accessCode" class="form-control">
                                    <option value="1">1: System Administrator</option>
                                    <option value="2">2: Administrator</option>
                                    <option value="3">3: Educator</option>
                                    <option value="4">4: Support Educator</option>
                                    <option value="5" selected>5: Student</option>
                                    <option value="6">6: Parent/Guardian</option>
                                </select>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-12">
                                <?php

                                //Add user button
                                $confirm = new Button();

                                $confirm->buttonName = "add";
                                $confirm->buttonID = "addID";
                                $confirm->buttonValue = "Add User";
                                $confirm->buttonStyle = "font-family:sans-serif";
                                $confirm->display(); ?>
                            </div>
                        </div>
            </form>
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

//Close database connection
$database->close();

?>