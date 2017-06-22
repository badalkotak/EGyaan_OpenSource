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
require_once("../../manage_user/classes/User.php");
require_once("../../manage_teacher_course/classes/TeacherCourse.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$timetable=new Timetable($dbconnect->getInstance());
$timetimetable=new TimeTimetable($dbconnect->getInstance());
$timetype=new TimeType($dbconnect->getInstance());

if(empty($_REQUEST['branch']) || empty($_REQUEST['batch']))
{
	$msg=Constants::EMPTY_PARAMETERS;
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('$msg')
        window.location.href='timetable_select_branch_batch.php';
        </SCRIPT>");
}
else
{
	$branch_id=$_REQUEST['branch'];
	$batch_id=$_REQUEST['batch'];
}
?>
<html>
<body>

<?php
if(empty($_REQUEST['day']) && empty($_REQUEST['time']) && empty($_REQUEST['course']))
{
echo '<form action="add_timetable.php" method="post">';
}
else
{
	$day_id=$_REQUEST['day'];
	$time_id=$_REQUEST['time'];
	$course_id=$_REQUEST['course'];
	echo '<form action="insert_timetable.php" method="post">';
}
$days = array(
	' ',
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday',
     'Sunday'
);
echo '
<select name="day">
<option value="0">select</option>';
$i=1;
		while($i<=7)
		{
			if($i == $day_id)
			{
				echo "<option value=".$i." selected>".$days[$i]."</option>";
			}
			else
			{
				echo "<option value=".$i.">".$days[$i]."</option>";
			}
			$i=$i+1;
		}
	
	echo '</select>';
$result_time=$timetimetable->getTimeTimetable();

echo '
<select name="time">
<option value="0">select</option>';
if($result_time!=null)
{
	while($row=$result_time->fetch_assoc())
	{
		$result_timetype=$timetype->getTimeType($row['type']);
		
		if($result_timetype!=null)
		{
			while($row_type=$result_timetype->fetch_assoc())
			{
				if($row['id']==$time_id)
				{
					echo "<option value=".$row['id']." selected>".$row['from_time']."-".$row['to_time']."-".$row_type['name']."</option>";
				}
				else
				{
				echo "<option value=".$row['id'].">".$row['from_time']."-".$row['to_time']."-".$row_type['name']."</option>";
				}
			}
		}
	}
}
echo '</select>';

$course_obj=new Course($dbconnect->getInstance());
$result_course=$course_obj->getCourse("no",0,"yes",$batch_id,0,null,$branch_id);

echo '
<select name="course">
<option value="0">select</option>';

if($result_course!=null)
{
	while($row=$result_course->fetch_assoc())
	{
		if($row['id']==$course_id)
		{
			echo "<option value=".$row['id']." selected>".$row['name']."</option>";
		}
		else
		{
			echo "<option value=".$row['id'].">".$row['name']."</option>";
		}
	}
}
echo '</select>';
echo '<input type=hidden name=branch value='.$branch_id.'>
<input type=hidden name=batch value='.$batch_id.'>';

$user_obj=new User($dbconnect->getInstance());
$teacher_course=new TeacherCourse($dbconnect->getInstance());


if(!empty($_REQUEST['course']))
{
	$course_id=$_REQUEST['course'];
	$result_userid=$teacher_course->getTeacherCourse(0,$course_id,0);
	echo '<select name="user">
	<option value="0">select</option>';

	if($result_userid != null)
	{
		while($row_userId=$result_userid->fetch_assoc())
		{
			$userId=$row_userId['user_id'];
			$result_user=$user_obj->getUser($userId);
			if($result_user!=null)
			{
				while($row_user=$result_user->fetch_assoc())
				{

					echo "<option value=".$row_user['id'].">".$row_user['name']."</option>";
				}
			}
			
		}
	}
}
echo '</select>';
echo '<input type=submit name=submit value=submit>';
?>
</form>

<table>
<tr>
<th>Timing</th>
<th>Monday</th>
<th>Tuesday</th>
<th>Wednesday</th>
<th>Thursday</th>
<th>Friday</th>
<th>Saturday</th>
<th>Sunday</th>
</tr>

<?php

$getTiming=$timetimetable->getTimeTimetable();
if($getTiming!=null)
{
		while($row=$getTiming->fetch_assoc())
		{
			$time_id=$row['id'];
			$from_time=$row['from_time'];
			$to_time=$row['to_time'];

			echo "<tr>";
			echo "<td>";
			echo $from_time." - ".$to_time;
			echo "</td>";

			for($day=1;$day<=7;$day++)//7 days of week loop
			{
				$getLecture=$timetable->getTimetable($batch_id,$day,$time_id);
				if($getLecture!=null)
				{
					while($lectureRow=$getLecture->fetch_assoc())
					{
						$teacher_course_id=$lectureRow['teacher_course_id'];
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

							echo "<td>";
							echo $course_name." (".$user_name.")"; 
							echo "</td>";
					}
					
				}
				else
				{
					echo "<td>";
					echo "</td>";
				}
			}

			echo "</tr>";
		}
}
else
{
	echo "Insert timing first";
	break;
}
?>
</table>
</body>
</html>