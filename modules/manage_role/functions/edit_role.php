<html>
<head>
    <?php
    include "../../../Resources/Dashboard/header.php"
    ?>
    <title>Edit Roles | EGyaan</title>
</head>
<body>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <br>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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

	echo "<form role='form' action=update_role.php method=post><div class='form-group'><label>Role Name</label><input type=text class='form-control' value='$role_name' id=role_name name=role_name></div><br><div id=role_err></div><div class='form-group'><label>Is Teacher : $isTeacher</label></div><button class='btn btn-primary' type=submit value=$role_id name=edit id=submit><i class='fa fa-pencil'></i>&nbsp;Edit</button></form>";
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
</div>
<?php
include "../../../Resources/Dashboard/footer.php"
?>
</body>
</html>