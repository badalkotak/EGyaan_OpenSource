<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_course/classes/Course.php");
require_once("../../manage_syllabus/classes/Syllabus.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

// $user_id=3; // To be sent via app
$user_id=$_REQUEST['user_id'];

$json=array();
$syllabus_array=array();
$final=array();

$course=new Course($dbconnect->getInstance());
$syllabus=new Syllabus($dbconnect->getInstance());

$getCourse=$course->getCourse("no",$user_id,"no",0,0,null,0);

if($getCourse!=null)
{
	while($row=$getCourse->fetch_assoc())
	{
		$course_id=$row['id'];
		$course_name=$row['name'];
		$getSyllabus=$syllabus->getSyllabus($course_id);

		if($getSyllabus!=null)
		{
			$final['status']="success";

			while($row=$getSyllabus->fetch_assoc())
			{
				$syllabus_array['course']=$course_name;
				$syllabus_array['file']=$row['file'];

				$json[]=$syllabus_array;
			}

			$final['syllabus']=$json;
		}
		else
		{
			$final['status']="fail";
		}
	}
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo "[".json_encode($final)."]";

?>