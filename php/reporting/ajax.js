$(document).ready(function () {
    $("#courseSemester").change(function () {
        var classID = $(this).val();
        if (classID != "") {
            $.ajax({
                type: 'POST',
                url: "getStudentEnterMark.php",
                data: {classID: classID},
                success: function (response) {
                    var resp = $.trim(response);
                    $("#studentMark").html(resp);
                }
            });
        } else {
            $("#courseSemester").html("<option value=''>No Student in this course</option>");
        }
    });


    $("#semesterYearAssignCourse").change(function () {
        var semesterNum = $(this).val();
        var schoolYear = $("#yearAsscourseSemesterYearAssignCourseignCourse option:selected").val();
        var subjectCode = $("#subjectsAssignCourse option:selected").val();

        if (semesterNum != "") {
            $.ajax({
                type: 'POST',
                url: "../reporting/getCourseSchoolYearAssignCourse.php",
                data: {semesterNum: semesterNum, schoolYear: schoolYear, subjectCode: subjectCode},
                success: function (response) {
                    var resp = $.trim(response);
                    $("#courseSemesterYearAssignCourse").html(resp);
                }
            });
        } else {
            $("#semesterYearAssignCourse").html("<option value=''>No Semester</option>");
        }
    });




});