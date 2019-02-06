$(document).ready(function () {
	//Counter of characters

  $("#teacherNotes").on("input", function() {

          var limit = 200;
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
}