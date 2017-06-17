<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 9/6/17
 * Time: 4:37 PM
 */

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['studentId']) && isset($_REQUEST['firstName']) && isset($_REQUEST['lastName']) && isset($_REQUEST['emailId']) 
    && isset($_REQUEST['mobile']) && isset($_REQUEST['gender']) && isset($_REQUEST['parentName']) && isset($_REQUEST['parentEmail']) && isset($_REQUEST['totalFees']) && isset($_REQUEST['feesPaid']) && isset($_REQUEST['feesComment'])
    && isset($_REQUEST['dateOfAdmission']) && isset($_REQUEST['parentMobile'])
    && isset($_REQUEST['batchId']) && !empty(trim($_REQUEST['studentId'])) && !empty(trim($_REQUEST['firstName'])) && !empty(trim($_REQUEST['lastName']))
    && !empty(trim($_REQUEST['emailId'])) && !empty(trim($_REQUEST['mobile']))
    && !empty(trim($_REQUEST['gender'])) && !empty(trim($_REQUEST['parentName'])) && !empty(trim($_REQUEST['parentEmail'])) && !empty(trim($_REQUEST['totalFees'])) && !empty(trim($_REQUEST['feesPaid']))
    && !empty(trim($_REQUEST['feesComment'])) && !empty(trim($_REQUEST['dateOfAdmission'])) && !empty(trim($_REQUEST['parentMobile']))
    && !empty(trim($_REQUEST['batchId']))
) {
    $studentId = $_REQUEST['studentId'];
    $firstName = $_REQUEST['firstName'];
    $lastName = $_REQUEST['lastName'];
    $emailId = $_REQUEST['emailId'];
    // $studentPassword = $_REQUEST['studentPassword'];
    $mobile = $_REQUEST['mobile'];
    $gender = $_REQUEST['gender'];
    $parentName = $_REQUEST['parentName'];
    $parentEmail = $_REQUEST['parentEmail'];
    // $parentPassword = $_REQUEST['parentPassword'];
    $totalFees = $_REQUEST['totalFees'];
    $feesPaid = $_REQUEST['feesPaid'];
    $feesComment = $_REQUEST['feesComment'];
    $dateOfSubmission = $_REQUEST['dateOfAdmission'];
    $parentMobile = $_REQUEST['parentMobile'];
    $batchId = $_REQUEST['batchId'];

    if ($gender == 'Male') {
        $studentProfilePhoto = "EGyaan_OpenSource/Resources/images/boy.png";
        $parentProfilePhoto = "EGyaan_OpenSource/Resources/images/boy.png";
    } elseif ($gender == 'Female') {
        $studentProfilePhoto = "EGyaan_OpenSource/Resources/images/girl.png";
        $parentProfilePhoto = "EGyaan_OpenSource/Resources/images/girl.png";
    } else {
        $studentProfilePhoto = "EGyaan_OpenSource/Resources/images/no.png";
        $parentProfilePhoto = "EGyaan_OpenSource/Resources/images/no.png";
    }

    $student = new Student($dbConnect->getInstance());

    $insertData = $student->updateStudent($studentId, $firstName, $lastName, $emailId, $mobile, $gender,
        $parentName, $parentEmail, $totalFees, $feesPaid, $feesComment, $dateOfSubmission,
        $parentMobile, $studentProfilePhoto, $parentProfilePhoto, $batchId);

    if ($insertData == 'true') {
        echo Constants::STATUS_SUCCESS;
//        header('Location:student.php');
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}