<?php
include("../../../Resources/sessions.php");
$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Timetable.php");
require_once("../classes/TimeType.php");
require_once("../classes/TimeTimetable.php");
require_once("../../manage_branch/classes/Branch.php");
require_once("../../manage_batch/classes/Batch.php");
require_once("../../manage_course/classes/Course.php");
require_once("../../manage_teacher_course/classes/TeacherCourse.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$timetable=new Timetable($dbconnect->getInstance());
$timetimetable=new TimeTimetable($dbconnect->getInstance());
$timetype=new TimeType($dbconnect->getInstance());


if(empty($_REQUEST['day']) || empty($_REQUEST['time']) || empty($_REQUEST['course']))
{
	$batch=$_REQUEST['batch'];
	$branch=$_REQUEST['branch'];
	$msg=Constants::EMPTY_PARAMETERS;
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('$msg')
        window.location.href='add_timetable.php?branch=$branch&batch=$batch';
        </SCRIPT>");
}
else
{
	$day_id=$_REQUEST['day'];
	$time_id=$_REQUEST['time'];
	$course_id=$_REQUEST['course'];
	$user_id=$_REQUEST['user'];
	$batch=$_REQUEST['batch'];
	$branch=$_REQUEST['branch'];
	$comment=$_REQUEST['comment'];

	$teacher_course=new TeacherCourse($dbconnect->getInstance());
	$result_teacher_course_id=$teacher_course->getTeacherCourse($user_id,$course_id,0);
	if($result_teacher_course_id != null)
	{
		while($row_teacher_course_id=$result_teacher_course_id->fetch_assoc())
		{
			$teacher_course_id=$row_teacher_course_id['id'];
		}
	}

	$result_timetable=$timetable->getTimetable($user_id,$batch,$time_id,$day_id);
	if($result_timetable == null)
	{
		
		$insert_timetable=$timetable->insertTimeTable($day_id,$time_id,$teacher_course_id,$comment);
	
	
		if($insert_timetable === true)
		{
			echo $msg=Constants::INSERT_SUCCESS_MSG;
			echo ("<SCRIPT LANGUAGE='JavaScript'>
		        window.alert('$msg')
		        window.location.href='add_timetable.php?branch=$branch&batch=$batch';
		        </SCRIPT>");
		}
		else if($insert_timetable == Constants::STATUS_EXISTS)
		{
			echo $msg=$insert_timetable;
			echo ("<SCRIPT LANGUAGE='JavaScript'>
		        window.alert('$msg')
		        window.location.href='add_timetable.php?branch=$branch&batch=$batch';
		        </SCRIPT>");
		}
		else
		{
			$msg=Constants::INSERT_FAIL_MSG;
			echo ("<SCRIPT LANGUAGE='JavaScript'>
		        window.alert('$msg')
		        window.location.href='add_timetable.php?branch=$branch&batch=$batch';
		        </SCRIPT>");
		}
	}
	else
	{
		while($row=$result_timetable->fetch_assoc())
		{
			$batch_name=$row['batch'];
			$branch_name=$row['branch'];
		}
		$msg="Teacher Busy at ".$batch_name." of ".$branch_name." Branch. ";
		echo ("<SCRIPT LANGUAGE='JavaScript'>
	        window.alert('$msg')
	        window.location.href='add_timetable.php?branch=$branch&batch=$batch';
	        </SCRIPT>");
	}
}
?>