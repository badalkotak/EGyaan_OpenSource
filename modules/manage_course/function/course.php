<html>
<body>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
?>
<head>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>
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
                if ($profile != null) {
                    echo "<img src='../../manage_student/images/student/$profile' class=img-circle alt='User Image'>";
                } else {
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
                <a href="../../manage_branch/function/branch.php">
                    <i class="fa  fa-sitemap"></i> <span>Manage Branch</span>
                </a>
            </li>
            <li class="treeview">
                <a href="../../manage_batch/function/batch.php">
                    <i class="fa fa-users"></i> <span>Manage Batch</span>
                </a>
            </li>
            <li class="treeview active">
                <a href="../../manage_course/function/course.php">
                    <i class="fa fa-book"></i> <span>Manage Course</span>
                </a>
            </li>
            <li class="treeview">
                <a href="../../manage_user/functions/user.php">
                    <i class="fa fa-user"></i> <span>Manage Users</span>
                </a>
            </li>
            <li class="treeview">
                <a href="../../manage_student/function/student.php">
                    <i class="fa fa-graduation-cap"></i> <span>Manage Students</span>
                </a>
            </li>
            <li class="treeview">
                <a href="../../manage_role/functions/role.php">
                    <i class="fa fa-user"></i> <span>Manage Role</span>
                </a>
            </li>
            <li class="treeview">
                <a href="../../manage_fees/function/manage_fees.php">
                    <i class="fa fa-file-text-o"></i> <span>Manage Fees</span>
                </a>
            </li>
            <li class="treeview">
                <a href="../../manage_noticeboard/function/index.php">
                    <i class="fa fa-calendar-minus-o"></i> <span>Noticeboard</span>
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
            <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active"><b>Course List</b></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Courses</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form action="" method="post">
                                <div class="col-md-6">
                                    <select class="form-control select2" name="branchId">
                                        <option value="-1">Select Branch</option>
                                        <?php
                                        /**
                                         * Created by PhpStorm.
                                         * User: fireion
                                         * Date: 5/6/17
                                         * Time: 2:46 PM
                                         */
                                        require_once("../../../classes/Constants.php");
                                        require_once("../../../classes/DBConnect.php");
                                        require_once("../classes/Course.php");
                                        require_once("../../manage_branch/classes/Branch.php");
                                        require_once("../../manage_batch/classes/Batch.php");

                                        $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                            Constants::DB_USERNAME,
                                            Constants::DB_PASSWORD,
                                            Constants::DB_NAME);

                                        $branch = new Branch($dbConnect->getInstance());
                                        $batch = new Batch($dbConnect->getInstance());
                                        $course = new Course($dbConnect->getInstance());

                                        $getBranchData = $branch->getBranch(0);
                                        if ($getBranchData != null) {
                                            while ($row = $getBranchData->fetch_assoc()) {
                                                $branchId = $row['id'];
                                                $branchName = $row['name'];

                                                if ($branchId == $_REQUEST['branchId']) {
                                                    echo "<option value='" . $branchId . "' selected>" . $branchName . "</option>";
                                                } else {
                                                    echo "<option value='" . $branchId . "'>" . $branchName . "</option>";
                                                }
                                            }
                                        } else {
                                            echo Constants::STATUS_FAILED;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success" value="Submit"><i class='fa fa-check'></i>&nbsp;Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        <?php
                        if (isset($_REQUEST['branchId'])) {
                            $branch_Id = $_REQUEST['branchId'];
                            $getBatchData = $batch->getBatch('yes', $branch_Id, 0, 'no', 0);
                            if ($branch_Id > 0) {
                                echo "<div class='row'><form action='' method='post'>";
                                echo "<div class='col-md-6'><select class='form-control select2' name='batchId'>";
                                echo "<option value='-2'>Select Batch</option>";
                                if ($getBatchData == true) {
                                    while ($array = $getBatchData->fetch_assoc()) {
                                        $batchId = $array['batchId'];
                                        $batchName = $array['batchName'];

                                        if ($batchId == $_REQUEST['batchId']) {
                                            echo "<option value='" . $batchId . "' selected>" . $batchName . "</option>";
                                        } else {
                                            echo "<option value='" . $batchId . "'>" . $batchName . "</option>";
                                        }
                                    }
                                } else {
                                    echo Constants::STATUS_FAILED;
                                }
                                echo "</select></div>";
                                echo "<input type='hidden' name='branchId' value='" . $branch_Id . "'>";
                                echo "<div class='col-md-6'><button type='submit' class='btn btn-success' value='Submit'><i class='fa fa-check'></i>&nbsp;Submit</button></div>";
                                echo "</form></div>";

                                if (isset($_REQUEST['branchId']) && isset($_REQUEST['batchId'])) {
                                    $branch_id = $_REQUEST['branchId'];
                                    $batch_id = $_REQUEST['batchId'];

                                    if ($branch_id > 0 && $batch_id > 0) {
                                        echo "<div class='row'><form action='insert_course.php' method='post'>";
                                        echo "<input type='hidden' name='branch_id' value='" . $branch_id . "'>";
                                        echo "<input type='hidden' name='batch_id' value='" . $batch_id . "'>";
                                        echo "<div class='form-group col-md-6'><input type='text' class='form-control' name='courseName' placeholder='Enter Course Name'></div>";

                                        echo "<div class='col-md-6'><button type='submit' class='btn btn-success' value='Submit'><i class='fa fa-check'></i>&nbspSubmit</button></div>";
                                        echo "</form></div>";
                                    } else {
                                        echo "<div class='alert-message'><i class='fa fa-exclamation-triangle'></i>&nbsp;Select valid Batch</div>";
                                    }
                                } else {
                                    echo "<div class='alert-message'><i class='fa fa-exclamation-triangle'></i>&nbsp;Select Appropriate Batch</div>";
                                }

                            } else {
                                echo "<div class='alert-message'><i class='fa fa-exclamation-triangle'></i>&nbsp;Select valid Branch/Department</div>";
                            }
                        } else {
                            echo "<div class='alert-message'><i class='fa fa-exclamation-triangle'></i>&nbsp;Select Appropriate Branch/Department</div>";
                        }

                        echo "<hr><h3 class='box-title'>List of Courses</h3>";

                        $getBatchNameData = $batch->getBatch('no', 0, 0, 'yes', 0);
                        if ($getBatchNameData != null) {
                            while ($nameArray = $getBatchNameData->fetch_assoc()) {
                                $_batchName[] = htmlentities($nameArray['name'], ENT_QUOTES);
                            }
                            for ($i = 0; $i < count($_batchName); $i++) {
                                echo "<h3 class='box-title'>" . $_batchName[$i] . "<br>";
//        var_dump($dbConnect->getInstance()->real_escape_string($_batchName[$i]));
                                $getCourseData = $course->getCourse('no', 0, 'yes', 0, 0, $dbConnect->getInstance()->real_escape_string($_batchName[$i]), 0);
                                if ($getCourseData != false) {
                                    $id = 1;
                                    echo "<div class='table-container1'><table  class='table table-bordered table-hover'>";
                                    echo "<thead><tr><th>Sr No</th><th>Branch Name</th><th>Course Name</th><th>Edit</th><th>Delete</th></tr></thead><tbody>";
                                    while ($rowData = $getCourseData->fetch_assoc()) {
                                        $_branchId = $rowData['branchId'];
                                        $_branchName = htmlentities($rowData['branchName'], ENT_QUOTES);
                                        $_batchId = $rowData['batchId'];
                                        $_courseId = $rowData['courseId'];
                                        $_courseName = htmlentities($rowData['courseName'], ENT_QUOTES);
                                        echo "<tr><td>" . $id . "</td><td>" . $_branchName . "</td><td>" . $_courseName . "</td>
                                            <td><form action='editCourse.php' method='post'><input type='hidden' name='branchId' value='" . $_branchId . "'>
                                                <input type='hidden' name='batchId' value='" . $_batchId . "'>
                                                <input type='hidden' name='courseId' value='" . $_courseId . "'>
                                                <button type='submit' class='btn btn-primary btn-sm' value='Edit'><i class='fa fa-pencil'></i>&nbsp;Edit</button></form></td>

                                                <td><button type='submit' id='" . $_courseId . "' class='btn btn-danger btn-sm delete-branch-button' value='Delete'><i class='fa fa-trash'></i>&nbsp;Delete</button>
                                                </td></tr>";
                                        $id++;
                                    }
                                    echo "</tbody></table></div>";
                                } else {
                                    echo "<h4 class='box-title'>No Records Found</h4>";
                                }
                            }
                        } else {
                            echo Constants::STATUS_FAILED;
                        }
                        ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".delete-branch-button").click(function (event) {
            event.preventDefault();
            var id = $(this).attr("id");
            console.log(id);
            var result = confirm('<?php echo Constants::DELETE_CONFIRMATION?>');
            if (result) {
                $.ajax(
                    {
                        type: "POST",
                        url: "delete_course.php",
                        data: "courseId=" + id,
//                        dataType:  "json ",
                        success: function (json) {
                            var parsedJson = jQuery.parseJSON(json);
                            if (parsedJson.statusMsg == "<?php echo Constants::STATUS_SUCCESS?>") {
                                alert(parsedJson.Msg);
                                location.reload();
                            } else {
                                alert(parsedJson.Msg);
                                location.reload();
                            }
                        },
                        error: function (a, b, c) {
                            console.log("Error ");
                        }
                    });
            } else {
                return false;
            }
        });
    });
</script>
<?php
include("../../../Resources/Dashboard/footer.php");

?>
</body>
</html>