<?php
/**
 * Created by PhpStorm.
 * User: smartin120712
 * Date: 2/4/2019
 * Time: 10:51 AM
 */




if (!isset($_SESSION['accessCode'])){
    $accessCode = 0;
} else {
    $accessCode = $_SESSION['accessCode'];
}



switch ($accessCode) {

    // System Admin:
    case 1:

        echo '<ul id="footerMenu">
            <a href="/CIS2261_Team_Talent_FP_Code/index.php"><li class = "titleNav">Home</li></a>
                <li class = "titleNav">Admin
                    <ul class = "dropupMenu">
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/addUser.php"><li>Add User</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestSchoolSubAvg.php"><li>School Average</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/editStudent.php"><li>Edit Student</li></a>
                            
                    </ul>
                </li>
                <li class = "titleNav">Student
                    <ul class = "dropupMenu">
                            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestReportCard.php"><li>Report Card</li></a>  
                            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/enterMark.php"><li>Enter Mark</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/searchStudent.php"><li>Search/Edit Student</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestStudentSubHistory.php"><li>Student History</li></a>
                    </ul>
                </li>
                <li class = "titleNav">Enrollment
                    <ul class = "dropupMenu">
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/searchCourses.php"><li>Un-enroll</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/assignCourse.php"><li>Assign Course</li></a>
                    </ul>
                </li>   
        </ul>';
        break;

    // Administrator:
    case 2:

        echo '<ul id="footerMenu">
            <a href="/CIS2261_Team_Talent_FP_Code/index.php"><li class = "titleNav">Home</li></a>
                <li class = "titleNav">Admin
                    <ul class = "dropupMenu">
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/addUser.php"><li>Add User</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestSchoolSubAvg.php"><li>School Average</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/editStudent.php"><li>Edit Student</li></a>
                            
                    </ul>
                </li>
                <li class = "titleNav">Student
                    <ul class = "dropupMenu">
                            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestReportCard.php"><li>Report Card</li></a>  
                            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/enterMark.php"><li>Enter Mark</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/searchStudent.php"><li>Search/Edit Student</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestStudentSubHistory.php"><li>Student History</li></a>
                    </ul>
                </li>
                <li class = "titleNav">Enrollment
                    <ul class = "dropupMenu">
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/searchCourses.php"><li>Un-enroll</li></a>
                            <a href="/CIS2261_Team_Talent_FP_Code/php/admin/assignCourse.php"><li>Assign Course</li></a>
                    </ul>
                </li>   
        </ul>';
        break;

    // Educator
    case 3:

        echo '<ul id="footerMenu">
            <a href="/CIS2261_Team_Talent_FP_Code/index.php"><li class = "titleNav">Home</li></a>
            <li class = "titleNav">Student
                <ul class = "dropupMenu">
                        <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestReportCard.php"><li>Report Card</li></a>  
                        <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/enterMark.php"><li>Enter Mark</li></a>
                        <a href="/CIS2261_Team_Talent_FP_Code/php/admin/searchStudent.php"><li>Search/Edit Student</li></a>
                        <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestStudentSubHistory.php"><li>Student History</li></a>
                </ul>
            </li>  
        </ul>';
        break;

    // Support Educator
    case 4:

        echo '<ul id="footerMenu">
            <a href="/CIS2261_Team_Talent_FP_Code/index.php"><li class = "titleNav">Home</li></a>
            <li class = "titleNav">Student
                <ul class = "dropupMenu">
                        <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestReportCard.php"><li>Report Card</li></a>  
                        <a href="/CIS2261_Team_Talent_FP_Code/php/admin/searchStudent.php"><li>Search/Edit Student</li></a>
                        <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestStudentSubHistory.php"><li>Student History</li></a>
                </ul>
            </li>  
        </ul>';
        break;

    // Student
    case 5:

        echo '<ul id="footerMenu">
            <a href="/CIS2261_Team_Talent_FP_Code/index.php"><li class = "titleNav">Home</li></a>
            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestReportCard.php"><li class = "titleNav">Report Card</li></a>  
            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestStudentSubHistory.php"><li>Student History</li></a>     
        </ul>';
        break;

    // Parent or Guardian
    case 6:

        echo '<ul id="footerMenu">
            <a href="/CIS2261_Team_Talent_FP_Code/index.php"><li class = "titleNav">Home</li></a>
            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestReportCard.php"><li class = "titleNav">Report Card</li></a>  
            <a href="/CIS2261_Team_Talent_FP_Code/php/reporting/requestStudentSubHistory.php"><li>Student History</li></a>      
        </ul>';
        break;

    default:

        echo '<ul id="footerMenu">
            <a href="/CIS2261_Team_Talent_FP_Code/index.php"><li class = "titleNav">Home</li></a>
        </ul>';
        break;
}



?>
