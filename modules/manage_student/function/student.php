<html>
<?php
include("../../../Resources/sessions.php");
include "../../../Resources/Dashboard/header.php";
?>
<head>
    <title>Add Student | EGyaan</title>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>
    <style>
        div.hide {
            display: none;
        }
    </style>
</head>
<!--START OF SIDEBAR===========================================================================================================-->
<!-- Left side column. contains the sidebar -->
<
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><br>
        <ol class="breadcrumb">
            <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active"><b>Add Student</b></li>
        </ol>
    </section>
    <section class="content">

        <!-- Default box -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!--<div class="box-header with-border">
                        <h3 class="box-title">Add Student</h3>
                    </div>-->
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Student</h3>
                    </div>
                    <form role="form" action="insert_student.php" method="post" id="student-form"
                          enctype="multipart/form-data">
                        <div class="box-body">
                            <h4>Student Details</h4>
                            <div class="form-group">
                                Choose Student Photo : <input type="file" class="form-control"
                                                              name="studentProfilePhoto">
                                <label>Max Size of Image is 5MB.</label>
                            </div>
                            <div class="form-group">
                                <label>Firstname</label>
                                <input type="text" class="form-control" name="firstName"
                                       placeholder="Enter First Name">
                            </div>
                            <div class="form-group">
                                <label>Lastname</label>
                                <input type="text" class="form-control" name="lastName"
                                       placeholder="Enter Last Name">
                            </div>
                            <div class="form-group">
                                <label>Email-Id</label>
                                <input type="email" class="form-control" name="emailId"
                                       placeholder="Enter Email Id">
                            </div>
                            <!-- <input type="password" name="studentPassword" placeholder="Enter Student Password"><br> -->
                            <div class="form-group">
                                <label>Mobile No.</label>
                                <input type="number" class="form-control" name="mobile"
                                       placeholder="Enter Mobile Number">
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control select2">
                                    <option value="-1" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="TransGender">TransGender</option>
                                </select>
                            </div>
                            <hr>
                            <h4>Parent Details</h4>
                            <div class="form-group">
                                Choose Parent Photo : <input type="file" class="form-control"
                                                             name="parentProfilePhoto">
                                <label>Max Size of Image is 5MB.</label>
                            </div>
                            <div class="form-group">
                                <label>Parent Name</label>
                                <input type="text" class="form-control" name="parentName"
                                       placeholder="Enter Parent name">
                            </div>
                            <div class="form-group">
                                <label>Parent Email-id</label>
                                <input type="email" class="form-control" name="parentEmail"
                                       placeholder="Enter Parent Email">
                            </div>
                            <div class="form-group">
                                <label>Total Fees</label>
                                <input type="number" class="form-control" name="totalFees"
                                       placeholder="Enter Total Fees">
                            </div>
                            <div class="form-group">
                                <label>Fees Paid</label>
                                <input type="number" class="form-control" name="feesPaid"
                                       placeholder="Enter Fees Paid">
                            </div>
                            <div class="form-group">
                                <label>Fees Comment</label>
                                <textarea class="form-control" style="resize: vertical;" name="feesComment"
                                          placeholder="Enter Fees Comment"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Date Of Admission</label>
                                <input type="date" class="form-control datepicker" name="dateOfAdmission"
                                       placeholder="Enter Date of Admission">
                            </div>
                            <div class="form-group">
                                <label>Parent Phone No.</label>
                                <input type="number" class="form-control" name="parentMobile"
                                       placeholder="Enter parent Phone Number">
                            </div>
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control select2" id="branch-id">
                                    <option value="-2" disabled selected>Select Branch</option>

                                    <?php
                                    /**
                                     * Created by PhpStorm.
                                     * User: fireion
                                     * Date: 9/6/17
                                     * Time: 4:45 PM
                                     */

                                    require_once("../../../classes/Constants.php");
                                    require_once("../../../classes/DBConnect.php");
                                    require_once("../../manage_branch/classes/Branch.php");
                                    require_once("../../manage_batch/classes/Batch.php");

                                    $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                        Constants::DB_USERNAME,
                                        Constants::DB_PASSWORD,
                                        Constants::DB_NAME);

                                    $branch = new Branch($dbConnect->getInstance());

                                    $getData = $branch->getBranch(0);

                                    if ($getData != null) {
                                        while ($row = $getData->fetch_assoc()) {
                                            $branchId = $row['id'];
                                            $branchName = $row['name'];

                                            echo "<option value='$branchId'>" . $branchName . "</option>";
                                        }
                                    } else {
                                        echo Constants::STATUS_FAILED;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="new-drop-down">
<!--                                <select class="form-control select2" name="batchId" id="batch-id">-->
<!--                                    <!--            <option value="-3">Select Batch</option>-->
<!--                                </select>-->
                            </div>

                            <div class="box-footer">
                                <button type="submit" value="Submit" class="btn btn-success"><i
                                            class="fa fa-check  "></i>&nbsp;Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
</div>
<SCRIPT>
    $(":file").filestyle({size: "sm"});
</SCRIPT>
<script type="text/javascript">
    $(document).ready(function () {
//        $("#student-form").submit(function (event) {
//            event.preventDefault();
//        });

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
                            $("#new-drop-down").removeClass("hide");
                            $("#new-drop-down").append("<select class='form-control select2' name='batchId' id='batch-id'></select>");
                            $("#batch-id").empty();
                            $("#batch-id").append("<option value='-3' disabled selected>Select Batch</option>");
                            var parsed = jQuery.parseJSON(json);
                            for (var i = 0; i < parsed.batchId.length; i++) {
                                var batchId = parsed.batchId[i];
                                var batchName = parsed.batchName[i];
                                $("#batch-id").append("<option value='" + batchId + "'>" + batchName + "</option>");
                            }
                            $(".select2, #select2").select2();
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
include("../../../Resources/Dashboard/footer.php");
?>
</body>
</html>
