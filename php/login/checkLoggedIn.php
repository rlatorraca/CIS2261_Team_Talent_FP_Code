<?php
/**
 * Created by PhpStorm.
 * User: jgaudet109873
 * Date: 2/14/2019
 * Time: 11:49 AM
 * 
 * This page ensures that the lowest level of clearance is checked.
 * All pages, with exceptions to the home, help and about pages, require that users must be logged in successfully.
 * This page handles that functionality, and is the first wall of protection for this application.
 *
 */

session_start();

//Check if the user accessing page is properly logged in as an authenticated user in STARS
if ($_SESSION["isLoggedIn"] == false){

    header('Location: ../../php/login/login.php');

}

?>