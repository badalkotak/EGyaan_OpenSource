<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$role_id=$_REQUEST['delete'];

$role=new Role($dbConnect->getInstance());

$delete=$role->deleteRole($role_id);

if($delete)
{
	$message="Role ".Constants::DELETE_SUCCESS_MSG;
	echo "<script>alert('$message');window.location.href='role.php';</script>";	
}

else
{
	$message=Constants::DELETE_FAIL_MSG."role";
	echo "<script>alert('$message');window.location.href='role.php';</script>";	
}
?>