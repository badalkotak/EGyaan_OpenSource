<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 11/6/17
 * Time: 1:27 PM
 */

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/StudentCourseRegistration.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['courseCheck']) && isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))
) {
    $studentId = $_REQUEST['studentId'];
    $courseId = $_REQUEST['courseCheck'];

//    var_dump($courseId);

    $studentCourseRegistration = new StudentCourseRegistration($dbConnect->getInstance());

    $flag = false;
    foreach ($courseId as $id) {
        $insertData = $studentCourseRegistration->insertStudentCourse($studentId, $id);
        if ($insertData == true) {
            $flag = true;
        } elseif ($insertData == Constants::STATUS_EXISTS) {
            echo "Course for student " . Constants::STATUS_EXISTS;
        } else {
            $flag = false;
        }
    }
    if ($flag == true) {
        echo Constants::STATUS_SUCCESS;
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}