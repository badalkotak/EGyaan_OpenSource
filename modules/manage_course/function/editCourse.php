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
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="course.php">Course List</a></li>
            <li class="active"><b>Edit Course<b></li>
        </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Course</h3>
          </div>
          <div class="box-body">
            <form action="edit_course.php" method="post">
                <?php
    /**
     * Created by PhpStorm.
     * User: fireion
     * Date: 5/6/17
     * Time: 5:05 PM
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

    if (isset($_REQUEST['branchId']) && isset($_REQUEST['batchId']) && isset($_REQUEST['courseId'])
        && !empty(trim($_REQUEST['branchId'])) && !empty(trim($_REQUEST['batchId'])) && !empty(trim($_REQUEST['courseId']))
        ) {
        $branchId = $_REQUEST['branchId'];
    $batchId = $_REQUEST['batchId'];
    $courseId = $_REQUEST['courseId'];
//        $branchName = $_REQUEST['branchName'];
//        $batchName = $_REQUEST['batchName'];
//        $courseName = $_REQUEST['courseName'];

    $branch = new Branch($dbConnect->getInstance());
    $batch = new Batch($dbConnect->getInstance());
    $course = new Course($dbConnect->getInstance());

    $getBranchData = $branch->getBranch($branchId);
    if ($getBranchData != null) {
        while ($row = $getBranchData->fetch_assoc()) {
            $branchName = htmlentities($row['name'], ENT_QUOTES);
        }

        $getBatchData = $batch->getBatch('no', 0, $batchId, 'no', 0);
        if ($getBatchData != null) {
            while ($row1 = $getBatchData->fetch_assoc()) {
                $batchName = htmlentities($row1['batchName'], ENT_QUOTES);
            }

            $getCourseData = $course->getCourse('no', 0, 'no', 0, $courseId, null, 0);
            if ($getCourseData != null) {
                while ($row2 = $getCourseData->fetch_assoc()) {
                    $courseName = htmlentities($row2['name'], ENT_QUOTES);
                }

                    //        echo "<select name='branchId' disabled>";
//        echo "<option value='" . $branchId . "'>" . $branchName . "</option>";
//        echo "</select>";
                echo "<label>" . $branchName . "</label>";
                echo "<br>";
//        echo "<select name='batchId' disabled>";
//        echo "<option value='" . $batchId . "'>" . $batchName . "</option>";
//        echo "</select>";
                echo "<label>" . $batchName . "</label>";
                echo "<br>";
                echo "<div class='col-md-6'><input type='hidden' name='branchId' value='" . $branchId . "'>";
                echo "<input type='hidden' name='batchId' value='" . $batchId . "'>";
                echo "<input type='hidden' name='courseId' value='" . $courseId . "'>";
                echo "<input type='text' class='form-control' name='courseName' value='" . $courseName . "'></div>";
                
                echo "<button type='submit' class='btn btn-success' value='Update'><i class='fa fa-check'></i>&nbspUpdate</button>";
            } else {
                echo Constants::STATUS_FAILED;
            }
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