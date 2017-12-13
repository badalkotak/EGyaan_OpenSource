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
                    <li class="treeview active">
                        <a href="../../manage_branch/function/branch.php">
                            <i class="fa  fa-sitemap"></i> <span>Manage Branch</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_batch/function/batch.php">
                            <i class="fa fa-users"></i> <span>Manage Batch</span>
                        </a>
                    </li>
                    <li class="treeview">
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
            <li class="active"><b>Branch List</b></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Branches</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form action="insert_branch.php" method="post">
                                <div class="col-md-6">
                                    <input type="text" class="form-group form-control" name="branch_name"
                                           placeholder="Enter Branch Name">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success" value="Submit"><i class="fa fa-check"></i>&nbsp;Submit
                                </button>
                                </div>
                            </form>
                        </div>

                        <?php
                        /**
                         * Created by PhpStorm.
                         * User: fireion
                         * Date: 4/6/17
                         * Time: 5:16 PM
                         */
                        require_once("../../../classes/Constants.php");
                        require_once("../../../classes/DBConnect.php");
                        require_once("../classes/Branch.php");

                        $dbConnect = new DBConnect(Constants::SERVER_NAME,
                            Constants::DB_USERNAME,
                            Constants::DB_PASSWORD,
                            Constants::DB_NAME);

                        echo "<hr><h4>List of Department - Branches</h4>";
                        
                        $branch = new Branch($dbConnect->getInstance());
                        $result = $branch->getBranch(0);

                        if ($result != null) {
                            $i = 0;
                            echo '<div class="table-container1">';
                            echo "<table class='table table-bordered table-hover example2'>";
                            echo "<thead><tr><th>Sr No</th><th>Name</th><th>Edit</th><th>Delete</th></tr></thead>";
                            echo "<tbody>";
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['id'];
                                $name = htmlentities($row['name'], ENT_QUOTES);
                                // echo "<tr><td>" . $name . "</td><td><form action='editBranch.php' method='post'>
                                // <input type='hidden' value='" . $id . "' name='branchId'><input type='hidden' value='" . $name . "' name='branchName'>
                                // <input type='submit' value='Edit'></form></td><td><form action='delete_branch.php' method='post'>
                                // <input type='hidden' value='" . $id . "' name='branchId'><input type='hidden' value='" . $name . "' name='branchName'>
                                // <input type='submit' value='Delete'></form></td></tr>";

                                echo "<tr>";
                                $i++;
                                echo "<td>";
                                echo $i;
                                echo "</td>";

                                echo "<td>";
                                echo $name;
                                echo "</td>";

                                echo "<td>";
                                echo "<form action='editBranch.php' method='post'><input type='hidden' value='$id' name='edit'>
    <button type='submit' class='btn btn-primary btn-sm' value='Edit'><i class='fa fa-pencil'></i>&nbspEdit</button></form>";
                                echo "</td>";

                                echo "<td>";
                                echo "<button type='submit' id='" . $id . "' class='btn btn-danger btn-sm delete-branch-button' value='Delete'>
                                      <i class='fa fa-trash'></i>&nbspDelete</button>";
                                echo "</td>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                        } else {
                            echo "No Records Found";
                        }
                        ?>
                        <!-- </div> -->
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
//            console.log(id);
            var result = confirm('<?php echo Constants::DELETE_CONFIRMATION?>');
            if (result) {
                $.ajax(
                    {
                        type: "POST",
                        url: "delete_branch.php",
                        data: "delete=" + id,
//                        dataType: "json",
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
                            console.log("Error");
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