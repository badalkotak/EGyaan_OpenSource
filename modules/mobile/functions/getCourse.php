<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_course/classes/Course.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$user_id=3; // To be sent via app

$json=array();
$course_array=array();
$final=array();

$course=new Course($dbconnect->getInstance());

$getCourse=$course->getCourse("no",$user_id,"no",0,0,null,0);

if($getCourse!=null)
{
	$final['status']="success";
	while($row=$getCourse->fetch_assoc())
	{
		$course_array['id']=$row['id'];
		$course_array['name']=$row['name'];

		$json[]=$course_array;
	}
	$final['course']=$json;
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo json_encode($final);
?>