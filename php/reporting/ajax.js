$(document).ready(function () {
    $("#courseSemester").change(function () {
        var classID = $(this).val();
        if (classID != "") {
            $.ajax({
                url: "getStudentEnterMark.php",
                data: {classID: classID},
                type: 'POST',
                success: function (response) {
                    var resp = $.trim(response);
                    $("#studentMark").html(resp);
                }
            });
        } else {
            $("#state").html("<option value=''>No Student in this course</option>");
        }
    });
});