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

<?php
if(empty($_REQUEST['branch']))
{ 
	echo '<form action="timetale_select_branch_batch.php" method="post">
<select name="branch">
<option value="0">select</option>';

	$result_branch=$branch->getBranch(0);
	if($result_branch!=null)
	{
		while($row=$result_branch->fetch_assoc())
		{
			echo "<option value=".$row['id'].">".$row['name']."</option>";
		}
	} 
	echo '</select>
	<input type=submit name=submit value=submit></form>';
}
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

?>

</body>
</html>