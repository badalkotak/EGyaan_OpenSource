<html>
<head>
    <title>Add Course - Student | EGyaan</title>
</head>
<body>

<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 20/6/17
 * Time: 4:20 PM
 */

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");
require_once("../classes/StudentCourseRegistration.php");
require_once("../../manage_course/classes/Course.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {
    $studentId = $_REQUEST['studentId'];

    $student = new Student($dbConnect->getInstance());
    $studentCourseRegistration = new StudentCourseRegistration($dbConnect->getInstance());
    $course = new Course($dbConnect->getInstance());

    $getStudentData = $student->getStudent($studentId, 0);
    if ($getStudentData != null) {
        while ($array = $getStudentData->fetch_assoc()) {
            $firstName = $array['firstname'];
            $lastName = $array['lastname'];
            $batchId = $array['batch_id'];
        }
        echo "List of Courses enrolled for <b>" . $firstName . " " . $lastName . "</b><br>";
//Student Enrolled Courses
        $getData = $studentCourseRegistration->getStudentCourse($studentId);
        if ($getData != null) {
            while ($row = $getData->fetch_assoc()) {
                $studentCourseRegistrationId[] = $row['courseRegId'];
                $studentCourseRegistrationCourseId[] = $row['courseRegCourseId'];
                $studentCourseRegCourseName[] = $row['courseName'];
            }
            $e = 1;
            echo "<table border='3'>";
            echo "<tr><th>Sr. no.</th><th>Course Name</th></tr>";
            for ($k = 0; $k < count($studentCourseRegistrationId); $k++) {
                echo "<tr><td>" . $e . "</td><td>" . $studentCourseRegCourseName[$k] . "</td></tr>";
                $e++;
            }
            echo "</table>";
        } else {
            echo "No Courses Enrolled";
        }

//Student Not Enrolled Courses
        $getCourseData = $course->getCourse('no', 0, 'yes', $batchId, 0, null, 0);
        if ($getCourseData != null) {
            while ($row1 = $getCourseData->fetch_assoc()) {
                $courseId[] = $row1['courseId'];
                $courseName[] = $row1['courseName'];
            }
            if (!empty($courseId) && !empty($studentCourseRegistrationCourseId)) {
                $newCourseIdArray = array_merge(array_diff($courseId, $studentCourseRegistrationCourseId));
                if (count($newCourseIdArray) > 0) {
                    echo "<br><br>List of Courses not enrolled by <b>" . $firstName . " " . $lastName . "</b>";
                    echo "<form action='course_reg_student.php' method='post'>";
                    echo "<table border='3'>";
                    echo "<tr><th>Sr. no.</th><th>Course Name</th><th>Apply</th></tr>";
                    $i = 1;
                    for ($j = 0; $j < count($newCourseIdArray); $j++) {
                        $newCourseData = $course->getCourse('no', 0, 'no', 0, $newCourseIdArray[$j], null, 0);
                        if ($newCourseData != null) {
                            while ($array1 = $newCourseData->fetch_assoc()) {
                                $newCourseId = $array1['id'];
                                $newCourseName = $array1['name'];
                                echo "<tr><td>" . $i . "</td><td>" . $newCourseName . "</td><td>
                <input type='checkbox' value='" . $newCourseId . "' name='courseCheck[]'></td></tr>";
                                $i++;
                            }
                        } else {
                            echo Constants::STATUS_FAILED;
                        }
                    }
                    echo "</table>";
                    echo "<br>";
                    echo "<input type='hidden' value='" . $studentId . "' name='studentId'>";
                    echo "<input type='submit' value='Add'>";
                    echo "</form>";
                } else {
                    echo "<br><br>All Courses enrolled";
                }
            } else {
                $getCourseData = $course->getCourse('no', 0, 'yes', $batchId, 0, null, 0);
                if ($getCourseData != null) {
                    $z = 1;
                    echo "<br><br>List of Courses not enrolled by <b>" . $firstName . " " . $lastName . "</b>";
                    echo "<form action='course_reg_student.php' method='post'>";
                    echo "<table border='3'>";
                    echo "<tr><th>Sr. no.</th><th>Course Name</th><th>Apply</th></tr>";
                    while ($row1 = $getCourseData->fetch_assoc()) {
                        $courseId = $row1['courseId'];
                        $courseName = $row1['courseName'];
                        echo "<tr><td>" . $z . "</td><td>" . $courseName . "</td><td>
                <input type='checkbox' value='" . $courseId . "' name='courseCheck[]'></td></tr>";
                        $z++;
                    }
                    echo "</table>";
                    echo "<br>";
                    echo "<input type='hidden' value='" . $studentId . "' name='studentId'>";
                    echo "<input type='submit' value='Add'>";
                    echo "</form>";
                } else {
                    echo "<br><br>All Courses enrolled";
                }
            }
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