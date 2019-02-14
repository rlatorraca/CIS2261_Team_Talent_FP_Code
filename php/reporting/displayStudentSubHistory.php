<?php
    /**
     * Created by PhpStorm.
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This is the page used when user request display a student's subject history.
     *
     * This page requires: stars.css, index.php, login.php, checkLoggedIn.php, dbConn.php, requestStudentSubHistory.php
     *
     */
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Fonts !-->
        <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Roboto" rel="stylesheet">

        <!-- JQuery Links !-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- JS/JQuery links-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- Here is where we call bootstrap. !-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!--Link to custom style sheet-->
        <link href="../../css/stars.css" rel="stylesheet">
        <script src="../../js/main.js"></script>

        <?php

            // Button Class
            include("../button.class.php");

            //Lock down page
            include "../login/checkLoggedIn.php";

            //Database connection
            include "../db/dbConn.php";

            //Selected info from request page
            $student = $_POST["students"];
            $subject = $_POST["subjects"];
            $yearStart = $_POST["yearStart"];
            $yearEnd = $_POST["yearEnd"];

            $queryStudentHistory = "SELECT student.studentID, student.firstName, student.lastName, course.courseName, 
          subject.subjectCode, subject.subjectName, enrollment.mark, enrollment.schoolYear, enrollment.semesterNum 
          FROM student, enrollment, course, courseoffering, subject 
          WHERE student.studentID = $student 
          AND enrollment.schoolYear BETWEEN '$yearStart' AND '$yearEnd'
          AND enrollment.studentID = student.studentID 
          AND enrollment.classID = courseoffering.classID 
          AND courseoffering.courseID = course.courseID 
          AND subject.subjectCode = '$subject'
          AND course.subjectCode = subject.subjectCode ORDER BY enrollment.schoolYear ";

            $resultSubHistory = $database->query($queryStudentHistory);
            $resultSubHistory2 = $database->query($queryStudentHistory);
            $resultSubName = $database->query($queryStudentHistory);

            //Check/validate if there are items in the database object
            if ($resultSubHistory->num_rows > 0) {

            //Display results to a table
            //Create array to store values of school years and averages
            $array = array();

            while ($row = $resultSubHistory->fetch_assoc()) {

                //If the results of the average calculation is empty, show the provided message to the user.
                //This would happen if there is no data to pull from between the selected dates or selected subject.
                if ($row["mark"] == null) {

                    $row["mark"] = 0;
                    $array[$row["schoolYear"] . " - " . $row["semesterNum"]] = $row["mark"];

                } else {

                    $array[$row["schoolYear"] . " - " . $row["semesterNum"]] = $row['mark'];

                }
            }
        ?>
        <!--Creating the graphical chart-->
        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages': ['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            // Callback that creates and populates a data table, instantiates the pie chart, passes in the data and
            // draws it.
            function drawChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Year');
                data.addColumn('number', 'Mark');
                data.addRows([
                    <?php
                    foreach ($array as $key=>$value) {
                    ?> ['<?php echo $key; ?>', <?php echo $value; ?>], <?php
                    } ?>
                ]);

                // Set chart options
                var options = {
                    chart: {
                        'title': 'School Subject Average',
                    },
                    vAxis: {
                        viewWindowMode: 'explicit',
                        viewWindow: {
                            max: 0,
                            min: 100
                        }
                    },
                    bars: 'horizontal', // Required for Material Bar Charts.
                    width: 625,
                    height: 300
                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
        <title>STARS - Display School Average</title>
    </head>

    <body>
        <?php include "../../header.php"; ?>

        <div class="jumbotron-fluid">
            <div class="container-fluid chart-sizer">
                <!--Main container-->
                <div class="container chart-container">
                    <?php
                        //Display results or message
                        if ($row = $resultSubName->fetch_assoc()) {
                            ?>
                            <h2><?php echo $row["firstName"] . " " . $row["lastName"] . "'s History for " . $row["subjectName"]; ?></h2>
                            <?php
                        } else {
                            echo "<p>Empty</p>";
                        } ?>
                    <br>

                    <div class="row">
                        <!--Div that will hold the chart-->
                        <div class="col-sm-12 " id="chart_div"></div>
                        <div>&nbsp;</div>
                        <table class="table table-striped">
                            <thead class="tableHeads">
                                <tr id="viewHeader">
                                    <th>Course</th>
                                    <th>Mark</th>
                                    <th>School Year</th>
                                    <th>Semester</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($row2 = $resultSubHistory2->fetch_assoc()) {
                                        ?>
                                        <tr class="tableInfo">
                                            <td><?php echo $row2['courseName'] ?></td>
                                            <td><?php if ($row2['mark'] == null) {
                                                    echo 0;
                                                } else {
                                                    echo $row2['mark'];
                                                } ?></td>
                                            <td><?php echo $row2['schoolYear'] ?></td>
                                            <td><?php echo $row2['semesterNum'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    } else {
                                    $error = "<h5>Sorry, there are no marks in STARS to view in the selected subject.</h5>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                            if (isset($error)) {
                                include "../../header.php";
                                echo "<div class='jumbotron-fluid'>";
                                echo "<div class='container-fluid chart-sizer'>";
                                echo "<div class='container chart-container'>";
                                echo "<br><div class='alert alert-danger'>$error</div>";
                            }

                            $button = new Button();

                            $button->buttonName = "goBack";
                            $button->buttonID = "goBack";
                            $button->buttonValue = "Go Back";
                            $button->buttonStyle = "font-family:sans-serif";
                            $button->buttonWeb = "goBack()";
                            $button->display();

                        ?>
                    </div>
                    <script>
                        function goBack() {
                            window.history.back();
                        }
                    </script>
                </div>
            </div>
        </div>
        <!--Bottom navbar-->
        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
    </body>
</html>
