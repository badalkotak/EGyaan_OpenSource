<!DOCTYPE html>
<html>
<?php
include("../../../Resources/Dashboard/header.php");
require_once "../../../classes/DBConnect.php";
require_once "../../../classes/Constants.php";
$dbconnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$connection = $dbconnect->getInstance();
session_start();
$_SESSION["teacher_id"] = 3;
if (!isset($_SESSION["teacher_id"])) {
    //redirect
}
?>
<!--START OF SIDEBAR===========================================================================================================-->
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?
                if ($profile != null) {
                    echo "<img src='../../manage_student/images/student/$profile' class=img-circle alt='User Image'>";
                } else {
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
            <li class="treeview active">
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
        <h1>Hello!
            <small>User</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
            <li class="active"><b>Mark Attendance</b></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Mark Attendance</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6" id="message">
                        <p>
                            <?php
                            if (isset($_REQUEST["status"], $_REQUEST["message"])) {
                                echo $_REQUEST["message"];
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <form id="meta_info_form_courses" action="mark_attendance.php" method="get">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control select2" id="course_id" name="course_id">
                                    <option value="null">Select Course</option>
                                    <?php
                                    // $sql = "select distinct c.id, c.name from egn_courses as c, egn_load as l where c.id = l.course_id and l.teacher_id = " . $_SESSION["teacher_id"];
                                    $sql = "select distinct c.id, c.name, eb.name as branch from egn_batch as ebatch, egn_branch as eb, egn_course as c, egn_teacher_course as etc  where etc.user_id = " . $_SESSION["teacher_id"] . " and etc.course_id = c.id and c.batch_id = ebatch.id and ebatch.branch_id = eb.id";
                                    $result = $connection->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            if (isset($_REQUEST["course_id"])) {
                                                $selected = $_REQUEST["course_id"] == $row["id"] ? "selected" : "";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='" . $row["id"] . "' " . $selected . ">" . $row["branch"] . " - " . $row["name"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" value="Apply" id="courses_apply_button"
                                        name="submit"><span class="fa fa-check"></span>Apply
                                </button>

                            </div>
                        </div>
                    </form>
                </div>


                <form id="meta_info_form_timetable" action="mark_attendance.php" method="get">
                    <input type="hidden" name="course_id"
                           value="<?php echo isset($_REQUEST["course_id"]) ? $_REQUEST["course_id"] : "null" ?>"/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control select2" id="timetable_id" name="timetable_id">
                                    <option value="null">Select Timetable Slot</option>
                                    <?php
                                    $sql = "select t.id, t.day_id, ett.from_time, ett.to_time, t.comment from egn_time_timetable as ett, egn_timetable as t, egn_teacher_course as etc where etc.course_id = " . $_REQUEST["course_id"] . " and etc.user_id = " . $_SESSION["teacher_id"] . " and etc.id = t.teacher_course_id and ett.id = t.time_id";
                                    $result = $connection->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            if (isset($_REQUEST["timetable_id"])) {
                                                $selected = $_REQUEST["timetable_id"] == $row["id"] ? "selected" : "";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='" . $row["id"] . "' " . $selected . "> Day " . $row["day_id"] . " : " . $row["from_time"] . " - " . $row["to_time"] . " : (" . $row["comment"] . ")</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                    $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control date-picker2" type="date" name="date"
                                       value="<?php echo $date ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" value="Apply" id="meta_info_form_button"
                                        name="Apply"><span class="fa fa-check"></span>Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div id="content">
                        <?php if (isset($_REQUEST["course_id"], $_REQUEST["date"], $_REQUEST["timetable_id"])): ?>
                            <form id="attendance_marking_form" action="attendanceMarking.php" method="post">
                                <input type="hidden" name="timetable_id"
                                       value="<?php echo isset($_REQUEST["timetable_id"]) ? $_REQUEST["timetable_id"] : "null" ?>"/>
                                <input type="hidden" name="date"
                                       value="<?php echo isset($_REQUEST["date"]) ? $_REQUEST["date"] : "null" ?>"/>
                                <div class="col-md-12">
                                    <div class="table-container1">
                                        <table class="table table-bordered table-hover" id="attendance_list">
                                            <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Name</th>
                                                <th>Attendance</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql = "select distinct s.id, s.firstname, s.lastname from egn_student as s , egn_course_reg as ecr where s.id = ecr.student_id and ecr.course_id = " . $_REQUEST["course_id"];
                                            $result = $connection->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["firstname"] . " " . $row["lastname"] . "</td><td><input type='checkbox' name='attendees[]' id='attendees' value='" . $row['id'] . "'/></td></tr>";
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <button type="submit" value="Mark Attendance" id="attendance_marking_form_submit"
                                            class="btn btn-success"
                                            name="Apply"><span class="fa fa-check"></span>Mark Attendance
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
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
</body>
</html>
