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