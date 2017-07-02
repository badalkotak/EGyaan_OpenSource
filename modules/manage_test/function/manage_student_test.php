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
if(isset($_REQUEST["message"]) && !empty(trim($_REQUEST["message"]))){
    echo $_REQUEST["message"];
}
$test = new StudentTest($dbConnect->getInstance());
$result=$test->getTests($student_id);
?>
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>List Of Test</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List Of Test:</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-container1">
                                <?php
                                if($result!=null)
                                {
                                    ?>
                                    <table  id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Title</th>
                                                <th>Date of Test</th>
                                                <th>Type</th>
                                                <th>Course name</th>
                                                <th>Marks Obtained</th>
                                                <th>Out of</th>
                                                <th>Give Test</th>
                                                <th>View Answers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?
                                        $i=1;
                                        while($row=$result->fetch_assoc())
                                        {
                                            echo '  <tr id =' . $row["id"] . '>
                                                    <td>' . $i . '</td>
                                                    <td>' . $row["title"] . '</td>
                                                    <td>' . $row["date_of_test"]  . '</td>
                                                    <td>' . (($row["type"] == 'O')?'Online':'Offline') . '</td>
                                                    <td>' . $row["name"]  . '</td>
                                                    <td>' . $row["marks"] . '</td>
                                                    <td>' .  $row["total_marks"]  . '</td>
                                                    <td>' . (($row["type"] == 'O')?(($row["marks"]=="-")?'<a href="give_test.php?test_id=' . $row["id"] . '" class="btn btn-success btn-sm">Start</a>':'Submitted'):'NA') . '</td> 
                                                    <td>' . (($row["type"] == 'O')?(($row["marks"]=="-")?'-':'<a
                                                    class="btn btn-primary btn-sm" href="view_answer.php?test_id=' . $row["id"] . '&marks=' .  $row["total_marks"]  . '"><span class="fa fa-table"></span> View</a>'):'NA') . '</td> 
                                                  </tr>';
                                            $i++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?
                                }
                                else
                                {
                                    echo "No Test added yet!!";
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
