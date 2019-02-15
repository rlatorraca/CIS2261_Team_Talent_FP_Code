<?php
    /**
     * Created by PhpStorm.
     * STARS Beta Version 1.0
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This is the page used when parent/guardian or student confirms that they have viewed the report card
     *
     * This page requires: stars.css, index.php, login.php, checkLoggedIn.php, dbConn.php, requestReportCard.php, displayReportCard.php .
     *
     */

//Lock down page
include "../login/checkLoggedIn.php";

//Database connection
include "../db/dbConn.php";

//Ensure report card number is set before proceeding
if (!isset($_GET["reportCardNum"])) {

    //If not, redirect them
    header("Location: requestReportCard.php");

}

$reportCardNum = $_GET["reportCardNum"];

$updateReportCardQuery = "UPDATE reportcard SET isRead = 1 WHERE reportCardID = $reportCardNum;";

$resultUpdateReportCard = $database->query($updateReportCardQuery);

if ($resultUpdateReportCard) {

    $database->close();
    header("Location: requestReportCard.php");

} else {

    //To handle regarding a failed report card update query.
    $msg = "Could not update Report Card at this time";

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STARS - Update Report Card</title>
</head>

<body>\
<!--Message displayed if cannot be updated.-->
<div><?php if (isset($msg)) {
        echo $msg;
    } ?></div>
</body>
</html>

