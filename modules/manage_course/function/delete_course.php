<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 5/6/17
 * Time: 5:01 PM
 */
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Course.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

function jsonOutput($status, $message)
{
    $json = array();
    $json["statusMsg"] = $status;
    $json["Msg"] = $message;

    echo json_encode($json);
}

if (isset($_REQUEST['courseId']) && !empty(trim($_REQUEST['courseId']))) {
    $courseId = $_REQUEST['courseId'];

    $course = new Course($dbConnect->getInstance());

    $deleteData = $course->deleteCourse($courseId);

    if ($deleteData == true) {
        jsonOutput(Constants::STATUS_SUCCESS, "Course " . Constants::STATUS_SUCCESS . "fully deleted");
    } else {
        jsonOutput(Constants::STATUS_FAILED, Constants::STATUS_FAILED . " to delete course");
    }
} else {
    jsonOutput(Constants::EMPTY_PARAMETERS, Constants::EMPTY_PARAMETERS . " found");
}