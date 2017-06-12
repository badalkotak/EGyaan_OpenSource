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

	echo "<form action=update_role.php method=post><input type=text value='$role_name' id=role_name name=role_name><br><div id=role_err></div><br>Is Teacher: $isTeacher<br><input type=submit value=$role_id name=edit id=submit></form>";
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