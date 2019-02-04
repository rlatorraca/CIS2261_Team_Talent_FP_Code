<?php
/**
 * Created by PhpStorm.
 * User: smartin120712
 * Date: 2/4/2019
 * Time: 10:51 AM
 */

?>


<?php


$accessCode = 3;

switch ($accessCode) {

    case 1:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
                <li class = "titleNav">Add User
                    <ul class = "dropupMenu">
                        <a><li>Student</li></a>
                        <a><li>Educator</li></a>
                        <a><li>Support Educator</li></a>
                    </ul>
                </li>

                <a href="#"><li class = "titleNav">Edit User</li></a>   

                <a href="#"><li class = "titleNav">Search Students</li></a>
            
        </ul>';
        break;

    case 2:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
                <li class = "titleNav">Add Banana
                    <ul class = "dropupMenu">
                        <a><li>Student</li></a>
                        <a><li>Educator</li></a>
                        <a><li>Support Educator</li></a>
                    </ul>
                </li>

                <a href="#"><li class = "titleNav">Edit User</li></a>   

                <a href="#"><li class = "titleNav">Search Students</li></a>
            
        </ul>';
        break;

    case 3:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
                <li class = "titleNav">Add Grape
                    <ul class = "dropupMenu">
                        <a><li>Student</li></a>
                        <a><li>Educator</li></a>
                        <a><li>Support Educator</li></a>
                    </ul>
                </li>

                <a href="#"><li class = "titleNav">Edit User</li></a>   

                <a href="#"><li class = "titleNav">Search Students</li></a>
            
        </ul>';
        break;

    default:
}



?>
