<?php
/**
 * Created by PhpStorm.
 * User: jgaudet109873
 * Date: 2/5/2019
 * Time: 9:39 AM
 */

//Check if the logged in user visiting the page is authorized to view it.
if ($_SESSION["accessCode"] != 1 && $_SESSION["accessCode"] != 2) {

    //Redirect user to the Home page.
    header("Location: ../../index.php");

}

?>