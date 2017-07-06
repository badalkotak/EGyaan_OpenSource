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
                        <form action="" method="post">
                            <div class="col-md-6">
                                <select class="form-control" name="branchId">
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
                                </select></div>
                            <button type="submit" class="btn btn-success" value="Submit"><i class='fa fa-check'></i>&nbspSubmit
                            </button>
                        </form>
                        <?php
                        if (isset($_REQUEST['branchId'])) {
                            $branch_Id = $_REQUEST['branchId'];
                            $getBatchData = $batch->getBatch('yes', $branch_Id, 0, 'no', 0);
                            if ($branch_Id > 0) {
                                echo "<form action='' method='post'>";
                                echo "<div class='col-md-6'><select class='form-control' name='batchId'>";
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
                                echo "<button type='submit' class='btn btn-success' value='Submit'><i class='fa fa-check'></i>&nbspSubmit</button>";
                                echo "</form>";

                                if (isset($_REQUEST['branchId']) && isset($_REQUEST['batchId'])) {
                                    $branch_id = $_REQUEST['branchId'];
                                    $batch_id = $_REQUEST['batchId'];

                                    if ($branch_id > 0 && $batch_id > 0) {
                                        echo "<form action='insert_course.php' method='post'>";
                                        echo "<div class='col-md-6'><input type='hidden' name='branch_id' value='" . $branch_id . "'>";
                                        echo "<input type='hidden' name='batch_id' value='" . $batch_id . "'>";
                                        echo "<input type='text' class='form-control' name='courseName' placeholder='Enter Course Name'></div>";

                                        echo "<button type='submit' class='btn btn-success' value='Submit'><i class='fa fa-check'></i>&nbspSubmit</button>";
                                        echo "</form>";
                                    } else {
                                        echo "Select valid Batch";
                                    }
                                } else {
                                    echo "<br>Select Appropriate Batch<br><br>";
                                }

                            } else {
                                echo "Select valid Branch/Department";
                            }
                        } else {
                            echo "Select Appropriate Branch/Department<br>";
                        }

                        echo "<br><br><h3 class='box-title'>List of Courses</h3>";

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
                                    echo "<table class='table table-bordered table-hover'>";
                                    echo "<tr><th>Sr. no.</th><th>Branch Name</th><th>Course Name</th><th>Edit</th><th>Delete</th></tr>";
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
                    <button type='submit' class='btn btn-primary' value='Edit'><i class='fa fa-pencil'></i>&nbspEdit</button></form></td>
                    
                    <td><button type='submit' id='" . $_courseId . "' class='btn btn-danger delete-branch-button' value='Delete'><i class='fa fa-trash'></i>&nbspDelete</button>
                    </td></tr> ";
                                        $id++;
                                    }
                                    echo "</table><br> ";
                                } else {
                                    echo "<h4 class='box-title'>No Records Found</h4><br><br> ";
                                }
                            }
                        } else {
                            echo Constants::STATUS_FAILED;
                        }
                        ?>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
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