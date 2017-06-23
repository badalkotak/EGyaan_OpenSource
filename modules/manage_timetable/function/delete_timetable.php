<?php
session_start();
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Timetable.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);
 
if(isset($_REQUEST['id']))
{
	$id=$_REQUEST['id'];
	$timetable=new Timetable($dbconnect->getInstance());
	$delete=$timetable->deleteTimeTable($id);
	if($delete==true)
	{
		$msg=Constants::DELETE_SUCCESS_MSG;
		echo "<script>
	alert('$msg');
	window.location.href='timetable_select_branch_batch.php';
	</script>";

	}
	else
	{
		$msg=Constants::DELETE_FAIL_MSG;
	echo "<script>
	alert('$msg');
	window.location.href='timetable_select_branch_batch.php';
	</script>";

	}
}
else
{
	echo "<script>
	alert('Error');
		window.location.href='timetable_select_branch_batch.php';
	</script>";
}


?>