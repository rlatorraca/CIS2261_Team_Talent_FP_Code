$(function () {
    $("#courseSemester").change(function () {
        var courseid = $(this).val();
        if (courseid != "") {
            $.ajax({
                url: "enterMark.php",
                data: {course_id: courseID},
                type: 'POST',
                success: function (response) {
                    var resp = $.trim(response);
                    $("#studentMark").html(resp);
                }
            });
        } else {
            $("#state").html("<option value=''>------- Select --------</option>");
        }
    });
});