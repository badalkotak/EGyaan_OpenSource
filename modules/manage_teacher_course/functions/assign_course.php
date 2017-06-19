<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/TeacherCourse.php");
require_once("../../manage_role/classes/Role.php");
require_once("../../manage_branch/classes/Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

?>

<html>
<head>
	<title>Assign Course</title>
	<script src="../../../Resources/jquery.min.js"></script>
</head>
<body>
	Assign Course:<br><br>

	<form action="add_teacher_course.php" method="post">
		<select name="branch" id="branch">
		<option value=-1>Select Branch</option>
		<?php
			$branch=new Branch($dbConnect->getInstance());

			$getBranch=$branch->getBranch();
			if($getBranch!=null)
			{
				while($row=$getBranch->fetch_assoc())
				{
					$branch_id=$row['id'];
					$branch_name=$row['name'];

					echo "<option value=$branch_id>$branch_name</option>";
				}
			}
		?>
		</select>
	</form>
	<br>
	<div id="batch_div"></div>
</body>

<script>
$(document).ready(function(){
	$("#branch").change(function(){
		var branch_id=$("#branch").val();

		if(branch_id!=-1)
		{
			$.ajax({
				type: "POST",
				url: "getBatch.php",
				data: "branch_id="+branch_id,
				datatype: "json",

				success:function(json)
				{
					var status=json.status;
					var count=json.batch.length;
					var batch_dropdown="<select name=batch id=batch><option value=-1>Select Batch</option>";

					for(var i=0;i<count;i++)
					{
						batch_dropdown = batch_dropdown + "<option value="+json.batch[i].id+">"+json.batch[i].name+"</option>";
					}

					batch_dropdown = batch_dropdown + "</select><script type=text/javascript src='getBatch.js'></ script>";

					$("#batch_div").html(batch_dropdown);
				}
			});
		}
		else
		{
			$("#batch_div").text("Please select the Branch!");
		}
	});

	// $("#batch").change(function(){
	// 	var batch_id=$("#batch").val();

	// 	console.log("Hua");
	// 	if(batch_id!=-1)
	// 	{
	// 		$.ajax({
	// 			type: "POST",
	// 			url: "getCourse.php",
	// 			data: "batch_id="+batch_id,
	// 			datatype: "json",

	// 			success:function(json)
	// 			{
	// 				console.log(json);
	// 			}
	// 		});
	// 	}
	// });
});
</script>
</html>