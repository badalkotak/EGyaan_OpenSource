<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 5/6/17
 * Time: 5:01 PM
 */
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Course.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['courseId']) && !empty(trim($_REQUEST['courseId']))) {
    $courseId = $_REQUEST['courseId'];

    $course = new Course($dbConnect->getInstance());

    $deleteData = $course->deleteCourse($courseId);

    if ($deleteData == true) {
        echo Constants::STATUS_SUCCESS;
        header('Location:course.php');
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}