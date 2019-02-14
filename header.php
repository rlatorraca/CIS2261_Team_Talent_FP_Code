<?php
    /**
     * Created by PhpStorm.
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This page determines what is seen on top bar of page.  If user is not logged in they will see a login button, if
     * user is logged in they will see their name and a logout button.
     *
     * This page requires: stars.css, Login.php, index.php.
     *
     */

    include 'php/db/dbConn.php';

    $loggedUser = " to STARS";
    $success = false;
    $access = 0;
    //Check to see if user is logged in
    if (isset($_SESSION['isLoggedIn'])) {
        $success = TRUE;
        $loggedId = $_SESSION['userID'];
        $access = $_SESSION['accessCode'];
    }
    //switch to get name of logged in user, checks access level to know which table to look in.
    switch ($access) {

        //System Administrator
        case 1:
            $loggedUser = "System Admin";
            break;

        //Administrator
        case 2:
            $queryAdmin = "SELECT adminFName FROM administrator WHERE userID = '$loggedId'";

            $result1 = $database->query($queryAdmin);

            $rowName = $result1->fetch_assoc();
            $loggedUser = $rowName["adminFName"];
            break;

        //Educator
        case 3:
            $queryAdmin = "SELECT educatorFName FROM educator WHERE userID = '$loggedId'";

            $result1 = $database->query($queryAdmin);

            $rowName = $result1->fetch_assoc();
            $loggedUser = $rowName["educatorFName"];
            break;

        //Support Educator
        case 4:
            $queryAdmin = "SELECT supFName FROM supporteducator WHERE userID = '$loggedId'";

            $result1 = $database->query($queryAdmin);

            $rowName = $result1->fetch_assoc();
            $loggedUser = $rowName["supFName"];
            break;

        //Student
        case 5:
            $queryStu = "SELECT student.firstName FROM student WHERE student.userID = '$loggedId'";

            $result1 = $database->query($queryStu);

            $rowName = $result1->fetch_assoc();
            $loggedUser = $rowName["firstName"];
            break;

        //Parent/Guardian
        case 6:
            $queryAdmin = "SELECT parentFName FROM parentorguardian WHERE userID = '$loggedId'";

            $result1 = $database->query($queryAdmin);

            $rowName = $result1->fetch_assoc();
            $loggedUser = $rowName["parentFName"];
            break;
        default:
            break;
    }
    //Display based on logged in status
?>
<div class="row-header header">
    <div class="col-sm-8 starnav">
        <img src="/CIS2261_Team_Talent_FP_Code/img/StarsWhiteFIN.jpg">
    </div>
    <div class="col-sm-4 topnav">
        <nav>
            <ul class="nav nav-pills pull-right welcome">
                <?php

                    if ($success == true) {

                        echo "<li role='presentation'>Welcome " . $loggedUser . "! &nbsp;";

                        $logout = new Button();

                        $logout->buttonName = "logout";
                        $logout->buttonID = "logout";
                        $logout->buttonValue = "Logout";
                        $logout->buttonStyle = "font-family:sans-serif";
                        $logout->buttonWeb = 'location.href="/CIS2261_Team_Talent_FP_Code/php/login/logout.php"';
                        $logout->display();
                        echo "</li>";
                    } else {

                        echo "<li role='presentation'>Welcome" . $loggedUser . "! &nbsp;";

                        $login = new Button();

                        $login->buttonName = "login";
                        $login->buttonID = "login";
                        $login->buttonValue = "Login";
                        $login->buttonStyle = "font-family:sans-serif";
                        $login->buttonWeb = 'location.href="/CIS2261_Team_Talent_FP_Code/php/login/login.php"';
                        $login->display();

                        echo "</li>";
                    }
                ?>
            </ul>
        </nav>
    </div>
</div>
