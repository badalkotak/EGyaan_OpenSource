<html>
<head>
    <title>Student - Add Students|EGyaan</title>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>
    <style>
        div.hide {
            display: none;
        }
    </style>
</head>
<body>
<form action="insert_student.php" method="post" id="student-form">
    <input type="text" name="firstName" placeholder="Enter First Name"><br>
    <input type="text" name="lastName" placeholder="Enter Last Name"><br>
    <input type="email" name="emailId" placeholder="Enter Email Id"><br>
    <!-- <input type="password" name="studentPassword" placeholder="Enter Student Password"><br> -->
    <input type="number" name="mobile" placeholder="Enter Mobile Number"><br>
    <select name="gender">
        <option value="-1">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="TransGender">TransGender</option>
    </select>
    <br>
    <input type="text" name="parentName" placeholder="Enter Parent name"><br>
    <input type="email" name="parentEmail" placeholder="Enter Parent Email"><br>
    <!-- <input type="password" name="parentPassword" placeholder="Enter Parent Password"><br> -->
    <input type="number" name="totalFees" placeholder="Enter Total Fees"><br>
    <input type="number" name="feesPaid" placeholder="Enter Fees Paid"><br>
    <textarea name="feesComment" placeholder="Enter Fees Comment"></textarea><br>
    <input type="date" name="dateOfAdmission" placeholder="Enter Date of Admission"><br>
    <input type="number" name="parentMobile" placeholder="Enter parent Phone Number"><br>
    <select id="branch-id">
        <option value="-2">Select Branch</option>

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
    <div id="new-drop-down" class="hide">
        <select name="batchId" id="batch-id">
            <!--            <option value="-3">Select Batch</option>-->
        </select>
    </div>
    <br>
    <br>
    <input type="submit" value="Submit">
</form>

<script type="text/javascript">
    $(document).ready(function () {
//        $("#student-form").submit(function (event) {
//            event.preventDefault();
//        });

        $("#branch-id").change(function () {
            var branchId = $("#branch-id option:selected").val();
            if (branchId < 0) {
                $("#new-drop-down").hide();
                alert("Select Valid Branch");
            } else {
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
