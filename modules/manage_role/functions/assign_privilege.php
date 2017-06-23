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
echo "Assign Privilege:<br>";
if($getPrivileges!=null)
{
	$i=0;
	echo "<form action=assign_privilege_role.php method=post>";
	while($row=$getPrivileges->fetch_assoc())
	{
		$privilege_id=$row['id'];
		$privilege_name=$row['name'];
		$i++;

		$checkPrivilegeRole=$privilege->getPrivilege($role_id,$privilege_id);

		if($checkPrivilegeRole!=null)
		{
			echo "<input type=checkbox name=c$i value='$privilege_id' checked> $privilege_name<br>";
		}
		else
		{
			echo "<input type=checkbox name=c$i value='$privilege_id'> $privilege_name<br>";
		}
	}
	echo "<input type=submit value=$role_id name=role_id>";
	echo "</form>";
}
?>