$(document).ready(function () {
    $('#batch_list').html("");
    $('#course_list').html("");
    $('#form_input').html("");
    $('body').on('change','#branch_id', function () {
        $('#batch_list').html("");
        $('#course_list').html("");
        var branch_id = $('#branch_id').val();
        console.log(branch_id);
        if(branch_id != 0){
            $.ajax({
                type: "GET",
                url: "get_options.php",
                data: "branch_id="+branch_id+"&select=batch",
                success: function(json){
                    if(json.status=="success"){
                        var select = '<select title="Select batch" id="batch_id" name="batch_id" required>';
                        select = select + '<option value="0" selected> Select a Batch </option>';
                        for (i = 0; i < json.data.length; i++) {
                            select = select + "<option value='" +json.data[i].id + "'>" + json.data[i].name + "</option>";
                        }
                        select = select + '</select>';
                        $("#batch_list").html(select);
                    }else{
                        alert(json.message);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert("Something went wrong");
                }
            });
        }else{
            alert("Please select a branch");
        }
    });

    $('body').on('change','#batch_id', function () {
        $('#course_list').html("");
        $('#form_input').html("");
        var branch_id = $('#branch_id').val();
        var batch_id = $('#batch_id').val();
        if(batch_id != 0){
            $.ajax({
                type: "GET",
                url: "get_options.php",
                data: "branch_id="+branch_id+"&batch_id="+batch_id+"&select=course",
                success: function(json){
                    if(json.status=="success"){
                        var select = '<select title="Select course" id="course_id" name="course_id" required>';
                        select = select + '<option value="0" selected> Select a Course </option>';
                        for (i = 0; i < json.data.length; i++) {
                            select = select + "<option value='" +json.data[i].id + "'>" + json.data[i].name + "</option>";
                        }
                        select = select + '</select>';
                        $("#course_list").html(select);
                    }else{
                        alert(json.message);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert("Something went wrong");
                }
            });
        }else{
            alert("Please select a batch");
        }
    });

    $('body').on('change','#course_id', function () {
        $('#form_input').html("");
        if(course_id != 0){
            var test_form = '<label>Enter Test Title:</label>' +
                            '<input type="text" id="title" name="title" placeholder="Enter test title" required><br>' +
                            '<label>Enter Marks:</label>' +
                            '<input type="number" min=1 id="marks" name="marks" placeholder="Enter marks here" required><br>' +
                            '<label for="date">Date of test:</label>' +
                            '<input type="date" id="date" name="date" value="' + new Date() + '" required><br>' +
                            '<label>Type of test:</label>' +
                            '<input type="radio" id="online" name="type" value="online" onchange="changeAction()" checked required><label for="online">Online</label>' +
                            '<input type="radio" id="offline" name="type" value="offline" onchange="changeAction()" required><label for="offline">Offline</label><br>' +
                            '<button formaction="add_questions.php" formmethod="post" id="test_button" name="test_button" type="submit">Next</button>';
            $('#form_input').html(test_form);
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            $('#date').val(today);
        }else{
            alert("Please select a course");
        }
    });
});

