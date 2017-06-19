<html>
<head>
    <title>Course Registration - Add Course for Student|EGyaan</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 10/6/17
 * Time: 9:11 PM
 */

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");
require_once("../../manage_course/classes/Course.php");
require_once("../classes/StudentCourseRegistration.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

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

        $getCourseData = $course->getCourse('no', 0, 'yes', $batchId, 0, null);
//        var_dump($getCourseData);
        if ($getCourseData != false) {
            $id = 1;
            echo "<form action='course_reg_student.php' method='post'>";
            echo "<table border='3'>";
            echo "<tr><th>Sr. no.</th><th>Branch Name</th><th>Batch Name</th><th>Course Name</th><th>Apply</th></tr>";
            while ($array = $getCourseData->fetch_assoc()) {
                $branchName = $array['branchName'];
                $batchName = $array['batchName'];
                $courseId = $array['courseId'];
                $courseName = $array['courseName'];

                echo "<tr><td>" . $id . "</td><td>" . $branchName . "</td><td>" . $batchName . "</td>
                <td>" . $courseName . "</td><td><input type='checkbox' value='" . $courseId . "' name='courseCheck[]'>
                </td></tr>";
                echo "<input type='hidden' name='studentId' value='" . $studentId . "'>";
                $id++;
            }
            echo "</table>";
            echo "<br><input type='submit' value='Enroll Courses'>";
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

</body>
</html>