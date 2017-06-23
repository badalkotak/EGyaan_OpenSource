<?php
header("Content-Type:application/json");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_branch/classes/Branch.php");


$dbConnect = new DBConnect(Constants::SERVER_NAME,
        Constants::DB_USERNAME,
        Constants::DB_PASSWORD,
        Constants::DB_NAME);


$json=array();
$branch_array=array();
$final=array();

$branch = new Branch($dbConnect->getInstance());
$selectData = $branch->getBranch(0);
if($selectData)
{
    while ($row = $selectData->fetch_assoc()) {

        $json[]=$row;
        
	}
	$final['status']="success";
	$final['branch']=$json;
	
	echo json_encode($final);
}
else{
    header("location:add_noticeboard.php?errormessage=no branch added!");
}
