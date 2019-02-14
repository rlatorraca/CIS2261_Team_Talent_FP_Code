<?php
    /**
     * Created by PhpStorm.
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This is a simple about page to give details on system and developers
     *
     * This page requires: index.php.
     *
     */

    session_start();
    include "button.class.php";
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

        <!--Link to custom style sheet-->
        <link href="../css/stars.css" rel="stylesheet">

        <!-- JQuery Links !-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <!-- JQuery Calendar Date Picker !-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- Here is where we call bootstrap. !-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <title>STARS</title>
    </head>
    <body>

        <?php include "../header.php"; ?>

        <div class="jumbotron-fluid">
            <div class="container-fluid container-sizer">
                <div>
                    <h1 class="homeTitle">About STARS</h1>
                    <p class="p2">Scholastic Tracking and Records System - STARS is an information system
                        developed to replace the current paper-based report card system used by the
                        Provincial School Board and include additional functionality to track other
                        aspects of a student’s education such as speech therapy, additional tutoring
                        in literacy and numeracy, Individual Education Plans and more.
                        The aim of STARS is to improve operations, decrease costs, lower the
                        environmental impact, and provide better educational tracking for educators,
                        guardians and students. </p>
                    <p>STARS Beta Version 1.0</p>
                    <p>Copywright © 2019 Team Talent 2.0</p>

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