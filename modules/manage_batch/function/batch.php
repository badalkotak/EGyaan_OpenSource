<html>
<body>
    <?php
    include("../../../Resources/Dashboard/header.php");
    ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Hello!
            <small>Indresh Jotangia</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Batch List</li>
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
    <button type="submit" class="btn btn-success" value="Submit"><i class='fa fa-check'></i>Submit</button>
</form>

<?php
//var_dump($_REQUEST['branchId']);
if (isset($_REQUEST['branchId'])) {
    $branch_Id = $_REQUEST['branchId'];
    if ($branch_Id > 0) {
        echo "<form action='insert_batch.php' method='post'>";
        echo "<div class='col-md-6'><input type='hidden' name='branchId' value='" . $branch_Id . "'>";
        echo "<input type='text' class='form-control' name='batchName' placeholder='Enter Batch Name'></div>";
        
        echo "<button type='submit'  class='btn btn-success' value='Submit'><i class='fa fa-check'></i>Submit</button>";
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
        echo "<br><h3 class=box-title'>" . $branch_name[$i]."</h3>";
        $getBatchData = $batch->getBatch('yes', $branch_id[$i], 0, 'no', 0);
        if ($getBatchData != null) {
            $id = 1;
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr><th>Sr. no.</th><th>Batch Name</th><th>Edit</th><th>Delete</th></tr>";

            while ($row = $getBatchData->fetch_assoc()) {
                $batchTableId = $row['batchId'];
                $batchTableName = htmlentities($row['batchName'], ENT_QUOTES);

                echo "<tr><td>" . $id . "</td><td>" . $batchTableName . "</td><td><form action='editBatch.php' method='post'>
                <input type='hidden' name='branchId' value='" . $branch_id[$i] . "'><input type='hidden' name='batchId' value='" . $batchTableId . "'>
                <button type='submit' class='btn btn-primary' value='Edit'><i class='fa fa-pencil'></i>Edit</button></form></td>
                <td><form action='delete_batch.php' method='post'><input type='hidden' name='branchId' value='" . $branch_id[$i] . "'>
                    <input type='hidden' name='batchId' value='" . $batchTableId . "'><button type='submit' class='btn btn-danger' value='Delete'>Delete<i class='fa fa-trash'></i></button></form>
                </td></tr>";
                $id++;
            }
            echo "</table>";
        } else {
            echo "<br><br><h4 class='box-title'>No Records found</h4>";
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
<?php
include("../../../Resources/Dashboard/footer.php");

?>
</body>
</html>