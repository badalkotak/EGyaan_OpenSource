<!DOCTYPE html>
<html>
<body>
<?php
ob_start();
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
                <li><a href="manage_test.php">List Of Test</a></li>
                <li class="active"><b>View Test</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Test:</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-8 col-md-offset-2">
                                <?php
                                if(isset($_REQUEST["id"]) && isset($_REQUEST["type"])){
                                    if($_REQUEST["type"] == 'F'){
                                        if(file_exists("offline_test/" . $_REQUEST["id"] . ".pdf")){
                                            ob_clean();
                                            header("Location: offline_test/" . $_REQUEST["id"] . ".pdf");
                                        }else{
                                            ob_clean();
                                            echo $test->parentPageRedirect("Error processing request");
                                        }
                                    }elseif($_REQUEST["type"] == 'O'){
                                        $result = $test->getTestQuestions($_REQUEST["id"]);
                                        if($result != null){
                                            $total_marks = 0 ;
                                            $i = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<div class="row">'.
                                                            '<div class="col-md-1">'.
                                                                '<h4>Q' . $i . ') </h4>' .
                                                            '</div>'.
                                                            '<div class="col-md-11 text-justify">'.
                                                                '<h4>'. $row["question"] .'</h4>'.
                                                            '</div>' .
                                                        '</div>' .
                                                        '<div class="row">'.
                                                            '<div class="col-md-12">'.
                                                                '<h4>Marks : ' . $row["marks"] . '</h4>'.
                                                            '</div>'.
                                                        '</div>';
                                                echo '<div class="row">'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 1)?('"fa fa-check" style="color:green;font-weight:bold">'):('"">')) . '1) ' . $row["option1"] . '</span>' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 2)?('"fa fa-check" style="color:green;font-weight:bold">'):('"">')) . '2) ' . $row["option2"] . '</span>' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 3)?('"fa fa-check" style="color:green;font-weight:bold">'):('"">')) . '3) ' . $row["option3"] . '</span>' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 4)?('"fa fa-check" style="color:green;font-weight:bold">'):('"">')) . '4) ' . $row["option4"] . '</span>'.
                                                        '</div>'.
                                                    '</div><hr>';
                                                
                                                    
                                                $i++;
                                                $total_marks += $row["marks"];
                                            }
                                            echo '<div class="row">'.
                                                    '<div class="col-md-12">'.
                                                        '<h4>Total marks : ' . $total_marks.'</h4>'.
                                                    '</div>'.
                                                '</div>';
                                        }else{
                                            ob_clean();
                                            echo $test->parentPageRedirect("Error processing request");
                                        }
                                    }else{
                                        ob_clean();
                                        echo $test->parentPageRedirect("Error processing request");
                                    }
                                }else{
                                    ob_clean();
                                    echo $test->parentPageRedirect("Error processing request");
                                }
                                ?>
                            </div>
                        </div>
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
