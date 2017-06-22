<?php
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

<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
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
	<form action="update_user.php" method="post">
	<?php
		echo "<input type=text name=name id=name placeholder='Full Name' value='$name'><br><br>";

		if($gender=="M")
		{
			echo '<input type="radio" name="gender" id="gender_M" value="M" checked="checked">Male
		<input type="radio" name="gender" id="gender_F" value="F">Female<br><br>';
		}
		else
		{
			echo '<input type="radio" name="gender" id="gender_M" value="M">Male
		<input type="radio" name="gender" id="gender_F" value="F" checked="checked">Female<br><br>';
		}
		
		echo "<input type=email name=email id=email placeholder=Email value='$email'><br><br>";
		echo "<input type=text name=mobile placeholder=Mobile id=mobile value='$mobile'><br><br>";
		echo '<select name="role_id" id="role_id">
		<option value="-1">Select Role</option>';
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
		?>
		</select><br><br>
		<?php
			echo "<input type=submit value='$user_id' name=submit id=submit><br><br>";
		?>
		<div id="user_err"></div>
	</form>
</body>
</html>