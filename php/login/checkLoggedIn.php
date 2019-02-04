<?php
/**
 * Created by PhpStorm.
 * User: jgaudet109873
 * Date: 2/4/2019
 * Time: 11:49 AM
 */

session_start();

//Check if the user accessing page is properly logged in as an authenticated user in STARS
if ($_SESSION["isLoggedIn"] == false){

    header('Location: ../../php/login/login.php');

}

?>