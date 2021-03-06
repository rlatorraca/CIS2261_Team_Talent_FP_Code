<?php
/**
 * Created by PhpStorm.
 * STARS Beta Version 1.0
 * Firm: Team Talent 2.0
 * Members: Sara, John, Rodrigo, Steve
 * Date: 2/14/2019
 *
 * Page displaying the students based on the entered criteria from the prior page (searchStudent.php).
 *
 * Required pages: stars.css, login.php, checkLoggedIn.php, dbConn.php, addUser.php, addStudent.php, confirmStudent.php,
 * insertStudent.php, searchStudent.php
 *
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Lock down page for only admin users
include "../login/authenticateAdminPages.php";

//Import button class
include("../button.class.php");
$confirm = new Button();

//Database connection
include "../db/dbConn.php";

//Deter SQL injection
$cleanFName = $database->real_escape_string($_GET['firstName']);
$cleanLName = $database->real_escape_string($_GET['lastName']);
$cleanID = $database->real_escape_string($_GET['studentID']);
$cleanResultsReturned = $database->real_escape_string($_GET['resultsReturned']);
$cleanOrderBy = $database->real_escape_string($_GET['orderBy']);
$cleanSort = $database->real_escape_string($_GET['sort']);

if ($_SESSION["accessCode"] == 2) {

    $schoolID = 0;
    $userID = $_SESSION["userID"];

    $querySchoolID = "SELECT schoolID FROM administrator WHERE userID = $userID;";

    $resultSchoolID = $database->query($querySchoolID);

    if ($resultSchoolID) {

        while ($row = $resultSchoolID->fetch_assoc()) {

            $schoolID = $row["schoolID"];

        }

    }

}

//The SQL query for the search
$query = "";

//If/else statement based on the user selecting or not selecting return all.
if ($cleanResultsReturned != "All") {

    if ($_SESSION["accessCode"] == 1) {

        $query = "SELECT studentID, firstName, lastName FROM student WHERE firstName 
                          LIKE '%$cleanFName%' AND lastName LIKE '%$cleanLName%' 
                          AND studentID LIKE '%$cleanID%' ORDER BY $cleanOrderBy $cleanSort 
                          LIMIT $cleanResultsReturned;";

    } else if ($_SESSION["accessCode"] == 2) {

        $query = "SELECT studentID, firstName, lastName FROM student 
                          WHERE firstName LIKE '%$cleanFName%' AND lastName LIKE '%$cleanLName%' 
                          AND studentID LIKE '%$cleanID%' AND schoolID = $schoolID ORDER BY $cleanOrderBy $cleanSort 
                          LIMIT $cleanResultsReturned;";

    }

} else {

    if ($_SESSION["accessCode"] == 1) {

        $query = "SELECT studentID, firstName, lastName FROM student 
                              WHERE firstName LIKE '%$cleanFName%' AND lastName LIKE '%$cleanLName%' 
                              AND studentID LIKE '%$cleanID%' ORDER BY $cleanOrderBy $cleanSort;";

    } else if ($_SESSION["accessCode"] == 2) {

        $query = "SELECT studentID, firstName, lastName FROM student 
                              WHERE firstName LIKE '%$cleanFName%' AND lastName LIKE '%$cleanLName%' 
                              AND studentID LIKE '%$cleanID%' AND schoolID = $schoolID 
                              ORDER BY $cleanOrderBy $cleanSort;";

    }

}

//Use $db object created above and run the query method.
$result = $database->query($query);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts !-->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Roboto" rel="stylesheet">

    <!-- Instructions to replicate can be found here:  https://getbootstrap.com/docs/4.1/getting-started/introduction/ !-->
    <!-- Here is where we call bootstrap. !-->
    <title>STARS - Search Results</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Calendar Date Picker !-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="../../css/stars.css" rel="stylesheet">

    <script src="../../js/main.js"></script>
</head>
<body>
<?php include "../../header.php"; ?>
<div class="jumbotron-fluid">
    <div class="container-fluid">
        <?php

        //Check/validate if there are items in the database object
        //Validation passed, display search results to a table
        if ($result->num_rows > 0)
        {
        ?>
        <h2 class="centerStuff">Search Results</h2>
        <!--The table-->
        <table class="table table-striped">
            <tr id="viewHeader">
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Edit</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td class="smCol"><?php echo $row['studentID'] ?></td>
                    <td class="nameCol"><?php echo $row['firstName'] ?></td>
                    <td class="nameCol"><?php echo $row['lastName'] ?></td>
                    <?php
                    echo "<td><a href='editStudent.php?studentID=" . $row['studentID'] . "'>Edit</a></td>";
                    ?>
                </tr>
                <?php
            }
            echo "</table>";
            // if no results display message to advise user
            } else {
                echo "<h5 class='centerStuff'>Sorry there are no results for your search.</h5>";
            }
            //Reset link
            echo "<br><h5 class = 'centerStuff'>Start a new <a href='searchStudent.php'>Search?</a></h5>";
            echo "</div>";
            ?>
            <!--The bottom navbar/footer section-->
            <div class="bottom">
                <div id="footer">
                    <?php include("../../navMenu.php"); ?>
                </div>
            </div>
    </div>
</body>
</html>
<?php

//Close database
$database->close();

?>
