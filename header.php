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

$tableName;
$identifier;

$queryUser = "SELECT * FROM administrator WHERE adminID = $loggedUser;";


switch ($accessCode) {

    case 1:
        $querySysAdmin = "SELECT * FROM administrator WHERE adminID = $loggedUser;";
        break;

    case 2:
        $loggedUser = $adminFName;




        $queryStudent = "SELECT * FROM student WHERE studentID = $studentID;";



        default:
        $loggedUser = "default";
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