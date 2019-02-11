<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="../reporting/ajax.js"></script>

<script type="text/javascript" language="javascript">
    function ClearForm() {
        document.reset();
    }
</script>

<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 2019-01-27
 * Time: 9:05 PM
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
include "../db/dbConn.php";

// Button class
include("../button.class.php");


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


    <!-- JQuery Links !-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- JQuery Calendar Date Picker !-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Here is where we call bootstrap. !-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">


    <script src="../../js/main.js"></script>

    <!--Link to custom style sheet-->
    <link href="../../css/stars.css" rel="stylesheet">

    <!--   function to go back to your incomplete form without losing previously filled fields-->
    <!--    <script>-->
    <!--        function goBack() {-->
    <!--            window.history.back();-->
    <!--        }-->
    <!---->
    <!--        // This function shows the date picker.-->
    <!--        $(function () {-->
    <!--            $("#datepicker").datepicker();-->
    <!--        });-->
    <!---->
    <!--        // This function shows the note.-->
    <!--        // Will need to add a variable to get the notes to then call.-->
    <!--        $(function () {-->
    <!--            $(document).tooltip();-->
    <!--        });-->
    <!---->
    <!--        // This function manages the drop downs on the main menu.-->
    <!--        $(function () {-->
    <!--            $("#menu").menu();-->
    <!--        });-->
    <!--    </script>-->
    <title>Assign Student to a Course/Enrollment</title>


</head>
<body>
<?php include "../../header.php"; ?>

