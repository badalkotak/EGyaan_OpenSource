$(document).ready(function(){
	$("#submit").click(function(){
		var course_id=$("#course").val();

		if(course_id!=-1)
		{
			return true;
		}
		else
		{
			$("#course_err").html("<h4 class='alert-message'><i class='fa fa-exclamation-triangle'></i>Please select the Course!</h4>");
			return false;
		}
	});
});