<?php
include("../../../Resources/sessions.php");
$user_id=$id;
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/TimeTimetable.php");
require_once("../classes/TimeType.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);
$timetimetable=new TimeTimetable($dbconnect->getInstance());

if(empty($_REQUEST['type']) || empty($_REQUEST['from_time']) || empty($_REQUEST['to_time']))
{
	$msg=Constants::EMPTY_PARAMETERS;
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('$msg')
        window.location.href='add_time_timetable.php';
        </SCRIPT>");
}
else
{
	$from=$_REQUEST['from_time'];
	$to=$_REQUEST['to_time'];
	$type=$_REQUEST['type'];
	$insert=$timetimetable->insertTimeTimetable($from,$to,$type);
	if($insert === true)
	{
		$msg=Constants::INSERT_SUCCESS_MSG;
		echo "<script>
		alert('$msg');
		window.location.href='add_time_timetable.php';
		</script>";
	}
	else if($insert==Constants::STATUS_EXISTS)
	{
		echo "<script>
		alert('$insert');
		window.location.href='add_time_timetable.php';
		</script>";
	}
	else
	{
		$msg=Constants::INSERT_FAIL_MSG;
		echo "<script>
		alert('$msg');
		window.location.href='add_time_timetable.php';
		</script>";
	}
}
?>