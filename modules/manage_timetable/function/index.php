<?php
include("../../../Resources/sessions.php");
include("privilege.php");

if($add===true || $delete===true || $view===true)
{
	if($role_id==Constants::ROLE_STUDENT_ID || $role_id==Constants::ROLE_PARENT_ID)
{
	header('Location: view_timetable_student_parent.php');	
}
else
{
	if($add===true)
	{
		header('Location: timetable_select_branch_batch.php');
	}
	else
	{
		header('Location: view_teacher_timetable.php');
	}
}
}
else
{
	$msg = Constants::NO_PRIVILEGE;
	echo "<script>alert('$msg');window.location.href='../../login/functions/logout.php';</script>";
}

?>