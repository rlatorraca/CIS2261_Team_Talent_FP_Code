<?php
/**
 * Created by PhpStorm.
 * STARS Beta Version 1.0
 * Authors: Team Talent 2.0
 * Date: 2/14/2019
 *
 * Page which logs a user out of the system. When the button to logout is selected, the session if destroyed and the user is redirected to home.
 *
 * Required pages: login.php, checkLoggedIn.php, index.php
 *
 */

//Starts session.
session_start();

//Destroying the session clears the $_SESSION variable, thus "logging" the user out.
//This also happens automatically when the browser is closed
session_destroy();

//Change location page. Redirects user back to the home page.
header('Location: /CIS2261_Team_Talent_FP_Code/index.php');

?>