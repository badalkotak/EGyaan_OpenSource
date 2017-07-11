<?php

require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../classes/Role.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$role_name=$_REQUEST['role_name'];
$isTeacher=$_REQUEST['isTeacher'];
$connection = $dbConnect->getInstance();

$role_name=$connection->real_escape_string(trim($role_name));
$isTeacher=$connection->real_escape_string(trim($isTeacher));

if($isTeacher!=1)
{
	$isTeacher=0;
}

$role=new Role($dbConnect->getInstance());

$insertRole=$role->insertRole($role_name,$isTeacher);

if($insertRole===Constants::STATUS_EXISTS)
{
	$message="Role ".Constants::INSERT_ALREADY_EXIST_MSG;
	echo "<script>alert('$message');window.location.href='role.php';</script>";	
}
else if($insertRole===true)
{
	$message="Role ".Constants::INSERT_SUCCESS_MSG;
	echo "<script>alert('$message');window.location.href='role.php';</script>";
}

else
{
	$message=Constants::INSERT_FAIL_MSG."Role";
	echo "<script>alert('$message');window.location.href='role.php';</script>";
}
?>