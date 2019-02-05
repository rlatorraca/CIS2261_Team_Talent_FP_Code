<?php
/**
 * Created by PhpStorm.
 * User: stevemartin
 * Date: 2019-02-05
 * Time: 11:04 AM
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
include "../db/dbConn.php";

$loggedId;

$queryUser = "SELECT adminFName FROM Administrator WHERE adminID = ''";

$queryUser = "SELECT * FROM administrator WHERE adminID = '$loggedUser'";


switch ($accessCode) {

    case 1:
        $loggedUser = "Admin!";
        break;

    case 2:
        $queryAdmin = "SELECT adminFName FROM Administrator WHERE adminID = '$loggedId'";
        $result = $database->query($queryAdmin);
        $loggedUser = $adminFName;
        break;

    case 3:
    case 4:
    case 5:
    case 6:

        $queryStudent = "SELECT * FROM student WHERE studentID = $studentID;";



        default:
        $loggedUser = "!";
        break;




}







?>
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <li role="presentation">Welcome</li>
                        <!-- Both buttons below should never be visible at the same time -->
                        <?php
                        if ($_SESSION['hasAccess'] == true) {
                            echo "<li role='presentation'>". $loggedUser  ."<a href='php/login/logout.php'>Logout</a></li>";
                        } else {
                            echo "<li role='presentation'>!</li>";
                        }
                        ?>
                    </ul>
                </nav>