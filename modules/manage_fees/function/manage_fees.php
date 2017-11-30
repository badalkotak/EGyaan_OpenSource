<html>
<body>
    <?php
    include("privilege.php");
if($fee!=true)
{
    $message=Constants::NO_PRIVILEGE;
    echo "<script>alert('$message');window.location.href='../../login/functions/logout.php'</script>";
}
    include("../../../Resources/Dashboard/header.php");
    ?>
    <?php
    require_once("../../../classes/Constants.php");
    require_once("../../../classes/DBConnect.php");
    require_once("../classes/Fees.php");
    $dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);
        ?>
    
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
                        <a href="../../manage_branch/function/branch.php">
                            <i class="fa  fa-sitemap"></i> <span>Manage Branch</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_batch/function/batch.php">
                            <i class="fa fa-users"></i> <span>Manage Batch</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_course/function/course.php">
                            <i class="fa fa-book"></i> <span>Manage Course</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_user/functions/user.php">
                            <i class="fa fa-user"></i> <span>Manage Users</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_student/function/student.php">
                            <i class="fa fa-graduation-cap"></i> <span>Manage Students</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_role/functions/role.php">
                            <i class="fa fa-user"></i> <span>Manage Role</span>
                        </a>
                    </li>
                    <li class="treeview active">
                        <a href="../../manage_fees/function/manage_fees.php">
                            <i class="fa fa-file-text-o"></i> <span>Manage Fees</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="../../manage_noticeboard/function/index.php">
                            <i class="fa fa-calendar-minus-o"></i> <span>Noticeboard</span>
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
                <li class="active"><b>Manage Fees</b></li>
            </ol>
        </section>

        <?php
$user_id = 1; //To Do: Change This
if(isset($_REQUEST["message"]) && !empty(trim($_REQUEST["message"]))){
    echo "<script> alert('" . $_REQUEST["message"] . "');</script>";
    echo "<noscript>" . $_REQUEST["message"] . "</noscript>";
}
$fees = new Fees($dbConnect->getInstance());
$result=$fees->getStudentList();
if($result!=null)
{
    ?>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Manage Fees</h3>
          </div>
          <div class="box-body">
            <div class="table-container1">
                <table class="table table-bordered table-hover example2">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Total Fees</th>
                            <th>Fees paid</th>
                            <th>Fees pending</th>
                            <th>Date of admission</th>
                            <th>Contact parent</th>
                            <th>Add amount</th>
                            <th>Refund</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        while($row=$result->fetch_assoc())
                        {
                            $pending_fees = $row["total_fees"] - $row["fees_paid"];
                            $input_fees ='<input type="number" id="fees_add_input_' . $row["id"] . '" value="0" min=1 max=' . $pending_fees . '>
                            <br><br>
                            <button type="button" class="btn btn-primary btn-sm" onclick="add_fees(' . $row["id"] . ',' . $pending_fees . ')"><i class="fa fa-plus"></i>&nbspAdd fees</button>';
                            $refund_fees ='<input type="number" id="fees_refund_input_' . $row["id"] . '" value="0" min=1 max=' . $row["fees_paid"] . '><br><br>
                            <button type="button" class="btn btn-warning btn-sm" onclick="refund_fees(' . $row["id"] . ',' . $row["fees_paid"] . ')"><i class="fa fa-exchange"></i>&nbspRefund</button>';
                            echo '  <tr id =' . $row["id"] . '>
                            <td>' . $i . '</td>
                            <td>' . $row["firstname"] . ' ' . $row["lastname"] . '</td>
                            <td>' . $row["email"]  . '</td>
                            <td>' . $row["mobile"]  . '</td>
                            <td>' . $row["total_fees"]  . '</td>
                            <td>' . $row["fees_paid"]  . '</td>
                            <td>' . $pending_fees . '</td>
                            <td>' . $row["date_of_admission"] . '</td>
                            <td>' . $row["parent_mobile"] . '</td>
                            <td>' . (($pending_fees > 0)?$input_fees:'Fees paid') . '</td>
                            <td>' . (($row["fees_paid"] > 0)?$refund_fees:'NA') . '</td>
                        </tr>';
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
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
<script>
    function add_fees(id,pending_fees) {
        var fees_input = parseInt(document.getElementById("fees_add_input_" + id).value);
        if(isNaN(fees_input)){
            fees_input = parseInt(0);
        }
        var temp_fees = pending_fees - fees_input;
        if(temp_fees >= 0 && fees_input>0){
            if (confirm("Do you want to proceed?") == true) {
                document.location = "add_fees.php?id="+id+"&fees_input="+fees_input;
            } else {}
        }else{
            alert("The amount of fees to be added should be less than/equal to the pending fees and greater than 0.");
        }
    }
    function refund_fees(id,paid_fees) {
        var fees_input = parseInt(document.getElementById("fees_refund_input_" + id).value);
        if(isNaN(fees_input)){
            fees_input = parseInt(0);
        }
        var temp_fees = paid_fees - fees_input;
        if(temp_fees >= 0 && fees_input>0){
            if (confirm("Do you want to proceed?") == true) {
                document.location = "refund_fees.php?id="+id+"&fees_input="+fees_input;
            } else {}
        }else{
            alert("The amount of fees to be refunded should be less than/equal to the paid fees and greater than 0.");
        }
    }
</script>
<?php
}
else
{
    echo "No student added yet!!";
}
?>
<?php
include("../../../Resources/Dashboard/footer.php");

?>
</body>
</html>