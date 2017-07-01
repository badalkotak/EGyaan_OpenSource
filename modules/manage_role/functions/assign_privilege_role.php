<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Role.php");
require_once("../../manage_privilege/classes/Privilege.php");

error_reporting(0);
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$role_id=$_REQUEST['role_id'];

$privilege=new Privilege($dbConnect->getInstance());
$role=new Role($dbConnect->getInstance());
$count=0;

$getPrivilegeCount=$privilege->getPrivilege(0,0);
if($getPrivilegeCount!=null)
{
	while($row=$getPrivilegeCount->fetch_assoc())
	{
		$count++;
	}
}
else
{
	echo "No privileges available";
}

$actual_count=0;
$insert_count=0;
	$delete=$privilege->deleteRolePrivilege($role_id);


for($i=1;$i<=$count;$i++)
{
	$ci="c".$i;
	$privilege_id=$_REQUEST[$ci];
	if($privilege_id!="")
	{
		$actual_count++;
		$insert=$role->assignPrivilegeRole($role_id,$privilege_id);

		//else for if statements below is pending
		if($insert)
		{
			$insert_count++;
		}
		
	}
}


if($actual_count==$insert_count)
{
	$message=Constants::PRIVILEGE_ASSIGN_SUCCESS;
	echo "<script>alert('$message');window.location.href='role.php';</script>";
}
else
{
	$message=Constants::PRIVILEGE_ASSIGN_FAIL;
	echo "<script>alert('$message');window.location.href='role.php';</script>";
}
?>