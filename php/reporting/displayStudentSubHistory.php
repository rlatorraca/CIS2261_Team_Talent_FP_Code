<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 9:00 PM
 */

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

//Display results or message
if ($row = $resultSubName->fetch_assoc()) {
	?><h2><?php echo $row["firstName"] . " " . $row["lastName"] . "'s History for " . $row["subjectName"]; ?></h2>
	<?php
} else {
	echo "<p>Empty</p>";
}


//Check/validate if there are items in the database object
if ($resultSubHistory->num_rows > 0) {

//Display results to a table
//Create array to store values of school years and averages
$array = array();

//$array = [];


while ($row = $resultSubHistory->fetch_assoc()) {


	//If the results of the average calculation is empty, show the provided message to the user.
	//This would happen if there is no data to pull from between the selected dates or selected subject.
	if ($row["studentID"] == "") {

		$row["mark"] = 0;
		$array[$row["schoolYear"] . " - " . $row["semesterNum"]] = $row["mark"];

	} else {
		$array[$row["schoolYear"] . " - " . $row["semesterNum"]] = $row['mark'];


	}


}

//    } else {
//
//	echo "<p>Could not display select subject average at this time.</p>";
//
//    }


?>
<!DOCTYPE HTML>
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
                chart: {
                    'title': 'School Subject Average',
                    // 'width': 500,
                    // 'height': 300
                },
                vAxis: {
                    viewWindowMode: 'explicit',
                    viewWindow: {
                        max: 0,
                        min: 100
                    }
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                width: 500,
                height: 300
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

<table class="table table-striped">
    <thead>
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
        <tr>
            <td><?php echo $row2['courseName'] ?></td>
            <td><?php echo $row2['mark'] ?></td>
            <td><?php echo $row2['schoolYear'] ?></td>
            <td><?php echo $row2['semesterNum'] ?></td>
        </tr>
		<?php
	}
	} else {
		?>
        <h2><?php echo "Subject History" ?></h2><?php
		echo "<option>Sorry, there are no marks in STARS to view in the selected subject.</option>";
	}
	?>
    </tbody>
</table>


</body>
</html>
