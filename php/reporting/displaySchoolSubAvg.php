<?php
    /**
     * Created by PhpStorm.
     * STARS Beta Version 1.0
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This is the page used to request a school's subject average in a chosen subject.
     *
     * This page requires: stars.css, index.php, login.php, checkLoggedIn.php, dbConn.php, requestSchoolSubAverage.php
     */

    //Lock down page
    include "../login/checkLoggedIn.php";

    //Ensure admin level staff have view and can use this page
    include "../login/authenticateAdminPages.php";

    //Db connection
    include "../db/dbConn.php";

    // Button Class
    include("../button.class.php");

    //Selected info from request page
    $subject = $_POST["subjects"];
    $yearStart = $_POST["yearStart"];
    $yearEnd = $_POST["yearEnd"];

    //Get the school from the logged in administrator
    $userID = $_SESSION["userID"];
    $schoolID = 0;
    $schoolName = "";
    $emptyAverage = 0;

    //Declare array variable
    $array = array();

    if ($_SESSION['accessCode'] == 2) {

        $querySchoolID = "SELECT administrator.schoolID FROM administrator WHERE administrator.userID = $userID";

        $resultSchoolID = $database->query($querySchoolID);

        if ($resultSchoolID) {

            while ($row = $resultSchoolID->fetch_assoc()) {

                $schoolID = $row["schoolID"];

            }

        }

    }

    //Get distinct years from the selections
    $getSchoolYearsQuery = "SELECT DISTINCT semester.schoolYear FROM semester WHERE semester.schoolYear BETWEEN '$yearStart' AND '$yearEnd'";

    //Run initial query and get all school years from the database between the selected dates.
    $resultSetInitialQuery = $database->query($getSchoolYearsQuery);

    //Major if statement.
    //Gets each year selected and runs a query to perform against the database, subbing the year chosen in to be able to return distinct averages for each school year that the user desires.
    if ($resultSetInitialQuery) {

        while ($years = $resultSetInitialQuery->fetch_assoc()) {

            $schoolYear = $years["schoolYear"];

            if ($_SESSION['accessCode'] == 1) {

                $querySubjectAverage = "SELECT subject.subjectName, AVG (enrollment.mark) AS average 
						FROM school, subject, enrollment, courseoffering, course, semester, student
						WHERE subject.subjectCode = '$subject'
                        AND course.subjectCode = subject.subjectCode
						AND semester.schoolYear = '$schoolYear'
					  	AND enrollment.schoolYear = semester.schoolYear
						AND courseoffering.schoolYear = semester.schoolYear
						AND enrollment.classID = courseoffering.classID
						AND courseoffering.courseID = course.courseID;";

            } else if ($_SESSION['accessCode'] == 2) {

                $querySubjectAverage = "SELECT school.name, subject.subjectName, AVG (enrollment.mark) AS average 
						FROM school, subject, enrollment, courseoffering, course, semester, student
						WHERE school.schoolID = $schoolID
						AND student.schoolID = school.schoolID
						AND subject.subjectCode = '$subject'
                        AND course.subjectCode = subject.subjectCode
						AND semester.schoolYear = '$schoolYear'
					  	AND enrollment.schoolYear = semester.schoolYear
						AND courseoffering.schoolYear = semester.schoolYear
						AND enrollment.classID = courseoffering.classID
						AND courseoffering.courseID = course.courseID;";
            }

            $resultSetSubjectAverageQuery = $database->query($querySubjectAverage);

            if ($resultSetSubjectAverageQuery) {

                while ($row = $resultSetSubjectAverageQuery->fetch_assoc()) {

                    if ($_SESSION['accessCode'] == 1) {

                        $schoolName = "Province Wide";

                    } else if ($_SESSION['accessCode'] == 2) {

                        $schoolName = $row['name'];

                    }

                    $average = $row['average'];

                    //If the results of the average calculation is empty, show the provided message to the user.
                    //This would happen if there is no data to pull from between the selected dates or selected subject.
                    if ($average == null) {

                        $array[$schoolYear] = $emptyAverage;


                    } else {

                        $array[$schoolYear] = $average;

                    }
                }

            } else {

                $msg = "<p>No data is available for your selection.</p>";
            }
        }
    }

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

        <!-- JS/JQuery Links !-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- Here is where we call bootstrap. !-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!--Link to custom style sheet-->
        <link href="../../css/stars.css" rel="stylesheet">

        <!--function to go back to your incomplete form without losing previously filled fields-->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <title>STARS - Display School Average</title>
        <!--Script to create chart-->
        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            //Create a graphical chart
            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages': ['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            // Callback that creates and populates a data table,
            // instantiates the pie chart, passes in the data and
            // draws it.
            function drawChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Year');
                data.addColumn('number', 'Average');
                data.addRows([
                    <?php
                    foreach ($array as $key=>$value) {
                    ?> ['<?php echo $key; ?>', <?php echo $value; ?>], <?php
                    } ?>
                ]);

                // Set chart options

                var options = {
                    'title': '<?php echo $schoolName . " " . $subject; ?> Average',
                    chart: {

                        'title': '<?php echo $schoolName . " " . $subject; ?> Average',
                        //'width': 600,
                        //'height': 300
                    }, vAxis: {
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
                <?php
                if ( $array[$schoolYear] != $emptyAverage) {
                ?>
                chart.draw(data, options);
                <?php
                }
                else {
                    $error = "<p>Could not display subject average at this time.</p>";
                }
                ?>
            }
        </script>
    </head>
    <body>
        <?php include "../../header.php"; ?>

        <div class="jumbotron-fluid">
            <div class="container-fluid chart-sizer">

                <div class="container chart-container">
                    <h2>School Subject Average</h2>

                    <?php
                        if (isset($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <div class="row">
                        <div class="col-sm-12 " id="chart_div">
                        </div>
                    </div>
                    <?php

                        $goBack = new Button();

                        $goBack->buttonName = "goBack";
                        $goBack->buttonID = "goBack";
                        $goBack->buttonValue = "Go Back";
                        $goBack->buttonStyle = "font-family:sans-serif";
                        $goBack->buttonWeb = 'goBack()';
                        $goBack->display();
                    ?>

                </div>

            </div>
        </div>
        <!--Bottom navBar-->
        <div class="bottom">
            <div id="footer">
                <?php include("../../navMenu.php"); ?>
            </div>
        </div>
    </body>
</html>