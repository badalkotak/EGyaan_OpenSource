<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_user/classes/User.php");
require_once("../../login/classes/Login.php");
require_once("../../manage_student/classes/Student.php");
require_once("../../manage_batch/classes/Batch.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$login=new Login($dbconnect->getInstance());
$user=new User($dbconnect->getInstance());
$student=new Student($dbconnect->getInstance());
$batch=new Batch($dbconnect->getInstance());

// $json=array();
$details=array();
$final=array();

$email="badalkotak@gmail.com";
$passwd="bk123";

$checkLogin=$login->checkLogin($email,$passwd);

if($checkLogin!=null)
{
	$final['status']="success";
	$details['role_id']=$checkLogin;

	$getUserId=$user->getUserId($email);

	$user_id=$getUserId;

	$details['user_id']=$user_id;

	$getStudentDetails=$student->getStudent($user_id,0);

	while($row=$getStudentDetails->fetch_assoc())
	{
		$details['firstname']=$row['firstname'];
		$details['lastname']=$row['lastname'];
		$details['email']=$row['email'];
		$details['student_passwd']=$row['student_passwd'];
		$details['gender']=$row['gender'];
		$details['mobile']=$row['mobile'];
		$details['student_profile_photo']=$row['student_profile_photo'];
		$batch_id=$row['batch_id'];
		$details['batch_id']=$batch_id;
		$getBranchId=$batch->getBatch("no",0,$batch_id,"no",0);
		while($batchRow=$getBranchId->fetch_assoc())
		{
			$details['branch_id']=$batchRow['batchBranchId'];
		}

		$details['parent_name']=$row['parent_name'];
		$details['parent_email']=$row['parent_email'];
		$details['parent_passwd']=$row['parent_passwd'];
		$details['parent_mobile']=$row['parent_mobile'];
		$details['student_profile_photo']=$row['student_profile_photo'];
	}

	$final['details']=$details;
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo json_encode($final);
?>