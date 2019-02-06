<?php
    /**
     * Created by PhpStorm.
     * Firm: Team Talent 2.0
     * Members: Sara, John, Rodrigo, Steve
     * Date: 2019-01-14
     * Time: 12:09 AM
     */

    session_start();
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

        <!--Link to custom style sheet-->
        <link href="../css/stars.css" rel="stylesheet">


        <!-- Here is where we call bootstrap. !-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>


        <title>STARS - About</title>
    </head>
    <body>

        <?php include "../php/about.php"; ?>

        <div class="jumbotron-fluid">
            <div class="container-fluid">


                <div class="home">
                    <h1 class="homeTitle">Welcome to STARS</h1>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                       lore te feugait nulla facilisi. Nam liber tempor cum soluta
                        nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim
                        assum.</p>
                </div>

            </div>
        </div>

        <div class="bottom">
            <div id="footer">
                <?php include("../navMenu.php"); ?>
            </div>
        </div>
    </body>
</html>