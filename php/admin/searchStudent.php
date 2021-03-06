<?php
/**
 * Created by PhpStorm.
 * STARS Beta Version 1.0
 * Firm: Team Talent 2.0
 * Members: Sara, John, Rodrigo, Steve
 * Date: 2/14/2019
 *
 * Page allowing users to search students based on entered parameters. Results are posted to the searchResults.php page.
 *
 * Required pages: stars.css, login.php, checkLoggedIn.php, dbConn.php, addUser.php, addStudent.php, confirmStudent.php,
 * insertStudent.php, searchStudent.php
 *
 */

//Lock down page
include "../login/checkLoggedIn.php";

//Lock down page for only admin staff
include "../login/authenticateAdminPages.php";

//Importing button
include("../button.class.php");
$confirm = new Button();

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

        <!-- Here is where we call bootstrap. !-->
        <title>STARS - Search Student</title>
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

        <!-- function to go back to your incomplete album form without losing previously filled fields -->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </head>
    <body>
    <?php include "../../header.php"; ?>
    <div class="jumbotron-fluid">
        <div class="container-fluid">

            <!--Main container and contents-->
            <div class="container main-container" id="studentSearch">

                <!--Search form items-->
                <form action="searchResults.php" method="get">
                    <h2>Student Search</h2>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName"><br>
                        </div>
                        <div class="col-sm-6">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName"><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="studentID">StudentID</label>
                            <input type="text" class="form-control" id="studentID" name="studentID"><br>
                        </div>
                        <div class="col-sm-6">
                            <label for="resultsReturned">Results Returned</label>
                            <select type="text" class="form-control" id="resultsReturned"
                                    name="resultsReturned">
                                <option value="2">2</option>
                                <option value="5" selected>5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="All">All</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="orderBy">Order By</label>
                            <select type="text" class="form-control" id="orderBy" name="orderBy">
                                <option value="studentID">Student ID</option>
                                <option value="firstName">First Name</option>
                                <option value="lastName" selected>Last Name</option>
                            </select><br>
                        </div>
                        <div class="col-sm-6">
                            <label for="sort">Sort</label>
                            <select type="text" class="form-control year" id="sort" name="sort">
                                <option value="ASC" selected>Ascending</option>
                                <option value="DESC">Descending</option>
                            </select>
                        </div>
                    </div>
                    <!--Search button-->
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $confirm = new Button();

                            $confirm->buttonName = "search";
                            $confirm->buttonID = "search";
                            $confirm->buttonValue = "Search";
                            $confirm->buttonStyle = "font-family:sans-serif";
                            $confirm->display(); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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

//Close Database
$database->close();

?>