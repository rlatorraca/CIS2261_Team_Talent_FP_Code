<?php
    /**
     * Created by PhpStorm.
     * STARS Beta Version 1.0
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This is the page used to display an IEP if option is selected in the report card
     *
     * This page requires: stars.css, index.php, login.php, checkLoggedIn.php, dbConn.php, requestReportCard.php, displayReportCard.php .
     *
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

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Roboto" rel="stylesheet">

        <!-- Here is where we call bootstrap. !-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!-- Calendar Date Picker !-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!--custom css-->
        <link href="../../css/stars.css" rel="stylesheet">
        <script src="../../js/main.js"></script>
        <title>STARS - View IEP</title>
    </head>

    <body>
        <?php include "../../header.php"; ?>
        <div class="jumbotron-fluid">
            <div class="container-fluid">
                <?php

                    //Check to ensure that a studentID was selected from the report card page before user can access this page.
                    if (!isset($_POST["selectStudent"])) {
                        ?>
                        <form method="post" action="displayReportCard.php">
                            <input type="hidden" id="selectStudent" name="selectStudent"
                                   value="<?php echo $_POST['selectStudent']; ?>">
                            <input type="hidden" id="selectYear" name="selectYear"
                                   value="<?php echo $_POST['selectYear']; ?>">
                            <input type="hidden" id="selectSemester" name="selectSemester"
                                   value="<?php echo $_POST['selectSemester']; ?>">
                            <?php
                                echo "<p><h2>Error</h2>Please request a student's report card first before viewing an Individual Education Plan.</p>";
                                $goBack1 = new Button();
                                $goBack1->buttonName = 'goBack';
                                $goBack1->buttonID = 'goBack';
                                $goBack1->buttonValue = 'Go Back';
                                $goBack1->buttonStyle = 'font-family:sans-serif';

                                $goBack1->display();
                            ?>
                        </form>
                        <?php
                        echo "</div>
        </div>
        <div class='bottom'>
            <div id='footer'>";
                        include("../../navMenu.php");
                        echo "</div>
        </div>
    </body>
</html>";
                    }
                    //StudentID pulled from the report card page.
                    $studentIDFromForm = $_POST["selectStudent"];

                    //Need to work out issue with first/last name of student and support educator
                    $querySelectIEP = "SELECT planID, reason, dateIssued, comments, supportEducator.supFName, supportEducator.supLName, student.firstName, student.lastName  
                  FROM individualeducationplan, supporteducator, student 
                  WHERE individualeducationplan.studentID = $studentIDFromForm
                  AND student.studentID = individualeducationplan.studentID
                  AND individualeducationplan.supportEducatorID = supporteducator.supportEducatorID;";

                    $resultIEP = $database->query($querySelectIEP);

                    if ($resultIEP->num_rows > 0) {

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
                            <h2>Individual Education Plan
                                for <?php echo $studentFirstName . " " . $studentLastName; ?></h2>
                            <table class="table table-striped">
                                <thead class="tableHeadsIEP">
                                    <tr class="viewHeader">

                                        <td>Reason for IEP</td>
                                        <td>Date Issued</td>
                                        <td>Plan Details</td>
                                        <td>Support Educator</td>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="tableInfo">

                                        <td><?php echo $reason; ?></td>
                                        <td><?php echo $dateIssued; ?></td>
                                        <td><?php echo $comments; ?></td>
                                        <td><?php echo $supportEducatorFirstName . " " . $supportEducatorLastName; ?></td>


                                    </tr>
                                </tbody>
                            </table>

                        <?php }
                    } else {
                        $msg = "This student has no IEP listed in the system";
                        echo "<div class='alert alert-danger'>$msg</div>";
                    }
                ?>
                <form method="post" action="displayReportCard.php">
                    <input type="hidden" id="selectStudent" name="selectStudent"
                           value="<?php echo $_POST['selectStudent']; ?>">
                    <input type="hidden" id="selectYear" name="selectYear"
                           value="<?php echo $_POST['selectYear']; ?>">
                    <input type="hidden" id="selectSemester" name="selectSemester"
                           value="<?php echo $_POST['selectSemester']; ?>">
                    <?php

                        $goBack1 = new Button();
                        $goBack1->buttonName = 'goBack';
                        $goBack1->buttonID = 'goBack';
                        $goBack1->buttonValue = 'Go Back';
                        $goBack1->buttonStyle = 'font-family:sans-serif';
                        //Back button works. Does not use the main.js file however. Requires that the page be reloaded.
                        $goBack1->display();
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
