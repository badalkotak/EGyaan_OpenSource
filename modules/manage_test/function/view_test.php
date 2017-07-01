<!DOCTYPE html>
<html>
<body>
<?php
ob_start();
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
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>View Test</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title">View Test:</h3>
                            <hr>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-8 col-md-offset-2">
                                <?php
                                if(isset($_REQUEST["id"]) && isset($_REQUEST["type"])){
                                    if($_REQUEST["type"] == 'F'){
                                        if(file_exists("offline_test/" . $_REQUEST["id"] . ".pdf")){
                                            ob_clean();
                                            header("Location: offline_test/" . $_REQUEST["id"] . ".pdf");
                                        }else{
                                            $test->parentPageRedirect("Error processing request");
                                        }
                                    }elseif($_REQUEST["type"] == 'O'){
                                        $result = $test->getTestQuestions($_REQUEST["id"]);
                                        if($result != null){
                                            $total_marks = 0 ;
                                            $i = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<div class="row">'.
                                                            '<div class="col-md-1">'.
                                                                '<h4>Q' . $i . ') </h4>' .
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
                                                echo '<div class="row">'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 1)?('"fa fa-check" style="color:green;font-weight:bold">'):('"">')) . '1) ' . $row["option1"] . '</span>' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 2)?('"fa fa-check" style="color:green;font-weight:bold">'):('"">')) . '2) ' . $row["option2"] . '</span>' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 3)?('"fa fa-check" style="color:green;font-weight:bold">'):('"">')) . '3) ' . $row["option3"] . '</span>' .
                                                        '</div>'.
                                                        '<div class="col-md-6">'.
                                                            '<span class=' . (($row["answer"] == 4)?('"fa fa-check" style="color:green;font-weight:bold">'):('"">')) . '4) ' . $row["option4"] . '</span>'.
                                                        '</div>'.
                                                    '</div><hr>';
                                                
                                                    
                                                $i++;
                                                $total_marks += $row["marks"];
                                            }
                                            echo '<div class="row">'.
                                                    '<div class="col-md-12">'.
                                                        '<h4>Total marks : ' . $total_marks.'</h4>'.
                                                    '</div>'.
                                                '</div>';
                                        }else{
                                            ob_clean();
                                            $test->parentPageRedirect("Error processing request");
                                        }
                                    }else{
                                        ob_clean();
                                        $test->parentPageRedirect("Error processing request");
                                    }
                                }else{
                                    ob_clean();
                                    $test->parentPageRedirect("Error processing request");
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
