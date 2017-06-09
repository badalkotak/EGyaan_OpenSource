<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 5/6/17
 * Time: 5:05 PM
 */
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Course.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['courseId']) && isset($_REQUEST['courseName']) && isset($_REQUEST['batchId'])
    && !empty(trim($_REQUEST['courseId'])) && !empty(trim($_REQUEST['courseName']))
    && !empty(trim($_REQUEST['batchId']))
) {
    $courseId = $_REQUEST['courseId'];
    $courseName = $_REQUEST['courseName'];
    $batchId = $_REQUEST['batchId'];

    $course = new Course($dbConnect->getInstance());

    $updateData = $course->updateCourse($courseId, $courseName, $batchId);

    if ($updateData == true) {
        echo Constants::STATUS_SUCCESS;
        header('Location:course.php');
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}