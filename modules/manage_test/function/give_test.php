<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/StudentTest.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$student_id = $id;
$test = new StudentTest($dbConnect->getInstance());
?>
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="manage_student_test.php">List Of Test</a></li>
                <li class="active"><b>Test</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Test:</h3>
                                
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-8 col-md-offset-2">
                                <form action="save_answer.php" method="post">
                                    <?php
                                    if(isset($_REQUEST["test_id"])){
                                        if(!$test->checkValidTest($student_id,$_REQUEST["test_id"])) {
                                            $result = $test->getTestQuestions($_REQUEST["test_id"], $student_id);
                                            if ($result != null) {
                                                ?>
                                                <input type="hidden" id="test_id" name="test_id" value=<? echo $_REQUEST["test_id"]; ?>>
                                                <?
                                                $i = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<div class="row">'.
                                                            '<div class="col-md-1">'.
                                                                '<h4>'.$i . '.</h4>'.
                                                            '</div>'.
                                                            '<div class="col-md-11 text-justify">'.
                                                                '<h4>'. $row["question"] .'</h4>'.
                                                            '</div>' .
                                                        '</div>' .
                                                        '<div class="row">'.
                                                            '<div class="col-md-12">'.
                                                                '<h4>Marks : ' . $row["marks"] . '</h4>'.
                                                            '</div>'.
                                                        '</div>';
                                                    echo '<div class="col-md-12">'.
                                                            '<div class="row">'.
                                                                '<div class="form-group">'.
                                                                    '<p>'.
                                                                        '<input type="radio" id="' . $row["id"] . '" name="' . $row["id"] . '" value="1" required>&nbsp;' . $row["option1"].
                                                                    '</p>';
                                                    
                                                                echo '<p>'.
                                                                        '<input type="radio" id="' . $row["id"] . '" name="' . $row["id"] . '" value="2" required>&nbsp;' . $row["option2"].
                                                                    '</p>';
                                                    
                                                                echo '<p>'.
                                                                        '<input type="radio" id="' . $row["id"] . '" name="' . $row["id"] . '" value="3" required>&nbsp;' . $row["option3"].
                                                                    '</p>';
                                                    
                                                                echo '<p>'.
                                                                        '<input type="radio" id="' . $row["id"] . '" name="' . $row["id"] . '" value="4" required>&nbsp;' . $row["option4"] . 
                                                                    '</p>';
                                                           echo '</div>'.
                                                            '</div>'.
                                                        '</div>';
                                                    
                                                    $i++;
                                                }
                                                echo '<div class="row"><center><button type="submit" class="btn btn-success"><span class="fa fa-check"></span>Submit</button></center></div>';
                                            } else {
                                                echo $test->parentRedirect("Error processing the request");
                                            }
                                        }else{
                                            echo $test->parentRedirect("Error processing the request");
                                        }
                                    }else{
                                        echo $test->parentRedirect("Error processing the request");
                                    }
                                    ?>
                                </form>
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
