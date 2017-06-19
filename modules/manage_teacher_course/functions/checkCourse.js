$(document).ready(function(){
	$("#submit").click(function(){
		var course_id=$("#course").val();

		if(course_id!=-1)
		{
			return true;
		}
		else
		{
			$("#course_err").text("Please select the Course!");
			return false;
		}
	});
});