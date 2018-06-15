<?php
include("../../../Resources/sessions.php");
require_once("../../../classes/Constants.php");
include("privilege.php");

if($add===true || $delete===true || $view===true || $result_view_id===true || $result_add_id===true)
{
	if($role_id==Constants::ROLE_STUDENT_ID)
{
	header('Location: manage_student_test.php');
}
else
{
	header('Location: manage_test.php');	
}
}
else
{
	$msg = Constants::NO_PRIVILEGE;
	echo "<script>alert('$msg');window.location.href='../../login/functions/logout.php';</script>";
}

?>