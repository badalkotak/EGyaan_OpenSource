/**
 * Created by adityajthakker on 28/12/16.
 */

$(document).ready(function () {
    var topic_id;
    var timetable_id;
    var isTopicCompleted;
    $("body").hide();
    $("#courses_apply_button").hide();

    $("#meta_info_form_topics").hide();
    $("#topic_apply_button").hide();


    $("#meta_info_form_timetable").hide();
    $("#meta_info_form_button").hide();

    $("#content").hide();
    $("body").show();

    $("#meta_info_form_timetable").submit(function (event) {
        event.preventDefault();
    });

    $("#topic_id").change(function () {
        topic_id = $(this).val();
        if(topic_id != "null"){
            $("#meta_info_form_timetable").show();
            $("#message").html("<p></p>");

        }else{
            $("#meta_info_form_timetable").hide();
            $("#message").html("<p>Select A Valid Topic</p>");
        }
    });

    $("#isTopicCompleted").change(function () {
        isTopicCompleted = $(this).is(':checked');
    });



    $("#timetable_id").change(function () {
        timetable_id = $(this).val();
        if(timetable_id != "null"){
            $("#message").html("<p></p>");
            $.ajax({
                url: "functions/getStudents.php",
                type:"POST",
                dataType:"json",
                success:function (json) {
                    if(json.status == "success"){
                        var content = "<form id='attendance_marking_form' action='functions/attendanceMarking.php' method='post'> " +
                            "<input type='hidden' name='topic_id' " +
                            "value='" + topic_id + "'/> " +
                            "<input type='hidden' name='timetable_id' " +
                            "value='" + timetable_id + "'/> " +
                            "<table id='attendance_list'>";
                        for(var i = 0; i < json.students.length; i++){
                            content = content +  "<tr><td>" + json.students[i].id + "</td><td>" + json.students[i].student_fullname + "</td><td><input type='checkbox' name='attendees[]' id='attendees' value='" + json.students[i].id + "'/></td></tr>";
                        }
                        content = content + "</table> " +
                            "<input type='submit' value='Mark Attendance' id='attendance_marking_form_submit'/> " +
                            "</form>";
                        $("#content").html(content);
                        $("#content").show();

                        $("#attendance_marking_form").submit(function (event) {
                            event.preventDefault();
                        });

                        $("#attendance_marking_form_submit").click(function () {
                            var attendees = [];
                            $("#attendance_marking_form input:checkbox:checked").each(function() {
                                attendees.push($(this).val()); // do your staff with each checkbox
                            });
                            console.log(attendees);
                            $.ajax({
                                url: "functions/attendanceMarking.php",
                                type:"POST",
                                data:{
                                    topic_id:topic_id,
                                    timetable_id:timetable_id,
                                    attendees:attendees,
                                    isTopicCompleted: isTopicCompleted,
                                    output:"json"
                                },
                                dataType:"json",
                                success:function (json) {
                                    if(json.status == "success"){
                                        if(json.redirect == true){
                                            window.location.href = "addMCQ.php";
                                        }else{
                                            $("#message").html("<p>" + json.message+ "</p>");
                                            $('#course_id').val('null');
                                            $('#topic_id').val('null');
                                            topic_id = "null";
                                            $("#meta_info_form_topics").hide();
                                            $('#timetable_id').val('null');
                                            timetable_id = "null";
                                            $("#meta_info_form_timetable").hide();
                                            $('#isTopicCompleted').attr('checked', false);
                                            $('#isTopicCompleted').val('null');
                                            isTopicCompleted = "null";
                                            $("#content").html("");
                                            $("#content").hide();
                                        }

                                    }else{
                                        $("#message").html("<p>" + json.message+ "</p>");
                                    }

                                },
                                error:function (a, b, c) {
                                    console.log("error: " + b);
                                    console.log(c);
                                }
                            });
                        });

                    }else{
                        $("#message").html("<p>"+json.message+"</p>");
                        $("#content").hide();
                    }
                },
                error:function (a, b, c) {
                    console.log("error: " + b);
                    console.log(c);
                }
            });
        }else{
            $("#message").html("<p>Select A Valid Topic</p>");
        }
    });



    $("#course_id").change(function () {
        var course_id = $(this).val();
        if(course_id != "null"){
            $("#message").html("<p></p>");
            $("#meta_info_form_topics").show();
            $.ajax({
                url: "functions/getTopics.php",
                type:"POST",
                data:{course_id:course_id},
                dataType:"json",
                success:function (json) {
                    if(json.status == "success"){
                        var options = "<option value='null'>Select Topic</option>";
                        for(var i = 0; i < json.topics.length; i++){
                            options = options + "<option value='" + json.topics[i].id + "'>" + json.topics[i].name + "</option>";
                        }
                        $("#topic_id").html(options);
                    }else{
                        $("#message").html("<p>"+json.message+"</p>");
                    }
                },
                error:function (a, b, c) {
                    console.log("error: " + b);
                    console.log(c);
                }
            });
        }else{
            $("#message").html("<p>Select A Valid Course</p>");
            $("#meta_info_form_topics").hide();
        }
    });

});
