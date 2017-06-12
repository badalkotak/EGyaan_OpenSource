<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 5/6/17
 * Time: 4:54 PM
 */

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
        echo "Course " . Constants::STATUS_SUCCESS . "fully inserted";
//        header('Location:course.php');
    } elseif ($insertData == Constants::STATUS_EXISTS) {
        echo "Course Name " . Constants::STATUS_EXISTS;
    } else {
        echo Constants::STATUS_FAILED . " to insert course";
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}