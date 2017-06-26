<!DOCTYPE html>
<html>
<head>
    <?php
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>View - Delete | EGyaan</title>
</head>
<body>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><b>Edit Student</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Edit Student</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <?php
                            /**
                             * Created by PhpStorm.
                             * User: fireion
                             * Date: 12/6/17
                             * Time: 12:38 PM
                             */

                            require_once("../../../classes/Constants.php");
                            require_once("../../../classes/DBConnect.php");
                            require_once("../classes/Student.php");

                            $dbConnect = new DBConnect(Constants::SERVER_NAME,
                                Constants::DB_USERNAME,
                                Constants::DB_PASSWORD,
                                Constants::DB_NAME);

                            if (isset($_REQUEST['branchId']) && isset($_REQUEST['batchId']) && !empty(trim($_REQUEST['branchId']))
                                && !empty(trim($_REQUEST['batchId']))
                            ) {
                                $branchId = $_REQUEST['branchId'];
                                $batchId = $_REQUEST['batchId'];

                                $student = new Student($dbConnect->getInstance());

                                $getData = $student->getStudent(0, $batchId);

                                if ($getData != false) {
                                    $id = 1;
                                    echo "<table class='table table-bordered table-hover example2'>";
                                    echo "<thead><tr><th>Sr. no.</th><th>Student Name</th><th>View</th><th>Edit</th><th>Delete</th></tr></thead>";
                                    while ($row = $getData->fetch_assoc()) {
                                        $studentId = $row['id'];
                                        $studentFirstName = $row['firstname'];
                                        $studentLastName = $row['lastname'];

                                        echo "<tbody><tr><td>" . $id . "</td><td>" . $studentFirstName . " " . $studentLastName . "</td><td>
        <form action='viewStudent.php' method='post'><input type='hidden' name='studentId' value='" . $studentId . "'>
        <button type='submit' class='btn btn-success' value='View'><i class='fa fa-eye'></i>&nbspView</form></td><td><form action='editStudent.php' method='post'>
        <input type='hidden' name='studentId' value='" . $studentId . "'><button type='submit' class='btn btn-primary' value='Edit'><i class='fa fa-pencil'></i>&nbspEdit</form></td>
        <td><form action='delete_student.php' method='post'><input type='hidden' name='studentId' value='" . $studentId . "'>
        <button type='submit' value='Delete' class='btn btn-danger'><i class='fa fa-trash'></i>&nbspDelete</form></td></tr>";
                                        $id++;

                                    }
                                } elseif ($getData == false) {
                                    echo Constants::STATUS_FAILED;
                                } else {
                                    echo "No Records Found!";
                                }
                            } else {
                                echo Constants::EMPTY_PARAMETERS;
                            }
                            echo "</tbody></table>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
include "../../../Resources/Dashboard/footer.php"
?>
</body>
</html>
