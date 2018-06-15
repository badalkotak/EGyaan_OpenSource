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

$manage_fees=Constants::MANAGE_FEES_ID;
$role_id = $_SESSION['role'];

$fee=$privilege->checkPrivilege($id,$manage_fees,$email,$role_id);
?>