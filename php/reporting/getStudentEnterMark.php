<?php
    /**
     * Created by PhpStorm.
     * STARS Beta Version 1.0
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * Page to get the items to populate the dropdowns for the enter mark option
     *
     * This page requires: stars.css, index.php, login.php, checkLoggedIn.php, dbConn.php, enterMark.php, ajax.js
     *
     */
    ?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<?php

//Lock down page
include "../login/checkLoggedIn.php";

//Locks down page for non-admin or educational staff.
//Parent/Guardians, Support Educators and Students are not able to view this page.
if ($_SESSION["accessCode"] == 4 || $_SESSION["accessCode"] == 5 || $_SESSION["accessCode"] == 6) {

    //Redirect unauthorized user back to Home page
    header("Location: ../../index.php");
}

//Database connection
include("../db/dbConn.php");

if (isset($_POST['classID'])) {
    $sql = "SELECT student.firstName, student.lastName, student.studentID 
            FROM enrollment, student, courseoffering 
            WHERE courseoffering.classID=" . mysqli_real_escape_string($database, $_POST['classID']) . " 
            AND enrollment.classID = courseoffering.classID 
            AND student.studentID = enrollment.studentID;";
    $res = mysqli_query($database, $sql);
    if (mysqli_num_rows($res) > 0) {
        echo "<option value=''>Select</option>";
        while ($row = mysqli_fetch_object($res)) {
            echo "<option value='" . $row->studentID . "'>" . $row->firstName . " " . $row->lastName . "</option>";
        }
    }
} else {
    echo "WRONG CONNECTION";
}
?>