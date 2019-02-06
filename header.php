<?php
/**
 * Created by PhpStorm.
 * User: stevemartin
 * Date: 2019-02-05
 * Time: 11:04 AM
 */

include 'php/db/dbConn.php';

$loggedUser = "";
$success = false;
$access = 0;

if (isset($_SESSION['isLoggedIn'])) {
    $success = TRUE;
    $loggedId = $_SESSION['userID'];
    $access = $_SESSION['accessCode'];
}


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

?>
<nav>
    <ul class="nav nav-pills pull-right">
        <?php
        if ($success == true) {
            echo "<li role='presentation' class='welcome'>Welcome " . $loggedUser . "!";


                $logout = new Button();

                $logout->buttonName = "logout";
                $logout->buttonID = "logout";
                $logout->buttonValue = "Logout";
                $logout->buttonStyle = "font-family:sans-serif";
                $logout->buttonWeb = 'location.href="php/login/logout.php"';
                $logout->display();
            echo "</li>";
        } else {
            echo "<li role='presentation'>";

                $login = new Button();

                $login->buttonName = "login";
                $login->buttonID = "login";
                $login->buttonValue = "Login";
                $login->buttonStyle = "font-family:sans-serif";
                $login->buttonWeb = 'location.href="php/login/login.php"';
                $login->display();


            echo "</li>";
        }
        ?>
    </ul>
</nav>