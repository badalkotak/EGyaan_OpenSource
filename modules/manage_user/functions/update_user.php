<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/User.php");
require_once("../../manage_role/classes/Role.php");
require_once("../../manage_teacher_course/classes/TeacherCourse.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$user=new User($dbConnect->getInstance());
$teacherCourse=new TeacherCourse($dbConnect->getInstance());

$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$mobile=$_REQUEST['mobile'];
$role_id=$_REQUEST['role_id'];
$gender=$_REQUEST['gender'];
$user_id=$_REQUEST['submit'];

if($role_id!=Constants::ROLE_TEACHER_ID)
{
	$delete=$teacherCourse->deleteTeacherCourse(0,$user_id);
}

$update=$user->updateUser($user_id,$email,$role_id,$gender,$mobile,$name);
if($update)
{
	$message="User ".Constants::UPDATE_SUCCESS_MSG;}
else
{
	$message="User ".Constants::UPDATE_FAIL_MSG;
}

	echo "<script>alert('$message');window.location.href='user.php';</script>";
?>