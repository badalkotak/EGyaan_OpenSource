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
    && isset($_REQUEST['batchId']) && isset($_FILES['studentProfilePhoto']) && isset($_FILES['parentProfilePhoto'])
    && !empty(trim($_REQUEST['studentId'])) && !empty(trim($_REQUEST['firstName'])) && !empty(trim($_REQUEST['lastName']))
    && !empty(trim($_REQUEST['emailId'])) && !empty(trim($_REQUEST['mobile']))
    && !empty(trim($_REQUEST['gender'])) && !empty(trim($_REQUEST['parentName'])) && !empty(trim($_REQUEST['parentEmail'])) && !empty(trim($_REQUEST['totalFees'])) && !empty(trim($_REQUEST['feesPaid']))
    && !empty(trim($_REQUEST['feesComment'])) && !empty(trim($_REQUEST['dateOfAdmission'])) && !empty(trim($_REQUEST['parentMobile']))
    && !empty(trim($_REQUEST['batchId'])) && !empty($_FILES['studentProfilePhoto']) && !empty($_FILES['parentProfilePhoto'])
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

//    if ($gender == 'Male') {
//        $studentProfilePhoto = "EGyaan_OpenSource/Resources/images/boy.png";
//        $parentProfilePhoto = "EGyaan_OpenSource/Resources/images/boy.png";
//    } elseif ($gender == 'Female') {
//        $studentProfilePhoto = "EGyaan_OpenSource/Resources/images/girl.png";
//        $parentProfilePhoto = "EGyaan_OpenSource/Resources/images/girl.png";
//    } else {
//        $studentProfilePhoto = "EGyaan_OpenSource/Resources/images/no.png";
//        $parentProfilePhoto = "EGyaan_OpenSource/Resources/images/no.png";
//    }

    $student = new Student($dbConnect->getInstance());

    $getData = $student->getStudent($studentId, 0);
    if ($getData != null) {
        while (($row = $getData->fetch_assoc())) {
            $studentProfileName = $row['student_profile_photo'];
            $parentProfileName = $row['parent_profile_photo'];
        }
    } else {
        echo Constants::STATUS_FAILED."1";
    }


    //Start Upload Student Photo
    $studentImgFile = $_FILES['studentProfilePhoto']['name'];
    $tmp_student_dir = $_FILES['studentProfilePhoto']['tmp_name'];
    $img_student_size = $_FILES['studentProfilePhoto']['size'];

    if ($studentImgFile) {
        $upload_student_dir = "../images/student/"; // upload directory

        $imgStudentExt = strtolower(pathinfo($studentImgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_student_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        $studentProfilePhoto = rand(1000, 1000000) . "." . $imgStudentExt;

        // allow valid image file formats
        if (in_array($imgStudentExt, $valid_student_extensions)) {
            // Check file size '5MB'
            if ($img_student_size < 5000000) {
                unlink($upload_student_dir . $studentProfileName);
                move_uploaded_file($tmp_student_dir, $upload_student_dir . $studentProfilePhoto);
            } else {
                echo Constants::FILE_SIZE_LARGE;
            }
        } else {
            echo Constants::FILE_EXTENSION_WRONG;
        }

//    echo $studentImgFile . " " . $tmp_student_dir . " " . $img_student_size;
//    echo "<br>" . $upload_student_dir;
        //End Student upload Photo
    } else {
        $studentProfilePhoto = $studentProfileName;
    }


    //Start Upload Parent Photo
    $parentImgFile = $_FILES['parentProfilePhoto']['name'];
    $tmp_parent_dir = $_FILES['parentProfilePhoto']['tmp_name'];
    $img_parent_size = $_FILES['parentProfilePhoto']['size'];

    if ($parentImgFile) {
        $upload_parent_dir = "../images/parent/"; // upload directory

        $imgParentExt = strtolower(pathinfo($parentImgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_parent_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        $parentProfilePhoto = rand(1000, 1000000) . "." . $imgParentExt;

        // allow valid image file formats
        if (in_array($imgParentExt, $valid_parent_extensions)) {
            // Check file size '5MB'
            if ($img_parent_size < 5000000) {
                unlink($upload_parent_dir . $parentProfileName);
                move_uploaded_file($tmp_parent_dir, $upload_parent_dir . $parentProfilePhoto);
            } else {
                echo Constants::FILE_SIZE_LARGE;
            }
        } else {
            echo Constants::FILE_EXTENSION_WRONG;
        }
        //End Parent upload Photo
    } else {
        $parentProfilePhoto = $parentProfileName;
    }

    $insertData = $student->updateStudent($studentId, $firstName, $lastName, $emailId, $mobile, $gender,
        $parentName, $parentEmail, $totalFees, $feesPaid, $feesComment, $dateOfSubmission,
        $parentMobile, $studentProfilePhoto, $parentProfilePhoto, $batchId);

    if ($insertData == 'true') {
        echo Constants::STATUS_SUCCESS;
//        header('Location:student.php');
    } else {
        echo Constants::STATUS_FAILED."2";
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}