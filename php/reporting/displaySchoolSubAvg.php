<?php
    /**
     * Created by PhpStorm.
     * Created and edited by: Team Talent 2.0
     * Date: 2019-01-27
     * Time: 9:00 PM
     */

    //Lock down page
    include "../login/checkLoggedIn.php";

    //Ensure admin level staff have view and can use this page
    include "../login/authenticateAdminPages.php";

    //Db connection
    include "../db/dbConn.php";

    //Selected info from request page
    $subject = $_POST["subjects"];
    $yearStart = $_POST["yearStart"];
    $yearEnd = $_POST["yearEnd"];

    //Get the school from the logged in administrator
    $userID = $_SESSION["userID"];
    $schoolID = 0;

    $querySchoolID = "SELECT administrator.schoolID FROM administrator WHERE administrator.userID = $userID";

    $resultSchoolID = $database->query($querySchoolID);

    if ($resultSchoolID) {

        while ($row = $resultSchoolID->fetch_assoc()) {

            $schoolID = $row["schoolID"];

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
            echo $schoolYear;

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

            $resultSetSubjectAverageQuery = $database->query($querySubjectAverage);

            if ($resultSetSubjectAverageQuery) {

                //Create array to store values of school years and averages
                $array[]=0;

                //$array = [];

                while ($row = $resultSetSubjectAverageQuery->fetch_assoc()) {

                    //$array[$schoolYear] = $row['average'];

                    //array_push($array, array($schoolYear => $row['average']));

                    //If the results of the average calculation is empty, show the provided message to the user.
                    //This would happen if there is no data to pull from between the selected dates or selected subject.
                    if ($row["average"] == "") {

                        //Output message. To graph, use 0.00 to indicate that no average was calculated. (Or 100.00 but I don't think so??????)
//                        echo "<p>Sorry, there is no school enrollment data in STARS to calculate chosen subject's average at this time.</p>";
//                        ?><!--<p>--><?php //echo $row["name"] . ": " . $row["subjectName"] . " = " . 0.00; ?><!--</p>--><?php

                        $row["average"] = 0;
                        $array[$schoolYear] = $row["average"];



                    } else {

                        //Returned information to graph on the page.
//                        ?><!--<p>--><?php //echo $row["name"] . ": " . $row["subjectName"] . " = " . $row["average"]; ?><!--</p>--><?php

                        $array[$schoolYear] = $row['average'];


                    }

                }

            } else {

                echo "<p>Could not display select subject average at this time.</p>";

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
        <title>STARS - Display School Average</title>
        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

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
                data.addColumn('number', 'Mark');
                data.addRows([
                    <?php
                    foreach ($array as $key=>$value) {
                    ?> ['<?php echo $key; ?>', <?php echo $value; ?>], <?php
                    } ?>
                ]);

                // Set chart options
                var options = {
                    'title': 'School Subject Average',
                    'width': 500,
                    'height': 300
                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <!--Div that will hold the chart-->
        <div id="chart_div"></div>
    </body>
</html>