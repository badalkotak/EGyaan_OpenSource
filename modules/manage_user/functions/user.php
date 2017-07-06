<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/User.php");
require_once("../../manage_role/classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$role=new Role($dbConnect->getInstance());
$user=new User($dbConnect->getInstance());
?>

<html>
<head>
    <?php
    include "../../../Resources/Dashboard/header.php"
    ?>
<title>Manage Users | EGyaan</title>

<script src="../../../Resources/jquery.min.js"></script>
<script>
		
		$(document).ready(function(){
			$("#submit").click(function(){
				var name=$("#name").val();
				var email=$("#email").val();
				var mobile=$("#mobile").val();
				var role_id=$("#role_id").val();

				if(name=="" || email=="" || mobile=="" || role_id==-1)
				{
					$("#user_err").text("Please input all the fields!");
					return false;
				}
				else
				{
					$("#user_err").text("");
				}
			});
		});
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
    
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active"><b>Manage Users</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Manage User</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

	<form class="role" action=add_user.php method=post>
        <div class="form-group">
        <label>Full Name</label>
		<input type="text" class="form-control" name="name" id="name">
        </div>
        <div class="form-group">
        <label>Gender</label><br>
        <input type="radio" class="flat" name="gender" id="gender_M" value="M" checked="checked">Male
		<input type="radio" class="flat" name="gender" id="gender_F" value="F">Female
        </div>
        <div class="form-group">
        <label>Email-Id</label>
		<input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="form-group">
        <label>Mobile No.</label>
		<input type="text" class="form-control" name="mobile" id="mobile">
        </div>
        <div class="form-group">
        <label>Role</label>
		<select name="role_id" class="form-control" id="role_id">
		<option value="-1">Select Role</option>
		<?php
			$getRoles=$role->getRole();

			if($getRoles!=null)
			{
				while($row=$getRoles->fetch_assoc())
				{
					$id=$row['id'];
					$role_name=$row['name'];

					echo "<option value='$id'>$role_name</option>";
				}
			}
		?>
		</select>
        </div>
        <button type="submit" class="btn btn-primary" value="Add Student" id="submit"><i class="fa fa-plus"></i>&nbspAdd</button>
		<div id="user_err"></div>
	</form><hr>

	
		<?php
			$getUsers=$user->getUser(0);
			$i=0;

			if($getUsers!=null)
			{
			    echo "<div class='box-header'>
                            <h3 class='box-title'><b>Users</b></h3>
                        </div>";
				echo "<table class='table table-bordered table-hover example2'>
	<thead>
		<th>Sr No.</th>
		<th>Name</th>
		<th>Gender</th>
		<th>Email</th>
		<th>Mobile</th>
		<th>Role</th>
		<th>Assign Courses</th>
		<th>Edit</th>
		<th>Delete</th>
	</thead>
	<tbody>";
				while($row=$getUsers->fetch_assoc())
				{
					$i++;
					$user_id=$row['id'];
					$name=$row['name'];
					$gender=$row['gender'];
					if($gender=="M")
					{	
						$gender="Male";
					}
					else
					{
						$gender="Female";
					}
					$email=$row['email'];
					$mobile=$row['mobile'];
					$role_id=$row['role_id'];

					$getRole=$role->getRole();
					if($getRole!=null)
					{
						while($roleRow=$getRole->fetch_assoc())
						{
							$id=$roleRow['id'];
							if($id==$role_id)
							{
								$role_name=$roleRow['name'];
								break;
							}
						}
					}
					else
					{
						$role_name="No role";
					}

					echo "<tr>";

					echo "<td>";
					echo $i;
					echo "</td>";

					echo "<td>";
					echo $name;
					echo "</td>";

					echo "<td>";
					echo $gender;
					echo "</td>";

					echo "<td>";
					echo $email;
					echo "</td>";

					echo "<td>";
					echo $mobile;
					echo "</td>";

					echo "<td>";
					echo $role_name;
					echo "</td>";

					echo "<td>";
					if($role_id==Constants::ROLE_TEACHER_ID)
					{
						echo "<form role='form' action=../../manage_teacher_course/functions/assign_course.php method=post><button class='btn btn-default' type=submit name=user_id value=$user_id>Assign</button></form>";
					}
					else
					{
						echo "We can assign a course only to a Teacher";
					}
					echo "</td>";

					echo "<td>";
					echo "<form role='form' action=edit_user.php method=post><button class='btn btn-primary' type=submit name=edit value=$user_id><i class='fa fa-pencil'></i>&nbspEdit</button></form>";
					echo "</td>";

					echo "<td>";
					echo "<form action=delete_user.php method=post><button class='btn btn-danger' type=submit name=delete value=$user_id><i class='fa fa-trash'></i>&nbspDelete</button></form>";
					echo "</td>";

					echo "</tr>";
				}

				echo "</tbody>
	</table>";
			}
			else
			{
				echo "No users added yet";
			}
		?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
include "../../../Resources/Dashboard/footer.php"
?>
</body>
</html>