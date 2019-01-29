<?php
    /**
     * Created by PhpStorm.
     * User: sahra
     * Date: 2019-01-27
     * Time: 8:58 PM
     */
?>
<!--Form to request to view a students subject history, (request from a teacher)return in graph-->
<!--//*****************creating dropdown of school subjects**********************************************************-->
<!--    //Get educatorID of user-->
<!--    //$educatorID = ($_GET['educatorID']);-->
<!---->
<!--    //Deter SQL injection-->
<!--    //$cleaneducatorID = $db->real_escape_string($educatorID);-->
<!--    //echo "got here1";-->
<!---->
<!--  Create a new connection object using mysqli-->
    <?php
    @ $database = new mysqli('localhost', 'root', '', 'stars');
    if (mysqli_connect_errno()) {
        echo '<h2>An error has occurred.  Would you like to <a href=\'requestSchoolSubAvg.php\'>try again?</a></h2>';
        exit("</div></body></html>");
        $db->close();
    }
    //create the query to find the courses the teacher has assigned to them and pull all the students.
    $queryStudent= "SELECT student.firstName, student.lastName FROM course, student, educator WHERE educator.educatorID = 69";

    $queryYear = "SELECT DISTINCT schoolYear FROM `semester`";;
    //Execute query and store result.
    $resultSubject = $database->query($querySubject);
    $resultYear = $database->query($queryYear);
?>
<form action="displayStudentSubHistory.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">

<!--<input type="hidden" class="form-control" id="isbn" name="isbn"-->
<!--       value="--><?php //echo $row['isbn'] ?><!--">-->

<!-- Are we selecting student from drop down here???? -->
</div>
<div class="col-3">
    <label for="selectSubject">Select Subject</label>
    <br>
    <select class="g" id="selectSubject" name="selectSubject">
        <!-- Here we need to use SQL queries to populate the dropdown with available subjects -->
        <?php
            for ($i = 2016; $i <= 2020; $i++) {
                ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php
            }
        ?>
    </select>
</div>

            <!--date ranges-->
            <div class="col-3">


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

< <!-- Button elements declared here. Button includes is above with button object declared. !-->
<?php
//    $confirm->buttonName = "Submit";
//    $confirm->buttonValue = "Request";
//    $confirm->buttonStyle = "font-family:sans-serif";
//    $confirm->display(); ?>
</form>