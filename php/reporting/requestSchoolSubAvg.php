<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-30
 * Time: 2:07 PM
 */

include '../db/dbConn.php';

//create the query to get subjects.
//Make sure to pull the logged in administrator's schoolID from the session to use as the required field below.
$querySubject = "SELECT subject.subjectCode, subject.subjectName FROM subject, school WHERE school.schoolID = 1";
//create query to get date ranges
$queryYear = "SELECT DISTINCT schoolYear FROM `semester`";;
//Execute queries and store results.
$resultSubject = $database->query($querySubject);
$resultYear = $database->query($queryYear);
?>
<form action="displaySchoolSubAvg.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">
                <label for="subjects">Select Subject</label>
                <select class="g" id="subjects" name="subjects">
                    <!-- Using SQL to populate dropdown list of subjects -->
                    <?php if ($resultSubject->num_rows > 0) {
                        while ($row = $resultSubject->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row["subjectCode"]; ?>"><?php echo $row["subjectName"]; ?></option><?php
                        }
                    } else {
                        echo "<option>No Subjects registered in STARS</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label for="yearStart">Start Date</label>
                <select class="g" id="yearStart" name="yearStart">
                    <!-- Using SQL to populate dropdown date range start -->
                    <?php if ($resultYear->num_rows > 0) {
                        while ($row = $resultYear->fetch_assoc()) {
                            ?>
                            <option><?php echo $row["schoolYear"]; ?></option><?php
                        }
                    } else {
                        echo "<option>Unavailable</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label for="yearEnd">End Date</label>
                <select class="g" id="yearEnd" name="yearEnd">
                    <!-- Using SQL to populate dropdown date range end -->
                    <?php
                    $resultYear->data_seek(0); // Resets the pointer back to the beginning.
                    if ($resultYear->num_rows > 0) {
                        while ($row = $resultYear->fetch_assoc()) {
                            ?>
                            <option><?php echo $row["schoolYear"]; ?></option><?php
                        }
                    } else {
                        echo "<option>Unavailable</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-3">
            <!--            <input type="submit" id="btn" name="submitUpdateRecord" class="btn btn-info text-center" value="submitUpdateRecord">-->
            <button type="submit" id="getSubjectAverage" name="getSubjectAverage">Calculate</button>
        </div>
    </div>
</form>