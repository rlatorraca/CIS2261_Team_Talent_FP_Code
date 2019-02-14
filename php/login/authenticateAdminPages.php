<?php
/**
 * Created by PhpStorm.
 * Authors: Team Talent 2.0
 * Date: 2/14/2019
 *
 * This page enforces that only admin-level users (system administrators and school administrators)
 * have access to pages using this clearance protection.
 *
 * If a non-authorized user lands on page which includes this php file of code, they will be redirected to the home page (index.php).
 *
 * This page requires: checkLoggedIn.php
 *
 */

//Check if the logged in user visiting the page is authorized to view it.
if ($_SESSION["accessCode"] != 1 && $_SESSION["accessCode"] != 2) {

    //Redirect user to the Home page.
    header("Location: ../../index.php");

}

?>