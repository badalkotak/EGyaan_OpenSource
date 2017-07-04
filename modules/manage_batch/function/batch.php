<html>
<body>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
?>
<head>
    <script type="text/javascript" src="../../../Resources/jQuery/jquery-3.2.1.js"></script>
</head>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <br>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><b>Batch List</b></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Batches</h3>
                    </div>
                    <div class="box-body">
                        <form action="" method="post">
                            <div class="col-md-6">
                                <select class="form-control" name="branchId" id="branchId" required>
                                    <option value="-1">Select Branch</option>

                                    <?php
                                    /**
                                     * Created by PhpStorm.
                                     * User: fireion
                                     * Date: 5/6/17
                                     * Time: 11:02 AM
                                     */
                                    require_once("../../../classes/Constants.php");
                                    require_once("../../../classes/DBConnect.php");
                                    require_once("../classes/Batch.php");
                                    require_once("../../manage_branch/classes/Branch.php");

                                    $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                        Constants::DB_USERNAME,
                                        Constants::DB_PASSWORD,
                                        Constants::DB_NAME);

                                    $branch = new Branch($dbConnect->getInstance());
                                    $batch = new Batch($dbConnect->getInstance());

                                    $getData = $branch->getBranch(0);

                                    if ($getData != null) {
                                        while ($arrayGetData = $getData->fetch_assoc()) {
                                            $branchId = $arrayGetData['id'];
                                            $branchName = htmlentities($arrayGetData['name'], ENT_QUOTES);

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
                        //var_dump($_REQUEST['branchId']);
                        if (isset($_REQUEST['branchId'])) {
                            $branch_Id = $_REQUEST['branchId'];
                            if ($branch_Id > 0) {
                                echo "<form action='insert_batch.php' method='post'>";
                                echo "<div class='col-md-6'><input type='hidden' name='branchId' value='" . $branch_Id . "'>";
                                echo "<input type='text' class='form-control' name='batchName' placeholder='Enter Batch Name'></div>";

                                echo "<button type='submit'  class='btn btn-success' value='Submit'><i class='fa fa-check'></i>&nbspSubmit</button>";
                                echo "</form>";
                            } else {
                                echo "Select valid Branch/Department";
                            }
                        } else {
                            echo "Select Appropriate Branch/Department";
                        }

                        echo "<br><br><h3 class='box-title'>List of Batches</h3>";
                        $getBatchData = $branch->getBranch(0);
                        //var_dump($getBatchData);
                        if ($getBatchData != null) {
                            while ($array = $getBatchData->fetch_assoc()) {
                                $branch_id[] = $array['id'];
                                $branch_name[] = htmlentities($array['name'], ENT_QUOTES);
                            }
                            for ($i = 0; $i < count($branch_id); $i++) {
                                echo "<br><h3 class=box-title'>" . $branch_name[$i] . "</h3>";
                                $getBatchData = $batch->getBatch('yes', $branch_id[$i], 0, 'no', 0);
                                if ($getBatchData != null) {
                                    $id = 1;
                                    echo "<table class='table table-bordered table-hover example2'>";
                                    echo "<thead><tr><th>Sr. no.</th><th>Batch Name</th><th>Edit</th><th>Delete</th></tr></thead><tbody>";

                                    while ($row = $getBatchData->fetch_assoc()) {
                                        $batchTableId = $row['batchId'];
                                        $batchTableName = htmlentities($row['batchName'], ENT_QUOTES);

                                        echo "<tr><td>" . $id . "</td><td>" . $batchTableName . "</td><td><form action='editBatch.php' method='post'>
                <input type='hidden' name='branchId' value='" . $branch_id[$i] . "'><input type='hidden' name='batchId' value='" . $batchTableId . "'>
                <button type='submit' class='btn btn-primary' value='Edit'><i class='fa fa-pencil'></i>&nbspEdit</button></form></td>
                
                <td><button type='submit' id='" . $batchTableId . "' class='btn btn-danger delete-branch-button' value='Delete'><i class='fa fa-trash'></i>&nbspDelete</button>
                </td></tr>";
                                        $id++;
                                    }
                                    echo "</tbody></table>";
                                } else {
                                    echo "<br><br><h4 class='box-title'>No Records found</h4> ";
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
//            console.log(id);
            var result = confirm('<?php echo Constants::DELETE_CONFIRMATION?>');
            if (result) {
                $.ajax(
                    {
                        type: "POST",
                        url: "delete_batch.php",
                        data: "batchId=" + id,
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