<?php
include("../../../Resources/sessions.php");
$user_id=$_SESSION['id'];
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_batch/classes/Batch.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$batch=new Batch($dbconnect->getInstance());
$branch_id=$_REQUEST['branch_id'];
$result_batch_id=$batch->getBatch("yes",$branch_id,0,"no",0);
$json=array();
$batch=array();
$final=array();

if($result_batch_id!=null)
{
	while($row=$result_batch_id->fetch_assoc())
	{
		$batch['id']=$row['batchId'];
		$batch['name']=$row['batchName'];
		$json[]=$batch;		
	}
	$final['status']="success";
	$final['batch']=$json;
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo json_encode($final);
?>