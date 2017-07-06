<html>
<head>
    <?php
    include("../../../Resources/sessions.php");
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Edit Roles | EGyaan</title>
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
                <li class="active"><b>Edit Roles</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Edit Roles</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$role_id=$_REQUEST['edit'];

$role = new Role($dbConnect->getInstance());

$getRole=$role->getRole();

if($getRole!=null)
{
	while($row=$getRole->fetch_assoc())
	{
		$id=$row['id'];
		if($id===$role_id)
		{
			$role_name=$row['name'];
			$isTeacher=$row['is_teacher'];
			if($isTeacher===1)
			{
				$isTeacher="Yes";
			}
			else
			{
				$isTeacher="No";
			}
			break;
		}
	}

	echo "<form role='form' action=update_role.php method=post><div class='form-group'><label>Role Name</label><input type=text class='form-control' value='$role_name' id=role_name name=role_name></div><br><div id=role_err></div><div class='form-group'><label>Is Teacher : $isTeacher</label></div><button class='btn btn-primary' type=submit value=$role_id name=edit id=submit><i class='fa fa-pencil'></i>&nbsp;Update</button></form>";
}
else
{
	echo "No such role available!";
}
?>
<script src="../../../Resources/jquery.min.js"></script>
<script>
		
		$(document).ready(function(){

		// $("#role").submit(function(event){
		// event.preventDefault();
		// });

		$("#submit").click(function(){
		var role_name=$("#role_name").val();

		if(role_name=="")
		{
			$("#role_err").text("Please enter the Name of the Role");
			return false;
		}
		else
		{
			$("#role_err").text("");
		}
	});

});
		</script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php
include "../../../Resources/Dashboard/footer.php"
?>
</body>
</html>