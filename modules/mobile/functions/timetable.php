<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_timetable/classes/Timetable.php");
require_once("../../manage_timetable/classes/TimeTimetable.php");
require_once("../../manage_teacher_course/classes/TeacherCourse.php");
require_once("../../manage_course/classes/Course.php");
require_once("../../manage_user/classes/User.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$batch_id=2; // to be sent from local database of app $_REQUEST['batch_id']
$day_id=1; // to be sent from the app $_REQUEST['day_id']

$json=array();
$lecture=array();
$final=array();

$timetable=new Timetable($dbconnect->getInstance());
$timeTimetable=new TimeTimetable($dbconnect->getInstance());
$course_obj=new Course($dbconnect->getInstance());
$user_obj=new User($dbconnect->getInstance());
$teacher_course=new TeacherCourse($dbconnect->getInstance());

$getTime=$timeTimetable->getTimeTimetable();

if($getTime!=null)
{
	while($timeRow=$getTime->fetch_assoc())
	{
		$time_id=$timeRow['id'];
		$getLecture=$timetable->getTimetable(0,$batch_id,$day_id,$time_id);

		if($getLecture!=null)
		{
			while($row=$getLecture->fetch_assoc())
			{
				$lecture['day_id']=$day_id;
				$lecture['time_id']=$time_id;
				$teacher_course_id=$row['teacher_course_id'];

				$teacher_course_details=$teacher_course->getTeacherCourse(0,0,$teacher_course_id);
				while($teacherCourseRow=$teacher_course_details->fetch_assoc())
				{
					$user_id=$teacherCourseRow['user_id'];

					$get_user_name=$user_obj->getUser($user_id);
					while($nameRow=$get_user_name->fetch_assoc())
					{
						$user_name=$nameRow['name'];
					}

					$course_id=$teacherCourseRow['course_id'];
					$get_course_name=$course_obj->getCourse("no",0,"no",0,$course_id,null,0);

					while($courseRow=$get_course_name->fetch_assoc())
					{
						$course_name=$courseRow['name'];
					}
				}

				$lecture['teacher']=$user_name;
				$lecture['course']=$course_name;
			}
		}
		else
		{
			$lecture['day_id']=$day_id;
			$lecture['time_id']=$time_id;
			$lecture['teacher']=null;
			$lecture['course']=null;
		}

		$json[]=$lecture;
	}

	$final['status']="success";
	$final['timetable']=$json;
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo json_encode($final);
?>