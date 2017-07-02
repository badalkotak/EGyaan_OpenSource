$(document).ready(function () {

    $("#reply_form").submit(function (event) {
        event.preventDefault();
    });

    $("a").click(function (event) {
        if($(this).attr("id") == "delete_link") {
           if(!confirm("Are You Sure?")){
               event.preventDefault();
           }
       }
    });

    $("#reply_form_submit").click(function () {
        var reply = $("#reply").val();
        if(reply.length <= 0){
            $("#message").text("Title Cannot Be Empty");
            return;
        }
        var student_id = $("#student_id").val();
        var teacher_id = $("#teacher_id").val();
        var thread_id = $("#thread_id").val();
        var parent_reply_id = $("#parent_reply_id").val();

        $.ajax(
            {
                type:"POST",
                url: "functions/add_reply.php",
                data: "reply=" + reply + "&student_id=" + student_id + "&teacher_id=" + teacher_id + "&thread_id=" + thread_id + "&parent_reply_id=" + parent_reply_id + "&output=json",
                dataType: "json",
                success: function(json){
                    console.log(json);
                    window.location.href = "thread.php?id=" + thread_id+ "&status=" + json.status + "&message=" + json.message;
                },
                error: function (a, b, c) {
                    window.location.href = "thread.php?id=" + thread_id;
                }
            });
    });
});