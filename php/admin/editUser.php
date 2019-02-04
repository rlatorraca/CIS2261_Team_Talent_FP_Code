<?php
/**
 * Created by PhpStorm.
 * User: sahra
 * Date: 2019-01-27
 * Time: 8:36 PM
 */


include("../button.class.php");
$confirm = new Button();

include "../db/dbConn.php";


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
        <link href="../../css/stars.css" rel="stylesheet">

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

        <script>
            // This function shows the date picker.
            $(function () {
                $("#datepicker").datepicker();
            });

            // This function shows the note.
            // Will need to add a variable to get the notes to then call.
            $(function () {
                $(document).tooltip();
            });

            // This function manages the drop downs on the main menu.
            $(function () {
                $("#menu").menu();
            });


        <!--function to go back to your incomplete form without losing previously filled fields-->
            function goBack() {
                window.history.back();
            }
        </script>

        <title>STARS - Edit User</title>
    </head>
    <body>
        <div class="header">
            <img src="../../img/StarsWhiteFIN.jpg">
        </div>
        <div class="jumbotron-fluid">
            <div class="container-fluid">

                <!-- Menu title example !-->
                <h2>Student Menu</h2>
                <br>
                <form>
                    <!-- Label and input example !-->
                    <label>Input Label</label>
                    <input type="text">
                </form>

                <br>

                <!-- Button elements declared here. Button includes is above with button object declared. !-->
                <?php
                $confirm->buttonName = "Submit";
                $confirm->buttonValue = "Confirm";
                $confirm->buttonStyle = "font-family:sans-serif";
                $confirm->display(); ?>

                <br>

                <br>

                <!-- Date Picker Icon mis-aligned !-->

                <p>DOB: <input type="text" id="datepicker"></p>


                <!-- Tooltip !-->


                <p><a href="#" title="That&apos;s what this widget is">Tooltips</a></p>

            </div>
        </div>

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
    </body>
</html>
