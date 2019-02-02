$(function () {
    $("#studentMark").change(function () {
        var courseName = $(this).val();
        if (country_id != "") {
            $.ajax({
                url: "enterMark.php",
                data: {c_id: country_id},
                type: 'POST',
                success: function (response) {
                    var resp = $.trim(response);
                    $("#state").html(resp);
                }
            });
        } else {
            $("#state").html("<option value=''>------- Select --------</option>");
        }
    });
});