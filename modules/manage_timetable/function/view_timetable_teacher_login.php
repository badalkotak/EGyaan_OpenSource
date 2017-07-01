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
$user_obj=new User($dbconnect->getInstance());
$teacher_course=new TeacherCourse($dbconnect->getInstance());
$course_obj=new Course($dbconnect->getInstance());
if($_REQUEST['branch']== 0 || $_REQUEST['batch'] == -1)
{
    $msg=Constants::EMPTY_PARAMETERS;
    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('$msg')
        window.location.href='view_teacher_timetable.php';
        </SCRIPT>");
}
else
{
    $branch_id=$_REQUEST['branch'];
    $batch_id=$_REQUEST['batch'];
}
if($_REQUEST['branch']== 0 || $_REQUEST['batch'] == -1)
{
    $msg=Constants::EMPTY_PARAMETERS;
    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('$msg')
        window.location.href='view_teacher_timetable.php';
        </SCRIPT>");
}
else
{
    $branch_id=$_REQUEST['branch'];
    $batch_id=$_REQUEST['batch'];
}
?>
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>Timetable</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Timetable</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-container1">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
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
                                                echo "<th>";
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
                                                            echo "<td>";
                                                            echo $course_name." (".$user_name.") ".$lectureRow['comment']; 
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
                        <!-- /.box-body -->
                    </div>
                    <!--end of Table box-->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php
    include("../../../Resources/Dashboard/footer.php");
?>
    </body>
</html>
