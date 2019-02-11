$(document).ready(function () {
    //Counter of characters
    $("#teacherNotes").on("input", function () {

        var limit = 500;
        var charactersTyped = $(this).val().length;
        var charactersRemaining = limit - charactersTyped;

        if (charactersRemaining <= 0) {
            var comments = $("#teacherNotes").val();
            $("#teacherNotes").val(comments.substr(0, limit));
            $(".charactersTeacherNotes").text("0 ");
        } else {
            $(".charactersTeacherNotes").text(charactersRemaining);
        }
    });

    function goBack() {
        window.history.back();
    }

    // This function shows the date picker.
    $(function () {
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true
        });
    });

    // This function shows the note.
    // Will need to add a variable to get the notes to then call.
    $(function () {
        $(document).tooltip();
    });

    // This function manages the drop downs on the main menu.
    $(function () {
        $("#menu").menu();
    });
});