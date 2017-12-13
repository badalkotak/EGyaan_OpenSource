<html>
<body>
  <?php
  include("../../../Resources/sessions.php");
  include("../../../Resources/Dashboard/header.php");
  ?>
    
    
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
        echo "<div class='row'><div class='form-group col-md-6'><input type='hidden' name='branchId' value='" . $branchId . "'>";
        echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
        echo "<input type='text' class='form-control' name='batchName' value='" . $batchName . "'></div>";
        
        echo "<div class='col-md-6'><button type='submit' class='btn btn-success' value='Update'><i class='fa fa-check'></i>&nbspUpdate</button></div></div>";
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
