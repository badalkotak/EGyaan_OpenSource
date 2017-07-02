<!DOCTYPE html>
<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Student Information - Detailed View | EGyaan</title>
</head>
<body>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="editDeleteStudent.php">&nbspEdit Student</a></li>
                <li class="active"><b>Student Details</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Student Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
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

                                $getData = $student->getStudent($studentId, 0);

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
                                        $parentProfilePhoto = $row['parent_profile_photo'];
                                        $batchId = $row['batch_id'];
                                    }

                                    //        var_dump($studentProfilePhoto);
                                    echo "<img src='../images/student/" . $studentProfilePhoto . "' width='75' height='75'><br>";
                                    echo "<label>Name:&nbsp</label>";
                                    echo $firstName . " " . $lastName . "<br>";
                                    echo "<label>Email:&nbsp</label>";
                                    echo $email . "<br>";
                                    echo "<label>Name:&nbsp</label>";
                                    echo $mobile . "<br>";
                                    echo "<label>Gender:&nbsp</label>";
                                    echo $gender . "<br>";
                                    echo '<hr>';
                                    echo "<h4>Parent Details</h4>";
                                    echo "<img src='../images/parent/" . $parentProfilePhoto . "' width='75' height='75'><br>";
                                    echo "<label>Name:&nbsp</label>";
                                    echo $parentName . "<br>";
                                    echo "<label>Email:&nbsp</label>";
                                    echo $parentEmail . "<br>";
                                    echo "<label>Total Fees:&nbsp</label>";
                                    echo $totalFees . "<br>";
                                    echo "<label>Fees Paid:&nbsp</label>";
                                    echo $feesPaid . "<br>";
                                    echo "<label>Fees Comment:&nbsp</label>";
                                    echo $feesComment . "<br>";
                                    echo "<label>Date Of Admission:&nbsp</label>";
                                    echo $dateOfAdmission . "<br>";
                                    echo "<label>Mobile No.:&nbsp</label>";
                                    echo $parentMobile . "<br>";

                                    $batch = new Batch($dbConnect->getInstance());

                                    $getBatchData = $batch->getBatch('no', 0, $batchId, 'no', 0);
                                    if ($getBatchData != null) {
                                        while ($row = $getBatchData->fetch_assoc()) {
                                            $batchName = $row['batchName'];
                                            echo $batchName . "<br>";
                                        }
                                    } else {
                                        echo Constants::STATUS_FAILED;
                                    }
                                } elseif ($getData == false) {
                                    echo Constants::STATUS_FAILED;
                                } else {
                                    echo "No Records Found!";
                                }
                            } else {
                                echo Constants::EMPTY_PARAMETERS;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
include "../../../Resources/Dashboard/footer.php";
?>
</body>
</html>