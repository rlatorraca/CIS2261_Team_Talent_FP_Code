<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 8:58 PM
 */
?>
<!--Form to request to view a student's report card.  Requires student name, student ID?(how to incorporate), year & semester-->
<form action="displayReportCard.php" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">
                <label for="student">Select Student</label>
                <select class="g" id="selectStud" name="selectStud">
                    <!-- Here we need to use SQL queries to populate the dropdowns -->
                    <?php
                    for ($i = 0; $i <= 30; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label for="year">Select Year</label>
                <select class="g" id="selectYear" name="selectYear">
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
            <div class="col-3">
                <label for="semester">Select Semester</label>
                <select class="g" id="selectSem" name="selectSem">
                    <!-- Here we need to use SQL queries to populate the dropdowns -->
                    <?php
                    for ($i = 0; $i <= 2; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <!--Submit button Do we consider a button class???-->
            <button class="btn btn-primary" type="submit">Submit</button>
</form>