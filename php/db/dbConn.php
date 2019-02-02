<?php
    /**
     * Created by PhpStorm.
     * User: sahra
     * Date: 2019-01-31
     * Time: 9:14 PM
     */
?>

<?php

    //connect to the database
    @ $database = new mysqli('localhost', 'root', '', 'stars');

    //confirm successful connection
    if (mysqli_connect_errno()) {
        $database->close();
        echo '>try again?</a></h2>';
        exit("</div></body></html>");

    }