<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 8:49 PM
 */

include "../db/dbConn.php";

if (isset($_POST["update"])) {



} else {

//Get studentID from list page of students
    $studentID = 7;

    $queryStudent = "SELECT * FROM student WHERE studentID = 7;";

    $resultSetFromQueryStudent = $database->query($queryStudent);

    if ($resultSetFromQueryStudent->num_rows == 1) {

        while ($row = $resultSetFromQueryStudent->fetch_assoc()) {

            $firstName = $row["firstName"];
            $middleName = $row["middleName"];
            $lastName = $row["lastName"];
            $gender = $row["gender"];
            $dob = $row["dob"];
            $grade = $row["grade"];
            $address = $row["address"];
            $phoneNumber = $row["phoneNum"];
            $emailAddress = $row["emailAddress"];
            $allergies = $row["allergies"];

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

                    <!--Link to custom style sheet-->
                    <link href="../../css/stars.css" rel="stylesheet">

                    <!-- JQuery Links !-->
                    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                    <link rel="stylesheet" href="/resources/demos/style.css">
                    <!-- JQuery Calendar Date Picker !-->
                    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

                    <!-- Here is where we call bootstrap. !-->
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                            crossorigin="anonymous"></script>

                    <!--function to go back to your incomplete form without losing previously filled fields-->
                    <script>
                        function goBack() {
                            window.history.back();
                        }

                        // This function shows the date picker.
                        $(function () {
                            $("#datepicker").datepicker();
                        });

                        // This function shows the note.
                        // Will need to add a variable to get the notes to then call.
                        $(function () {
                            $(document).tooltip();
                        });

                        // This function manages the drop downs on the main menu.
                        $(function () {
                            $("#menu").menu();
                        });
                    </script>
                    <title>STARS - Edit Student</title>
        </head>
        <body>
            <div class="header">
                <img src="../../img/StarsWhiteFIN.jpg">
            </div>
            <div class="jumbotron-fluid">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-6">Testing</div>
                        <div class="col-sm-6">Testing 2</div>

                    </div>

            <form action="editStudent.php" method="post">
                    <h2>Student Details</h2>
                    <p>**Please ensure all fields are filled before editing a Student's details.</p>
                    <div class = "row">
                    <div class="col-sm-6">
                        <label for="studentID">Student ID</label>
                        <input type="text" name="studentID" class="form-control" value="7">
                    </div>
                    <div class="col-sm-6">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstName" class="form-control"
                               value="<?php echo $firstName; ?>">
                    </div>
                    </div>
                <div class = "row">
                    <div class="col-sm-6">
                        <label for="middlename">Middle Name</label>
                        <input type="text" name="middleName" class="form-control"
                               value="<?php echo $middleName; ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="title">Last Name</label>
                        <input type="text" name="lastName" class="form-control"
                               value="<?php echo $lastName; ?>">
                    </div>
                </div>
                <div class = "row">
                    <div class="col-sm-6">
                        <label for="title">Gender</label>
                        <input type="text" name="gender" class="form-control"
                               value="<?php echo $gender; ?>">
                    </div>
                    <!-- Add proper date picker to allow for a date in proper format to be selected-->
                    <div class="col-sm-6">
                        <label for="title">Date of Birth</label>
                        <input type="text" name="dob" class="form-control"
                               value="<?php echo $dob; ?>">
                    </div>
                </div>
                <div class = "row">
                    <div class="col-sm-6">
                        <label for="title">Grade</label>
                        <select name="grade">
                            <option name="10">10</option>
                            <option name="11">11</option>
                            <option name="12">12</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="title">Address</label>
                        <input type="text" name="address" class="form-control"
                               value="<?php echo $address; ?>">
                    </div>
                </div>
                <div class = "row">
                    <div class="col-sm-6">
                        <label for="title">Phone Number</label>
                        <input type="text" name="phoneNum" class="form-control"
                               value="<?php echo $phoneNumber; ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="title">Email Address</label>
                        <input type="text" name="emailAddress" form-control"
                               value="<?php echo $emailAddress; ?>">
                    </div>
                </div>
                <div class = "row">
                    <div class="col-sm-6">
                        <label for="title" >Allergies</label>
                        <input type="text" name="allergies" class="form-control"
                               value="<?php echo $allergies; ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="title" >School</label>
                        <select name="selectSchool">
                            <?php
                            //Needs work done
                            $querySchools = "SELECT schoolID, name FROM school";
                            $resultFromSchoolQuery = $database->query($querySchools);
                            if ($resultFromSchoolQuery->num_rows > 0) {
                                while ($schoolResults = $resultFromSchoolQuery->fetch_assoc()) {
                                    ?>
                                    <option
                                    value="<?php echo $schoolResults["schoolID"]; ?>"><?php echo $schoolResults["name"]; ?></option><?php
                                }
                            } else {
                                echo "<option>There are no Schools registered in STARS</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-sm-6">
                        <label for="title">Parent/Guardian</label>
                        <select name="selectParentGuardian">
                            <?php
                            //Currently working on this here (to also handle if the student has no parent/guardian listed)
                            $queryParentGuardians = "SELECT guardianID, parentFName, parentLName FROM parentorguardian, student WHERE student.studentID = $studentID AND parentorguardian.guardianID = student.guardianID";
                            $resultsFromParentGuardian = $database->query($queryParentGuardians);
                            if ($resultsFromParentGuardian->num_rows == 1) {
                                while ($parentGuardianResultSet = $resultsFromParentGuardian->fetch_assoc()) {
                                    ?>
                                <option value="<?php echo $parentGuardianResultSet["guardianID"]; ?>">
                                    <?php echo $parentGuardianResultSet["parentFName"] . " "
                                        . $parentGuardianResultSet["parentLName"]; ?></option><?php
                                }
                            } else {
                                echo "<option>There are no Parent/Guardians registered in STARS</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="title">Username</label>
                        <input type="text" name="username" class="form-control"
                               value="<?php echo $_SESSION['username'] ?>" readonly>

                    </div>
                </div>
                <div class = "row">
                    <div class="col-sm-6">
                        <label for="title">Support Educator</label>
                        <select name="selectSupportEducator">
                            <option value=NULL>None</option>
                            <?php
                            //Also needs work done
                            $querySupportEducators = "SELECT supportEducatorID, supFName, supLName FROM supporteducator";
                            $resultsSupportEducators = $database->query($querySupportEducators);
                            if ($resultsSupportEducators->num_rows > 0) {
                                while ($supportEducatorResultSet = $resultsSupportEducators->fetch_assoc()) {
                                    ?>
                                <option value="<?php echo $supportEducatorResultSet["supportEducatorID"] ?>">
                                    <?php echo $supportEducatorResultSet["supFName"] . " "
                                        . $supportEducatorResultSet["supLName"]; ?></option><?php
                                }
                            } else {
                                echo "<option>There are no Support Educators registered in STARS</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <input type="submit" name="update" value="Update Student">
                    </div>
                </div>
            </form>
                </div>
            </div>

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
        </body>
    </html>
<?php
}
//Close db connection
$database->close();
?>

