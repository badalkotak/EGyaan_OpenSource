<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_test/classes/StudentTest.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

// $user_id=3;
$user_id=$_REQUEST['user_id'];

$studentTests=new StudentTest($dbconnect->getInstance());

$json=array();
$test=array();
$final=array();

$getTests=$studentTests->getTests($user_id);

if($getTests!=null)
{
	$final['status']="success";
	while($row=$getTests->fetch_assoc())
	{
		$test['title']=$row['title'];
		$test['date_of_test']=$row['date_of_test'];
		$test['marks']=$row['marks'];
		$test['total_marks']=$row['total_marks'];
		$test['type']=$row['type'];

		$json[]=$test;
	}

	$final['tests']=$json;
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo "[".json_encode($final)."]";
?>