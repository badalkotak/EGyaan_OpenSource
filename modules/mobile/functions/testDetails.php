<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_test/classes/StudentTest.php");
require_once("../../manage_test/classes/Test.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$test_id=$_REQUEST['test_id'];
$user_id=$_REQUEST['user_id'];
$test = new Test($dbconnect->getInstance());
$student_test = new StudentTest($dbconnect->getInstance());

$json=array();
$test=array();
$final=array();

$result = $student_test->getTestAnswers($test_id,$user_id);
if($result != null){
	$total_marks = 0 ;
	$final['status']="success";
	while ($row = $result->fetch_assoc()) {
		$test["question"]=$row['question'];
		$answer=$row['answer'];
		$test["answer"]=$row['answer'];
		$correct_ans=$row['option_id'];
		$test["correct_ans"]=$row['option_id'];

		$option="option".$answer;
		$option_correct="option".$correct_ans;
		$test["answer_text"]=$row[$option];
		$test["correct_ans_text"]=$row[$option_correct];

		$json[]=$test;
	}

	$final["test"]=$json;
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo "[".json_encode($final)."]";
?>