<!DOCTYPE html>
<html>
<?php
include("../../../Resources/sessions.php");
include("../../../Resources/Dashboard/header.php");
    $user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/TimeTimetable.php");
require_once("../classes/TimeType.php");
$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);
$timetimetable=new TimeTimetable($dbconnect->getInstance());
?>
<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Hello!<small>User</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li class="active"><b>Add Time</b></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Insert Time</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="insert_time_timetable.php" method="post">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>From :</label>
                                        <div class="input-group">
                                            <input type="text" name="from_time" class="form-control timepicker">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>To :</label>
                                        <div class="input-group">
                                            <input type="text" name="to_time" class="form-control timepicker">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $timetype=new TimeType($dbconnect->getInstance());
                                ?>
                                
                                <div class="form-group">
                                    <select name="type" class="form-control select2" style="width: 100%;">
                                        <option value="0" selected="selected">Select</option>
                                        <?php
                                        $result=$timetype->getTimeType(0);
                                        if($result!=null)
                                        {
                                            $i=1;
                                            while($row=$result->fetch_assoc())
                                            {
                                                echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" name="submit"><span class="fa fa-check"></span>Submit</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                             <h4>Lectures Time:</h4>
                            <div class="table-container1">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>From Time</th>
                                            <th>To Time</th>
                                            <th>Type Time</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result=$timetimetable->getTimeTimetable(0);
                                        if($result!=null)
                                        {
                                            $i=1;
                                            while($row=$result->fetch_assoc())
                                            { 
                                                echo '<tr><td>'.$i.'</td><td>'.$row['from_time'].'</td><td>'.$row['to_time'].'</td>';
                                                $result_type=$timetype->getTimeType($row['type']);
                                                {
                                                    if($result != null)
                                                    {
                                                        while($row_type=$result_type->fetch_assoc())
                                                        {
                                                            $time_type=$row_type['name'];
                                                        }
                                                    }
                                                }
                                                echo '<td>'.$time_type.'</td>
                                                <td><a href=delete_time_timetable.php?id='.$row['id'].' onclick="ConfirmDelete()" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span>Delete</a></td></tr>';
                                                $i=$i+1;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    include("../../../Resources/Dashboard/footer.php");
    ?>
    <script type="text/javascript">
        function ConfirmDelete()
        {
            confirm("Are you sure you want to delete it ?")
        }
    </script>
    </body>
</html>
