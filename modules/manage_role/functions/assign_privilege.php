<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Assign Roles | EGyaan</title>
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
                <li><a href="role.php">Manage Roles</a></li>
                <li class="active"><b>Assign Roles</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Assign Roles</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Role.php");
require_once("../../manage_privilege/classes/Privilege.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$role_id=$_REQUEST['assign'];

if($role_id==Constants::ROLE_STUDENT_ID || $role_id==Constants::ROLE_PARENT_ID || $role_id==Constants::ROLE_TEACHER_ID)
{
	echo "<script>alert('You cannot change the privileges for Role: Student, Teacher, Parent!');window.location.href='role.php';</script>";
}

$privilege = new Privilege($dbConnect->getInstance());

$getPrivileges=$privilege->getPrivilege(0,0);
if($getPrivileges!=null)
{
	$i=0;
	echo "<form role='form' action=assign_privilege_role.php method=post>";
	while($row=$getPrivileges->fetch_assoc())
	{
		$privilege_id=$row['id'];
		$privilege_name=$row['name'];
		$i++;

		$checkPrivilegeRole=$privilege->getPrivilege($role_id,$privilege_id);

		if($checkPrivilegeRole!=null)
		{
			echo "<div class='form-group'><input type=checkbox name=c$i value='$privilege_id' checked> $privilege_name</div>";
		}
		else
		{
			echo "<div class='form-group'><input type=checkbox name=c$i value='$privilege_id'> $privilege_name</div>";
		}
	}
	echo "<button class='btn btn-success' type=submit value=$role_id name=role_id><i class='fa fa-check'></i>&nbsp;Assign</button>";
	echo "</form>";
}
?>
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

