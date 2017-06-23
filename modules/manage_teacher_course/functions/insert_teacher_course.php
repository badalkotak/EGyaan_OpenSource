<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/TeacherCourse.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$teacherCourse=new TeacherCourse($dbConnect->getInstance());

$user_id=$_REQUEST['user_id'];
$course_id=$_REQUEST['course'];
$insert=$teacherCourse->insertTeacherCourse($user_id,$course_id);

if($insert===true)
{
	// echo "Done";
	$message=Constants::COURSE_ASSIGN_SUCCESS;
}
else if($insert==Constants::STATUS_EXISTS)
{
	$message = "This course is already assigned to this user!";
}
else
{
	$message=Constants::COURSE_ASSIGN_FAIL;
}

echo "<script>alert('$message');window.location.href='assign_course.php?user_id=$user_id';</script>";
?>