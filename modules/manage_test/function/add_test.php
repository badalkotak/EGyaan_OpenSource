<!DOCTYPE html>
<html>
<?php
    include("privilege.php");

if($add!=true)
{
    $message=Constants::NO_PRIVILEGE;
    echo "<script>alert('$message');window.location.href='../../login/functions/logout.php'</script>";
}

include("../../../Resources/Dashboard/header.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
require_once("../../manage_course/classes/Course.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
    
$teacher_id = $id;
if(isset($_REQUEST["message"]) && !empty(trim($_REQUEST["message"]))){
    echo '<script>alert("' . $_REQUEST["message"] . '");</script>';
}
$test = new Test($dbConnect->getInstance());
$course=new COurse($dbConnect->getInstance());
$result=$test->getBranch();
$getTeacherCourse=$course->getCourse("yes",$teacher_id,"no",0,0,null,0);
?>
<script src="../../../Resources/jquery.min.js"></script>
<script src="get_option.js"></script>
    
    
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
                    <li class="treeview active">
                        <a href="../../manage_test/function/manage_test.php">
                            <i class="fa fa-pencil-square-o"></i> <span>Tests</span>
                        </a>
                    </li>
                    <li class="treeview">
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
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="manage_test.php">List Of Test</a></li>
                <li class="active"><b>Add Test</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Test</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form id="test_input" action="?" method="post" enctype="multipart/form-data">
                                <?php
                                if($getTeacherCourse===false)
                                {
                                    $result=$course->getCourse("no",0,'no',0,0,null,0);
                                    if($result!=null) 
                                    {
                                ?>
                                <div class="form-group">
                                    <select title="Select course" class="form-control select2" id="course_id" name="course_id" required>
                                        <option value='0' selected disabled> Select a Course</option>
                                        <?php
                                        while ($row = $result->fetch_assoc()) 
                                        {
                                            echo "<option value='" . $row['courseId'] . "'>" . $row['branchName'] . " - " . $row['batchName'] . " - " . $row['courseName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                    }
                                    else
                                    {
                                        echo "No Course added yet!!!";
                                    }
                                ?>
                                
                            <?php
                                }
                                else
                                {
                            ?>
                            <div id="branch_list">
                                <?php
                                    if($result!=null)
                                    {
                                ?>
                                <div class="form-group">
                                    <select title="Select branch" class="form-control select2" id="branch_id" name="branch_id" required>
                                        <option value='0' selected disabled> Select a Branch </option>
                                        <?php

                                            while($row = $result->fetch_assoc()){
                                                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                    }
                                    else
                                    {
                                        echo "No Branches added yet!!!";
                                    }
                                ?>
                            </div>
                            <div id="batch_list"></div>
                            <div id="course_list"></div>
                            <?php
                                }
                            ?>
                            <div id="form_input"></div>
                            </form>
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

<script>
    var form = document.getElementById("form_input");
    var br = document.createElement("br");
    function changeAction() {
        form.removeChild(document.getElementById("test_button"));
        var button = document.createElement("button");
        if (document.getElementById("online").checked) {
            console.log("online");
            var visible_file_input = document.getElementById("test_file");
            if (typeof(visible_file_input) != 'undefined' && visible_file_input != null) {
                if (typeof(visible_file_input.nextElementSibling) != 'undefined' && visible_file_input.nextElementSibling != null) {
                    form.removeChild(visible_file_input.nextElementSibling);
                }
                form.removeChild(visible_file_input);
            }
            button.setAttribute('formaction', 'add_questions.php');
        } else {
            console.log("offline");
            button.setAttribute('formaction', 'add_offline_test.php');
            var file_input = document.createElement("input");
            file_input.setAttribute('type', 'file');
            file_input.setAttribute('id', 'test_file');
            file_input.setAttribute('name', 'test_file');
            form.appendChild(file_input);
            form.appendChild(br);
        }
        var span = document.createElement("span");
        span.setAttribute('class', 'fa fa-angle-right');
        button.setAttribute('formmethod', 'post');
        button.setAttribute('id', 'test_button');
        button.setAttribute('name', 'test_button');
        button.setAttribute('type', 'submit');
        button.setAttribute('class','btn btn-success');
        button.innerHTML = 'Next <span class="fa fa-angle-right"></span>';
        form.appendChild(button);
    }
</script>
</html>