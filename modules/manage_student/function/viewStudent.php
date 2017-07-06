<!DOCTYPE html>
<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Student Information - Detailed View | EGyaan</title>
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
                <li><a href="editDeleteStudent.php">&nbsp;Edit Student</a></li>
                <li class="active"><b>Student Details</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Student Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php
                            /**
                             * Created by PhpStorm.
                             * User: fireion
                             * Date: 12/6/17
                             * Time: 2:41 PM
                             */

                            require_once("../../../classes/Constants.php");
                            require_once("../../../classes/DBConnect.php");
                            require_once("../classes/Student.php");
                            require_once("../../manage_batch/classes/Batch.php");

                            $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                Constants::DB_USERNAME,
                                Constants::DB_PASSWORD,
                                Constants::DB_NAME);

                            if (isset($_REQUEST['studentId']) && !empty(trim($_REQUEST['studentId']))) {

                                $studentId = $_REQUEST['studentId'];
//    var_dump($studentId);

                                $student = new Student($dbConnect->getInstance());

                                $getData = $student->getStudent($studentId, 0);

                                if ($getData != false) {
                                    while ($row = $getData->fetch_assoc()) {
                                        $id = $row['id'];
                                        $firstName = $row['firstname'];
                                        $lastName = $row['lastname'];
                                        $email = $row['email'];
//            $studentPassword = $row['student_passwd'];
                                        $mobile = $row['mobile'];
                                        $gender = $row['gender'];
                                        $parentName = $row['parent_name'];
                                        $parentEmail = $row['parent_email'];
//            $parentPassword = $row['parent_passwd'];
                                        $totalFees = $row['total_fees'];
                                        $feesPaid = $row['fees_paid'];
                                        $feesComment = $row['fees_comment'];
                                        $dateOfAdmission = $row['date_of_admission'];
                                        $parentMobile = $row['parent_mobile'];
                                        $studentProfilePhoto = $row['student_profile_photo'];
                                        $parentProfilePhoto = $row['parent_profile_photo'];
                                        $batchId = $row['batch_id'];
                                    }

                                    //        var_dump($studentProfilePhoto);
                                    echo "<img src='../images/student/" . $studentProfilePhoto . "' width='75' height='75'><br>";
                                    echo "<label>Name:&nbsp</label>";
                                    echo $firstName . " " . $lastName . "<br>";
                                    echo "<label>Email:&nbsp</label>";
                                    echo $email . "<br>";
                                    echo "<label>Name:&nbsp</label>";
                                    echo $mobile . "<br>";
                                    echo "<label>Gender:&nbsp</label>";
                                    echo $gender . "<br>";
                                    echo '<hr>';
                                    echo "<h4>Parent Details</h4>";
                                    echo "<img src='../images/parent/" . $parentProfilePhoto . "' width='75' height='75'><br>";
                                    echo "<label>Name:&nbsp</label>";
                                    echo $parentName . "<br>";
                                    echo "<label>Email:&nbsp</label>";
                                    echo $parentEmail . "<br>";
                                    echo "<label>Total Fees:&nbsp</label>";
                                    echo $totalFees . "<br>";
                                    echo "<label>Fees Paid:&nbsp</label>";
                                    echo $feesPaid . "<br>";
                                    echo "<label>Fees Comment:&nbsp</label>";
                                    echo $feesComment . "<br>";
                                    echo "<label>Date Of Admission:&nbsp</label>";
                                    echo $dateOfAdmission . "<br>";
                                    echo "<label>Mobile No.:&nbsp</label>";
                                    echo $parentMobile . "<br>";

                                    $batch = new Batch($dbConnect->getInstance());

                                    $getBatchData = $batch->getBatch('no', 0, $batchId, 'no', 0);
                                    if ($getBatchData != null) {
                                        while ($row = $getBatchData->fetch_assoc()) {
                                            $batchName = $row['batchName'];
                                            echo $batchName . "<br>";
                                        }
                                    } else {
                                        echo Constants::STATUS_FAILED;
                                    }
                                } elseif ($getData == false) {
                                    echo Constants::STATUS_FAILED;
                                } else {
                                    echo "No Records Found!";
                                }
                            } else {
                                echo Constants::EMPTY_PARAMETERS;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php
include "../../../Resources/Dashboard/footer.php";
?>
</body>
</html>