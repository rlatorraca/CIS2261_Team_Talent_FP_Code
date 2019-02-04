<?php
    /**
     * Created by PhpStorm.
     * Firm: Team Talent 2.0
     * Members: Sara, John, Rodrigo, Steve
     * Date: 2019-01-14
     * Time: 12:09 AM
     */

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

        <!-- Instructions to replicate can be found here:  https://getbootstrap.com/docs/4.1/getting-started/introduction/ !-->
        <!-- Here is where we call bootstrap. !-->
        <title>STARS - Enrollments</title>
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

        <!--function to go back to your incomplete album form without losing previously filled fields-->
        <script>
            function goBack() {
                window.history.back();
            }
        </script>

    </head>

    <body>
        <div class="header">
            <img src="../../img/StarsWhiteFIN.jpg">
        </div>
        <div class="jumbotron-fluid">
            <div class="container-fluid">

                <!--Main container and contents-->
                <div class="container main-container" id="studentSearch">

                    <!--Search form items-->
                    <form action="searchCourseResults.php" method="get">

                        <h2>Enrollments</h2>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="firstName">Select Course</label>
                                <input type="text" class="form-control" id="firstName" name="firstName"><br>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-12">
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
                </div>
                </form>
            </div>
        </div>
        <!--The bottom navbar/footer section-->
        <div class="bottom">
            <div id="footer">
                <ul id="footerMenu">
                    <li class="titleNav">List One
                        <ul class="dropupMenu">
                            <li><a>List 1:1</a></li>
                            <li><a>List 1:2</a></li>
                            <li><a>List 1:3</a></li>
                            <li><a>List 1:4</a></li>
                        </ul>
                    </li>
                    <li class="titleNav">List Two
                        <ul class="dropupMenu">
                            <li><a>List 2:1</a></li>
                            <li><a>List 2:2</a></li>
                            <li><a>List 2:3</a></li>
                            <li><a>List 2:4</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </body>
</html>