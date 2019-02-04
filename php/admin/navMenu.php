<?php
/**
 * Created by PhpStorm.
 * User: smartin120712
 * Date: 2/4/2019
 * Time: 10:51 AM
 */


$accessCode = 2;

switch ($accessCode) {

    // System Admin:
    case 1:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
                <a href="#"><li class = "titleNav">Not Implemented</li></a>    
        </ul>';
        break;

    // Administrator:
    case 2:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
                <a href="#"><li class = "titleNav">Add User</li></a>
                <a href="#"><li class = "titleNav">Edit Student</li></a>   
                <a href="#"><li class = "titleNav">Search Students</li></a>
                <li class = "titleNav">Enrollment
                    <ul class = "dropupMenu">
                            <a href="#"><li>Un-enroll</li></a>
                            <a href="#"><li>Assign Course</li></a>
                    </ul>
                </li>
                <a href="#"><li class = "titleNav">Search Students</li></a>   
                <a href="#"><li class = "titleNav">Report Card</li></a>  
                <a href="#"><li class = "titleNav">History</li></a>    
        </ul>';
        break;

    // Educator
    case 3:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
                <a href="#"><li class = "titleNav">Add User</li></a>
                <a href="#"><li class = "titleNav">Edit Student</li></a>   
                <a href="#"><li class = "titleNav">Search Students</li></a>
                <li class = "titleNav">Enrollment
                    <ul class = "dropupMenu">
                            <a href="#"><li>Un-enroll</li></a>
                            <a href="#"><li>Assign Course</li></a>
                    </ul>
                <a href="#"><li class = "titleNav">Subject Average</li></a>    
        </ul>';
        break;

    // Support Educator
    case 4:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
                <a href="#"><li class = "titleNav">Add User</li></a>
                <a href="#"><li class = "titleNav">Edit Student</li></a>   
                <a href="#"><li class = "titleNav">Search Students</li></a>
                <li class = "titleNav">Enrollment
                    <ul class = "dropupMenu">
                            <a href="#"><li>Un-enroll</li></a>
                            <a href="#"><li>Assign Course</li></a>
                    </ul>
                <a href="#"><li class = "titleNav">Subject Average</li></a>    
        </ul>';
        break;

    // Student
    case 5:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
                <a href="#"><li class = "titleNav">Add User</li></a>
                <a href="#"><li class = "titleNav">Edit Student</li></a>   
                <a href="#"><li class = "titleNav">Search Students</li></a>
                <li class = "titleNav">Enrollment
                    <ul class = "dropupMenu">
                            <a href="#"><li>Un-enroll</li></a>
                            <a href="#"><li>Assign Course</li></a>
                    </ul>
                <a href="#"><li class = "titleNav">Subject Average</li></a>    
        </ul>';
        break;

    // Parent or Guardian
    case 6:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
            <a href="#"><li class = "titleNav">Report Card</li></a>
            <a href="#"><li class = "titleNav">History</li></a>      
        </ul>';
        break;

    default:

        echo '<ul id="footerMenu">
            <a href="#"><li class = "titleNav">Home</li></a>
            <a href="#"><li class = "titleNav">Report Card</li></a>  
            <a href="#"><li class = "titleNav">History</li></a>  
        </ul>';
        break;
}



?>
