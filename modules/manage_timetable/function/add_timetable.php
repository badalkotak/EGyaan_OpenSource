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
<th> </th>
<th>Monday</th>
<th>Tuesday</th>
<th>Wednesday</th>
<th>Thursday</th>
<th>Friday</th>
<th>Saturday</th>
<th>Sunday</th>
</tr>

<?php

/*$teachercourse=new TeacherCourse($dbconnect->getInstance());

$result=$timetable->getTimeTable($batch_id,0,0);
if($result != null)
{

while($row=$result->fetch_assoc())
{
	$result_time1=$timetimetable->getTimeTimetable();
	if($result_time1 != null)
	{
		while($row_time1=$result_time1->fetch_assoc())
		{
			
			echo '<tr><td>'.$row_time1['from_time'].'-'.$row_time1['to_time'].'</td>';
			$time1=$row_time1['id'];
		
	$day_id=$row['day_id'];
	$time_id=$row['time_id'];
	$teacher_course_id=$row['teacher_course_id'];
	$result_time=$timetimetable->getTimeTimetable();
	if($result_time != null)
	{
		while($row_time=$result_time->fetch_assoc())
		{
			 if($row_time['id']==$time_id)
			 {
			 	 $row_time['id'];
			 	$time_id_timetable=$row_time['id'];
			 	$from_time=$row_time['from_time'];
			 	$to_time=$row_time['to_time'];
			 	$type=$row_time['type'];
			 	$result_type=$timetype->getTimeType($type);
			 	if($result_type!=null)
			 	{
			 		while($row_type=$result_type->fetch_assoc())
			 		{
			 			 $type_name=$row_type['name'];
			 		}
			 	}
			 }
		}
	}
}
}
$i=1;
while($i<8)
	{
		if($day_id==$i && $time_id==$time1)
		{
			echo '<td>'.$day_id.'</td>';
		}
		else
		{	
			echo '<td>Available</td>';
		}
	$i=$i+1;
	}

echo '</tr>';
}
}


$result_time=$timetimetable->getTimeTimetable();
if($result_time != null)
{
while($row_time=$result_time->fetch_assoc())
{
	 $time_id=$row_time['id'];
	$time_from=$row_time['from_time'];
	$time_to=$row_time['to_time'];
				echo '<td>'.$time_from.'-'.$time_to.'</td>';
if($result!=null)
{
while($i<8)
{

	while($row=$result->fetch_assoc())
			{

					
					if($row['time_id']==$time_id && $row['day_id']==$i)
					{
						$result_teacher_course=$teachercourse->getTeacherCourse(0,0,$row['teacher_course_id']);
						if($result_teacher_course!=null)
						{

							while($row_teacher_course=$result_teacher_course->fetch_assoc())
							{
								$result_user=$user_obj->getUser($row_teacher_course['user_id']);
								{
									if($result_user!=null)
									{
										while($row_user=$result_user->fetch_assoc())
										{
											echo $user=$row_user['name'];
										}
									}
								}
								$result_course=$course_obj->getcourse("no",0,"no",0,$row_teacher_course['user_id'],null,0);
								{
									if($result_course!=null)
									{
										while($row_course=$result_course->fetch_assoc())
										{
											$course=$row_course['name'];
										}
									}
								}
							}
						}
						echo '<td>'.$user.'-'.$course.'</td>';
					}
					else
					{
						echo '<td>--Available--</td>';
					}
				}
			}
		}
$i=$i+1;
}
echo '</tr>';
}*/
?>
</table>
</body>
</html>