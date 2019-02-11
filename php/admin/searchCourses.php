<?php
/**
 * Created by PhpStorm.
 * Firm: Team Talent 2.0
 * Members: Sara, John, Rodrigo, Steve
 * Date: 2019-01-14
 * Time: 12:09 AM
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Ensure only admin/system admin staff can view and use page
include "../login/authenticateAdminPages.php";

include("../button.class.php");
$confirm = new Button();

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
        <title>STARS - Enrollments</title>
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


    </head>
    <?php
    include '../db/dbConn.php';
    //create query to get courses
    $queryCourse = "SELECT course.courseName, courseoffering.schoolYear, courseoffering.semesterNum, 
                courseoffering.classID FROM course, courseoffering, semester 
                WHERE course.courseID = courseoffering.courseID
                AND courseoffering.schoolYear = semester.schoolYear
                AND courseoffering.semesterNum = semester.semesterNum;";

    //Execute queries and store results.
    $resultCourse = $database->query($queryCourse);
    ?>
    <body>
        <?php include "../../header.php"; ?>


        <div class="jumbotron-fluid">
            <div class="container-fluid container-sizer">

                <!--Main container and contents-->
                <div class="container main-container scaler" id="courseSearch">
                    <form action="searchCourseResults.php" method="get">
                        <div class="form-group">
                            <h2>Search Courses</h2>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="courses">Select Course & Semester</label><br>
                                    <select type="text" class="form-control" id="courses" name="subjects">
                                        <!-- Using SQL to populate dropdown list of subjects -->
                                        <?php if ($resultCourse->num_rows > 0) {
                                            while ($row = $resultCourse->fetch_assoc()) {
                                                ?>
                                                <option
                                                value="<?php echo $row["classID"]; ?>"><?php echo $row["courseName"] . " - " . $row["schoolYear"] . "-" . $row["semesterNum"]; ?></option><?php
                                            }
                                        } else {
                                            echo "<option>No Courses registered in STARS</option>";
                                        }
                                        ?>
                                    </select><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="sort">Sort</label>
                                    <select type="text" class="form-control" id="sort" name="sort">
                                        <option value="ASC" selected>Ascending</option>
                                        <option value="DESC">Descending</option>
                                    </select><br>
                                </div>
                            </div>

                            <!--Search button-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    $confirm = new Button();

                                    $confirm->buttonName = "search";
                                    $confirm->buttonID = "search";
                                    $confirm->buttonValue = "Search";
                                    $confirm->buttonStyle = "font-family:sans-serif";
                                    $confirm->display(); ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--The bottom navbar/footer section-->
            <div class="bottom">
                <div id="footer">
                    <?php include("../../navMenu.php"); ?>
                </div>
            </div>
        </div>
    </body>
</html>