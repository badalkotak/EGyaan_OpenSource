<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$teacher_id = $id;
$test = new Test($dbConnect->getInstance());
?>
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="manage_test.php">List of Test</a></li>
                <li class="active"><b>Result</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Result:</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-container1">
                                <?php
                                if(isset($_REQUEST["id"]) && isset($_REQUEST["type"]) && isset($_REQUEST["marks"])){
                                    if($test->checkMarksEntered($_REQUEST["id"],"edit")) {
                                        $result = $test->getStudentList($_REQUEST["id"], $teacher_id,$_REQUEST["type"]);
                                        if ($result != null) {
                                            ?>
                                            <table id="example2" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Marks</th>
                                                    <? echo ($_REQUEST["type"] == "O")?'<th>View</th>':''; ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                while ($row = $result->fetch_assoc()) {
                                                    $answer_page = '<td><a class="btn btn-primary btn-sm" href="view_answer_by_teacher.php?student_id=' . $row["id"] . '&test_id=' . $_REQUEST["id"] . '&marks='. $_REQUEST["marks"] . '"><span class="fa fa-eye"></span> View</a></td>';
                                                    echo '<tr>
                                                    <td>' . $row["firstname"] . ' ' . $row["lastname"] . '</td>
                                                    <td>' . $row["marks"] . ' out of  ' . $row["total_marks"] . '</td>'
                                                    . (($_REQUEST["type"] == "O")?($answer_page):('')) .
                                                  '</tr>';
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <?
                                        } else {
                                            echo $test->parentPageRedirect("Error processing request");
                                        }
                                    }else{
                                        echo $test->parentPageRedirect("Marks not entered/Error processing request");
                                    }
                                }else{
                                    echo $test->parentPageRedirect("Error processing request");
                                }
                                ?>
                                
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!--end of Table box-->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php
    include("../../../Resources/Dashboard/footer.php");
?>
    </body>
</html>
