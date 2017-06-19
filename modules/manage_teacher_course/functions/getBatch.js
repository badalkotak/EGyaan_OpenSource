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
					console.log(json);
				}
			});
		}
	});
});