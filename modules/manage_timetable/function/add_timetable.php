<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");

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

if($_REQUEST['branch']== 0 || $_REQUEST['batch'] == -1)
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

<?php
// if(empty($_REQUEST['day']) && empty($_REQUEST['time']) && empty($_REQUEST['course']))
// {
// echo '<form action="add_timetable.php" method="post">';
// }
// else
// {
// 	$day_id=$_REQUEST['day'];
// 	$time_id=$_REQUEST['time'];
// 	$course_id=$_REQUEST['course'];
// 	echo '<form action="insert_timetable.php" id=timetable_form method="post">';
// }
// $days = array(
// 	' ',
//     'Monday',
//     'Tuesday',
//     'Wednesday',
//     'Thursday',
//     'Friday',
//     'Saturday',
//      'Sunday'
// );
// echo '
// <select name="day">
// <option value="0">select</option>';
// $i=1;
// 		while($i<=7)
// 		{
// 			if($i == $day_id)
// 			{
// 				echo "<option value=".$i." selected>".$days[$i]."</option>";
// 			}
// 			else
// 			{
// 				echo "<option value=".$i.">".$days[$i]."</option>";
// 			}
// 			$i=$i+1;
// 		}
	
// 	echo '</select>';
// $result_time=$timetimetable->getTimeTimetable();

// echo '
// <select name="time">
// <option value="0">select</option>';
// if($result_time!=null)
// {
// 	while($row=$result_time->fetch_assoc())
// 	{
// 		$result_timetype=$timetype->getTimeType($row['type']);
		
// 		if($result_timetype!=null)
// 		{
// 			while($row_type=$result_timetype->fetch_assoc())
// 			{
// 				if($row['id']==$time_id)
// 				{
// 					echo "<option value=".$row['id']." selected>".$row['from_time']."-".$row['to_time']."-".$row_type['name']."</option>";
// 				}
// 				else
// 				{
// 				echo "<option value=".$row['id'].">".$row['from_time']."-".$row['to_time']."-".$row_type['name']."</option>";
// 				}
// 			}
// 		}
// 	}
// }
// echo '</select>';

$course_obj=new Course($dbconnect->getInstance());
// $result_course=$course_obj->getCourse("no",0,"yes",$batch_id,0,null,$branch_id);

// echo '
// <select name="course">
// <option value="0">select</option>';

// if($result_course!=null)
// {
// 	while($row=$result_course->fetch_assoc())
// 	{
// 		if($row['id']==$course_id)
// 		{
// 			echo "<option value=".$row['id']." selected>".$row['name']."</option>";
// 		}
// 		else
// 		{
// 			echo "<option value=".$row['id'].">".$row['name']."</option>";
// 		}
// 	}
// }
// echo '</select>';
// echo '<input type=hidden name=branch value='.$branch_id.'>
// <input type=hidden name=batch value='.$batch_id.'>';

$user_obj=new User($dbconnect->getInstance());
$teacher_course=new TeacherCourse($dbconnect->getInstance());


// if(!empty($_REQUEST['course']))
// {
// 	$course_id=$_REQUEST['course'];
// 	$result_userid=$teacher_course->getTeacherCourse(0,$course_id,0);
// 	echo '<select name="user">
// 	<option value="0">select</option>';

// 	if($result_userid != null)
// 	{
// 		while($row_userId=$result_userid->fetch_assoc())
// 		{
// 			$userId=$row_userId['user_id'];
// 			$result_user=$user_obj->getUser($userId);
// 			if($result_user!=null)
// 			{
// 				while($row_user=$result_user->fetch_assoc())
// 				{

// 					echo "<option value=".$row_user['id'].">".$row_user['name']."</option>";
// 				}
// 			}
			
