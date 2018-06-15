<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
$user_id=$id;
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Timetable.php");
require_once("../../manage_branch/classes/Branch.php");
require_once("../../manage_batch/classes/Batch.php");
require_once("../../manage_course/classes/Course.php");
// require_once("../../manage_teacher_course/classes/TeacherCourse.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$branch=new Branch($dbconnect->getInstance());
$batch=new Batch($dbconnect->getInstance());
$course=new Course($dbconnect->getInstance());
$result_branch=$course->getCourse("yes",$user_id,"no",0,0,null,0);
if($result_branch!=null)
{
    while($row_branch=$result_branch->fetch_assoc())
    {
        $branch_id=$row_branch['batchBranchId'];
    }
}

if($role_id==Constants::ROLE_STUDENT_ID || $role_id==Constants::ROLE_PARENT_ID)
{
    // header('Location: view_timetable_student_parent.php');
    $msg = Constants::NO_PRIVILEGE;
    echo "<script>alert('$msg');window.location.href='../../login/functions/logout.php';</script>";
}
?>
<script src="../../../Resources/jquery.min.js"></script>
    
    
    <!--START OF SIDEBAR===========================================================================================================-->
    <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <?
                        if($profile!=null)
                            		{
                            			echo "<img src='../../manage_student/images/student/$profile' class=img-circle alt='User Image'>";
                            		}
                           			else
                            		{
                            			echo "<img src='../../../Resources/images/boy.png' class=img-circle alt='User Image'>";
                            		}
                        ?>
                    </div>
                    <div class="pull-left info">
                    <?
                    echo "<p>$display_name</p>";
                    ?>
                        <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
                    </div>
                </div>
                        <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview">
                        <a href="../../login/functions/Dashboard.php">
                            <i class="fa fa-home"></i> <span>Home</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_notes/function/insert_page.php">
                            <i class="fa fa-book"></i> <span>Notes</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="">
                            <i class="fa fa-send-o"></i> <span>Submissions</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_test/function/manage_test.php">
                            <i class="fa fa-pencil-square-o"></i> <span>Tests</span>
                        </a>
                    </li>
                    <li class="treeview active">
                        <a href="../../manage_timetable/function/view_teacher_timetable.php">
                            <i class="fa fa-calendar"></i> <span>Timetable</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_syllabus/function/insert_page.php">
                            <i class="fa fa-book"></i> <span>Syllabus</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_attendance/functions/attendanceMarking.php">
                            <i class="fa fa-bar-chart"></i> <span>Attendance</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../discussion_forum/functions/forum.php">
                            <i class="fa fa-wechat"></i> <span>Discussion Forum</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_noticeboard/index.php">
                            <i class="fa  fa-calendar-minus-o"></i> <span>Noticeboard</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-gears"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
    
<!--END OF SIDEBAR=============================================================================================================-->
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>Select Branch And Batch</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Select Branch And Batch</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            //if(empty($_REQUEST['branch']))
                            //{ 
                            ?>
                            <form  method="post" id="select_batch">
                                <div class="form-group">
                                    <select name="branch" id="branch" class="form-control select2" style="width: 100%;">
                                        <option value="-1" selected disabled>Select Branch</option>
                                        <?php
                                        $result_branch=$branch->getBranch($branch_id);
                                        if($result_branch!=null)
                                        {
                                        while($row=$result_branch->fetch_assoc())
                                        {
                                            echo "<option value=".$row['id'].">".$row['name']."</option>";
                                        }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                            <div id="batch_div">
                            </div>
                            <?php
                            /*}
                            else
                            {
                                echo '<form action="add_timetable.php" method="post">
                            <select name="branch">
                            <option value="0">select</option>';
                                $branch_id=$_REQUEST['branch'];
                                $result_branch=$branch->getBranch(0);
                                if($result_branch!=null)
                                {
                                    while($row=$result_branch->fetch_assoc())
                                    {
                                        if($row['id']==$branch_id)
                                        {
                                            echo "<option value=".$row['id']." selected>".$row['name']."</option>";
                                        }
                                        else
                                        {
                                            echo "<option value=".$row['id'].">".$row['name']."</option>";
                                        }
                                    }
                                    echo '</select>';
                                }
                                $result_batch=$batch->getBatch("yes",$branch_id,0,"yes",0);
                                echo '<select name="batch">
                            <option value="0">select</option>';
                                if($result_batch!=null)
                                {
                                    while($row=$result_batch->fetch_assoc())
                                    {
                                        echo "<option value=".$row['id'].">".$row['name']."</option>";
                                    }
                                }
                                echo '</select><input type=submit name=submit value=submit></form>';
                            }
                            */
                            ?>

                        </div>
                    </div>
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
    </body>
<script type="text/javascript">
                                $(document).ready(function(){
                                    $("#select_batch").change(function(){
                                        event.preventDefault();
                                        var branch=$("#branch").val();

                                        if(branch==-1)
                                        {
                                            $("#batch_div").text("Please input all the fields!");
                                        }
                                        else
                                        {
                                            $.ajax({
                                                type: "POST",
                                                url: "get_batch.php",
                                                data: "branch_id="+branch,
                                                datatype: "json",

                                                success:function(json)
                                                {
                                                    var status=json.status;
                                                    if (status=="success") 
                                                    {
                                                        var count=json.batch.length;

                                                        var batch_dropdown = "<form action=view_timetable_teacher_login.php method=post><input type=hidden name=branch value="+branch+"><div class='form-group'><select name=batch  class='form-control select2' style='width: 100%;'><option value=-1 selected=selected>Select batch</option>"
                                                        for(var i=0;i<count;i++)
                                                        {
                                                            batch_dropdown = batch_dropdown + "<option value="+json.batch[i].id+">"+json.batch[i].name+"</option>";
                                                        }
                                                        batch_dropdown = batch_dropdown + "</select></div><button type='submit' class='btn btn-success' name='submit'><span class='fa fa-check'></span>Submit</button></form>";

                                                        $("#batch_div").html(batch_dropdown);
                                                        $(".select2").select2();  
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });
                            </script>

</html>
