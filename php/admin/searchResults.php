<?php
    /**
     * Created by PhpStorm.
     * User: sahra
     * Date: 2019-02-03
     * Time: 8:45 PM
     */

    include "../db/dbConn.php";

    //Get input of each item from employeeSearch
    $fName = htmlspecialchars($_GET['firstName']);
    $lName = htmlspecialchars($_GET['lastName']);
    $studentID = htmlspecialchars($_GET['studentID']);
    $resultsReturned = ($_GET['resultsReturned']);
    $orderBy = ($_GET['orderBy']);
    $sort = ($_GET['sort']);

    //Deter SQL injection
    $cleanFName = $database->real_escape_string($fName);
    $cleanLName = $database->real_escape_string($lName);
    $cleanID = $database->real_escape_string($studentID);
    $cleanResultsReturned = $database->real_escape_string($resultsReturned);
    $cleanOrderBy = $database->real_escape_string($orderBy);
    $cleanSort = $database->real_escape_string($sort);

    //The SQL query for the search
            if ($resultsReturned != "All") {
                $query = "SELECT * FROM student WHERE firstName LIKE '%$cleanFName%' AND lastName LIKE '%$cleanLName%' 
                        AND studentID LIKE '%$cleanID'
                  ORDER BY $cleanOrderBy $cleanSort LIMIT $cleanResultsReturned";
            } else {
                $query = "SELECT * FROM student WHERE firstName LIKE '%$cleanFName%' AND lastName LIKE '%$cleanLName%' 
                        AND studentID LIKE '%$cleanID'
                  ORDER BY $cleanOrderBy $cleanSort";
            }

            // Use $db object created above and run the query() method.
            $result = $database->query($query);

            //Check/validate if there are items in the database object
            if ($result->num_rows > 0)
            {
            //Validation passed, display search results to a table
            ?>
            <h2 class="centerStuff">Search Results</h2>
            <!--The table-->
            <table class="table table-striped">
                <tr id="viewHeader">
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Edit</th>
                    <th>Delete</th>

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
                        echo "<td><a class = 'delete' href='deleteStudent.php?studentID=" . $row['studentID'] . "'>Delete</a></td>";
    $result->free();
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
                echo "<br><h5 class = 'centerStuff'>Start a new <a href='search.php'>Search?</a></h5>";
                echo "</div>";

                ?>