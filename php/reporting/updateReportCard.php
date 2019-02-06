<?php
/**
 * Created by PhpStorm.
 * User: jgaudet109873
 * Date: 2/6/2019
 * Time: 2:21 PM
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
include "../db/dbConn.php";

//Ensure report card number is set before proceeding
if (!isset($_GET["reportCardNum"])){

    //If not, redirect them
    header("Location: ../../index.php");

}

$reportCardNum = $_GET["reportCardNum"];

$updateReportCardQuery = "UPDATE reportcard SET isRead = 1 WHERE reportCardID = $reportCardNum;";

$resultUpdateReportCard = $database->query($updateReportCardQuery);

if ($resultUpdateReportCard) {

    $database->close();
    header("Location: ../../index.php");

} else {

    echo "<p>Could not update Report card at this time</p>";

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Report Card</title>
</head>
<body>

</body>
</html>

