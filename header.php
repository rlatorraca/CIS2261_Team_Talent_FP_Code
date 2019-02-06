<?php
/**
 * Created by PhpStorm.
 * User: stevemartin
 * Date: 2019-02-05
 * Time: 11:04 AM
 */


include 'php/db/dbConn.php';

session_start();

$loggedUser = "";


if (isset($_SESSION['isLoggedIn'])) {
    $success = TRUE;
    $loggedId = $_SESSION['userID'] ;
    $access = $_SESSION['accessCode'];
}


switch ($access) {

    case 1:
        $queryAdmin = "SELECT USER.USER FROM Student WHERE STUDENT.userID = $loggedUser";

        $result1 = $database->query($queryAdmin);

        $rowName = $result1->fetch_assoc();
        $loggedUser = $rowReportCard["adminFName"];
        break;

    case 2:
        $queryAdmin = "SELECT adminFName FROM Administrator WHERE adminID = '$loggedId'";

        $result1 = $database->query($queryAdmin);

        $rowName = $result1->fetch_assoc();
        $loggedUser = $rowReportCard["adminFName"];
        break;

    case 3:
        $queryAdmin = "SELECT adminFName FROM Administrator WHERE adminID = '$loggedId'";

        $result1 = $database->query($queryAdmin);

        $rowName = $result1->fetch_assoc();
        $loggedUser = $rowReportCard["adminFName"];
        break;
    case 4:
        $queryAdmin = "SELECT adminFName FROM Administrator WHERE adminID = '$loggedId'";

        $result1 = $database->query($queryAdmin);

        $rowName = $result1->fetch_assoc();
        $loggedUser = $rowReportCard["adminFName"];
        break;
    case 5:
        $queryStu = "SELECT student.firstName FROM student WHERE student.userID = '$loggedId'";

        $result1 = $database->query($queryStu);

        $rowName = $result1->fetch_assoc();
        $loggedUser = $rowName["firstName"];
        break;
    case 6:
        $queryAdmin = "SELECT adminFName FROM Administrator WHERE adminID = '$loggedId'";

        $result1 = $database->query($queryAdmin);

        $rowName = $result1->fetch_assoc();
        $loggedUser = $rowReportCard["adminFName"];
        break;



        default:
        break;

}

?>
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <?php
                        if ($success == true) {
                        echo "<li role='presentation'>Welcome " .$loggedUser. "!";




                                    $logout = new Button();

                                    $logout->buttonName = "logout";
                                    $logout->buttonID = "logout";
                                    $logout->buttonValue = "Logout";
                                    $logout->buttonStyle = "font-family:sans-serif";
                                    $logout->buttonWeb = 'location.href="php/login/logout.php"';
                                    $logout->display();
                                    echo "</li>";
                        } else {
                        echo "<li role='presentation'><a href='login.php'>Login</a></li>";
                        }
                        ?>
                    </ul>
                </nav>