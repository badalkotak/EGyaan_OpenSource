<?php
	require_once("../../../classes/Constants.php");
	require_once("../../../classes/DBConnect.php");
	require_once("../../manage_noticeboard/classes/Noticeboard.php");
	require_once("../../manage_student/classes/Student.php");
	require_once("../../manage_user/classes/User.php");
	require_once("../../manage_batch/classes/Batch.php");

	$dbConnect = new DBConnect(Constants::SERVER_NAME,
		Constants::DB_USERNAME,
		Constants::DB_PASSWORD,
		Constants::DB_NAME);

// $notice_id=$_REQUEST['id'];

$noticeboard = new Noticeboard($dbConnect->getInstance());

$getNotice = $noticeboard->getLatestNotice();

$json=array();
$notices=array();
$final=array();

if($getNotice!=null)
{
	while($row=$getNotice->fetch_assoc())
	{
		$title=$row['title'];
				$type=$row['type'];
				$file=$row['file'];
				$notice=$row['notice'];
				$date=$row['notice_date'];
				$time=$row['notice_time'];
			
				$notices['title']=$title;
				$notices['type']=$type;
				$notices['date']=$date;
				$notices['time']=$time;
				$notices['notice']=$notice;

				if ($file == "")
				{
					$notices['file']="-";	
				}
				else
				{
					$notices['file']=$file;
				}
				

				$json[]=$notices;
	}
			$final['status']="success";
	$final['notice']=$json;

}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");

	echo "[".json_encode($final)."]";
?>
