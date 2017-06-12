<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$role_name=$_REQUEST['role_name'];
$connection=$dbConnect->getInstance();
$role_name=$connection->real_escape_string(trim($role_name));

$role_id=$_REQUEST['edit'];

$role = new Role($connection);

$update=$role->updateRole($role_id,$role_name);

if($update)
{
	$message="Role ".Constants::UPDATE_SUCCESS_MSG;
	echo "<script>alert('$message');window.location.href='role.php';</script>";
}
else
{
	$message=Constants::UPDATE_FAIL_MSG."Role";
	echo "<script>alert('$message');window.location.href='role.php';</script>";
}
?>