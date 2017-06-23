<html>
<head>
    <title>Edit Student Information | EGyaan</title>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>
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

        echo "<form  action='edit_student.php' method='post' enctype='multipart/form-data'>";
        echo "<img src='http://localhost/EGyaan_OpenSource/modules/manage_student/images/student/" . $studentProfilePhoto . "' width='75' height='75'><br>";
        echo "Choose Student Photo : <input type='file' name='studentProfilePhoto'>
    <label>Max Size of Image is 5MB.</label>
    <br>";
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
        echo "<img src='http://localhost/EGyaan_OpenSource/modules/manage_student/images/parent/" . $parentProfilePhoto . "' width='75' height='75'><br>";
        echo "Choose Parent Photo : <input type='file' name='parentProfilePhoto'>
    <label>Max Size of Image is 5MB.</label>
    <br>";
        echo "<input type='text' name='parentName' value='" . $parentName . "'><br>";
        echo "<input type='email' name='parentEmail' value='" . $parentEmail . "'><br>";
        echo "<input type='text' name='parentPassword' value='" . $parentPassword . "'><br>";
        echo "<input type='number' name='totalFees' value='" . $totalFees . "'><br>";
        echo "<input type='number' name='feesPaid' value='" . $feesPaid . "'><br>";
        echo "<textarea name='feesComment'>" . $feesComment . "</textarea><br>";
        echo "<input type='date' name='dateOfAdmission' value='" . $dateOfAdmission . "'><br>";
        echo "<input type='number' name='parentMobile' value='" . $parentMobile . "'><br>";
//        echo $batchName . "<br>";
//        echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
        echo "<select name='branchId' id='branch-id'>";
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
        echo "<select id='batch-id' name='batchId'>";
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

        echo "<input type='submit' value='Update'>";
        echo "</form>";
    } else {
        echo Constants::STATUS_FAILED;
    }
} else {
    echo Constants::EMPTY_PARAMETERS;
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#branch-id").change(function () {
            var branchId = $("#branch-id option:selected").val();
            if (branchId < 0) {
                alert("Select Valid Branch");
                $("#new-drop-down").hide();
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

</body>
</html>