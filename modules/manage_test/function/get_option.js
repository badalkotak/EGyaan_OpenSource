$(document).ready(function () {
    
    $('body').on('change','#branch_id', function () {
        $('#batch_list').html("");
        $('#course_list').html("");
        var branch_id = $('#branch_id').val();
        if(branch_id != 0){
            $.ajax({
                type: "GET",
                url: "get_options.php",
                data: "branch_id="+branch_id+"&select=batch",
                success: function(json){
                    if(json.status=="success" && json.type=="specific"){
                        var select = '<div class="form-group"><select title="Select batch" class="form-control select2" id="batch_id" name="batch_id" required>';
                        select = select + '<option value="0" selected disabled> Select a Batch </option>';
                        for (i = 0; i < json.data.length; i++) {
                            select = select + "<option value='" +json.data[i].id + "'>" + json.data[i].name + "</option>";
                        }
                        select = select + '</select></div>';
                        $("#batch_list").html(select);
                        $(".select2").select2();
                    }else if(json.status=="success" && json.type=="unspecific"){
                        var select = '<div class="form-group"><select title="Select course" class="form-control select2" id="course_id" name="course_id" required>';
                        select = select + '<option value="0" selected disabled> Select a Course </option>';
                        for (i = 0; i < json.data.length; i++) {
                            select = select + "<option value='" +json.data[i].courseId + "'>" + json.data[i].courseName + "</option>";
                        }
                        select = select + '</select></div>';
                        $("#course_list").html(select);
                        $(".select2").select2();
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
                        var select = '<div class="form-group"><select title="Select course" class="form-control select2" id="course_id" name="course_id" required>';
                        select = select + '<option value="0" selected disabled> Select a Course </option>';
                        for (i = 0; i < json.data.length; i++) {
                            select = select + "<option value='" +json.data[i].id + "'>" + json.data[i].name + "</option>";
                        }
                        select = select + '</select></div>';
                        $("#course_list").html(select);
                        $(".select2").select2();
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
            var test_form = '<div class="form-group">' + 
                                '<input type="text" class="form-control" id="title" name="title" placeholder="Enter test title" required>' + 
                            '</div>' +
                            '<div class="form-group">' + 
                                '<input type="number" class="form-control" min=1 id="marks" name="marks" placeholder="Enter marks here" required>' + 
                            '</div>' +
                            '<div class="form-group">' + 
                                '<div class="input-group">' +
                                    '<input type="date" class="form-control" id="date" placeholder="Date Of Test" name="date" value="' + new Date() + '" required>' +
                                    '<div class="input-group-addon">' + 
                                        '<i class="fa fa-calendar"></i>' +
                                    '</div>' + 
                                '</div>' + 
                            '</div>' +
                            '<div class="form-group">' + 
                                '<label>Type of test:</label>' + 
                                '<div class="radio">' + 
                                    '<label for="online">' + 
                                        '<input type="radio" id="online" name="type" value="online" onchange="changeAction()" checked required> Online' + 
                                    '</label>' + 
                                '</div>' +
                                '<div class="radio">' + 
                                    '<label for="offline">' + 
                                        '<input type="radio" id="offline" name="type" value="offline" onchange="changeAction()" required> Offline' + 
                                    '</label>' + 
                                '</div>' +
                            '</div>' +
                            '<button formaction="add_questions.php" formmethod="post" id="test_button" name="test_button" type="submit" class="btn btn-success">Next <span class="fa fa-angle-right"></span></button>';
            $('#form_input').html(test_form);
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            $('#date').val(today);
            $('.datepicker').datepicker({
                autoclose: true
            });
        }else{
            alert("Please select a course");
        }
    });
});

