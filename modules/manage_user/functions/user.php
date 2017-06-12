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
?>

<html>
<head>
<title>Manage Users</title>

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
	Manage Users:<br><br>

	<form action=add_user.php method=post>
		<input type="text" name="name" id="name" placeholder="Full Name"><br><br>
		<input type="radio" name="gender" id="gender_M" value="M" checked="checked">Male
		<input type="radio" name="gender" id="gender_F" value="F">Female<br><br>
		<input type="email" name="email" id="email" placeholder="Email"><br><br>
		<input type="text" name="mobile" placeholder="Mobile" id="mobile"><br><br>
		<select name="role_id" id="role_id">
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
		</select><br><br>
		<input type="submit" value="Add Student" id="submit"><br><br>
		<div id="user_err"></div>
	</form>

	
		<?php
			$getUsers=$user->getUser();
			$i=0;

			if($getUsers!=null)
			{
				echo "<table>
	<thead>
		<th>Sr No.</th>
		<th>Name</th>
		<th>Gender</th>
		<th>Email</th>
		<th>Mobile</th>
		<th>Role</th>
	</thead>
	<tbody>";
				while($row=$getUsers->fetch_assoc())
				{
					$i++;
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
	
</body>
</html>