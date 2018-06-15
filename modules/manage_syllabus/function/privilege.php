<?php
include("../../../Resources/sessions.php");
include("../../../classes/Constants.php");
include("../../../classes/DBConnect.php");
require_once("../../manage_privilege/classes/Privilege.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$privilege=new Privilege($dbconnect->getInstance());

$add_id=Constants::SYLLABUS_ADD_ID;
$delete_id=Constants::SYLLABUS_DELETE_ID;
$view_id=Constants::SYLLABUS_VIEW_ID;

$role_id = $_SESSION['role'];
$email = $_SESSION['email'];
echo $id = $_SESSION['id'];

$add=$privilege->checkPrivilege($id,$add_id,$email,$role_id);
$delete=$privilege->checkPrivilege($id,$delete_id,$email,$role_id);
$view=$privilege->checkPrivilege($id,$view_id,$email,$role_id);
?>