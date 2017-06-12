<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../../manage_privilege/classes/Privilege.php");
require_once("../classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
?>

<html>
<head>
	<title>View Privileges</title>
</head>
<body>
	<?php
		$privilege=new Privilege($dbConnect->getInstance());

		$role_id=$_REQUEST['view'];
		$role=new Role($dbConnect->getInstance());

		$getRoleName=$role->getRole();
		if($getRoleName!=null)
		{
			while($row=$getRoleName->fetch_assoc())
			{
				$id=$row['id'];
				if($id==$role_id)
				{
					$role_name=$row['name'];break;
				}
			}

			echo "Privilege List:$role_name<br><br>";
		}

		$getPrivilegeRole=$privilege->getPrivilegeRole($role_id);

		if($getPrivilegeRole!=null)
		{
			while($row=$getPrivilegeRole->fetch_assoc())
			{
				$privilege_id=$row['privilege_id'];

			$getPrivilegeName=$privilege->getPrivilege(0,0);
			while($privilegeRow=$getPrivilegeName->fetch_assoc())
			{
				$id=$privilegeRow['id'];
				if($id==$privilege_id)
				{
					$privilege_name=$privilegeRow['name'];
					echo $privilege_name."<br>";
				}
			}

			}
		}
		else
		{
			echo "Nothing to show!";
		}
	?>
</body>
</html>