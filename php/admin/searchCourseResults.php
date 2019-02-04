<?php
    /**
     * Created by PhpStorm.
     * User: sahra
     * Date: 2019-02-03
     * Time: 8:45 PM
     */

    include("../button.class.php");
    $confirm = new Button();

    include "../db/dbConn.php";

    //Get input of each item from employeeSearch
    $course = ($_GET['subjects']);
    $sort = ($_GET['sort']);

    //Deter SQL injection
    $cleanCourse = $database->real_escape_string($course);
    $cleanSort  = $database->real_escape_string($sort);

    $cleanResultsReturned = $database->real_escape_string($cleanCourse);


    //The SQL query for the search
    $query = "SELECT student.firstName, student.lastName, student.studentID 
      FROM student, courseoffering, course, enrollment 
      WHERE course.courseID = 12 
      AND courseoffering.courseID = course.courseID 
      AND enrollment.classID = courseoffering.classID 
      AND enrollment.studentID = student.studentID 
      ORDER By lastName $cleanSort";


    // Use $db object created above and run the query() method.
    $resultCourseSearch = $database->query($query);

    //Check/validate if there are items in the database object
    if ($resultCourseSearch->num_rows > 0)
    {
    //Validation passed, display search results to a table
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

        <!--function to go back to your incomplete album form without losing previously filled fields-->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>

    </head>

    <body>
        <div class="header">
            <img src="../../img/StarsWhiteFIN.jpg">
        </div>
        <div class="jumbotron-fluid">
            <div class="container-fluid">


                <h2 class="centerStuff">Search Results</h2>
                <!--The table-->
                <table class="table table-striped">
                    <tr id="viewHeader">
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Delete</th>


                    </tr>
                    <?php
                        while ($row = $resultCourseSearch->fetch_assoc()) {
                            ?>
                            <tr>
                                <td class="smCol"><?php echo $row['studentID'] ?></td>
                                <td class="nameCol"><?php echo $row['firstName'] ?></td>
                                <td class="nameCol"><?php echo $row['lastName'] ?></td>

                                <?php
                                    echo "<td><a class = 'delete' href='editStudent.php?studentID=" . $row['studentID'] . "'>Delete</a></td>";
                                ?>

                            </tr>
                            <?php
                        }
                        echo "</table>";
                        // if no results display message to advise user
                        } else {
                        echo "<h5 class='centerStuff'>Sorry there are no results for your search.</h5>";
                    }
                        //Reset link
                        echo "<br><h5 class = 'centerStuff'>Start a new <a href='searchStudent.php'>Search?</a></h5>";
                        echo "</div>";

                    ?>


                    <!--The bottom navbar/footer section-->
                    <div class="bottom">
                        <div id="footer">
                            <ul id="footerMenu">
                                <li class="titleNav">List One
                                    <ul class="dropupMenu">
                                        <li><a>List 1:1</a></li>
                                        <li><a>List 1:2</a></li>
                                        <li><a>List 1:3</a></li>
                                        <li><a>List 1:4</a></li>
                                    </ul>
                                </li>
                                <li class="titleNav">List Two
                                    <ul class="dropupMenu">
                                        <li><a>List 2:1</a></li>
                                        <li><a>List 2:2</a></li>
                                        <li><a>List 2:3</a></li>
                                        <li><a>List 2:4</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
    </body>
</html>
