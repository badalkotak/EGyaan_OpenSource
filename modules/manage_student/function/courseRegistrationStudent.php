<html>
<head>
    <title>Course Registration - Add Course for Student | EGyaan</title>
</head> 
<body>
<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 10/6/17
 * Time: 9:11 PM
 */
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");
require_once("../../manage_course/classes/Course.php");
require_once("../classes/StudentCourseRegistration.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
    ?>
    
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="student.php">Add Student</a></li>
                <li class="active"><b>Course Registration</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Course Registration</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
    
                            <?php
                            if (isset($_REQUEST['batchId']) && isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['batchId']))
                                && !empty(trim($_REQUEST['studentId']))
                            ) {
                                $studentId = $_REQUEST['studentId'];
                                $batchId = $_REQUEST['batchId'];

                                $student = new Student($dbConnect->getInstance());
                                $course = new Course($dbConnect->getInstance());

                                $getStudentData = $student->getStudent(0, 0);

                                if ($getStudentData != false) {
                                    while ($row = $getStudentData->fetch_assoc()) {
                                        $firstName = $row['firstname'];
                                        $lastName = $row['lastname'];
                                    }
                                    echo "<h2>Course Registration for " . $firstName . " " . $lastName . "</h2>";

                                    $getCourseData = $course->getCourse('no', 0, 'yes', $batchId, 0, null, 0);
                            //        var_dump($getCourseData);
                                    if ($getCourseData != false) {
                                        $id = 1;
                                        echo "<form action='course_reg_student.php' method='post'>";
                                        echo "<div class='table-container1'>";
                                        echo "<table class='table table-bordered table-hover example2'>";
                                        echo "<thead><tr><th>Sr No</th><th>Branch Name</th><th>Batch Name</th><th>Course Name</th><th>Apply</th></tr></thead>";
                                        while ($array = $getCourseData->fetch_assoc()) {
                                            $branchName = $array['branchName'];
                                            $batchName = $array['batchName'];
                                            $courseId = $array['courseId'];
                                            $courseName = $array['courseName'];

                                            echo "<tbody><tr><td>" . $id . "</td><td>" . $branchName . "</td><td>" . $batchName . "</td>
                                            <td>" . $courseName . "</td><td><input type='checkbox' value='" . $courseId . "' name='courseCheck[]'>
                                            </td></tr></tbody>";
                                            echo "<input type='hidden' name='studentId' value='" . $studentId . "'>";
                                            $id++;
                                        }
                                        echo "</table></div>";
                                        echo "<button type='submit' class='btn btn-success'>Enroll Courses</button>";
                                        echo "</form>";
                                    } else {
                                        echo Constants::STATUS_FAILED;
                                    }
                                } else {
                                    echo Constants::STATUS_FAILED;
                                }
                            } else {
                                echo Constants::EMPTY_PARAMETERS;
                            }
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