<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$teacher_id = $id;
$test = new Test($dbConnect->getInstance());
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
                <li><a href="manage_test.php">List of Test</a></li>
                <li class="active"><b>Result</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Result:</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-container1">
                                <?php
                                if(isset($_REQUEST["id"]) && isset($_REQUEST["type"]) && isset($_REQUEST["marks"])){
                                    if($test->checkMarksEntered($_REQUEST["id"],"edit")) {
                                        $result = $test->getStudentList($_REQUEST["id"], $teacher_id,$_REQUEST["type"]);
                                        if ($result != null) {
                                            ?>
                                            <table id="example2" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Present</th>
                                                    <th>Marks</th>
                                                    <? echo ($_REQUEST["type"] == "O")?'<th>View</th>':''; ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                while ($row = $result->fetch_assoc()) {
                                                    $answer_page = '<td><a class="btn btn-primary btn-sm" href="view_answer_by_teacher.php?student_id=' . $row["id"] . '&test_id=' . $_REQUEST["id"] . '&marks='. $_REQUEST["marks"] . '"><span class="fa fa-eye"></span> View</a></td>';
                                                    echo '<tr>
                                                    <td>' . $row["firstname"] . ' ' . $row["lastname"] . '</td>
                                                    <td>' . (($row["marks"] != -1)? 'Yes' : 'No') . '</td>
                                                    <td>' . (($row["marks"] != -1)?$row["marks"] : '0') . ' out of  ' . $row["total_marks"] . '</td>'
                                                    . (($_REQUEST["type"] == "O")?($answer_page):('')) .
                                                  '</tr>';
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <?
                                        } else {
                                            echo $test->parentPageRedirect("Error processing request");
                                        }
                                    }else{
                                        echo $test->parentPageRedirect("Marks not entered/Error processing request");
                                    }
                                }else{
                                    echo $test->parentPageRedirect("Error processing request");
                                }
                                ?>
                                
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
