<?php
    /**
     * Created by PhpStorm
     * Edited by: John Gaudet
     * Date: 2019-01-27
     * Time: 8:49 PM
     *
     * 2019/01/28: Functionality mostly there. Able to pull user ID from prior screen but cannot use to insert into database.
     *
     * Changed functionality approach to use username instead of userID
     */

    //Lock down page
    include "../login/checkLoggedIn.php";

    //Ensure only admin/system admin staff can view this page.
    include "../login/authenticateAdminPages.php";

    //Database connection
    include "../db/dbConn.php";

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
        <!--Datepicker-->
        <script>
            $(function () {
                $("#datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true
                });
            });
        </script>
        <!--function to go back to your incomplete form without losing previously filled fields-->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>

        <title>STARS - Add Student</title>
    </head>
    <body>

            <div class="header">
                <img src="../../img/StarsWhiteFIN.jpg">
            </div>

            <div class="jumbotron-fluid">
                <div class="container-fluid">
                    <!--Main container and contents-->
                    <div class="container main-container" id="addStudent">

                        <form action="confirmStudent.php" method="post">
                            <h2>Student Details</h2>
                            <p><span style="color:red">*Please ensure all form fields are filled</span></p>
                            <fieldset>
                                <legend>Student Details</legend>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="firstName">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName"><br>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="middleName">Middle Name(s)</label>
                                        <input type="text" class="form-control" id="middleName" name="middleName"><br>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName"><br>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="gender">Gender</label>
                                        <select class="form-control" type="text" name="gender">
                                            <option name="Male">Male</option>
                                            <option name="Female">Female</option>
                                            <option name="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="datepicker" class="col-md-6">Date of Birth</label>
                                        <input type="text" id="datepicker" name="dob"><br>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="gender">Gender</label>
                                        <label for="grade" class="col-md-6">Grade</label>
                                        <select class="form-control" name="grade">
                                            <option name="10">10</option>
                                            <option name="11">11</option>
                                            <option name="12">12</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="address">Address</label><br/>
                                        <textarea class="form-control" id="address" name="address"
                                                  placeholder="Enter home address" cols="40"
                                                  rows="4"></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="phoneNum">Phone Number</label>
                                        <input type="text" name="phoneNum" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="emailAddress">Email Address</label>
                                        <input type="text" name="emailAddress" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="allergies">Allergies</label><br/>
                                        <textarea class="form-control" id="allergies" name="allergies"
                                                  placeholder="List allergies and any details" cols="40"
                                                  rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="selectSchool">School</label>
                                        <select class="form-control" name="selectSchool">
                                            <?php
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
                                    <div class="col-sm-6">
                                        <label for="selectParentGuardian">Parent/Guardian</label>
                                        <select class="form-control" name="selectParentGuardian">
                                            <option value=NULL>None</option>
                                            <?php
                                                $queryParentGuardians = "SELECT guardianID, parentFName, parentLName FROM parentorguardian";
                                                $resultsFromParentGuardian = $database->query($queryParentGuardians);
                                                if ($resultsFromParentGuardian->num_rows > 0) {
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
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" class="form-control"
                                               value="<?php echo $_SESSION['username'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="selectSupportEducator">Support Educator</label>
                                        <select name="selectSupportEducator">
                                            <option value=NULL>None</option>
                                            <?php
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
                                </div>

                                <!--Register student button-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php
                                            $confirm = new Button();

                                            $confirm->buttonName = "reset";
                                            $confirm->buttonID = "reset";
                                            $confirm->buttonValue = "Reset";
                                            $confirm->buttonStyle = "font-family:sans-serif";
                                            $confirm->display(); ?>

                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                            $confirm = new Button();

                                            $confirm->buttonName = "add";
                                            $confirm->buttonID = "add";
                                            $confirm->buttonValue = "Add";
                                            $confirm->buttonStyle = "font-family:sans-serif";
                                            $confirm->display(); ?>
                                    </div>
                                </div>
                            </fieldset>
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


