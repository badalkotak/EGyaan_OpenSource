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

$user_id=$_REQUEST['edit'];

$getDetails=$user->getUser($user_id);

if($getDetails!=null)
{
	while($row=$getDetails->fetch_assoc())
	{
		$name=$row['name'];
		$gender=$row['gender'];
		$email=$row['email'];
		$mobile=$row['mobile'];
		$role_id=$row['role_id'];
		$user_id=$row['id'];
	}
}
?>

<html>
<head>
    <?php
    include "../../../Resources/Dashboard/header.php"
    ?>
	<title>Edit User | EGyaan</title>
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
   
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="../../login/functions/Dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="user.php">Manage Users</a></li>
                <li class="active"><b>Edit User</b></li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Manage User</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form role="form" action="update_user.php" method="post">
                                    <?php
                                        echo "<div class='form-group'>
                                        <label>Full Name</label><input type=text class='form-control' name=name id=name value='$name'></div>";

                                        if($gender=="M")
                                        {
                                            echo '<div class="form-group">
                                        <label>Gender</label><br><input type="radio" class="flat" name="gender" id="gender_M" value="M" checked="checked">Male
                                        <input type="radio" class="flat" name="gender" id="gender_F" value="F">Female</div>';
                                        }
                                        else
                                        {
                                            echo '<div class="form-group"><label>Gender:</label><label><input type="radio" class="flat" name="gender" id="gender_M" value="M">&nbsp;Male</label>
                                        <label><input type="radio" class="flat" name="gender" id="gender_F" value="F" checked="checked">&nbsp;Female</label>';
                                        }

                                        echo "<div class='form-group'><label>Email-Id</label><input class='form-control' type=email name=email id=email value='$email'></div>";
                                        echo "<div class='form-group'><label>Mobile No.</label><input class='form-control' type=text name=mobile id=mobile value='$mobile'></div>";
                                        echo '<div class="form-group"><label>Role</label><select class="form-control select2" name="role_id" id="role_id">
                                        <option value="-1" disabled>Select Role</option>';
                                            $getRoles=$role->getRole();

                                            if($getRoles!=null)
                                            {
                                                while($row=$getRoles->fetch_assoc())
                                                {
                                                    $id=$row['id'];
                                                    $role_name=$row['name'];

                                                    if($role_id==$id)
                                                        echo "<option value='$id' selected>$role_name</option>";
                                                    else
                                                        echo "<option value='$id'>$role_name</option>";
                                                }
                                            }
                                            echo "</select></div>";

                                        ?>

                                        <?php
                                            echo "<button class='btn btn-success' type=submit value='$user_id' name=submit id=submit><i class='fa fa-check'></i>&nbspUpdate</button>";
                                        ?>
                                        <div id="user_err"></div>
                                    </form>
                                </div>
                            </div>
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