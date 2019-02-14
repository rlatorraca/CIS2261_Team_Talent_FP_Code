<?php
    /**
     * Created by PhpStorm.
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This is the page used to request the school average in a particular subject.  Only available to admin users & sysAdmin.
     *
     * This page requires: stars.css, index.php, login.php, checkLoggedIn.php, dbConn.php, displayStudentSubHistory.php
     *
     */

    //Lock down page
    include "../login/checkLoggedIn.php";

    //Ensure only admin level staff have view of this page.
    include "../login/authenticateAdminPages.php";

    //Make connection to database
    include '../db/dbConn.php';

    include("../button.class.php");
    $confirm = new Button();

    //create the query to get subjects.
    $querySubject = "SELECT subject.subjectCode, subject.subjectName FROM subject";

    //create query to get date ranges
    $queryYear = "SELECT DISTINCT schoolYear FROM semester";
    //Execute queries and store results.
    $resultSubject = $database->query($querySubject);
    $resultYear = $database->query($queryYear);
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
        <title>STARS - School Avg</title>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!-- JS/JQuery links-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link href="../../css/stars.css" rel="stylesheet">

    </head>
    <body>
        <?php include "../../header.php"; ?>

        <div class="jumbotron-fluid">
            <div class="container-fluid">
                <!--Main container and contents-->
                <div class="container" id="studentSearch">
                    <!--Selected items-->
                    <form action="displaySchoolSubAvg.php" method="post">

                        <h2>School Subject Average</h2>
                        <p>To view the school's average in a particular subject select the subject and the years
                            you wish to view</p>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="subjects">Select Subject</label>
                                <select type="text" class="form-control" id="subjects"
                                        name="subjects">
                                    <!-- Using SQL to populate dropdown list of subjects -->
                                    <?php if ($resultSubject->num_rows > 0) {
                                        while ($row = $resultSubject->fetch_assoc()) {
                                            ?>
                                            <option
                                            value="<?php echo $row["subjectCode"]; ?>"><?php echo $row["subjectName"]; ?></option><?php
                                        }
                                    } else {
                                        echo "<option>No Subjects registered in STARS</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="yearStart">Start Date</label>
                                <select type="text" class="form-control" id="yearStart"
                                        name="yearStart">
                                    <!-- Using SQL to populate dropdown date range start -->
                                    <?php if ($resultYear->num_rows > 0) {
                                        while ($row = $resultYear->fetch_assoc()) {
                                            ?>
                                            <option><?php echo $row["schoolYear"]; ?></option><?php
                                        }
                                    } else {
                                        echo "<option>Unavailable</option>";
                                    }
                                    ?>
                                </select>
                                <br>
                            </div>

                            <div class="col-sm-4">
                                <label for="yearEnd">End Date</label>
                                <select type="text" class="form-control" id="yearEnd"
                                        name="yearEnd">
                                    <!-- Using SQL to populate dropdown date range end -->
                                    <?php
                                        $resultYear->data_seek(0); // Resets the pointer back to the beginning.
                                        if ($resultYear->num_rows > 0) {
                                            while ($row = $resultYear->fetch_assoc()) {
                                                ?>
                                                <option><?php echo $row["schoolYear"]; ?></option><?php
                                            }
                                        } else {
                                            echo "<option>Unavailable</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <!--View Report button-->
                                <div class="col-sm-12">
                                    <?php
                                        $confirm = new Button();

                                        $confirm->buttonName = "view";
                                        $confirm->buttonID = "view";
                                        $confirm->buttonValue = "View";
                                        $confirm->buttonStyle = "font-family:sans-serif";
                                        $confirm->display(); ?>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--The bottom navbar/footer section-->
        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
    </body>
</html>
