<?php
    /**
     * Created by PhpStorm.
     * User: sahra
     * Date: 2019-01-27
     * Time: 8:58 PM
     */
?>
<!--Form to request to view a schoolS' average in a subject


<?php

    //*****************creating dropdown of school subjects**********************************************************
    //Get schoolID of user
    //$schoolID = ($_GET['schoolID']);

    //Deter SQL injection
    //$cleanSchoolID = $db->real_escape_string($schoolID);
    //echo "got here1";

    //Create a new connection object using mysqli
    @ $database = new mysqli('localhost', 'root', '', 'stars');
    if (mysqli_connect_errno()) {
        echo '<h2>An error has occurred.  Would you like to <a href=\'requestSchoolSubAvg.php\'>try again?</a></h2>';
        exit("</div></body></html>");
        $db->close();
    }
    //create the query
    $querySubject = "SELECT subject.subjectName FROM subject, school WHERE school.schoolID = 69";
    $queryYear = "SELECT DISTINCT schoolYear FROM `semester`";;
    //Execute query and store result.
    $resultSubject = $database->query($querySubject);
    $resultYear = $database->query($queryYear);
?>

<form action="displaySchoolSubAvg.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">
                <!--populate a header? with the name of the school associated with the user.  Use that hidden ID to write SQL-->
                <!---->
                <!--                <input type="hidden" class="form-control" id="isbn" name="isbn"-->
                <!--                       value="--><?php //echo $row['isbn'] ?><!--">-->

            </div>
            <div class="col-3">
                <!--Check to see what years data exists for the chosen subject....-->
                <?php
                    if ($resultSubject->num_rows < 1) {
                        echo "<label for='course'>Select Course</label>
                        <select name=student ></option>";
                        {
                            echo "<option value=''>No Results</option>";
                        }
                        echo "</select>";
                        //if results exist
                    } else if ($resultSubject) {
                        //while ($row = mysqli_fetch_assoc($result)) {
                        echo "<label for='course'>Select Subject</label>
                        <select name=student value=''>"; // list box select command

                        foreach ($database->query($querySubject) as $row) {//Array or records stored in $row

                            echo "<option value=$row[subjectCode]>$row[subjectName]</option>";
                            /* Option values are added by looping through the array */
                        }
                        echo "</select>";
                    }
                ?>
            </div>
            <div class="col-3">
                <!--                <label for="semester">Select Year Range</label>-->
                <br>
                <!--                <select class="g" id="selectYearBegin" name="selectYearBegin">-->
                <!-- Here we need to use SQL queries to populate the dropdowns -->
                <?php
                    if ($resultYear->num_rows < 1) {
                        echo "<label for='course'>Beginning</label><br>
                        <select id='yearBegin' name='yearBegin' ></option>";
                        {
                            echo "<option value=''>No Results</option>";
                        }
                        echo "</select>";
                        //if results exist
                    } else if ($resultYear) {
                        //while ($row = mysqli_fetch_assoc($result)) {
                        echo "<label for='course'>Beginning</label><br>
                        <select id='yearEnd' name='yearEnd'>"; // list box select command

                        foreach ($database->query($queryYear) as $row) {//Array or records stored in $row

                            echo "<option value=$row[schoolYear]>$row[schoolYear]</option>";
                            /* Option values are added by looping through the array */
                        }
                        echo "</select>";
                    }
                ?>

            </div>
            <div class="col-3">
                <!--                <select class="g" id="selectYearEnd" name="selectYearEnd">-->
                <!-- Here we need to use SQL queries to populate the dropdowns -->
                <?php
                    if ($resultYear->num_rows < 1) {
                        echo "<label for='course'>End</label><br>
                        <select name=student ></option>";
                        {
                            echo "<option value=''>No Results</option>";
                        }
                        echo "</select>";
                        //if results exist
                    } else if ($resultYear) {
                        //while ($row = mysqli_fetch_assoc($result)) {
                        echo "<label for='course'>End</label><br>
                        <select name=student value=''>"; // list box select command

                        foreach ($database->query($queryYear) as $row) {//Array or records stored in $row

                            echo "<option value=$row[schoolYear]>$row[schoolYear]</option>";
                            /* Option values are added by looping through the array */
                        }
                        echo "</select>";
                    }
                ?>

            </div>

            <!-- Button elements declared here. Button includes is above with button object declared. !-->
            <!--            --><?php
                //            $confirm->buttonName = "Submit";
                //            $confirm->buttonValue = "Request";
                //            $confirm->buttonStyle = "font-family:sans-serif";
                //            $confirm->display(); ?>
</form>
