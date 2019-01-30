<?php
/**
 * Created by PhpStorm.
 * Edited by: John Gaudet
 * Date: 1/30/2019
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Individual Education Plan</title>
</head>
<body>
<?php

    //StudentID pulled from the report card page.
    $studentIDFromForm = $_GET["studentID"];

    //To ensure studentID is the accurate one
    echo $studentIDFromForm;

//Make connection to the database and check to ensure that a solid connection can be made
@ $database = new mysqli('localhost', 'root', '', 'stars');
if (mysqli_connect_errno()) {
    echo '<h2>Error: Could not connect to database. Please try again later.</h2>';
    exit("</div></body></html>");
}

//Need to work out issue with first/last name of student and support educator
$querySelectIEP = "SELECT planID, reason, dateIssued, comments, supportEducator.firstName, supportEducator.lastName, student.firstName, student.lastName  
                  FROM individualeducationplan, supporteducator, student 
                  WHERE individualeducationplan.studentID = $studentIDFromForm
                  AND student.studentID = individualeducationplan.studentID
                  AND individualeducationplan.supportEducatorID = supporteducator.supportEducatorID;";

$resultIEP = $database->query($querySelectIEP);

if ($resultIEP->num_rows > 0) {

    ?>
    <table>
        <thead>
        <tr>
            <td>Plan ID</td>
            <td>Reason for IEP</td>
            <td>Date Issued</td>
            <td>Comments</td>
            <td>Student Name</td>
            <td>Support Educator Name</td>
        </tr>
        </thead>
    <?php

    while ($rowIEP = $resultIEP->fetch_assoc()){

        $planID = $rowIEP["planID"];
        $reason = $rowIEP["reason"];
        $dateIssued = $rowIEP["dateIssued"];
        $comments = $rowIEP["comments"];
        $supportEducatorFirstName = $rowIEP["firstName"];
        $supportEducatorLastName = $rowIEP["lastName"];
        $studentFirstName = $rowIEP["firstName"];
        $studentLastName = $rowIEP["lastName"];

        ?>
        <tbody>
            <tr>
                <td><?php echo $planID; ?></td>
                <td><?php echo $reason; ?></td>
                <td><?php echo $dateIssued; ?></td>
                <td><?php echo $comments; ?></td>
                <td><?php echo $supportEducatorFirstName; ?></td>
                <td><?php echo $supportEducatorLastName; ?></td>
                <td><?php echo $studentFirstName; ?></td>
                <td><?php echo $studentLastName; ?></td>
            </tr>
        </tbody>
        </table>
        <?php }
} else {
    echo "<p>This student has no IEP listed in the system</p>";
}
?>
</body>
</html>
