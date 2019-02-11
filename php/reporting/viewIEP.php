<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 1/30/2019
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
include "../db/dbConn.php";

//Button class
include "../button.class.php";

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

        <title>STARS: Request Report Card</title>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!-- Calendar Date Picker !-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <link href="../../css/stars.css" rel="stylesheet">
        <script src="../../js/main.js"></script>
        <title>View Individual Education Plan</title>
    </head>
    <body>
        <?php include "../../header.php"; ?>
        <div class="jumbotron-fluid">
            <div class="container-fluid login">
                <?php

                //Check to ensure that a studentID was selected from the report card page before user can access this page.
                if (!isset($_GET["studentID"])) {

                    echo "<p><h2>Error</h2>Please request a student's report card first before viewing an Individual Education Plan.</p>
            </div>
        </div>
        <div class='bottom'>
            <div id='footer'>";
                include("../../navMenu.php");
    echo "</div>
        </div>
    </body>
</html>";
                    exit();
                }

                //StudentID pulled from the report card page.
                $studentIDFromForm = $_GET["studentID"];

                //To ensure studentID is the accurate one
                echo $studentIDFromForm;

                //Need to work out issue with first/last name of student and support educator
                $querySelectIEP = "SELECT planID, reason, dateIssued, comments, supportEducator.supFName, supportEducator.supLName, student.firstName, student.lastName  
                  FROM individualeducationplan, supporteducator, student 
                  WHERE individualeducationplan.studentID = $studentIDFromForm
                  AND student.studentID = individualeducationplan.studentID
                  AND individualeducationplan.supportEducatorID = supporteducator.supportEducatorID;";

                $resultIEP = $database->query($querySelectIEP);

                if ($resultIEP->num_rows > 0) {

                    ?>
                    <table>
                    <thead>
                        <tr>
                            <td>Plan ID</td>
                            <td>Reason for IEP</td>
                            <td>Date Issued</td>
                            <td>Comments</td>
                            <td>Support Educator Name</td>
                            <td>Student Name</td>
                        </tr>
                    </thead>
                    <?php

                    while ($rowIEP = $resultIEP->fetch_assoc()) {

                        $planID = $rowIEP["planID"];
                        $reason = $rowIEP["reason"];
                        $dateIssued = $rowIEP["dateIssued"];
                        $comments = $rowIEP["comments"];
                        $supportEducatorFirstName = $rowIEP["supFName"];
                        $supportEducatorLastName = $rowIEP["supLName"];
                        $studentFirstName = $rowIEP["firstName"];
                        $studentLastName = $rowIEP["lastName"];

                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $planID; ?></td>
                                <td><?php echo $reason; ?></td>
                                <td><?php echo $dateIssued; ?></td>
                                <td><?php echo $comments; ?></td>
                                <td><?php echo $supportEducatorFirstName; ?></td>
                                <td><?php echo $supportEducatorLastName; ?></td>
                                <td><?php echo $studentFirstName; ?></td>
                                <td><?php echo $studentLastName; ?></td>
                            </tr>
                        </tbody>
                        </table>
                    <?php }
                } else {
                    echo "<p>This student has no IEP listed in the system</p>";
                }
                ?>
            </div>
        </div>
        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
    </body>
</html>
