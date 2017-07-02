$(document).ready(function () {

    $("#submit").click(function () {
        $("#add_thread").submit(function (event) {
            event.preventDefault();
        });

        var title = $("#title").val();
        if(title.length <= 0){
            new PNotify({
                title: 'Ohh No! Error',
                type: 'error',
                text: 'Title Is Too Small',
                nonblock: {
                    nonblock: false
                },
                styling: 'bootstrap3',
                hide: true,
                before_close: function(PNotify) {
                    PNotify.update({
                        title: PNotify.options.title + ' - Enjoy your Stay',
                        before_close: null
                    });

                    PNotify.queueRemove();

                    return false;
                }
            });
            return;
        }
        var description = $("#description").val();
        if(description.length < 20){
            new PNotify({
                title: 'Ohh No! Error',
                type: 'error',
                text: 'Description Cannot Be Smaller Than 20 Characters',
                nonblock: {
                    nonblock: false
                },
                styling: 'bootstrap3',
                hide: true,
                before_close: function(PNotify) {
                    PNotify.update({
                        title: PNotify.options.title + ' - Enjoy your Stay',
                        before_close: null
                    });

                    PNotify.queueRemove();

                    return false;
                }
            });
            return;
        }
        var student_id = $("#student_id").val();
        var teacher_id = $("#teacher_id").val();
        var course_id = $("#course_id").val();

        $.ajax(
            {
                type:"POST",
                url: "functions/add_thread.php",
                data: "title=" + title + "&description=" + description + "&student_id=" + student_id + "&teacher_id=" + teacher_id + "&course_id=" + course_id + "&output=json",
                dataType: "json",
                success: function(json){
                    console.log(json);
                    window.location.href = "forum.php?status=" + json.status +"&message=" + json.message;
                },
                error:function (a,b,c) {
                    console.log(b);
                    console.log(c);
                    window.location.href = "forum.php?status=failed&message=Something Went Wrong";
                }
            });
    });
});
