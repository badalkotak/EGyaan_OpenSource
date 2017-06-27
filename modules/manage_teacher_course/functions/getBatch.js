//Used to get courses

$(document).ready(function(){
$("#batch").change(function(){
		var batch_id=$("#batch").val();

		if(batch_id!=-1)
		{
			$.ajax({
				type: "POST",
				url: "getCourse.php",
				data: "batch_id="+batch_id,
				datatype: "json",

				success:function(json)
				{
					var status=json.status;
					var user_id=$("#user_id").val();

					if(status==="success")
					{
						var count=json.course.length;
						var course_dropdown="<form role='form' action=insert_teacher_course.php method=post id=course_form><input type=radio hidden checked value="+user_id+" id=user_id name=user_id><div class='form-group'><label>Course</label><select class='form-control' name=course id=course><option value=-1>Select Course</option>";

						for(var i=0;i<count;i++)
						{
							course_dropdown = course_dropdown + "<option value="+json.course[i].id+">"+json.course[i].name+"</option>";
						}

						course_dropdown = course_dropdown + "</select></div><button class='btn btn-success' type=submit id=submit><i class='fa fa-check'></i>&nbsp;Submit</button><br><div id=course_err></div></form><script src=checkCourse.js></script>";

						$("#course_div").html(course_dropdown);
					}
					else
					{
						$("#course_div").text("This batch has not Courses added to it!");	
					}
				}
			});
		}

		else
		{
			$("#course_div").text("Please select the Batch!");
		}
	});
});