<?php
/**
 * Created by PhpStorm.
 * User: stevemartin
 * Date: 2019-02-05
 * Time: 11:04 AM
 */

//Lock down page
include "php/login/checkLoggedIn.php";

include 'php/db/dbConn.php';


$loggedUser = $_SESSION['userID']

$access =$_SESSION['accessCode']



$queryUser = "SELECT adminFName FROM Administrator WHERE adminID = ''";

$queryUser = "SELECT * FROM administrator WHERE adminID = '$loggedUser'";

var_dump($loggedUser);

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
        $queryAdmin = "SELECT Student.firstName FROM Student WHERE STUDENT.userID = '$loggedUser'";

        $result1 = $database->query($queryAdmin);

        $rowName = $result1->fetch_assoc();
        $loggedUser = $rowReportCard["adminFName"];
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
                        <li role="presentation">Welcome<?php echo $loggedUser; var_dump($loggedUser); ?>!</li>
                        <!-- Both buttons below should never be visible at the same time -->

                    </ul>
                </nav>