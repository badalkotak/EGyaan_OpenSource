<!DOCTYPE html>
<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>View Course - Student | EGyaan</title>
</head>
<body>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="editDeleteCourse.php">&nbspEdit Course</a></li>
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
            echo "<thead><tr><th>Sr. no.</th><th>Course Name</th></tr></thead>";
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
</div>
<?php
include "../../../Resources/Dashboard/footer.php"
?>

</body>
</html>
