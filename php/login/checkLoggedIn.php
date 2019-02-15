<?php
/**
 * Created by PhpStorm.
 * STARS Beta Version 1.0
 * Authors: Team Talent 2.0
 * Date: 2/14/2019
 *
 * This page ensures that the lowest level of clearance is checked.
 * All pages, with exceptions to the home, help and about pages, require that users must be logged in successfully.
 * This page handles that functionality, and is the first wall of protection for this application.
 *
 */

//Start session for the page. Additionally starts the session for when this page is included in all other pages requiring login.
session_start();

//Check if the user accessing page is properly logged in as an authenticated user in STARS
if ($_SESSION["isLoggedIn"] == false){

    header('Location: ../../php/login/login.php');

}

?>