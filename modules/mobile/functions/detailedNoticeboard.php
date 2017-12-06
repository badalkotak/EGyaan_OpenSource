<?php
	require_once("../../../classes/Constants.php");
	require_once("../../../classes/DBConnect.php");
	require_once("../../manage_noticeboard/classes/Noticeboard.php");
	// require_once("../../manage_branch/classes/Branch.php");
	// require_once("../../manage_course/classes/Course.php");
	require_once("../../manage_student/classes/Student.php");
	require_once("../../manage_user/classes/User.php");
	require_once("../../manage_batch/classes/Batch.php");
	// include("../../../Resources/sessions.php");

	$dbConnect = new DBConnect(Constants::SERVER_NAME,
		Constants::DB_USERNAME,
		Constants::DB_PASSWORD,
		Constants::DB_NAME);

$notice_id=$_REQUEST['id'];

// $email="badalkotak@gmail.com";
// $user=new User($dbConnect->getInstance());
// // $user_id=$user->getUserId($email);

// $student=new Student($dbConnect->getInstance());
// $getStudentBatch=$student->getStudent($user_id,0);
// while($studentRow=$getStudentBatch->fetch_assoc())
// {
// 	$batch_id=$studentRow['batch_id'];
// }

// $batch=new Batch($dbConnect->getInstance());
// $getBranchId=$batch->getBatch("no",0,$batch_id,"no",0);
// while($batchRow=$getBranchId->fetch_assoc())
// {
// 	$branch_id=$batchRow['batchBranchId'];
// }

$noticeboard = new Noticeboard($dbConnect->getInstance());

$getNotice = $noticeboard->getNotice($notice_id);

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
