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
<form action="displayStudentSubHistory.phpp" method="post">
    <div class="form-group">
        <div class="form-row">
            <div class="col-3">

                <!--populate a header? with the name of the Student??? associated with the user.  Use that hidden Student ID to write SQL-->

                <input type="hidden" class="form-control" id="isbn" name="isbn"
                       value="<?php echo $row['isbn'] ?>">

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

            < <!-- Button elements declared here. Button includes is above with button object declared. !-->
            <?php
            $confirm->buttonName = "Submit";
            $confirm->buttonValue = "Request";
            $confirm->buttonStyle = "font-family:sans-serif";
            $confirm->display(); ?>
</form>