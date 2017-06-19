<?php
require_once("../../../classes/DBConnect.php");
require_once("../../../classes/Constants.php");
require_once("../../manage_batch/classes/Batch.php");

$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);

$batch=new Batch($dbConnect->getInstance());

$branch_id=$_REQUEST['branch_id'];
$getBatch=$batch->getBatch("yes",$branch_id,0);

$json=array();
$final=array();

if($getBatch!=null)
{
	$final['status']="success";
	$batch_array=array();
	while($row=$getBatch->fetch_assoc())
	{
		$batch_array['id']=$row['batchId'];
		$batch_array['name']=$row['batchName'];

		$json[]=$batch_array;
	}

	$final['batch']=$json;
}

else
{
	$final['status']="fail";
	$final['error']=Constants::NO_BATCH_ERR;
}

header("Content-Type: application/json");

echo json_encode($final);
?>