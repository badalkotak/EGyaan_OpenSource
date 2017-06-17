<html>
<head>
    <title>Edit Student Information | EGyaan</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 12/6/17
 * Time: 3:38 PM
 */

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

echo $_REQUEST['studentId'];

if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {

    $studentId = $_REQUEST['studentId'];
//    var_dump($studentId);

    $student = new Student($dbConnect->getInstance());

    $getData = $student->getStudent($studentId);

    if ($getData != false) {
        while ($row = $getData->fetch_assoc()) {
//            $id = $row['id'];
            $firstName = $row['firstname'];
            $lastName = $row['lastname'];
            $email = $row['email'];
            $studentPassword = $row['student_passwd'];
            $mobile = $row['mobile'];
            $gender = $row['gender'];
            $parentName = $row['parent_name'];
            $parentEmail = $row['parent_email'];
            $parentPassword = $row['parent_passwd'];
            $totalFees = $row['total_fees'];
            $feesPaid = $row['fees_paid'];
            $feesComment = $row['fees_comment'];
            $dateOfAdmission = $row['date_of_admission'];
            $parentMobile = $row['parent_mobile'];
//            $studentProfilePhoto = $row['student_profile_photo'];
//            $parentProfilePhoto = $row['parent_profile_photo'];
            $batchId = $row['batch_id'];
        }

        echo "<form  action='edit_student.php' method='post'>";
        echo "<input type='hidden' name='studentId' value='" . $studentId . "'>";
        echo "<input type='text' name='firstName' value='" . $firstName . "'><br>";
        echo "<input type='text' name='lastName' value='" . $lastName . "'><br>";
        echo "<input type='email' name='emailId' value='" . $email . "'><br>";
        echo "<input type='text' name='studentPassword' value='" . $studentPassword . "'><br>";
        echo "<input type='number' name='mobile' value='" . $mobile . "'><br>";
        echo "<select name='gender'>";
        echo "<option value='-1'>Select Gender</option>";
        if ($gender == 'M') {
            echo "<option value='Male' selected>Male</option>";
            echo "<option value='Female'>Female</option>";
            echo "<option value='TransGender'>TransGender</option>";
        } elseif ($gender == 'F') {
            echo "<option value='Male'>Male</option>";
            echo "<option value='Female' selected>Female</option>";
            echo "<option value='TransGender'>TransGender</option>";
        } else {
            echo "<option value='Male'>Male</option>";
            echo "<option value='Female'>Female</option>";
            echo "<option value='TransGender' selected>TransGender</option>";
        }
        echo "</select>";
        echo "<br>";
        echo "<input type='text' name='parentName' value='" . $parentName . "'><br>";
        echo "<input type='email' name='parentEmail' value='" . $parentEmail . "'><br>";
        echo "<input type='text' name='parentPassword' value='" . $parentPassword . "'><br>";
        echo "<input type='number' name='totalFees' value='" . $totalFees . "'><br>";
        echo "<input type='number' name='feesPaid' value='" . $feesPaid . "'><br>";
        echo "<textarea name='feesComment'>" . $feesComment . "</textarea><br>";
        echo "<input type='date' name='dateOfAdmission' value='" . $dateOfAdmission . "'><br>";
        echo "<input type='number' name='parentMobile' value='" . $parentMobile . "'><br>";
        echo $batchId . "<br>";
        echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}
?>
</body>
</html>