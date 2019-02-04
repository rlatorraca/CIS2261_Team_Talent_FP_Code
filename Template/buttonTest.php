<?php
/**
 * Created by PhpStorm.
 * User: smartin120712
 * Date: 2/4/2019
 * Time: 11:00 AM
 */






include("XXXbutton.class.php");
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

    <title>STARS: Login</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Calendar Date Picker !-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <link href="../../css/stars.css" rel="stylesheet">
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