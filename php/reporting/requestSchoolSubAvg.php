<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 8:58 PM
 */
?>
<!--Form to request to view a schoolS' average in a subject
Requires user, user id, user school, school id, subjects, courses associated to subjects, grades, years & semester-->
<form action="displaySchoolSubAvg.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">

                <!--populate a header? with the name of the school associated with the user.  Use that hidden ID to write SQL-->

                <input type="hidden" class="form-control" id="isbn" name="isbn"
                       value="<?php echo $row['isbn'] ?>">


            </div>
            <div class="col-3">
                <label for="selectSubject">Select Subject</label>
                <br>
                <select class="g" id="selectSubject" name="selectSubject">
                    <!-- Here we need to use SQL queries to populate the dropdown with available subjects -->
                    //Create a new connection object using mysqli

                    <?php

                    //*****************attempting dropdown of school subjects**********************************************************

                    //Create a new connection object using mysqli
                    @
                    $db = new mysqli('localhost', 'root', '', 'stars');

                    //if cannot connect to database, display message to user & close db
                    if (mysqli_connect_errno()) {
                        echo 'Error: Could not connect to database.  Please try again later.</body></html>';
                        $db->close();
                        exit;
                    }

                    //Get schoolID of user
                    $schoolID = ($_GET['schoolID']);

                    //Deter SQL injection
                    $cleanSchoolID = $db->real_escape_string($schoolID);

                    //The SQL query to populate the dropdown of subjects based on schoolID
                    if ($result) {
                        $query = "SELECT subject.subjectName FROM subject, school WHERE school.schoolID = '69'";
                    } else {
                        //if cannot connect to db let user know, offer link back to ??????????????????
                        echo "An error has occurred.  Would you like to <a href='requestSchoolSubAvg.php'>try again?</a>";

                        $db->close();
                    }

                    $result = $db->query($query);
                    //Get the num_rows attribute of the $result object
                    //This is key to knowing if we should show the results or display an error message etc
                    $num_results = $result->num_rows;

                    //echo "<p>Total Results: $num_results</p>";

                    //Check/validate if there are items in the database object
                    if ($result->num_rows > 0)

                        //*****************************************************************************

                        for ($i = 2016; $i <= 2020; $i++) {
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label for="semester">Select Year Range</label>
                <br>
                <select class="g" id="selectYearBegin" name="selectYearBegin">
                    <!-- Here we need to use SQL queries to populate the dropdowns -->
                    <?php
                    for ($i = 2016; $i <= 2020; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <select class="g" id="selectYearEnd" name="selectYearEnd">
                    <!-- Here we need to use SQL queries to populate the dropdowns -->
                    <?php
                    for ($i = 2016; $i <= 2020; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <!-- Button elements declared here. Button includes is above with button object declared. !-->
            <?php
            $confirm->buttonName = "Submit";
            $confirm->buttonValue = "Request";
            $confirm->buttonStyle = "font-family:sans-serif";
            $confirm->display(); ?>
</form>