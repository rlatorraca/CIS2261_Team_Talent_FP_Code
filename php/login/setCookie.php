<?php
/**
 * Created by PhpStorm.
 * Authors: Rodrigo
 * Date: 2018-11-27
 * Time: 12:18 PM
 * Client: Bookorama Management System
 * File: setCookies.php
 * File purpose: Principal PHP file to control the Bookorama Management System
 * AppPurpose: to create a CRUD (create, retrieve, update, delete) site for the bookorama database.
 */

//Set the cookie named "userLogin" to save the user login and to be used when the user come back in the page

$cookie_name = "stars";
$cookie_value = $_SESSION['username'];
setcookie($cookie_name, $cookie_value, strtotime('+180 days'), "/");

?>