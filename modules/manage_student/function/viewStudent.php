<html>
<head>
    <title>Student Information - Detailed View | EGyaan</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 12/6/17
 * Time: 2:41 PM
 */

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Student.php");
require_once("../../manage_batch/classes/Batch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {

    $studentId = $_REQUEST['studentId'];
//    var_dump($studentId);

    $student = new Student($dbConnect->getInstance());

    $getData = $student->getStudent($studentId);

    if ($getData != false) {
        while ($row = $getData->fetch_assoc()) {
            $id = $row['id'];
            $firstName = $row['firstname'];
            $lastName = $row['lastname'];
            $email = $row['email'];
//            $studentPassword = $row['student_passwd'];
            $mobile = $row['mobile'];
            $gender = $row['gender'];
            $parentName = $row['parent_name'];
            $parentEmail = $row['parent_email'];
//            $parentPassword = $row['parent_passwd'];
            $totalFees = $row['total_fees'];
            $feesPaid = $row['fees_paid'];
            $feesComment = $row['fees_comment'];
            $dateOfAdmission = $row['date_of_admission'];
            $parentMobile = $row['parent_mobile'];
            $studentProfilePhoto = $row['student_profile_photo'];
//            $parentProfilePhoto = $row['parent_profile_photo'];
            $batchId = $row['batch_id'];
        }

        //        var_dump($studentProfilePhoto);
        echo "<img src='http://localhost/" . $studentProfilePhoto . "' width='75' height='75'><br>";
        echo $firstName . " " . $lastName . "<br>";
        echo $email . "<br>";
        echo $mobile . "<br>";
        echo $gender . "<br>";
        echo $parentName . "<br>";
        echo $parentEmail . "<br>";
        echo $totalFees . "<br>";
        echo $feesPaid . "<br>";
        echo $feesComment . "<br>";
        echo $dateOfAdmission . "<br>";
        echo $parentMobile . "<br>";

        $batch = new Batch($dbConnect->getInstance());

        $getBatchData = $batch->getBatch('no', 0, $batchId);
        if ($getBatchData != null) {
            while ($row = $getBatchData->fetch_assoc()) {
                $batchName = $row['name'];
                echo $batchName . "<br>";
            }
        } else {
            echo Constants::STATUS_FAILED;
        }
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}
?>
</body>
</html>