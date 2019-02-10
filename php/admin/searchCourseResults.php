<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-02-03
 * Time: 8:45 PM
 */

include "../login/checkLoggedIn.php";

include "../login/authenticateAdminPages.php";


include("../button.class.php");
$confirm = new Button();

include "../db/dbConn.php";

//Get input of each item from search
$classID = ($_GET['subjects']);
$sort = ($_GET['sort']);

//Deter SQL injection
$cleanClassID = $database->real_escape_string($classID);
$cleanSort = $database->real_escape_string($sort);

$cleanResultsReturned = $database->real_escape_string($cleanClassID);

//The SQL query for the search
$query = "SELECT student.studentID, student.firstName, student.lastName 
          FROM student, courseoffering, course, enrollment
          WHERE enrollment.classID = $cleanClassID
            AND courseoffering.classID = enrollment.classID
            AND courseoffering.courseID = course.courseID
            AND enrollment.studentID = student.studentID
          ORDER By lastName ASC";

// Use $db object created above and run the query() method.
$resultCourseSearch = $database->query($query);
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
    <title>STARS - Search Results</title>
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

    <!--    function to go back to your incomplete album form without losing previously filled fields-->
    <!--    <script>-->
    <!--        function goBack() {-->
    <!--            window.history.back();-->
    <!--        }-->
    <!--    </script>-->

</head>

<body>
    <?php include "../../header.php"; ?>
<div class="jumbotron-fluid">
    <div class="container-fluid">


        <h2 class="centerStuff">Search Results</h2>

        <!--Check/validate if there are items in the database object-->
	    <?php if ($resultCourseSearch->num_rows > 0)
	    {
	    //Validation passed, display search results to a table
	    ?>
        <!--The table-->
        <table class="table table-striped">
            <thead>
            <tr id="viewHeader">
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = $resultCourseSearch->fetch_assoc()) {
                ?>
                <tr>
                    <td class="smCol"><?php echo $row['studentID'] ?></td>
                    <td class="nameCol"><?php echo $row['firstName'] ?></td>
                    <td class="nameCol"><?php echo $row['lastName'] ?></td>
                    <?php
                    //$url = "'deleteEnrollment.php?studentID='".$row['studentID']."'&classID='".$classID;
                    echo "<td><a class='delete' href='deleteEnrollment.php?studentID=".$row["studentID"]."&classID=".$classID."'>Delete</a></td>";
                    ?>
                </tr>
                <?php
            }
            echo "</tbody></table>";
            // if no results display message to advise user
            } else {
                echo "<h5 class='centerStuff'>Sorry there are no results for your search.</h5>";

            }
            //Reset link
            echo "<br><h5 class = 'centerStuff'>Start a new <a href='searchCourses.php'>Search?</a></h5>";
            echo "</div>";

            ?>


            <!--The bottom navbar/footer section-->
                <div class="bottom">
                    <div id="footer">
	                    <?php include("../../navMenu.php"); ?>
                    </div>
                </div>
    </div>
</body>
</html>
