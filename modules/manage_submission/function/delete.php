<?php
session_start();
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Submission.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);
 
if(isset($_REQUEST['id']) && isset($_REQUEST['file']))
{
	$id=$_REQUEST['id'];
	$file=$_REQUEST['file'];
	$Submission=new Submission($dbconnect->getInstance());
	$delete=$Submission->deleteSubmission($id);
	if($delete==true)
	{
		$msg=Constants::DELETE_SUCCESS_MSG;
		unlink($file);
		echo "<script>
	alert('$msg');
	window.location.href='insert_page.php';
	</script>";

	}
	else
	{
		$msg=Constants::DELETE_FAIL_MSG;
	echo "<script>
	alert('$msg');
	window.location.href='insert_page.php';
	</script>";

	}
}
else
{
	echo "<script>
	alert('Error');
	window.location.href='insert_page.php';
	</script>";
}


?>