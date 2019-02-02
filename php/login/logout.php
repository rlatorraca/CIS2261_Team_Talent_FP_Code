<?php
/**
 * Created by PhpStorm.
 * User: Rosdrigo Pires
 * Date: 2019-01-27
 * Time: 8:35 PM
 */


// Always start this first
session_start();

// Destroying the session clears the $_SESSION variable, thus "logging" the user out.
//  This also happens automatically when the browser is closed
session_destroy();
if (session_destroy()) {
	header("Location: ../index.php");
}
?>