<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 9:05 PM
 */
?>
<!--Form to update a students mark.  Requires course name, student name, mark, attendance-->
<form action="displayReportCard.php" method="post">
    <div class="form-group">
        <div class="form-row">

            <div class="col-3">
                <label for="course">Select Course</label>
                <select class="g" id="selectCourse" name="selectCourse">
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
                <label for="year">Enter Mark</label>
                <select class="g" id="selectMark" name="selectMark">
                    <!-- Do we want to use drop down or the little up and down arrows??? -->
                    <?php
                    for ($i = 40; $i <= 100; $i++) {
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label for="attendance">Enter Days Missed</label>
                <select class="g" id="attendance" name="attendance">
                    <?php
                    for ($i = 0; $i <= 30; $i++) {
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