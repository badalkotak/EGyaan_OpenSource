<!DOCTYPE html>
<html>
<?php
include("privilege.php");
include("../../../Resources/Dashboard/header.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$teacher_id = $id;
if(isset($_REQUEST["message"]) && !empty(trim($_REQUEST["message"]))){
    echo '<script>alert("' . $_REQUEST["message"] . '");</script>';
}
$test = new Test($dbConnect->getInstance());
$result=$test->getTestsByTeacher($teacher_id);

echo "Role:".$role_id = $_SESSION['role'];

    if($role_id==Constants::ROLE_STUDENT_ID)
{
        // echo "Inn";
    $msg = Constants::NO_PRIVILEGE;
    echo "<script>alert('$msg');window.location.href='../../login/functions/logout.php';</script>";   
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
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>List Of Test</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List Of Test:</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-container1">
                                <?php
                                if($result!=null)
                                {
                                    ?>
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Title</th>
                                            <th>Marks</th>
                                            <th>Date of Test</th>
                                            <th>Date of Result</th>
                                            <th>Type</th>
                                            <th>Course name</th>
                                            <th>View Test</th>
                                            <?php
                                            if($delete===true)
                                                echo "<th>Delete</th>";
                                            if($result_add_id===true)
                                                echo "<th>Add Marks</th>";
                                            if($result_view_id===true)
                                                echo "<th>View Result</th>";
                                            ?>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $i=1;
                                            while($row=$result->fetch_assoc())
                                            {
                                                echo '  <tr id =' . $row["id"] . '>
                                                            <td>' . $i . '</td>
                                                            <td>' . $row["title"] . '</td>
                                                            <td>' . $row["total_marks"]  . '</td>
                                                            <td>' . $row["date_of_test"]  . '</td>
                                                            <td>' . $row["date_of_result"]  . '</td>
                                                            <td>' . (($row["type"] == 'O')?'Online':'Offline') . '</td>
                                                            <td>' . $row["name"]  . '</td>
                                                            <td><a class="btn btn-primary btn-sm" href="view_test.php?id=' . $row["id"] . '&type=' . $row["type"] . '"><span class="fa fa-table"></span> View</a></td>';
                                                            if($delete===true)
                                                            echo '<td><a class="btn btn-danger btn-sm" href="delete_test.php?id=' . $row["id"] . '"><span class="fa fa-trash"></span> Delete</a></td>';
                                                            if($result_add_id===true)
                                                            echo '<td>' . (($row["type"] == 'O')?'NA':(($row["status"] == 0)?'<a class="btn btn-primary btn-sm" href="add_marks_offline_test.php?id=' . $row["id"] . '&action=add"><span class="fa fa-plus"></span> Add</a>':'<a  class="btn btn-primary btn-sm" href="add_marks_offline_test.php?id=' . $row["id"] . '&action=edit"><span class="fa fa-pencil"></span> Edit</a>')) . '</td>';
                                                            if($result_view_id===true)
                                                            echo '<td><a class="btn btn-primary btn-sm" href="view_result.php?id=' . $row["id"] . '&type=' . $row["type"] . '&marks=' . $row["total_marks"] . '"><span class="fa fa-table"></span> View</a></td>';
                                                          echo '</tr>';
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                }
                                else
                                {
                                    echo "<label>No test added yet!!</label>";
                                }
                                ?>        
                            </div>
                            <?php
                            if($add===true)
                            echo "<a href=add_test.php class='btn btn-primary'><i class='fa fa-plus'></i>&nbsp;Add Test</a>";
                        ?>
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
