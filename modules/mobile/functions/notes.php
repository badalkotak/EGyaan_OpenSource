<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_notes/classes/Notes.php");
require_once("../../manage_student/classes/Student.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

$course_id=1; // To be sent via app

$notes=new Notes($dbconnect->getInstance());

$getNotes=$notes->getNotes($course_id);

$json=array();
$notes_array=array();
$final=array();

if($getNotes!=null)
{
	$final['status']="success";

	while($row=$getNotes->fetch_assoc())
	{
		$notes_array['title']=$row['title'];
		$notes_array['file']=$row['file'];

		$json[]=$notes_array;
	}

	$final['notes']=$json;
}
else
{
	$final['status']="fail";
}

header("Content-Type: application/json");
echo json_encode($final);
?>