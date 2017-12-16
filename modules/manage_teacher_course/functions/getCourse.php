<?php
include("../../../Resources/sessions_for_backend.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../../manage_course/classes/Course.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);


$course=new Course($dbConnect->getInstance());

$batch_id=$_REQUEST['batch_id'];
$getCourse=$course->getCourse("no",0,"yes",$batch_id,0,null,0);

$json=array();
$course_array=array();
$final=array();

if($getCourse!=false)
{
	while($row=$getCourse->fetch_assoc())
	{
		$course_array['id']=$row['courseId'];
		$course_array['name']=$row['courseName'];

		$json[]=$course_array;
	}

	$final['status']="success";
	$final['course']=$json;
}

else
{
	$final['status']="fail";
}

header("Content-Type: application/json");

echo json_encode($final);
?>