// 		}
// 	}
// }
// echo '</select>';
// echo '<input type=submit name=submit id=submit value=submit>';
?>
<script src="../../../Resources/jquery.min.js"></script>
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li class="active">Add TimeTable</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Add TimeTable</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post" id="TT_form">
                                <div class="form=group">
                                    <select name="day" id="day" class="form-control select2" style="width:100%;">
                                        <option value="-1" selected disabled>Select Day</option>
                                        <option value=1>Monday</option>
                                        <option value=2>Tuesday</option>
                                        <option value=3>Wednesday</option>
                                        <option value=4>Thursday</option>
                                        <option value=5>Friday</option>
                                        <option value=6>Saturday</option>
                                        <option value=7>Sunday</option>
                                    </select>
                                </div>
                                
                                <?php
                                $result_time=$timetimetable->getTimeTimetable();
                                ?>
                                <br>
                                <div class="form-group">
                                    <select name="time" class="form-control select2" style="width:100%;" id=time>
                                        <option value="-1" selected disabled>Select Time</option>
                                        <?php
                                        if($result_time!=null)
                                        {
                                            while($row=$result_time->fetch_assoc())
                                            {
                                                $result_timetype=$timetype->getTimeType($row['type']);
                                                if($result_timetype!=null)
                                                {
                                                    while($row_type=$result_timetype->fetch_assoc())
                                                    {
                                                        echo "<option value=".$row['id'].">".$row['from_time']."-".$row['to_time']."-".$row_type['name']."</option>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <?php                
                                $result_course=$course_obj->getCourse("no",0,"yes",$batch_id,0,null,$branch_id);
                                ?>
                                
                                <div class="form-group"> 
                                    <select name="course" id="course"  class="form-control select2" style="width:100%">
                                        <option value="-1" selected disabled>Select Course</option>
                                        <?php
                                        if($result_course!=null)
                                        {
                                            while($row=$result_course->fetch_assoc())
                                            {
                                                echo "<option value=".$row['courseId'].">".$row['courseName']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <?php
                                echo '<input type=hidden name=branch id=branch value='.$branch_id.'>
                                <input type=hidden name=batch id=batch value='.$batch_id.'>';
                                ?>
                                
                                <button type="submit" id="submit_form" class="btn btn-success" name="submit"><span class="fa fa-check"></span>Submit</button>
                            </form>
                            <br>
                            <div id="teacher_div"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                             <h4>TimeTable:</h4>
                            <div class="table-container1">
                                <table class="table" style="border-collapse:separate;border-spacing: 5px 5px;color:white">
                                    <thead>
                                        <tr style='background:#F19b24'>
                                            <th>Timing</th>
                                            <th>Monday</th>
                                            <th>Tuesday</th>
                                            <th>Wednesday</th>
                                            <th>Thursday</th>
                                            <th>Friday</th>
                                            <th>Saturday</th>
                                            <th>Sunday</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $getTiming=$timetimetable->getTimeTimetable();
                                        if($getTiming!=null)
                                        {
                                            while($row=$getTiming->fetch_assoc())
                                            {
                                                $time_id=$row['id'];
                                                $from_time=$row['from_time'];
                                                $to_time=$row['to_time'];
                                                echo "<tr>";//for lecture time
                                                echo "<th  style='background:#F19b24'>";
                                                echo $from_time." - ".$to_time;
                                                echo "</th>";
                                                for($day=1;$day<=7;$day++)//7 days of week loop
                                                {
                                                    $getLecture=$timetable->getTimetable(0,$batch_id,$day,$time_id);
                                                    if($getLecture!=null)
                                                    {
                                                        while($lectureRow=$getLecture->fetch_assoc())
                                                        {
                                                            $id=$lectureRow['id'];
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
                                                            echo "<td  style='background:#f2f2f2'>";
                                                            echo $course_name." (".$user_name.") ".$lectureRow['comment']; 
                                                            echo "</br><a href=delete_timetable.php?id=".$id."&batch=$batch_id&branch=$branch_id onclick='return confirmation()' class='btn btn-danger btn-sm'><span class='fa fa-trash'></span>Delete</a></td>";
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    include("../../../Resources/Dashboard/footer.php");
    ?>
    <script type="text/javascript">
	$(document).ready(function(){
		$("#TT_form").submit(function(event){
			event.preventDefault();
			var day=$("#day").val();
			var time=$("#time").val();
			var course=$("#course").val();
			var branch=$("#branch").val();
			var batch=$("#batch").val();

			if(day==-1 || time==-1 || course==-1)
			{
				$("#teacher_div").text("Please input all the fields!");
			}
			else
			{
				$.ajax({
					type: "POST",
					url: "getTeacher.php",
					data: "course_id="+course,
					datatype: "json",

					success:function(json)
					{
						var status=json.status;
						if (status=="success") 
						{
							var count=json.teacher.length;
							var teacher_dropdown = "<form action=insert_timetable.php method=post><input type=hidden name=day value="+day+"><input type=hidden name=time value="+time+"><input type=hidden name=course value="+course+"><input type=hidden name=branch value="+branch+"><input type=hidden name=batch value="+batch+"><div class='form-group'><select id='select2' name='user' class='form-control' style='width:100%;'><option value=-1 selected disabled>Select Teacher</option>"
							for(var i=0;i<count;i++)
							{
								teacher_dropdown = teacher_dropdown + "<option value="+json.teacher[i].id+">"+json.teacher[i].name+"</option>";
							}
							teacher_dropdown = teacher_dropdown + "</select></div><div class='form-group'><input type='text' name=comment placeholder='Comment' class='form-control'></div><button type='submit' class='btn btn-success' name='submit'><span class='fa fa-check'></span>Submit</button></form>";

							$("#teacher_div").html(teacher_dropdown);
                        }
                    }
                });
            }
        });
    });
    </script>
    
    </body>
     <script type="text/javascript">
    function confirmation() {
      return confirm("Are you sure you want to delete it ?")
    }
</script>
</html>
