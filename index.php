<?php
    /**
     * Created by PhpStorm.
     * STARS Beta Version 1.0
     * Company: Team Talent 2.0
     * Authors: John, Rodrigo, Sara, Steve
     * Date: 2/14/2019
     *
     * This page is the home page. Users can login from this page.
     *
     * This page requires: stars.css, login.php.
     *
     */


    session_start();
    include("../CIS2261_Team_Talent_FP_Code/php/button.class.php");
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
        <link href="../CIS2261_Team_Talent_FP_Code/css/stars.css" rel="stylesheet">

        <!-- JQuery Links !-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- JQuery Calendar Date Picker !-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- Here is where we call bootstrap. !-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"

                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <title>STARS - Home</title>
    </head>
    <body>

        <?php include "header.php"; ?>

        <div class="jumbotron-fluid">
            <div class="container-fluid">

                <div class="home">
                    <h1 class="homeTitle">Welcome to STARS</h1>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                        ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci
                        tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum
                        iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu
                        feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent
                        luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta
                        nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim
                        assum.Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod
                        mazim placerat facer possim
                        assum.</p>
                </div>
            </div>
        </div>
        <!--Bottom navbar-->
        <div class="bottom">
            <div id="footer">
                <?php include("navMenu.php"); ?>
            </div>
        </div>
    </body>
</html>