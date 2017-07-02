<?php
include("../../../Resources/sessions.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/TimeTimetable.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);
 
if(isset($_REQUEST['id']))
{
	$id=$_REQUEST['id'];
	$timetimetable=new TimeTimetable($dbconnect->getInstance());
	$delete=$timetimetable->deleteTimeTimetable($id);
	if($delete==true)
	{
		$msg=Constants::DELETE_SUCCESS_MSG;
		echo "<script>
	alert('$msg');
	window.location.href='add_time_timetable.php';
	</script>";

	}
	else
	{
		$msg=Constants::DELETE_FAIL_MSG;
	echo "<script>
	alert('$msg');
	window.location.href='add_time_timetable.php';
	</script>";

	}
}
else
{
	echo "<script>
	alert('Error');
		window.location.href='add_time_timetable.php';
	</script>";
}


?>