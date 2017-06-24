<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_suggestion_complaint/classes/SuggestionComplaint.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$sc=new Suggestioncomplaint($dbconnect->getInstance());

$title=$_REQUEST['title'];
$desp=$_REQUEST['desp'];
$type=$_REQUEST['type'];

$insert=$sc->insertSuggestioncomplaint($title,$desp,$type);

$json=array();

if($insert)
{
	$json['status']="success";
}
else
{
	$json['status']="fail";
}

header("Content-Type: application/json");
echo json_encode($json);
?>