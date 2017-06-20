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
            echo "<br><table border='3'>";
            echo "<tr><th>Sr. no.</th><th>Course Name</th></tr>";
            while ($row = $getData->fetch_assoc()) {
                $studentCourseRegistrationId = $row['id'];
                $studentCourseRegistrationCourseId = $row['course_id'];
                $courseName = $row['name'];
                echo "<tr><td>" . $i . "</td><td>" . $courseName . "</td></tr>";
                $i++;
            }
            echo "</table>";
        } else {
            echo Constants::STATUS_FAILED;
        }
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}