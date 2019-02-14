<?php
/**
 * Created by PhpStorm.
 * Authors: Team Talent 2.0
 * Date: 2/14/2019
 *
 * File to set a cookie of the user's username.
 *
 * Required pages: login.php
 *
 */

//Set the cookie named "userLogin" to save the user login and to be used when the user comes back to the page

$cookie_name = "stars";
$cookie_value = $_SESSION['username'];
setcookie($cookie_name, $cookie_value, strtotime('+180 days'), "/");

?>