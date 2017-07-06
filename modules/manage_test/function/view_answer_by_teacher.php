<!DOCTYPE html>
<html>
    
<?php
include("privilege.php");

if($result_view_id!=true)
{
    $message=Constants::NO_PRIVILEGE;
    echo "<script>alert('$message');window.location.href='../../login/functions/logout.php'</script>";
}
include("../../../Resources/Dashboard/header.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/StudentTest.php");
require_once("../classes/Test.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$teacher_id = $id;
$student_test = new StudentTest($dbConnect->getInstance());
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
                <li><a href="manage_test.php">List Of Test</a></li>
                <li><a href="view_result.php">Result</a></li>
                <li class="active"><b>View Answer</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Answer:</h3>
                    
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-8 col-md-offset-2">
                                <?php
                                if(isset($_REQUEST["test_id"]) && is_numeric($_REQUEST["marks"]) && isset($_REQUEST["student_id"])){
                                    $student_id = $_REQUEST["student_id"];
                                    if($student_test->checkValidTest($student_id,$_REQUEST["test_id"])) {
                                        $total_marks = 0 ;
                                        $result = $student_test->getTestAnswers($_REQUEST["test_id"], $student_id);
                                        if ($result != null) {
                                            $i = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<div class="row">'.
                                                        '<div class="col-md-1">'.
                                                            '<h4>Q' . $i . ')</h4> ' .
                                                        '</div>'.
                                                        '<div class="col-md-11 justify">'.
                                                            '<h4>'.$row["question"] .'</h4>'.
                                                        '</div>'.
                                                    '</div>'.
                                                    '<div class="row">'.
                                                        '<div class="col-md-12">'.
                                                            '<h4>'. ' Marks : ' . $row["marks"] . '</h4>'.
                                                        '</div>'.
                                                    '</div>';
                                                echo '<div class="row">'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 1)?('"fa fa-check" style="color:green;font-weight:bold">'):((($row["option_id"] == 1)?('"fa fa-close" style="color:red;font-weight:bold">'):('"">')))) . '1) ' . $row["option1"] . '</span>' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 2)?('"fa fa-check" style="color:green;font-weight:bold">'):((($row["option_id"] == 2)?('"fa fa-close" style="color:red;font-weight:bold">'):('"">')))) . '2) ' . $row["option2"] . '</span>&nbsp;&nbsp;&nbsp;' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 3)?('"fa fa-check" style="color:green;font-weight:bold">'):((($row["option_id"] == 3)?('"fa fa-close" style="color:red;font-weight:bold">'):('"">')))) . '3) ' . $row["option3"] . '</span>&nbsp;&nbsp;&nbsp;' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 4)?('"fa fa-check" style="color:green;font-weight:bold">'):((($row["option_id"] == 4)?('"fa fa-close" style="color:red;font-weight:bold">'):('"">')))) . '4) ' . $row["option4"] . '</span>'.
                                                        '</div>'.
                                                    '</div><hr>';
                                                $i++;
                                                if($row["answer"] == $row["option_id"]){
                                                    $total_marks += $row["marks"];
                                                }
                                            }
                                            echo '<div class="row">'.
                                                    '<div class="col-md-12">'.
                                                        '<h4>Marks Obtained : ' . $total_marks . ' out of ' . $_REQUEST["marks"].'</h4>'.
                                                    '</div>'.
                                                '</div>';
                                        } else {
                                            echo $test->parentPageRedirect("Error processing the request");
                                        }
                                    }else{
                                        echo $test->parentPageRedirect("Error processing the request");
                                    }
                                }else{
                                    echo $test->parentPageRedirect("Error processing the request");
                                }
                                ?>
                            </div>
                        </div>
                            
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
