<?php
/**
 * Created by PhpStorm.
 * User: fireion
 * Date: 4/6/17
 * Time: 5:49 PM
 */
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Branch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

if (isset($_REQUEST['edit']) && !empty(trim($_REQUEST['edit']))) {
    $branchId = $_REQUEST['edit'];
    // $branchName = $_REQUEST['branchName'];

    $branch = new Branch($dbConnect->getInstance());

    $getBranchName = $branch->getBranch(0);
    if ($getBranchName != null) {
        while ($row = $getBranchName->fetch_assoc()) {
            $id = $row['id'];
            if ($id === $branchId) {
                $branchName = htmlentities($row['name'], ENT_QUOTES);
                break;
            }
        }
    } else {
        echo Constants::STATUS_FAILURE;
    }

} else {
    echo Constants::EMPTY_PARAMETERS;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Department - Edit Branches|EGyaan</title>
</head>
<body>
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
            <li><a href="branch.php">Branch List</a></li>
            <li class="active"><b>Edit Branch</b></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Branch</h3>
                    </div>
                    <div class="box-body">
                        <form action="edit_branch.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="branchId" value="<?php echo $branchId; ?>">

                                    <input type="text" class="form-group form-control" name="branchName"
                                           value="<?php echo $branchName; ?>">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success" value="Update"><i class='fa fa-check'></i>&nbsp;Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
</div>
<!-- /.row -->

<?php
include("../../../Resources/Dashboard/footer.php");

?>
</body>
</html>