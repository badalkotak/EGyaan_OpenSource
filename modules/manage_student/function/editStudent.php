<!DOCTYPE html>
<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Edit Student Information | EGyaan</title>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>
</head>
<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="editDeleteStudent.php">&nbsp;Edit Student</a></li>
                <li class="active"><b>Edit Student Details</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Edit Student Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
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
                            require_once("../../manage_batch/classes/Batch.php");
                            require_once("../../manage_branch/classes/Branch.php");

                            $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                Constants::DB_USERNAME,
                                Constants::DB_PASSWORD,
                                Constants::DB_NAME);

                            //echo $_REQUEST['studentId'];

                            if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {

                                $studentId = $_REQUEST['studentId'];
//    var_dump($studentId);

                                $student = new Student($dbConnect->getInstance());

                                $getData = $student->getStudent($studentId, 0);

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
                                        $studentProfilePhoto = $row['student_profile_photo'];
                                        $parentProfilePhoto = $row['parent_profile_photo'];
                                        $batchId = $row['batch_id'];
                                    }

                                    echo "<form role='form' action='edit_student.php' method='post' enctype='multipart/form-data'>";
                                    echo "<img src='../images/student/" . $studentProfilePhoto . "' width='75' height='75'><br><br>";
                                    echo "Choose Student Photo : <input type='file' class='form-control' name='studentProfilePhoto'>
    <label>Max Size of Image is 5MB.</label>
    <br>";
                                    echo "<input type='hidden' name='studentId' value='" . $studentId . "'>";
                                    echo "<label>Firstname:</label><br>";
                                    echo "<input type='text' class='form-control' name='firstName' value='" . $firstName . "'><br>";
                                    echo "<label>Lastname:</label><br>";
                                    echo "<input type='text' class='form-control' name='lastName' value='" . $lastName . "'><br>";
                                    echo "<label>Email:</label><br>";
                                    echo "<input type='email' class='form-control' name='emailId' value='" . $email . "'><br>";
                                    echo "<label>Password:</label><br>";
                                    echo "<input type='text' class='form-control' name='studentPassword' value='" . $studentPassword . "'><br>";
                                    echo "<label>Mobile No.:</label><br>";
                                    echo "<input type='number' class='form-control' name='mobile' value='" . $mobile . "'><br>";
                                    echo "<label>Gender:</label><br>";
                                    echo "<select name='gender' class='form-control'>";
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
                                    echo "<hr>";
                                    echo "<h4>Parent Details</h4>";
                                    echo "<img src='../images/parent/" . $parentProfilePhoto . "' width='75' height='75'><br><br>";
                                    echo "Choose Parent Photo : <input type='file' class='form-control' name='parentProfilePhoto'>
    <label>Max Size of Image is 5MB.</label>
    <br>";
                                    echo "<label>Firstname:</label><br>";
                                    echo "<input type='text' class='form-control' name='parentName' value='" . $parentName . "'><br>";
                                    echo "<label>Email:</label><br>";
                                    echo "<input type='email' class='form-control' name='parentEmail' value='" . $parentEmail . "'><br>";
                                    echo "<label>Password:</label><br>";
                                    echo "<input type='text' class='form-control' name='parentPassword' value='" . $parentPassword . "'><br>";
                                    echo "<label>Total Fees:</label><br>";
                                    echo "<input type='number' class='form-control' name='totalFees' value='" . $totalFees . "'><br>";
                                    echo "<label>Fees Paid:</label><br>";
                                    echo "<input type='number' class='form-control' name='feesPaid' value='" . $feesPaid . "'><br>";
                                    echo "<label>Fees Comment:</label><br>";
                                    echo "<textarea name='feesComment' class='form-control'>" . $feesComment . "</textarea><br>";
                                    echo "<label>Date Of Admission:</label><br>";
                                    echo "<input type='date' class='form-control' name='dateOfAdmission' value='" . $dateOfAdmission . "'><br>";
                                    echo "<label>Mobile No.:</label><br>";
                                    echo "<input type='number' class='form-control' name='parentMobile' value='" . $parentMobile . "'><br>";
