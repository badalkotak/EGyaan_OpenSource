<!DOCTYPE html>
<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Select Branch and Batch - Student Course | EGyaan</title>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>

    <style>
        div.hide {
            display: none;
        }
    </style>

</head>
<!--START OF SIDEBAR===========================================================================================================-->
    <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <?
                        if($profile!=null)
                            		{
                            			echo "<img src='../../manage_student/images/student/$profile' class=img-circle alt='User Image'>";
                            		}
                           			else
                            		{
                            			echo "<img src='../../../Resources/images/boy.png' class=img-circle alt='User Image'>";
                            		}
                        ?>
                    </div>
                    <div class="pull-left info">
                    <?
                    echo "<p>$display_name</p>";
                    ?>
                        <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
                    </div>
                </div>
                        <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview">
                        <a href="../../login/functions/Dashboard.php">
                            <i class="fa fa-home"></i> <span>Home</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-gears"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
    
<!--END OF SIDEBAR=============================================================================================================-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="student.php">Add Student</a></li>
                <li><a href="courseRegistrationStudent.php">Course Registration</a></li>
                <li class="active"><b>Select Course</b></li>
            </ol>
        </section>
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Select Course</h3>
                </div>
                <form role="form" action="editDeleteCourse.php" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <select id="branch-id" name="branchId" class="form-control select2">
                                <option value="-2">Select Branch</option>
                                <?php
                                /**
                                 * Created by PhpStorm.
                                 * User: fireion
                                 * Date: 20/6/17
                                 * Time: 1:17 PM
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
                                $batch = new Batch($dbConnect->getInstance());

                                $getBranchData = $branch->getBranch(0);
                                if ($getBranchData != null) {
                                    while ($row = $getBranchData->fetch_assoc()) {
                                        $branchId = $row['id'];
                                        $branchName = $row['name'];

                                        echo "<option value='" . $branchId . "'>" . $branchName . "</option>";
                                    }
                                } else {
                                    echo Constants::STATUS_FAILED;
                                }
                                ?>

                            </select>
                        </div>
                        <div id="new-drop-down" class="hide">
                            <div class="form-group">
                                <select name="batchId" id="batch-id" class="form-control">
                                    <!--            <option value="-3">Select Batch</option>-->
                                </select>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-success" type="submit" value="Submit"><i class="fa fa-check"></i>&nbsp;Submit
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

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
<?php
include "../../../Resources/Dashboard/footer.php";
?>


</body>
</html>
