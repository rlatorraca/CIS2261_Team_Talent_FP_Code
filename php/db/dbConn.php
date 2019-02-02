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




    // If Steve can not connect with the above line, this line will try next.
    if (mysqli_connect_errno()) {
        @ $database = new mysqli('localhost', 'root', 'root', 'stars');

    //confirm successful connection
        if (mysqli_connect_errno()) {
            echo '>try again?</a></h2>';
            exit("</div></body></html>");
            $db->close();
        }
    }