<div class="jumbotron-fluid">
    <div class="container-fluid container-sizer">

        <?php
        $msg = "";
        //To trigger when user submits request to add new Student to stars database
        if (isset($_POST["register"])) {

            //If details are empty, display a message and give redirect links. Otherwise, proceed.
            if ($_POST["subjectsAssignCourse"] == "" || $_POST["yearAsscourseSemesterYearAssignCourseignCourse"] == "" || $_POST["semesterYearAssignCourse"] == "" || $_POST["courseSemesterYearAssignCourse"] == "" || $_POST["studentAssignCourse"] == "") {
                echo "<h2>Error</h2><p>Form fields must not be empty before registering new student in a course.</p><br>";
                echo "<form action='assignCourse.php' method='post'><div class='row'><div class='col-md-6'><button class='button button2'>Try Again</button>
                                </div></form>";
                echo "<form action='../../index.php' method='post'><div class='col-md-6'><button class='button button2'>Return Home</button>
                              </div></form>";
                echo "</div></div><div class='bottom'><div id='footer'>";
                include('../../navMenu.php');
                exit("</div></div></body></html>");
            }

            $queryClassID = "SELECT classID FROM courseoffering WHERE courseID=" . mysqli_real_escape_string($database, $_POST['courseSemesterYearAssignCourse']) . " and schoolYear = '" . mysqli_real_escape_string($database, $_POST['yearAsscourseSemesterYearAssignCourseignCourse']) . "' and semesterNum = " . mysqli_real_escape_string($database, $_POST['semesterYearAssignCourse']) . ";";
            //var_dump($queryClassID);
            $resultClassID = $database->query($queryClassID);
            //var_dump($resultClassID);

            if ($resultClassID->num_rows > 0) {
                $row = $resultClassID->fetch_assoc();
            }

            //*******will need to pull the classID and StudentID somewhere
            //Sanitize user inputs to prepare for database insert query.
            $subject = $database->real_escape_string($_POST["subjectsAssignCourse"]);
            $schoolYear = $database->real_escape_string($_POST["yearAsscourseSemesterYearAssignCourseignCourse"]);
            $semesterNum = $database->real_escape_string($_POST["semesterYearAssignCourse"]);
            $classID = $database->real_escape_string($row['classID']);
            $studentID = $database->real_escape_string($_POST["studentAssignCourse"]);

            //Create initial SQL query to insert form data into database
            $queryEnrollment = "INSERT INTO enrollment(classID,schoolYear, semesterNum, studentID) 
                                        VALUES ('$classID', '$schoolYear', '$semesterNum', '$studentID');";

            //Execute query and store result.
            $result = $database->query($queryEnrollment);

            //Check if query executed successfully and that the result contains data.
            if (!$result) {
                echo "<h2>Error</h2><p>Sorry, student could not be registered in this course at this time.</p><br>";
                echo "<form action='assignCourse.php' method='post'><div class='row'><div class='col-md-6'><button class='button button2'>Try Again</button></div></form>";
                echo "<form action='../../index.php' method='post'><div class='col-md-6'><button class='button button2'>Return Home</button></div></div></form>";
            } else {
                $studentName = $_SESSION["studentNameForAssignToCourse"];
                echo "<h2>Student Assigned. </h2><p>$studentName with an ID of " . $studentID . " " . " has been assigned to " . $subject . " course (year: " . $schoolYear . ", semester: " . $semesterNum . ")</p><br>";
                echo "<form action='assignCourse.php' method='post'><div class='row'><div class='col-md-6'><button class='button button2'>Assign New</button></div></form>";
                echo "<form action='../../index.php' method='post'><div class='col-md-6'><button class='button button2'>Return Home</button>
                        </div></div></form>";
                echo "</div></div><div class='bottom'><div id='footer'>";
                include('../../navMenu.php');
                exit("</div></div></body></html>");

            }

            //Take details used in assign student to a course to generate/search for report cards
            //Report card query
            $queryReportCard = "SELECT * FROM reportcard WHERE studentID = $studentID 
                    AND schoolYear = '$schoolYear' AND semesterNum = '$semesterNum';";

            $resultReportCard = $database->query($queryReportCard);

            //If no report card is returned from the query, add one using the information.
            //Otherwise, proceed is normally and bypass the insert query.
            if ($resultReportCard->num_rows == 0) {

                $queryAddReportCard = "INSERT INTO reportcard (isRead, studentID, schoolYear, semesterNum) 
                            VALUES (0, $studentID, '$schoolYear', '$semesterNum')";

                $resultAddReportCard = $database->query($queryAddReportCard);

                if ($resultAddReportCard) {

                    //If successful, reload page

                    //header("Location: assignCourse.php");

                } else {

                    echo "<p>Issue adding a report card to STARS for Student $studentIDFromAssignToCourse</p>";

                }

            } else {


                //If no report card is generated, refresh the page.
                //header("Location: assignCourse.php");

            }

            //Close database connection
            $database->close();

        } else {

        $querySubject = "SELECT * FROM subject;";
        $resultSubject = $database->query($querySubject);

        $queryYearSemester = "SELECT * FROM courseoffering;";
        $resultYearSemester = $database->query($queryYearSemester);

        //Initialize variables to hold the queries and results for students.
        $queryStudent = "";
        $resultStudent = "";

        //Get school ID to populate student's dropdown
        if ($_SESSION["accessCode"] == 1) {

            $queryStudent = "SELECT studentID, firstName, lastName FROM student;";
            $resultStudent = $database->query($queryStudent);

        } else if ($_SESSION["accessCode"] == 2) {

            $userID = $_SESSION["userID"];
            $schoolID = 0;
            $querySchoolID = "SELECT schoolID FROM administrator WHERE userID = $userID;";

            $resultSchoolID = $database->query($querySchoolID);

            if ($resultSchoolID) {

                while ($row = $resultSchoolID->fetch_assoc()) {

                    $schoolID = $row["schoolID"];

                }

            }

            $queryStudent = "SELECT studentID, firstName, lastName FROM student WHERE schoolID = $schoolID;";
            $resultStudent = $database->query($queryStudent);

        }

        $querySemester = "SELECT * FROM semester;";
        $resultSemester = $database->query($querySemester);

        //Close database connection
        $database->close();

        ?>
        <form action="assignCourse.php" method="post">

            <h2>Student Details</h2>
            <p>**Please ensure all fields are filled before registering a new Student.</p>
            <div class="row">
                <div class="col-md-12">
                    <label for="subjectsAssignCourse">Subjects</label>
                    <select class="form-control" id="subjectsAssignCourse" name="subjectsAssignCourse">
                        <option value=''> Select</option>
                        <!-- Using SQL to populate dropdown list of students -->
                        <?php if ($resultSubject->num_rows > 0) {
                            while ($row = $resultSubject->fetch_assoc()) {
                                ?>
                                <option
                                value= <?php echo $row["subjectCode"] ?> ><?php echo $row["subjectCode"] . " - " . $row["subjectName"]; ?></option><?php
                            }
                        } else {
                            echo "<option>No Subjects</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="yearAsscourseSemesterYearAssignCourseignCourse">School Year</label>
                        <select class="form-control" id="yearAsscourseSemesterYearAssignCourseignCourse"
                                name="yearAsscourseSemesterYearAssignCourseignCourse">
                            <option value=''> Select</option>
                            <!-- Using SQL to populate dropdown list of students -->
                            <?php if ($resultSemester->num_rows > 0) {
                                $count = 1;
                                while ($row = $resultSemester->fetch_assoc()) {
                                    if (($count % 2) == 0) {
                                        ?>
                                        <option
                                        value= <?php echo $row["schoolYear"] ?>><?php echo $row["schoolYear"] ?></option><?php
                                    }
                                    $count++;
                                }
                            } else {
                                echo "<option>No Subjects</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <!--                    <label for="yearAsscourseSemesterYearAssignCourseignCourse">Year</label>-->
                <!--                    <select class="g" id="yearAsscourseSemesterYearAssignCourseignCourse"-->
                <!--                            name="yearAsscourseSemesterYearAssignCourseignCourse">-->
                <!--                        <option value=''>------- Select --------</option>-->
                <!--                        <option value='2015/2016'>2015/2016</option>-->
                <!--                        <option value='2016/2017'>2016/2017</option>-->
                <!--                        <option value='2017/2018'>2017/2018</option>-->
                <!--                        <option value='2018/2019'>2018/2019</option>-->
                <!--                        <option value='2019/2020'>2019/2020</option>-->
                <!--                    </select>-->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="semesterYearAssignCourse">Semester</label>
                    <select class="form-control" id="semesterYearAssignCourse"
                            name="semesterYearAssignCourse">
                        <option value=0> Select</option>
                        <option value="01">1st Semester</option>
                        <option value="02">2nd Semester</option>
                    </select>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">

                    <label for="courseSemesterYearAssignCourse">Course</label> <select class="form-control"
                                                                                       name="courseSemesterYearAssignCourse"
                                                                                       id="courseSemesterYearAssignCourse">
                        <option> Select</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="studentAssignCourse">Student</label>
                    <select class="form-control" id="studentAssignCourse" name="studentAssignCourse">
                        <option value=''> Select</option>
                        <!-- Using SQL to populate dropdown list of students -->
                        <?php if ($resultStudent->num_rows > 0) {
                            while ($row = $resultStudent->fetch_assoc()) {
                                ?>
                                <option
                                value= <?php echo $row["studentID"] ?> ><?php echo $row["studentID"] . " - "
                                    . $row["firstName"] . " " . $row["lastName"]; ?></option><?php
                                $_SESSION["studentNameForAssignToCourse"] = $row['firstName'] . " " . $row['lastName'];
                            }
                        } else {
                            echo "<option>No Students</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <!--                            <input type="submit" name="register" value="Register Student in Course">-->
                        <?php
                        $assignCourse = new Button();

                        $assignCourse->buttonName = "register";
                        $assignCourse->buttonID = "register";
                        $assignCourse->buttonValue = "Register Student in Course";
                        $assignCourse->buttonStyle = "font-family:sans-serif";
                        $assignCourse->display();
                        ?>

                    </div>
                </div>
        </form>
        <div><?php echo $msg ?></div>
    </div>
</div>


<div class="bottom">
    <div id="footer">
        <?php include("../../navMenu.php"); ?>
    </div>
</div>
</body>
</html>
<?php
}
?>
