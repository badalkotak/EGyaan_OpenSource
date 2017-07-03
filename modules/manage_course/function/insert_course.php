<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 5/6/17
 * Time: 4:54 PM
 */
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Course.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['courseName']) && isset($_REQUEST['batch_id']) && !empty(trim($_REQUEST['courseName']))
    && !empty(trim($_REQUEST['batch_id']))
) {
    $batchId = $_REQUEST['batch_id'];
    $courseName = $_REQUEST['courseName'];

    $course = new Course($dbConnect->getInstance());

    $insertData = $course->insertCourse($courseName, $batchId);

    if ($insertData == 'true') {
        echo "<script>alert('Course " . Constants::STATUS_SUCCESS . "fully inserted');
        window.location.href='course.php';</script>";
//        header('Location:course.php');
    } elseif ($insertData == Constants::STATUS_EXISTS) {
        echo "<script>alert('Course Name " . Constants::STATUS_EXISTS . "');
        window.location.href='course.php';</script>";
    } else {
        echo "<script>alert('" . Constants::STATUS_FAILED . " to insert course');
        window.location.href='course.php';</script>";
    }
} else {
    echo "<script>alert('" . Constants::EMPTY_PARAMETERS . "');
    window.location.href='course.php';</script>";
}