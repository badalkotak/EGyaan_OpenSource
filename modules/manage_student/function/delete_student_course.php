<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 20/6/17
 * Time: 6:18 PM
 */
include("../../../Resources/sessions.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/StudentCourseRegistration.php");


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


if (isset($_REQUEST['studentCourseRegistrationId']) && !empty(trim($_REQUEST['studentCourseRegistrationId']))) {
    $studentCourseRegistrationId = $_REQUEST['studentCourseRegistrationId'];

    $studentCourseReg = new StudentCourseRegistration($dbConnect->getInstance());

    $deleteData = $studentCourseReg->deleteStudentCourse($studentCourseRegistrationId);

    if ($deleteData === true) {
        jsonOutput(Constants::STATUS_SUCCESS, "Student Course " . Constants::STATUS_SUCCESS . "fully deleted");
    } else {
        jsonOutput(Constants::STATUS_SUCCESS, Constants::STATUS_FAILED . " to delete student course");
    }
} else {
    jsonOutput(Constants::STATUS_SUCCESS, Constants::EMPTY_PARAMETERS . " found");
}