<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 1/22/2019
 * Time: 5:37 PM
 */

include "../button.class.php" ;
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

    <title>STARS: Login</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Calendar Date Picker !-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <link href="/CIS2261_Team_Talent_FP_Code/css/stars.css" rel="stylesheet">
    <script src="../../js/main.js"></script>
    <!--    <script>-->
    <!--        // This function shows the date picker.-->
    <!--        $(function () {-->
    <!--            $("#datepicker").datepicker();-->
    <!--        });-->
    <!---->
    <!--        // This function shows the note.-->
    <!--        // Will need to add a variable to get the notes to then call.-->
    <!--        $(function () {-->
    <!--            $(document).tooltip();-->
    <!--        });-->
    <!---->
    <!--        // This function manages the drop downs on the main menu.-->
    <!--        $(function () {-->
    <!--            $("#menu").menu();-->
    <!--        });-->
    <!--    </script>-->
</head>

<body>

<?php
session_start();

//Login processing logic here
if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    if ($_SESSION['username'] == '' || $_SESSION['password'] == '') {
        $error = "You need a Username and  Password";
        $_SESSION['isLoggedIn'] = false;
    } else {

        include "../db/dbConn.php";

        $usernamedb = $database->real_escape_string(trim($_SESSION['username']));
        $passworddb = $database->real_escape_string(md5(trim($_SESSION['password'])));

        $query = "SELECT userID, username, password, accessCode FROM user 
                  WHERE (username = '$usernamedb') AND (password = '$passworddb') LIMIT 1";

        //$db object created above and run the query() method. We pass it our query from above.
        $result = $database->query($query);
        $num_results = $result->num_rows;

        //if result is false [don't have any register in the database]
        if ($num_results == 0) {
            $error = "Login/Password incorrect";
        } else {
            if ($num_results == 1) {
                $row = $result->fetch_assoc();
                $accessCodeDB = $row['accessCode'];
                $userID = $row['userID'];
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['accessCode'] = $accessCodeDB;
                $_SESSION['userID'] = $userID;
                include("setCookie.php");
                echo "<p>My access code is : " . $_SESSION['accessCode'] . "<p>";
                $error = "Logged IN";
                header('Location: /CIS2261_Team_Talent_FP_Code/index.php');
            } else {
                $error = "Login/Password incorrect";
                exit;
            }
        }
    }
}
?>
    <?php include "../../header.php"; ?>
    <div class="jumbotron-fluid">
    <div class="container-fluid login">
        <form action="login.php" method="post">
            <div class="form-group">
                <h2>User Login</h2>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="user" type="text" class="form-control" name="username" placeholder="Enter your username"

                    <?php if (isset($_COOKIE['stars'])) {
                        echo "value='" . $_COOKIE['stars'] . "'>";
                    } else {
                        echo "value=''/>";
                    } ?>
                </div>
                <br>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password"
                           placeholder="Enter your password">
                </div>

                <br>
                <?php


                $login2 = new Button();

                $login2->buttonName = "login2";
                $login2->buttonID = "login2";
                $login2->buttonValue = "Login";
                $login2->buttonStyle = "font-family:sans-serif";
                $login2->display(); ?>
            </div>
        </form>
        <?php
        if (isset($error)) {
            echo "<br><br><div class='alert alert-danger'>$error</div>";
        }


        ?>
    </div>r
</div>
<div class="bottom">
    <div id="footer">
        <ul id="footerMenu">
            <?php
            echo '<a href="../../index.php"><li class = "titleNav">Home</li></a>';

            ?>
        </ul>
    </div>
</div>
</body>
</html>



