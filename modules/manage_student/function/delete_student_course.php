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

if (isset($_REQUEST['studentCourseRegistrationId']) && !empty(trim($_REQUEST['studentCourseRegistrationId']))) {
    $studentCourseRegistrationId = $_REQUEST['studentCourseRegistrationId'];

    $studentCourseReg = new StudentCourseRegistration($dbConnect->getInstance());

    $deleteData = $studentCourseReg->deleteStudentCourse($studentCourseRegistrationId);

    if ($deleteData === true) {
        echo "Student Course " . Constants::STATUS_SUCCESS . "fully deleted";
//        header('Location:student.php');
    } else {
        echo Constants::STATUS_FAILED . " to delete student course";
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}
