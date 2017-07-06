<!DOCTYPE html>
<html>
<?php
include("privilege.php");

if($result_add_id!=true)
{
    $message=Constants::NO_PRIVILEGE;
    echo "<script>alert('$message');window.location.href='../../login/functions/logout.php'</script>";
}
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
                <li><a href="manage_test.php">List Of Test</a></li>
                <li class="active"><b>Insert Marks</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!--start of Table box-->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Insert Marks:</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="save_offline_test_marks.php" method="post">
                                    <?php
                                    if(isset($_REQUEST["id"]) && isset($_REQUEST["action"]))
                                    {
                                        if($test->checkMarksEntered($_REQUEST["id"],$_REQUEST["action"])) 
                                        {
                                            $result = $test->getStudentList($_REQUEST["id"], $teacher_id,'F');
                                            if ($result != null) 
                                            {
                                                ?>
                                                <input type="hidden" name="test_id" value="<? echo $_REQUEST["id"]; ?>">
                                                <input type="hidden" name="action" value="<? echo $_REQUEST["action"]; ?>">
                                                <table id="example2" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Marks</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<tr>
                                                            <td>' . $row["firstname"] . ' ' . $row["lastname"] . '</td>
                                                            <td><input class="form-control" type="number" name="' . $row["id"] . '" value="' . (($row["marks"] != NULL) ? $row["marks"] : '0') . '" min="1" max="' . $row["total_marks"] . '" required> out of ' . $row["total_marks"] . '</td>
                                                          </tr>';
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Save</button>
                                                <?
                                            } else {
                                                echo $test->parentPageRedirect("Error processing request");
                                            }
                                        }else{
                                            echo $test->parentPageRedirect("Error processing request");
                                        }
                                    }else{
                                        echo $test->parentPageRedirect("Error processing request");
                                    }
                                    ?>
                                    
                                
                            </form>
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
