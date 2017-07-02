<?php
include("../../../Resources/sessions.php");
$user_id=$id;
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/TimeType.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);
$timetype=new TimeType($dbconnect->getInstance());

if(empty($_REQUEST['type']))
{
	$msg=Constants::EMPTY_PARAMETERS;
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('$msg')
        window.location.href='add_time_type.php';
        </SCRIPT>");
}
else
{
	$type=$_REQUEST['type'];
	$insert=$timetype->insertTimeType($type);
	if($insert === true)
	{
		$msg=Constants::INSERT_SUCCESS_MSG;
		echo "<script>
		alert('$msg');
		window.location.href='add_time_type.php';
		</script>";
	}
	else if($insert==Constants::STATUS_EXISTS)
	{
		echo "<script>
		alert('$insert');
		window.location.href='add_time_type.php';
		</script>";
	}
	else
	{
		$msg=Constants::INSERT_FAIL_MSG;
		echo "<script>
		alert('$msg');
		window.location.href='add_time_type.php';
		</script>";
	}
}
?>