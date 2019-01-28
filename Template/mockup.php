<?php
/**
 * Created by PhpStorm.
 * Firm: Team Talent 2.0
 * Members: Sara, John, Rodrigo, Steve
 * Date: 2019-01-14
 * Time: 12:09 AM
 */

include("button.class.php");
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

        <title>STARS Template</title>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!-- Calendar Date Picker !-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <link href="css/stars.css" rel="stylesheet">
        <script>
            // This function shows the date picker.
            $( function() {
                $( "#datepicker" ).datepicker();
            } );

            // This function shows the note.
            // Will need to add a variable to get the notes to then call.
            $( function() {
                $( document ).tooltip();
            } );

            // This function manages the drop downs on the main menu.
            $( function() {
                $( "#menu" ).menu();
            } );
        </script>
    </head>
    <body>
            <div class="container">
                <div class="header">
                    <img src = "img/StarsWhiteFIN.jpg">
                </div>
                <ul class="starFrame">
                    <li></li>
                </ul>
            </div>

        <div class="jumbotron-fluid">
            <div class="spacer"></div>
            <div class="container-fluid">

                <!-- Menu title example !-->
                <h1>Student Menu</h1>
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
        <div class="navbar">
            <a href="#home">Home</a>
            <a href="#news">News</a>
            <div class="dropdown">
                <button class="dropbtn">Dropdown
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div>
        </div>

        <div class ="bottom"></div>

    </body>
</html>