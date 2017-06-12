<?php

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
<title>Manage Roles</title>
<script src="../../../Resources/jquery.min.js"></script>
<script>
		
		$(document).ready(function(){
			
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

		<script>
	function del_confirm() {
		var x;
		if (confirm("Are you sure you want to delete it ?") == true) {

		} else {
			event.preventDefault() ;
		}
    //document.getElementById("demo").innerHTML = x;
}

</script>
</head>
<body>
	Manage Roles: <br><br>

	<form action="add_role.php" method="post" id="role">
		<input type="text" name="role_name" id="role_name"><br><br><div id="role_err"></div>
		<input type="checkbox" name="isTeacher" value=1>Is Teacher<br><br>
		<input type="submit" value="Add Role" id="submit">
	</form>

		<?php
			$i=0;

			$roles=new Role($dbConnect->getInstance());
			$getRoles=$roles->getRole();

			if($getRoles!=null)
			{
				echo "<table border=5>
				<thead>
					<th>Sr No.</th>
					<th>Role</th>
					<th>Is Teacher</th>
					<th>Assign Privilege</th>
					<th>Edit</th>
					<th>Delete</th>
					<th>View Privilege</th>
				</thead>
				<tbody>";
				while($row=$getRoles->fetch_assoc())
				{
					$i++;
					$id=$row['id'];
					$name=$row['name'];
					$isTeacher=$row['is_teacher'];

					echo "<tr>";

					echo "<td>";
					echo $i;
					echo "</td>";

					echo "<td>";
					echo $name;
					echo "</td>";

					echo "<td>";
					if($isTeacher==1)
					{
						echo "Yes";
					}
					else
					{
						echo "No";
					}
					
					echo "</td>";

					echo "<td>";
					if($id==Constants::ROLE_STUDENT_ID || $id==Constants::ROLE_PARENT_ID || $id==Constants::ROLE_TEACHER_ID)
					{
						echo "Privileges for this role cannot be updated!";
					}
					else
					{
						echo "<form action=assign_privilege.php method=post><input type=submit name=assign value='$id'></form>";
					}
					echo "</td>";

					echo "<td>";
					if($id==Constants::ROLE_STUDENT_ID || $id==Constants::ROLE_PARENT_ID || $id==Constants::ROLE_TEACHER_ID)
					{
						echo "Cannot be edited!";
					}
					else
					{
						echo "<form action=edit_role.php method=post><input type=submit name=edit value='$id'></form>";	
					}
					echo "</td>";

					echo "<td>";
					if($id==Constants::ROLE_STUDENT_ID || $id==Constants::ROLE_PARENT_ID || $id==Constants::ROLE_TEACHER_ID)
					{
						echo "Cannot be deleted!";
					}

					else
					{
						echo "<form action=delete_role.php method=post><input type=submit name=delete id=delete value='$id' onclick=del_confirm()></form>";
					}
					echo "</td>";

					echo "<td>";
					echo "<form action=view_privilege.php method=post><input type=submit name=view id=view value='$id'></form>";
					echo "</td>";

					echo "</tr>";
				}
				echo "</tbody></table>";
			}
			else
			{
				echo "No Records";
			}
		?>


</body>