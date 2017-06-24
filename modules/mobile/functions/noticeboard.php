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

// $email=$_REQUEST['email']; // Later to be sent from the app

$email="badalkotak@gmail.com";
$user=new User($dbConnect->getInstance());
$user_id=$user->getUserId($email);

$student=new Student($dbConnect->getInstance());
$getStudentBatch=$student->getStudent($user_id,0);
while($studentRow=$getStudentBatch->fetch_assoc())
{
	$batch_id=$studentRow['batch_id'];
}

$batch=new Batch($dbConnect->getInstance());
$getBranchId=$batch->getBatch("no",0,$batch_id,"no",0);
while($batchRow=$getBranchId->fetch_assoc())
{
	$branch_id=$batchRow['batchBranchId'];
}

$noticeboard = new Noticeboard($dbConnect->getInstance());
		$selectData=$noticeboard->getNested2("egn_batch","egn_student","branch_id",1,1,1,1,"id","batch_id",1,1,"email",$email);

$json=array();
$notices=array();
$final=array();

if($selectData!=null)
{
	while($row=$selectData->fetch_assoc())
	{
		$student_branch=$branch_id;
		$var1="type";
		$var2=1;
		$var3=1;
		$urgent=1;
		$id=1;

		$selData=$noticeboard->getNoticeboard($var1,$student_branch,$var2,$urgent,$var3,$id);

		if($selData!=null)
		{
			while($row=$selData->fetch_assoc())
			{
				$title=$row['title'];
				$id=$row['id'];
				$type=$row['type'];
			
				$notices['id']=$id;
				$notices['title']=$title;
				$notices['type']=$type;

				$json[]=$notices;
			}
		}
	}

	$final['notice']=$json;

header("Content-Type: application/json");

	echo json_encode($final);
}
