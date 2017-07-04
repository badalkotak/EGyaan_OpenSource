<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 9/6/17
 * Time: 4:34 PM
 */
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");


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


if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {
    $studentId = $_REQUEST['studentId'];

    $student = new Student($dbConnect->getInstance());

    $getData = $student->getStudent($studentId, 0);
    if ($getData != null) {
        while (($row = $getData->fetch_assoc())) {
            $studentProfileName = $row['student_profile_photo'];
            $parentProfileName = $row['parent_profile_photo'];
        }
    } else {
        echo "<script>alert('" . Constants::STATUS_FAILED . " while fetching student details.');
        window.location.href='editDeleteStudent.php';</script>";
    }

    $deleteData = $student->deleteStudent($studentId);

    if ($deleteData === true) {

        unlink("../images/student/" . $studentProfileName);
        unlink("../images/parent/" . $parentProfileName);

        jsonOutput(Constants::STATUS_SUCCESS, "Student " . Constants::STATUS_SUCCESS . "fully deleted");
    } else {
        jsonOutput(Constants::STATUS_SUCCESS, Constants::STATUS_FAILED . " to delete student");
    }
} else {
    jsonOutput(Constants::STATUS_SUCCESS, Constants::EMPTY_PARAMETERS . " found");
}