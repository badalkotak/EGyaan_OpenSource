<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
?>

<html>
<head>
    <?php
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Manage Role | EGyaan</title>
    <script src="../../../Resources/jquery.min.js"></script>
    <script>

        $(document).ready(function () {

            $("#submit").click(function () {
                var role_name = $("#role_name").val();

                if (role_name == "") {
                    var alert_icon = document.createElement('i');
                    alert_icon.setAttribute('class', 'fa fa-exclamation-triangle');
                    $("#role_err").html(alert_icon).append("&nbsp;Please Enter the Name of the Role");
                    return false;
                }
                else {
                    $("#role_err").text("");
                }
            });

        });
    </script>

    <script>
        function del_confirm() {
            var x;
            if (confirm("Are you sure you want to delete it ?") == true) {

            } else {
                event.preventDefault();
            }
            //document.getElementById("demo").innerHTML = x;
        }

    </script>
</head>
<body>
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
                    <li class="treeview active">
                        <a href="../../manage_role/functions/role.php">
                            <i class="fa fa-user"></i> <span>Manage Role</span>
                        </a>
                    </li>
                    <li class="treeview">
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
                <li class="active"><b>Manage Roles</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Manage Roles</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form role="form" action="add_role.php" method="post" id="role">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="role_name" id="role_name" placeholder="Enter Role Name">
                                        </div>
                                        <div class="alert-message" id="role_err"></div>
                                        <div class="form-group">
                                            <input type="checkbox" class="flat" name="isTeacher" value=1>&nbsp;Is Teacher<br>
                                        </div>
                                        <button class="btn btn-primary" type="submit" value="Add Role" id="submit"><i
                                                    class="fa fa-plus"></i>&nbsp;Add Role
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                
                                    <?php
                                    $i = 0;

                                    $roles = new Role($dbConnect->getInstance());
                                    $getRoles = $roles->getRole();

                                    if ($getRoles != null) {
                                        echo "<h3 class='box-title'>Roles:</h3>";
                                        echo "<div class='table-container1'><table class='table table-bordered table-hover example2'>
                        <thead>
                            <th>Sr No</th>
                            <th>Role</th>
                            <th>Is Teacher</th>
                            <th>Assign Privilege</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>View Privilege</th>
                        </thead>
                        <tbody>";
                                        while ($row = $getRoles->fetch_assoc()) {
                                            $i++;
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $isTeacher = $row['is_teacher'];

                                            echo "<tr>";

                                            echo "<td>";
                                            echo $i;
                                            echo "</td>";

                                            echo "<td>";
                                            echo $name;
                                            echo "</td>";

                                            echo "<td>";
                                            if ($isTeacher == 1) {
                                                echo "Yes";
                                            } else {
                                                echo "No";
                                            }

                                            echo "</td>";

                                            echo "<td>";
                                            if ($id == Constants::ROLE_STUDENT_ID || $id == Constants::ROLE_PARENT_ID || $id == Constants::ROLE_TEACHER_ID || $id == Constants::ROLE_ADMIN_ID) {
                                                echo "Privileges for this role cannot be updated!";
                                            } else {
                                                echo "<form role='form' action=assign_privilege.php method=post><button class='btn btn-default btn-sm' type=submit name=assign value='$id'>Assign</form>";
                                            }
                                            echo "</td>";

                                            echo "<td>";
                                            if ($id == Constants::ROLE_STUDENT_ID || $id == Constants::ROLE_PARENT_ID || $id == Constants::ROLE_TEACHER_ID || $id == Constants::ROLE_ADMIN_ID) {
                                                echo "Cannot be edited!";
                                            } else {
                                                echo "<form role='form' action=edit_role.php method=post><button class='btn btn-primary btn-sm' type=submit name=edit value='$id'><i class='fa fa-pencil'></i>&nbsp;Edit</button></form>";
                                            }
                                            echo "</td>";

                                            echo "<td>";
                                            if ($id == Constants::ROLE_STUDENT_ID || $id == Constants::ROLE_PARENT_ID || $id == Constants::ROLE_TEACHER_ID || $id == Constants::ROLE_ADMIN_ID) {
                                                echo "Cannot be deleted!";
                                            } else {
                                                echo "<form role='form' action=delete_role.php method=post><button class='btn btn-danger btn-sm' type=submit name=delete id=delete value='$id' onclick=del_confirm()><i class='fa fa-trash'></i>&nbsp;Delete</button></form>";
                                            }
                                            echo "</td>";

                                            echo "<td>";
                                            echo "<form role='form' action=view_privilege.php method=post><button class='btn btn-primary btn-sm' type=submit name=view id=view value='$id'><i class='fa fa-eye'></i>&nbsp;View</button></form>";
                                            echo "</td>";

                                            echo "</tr>";
                                        }
                                        echo "</tbody></table></div>";
                                    } else {
                                        echo "No Records";
                                    }
                                    ?>
                                </div>
                            </div>
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
