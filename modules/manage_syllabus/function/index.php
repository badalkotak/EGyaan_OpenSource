<?php
include("../../../Resources/sessions.php");
// require_once("../../../classes/Constants.php");
include("privilege.php");

if($add === true || $view === true || delete === true)
{
	if($role_id==Constants::ROLE_STUDENT_ID)
{
	header('Location: function/student_view_syllabus.php');	
}
else
{
	header('Location: function/insert_page.php');	
}
}
else
{
	$msg = Constants::NO_PRIVILEGE;
	echo "<script>alert('$msg');window.location.href='../../login/functions/logout.php';</script>";
}

?>