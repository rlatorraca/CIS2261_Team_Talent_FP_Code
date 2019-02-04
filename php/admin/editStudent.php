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
            <title>Edit Student</title>
        </head>
        <body>
            <p>**Please ensure all fields are filled before editing a Student's details.</p>
            <form action="editStudent.php" method="post">
                <fieldset>
                    <legend>Student Details</legend>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="isbn" class="col-md-6">Student ID</label>
                        <input type="text" name="studentID" class="col-md-6 form-control" value="7">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="author" class="col-md-6">First Name</label>
                        <input type="text" name="firstName" class="col-md-6 form-control"
                               value="<?php echo $firstName; ?>">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Middle Name</label>
                        <input type="text" name="middleName" class="col-md-6 form-control"
                               value="<?php echo $middleName; ?>">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Last Name</label>
                        <input type="text" name="lastName" class="col-md-6 form-control"
                               value="<?php echo $lastName; ?>">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Gender</label>
                        <input type="text" name="gender" class="col-md-6 form-control"
                               value="<?php echo $gender; ?>">
                    </div>
                    <!-- Add proper date picker to allow for a date in proper format to be selected-->
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Date of Birth</label>
                        <input type="text" name="dob" class="col-md-6 form-control"
                               value="<?php echo $dob; ?>">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Grade</label>
                        <select name="grade">
                            <option name="10">10</option>
                            <option name="11">11</option>
                            <option name="12">12</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Address</label>
                        <input type="text" name="address" class="col-md-6 form-control"
                               value="<?php echo $address; ?>">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Phone Number</label>
                        <input type="text" name="phoneNum" class="col-md-6 form-control"
                               value="<?php echo $phoneNumber; ?>">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Email Address</label>
                        <input type="text" name="emailAddress" class="col-md-6 form-control"
                               value="<?php echo $emailAddress; ?>">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Allergies</label>
                        <input type="text" name="allergies" class="col-md-6 form-control"
                               value="<?php echo $allergies; ?>">
                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">School</label>
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
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Parent/Guardian</label>
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
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Username</label>
                        <input type="text" name="username" class="col-md-6 form-control value="
                               value="<?php echo $_SESSION['username'] ?>" readonly>

                    </div>
                    <div class="col-md-12 form-inline customDiv">
                        <label for="title" class="col-md-6">Support Educator</label>
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
                    <div class="col-md-12">
                        <input type="submit" name="update" value="Update Student">
                    </div>
                </fieldset>
            </form>
        </body>
    </html>
<?php
}
//Close db connection
$database->close();
?>

