<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/TeacherCourse.php");
require_once("../../manage_role/classes/Role.php");
require_once("../../manage_branch/classes/Branch.php");
require_once("../../manage_course/classes/Course.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$user_id=$_REQUEST['user_id'];
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
			<?php
				$course=new Course($dbConnect->getInstance());

				$getCourse=$course->getCourse("yes",$user_id,"no",0,0,null,0);

				$i=0;

				if($getCourse!=false)
				{
					echo "<table>
							<thead>
								<th>Sr No.</th>
								<th>Branch</th>
								<th>Batch</th>
								<th>Course</th>
								<th>Delete</th>
							</thead>
							<tbody>";

					while($row=$getCourse->fetch_assoc())
					{
						$i++;
						$courseId=$row['courseId'];
						$courseName=$row['courseName'];

						$batchName=$row['batchName'];
						$branchName=$row['branchName'];

						echo "<tr>";

						echo "<td>";
						echo $i;
						echo "</td>";

						echo "<td>";
						echo $branchName;
						echo "</td>";

						echo "<td>";
						echo $batchName;
						echo "</td>";

						echo "<td>";
						echo $courseName;
						echo "</td>";

						echo "<td>";
						echo "<form action=delete_teacher_course.php method=post><input type=submit value=$courseId name=courseId></form>";
						echo "</td>";

						echo "</tr>";
					}

					echo "</tbody>
					</table>";
				}
				else
				{
					echo "No courses assigned yet!";
				}
			?>
</body>

<script>
$(document).ready(function(){
	$("#branch").change(function(){
		var branch_id=$("#branch").val();
		<?php
			echo "var user_id=$user_id";
		?>

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
					var batch_dropdown="<input type=radio hidden value="+user_id+" id=user_id><select name=batch id=batch><option value=-1>Select Batch</option>";

					for(var i=0;i<count;i++)
					{
						batch_dropdown = batch_dropdown + "<option value="+json.batch[i].id+">"+json.batch[i].name+"</option>";
					}

					batch_dropdown = batch_dropdown + "</select><br><br><div id=course_div></div><script type=text/javascript src='getBatch.js'></ script>";

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
	<script src=getBatch.js></script>
	<script src=checkCourse.js></script>
</html>