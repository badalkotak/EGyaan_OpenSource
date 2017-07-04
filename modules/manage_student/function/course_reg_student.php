<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 11/6/17
 * Time: 1:27 PM
 */
include("../../../Resources/sessions.php");

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
            echo "<script>alert('Course for student " . Constants::STATUS_EXISTS . "');
            window.location.href='selectStudentForCourse.php';</script>";
        } else {
            $flag = false;
        }
    }
    if ($flag == true) {
        echo "<script>alert('" . Constants::STATUS_SUCCESS . "fully added');
        window.location.href='selectStudentForCourse.php';</script>";
    } else {
        echo "<script>alert('" . Constants::STATUS_FAILED . " to add');
        window.location.href='selectStudentForCourse.php';</script>";
    }
} else {
    echo "<script>alert('" . Constants::EMPTY_PARAMETERS . " found');
        window.location.href='selectStudentForCourse.php';</script>";
}