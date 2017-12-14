<!DOCTYPE html>
<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>View Course - Student | EGyaan</title>
</head>
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
                        <a href="../../manage_branch/function/branch.php">
                            <i class="fa  fa-sitemap"></i> <span>Manage Branch</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_batch/function/batch.php">
                            <i class="fa fa-users"></i> <span>Manage Batch</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_course/function/course.php">
                            <i class="fa fa-book"></i> <span>Manage Course</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_user/functions/user.php">
                            <i class="fa fa-user"></i> <span>Manage Users</span>
                        </a>
                    </li>
                    <li class="treeview active">
                        <a href="../../manage_student/function/student.php">
                            <i class="fa fa-graduation-cap"></i> <span>Manage Students</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_role/functions/role.php">
                            <i class="fa fa-user"></i> <span>Manage Role</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_fees/function/manage_fees.php">
                            <i class="fa fa-file-text-o"></i> <span>Manage Fees</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_noticeboard/function/index.php">
                            <i class="fa fa-calendar-minus-o"></i> <span>Noticeboard</span>
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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="student.php">Add Student</a></li>
                <li><a href="courseRegistrationStudent.php">Course Registration</a></li>
                <li><a href="courseRegistrationStudent.php">Select Course</a></li>
                <li><a href="editDeleteCourse.php">Edit Course</a></li>
                <li class="active"><b>Course Details</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Student Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <?php
                            /**
                             * Created by PhpStorm.
                             * User: fireion
                             * Date: 20/6/17
                             * Time: 3:21 PM
                             */

                            require_once("../../../classes/Constants.php");
                            require_once("../../../classes/DBConnect.php");
                            require_once("../classes/Student.php");
                            require_once("../classes/StudentCourseRegistration.php");

                            $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                Constants::DB_USERNAME,
                                Constants::DB_PASSWORD,
                                Constants::DB_NAME);

                            if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {
                                $studentId = $_REQUEST['studentId'];

                                $student = new Student($dbConnect->getInstance());
                                $studentCourseRegistration = new StudentCourseRegistration($dbConnect->getInstance());

                                $getStudentData = $student->getStudent($studentId, 0);
                                if ($getStudentData != null) {
                                    while ($array = $getStudentData->fetch_assoc()) {
                                        $firstName = $array['firstname'];
                                        $lastName = $array['lastname'];
                                    }
                                    echo "List of Courses enrolled for <b>" . $firstName . " " . $lastName . "</b><br>";

                                    $getData = $studentCourseRegistration->getStudentCourse($studentId);
                                    if ($getData != null) {
                                        $i = 1;
                                        echo "<br><table class='table table-bordered table-hover example2'>";
                                        echo "<thead><tr><th>Sr No.</th><th>Course Name</th></tr></thead>";
                                        while ($row = $getData->fetch_assoc()) {
                                            $studentCourseRegistrationId = $row['courseRegId'];
                                            $studentCourseRegistrationCourseId = $row['courseRegCourseId'];
                                            $courseName = $row['courseName'];
                                            echo "<tbody><tr><td>" . $i . "</td><td>" . $courseName . "</td></tr>";
                                            $i++;
                                        }
                                        echo "</tbody></table>";
                                    } else {
                                        echo "No Courses Enrolled";
                                    }
                                } else {
                                    echo Constants::STATUS_FAILED;
                                }
                            } else {
                                echo Constants::EMPTY_PARAMETERS;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
include "../../../Resources/Dashboard/footer.php"
?>

</body>
</html>