//        echo $batchName . "<br>";
//        echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
                                    echo "<label>Branch:</label><br>";
                                    echo "<select name='branchId' id='branch-id' class='form-control'>";
                                    echo "<option value='-1'>Select Branch</option>";

                                    $batch = new Batch($dbConnect->getInstance());

                                    $getBatchData = $batch->getBatch('no', 0, $batchId, 'no', 0);
                                    if ($getBatchData != null) {
                                        while ($row = $getBatchData->fetch_assoc()) {
                                            $_branchId = $row['branchId'];
//                $_branchName = $row['branchName'];
                                            $_batchId = $row['batchId'];
//                $_batchName = $row['name'];
                                        }
                                        $branch = new Branch($dbConnect->getInstance());
                                        $getBranchData = $branch->getBranch(0);
                                        if ($getBranchData != null) {
                                            while ($array = $getBranchData->fetch_assoc()) {
                                                $__branchId = $array['id'];
                                                $__branchName = $array['name'];

                                                if ($_branchId == $__branchId) {
                                                    echo "<option value='" . $__branchId . "' selected>" . $__branchName . "</option>";
                                                } else {
                                                    echo "<option value='" . $__branchId . "'>" . $__branchName . "</option>";
                                                }
                                            }
                                        } else {
                                            echo Constants::STATUS_FAILED;
                                        }
                                    } else {
                                        echo Constants::STATUS_FAILED;
                                    }

                                    echo "</select>";
                                    echo "<br>";

                                    echo "<div id='new-drop-down' class='hide'>";
                                    echo "<label>Batch:</label><br>";
                                    echo "<select id='batch-id' name='batchId' class='form-control'>";
                                    echo "<option value='-2'>Select Batch</option>";
                                    $_getBatchData = $batch->getBatch('yes', $_branchId, 0, 'no', 0);
                                    if ($_getBatchData != null) {
                                        while ($row = $_getBatchData->fetch_assoc()) {
                                            $__batchId = $row['batchId'];
                                            $__batchName = $row['batchName'];

                                            if ($__batchId == $_batchId) {
                                                echo "<option value='" . $__batchId . "' selected>" . $__batchName . "</option>";
                                            } else {
                                                echo "<option value='" . $__batchId . "'>" . $__batchName . "</option>";
                                            }
                                        }
                                    } else {
                                        echo Constants::STATUS_FAILED;
                                    }
                                    echo "</select>";
                                    echo "</div>";
                                    echo "<button type='submit' class='btn btn-success' value='Update'>Update</button>";
                                    echo "</form>";
                                } else {
                                    echo Constants::STATUS_FAILED;
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


<script type="text/javascript">
    $(document).ready(function () {
        $("#branch-id").change(function () {
            var branchId = $("#branch-id option:selected").val();
            if (branchId < 0) {
                alert("Select Valid Branch");
//                $("#new-drop-down").hide();
            } else {
                $("#new-drop-down").show();
                $.ajax(
                    {
                        type: "POST",
                        url: "get_batch_jquery.php",
                        data: "branchId=" + branchId,
//                        dataType: "json",
                        success: function (json) {
                            console.log(json);
                            $("div#new-drop-down").removeClass("hide");
                            $("#batch-id").empty();
                            $("#batch-id").append("<option value='-3'>Select Batch</option>");
                            var parsed = jQuery.parseJSON(json);
                            for (var i = 0; i < parsed.batchId.length; i++) {
                                var batchId = parsed.batchId[i];
                                var batchName = parsed.batchName[i];
                                $("#batch-id").append("<option value='" + batchId + "'>" + batchName + "</option>");
                            }
                        },
                        error: function (a, b, c) {
                            console.log("Error");
                        }
                    });
            }
        });
    });
</script>
<?php
include "../../../Resources/Dashboard/footer.php"
?>
</body>
</html>