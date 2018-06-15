<?php
include("../../../Resources/sessions.php");
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_privilege/classes/Privilege.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$privilege=new Privilege($dbconnect->getInstance());

$add_id=Constants::TEST_ADD_ID;
$delete_id=Constants::TEST_DELETE_ID;
$view_id=Constants::TEST_VIEW_ID;

$result_add=Constants::RESULT_ADD_ID;
$result_view=Constants::RESULT_VIEW_ID;

$role_id = $_SESSION['role'];
$email = $_SESSION['email'];
$id = $_SESSION['id'];

$add=$privilege->checkPrivilege($id,$add_id,$email,$role_id);
$delete=$privilege->checkPrivilege($id,$delete_id,$email,$role_id);
$view=$privilege->checkPrivilege($id,$view_id,$email,$role_id);
$result_view_id=$privilege->checkPrivilege($id,$result_view,$email,$role_id);
$result_add_id=$privilege->checkPrivilege($id,$result_add,$email,$role_id);

if($result_add_id===true)
{
	$result_view_id=true;
}
?>