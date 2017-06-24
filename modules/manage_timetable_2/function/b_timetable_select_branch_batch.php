<?php
include("../../../Resources/sessions.php");
$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Timetable.php");
require_once("../../manage_branch/classes/Branch.php");
require_once("../../manage_batch/classes/Batch.php");
// require_once("../../manage_teacher_course/classes/TeacherCourse.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$branch=new Branch($dbconnect->getInstance());
$batch=new Batch($dbconnect->getInstance());
?>
<html>
<body>
<script src="../../../Resources/jquery.min.js"></script>


<?php
//if(empty($_REQUEST['branch']))
//{ 
	echo '<form  method="post" id="select_batch">
<select name="branch" id=branch>
<option value="-1">select</option>';

	$result_branch=$branch->getBranch(0);
	if($result_branch!=null)
	{
		while($row=$result_branch->fetch_assoc())
		{
			echo "<option value=".$row['id'].">".$row['name']."</option>";
		}
	} 
	echo '</select></form>
	
	
	<div id=batch_div>
	</div>';

/*}
else
{
	echo '<form action="add_timetable.php" method="post">
<select name="branch">
<option value="0">select</option>';
	$branch_id=$_REQUEST['branch'];
	$result_branch=$branch->getBranch(0);
	if($result_branch!=null)
	{
		while($row=$result_branch->fetch_assoc())
		{
			if($row['id']==$branch_id)
			{
				echo "<option value=".$row['id']." selected>".$row['name']."</option>";
			}
			else
			{
				echo "<option value=".$row['id'].">".$row['name']."</option>";
			}
		}
		echo '</select>';
	}
	$result_batch=$batch->getBatch("yes",$branch_id,0,"yes",0);
	echo '<select name="batch">
<option value="0">select</option>';
	if($result_batch!=null)
	{
		while($row=$result_batch->fetch_assoc())
		{
			echo "<option value=".$row['id'].">".$row['name']."</option>";
		}
	}
	echo '</select><input type=submit name=submit value=submit></form>';
}
*/
?>

</body>
<script type="text/javascript">
	$(document).ready(function(){

		$("#select_batch").change(function(){
			event.preventDefault();
			var branch=$("#branch").val();

			if(branch==-1)
			{
				$("#batch_div").text("Please input all the fields!");
			}
			else
			{
				$.ajax({
					type: "POST",
					url: "get_batch.php",
					data: "branch_id="+branch,
					datatype: "json",

					success:function(json)
					{
						var status=json.status;
						if (status=="success") 
						{
							var count=json.batch.length;
							
							var batch_dropdown = "<form action=add_timetable.php method=post><input type=hidden name=branch value="+branch+"><select name=batch><option value=-1>Select batch</option>"
							for(var i=0;i<count;i++)
							{
								batch_dropdown = batch_dropdown + "<option value="+json.batch[i].id+">"+json.batch[i].name+"</option>";
							}
							batch_dropdown = batch_dropdown + "</select><input type=submit name=submit value=submit></form>";

							$("#batch_div").html(batch_dropdown);
						}
					}
				});
			}
		});
	});
</script>
</html>