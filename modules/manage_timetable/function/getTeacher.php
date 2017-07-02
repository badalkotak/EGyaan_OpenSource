<?php
include("../../../Resources/sessions_for_backend.php");
$user_id=$id;
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_teacher_course/classes/TeacherCourse.php");
require_once("../../manage_user/classes/User.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$user_obj=new User($dbconnect->getInstance());
$teacher_course=new TeacherCourse($dbconnect->getInstance());
$course_id=$_REQUEST['course_id'];

$result_userid=$teacher_course->getTeacherCourse(0,$course_id,0);
$json=array();
$teacher=array();
$final=array();

if($result_userid!=null)
{
	while($row=$result_userid->fetch_assoc())
	{
		$userId=$row['user_id'];
			$result_user=$user_obj->getUser($userId);
			if($result_user!=null)
			{
				while($row_user=$result_user->fetch_assoc())
				{
					$teacher['id']=$row_user['id'];
					$teacher['name']=$row_user['name'];

					$json[]=$teacher;
				}

				$final['status']="success";
				$final['teacher']=$json;
			}
	}
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo json_encode($final);
?>