<html>
<body>
  <?php
  include("../../../Resources/sessions.php");
  include("../../../Resources/Dashboard/header.php");
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <br>
      <ol class="breadcrumb">
        <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="batch.php">Batch List</a></li>
        <li class="active"><b>Edit Batch</b></li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Batch</h3>
            </div>
            <div class="box-body">
              <form action="edit_batch.php" method="post">
                <?php
    /**
     * Created by PhpStorm.
     * User: fireion
     * Date: 5/6/17
     * Time: 12:52 PM
     */
    require_once("../../../classes/Constants.php");
    require_once("../../../classes/DBConnect.php");
    require_once("../classes/Batch.php");
    require_once("../../manage_branch/classes/Branch.php");

    $dbConnect = new DBConnect(Constants::SERVER_NAME,
      Constants::DB_USERNAME,
      Constants::DB_PASSWORD,
      Constants::DB_NAME);

    if (isset($_REQUEST['branchId']) && isset($_REQUEST['batchId']) && !empty(trim($_REQUEST['branchId']))
      && !empty(trim($_REQUEST['batchId']))
      ) {
      $branchId = $_REQUEST['branchId'];
//        $branchName = $_REQUEST['branchName'];
    $batchId = $_REQUEST['batchId'];
//        $batchName = $_REQUEST['batchName'];

    $branch = new Branch($dbConnect->getInstance());
    $batch = new Batch($dbConnect->getInstance());

    $getBranchData = $branch->getBranch($branchId);
    if ($getBranchData != null) {
      while ($row = $getBranchData->fetch_assoc()) {
        $branchName = htmlentities($row['name'], ENT_QUOTES);
      }

      $getBatchData = $batch->getBatch('no', 0, $batchId, 'no', 0);
//            var_dump($getBatchData);
      if ($getBatchData != null) {
        while ($array = $getBatchData->fetch_assoc()) {
          $batchName = htmlentities($array['batchName'], ENT_QUOTES);
        }
        echo "<label>" . $branchName . "</label>";
        echo "<br>";
        echo "<div class='row'><div class='col-md-6'><input type='hidden' name='branchId' value='" . $branchId . "'>";
        echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
        echo "<input type='text' class='form-control' name='batchName' value='" . $batchName . "'></div>";
        
        echo "<button type='submit' class='btn btn-success' value='Update'><i class='fa fa-check'></i>&nbspUpdate</button></div>";
      } else {
        echo Constants::STATUS_FAILED;
      }
    } else {
      echo Constants::STATUS_FAILED;
    }
  } else {
    echo Constants::EMPTY_PARAMETERS;
  }
  ?>
</form>
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
